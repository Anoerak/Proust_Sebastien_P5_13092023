 <div class="hero__container">
 	<div class="top"></div>
 	<article>
 		<?php foreach ($datas as $post) : ?>
 		<div class="card">
 			<div class="card__image">
 				<img src="<?= $post->picture ?>" alt="Card image" />
 				<div class="card__subtext">
 					<div class="card__infos">
 						<p class="card__author"><?= $post->author_username ?></p>
 						<p class="card__date"><?= $post->created_at ?></p>
 					</div>
 					<p class="card__category"><?= $post->category ?></p>
 				</div>
 			</div>
 			<div class="card__content">
 				<h3 class="card__title"><?= $post->title ?></h3>
 				<p class="card__text"><?= $post->content ?></p>
 				<a href="index.php?page=post&action=get&option=view&id=<?= $post->id ?>" class="main__button">Read
 					more</a>
 			</div>
 		</div>
 		<?php endforeach; ?>

 	</article>

 	<div class="bottom"></div>
 	</section>