<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");

ob_start();
$slugCate = sql_escape($value[2]);
if (get_total("category", "WHERE slug = '$slugCate'") < 1) die(header('location:' . URL));
$category = GetDataArr("category", "slug = '$slugCate'");
$title = "Thể Loại {$category['title']} - {$cf['title']}";
$description = "Thể Loại {$category['title']} - {$cf['description']}";
?>
<input type="hidden" id="view" value="movie-category">
<input type="hidden" id="category_id" value="<?= $category['id'] ?>">
<input type="hidden" id="category_name" value="<?= $category['name'] ?>">
<div class="row container" id="wrapper">
	<main id="main-content" class="col-xs-12 col-sm-12 col-md-12">
		<div class="clearfix"></div>
		<section id="halim-showtimes-widget" class="halim-showtimes-widget" style="position: relative">
			<div class="clearfix">
				<div class="halim-ajax-popular-post-loading hidden"></div>
				<div class="halim_box" id="ajax-showtimes-widget">
					<?php echo loadMovieList(['view' => 'movie-category', 'filter' => ['category_id' => $category['id'], 'name' => $category['name']]]); ?>
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
