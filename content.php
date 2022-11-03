<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package CREA
 */

$video = get_field( 'video' );
$header_image = get_field( 'header_image' );

?>

<header>
<?php 
	if ( $header_image ) 
		echo '<img src="' . $header_image . '" class="background-header" />'; 
	else 
		the_post_thumbnail('Header-article', array( 'class'	=> "background-header"));
		
	get_template_part( 'template-parts/header' ) 
?>
</header>

<!-- New Template -->

<div class="article-single">
  <div class="container">
    <div class="breadcrumb">
      <ul>
        <li class="back-blog">
          <a href="<?php echo get_permalink(get_option( 'page_for_posts' )); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/pics/breadcrumb_back_arrow.svg" />
            <?php _e( 'Le blog', 'crea' ) ?>
          </a>
        </li>
      </ul>
    </div>

    <div class="article-container">

      <h1><?php the_title() ?></h1>

      <aside>
        <div class="author-card">
          <figure>
            <?php echo get_avatar( $post->post_author, 96, '', get_the_author() ); ?>
          </figure>

          <p><?php _e( 'Article du', 'crea' ) ?>&nbsp;<time><?php the_time('d/m/Y'); ?></time></p>
          
          <?php $category = crea_get_category(); ?>
          <p><?php _e( 'dans', 'crea' ) ?>&nbsp;<a href="<?php echo get_category_link( $category->term_id ) ?>"><?php echo $category->name ?></a></p>
          
          <p class="reading-time"><?php echo round( str_word_count( strip_shortcodes( strip_tags( get_the_content() ) ) ) / 200 ) ?> min</p>

          <p class="author-name"><?php _e( 'Par', 'crea' ) ?>&nbsp;<a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ) ?>"><?php echo get_the_author(); ?></a></p>
        </div>
		
		<?php if ( !$video ) : ?>
        <div class="featured-pic">
          <img src="<?php echo cb_image_resize( get_post_thumbnail_id(), 460, 460 ) ?>" alt="<?php the_title() ?>">
        </div>
        <?php endif; ?>
      </aside>

      <?php if ( $video ) : ?>
        <p class="embed--responsive">
          <?php echo wp_oembed_get( $video ) ?>
        </p>  
      <?php endif; ?>
      
      <?php the_content(); ?>
    </div>

    <div class="entry-footer">
      <div class="share">
        <?php sharing_tools(); ?>
      </div>

      <h3><?php esc_html_e( 'Découvrez aussi', 'crea' ); ?></h3>

      <div class="related">
        <?php $previous = get_adjacent_post( true ); if ( $previous ) : ?>
        <a href="<?php echo get_permalink( $previous->ID ) ?>" class="previous">
          <img src="<?php echo cb_image_resize( get_post_thumbnail_id( $previous->ID ), 200, 200 ) ?>" alt="<?php echo $previous->post_title ?>">
          <h4><?php echo $previous->post_title ?></h4>
        </a>
        <?php endif; ?>

        <?php $next = get_adjacent_post( true, '', false ); if ( $next ) : ?>
        <a href="<?php echo get_permalink( $next->ID ) ?>" class="next">
          <img src="<?php echo cb_image_resize( get_post_thumbnail_id( $next->ID ), 200, 200 ) ?>" alt="<?php echo $previous->post_title ?>">
          <h4><?php echo $next->post_title ?></h4>
        </a>
        <?php endif; ?>
      </div>
    </div>

    <?php $formations = get_field( 'formations' ); if ( $formations ): ?>
    <div class="formation-related">
      <div class="slider">
        <?php foreach( $formations as $post): setup_postdata($post); ?>
        <div class="crsl-item">
          <a href="<?php the_permalink() ?>">
            <h4><?php the_formation_type( get_post_type() ) ?></h4>
            <h3><?php the_title() ?></h3>
            <p><?php the_field( 'punchline', get_the_id() ) ?></p>
          </a>
        </div>
        <?php 
          endforeach;
          wp_reset_postdata();
        ?>
      </div>
    </div>
    <?php endif; ?>

    <script>
      $(document).ready(function () {
        $('.slider').slick({
          dots: false,
          arrows: false,
          speed: 400,
          slidesToShow: 3,
          slidesToScroll: 1,
          adaptiveHeight: true,
          responsive: [
            {
              breakpoint: 992,
              settings: {
                dots: true,
                slidesToShow: 2,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 768,
              settings: {
                dots: true,
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
          ]
        });
      });
    </script>

    <div class="comments-container">
      <div class="comments-wrapper">
        <?php // If comments are open or we have at least one comment, load up the comment template.
          if ( comments_open() || get_comments_number() ) :
            comments_template();
          endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- End of New Template -->
