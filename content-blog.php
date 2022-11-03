<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package CREA
 */

?>

<div class="grid-item category-news">
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <a href="<?php the_permalink(); ?>">
      <figure>
        <img src="<?php echo cb_image_resize( get_post_thumbnail_id(), 460, 305 ) ?>" alt="<?php the_title() ?>">
      </figure>

      <div class="entry-content">
        <h3><?php the_title(); ?></h3>
        <p>
          <span class="date"><time datetime="<?php the_time( 'Y-m-d' ) ?>"><?php the_time( 'd.m.Y' ) ?></time></span>
          <?php echo get_the_excerpt(); ?>
        </p>
        
      </div><!-- .entry-content -->

      <div class="entry-footer">
        <span class="more"></span>
      </div><!-- .entry-footer -->
    </a>
  </article><!-- #post-## -->
</div>

