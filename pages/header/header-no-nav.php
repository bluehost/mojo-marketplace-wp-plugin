<header id="header" class="navbar navbar-default">
	<div
		class="header-block bg-cover"
		style="height: 120px; background-image: url('<?php echo esc_url( mm_brand( MM_BASE_URL . 'assets/images/headers/header-bg-%s.jpg' ) ); ?>');"
	>
		<span
			data-srcset="<?php echo esc_url( mm_brand( MM_BASE_URL . 'assets/images/headers/header-bg-%s.jpg' ) ); ?>, <?php echo esc_url( mm_brand( MM_BASE_URL . 'assets/images/headers/header-bg-%s-2x.jpg' ) ); ?> 2x"></span>
		<div class="container">
			<div class="inner-holder">
				<a class="navbar-brand" href="#">
					<img
						alt="<?php esc_attr_e( 'Marketplace', 'mojo-marketplace-wp-plugin' ); ?>"
						src="<?php echo esc_url( mm_brand( MM_BASE_URL . 'assets/images/svgs/logo-icon-%s.svg' ) ); ?>"
					>
				</a>
			</div>

		</div>
	</div>
</header>
