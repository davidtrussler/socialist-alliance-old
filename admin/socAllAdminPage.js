$(document).ready(function() {
//	alert('ready!'); 
	bindDelete(); 
	bindEvents();		// CONTENT EDITOR
	writeViewMode();	// CONTENT EDITOR
})

function bindDelete() {
	$('.delete').bind('click', confirmDelete); 
}

function confirmDelete() {
	var conf = confirm('Are you sure you want to delete this page?'); 

	if (conf == true) {
		return true; 
	} else {
		return false; 
	}
};

// CONTENT EDITOR -->
window.onload = editorInit;

var viewMode = 1; // WYSIWYG

function editorInit() {
	if (window.frames['iView']) {
		window.frames['iView'].document.designMode = 'On';
	}

//	var editedContent = window.frames['iView'].document.getElementById('editorBody');
//	$(window.frames['iView']).children('#editorBody').bind('load', formatContent);	// css('color', 'green');
}

function writeViewMode() {
	if (viewMode == 1) {
		$('#viewMode').replaceWith('<ul id="viewMode"><li><input type="button" onclick="changeViewMode()" value="view HTML"/></li></ul>');
	} else {
		$('#viewMode').replaceWith('<ul id="viewMode"><li><input type="button" onclick="changeViewMode()" value="view WYSIWYG"/></li></ul>');
	}
}

function changeViewMode() {
	if (viewMode == 1) {
		var iHTML = window.frames['iView'].document.getElementById('editorBody').innerHTML;
		if (document.all) {					// check for feckin I feckin E
			window.frames['iView'].document.getElementById('editorBody').innerText = iHTML;
		} else {
			window.frames['iView'].document.getElementById('editorBody').textContent = iHTML;
		}; 

		document.getElementById('controls_1').style.display = 'none'; 
		document.getElementById('controls_2').style.display = 'none'; 
		document.getElementById('controls_3').style.display = 'none'; 
		document.getElementById('controls_4').style.display = 'none'; 
		document.getElementById('submit').style.display = 'none'; 

		window.frames['iView'].focus();
		viewMode = 2; // HTML
		writeViewMode(); 
	} else {
		if (document.all) {						// check for feckin I feckin E
			var iText = window.frames['iView'].document.getElementById('editorBody').innerText;
		} else {
			var iText = window.frames['iView'].document.getElementById('editorBody').textContent;
		}; 

		document.getElementById('controls_1').style.display = 'block'; 
		document.getElementById('controls_2').style.display = 'block'; 
		document.getElementById('controls_3').style.display = 'block'; 
		document.getElementById('controls_4').style.display = 'block'; 
		document.getElementById('submit').style.display = 'block'; 

		document.getElementById('viewMode').innerHTML = 
			'<input class="left" type="button" onclick="changeViewMode()" value="view HTML/WYSIWYG"/>'
		window.frames['iView'].document.getElementById('editorBody').innerHTML = iText;
		window.frames['iView'].focus();
		viewMode = 1; // WYSIWYG
		writeViewMode(); 
	}
}

function bindEvents() {
//	alert('bind!'); 

	$('#controlBold').bind('click', bold); 
	$('#controlItalic').bind('click', italic); 
	$('#controlUnderline').bind('click', underline); 
	$('#controlRemove').bind('click', removeFormat); 

	$('#controlFormatBlock').bind('change', formatBlock);
	$('#controlJustifyLeft').bind('click', justifyLeft); 
	$('#controlJustifyRight').bind('click', justifyRight); 
	$('#controlJustifyCenter').bind('click', justifyCenter); 

	$('#controlIndent').bind('click', indent);
	$('#controlOutdent').bind('click', outdent); 
	$('#controlOList').bind('click', oList); 
	$('#controlUList').bind('click', uList); 

	$('#controlExternalLink').bind('click', externalLink); 
	$('#controlUnLink').bind('click', unLink); 

	$('#contentEditor').bind('submit', submitText); 
}

/*
function formatContent() {
	alert('format!'); 
}
*/

//////

function bold() {
	window.frames['iView'].document.execCommand('bold', false, null) ;
}

function italic() {
	window.frames['iView'].document.execCommand('italic', false, null) ;
}

function underline() {
	window.frames['iView'].document.execCommand('underline', false, null) ;
}

function removeFormat() {
	window.frames['iView'].document.execCommand('removeFormat', false, null) ;
}

////

function formatBlock() {
	var value = $('#controlFormatBlock').val(); 
	window.frames['iView'].document.execCommand('formatBlock', false, '<' + value + '>') ;
}

function justifyLeft() {
	window.frames['iView'].document.execCommand('justifyLeft', false, null) ;
}

function justifyRight() {
	window.frames['iView'].document.execCommand('justifyRight', false, null) ;
}

function justifyCenter() {
	window.frames['iView'].document.execCommand('justifyCenter', false, null) ;
}

////

function indent() {
	window.frames['iView'].document.execCommand('indent', false, null) ;
}

function outdent() {
	window.frames['iView'].document.execCommand('outdent', false, null) ;
}

function oList() {
	window.frames['iView'].document.execCommand('insertOrderedList', false, null) ;
}

function uList() {
	window.frames['iView'].document.execCommand('insertUnorderedList', false, null) ;
}

////

function externalLink() {
	var url = prompt('enter url', 'http://') ;

	if (url != null) {
		url += '\" class=\"newWindow'; 

		window.frames['iView'].document.execCommand('createlink', false, url) ;
	}
}

function unLink() {
	window.frames['iView'].document.execCommand('unlink', false, null) ;
}

////

function submitText() {
	var editedContent = window.frames['iView'].document.getElementById('editorBody').innerHTML;
//	var editedContent = window.frames['iView'].documentContent;
	$('#hiddenField').text(editedContent);
}

/*
function transferContent(editedContent) {
	$('#hiddenField').html(editedContent);
	alert($('#hiddenField').html()); 
}
*/
// <-- CONTENT EDITOR