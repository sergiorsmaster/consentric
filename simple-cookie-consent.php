<?php
/**
 * Plugin Name:       Simple Cookie Consent
 * Plugin URI:        https://github.com/sergiorsmaster/simple-wp-cookie-consent
 * Description:       A simple, free, and open-source cookie consent banner. No Pro, no subscription.
 * Version:           0.1.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Sergio Ricardo
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       simple-cookie-consent
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin constants
define( 'SCC_VERSION',     '0.1.0' );
define( 'SCC_PLUGIN_FILE', __FILE__ );
define( 'SCC_PLUGIN_DIR',  plugin_dir_path( __FILE__ ) );
define( 'SCC_PLUGIN_URL',  plugin_dir_url( __FILE__ ) );

// Autoload core classes
require_once SCC_PLUGIN_DIR . 'includes/class-scc-activator.php';
require_once SCC_PLUGIN_DIR . 'includes/class-scc-deactivator.php';
require_once SCC_PLUGIN_DIR . 'includes/class-scc-consent-store.php';

// Activation / deactivation hooks
register_activation_hook( __FILE__,   array( 'SCC_Activator',   'activate' ) );
register_deactivation_hook( __FILE__, array( 'SCC_Deactivator', 'deactivate' ) );

// Enqueue frontend consent script
add_action( 'wp_enqueue_scripts', 'scc_enqueue_public_scripts' );

function scc_enqueue_public_scripts() {
	if ( ! get_option( 'scc_enabled', '1' ) ) {
		return;
	}

	wp_enqueue_script(
		'scc-consent',
		SCC_PLUGIN_URL . 'public/assets/scc-consent.js',
		array(),
		SCC_VERSION,
		false // load in <head> — consent must be available as early as possible
	);
}
