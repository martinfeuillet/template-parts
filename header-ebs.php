<?php
/**
 * Header for EBS part of CREA
 *
 * @package WordPress
 * @subpackage CREA
 */
?>

<!-- Header EBS -->
<div class="container top-nav">
	<nav>
		<div class="left">
			<div class="menuToggle">
				<div class="hamburger">
					<span></span>
					<span></span>
					<span></span>
				</div>
				<span class="text"><?php esc_html_e( 'menu', 'crea' ); ?></span>
			</div>
		</div>

		<div class="right">

			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart hide"></a>

			<ul class="lang-selector">
				<?php
				$languages = apply_filters( 'wpml_active_languages', null, array( 'order' => 'desc' ) );

				if ( count( $languages ) > 1 ) :
					foreach ( $languages as $code => $language ) :
						?>
						<li>
							<a
								rel="alternate"
								hreflang="<?php echo esc_attr( $language['tag'] ); ?>"
								href="<?php echo esc_url( $language['url'] ); ?>"
								<?php echo ( 1 === (int) $language['active'] ? ' class="active"' : '' ); ?>
							>
								<?php echo esc_html( strtoupper( $language['code'] ) ); ?>
							</a>
						</li>
						<?php
					endforeach;
				endif;
				?>
			</ul>

			<button class="searchToggle">
				<span class="loupe"></span>
			</button>

			<a href="tel:+41223381580" class="mobile-phone"></a>
		</div>
	</nav>

	<div class="logo" data-src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/ebs-geneve.svg">
		<a href="<?php echo esc_url( get_option( 'options' . (ICL_LANGUAGE_CODE != 'fr' ? '_en' : '')  . '_ebs_page_home' ) ); ?>">
			<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/ebs-geneve-dark.svg" alt="" height="127"/>
		</a>
	</div>
</div>
