<section class="login__container">

	<div class="login__form">
		<!--<video src="../../src/lib/videos/signin_video.mp4" width="344" height="310.5" autoplay="true" playsinline=""
			loop="" x-webkit-airplay="deny"
			title="Animation showing different users' Memojis surrounded by the icons of the apps the user personally uses most"></video>-->
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
	</div>
</section>