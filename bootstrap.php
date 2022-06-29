<?php
/**
 * Main plugin bootstrap process.
 *
 * @package MojoMarketplace
 */

use Endurance_WP_Plugin_Updater\Updater;
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
					'id'   => 'mojo',
					'file' => MM_FILE,
				)
			);
		}
	)
);

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

new Updater( 'bluehost', 'mojo-marketplace-wp-plugin', plugin_basename( MM_FILE ) );
