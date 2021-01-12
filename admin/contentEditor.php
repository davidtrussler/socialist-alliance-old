<?php 

$content .= 
	'<div id="contentEditor">
		<div id="contentHead">

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
		<input type="button" onclick="unLink()" value="remove link" />
		</p>
	</div>
	
	<iframe id="inputPanel" name="iView" src="textInput.php?source='.$sublinkid.'" type="text/html"></iframe>
	
	<textarea name="editedContent" id="hiddenField" cols="0" rows="0" style="visibility:hidden;display:none;"></textarea>
	
	<div id="viewMode"></div>'; 

?>