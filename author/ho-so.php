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
?>
<!DOCTYPE html>
<html lang="vi">

<head>
	<?php
	$title = "Trang Quản Lý Tài Khoản - {$cf['title']}";
	require_once(ROOT_DIR . '/view/head.php');
	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css"/>
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

		.hvr-sweep-to-right:hover, .hvr-sweep-to-right:focus, .hvr-sweep-to-right:active {
			color: #fff;
		}

		.hvr-sweep-to-right:hover:before, .hvr-sweep-to-right:focus:before, .hvr-sweep-to-right:active:before {
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
			-webkit-box-shadow: inset 0 1px 2px 0 rgba(0,0,0,0.5), 0px 1px 0 0 #FFF;
			-moz-box-shadow: inset 0 1px 2px 0 rgba(0,0,0,0.5),0px 1px 0 0 #FFF;
			box-shadow: inset 0 1px 2px 0 rgba(0,0,0,0.5), 0px 1px 0 0 #FFF;
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
			background-image: linear-gradient(-45deg,rgba(255,255,255,0.125) 25%,transparent 25%,transparent 50%,rgba(255,255,255,0.125) 50%,rgba(255,255,255,0.125) 75%,transparent 75%,transparent);
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
			width: 70%
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

		.nav-tabs .nav-link:focus, .nav-tabs .nav-link:hover {
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
		
	</style>
</head>

<body class="scroll-bar">
	<div id="fb-root"></div>
	<div id="ah_wrapper">
		<?php require_once(ROOT_DIR . '/view/header.php'); ?>
		<div class="ah_content">
			<?php require_once(ROOT_DIR . '/view/top-note.php'); ?>
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
							<p style="color: <?= LevelColor($user['level']+1) ?>">Cấp <?= $user['level']+1 ?></p>
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
								<a class="nav-link" href="/">
									<i class="fa-solid fa-sign-out"></i> Thoát
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
								<div class="input-zero">
									<p class="label">Biệt danh:</p>
									<p><?= $user['nickname'] ?></p>
								</div>
								<div class="input-zero">
									<p class="label">Châm ngôn:</p>
									<p><?= $user['quote'] ?></p>
								</div>
								<div class="input-zero">
									<p class="label">Icon:</p>
									<p><?= LevelIcon($user['level'], 18, 18) ?><?= UserIcon($user['id'], 18, 18) ?></p>
								</div>
								<div class="input-zero">
									<p class="label">Cảnh Giới:</p>
									<p><b style="color:<?= LevelColor($user['level']) ?>"><?= Danh_Hieu($user['level']) ?></b></p>
								</div>
								<div class="input-zero">
									<p class="label">Email:</p>
									<p><?= $user['email'] ?></p>
								</div>
								<div class="input-zero">
									<p class="label">Ngày tham gia:</p>
									<p><?= $user['time'] ?></p>
								</div>
								<div class="input-zero">
									<p class="label">Kinh nghiệm:</p>
									<p><?= $user['exp'] ?>/<?= ($user['level'] * 30) ?></p>
								</div>
								<div class="input-zero">
									<p class="label">Tiền xu:</p>
									<p><?= number_format($user['coins']) ?></p>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="tab-update-profile">
							<h4 class="tab-title">Chỉnh sửa thông tin</h4>
							<div class="tab-body">
								<div id="message-line"> <?= $Notice ?></div>
								<form action="" method="post" id="form-user-profile" class="ah-frame-bg border-radius-0">
									<div class="input-zero">
										<div class="label">Biệt danh</div>
										<div class="input"><input name="nickname" value="<?= $user['nickname'] ?>" type="text" placeholder="Nhập biệt danh của bạn"></div>
									</div>
									<div class="input-zero">
										<div class="label">Châm ngôn</div>
										<div class="input"><input name="quote" value="<?= $user['quote'] ?>" type="text"></div>
									</div>
									<div class="flex flex-ver-center">
										<button type="submit" name="change_profile" value="submit" class="button-default bg-red color-white">
											<span class="material-icons-round margin-0-5">save</span> Lưu
										</button>
									</div>
								</form>
							</div>
						</div>
						<div class="tab-pane fade" id="tab-movie-follow">
							<h4 class="tab-title">Phim theo dõi</h4>
						</div>
						<div class="tab-pane fade" id="tab-movie-history">
							<h4 class="tab-title">Lịch sử xem phim</h4>
							<div class="tab-body">
								<div class="display_axios">
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
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php require_once(ROOT_DIR . '/view/footer.php'); ?>
	</div>
</body>
<script type="text/javascript">
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
</script>

</html>