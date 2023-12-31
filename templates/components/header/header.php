<header>
	<div class="logo">
		<a href="index.php">
			<img src="../../../src/lib/imgs/logo.webp" alt="White S letter on black background">
		</a>
	</div>

	<nav>
		<ul>
			<li>
				<a class="
				{# if $_GET['page'] is undefined #}
				<?php if (!isset($_GET['page'])) : ?>
						active
					<?php endif ?>" href="index.php">
					<i class="fa-solid fa-house"></i>
					Home
				</a>
			</li>
			<li>
				<a class="
				<?php if (isset($_GET['page']) && $_GET['page'] === 'blog') : ?>
						active
					<?php endif ?>" href="index.php?page=blog&option=all">
					<i class="fa-solid fa-signs-post"></i>
					Projects
				</a>
			</li>
			<li>
				<a class="<?php if (isset($_GET['page']) && $_GET['page'] === 'about') : ?>active<?php endif ?>" href="index.php?page=about">
					<i class="fa-solid fa-circle-info"></i>
					About
				</a>
			</li>
			<li>
				<a class="<?php if (isset($_GET['page']) && $_GET['page'] === 'contact') : ?>active<?php endif ?>" href="index.php?page=contact">
					<i class="fa-regular fa-comment"></i>
					Contact
				</a>
			</li>
			<li class="responsive__log-in-out">
				<?php if (!isset($_SESSION['logged_user'])) : ?>
					<a href="index.php?page=login">
						<button class="login">
							Log in
						</button>
					</a>
					<a href="index.php?page=signup">
						<button class="signup">
							Sign up
						</button>
					</a>
				<?php else : ?>
					<a class="mini__profile__container" href="index.php?page=userProfile&action=getOne&option=user&id=<?= $_SESSION['user_id'] ?>">
						<img src="<?= $_SESSION['profile_picture'] ?>" alt="profile_picture">
					</a>
					<a href="index.php?page=login&action=logOut&option=userConnection">
						<button class="signup">
							Log out
						</button>
					</a>
				<?php endif; ?>
			</li>
	</nav>



	<div class="responsive__menu">
		<img id="responsive-menu-button" src="../../../src/lib/imgs/svg/menu.svg" alt="Menu button composed of 12 white blocks on 3 rows">
	</div>
	<?php if (!isset($_SESSION['logged_user'])) : ?>
		<div class="login_up__section">
			<a href="index.php?page=login">
				<button class="login">
					Log in
				</button>
			</a>
			<a href="index.php?page=signup">
				<button class="signup">
					Sign up
				</button>
			</a>
		</div>
	<?php else : ?>
		<div class="logged_in__section">
			<a class="mini__profile__container" href="index.php?page=userProfile&action=getOne&option=user&id=<?= $_SESSION['user_id'] ?>">
				<img src="<?= $_SESSION['profile_picture'] ?>" alt="profile_picture">
			</a>
			<a href="index.php?page=login&action=logOut&option=userConnection">
				<button class="signup">
					Log out
				</button>
			</a>
		</div>
	<?php endif; ?>
</header>
