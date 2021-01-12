<?php

class SocAllPage {
	private $ser;	// server; 
	private $use;	// userName
	private $pas;	// passWord
	private $dat;	// database
	private $mysqli;
	private $title; 
	private $content; 

	function __construct($title, $content) {
		/*
		 * remote
		 */
		$this->ser = 'localhost';
		$this->use = 'futuragr';
		$this->pas = '76G.n-mnp';
		$this->dat = 'futuragr_socialistalliance';

		/*
		 * local
		$this->ser = 'localhost';
		$this->use = 'root';
		$this->pas = '';
		$this->dat = 'socialistalliance';
		 */
		
		$this->title = $title; 
		$this->content = $content; 

		@ $this->mysqli = new mysqli($this->ser, $this->use, $this->pas, $this->dat);
	}
	
	public function writePage() {
		date_default_timezone_set('Europe/London');
		
		echo 
			'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
			<!-- new server -->'; 
		$this->writeHead(); 
		$this->writeBody(); 
		echo '</html>'; 
	}
	
	private function writeHead() {

?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Socialist Alliance | <?php echo $this->title; ?></title>
	<link rel="stylesheet" type="text/css" href="socAllPage.css"/>
	<script type="text/javascript" src="jquery-1.4.1.min.js"></script>
	<script type="text/javascript" src="socAllPage.js"></script>
</head>

<?php

	}

	private function writeBody() {
		$selfArray = explode('/', $_SERVER['PHP_SELF']); 
		$self = array_pop($selfArray); 

?>

<body class="<?php echo $this->title; ?>">
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
		
		// MENU ->
		$query = "SELECT * FROM links ORDER BY linkorder"; 
		$result = $this->mysqli->query($query); 

		if (!$result) {
			return 'Error: no results!'; 
		} else {
			$num_links = $result->num_rows; 
			$link_url_array = array(); 
			$link_array = array(); 
		
			for ($i = 0; $i < $num_links; $i++) {
				$result->data_seek($i); 
				$row = $result->fetch_assoc(); 
				$linkid = $row['linkid']; 
				$linkname = $row['linkname']; 
				array_push($link_url_array, $linkid); 
				array_push($link_array, $linkname); 
			}
		
			for ($i = 0; $i < count($link_array); $i++) {
				if ($link_url_array[$i] == $query_link && $self != 'contact.php' && $self != 'blog.php' && $self != 'events.php' && $self != 'about.php') {
					echo '<li class="live">'.$link_array[$i].'</li>'; 
				} else {
					echo '<li><a href="page.php?linkid='.$link_url_array[$i].'">'.$link_array[$i].'</a></li>'; 
				}
			}

			// STATIC PAGES
			// EVENTS ->
			if ($self == 'events.php') {
				echo '<li class="live">Events</li>'; 
			} else {
				echo '<li><a href="events.php">Events</a></li>'; 
			}
			// <- EVENTS

			// ABOUT ->
			if ($self == 'about.php') {
				echo '<li class="live">About Us</li>'; 
			} else {
				echo '<li><a href="about.php">About Us</a></li>'; 
			}
			// <- ABOUT

			// CONTACT ->
			if ($self == 'contact.php') {
				echo '<li class="live">Contact Us</li>'; 
			} else {
				echo '<li><a href="contact.php">Contact Us</a></li>'; 
			}
			// <- CONTACT

/*		
			// GREETINGS CARDS ->
			if ($self == 'cards.php') {
				echo '<li class="live">Greetings Cards</li>'; 
			} else {
				echo '<li><a href="cards.php">Greetings Cards</a></li>'; 
			}
			// <- GREETINGS CARDS
*/

/*
			// BLOG ->
			if ($self == 'blog.php') {
				echo '<li class="live">Blog</li>'; 
			} else {
				echo '<li><a href="blog.php">Blog</a></li>'; 
			}
			// <- BLOG
*/
		}

		$result->close();
		$this->mysqli->close();
		// <- MENU

?>

				</ul>
			</p>
		</div>

		<div id="content">

		<?php echo $this->content; ?>

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