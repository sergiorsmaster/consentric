<?php
/**
 * SCC Shortcodes
 *
 * [scc_preferences]
 *   Renders a link that opens the cookie preferences modal.
 *   Attributes:
 *     label  — link text (default: "Cookie Settings")
 *     class  — extra CSS classes on the <a> tag
 *
 * [scc_cookie_list]
 *   Renders a table of scanned cookies grouped by category.
 *   Implemented in FEAT-18.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SCC_Shortcodes {

	public static function init() {
		add_shortcode( 'scc_preferences',  array( __CLASS__, 'render_preferences' ) );
		add_shortcode( 'scc_cookie_list',  array( __CLASS__, 'render_cookie_list' ) );
	}

	/**
	 * [scc_preferences label="Cookie Settings" class=""]
	 */
	public static function render_preferences( $atts ) {
		$atts = shortcode_atts(
			array(
				'label' => __( 'Cookie Settings', 'simple-cookie-consent' ),
				'class' => '',
			),
			$atts,
			'scc_preferences'
		);

		$classes = trim( 'scc-preferences-link ' . sanitize_html_class( $atts['class'] ) );

		return sprintf(
			'<a href="#" class="%s" onclick="SimpleCookieConsent.openPreferences();return false;">%s</a>',
			esc_attr( $classes ),
			esc_html( $atts['label'] )
		);
	}

	/**
	 * [scc_cookie_list category=""]
	 * Stub — implemented in FEAT-18.
	 */
	public static function render_cookie_list( $atts ) {
		return '<!-- [scc_cookie_list] coming in FEAT-18 -->';
	}
}
