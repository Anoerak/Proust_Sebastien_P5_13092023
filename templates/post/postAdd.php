<?php session_start(); ?>
<section class="add__post">
	<h1>Create a new Post</h1>
	<form class="add__post__form" action="index.php?page=post&action=add&option=new" method="post"
		enctype="multipart/form-data">
		<div class="form-group">
			<input type="hidden" name="author_id" id="author_id" value="<?= $_SESSION['user_id'] ?>">
			<label for="title">Title</label>
			<input type="text" class="add__title__input" id="title" name="title" placeholder="Enter title">
			<label for="category">Category</label>
			<select class="add__category__select" id="category" name="category">
				<option value="">Choose a category</option>
				<option value="Frontend">Frontend</option>
				<option value="Backend">Backend</option>
				<option value="Fullstack">Fullstack</option>
				<option value="Others">Others</option>
			</select>
			<label for="image">
				<input type="file" class="add__picture__input" id="post_picture" name="post_picture"
					accept=".jpeg, .jpg, .png, gif">
			</label>
			<label for="content">Content</label>
			<textarea class="form-control" id="add__content_textarea" name="content" rows="10" cols="80"></textarea>
		</div>
		<div class="add__validation__area">
			<button type="submit" class="main__button">Submit</button>
			<button type="reset" class="delete__button">Reset</button>
		</div>
	</form>
</section>