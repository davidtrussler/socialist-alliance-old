<?php

require ('socAllPage.inc');
require('database_connect.php'); 

$page = new SocAllPage();

$title = 'Greetings Cards'; 

$content = <<<HTML
	<div id="col_full">
		<div class="panel_full cards">
			<div id="cardPanel">
				<img src="graphics/card_a.png"/>
				<p>Version A</p>
				<img src="graphics/card_b.png"/>
				<p>Version B</p>
			</div>

			<h1>BUY YOUR FESTIVE GREETINGS CARDS FROM THE SOCIALIST ALLIANCE!</h1>

			<h2>AVOID THE QUEUES &#8211; AND SUPPORT SOCIALIST ENTERPRISE!</h2>

			<p>Comrades,</p>

			<p>Once again, the Socialist Alliance, in conjunction with Rugby Red Green Alliance, is selling Festive Greetings Cards. This year, they are on sale in plenty of time before the festivities begin.</p>

			<p>The cards are priced at 35p each, 10 for &#163;3 &#8211; the same prices as last year, despite inflation on stationary. This includes envelopes, postage and packing &#8211; all you will need after receiving them is your own stamp! The design can be seen above, with the inside blank for your message. There is a brief statement about the SA on the back of the card reading &#8216;This card was produced by the Socialist Alliance, a national organisation, with local branches, for all socialist and socialist green groups and individuals. The Socialist Alliance is campaigning for One Party for the Left based solidly within the working class. Proceeds will be shared between the Socialist Alliance and Rugby Red Green Alliance on the basis of need. Please contact the SA at PO Box 4123, Rugby CV21 9BJ&#8217;.</p>

			<p>You can order the cards in two versions: with the SA flag (Version A), or without (Version B). Everything else is the same. We will not take offence if you prefer not to have the SA flag! However, if you do not state a preference, we will send the cards which include the SA flag!</p>

			<p>Please send your orders through to me using the form below, and I will endeavor to post them back the day I receive your cheque &#8211; or the day after you order them as we get nearer to Xmas. Please make your cheque out to &#8216;The Socialist Alliance&#8217;, and post it to the Socialist Alliance at P.O. Box 4123, Rugby CV21 9BJ. You can phone us on 07881 520626 to confirm delivery.</p>

			<p>In unity,<br />
			Pete McLaren, SA National Secretary</p>
HTML;

if (isset($_GET['action']) && $_GET['action'] == 'send') {
	$name = $_POST['name']; 
	$email = $_POST['email']; 
	$address = $_POST['address']; 
	$postcode = $_POST['postcode']; 
	$numA = $_POST['numA']; 
	$numB = $_POST['numB']; 
	$numTotal = $_POST['numTotal']; 
	$cheque = $_POST['cheque']; 

	$to = 'pete.mclaren@virgin.net'; 
	$subject = 'Greetings Card Order'; 
	$headers = 'From: '.$name.'<'.$email.'>'; 
	$message = 
		"An order for Greetings Cards has been sent with the details below\n\r
		Name: $name\n\r
		Email address: $email\n\r 
		Postal address: $address\n\r 
		Postcode: $postcode\n\r 
		Number of cards, Version A: $numA\n\r 
		Number of cards, version B: $numB\n\r 
		Total number of cards: $numTotal\n\r 
		Cheque amount: $cheque"; 

	$mail = mail($to, $subject, $message, $headers); 

	if (!$mail) {
		$content .= <<<HTML
				<h3>There was a problem sending your order!</h3>
				<h4>Please try again later or email us at <a href="mailto:mail@socialistalliance.org.uk">mail@socialistalliance.org.uk</a> to report the problem.</h4>
HTML;
	} else {
		$content .= <<<HTML
				<h3>Your order has been sent</h3>
				<h4>Your cards will be sent to you as soon as your cheque is received.</h4>
HTML;
	}
} else {
	$content .= <<<HTML
			<h3>GREETINGS CARD ORDER FORM</h3>
			
			<form action="cards.php?action=send" method="post">
				<table cellspacing="0" cellpadding="0">
					<tr>
						<td class="label">Name</td>
						<td><input type="text" name="name" value="" class="input"/></td>
					</tr>
					
					<tr>
						<td class="label">Email Address</td>
						<td><input type="text" name="email" value="" class="input"/></td>
					</tr>
					
					<tr>
						<td class="label">Postal Address</td>
						<td><textarea name="address" class="input"></textarea></td>
					</tr>
					
					<tr>
						<td class="label">Post Code</td>
						<td><input type="text" name="postcode" value="" class="input"/></td>
					</tr>
	
					<tr>
						<td class="label">Number of cards with the SA flag (VERSION A)</td>
						<td><input type="text" name="numA" value="" class="input input_narrow"/></td>
					</tr> 
					
					<tr>
						<td class="label">Number of cards without the SA flag (VERSION B)</td>
						<td><input type="text" name="numB" value="" class="input input_narrow"/></td> 
					</tr> 
	
					<tr>
						<td class="label">Total (state number)</td>
						<td><input type="text" name="numTotal" value="" class="input input_narrow"/></td>
					</tr>
				</table>
					
				<p>I confirm a cheque for &#163; <input type="text" name="cheque" value="" class="input_narrow"/> made out to &#8216;The Socialist Alliance&#8217; is in the post to pay for these Greetings Cards, based on the price of 35p per card, or &#163;3 for ten.</p>
				
				<p>Any additional donation will, of course, be gratefully received!</p>

				<p><input type="submit" name="" value="Send Order"/></p>
			</form>
HTML;
}

$content .= <<<HTML
		</div>
	</div>
HTML;

$page->writePage($title, $content);

require('database_close.php'); 

?>