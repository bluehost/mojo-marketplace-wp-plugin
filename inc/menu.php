<?php

/**
 * Mojo Marketplace Plugin Main Menu
 */
function mm_main_menu() {
	$icon_hash = get_transient( 'mm_icon_hash', false );
	if ( false === $icon_hash ) {
		$file = MM_BASE_DIR . '/assets/images/svgs/' . mm_brand() . '-icon.svg';
		if ( file_exists( $file ) ) {
			$content   = file_get_contents( $file );
			$icon_hash = base64_encode( $content );
			set_transient( 'mm_icon_hash', $icon_hash, WEEK_IN_SECONDS );
		}
	}
	$brand = get_option( 'mm_brand' );
	if ( false !== $brand ) {
		$menu_position = - 10;
		$menu_name     = $brand;
	} else {
		$menu_position = 59;
		$menu_name     = __( 'Mojo', 'mojo-marketplace-wp-plugin' );
	}

	if ( 'BlueHost' == $menu_name ) {
		$menu_name = __( 'Bluehost', 'mojo-marketplace-wp-plugin' );
	}

	if ( 'Bluehost_India' == $menu_name ) {
		$menu_name = __( 'Bluehost', 'mojo-marketplace-wp-plugin' );
	}

	$menu_name = str_replace( '_', ' ', $menu_name );

	add_menu_page( $menu_name, $menu_name, 'manage_options', 'mojo-marketplace', 'mm_marketplace_page', 'data:image/svg+xml;base64, ' . $icon_hash, $menu_position );

}

add_action( 'admin_menu', 'mm_main_menu' );

/**
 * Fix Main menu label
 */
function mm_main_menu_fix_subdomain_label() {
	global $submenu;
	if ( isset( $submenu['mojo-marketplace'] ) && is_array( $submenu['mojo-marketplace'] ) ) {
		if ( 'mojo-marketplace' === $submenu['mojo-marketplace'][0][2] ) {
			if ( 'bluehost' === mm_brand() || 'bluehost-india' === mm_brand() ) {
				$submenu['mojo-marketplace'][0][0] = __( 'Home', 'mojo-marketplace-wp-plugin' ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			} else {
				unset( $submenu['mojo-marketplace'][0] );
			}
		}
		if ( 'mojo-marketplace' === $submenu['mojo-marketplace'][1][2] ) {
			unset( $submenu['mojo-marketplace'][1] );
		}
	}
}

add_action( 'admin_menu', 'mm_main_menu_fix_subdomain_label', 11 );

/**
 * Add toolbar item hook
 *
 * @param WP_Admin_Bar $admin_bar Admin bar
 */
function mm_add_tool_bar_items( $admin_bar ) {
	if ( current_user_can( 'manage_options' ) ) {
		if ( mm_is_staging() ) {
			$args = array(
				'id'    => 'mojo-staging',
				'href'  => admin_url( 'admin.php?page=mojo-staging' ),
				'title' => '<div style="background-color: #ce0000; padding: 0px 10px;color:#fff;">' . esc_html_e( 'Staging Environment', 'mojo-marketplace-wp-plugin' ) . '</div>',
				'meta'  => array(
					'title' => __( 'Staging Actions', 'mojo-marketplace-wp-plugin' ),
				),
			);
			$admin_bar->add_menu( $args );
		}
		if ( defined( 'DESKTOPSERVER' ) ) {
			$args = array(
				'id'    => 'desktop-server',
				'href'  => 'http://mojo.live/desktopserver',
				'title' => '<div style="background-color: #3575C0; padding: 0 10px;color:#fff;">' . esc_html__( 'Get Online Now', 'mojo-marketplace-wp-plugin' ) . '</div>',
				'meta'  => array(
					'title' => __( 'Get Online Now', 'mojo-marketplace-wp-plugin' ),
				),
			);
			$admin_bar->add_menu( $args );
		}
		if ( 'true' === get_option( 'mm_coming_soon', 'false' ) ) {
			$cs_args = array(
				'id'    => 'mojo-home',
				'href'  => admin_url( 'admin.php?page=mojo-home' ),
				'title' => '<div style="background-color: #F89C24; padding: 0 10px;color:#fff;">' . esc_html__( 'Coming Soon Active', 'mojo-marketplace-wp-plugin' ) . '</div>',
				'meta'  => array(
					'title' => esc_html__( 'Launch Your Site', 'mojo-marketplace-wp-plugin' ),
				),
			);
			$admin_bar->add_menu( $cs_args );
		}
	}
}

add_action( 'admin_bar_menu', 'mm_add_tool_bar_items', 100 );

/**
 * Marketplace Page
 */
function mm_marketplace_page() {
	mm_require( MM_BASE_DIR . 'pages/mojo-marketplace.php' );
}

/**
 * Performance and Marketplace Menu Items
 */
function mm_performance_menu() {
	add_submenu_page( 'mojo-marketplace', esc_html__( 'Performance', 'mojo-marketplace-wp-plugin' ), esc_html__( 'Performance', 'mojo-marketplace-wp-plugin' ), 'manage_options', 'mojo-performance', 'mm_performance_page' );
	add_submenu_page( 'mojo-marketplace', esc_html__( 'Marketplace', 'mojo-marketplace-wp-plugin' ), esc_html__( 'Marketplace', 'mojo-marketplace-wp-plugin' ), 'manage_options', 'mojo-marketplace-page', 'mm_marketplace_page' );
}

add_action( 'admin_menu', 'mm_performance_menu' );

/**
 * Performance Page
 */
function mm_performance_page() {
	mm_require( MM_BASE_DIR . 'pages/mojo-performance.php' );
}

/**
 * Home Menu Item
 */
function mm_home_menu() {
	if ( 'bluehost' == mm_brand() || 'bluehost-india' == mm_brand() ) {
		add_submenu_page( 'mojo-marketplace', esc_html__( 'Home', 'mojo-marketplace-wp-plugin' ), esc_html__( 'Home', 'mojo-marketplace-wp-plugin' ), 'manage_options', 'mojo-home', 'mm_home_page', 0 );
	}
}

add_action( 'admin_menu', 'mm_home_menu' );

/**
 * Home Page
 */
function mm_home_page() {
	mm_require( MM_BASE_DIR . 'pages/mojo-home.php' );
}

/**
 * Staging Menu Item for Bluehost
 */
function mm_staging_menu() {
	if ( 'bluehost' == mm_brand() || 'bluehost-india' == mm_brand() ) {
		add_submenu_page( 'mojo-marketplace', esc_html__( 'Staging (beta)', 'mojo-marketplace-wp-plugin' ), __( 'Staging <small>(beta)</small>', 'mojo-marketplace-wp-plugin' ), 'manage_options', 'mojo-staging', 'mm_staging_page' );
	}
}

add_action( 'admin_menu', 'mm_staging_menu' );

/**
 * Staging Page
 */
function mm_staging_page() {
	$env = get_option( 'staging_environment' );
	switch ( $env ) {
		case 'production':
			require_once MM_BASE_DIR . 'pages/staging-production.php';
			break;

		case 'staging':
			require_once MM_BASE_DIR . 'pages/staging-staging.php';
			break;

		default:
			require_once MM_BASE_DIR . 'pages/staging-create.php';
			break;
	}

	echo "<a target='_blank' href='https://goo.gl/forms/HNmqYgRkpzu9KQfM2' style='z-index: 10;position: fixed; padding: 4px 10px; color: #fff;background-color: #000;right:0px;bottom:0px;'>" . esc_html__( 'Staging Feedback', 'mojo-marketplace-wp-plugin' ) . '</a>';
}

/**
 * Hosting Menu Item for bluehost
 */
function mm_hosting_menu() {
	if ( 'bluehost' == mm_brand() ) {
		add_submenu_page( 'mojo-marketplace', __( 'Back to Bluehost', 'mojo-marketplace-wp-plugin' ), __( 'Back to Bluehost', 'mojo-marketplace-wp-plugin' ), 'manage_options', 'mojo-hosting-panel', '__return_false' );
	}
}

add_action( 'admin_menu', 'mm_hosting_menu' );

/**
 * Jetpack Connect Menu Item for bluehost
 */
function mm_jetpack_connect_menu() {
	if ( 'bluehost' == mm_brand() ) {
		add_submenu_page( null, __( 'Connect Jetpack', 'mojo-marketplace-wp-plugin' ), __( 'Connect Jetpack', 'mojo-marketplace-wp-plugin' ), 'manage_options', 'mojo-jetpack-connect-bounce', '__return_false' );
	}
}

add_action( 'admin_menu', 'mm_jetpack_connect_menu' );

/**
 * Menu Redirects
 */
function mm_menu_redirects() {
	if ( isset( $_GET['page'] ) ) {
		if ( 'mojo-marketplace' == $_GET['page'] && ! isset( $_GET['section'] ) ) {
			$destination = admin_url( 'admin.php?page=mojo-performance' );
			if ( 'bluehost' == mm_brand() || 'bluehost-india' == mm_brand() ) {
				$destination = admin_url( 'admin.php?page=mojo-home' );
			}
		} elseif ( 'mojo-hosting-panel' == $_GET['page'] ) {
			wp_redirect( 'https://my.bluehost.com/cgi/home', 302 );
		} elseif ( 'mojo-jetpack-connect-bounce' == $_GET['page'] ) {
			if ( class_exists( 'Jetpack' ) ) {
				wp_redirect( Jetpack::init()->build_connect_url( true ), 302 );
			} else {
				$destination = admin_url( 'admin.php?page=mojo-home' );
			}
		}
		if ( isset( $destination ) ) {
			if ( isset( $_GET['items'] ) ) {
				$destination = add_query_arg( array( 'items' => $_GET['items'] ), $destination );
			}
			wp_safe_redirect( $destination, '301' );
		}
	}
}

add_action( 'admin_init', 'mm_menu_redirects' );

add_action( 'admin_enqueue_scripts', 'mm_enqueue_scripts' );

/**
 * Enqueue Scripts
 */
function mm_enqueue_scripts() {
	wp_enqueue_style(
		'mojo-marketplace',
		plugins_url( 'build/marketplace.css', MM_FILE ),
		null,
		MM_VERSION
	);
	wp_enqueue_script(
		'mojo-marketplace',
		plugins_url( 'build/marketplace.js', MM_FILE ),
		array(
			'wp-api-fetch',
			'wp-components',
			'wp-dom-ready',
			'wp-element',
			'wp-i18n',
		),
		MM_VERSION,
		true
	);
	wp_localize_script(
		'mojo-marketplace',
		'mojo',
		array(
			'restUrl'   => get_home_url() . '/index.php?rest_route=',
			'restNonce' => wp_create_nonce( 'wp_rest' ),
		)
	);
}
