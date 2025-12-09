<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");

ob_start();
$title = "Lịch Chiếu Phim - {$cf['title']}";
$description = "Xem lịch chiếu phim online";

$tabs = [
	'2' => 'Thứ Hai',
	'3' => 'Thứ Ba',
	'4' => 'Thứ Tư',
	'5' => 'Thứ Năm',
	'6' => 'Thứ Sáu',
	'7' => 'Thứ Bảy',
	'8' => 'Chủ Nhật',
];
$currentDay = date('N') + 1;
?>
<div class="row container" id="wrapper">
	<main id="main-content" class="col-xs-12 col-sm-12 col-md-12">
		<section>
			<div class="section-bar clearfix">
				<div class="page-title-wrapper">
					<h1 class="page-title"> <i class="fas fa-film"></i> Lịch Chiếu Phim</h1>
				</div>
			</div>
			<section class="halim-showtime">
				<ul class="halim-showtimes-block-custom">
					<?php foreach ($tabs as $key => $value) { ?>
						<li data-layout="4col" data-day="<?= $key ?>" role="presentation" class="weekday <?= $key == $currentDay ? 'active' : '' ?>">
							<?= $value ?>
						</li>
					<?php } ?>
				</ul>
				<div class="halim-ajax-popular-post-loading hidden"></div>
				<div id="ajax-showtimes-widget">
					<?php echo loadMovieShowtimes($currentDay); ?>
				</div>
			</section>
			<div class="clearfix"></div>
		</section>
	</main>
</div>
<script>
	jQuery(function($) {
		$('body').on('click', '.halim-showtimes-block-custom .weekday', function(e) {
			e.preventDefault();
			const that = $(this);
			const day = that.data('day');
			if (!day) return;

			$('.halim-ajax-popular-post-loading').removeClass('hidden');
			$.ajax({
				type: 'POST',
				url: '/server/api',
				contentType: 'application/json',
				dataType: 'json',
				data: JSON.stringify({
					action: 'load_movie_showtimes',
					day: day
				}),
				success: function(response) {
					$('.halim-showtimes-block-custom .weekday').removeClass('active');
					that.addClass('active');
					$('.halim-ajax-popular-post-loading').addClass('hidden');
					$('#ajax-showtimes-widget').html(response.data);
				},
				error: function() {
					alert('Có lỗi xảy ra khi tải dữ liệu');
				}
			});
		});
	});
</script>
<?php
$content = ob_get_clean();

// Include layout
require_once(ROOT_DIR . '/view/layout.php');
