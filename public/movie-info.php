<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$value[2]) die(header('location:' . URL));
FireWall();
$MovieSlug = sql_escape($value[2]);
if (get_total("movie", "WHERE slug = '$MovieSlug'") < 1) die(header('location:' . URL));

$Movie = GetDataArr("movie", "slug = '$MovieSlug'");

// SEO
$title = "Xem phim {$Movie['name']} - {$cf['title']}";
$description = strip_tags($Movie['content']);
$image = $Movie['image'];
// End SEO

$episodeId = GetDataArr("episode", "movie_id = '{$Movie['id']}' ORDER BY ep_num DESC LIMIT 1");
$episodeId = $episodeId['id'];
$status = ($Movie['loai_phim'] == 'Phim Lẻ' ? "{$Movie['movie_duration']} Phút" : "$NumEpisode/{$Movie['ep_num']}");
$categoryHtml = [];

if (!empty($Movie['cate'])) {
	$cate = json_decode($Movie['cate'], true);

	foreach ($cate as $key => $value) {
		$category = GetDataArr('category', "id = '{$value['cate_id']}'");
		if (!empty($category)) $categoryHtml[] = '<a href="' . URL . '/the-loai/' . $category['slug'] . '" rel="category tag">' . $category['name'] . '</a>';
	}
}
ob_start();
?>
<style>
	.htmlwrap {
		margin-top: -1px;
		background: #232323;
		border: 1px solid #1d2731a6;
	}

	#toggle_follow span {
		font-size: 20px;
	}

	.modal {
		height: 112px;
	}

	.info-movie .rated-star span {
		cursor: pointer;
	}

	.info-movie .head .first {
		width: 50% !important;
	}

	.info-movie .head .last {
		width: 100% !important;
	}
</style>
<input type="hidden" id="view" value="search">
<input type="hidden" id="keyword" value="<?= $kw ?>">
<div class="row container single-post info-movie" id="wrapper">
	<main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
		<section id="content">
			<div class="clearfix wrap-content">
				<div class="halim-movie-wrapper tpl-2">
					<div class="movie_info col-xs-12">
						<div class="head ah-frame-bg">
							<div class="first">
								<img src="<?= $Movie['image'] ?>" alt="<?= $Movie['name'] ?>">
							</div>
							<div class="last">
								<div class="name">
									<div>Tên</div>
									<div>
										<h1 class="movie_name"><?= $Movie['name'] ?></h1>
									</div>
								</div>
								<div class="name_other">
									<div>Tên Khác</div>
									<div>
										<p class="org_title"><?= $Movie['other_name'] ?></p>
									</div>
								</div>
								<div class="list_cate">
									<div>Thể Loại</div>
									<div><?= implode(' ', $categoryHtml) ?></div>
								</div>
								<div class="hh3d-new-ep">
									<div>Tập mới nhất</div>
									<div><span class="new-ep"><?= $status ?></span></div>
								</div>
								<div class="hh3d-info">
									<div>Thông Tin Khác</div>
									<div><span class="released"><span class="released"><i class="fa-regular fa-calendar-days"></i> <a href="javascript:void(0)" rel="tag"><?= $Movie['year'] ?></a></span> </span></div>
								</div>
								<div class="hh3d-rate">
									<div>Đánh Giá</div>
									<div class="ratings_wrapper single-info">
										<div class="halim-rating-container">
											<div class="halim-star-rating">
												<span class="halim-star-icon">★</span>
												<span class="halim-rating-score"><?= !empty($Movie['vote_all']) ? round($Movie['vote_point']/$Movie['vote_all'], 2) : 0 ?></span>
												<span class="halim-rating-slash">/</span>
												<span class="halim-rating-max">10</span>
												<span class="halim-rating-votes">(<span class="halim_num_votes"><?= $Movie['vote_all'] ?></span> lượt đánh giá)</span>
											</div>
											<button type="button" class="halim-rating-button" id="rated">Đánh Giá</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="btn ah-frame-bg">
							<a href="<?= URL ?>/watch/<?= $Movie['slug'] ?>-episode-id-<?= $episodeId ?>.html" class="button-default bg-lochinvar watch-btn"><i class="fa-solid fa-circle-play"></i>Xem Phim </a>
							<button id="toggle_follow" value="<?= $Movie['id'] ?>" type="button" class="button-default bg-lochinvar watch-btn"><i class="fa-solid fa-bookmark"></i></button>
						</div>
					</div>
				</div>
			</div>

			<div class="clearfix"></div>

			<div class="htmlwrap clearfix">
				<div class="section-title"><span>Tóm tắt phim</span></div>
				<div class="video-item halim-entry-box">
					<article class="item-content"><?= un_htmlchars($Movie['content']) ?></article>
					<div class="item-content-toggle">
						<div class="item-content-gradient"></div>
						<span class="show-more" data-single="true" data-showmore="Mở rộng..." data-showless="Thu gọn...">Mở rộng...</span>
					</div>
				</div>
			</div>

			<div class="htmlwrap clearfix">
				<?php if ($cf['cmt_on'] == 'true') { ?>
					<div class="ah-frame-bg">
						<div class="flex flex-space-auto">
							<div class="fw-700 fs-16 color-yellow-2 flex flex-hozi-center">
								<span class="material-icons-round margin-0-5"></span>Bình luận (<?= number_format(get_total('comment', "WHERE movie_id = '{$Movie['id']}'")) ?>)
							</div>
							<div id="refresh-comments" class="cursor-pointer"><span class="material-icons-round fs-35">refresh</span></div>
						</div>
						<?php if (!$_author_cookie) { ?>
							<div class="flex flex-ver-center fw-500">
								<a href="/login" class="button-default bg-red">
									Đăng nhập để bình luận
								</a>
							</div>
						<?php } ?>
						<script type="text/javascript" src="/themes/js_ob/fgEmojiPicker.js?v=1.7.4"></script>
						<div id="frame-comment"></div>
						<div id="comments" class="margin-t-10" style="width: 100%;overflow: hidden;"></div>
					</div>
				<?php } ?>
			</div>
		</section>
		<div id="modal" class="modal" style="display: block; visibility: hidden; top: 0px; transition: top 0.3s;">
			<div>
				<div>Đánh giá phim</div>
				<a href="javascript:$modal.toggleModal()"><span class="material-icons-round margin-0-5">close</span></a>
			</div>
			<div>
				<div class="rated-star flex flex-hozi-center flex-ver-center">
					<span rate="1"><span class="material-icons-round">star</span></span><span rate="2"><span class="material-icons-round">star</span></span><span rate="3"><span class="material-icons-round">star</span></span><span rate="4"><span class="material-icons-round">star</span></span><span rate="5"><span class="material-icons-round">star</span></span><span rate="6"><span class="material-icons-round">star</span></span><span rate="7"><span class="material-icons-round">star</span></span><span rate="8"><span class="material-icons-round">star</span></span><span rate="9"><span class="material-icons-round">star</span></span><span rate="10"><span class="material-icons-round">star</span></span>
				</div>
			</div>
		</div>
	</main>
</div>
<script type="text/javascript">
	var $modal = new MyModal();
	var $info_data = {
		movie_id: <?= $Movie['id'] ?>,
	}
	$_GET.comment_id = getParam("comment_id") || null;
	<?php if (get_total('history', "WHERE movie_save = '{$Movie['id']}' AND user_id = '{$user['id']}'") >= 1 && $_author_cookie) { ?>
		var $user_followed = true;
	<?php } else { ?>
		var $user_followed = false;
	<?php } ?>
</script>
<script type="text/javascript" src="/themes/js_ob/comments.js?v=1.7.4"></script>
<script type="text/javascript" src="/themes/js_ob/info_movie.js?v=1.7.4"></script>
<script>
	$(".show-more").click(function() {
		if (
			$(this).parent().parent().find(".item-content").toggleClass("toggled"),
			$(this).parent().find(".item-content-gradient").toggleClass("hidden"),
			1 == $(this).data("single")
		) {
			let a = $(this).text() == $(this).data("showmore") ? $(this).data("showless") : $(this).data("showmore");
			$(this).text(a)
		} else {
			let e = "hl-angle-down" == $(this).data("icon") ? "hl-angle-up" : "hl-angle-down";
			$(this).toggleClass(e).toggleClass("hl-angle-down")
		}
	});
</script>
<?php
$content = ob_get_clean();

// Include layout
require_once(ROOT_DIR . '/view/layout.php');
