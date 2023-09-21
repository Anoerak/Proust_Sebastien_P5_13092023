<section class="signup__container">
	<div class="signup__form">
		<div class="header">
			<div class="logo">
				<img src="../../src/lib/imgs/logo.webp" alt="White S letter on black background">
			</div>
			<div class="title">
				<h1>Create Your Account</h1>
			</div>
		</div>
		<form action="index.php?page=signup&action=create&option=user&id=none" method="post" id="form1">
			<div class="intro">
				<p>One account is all you need to get access to the power of this blog.</p>
				<p>Already have one?
					<a href="index.php?page=login">Login ></a>
				</p>
			</div>

			<div class="input__container">
				<label for="username">Name</label>
				<input type="text" name="username" placeholder=" " required>
				<span>Name</span>
			</div>

			<div class="input__container">
				<label for="email">Email</label>
				<input type="email" name="email" placeholder=" " required>
				<span>Email</span>
			</div>

			<div class="input__container">
				<label for="password">Password</label>
				<input type="password" name="password" placeholder=" " required>
				<span>Password</span>
			</div>

			<div class="input__container">
				<label for="passwordCheck">Confirm Password</label>
				<input type="password" name="passwordCheck" placeholder=" " required>
				<span>Password</span>
			</div>
		</form>

		<div class="bottom">
			<input type="reset" value="Cancel" class="cancel__button" form="form1">
			<input type="submit" value="Sign Up" class="main__button" form="form1">
		</div>
	</div>
</section>
