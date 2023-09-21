<section class="user__profile__container">
	<div class="top"></div>
	<h1>Your Informations</h1>
	<div class="main__container">
		<div class="left__container">
			<form id="form1" action="index.php?page=userProfile&action=update&option=user&id=<?= $_SESSION['user_id'] ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="page" value="userProfile">
				<input type="hidden" name="action" value="update">
				<input type="hidden" name="option" value="user">
				<input type="hidden" name="id" value="<?= $_SESSION['user_id'] ?>">
				<div class="user__profile__container__content__avatar">
					<img src="<?= $_SESSION['profile_picture'] ?>" alt="Avatar">
					<input type="file" name="profile_picture" id="profile_picture" accept=".jpeg, .jpg, .png, .webp">
				</div>
				<div class="input__container">
					<label for="username">Username</label>
					<input type="text" name="username" id="username" placeholder="" required>
					<span class="username"><?= $_SESSION['username'] ?></span>
				</div>
				<div class="input__container">
					<label for="email">Email</label>
					<input type="email" name="email" id="email" placeholder="" required>
					<span class="email"><?= $_SESSION['email'] ?></span>
				</div>
				<div class="action__container">
					<input formnovalidate form="form1" class="main__button update__user" type="submit" value="Update" onclick="<?php
																																if (empty($_POST['username'])) {
																																	$_POST['username'] = $_SESSION['username'];
																																}
																																if (empty($_POST['email'])) {
																																	$_POST['email'] = $_SESSION['email'];
																																}
																																?>">
				</div>
			</form>
		</div>
		<div class="right__container">
			<h2>Personal Details</h2>
			<p>
				Manage your personal details, register or unsubscribe to the newsletter.
			</p>
			<form id="form2" action="index.php?page=userProfile&action=update&option=user&id=<?= $_SESSION['user_id'] ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="page" value="userProfile">
				<input type="hidden" name="action" value="update">
				<input type="hidden" name="option" value="user">
				<input type="hidden" name="id" value="<?= $_SESSION['user_id'] ?>">
				<div class="input__container">
					<label for="firstname">First Name</label>
					<input type="text" name="firstname" id="firstname" placeholder=" " required>
					<span class="firstname"><?= $_SESSION['firstname'] ?></span>
				</div>
				<div class="input__container">
					<label for="lastname">Last Name</label>
					<input type="text" name="lastname" id="lastname" placeholder=" " required>
					<span class="lastname"><?= $_SESSION['lastname'] ?></span>
				</div>
				<div class="input__container">
					<label for="birthday">Birthday</label>
					<input type="text" name="birthday" id="birthday" onfocus="(this.type='date')" placeholder=" " required>
					<span class="birthday"><?= $_SESSION['birthday'] ?></span>
				</div>
				<div class="input__container">
					<label for="currentPassword">Current Password</label>
					<input type="password" name="currentPassword" id="currentPassword" placeholder=" " required>
					<span class="password">**********</span>
				</div>
				<div class="input__container">
					<label for="newPassword">New Password</label>
					<input type="password" name="newPassword" id="newPassword" placeholder=" " required>
					<span class="new__password">**********</span>
				</div>
				<div class="input__container">
					<label for="passwordCheck">Confirm Password</label>
					<input type="password" name="passwordCheck" id="passwordCheck" placeholder=" " required>
					<span class="password__check">**********</span>
				</div>
				<div class="action__container">
					<input formnovalidate form="form2" class="main__button update__user" type="submit" value="Update">
					<input formnovalidate class="delete__button delete__user" type="submit" value="Delete your account" formaction="index.php?page=userProfile&action=delete&option=user&id=<?= $_SESSION['user_id'] ?>">
				</div>
			</form>
			<div class="user__profile__container__content__bottom">
				<h2>Newsletter</h2>
				<p>
					Subscribe or unsubscribe to the newsletter.
				</p>
				<div class="user__profile__container__content__newsletter">
					<div class="newsletter__container">
						<form action="index.php?page=newsletter&action=subscribe" method="post">
							<input type="hidden" name="action" value="subscribe">
							<input type="hidden" name="email" value="<?= $_SESSION['email'] ?>">
							<input class="main__button" type="submit" value="Subscribe" <?php if ($_SESSION['newsletter'] === 'active') : ?> disabled <?php endif; ?>>
						</form>
					</div>
					<div class="newsletter__container">
						<form action="index.php?page=newsletter&action=unsubscribe" method="post">
							<input type="hidden" name="action" value="unsubscribe">
							<input type="hidden" name="email" value="<?= $_SESSION['email'] ?>">
							<input class="delete__button" type="submit" value="Unsubscribe" <?php if ($_SESSION['newsletter'] === 'inactive') : ?> disabled <?php endif; ?>>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="bottom"></div>
</section>
