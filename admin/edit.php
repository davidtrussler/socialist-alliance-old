<?php

require ('socAllAdminPage.php');
require ('socAllAdminClass.php');

$admin = new SocAllAdmin(); 
$action = $_POST['action']; 
$linkId = $_POST['linkId']; 

if ($action == 'edit') {		// EXISTING PAGE
	$page = 'exist'; 
	$sublinkId = $_POST['sublinkId']; 
	$sublinkName = $admin->getSublinkName(null, $sublinkId); 
} elseif ($action == 'editDefault') {	// DEFAULT PAGE
	$page = 'default'; 
	$sublinkId = $admin->getSublinkId($linkId); 
} elseif ($action == 'new') {		// NEW PAGE
	$page = 'new'; 
	$sublinkId = null; 
	$sublinkName = 'Add sublink name here'; 
}

$style_array = array(
	'p'=>'body', 
	'h1'=>'heading 1', 
	'h2'=>'heading 2', 
	'h3'=>'heading 3', 
	'h4'=>'heading 4'
); 

$content .= <<<HTML
	<form id="contentEditor" action="managePage.php" method="post">
		<fieldset id="contentHead">
HTML;

if ($page != 'default') {
	$content .= <<<HTML
			<p>Sublink Name:<br />
			<input type="text" name="sublinkName" value="$sublinkName" size=80></input></p>
HTML;
}

$content .= <<<HTML
			<input type="hidden" name="action" value="save"/>
			<input type="hidden" name="linkId" value="$linkId"/>
			<input type="hidden" name="sublinkId" value="$sublinkId"/>

			<ul id="controls_1">
				<li><input type="button" id="controlBold" value="bold" /></li>
				<li><input type="button" id="controlItalic" value="italic" /></li>
				<li><input type="button" id="controlUnderline" value="underline" /></li>
				<li><input type="button" id="controlRemove" value="undo styles" /></li>
			</ul>
	
			<ul id="controls_2">
				<li>paragraph style: <select type="select-one" id="controlFormatBlock" value="p">
HTML;

foreach($style_array as $code=>$name) {
	$content .= <<<HTML
					<option style="font-family:$name" value="$code">$name</option>
HTML;
}; 

$content .= <<<HTML
				</select></li>

				<li><input type="button" id="controlJustifyLeft" value="align left" /></li> 
				<li><input type="button" id="controlJustifyRight" value="align right" /></li> 
				<li><input type="button" id="controlJustifyCenter" value="align centre" /></li>
			</ul>

			<ul id="controls_3">
				<li><input type="button" id="controlIndent" value="add indent" /></li>
				<li><input type="button" id="controlOutdent" value="remove indent" /></li>
				<li><input type="button" id="controlOList" value="numbered list" /></li>
				<li><input type="button" id="controlUList" value="bullet list" /></li>
			</ul>

			<ul id="controls_4">
				<input type="button" id="controlExternalLink" value="add external link" />
				<input type="button" id="controlUnLink" value="remove link" />
			</ul>

			<ul id="viewMode"></ul>
		</fieldset>

		<iframe id="inputPanel" name="iView" src="textInput.php?sublinkId=$sublinkId" type="text/html"></iframe>
		<textarea name="editedContent" id="hiddenField" cols="0" rows="0"></textarea>
		<br /><br /><input type="submit" id="submit" value="save"/>
	</form>
HTML;

$edit = new SocAllAdminPage($content);

$edit->writePage();

?>