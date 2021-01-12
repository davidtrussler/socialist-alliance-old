<?php

$linkid = $_POST['linkid']; 

$query = "SELECT linkname, type FROM links WHERE linkid='$linkid'"; 
$result = mysql_query($query); 

if (!$result) {
	$content = 'There was a problem getting the data: error number: '.mysql_errno().' ('.mysql_error().')'; 
} else {
	$linkname = mysql_result($result, 0, 'linkname'); 
	$type = mysql_result($result, 0, 'type'); 
}

$content .= 
	'<form action="links.php" method="post" onsubmit="submitText()">
		<h3>Top level link:<br />
		<input type="" name="linkname" value="'.$linkname.'"</h3>'; 

$query = "SELECT * FROM sublinks WHERE linkid='$linkid' ORDER BY sublinkorder"; 
$result = mysql_query($query); 

if (!$result) {
	$content = 'There was a problem getting the data: error number: '.mysql_errno().' ('.mysql_error().')'; 
} else {
	$num_rows = mysql_num_rows($result); 

	$sublinkid = mysql_result($result, 0, 'sublinkid'); 

	$content .= 
		'<h3>Content of main page:</h3>'; 

	require ('contentEditor.php'); 

	$content .= 
		'<input type="hidden" name="action" value="update"/>
		<input type="hidden" name="linkid" value="'.$linkid.'"/>
		<input type="hidden" name="sublinkid" value="'.$sublinkid.'"/>
		<input type="submit" value="Save changes"/>'; 
}

$content .= '</form>'; 

$content .= 
	'<h3>Sublinks:</h3>

	<table cellspacing="0" border="1">'; 

//	for ($i = $num_rows - 1; $i > 0 ; $i--) {
for ($i = 1; $i < $num_rows; $i++) {
	$sublinkid = mysql_result($result, $i, 'sublinkid'); 
	$sublinkname = mysql_result($result, $i, 'sublinkname'); 
	$sublinkorder = mysql_result($result, $i, 'sublinkorder'); 
	$content .= 
		'<tr>
			<td>'; 

	if ($i > 1) {
		$content .= 
				'<form method=post>
					<input type="hidden" name="action" value="move"/>
					<input type="hidden" name="direction" value="down"/> <!-- reverse? -->
					<input type="hidden" name="linkid" value="'.$linkid.'"/>
					<input type="hidden" name="sublinkid" value="'.$sublinkid.'"/>
					<input type="hidden" name="sublinkorder" value="'.$sublinkorder.'"/>
					<input type="submit" value="&#8595;"/>
				</form>'; 
	}
	
	$content .= 
			'</td>'; 

		$content .= 
			'<td>'.$sublinkname.'</td>'; 

	$content .= 
			'<td>'; 
	
	if ($i != ($num_rows - 1)) {
		$content .= 
				'<form method=post>
					<input type="hidden" name="action" value="move"/>
					<input type="hidden" name="direction" value="up"/> <!-- reverse? -->
					<input type="hidden" name="linkid" value="'.$linkid.'"/>
					<input type="hidden" name="sublinkid" value="'.$sublinkid.'"/>
					<input type="hidden" name="sublinkorder" value="'.$sublinkorder.'"/>
					<input type="submit" value="&#8593;"/>
				</form>'; 
	}
	
	$content .= 
			'</td>
	
			<td>'; 
	
	$content .= 
				'<form action="sublinks.php" method=post>
					<input type="hidden" name="action" value="edit"/>
					<input type="hidden" name="linkid" value="'.$linkid.'"/>
					<input type="hidden" name="sublinkid" value="'.$sublinkid.'"/>
					<input type="hidden" name="linkname" value="'.$linkname.'"/>
					<input type="hidden" name="sublinkname" value="'.$sublinkname.'"/>
					<input type="submit" value="edit"/>
				</form>'; 
	
	$content .= 
			'</td>
		</tr>'; 
}

if ($type != 'index') {
	$content .= 
		'<tr>
			<td colspan="5">
				<form action="sublinks.php" method=post>
					<input type="hidden" name="action" value="add"/>
					<input type="hidden" name="linkid" value="'.$linkid.'"/>
					<input type="hidden" name="linkname" value="'.$linkname.'"/>
					<input type="submit" value="add new sublink"/>
				</form>
			</td>
		</tr>'; 
}

$content .= 
	'</table>'; 

?>