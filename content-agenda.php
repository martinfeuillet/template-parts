<?php 
/*
Template Name: Agenda
*/
 
get_header(); 

$sessions = get_field( 'sessions', 'option', false );

$dates = $places = $order = array(); $i = 0;
if ( $sessions )
{
	foreach ( $sessions as $k => $session )
	{
		// Ne pas faire apparaitre sur l'agenda?
		if ( ! $session['field_5a282b7042c9f'] ) 
			unset( $sessions[$k] );
		else
		{
			// Date dépassée?
			if ( $session['field_571630c2a8ec8'] < date( 'Ymd' ) )
				unset( $sessions[$k] );
			else
			{
				$order[$k] = $sessions[$k]['order'] = $i;
				$dates[$k] = $session['field_571630c2a8ec8'];

				$places[ strip_tags( trim( $session['field_571630eaa8ec9'] ) ) ] = 1;

				$i++;
			}
		}
	}
}

array_multisort( $dates, SORT_ASC, $order, SORT_ASC, $sessions );

?>

<div class="agenda">
  <header>
    <?php get_template_part( 'template-parts/header' ) ?>
  </header>

  <div class="container">
    <div class="head-group">
      <h1><?php the_title(); ?></h1>

      <div class="filter">
        <select>
          <option value=""><?php _e( 'Lieu : Tout', 'crea' ) ?></option>	      
	      <?php if ( $places ) foreach ( array_keys( $places ) as $place ) echo '<option value=".' . sanitize_title( $place ) . '">' . $place . '</option>' . PHP_EOL; ?>
        </select>

        <select>
          <option value=""><?php _e( 'Type : Tout', 'crea' ) ?></option>
          <option value=".item--green"><?php _e( 'Type : Séance d\'informations', 'crea' ) ?></option>
          <option value=".item--blue"><?php _e( 'Type : Acheter', 'crea' ) ?></option>
          <option value=".item--yellow"><?php _e( 'Type : Événements', 'crea' ) ?></option>
        </select>
      </div>
    </div>

    
    <div class="wrapper">
      <div class="agenda-container">
	    
	    <?php
		    $month = 0; $hide_button = false;
			if ( $sessions ) : foreach ( $sessions as $session ) :
			
		    	$post_id = $session['field_57163c2dbd6a9'];
		    	$date_timestamp = strtotime( $session['field_571630c2a8ec8'] );
		    	
		    	if ( $month != date( 'm', $date_timestamp ) )
		    	{
			    	echo '<div class="month">' . date_i18n( 'F', $date_timestamp ) . '</div>' . PHP_EOL;
			    	$month = date( 'm', $date_timestamp );
		    	}
		    	
		    	$item_class = 'item--green'; 
		    	$cta = __( 'Inscription', 'crea' );
		    	$link = '#';

		    	if ( ( $product_id = get_field( 'product', $post_id ) ) && $session['field_5a71f9e132a04'] )
			    {
			    	$item_class = 'item--blue';
			    	$cta = __( 'Acheter', 'crea' );
			    	$link = add_query_arg( 'add-to-cart', $product_id, get_permalink() );
			    	
			    	$_product = wc_get_product( $product_id );
			    	
			    	if ( $_product->get_stock_status() != 'instock' )
			    		$hide_button = true;
			    }
			    elseif ( has_category( EVENTS_CATEGORY_ID, $post_id ) || get_field( 'register_button_url', $post_id ) )
			    {
			    	$item_class = 'item--yellow';
			    	$cta = __( 'S\'inscrire', 'crea' );
			    }
	    ?>
        <div class="agenda-item <?php echo $item_class ?> <?php echo sanitize_title( strip_tags( $session['field_571630eaa8ec9'] ) ) ?>">
          <div class="pic-container">
            <figure>
              <a href="<?php echo get_permalink( $post_id ) ?>">
              	<?php if ( $image_agenda = get_field( 'image_agenda', $post_id ) ) : ?>
              	<img src="<?php echo cb_image_resize( $image_agenda['ID'], 310, 180 ) ?>" alt="<?php echo get_the_title( $post_id ) ?>">
              	<?php elseif ( get_post_thumbnail_id( $post_id ) ) : ?>
              	<img src="<?php echo cb_image_resize( get_post_thumbnail_id( $post_id ), 310, 180 ) ?>" alt="<?php echo get_the_title( $post_id ) ?>">
              	<?php else : ?>
              	<img src="<?php echo get_template_directory_uri() ?>/assets/pics/portes-ouvertes.jpg" alt="<?php echo get_the_title( $post_id ) ?>" />
              	<?php endif; ?>
              </a>
            </figure>
          </div>

          <main>
            <h2><a href="<?php echo get_permalink( $post_id ) ?>"><?php echo $session['field_5a2feff4f590c'] ? $session['field_5a2feff4f590c'] : get_the_title( $post_id ) ?></a></h2>

            <div class="metas">
              <div class="place"><?php _ex( 'à', 'Lieu événement', 'crea' ) ?> <?php echo $session['field_571630eaa8ec9'] ?></div>
              <div class="time">
                <?php _ex( 'Le', 'Date', 'crea' ) ?> <time datetime="<?php echo date_i18n( 'Y-m-d', $date_timestamp ) ?>">
                	<?php echo date_i18n( 'd F Y', $date_timestamp ) . ', ' . $session['field_57163105a8eca'] . ' - ' . $session['field_57163126a8ecb'] ?>
                </time>
              </div>
            </div>
          </main>

          <footer>

			<?php if ( $item_class == 'item--blue' ) echo '<div class="price">' . wc_price( $_product->get_price() ) . '</div>' ?>

			<?php if( $post_id == apply_filters( 'wpml_object_id', 9980, 'evenement' ) ): ?>
			<a href="https://www.eventbrite.fr/e/billets-crea-digital-day-10eme-edition-53094498073" target="_blank" class="cta"><?php echo $cta ?></a>
			<?php elseif( $post_id == apply_filters( 'wpml_object_id', 5030, 'evenement' ) ): ?>
			<a href="http://www.creadigitalday.com/" target="_blank" class="cta"><?php echo $cta ?></a>
			<?php elseif( $post_id == 4886 ): ?>
			<a href="https://reg.unog.ch/event/22352/" target="_blank" class="cta"><?php echo $cta ?></a>            
			<?php elseif( !get_field( 'hide_register_button', $post_id ) && $register_button_url = get_field( 'register_button_url', $post_id ) ): ?>
			<a href="<?php echo $register_button_url ?>" target="_blank" class="cta"><?php _e( 'Inscription', 'crea' ) ?></a>
			<?php elseif ( $item_class != 'item--blue' ) : ?>
			<a href="<?php echo add_query_arg( array( 'id' => $post_id ), get_permalink( FLOW_PAGE_ID ) ) ?>" class="cta flowinfo"><?php echo $cta ?></a>
			<?php elseif ( !$hide_button ): ?>
			<a href="<?php echo $link ?>" class="cta" data-code="<?php the_field( 'code', $post_id ) ?>"><?php echo $cta ?></a>
			<?php endif; ?>

          </footer>
        </div>
        <?php endforeach; endif; ?>

      </div>

      <aside>
	    <?php if ( ( $promo_title = get_field( 'promo_title' ) ) && ( $_product = wc_get_product( get_field( 'promo_product' ) ) ) && $_product->get_stock_status() == 'instock' ) : ?>
        <div class="push-product">
          <h3><?php echo $promo_title ?></h3>
          <div class="price">
            <span class="now">CHF <?php echo $_product->get_price() ?></span>
            <?php if ( $_product->get_sale_price() ) : ?><strike class="old">CHF <?php echo $_product->get_regular_price() ?></strike><?php endif; ?>
          </div>

          <footer>
            <a href="<?php echo add_query_arg( array( 'add-to-cart' => get_field( 'promo_product' ), 'quantity' => get_field( 'promo_quantity' ) ), get_permalink() ) ?>" class="btn">
              <i class="icon-cart"></i>
              <span><?php _e( 'Acheter', 'crea' ) ?></span>
            </a>
          </footer>
        </div>
        <?php endif; ?>

        <div class="facebook">
          <a href="<?php the_field( 'facebook', 'option' ) ?>" target="_blank" class="content">
            <h3><?php _e( 'Rejoignez CREA sur Facebook', 'crea' ) ?></h3>
          </a>
        </div>
      </aside>
    </div>
  </div>
</div>

<?php get_footer(); ?>
