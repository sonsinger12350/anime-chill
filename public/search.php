<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");

ob_start();
$kw = sql_escape($_GET['s']);
$title = "Bạn đã tìm: {$kw} - {$cf['title']}";
$description = "Tìm kiếm từ khoá: {$kw}";

?>
<input type="hidden" id="view" value="search">
<input type="hidden" id="keyword" value="<?= $kw ?>">
<div class="row container" id="wrapper">
	<main id="main-content" class="col-xs-12 col-sm-12 col-md-12">
		<div class="clearfix"></div>
		<section id="halim-showtimes-widget" class="halim-showtimes-widget" style="position: relative">
			<div class="clearfix">
				<div class="halim-ajax-popular-post-loading hidden"></div>
				<div class="halim_box" id="ajax-showtimes-widget">
					<?php echo loadMovieList(['view' => 'search', 'filter' => ['keyword' => $kw]]); ?>
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
