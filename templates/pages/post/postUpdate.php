<?php session_start();
if ($_SESSION['privileges'] != 'admin') {
	throw new Exception('You are not allowed to access this page.');
}
?>
<section class="update__post">
	<div class="top"></div>
	<h1>Update this Post</h1>
	<div class="update__post__form">
		<form action="index.php?page=post&action=update" method="post" enctype="multipart/form-data">
			<div class="form__group">
				<input type="hidden" name="post_id" id="post_id" value="<?= $datas->id ?>">
				<input type="hidden" name="author_id" id="author_id" value="<?= $_SESSION['user_id'] ?>">
				<input type="hidden" name="origin_title" id="origin_title" value="<?= $datas->title ?>">
				<input type="hidden" name="origin_description" id="origin_description" value="<?= $datas->description ?>">
				<input type="hidden" name="origin_category" id="origin_category" value="<?= $datas->category ?>">
				<input type="hidden" name="origin_content" id="origin_content" value="<?= $datas->content ?>">
				<input type="hidden" name="origin_keywords" id="origin_keywords" value="<?= $datas->keywords ?>">
				<input type="hidden" name="origin_link" id="origin_link" value="<?= $datas->link ?>">
				<input type="hidden" name="origin_github" id="origin_github" value="<?= $datas->github ?>">

				<div class="input__container">
					<label for="title">Title</label>
					<input type="text" class="update__title__input" id="title" name="title" placeholder="<?= $datas->title ?>">
				</div>

				<div class="input__container">
					<label for="description">Description</label>
					<input type="text" class="update__description__input" id="description" name="description" placeholder="<?= $datas->description ?>">
				</div>

				<div class="input__container">
					<label for="category">Category</label>
					<select class="update__category__select" id="category" name="category">
						<option value=""><?= $datas->category ?></option>
						<option value="Frontend">Frontend</option>
						<option value="Backend">Backend</option>
						<option value="Fullstack">Fullstack</option>
						<option value="Others">Others</option>
					</select>
				</div>

				<div class="input__container img">
					<img src="<?= $datas->picture ?>" alt="post_picture">
					<label for="image">
						<input type="file" class="update__picture__input" id="post_picture" name="post_picture" accept=".jpeg, .jpg, .png, .gif, .webp">
					</label>
				</div>

				<div class="input__container">
					<label for="content">Content</label>
					<textarea class="form-control" id="update__content_textarea" name="content" rows="10" cols="80" placeholder="<?= $datas->content ?>"></textarea>
				</div>

				<div class="input__container">
					<label for="keywords">Keywords</label>
					<input type="text" class="update__keywords__input" id="keywords" name="keywords" placeholder="<?= $datas->keywords ?>">
				</div>

				<div class="input__container">
					<label for="siteLink">site Link</label>
					<input type="text" class="update__siteLink__input" id="siteLink" name="siteLink" placeholder="<?= $datas->siteLink ?>">
				</div>

				<div class="input__container">
					<label for="githubLink">github Link</label>
					<input type="text" class="update__githubLink__input" id="githubLink" name="githubLink" placeholder="<?= $datas->githubLink ?>">
				</div>

			</div>
			<div class="update__validation__area">
				<button type="submit" class="main__button">Submit</button>
				<a href="index.php?page=post&action=getOne&option=view&id=<?= $datas->id ?>" class="cancel__button">
					Cancel
				</a>
			</div>
		</form>
	</div>
	<div class="bottom"></div>
</section>
