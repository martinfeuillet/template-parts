<?php
/*
Template Name: Home
*/

$excluded_articles = array();
$page_id = get_the_ID();

get_header();

?>

<div class="home">
	<header>
	<?php
		$videos = get_field( 'background_videos', 'option' );
	if ( is_array( $videos ) && count( $videos ) ) :
		foreach ( $videos as &$video ) {
			if ( $video['image_mobile'] ) {
				$video['image_mobile'] = $video['image_mobile']['url'];
			}
		}
		?>
	<script>
		var videos = <?php echo json_encode( $videos ); ?>,
			video_id = Math.floor( Math.random() * <?php echo count( $videos ); ?> );

			document.write(
				'<video width="1920" height="900" muted="muted" autoplay="true" loop class="background-header lazyloading" >' +
					'<source data-src="' + videos[video_id].video_mp4 + '" type="video/mp4" />' +
					'<source data-src="' + videos[video_id].video_webm + '" type="video/webm" />' +
					'<source data-src="' + videos[video_id].video_ogg + '" type="video/ogg" />' +
				'</video>'
			);

			if ( videos[video_id].image_mobile )
				document.write(
					'<picture>' +
						'<source media="(min-width: 992px)" sizes="1px" srcset="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7 1w"/>' +
						'<img src="' + videos[video_id].image_mobile + '" class="background-header-mobile" />' +
					'</picture>'
				);
	</script>
	<?php else : ?>
		<img src="<?php echo get_template_directory_uri(); ?>/assets/temp/header-background.png" alt="" class="background-header">
		<?php endif; ?>

		<?php get_template_part( 'template-parts/header' ); ?>

		<div class="container">
			<div class="row page-meta">
				<div class="col-xs-12 col-md-7">
					<div class="encart-title">
						<h1><?php the_field( 'home_title', 'option' ); ?></h1>
						<h2><?php the_field( 'home_subtitle', 'option' ); ?></h2>
					</div>
				</div>
			</div>
		</div>
	</header>

	<div class="content" id="content">
		<div class="container anchor-container">
			<a href="#content" class="anchor"></a>
		</div>

	<?php
		// Afficher le cartouche du prochain événement?
	if ( get_field( 'display_event_block', 'option' ) ) :
		$event      = get_field( 'event', 'option' );
		$event_date = new DateTime( get_field( 'event_date', 'option', false ) );
		$diff       = $event_date->diff( new DateTime( date( 'Y-m-d' ) ) );

		// Uniquement si l'événement est aujourd'hui ou dans le futur
		if ( get_field( 'event_date', 'option', false ) >= date( 'Ymd' ) ) :
			?>
		<div class="event">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 ticket-wrapper">
						<div class="ticket">
							<div class="logo">
								<img src="<?php the_field( 'event_logo', 'option' ); ?>">
							</div>

							<div class="info-event">
								<div class="date"><?php the_field( 'event_date', 'option' ); ?> <span class="horaires"><?php the_field( 'event_hours', 'option' ); ?></span></div>

								<div class="info-event-bis">
								<?php the_field( 'event_infos', 'option' ); ?>
								</div>

								<div class="qrcode">

								</div>
							</div>

							<div class="clearfix"></div>
						</div>
						<div class="event-cta">
							<div class="title"><?php the_field( 'event_name', 'option' ); ?></div>
							<div class="countdown">
							<?php _e( 'Cet événement a lieu', 'crea' ); ?> <span class="magenta"><?php echo $diff->days > 0 ? sprintf( _n( 'demain', 'dans %s jours', $diff->days, 'crea' ), $diff->days ) : __( 'aujourd\'hui', 'crea' ); ?></span>
							</div>

							<a href="<?php echo add_query_arg( array( 'id' => $event->ID ), get_permalink( FLOW_PAGE_ID ) ); ?>" class="btn flowinfo"><?php _e( 'Inscrivez-vous', 'crea' ); ?></a>
						</div>
					</div>

				<?php if ( $next_events = get_field( 'next_events' ) ) : ?>
					<div class="col-xs-12">
						<div class="row-events">
							<div class="events-title">
								<h3>
									<p>
										<?php _e( 'Autres <span>events</span>', 'crea' ); ?>
									</p>
								</h3>
							</div>

							<?php
							foreach ( $next_events as $k => $event ) :

								if ( $k >= 2 ) {
									break;
								}

								if ( $event->post_type == 'evenement' ) {
									$event_date = new DateTime( get_field( 'date', $event->ID, false ) );
								} else {
									// Si ce n'est pas un événement, on récupère les sessions correspondantes
									$sessions = find_formation_in_sessions( $event->ID, 'array' );
									foreach ( $sessions as $k => $session ) {
										$event_date             = new DateTime( $session['field_571630c2a8ec8'] );
										$diff                   = $event_date->diff( new DateTime( date( 'Y-m-d' ) ) );
										$sessions[ $k ]['diff'] = $diff->invert ? 0 - $diff->days : $diff->days;
									}

									// Identification de la session la plus proche dans le futur ou sinon de la plus proche dans le passé
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

									$event_date = isset( $sessions[ $key ] ) ? new DateTime( $sessions[ $key ]['field_571630c2a8ec8'] ) : false;

									switch ( $event->post_type ) {
										case 'bachelor':
											$event->post_title = __( 'Bachelor', 'crea' ) . ' ' . $event->post_title;
											break;
										case 'master':
											$event->post_title = __( 'Master', 'crea' ) . ' ' . $event->post_title;
											break;
										case 'mba':
											$event->post_title = __( 'MBA', 'crea' ) . ' ' . $event->post_title;
											break;
										case 'formation_continue':
											$event->post_title = __( 'Cycles certifiants', 'crea' ) . ' ' . $event->post_title;
											break;
										case 'brevet_federal':
											$event->post_title = __( 'Brevet fédéral', 'crea' ) . ' ' . $event->post_title;
											break;
									}
								}

								if ( $event_date ) {
									$diff = $event_date->diff( new DateTime( date( 'Y-m-d' ) ) );

									if ( $diff->days == 0 ) {
										$countdown = __( '<span>Aujourd\'hui</span>', 'crea' );
									} elseif ( $diff->invert ) {
										$countdown = sprintf( _n( '<span>Demain</span>', 'Dans <span>%s jours</span>', $diff->days, 'crea' ), $diff->days );
									} else {
										$countdown = sprintf( _n( '<span>Hier</span>', 'Il y a <span>%s jours</span>', $diff->days, 'crea' ), $diff->days );
									}
								}
								?>
								<div class="event-item">
									<a href="<?php echo get_permalink( $event->ID ); ?>">
										<h2><?php echo $event->post_title; ?></h2>
									<?php if ( $event_date ) : ?>
										<p class="countdown"><?php echo $countdown; ?></p>
										<time><?php _ex( 'Le', 'Avant une date', 'crea' ); ?> <?php echo date_i18n( 'd F Y', $event_date->getTimestamp() ); ?></time>
					<?php endif; ?>
									</a>
								</div>
							<?php endforeach; ?>

							<div class="cta">
								<a href="<?php echo get_permalink( AGENDA_PAGE_ID ); ?>" class="btn"><?php _e( 'Voir l\'agenda', 'crea' ); ?></a>
							</div>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
			<?php
		endif;
endif;
	?>

		<section class="formations">
			<div class="container">
				<header>
					<h2>
						<span class="first-line"><?php _e( 'Des expériences d\'apprentissage', 'crea' ); ?></span>
						<span class="second-line"><?php _e( '<span>créatives</span> à Genève et Lausanne', 'crea' ); ?></span>
					</h2>

					<div class="infos-cta">
						<a href="<?php echo add_query_arg( array( 'id' => get_the_ID() ), get_permalink( FLOW_PAGE_ID ) ); ?>" class="btn flowinfo"><?php _e( 'Séance d\'info / Contact', 'crea' ); ?></a>
					</div>
				</header>

				<main>
				<?php
				$formations_to_show = get_post_meta( $page_id, 'home_formations_types', true );
				$formations         = array();

				if ( in_array( 'bachelor', $formations_to_show, true ) ) {

					$formations['bachelor'] = array(
						'field' => 'bachelors_courses',
						'title' => _x( 'Bachelors', 'plural', 'crea' ),
					);
				}

				if ( in_array( 'master', $formations_to_show, true ) ) {

					$formations['master'] = array(
						'field' => 'masters_courses',
						'title' => __( 'Masters', 'crea' ),
					);
				}

				if ( in_array( 'mba', $formations_to_show, true ) ) {

					$formations['mba'] = array(
						'field' => 'mba_courses',
						'title' => __( 'MBA', 'crea' ),
					);
				}

				if ( in_array( 'continue', $formations_to_show, true ) ) {

					$formations['continue'] = array(
						'field' => 'lifelong_courses',
						'title' => __( 'Cycles certifiants', 'crea' ),
					);
				}

				if ( in_array( 'federal', $formations_to_show, true ) ) {

					$formations['federal'] = array(
						'field' => 'federal_courses',
						'title' => __( 'Brevets fédéraux', 'crea' ),
					);
				}

				if ( in_array( 'takeaway', $formations_to_show, true ) ) {

					$formations['takeaway'] = array(
						'field' => 'takeaway_courses',
						'title' => __( 'Masterclasses', 'crea' ),
					);
				}

				if ( in_array( 'learning7', $formations_to_show, true ) ) {

					$formations['learning7'] = array(
						'field' => 'elearning_courses',
						'title' => __( 'E-Learning', 'crea' ),
					);
				}
				?>
					<aside>
						<nav>
							<div class="filter">
								<select>
								<?php
								foreach ( $formations as $k => $formation ) {
									echo '<option value="' . $k . '">' . $formation['title'] . '</option>';
								}
								?>
									<option value="<?php the_field( 'company_solutions_link' ); ?>"><?php _e( 'Solutions pour entreprises', 'crea' ); ?></option>
								</select>
							</div>

							<ul>
							<?php
							foreach ( $formations as $k => $formation ) {
								echo '<li><a href="#" data-filter="' . $k . '" ' . ( $k == 'bachelor' ? 'class="active"' : '' ) . '>' . $formation['title'] . '</a></li>';
							}
							?>
							</ul>

							<footer>
								<a href="<?php the_field( 'company_solutions_link' ); ?>"><?php _e( 'Solutions pour entreprises', 'crea' ); ?></a>
							</footer>
						</nav>
					</aside>

					<div class="lessons-list">
					<?php
					foreach ( $formations as $k => $formation ) {
						$courses = get_field( $formation['field'] );
						if ( $courses ) {
							foreach ( $courses as $course ) {
								?>
						 <div class="grid-item grid-item--<?php echo $k; ?>">
							 <a href="<?php echo $course['link']; ?>" class="lesson-item lesson-item--<?php echo $k; ?>">
								<span class="lang"><?php echo $course['language']; ?></span>
								<h3><?php echo $course['label']; ?></h3>

								<span class="cta"><?php _e( 'Voir la formation', 'crea' ); ?></span>
							</a>
						</div>
								<?php
							}
						}
					}
					?>
					</div>

					<footer>
						<div class="infos-cta">
							<a href="<?php echo add_query_arg( array( 'id' => get_the_ID() ), get_permalink( FLOW_PAGE_ID ) ); ?>" class="btn flowinfo"><?php _e( 'Inscriptions séance d\'info', 'crea' ); ?></a>
						</div>
					</footer>
				</main>

			</div>
		</section>

		<section class="story-telling">
			<img src="<?php echo cb_image_resize( get_field( 'storytelling_bg' )['ID'], 1920, 900 ); ?>" />

			<div class="container">
				<h2>
				<?php the_field( 'storytelling' ); ?>
				</h2>

				<div class="cta">
				<?php $storytelling_bt = get_field( 'storytelling_bt' ); ?>
					<a href="<?php echo $storytelling_bt['url']; ?>" class="btn" target="<?php echo $storytelling_bt['target']; ?>"><?php echo $storytelling_bt['title']; ?></a>
				</div>
			</div>
		</section>

		<section class="le-blog">
			<div class="container">
				<header>
					<h2><?php _e( 'Le blog <span>CREA</span>', 'crea' ); ?></h2>
				</header>

				<main>
				<?php
					$featured_articles = get_field( 'featured_article' );
					$post              = $featured_articles[0];
				setup_postdata( $post );
				$excluded_articles[] = get_the_id();
				?>
					<section class="giant-featured-article">
						<a href="<?php the_permalink(); ?>" class="article-item">
							<article>
								<figure>
									<img src="<?php echo cb_image_resize( get_post_thumbnail_id(), 920, 610 ); ?>" alt="<?php the_title(); ?>" />
								</figure>

								<h3><?php the_title(); ?></h3>

								<?php echo '<p>' . get_the_excerpt() . '</p>'; ?>

								<footer>
									<?php _e( 'Article du', 'crea' ); ?>&nbsp;<time datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'd.m.Y' ); ?></time></p>
								</footer>
							</article>
						</a>
					</section>
					<section class="featured-article">
					<?php
						wp_reset_postdata();

						unset( $featured_articles[0] );

					foreach ( $featured_articles as $article ) :
						$post = $article;
						setup_postdata( $post );
						$excluded_articles[] = get_the_id();
						?>
						<a href="<?php the_permalink(); ?>" class="article-item">
							<article>
								<figure>
									<img src="<?php echo cb_image_resize( get_post_thumbnail_id(), 920, 610 ); ?>" alt="<?php the_title(); ?>" />
								</figure>

								<h3><?php the_title(); ?></h3>

								<footer>
								<?php _e( 'Article du', 'crea' ); ?>&nbsp;<time datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'd.m.Y' ); ?></time></p>
								</footer>
							</article>
						</a>
						<?php
			endforeach;
					wp_reset_postdata();
					?>
					</section>

					<section class="list-article">
						<h4><?php _e( 'Plus d\'articles', 'crea' ); ?></h4>

						<?php
						$articles = new WP_Query(
							array(
								'cat'            => ARTICLES_CATEGORY_ID,
								'post__not_in'   => (array) $excluded_articles,
								'posts_per_page' => 5,
							)
						);
						if ( $articles->post_count ) :
							foreach ( $articles->posts as $post ) :
													$excluded_articles[] = $post->ID;
								?>
						<a href="<?php echo get_permalink( $post->ID ); ?>" class="article-item">
							<article>
								<h3><?php echo $post->post_title; ?></h3>
							</article>
						</a>
											<?php
											endforeach;
endif;
						?>

						<div class="cta">
							<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="btn"><?php _e( 'Voir le blog', 'crea' ); ?></a>
						</div>
					</section>
				</main>

			</div>
		</section>

	<?php wp_reset_postdata(); ?>

		<div class="international">
			<div class="container">
				 <div class="row">
					 <div class="col-xs-12 col-sm-4 encart-logo">
						 <span><?php _e( 'Une école <br />du groupe', 'crea' ); ?></span>
						 <img src="<?php echo get_template_directory_uri(); ?>/assets/pics/logo-omnes-v.png" alt="OMNES">
						 <a href="<?php echo get_permalink( INSEEC_PAGE_ID ); ?>" class="more hide-mobile"><?php _e( 'En savoir plus', 'crea' ); ?></a>
					 </div>

					 <div class="col-xs-12 col-sm-8">
						 <h3><?php _e( 'Voyagez avec CREA :', 'crea' ); ?> <br /><?php _e( 'Découvrez nos campus à l\'international', 'crea' ); ?></h3>
						 <p><?php _e( 'Le Groupe OMNES, leader de l\'enseignement supérieur privé en France, propose une large gamme de programmes de Bac à Bac+8 en formation initiale et continue, partout dans le monde. CREA vous offre l\'opportunité d\'effectuer votre formation sur les différents campus.', 'crea' ); ?></p>
						 <a href="#" class="more hide-other"><?php _e( 'En savoir plus', 'crea' ); ?></a>
					 </div>
				 </div>

				 <div class="row hide-mobile">
					 <div class="col-xs-12">
						 <ul class="mosaique-place">

				 <?php
					if ( have_rows( 'campus', 'option' ) ) :
						while ( have_rows( 'campus', 'option' ) ) :
							the_row();
							?>
							 <li>
									<picture>
										<source media="(max-width: 991px)" sizes="1px"
														srcset="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7 1w"/>
										<img src="
										<?php
										$campus_photo = get_sub_field( 'campus_photo' );
										echo $campus_photo['sizes']['campus'];
										?>
										"/>
									</picture>
								 <span class="legend"><?php the_sub_field( 'campus_city' ); ?></span>
							 </li>
							 <?php
								endwhile;
endif;
					?>

						 </ul>
					 </div>
				 </div>
			</div>
		</div>
	</div>

	<?php
	$storytelling_bg_2 = get_field( 'storytelling_bg_2' );
	$storytelling_bt_2 = get_field( 'storytelling_bt_2' );
	?>
	<section class="story-telling">
		<?php if ( ! empty( $storytelling_bg_2['ID'] ) ) { ?>
			<img src="<?php echo esc_url( cb_image_resize( $storytelling_bg_2['ID'], 1920, 900 ) ); ?>" />
		<?php } ?>

		<div class="container">
			<h2>
			<?php the_field( 'storytelling_2' ); ?>
			</h2>

			<div class="cta">
				<?php if ( ! empty( $storytelling_bt_2['url'] ) ) { ?>
					<a href="<?php echo esc_url( $storytelling_bt['url'] ); ?>" class="btn" target="<?php echo $storytelling_bt['target']; ?>"><?php echo $storytelling_bt['title']; ?></a>
				<?php } ?>
			</div>
		</div>
	</section>
</div>

<?php get_footer(); ?>
