<?php

function mm_brand( $format = '%s' ) {
	$mm_brand = get_option( 'mm_brand', 'default' );

	$brands = array(
		'BlueHost'                         => 'bluehost',
		'BlueHost_for_Education'           => 'bluehost',
		'BlueHost_Optimized_for_WordPress' => 'bluehost',
		'Bluehost_QI'                      => 'bluehost',
		'Bluehost_India'                   => 'bluehost-india',
		'Bluehost_SEA'                     => 'bluehost',
		'Just_Host'                        => 'default',
		'Just_Host_QI'                     => 'default',
		'HostMonster'                      => 'default',
		'Hostmonster_QI'                   => 'default',
		'HostGator'                        => 'hostgator',
		'HostGator_QI'                     => 'default',
		'HostGator_com_for_Resellers'      => 'default',
		'Hostgator_Com_LLC'                => 'default',
		'HostGatorSG'                      => 'default',
		'Hostgator_India'                  => 'hostgator-india',
		'iPower'                           => 'ipower',
		'iPage'                            => 'ipage',
		'FatCow'                           => 'fatcow',
	);

	if ( array_key_exists( $mm_brand, $brands ) ) {
		$brand = $brands[ $mm_brand ];
	}

	if ( ! isset( $brand ) || empty( $brand ) || 'quickinstall' == $brand ) {
		$brand = 'default';
	}

	return sprintf( $format, sanitize_title( $brand ) );
}

function mm_plugin_details( $all_plugins ) {
	$plugin_file = 'mojo-marketplace-wp-plugin/mojo-marketplace.php';
	if ( isset( $all_plugins[ $plugin_file ] ) ) {
		switch ( mm_brand() ) {
			case 'bluehost':
				$branded_plugin_details = array(
					'Name'        => 'Bluehost',
					'Title'       => 'Bluehost',
					'Description' => esc_html__( 'This plugin integrates your WordPress site with the Bluehost control panel, including performance, security, and update features.', 'mojo-marketplace-wp-plugin' ),
				);
				break;
			case 'bluehost-india':
				$branded_plugin_details = array(
					'Name'  => 'Bluehost',
					'Title' => esc_html__( 'Bluehost', 'mojo-marketplace-wp-plugin' ),
				);
				break;
			default:
				$branded_plugin_details = array();
		}
		$all_plugins[ $plugin_file ] = wp_parse_args( $branded_plugin_details, $all_plugins[ $plugin_file ] );
	}

	return $all_plugins;
}

add_filter( 'all_plugins', 'mm_plugin_details' );
