<?php

require_once "./src/Repository/MainRepository.php";
require_once "./src/lib/tools/Tools.php";

class Post
{
	public int $id;
	public int $author_id;
	public string $author_username;
	public string $category;
	public string $picture;
	public string $title;
	public string $description;
	public string $content;
	public string $keywords;
	public $siteLink;
	public $githubLink;
	public $created_at;
	public $comments;
	public $updated_at;

	public function __construct(
		$id = null,
		$author_id = null,
		$author_username = null,
		$category = null,
		$picture = null,
		$title = null,
		$description = null,
		$content = null,
		$keywords = null,
		$siteLink = null,
		$githubLink = null,
		$created_at = null,
		$comments = null,
		$updated_at = null
	) {
		$this->id = $id;
		$this->author_id = $author_id;
		$this->author_username = $author_username;
		$this->category = $category;
		$this->picture = $picture;
		$this->title = $title;
		$this->description = $description;
		$this->content = $content;
		$this->keywords = $keywords;
		$this->siteLink = $siteLink;
		$this->githubLink = $githubLink;
		$this->created_at = $created_at;
		$this->comments = $comments;
		$this->updated_at = $updated_at;
	}

	public static function getPosts($filter)
	{
		$posts = array();
		$repo = new MainRepository("post");
		// We check if the request returned at least one result
		if ($repo->getAll($filter) > 0) {
			// We create a new Post object for each post
			foreach ($repo->getAll($filter) as $post) {
				$posts[] = new Post($post['id'], $post['author_id'], '', $post['category'], $post['picture'], $post['title'], $post['description'], $post['content'], $post['keywords'], $post['site_link'], $post['github_link'], $post['created_at'], $post['updated_at']);
			}
			// We get the author's username for each post
			foreach ($posts as $post) {
				$post->author_username = User::getUser($post->author_id)->username;
				// We replace the date value with the format we want
				$post->created_at = Tools::formatDate($post->created_at);
				$post->updated_at = Tools::formatDate($post->updated_at);
			}
			// We return an array of posts
			return $posts;
		} else {
			// We throw an exception if no post was found
			throw new Exception("No articles found for the category '$filter'", 400);
		}
	}

	public static function getPost($id)
	{
		$repo = new MainRepository("post");
		// We check if the request returned at least one result
		if ($repo->getOne($id) > 0) {
			$post = $repo->getOne($id);
			// We get the author's username
			$author = User::getUser($post['author_id']);
			// We replace the date value with the format we want
			$post['created_at'] = Tools::formatDate($post['created_at']);
			if ($post['updated_at'] !== null) {
				$post['updated_at'] = Tools::formatDate($post['updated_at']);
			} else {
				$post['updated_at'] = null;
			};
			// We return the post
			return new Post($post['id'], $author->id, $author->username, $post['category'], $post['picture'], $post['title'], $post['description'], $post['content'], $post['keywords'], $post['site_link'], $post['github_link'], $post['created_at'], $post['updated_at']);
		} else {
			// We throw an exception if no post was found
			throw new Exception("No article found for the id '$id'", 400);
		}
	}

	public static function addPost()
	{
		$post = array(
			'author_id' => $_POST['author_id'],
			'category' => $_POST['category'],
			'title' => $_POST['title'],
			'description' => $_POST['description'],
			'content' => $_POST['content'],
			'keywords' => $_POST['keywords'],
			'site_link' => $_POST['siteLink'],
			'github_link' => $_POST['githubLink']
		);

		// We check the picture format and add it if OK
		if (!empty($_FILES['post_picture']['name'])) {
			$checkPicture = Tools::uploadPicture('post_picture');
			if (!$checkPicture) {
				throw new Exception('The picture format is not valid.', 400);
			} else {
				// $picture = $checkPicture;
				$post['picture'] = $checkPicture;
			}
		} else {
			// $picture = null;
			$post['picture'] = null;
		}

		// We add the post to the database
		$repo = new MainRepository("post");
		$repo->add($post);

		// We check if everything worked out fine
		if ($repo->getLastInsertedId() > 0) {
			// We redirect the user to the post page
			header('Refresh: 1;URL=./index.php?page=blog&option=all');
			throw new Exception('Your post has been successfully created.', 200);
		} else {
			// We throw an exception if the insertion failed
			throw new Exception("Article insertion failed", 500);
		}
	}

	public static function updatePost()
	{
		$newPicture = '';

		// We check the picture format and add it if OK
		if (!empty($_FILES['post_picture']['name'])) {
			$checkPicture = Tools::uploadPicture('post_picture');
			if (!$checkPicture) {
				throw new Exception('The picture format is not valid.', 400);
			} else {
				// $picture = $checkPicture;
				$newPicture = $checkPicture;
			}
		} else {
			// $picture = null;
			$newPicture = null;
		}

		// We get the original values from the database
		$origin = Post::getPost($_POST['post_id']);

		// we create an array with the values to update
		$update = array(
			'title' => $_POST['title'] !== $origin->title ? $_POST['title'] : null,
			'description' => $_POST['description'] !== $origin->description ? $_POST['description'] : null,
			'category' => $_POST['category'] !== $origin->category ? $_POST['category'] : null,
			'content' => $_POST['content'] !== $origin->content ? $_POST['content'] : null,
			'picture' => $newPicture !== $origin->picture ? $newPicture : null,
			'keywords' => $_POST['keywords'] !== $origin->keywords ? $_POST['keywords'] : null,
			'site_link' => $_POST['siteLink'] !== $origin->siteLink ? $_POST['siteLink'] : null,
			'github_link' => $_POST['githubLink'] !== $origin->githubLink ? $_POST['githubLink'] : null,
		);

		// For each value equal to null or empty, we remove it from the array
		foreach ($update as $key => $value) {
			if ($value === null || $value === '') {
				unset($update[$key]);
			}
		}

		// We check if the array is not empty
		if (!empty($update)) {
			// We update the post in the database
			$repo = new MainRepository("post", $_POST['post_id']);
			$repo->update($update);
			// We check if everything worked out fine
			if ($repo->getOne($_POST['post_id']) > 0) {
				// We redirect the user to the post page
				header('Refresh: 1;URL=./index.php?page=blog&option=all');
				throw new Exception('Your post has been successfully updated.', 200);
			} else {
				// We throw an exception if the update failed
				throw new Exception("Article update failed", 500);
			}
		} else {
			// We throw an exception if the update failed
			throw new Exception("Article update failed", 500);
		}
	}




	public static function deletePost($id)
	{
		$repo = new MainRepository("post", $id);
		$repo->delete($id);

		// We check if everything worked out fine
		if ($repo->getOne($id) == 0 || $repo->getOne($id) == null || $repo->getOne($id) == "" || $repo->getOne($id) == false) {
			// We return a success message
			header('Refresh: 1;URL=./index.php?page=blog&option=all');
			throw new Exception('Your post has been successfully deleted.', 200);
		} else {
			// We throw an exception if the deletion failed
			throw new Exception("Article deletion failed", 500);
		}
	}
}
