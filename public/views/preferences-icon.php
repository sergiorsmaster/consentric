<?php
/**
 * Floating "cookie settings" icon template.
 * Only rendered when scc_show_preferences_icon is enabled.
 * Visibility is controlled by JS — hidden until consent is stored.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<button
	id="scc-preferences-icon"
	class="scc-preferences-icon"
	aria-label="<?php esc_attr_e( 'Cookie Settings', 'simple-cookie-consent' ); ?>"
	style="display:none"
	onclick="SimpleCookieConsent.openPreferences()">
	<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
		<path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 17.93V18a1 1 0 0 0-2 0v1.93A8 8 0 0 1 4.07 13H6a1 1 0 0 0 0-2H4.07A8 8 0 0 1 11 4.07V6a1 1 0 0 0 2 0V4.07A8 8 0 0 1 19.93 11H18a1 1 0 0 0 0 2h1.93A8 8 0 0 1 13 19.93zM12 8a4 4 0 1 0 4 4 4 4 0 0 0-4-4zm0 6a2 2 0 1 1 2-2 2 2 0 0 1-2 2z"/>
	</svg>
</button>
