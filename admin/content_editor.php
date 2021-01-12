<?php 

$query = "SELECT sublinkname FROM sublinks WHERE sublinkid=$sublinkid"; 
$result = mysql_query($query); 

if (!$result) {
	$content = 'There was a problem getting the data: error number: '.mysql_errno().' ('.mysql_error().')'; 
} else {
	$sublinkname = mysql_result($result, 0); 
//	$sublinkcontent = mysql_result($result, 0, 'content'); 
}

$content .= 
	'<form name="editor" action="links.php" onsubmit="submitText()" method="post" >
		<input type="hidden" name="action" value="update"/>
		<input type="hidden" name="linkid" value="'.$linkid.'"/>
		<input type="hidden" name="sublinkid" value="'.$sublinkid.'"/>'; 

/*
		if ($linkid == 'new') {
			$content .= '<h3>page title: <input type="text" value="'.$name.'" name="name"/></h3>'; 
		} elseif ($sublinkid) {
*/			$content .= 
				'<h3>sublink title:<br />
				<input type="text" value="'.$sublinkname.'" name="name" size="80"/></h3>'; 
//		}

$content .= 
	'<div id="contentEditor">
		<div id="contentHead">
			<h3>Content Editor</h3>

			<input type="hidden" name="sublinkid" value="'.$sublinkid.'"/>
			
			<p id="controls_1">
			<input type="button" onclick="bold()" value="bold" /> 
			<input type="button" onclick="italic()" value="italic" />
			<input type="button" onclick="underline()" value="underline" /> | 
			<input type="button" onclick="removeFormat()" value="undo styles" /></p>
		
			<p id="controls_2">paragraph style: <select type="select-one" onchange="formatBlock(value)" value="p"></p>'; 

$style_array = array(
	'p'=>'body', 
	'h1'=>'heading 1', 
	'h2'=>'heading 2', 
	'h3'=>'heading 3', 
	'h4'=>'heading 4'
); 

foreach($style_array as $code=>$name) {
	$content .= '<option style="font-family:'.$name.'" value="'.$code.'">'.$name.'</option>'; 
}; 

$content .= 
			'</select> | 
			<input type="button" onclick="justifyLeft()" value="align left" /> 
			<input type="button" onclick="justifyRight()" value="align right" /> 
			<input type="button" onclick="justifyCenter()" value="align centre" />
			</p>
			
			<p id="controls_3">
			<input type="button" onclick="indent()" value="add indent" />
			<input type="button" onclick="outdent()" value="remove indent" /> | 
			<input type="button" onclick="oList()" value="numbered list" /> 
			<input type="button" onclick="uList()" value="bullet list" />
			</p>
			
			<p id="controls_4">
			<input type="button" onclick="externalLink()" value="add external link" />
			<input type="button" onclick="localLink()" value="add local link" />
			<input type="button" onclick="unLink()" value="remove link" />
			</p>
		</div>

		<iframe id="inputPanel" name="iView" src="textInput.php?sublink='.$sublinkid.'" type="text/html"></iframe>

		<textarea name="editedContent" id="hiddenField" cols="0" rows="0" style="visibility:hidden;display:none;"></textarea>

		<div id="viewMode"></div>	
		<p><input id="submit" class="right" type="submit" value="save changes"/></p><br />
	</div>
</form>

<!--
<div id="uploadManager">
	<h2>upload manager</h2>
	
	<h3>images</h3>
	
	<iframe id="imageManager" name="imageView" src="uploadManager.php?manage=images" type="text/html"></iframe>
	
	<div id="selectedItem"></div>
	<div id="imageControls"></div>
	
	<h3>documents</h3>
	
	<iframe id="docManager" name="docView" src="uploadManager.php?manage=docs" type="text/html"></iframe>
	
	<div id="documentControl"></div>
	
	<p><a href="#" onclick="openWindow(\'uploadContent.php\')">upload new item</a></p>
</div> 
-->';

?>