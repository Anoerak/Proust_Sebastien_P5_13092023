<!-- We display the content of a post in this view: -->
<section class="post__detail__container">
	<div class="top"></div>
	<article>
		<h1 class="post__title"><?= $datas->title ?></h1>
		<div class="github">
			<a href="<?= $datas->githubLink ?>" target="_blank">
				<i class="fab fa-github"> GitHub Repository</i>
			</a>
		</div>
		<p class="description"><?= $datas->description ?></p>
		<img src="<?= $datas->picture ?>" alt="#">
		<br>
		<p>Catégorie : <span class="post__category"><?= $datas->category ?></span></p>
		<br>
		<p class="post__content"><?= $datas->content ?></p>
		<br>
		<p class="post__dates">Publish by <span class="post__author"><?= $datas->author_username ?></span> on
			<?= $datas->created_at ?></p>
		<?php if ($datas->updated_at !== null) : ?>
		<p class="post__dates">Edited on <?= $datas->updated_at ?></p>
		<?php endif; ?>
		<br>
		<?php
		session_start();
		if (isset($_SESSION['logged_user']) && $_SESSION['privileges']['privilege'] === 'admin') : ?>
		<br>
		<br>
		<div class="post__edition">
			<a href="index.php?page=post&action=getOne&option=update&id=<?= $datas->id ?>"
				class="main__button">Update</a>
			<a href="index.php?page=post&action=delete&id=<?= $datas->id ?>" class="delete__button">Delete</a>
		</div>
		<?php endif; ?>
	</article>
	<div class="bottom"></div>
</section>

<!-- We display the comments of a post in this view: -->

<?php require_once './templates/pages/comment/comment.php'; ?>
