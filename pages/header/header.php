<header id="header" class="navbar navbar-default">
	<div
		class="header-block bg-cover"
		style="background-image: url('<?php echo esc_url( mm_brand( MM_BASE_URL . 'assets/images/headers/header-bg-%s.jpg' ) ); ?>');"
	>
		<span
			data-srcset="<?php echo esc_url( mm_brand( MM_BASE_URL . 'assets/images/headers/header-bg-%s.jpg' ) ); ?>, <?php echo esc_url( mm_brand( MM_BASE_URL . 'assets/images/headers/header-bg-%s-2x.jpg' ) ); ?> 2x"></span>
		<nav>
			<div class="container">
				<div class="inner-holder">
					<a class="navbar-brand" href="#">
						<img
							src="<?php echo esc_url( mm_brand( MM_BASE_URL . 'assets/images/svgs/logo-icon-%s.svg' ) ); ?>"
							alt="<?php esc_attr_e( 'Marketplace', 'mojo-marketplace-wp-plugin' ); ?>"
						>
					</a>
				</div>
			</div>
			<?php
			require_once MM_BASE_DIR . 'pages/header/nav-primary.php';
			require_once MM_BASE_DIR . 'pages/header/nav-sub.php';
			if ( 'bluehost' === mm_brand() ) {
				echo '<div class="bluehost-loader"></div>';
			}
			?>
		</nav>
	</div>
</header>
