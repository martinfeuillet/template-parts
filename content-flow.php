<?php
/**
 * Template name: Flow
 *
 * @package WordPress
 * @subpackage CREA
 */

get_header();

$page_id    = get_the_ID();
$page_theme = get_post_meta( $page_id, 'page_theme', true );
$is_ebs     = ( 'ebs' === $page_theme ? true : false );
$sessions   = get_sessions( true );

// Formation fournie en paramètre
$id = isset( $_REQUEST['id'] ) ? '_' . $_REQUEST['id'] : false;

$current_type = false;

// Home url
if ( $is_ebs ) {
	$home_url = get_option( 'options' . (ICL_LANGUAGE_CODE != 'fr' ? '_en' : '')  . '_ebs_page_home' );
} else {
	$home_url = home_url();
}

// Gestion retour
$back = $home_url;
if ( isset( $_SERVER['HTTP_REFERER'] ) && strpos( $_SERVER['HTTP_REFERER'], home_url() ) === 0 ) {
	$back = $_SERVER['HTTP_REFERER'];
}

// Recherche formation si CREA
if ( !$is_ebs && $id ) {
	foreach ( $sessions as $type => $formations ) {
		foreach ( $formations as $formation_id => $formation ) {
			if ( (int) $id === (int) $formation_id ) {
				$current_type = $type;
				break( 2 );
			}
		}
	}

	$back = get_permalink( str_replace( '_', '', $id ) );
}

?>

<div class="flow-template">
	<header>
		<div class="container">
			<a href="<?php echo esc_url( $back ); ?>">
				<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/breadcrumb_back_arrow_grey.svg" />
				<?php esc_html_e( 'Retour', 'crea' ); ?>
			</a>

			<a href="<?php echo esc_url( $home_url ); ?>">

				<?php if ( $is_ebs ) { ?>

					<img
						src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/ebs-geneve.svg"
						alt=""
						height="73"
						width="248"
					>

				<?php } else { ?>

					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/logo.png"
						srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/logo@2x.png 2x" alt="">

				<?php } ?>

			</a>
		</div>
	</header>

	<main>
		<div class="container">
			<h1>
				<?php esc_html_e( 'Demande d\'informations', 'crea' ); ?>
			</h1>

			<article>
				<?php echo do_shortcode( '[inseec-form type=jpo]' ); ?>
			</article>

			<aside>
				<h3><?php esc_html_e( 'Je souhaite plutôt', 'crea' ); ?></h3>

				<?php
				$email          = $is_ebs ? 'contact@ebs-geneve.com' : 'inscriptions@creageneve.com';
				$messenger_id   = $is_ebs ? 'ebsgeneve' : 'CREA.Geneve';
				$whatsapp_phone = $is_ebs ? '41797356279' : '41791236837';
				$phone          = $is_ebs ? '+41 22 338 15 89' : '+41 22 338 15 80';
				?>
				<div class="card">
					<h3><?php esc_html_e( 'Poser une question à l\'équipe pédagogique', 'crea' ); ?></h3>

					<div class="content">
						<a href="mailto:<?php echo $email; ?>?Subject=Demande d'information&body=Bonjour,%0D%0A%0D%0AJe suis intéressé(e) par une formation ou un événement <?php echo strtoupper( $page_theme ); ?>.">
							<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/open-envelope.svg" alt="<?php esc_html_e( 'Email', 'crea' ); ?>">
						</a>
						<a href="https://m.me/<?php echo $messenger_id; ?>" target="_blank">
							<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/facebook-messenger.svg" alt="<?php esc_html_e( 'Messenger', 'crea' ); ?>">
						</a>
						<a href="https://wa.me/<?php echo $whatsapp_phone; ?>?text=Bonjour%2C%20je%20suis%20int%C3%A9ress%C3%A9(e)%20par%20une%20formation%20ou%20un%20%C3%A9v%C3%A9nement%20<?php echo strtoupper( $page_theme ); ?>." target="_blank">
							<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/whatsapp.svg" alt="<?php esc_html_e( 'Whatsapp', 'crea' ); ?>">
						</a>

						<a href="tel:<?php echo trim( str_replace( ' ', '', $phone ) ); ?>" class="telephone">Tél. <?php echo $phone; ?></a>
					</div>
				</div>

				<div class="card collapse">
					<h3>
						<?php esc_html_e( 'Qu\'on me rappelle gratuitement', 'crea' ); ?>
						<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/next.png">
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
