<?php

class Admin {
	private $ser;	// server; 
	private $use;	// userName
	private $pas;	// passWord
	private $dat;	// database
	private $mysqli;

	function __construct() {
		$this->ser = 'localhost';
		$this->use = 'root';
		$this->pas = 'skyblue';
		$this->dat = 'socialistalliance';

		@ $this->mysqli = new mysqli($this->ser, $this->use, $this->pas, $this->dat);
	}

	public function getLinkIds() {
		$linkIdArray = array(); 

		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
			exit(); 
		} else {
			$query = "SELECT linkid FROM links ORDER BY linkorder"; 
			$result = $this->mysqli->query($query); 

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
				exit(); 
			} else {
				while ($row = $result->fetch_assoc()) {
					array_push($linkIdArray, $row['linkid']); 
				}

				return $linkIdArray; 
			}
		}
	}

	public function getLinkName($linkid) {
		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
		} else {
			$query = "SELECT linkname FROM links WHERE linkid=$linkid"; 
			$result = $this->mysqli->query($query); 

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
			} else {
				$row = $result->fetch_row(); 
				return $row[0]; 
			}
		}
	}

	public function getSublinkIdArray($linkId) {
		$sublinkIdArray = array(); 

		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
			exit(); 
		} else {
			$query = "SELECT sublinkid FROM sublinks WHERE linkid=$linkId ORDER BY sublinkorder"; 
			$result = $this->mysqli->query($query); 

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
				exit(); 
			} else {
				while ($row = $result->fetch_assoc()) {
					array_push($sublinkIdArray, $row['sublinkid']); 
				}

				return $sublinkIdArray; 
			}
		}
	}

	public function getSublinkName($linkId, $sublinkId) {
		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
			exit(); 
		} else {
			$query = "SELECT sublinkname FROM sublinks WHERE linkid=$linkId AND sublinkid=$sublinkId"; 
			$result = $this->mysqli->query($query); 

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
				exit(); 
			} else {
				$row = $result->fetch_row(); 
				return $row[0]; 
			}
		}
	}

	public function moveSublink($direction, $linkId, $sublinkId) {
		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			echo 'Error: could not connect to database!'; 
			exit(); 
		} else {
			$query = "SELECT sublinkid, sublinkorder FROM sublinks WHERE linkid=$linkId ORDER BY sublinkorder"; 
			$result = $this->mysqli->query($query); 

			if (!$result) {
				echo 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
				exit(); 
			} else {
				for ($i = 0; $i < $result->num_rows; $i++) {
					$row = $result->fetch_assoc(); 

					if ($row['sublinkid'] == $sublinkId) {
						$thisId = $row['sublinkid']; 
						$thisOrder = $row['sublinkorder']; 

						if ($direction == 'down') {
							$result->data_seek($i + 1); 
						} elseif ($direction == 'up') {
							$result->data_seek($i - 1); 
						}

						$swapRow = $result->fetch_assoc(); 

						$swapId = $swapRow['sublinkid']; 
						$swapOrder = $swapRow['sublinkorder']; 

						$query = "UPDATE sublinks SET sublinkorder=$swapOrder WHERE sublinkid=$thisId AND linkid=$linkId"; 
						$result = $this->mysqli->query($query); 

						if (!$result) {
							echo 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
							exit(); 
						} else {
							$query = "UPDATE sublinks SET sublinkorder=$thisOrder WHERE sublinkid=$swapId AND linkid=$linkId"; 
							$result = $this->mysqli->query($query); 

							if (!$result) {
								echo 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
								exit(); 
							}
						}
					}
				}
			}
		}
	}

	function __destruct() {
		$this->mysqli->close;
	}
}

/*

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

*/

?>