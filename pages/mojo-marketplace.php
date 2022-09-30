<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

?>
<div id="mojo-wrapper" class="<?php echo esc_attr( mm_brand( 'mojo-%s-branding' ) ); ?>">
	<?php require_once MM_BASE_DIR . 'pages/header/header.php'; ?>
	<main id="main">
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 col-sm-8">
							<ol class="breadcrumb">
								<li><?php esc_html_e( 'Marketplace', 'mojo-marketplace-wp-plugin' ); ?></li>
							</ol>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div id="mojo-marketplace-app">
						Oops, something went wrong. Please try reloading this page.
					</div>
				</div>
			</div>
		</div>
	</main>
</div>
