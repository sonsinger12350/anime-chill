<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");

ob_start();

$title = $cf['title'];
$description = $cf['description'];
$weekdays = [
	'lastupdated' => [ 'first' => 'Mới', 'second' => 'cập nhật'],
	'2' => ['first' => 'Mon', 'second' => 'Thứ 2'],
	'3' => ['first' => 'Tue', 'second' => 'Thứ 3'],
	'4' => ['first' => 'Wed', 'second' => 'Thứ 4'],
	'5' => ['first' => 'Thu', 'second' => 'Thứ 5'],
	'6' => ['first' => 'Fri', 'second' => 'Thứ 6'],
	'7' => ['first' => 'Sat', 'second' => 'Thứ 7'],
	'8' => ['first' => 'Sun', 'second' => 'Chủ Nhật'],
];
?>
<style>
	.weekdayname {
		font-weight: 600;
		font-size: 13px;
	}
</style>
<input type="hidden" id="view" value="home">
<div class="row container" id="wrapper">
	<div class="clearfix"></div>

	<div class="col-xs-12 carausel-sliderWidget">
		<div id="halim-carousel-widget-chill-2xx" class="wrap-slider">
			<div class="section-bar clearfix">
				<h3 class="section-title">
					<span><i class="fa-solid fa-fire-flame-curved"></i> Đang thịnh hành
					</span>
				</h3>
			</div>
			<div id="halim-carousel-widget-chill-2" class="owl-carousel owl-theme custom-carousel owl-loaded owl-drag">
				<div class="owl-stage-outer">
					<div class="owl-stage" style="transform: translate3d(0px, 0px, 0px);transition: all;width: 2060px;">
						<?php
						$count = 1;
						$arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "movie WHERE public = 'true' ORDER BY view DESC LIMIT 10");
						while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
							$NumEpisode = ($row['ep_hien_tai'] ? $row['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$row['id']}'"));
							if ($row['loai_phim'] == 'Phim Lẻ') $status = "{$row['movie_duration']} Phút";
							else $status = "$NumEpisode/{$row['ep_num']}";
						?>
							<div class="owl-item">
								<article class="thumb grid-item post-189">
									<div class="halim-item">
										<a class="halim-thumb" href="<?= URL ?>/info/<?= $row['slug'] ?>.html" title="<?= $row['name'] ?>">
											<figure class="clip-path-even">
												<div class="halim-trending-poster-mask halim-trending-clip-path-even">
												</div>
												<img fetch="" class="blur-up img-responsive lazyautosizes lazyloaded" src="<?= $row['image'] ?>" alt="<?= $row['name'] ?>" title="<?= $row['name'] ?>" fetchpriority="high" />
												<div class="halim-trending-rating">
													<div class="halim-trending-rating-value">
														<?= Voteting($row['vote_point'], $row['vote_all']) ?>
													</div>
												</div>
											</figure>
											<div class="icon_overlay"></div>
											<div class="halim-post-title-box">
												<div class="halim-post-title-box">
													<div class="number"><?= $count ?></div>
													<div class="halim-post-title">
														<h2 class="entry-title"><?= $row['other_name'] ?></h2>
														<p class="original_title"><?= $row['name'] ?></p>
													</div>
												</div>
											</div>
										</a>
									</div>
								</article>
							</div>
						<?php $count++;
						} ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<main id="main-content" class="col-xs-12 col-sm-12 col-md-12">
		<div class="clearfix"></div>
		<section id="halim-showtimes-widget" class="halim-showtimes-widget" style="position: relative">
			<div class="section-bar clearfix">
				<ul class="nav nav-pills nav-justified halim-showtimes-block mobile">
					<li id="lastupdated" class="active">
						<a href="<?=  URL  ?>"><span>Mới cập nhật</span></a>
					</li>
					<li id="action_showtimes">
						<a href="javascript:;"><span>Lịch chiếu</span></a>
					</li>
				</ul>
				<ul class="nav nav-pills nav-justified halim-showtimes-block show-pc">
					<?php foreach ($weekdays as $key => $value) { ?>
						<li class="weekday <?= $key == 'lastupdated' ? 'active hide-mobile' : '' ?>" data-day="<?= $key ?>">
							<a href="<?=  $key == 'lastupdated' ? URL : 'javascript:;' ?>"><span class="weekdayshortname"><?= $value['first'] ?></span><span class="weekdayname"><?= $value['second'] ?></span></a>
						</li>
					<?php } ?>
				</ul>

				<div class="halim-ajax-popular-post-loading hidden"></div>
				<div class="halim_box" id="ajax-showtimes-widget">
					<?php echo loadMovieList(['view' => 'home']); ?>
				</div>
			</div>
		</section>
		<div class="clearfix"></div>
	</main>
</div>
<script>
	jQuery(document).ready(function($) {
		var owl = $("#halim-carousel-widget-chill-2");
		owl.owlCarousel({
			rtl: false,
			loop: false,
			margin: 4,
			autoplay: false,
			autoplayTimeout: 4000,
			autoplayHoverPause: true,
			nav: false,
			navText: [],
			responsiveClass: true,
			responsive: {
				0: { items: 2 },
				480: { items: 3 },
				600: { items: 4 },
				1000: { items: 5 },
			},
		});
	});
</script>
<?php
$content = ob_get_clean();

// Include layout
require_once(ROOT_DIR . '/view/layout.php');
