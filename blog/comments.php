<?php

require ('socAllBlogPage.inc');
require ('socAllBlogPageFunctions.php'); 
require ('../database_connect.php'); 

$comments = new SocAllBlogPage();

$post_id = $_GET['post_id']; 
$action = $_POST['action']; 

if ($action == 'insert') {
	$id = $_POST['id']; 
	$title = $_POST['title']; 
	$comment = $_POST['comment']; 

	$query = "INSERT INTO blog_comments VALUES (NULL, NULL, NULL, $id, '$title', '$comment')"; 
	$result = mysql_query($query); 
	
	if (!$result) {
		$content = '<p>There was a database problem. '.mysql_errno().': '.mysql_error().'</p>'; 
	} else {
		$content = '<p>Your comment has been added.</p>'; 
	}
}

$query = "SELECT * FROM blog_posts WHERE post_id=$post_id"; 
$result = mysql_query($query); 

if (!$result) {
	$content .= '<p>There was a database problem. '.mysql_errno().': '.mysql_error().'</p>'; 
} else {
	$allTagsArray = getAllTags(); 
	$content .= getPostContents($result, $allTagsArray, 0); 

	$content .= 
		'<h3>Comments</h3>'; 

	$query = "SELECT * FROM blog_comments WHERE post_id=$post_id ORDER BY timestamp DESC"; 
	$result = mysql_query($query); 
	
	if (!$result) {
		$content .= '<p>There was a database problem. '.mysql_errno().': '.mysql_error().'</p>'; 
	} else {
		$num_comments = mysql_num_rows($result); 

		if ($num_comments == 0) {
			$content .= '<p>There are no comments for this post.</p>'; 
		} else {
			for ($i = 0; $i < $num_comments; $i++) {
				$title = mysql_result($result, $i, 'title'); 
				$author = mysql_result($result, $i, 'author'); 
				$timestamp = mysql_result($result, $i, 'timestamp'); 
					$date = date('l, j F Y', strtotime($timestamp)); 
					$time = date('H:i', strtotime($timestamp)); 
				$comment = mysql_result($result, $i, 'content'); 

				$content .= 
					'<div class="post">
						<h4>'.$title.'</h4>
						<p>Posted by '.$author.' on '.$date.' at '.$time.'</p>
						<p>'.$comment.'</p>
					</div>'; 
			}
		}
	}

	$content .= 
		'<h3>Post a comment</h3>

		<form action="comments.php?post_id='.$post_id.'" method="post">
			<input type="hidden" name="action" value="insert"/>
			<input type="hidden" name="id" value="'.$post_id.'"/>
			<p>Title: <input type="text" name="title" value=""/></p>
			<p>Comment: <textarea name="comment"></textarea></p>
			<p><input type="submit" name="" value="Add comment"/></p>
		</form>'; 
}

$comments->writePage($content, $allTagsArray);

require ('../database_close.php'); 

?>