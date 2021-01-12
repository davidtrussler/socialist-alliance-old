<?php

$query = "SELECT * FROM links ORDER BY linkorder"; 
$result_links = mysql_query($query); 

if (!$result_links) {
	$content = 'There was a problem getting the data: error number: '.mysql_errno().' ('.mysql_error().')'; 
} else {
	$num_links = mysql_num_rows($result_links); 
	$linkArray = array(); 
	$linkTypeArray = array(); 
	$sublinkIdArray = array(); 
	$sublinkOrderArray = array(); 
	$sublinkNameArray = array(); 
	$max_sublinks = 0; 
}

$content .= 
	'<table cellspacing="0">
		<tr>'; 

// LINKS
for ($i = 0; $i < $num_links; $i++) {
	$linkid = mysql_result($result_links, $i, 'linkid'); 
	$linkname = mysql_result($result_links, $i, 'linkname'); 
	$linkorder = mysql_result($result_links, $i, 'linkorder'); 
	$type = mysql_result($result_links, $i, 'type'); 

	$content .= 
			'<td>'.$linkname.'<br/>'; 

	if ($type != 'index' && $i != 1) {
		$content .= 
				'<form method=post>
					<input type="hidden" name="action" value="move"/>
					<input type="hidden" name="direction" value="up"/>
					<input type="hidden" name="linkid" value="'.$linkid.'"/>
					<input type="hidden" name="linkorder" value="'.$linkorder.'"/>
					<input type="submit" value="&#8592;"/>
				</form>'; 
	}
	
	if ($type != 'contact') {
		$content .= 
				'<form action="content.php" method=post>
					<input type="hidden" name="action" value="edit"/>
					<input type="hidden" name="linkid" value="'.$linkid.'"/>
					<input type="submit" value="edit"/>
				</form>'; 
	}
	
	if ($type != 'index' && $type != 'contact') {
		$content .= 
				'<form method=post>
					<input type="hidden" name="action" value="delete"/>
					<input type="hidden" name="linkid" value="'.$linkid.'"/>
					<input type="submit" value="delete"/>
				</form>'; 
	}
	
	if ($type != 'index' && $i != ($num_links - 1)) {
		$content .= 
				'<form method=post>
					<input type="hidden" name="action" value="move"/>
					<input type="hidden" name="direction" value="down"/>
					<input type="hidden" name="linkid" value="'.$linkid.'"/>
					<input type="hidden" name="linkorder" value="'.$linkorder.'"/>
					<input type="submit" value="&#8594;"/>
				</form>'; 
	}
	
	$content .= 
			'</td>'; 

	$query = "SELECT sublinkid, sublinkorder, sublinkname FROM sublinks WHERE linkid='$linkid' ORDER BY sublinkorder"; 
	$result_sublinks = mysql_query($query); 

	if (!$result_sublinks) {
		$content = 'There was a problem getting the data: error number: '.mysql_errno().' ('.mysql_error().')'; 
	} else {
		$num_sublinks = mysql_num_rows($result_sublinks); 

		if ($num_sublinks > $max_sublinks) {
			$max_sublinks = $num_sublinks; 
		}

		for ($j = 0; $j < $num_sublinks; $j++) {
			$sublinkIdArray[$i][$j] .= mysql_result($result_sublinks, $j, 'sublinkid');
			$sublinkOrderArray[$i][$j] .= mysql_result($result_sublinks, $j, 'sublinkorder');
			$sublinkNameArray[$i][$j] .= mysql_result($result_sublinks, $j, 'sublinkname');
		}
	}

	$linkTypeArray[$i] .= $type;
}

$content .= 
			'<td>
				<form action="links.php" method=post>
					<input type="hidden" name="action" value="add"/>
					<input type="submit" value="New link"/>
				</form>
			</td>
		</tr>'; 

// SUBLINKS
for ($k = 1; $k < $max_sublinks; $k++) {
	$content .= 
		'<tr>'; 

	for ($i = 0; $i < $num_links; $i++) {
		$content .= 
			'<td>'.$sublinkNameArray[$i][$k].'<br />'; 

		if ($sublinkIdArray[$i][$k]) {
			if ($linkTypeArray[$i] != 'index' && $linkTypeArray[$i] != 'contact') {
				$content .= 
					'<form method=post>
						<input type="hidden" name="action" value="move"/>
						<input type="hidden" name="direction" value="up"/>
						<input type="hidden" name="linkid" value="'.$linkid.'"/>
						<input type="hidden" name="linkorder" value="'.$linkorder.'"/>
						<input type="submit" value="&#8593;"/>
					</form>'; 
			}
	
			if ($linkTypeArray[$i] != 'contact') {
				$content .= 
					'<form action="sublinks.php" method=post>
						<input type="hidden" name="linkid" value="'.$linkid.'"/>
						<input type="submit" value="edit"/>
					</form>'; 
			}

			if ($linkTypeArray[$i] != 'index' && $linkTypeArray[$i] != 'contact') {
				$content .= 
					'<form method=post>
						<input type="hidden" name="action" value="delete"/>
						<input type="hidden" name="linkid" value="'.$linkid.'"/>
						<input type="submit" value="delete"/>
					</form>'; 
			}

			if ($linkTypeArray[$i] != 'index' && $linkTypeArray[$i] != 'contact') {
				$content .= 
					'<form method=post>
						<input type="hidden" name="action" value="move"/>
						<input type="hidden" name="direction" value="down"/>
						<input type="hidden" name="linkid" value="'.$linkid.'"/>
						<input type="hidden" name="linkorder" value="'.$linkorder.'"/>
						<input type="submit" value="&#8595;"/>
					</form>'; 
			}
		}

		$content .= 
				'</td>'; 
	}

$content .= 
		'</tr>'; 
}

$content .= 
	'</table>'; 

?>