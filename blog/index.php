<?php

require ('socAllBlogPage.php');
require ('blogPost.php');

// CONTENT
$blogPost = new BlogPost('socialistalliance');

$numPosts = $blogPost->numPosts();
$postTitle = $blogPost->getTitle($numPosts - 1);	// from 0 - (total - 1)

$index = new SocAllBlogPage($postTitle);

$index->writePage();

require ('../database_close.php'); 

?>