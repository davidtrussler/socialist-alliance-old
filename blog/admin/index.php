<?php

require ('socAllBlogAdminPage.inc');

$index = new SocAllBlogAdminPage($content);

$content .= ''; 

$index->writePage($content);

?>