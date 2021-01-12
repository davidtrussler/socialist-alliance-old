//	window.onload = init; 

$(document).ready(function() {
	fillMonitor(); 
	setNewWindowLinks(); 
//	formatHomeStories(); 
}); 

function fillMonitor() {
	if (typeof(window.innerHeight) == 'number') {
	//Non-IE
	windowHeight = window.innerHeight;
	} else if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
	//IE 6+ in 'standards compliant mode'
	windowHeight = document.documentElement.clientHeight;
	} else if (document.body && (document.body.clientWidth || document.body.clientHeight)) {
	//IE 4 compatible
	windowHeight = document.body.clientHeight;
	}

	var pageWrap = document.getElementById('wrap');
	var wrapHeight = pageWrap.offsetHeight; 

	if (wrapHeight < windowHeight) {
		pageWrap.style.height = windowHeight + 'px'; 
	}
}

function setNewWindowLinks() {
	var links = document.getElementsByTagName('a'); 
	var numLinks = links.length; 

	for (var i = 0; i < numLinks; i++) {
		if (links[i].className == 'newWindow') {
			links[i].onclick = function () {
				window.open(this.href); 
				return false; 
			}
		}
	}
}

/*
function formatHomeStories() {
	$('.Home .story').each(function() {
		// hide all after headline and first para
		$(this).children().slice(2).css('opacity', 0).hide(); 
		// add 'show/hide' link
		$(this).append('<p><a class="showStory">read more ...</a></p>'); 
	})

	$('.Home .story a.showStory').bind('click', showStory, false); 
}

function showStory() {
	// show hidden paragraphs
	var linkPara = $(this).parent('p'); 
	linkPara.siblings().show(500, function() {
		// fade in content
		linkPara.siblings().animate({opacity: 1}, 500, function() {
			// change 'show/hide' link
			linkPara.html('<a class="hideStory">read less ...</a>'); 
			$('.Home .story a.hideStory').bind('click', hideStory, false); 
		})
	}); 
}

function hideStory() {
	// hide paragraphs
	var linkPara = $(this).parent('p'); 
	linkPara.siblings().slice(2).animate({opacity: 0}, 500, function() {
		// hide content
		$(this).hide(500, function() {
			// change 'show/hide' link
			linkPara.html('<a class="showStory">read more ...</a>'); 
			$('.Home .story a.showStory').bind('click', showStory, false); 
		})
	}); 
}
*/