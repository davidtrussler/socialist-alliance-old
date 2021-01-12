<?php

require ('socAllPage.php');
require ('blogPost.php');

function formatDate($timestamp) {
	$date = date('j F Y', strtotime($timestamp)); 
	return $date; 
}

$title = 'Blog'; 
$blogPost = new BlogPost('socialistalliance');

$numPosts = $blogPost->numPosts();
$allTagsArray = $blogPost->allTags(); 

if (isset($_GET['tag_id'])) {
	$tagPostArray = $blogPost->tagPostArray($_GET['tag_id']);

	$content = <<<HTML
		<div id="col_left">
			<div class="panel_left">
HTML;

foreach($tagPostArray as $post_id) {
	$postTitle = $blogPost->getTitle($post_id);
	$postAuthor = $blogPost->getAuthor($post_id); 
	$postDate = formatDate($blogPost->getDate($post_id)); 
	$postPartContent = $blogPost->getPartContent($post_id, 20); 

	$content .= <<<HTML
				<h3>$postDate</h3>
				<h2>$postTitle</h2>
				<h3>by $postAuthor</h3>
				<p>$postPartContent ... <a href="blog.php?post_id=$post_id">more</a></p>
HTML;
}

	$content .= <<<HTML
				<img class="panel_bottom" src="graphics/content_BG_bottom.gif"/>
			</div>
		</div>
HTML;
} else {
	if (isset($_GET['post_id'])) {
		$post_id = $_GET['post_id'];
	} else {
		$post_id = $blogPost->getPostId($numPosts);	// from 1 - total
	}
	
	$numComments = $blogPost->numComments($post_id); 
	$postTitle = $blogPost->getTitle($post_id);
	$postAuthor = $blogPost->getAuthor($post_id); 
	$postDate = formatDate($blogPost->getDate($post_id)); 
	$postContent = $blogPost->getContent($post_id); 
	$postTagsArray = $blogPost->getTags($post_id); 
	
	$content = <<<HTML
		<div id="col_left">
			<div class="panel_left">
				<h3>$postDate</h3>
				<h2>$postTitle</h2>
				<h3>by $postAuthor</h3>
				<p>$postContent</p>
				<h4>Topics:&nbsp;
HTML;
	
	for($i = 0; $i < count($postTagsArray) - 1; $i++) {
		$content .= <<<HTML
			$postTagsArray[$i], 
HTML;
	}
	
	$content .= $postTagsArray[count($postTagsArray) - 1]; 
	
	$content .= <<<HTML
				</h4>
	
				<h4>Comments ($numComments)</h4>
	
				<img class="panel_bottom" src="graphics/content_BG_bottom.gif"/>
			</div>
		</div>
HTML;
}

$content .= <<<HTML
	<div id="col_right">
		<div class="panel_right">
			<h2>Archive</h2>
HTML;

for ($i = $numPosts - 1; $i > 0 ; $i--) {
	$postId = $blogPost->getPostId($i);
	$postDate = formatDate($blogPost->getDate($postId)); 
	$postTitle = $blogPost->getTitle($postId);

	if (isset($_GET['post_id']) && $_GET['post_id'] == $postId) {
		$content .= <<<HTML
			<p class="live">$postDate<br />
			$postTitle</p>
HTML;
	} else {
		$content .= <<<HTML
			<p><a href="blog.php?post_id=$postId">$postDate<br />
			$postTitle</a></p>
HTML;
	}
}

$content .= <<<HTML
			<h2>Topics</h2>
HTML;

foreach($allTagsArray as $tag_id => $tag) {
	if (isset($_GET['tag_id']) && $_GET['tag_id'] == $tag_id) {
		$content .= <<<HTML
				<p class="live">$tag</p>
HTML;
	} else {
		$content .= <<<HTML
				<p><a href="blog.php?tag_id=$tag_id">$tag</a></p>
HTML;
	}
}

$content .= <<<HTML
			<h2>[SEARCH]</h2>

			<img class="panel_bottom" src="graphics/panel_BG_bottom.gif"/>
		</div>
	</div>
HTML;

$blog = new SocAllPage($title, $content);

$blog->writePage();


?>