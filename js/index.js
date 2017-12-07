( function( config ) {
	'use strict';
	
	var linkElements = document.getElementsByClassName( '__eth-link' );
	loadLinks( linkElements );
	
	function loadLinks( elements ) {
		if( elements != null ) forEachElement( elements, function( element ) {
			element.addEventListener( 'click', function( event ) {
				event.preventDefault() ;
				
				linkElements = document
						.getElementsByClassName( '__eth-selected-link' );
				forEachElement( linkElements, function( element ) {
					element.classList.remove( '__eth-selected-link' );
				} );
				
				element.classList.add( '__eth-selected-link' );
				
				history.pushState( '', '', element.getAttribute( 'href' ) );
				loadContent() ;
			} );
		} );
	}
	
	function loadContent() {
		scrollToTop() ;
		
		var request = new XMLHttpRequest() ;
		request.open( 'GET', getRealUrl() , true );
		
		var contentWrapper = document.getElementById( '__eth-content' );
		contentWrapper.style.opacity = 0;

		request.onload = function() {
			if ( this.status >= 200 && this.status < 400 ) {
				var response = this.response;
				var fn = function()  {
					contentWrapper.removeEventListener( 'transitionend', fn );
					
					contentWrapper.innerHTML = response;
					loadContentLinks() ;
					loadContentScripts() ;

					contentWrapper.style.opacity = 1;
				}
				contentWrapper.addEventListener( 'transitionend', fn );
			} else
				console.log( 'Ethenis->loadContent()  Error:' + this.status );
		};
		request.onerror = function()  {
			console.log( 'Ethenis->loadContent()  FatalError' );
		};

		request.send() ;
	}
	
	function loadContentScripts() {
		var scripts = document.getElementById( '__eth-content' )
				.getElementsByTagName( 'script' );

		forEachElement ( scripts, function( s ) {
			var script = document.createElement( 'script' );

			if (s.src)
				script.src = s.src;
			else
				script.textContent = s.innerText;

			document.head.appendChild( script )
				.parentNode.removeChild( script )
		} );
	}
	
	function loadContentLinks() {
		var linkElements =
				document.querySelectorAll( '#__eth-content .__eth-link' );

		loadLinks( linkElements );
	}
	
	function getRealUrl() {
		var path = window.location.pathname.substring( 1 );
		var realUrl = '';

		for( var dir in config.content ) {
			var dirRegex = new RegExp( dir.substring( 1, dir.length-1 ) );
			if( path == dir ||
					( /\/.*\//.test( dir ) && dirRegex.test( path ) ) )
				realUrl = '/content/' + config.content[dir][0];
		}

		return realUrl;
	}
	
	function scrollToTop() {
		var scrollDuration = config.scrollAnimationDuration; // ms
		var scrollStep = -window.scrollY / ( scrollDuration / 15 ),
			scrollInterval =
				setInterval( function() {
					if ( window.scrollY != 0  )
						window.scrollBy(  0, scrollStep  );
					else clearInterval( scrollInterval );
				},15 );
	}
	
	function forEachElement( elements, fn ) {
		for( var i = 0; i < elements.length; i++ ) {
			fn( elements[i] );
		}
	}

} )( __ETHENIS_CONFIG );
