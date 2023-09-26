<section class="subscribe__container">
	<div class="top"></div>
	<h1>Newsletter Registration</h1>
	<p><?=
		// We get the email address and the status from the URL
		$email = $_GET['email'];
		$status = $_GET['status'];
		// We display the email address and the status
		echo "<p class='intro'>
				Your email address is " . $email . " and your status is " . $status .
			"</p>";

		// We check if the status is 'active'
		if ($status == 'active') {
			// If the status is 'active', we display a message
			echo "<br><br>
				<p class='message'>You are already registered to the newsletter </p>";
			// And a button to unsubscribe
			echo "<br><br>
				<div class='newsletter__container'>
					<form action='index.php?page=newsletter&action=unsubscribe' method='post'>
						<input type='hidden' name='action' value='unsubscribe'>
						<input type='hidden' name='email' value=" . $email  . ">
						<input class='unsubscribe__button' type='submit' value='Unsubscribe'>
					</form>
				</div>";
		} else {
			// If the status is 'inactive', we display a message
			echo "<br><br>
				<p class='message'>You are not registered to the newsletter </p>";
			// And a button to subscribe
			echo "<br><br>
					<div class='newsletter__container'>
						<form action='index.php?page=newsletter&action=subscribe' method='post'>
							<input type='hidden' name='action' value='subscribe'>
							<input type='hidden' name='email' value=" . $email . ">
							<input class='subscribe__button' type='submit' value='Subscribe'>
						</form>
					</div>
					";
		}
		?></p>
	<div class="bottom"></div>
</section>
