<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_author_cookie) die(header("location:/login"));
if (isset($_POST['change_profile'])) {
	$nickname = sql_escape($_POST['nickname']);
	$quote = sql_escape($_POST['quote']);
	$Success = 0;
	if (!$nickname) {
		$Success++;
		$Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span>Vui Lòng Nhập Biệt Danh Của Bạn</div>';
	}
	if (strlen($nickname) < 6) {
		$Success++;
		$Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span>Biệt Danh phải nhiều hơn 6 kí tự</div>';
	}
	if (strlen($quote) > 50) {
		$Success++;
		$Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span>Châm Ngôn Sống Không Được Quá 50 Ký Tự</div>';
	}
	if ($Success == 0) {
		$mysql->update("user", "nickname = '$nickname',quote = '$quote'", "email = '$useremail'");
		header("Refresh:0");
		$Notice .= '<div class="noti-success flex flex-hozi-center"><span class="material-icons-round margin-0-5">success</span>Cập Nhật Hồ Sơ Thành Công</div>';
	}
}
$configs = getConfigGeneralUserInfo([
	'vip_package',
	'join_telegram',
	'first_login',
	'online_reward',
	'farm_tree',
	'comment',
	'first_upload_avatar',
	'vip_icon',
	'deposit_money',
	'vip_fee',
]);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
	<?php
	$title = "Trang Quản Lý Tài Khoản - {$cf['title']}";
	require_once(ROOT_DIR . '/view/head.php');
	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" />
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
	<style>
		body {
			color: #ccc;
		}

		a {
			color: #cac9c9;
			text-decoration: none;
		}

		@keyframes cssProgressActive {
			0% {
				background-position: 0 0;
			}

			100% {
				background-position: 35px 35px;
			}
		}

		.hvr-sweep-to-right {
			display: inline-block;
			vertical-align: middle;
			-webkit-transform: perspective(1px) translateZ(0);
			transform: perspective(1px) translateZ(0);
			box-shadow: 0 0 1px transparent;
			position: relative;
			-webkit-transition-property: color;
			transition-property: color;
			-webkit-transition-duration: .3s;
			transition-duration: .3s;
		}

		.hvr-sweep-to-right::before {
			content: "";
			position: absolute;
			z-index: -1;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background: #989898;
			-webkit-transform: scaleX(0);
			transform: scaleX(0);
			-webkit-transform-origin: 0 50%;
			transform-origin: 0 50%;
			-webkit-transition-property: transform;
			transition-property: transform;
			-webkit-transition-duration: .3s;
			transition-duration: .3s;
			-webkit-transition-timing-function: ease-out;
			transition-timing-function: ease-out;
		}

		.hvr-sweep-to-right:hover,
		.hvr-sweep-to-right:focus,
		.hvr-sweep-to-right:active {
			color: #fff;
		}

		.hvr-sweep-to-right:hover:before,
		.hvr-sweep-to-right:focus:before,
		.hvr-sweep-to-right:active:before {
			-webkit-transform: scaleX(1);
			transform: scaleX(1);
		}

		.progress {
			width: 100%;
			height: 20px;
			background: #858585;
			border-radius: 3px;
			overflow: hidden;
			margin-top: 10px;
			border: 0;
			-webkit-box-shadow: inset 0 1px 2px 0 rgba(0, 0, 0, 0.5), 0px 1px 0 0 #FFF;
			-moz-box-shadow: inset 0 1px 2px 0 rgba(0, 0, 0, 0.5), 0px 1px 0 0 #FFF;
			box-shadow: inset 0 1px 2px 0 rgba(0, 0, 0, 0.5), 0px 1px 0 0 #FFF;
		}

		.progress .progress-bar {
			display: block;
			height: 100%;
			text-align: center;
			line-height: 20px;
			font-size: 12px;
			padding: 0;
			font-weight: 700;
			-webkit-background-size: 35px 35px;
			background-color: #009dff;
			background-image: linear-gradient(-45deg, rgba(255, 255, 255, 0.125) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.125) 50%, rgba(255, 255, 255, 0.125) 75%, transparent 75%, transparent);
			box-shadow: inset 0 1px 0 0 #98d8ff, inset 0 -1px 1px #3a91c8;
			border: 1px solid #31607d;
			animation: cssProgressActive 2s linear infinite;
		}

		.profile {
			background-color: #404040;
			display: flex;
			padding: 10px;
		}

		.profile .navigation {
			width: 30%
		}

		.profile .navigation .avatar {
			display: flex;
			padding: 20px;
			background-color: #505050;
			margin-bottom: 24px;
		}

		.profile .navigation .avatar .img {
			position: relative;
		}

		.profile .navigation .avatar .img .upload-avatar {
			position: absolute;
			bottom: -30px;
			left: 0;
			border: 1px solid transparent;
			border-radius: 40px;
			line-height: 1.3;
			padding: 5px 7px;
			font-size: 10px;
			color: #fff;
			min-width: 80px;
			font-weight: bold;
			background: #6b6a6a;
			box-shadow: 0 1px 3px rgb(0 0 0 / 12%), 0 1px 2px rgb(0 0 0 / 24%);
		}

		.profile .navigation .avatar .img img {
			width: 80px;
			height: auto;
			border-radius: 50%;
		}

		.profile .navigation .avatar .profile-info {
			width: calc(100% - 90px);
			margin-left: 10px;
			display: flex;
			flex-direction: column;
			justify-content: center;
		}

		.profile .navigation .avatar .profile-info h3 {
			margin-bottom: 5px;
			color: #ffffff;
		}

		.profile .navigation .avatar .profile-info .coin img {
			width: 15px;
			height: 15px;
			position: relative;
		}

		.profile .navigation .avatar .profile-info .coin {
			display: flex;
			align-items: center;
			column-gap: 10px;
			color: #ff9393;
			font-weight: 600;
		}

		.profile .navigation .level {
			padding: 10px;
			background-color: #505050;
			border-radius: 8px;
			margin-bottom: 10px;
		}

		.profile .navigation .level .level-info {
			display: flex;
			align-items: center;
			justify-content: space-between;
		}

		.profile .info {
			width: 100%;
		}

		.profile .navigation .menu ul {
			background: #666565;
			list-style-type: none;
			padding: 0;
			border: 0;
		}

		.profile .navigation .menu ul li {
			width: calc(100% - 3px);
		}

		.profile .navigation .menu ul li:has(a.active) {
			background: #989898;
			border-left: 3px solid #2aa5f2;
		}


		.profile .navigation .menu .nav-tabs .nav-link.active {
			background-color: unset;
			border: 0;
		}


		.profile .navigation .menu ul li a {
			display: block !important;
			color: #ffffff;
			padding: 9px 30px;
		}

		.nav-tabs .nav-link:focus,
		.nav-tabs .nav-link:hover {
			border: 0;
		}

		.profile .navigation .menu ul li.active a {
			font-weight: 700;
		}

		.profile .info {
			padding: 10px;
			padding-left: 16px;
		}

		.profile .info .tab-content .tab-title {
			color: #ffffff;
			border-left: 3px solid #2aa5f2;
			padding-left: 10px;
		}

		.profile .info .tab-content .tab-body .input-zero .label {
			background: unset;
		}

		.profile .info .tab-content .tab-body .input-zero {
			display: flex;
			margin-bottom: 16px;
		}

		.profile .info .tab-content .tab-body .input-zero .label {
			min-width: 130px;
		}

		.profile .info .tab-content .tab-body .input-zero .input {
			width: calc(100% - 130px);
		}

		.profile .info .tab-content .tab-body .input-zero p:not(.label) {
			color: #ffffff;
		}

		.profile .info .tab-content #tab-movie-history .watch-history .item a>div:first-child {
			width: 75px;
			height: 75px;
		}

		.profile .info .tab-content #tab-movie-history .watch-history .item a>div:last-child:before {
			height: 103%;
		}

		.profile .info .tab-content #tab-movie-history .watch-history .item a>div:last-child {
			padding: 5px;
		}

		.profile .info .tab-content #tab-movie-history .watch-history .item a img {
			width: 100%;
		}

		.profile .info .tab-content #tab-movie-follow .movie-follow .delete  {
			position: absolute;
			z-index: 3;
			right: 0;
			background: #000;
			padding: 5px 10px;
			top: 0;
			color: #fff;
		}

		.profile .info .tab-content #tab-update-profile #form-change-password .invalid-feedback {
			min-height: 20px;
			display: block;
			visibility: hidden;
		}
		.profile .info .tab-content #tab-update-profile #form-change-password .is-invalid~.invalid-feedback {
			visibility: visible;
		}
		
	</style>
</head>

<body class="scroll-bar">
	<div id="fb-root"></div>
	<div id="ah_wrapper">
		<?php require_once(ROOT_DIR . '/view/header.php'); ?>
		<div class="ah_content">
			<?php require_once(ROOT_DIR . '/view/top-note.php'); ?>
			<!-- css profile  -->
			<style>
				/* #1. thông tin chung  */
				#tab-profile a {
					color: #0d6efd;
				}

				.account-info .info-detail .group .detail {
					display: table-cell;
					font-weight: 500;
				}

				.user-page .account-info {
					position: relative;
					margin-bottom: 30px;
				}

				.user-page .posttitle {
					font-weight: 500;
					border-left: 3px solid #2aa5f2;
					padding-left: 10px;
					font-size: 18px;
					line-height: 1.5;
					margin: 0 0 20px;
					min-height: 27px;
				}

				.account-info .info-detail {
					border: 1px solid #d9d9d9;
					border-radius: 3px;
					padding: 15px 20px;
				}

				.account-info .info-detail .group {
					margin-bottom: 10px;
				}

				.account-info .info-detail .group .label {
					min-width: 200px;
					float: left;
					width: 100px;
					color: #ffffff;
					font-size: 100%;
					text-align: left;
					font-weight: 400;
					display: inline-table;
				}

				.info-detail {
					font-size: 13px;
				}

				/* 1// end - thông tin chung  */
				/* 3. [phim theo dõi]   */
				.movies-list .movie-item {
					width: 25%;
					font-family: Comfortaa, sans-serif;
				}

				/* End #. [Phim theo dõi]  */

				/* [Lịch Sử Xem Phim] */
				ul.list-film {
					overflow: hidden;
					clear: both;
					padding: 4px;
					font-size: 11px;
					padding: 3px;
				}

				.film_lastwatch_grid {
					padding: 5px;
					margin: 0 5px 10px;
					position: relative;
					color: #000;
					line-height: 1.5em;
					font-size: 1.1em;
					display: grid;
					grid-template-columns: 120px calc(100% - 120px);
					height: 70px;
					overflow: hidden;
					border: 1px solid#e7e7e7;
					border-radius: 10px;
					background: #f9f9f9;
				}

				.film_lastwatch_round {
					position: relative;
					/* min-height: 70px; */
					/* border-radius: 7px; */
					overflow: hidden;
				}

				.film_lastwatch_iconplay {
					width: 40px;
					transform: translate(-50%, -50%) !important;
					left: 50%;
					top: 50%;
					position: absolute;
					display: none;
				}

				.film_lastwatch_title_deswap {
					display: none;
				}

				.film_lastwatch_title_desweb {
					padding-left: 15px;
					max-height: 65px;
					overflow: hidden;
				}

				.film_lastwatch_timeline {
					display: none;
					position: absolute;
					left: 0;
					bottom: 0;
					padding: 2px;
					background: red;
					color: #fff;
				}

				/* [Lịch Sử Xem Phim] */

				/* [thông báo -css] */
				.wrappertab_notification {
					background: #fff;
					border-top: none;
					border-bottom: none;
					padding: 15px 5px 10px;
					overflow: hidden;
				}

				.wrappertab_notification .tab_notification.active {
					background: #2aa5f2;
					border: 1px solid #2aa5f2;
					color: #fff;
				}

				.wrappertab_notification .tab_notification {
					color: #7e7e7e;
					border: 1px solid #2aa5f2;
					margin: 0 10px;
					line-height: 26px;
					font-family: Arial, Helvetica, sans-serif;
					display: inline-block;
					padding: 5px 10px;
					border-radius: 10px;
					cursor: pointer;
				}

				.tab_notification.active a {
					color: #fff;
				}

				.wrappertab_notification .tab_notification {
					color: #7e7e7e;
					border: 1px solid #2aa5f2;
					margin: 0 10px;
					line-height: 26px;
					font-family: Arial, Helvetica, sans-serif;
					display: inline-block;
					padding: 5px 10px;
					border-radius: 10px;
					cursor: pointer;
				}

				.noti {
					padding: 10px;
					border-bottom: 1px solid #e9e9e9;
				}

				.noti-two {
					padding: 10px 0;
					font-size: 0.8em;
					color: #777;
				}

				.noti-two span {
					color: #FFF;
					padding-right: 10px;
					cursor: pointer;
				}

				.center {
					text-align: center;
					cursor: pointer;
				}

				/* [End - thông báo ] */

				/* [bình luận] */
				.cmt-time {
					padding-left: 15px;
				}
			</style>
			<!-- end-css-profile  -->

			<div class="profile">
				<div class="navigation">
					<!-- Avatar -->
					<div class="avatar">
						<div class="img">
							<img src="<?= $user['avatar'] ?>" />
							<button class="upload-avatar" type="button" onclick="showModal()"><i class="fa fa-cloud-upload"></i> Up Avatar</button>
						</div>
						<div class="profile-info">
							<h3><?= $user['nickname'] ?></h3>
							<p class="coin"><img src="/themes/img/coin_15.gif" alt=""> <?= number_format($user['coins']) ?> XU</p>
						</div>
					</div>
					<!-- Level -->
					<div class="level">
						<div class="level-info">
							<p style="color: <?= LevelColor($user['level']) ?>">Cấp <?= $user['level'] ?></p>
							<p style="color: <?= LevelColor($user['level'] + 1) ?>">Cấp <?= $user['level'] + 1 ?></p>
						</div>
						<div class="progress">
							<span class="progress-bar" style="width: 50%">50%</span>
						</div>
					</div>
					<!-- Menu -->
					<nav class="menu">
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item menu-item hvr-sweep-to-right">
								<a class="nav-link active" href="#tab-profile" data-bs-toggle="tab">
									<i class="fa-solid fa-info-circle"></i> Thông tin chung
								</a>
							</li>
							<li class="nav-item menu-item hvr-sweep-to-right">
								<a class="nav-link" href="#tab-update-profile" data-bs-toggle="tab">
									<i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa thông tin
								</a>
							</li>
							<li class="nav-item menu-item hvr-sweep-to-right">
								<a class="nav-link" href="#tab-movie-follow" data-bs-toggle="tab">
									<i class="fa-solid fa-plus"></i> Phim theo dõi
								</a>
							</li>
							<li class="nav-item menu-item hvr-sweep-to-right">
								<a class="nav-link" href="#tab-movie-history" data-bs-toggle="tab">
									<i class="fa-solid fa-history"></i> Lịch sử xem phim
								</a>
							</li>
							<li class="nav-item menu-item hvr-sweep-to-right">
								<a class="nav-link" href="#tab-notification" data-bs-toggle="tab">
									<i class="fa-solid fa-bell"></i> Thông báo
								</a>
							</li>
							<li class="nav-item menu-item hvr-sweep-to-right">
								<a class="nav-link" href="#tab-comment" data-bs-toggle="tab">
									<i class="fa fa-comment"></i> Bình Luận
								</a>
							</li>
							<li class="nav-item menu-item hvr-sweep-to-right">
								<a class="nav-link" href="/dang-xuat">
									<i class="fa-solid fa-sign-out"></i> Đăng xuất
								</a>
							</li>
						</ul>
					</nav>
				</div>
				<!-- Tab content -->
				<div class="info">
					<div class="tab-content">
						<div class="tab-pane fade show active" id="tab-profile">
							<h4 class="tab-title">Thông tin chung</h4>
							<div class="tab-body">
								<div class="account-info clearfix">
									<h2 class="posttitle">Nhiệm vụ mỗi ngày</h2>
									<div class="info-detail">
										<div class="group">
											<div class="label">Gói VIP ADS:</div>
											<div class="detail">
												<?=nl2br($configs['vip_package'])?><br>
												<i class="fa fa-long-arrow-right" aria-hidden="true"></i> <a href="/store#vip">Mua VIP ADS tắt quảng cáo tại đây</a>
											</div>
										</div>
										<div class="group">
											<div class="label">Tham gia nhóm Telegram:</div>
											<div class="detail"><?=$configs['join_telegram']?><br><i class="fa fa-long-arrow-right" aria-hidden="true"></i> <a href="/user_edit">Tham gia nhóm nhận thông báo quan trọng tại đây</a></div>
										</div>
										<div class="group">
											<div class="label">Đăng nhập mỗi ngày:</div>
											<div class="detail"><?=$configs['first_login']?></div>
										</div>
										<div class="group">
											<div class="label">OnLine:</div>
											<div class="detail">
												<?=nl2br($configs['online_reward'])?>
											</div>
										</div>
										<div class="group">
											<div class="label">Cây khế nông trại:</div>
											<div class="detail"><?=$configs['farm_tree']?></div>
										</div>
										<div class="group">
											<div class="label">Bình luận:</div>
											<div class="detail"><?=$configs['comment']?></div>
										</div>
										<div class="group">
											<div class="label">Up Avatar:</div>
											<div class="detail"><?=$configs['first_upload_avatar']?></div>
										</div>
										<div class="group">
											<div class="label">Vip Icon:</div>
											<div class="detail"><?=$configs['vip_icon']?></div>
										</div>
										<div class="group">
											<div class="label">Sưu tầm khung viền:</div>
											<div class="detail"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> <a href="/store#khungvien">Mua khung viền</a></div>
										</div>
										<div class="group">
											<div class="label">Nạp Xu:</div>
											<div class="detail">
												<?=nl2br($configs['deposit_money'])?><br>
												<i class="fa fa-long-arrow-right" aria-hidden="true"></i> <a href="#">Nạp Xu ở đây</a>
											</div>
										</div>
										<div class="group">
											<div class="label">Giá Vip / Tháng:</div>
											<div class="detail">
												<?=$configs['vip_fee']?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="tab-update-profile">
							<h4 class="tab-title">Chỉnh sửa thông tin</h4>
							<div class="tab-body">
								<div class="account-info clearfix">
									<h2 class="posttitle">Chỉnh sửa / cập nhật tài khoản</h2>
									<div class="info-detail">
										<div class="grid-body no-border">
											<div class="row">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<div class="form-group">
														<label class="form-label">Tham gia nhóm telegram nhận thông báo quan trọng bằng cách</label><br><br>
														Cách 1: Click vào đường <a style="color: #009dff;" href="https://t.me/+P91IG7VRyvc1NGY9">link</a> này: <span style="color: #009dff;"> https://t.me/+P91IG7VRyvc1NGY9</span> <br><br>
														Cách 2: Truy cập telegram trên điện thoại hoặc máy tính </br>
														Tìm kiếm người dùng với từ khóa: <span style="color: #00FF00;"> My-anime </span>
														<br><br><img src="http://localhost/assets/upload/1-img-anime.png" style="max-width:500px"><br><br>
														<p></p>
														<br><br>
													</div>
												</div>
											</div>
										</div>
										<br><br><br>
										<div class="change-password-content">
											<form method="POST" id="form-change-password">
												<div class="mb-3">
													<label for="new_password" class="mb-1">Mật khẩu mới</label>
													<input id="new_password" name="new_password" type="password" class="form-control" placeholder="Nhập nếu muốn đổi" autocomplete="false">
													<p class="invalid-feedback mb-0"></p>
												</div>
												<div class="text-end">
													<button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="tab-movie-follow">
							<h4 class="tab-title">Phim theo dõi</h4>
							<div class="movie-follow">
								
							</div>
						</div>
						<div class="tab-pane fade" id="tab-movie-history">
							<h4 class="tab-title">Lịch sử xem phim</h4>
							<div class="tab-body">
								<div class="display_axios watch-history">
									<div class="ah_loading">
										<div class="lds-ellipsis">
											<div></div>
											<div></div>
											<div></div>
											<div></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="tab-notification">
							<h4 class="tab-title">Thông báo</h4>
							<div class="col-md-12 col-sm-8" id="list-item"></div>
							<div id="active_show"></div>
						</div>
						<div class="tab-pane fade" id="tab-comment">
							<h4 class="tab-title">Bình Luận</h4>
							<section class="list-comment clearfix"></section>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php require_once(ROOT_DIR . '/view/footer.php'); ?>
	</div>
</body>
<script>
	// show Tab Notificaiton 
	function showTab(tabId) {
		// #1. lấy all element tab content 
		var tabContents = document.querySelectorAll('.tab_content_notification');
		// #2. ân tất cả
		tabContents.forEach(function(content) {
			content.style.display = 'none';
		});
		// #3. show tab id được click
		document.getElementById(tabId).style.display = 'block';
	}
	// doing
	function AddActive() {

	}
</script>

<script type="text/javascript">
	// start tab-update-profile
		$(document).ready(function() {
			let form = $('#form-change-password');
			let new_password = form.find('[name="new_password"]');
			let btn = form.find('.btn[type="submit"]');
			let form_error = form.find('.form-error');
			
			form.submit(function() {
				let error = 0;
				
				if (!new_password.val()) {
					new_password.focus();
					new_password.addClass('is-invalid');
					new_password.next().html('Nhập mật khẩu mới');
					error = 1;
				} else {
					new_password.removeClass('is-invalid');
				}

				if (new_password.val().length < 6) {
					new_password.focus();
					new_password.addClass('is-invalid');
					new_password.next().html('Mật khẩu đặt phải nhiều hơn 6 kí tự');
					error = 1;
				} else {
					new_password.removeClass('is-invalid');
				}

				if (error == 0) {
					Promise.all([changePassword(new_password.val())])
					.then(function(responses) {
						let rs = responses[0].data;
						if (rs.status=='success') {
							new_password.removeClass('is-invalid');
							new_password.val('');
							alert(rs.result);
						} else {
							new_password.focus();
							new_password.addClass('is-invalid');
							new_password.next().html(rs.result);
						}
					})
					.catch(function(error) {
						console.error(error);
					});
				}

				return false;
			});
		});

		function changePassword(new_password) {
			if (new_password) {
				return axios.post(
					'/server/api', {
						"action": "change_password",
						"new_password": new_password,
					}
				);
			}

			return false;
		}
	// end tab-update-profile

	// Movie watch history
	const _0x3047 = ['getItem', 'post', '/server/api', 'getElementsByClassName', 'addEventListener', 'stringify', 'data_history', 'display_axios', 'log', 'innerHTML', 'parse', 'data'];
	(function(_0x150929, _0x209022) {
		const _0x304767 = function(_0x4e0512) {
			while (--_0x4e0512) {
				_0x150929['push'](_0x150929['shift']());
			}
		};
		_0x304767(++_0x209022);
	}(_0x3047, 0x7b));
	const _0x4e05 = function(_0x150929, _0x209022) {
		_0x150929 = _0x150929 - 0x1c2;
		let _0x304767 = _0x3047[_0x150929];
		return _0x304767;
	};
	(() => {
		const _0x80f4a7 = _0x4e05;
		document[_0x80f4a7(0x1c3)]('DOMContentLoaded', function(_0xa7e55) {
			const _0x560c85 = async () => {
				const _0xa4745d = _0x4e05;
				try {
					let _0x142d51 = document[_0xa4745d(0x1c2)](_0xa4745d(0x1c6))[0x0],
						_0x45dda4 = await loadHistorymovie(),
						_0x2f4f4f = _0x45dda4[_0xa4745d(0x1ca)];
					_0x142d51[_0xa4745d(0x1c8)] = _0x2f4f4f;
				} catch (_0x122e7c) {
					console[_0xa4745d(0x1c7)](_0x122e7c);
				}
			};
			_0x560c85();
		}), loadHistorymovie = () => {
			const _0xbb09c4 = _0x80f4a7,
				_0x1ec641 = localStorage[_0xbb09c4(0x1cb)]('data_history'),
				_0x4a6ccd = _0x1ec641 ? JSON[_0xbb09c4(0x1c9)](_0x1ec641) : [];
			return axios[_0xbb09c4(0x1cc)](_0xbb09c4(0x1cd), {
				'action': _0xbb09c4(0x1c5),
				'data_history': JSON[_0xbb09c4(0x1c4)](_0x4a6ccd)
			});
		};
	})();

	// End movie watch history

	// Movie follow
	var run_ax = true;

	(() => {
		document.addEventListener("DOMContentLoaded", function(event) {
			const dataFollow = async () => {
				try {
					let movie_follow = document.getElementsByClassName('movie-follow')[0];
					let response = await loadFollowmovie();
					let data = response.data;
					movie_follow.innerHTML = data;
				} catch (e) {
					console.log(e)
				}
			};
			$user.id && asyncFollow();
			dataFollow();
		});
	})();

	asyncFollow = async () => {
		let local_store = localStorage.getItem("data_follow");
		let data_follow_store = local_store ? JSON.parse(local_store) : [];
		var check_async_follow = localStorage.getItem("async_follow");
		await securityCode();
		if (!check_async_follow) {
			await axios.post('/server/api', {
				"action": 'async_follow',
				"token": $dt.token,
				"data_follow": JSON.stringify(data_follow_store),
			}).then(reponse => {
				run_ax = true;
				if (reponse.data == "success") {
					localStorage.setItem("async_follow", true);
					let success = document.createElement("div");
					let el_ah_follows = document.getElementsByClassName("ah_follows")[0];
					success.setAttribute('class', 'noti-success');
					success.innerHTML = 'Đồng bộ phim theo dõi lưu trên trình duyệt sang tài khoản thành công!';
					el_ah_follows.insertBefore(success, el_ah_follows.childNodes[2]);
					location.reload();
				}
			}).catch(e => run_ax = true)
		}
	}

	loadFollowmovie = () => {
		let local_store = localStorage.getItem("data_follow");
		let data_follow_store = local_store ? JSON.parse(local_store) : [];
		return axios.post(
			'/server/api', {
				"action": "data_follow",
				"data_follow": JSON.stringify(data_follow_store),
				"page_now": 1
			}
		);
	}

	followGuestmovie = (e, movie_id) => {
		let local_store = localStorage.getItem("data_follow");
		let data_follow_store = local_store ? JSON.parse(local_store) : [];
		var index_this_movie = data_follow_store.indexOf(movie_id);
		if (index_this_movie !== -1) {
			data_follow_store.splice(index_this_movie, 1);
			e.target.parentNode.remove();
			Toast({
				message: "Xoá theo dõi thành công!",
				type: "success"
			});
		}
		localStorage.setItem("data_follow", JSON.stringify(data_follow_store));
	}

	delFollowmovie = (e, movie_id) => {
		e.preventDefault();
		if (!$user.id) {
			followGuestmovie(e, movie_id)
		} else {
			if (run_ax) {
				run_ax = false;
				axios.post('/server/api', {
					"action": 'del_follow',
					"movie_id": movie_id,
				}).then(reponse => {
					run_ax = true;
					if (reponse.data == "success") {
						followGuestmovie(e, movie_id)
					} else {
						alert('Xoá theo dõi thất bại, thử lại sau!');
					}
				}).catch(e => run_ax = true)
			}
		}
	}

	// End movie follow

	// Notification
	var loaded_noti = true;
	(function() {
		Observer("active_show", async function() {
			if (loaded_noti) {
				let id_load_more = document.getElementById("list-item").lastElementChild;
				id_load_more = id_load_more ? parseInt(id_load_more.attributes[1].value) || 0 : 0;
				console.log(id_load_more);
				loaded_noti = await loadNotification("list-item", id_load_more, loaded_noti);
				//if (loaded_noti.status == "failed") 
				loaded_noti = false;
			}
		}, false)
	}());
	// End Notification

	// Comment
	$(document).ready(async function() {
		let response = await getListComment();
		let content = '';

		if (response.status == 200) {
			if (response.data.status == "success") {
				content = response.data.result;
			} else {
				content = 'Không có bình luận';
			}
		} else {
			content = 'Không có bình luận';
		}
		
		$('#tab-comment .list-comment').html(content);
	});

	function getListComment() {
		return axios.post('/server/api', {
			"action": 'list_comment',
			"token": $dt.token,
		});
	}
	// End comment

</script>

</html>