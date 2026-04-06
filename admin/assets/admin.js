/**
 * SCC Admin JS
 *
 * Handles the WordPress Media Library picker for the logo field.
 */

(function ( $ ) {
	'use strict';

	var mediaFrame;

	// "Select Image" button — opens the WP media library
	$( document ).on( 'click', '.scc-media-select', function ( e ) {
		e.preventDefault();

		var $btn    = $( this );
		var $input  = $( $btn.data( 'target' ) );
		var $remove = $btn.siblings( '.scc-media-remove' );
		var $preview = $btn.closest( '.scc-field__control' ).find( '.scc-logo-preview' );

		if ( mediaFrame ) {
			mediaFrame.open();
			return;
		}

		mediaFrame = wp.media( {
			title:    'Select Logo',
			button:   { text: 'Use this image' },
			multiple: false,
			library:  { type: 'image' },
		} );

		mediaFrame.on( 'select', function () {
			var attachment = mediaFrame.state().get( 'selection' ).first().toJSON();
			$input.val( attachment.url );
			$preview.attr( 'src', attachment.url ).show();
			$remove.show();
		} );

		mediaFrame.open();
	} );

	// "Remove" button — clears the logo field
	$( document ).on( 'click', '.scc-media-remove', function ( e ) {
		e.preventDefault();

		var $btn     = $( this );
		var $input   = $( $btn.data( 'target' ) );
		var $preview = $btn.closest( '.scc-field__control' ).find( '.scc-logo-preview' );

		$input.val( '' );
		$preview.attr( 'src', '' ).hide();
		$btn.hide();
	} );

	// Jurisdiction cards — highlight selected + show/hide CCPA field
	$( document ).on( 'change', '.scc-jurisdiction-radio', function () {
		$( '.scc-jurisdiction-card' ).removeClass( 'is-selected' );
		$( this ).closest( '.scc-jurisdiction-card' ).addClass( 'is-selected' );

		if ( $( this ).val() === 'ccpa' ) {
			$( '.scc-ccpa-field' ).show();
		} else {
			$( '.scc-ccpa-field' ).hide();
		}
	} );

} )( jQuery );
