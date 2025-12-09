<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");

ob_start();
$title = "Phim Hoàn Thành - {$cf['title']}";
$description =  "Xem phim hoàn thành online";
?>
<input type="hidden" id="view" value="movie-complete">
<div class="row container" id="wrapper">
	<main id="main-content" class="col-xs-12 col-sm-12 col-md-12">
		<div class="clearfix"></div>
		<section id="halim-showtimes-widget" class="halim-showtimes-widget" style="position: relative">
			<div class="clearfix">
				<div class="halim-ajax-popular-post-loading hidden"></div>
				<div class="halim_box" id="ajax-showtimes-widget">
					<?php echo loadMovieList(['view' => 'movie-complete']); ?>
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
