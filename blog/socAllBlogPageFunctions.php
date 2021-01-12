<?php

function getAllTags() {
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

	return $allTagsArray; 
}

function getPostContents($result, $allTagsArray, $i) {
	$selfArray = explode('/', $_SERVER['PHP_SELF']); 
	$self = array_pop($selfArray); 
//	echo $self; 

	$post_id = mysql_result($result, $i, 'post_id'); 
	$title = mysql_result($result, $i, 'title'); 
	$author_id = mysql_result($result, $i, 'author_id'); 
	$timestamp = mysql_result($result, $i, 'timestamp'); 
		$date = date('l, j F Y', strtotime($timestamp)); 
		$time = date('H:i', strtotime($timestamp)); 
	$postContent = mysql_result($result, $i, 'content'); 
	$tags = mysql_result($result, $i, 'tags'); 
		$tags_idArray = explode(',', $tags); 

	$postContents .= 
		'<div class="post">
			<h2>'.$title.'</h2>
			<p>Posted by '.$author_id.' on '.$date.' at '.$time.'</p>
			<p>'.$postContent.'</p>'; 

	if (count($tags_idArray) > 2) {
		$tagIds = array(); 
		$tagNames = array(); 

		$postContents .= 
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
			$postContents .= '<a href="index.php?tag_id='.$tagIds[$j].'">'.$tagNames[$j].'</a>, '; 
		}

		$postContents .= 
			'<a href="index.php?tag_id='.$lastTagId.'">'.$lastTag.'</a></p>'; 
	}

	if ($self == 'index.php') {
		$query = "SELECT comment_id FROM blog_comments WHERE post_id=$post_id"; 
		$result_comments = mysql_query($query); 

		if (!$result_comments) {
			$content = '<p>There was a database problem. '.mysql_errno().': '.mysql_error().'</p>'; 
		} else {
			$num_comments = mysql_num_rows($result_comments); 
		}

		$postContents .= 
			'<p><a href="comments.php?post_id='.$post_id.'">Comments ('.$num_comments.')</a></p>'; 
	}

	$postContents .= 
		'</div>'; 

	return $postContents; 
}

?>