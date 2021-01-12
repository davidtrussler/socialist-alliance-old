<?php

if (isset($_GET['action'])) {
	$action = $_GET['action']; 
} else {
	$action = null; 
}

require ('socAllPage.php');
require ('database_connect.php'); // database connection onto socAllPage

$title = 'Contact Us'; 

$content = <<<HTML
	<div id="col_left">
		<div class="panel_left">
			<h1>Contact Us</h1>
HTML;

if ($action == 'send') {
	$name = $_POST['name']; 
	$email = $_POST['email']; 
	$phone = $_POST['phone']; 
	$address = $_POST['address']; 
	$message = $_POST['message']; 
	$subject = $_POST['subject']; 

	$message .= 
		"\r\n\r\n".'Sender details:'.
		"\r\n".'name: '.$name.
		"\r\n".'email: '.$email.
		"\r\n".'telephone number: '.$phone.
		"\r\n".'address: '.$address; 

	$to = 'pete.mclaren@virgin.net'; 
	$headers = 'From: '.$email; 

	$mail = mail($to, $subject, $message, $headers); 

	if ($mail) {
		$content .= <<<HTML
			<p>Your message has been sent.</p>
HTML;
	} else {
		$content .= <<<HTML
			<p>There was a problem delivering your message. Please try again later.</p>
HTML;
	}
}

$content .= <<<HTML
	<form id="contact" action="?action=send" method="post">
		<fieldset class="col_left">
			<p class="label">Your name<br />
			<input class="input" type="text" name="name"/></p>

			<p class="label">Your email address<br />
			<input class="input" type="text" name="email"/></p>

			<p class="label">Your phone number<br />
			<input class="input" type="text" name="phone"/></p>
		</fieldset>

		<fieldset class="col_right">
			<p class="label">Your address<br />
			<textarea class="input" name="address"></textarea></p>
		</fieldset>

		<fieldset class="col_full">
			<p class="label">Subject of your message<br />
			<input class="input_wide" type="text" name="subject"/></p>

			<p class="label">Your message<br />
			<textarea class="input_deep" name="message"></textarea></p>

			<p><input class="submit" type="submit" value="send"/></p>
		</fieldset>
	</form>
HTML;

$content .= <<<HTML
		</div>
	</div>

	<div id="col_right">
		<div class="panel_right">
			<p>Contact us by email at<br />
			<a href="mailto:mail@socialistalliance.org.uk">mail@socialistalliance.org.uk</a><br />
			or by using the form on the left.</p> 

			<p>Click <a href="uploads/SA_membership_form_A4_2007.pdf">here</a> to download a membership form.</p>
		</div>
	</div>
HTML;

$contact = new SocAllPage($title, $content);

$contact->writePage();

require('database_close.php'); 

?>