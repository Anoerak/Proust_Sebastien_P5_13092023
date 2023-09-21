<section class="login__container">

	<div class="login__form">
		<div class="container">
			<span class="icon__central">
			</span>
			<span class="icon"></span>
			<span class="icon"></span>
			<span class="icon"></span>
			<span class="icon"></span>
			<span class="icon"></span>
			<span class="icon"></span>
			<span class="icon"></span>
			<span class="icon"></span>
			<span class="icon"></span>
			<span class="icon"></span>
			<span class="icon"></span>
		</div>
		<form action="index.php?page=login&action=logIn&option=userConnection" method="post">
			<div class="username">
				<label for="username">Username</label>
				<input type="username" name="username" required>
				<span>Username</span>
			</div>
			<div class="password">
				<label for="password">Password</label>
				<input type="password" name="password" required>
				<span>Password</span>
			</div>

			<input type="submit" value="Login" class="main__button">
		</form>
		<div class="bottom">
			<p>Don't have an account?
				<a href="index.php?page=signup">Sign Up ></a>
			</p>
		</div>
	</div>
</section>
