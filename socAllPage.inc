<?php

class SocAllPage {

function writePage($title, $content) {
	echo 
		'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
		<!-- eu account -->'; 
	$this->writeHead($title); 
	$this->writeBody($content); 
	echo '</html>'; 
}

function writeHead($title) {

?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Socialist Alliance | <?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="socAllPage.css"/>
	<script type="text/javascript" src="socAllPage.js"></script>
</head>

<?php

}

function writeBody($content) {

?>

<body>
	<div id="wrap">
		<div id="banner">
			<img src="graphics/banner.gif"/>
		</div>
		
		<div id="links">
			<p>
				<ul>

<?php

if (isset($_GET['linkid'])) {
	$query_link = $_GET['linkid']; 
} else {
	$query_link = 1; 
}

$query = "SELECT * FROM links ORDER BY linkorder"; 
$result = mysql_query($query); 
if (!$result) {
	echo mysql_errno($link).': '.mysql_error($link); 
} else {
	$num_links = mysql_num_rows($result); 
	$link_url_array = array(); 
	$link_array = array(); 

	for ($i = 0; $i < $num_links; $i++) {
		$linkid = mysql_result($result, $i, 'linkid'); 
		$linkname = mysql_result($result, $i, 'linkname'); 
		array_push($link_url_array, $linkid); 
		array_push($link_array, $linkname); 
	}

	// EXTRA TEMPORARY PAGE ADDED FOR GREETINGS CARDS
	$selfArray = explode('/', $_SERVER['PHP_SELF']); 
	$self = array_pop($selfArray); 
	// EXTRA TEMPORARY PAGE ADDED FOR GREETINGS CARDS

	for ($i = 0; $i < count($link_array); $i++) {
		if ($link_url_array[$i] == $query_link && $self != 'cards.php') {
			echo '<li class="live">'.mysql_result($result, $i, 'linkname').'</li>'; 
		} else {
			echo '<li><a href="page.php?linkid='.mysql_result($result, $i, 'linkid').'">'.mysql_result($result, $i, 'linkname').'</a></li>'; 
		}
	}

	// EXTRA TEMPORARY PAGE ADDED FOR GREETINGS CARDS
	if ($self == 'cards.php') {
		echo '<li class="live">Greetings Cards</li>'; 
	} else {
		echo '<li><a href="cards.php">Greetings Cards</a></li>'; 
	}
	// EXTRA TEMPORARY PAGE ADDED FOR GREETINGS CARDS
}

?>

				</ul>
			</p>
		</div>

		<div id="content">

<?php echo $content; ?>

		</div>

		<div id="footer">
			<p>Alliance for Socialism, Internationalism, Republicanism, and the Environment and opposed to racism, fascism and specific oppressions</p>
			<img class="panel_bottom" src="graphics/footer_BG_bottom.gif"/>
		</div>

		<div id="credits">
			<p>&#169; Socialist Alliance <?php echo date('Y'); ?>, web design: <a href="http://www.futurawebsites.com" class="newWindow">futura websites</a></p>
		</div>
	</div>
</body>

<?php

}

}

?>