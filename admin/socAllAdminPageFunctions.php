<?php

function format($text) {
	$text = str_replace('%22', '\"', $text); 
	$text = str_replace('%20', ' ', $text); 

// REPLACE MS WORD CHARACTERS	
	$text = str_replace(chr(133), '&#8230;', $text);	// ellipsis
	$text = str_replace(chr(145), "&#8216;", $text);	// left single quote
	$text = str_replace(chr(146), "&#8217;", $text);	// right single quote
	$text = str_replace(chr(147), '&#8220;', $text);	// left double quote
	$text = str_replace(chr(148), '&#8221;', $text);	// right double quote
	$text = str_replace(chr(149), '-', $text);		// bullet
	$text = str_replace(chr(150), '&#8211;', $text);    	// endash
	$text = str_replace(chr(151), '&#8212;', $text);	// emdash
//	$text = str_replace(chr(163), '&#163;', $text);		// pound sign
	$text = str_replace(chr(167), '&#176;', $text);		// degrees
// REPLACE MS WORD CHARACTERS	

//	$text = bin2hex($text);	

	// REPLACE WITH WHILE LOOP
	$text = str_replace('  ', ' ', $text); 

	return $text; 
}

?>