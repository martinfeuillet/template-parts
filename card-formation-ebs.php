<?php
/**
 * Formation EBS card
 *
 * @package WordPress
 * @subpackage CREA
 */

$formation_id = isset( $args['formation_id'] ) ? (int) $args['formation_id'] : '';

if ( ! empty( $formation_id ) ) {

	$formation_type                    = get_post_type( $formation_id );
	$formation_language_data           = apply_filters( 'wpml_post_language_details', null, $formation_id );
	$formation_permalink               = get_permalink( $formation_id );
	$formation_permalink_post_language = ! is_wp_error( $formation_language_data ) && isset( $formation_language_data['language_code'] ) ? apply_filters( 'wpml_permalink', $formation_permalink, $formation_language_data['language_code'] ) : $formation_permalink;
	$formation_view_label              = get_field( 'ebs_view_formation', 'options' );
	?>

	<div class="relative overflow-hidden text-white rounded card-formation-ebs bg-ebs-blue-dark p-7 <?php echo ! is_wp_error( $formation_language_data ) && isset( $args['classes'] ) ? $args['classes'] : ''; ?>">
		<?php if ( isset( $formation_language_data['display_name'] ) ) : ?>
			<p class="m-0">
				<?php echo esc_html( get_post_type_object( $formation_type )->labels->singular_name ); ?>
			</p>
		<?php endif; ?>

		<h3 class="m-0 font-black uppercase text-20"><?php echo esc_html( get_the_title( $formation_id ) ); ?></h3>

		<footer class="text-right mt-9 cta">
			<p class="text-white">
				<?php echo esc_html( $formation_view_label ); ?>
			</p>
		</footer>

		<a class="absolute top-0 bottom-0 left-0 right-0" href="<?php echo esc_url( $formation_permalink_post_language ); ?>" aria-label="<?php the_title(); ?>"></a>
	</div>

	<?php
}
