<?php
$mojo_page = sanitize_key( $_GET['page'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$nav       = array(
	'mojo-marketplace-page' => array(
		'href'    => add_query_arg( array( 'page' => 'mojo-marketplace-page' ), admin_url( 'admin.php' ) ),
		'content' => esc_html__( 'Marketplace', 'mojo-marketplace-wp-plugin' ),
	),
	'mojo-performance' => array(
		'href'    => add_query_arg( array( 'page' => 'mojo-performance' ), admin_url( 'admin.php' ) ),
		'content' => esc_html__( 'Performance', 'mojo-marketplace-wp-plugin' ),
	),
);

if ( 'bluehost' === mm_brand() || 'bluehost-india' === mm_brand() ) {
	$home = array(
		'mojo-home' => array(
			'href'    => add_query_arg( array( 'page' => 'mojo-home' ), admin_url( 'admin.php' ) ),
			'content' => esc_html__( 'Home', 'mojo-marketplace-wp-plugin' ),
		),
	);
	$nav  = $home + $nav;
}

if ( 'bluehost' === mm_brand() || 'bluehost-india' === mm_brand() ) {
	$nav['mojo-staging'] = array(
		'href'    => add_query_arg( array( 'page' => 'mojo-staging' ), admin_url( 'admin.php' ) ),
		'content' => esc_html__( 'Staging', 'mojo-marketplace-wp-plugin' ),
	);
}

if ( array_key_exists( $mojo_page, $nav ) ) {
	$nav[ $mojo_page ]['active'] = true;
} else {
	$nav['mojo-home']['active'] = true;
}
?>

<div class="collapse navbar-collapse" id="navbar-collapse-1" style="margin-top: 40px;">
	<div class="container">
		<div class="inner-holder">
			<div class="nav-holder clearfix">
				<ul class="nav navbar-nav justified-nav">
					<?php
					foreach ( $nav as $navitem ) {
						if ( ! isset( $navitem['active'] ) ) {
							echo '<li>';
						} else {
							echo '<li class="active">';
						}
						echo '<a href="' . esc_url( $navitem['href'] ) . '">' . wp_kses_post( $navitem['content'] ) . '</a>';
						echo '</li>';
					}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>
