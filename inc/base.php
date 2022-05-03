<?php

function mm_setup() {
	if ( ( '' === get_option( 'mm_master_aff' ) || false === get_option( 'mm_master_aff' ) ) && defined( 'MMAFF' ) ) {
		update_option( 'mm_master_aff', MMAFF );
	}
	if ( ! get_option( 'mm_install_date' ) ) {
		update_option( 'mm_install_date', date( 'M d, Y' ) );
		$event                            = array(
			't'    => 'event',
			'ec'   => 'plugin_status',
			'ea'   => 'installed',
			'el'   => sprintf(
				/* translators: %s: installation date */
				esc_html__( 'Install date: %s', 'mojo-marketplace-wp-plugin' ),
				get_option( 'mm_install_date', date( 'M d, Y' ) )
			),
			'keep' => false,
		);
		$events                           = get_option( 'mm_cron', array() );
		$events['hourly'][ $event['ea'] ] = $event;
		update_option( 'mm_cron', $events );
	}
}

add_action( 'admin_init', 'mm_setup' );

function mm_api_cache( $api_url ) {
	$key = md5( $api_url );
	if ( false === ( $transient = get_transient( 'mm_api_calls' ) ) || ! isset( $transient[ $key ] ) ) {
		$transient[ $key ] = wp_remote_get( $api_url, array( 'timeout' => 15 ) );
		if ( ! is_wp_error( $transient[ $key ] ) ) {
			set_transient( 'mm_api_calls', $transient, DAY_IN_SECONDS );
		}
	}

	return $transient[ $key ];
}

function mm_build_link( $url, $args = array() ) {
	$defaults = array(
		'utm_source'   => 'mojo_wp_plugin', // this should always be mojo_wp_plugin
		'utm_campaign' => 'mojo_wp_plugin',
		'utm_medium'   => 'plugin_admin', // (plugin_admin, plugin_widget, plugin_shortcode)
		'utm_content'  => '', // specific location
		'r'            => get_option( 'mm_master_aff' ),
	);
	$args     = wp_parse_args( array_filter( $args ), array_filter( $defaults ) );

	$test = get_transient( 'mm_test' );

	if ( isset( $test['key'] ) && isset( $test['name'] ) ) {
		$args['utm_medium'] = $args['utm_medium'] . '_' . $test['name'] . '_' . $test['key'];
	}

	if ( false !== strpos( $url, 'mojomarketplace.com' ) && 'default' != mm_brand() ) {
		$args['theme'] = mm_brand();
	}

	$args = wp_parse_args( array_filter( $args ), array_filter( $defaults ) );

	$url = add_query_arg( $args, $url );

	return esc_url( $url );
}

function mm_clear_api_calls() {
	if ( is_admin() ) {
		delete_transient( 'mojo_api_calls' );
	}
}

add_action( 'wp_login', 'mm_clear_api_calls' );
add_action( 'pre_current_active_plugins', 'mm_clear_api_calls' );

function mm_cron() {
	if ( ! wp_next_scheduled( 'mm_cron_monthly' ) ) {
		wp_schedule_event( time(), 'monthly', 'mm_cron_monthly' );
	}
	if ( ! wp_next_scheduled( 'mm_cron_weekly' ) ) {
		wp_schedule_event( time(), 'weekly', 'mm_cron_weekly' );
	}
	if ( ! wp_next_scheduled( 'mm_cron_daily' ) ) {
		wp_schedule_event( time(), 'daily', 'mm_cron_daily' );
	}
	if ( ! wp_next_scheduled( 'mm_cron_twicedaily' ) ) {
		wp_schedule_event( time(), 'twicedaily', 'mm_cron_twicedaily' );
	}
	if ( ! wp_next_scheduled( 'mm_cron_hourly' ) ) {
		wp_schedule_event( time(), 'hourly', 'mm_cron_hourly' );
	}
}

add_action( 'admin_init', 'mm_cron' );

function mm_cron_schedules( $schedules ) {
	$schedules['weekly']  = array(
		'interval' => WEEK_IN_SECONDS,
		'display'  => __( 'Once Weekly', 'mojo-marketplace-wp-plugin' ),
	);
	$schedules['monthly'] = array(
		'interval' => 4 * WEEK_IN_SECONDS,
		'display'  => __( 'Once a month', 'mojo-marketplace-wp-plugin' ),
	);

	return $schedules;
}

add_filter( 'cron_schedules', 'mm_cron_schedules' );

function mm_require( $original ) {
	$file = apply_filters( 'mm_require_file', $original );
	if ( file_exists( $file ) ) {
		require $file;

		return $file;
	} elseif ( file_exists( $original ) ) {
		require $original;

		return $original;
	} else {
		return false;
	}
}

function mm_minify( $content ) {
	$content = str_replace( "\r", '', $content );
	$content = str_replace( "\n", '', $content );
	$content = str_replace( "\t", '', $content );
	$content = str_replace( '  ', ' ', $content );
	$content = trim( $content );

	return $content;
}

function mm_safe_hosts( $hosts ) {
	$hosts[] = 'mojomarketplace.com';

	return $hosts;
}

add_filter( 'allowed_redirect_hosts', 'mm_safe_hosts' );

function mm_better_news_feed( $feed ) {
	return 'http://feeds.feedburner.com/wp-pipes';
}

add_filter( 'dashboard_secondary_feed', 'mm_better_news_feed' );
add_filter( 'dashboard_secondary_link', 'mm_better_news_feed' );

function mm_adjust_feed_transient_lifetime( $lifetime ) {
	return 3 * HOUR_IN_SECONDS;
}

add_filter( 'wp_feed_cache_transient_lifetime', 'mm_adjust_feed_transient_lifetime' );

function mm_loader() {
	if ( isset( $_GET['page'] ) && false !== strpos( $_GET['page'], 'mojo-' ) && mm_brand() == 'bluehost' ) {
		?>
		<script type="text/javascript">
			jQuery(document).ready(function ($) {
				setTimeout(function () {
					$('.bluehost-loader').fadeOut('slow');
				}, 2000);
			});
		</script>
		<?php
	}
}

add_action( 'admin_footer', 'mm_loader' );

function mm_site_bin2hex() {
	$path = ABSPATH;
	$path = explode( 'public_html/', $path );
	if ( 2 === count( $path ) ) {
		$path = '/public_html/' . $path[1];
	} else {
		return false;
	}

	$path_hash = bin2hex( $path );

	return $path_hash;
}
