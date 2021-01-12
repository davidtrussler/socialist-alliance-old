<?php

session_start(); 

require ('socAllBlogAdminPage.inc');
require ('../../database_connect.php'); 

$post = new SocAllBlogAdminPage($content);
$action = $_POST['action']; 

if ($action) {
	switch ($action) {
		case 'insert': 
			$author_id = $_SESSION['author']; 
			$title = $_POST['title']; 
			$postContent = $_POST['content']; 
			$tags = $_POST['tags']; 
			$newTags = $_POST['newTags']; 
				$newTagsArray = explode(',', $newTags); 

			$tag_idArray = array(); 

			// ADD NEW TAGS TO DATABASE AND REMEMBER ID
			foreach ($newTagsArray as $tag) {
				if ($tag != '') {
					$query = "SELECT tag_id FROM blog_tags WHERE name='$tag'"; 
					$result = mysql_query($query); 
	
					if (!$result) {
						$content = '<p>There was a database problem. Error: '.mysql_errno().', '.mysql_error().'</p>'; 
					} else {
						if (mysql_num_rows($result) == 0) {
							$tag = trim($tag); 
							$tag = strtolower($tag); 
	
							$query = "INSERT INTO blog_tags VALUES (NULL, '$tag')"; 
							$result_tag = mysql_query($query); 
	
							if (!$result_tag) {
								$content = '<p>There was a database problem. Error: '.mysql_errno().', '.mysql_error().'</p>'; 
							} else {
								array_push($tag_idArray, mysql_insert_id()); 
							}
						}
					}
				}
			}

			// ADD AREADY EXISTING TAGS TO LIST
			if ($tags) {
				foreach ($tags as $tag_id) {
					array_push($tag_idArray, $tag_id); 
				}
			}

			$tag_ids = implode(',', $tag_idArray); 
			$tag_ids = ','.$tag_ids.',';

//			echo $tag_ids; 

			$query = "INSERT INTO blog_posts VALUES (NULL, NULL, $author_id, '$tag_ids', '$title', '$postContent')"; 
			$result = mysql_query($query); 

			if (!$result) {
				$content = '<p>There was a database problem. Error: '.mysql_errno().', '.mysql_error().'</p>'; 
			} else {
				$content = '<p>That post has been added.</p>'; 
			}
		break; 
	}
}

$query = "SELECT * FROM blog_tags ORDER BY name"; 
$result = mysql_query($query); 

if (!$result) {
	$content = '<p>There was a database problem. Error: '.mysql_errno().', '.mysql_error().'</p>'; 
} else {
	$tagArray = array(); 

	$num_tags = mysql_num_rows($result); 

	for ($i = 0; $i < $num_tags; $i++) {
		$tag_id = mysql_result($result, $i, 'tag_id'); 
		$tagArray[$tag_id] = mysql_result($result, $i, 'name'); 
	}
}

$content .= 
	'<h2>Make new post</h2>

	<form action="post.php" method="post">
		<p>Title: <input type="text" name="title" value=""/></p>
		<p>Content:<br/>
		<textarea name="content"></textarea></p>'; 

if (count($tagArray) > 0) {
	$content .= 
		'<p>Tags: '; 

	foreach($tagArray as $tag_id => $tag) {
		$content .= '<label><input type="checkbox" name="tags[]" value="'.$tag_id.'"/>&nbsp;'.$tag.'</label>'; 
	}

	$content .= 
		'</p>'; 
}

$content .= 
		'<p>New tags (comma-separated list):<br />
		<textarea name="newTags"></textarea></p>
		<input type="hidden" name="action" value="insert"/>
		<input type="submit" name="" value="Save new post"/>
	</form>'; 

$post->writePage($content);

require ('../../database_close.php'); 

?>