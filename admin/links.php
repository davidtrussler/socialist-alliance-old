<?php

$self = 'links'; 
$action = $_POST['action']; 

require ('socAllAdminPage.inc');
require ('socAllAdminPageFunctions.php');
require ('../database_connect.php');

$links = new SocAllAdminPage($content);

if ($action) {
	$linkid = $_POST['linkid']; 

	switch ($action) {
		case 'move': 
			$direction = $_POST['direction']; 
			$linkorder = $_POST['linkorder']; 
		
			$query = "UPDATE links SET linkorder='NULL' WHERE linkorder='$linkorder'"; 
			$result = mysql_query($query); 
		
			if (!$result) {
				$content = 'There was a problem moving that link: error number: '.mysql_errno().' ('.mysql_error().')'; 
			}
		
			if ($direction == 'up') {
				$query = "UPDATE links SET linkorder='$linkorder' WHERE linkorder=('$linkorder' - 1)"; 
				$result = mysql_query($query); 
		
				if (!$result) {
					$content = 'There was a problem moving that link: error number: '.mysql_errno().' ('.mysql_error().')'; 
				}
		
				$query = "UPDATE links SET linkorder=('$linkorder' - 1) WHERE linkorder='NULL'"; 
				$result = mysql_query($query); 
		
				if (!$result) {
					$content = 'There was a problem moving that link: error number: '.mysql_errno().' ('.mysql_error().')'; 
				}
			} else {	// direction = 'dowm'
				$query = "UPDATE links SET linkorder='$linkorder' WHERE linkorder=('$linkorder' + 1)"; 
				$result = mysql_query($query); 
		
				if (!$result) {
					$content = 'There was a problem moving that link: error number: '.mysql_errno().' ('.mysql_error().')'; 
				}
		
				$query = "UPDATE links SET linkorder=('$linkorder' + 1) WHERE linkorder='NULL'"; 
				$result = mysql_query($query); 
		
				if (!$result) {
					$content = 'There was a problem moving that link: error number: '.mysql_errno().' ('.mysql_error().')'; 
				}
			}

			require('link_table.php'); 
		break; 

		case 'update': 
			$linkid = $_POST['linkid']; 
			$linkname = $_POST['linkname']; 
			$sublinkid = $_POST['sublinkid']; 
			$editedContent = $_POST['editedContent']; 
				$editedContent = format($editedContent); 

			$query = "UPDATE links SET linkname='$linkname' WHERE linkid=$linkid"; 
			$result = mysql_query($query); 
	
			if (!$result) {
				$content = 'There was a problem saving the data: error number: '.mysql_errno().' ('.mysql_error().')'; 
			} else {
				$query = "UPDATE sublinks SET content='$editedContent' WHERE sublinkid=$sublinkid"; 
				$result = mysql_query($query); 
		
				if (!$result) {
					$content = 'There was a problem saving the data: error number: '.mysql_errno().' ('.mysql_error().')'; 
				}
			}

			require('link_table.php'); 
		break; 

		case 'add': 
			$content .= 
				'<form action="links.php" method="post">
					<h3>Link:<br />

					<input type="text" name="linkname" value=""/></h3>'; 

			$sublinkid = 'new'; 

			require ('contentEditor.php'); 

			$content .= 
					'<input type="hidden" name="action" value="new"/>

					<input type="submit" name="" value="Save link"/>
				</form>'; 
		break; 

		case 'new': 
			$linkname = $_POST['linkname'];
			$sublinkname = $_POST['sublinkname']; 
			$editedContent = $_POST['editedContent']; 
				$editedContent = format($editedContent); 

/*
			echo 'linkname = '.$linkname.'<br />'; 
			echo 'sublinkname = '.$sublinkname.'<br />'; 
			echo 'content = '.$editedContent.'<br />'; 
*/

			$query = "SELECT linkorder FROM links ORDER BY linkorder DESC"; 
			$result = mysql_query($query); 

			if (!$result) {
				$content = 'There was a problem saving that link: error number: '.mysql_errno().' ('.mysql_error().')'; 
			} else {
				$linkorder = mysql_result($result, 0, 'linkorder'); 

				$query = "INSERT INTO links VALUES (NULL, '$linkname', ($linkorder + 1), NULL)"; 
				$result = mysql_query($query); 

				if (!$result) {
					$content = 'There was a problem saving that link: error number: '.mysql_errno().' ('.mysql_error().')'; 
				} else {
					$linkid = mysql_insert_id(); 
					$query = "INSERT INTO sublinks VALUES (NULL, '$sublinkname', 0, $linkid, '$editedContent')"; 
					$result = mysql_query($query); 

					if (!$result) {
						$content = 'There was a problem saving that link: error number: '.mysql_errno().' ('.mysql_error().')'; 
					} else {
						require('link_table.php'); 
					}
				}
			}
		break; 

		case 'delete': 
			
		break; 
	}
} else {
	require('link_table.php'); 
}

$links->writePage($content);

require ('../database_close.php');

?>