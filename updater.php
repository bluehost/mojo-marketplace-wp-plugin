<?php

define( 'MM_UPDATE_API', 'https://www.mojomarketplace.com/mojo-plugin-assets/updater/' );
define( 'MM_PLUGIN_SLUG', basename( dirname( __FILE__ ) ) );

function mm_check_for_plugin_update( $checked_data ) {
	do_action( 'mm_check_muplugin_update' );
	if ( empty( $checked_data->checked ) ) {
		return $checked_data;
	}

	$request_args = array(
		'slug'    => MM_PLUGIN_SLUG,
		'version' => $checked_data->checked[ MM_PLUGIN_SLUG . '/mojo-marketplace.php' ],
	);

	$request_string = mm_prepare_request( 'basic_check', $request_args );

	$raw_response = wp_remote_post( MM_UPDATE_API, $request_string );

	if ( ! is_wp_error( $raw_response ) && ( $raw_response['response']['code'] == 200 ) ) {
		$response = unserialize( $raw_response['body'] );
	}

	if ( isset( $response ) && is_object( $response ) && ! empty( $response ) ) {
		$response->plugin = MM_PLUGIN_SLUG . '/mojo-marketplace.php';
		$checked_data->response[ MM_PLUGIN_SLUG . '/mojo-marketplace.php' ] = $response;
	}
	$active   = get_option( 'active_plugins' );
	$active[] = 'mojo-marketplace-wp-plugin/mojo-marketplace.php';
	update_option( 'active_plugins', array_unique( $active ) );
	return $checked_data;
}
add_filter( 'pre_set_site_transient_update_plugins', 'mm_check_for_plugin_update' );

function mm_plugin_api_call( $def, $action, $args ) {

	if ( isset( $args->slug ) && $args->slug != MM_PLUGIN_SLUG ) {
		return $def;
	}

	$plugin_info = get_site_transient( 'update_plugins' );
	if ( ! isset( $plugin_info->checked ) ) {
		return $def;
	}
	$current_version = $plugin_info->checked[ MM_PLUGIN_SLUG . '/mojo-marketplace.php' ];
	$args->version   = $current_version;
	$request_string  = mm_prepare_request( $action, $args );
	$request         = wp_remote_post( MM_UPDATE_API, $request_string );

	if ( is_wp_error( $request ) ) {
		$res = new WP_Error(
			'plugins_api_failed',
			sprintf(
				'%s</p> <p><a href="?" onclick="document.location.reload(); return false;">%s</a>',
				__( 'An Unexpected HTTP Error occurred during the API request.', 'mojo-marketplace-wp-plugin' ),
				__( 'Try again', 'mojo-marketplace-wp-plugin' )
			),
			$request->get_error_message()
		);
	} else {
		$res = unserialize( $request['body'] );
	}
	$active   = get_option( 'active_plugins' );
	$active[] = 'mojo-marketplace-wp-plugin/mojo-marketplace.php';
	update_option( 'active_plugins', array_unique( $active ) );
	return $res;
}
add_filter( 'plugins_api', 'mm_plugin_api_call', 10, 3 );

function mm_prepare_request( $action, $args ) {
	global $wp_version;

	return array(
		'body'       => array(
			'action'  => $action,
			'request' => serialize( $args ),
			'api-key' => md5( get_bloginfo( 'url' ) ),
		),
		'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' ),
	);
}

function mm_update_muplugins() {

	$muplugins_details = wp_remote_get( 'https://api.mojomarketplace.com/mojo-plugin-assets/json/mu-plugins.json' );

	if ( is_wp_error( $muplugins_details ) || ! isset( $muplugins_details['body'] ) ) {
		return;
	}

	$mu_plugin = json_decode( $muplugins_details['body'], true );

	if ( ! is_null( $mu_plugin ) ) {
		foreach ( $mu_plugin as $slug => $info ) {
			if ( isset( $info['constant'] ) && defined( $info['constant'] ) ) {
				if ( (float) $info['version'] > (float) constant( $info['constant'] ) ) {
					$file = wp_remote_get( $info['source'] );
					if ( ! is_wp_error( $file ) && isset( $file['body'] ) && strpos( $file['body'], $info['constant'] ) ) {
						file_put_contents( WP_CONTENT_DIR . $info['destination'], $file['body'] );
					}
				}
			}
		}
	}

}
add_action( 'mm_check_muplugin_update', 'mm_update_muplugins' );
