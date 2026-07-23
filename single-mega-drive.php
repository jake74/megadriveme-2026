<?php
/**
 * The template for displaying all Mega Drive single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package dekiru
 */

get_header();

$game_title = get_the_title();

$jpn_title = get_field('japanese_title');
$aka = get_field('aka');
$catalog_no = get_field('catalog_no');
$publisher = get_field('publisher');
$developer = get_field('developer');
$memory = get_field('memory');
$price = get_field('price');

$release_date = get_field('release_date');

$players = get_field('players');
$genre = get_field('genre');
$battery = get_field('battery');
$btn6 = get_field('btn6');
$multi_tap = get_field('multi_tap');
$modem = get_field('modem');
$mouse = get_field('mouse');

$euro_title = get_field('euro');
$usa_title = get_field('usa');

$overview = get_field('overview');
$comment = get_field('comment');
$notes = get_field('notes');

$gallery = get_field('gallery');

$youtube = get_field('youtube');
$youtube_clip = get_field('youtube_clip');

?>

	<main id="primary" class="site-main">

		<div class="game-detail-cover">
			<?php 
				$array = array(
					'alt' => the_title_attribute( array( 'echo' => false, ) ),
					'id' => 'cover-image',
				);
			
				echo get_the_post_thumbnail();
			?>
		</div>

		<div class="single-game">
			<?php
				$random = (rand(0,40)/10) - 2;
				// echo $random;
				echo '<style>';
				echo ':root { --rotate: ' . $random . 'deg; }';
				echo '</style>';

			?>

			<div class="game-data-sheet">
				
				<header class="game-header">
					<nav id="nav-games" class="game-navigation">
						<?php 
							$prev_post = get_adjacent_post(false, '', true);
							$next_post = get_adjacent_post(false, '', false);
						?>
						<ul>
							<li class="back-to-covers"><a href="<?php echo get_post_type_archive_link( 'mega-drive' ); ?>"><?php echo file_get_contents( get_template_directory() . '/assets/images/cover-grid.svg' ); ?> <span>Mega Drive library</span></a></li>
							<li class="prev"><a href="<?php echo get_permalink($prev_post->ID); ?>" title="<?php echo $prev_post->post_title; ?>"><?php echo file_get_contents( get_template_directory() . '/assets/images/nav-arrow.svg' ); ?> <span><?php echo $prev_post->post_title; ?></span></a></li>
							<li class="next"><a href="<?php echo get_permalink($next_post->ID); ?>" title="<?php echo $next_post->post_title; ?>"><?php echo file_get_contents( get_template_directory() . '/assets/images/nav-arrow.svg' ); ?> <span><?php echo $next_post->post_title; ?></span></a></li>
						</ul>
					</nav>

					<ul class="title-misc-info">
						<?php if ($catalog_no) : ?>
							<li><?php echo $catalog_no; ?></li>
						<?php endif; ?>
						<?php if ($aka) : ?>
							<li><?php echo $aka; ?></li>
						<?php endif; ?>
					</ul>

					<?php the_title( '<h1 class="game-title">', '</h1>' ); ?>
					<?php if ( $jpn_title ) : ?>
						<h2 class="japanese-title" lang="ja"><?php echo $jpn_title; ?></h2>
					<?php endif; ?>

				</header>

				<div class="game-info">
					<div class="game-meta">
						<dl class="game-specs">
							<?php if ($release_date) : ?>
								<dt>Released</dt>
								<dd><?php echo $release_date; ?></dd>
							<?php endif; ?>

							<?php if ($publisher) : ?>
								<dt>Publisher</dt>
								<dd><?php echo $publisher; ?></dd>
							<?php endif; ?>

							<?php if ( ($developer != 0) && ($developer != $publisher) ) : ?>
								<dt>Developer</dt>
								<dd><?php echo $developer; ?></dd>
							<?php endif; ?>

							<?php if ($catalog_no) : ?>
								<dt>Catalog#</dt>
								<dd><?php echo $catalog_no; ?></dd>
							<?php endif; ?>

							<?php if ($memory) : ?>
								<dt>Capacity</dt>
								<dd><?php echo $memory; ?></dd>
							<?php endif; ?>

							<?php if ($price) : ?>
								<dt>Price</dt>
								<dd><?php echo $price; ?>円</dd>
							<?php endif; ?>
						</dl>

						<div class="icons">
							<ul>
								<?php 
								if ( $players ) {
										$player_class = substr($players, 2, 1);
										$player_class = strtolower( $player_class );
										echo '<li class="p' . $player_class . '">' . $players . '</li>';
									}
									if ( $genre ) {
										$genre = substr( $genre, 0, 3);
										$genretitle = substr( $genre, -6);
										$genre_lwr = strtolower($genre);
										echo '<li class="' . $genre_lwr . ' genre">' . $genretitle . '</li>';
									}
									if ( $battery ) {
										echo '<li class="battery">Battery backup</li>';
									}
									if ( $btn6 ) {
										echo '<li class="btn6">6 Button pad compatible</li>';
									}
									if ( $multi_tap ) {
										echo '<li class="multitap">Multi-tap</li>';
									}
									if ( $modem ) {
										echo '<li class="modem">Modem</li>';
									}
									if ( $mouse ) {
										echo '<li class="mouse">Mouse</li>';
									}
								?>
							</ul>
						</div>

						<?php if( $euro_title || $usa_title ) : 
						?>
							<div class="regions">
								<ul>
									<?php if ( $euro_title /*!= $game_title*/ ) : ?>
										<li class="flag eu"><?php echo $euro_title; ?></li>
									<?php endif;
									
									if ( $usa_title /*!= $game_title*/ ) : ?>
										<li class="flag us"><?php echo $usa_title; ?></li>
									<?php endif; ?>
								</ul>
							</div>
						<?php endif; ?>
					</div>

					<div class="overview">
						<h2 class="sub-title">Overview</h2>
						<?php if ( $overview ) {
							echo $overview;
						} else {
							echo '<p>Awaiting overview.</p>';
						} ?>
					</div>

					<div class="author-comment">
						<h3 class="sub-title">Comment</h3>
						<?php if ( $comment ) {
							echo $comment;
						} else {
							echo '<p>Awaiting author comments.</p>';
						}?>
					</div>

					<?php if ( $notes ) : ?>
						<div class="author-notes">
							<h3 class="sub-title">Notes</h3>
							<?php echo $notes; ?>
						</div>
					<?php endif; ?>
					
					<?php // add the slug to the verdict div for colour styling
						global $wp_query;
						$verdict_slug = get_the_category(); 
						
						// print_r($verdict_slug);
					?>
					<div class="verdict <?php if($verdict_slug) { echo $verdict_slug[0]->slug; } ?>">
						<h3 class="sub-title">Verdict</h3>
						<?php if ( get_the_category() ) {
							the_category();
						} else {
							echo '<p>Awaiting review</p>';
						} ?>
					</div>

					<?php // If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) : ?>
							<h3 class="sub-title">Discussion</h3>
						<?php
							comments_template();
						endif;
					?>

					<?php // get_template_part( 'template-parts/google-ads' ); ?>

				</div>

				<div class="game-media">
					<?php if ( have_rows('videos') ) : ?>
						<div class="entry-video">
							<h4 class="sub-title">Video</h4>
							<?php
								while ( have_rows('videos') ) : the_row();
                  $video = get_sub_field('video');

                  echo $video;
                endwhile;
							?>
						</div>
					<?php endif; ?>
          
					<div class="entry-screenshots">
						<h4 class="sub-title">Screenshots</h4>
            <?php if (have_rows('screenshots')) : ?>
							<div class="game-gallery">
                <div class="swiper-wrapper">
                  <?php while(have_rows('screenshots')) : the_row();
                    $screenshot = get_sub_field('screenshot');
                  ?>
                    <div class="swiper-slide">
                      <img src="<?php echo $screenshot['url']; ?>" alt="<?php echo $screenshot['title']; ?>" loading="lazy">
                    </div>
                  <?php endwhile; ?>
                </div>
							</div>
						<?php else : ?>
							<p>There are no screenshots yet.</p>
						<?php endif; ?>
					</div>
			
				</div>

			</div>
		</div>

	</main>

<?php
get_footer();
