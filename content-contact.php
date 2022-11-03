<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package CREA
 */

?>

<?php
/*
Template Name: Contact
*/
?>

<?php get_header(); ?>

<div class="contact">
  <header>
	<?php the_post_thumbnail('Header-article', array( 'class' => "background-header")); ?>

	<?php get_template_part( 'template-parts/header' ) ?>

	<div class="container">
	  <div class="row page-meta">
		<div class="col-xs-12 col-md-7">
		  <div class="encart-title">
			<h1><?php the_title() ?></h1>
		  </div>
		</div>
	  </div>
	</div>
  </header>

  <div class="map-container">
	<?php
	$adresses = get_field( 'contact_addresses' );

	if (
		! empty( $adresses ) &&
		is_array( $adresses )
	) {
		?>
		<div class="address">
			<?php foreach ( $adresses as $address ) { ?>

				<div class="col-md-6">
					<?php if ( ! empty( $address['title'] ) ) { ?>
						<h4><?php echo esc_html( $address['title'] ); ?></h4>
					<?php } ?>

					<?php
					if ( ! empty( $address['body'] ) ) {
						echo wp_kses_post( wpautop( $address['body'] ) );
					}
					?>
				</div>

			<?php } ?>
		</div>
		<?php
	}
	?>

	<div id="map" data-lat="46.19120708458086" data-long="6.130568906664848" data-zoom="10" data-scroll="false" data-icon="<?php echo get_template_directory_uri(); ?>/assets/pics/gmap-icon.png"></div>

  </div>

  <div class="content" id="content">
	<div class="container">
	  <div class="col-xs-12 col-md-8 wysiwyg-content">
		<h1><?php _e( 'Formulaire de contact', 'crea' ) ?></h1>
		<?php if (have_posts()) : ?>
		  <?php while (have_posts()) : the_post(); ?>
			<?php the_content(); ?>
		  <?php endwhile; ?>
		<?php endif; ?>
	  </div>

	  <div class="hide-mobile col-xs-12 col-md-4">
		<div class="info-cat">
		  <h3><?php _e( 'Vous souhaitez recruter un étudiant CREA pour un stage ou un emploi ?', 'crea' ) ?></h3>
		  <?php the_field( 'contact_text', 'option' ) ?>
		  <a style="color:#0093b9; text-decoration:none;" href="http://www.creageneve-jobs.com" target="_blank"><?php _e( '>> Déposez votre annonce', 'crea' ) ?></a>
		</div>
	  </div>
	</div>
  </div>

  <div class="hide-mobile pre-footer">
	<div class="container">
	  <div class="col-xs-12 col-md-4">
		<div class="facebook-block">
		  <a href="<?php the_field( 'facebook', 'option' ) ?>" target="_blank" class="content-block">
			<h3><?php _e( 'Rejoignez CREA<br /> sur Facebook', 'crea' ) ?></h3>
			<span class="like"></span>
		  </a>
		</div>
	  </div>

	  <div class="col-xs-12 col-md-4">
		<div class="twitter-block">
		  <a href="<?php the_field( 'twitter', 'option' ) ?>" target="_blank" class="content-block">
			<h3><?php _e( 'CREA<br /> sur Twitter', 'crea' ) ?></h3>
			<span class="more"></span>
		  </a>
		</div>
	  </div>

	  <div class="col-xs-12 col-md-4">
		<div class="instagram-block">
		  <a href="<?php the_field( 'instagram', 'option' ) ?>" target="_blank" class="content-block">
			<h3><?php _e( 'CREA<br /> sur Instagram', 'crea' ) ?></h3>
			<span class="more"></span>
		  </a>
		</div>
	  </div>
	</div>
  </div>
</div>

<?php get_footer(); ?>
