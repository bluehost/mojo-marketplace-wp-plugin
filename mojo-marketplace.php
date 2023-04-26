<?php
/**
 * MOJO Marketplace Plugin
 *
 * @package           MojoMarketplace
 * @author            Newfold Digital
 * @copyright         Copyright 2023 by Newfold Digital - All rights reserved.
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       The MOJO Marketplace
 * Plugin URI:        https://mojomarketplace.com
 * Description:       This plugin adds shortcodes, widgets, and themes to your WordPress site.
 * Version:           1.7.4
 * Tested up to:      6.2
 * Requires at least: 5.8
 * Requires PHP:      5.6
 * Author:            Bluehost
 * Author URI:        https://bluehost.com
 * Text Domain:       mojo-marketplace-wp-plugin
 * Domain Path:       /languages
 * License:           GPL 2.0 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// Do not access file directly!
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'MM_VERSION', '1.7.4' );
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
$nfd_plugins_check = new NFD_Plugin_Compat_Check( MM_FILE );
// Defer to Incompatible plugin, self-deactivate
$nfd_plugins_check->incompatible_plugins = array(
	'The Bluehost Plugin'  => 'bluehost-wordpress-plugin/bluehost-wordpress-plugin.php',
	'The HostGator Plugin' => 'wp-plugin-hostgator/wp-plugin-hostgator.php',
	'The Web.com Plugin'   => 'wp-plugin-web/wp-plugin-web.php',
	'The MOJO Plugin'      => 'wp-plugin-mojo/wp-plugin-mojo.php', // new mojo
);
// Save val to abort loading if incompatabilities are found
$pass_nfd_check = $nfd_plugins_check->check_plugin_requirements();

// Check PHP version before initializing to prevent errors if plugin is incompatible.
if ( $pass_nfd_check && version_compare( PHP_VERSION, '5.3', '>=' ) ) {
	require dirname( __FILE__ ) . '/bootstrap.php';
}
