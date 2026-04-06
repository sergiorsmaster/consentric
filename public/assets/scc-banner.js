/**
 * SCC Banner — show/hide logic
 *
 * Reads the consent cookie on page load and decides whether to show the banner.
 * Wires Accept / Deny buttons to SCC_Consent_Store helpers.
 * The Preferences button is wired in FEAT-07 (preferences modal).
 */

(function () {

	'use strict';

	var SCC = window.SimpleCookieConsent;
	if ( ! SCC ) return;

	var banner  = document.getElementById( 'scc-banner' );
	if ( ! banner ) return;

	var overlay   = document.querySelector( '.scc-banner-overlay' );
	var isModal   = banner.classList.contains( 'scc-position-center-modal' );

	// -------------------------------------------------------------------------
	// Focus trap helpers (used for center-modal position only)
	// -------------------------------------------------------------------------

	var FOCUSABLE = 'button:not([disabled]), [href], input:not([disabled]), ' +
		'select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';

	function getFocusable( container ) {
		return Array.prototype.slice.call( container.querySelectorAll( FOCUSABLE ) )
			.filter( function ( el ) { return el.offsetParent !== null; } );
	}

	if ( isModal ) {
		banner.addEventListener( 'keydown', function ( e ) {
			if ( e.key !== 'Tab' ) return;
			var focusable = getFocusable( banner );
			if ( ! focusable.length ) return;

			var first = focusable[ 0 ];
			var last  = focusable[ focusable.length - 1 ];

			if ( e.shiftKey ) {
				if ( document.activeElement === first ) {
					e.preventDefault();
					last.focus();
				}
			} else {
				if ( document.activeElement === last ) {
					e.preventDefault();
					first.focus();
				}
			}
		} );
	}

	// Preview mode: force-show banner even if consent is already stored.
	// Only active for logged-in admins (gated server-side via sccSettings.preview).
	var isPreview = ( window.sccSettings && window.sccSettings.preview );

	// Show banner (and overlay if present) only if visitor hasn't chosen yet,
	// or if preview mode is active.
	if ( isPreview || ! SCC.hasInteracted() ) {
		banner.style.display = '';
		if ( overlay ) overlay.style.display = '';
		SCC.log( isPreview ? 'Banner: showing (preview mode)' : 'Banner: showing (no prior consent)' );

		// Move focus into the banner: for center-modal focus the dialog itself,
		// for bars focus the first button so keyboard users can act immediately.
		if ( isModal ) {
			banner.focus();
		} else {
			var firstBtn = banner.querySelector( 'button' );
			if ( firstBtn ) firstBtn.focus();
		}
	} else {
		SCC.log( 'Banner: hidden (consent already stored)' );
	}

	// Hide banner + overlay whenever consent is saved.
	document.addEventListener( 'scc:consentUpdated', function () {
		banner.style.display = 'none';
		if ( overlay ) overlay.style.display = 'none';
		SCC.log( 'Banner: hidden after consent update' );
	} );

	// Accept All button
	var btnAccept = document.getElementById( 'scc-accept' );
	if ( btnAccept ) {
		btnAccept.addEventListener( 'click', function () {
			SCC.log( 'Banner: Accept All clicked' );
			SCC.acceptAll();
		} );
	}

	// Deny All button
	var btnDeny = document.getElementById( 'scc-deny' );
	if ( btnDeny ) {
		btnDeny.addEventListener( 'click', function () {
			SCC.log( 'Banner: Deny All clicked' );
			SCC.denyAll();
		} );
	}

	// Preferences button — opens modal
	var btnPrefs = document.getElementById( 'scc-preferences' );
	if ( btnPrefs ) {
		btnPrefs.addEventListener( 'click', function () {
			SCC.log( 'Banner: Preferences clicked' );
			document.dispatchEvent( new CustomEvent( 'scc:openPreferences' ) );
		} );
	}

	// Floating preferences icon — show after consent is stored
	var prefIcon = document.getElementById( 'scc-preferences-icon' );
	if ( prefIcon ) {
		if ( SCC.hasInteracted() ) {
			prefIcon.style.display = '';
			SCC.log( 'Preferences icon: visible (consent already stored)' );
		}
		document.addEventListener( 'scc:consentUpdated', function () {
			prefIcon.style.display = '';
			SCC.log( 'Preferences icon: visible after consent update' );
		} );
	}

} )();
