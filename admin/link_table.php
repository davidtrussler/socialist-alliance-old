<?php

$query = "SELECT * FROM links ORDER BY linkorder"; 
$result = mysql_query($query); 

if (!$result) {
	$content = 'There was a problem getting the data: error number: '.mysql_errno().' ('.mysql_error().')'; 
} else {
	$num_rows = mysql_num_rows($result); 
}

$content .= 
	'<table cellspacing="0" border="1">
		<tr><th colspan="5">Top level links</th></tr>'; 


for ($i = 0; $i < $num_rows; $i++) {
	$linkid = mysql_result($result, $i, 'linkid'); 
	$linkname = mysql_result($result, $i, 'linkname'); 
	$linkorder = mysql_result($result, $i, 'linkorder'); 
	$type = mysql_result($result, $i, 'type'); 
	$content .= 
		'<tr>
			<td>'; 

if ($type != 'index') {
	if ($i != 1) {
		$content .= 
					'<form method=post>
						<input type="hidden" name="action" value="move"/>
						<input type="hidden" name="direction" value="up"/>
						<input type="hidden" name="linkid" value="'.$linkid.'"/>
						<input type="hidden" name="linkorder" value="'.$linkorder.'"/>
						<input type="submit" value="&#8593;"/>
					</form>'; 
	} else {
		$content .= '&nbsp;'; 
	}
} else {
	$content .= '&nbsp;'; 
}

	$content .= 
			'</td>

			<td>'.$linkname.'</td>

			<td>'; 

if ($type != 'index') {
	if ($i != ($num_rows - 1)) {
		$content .= 
					'<form method=post>
						<input type="hidden" name="action" value="move"/>
						<input type="hidden" name="direction" value="down"/>
						<input type="hidden" name="linkid" value="'.$linkid.'"/>
						<input type="hidden" name="linkorder" value="'.$linkorder.'"/>
						<input type="submit" value="&#8595;"/>
					</form>'; 
	} else {
		$content .= '&nbsp;'; 
	}
} else {
	$content .= '&nbsp;'; 
}

	$content .= 
			'</td>

			<td>'; 

if ($type != 'contact') {
	$content .= 
				'<form action="sublinks.php" method=post>
					<input type="hidden" name="linkid" value="'.$linkid.'"/>
					<input type="submit" value="edit"/>
				</form>'; 
}

	$content .= 
			'</td>

			<td>'; 

if ($type != 'index' && $type != 'contact') {
/*
	$content .= 
				'<form method=post>
					<input type="hidden" name="action" value="delete"/>
					<input type="hidden" name="linkid" value="'.$linkid.'"/>
					<input type="submit" value="delete"/>
				</form>'; 
} else {
	$content .= '&nbsp;'; 
*/
}

	$content .= 
			'</td>'; 
		'</tr>'; 
}

	$content .= 
		'<tr>
			<td colspan="5">
				<form action="links.php" method=post>
<!--					Add new link:<br />
					<input type="text" name="linkname" value=""/><br />	-->
					<input type="hidden" name="action" value="add"/>
					<input type="submit" value="Add new link"/>
				</form>
			</td>
		</tr>'; 

$content .= 
	'</table>'; 

?>