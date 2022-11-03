<?php
/*
Template Name: Thank you
*/

use function Wow\Crea\Ebs\is_ebs;

?>

<?php get_header(); ?>

<div class="thankyou">
  <header>
    <?php the_post_thumbnail('full', array( 'class' => "background-header")); ?>

    <?php get_template_part( 'template-parts/header' . (is_ebs() ? '-ebs' : '') ) ?>

    <div class="container">
      <div class="row page-meta">
        <div class="col-xs-12 col-md-7">
          <div class="encart-title">
            <h1><?php _e( 'Merci !', 'crea' ) ?></h1>
          </div>
        </div>
      </div>
    </div>
  </header>

  <?php

	if (isset($_REQUEST['event']))
	{
		list( $event_type, $event_id ) = explode( '#_', $_REQUEST['event'] );
		$download = false;
	}
	else
	{
		$event_id = $_REQUEST['id'];
		$download = true;
	}

  $download = ($_REQUEST['type'] == 'documentation');

	$event = get_post( (int)$event_id );
	$formation = $event->post_title;
	switch( $event->post_type )
	{
		case 'bachelor': $formation = 'Bachelor ' . $formation; break;
		case 'master': $formation = 'Master ' . $formation; break;
		case 'formation_continue': $formation = 'Formation ' . $formation; break;
		case 'evenement': $formation = get_the_category( $event )[0]->name . ' ' . $formation; break;
	}

	if (!$download)
	{
		$session = find_formation_in_sessions( $event->ID );
		if ( $session )
			$event_date = new DateTime( $session['field_571630c2a8ec8'] );
		else
			$event_date = new DateTime( get_field( 'date', $event->ID ) );
	}

  ?>
  <div class="content" id="content">
    <div class="container">
      <div class="col-xs-12 col-md-8">
        <div class="wysiwyg-content">
          <?php
	          if (!$download)
	          {
			  	the_content();
			  }
			  else
			  {
				  echo '<p>' . __('Votre demande a bien été prise en compte.', 'crea' ) . '</p>' .
				  	   '<p>' . __('Vous pouvez télécharger la brochure en cliquant sur le bouton ci-dessous :', 'crea' ) . '</p>' .
				  	   '<p class="green"><a href="' . get_field('leaflet_pdf',  $event->ID ) . '" class="btn pdf" target="_blank">' . __('Télécharger la brochure', 'crea') . '</a></p>' .
				  	   '<p>' . __('N\'hésitez pas à consulter les dates de nos prochaines séances d\'info et portes ouvertes dans la section agenda du site.', 'crea' ) . '</p>';
			  }
          ?>
        </div>

        <a href="<?php echo home_url() ?>" class="btn"><?php _e( 'Retour à l\'accueil', 'crea' ) ?></a>
        <a href="<?php echo get_permalink( $event->ID ) ?>" class="btn">
	        <?php echo $event->post_type == 'evenement' ? __( 'Aller à l\'événement', 'crea' ) : __( 'Aller à la formation', 'crea' ) ?>
	    </a>
      </div>

      <div class="col-xs-12 col-md-4 your-infos">
        <h2><?php _e( 'Vos informations', 'crea' ) ?> :</h2>
        <div class="info-item">
          <span class="info-title"><?php _e( 'Prénom', 'crea' ) ?> :</span>
          <span class="info-content"><?php echo $_REQUEST['fname'] ?></span>
        </div>
        <div class="info-item">
          <span class="info-title"><?php _e( 'Nom', 'crea' ) ?> :</span>
          <span class="info-content"><?php echo $_REQUEST['lname'] ?></span>
        </div>

        <?php if ( isset( $_REQUEST['company_function'] ) && $_REQUEST['company_function'] != '' ) : ?>
        <div class="info-item">
          <span class="info-title"><?php _e( 'Entreprise - Fonction', 'crea' ) ?> :</span>
          <span class="info-content"><?php echo $_REQUEST['company_function'] ?></span>
        </div>
        <?php endif; ?>

        <?php if ( isset( $_REQUEST['address'] ) && $_REQUEST['address'] != '' ) : ?>
        <div class="info-item">
          <span class="info-title"><?php _e( 'Adresse', 'crea' ) ?> :</span>
          <span class="info-content"><?php echo $_REQUEST['address'] ?></span>
        </div>
        <?php endif; ?>

        <div class="info-item">
          <span class="info-title"><?php _e( 'E-mail', 'crea' ) ?> :</span>
          <span class="info-content"><?php echo $_REQUEST['email'] ?></span>
        </div>
        <?php
	    // Nettoyage du numéro de téléphone
		$tel = preg_replace( '/[^+0-9]/', '', $_REQUEST['tel'] );

		if ( isset( $_REQUEST['country_code'] ) )
		{
			$tel = preg_replace( '/^(0|' . $_REQUEST['country_code'] . '|\+)+/', '', $tel );
			$tel = '+' . $_REQUEST['country_code'] . $tel;
		}
		?>
        <div class="info-item">
          <span class="info-title"><?php _e( 'Téléphone', 'crea' ) ?> :</span>
          <span class="info-content"><?php echo $tel ?></span>
        </div>
        <div class="info-item">
          <span class="info-title"><?php echo $event->post_type == 'evenement' ? __( 'Evénement', 'crea' ) : __( 'Formation', 'crea' ) ?> :</span>
          <span class="info-content"><?php echo $formation ?></span>
        </div>
        <?php
	        if (isset($_REQUEST['session']) && strpos( $_REQUEST['session'], '#' ) !== false ) :
		        list( $session_date, $session_start, $session_end, $session_place ) = explode( '#', $_REQUEST['session'] );
		?>
        <div class="info-item">
          <span class="info-title"><?php _e( 'Date', 'crea' ) ?> :</span>
          <span class="info-content"><?php echo stripslashes(stripslashes($session_date)) . ' ' . __( 'de', 'crea' ) . ' ' . $session_start . ' ' . __( 'à', 'crea' ) . ' ' . $session_end ?></span>
        </div>
        <div class="info-item">
          <span class="info-title"><?php _e( 'Lieu', 'crea' ) ?> :</span>
          <span class="info-content"><?php echo $session_place ?></span>
        </div>
        <?php elseif (isset($_REQUEST['session'])) : ?>
        <div class="info-item">
          <span class="info-title"><?php _e( 'Date', 'crea' ) ?> :</span>
          <span class="info-content"><?php echo $_REQUEST['session'] ? $_REQUEST['session'] : $event_date->format( 'd/m/Y' ) ?></span>
        </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>
 
<script>
  window.dataLayer = window.dataLayer || [];
  dataLayer.push({'event': '<?php echo strtolower($_REQUEST['type'] . '_' . get_post_meta($event->ID, 'code', true)) ?>' });
</script>

<?php get_footer(is_ebs() ? 'ebs' : ''); ?>
