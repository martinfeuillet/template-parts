<?php
/**
 * Contributors section
 *
 * @package WordPress
 * @subpackage CREA
 */

$contributors = get_field( 'ebs_contributors_list', 'options' );

if ( ! empty( $contributors ) ) {

	$contributors_title = get_option( 'options' . (ICL_LANGUAGE_CODE != 'fr' ? '_en' : '')  . '_ebs_contributors_title' );
	?>
	<section class="py-14 bg-grey-96 contributors">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<?php if ( ! empty( $contributors_title ) ) : ?>
						<h2 class="m-0 font-black -tracking-3 text-30 text-grey-60">
							<?php echo wp_kses( $contributors_title, array( 'strong' => array() ) ); ?>
						</h2>
					<?php endif ?>
				</div>
			</div>

			<div class="relative row mt-7 js-contributors lg:px-6.75">

				<button type="button" data-role="none" class="absolute top-0 hidden sm:block mt-22 slick-prev js-previous" aria-label="Previous" role="button"></button>
				<button type="button" data-role="none" class="absolute top-0 hidden sm:block mt-22 slick-next js-next" aria-label="Next" role="button"></button>

				<?php
				foreach ( $contributors as $contributor ) {

					$contributor_image_id = isset( $contributor['image'] ) ? $contributor['image'] : '';
					$contributor_name     = isset( $contributor['name'] ) ? $contributor['name'] : '';
					$contributor_topic    = isset( $contributor['topic'] ) ? $contributor['topic'] : '';
					$contributor_linkedin = isset( $contributor['linkedin'] ) ? $contributor['linkedin'] : '';
					?>
					<div class="col-xs-12 col-sm-2 js-slide">
						<div>
							<?php echo ! empty( $contributor_linkedin ) ? '<a class="relative block pb-full bg-grey-75" href="' . esc_url( $contributor_linkedin ) . '">' : '<div class="relative pb-full bg-grey-75">'; ?>
								<?php if ( ! empty( $contributor_image_id ) ) : ?>
									<img
										src="<?php echo esc_url( cb_image_resize( $contributor_image_id, 180, 180, true ) ); ?>"
										srcset="<?php echo esc_url( cb_image_resize( $contributor_image_id, 360, 360, true ) ); ?> 2x"
										alt="<?php echo esc_attr( get_image_alt( $contributor_image_id ) ); ?>"
										width="180"
										height="180"
										class="absolute top-0 bottom-0 left-0 right-0 w-full h-full"
									/>
								<?php endif ?>
							<?php echo ! empty( $contributor_linkedin ) ? '</a>' : '</div>'; ?>

							<div class="mt-3.5">
								<div class="flex items-start justify-between">
									<?php if ( ! empty( $contributor_name ) ) : ?>
										<h3 class="my-0 text-ebs-blue-dark text-18 font-amsipro">
											<?php echo ! empty( $contributor_linkedin ) ? '<a class="no-underline text-ebs-blue-dark" href="' . esc_url( $contributor_linkedin ) . '">' : ''; ?>
											<?php echo esc_html( $contributor_name ); ?>
											<?php echo ! empty( $contributor_linkedin ) ? '</a>' : ''; ?>
										</h3>
									<?php endif ?>

									<?php if ( ! empty( $contributor_linkedin ) ) { ?>
										<a class="block ml-1" href="<?php echo esc_url( $contributor_linkedin ); ?>" target="_blank" rel="noopener nofollow">
											<img class="block" src="<?php echo get_template_directory_uri() . '/assets/pics/linkedin-ebs.svg'; ?>" alt="">
										</a>
									<?php } ?>
								</div>
							</div>

							<?php if ( ! empty( $contributor_topic ) ) : ?>
								<p class="mt-2 mb-0 text-14 -tracking-3"><?php echo esc_html( $contributor_topic ); ?></p>
							<?php endif ?>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</section>
	<?php
}
?>
