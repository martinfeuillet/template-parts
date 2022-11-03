<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package CREA
 */
?>

<div class="grid-item twitter category-twitter">
	<a href="https://twitter.com/CREA_Geneve/status/<?php the_title() ?>" target="_blank" class="content">
		<h3><?php _e( 'CREA sur Twitter', 'crea' ) ?></h3>
		<span class="tweet-content">
			<?php echo $post->post_content ?> 
		</span>
		<span class="account">@CREA_Geneve</span>
		<span class="date"><?php the_time( 'd M Y' ) ?></span>
		<span class="more"></span>
	</a>
</div>
