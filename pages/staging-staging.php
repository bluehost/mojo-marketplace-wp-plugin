<?php
if ( ! defined( 'WPINC' ) ) { die; }
?>
<div id="mojo-wrapper" class="<?php echo mm_brand( 'mojo-%s-branding' );?>">
<?php
require_once( MM_BASE_DIR . 'pages/header/header.php' );
?>
	<main id="main">
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 col-sm-12">
							<ol class="breadcrumb">
								<li>Staging Environment</li>
							</ol>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-sm-12">
							<p><?php esc_html_e( 'Below are the details of your staging environment.' ); ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-8">
							<?php
							$config = get_option( 'staging_config' );
							?>
							<table class="table table-bordered">

								<?php
								if ( isset( $config['staging_url'] ) ) {
									echo '<tr><td>Staging URL:</td><td><a href="' . esc_url( $config['staging_url'] ) . '" target="_blank">' . $config['staging_url'] . '</a></td></tr>';
								}
								if ( isset( $config['staging_dir'] ) ) {
									echo '<tr><td>Staging Directory:</td><td>' . $config['staging_dir'] . '</td></tr>';
								}
								if ( isset( $config['creation_date'] ) ) {
									echo '<tr><td>Creation Date:</td><td>' . $config['creation_date'] . '</td></tr>';
								}
								?>

							</table>
						</div>
						<div class="col-xs-12 col-sm-4">
							<button class="btn btn-primary btn-lg staging-action" data-staging-action="mm_sso_production"><?php esc_html_e( 'Go To Production Site' ); ?></button>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 col-sm-12">
							<ol class="breadcrumb">
								<li><?php esc_html_e( 'Deployment Options' ); ?></li>
							</ol>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-sm-offset-3  text-center">
							<h2><?php esc_html_e( 'Deploy Staging To Production' ); ?></h2>
							<br/>
							<img src="<?php echo esc_url( MM_ASSETS_URL . 'img/staging-to-production.png' ); ?>" />
							<br/>
							<p><?php esc_html_e( 'Ready to make your changes live? These options will push the changes you have made on staging up to your production site.' ); ?></p>
						</div>
					</div>
					<br/>
					<div class="row">
						<div class="col-xs-12 col-sm-4 text-center">
							<div style="height: 150px;">
								<img src="<?php echo esc_url( MM_ASSETS_URL . 'img/files.png' ); ?>" />
							</div>
							<button class="btn btn-success btn-lg mm-modal" data-mm-modal="deploy-files"><?php esc_html_e( 'Deploy Files Only' ); ?></button>
							<br/>
							<p><?php esc_html_e( 'This will only upload the files you have changed (ie. html or css files). It will not upload any changes you have made to your staging database.' ); ?></p>
						</div>
						<div class="col-xs-12 col-sm-4 text-center">
							<div style="height: 150px;">
								<img src="<?php echo esc_url( MM_ASSETS_URL . 'img/files-db.png' ); ?>" />
							</div>
							<button class="btn btn-success btn-lg mm-modal" data-mm-modal="deploy-files-database"><?php esc_html_e( 'Deploy Files &amp; Database' ); ?></button>
							<br/>
							<p><?php esc_html_e( 'Deploy all changes you have made to the file system and database of your website.' ); ?></p>
						</div>
						<div class="col-xs-12 col-sm-4 text-center">
							<div style="height: 150px;">
								<img src="<?php echo esc_url( MM_ASSETS_URL . 'img/database.png' ); ?>" />
							</div>
							<button class="btn btn-success btn-lg mm-modal" data-mm-modal="deploy-database"><?php esc_html_e( 'Deploy Database Only' ); ?></button>
							<br/>
							<p><?php esc_html_e( 'Only upload changes you have made to the database on your staging server. For example, adding a new blog post to your website is a database change.' ); ?></p>
						</div>
					</div>
				</div>
			</div>

			<?php
			$revisions = mm_cl( 'revisions' );
			$revisions = explode( ';', $revisions );
			if ( is_array( $revisions ) ) {
			?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 col-sm-12">
							<ol class="breadcrumb">
								<li><?php esc_html_e( 'Restoration Options' ); ?></li>
							</ol>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-sm-8">
							<p><?php esc_html_e( 'Save the current staging environment or restore a previously saved staging environment.' ); ?></p>
						</div>
						<div class="col-xs-12 col-sm-4 text-right">
							<button class="btn btn-primary btn-lg staging-action" data-staging-action="mm_save_state"><?php esc_html_e( 'Add Restoration Point' ); ?></button>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12">
							<table class="table">
								<tr><th><?php esc_html_e( 'Message' ); ?></th><th><?php esc_html_e( 'Date' ); ?></th><th>&nbsp;</th></tr>
								<tr id="staging-revisions-loader"><td colspan="3" class="text-center"><img src="<?php echo MM_ASSETS_URL . 'img/loader-balls.svg';?>"/></td></tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			<?php
			}
			?>
		</div>
	</main>
</div>

<script type="text/javascript" src="https://api.mojomarketplace.com/mojo-plugin-assets/js/staging.js"></script>
