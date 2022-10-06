<?php

// phpcs:disable Squiz.Commenting.FunctionComment.Missing

if ( ! defined( 'WPINC' ) ) {
	die;
}

function mm_is_staging() {
	return ( get_option( 'staging_environment' ) === 'staging' ) ? true : false;
}

function mm_cl( $command, $args = null ) {
	$whitelist_commands = array(
		'create'          => false,
		'clone'           => 'production',
		'destroy'         => 'production',
		'sso_staging'     => 'production',
		'deploy_files'    => 'staging',
		'deploy_db'       => 'staging',
		'deploy_files_db' => 'staging',
		'sso_production'  => 'staging',
		'compat_check'    => false,
	);

	if ( ! array_key_exists( $command, $whitelist_commands ) ) {
		echo wp_json_encode(
			array(
				'status'  => 'error',
				'message' => 'Command not found in whitelist.',
			)
		);
	} else {
		if ( ! class_exists( 'WP_CLI_Command' ) ) {
			mm_check_env( $whitelist_commands[ $command ] );
		}
	}

	if ( 'compat_check' !== $command ) {
		do_action( 'mm_staging_command', $command );
	}

	$command = array( $command );
	$token   = wp_generate_password( 32, false );
	set_transient( 'staging_auth_token', $token, 60 );
	$command[] = $token;
	$config    = get_option( 'staging_config' );
	if ( false === $config || ! isset( $config['production_dir'] ) || ! isset( $config['staging_dir'] ) ) {
		$staging_rel = 'staging/' . mt_rand( 1000, 9999 ); // phpcs:ignore
		$config      = array(
			'production_dir' => ABSPATH,
			'staging_dir'    => ABSPATH . $staging_rel . '/',
			'production_url' => get_option( 'siteurl' ),
			'staging_url'    => get_option( 'siteurl' ) . '/' . $staging_rel,
			'creation_date'  => date( 'M j, Y' ), // phpcs:ignore
		);
		update_option( 'staging_config', $config );
	}

	$command[] = $config['production_dir'];
	$command[] = $config['staging_dir'];
	$command[] = $config['production_url'];
	$command[] = $config['staging_url'];
	$command[] = get_current_user_id();

	if ( ! is_null( $args ) && is_array( $args ) ) {
		$args    = array_values( $args );
		$command = array_merge( $command, $args );
	}

	array_map( 'escapeshellcmd', $command );
	$command = implode( ' ', $command );

	if ( false !== strpos( $command, ';' ) ) {
		echo wp_json_encode(
			array(
				'status'  => 'error',
				'message' => 'Invalid character in command (;).',
			)
		);
		die;
	}

	if ( false !== strpos( $command, '&' ) ) {
		echo wp_json_encode(
			array(
				'status'  => 'error',
				'message' => 'Invalid character in command (&).',
			)
		);
		die;
	}

	if ( false !== strpos( $command, '|' ) ) {
		echo wp_json_encode(
			array(
				'status'  => 'error',
				'message' => 'Invalid character in command (|).',
			)
		);
		die;
	}

	$disabled_functions = explode( ',', ini_get( 'disable_functions' ) );
	if ( is_array( $disabled_functions ) && in_array( 'exec', array_map( 'trim', $disabled_functions ), true ) ) {
		echo wp_json_encode(
			array(
				'status'  => 'error',
				'message' => 'Unable to execute script (disabled_function).',
			)
		);
		die;
	}

	$script = MM_BASE_DIR . 'lib/.staging';

	if ( 0755 !== (int) substr( sprintf( '%o', fileperms( $script ) ), - 4 ) ) {
		if ( is_writable( $script ) ) {
			chmod( $script, 0755 );
		} else {
			echo wp_json_encode(
				array(
					'status'  => 'error',
					'message' => 'Unable to execute script (permission error).',
				)
			);
			die;
		}
	}

	putenv( 'PATH=' . getenv( 'PATH' ) . PATH_SEPARATOR . '/usr/local/bin' ); // phpcs:ignore

	$response = exec( $script . ' ' . $command ); // phpcs:ignore

	return $response;
}

function mm_check_admin() {
	if ( ! current_user_can( 'manage_options' ) ) {
		$response = array(
			'status'  => 'error',
			'message' => 'Invalid user permissions.',
		);
		echo wp_json_encode( $response );
		die;
	}
}

function mm_check_env( $env ) {
	$current_env = get_option( 'staging_environment', false );
	if ( $env === $current_env ) {
		return true;
	} else {
		$response = array(
			'status'  => 'error',
			'message' => 'Invalid environment for command.',
		);
		echo wp_json_encode( $response );
		die;
	}
}

function mm_compat_check() {
	echo mm_cl( 'compat_check' ); // phpcs:ignore
	die;
}

add_action( 'wp_ajax_mm_compat_check', 'mm_compat_check' );

function mm_create() {
	mm_check_admin();
	mm_check_env( false );
	set_transient( 'mm_fresh_staging', true, 300 );
	echo mm_cl( 'create' ); // phpcs:ignore
	die;
}

add_action( 'wp_ajax_mm_create', 'mm_create' );

function mm_clone() {
	mm_check_admin();
	mm_check_env( 'production' );
	echo mm_cl( 'clone' ); // phpcs:ignore
	die;
}

add_action( 'wp_ajax_mm_clone', 'mm_clone' );

function mm_deploy_files() {
	mm_check_admin();
	mm_check_env( 'staging' );
	echo mm_cl( 'deploy_files' ); // phpcs:ignore
	die;
}

add_action( 'wp_ajax_mm_deploy_files', 'mm_deploy_files' );

function mm_deploy_files_db() {
	mm_check_admin();
	mm_check_env( 'staging' );
	echo mm_cl( 'deploy_files_db' ); // phpcs:ignore
	die;
}

add_action( 'wp_ajax_mm_deploy_files_db', 'mm_deploy_files_db' );

function mm_deploy_db() {
	mm_check_admin();
	mm_check_env( 'staging' );
	echo mm_cl( 'deploy_db' ); // phpcs:ignore
	die;
}

add_action( 'wp_ajax_mm_deploy_db', 'mm_deploy_db' );

function mm_destroy() {
	mm_check_admin();
	mm_check_env( 'production' );
	echo mm_cl( 'destroy' ); // phpcs:ignore
	die;
}

add_action( 'wp_ajax_mm_destroy', 'mm_destroy' );

function mm_sso_production() {
	mm_check_admin();
	mm_check_env( 'staging' );
	echo mm_cl( 'sso_production', array( get_current_user_id() ) ); // phpcs:ignore
	die;
}

add_action( 'wp_ajax_mm_sso_production', 'mm_sso_production' );

function mm_sso_staging() {
	mm_check_env( 'production' );
	echo mm_cl( 'sso_staging', array( get_current_user_id() ) ); // phpcs:ignore
	die;
}

add_action( 'wp_ajax_mm_sso_staging', 'mm_sso_staging' );

function mm_interim() {
	if ( isset( $_POST['template'] ) ) { // // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$interim = MM_BASE_DIR . 'pages/interim-' . sanitize_file_name( $_POST['template'] ) . '.php'; // // phpcs:ignore WordPress.Security.NonceVerification.Missing
		mm_require( $interim );
	}
	die;
}

add_action( 'wp_ajax_mm_interim', 'mm_interim' );

function mm_modal() {
	if ( isset( $_POST['template'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$interim = MM_BASE_DIR . 'pages/modal-' . sanitize_file_name( $_POST['template'] ) . '.php'; // phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( file_exists( $interim ) ) {
			?>
			<div id="mm-modal-wrap">
				<?php mm_require( $interim ); ?>
			</div>
			<?php
		}
	}
	die;
}

add_action( 'wp_ajax_mm_modal', 'mm_modal' );
