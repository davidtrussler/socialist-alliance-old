<?php

class SocAllAdmin {
	private $ser;	// server; 
	private $use;	// userName
	private $pas;	// passWord
	private $dat;	// database
	private $mysqli;

	public function __construct() {
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

	public function getSublinkId($linkId) {
		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
			exit(); 
		} else {
			$query = "SELECT sublinkid FROM sublinks WHERE linkid=$linkId AND sublinkorder=0"; 
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

	public function getSublinkName($linkId, $sublinkId) {
		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
			exit(); 
		} else {
			if ($linkId == null) {
				$query = "SELECT sublinkname FROM sublinks WHERE sublinkid=$sublinkId"; 
			} else {
				$query = "SELECT sublinkname FROM sublinks WHERE linkid=$linkId AND sublinkid=$sublinkId"; 
			}

			$result = $this->mysqli->query($query); 

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
				exit(); 
			} else {
				$row = $result->fetch_row(); 
				$text = stripslashes($row[0]); 
				return $text; 
			}
		}
	}

	public function getBody($sublinkId) {
		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
			exit(); 
		} else {
			$query = "SELECT content FROM sublinks WHERE sublinkid=$sublinkId"; 
			$result = $this->mysqli->query($query); 

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
				exit(); 
			} else {
				$row = $result->fetch_row(); 
				$text = stripslashes($row[0]); 

				return $text; 
			}
		}
	}

	public function moveSublink($direction, $linkId, $sublinkId) {
		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
			exit(); 
		} else {
			$query = "SELECT sublinkid, sublinkorder FROM sublinks WHERE linkid=$linkId ORDER BY sublinkorder"; 
			$result = $this->mysqli->query($query); 

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
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
							return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
							exit(); 
						} else {
							$query = "UPDATE sublinks SET sublinkorder=$thisOrder WHERE sublinkid=$swapId AND linkid=$linkId"; 
							$result = $this->mysqli->query($query); 

							if (!$result) {
								return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
								exit(); 
							}
						}
					}
				}
			}
		}
	}

	public function updateContent($linkId, $sublinkId, $sublinkName, $editedContent) {
		$sublinkName = $this->format($sublinkName); 
		$editedContent = $this->format($editedContent); 

		// echo $editedContent; 

		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
			exit(); 
		} else {
			if ($sublinkId == null) {
				$query = "SELECT MAX(sublinkorder) FROM sublinks WHERE linkid=$linkId"; 
				$result = $this->mysqli->query($query); 
	
				if (!$result) {
					return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
					exit(); 
				} else {
					$row = $result->fetch_row(); 
					$sublinkOrder = $row[0] + 1; 

					$query = "INSERT INTO sublinks VALUES (NULL, '$sublinkName', $sublinkOrder, $linkId, '$editedContent')"; 
				}
			} else {
				$query = "UPDATE sublinks SET sublinkname='$sublinkName', content='$editedContent' WHERE sublinkid=$sublinkId"; 
			}

			$result = $this->mysqli->query($query); 

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
				exit(); 
			} else {
				return 'The page has been updated.'; 
			}
		}
	}

	public function updateLinkName($linkId, $linkName) {
//		$linkName = $this->format($sublinkName); 

		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
			exit(); 
		} else {
			$query = "UPDATE links SET linkname='$linkName' WHERE linkid=$linkId"; 
		}

		$result = $this->mysqli->query($query); 

		if (!$result) {
			return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
			exit(); 
		} else {
			return 'The link name has been updated.'; 
		}
	}

	public function deleteContent($sublinkId) {
		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
			exit(); 
		} else {
			$query = "DELETE FROM sublinks WHERE sublinkid=$sublinkId"; 
			$result = $this->mysqli->query($query); 

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
				exit(); 
			} else {
				return 'The page has been deleted.'; 
			}
		}
	}

	private function format($text) {
		/* CONVERSION FOR MICROSOFT CHARACTERS
		$text = str_replace(chr(133), '&#8230;', $text);	// ellipsis
		$text = str_replace(chr(149), '-', $text);		// bullet
		$text = str_replace(chr(150), '&#8211;', $text);    	// endash
		$text = str_replace(chr(151), '&#8212;', $text);	// emdash
		$text = str_replace(chr(167), '&#176;', $text);		// degrees
		$text = str_replace(chr(145), '&#8216;', $text);	// left single quote
		$text = str_replace(chr(146), '&#8217;', $text);	// right single quote
		$text = str_replace(chr(147), '&#8220;', $text);	// left double quote
		$text = str_replace(chr(148), '&#8221;', $text);	// right double quote */

		$text = str_replace('%22', '"', $text);			// double quotes
		$text = str_replace('%20', ' ', $text);			// spaces
		$text = str_replace('&nbsp;', ' ', $text);		// spaces
		$text = str_replace('  ', ' ', $text);			// double spaces
		$text = str_replace(' - ', ' &#8211; ', $text);		// dash

		// dubious classes and suchlike from fucking Microsoft word processing
		$text = preg_replace('/<p(.*?)>/', '<p>', $text);
		$text = preg_replace('/<h1(.*?)>/', '<h1>', $text);
		$text = preg_replace('/<h2(.*?)>/', '<h2>', $text);
		$text = preg_replace('/<h3(.*?)>/', '<h4>', $text);
		$text = preg_replace('/<ul(.*?)>/', '<ul>', $text);
		$text = preg_replace('/<ol(.*?)>/', '<ol>', $text);
		$text = preg_replace('/<li(.*?)>/', '<li>', $text);
		$text = preg_replace('/<a(.*?)>/', '<a>', $text);
		$text = preg_replace('/<span(.*?)>/', '<span>', $text);
		$text = preg_replace('/<table(.*?)>/', '<table>', $text);
		$text = preg_replace('/<thead(.*?)>/', '<thead>', $text);
		$text = preg_replace('/<tbody(.*?)>/', '<tbody>', $text);
		$text = preg_replace('/<tfoot(.*?)>/', '<tfoot>', $text);
		$text = preg_replace('/<tr(.*?)>/', '<tr>', $text);
		$text = preg_replace('/<th(.*?)>/', '<th>', $text);
		$text = preg_replace('/<td(.*?)>/', '<td>', $text);

		$text = strip_tags($text, '<p><h1><h2><h3><h4><ul><ol><li><a><span><b><i><u><em><strong><table><thead><tbody><tfoot><tr><th><td>'); 
		$text = mysqli_real_escape_string($this->mysqli, $text);

		return $text; 
	}

	public function __destruct() {
		$this->mysqli->close;
	}
}

?>