<?php
/**
 * Main navigation for CREA
 *
 * @package WordPress
 * @subpackage CREA
 */

$page_id      = get_the_ID();
$page_theme   = get_post_meta( $page_id, 'page_theme', true );
$flow_page_id = ( 'ebs' === $page_theme ? FLOW_EBS_PAGE_ID : FLOW_PAGE_ID );
?>
<div class="menu-container">
	<div class="overlay-layer"></div>

	<nav>
		<div class="actions">
			<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="btn"><?php esc_html_e( 'Le blog', 'crea' ); ?></a>

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
				'theme_location' => 'primary',
				'menu_id'        => 'primary-menu',
			)
		);
		?>

		<footer class="menu-container-footer">

			<?php
			$ebs_home_url = get_option( 'options_ebs_page_home' );

			if ( ! empty( $ebs_home_url ) ) {
				?>
				<a class="flex items-center no-underline border-y py-2.5 border-grey-75 mb-9 text-ebs-blue-dark" href="<?php echo esc_url( $ebs_home_url ); ?>" target="_blank" rel="noopener">
					<img class="mr-1.5" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/ebs-geneve.svg" alt="" width="43.194" height="30.116">
					<?php esc_html_e( 'Aller sur EBS Genève', 'crea' ); ?>
					<img class="ml-auto" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/chevron-right.svg" alt="" width="7.136" height="13.273">
				</a>
				<?php
			}
			?>

			<a href="<?php echo esc_url( get_permalink( $flow_page_id ) ); ?>" class="btn d-block flowinfo" data-hide_takeaway="1">
				<?php echo esc_html__( 'Séance d\'info', 'crea' ) . ' <span>/ ' . esc_html__( 'Contact', 'crea' ) . '</span>'; ?>
			</a>

		</footer>
	</nav>
</div>
