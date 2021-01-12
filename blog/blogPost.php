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
			$mysqli->close;

			if (!$result) {
				return 'Error: no results!'; 
			} else {
				return $result->num_rows; 
			}
		}
	}

	public function getTitle($num) {
		// USE EXCEPTION HERE
		if ($this->mysqli->connect_errno) {
			return 'Error: could not connect to database!'; 
		} else {
			$query = "SELECT title FROM blog_posts"; 
			$result = $this->mysqli->query($query); 
			$mysqli->close;

			if (!$result) {
				return 'Error: no results!'; 
			} else {
				$result->data_seek($num); 
				$row = $result->fetch_assoc(); 
				return $row['title']; 
			}

			$result->result_close(); 
		}
	}
}

?>