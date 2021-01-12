<?php

require('database_connect.php'); 

if (isset($_GET['sublinkid'])) {
	$query_sublink = $_GET['sublinkid']; 
	$sublinkid = $_GET['sublinkid']; 
}

if (isset($_GET['linkid'])) {
	$linkid = $_GET['linkid']; 
} else {
	$linkid = 1; 
}

if (isset($type)) {
	$type = $type; 
} else {
	$type = null; 
}

// echo 'linkid = '.$linkid.'<br />'; 

// GET TYPE FOR PAGE
if ($type != 'index') {
	$query = "SELECT type FROM links WHERE linkid='$linkid'"; 
	$result = mysql_query($query); 
	
	if (!$result) {
		echo mysql_errno($link).': '.mysql_error($link); 
	} else {
		$type = mysql_result($result, 0); 
	}
}

// echo 'type = '.$type.'<br />'; 

// GET TITLE FOR PAGE
if ($type == 'index') {
	$title = 'Home'; 
} elseif (isset($type) && $type == 'contact') {
	$title = 'Contact Us'; 
} else {
	$query = "SELECT linkname FROM links WHERE linkid=$linkid"; 
	$result = mysql_query($query); 
	
	if (!$result) {
		echo mysql_errno($link).': '.mysql_error($link); 
	} else {
		$title = stripslashes(mysql_result($result, 0)); 
	}
}

// echo 'title = '.$title.'<br />'; 

// GET SUBLINKS
if ($type != 'index') {
	$query = "SELECT sublinkid, sublinkname FROM sublinks WHERE linkid='$linkid' AND sublinkorder > 0 ORDER BY sublinkorder"; 
} else {
	// HOME PAGE
	if (isset($_GET['storyId'])) {
		$storyId = $_GET['storyId']; 
		$query = "SELECT content, sublinkname FROM sublinks WHERE sublinkid=$storyId"; 
	} else {
		$storyId = null; 
		$query = "SELECT sublinkid, sublinkname, content FROM sublinks WHERE linkid=1 ORDER BY sublinkorder"; 
	}
}

$result = mysql_query($query); 

if (!$result) {
	echo mysql_errno($link).': '.mysql_error($link); 
} else {
	if (!isset($storyId)) {
		$num_sublinks = mysql_num_rows($result); 
	}
}

// echo 'num_sublinks = '.$num_sublinks.'<br />'; 

// MAIN PANEL ->
if (isset($num_sublinks) && $num_sublinks!= 0 && $type != 'index') {
	$content = 
		'<div id="col_left">
			<div class="panel_left">'; 
} else {
	$content = 
		'<div id="col_full">
			<div class="panel_full">'; 
}
	
if ($type != 'index') {
	if (isset($sublinkid)) {
		$query = "SELECT content, sublinkname FROM sublinks WHERE sublinkid='$sublinkid'";
		$result_main = mysql_query($query);  
		
		if (!$result_main) {
			echo mysql_errno($link).': '.mysql_error($link); 
		} else {
			$content_main = stripslashes(mysql_result($result_main, 0)); 
			$title_main = stripslashes(mysql_result($result_main, 0, 'sublinkname')); 
		}
		
		$content .= $content_main; 
	} else {
		// DEFAULT CONTENT ->
		$query = "SELECT content, sublinkname FROM sublinks WHERE linkid=$linkid AND sublinkorder=0";
		$result_def = mysql_query($query);  
		
		if (!$result_def) {
			echo mysql_errno($link).': '.mysql_error($link); 
		} else {
			$content_def = stripslashes(mysql_result($result_def, 0)); 
			$title_def = stripslashes(mysql_result($result_def, 0, 'sublinkname')); 
		}
	
		$content .= $content_def; 
		// <- DEFAULT CONTENT
	}
} else {
	// HOME PAGE
	// SINGLE STORY LEVEL
	if ($storyId) {
		$storyContent = stripslashes(mysql_result($result, 0, 'content')); 
		$storyHead = stripslashes(mysql_result($result, 0, 'sublinkname')); 

		$content .= <<<HTML
			<p class="return"><a href="index.php">< back</a></p>
			<h1>$storyHead</h1>
			<p>$storyContent</p>
HTML;
	// GENERAL LEVEL
	} else {
		// include('includes/formatter.php'); 
		// $format = new Formatter(); 
	
		for ($i = $num_sublinks - 1; $i >= 0; $i--) {
			// $storyContent = stripslashes(mysql_result($result, $i, 'content')); 
			$storyHead = stripslashes(mysql_result($result, $i, 'sublinkname')); 
			$storyId = mysql_result($result, $i, 'sublinkid'); 
			$storyLink = '<a href="?linkId=1&storyId='.$storyId.'">read article</a>';
	
			// truncate story and add link
			// $story = $format->truncateStory($storyContent, $storyId); 
			$content .= <<<HTML
				<div class="story">
					<p class="storyHead">$storyHead</p>
					<p class="storyLink">$storyLink</p>
				</div>
HTML;
		}
	}
}

if (isset($num_sublinks) && $num_sublinks != 0 && $type != 'index') {
	$content .= 
			'<img class="panel_bottom" src="graphics/content_BG_bottom.gif"/>'; 
} else {
	$content .= 
			'<img class="panel_bottom" src="graphics/full_BG_bottom.gif"/>'; 
}

$content .= 
		'</div>
	</div>'; 
// <- MAIN PANEL

// RIGHT PANEL ->
if (isset($num_sublinks) && $num_sublinks != 0 && $type != 'index') {
	$content .= 
		'<div id="col_right">
			<div class="panel_right">'; 
	
	if ($type == 'index') {
		$query = "SELECT sublinkname, content FROM sublinks WHERE linkid='$linkid' AND sublinkorder=1";
		$result = mysql_query($query); 
		
		if (!$result) {
			echo mysql_errno($link).': '.mysql_error($link); 
		} else {
			$title_panel = mysql_result($result, 0, 'sublinkname'); 
			$content_panel = mysql_result($result, 0, 'content'); 
		}
	
		$content .= '<h2>'.$title_panel.'</h2>'.$content_panel; 
	} else {
		// SUBLINKS ->
		for ($i = 0; $i < $num_sublinks; $i++) {
			$sublink_id = mysql_result($result, $i, 'sublinkid'); 
			$sublink_name = mysql_result($result, $i, 'sublinkname'); 
	
			if (isset($query_sublink) && $sublink_id == $query_sublink) {
				$content .= 
					'<p class="live">'.$sublink_name.'</p>'; 
			} else {
				$content .= 
					'<p><a href="page.php?linkid='.$linkid.'&sublinkid='.$sublink_id.'">'.$sublink_name.'</a></p>'; 
			}
		}
		// <- SUBLINKS
	}
	
	$content .= 
				'<img class="panel_bottom" src="graphics/panel_BG_bottom.gif"/>
			</div>
		</div>'; 
}
// <- RIGHT PANEL

require ('socAllPage.php');

$page = new SocAllPage($title, $content);

$page->writePage();

require('database_close.php'); 

?>