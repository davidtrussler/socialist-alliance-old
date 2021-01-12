<?php

require ('socAllAdminPage.php');
require ('socAllAdminClass.php');

$admin = new SocAllAdmin(); 

$content = <<<HTML
	<p>Select a page to edit</p>

	<table cellspacing="0" cellpadding="0">
HTML;

$linkIdArray = $admin->getLinkIds(); 

echo $linkIdArray; 

foreach ($linkIdArray as $linkId) {
	$linkName = $admin->getLinkName($linkId); 

	$content .= <<<HTML
		<tr>
			<td>$linkName</td>

			<td>
				<form action="managePage.php" method="post">
					<input type="hidden" name="linkId" value="$linkId"/>
					<input type="submit" name="" value="Edit"/>
				</form>
			</td>
		</tr>
HTML;
}

$content .= <<<HTML
	</ul>
HTML;

$manage = new SocAllAdminPage($content);
$manage->writePage();

?>