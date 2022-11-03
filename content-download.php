<?php
/**
 * Template Name: Download
 *
 * @package WordPress
 * @subpackage CREA
 */

get_header();

// Formation fournie en paramètre.
$formation_id = isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : false; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
$formation    = get_post( $formation_id );

if ( ! $formation ) {
	wp_safe_redirect( home_url() );
	exit;
}

// Gestion retour.
$back = home_url();
if ( isset( $_SERVER['HTTP_REFERER'] ) && 0 === strpos( $_SERVER['HTTP_REFERER'], home_url() ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$back = $_SERVER['HTTP_REFERER']; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
}

// Recherche formation.
if ( $formation_id ) {
	$back = get_permalink( str_replace( '_', '', $formation_id ) );
}

?>

<div class="flow-template">
	<header>
		<div class="container">
			<a href="<?php echo esc_url( $back ); ?>">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/pics/breadcrumb_back_arrow_grey.svg' ); ?>" />
				<?php esc_html_e( 'Retour', 'crea' ); ?>
			</a>

			<a href="<?php echo esc_url( get_home_url() ); ?>">
				<img
					src="<?php echo esc_url( get_template_directory_uri() . '/assets/pics/logo.png' ); ?>"
					srcset="<?php echo esc_url( get_template_directory_uri() . '/assets/pics/logo@2x.png 2x' ); ?>"
					alt=""
				>
			</a>
		</div>
	</header>


	<main>
		<div class="container">
			<h1><?php esc_html_e( 'Télécharger la brochure', 'crea' ); ?></h1>

			<article><?php echo do_shortcode( '[inseec-form type=documentation]' ); ?></article>

			<aside>
				<h3><?php esc_html_e( 'Je souhaite plutôt', 'crea' ); ?></h3>

				<div class="card">
					<h3><?php esc_html_e( 'Poser une question à l\'équipe pédagogique', 'crea' ); ?></h3>

					<div class="content">
						<a href="mailto:inscriptions@creageneve.com?Subject=Demande d'information&body=Bonjour,%0D%0A%0D%0AJe suis intéressé(e) par une formation ou un événement CREA.">
							<img
								src="<?php echo esc_url( get_template_directory_uri() . '/assets/pics/open-envelope.svg' ); ?>"
								alt="<?php esc_attr_e( 'Email', 'crea' ); ?>"
							>
						</a>
						<a href="https://m.me/CREA.Geneve" target="_blank">
							<img
								src="<?php echo esc_url( get_template_directory_uri() . '/assets/pics/facebook-messenger.svg' ); ?>"
								alt="<?php esc_attr_e( 'Messenger', 'crea' ); ?>"
							>
						</a>
						<a
							href="https://wa.me/41797356276?text=Bonjour%2C%20je%20suis%20int%C3%A9ress%C3%A9(e)%20par%20une%20formation%20ou%20un%20%C3%A9v%C3%A9nement%20CREA."
							target="_blank"
						>
							<img
								src="<?php echo esc_url( get_template_directory_uri() . '/assets/pics/whatsapp.svg' ); ?>"
								alt="<?php esc_attr_e( 'Whatsapp', 'crea' ); ?>"
							>
						</a>

						<a href="tel:+41223381580" class="telephone">Tél. +41 22 338 15 80</a>
					</div>
				</div>

				<div class="card collapse">
					<h3>
						<?php esc_html_e( 'Qu\'on me rappelle gratuitement', 'crea' ); ?>
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/pics/next.png' ); ?>">
					</h3>

					<div class="content">
						<?php echo do_shortcode( '[inseec-form type=rappel]' ); ?>
					</div>
				</div>
			</aside>
		</div>
	</main>
</div>

<div class="loader">
	<div class="loader-element"></div>
	<p><?php esc_html_e( 'Veuillez patienter...', 'crea' ); ?></p>
</div>

<?php get_footer(); ?>
