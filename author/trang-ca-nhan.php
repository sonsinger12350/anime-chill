<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");

ob_start();

$userId = $value[2];
$iconCategory = categoryStore();
$listItemStore = listItemStore();
$listItemOwned = listUserItemOwner($userId, false);
$currentUser = GetDataArr('user', "id = $userId");

if (!empty($currentUser)) {
	$currentUser['khung-vien'] = getIconStoreActive($userId, 'khung-vien');
	$currentUser['background'] = getIconStoreActive($userId, 'background');
}

$totalFollow = getTotalFollow($userId);

$title = "Trang cá nhân - {$currentUser['nickname']} - {$cf['title']}";
$description = "Xem trang cá nhân của {$currentUser['nickname']}";

?>
<style>
	.page-title {
		font-size: 17px;
	}

	.page-title::after {
		content: none;
	}

	.btn-dark,
	.btn-dark:hover,
	.btn-dark:focus {
		background-color: #212529;
		color: #fff;
	}

	.nav-tabs .nav-link.active {
		background-color: #fff;
	}
</style>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" /> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"></script> -->
<script type="text/javascript" src="/themes/js_ob/croppie.js?v=1.7.4"></script>
<link href="/themes/styles/croppie.css?v=1.4.0" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<link href="/themes/styles/trang-ca-nhan.css?v=<?= time() ?>" rel="stylesheet" />
<input type="hidden" id="view" value="movie-bookmark">
<input type="hidden" id="limit" value="<?= $limit ?>">

<div class="row container" id="wrapper">
	<main id="main-content" class="col-xs-12 col-sm-12 col-md-12">
		<div class="page-title fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">Trang cá nhân</div>
		<div class="profile">
			<?php if (!empty($currentUser)): ?>
			<div class="navigation">
				<!-- Avatar -->
				<div class="avatar" style="<?= $currentUser['background'] ? 'background-image: url(' . $currentUser['background'] . ');' : '' ?>">
					<div class="img">
						<img src="<?= $currentUser['avatar'] ?>" />
						<img src="<?= $currentUser['khung-vien'] ?>" alt="" class="avatar-frame">
					</div>
					<div class="profile-info">
						<h4><?= $currentUser['nickname'] ?></h4>
						<h6 style="color: <?= LevelColor($currentUser['level']) ?>">Cấp <?= $currentUser['level'] ?></h6>
						<?php if (isFollowed($userId)): ?>
							<button class="btn btn-danger border-white btn-follow" type="button"><i class="fa-solid fa-user"></i>Đang theo dõi (<?= $totalFollow ?>)</button>
						<?php else: ?>
							<button class="btn btn-dark border-white btn-follow" type="button"><i class="fa-solid fa-user"></i>Theo dõi (<?= $totalFollow ?>)</button>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="tabs">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item menu-item hvr-sweep-to-right">
						<a class="nav-link active" href="#tab-movie" data-bs-toggle="tab">Phim theo dõi</a>
					</li>
					<li class="nav-item menu-item hvr-sweep-to-right">
						<a class="nav-link" href="#tab-icon" data-bs-toggle="tab">Vật phẩm sở hữu</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane show active" id="tab-movie">
						<div class="tab-body mb-4 movie-follow">

						</div>
					</div>
					<div class="tab-pane" id="tab-icon">
						<div class="tab-body mb-4">
							<div class="icons">
								<div class="grid">
									<?php foreach ($listItemOwned as $cat => $list): ?>
										<?php if (!empty($list)): ?>
										<div class="icon-cat <?= $cat ?>">
											<p><?= $iconCategory[$cat] ?></p>
											<div class="list">
												<?php foreach ($list as $iconId): ?>
													<?php
														$tooltip = '<img src="'.$listItemStore[$cat][$iconId]['image'].'" /><span class="icon-name">'.$listItemStore[$cat][$iconId]['name'].'</span>';
													?>
													<a href="javascript:void(0)" data-tooltip-icon='<?= $tooltip ?>'><img src="<?= $listItemStore[$cat][$iconId]['image'] ?>" alt="<?= $listItemStore[$cat][$iconId]['name'] ?>"></a>
												<?php endforeach;?>
											</div>
										</div>
										<?php endif?>
									<?php endforeach;?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php else: ?>
				<p class="mb-0 mt-3 text-center">Không có dữ liệu</p>
			<?php endif; ?>
		</div>
	</main>
</div>
<script type="text/javascript">
	$('body').on('click', '[data-bs-toggle="tab"]', function(e) {
		const element = $(this);
		const tab = element.attr('href');

		element.closest('.nav-tabs').find('.nav-item .nav-link').removeClass('active');
		element.addClass('active');
		$('.tab-content .tab-pane').removeClass('show active');
		$(tab).addClass('show active');
		e.preventDefault();
	});

	$(document).ready(function() {
		showMovieFollow(0);

		$('body').on('click', '.movie-follow-pagination', function() {
			if ($(this).parent().hasClass('active')) return false;

			showMovieFollow($(this).attr('data-page'));
		});

		$('body').on('click', '.btn-follow', async function() {
			let btn = $(this);
			await axios.post('/server/api', {
				"action": "follow_user",
				"user_id": <?=$userId?>,
			}).then(response => {
				console.log(response);
				if (response.data.action == 'follow') {
					btn.removeClass('btn-dark');
					btn.addClass('btn-danger');
					btn.html(`<i class="fa-solid fa-user"></i>Đang theo dõi (${response.data.follow})`);
				}
				else {
					btn.removeClass('btn-danger');
					btn.addClass('btn-dark');
					btn.html(`<i class="fa-solid fa-user"></i>Theo dõi (${response.data.follow})`);
				}
			}).catch(e => {
				console.log(e);
			});
		});
	});

	async function showMovieFollow(page) {
		try {
			let response = await loadFollowmovie(page);

			$('.movie-follow').html(response.data);
			$('.movie-follow .movie-item .delete').remove();
		} catch (e) {
			console.log(e)
		}
	}

	loadFollowmovie = (page = 0) => {
		let local_store = localStorage.getItem("data_follow");
		let data_follow_store = local_store ? JSON.parse(local_store) : [];
		let limit;
		
		if (screen.width <= 767) limit = 9;
		else limit = 10;

		return axios.post(
			'/server/api', {
				"action": "data_follow",
				"data_follow": JSON.stringify(data_follow_store),
				"page_now": page,
				"limit": limit,
				"user": <?=$userId?>,
			}
		);
	}

	// End movie follow
</script>
<?php
$content = ob_get_clean();

// Include layout
require_once(ROOT_DIR . '/view/layout.php');
