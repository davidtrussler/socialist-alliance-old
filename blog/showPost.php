<?php

require ('socAllBlogPage.inc');
require ('../database_connect.php'); 

$tag_id = $_GET['tag_id']; 

//	echo 'tag = '.$tag_id; 

$showPost = new SocAllBlogPage();

$query = "SELECT * FROM blog_posts WHERE tags LIKE '%,$tag_id,%' ORDER BY timestamp DESC"; 
$result = mysql_query($query); 

if (!$result) {
	$content = '<p>There was a database problem. '.mysql_errno().': '.mysql_error().'</p>'; 
} else {
	$query = "SELECT * FROM blog_tags ORDER BY name"; 
	$result_tags = mysql_query($query); 

	if (!$result_tags) {
		$content = '<p>There was a database problem. '.mysql_errno().': '.mysql_error().'</p>'; 
	} else {
		$allTagsArray = array(); 
		$num_tags = mysql_num_rows($result_tags); 

		for ($i = 0; $i < $num_tags; $i++) {
			$allTagsArray[mysql_result($result_tags, $i, 'name')] = mysql_result($result_tags, $i, 'tag_id'); 
		}
	}

	$num_posts = mysql_num_rows($result); 

	for ($i = 0; $i < $num_posts; $i++) {
		$title = mysql_result($result, $i, 'title'); 
		$author_id = mysql_result($result, $i, 'author_id'); 
		$timestamp = mysql_result($result, $i, 'timestamp'); 
		$postContent = mysql_result($result, $i, 'content'); 
		$tags = mysql_result($result, $i, 'tags'); 

		$tags_idArray = explode(',', $tags); 

		$content .= 
			'<h2>'.$title.'</h2>
			<p>Posted by '.$author_id.' on '.$timestamp.'</p>
			<p>'.$postContent.'</p>'; 

		if ($tags) {
			$tagIds = array(); 
			$tagNames = array(); 

			$content .= 
				'<p>Tags: '; 

			foreach ($allTagsArray as $tag => $tag_id) {
				if (in_array($tag_id, $tags_idArray)) {
					array_push($tagIds, $tag_id); 
					array_push($tagNames, $tag); 
				}
			}

			$lastTagId = array_pop($tagIds); 
			$lastTag = array_pop($tagNames); 

			for ($j = 0; $j < count($tagIds); $j++) {
				$content .= '<a href="'.$tagIds[$j].'">'.$tagNames[$j].'</a>, '; 
			}
	
			$content .= '<a href="'.$lastTagId.'">'.$lastTag.'</a>'; 
	
			$content .= 
				'</p>'; 
		}
	}
}

$showPost->writePage($content, $allTagsArray);

require ('../database_close.php'); 

?>