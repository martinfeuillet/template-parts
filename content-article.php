<?php $category = crea_get_category(); ?>
<div <?php post_class( 'grid-item' ) ?> data-category="<?php echo $category->name ?>">
    <article>
      <a href="<?php the_permalink() ?>">
        <figure class="featured-pic">
          <img src="<?php echo cb_image_resize( get_post_thumbnail_id(), 350, 350 ) ?>" alt="<?php the_title() ?>">
        </figure>
      </a>

      <div class="item-content">
        <h2>
          <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
        </h2>

        <footer class="metas">
          <figure>
            <?php echo get_avatar( get_the_author_meta('ID'), 96, '', get_the_author() ) ?>
          </figure>

          <p class="date"><?php _e( 'Article du', 'crea' ) ?>&nbsp;<time datetime="<?php the_time( 'Y-m-d' ) ?>"><?php the_time( 'd.m.Y' ) ?></time></p>
          <p class="author"><?php _e( 'par', 'crea' ) ?>&nbsp;<a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ) ?>"><?php echo get_the_author(); ?></a></p>
        </footer>
      </div>

      <a href="<?php echo get_category_link( $category->term_id ) ?>" class="categ"><?php echo $category->name ?></a>
    </article>
</div>
