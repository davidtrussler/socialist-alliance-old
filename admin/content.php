<?php

$action = $_POST['action']; 

require ('../database_connect.php');
require ('socAllAdminPage.inc');
require ('socAllAdminPageFunctions.php');

$sublinks = new SocAllAdminPage($content);

//	if ($action) {
//	$linkid = $_POST['linkid']; 
//	$sublinkid = $_POST['sublinkid']; 

	switch ($action) {
/*
		case 'move': 
			$direction = $_POST['direction']; 
			$sublinkorder = $_POST['sublinkorder']; 
		
			$query = "UPDATE sublinks SET sublinkorder=-1 WHERE sublinkorder='$sublinkorder' AND linkid='$linkid'"; 
			$result = mysql_query($query); 
		
			if (!$result) {
				$content = 'There was a problem moving that link: error number: '.mysql_errno().' ('.mysql_error().')'; 
			}
		
			if ($direction == 'up') {
				$query = "UPDATE sublinks SET sublinkorder='$sublinkorder' WHERE sublinkorder=('$sublinkorder' - 1) AND linkid='$linkid'"; 
				$result = mysql_query($query); 
		
				if (!$result) {
					$content = 'There was a problem moving that link: error number: '.mysql_errno().' ('.mysql_error().')'; 
				}
		
				$query = "UPDATE sublinks SET sublinkorder=('$sublinkorder' - 1) WHERE sublinkorder=-1 AND linkid='$linkid'"; 
				$result = mysql_query($query); 
		
				if (!$result) {
					$content = 'There was a problem moving that link: error number: '.mysql_errno().' ('.mysql_error().')'; 
				}
			} else {	// direction = 'dowm'
				$query = "UPDATE sublinks SET sublinkorder='$sublinkorder' WHERE sublinkorder=('$sublinkorder' + 1) AND linkid='$linkid'"; 
				$result = mysql_query($query); 
		
				if (!$result) {
					$content = 'There was a problem moving that link: error number: '.mysql_errno().' ('.mysql_error().')'; 
				}
		
				$query = "UPDATE sublinks SET sublinkorder=('$sublinkorder' + 1) WHERE sublinkorder=-1 AND linkid='$linkid'"; 
				$result = mysql_query($query); 
		
				if (!$result) {
					$content = 'There was a problem moving that link: error number: '.mysql_errno().' ('.mysql_error().')'; 
				}
			}
		break; 

		case 'delete': 
			
		break; 

		case 'add': 
			$linkname = $_POST['linkname']; 
			$sublinkid = 'new'; 

			$content .= 
				'<form action="sublinks.php" method="post" onsubmit="submitText()">

				<h3>Top level link: '.$linkname.'</h3> 

				<h3>Sublink:<br />
				<input type="" name="sublinkname" value=""</h3>

				<h3>Content of page:</h3>'; 

			require('contentEditor.php'); 

			$content .= 
				'<input type="hidden" name="linkid" value="'.$linkid.'"
				<input type="hidden" name="action" value="insertSublink"
				<input type="submit" value="Create sublink"'; 
		break; 
*/

		case 'edit': 
/*
			$linkname = $_POST['linkname']; 
			$sublinkid = $_POST['sublinkid']; 
			$sublinkname = $_POST['sublinkname']; 
*/

	if ($_POST['linkid']) {
		$linkid = $_POST['linkid']; 
		
		$query = "SELECT linkname FROM links WHERE linkid=$linkid"; 
		$result = mysql_query($query); 
	
		if (!$result) {
			$content = 'There was a problem moving that link: error number: '.mysql_errno().' ('.mysql_error().')'; 
		} else {
			$linkname = mysql_result($result, 0); 

			$query = "SELECT sublinkid FROM sublinks WHERE linkid=$linkid AND sublinkorder=0"; 
			$result = mysql_query($query); 
		
			if (!$result) {
				$content = 'There was a problem moving that link: error number: '.mysql_errno().' ('.mysql_error().')'; 
			} else {
				$sublinkid = mysql_result($result, 0); 
			}
		}

		$content .= 
			'<h3>Link: <input type="" name="linkname" value="'.$linkname.'"</h3>'; 
	} 

			$content .= 
				'<form action="manage.php" method="post" onsubmit="submitText()">

				<h3>Content of page:</h3>'; 

			require('contentEditor.php'); 

			$content .= 
				'<input type="hidden" name="linkid" value="'.$linkid.'"/>
				<input type="hidden" name="linkname" value="'.$linkname.'"/>
				<input type="hidden" name="sublinkid" value="'.$sublinkid.'"/>
				<input type="hidden" name="action" value="update"/>
				<input type="submit" value="Save Changes"/>'; 
		break; 

/*
		case 'insertSublink': 
			$linkid = $_POST['linkid']; 
			$sublinkname = $_POST['sublinkname']; 
			$editedContent = $_POST['editedContent']; 
				$editedContent = format($editedContent); 

			$query = "INSERT INTO sublinks VALUES (NULL, '$sublinkname', 1, $linkid, '$editedContent')"; 
			$result = mysql_query($query); 
		
			if (!$result) {
				$content = 'There was a problem saving that data: error number: '.mysql_errno().' ('.mysql_error().')'; 
			} else {
				require('sublink_table.php'); 
			}
		break; 

		case 'new': 
			$linkname = $_POST['linkname']; 
			$sublinkid = $_POST['sublinkid']; 
			$sublinkname = $_POST['sublinkname']; 

			$content .= 
				'<form action="sublinks.php" method="post" onsubmit="submitText()">

				<h3>Top level link: '.$linkname.'</h3> 

				<h3>Sublink:<br />
				<input type="" name="sublinkname" value="'.$sublinkname.'"</h3>

				<h3>Content of page:</h3>'; 

			require('contentEditor.php'); 

			$content .= 
				'<input type="hidden" name="linkid" value="'.$linkid.'"
				<input type="hidden" name="action" value="updateSublink"
				<input type="submit" value="Save Changes"'; 
		break; 

		case 'updateSublink': 
			$sublinkid = $_POST['sublinkid']; 
			$sublinkname = $_POST['sublinkname']; 
			$editedContent = $_POST['editedContent']; 
				$editedContent = format($editedContent); 

			$query = "UPDATE sublinks SET sublinkname='$sublinkname', content='$editedContent' WHERE sublinkid=$sublinkid"; 
			$result = mysql_query($query); 
		
			if (!$result) {
				$content = 'There was a problem saving that data: error number: '.mysql_errno().' ('.mysql_error().')'; 
			} else {
				require('sublink_table.php'); 
			}
		break; 
*/
	}
//	}

/*
if (!$action || $action == 'move') {
	require('link_table.php'); 
}
*/

$sublinks->writePage($content);

require ('../database_close.php');

?>