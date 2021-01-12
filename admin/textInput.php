<?php

$sublinkId = $_GET['sublinkId']; 

if ($sublinkId != null) {
	require ('socAllAdminClass.php');
	
	$admin = new SocAllAdmin(); 
	$body = $admin->getBody($sublinkId); 
} else {
	$body = '<p>Add new text here</p>'; 
}

echo 
'<html>
<head> 
<link rel="stylesheet" href="../socAllPage.css" type="text/css">
</head>
<body id="editorBody">'; 
echo $body; 
echo 
'</body>
</html>'; 

?>