<section class="comments__container">
	<h2>Comments</h2>
	<!-- We require the template to add a comment -->
	<?php
	require_once './templates/pages/comment/commentAdd.php';
	?>
	<?php foreach ($datas->comments as $comment) :
	?>
	<!-- If is set a "comment_id" tag, then when display a form to edit it and navigate to the anchor matching its id -->
	<?php if (isset($_REQUEST['comment_id']) && $comment->id == $_REQUEST['comment_id']) : ?>
	<div id="<?= $comment->id ?>" class="comment__container">
		<div class="comment__infos">
			<p class="comment__author"><?= $comment->author_username ?></p>
			<!-- If you're an admin, we display the status of the comment and the real content -->
			<?php if (isset($_SESSION['logged_user']) && $_SESSION['privileges']['privilege'] === 'admin') : ?>
			<p class="<?php
									if ($comment->validation_status === 'published') : ?>comment__status--true
							<?php elseif ($comment->validation_status === 'unpublished') : ?>comment__status--false
							<?php elseif ($comment->validation_status === 'pending') : ?>comment__status--pending
							<?php endif;
							?>"><b>Status : </b><em><?= $comment->validation_status ?></em></p>
			<p class="comment__content"><?= $comment->content ?></p>
			<!-- If you're not an admin, we display the comment if validated -->
			<?php elseif ($comment->validation_status === 'published') : ?>
			<p class="comment_content"><?= $comment->content ?></p>
			<!-- Or we display a message to indicate the actual status of the message -->
			<?php elseif ($comment->validation_status === 'unpublished' || $comment->validation_status === 'pending') : ?>
			<p class="comment_content"><?= $comment->content_status ?></p>
			<?php endif; ?>
		</div>
		<p class="comment__date">Created on <?= $comment->created_at ?></p>
		<!-- If edited, we display when. -->
		<?php if ($comment->updated_at !== null) : ?>
		<p class="comment__date">Edited on <?= $comment->updated_at ?></p>
		<?php endif; ?>
		<!-- If the logged user is the comment author, an "edit" button is displayed  -->
		<?php if (isset($_SESSION['logged_user']) && $_SESSION['user_id'] == $comment->user_id && $comment->validation_status === 'published' && $comment->id == $_REQUEST['comment_id']) : ?>
		<form
			action="index.php?page=post&action=update&option=comment&id=<?= $comment->id ?>&post_id=<?= $_GET['id'] ?>"
			method="post" class="edited__comment">
			<label for="comment" id="<?= $_REQUEST['comment_id'] ?>">Comment to Edit</label>
			<textarea cols="60" rows="7" type="text" class="comment__content" name="comment"
				id="comment"><?= $comment->content ?></textarea>
			<div class="validation__area">
				<input class="main__button" type="submit" value="Submit">
				<a href="index.php?page=post&action=get&option=view&id=<?=
																					$_GET['id'] ?>#<?= $_REQUEST['comment_id'] ?>" class="cancel__button">Cancel</a>
			</div>
		</form>
		<?php elseif (isset($_SESSION['logged_user']) && $_SESSION['user_id'] == $comment->user_id && $comment->validation_status === 'published' && $comment->id !== $_REQUEST['comment_id']) : ?>
		<p class="comment_content"><?= $comment->content ?></p>
		<?php endif; ?>
		<div class="border__bottom"></div>
		<?php else : ?>
		<div id="<?= $comment->id ?>" class="comment__validation">
			<div class="comment__container">
				<div class="comment__infos">
					<p class="comment__author"><?= $comment->author_username ?></p>
					<!-- If you're an admin, we display the status of the comment and the real content -->
					<?php if (isset($_SESSION['logged_user']) && $_SESSION['privileges']['privilege'] === 'admin') : ?>
					<p class="<?php
											if ($comment->validation_status === 'published') : ?>comment__status--true
					<?php elseif ($comment->validation_status === 'unpublished') : ?>comment__status--false
					<?php elseif ($comment->validation_status === 'pending') : ?>comment__status--pending
					<?php endif;
					?>"><b>Status : </b><em><?= $comment->validation_status ?></em></p>
					<p class="comment__content"><?= $comment->content ?></p>
					<!-- If you're not an admin, we display the comment if validated -->
					<?php elseif ($comment->validation_status === 'published') : ?>
					<p class="comment_content"><?= $comment->content ?></p>
					<!-- Or we display a message to indicate the actual status of the message -->
					<?php elseif ($comment->validation_status === 'unpublished' || $comment->validation_status === 'pending') : ?>
					<p class="comment_content"><?= $comment->content_status ?></p>
					<?php endif; ?>
				</div>
				<p class="comment__date">Created on <?= $comment->created_at ?></p>
				<!-- If edited, we display when. -->
				<?php if ($comment->updated_at !== null) : ?>
				<p class="comment__date">Edited on <?= $comment->updated_at ?></p>
				<?php endif; ?>
				<!-- If the logged user is the comment author, an "edit" button is displayed  -->
				<?php if (isset($_SESSION['logged_user']) && $_SESSION['user_id'] == $comment->user_id && $comment->validation_status === 'published') : ?>
				<button class="main__button__light"
					onclick="window.location.href='index.php?page=post&action=getOne&option=view&id=<?= $_GET['id'] ?>&comment_id=<?= $comment->id ?>#<?= $comment->id ?>'">Edit</button>
				<?php endif; ?>
			</div>
			<!-- If you're an admin, we display buttons to validate or remove comments -->
			<?php if (isset($_SESSION['logged_user']) && $_SESSION['privileges']['privilege'] === 'admin') : ?>
			<div class="comment__actions">
				<button class="main__button"
					onclick="window.location.href='index.php?page=post&action=publish&option=comment&id=<?= $comment->id ?>&post_id=<?= $_GET['id'] ?>'"
					<?php if ($comment->validation_status === 'published') : ?>disabled<?php endif; ?>>Publish</button>
				<button class="alert__button"
					onclick="window.location.href='index.php?page=post&action=unpublish&option=comment&id=<?= $comment->id ?>&post_id=<?= $_GET['id'] ?>'"
					<?php if ($comment->validation_status === 'unpublished') : ?>disabled<?php endif; ?>>Unpublish</button>
				<button class="delete__button"
					onclick="window.location.href='index.php?page=post&action=delete&option=comment&id=<?= $comment->id ?>&post_id=<?= $_GET['id'] ?>'">Delete</button>
			</div>
			<?php endif ?>
		</div>
		<div class="border__bottom"></div>
		<?php endif ?>
		<?php endforeach; ?>
</section>
