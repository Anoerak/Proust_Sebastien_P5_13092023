<?php

require_once "./src/Repository/MainRepository.php";
require_once "./src/lib/tools/Tools.php";

class Comment
{
	public int $id;
	public int $post_id;
	public int $user_id;
	public string $author_username;
	public string $content;
	public string $content_status;
	public string $created_at;
	public $updated_at;
	public string $validation_status;

	public function __construct($id = null, $post_id = null, $user_id = null, $author_username = '', $content = null, $content_status = null, $created_at = null, $updated_at = null, $validation_status = null)
	{
		$this->id = $id;
		$this->post_id = $post_id;
		$this->user_id = $user_id;
		$this->author_username = $author_username;
		$this->content = $content;
		$this->content_status = $content_status;
		$this->created_at = $created_at;
		$this->updated_at = $updated_at;
		$this->validation_status = $validation_status;
	}

	public static function getAll(int $post_id)
	{
		$comments = array();
		$repo = new MainRepository("comment");
		// We check if the request returned at least one result
		if ($repo->getAll('post_id', $post_id, 'DESC') > 0) {
			// We get the results
			$results = $repo->getAll('post_id', $post_id, 'DESC');
			// We loop through the results
			foreach ($results as $result) {
				// We create a new comment object, we replace the dates with a formatted date and we add the author username to the object
				$comment = new Comment(
					$result["id"],
					$result["post_id"],
					$result["user_id"],
					'Anonymous',
					$result["content"],
					'Temporary content status',
					$result["created_at"],
					$result["updated_at"],
					$result["validation_status"],
				);
				$comment->author_username = User::getOne($result["user_id"])->username;
				$comment->created_at = Tools::formatDate($result["created_at"]);
				if ($comment->updated_at !== null) {
					$comment->updated_at = Tools::formatDate($result["updated_at"]);
				}
				if ($comment->validation_status === 'unpublished') {
					$comment->content_status = '<font color="#ff5353">
					Attention, blog-o-sphere!<br>
					Unfortunately, this comment has been removed for not following the <a href="index.php?page=rules">rules</a> of my legendary blog.<br>
					So, if you want your comment to be seen by the world, make sure you follow these simple rules.<br>
					And if you don\'t, well, let\'s just say you\'ll be getting a visit from the comment-blocking hammer.<br>
					Suit up!</font>';
				} elseif ($comment->validation_status === 'pending') {
					$comment->content_status = '<font color="#9fa4ac">
					<em><b>Blog-o-sphere, gather around!</b><br>
					There\'s a new comment on my latest post that\'s waiting for my legendary approval. And let me tell you, I take this responsibility very seriously.<br>
					So, if you\'re waiting for your comment to be published, don\'t worry, it\'s in good hands. And if it doesn\'t make the cut, well, let\'s just say it\'s not you, it\'s me.<br>
					Suit up!</em></font>
					';
				}
				// We add the comment to the comments array
				array_push($comments, $comment);
			}

			return $comments;
		}
	}

	public static function create(int $post_id)
	{
		if (empty($_POST['comment'])) {
			header('Refresh: 1; URL= index.php?page=post&action=getOne&option=view&id=' . $post_id . '#add-comment');
			throw new Exception('You must fill in all the fields.', 500);
		} else {
			$repo = new MainRepository("comment");
			session_start();
			$repo->create(
				[
					'post_id' => $post_id,
					'user_id' => $_SESSION['user_id'],
					'content' => $_POST['comment']
				]
			);
			// We check if the comment has been created
			if ($repo->getAll('post_id', $post_id, null) > 0) {
				$comments = $repo->getAll('post_id', $post_id, null);
				$lastComment = end($comments);
				$newCommentId = $lastComment['id'];
				header('Refresh: 1; URL= index.php?page=post&action=getOne&option=view&id=' . $post_id . '#' . $newCommentId);
				throw new Exception('Your comment has been posted.', 200);
			} else {
				throw new Exception('An error occurred while posting your comment.', 500);
			}
		}
	}

	public static function update(int $id)
	{
		if (empty($_POST['comment'])) {
			header('Refresh: 1; URL= index.php?page=post&action=getOne&option=view&id=' . $_GET['post_id'] . '#' . $id);
			throw new Exception('You must fill in all the fields.', 500);
		} else {
			$repo = new MainRepository("comment", $id);
			$repo->update(
				[
					'content' => $_POST['comment'],
				]
			);
			if (!$repo) {
				throw new Exception('An error occurred while updating your comment.', 500);
			} else {
				header('Refresh: 1; URL= index.php?page=post&action=getOne&option=view&id=' . $_GET['post_id'] . '#' . $id);
				throw new Exception('Your comment has been updated.', 200);
			}
		}
	}

	public static function delete(int $id)
	{
		$repo = new MainRepository("comment", $id);
		$repo->delete();
		if (!$repo) {
			throw new Exception('An error occurred while deleting your comment.', 500);
		} else {
			header('Refresh: 1; URL= index.php?page=post&action=getOne&option=view&id=' . $_GET['post_id']);
			throw new Exception('Your comment has been deleted.', 200);
		}
	}

	public static function publish(int $id)
	{
		$repo = new MainRepository('comment', $id);
		$repo->publishComment([
			'validation_status' => 'published',
		]);
		if (!$repo) {
			throw new Exception('An error occurred while publishing your comment', 500);
		} else {
			header('Refresh: 1; URL= index.php?page=post&action=getOne&option=view&id=' . $_GET['post_id'] . '#' . $id);
			throw new Exception('This comment is now available for all users', 200);
		}
	}

	public static function unpublish(int $id)
	{
		$repo = new MainRepository('comment', $id);
		$repo->unpublishComment([
			'validation_status' => 'unpublished',
		]);
		if (!$repo) {
			throw new Exception('An error occurred while redacting your comment', 500);
		} else {
			header('Refresh: 1; URL= index.php?page=post&action=getOne&option=view&id=' . $_GET['post_id'] . '#' . $id);
			throw new Exception('This comment is now unavailable for all users', 200);
		}
	}
}
