<?php
/**
 * Main navigation for EBS
 *
 * @package WordPress
 * @subpackage CREA
 */

?>
<div class="menu-container">
	<div class="overlay-layer"></div>

	<nav>
		<div class="actions">
			<div class="back-btn">
				<i class="icon-back"></i>
			</div>

			<ul class="lang-selector">
				<?php
				$languages = apply_filters(
					'wpml_active_languages',
					null,
					array(
						'order' => 'desc',
					)
				);

				if ( count( $languages ) > 1 ) {
					foreach ( $languages as $code => $language ) {
						?>
						<li>
							<a rel="alternate" hreflang="<?php echo esc_attr( $language['tag'] ); ?>" href="<?php echo esc_url( $language['url'] ); ?>" <?php echo ( 1 === (int) $language['active'] ? 'class="active"' : '' ); ?>>
								<?php echo esc_html( strtoupper( $language['code'] ) ); ?>
							</a>
						</li>
						<?php
					}
				}
				?>
			</ul>
		</div>

		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary_ebs',
				'menu_id'        => 'primary-menu',
			)
		);
		?>
		<footer class="menu-container-footer">
			<?php if ( defined( 'CREA_DOMAIN' ) ) : ?>
				<a
					class="flex items-center no-underline border-y py-2.5 border-grey-75 mb-9 text-magenta"
					href="<?php echo esc_url( 'https://' . CREA_DOMAIN ); ?>"
					target="_blank"
					rel="noopener"
				>
					<img
						class="mr-1.5" src="<?php echo esc_url( get_template_directory_uri() . '/assets/pics/logo.svg' ); ?>"
						alt=""
						width="43.194"
						height="30.116"
					>
					<?php esc_html_e( 'Aller sur CREA', 'crea' ); ?>
					<img
						class="ml-auto" src="<?php echo esc_url( get_template_directory_uri() . '/assets/pics/chevron-right.svg' ); ?>"
						alt=""
						width="7.136"
						height="13.273"
					>
				</a>
			<?php endif; ?>

			<a href="<?php echo esc_url( get_permalink( get_option( 'options_ebs_page_flow' ) ) ); ?>" class="btn d-block flowinfo" data-hide_takeaway="1">
				<?php echo esc_html__( 'Séance d\'info', 'crea' ) . '<span>/' . esc_html__( 'Contact', 'crea' ) . '</span>'; ?>
			</a>

		</footer>
	</nav>
</div>
