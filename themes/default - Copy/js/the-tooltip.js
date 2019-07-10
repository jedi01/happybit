;(function(selector) {

if('ontouchstart' in window) {
	
	try {
	
		for(var i=0, elements = document.querySelectorAll(selector + ' > :last-child'), clicked = false; i<elements.length; i++) {
			
			// iOS opacity + transition + visibility bug fix
			if(navigator.userAgent.match(/iPad|iPhone|iPod/)) elements[i].style.webkitTransitionDuration = '0s';
			
			// adding a click event listener is sufficient for iOS
			elements[i].parentNode.addEventListener('click', function(event) {
				
				// Android hover fix
				if(navigator.userAgent.match(/Android/) && !clicked) (clicked = true) && event.preventDefault();
			});
			
			// Android needs a tabindex too
			elements[i].parentNode.setAttribute('tabindex', 0);
		}
	}
	catch(error) {}
}

})('.the-tooltip');