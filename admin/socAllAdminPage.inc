<?php

class SocAllAdminPage {

function writePage($content) {
	echo 
		'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">'; 
	$this->writeHead(); 
	$this->writeBody($content); 
	echo '</html>'; 
}

function writeHead() {

?>

<head>
	<title>socialist alliance | admin area</title>
	<link rel="stylesheet" type="text/css" href="../socAllPage.css"/>
	<link rel="stylesheet" type="text/css" href="socAllAdminPage.css"/>
	<script type="text/javascript" src="../socAllPage.js"></script>
	<script type="text/javascript" src="contentEditor.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>

<?php

}

function writeBody($content) {

?>

<body>
	<div id="wrap">
		<div id="banner">
			<h1>Socialist Alliance | Admin Area</h1>
		</div>
		
		<div id="links">
			<ul>
				<li><a href="index.php">Home</a></li><li><a href="manage.php">Manage Content</a></li>
			</ul>
		</div>

		<div id="content">

<?php echo $content; ?>

		</div>
	</div>
</body>

<?php

}

}

?>