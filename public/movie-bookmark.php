<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");

ob_start();
$title = "Phim theo dõi - {$cf['title']}";
$description = "Xem danh sách phim đã theo dõi";

// Kiểm tra đăng nhập và lấy user_id
$user_id = null;
if ($_author_cookie && isset($user['id']) && $user['id'] > 0) {
	$user_id = $user['id'];
}

// Lấy tham số phân trang
$page = GetParam('p') ? GetParam('p') : null;
$limit = 20;
// Render danh sách phim đã theo dõi bằng hàm renderBookmarkedMovies
$bookmarked_content = renderBookmarkedMovies([
	'user_id' => $user_id,
	'page' => $page,
	'limit' => $limit,
	'showPagination' => true
]);

?>
<style>
	.section-title {
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.list-movie {
		min-height: 58vh;
	}

	.list-movie:has(.noti-error) {
		justify-content: center;
		align-items: start;
	}

	.list-movie .noti-error {
		margin-top: 16px;
	}
</style>
<input type="hidden" id="view" value="movie-bookmark">
<input type="hidden" id="limit" value="<?= $limit ?>">

<div class="row container" id="wrapper">
	<main id="main-content" class="col-xs-12 col-sm-12 col-md-12">
		<div class="clearfix"></div>
		<section id="halim-showtimes-widget" class="halim-showtimes-widget" style="position: relative">
			<div class="clearfix">
				<div class="halim-ajax-popular-post-loading hidden"></div>
				<div class="section-title">
					<span>Phim đã theo dõi</span>
					<button type="button" class="button-default bg-lochinvar remove-all-bookmark"><i class="fa-solid fa-trash"></i> Xóa tất cả</button>
				</div>
				<div class="halim_box" id="ajax-showtimes-widget">
					
					<?php echo $bookmarked_content; ?>
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
