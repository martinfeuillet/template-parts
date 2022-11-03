<?php
/**
 * OMNES Footer
 *
 * @package WordPress
 * @subpackage CREA
 */

?>

<footer id="colophon" role="contentinfo" class="gradient--style-2">
	<div class="site-footer" >
		<div class="wrapper-content">
			<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/logo-omnes-white.png" alt="Omnes Education">

			<?php
			$intro = get_field( 'footer_omnes_intro', 'options' );
			if ( ! empty( $intro ) ) {
				?>
				<p class="footer-text">
					<?php echo esc_html( $intro ); ?>
				</p>
				<?php
			}
			?>

			<?php
			$fields = get_field( 'footer_omnes_fields', 'options' );

			if ( ! empty( $fields ) ) {
				?>
				<div class="footer-categories">
					<?php foreach ( $fields as $field ) { ?>
						<div><p><?php echo wp_kses( $field['name'], array( 'br' => array() ) ); ?></p></div>
					<?php } ?>
				</div>
				<?php
			}
			?>

			<?php
			$numbers = get_field( 'footer_omnes_numbers', 'options' );

			if ( ! empty( $numbers ) ) {
				?>
				<div class="footer-numbers">
					<?php foreach ( $numbers as $number ) { ?>
						<div class="footer-numbers-item">
							<p class="item-number"><?php echo esc_html( $number['number'] ); ?></p>
							<p class="item-info"><?php echo wp_kses( $number['body'], array( 'br' => array() ) ); ?></p>
						</div>
					<?php } ?>
				</div>
				<?php
			}
			?>

			<?php
			$omnes_link = get_field( 'footer_omnes_link', 'options' );

			if ( ! empty( $omnes_link['url'] ) ) {
				?>
				<a
					class="btn btn--style-3"
					href="<?php echo esc_url( $omnes_link['url'] ); ?>"
					<?php echo ! empty( $omnes_link['target'] ) ? 'target="_blank" rel="noopener"' : ''; ?>
				>
					<?php echo esc_html( $omnes_link['title'] ); ?>
				</a>
				<?php
			}
			?>
		</div>
	</div>
</footer>
