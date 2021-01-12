<?php

require ('socAllAdminPage.php');
require ('socAllAdminClass.php');

$linkId = $_POST['linkId']; 
$admin = new SocAllAdmin(); 

if (isset($_POST['action'])) {
	if ($_POST['action'] == 'move') {
		$direction = $_POST['direction']; 
		$sublinkid = $_POST['sublinkid']; 
		$admin->moveSublink($direction, $linkId, $sublinkid); 
	} elseif ($_POST['action'] == 'save') {
		$sublinkId = $_POST['sublinkId']; 
		$sublinkName = $_POST['sublinkName']; 
		$editedContent = $_POST['editedContent']; 
		$return = $admin->updateContent($linkId, $sublinkId, $sublinkName, $editedContent); 
//		echo $editedContent; 
	} elseif ($_POST['action'] == 'delete') {
		$sublinkId = $_POST['sublinkId']; 
		$return = $admin->deleteContent($sublinkId); 
	}

	$content = <<<HTML
		<p>$return</p>
HTML;
}

$content .= <<<HTML
	<table cellspacing="0" cellpadding="0">
HTML;

$sublinkIdArray = $admin->getSublinkIdArray($linkId); 

for ($i = 0; $i < count($sublinkIdArray); $i++) {
	$sublinkId = $sublinkIdArray[$i]; 
	$sublinkName = $admin->getSublinkName($linkId, $sublinkId); 

	if ($i == 0 && $linkId != 1) {
		$content .= <<<HTML
			<tr>
				<td>&nbsp;</td>
		
				<td>DEFAULT</td>
		
				<td>&nbsp;</td>
		
				<td>
					<form action="edit.php" method="post">
						<input type="hidden" name="action" value="editDefault"/>
						<input type="hidden" name="linkId" value="$linkId"/>
						<input type="submit" value="edit"/>
					</form>
				</td>
		
				<td>&nbsp;</td>
			</tr>
HTML;
	} else {
		$content .= <<<HTML
			<tr>
HTML;

		if ($i != 1 && $linkId != 1) {
			$content .= <<<HTML
				<td>
					<form action="managePage.php" method=post>
						<input type="hidden" name="action" value="move"/>
						<input type="hidden" name="direction" value="up"/>
						<input type="hidden" name="linkId" value="$linkId"/>
						<input type="hidden" name="sublinkid" value="$sublinkId"/>
						<input type="submit" value="&#8593;"/>
					</form>
				</td>
HTML;
		} elseif ($linkId != 1) {
			$content .= <<<HTML
				<td>&nbsp;</td>
HTML;
		}

		$content .= <<<HTML
				<td>$sublinkName</td>
HTML;

		if ($i != (count($sublinkIdArray) - 1) && $linkId != 1) {
			$content .= <<<HTML
				<td>
					<form action="managePage.php" method=post>
						<input type="hidden" name="action" value="move"/>
						<input type="hidden" name="direction" value="down"/>
						<input type="hidden" name="linkId" value="$linkId"/>
						<input type="hidden" name="sublinkid" value="$sublinkId"/>
						<input type="submit" value="&#8595;"/>
					</form>
				</td>
HTML;
		} elseif ($linkId != 1) {
			$content .= <<<HTML
				<td>&nbsp;</td>
HTML;
		}

		$content .= <<<HTML
				<td>
					<form action="edit.php" method="post">
						<input type="hidden" name="action" value="edit"/>
						<input type="hidden" name="linkId" value="$linkId"/>
						<input type="hidden" name="sublinkId" value="$sublinkId"/>
						<input type="submit" value="edit"/>
					</form>
				</td>
	
				<td>
					<form action="managePage.php" method="post" class="delete">
						<input type="hidden" name="action" value="delete"/>
						<input type="hidden" name="linkId" value="$linkId"/>
						<input type="hidden" name="sublinkId" value="$sublinkId"/>
						<input type="submit" value="delete"/>
					</form>
				</td>
			</tr>
HTML;
	}
}

$content .= <<<HTML
	</table>
HTML;

$content .= <<<HTML
	<form action="edit.php" method="post">
		<input type="hidden" name="action" value="new"/>
		<input type="hidden" name="linkId" value="$linkId"/>
HTML;

if ($linkId != 1) {
	$content .= <<<HTML
		<input type="submit" value="ADD NEW SUBLINK"/>
HTML;
} else {
	$content .= <<<HTML
		<input type="submit" value="ADD NEW STORY"/>
HTML;
}

$content .= <<<HTML
	</form>
HTML;

$managePage = new SocAllAdminPage($content);
$managePage->writePage();

?>