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
	'deposit_min',
	'deposit_rate',
	'deposit_exp',
	'vip_fee',
]);

$paypalConfig = [
	'client_id'	=>	'AYldjoFRqHN-fq47TxTzcg9pQc6f-Z8jYqqbTaVniT4bCdoD4fZwp37Zjv--L2ffBnmkS7M99P8medCf',
];

global $mysql;
$sql = "SELECT `id`, `icon`, `price` FROM `table_khung_vien` ORDER BY `price` DESC LIMIT 100";
$query = $mysql->query($sql);
$listAvatarFrame = [];

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
	$listAvatarFrame[$row['id']] = [
		'price'	=>	$row['price'],
		'icon'	=>	$row['icon'],
	];
}

$sql = "SELECT `frame_id` FROM table_user_avatar_frame WHERE `user_id` = " . $user['id'] . " LIMIT 100";
$query = $mysql->query($sql);
$listUserFrame = [];

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
	$listUserFrame[] = $row['frame_id'];
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
	<?php
	$title = "Trang Quản Lý Tài Khoản - {$cf['title']}";
	require_once(ROOT_DIR . '/view/head.php');
	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"></script>
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script> -->
	<script type="text/javascript" src="/themes/js_ob/croppie.js?v=1.7.4"></script>
	<link href="/themes/styles/croppie.css?v=1.4.0" rel="stylesheet" />
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.10.0/autoNumeric.min.js"></script> -->
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
	<link href="/themes/styles/ho-so.css?v=<?= time() ?>" rel="stylesheet" />
</head>

<body class="scroll-bar">
	<div id="fb-root"></div>
	<div id="ah_wrapper">
		<?php require_once(ROOT_DIR . '/view/header.php'); ?>
		<div class="ah_content">
			<div class="profile">
				<div class="navigation">
					<!-- Avatar -->
					<div class="avatar">
						<div class="img">
							<img src="<?= $user['avatar'] ?>" />
							<img src="<?= $user['frame'] ?>" alt="" class="avatar-frame">
							<button class="upload-avatar" type="button" onclick="showModal()"><i class="fa fa-cloud-upload"></i> Up Avatar</button>
						</div>
						<div class="profile-info">
							<h3><?= $user['nickname'] ?></h3>
							<p class="coin"><img src="/themes/img/coin_15.gif" alt=""> <?= number_format($user['coins']) ?> Xu</p>
						</div>
					</div>
					<!-- // doing  -->
					<?php if ($user['vip'] == 1) {
					?>
						<div class="vip-info" data-vip_date_end=<?= date("Y-m-d H:i:s", $user['vip_date_end'])?>>
							<img style="width: 70px;" src="<?= $vipIcon ?>" />
							<p class="days">Còn </p>
						</div>
					<?php
					} ?>

					<!-- Level -->
					<div class="level">
						<div class="level-info">
							<p style="color: <?= LevelColor($user['level']) ?>">Cấp <?= $user['level'] ?></p>
							<p style="color: <?= LevelColor($user['level'] + 1) ?>">Cấp <?= $user['level'] + 1 ?></p>
						</div>
						<div class="progress">
							<?php
							$exp = number_format(($user['exp'] * 100) / getExpLevel($user['level']), 0, ',', '.');
							?>
							<span class="progress-bar" style="width: <?= $exp ?>%"><?= $exp . '%' ?></span>
						</div>
					</div>
					<!-- Menu -->
					<nav class="menu">
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item menu-item hvr-sweep-to-right">
								<a class="nav-link" href="#tab-profile" data-bs-toggle="tab">
									<i class="fa-solid fa-info-circle"></i> Thông tin chung
								</a>
							</li>
							<li class="nav-item menu-item hvr-sweep-to-right">
								<a class="nav-link active" href="#tab-deposit" data-bs-toggle="tab">
									<i class="fa-solid fa-cart-plus"></i> Nạp Xu
								</a>
							</li>
							<li class="nav-item menu-item hvr-sweep-to-right">
								<a class="nav-link" href="#tab-update-profile" data-bs-toggle="tab">
									<i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa thông tin
								</a>
							</li>
							<li class="nav-item menu-item hvr-sweep-to-right">
								<a class="nav-link " href="#tab-cart" data-bs-toggle="tab">
									<i class="fa-solid fa-cart-shopping"></i> Cửa hàng vật phẩm
								</a>
							</li>
							<li class="nav-item menu-item hvr-sweep-to-right">
								<a class="nav-link" href="#tab-movie-follow" data-bs-toggle="tab">
									<i class="fa-solid fa-heart"></i> Phim theo dõi
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
						<!-- // doing  -->
							<p class="text-while" id="thongbao"> </p>
						<div class="tab-pane fade" id="tab-profile">
						    
							<h4 class="tab-title mb-3">Tủ đồ cá nhân</h4>
							<div class="tab-body mb-4 tab-avatar-frame-content">
								<ul class="nav nav-tabs mb-2" role="tablist">
									<li class="nav-item menu-item hvr-sweep-to-right">
										<a class="nav-link active" href="#tab-user-owned-frame" data-bs-toggle="tab">
											KHUNG VIỀN
										</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane fade show active" id="tab-user-owned-frame">
										<div class="tab-body">
											<div class="list-owned-frame">
												<?php foreach ($listAvatarFrame as $k => $v) : ?>
													<?php if (in_array($k, $listUserFrame)) : ?>
														<div class="frame-owned" data-id="<?= $k ?>" data-frame="<?= $v['icon'] ?>">
															<img src="<?= $v['icon'] ?>" alt="">
														</div>
													<?php endif ?>
												<?php endforeach ?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<h4 class="tab-title">Thông tin chung</h4>
							<div class="tab-body">
								<div class="account-info clearfix">
									<h2 class="posttitle">Nhiệm vụ mỗi ngày</h2>
									<div class="info-detail">
										<div class="group">
											<div class="label">Gói VIP ADS:</div>
											<div class="detail">
												<?= nl2br($configs['vip_package']) ?><br>
												<i class="fa fa-long-arrow-right" aria-hidden="true"></i>
												<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#VipModal">
													Mua VIP ADS tắt quảng cáo tại đây
												</button>
												<!-- <a href="/store#vip">Mua VIP ADS tắt quảng cáo tại đây</a> -->
												<!-- <i class="fa fa-long-arrow-right" aria-hidden="true"></i> <a href="/store#vip">Mua VIP ADS tắt quảng cáo tại đây</a> -->
											</div>
										</div>
										<div class="group">
											<div class="label">Tham gia nhóm Telegram:</div>
											<div class="detail">
												+<?= $configs['join_telegram'] ?> Xu<br>
												<i class="fa fa-long-arrow-right" aria-hidden="true"></i>
												<a href="/user_edit">Tham gia nhóm nhận thông báo quan trọng tại đây</a>
											</div>
										</div>
										<div class="group">
											<div class="label">Đăng nhập mỗi ngày:</div>
											<div class="detail">+<?= $configs['first_login'] ?> Xu</div>
										</div>
										<div class="group">
											<div class="label">OnLine:</div>
											<div class="detail">
												<?= nl2br($configs['online_reward']) ?>
											</div>
										</div>
										<div class="group">
											<div class="label">Cây khế nông trại:</div>
											<div class="detail"><?= $configs['farm_tree'] ?></div>
										</div>
										<div class="group">
											<div class="label">Bình luận:</div>
											<div class="detail">
												Mỗi bình luận trong bộ phim trong 1 ngày + <?= $configs['comment'] ?> xu (chỉ tính bình luận đầu tiên trong ngày của bộ phim đó ).
											</div>
										</div>
										<div class="group">
											<div class="label">Up Avatar:</div>
											<div class="detail">
												+<?= $configs['first_upload_avatar'] ?> Xu ( lần đầu )
											</div>
										</div>
										<div class="group">
											<div class="label">Vip Icon:</div>
											<div class="detail"><?= $configs['vip_icon'] ?></div>
										</div>
										<div class="group">
											<div class="label">Sưu tầm khung viền:</div>
											<div class="detail"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> <a href="/store#khungvien">Mua khung viền</a></div>
										</div>
										<div class="group">
											<div class="label">Nạp Xu:</div>
											<div class="detail">
												Nạp ít nhất <?= $configs['deposit_min'] ?>$<br>
												Mỗi 1$=<?= $configs['deposit_rate'] ?> Xu<br>
											</div>
										</div>
										<div class="group">
											<div class="label">Giá Vip / Tháng:</div>
											<div class="detail">
												<?= $configs['vip_fee'] ?> Xu
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade show active" id="tab-deposit">
							<h4 class="tab-title">Nạp Xu</h4>
							<div class="tab-body">
								<div class="deposit-method">
									<i class="fa-brands fa-paypal"></i> Paypal/Visa
								</div>
								<div class="alert-deposit mb-3">
									<i class="fa-solid fa-circle-info"></i> Nạp ít nhất là 10$, vì bên paypal thu phí cố định nên nạp 1 lúc càng nhiều sẽ càng đỡ phí so với nạp chia nhỏ
								</div>
								<form action="" method="POST" id="form-deposit">
									<div class="alert alert-danger d-none"></div>
									<div class="alert alert-success d-none"></div>
									<div class="form-group mb-3">
										<label for="deposit_money" class="mb-1">Số tiền muốn nạp</label>
										<input type="text" value="10" min="10" name="deposit[money]" id="deposit_money" class="form-control">
									</div>
									<div class="form-group mb-3">
										<label class="mb-1">Loại tiền</label>
										<input type="text" value="USD" class="form-control" readonly>
									</div>
									<div class="form-group mb-3">
										<label for="deposit_earn" class="mb-1">Số xu nhận được</label>
										<input type="text" value="" id="deposit_earn" class="form-control" readonly>
									</div>
									<div class="form-group mb-3">
										<label for="deposit_exp" class="mb-1">Số kinh nghiệm nhận được</label>
										<input type="text" value="" id="deposit_exp" class="form-control" readonly>
									</div>
									<div id="deposit-checkout"></div>
								</form>
							</div>
						</div>
						<div class="tab-pane fade" id="tab-update-profile">
							<h4 class="tab-title">Chỉnh sửa thông tin</h4>
							<div class="tab-body">
								<div class="account-info clearfix">
									<h2 class="posttitle">Chỉnh sửa / Cập nhật tài khoản</h2>
									<div class="info-detail">
										<div class="grid-body no-border">
											<div class="row">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<div class="form-group">
														<label class="form-label">Tham gia nhóm telegram nhận thông báo quan trọng bằng cách</label><br><br>
														Cách 1: Click vào đường link này: <a style="color: #009dff;" href="https://t.me/+P91IG7VRyvc1NGY9">https://t.me/+P91IG7VRyvc1NGY9</a><span style="color: #009dff;"></span> <br><br>
														Cách 2: Truy cập telegram trên điện thoại hoặc máy tính </br>
														Tìm kiếm người dùng với từ khóa: <span style="color: #00FF00;"> My-anime </span>
														<br><br><img src="/assets/upload/1-img-anime.png" style="max-width:500px"><br><br>
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
							<div class="movie-follow"></div>
						</div>
						<div class="tab-pane fade" id="tab-cart">
							<h4 class="tab-title">Cửa hàng vật phẩm</h4>
							<div class="">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item menu-item hvr-sweep-to-right">
										<a class="nav-link active" href="#tab-user-frame" data-bs-toggle="tab">
											KHUNG VIỀN
										</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane fade show active" id="tab-user-frame">
										<div class="tab-body">
											<div class="list-avatar-frame mt-4">
												<?php if (!empty($listAvatarFrame)) : ?>
													<?php foreach ($listAvatarFrame as $key => $frame) : ?>
														<div class="frame <?= in_array($key, $listUserFrame) ? 'owned' : '' ?>" data-id="<?= $key ?>" data-price="<?= numberFormat($frame['price']) ?>" data-frame="<?= $frame['icon'] ?>">
															<img src="<?= $frame['icon'] ?>" alt="">
														</div>
													<?php endforeach ?>
												<?php else : ?>
													<p class="text-center">Nội dung đang cập nhật</p>
												<?php endif ?>
											</div>
											<div class="current-coin mt-2">
												<p class="coin fw-bold"><img src="/themes/img/coin_15.gif" alt=""> Tài sản: <?= number_format($user['coins']) ?> Xu</p>
											</div>
											<div class="avatar-frame-price d-none">
												<p>Giá: <span class="frame-price"></span> Xu</p>
												<input name="frame-id" type="text" hidden>
												<button type="button" class="btn btn-primary" id="buy-frame"><i class="fa-solid fa-cart-plus"></i> Mua</button>
											</div>
											<div class="alert alert-danger mt-3 d-none"></div>
										</div>
									</div>
								</div>
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
	</div>
	<div id="modal" class="modal">
		<div>
			<div>Tải lên ảnh đại diện</div>
			<a href="javascript:$modal.toggleModal()"><span class="material-icons-round margin-0-5">
					close
				</span></a>
		</div>
		<div class="upload-area">
			<form action="/file-upload">
				<div class="fallback">
					<div id="show-image-upload">
					</div>
					<input name="file" type="file" id="upload-avatar" class="display-none" accept="image/*" />
					<div class="option-avatar">
					</div>
					<div class="button-default padding-10-20 bg-red color-white" id="select-avatar" onclick="showSelectAvatar()"><span class="material-icons-round margin-0-5">
							cloud_upload
						</span> Tải ảnh lên</div>
					<div class="fw-500 margin-t-10">Upload ảnh 18+ sẽ bị khoá nick ngay lập tức</div>
				</div>
			</form>
		</div>
	</div>
	<!-- Modal buy vip  -->
	<div class="modal fade" id="VipModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form action="" id="BuyVip" method="">
					<div class="modal-header">
						<h5 class="modal-title text-primary" id="exampleModalLabel">Chọn gói VIP</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<select class="form-control" name="vip_package" id="vip_package">
								<option value="1" selected>1 Tháng (30.000 Xu)</option>
								<option value="12"> 12 tháng (360.000 Xu) + Tặng kèm 1 tháng</option>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" id="btn_BuyVip" class="btn btn-primary">Tiếp tục mua</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
<!-- Handler Buy Vip User -->
<script>
	$(document).ready(function() {
		// Call ajax process 
		$("#btn_BuyVip").click(function() {
			var vip_package = $("#vip_package").val();
			$.ajax({
				url: "<?= URL ?>/buy-vip-user/" + vip_package + ".html",
				method: 'GET',
				data: {
					vip_package: vip_package
				},
				success: function(response) {
					// Xử lý dữ liệu nhận được từ server
					var responseObject = JSON.parse(response);
					// console.log(responseObject.message);
					$('.modal-footer .btn.btn-secondary').click();
					$("#thongbao").html(responseObject.message)
					$("#thongbao").addClass('alert alert-info');
					window.location.hash = '#thongbao';
				},
				error: function(error) {
					console.log('Error:', error);
				}
			});
		});

		// hàm cập nhật time
		function updateTime() {
			var vip_date_end = $(".vip-info").data('vip_date_end');
			// console.log(vip_date_end);
			var currentDate = moment();
			// console.log(currentDate);
			// Chuyển vip_date_end monent 
			var vip_date_end = moment(vip_date_end, "YYYY-MM-DD");
			// Tính chênh lệnh time
			var duration = moment.duration(vip_date_end.diff(currentDate));

			// Chia duration thành các thành phần: ngày, giờ, phút
			var days = Math.floor(duration.asDays());
			var hours = Math.floor(duration.asHours() % 24);
			var minutes = Math.floor(duration.asMinutes() % 60);
			// console.log('Days remaining:', days , hours, minutes);
			$(".vip-info .days").text(days + ' Ngày' + ' ' + hours + ' ' + 'Giờ' + ' ' + minutes + ' Phút');
		}
		updateTime();
		setInterval(updateTime, 60000);
	});
</script>
<script type="text/javascript" src="/themes/js_ob/user.profile.js?v=1.7.4"></script>
<script src="https://www.paypal.com/sdk/js?client-id=<?= $paypalConfig['client_id'] ?>&components=buttons&disable-funding=card"></script>

<script>
	// show Tab Notificaiton 
	function showTab(tabId) {
		// #1. lấy all element tab content 
		// var tabContents = document.querySelectorAll('.tab_content_notification');
		// #2. ân tất cả
		// tabContents.forEach(function(content) {
		// content.style.display = 'none';
		// });
		// #3. show tab id được click
		// document.getElementById(tabId).style.display = 'block';
	}
	// doing
	function AddActive() {

	}
</script>

<script type="text/javascript">
	$('body').on('click', '[data-bs-toggle="tab"]', function(e) {
		$('[data-bs-toggle="tab"]').css('display', 'block');
	});

	// Change password
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
						if (rs.status == 'success') {
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
	// End change password

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
			showMovieFollow(0);
		});
	})();

	$('body').on('click', '.movie-follow-pagination', function() {
		if ($(this).parent().hasClass('active')) {
			return false;
		}

		let page = $(this).attr('data-page');
		showMovieFollow(page);
	});

	async function showMovieFollow(page) {
		try {
			let movie_follow = document.getElementsByClassName('movie-follow')[0];
			let response = await loadFollowmovie(page);
			let data = response.data;
			movie_follow.innerHTML = data;
		} catch (e) {
			console.log(e)
		}
		$user.id && asyncFollow();
	}

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

	loadFollowmovie = (page = 0) => {
		let local_store = localStorage.getItem("data_follow");
		let data_follow_store = local_store ? JSON.parse(local_store) : [];
		let limit;
		
		if (screen.width <= 767) {
			limit = 9;
		} else {
			limit = 8;
		}

		return axios.post(
			'/server/api', {
				"action": "data_follow",
				"data_follow": JSON.stringify(data_follow_store),
				"page_now": page,
				"limit": limit,
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

	//Deposit
	let formDeposit = $('#form-deposit');
	let depositMin = <?= !empty($configs['deposit_min']) ? $configs['deposit_min'] : 10 ?>;
	let depositRate = <?= !empty($configs['deposit_rate']) ? $configs['deposit_rate'] : 10.000 ?>;
	let depositExp = <?= !empty($configs['deposit_exp']) ? $configs['deposit_exp'] : 50 ?>;

	$(document).ready(function() {
		caculateDeposit();

		formDeposit.on('input', '#deposit_money', function() {
			caculateDeposit();
		})

		formDeposit.submit(function() {
			validateFormDeposit();
			return false;
		});

		paypal.Buttons({
			onInit(data, actions) {
				// actions.disable();

				// if (!validateFormDeposit()) {
				// 	actions.enable();
				// }
			},
			onClick() {
				if (validateFormDeposit()) {
					return false;
				}
			},
			createOrder: function(data, actions) {
				if (!validateFormDeposit()) {
					return actions.order.create({
						purchase_units: [{
							amount: {
								currentcy: 'USD',
								value: formDeposit.find('#deposit_money').val()
							}
						}]
					});
				}

				return false;
			},
			onApprove: function(data, actions) {
				return actions.order.capture().then(async function(details) {
					await axios.post('/server/api', {
						"action": 'add_deposit',
						"token": $dt.token,
						"data": details,
					}).then(rs => {
						if (rs.data.success) {
							formDeposit.find('.alert-success').html(rs.data.message);
							formDeposit.find('.alert-success').removeClass('d-none');
							setTimeout(function() {
								location.reload();
							}, 2000);
						} else {
							formDeposit.find('.alert-danger').html(rs.data.message);
							formDeposit.find('.alert-danger').removeClass('d-none');
						}
					});
				});
			}
		}).render('#deposit-checkout');
	});

	function caculateDeposit() {
		let inputMoney = formDeposit.find('#deposit_money');
		let inputEarn = formDeposit.find('#deposit_earn');
		let inputExp = formDeposit.find('#deposit_exp');

		inputEarn.val(new Intl.NumberFormat('vi-VN', {
			maximumSignificantDigits: 3
		}).format(inputMoney.val() * depositRate));
		inputExp.val(new Intl.NumberFormat('vi-VN', {
			maximumSignificantDigits: 3
		}).format(inputMoney.val() * depositExp));
	}

	function validateFormDeposit() {
		let inputMoney = formDeposit.find('#deposit_money');
		let inputEarn = formDeposit.find('#deposit_earn');
		let inputExp = formDeposit.find('#deposit_exp');
		let error = 0;
		let errorMsg = '';
		formDeposit.find('.alert').addClass('d-none');

		if (inputMoney.val() <= 0 || isNaN(inputMoney.val())) {
			errorMsg = 'Chưa nhập số tiền muốn nạp';
			error = 1;
			inputMoney.addClass('is-invalid');
		} else {
			inputMoney.removeClass('is-invalid');
		}

		if (inputMoney.val() <= 9) {
			errorMsg = 'Nạp ít nhất ' + depositMin + '$';
			inputMoney.addClass('is-invalid');
			error = 1;
		} else {
			inputMoney.removeClass('is-invalid');
		}

		if (error == 1) {
			formDeposit.find('.alert-danger').html(errorMsg);
			formDeposit.find('.alert-danger').removeClass('d-none');
		} else {
			formDeposit.find('.alert-danger').html('');
			formDeposit.find('.alert-danger').addClass('d-none');
		}

		return error;
	}
	//End deposit

	// Avatar Frame Store
	$('body').on('click', '.frame', function() {
		let id = $(this).attr('data-id');
		let price = $(this).attr('data-price');
		let frame = $(this).attr('data-frame');

		$('.frame').removeClass('active');
		$(this).addClass('active');

		$('.avatar-frame-price .frame-price').html(price);
		$('.avatar-frame-price [name="frame-id"]').val(id);
		$('.avatar-frame-price').removeClass('d-none');

		$('.avatar-frame').attr('src', frame);

		$('#tab-user-frame .alert-danger').addClass('d-none');
	});

	// Buy avatar frame
	$('body').on('click', '#buy-frame', function() {
		let frame = $('[name="frame-id"]').val();
		let errorDiv = $('#tab-user-frame .alert-danger');

		errorDiv.addClass('d-none');

		if (!frame) {
			return false;
		}

		if ($(`[data-id="${frame}"]`).hasClass('owned')) {
			errorDiv.html('Đã sở hữu');
			errorDiv.removeClass('d-none');
			return false;
		}

		Promise.all([
				axios.post('/server/api', {
					"action": 'buy_avatar_frame',
					"token": $dt.token,
					"data": {
						'frame': frame
					}
				})
			])
			.then(function(responses) {
				let rs = responses[0].data;

				if (rs.success) {
					location.reload();
				} else {
					errorDiv.html(rs.message);
					errorDiv.removeClass('d-none');
				}
			})
			.catch(function(error) {
				console.error(error);
			});
	});

	// User active avatar frame
	$('body').on('click', '.frame-owned', function() {
		let element = $(this);
		let id = element.attr('data-id');
		let frame = element.attr('data-frame');

		if (!id) {
			return false;
		}

		element.append('<img src="/themes/img/loading_spinner_24x24.gif" class="loading">');

		Promise.all([
			axios.post('/server/api', {
				"action": 'active_avatar_frame',
				"token": $dt.token,
				"data": {
					'frame': id
				}
			})
		])
		.then(function(responses) {
			let rs = responses[0].data;

			if (rs.success) {
				$('.avatar-frame').attr('src', frame);
			} else {
				alert(ms.message);
			}
			element.find('.loading').remove();
		})
		.catch(function(error) {
			console.error(error);
		});
	});
</script>

</html>