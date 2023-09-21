<?php session_start(); ?>
<section class="add__post">
	<div class="top"></div>
	<h1>Create a new Post</h1>
	<div class="add__post__form">
		<form action="index.php?page=post&action=add&option=new" method="post" enctype="multipart/form-data">
			<div class="form__group">
				<div class="input__container">
					<input type="hidden" name="author_id" id="author_id" value="<?= $_SESSION['user_id'] ?>" required>
				</div>

				<div class="input__container">
					<label for="title">Title</label>
					<input type="text" class="add__title__input" id="title" name="title" placeholder=" " required>
				</div>

				<div class="input__container">
					<label for="description">Description</label>
					<input type="text" class="update__description__input" id="description" name="description" placeholder=" " required>
				</div>

				<div class="input__container">
					<label for="category">Category</label>
					<select class="add__category__select" id="category" name="category">
						<option value="">Choose a category</option>
						<option value="Frontend">Frontend</option>
						<option value="Backend">Backend</option>
						<option value="Fullstack">Fullstack</option>
						<option value="Others">Others</option>
					</select>
				</div>

				<div class="input__container img">
					<label for="image">Image</label>
					<input type="file" class="add__picture__input" id="post_picture" name="post_picture" accept=".jpeg, .jpg, .png, .gif, .webp">
				</div>

				<div class="input__container">
					<label for="content">Content</label>
					<textarea class="form-control" id="add__content_textarea" name="content" rows="10" cols="80" required></textarea>
				</div>

				<div class="input__container">
					<label for="keywords">Keywords</label>
					<input type="text" class="update__keywords__input" id="keywords" name="keywords" placeholder=" " required>
				</div>

				<div class="input__container">
					<label for="siteLink">site Link</label>
					<input type="text" class="update__siteLink__input" id="siteLink" name="siteLink" placeholder=" " required>
				</div>

				<div class="input__container">
					<label for="githubLink">github Link</label>
					<input type="text" class="update__githubLink__input" id="githubLink" name="githubLink" placeholder=" " required>
				</div>

				<div class="add__validation__area">
					<button type="submit" class="main__button">Submit</button>
					<a href="index.php?page=blog&option=all" class="cancel__button">Cancel</a>
					<!--<button type="reset" class="delete__button">Reset</button>-->
				</div>
		</form>
	</div>
	<div class="bottom"></div>
</section>
