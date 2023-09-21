<?php
session_start();

?>
<section class="project__container">
	<div class="top"></div>
	<h1>Projects</h1>
	<div class="main__container">
		<?php
		if (isset($_SESSION['logged_user']) && ($_SESSION['privileges']['privilege'] === 'admin')) : ?>
			<a href="index.php?page=post&action=new" class="add__post__button main__button">
				Add a post
			</a>
		<?php endif; ?>

		<article>
			<?php foreach ($datas as $post) : ?>
				<div class="card <?= $post->id ?>" style="background-image: url('<?= $post->picture ?>');">
					<a href="index.php?page=post&action=get&option=view&id=<?= $post->id ?>" class="projects__details">More
						Informations</a>
					<div class="card__filter"></div>
					<div class=" card__content">
						<div class="card__content__main">
							<div class="project__type"><?= $post->category ?></div>
							<h2 class="project__title"><?= $post->title ?></h2>
							<p class="project__description"><?= $post->description ?></p>
						</div>
						<div class="card__content__banner">
							<a href="<?= $post->githubLink ?>" class="left__side" target="_blank">
								<div class="img__container">
									<img src="../../src/lib/imgs/technos/github.webp" alt="Github logo" />
								</div>
								<div class="content">
									<h3 class="title">GitHub repository</h3>
									<p class="keywords"><?= $post->keywords  ?></p>
								</div>
							</a>
							<div class="right__side">
								<a href="<?= $post->siteLink ?>" class="main__button" target=”_blank”>Visit</a>
								<p>No In-App Purchases</p>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</article>
	</div>
	<div class="bottom"></div>
</section>
