<?php
/**
 * Template Name: Registration contract
 * Template utilisé pour vérifier si la requête est bonne et affiche le formulaire correspondant au type de la formation
 *
 * @package WordPress
 * @subpackage Crea
 */

get_header();

if ( empty( $_REQUEST['formation'] ) ) {

	header( 'Location: /' );
	die();
}

$formation_id    = (int) $_REQUEST['formation'];
$formation_type  = get_post_type( $formation_id );
$formation_theme = get_post_meta( $formation_id, 'page_theme', true );
$is_ebs          = ( 'ebs' === $formation_theme ? true : false );
$error_message   = '';

if ( 'formation_continue' === $formation_type ) {

	// Force page to be in french.
	$current_language = apply_filters( 'wpml_current_language', null );
	do_action( 'wpml_switch_language', 'fr' );
}

$background_header_mp4    = get_field( 'background_header_mp4', $formation_id );
$background_header_webm   = get_field( 'background_header_webm', $formation_id );
$background_header_ogg    = get_field( 'background_header_ogg', $formation_id );
$background_header_mobile = get_field( 'background_header_mobile', $formation_id );

// Checking errors.
if ( ! empty( $_REQUEST['error'] ) ) {
	switch ( $_REQUEST['error'] ) {
		case 'missing_value':
			$error_message = __( 'Veuillez remplir les champs obligatoires', 'crea' );
			break;
		case 'not_valid_files':
			$error_message = __( 'Veuillez vérifier vos pièces jointes', 'crea' );
			break;
		case 'email_not_valid':
			$error_message = __( 'Veuillez vérifier les adresses e-mails', 'crea' );
			break;
		case 'bad_files':
			$error_message = __( 'Veuillez vérifier vos fichiers. Nous acceptons uniquement les fichiers inférieurs à 4Mo dans les formats suivants : PDF, PNG, JPEG.', 'crea' );
			break;
		case 'too_old':
			$error_message = __( 'Vous devez avoir 30 maximum pour vous inscrire à un bachelor', 'crea' );
			break;
		default:
			$error_message = __( 'Erreur non identifiée', 'crea' );
	}
}

// Unserialize data.
if ( ! empty( $error_message ) && isset( $_REQUEST['data'] ) ) {
	$data = unserialize( base64_decode( $_REQUEST['data'] ) ); // phpcs:ignore
}
?>

<div class="registration">
	<header>
		<?php if ( $background_header_mp4 || $background_header_webm || $background_header_ogg ) : ?>
			<video width="1920" height="900" autoplay="true" loop class="background-header lazyloading">
				<source data-src="<?php echo esc_url( $background_header_mp4 ); ?>" type="video/mp4" />
				<source data-src="<?php echo esc_url( $background_header_webm ); ?>" type="video/webm" />
				<source data-src="<?php echo esc_url( $background_header_ogg ); ?>" type="video/ogg" />
			</video>
		<?php else : ?>
			<?php the_post_thumbnail( 'full', array( 'class' => 'background-header' ) ); ?>
		<?php endif; ?>

		<?php if ( $background_header_mobile ) : ?>
			<picture>
				<source media="(min-width: 992px)" sizes="1px" srcset="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7 1w" />
				<img src="<?php echo esc_url( $background_header_mobile['url'] ); ?>" class="background-header-mobile" />
			</picture>
		<?php endif; ?>

		<?php
		if ( $is_ebs ) {
			get_template_part( 'template-parts/header-ebs' );
		} else {
			get_template_part( 'template-parts/header' );
		}
		?>

		<div class="container">
			<div class="row page-meta">
				<div class="col-xs-12 col-md-7">
					<div class="encart-title">
						<h1><?php the_title(); ?></h1>
					</div>
				</div>
			</div>
		</div>
	</header>
	<div class="flow-template">
		<main>
			<?php
			// Get city of formation.
			// only used when a formation takes place in several cities.
			$formation_groupement = get_groupement( $formation_id );
			$formation_city       = '';
			if ( ! empty( $formation_groupement ) ) :
				foreach ( $formation_groupement['formations'] as $other_formations ) :
					if ( (int) $other_formations['formation']->ID === (int) $formation_id ) {
						$formation_city = ' ' . ucfirst( esc_html( $other_formations['label'] ) );
					}
				endforeach;
			endif;
			?>

			<h3>
				<?php
				echo sprintf(
					// translators: diploma name.
					esc_html__( 'Merci de bien vouloir remplir tous les champs obligatoires de votre contrat d\'admission %s', 'crea' ),
					'<br>' .
					esc_html(
						get_post_type_object(
							get_post_type( $formation_id )
						)->labels->singular_name
					) .
					' ' .
					esc_html( get_the_title( $formation_id ) ) .
					esc_html( $formation_city )
				);
				?>
			</h3>

			<?php
			$intro_extra = get_post_meta( $formation_id, 'cc_registration_intro_extra', true );
			if ( ! empty( $intro_extra ) ) {
				?>
				<p class="intro__extra"><?php echo esc_html( $intro_extra ); ?></p>
				<?php
			}
			?>

			<?php
			if ( ! empty( $error_message ) ) {
				?>
				<h3 class="error"><?php echo esc_html( $error_message ); ?></h3>
				<?php
			}
			?>

			<div class="container">
				<article class="full-width">
					<?php
					if ( 'bachelor' === $formation_type ) {

						get_template_part( 'template-parts/registration/forms/bachelor' );

					} elseif ( 'master' === $formation_type ) {

						get_template_part( 'template-parts/registration/forms/master' );

					} elseif (
						'formation_continue' === $formation_type ||
						'brevet_federal' === $formation_type ||
						'certificat' === $formation_type
					) {

						get_template_part( 'template-parts/registration/forms/formation_continue' );

					} else {

						esc_html_e( 'Formulaire indisponible', 'crea' );

					}
					?>
				</article>
			</div>
		</main>
	</div>
</div>
<?php

if ( 'formation_continue' === $formation_type ) {

	// Switch back to original language.
	do_action( 'wpml_switch_language', $current_language );
}

if ( $is_ebs ) {
	get_footer( 'ebs' );
} else {
	get_footer();
}
?>
