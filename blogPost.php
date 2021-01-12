<?php

class BlogPost {
	private $ser;	// server; 
	private $use;	// userName
	private $pas;	// passWord
	private $dat;	// database
	private $mysqli;

	function __construct($dat) {
		$this->ser = 'localhost';
		$this->use = 'root';
		$this->pas = 'skyblue';
		$this->dat = $dat;

		@ $this->mysqli = new mysqli($this->ser, $this->use, $this->pas, $this->dat);
	}

	public function numPosts() {
		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
		} else {
			$query = "SELECT post_id FROM blog_posts"; 
			$result = $this->mysqli->query($query); 
			$this->mysqli->close;

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
			} else {
				return $result->num_rows; 
			}

			$result->result_close(); 
		}
	}

	public function numComments($post_id) {
		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
		} else {
			$query = "SELECT comment_id FROM blog_comments WHERE post_id=$post_id"; 
			$result = $this->mysqli->query($query); 
			$this->mysqli->close;

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
			} else {
				return $result->num_rows; 
			}

			$result->result_close(); 
		}
	}

	public function tagPostArray($tag_id) {
		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
		} else {
			$query = "SELECT post_id FROM blog_posts WHERE tags LIKE '%,$tag_id,%' ORDER BY timestamp DESC"; 
			$result = $this->mysqli->query($query); 
			$this->mysqli->close;

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
			} else {
				while ($row = $result->fetch_row()) {
					$tagArray[] = $row[0]; 
				}; 

				return $tagArray; 
			}

			$result->result_close(); 
		}
	}

	public function allTags() {
		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
		} else {
			$query = "SELECT * FROM blog_tags ORDER BY name"; 
			$result = $this->mysqli->query($query); 
			$this->mysqli->close;

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
			} else {
				while ($row = $result->fetch_assoc()) {
					$allTagArray[$row['tag_id']] = $row['name']; 
				}; 

				return $allTagArray; 
			}

			$result->result_close(); 
		}
	}

	public function getPostId($num) {
		$num--; 

		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
		} else {
			$query = "SELECT post_id FROM blog_posts"; 
			$result = $this->mysqli->query($query); 
			$this->mysqli->close;

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
			} else {
				$result->data_seek($num); 
				$row = $result->fetch_assoc(); 
				return $row['post_id']; 
			}

			$result->result_close(); 
		}
	}

	public function getTitle($post_id) {
		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
		} else {
			$query = "SELECT title FROM blog_posts WHERE post_id=$post_id"; 
			$result = $this->mysqli->query($query); 
			$this->mysqli->close;

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
			} else {
				$row = $result->fetch_row(); 
				return $row[0]; 
			}

			$result->result_close(); 
		}
	}

	public function getAuthor($post_id) {
		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
		} else {
			// USE JOIN TO GET NAME
			$query = "SELECT author_id FROM blog_posts WHERE post_id=$post_id"; 
			$result = $this->mysqli->query($query); 
			$this->mysqli->close;

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
			} else {
				$row = $result->fetch_row(); 
				return $row[0]; 
			}

			$result->result_close(); 
		}
	}

	public function getDate($post_id) {
		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
		} else {
			$query = "SELECT timestamp FROM blog_posts WHERE post_id=$post_id"; 
			$result = $this->mysqli->query($query); 
			$this->mysqli->close;

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
			} else {
				$row = $result->fetch_row(); 
				return $row[0]; 
			}

			$result->result_close(); 
		}
	}

	public function getContent($post_id) {
		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
		} else {
			$query = "SELECT content FROM blog_posts WHERE post_id=$post_id"; 
			$result = $this->mysqli->query($query); 
			$this->mysqli->close;

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
			} else {
				$row = $result->fetch_row(); 
				return $row[0]; 
			}

			$result->result_close(); 
		}
	}

	public function getPartContent($post_id, $substr_length) {
		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
		} else {
			$query = "SELECT SUBSTRING(content, 1, $substr_length) FROM blog_posts WHERE post_id=$post_id"; 
			$result = $this->mysqli->query($query); 
			$this->mysqli->close;

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
			} else {
				$row = $result->fetch_row(); 
				return $row[0]; 
			}

			$result->result_close(); 
		}
	}

	public function getTags($post_id) {
		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
		} else {
			$query = "SELECT tags FROM blog_posts WHERE post_id=$post_id"; 
			$result = $this->mysqli->query($query); 
			$this->mysqli->close;

			if (!$result) {
				return 'Error: no results! '.$this->mysqli->errno.': '.$this->mysqli->error; 
			} else {
				$row = $result->fetch_row(); 
				$tagArray = explode(',', $row[0]); 
				$tagIdArray = array(); 

				foreach($tagArray as $tagId) {
					if ($tagId != '') {
						array_push($tagIdArray, $tagId); 
					}
				}

				return $tagIdArray; 
			}
		}
	}
}

?>