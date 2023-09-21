<section class="contact__container">
	<div class="contact__form">
		<div class="header">
			<div class="logo">
				<img src="../../src/lib/imgs/logo.webp" alt="White S letter on black background">
			</div>
			<div class="title">
				<h1>Code with Me
				</h1>
			</div>
		</div>
		<form action="index.php?page=contact&action=send" method="post" id="form1">

			<div class="input__container">
				<label for="name">Name</label>
				<input type="text" name="contactName" placeholder=" " required>
				<span>Name</span>
			</div>

			<div class="input__container">
				<label for="email">Email</label>
				<input type="email" name="contactEmail" placeholder=" " required>
				<span>Email</span>
			</div>

			<div class="input__container">
				<label for="subject">Subject</label>
				<input type="text" name="contactSubject" placeholder=" " required>
				<span>Subject</span>
			</div>

			<div class="input__container">
				<label for="message">Message</label>
				<textarea name="contactMessage" placeholder=" " cols="48" rows="8" required></textarea>
				<span>Message</span>
			</div>

		</form>
		<div class="bottom">
			<input type="reset" value="Cancel" class="cancel__button" form="form1">
			<input type="submit" value="Send" class="main__button" form="form1">
		</div>
	</div>
</section>
