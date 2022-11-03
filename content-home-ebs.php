<?php
/**
 * Template Name: Home EBS
 *
 * @package WordPress
 * @subpackage CREA
 */

$excluded_articles = array();
$page_id           = get_the_ID();

$descriptions = array(
	array( 'title' => '100% in English' ),
	array( 'title' => 'International program' ),
	array( 'title' => 'Excellent employment records' ),
	array( 'title' => 'Real case workshops with clients' ),
	array( 'title' => 'No teachers, only experts' ),
	array( 'title' => 'Digital and technology' ),
);

get_header();
?>

<div class="home">

	<!-- Intro -->
	<?php
	$intro_image_id        = get_post_meta( $page_id, 'home_intro_image', true );
	$intro_image_mobile_id = get_post_meta( $page_id, 'home_intro_image_mobile', true );
	$intro_title           = get_post_meta( $page_id, 'home_intro_title', true );
	$intro_subtitle        = get_post_meta( $page_id, 'home_intro_subtitle', true );
	?>
	<header class="hero">
		<picture>
			<?php if ( ! empty( $intro_image_mobile_id ) ) { ?>
				<source
					srcset="<?php echo esc_url( cb_image_resize( $intro_image_mobile_id, 992, null, false ) ); ?>"
					media="(max-width: 992px)"
				>
			<?php } ?>

			<?php if ( ! empty( $intro_image_id ) ) : ?>
				<img
					src="<?php echo esc_url( cb_image_resize( $intro_image_id, 1900, 800, true ) ); ?>"
					alt="<?php echo esc_attr( get_image_alt( $intro_image_id ) ); ?>"
					width="1900"
					height="800"
					class="absolute top-0 bottom-0 left-0 right-0 object-cover object-center w-full h-full"
				>
			<?php endif; ?>
		</picture>

		<?php get_template_part( 'template-parts/header-ebs' ); ?>

		<div class="container">
			<div class="row page-meta">
				<div class="col-xs-12 col-md-7">
					<div class="encart-title">
						<?php if ( ! empty( $intro_title ) ) { ?>
							<h1><?php echo esc_html( $intro_title ); ?></h1>
						<?php } ?>

						<?php if ( ! empty( $intro_subtitle ) ) { ?>
							<h2><?php echo esc_html( $intro_subtitle ); ?></h2>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</header>

	<div class="content" id="content">
		<div class="container anchor-container">
			<a href="#content" class="anchor"></a>
		</div>

		<!-- Descriptions -->
		<?php
		$description_title  = get_post_meta( $page_id, 'home_description_title', true );
		$intro_blocks_count = get_post_meta( $page_id, 'home_description_blocks', true );

		if ( $intro_blocks_count ) {
			?>

			<section class="my-18.75 descriptions">
				<div class="container">
					<?php if ( $description_title ) : ?>
					<div class="row">
						<div class="col-xs-12">
							<h2 class="m-0 font-black -tracking-3 text-30 text-grey-60"><?php echo $description_title ?></h2>
						</div>
					</div>
					<?php endif; ?>
					<div class="row lg:px-6.75 js-descriptions mt-7">

					<button type="button" data-role="none" class="absolute top-0 hidden mt-17 sm:block slick-prev js-previous" aria-label="Previous" role="button"></button>
					<button type="button" data-role="none" class="absolute top-0 hidden mt-17 sm:block slick-next js-next" aria-label="Next" role="button"></button>

					<?php for ($i = 0; $i < $intro_blocks_count; $i++) : ?>
						<div class="col-xs-12 col-sm-4 js-slide">
							<article class="relative h-full overflow-hidden text-white rounded bg-ebs-blue-dark pb-216/320">
								<img
									src="<?php echo esc_url( cb_image_resize( get_post_meta( $page_id, 'home_description_blocks_' . $i . '_image', true ), null, null, false ) ); ?>"
									class="absolute w-full h-full object-fit-cover object-position-center"
									alt="<?php echo get_post_meta( $page_id, 'home_description_blocks_' . $i . '_title', true ) ?>"
									width="320"
									height="216"
								/>
							</article>
						</div>
					<?php endfor; ?>
				</div>
			</section>

			<?php
		}
		?>

		<!-- Prochain événement -->
		<?php
		$show_events = get_post_meta( $page_id, 'home_events_show', true );

		if ( (bool) $show_events ) {

			$event_id   = get_post_meta( $page_id, 'home_events_next_id', true );
			$timezone   = new DateTimeZone( wp_timezone_string() );
			$now        = new DateTime( 'now', $timezone );
			$event_date = new DateTime( get_post_meta( $page_id, 'home_events_next_date', true ), $timezone );
			$diff       = $now->diff( $event_date );

			// Uniquement si l'événement est aujourd'hui ou dans le futur.
			if ( $diff->days >= 0 ) {

				$logo_id = get_post_meta( $page_id, 'home_events_next_logo', true );
				?>
				<section class="event">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 ticket-wrapper">

								<div class="ticket">
									<div class="logo">
										<img src="<?php echo esc_url( cb_image_resize( $logo_id, null, null, false ) ); ?>">
									</div>

									<div class="info-event">
										<div class="date">
											<?php echo esc_html( wp_date( 'd F', $event_date->format( 'U' ) ) ); ?>
											<span class="horaires">
												<?php echo esc_html( get_post_meta( $page_id, 'home_events_next_hour', true ) ); ?>
											</span>
										</div>

										<div class="info-event-bis">
											<?php
											echo wp_kses(
												nl2br(
													get_post_meta( $page_id, 'home_events_next_infos', true )
												),
												array(
													'br' => array(),
												)
											);
											?>
										</div>
									</div>

									<div class="clearfix"></div>
								</div>

								<div class="event-cta">
									<div class="title">
										<?php
										echo wp_kses(
											nl2br(
												get_post_meta( $page_id, 'home_events_next_title', true )
											),
											array(
												'br' => array(),
											)
										);
										?>
									</div>
									<div class="countdown">
										<?php if ( 0 === $diff->invert ) { ?>

											<?php esc_html_e( 'Cet événement a lieu', 'crea' ); ?>
											<span class="magenta">
												<?php
												echo $diff->days > 0 ?
												esc_html(
													sprintf(
														// translators: number of days left.
														_n(
															'demain', // phpcs:ignore WordPress.WP.I18n.MissingSingularPlaceholder
															'dans %s jours',
															(int) $diff->days,
															'crea'
														),
														$diff->days
													)
												) :
												esc_html__( 'aujourd\'hui', 'crea' );
												?>
											</span>

										<?php } else { ?>

											<?php esc_html_e( 'Cet événement a déjà eu lieu', 'crea' ); ?>

										<?php } ?>
									</div>

									<?php if ( 0 === $diff->invert ) { ?>
										<a href="<?php echo esc_url( add_query_arg( array( 'id' => $event_id ), get_permalink( get_option( 'options_ebs_page_flow' ) ) ) ); ?>" class="btn flowinfo">
											<?php esc_html_e( 'Inscrivez-vous', 'crea' ); ?>
										</a>
									<?php } ?>
								</div>

							</div>

							<?php
							$next_events = get_field( 'home_events_list', $page_id );

							if ( ! empty( $next_events ) ) :
								?>
								<div class="col-xs-12">
									<div class="row-events">
										<div class="events-title">
											<h3>
												<p>
													<?php esc_html_e( 'Prochaines', 'crea' ); ?>
													<span><?php esc_html_e( 'rencontres', 'crea' ); ?></span>
												</p>
											</h3>
										</div>

										<?php
										foreach ( $next_events as $event_id ) {

											$event_post_type = get_post_type( $event_id );
											if ( 'evenement' === $event_post_type ) {

												$event_date  = new DateTime( get_field( 'date', $event_id, false ), $timezone );
												$event_title = get_the_title( $event_id );

											} else {

												// Si ce n'est pas un événement, on récupère les sessions correspondantes.
												$sessions = find_formation_in_sessions( $event_id, 'array' );
												foreach ( $sessions as $k => $session ) {
													$event_date             = new DateTime( $session['field_571630c2a8ec8'] );
													$diff                   = $event_date->diff( $now );
													$sessions[ $k ]['diff'] = $diff->invert ? 0 - $diff->days : $diff->days;
												}

												// Identification de la session la plus proche dans le futur ou sinon de la plus proche dans le passé.
												$closest = false;
												$key     = 0;
												foreach ( $sessions as $k => $session ) {
													if ( $closest === false ) {
														$closest = $session['diff'];
													}

													if ( $session['diff'] == 0 ) {
														$closest = $session['diff'];
														$key     = $k;
														break;
													}

													if ( $session['diff'] < 0 && $closest < 0 ) {
														if ( $session['diff'] > $closest ) {
															$closest = $session['diff'];
															$key     = $k;
														}
													} elseif ( $session['diff'] < $closest ) {
														$closest = $session['diff'];
														$key     = $k;
													}
												}

												$event_date  = isset( $sessions[ $key ] ) ? new DateTime( $sessions[ $key ]['field_571630c2a8ec8'], $timezone ) : false;
												$event_title = esc_html( get_post_type_object( $event_post_type )->labels->singular_name ) . ' ' . get_the_title( $event_id );

											}

											if ( $event_date ) {
												$diff = $event_date->diff( $now );

												if ( 0 === (int) $diff->days ) {

													$countdown = '<span>' . esc_html__( 'Aujourd\'hui', 'crea' ) . '</span>';

												} elseif ( $diff->invert ) {

													$countdown = sprintf(
														// translators: nb of days.
														_n(
															'<span>Demain</span>',
															'Dans <span>%s jours</span>',
															(int) $diff->days,
															'crea'
														),
														$diff->days
													);

												} else {

													$countdown = sprintf(
														// translators: nb of days.
														_n(
															'<span>Hier</span>',
															'Il y a <span>%s jours</span>',
															(int) $diff->days,
															'crea'
														),
														$diff->days
													);

												}
											}
											?>
											<div class="event-item">
												<a href="<?php echo esc_url( get_permalink( $event_id ) ); ?>">
													<h2><?php echo wp_kses( $event_title, array( 'br' => array() ) ); ?></h2>
													<?php if ( $event_date ) { ?>
														<p class="countdown"><?php echo wp_kses( $countdown, array( 'span' => array() ) ); ?></p>
														<time>
															<?php echo esc_html( _x( 'Le', 'Avant une date', 'crea' ) ); ?> <?php echo esc_html( wp_date( 'd F Y', $event_date->format( 'U' ) ) ); ?>
														</time>
													<?php } ?>
												</a>
											</div>
										<?php } ?>

									</div>
								</div>
								<?php
							endif;
							?>
						</div>
					</div>
				</section>
				<?php
			}
		}
		?>

		<section class="py-18.75 bg-grey-96">
			<!-- Découvrez nos programmes -->
			<?php $formations_ids = get_post_meta( $page_id, 'home_diplomas_all_languages_list', true ); ?>

			<?php
			if ( ! empty( $formations_ids ) ) {

				$formations_title = get_post_meta( $page_id, 'home_diplomas_title', true );
				?>
					<div class="container">
						<?php if ( ! empty( $formations_title ) ) : ?>
							<div class="row">
								<div class="col-xs-12">
									<h2 class="m-0 font-black -tracking-3 text-30 text-grey-60 font-amsipro">
										<?php echo esc_html( $formations_title ); ?>
									</h2>
								</div>
							</div>
						<?php endif ?>

						<div class="mt-12 row sm:flex">
							<?php foreach ( $formations_ids as $key => $formation_id ) : ?>
								<div class="col-xs-12 col-sm-4<?php echo array_key_first( $formations_ids ) === $key ? '' : ' mt-3.5 sm:mt-0'; ?>">
									<?php
									get_template_part(
										'template-parts/card',
										'formation-ebs',
										array(
											'formation_id' => $formation_id,
											'classes'      => 'h-full',
										)
									);
									?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php
			}
			?>

			<!-- Découvrez notre école -->
			<?php
			$videos_title             = get_post_meta( $page_id, 'home_videos_title', true );
			$videos_body              = get_post_meta( $page_id, 'home_videos_body', true );
			$videos_main_video_iframe = get_field( 'home_videos_main_video_embed' );
			$videos_main_video_title  = get_post_meta( $page_id, 'home_videos_main_video_title', true );
			$videos_main_video_body   = get_post_meta( $page_id, 'home_videos_main_video_body', true );
			$videos_sidebar_videos    = get_field( 'home_videos_sidebar_videos' );
			$videos_button            = get_post_meta( $page_id, 'home_videos_button', true );
			?>

			<div class="container mt-18.75">
				<div class="row">
					<div class="col-xs-12">
						<?php if ( ! empty( $videos_title ) ) : ?>
							<h2 class="m-0 font-black -tracking-3 text-30 text-grey-60 font-amsipro">
								<?php echo wp_kses( $videos_title, array( 'strong' => array() ) ); ?>
							</h2>
						<?php endif; ?>

						<?php if ( ! empty( $videos_body ) ) : ?>
							<div class="Wysiwyg text-grey-60 mt-7">
								<?php
								echo wp_kses(
									wpautop( $videos_body ),
									array(
										'br'     => array(),
										'p'      => array(),
										'strong' => array(),
									)
								);
								?>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<div class="row mt-8.75">

					<div class="col-xs-12 col-sm-7">
						<div class="embed-container">
							<?php echo vimeo_lazyloading( $videos_main_video_iframe ); ?>
						</div>

						<?php if ( ! empty( $videos_main_video_title ) ) : ?>
							<h3 class="mb-0 mt-9 text-30 text-ebs-blue-dark"><?php echo esc_html( $videos_main_video_title ); ?></h3>
						<?php endif; ?>

						<?php if ( ! empty( $videos_main_video_body ) ) : ?>
							<p class="mb-0 text-16 text-grey-60 mt-9">
								<?php echo wp_kses( nl2br( $videos_main_video_body ), array( 'br' => array() ) ); ?>
							</p>
						<?php endif ?>
					</div>

					<?php if ( ! empty( $videos_sidebar_videos ) ) : ?>
						<div class="col-xs-12 col-sm-5">
							<?php foreach ( $videos_sidebar_videos as $key => $video_sidebar ) : ?>
								<?php if ( ! empty( $video_sidebar['embed'] ) ) : ?>
									<div class="embed-container<?php echo array_key_first( $videos_sidebar_videos ) === $key ? ' mt-10 sm:mt-0' : ''; ?><?php echo array_key_last( $videos_sidebar_videos ) === $key ? ' mt-10' : ''; ?>">
										<?php echo vimeo_lazyloading( $video_sidebar['embed'] ); ?>
									</div>
								<?php endif; ?>

								<?php if ( ! empty( $video_sidebar['title'] ) ) : ?>
									<h4 class="mb-0 text-20 text-ebs-blue-dark mt-7">
										<?php echo esc_html( $video_sidebar['title'] ); ?>
									</h4>
								<?php endif ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

				</div>

				<?php if ( ! empty( $videos_button['url'] ) ) : ?>
					<div class="mt-8 row">
						<div class="text-center col-xs-12">
							<a
								class="btn button"
								href="<?php echo esc_url( $videos_button['url'] ); ?>"
								<?php echo ! empty( $videos_button['target'] ) ? 'target="_blank" rel="noopener"' : ''; ?>
							>
								<?php echo esc_html( $videos_button['title'] ); ?>
							</a>
						</div>
					</div>
				<?php endif ?>
			</div>
		</section>

		<!-- EBS sur les réseaux -->
		<?php
		$networks = get_field( 'home_networks' );
		?>
		<section class="my-16">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<?php if ( ! empty( $networks['title'] ) ) : ?>
							<h2 class="m-0 font-black -tracking-3 text-30 text-grey-60 font-amsipro"><?php echo esc_html( $networks['title'] ); ?></h2>
						<?php endif ?>
					</div>
				</div>

				<div class="mt-8 mb-12 row">
					<div class="col-xs-12">
						<?php echo do_shortcode( '[instagram-feed]' ); ?>
					</div>
				</div>

				<?php if ( ! empty( $networks['buttons'] ) ) { ?>
					<div class="text-center row">
						<div class="flex flex-wrap justify-center col-xs-12">
							<?php
							foreach ( $networks['buttons'] as $button ) {

								if ( ! empty( $button['button']['url'] ) ) {
									?>
									<a
										class="m-1 btn button"
										href="<?php echo esc_url( $button['button']['url'] ); ?>"
										<?php echo ! empty( $button['button']['target'] ) ? 'target="_blank" rel="noopener"' : ''; ?>
									>
										<?php echo esc_html( $button['button']['title'] ); ?>
									</a>
									<?php
								}
							}
							?>
						</div>
					</div>
				<?php } ?>

			</div>
		</section>

		<!-- Intervenants -->
		<?php get_template_part( 'template-parts/section', 'contributors' ); ?>

		<!-- Programme à l'international -->
		<?php
		$international_title    = get_post_meta( $page_id, 'home_international_texts_title', true );
		$international_body     = get_post_meta( $page_id, 'home_international_texts_body', true );
		$international_button   = get_post_meta( $page_id, 'home_international_texts_button', true );
		$international_image_id = get_post_meta( $page_id, 'home_international_image', true );
		?>
		<section class="my-20">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-6">
						<?php if ( ! empty( $international_title ) ) : ?>
							<h2 class="m-0 font-black -tracking-3 text-30 text-grey-60 font-amsipro">
								<?php
								echo wp_kses(
									nl2br( $international_title ),
									array(
										'strong' => array(),
										'br'     => array(),
									)
								);
								?>
							</h2>
						<?php endif ?>

						<?php if ( ! empty( $international_body ) ) : ?>
							<div class="mt-8 Wysiwyg text-grey-60">
								<?php
								echo wp_kses(
									wpautop( $international_body ),
									array(
										'p'      => array(),
										'br'     => array(),
										'strong' => array(),
									)
								);
								?>
							</div>
						<?php endif ?>

						<?php if ( ! empty( $international_button['url'] ) ) : ?>
							<a
								class="mt-10 button btn"
								href="<?php echo esc_url( $international_button['url'] ); ?>"
								<?php echo ! empty( $international_button['target'] ) ? 'target="_blank" rel="noopener"' : ''; ?>
							>
								<?php echo esc_html( $international_button['title'] ); ?>
							</a>
						<?php endif ?>
					</div>

					<div class="col-xs-12 col-sm-6">

						<?php if ( ! empty( $international_image_id ) ) : ?>
							<img
								src="<?php echo esc_url( cb_image_resize( $international_image_id, 535, 401, true ) ); ?>"
								srcset="<?php echo esc_url( cb_image_resize( $international_image_id, 1070, 802, true ) ); ?> 2x"
								alt="<?php echo esc_attr( get_image_alt( $international_image_id ) ); ?>"
								width="535"
								height="401"
								class="block object-cover object-center w-full h-full"
							/>
						<?php endif ?>
					</div>

				</div>
			</div>
		</section>

	</div>
</div>

<?php get_footer( 'ebs' ); ?>
