<?php
/**
 * Plugin Name: MOJO Marketplace
 * Description: This plugin adds shortcodes, widgets, and themes to your WordPress site.
 * Version: 1.7.1
 * Author: Bluehost
 * Author URI: https://bluehost.com
 * Requires at least: 4.7
 * Requires PHP: 5.3
 * Text Domain: mojo-marketplace-wp-plugin
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package MojoMarketplace
 */

// Do not access file directly!
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'MM_VERSION', '1.7.1' );
define( 'MM_FILE', __FILE__ );
define( 'MM_BASE_DIR', plugin_dir_path( __FILE__ ) );
define( 'MM_BASE_URL', plugin_dir_url( __FILE__ ) );
if ( ! defined( 'NFD_HIIVE_URL' ) ) {
	define( 'NFD_HIIVE_URL', 'https://hiive.cloud/api' );
}

global $pagenow;
if ( 'plugins.php' === $pagenow ) {

	require dirname( __FILE__ ) . '/inc/plugin-php-compat-check.php';

	$plugin_check = new Mojo_Plugin_PHP_Compat_Check( __FILE__ );

	$plugin_check->min_php_version = '5.3';
	$plugin_check->min_wp_version  = '4.7';

	$plugin_check->check_plugin_requirements();
}

// Check NFD plugins
require dirname( __FILE__ ) . '/inc/plugin-nfd-compat-check.php';
$nfd_plugins_check = new NFD_Plugin_Compat_Check( __FILE__ );
// Save val to abort loading if incompatabilities are found
$pass_nfd_check = $nfd_plugins_check->check_plugin_requirements();

// Check PHP version before initializing to prevent errors if plugin is incompatible.
if ( $pass_nfd_check && version_compare( PHP_VERSION, '5.3', '>=' ) ) {
	require dirname( __FILE__ ) . '/bootstrap.php';
}
