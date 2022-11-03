<?php if ( ! is_404() ) : ?>
	<img src="<?php echo get_template_directory_uri(); ?>/assets/pics/layer-color-header.png" alt="" class="layer-header">
	<?php endif; ?>
	
	<div class="container top-nav">
		<nav>
		<div class="left">
			<div class="menuToggle">
			<div class="hamburger">
				<span></span>
				<span></span>
				<span></span>
			</div>
			<span class="text"><?php _e( 'menu', 'crea' ); ?></span>
			</div>
		</div>

		<div class="right">

			<a href="<?php echo wc_get_cart_url(); ?>" class="cart hide"></a>

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
				<li><a rel="alternate" hreflang="<?php echo esc_attr( $language['tag'] ); ?>" href="<?php echo $language['url']; ?>" <?php echo ( (int) $language['active'] === 1 ? ' class="active"' : '' ); ?>><?php echo esc_html( strtoupper( $language['code'] ) ); ?></a></li>
					<?php
				}
			}
			?>
			</ul>

			<button class="searchToggle">
			<span class="loupe"></span>
			</button>

			<a href="tel:+41223381580" class="mobile-phone"></a>
		</div>
		</nav>

		<div class="logo" data-src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/logo.png">
		<a href="<?php echo esc_url( home_url() ); ?>">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/pics/logo.png"
				 srcset="<?php echo get_template_directory_uri(); ?>/assets/pics/logo@2x.png 2x" alt="">
		</a>
		</div>
	</div>
