<?php
/**
 * Main plugin bootstrap process.
 *
 * @package MojoMarketplace
 */

use WP_Forge\WPUpdateHandler\PluginUpdater;
use NewfoldLabs\WP\ModuleLoader\Container;
use NewfoldLabs\WP\ModuleLoader\Plugin;

use function NewfoldLabs\WP\ModuleLoader\container as setContainer;

// Do not access file directly!
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Load the plugin translations.
 */
function mojo_marketplace_load_plugin_textdomain() {
	load_plugin_textdomain( 'mojo-marketplace-wp-plugin', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'mojo_marketplace_load_plugin_textdomain' );

// Composer autoloader
require dirname( __FILE__ ) . '/vendor/autoload.php';

/*
 * Initialize container
 */
$mojo_container = new Container();

// Set plugin to container
$mojo_container->set(
	'plugin',
	$mojo_container->service(
		function () {
			return new Plugin(
				array(
					'id'           => 'mojo',
					'file'         => MM_FILE,
					'brand'        => get_option( 'mm_brand', 'mojo' ),
					'install_date' => get_option( 'mm_install_date' ),
				)
			);
		}
	)
);

// Set marketplace brand from mm_brand
$marketplace_brand = strtolower( get_option( 'mm_brand', 'mojo' ) );
if ( false !== strpos( $marketplace_brand, 'bluehost' ) ) {
	// simplify bluehost brand for marketplace
	$marketplace_brand = 'bluehost';
} elseif ( false !== strpos( $marketplace_brand, 'hostgator' ) ) {
	// simplify hostgator brand for marketplace
	$marketplace_brand = 'hostgator';
} else {
	// if not set, make it mojo
	$marketplace_brand = 'mojo';
}
$mojo_container->set( 'marketplace_brand', $marketplace_brand );

setContainer( $mojo_container );

require_once MM_BASE_DIR . 'inc/base.php';
require_once MM_BASE_DIR . 'inc/menu.php';
require_once MM_BASE_DIR . 'inc/shortcode-generator.php';
require_once MM_BASE_DIR . 'inc/styles.php';
require_once MM_BASE_DIR . 'inc/jetpack.php';
require_once MM_BASE_DIR . 'inc/user-experience-tracking.php';
require_once MM_BASE_DIR . 'inc/staging.php';
require_once MM_BASE_DIR . 'inc/updates.php';
require_once MM_BASE_DIR . 'inc/coming-soon.php';
require_once MM_BASE_DIR . 'inc/tests.php';
require_once MM_BASE_DIR . 'inc/track-last-login.php';
require_once MM_BASE_DIR . 'inc/performance.php';
require_once MM_BASE_DIR . 'inc/partners.php';

mm_require( MM_BASE_DIR . 'inc/branding.php' );

// Check proper PHP and bring CLI loader online
if ( version_compare( PHP_VERSION, '5.3.29' ) >= 0 ) {
	mm_require( MM_BASE_DIR . 'inc/cli-init.php' );
}

mm_require( MM_BASE_DIR . 'inc/admin-page-notifications-blocker.php' );

// Set up the updater endpoint and map values
$mojo_update_url     = 'https://hiive.cloud/workers/release-api/plugins/bluehost/mojo-marketplace-wp-plugin?file=mojo-marketplace.php'; // Custom API GET endpoint
$mojo_plugin_updater = new PluginUpdater( MM_FILE, $mojo_update_url );
$mojo_plugin_updater->setDataMap(
	array(
		'version'       => 'version.latest',
		'download_link' => 'download',
		'last_updated'  => 'updated',
		'requires'      => 'requires.wp',
		'requires_php'  => 'requires.php',
		'tested'        => 'tested.wp',
	)
);

/**
 * Filter to add applicable BN code to paypal requests
 *
 * https://github.com/newfold-labs/wp-module-ecommerce/blob/trunk/bootstrap.php#L31-L57
 */
if ( function_exists( 'add_filter' ) ) {

	add_filter(
		'http_request_args',
		function ( $parsed_args, $url ) {

			// Bail early if the request is not to PayPal's v2 checkout API
			if ( false === stripos( wp_parse_url( $url, PHP_URL_HOST ), 'paypal.com' ) ) {
				return $parsed_args;
			}

			// Check for an existing bn_code
			$bn_code = isset( $parsed_args['headers']['PayPal-Partner-Attribution-Id'] ) ? $parsed_args['headers']['PayPal-Partner-Attribution-Id'] : null;

			// Ensure we only set when blank, or when using one of our stale codes
			if ( is_null( $bn_code ) || false !== stripos( $bn_code, 'yith' ) || false !== stripos( $bn_code, 'newfold' ) ) {
				// The correct code is case-sensitive. YITH brand is uppercase, but the code is not.
				$parsed_args['headers']['PayPal-Partner-Attribution-Id'] = 'Yith_PCP';
			}

			return $parsed_args;
		},
		10,
		2
	);

}
