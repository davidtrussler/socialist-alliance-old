<?php

/*
 * local
 */
$link = mysql_connect('localhost', 'root', '') or die ('Could not connect to the database server');
mysql_select_db('socialistalliance', $link) or die ('Could not find the requested database');

/*
 * remote
$link = mysql_connect('localhost', 'futuragr', '76G.n-mnp') or die ('Could not connect to the database server');
mysql_select_db('futuragr_socialistalliance', $link) or die ('Could not find the requested database');
 */

?>