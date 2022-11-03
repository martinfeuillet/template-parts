<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package CREA
 */
?>

<div class="grid-item instagram category-instagram">
	<a href="https://www.instagram.com/p/<?php the_title() ?>/" target="_blank" class="content">
		<?php the_post_thumbnail( 'full' ) ?>
		<span class="more"></span>
	</a>
</div>
