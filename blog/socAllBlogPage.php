<?php

class SocAllBlogPage {
	private $content; 
	
	function __construct($content) {
		$this->content = $content; 
	}

	public function writePage() {
	
		echo 
			'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">'; 
		$this->writeHead(); 
		$this->writeBody(); 
		echo '</html>'; 
	}

	private function writeHead() {

?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Socialist Alliance | Blog</title>
	<link rel="stylesheet" type="text/css" href="../socAllPage.css"/>
	<link rel="stylesheet" type="text/css" href="socAllBlogPage.css"/>
	<script type="text/javascript" src="../socAllPage.js"></script>
</head>

<?php

	}

	private function writeBody() {

?>

<body>
	<div id="wrap">
		<div id="banner">
			<img src="../graphics/banner.gif"/>
		</div>
		
		<div id="content">
			<h1><a href="index.php">Socialist Alliance Blog</a></h1>
	
			<div id="col_left">
				<div class="panel_left">
					<p>

<?php echo $this->content; ?>

					</p>
		
					<img class="panel_bottom" src="../graphics/content_BG_bottom.gif"/>
				</div>
			</div>
		
			<div id="col_right">
				<div class="panel_right">
					<h3>[TAGS]</h3>
					<h3>[SEARCH]</h3>
					<h3>[ARCHIVE]</h3>
					<h3>[LINKS]</h3>
		
					<img class="panel_bottom" src="../graphics/panel_BG_bottom.gif"/>
				</div>
			</div>
		</div>

		<div id="footer">
			<p>Alliance for Socialism, Internationalism, Republicanism, and the Environment and opposed to racism, fascism and specific oppressions</p>
			<img class="panel_bottom" src="../graphics/footer_BG_bottom.gif"/>
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