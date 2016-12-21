window.ZPDFViewer = window.ZPDFViewer || {};

( function( window, document, $, app, undefined ) {
	'use strict';

	var $body;

	app.browserClass = function() {
		if ( 'undefined' === typeof window.navigator.userAgent ) {
			return $body.addClass( 'navigator-unavailable' );
		}

		$body.attr( 'data-userAgent', window.navigator.userAgent );

		var agent = window.detect.parse( window.navigator.userAgent );

		// Get browser
		var _class = agent.browser.name.toLowerCase().split( ' ' );
		var classes = _class[0];

		// Get browser-version
		classes += ' ' + agent.browser.name.toLowerCase().replace(' ', '-');

		// Get OS
		classes += ' ' + agent.device.type.toLowerCase() + ' os-' + agent.os.name.toLowerCase();

		// Add classes
		$body.addClass( classes );
	};

	app.init = function() {
		$body = $( document.body );

		app.browserClass();

		var frame = $('<iframe id="pdfv-frame" class="noscrolling pdfv-frame" width="100%" height="100%" scrolling="no" frameborder="0" name="pdfv"></iframe>');
		frame.attr( 'src', pdfv.default );
		frame.appendTo( '#pdf_div' );

	};

	$( app.init );

} )( window, document, jQuery, window.ZPDFViewer );
