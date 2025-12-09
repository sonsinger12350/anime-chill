<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");

ob_start();
$title = "Lịch sử xem phim - {$cf['title']}";
$description = "Xem lịch sử xem phim online";

?>
<div class="row container" id="wrapper">
	<main id="main-content" class="col-xs-12 col-sm-12 col-md-12">
		<div class="clearfix"></div>
		<section id="halim-showtimes-widget" class="halim-showtimes-widget" style="position: relative">
			<div class="clearfix">
				<div class="halim-ajax-popular-post-loading hidden"></div>
				<div class="halim_box" id="ajax-showtimes-widget">
					<h3 class="section-title"><span>Lịch sử xem phim</span></h3>
					<div class="list-movie">
						<?php
						$history_data = getHistory();

						foreach ($history_data as $value) {
							$MovieID = sql_escape($value['movie_id']);
							$EpisodeID = sql_escape($value['episode_id']);
							
							if (get_total("movie", "WHERE id = '$MovieID'") >= 1) {
								$row = GetDataArr("movie", "id = '$MovieID'");
								include(ROOT_DIR . '/view/single-movie.php');
							}
						}
						?>
					</div>
				</div>
			</div>
		</section>
		<div class="clearfix"></div>
	</main>
</div>
<?php
$content = ob_get_clean();

// Include layout
require_once(ROOT_DIR . '/view/layout.php');
