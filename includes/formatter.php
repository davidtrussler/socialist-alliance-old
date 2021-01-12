<?php

class Formatter {
	// private $content; 

	function __construct() {
		// $this->content = $content; 
	}

	public function truncateStory($storyContent, $storyId) {
		$story = substr($storyContent, 0, 200); 

		if (substr($story, -4) == '</p>') {
			$story = substr($storyContent, 0, -4); 
		}

		$story .= <<<HTML
			&nbsp;&#8230;&nbsp;<a href="index.php?storyId=$storyId">read more</a>
HTML;

		return $story; 
	}
}

?>