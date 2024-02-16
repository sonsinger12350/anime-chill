<?php
	if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
	if (isset($_author_cookie)) die(header("location:/"));
	if (isset($_POST['action_dang_ky'])) {
		$nickname = sql_escape($_POST['nickname']);
		$email = sql_escape($_POST['email']);
		$password = md5(sql_escape($_POST['password']));
		$password2 = md5(sql_escape($_POST['password2']));
		$Captcha = sql_escape($_POST['captcha']);
		$Success = 0;
		if (!$nickname) {
			$Success++;
			$Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span> Bạn Không Được Để Trống Biệt Danh</div>';
		}
		if ($cf['sign_up'] <= 0) {
			$Success++;
			$Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span> Chức năng đăng ký không khả dụng</div>';
		}
		if (strlen($nickname) < 5) {
			$Success++;
			$Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span> Biệt danh chứa từ ngữ không chuẩn: Ít nhất 5 kí tự</div>';
		}
		if (!$email) {
			$Success++;
			$Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span> Bạn Không Được Để Trống Email</div>';
		}
		if (!$password) {
			$Success++;
			$Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span> Bạn Không Được Để Trống Password</div>';
		}
		if (!$password2) {
			$Success++;
			$Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span> Bạn Không Được Để Trống Nhập Lại Password</div>';
		}
		if ($password != $password2) {
			$Success++;
			$Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span> Hai Mật Khẩu Không Khớp Nhau</div>';
		}
		if (!$Captcha) {
			$Success++;
			$Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span> Bạn Chưa Nhập Capcha</div>';
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$Success++;
			$Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span> Địa Chỉ Email Không Hợp Lệ</div>';
		}
		if (get_total("user", "WHERE email = '$email'") >= 1) {
			$Success++;
			$Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span>Địa Chỉ Email Đã Tồn Tại Trên Website</div>';
		}
		// if ($Captcha != $_SESSION["captcha"]) {
		// 	$Success++;
		// 	$Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span> Mã Capcha Bạn Nhập Không Đúng </div>';
		// }
		if ($Success == 0) {
			$AccessToken = RenderAccessToken();
			$mysql->insert('user', "email,password,avatar,nickname,_accesstoken,ipadress,time", "'$email','$password2','https:\//ui-avatars.com/api/?background=random&name=$nickname','$nickname','$AccessToken','" . IP . "','" . DATEFULL . "'");
			$User_Arr = GetDataArr("user", "email = '$email'");
			addCoin($User_Arr['id'], 'register');
			setcookie('author', $AccessToken, time() + (86400 * 30), "/", URL_None_HTTP(), false);
			setcookie('_accesstoken', $AccessToken, time() + (86400 * 30), "/", URL_None_HTTP(), false);
			die(header("location:/"));
		}
	}
	$Capcha = ImagesCapcha();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
	<?php
	$title = "Đăng Nhập Tài Khoản Thành Viên- {$cf['title']}";
	require_once(ROOT_DIR . '/view/head.php');
	?>
</head>

<body class="scroll-bar">
	<div id="fb-root"></div>
	<div id="ah_wrapper">
		<?php require_once(ROOT_DIR . '/view/header.php'); ?>
		<div class="ah_content">
			<div class="login-page">
				<div class="margin-10-0 bg-brown flex flex-space-auto">
					<div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
						<h3 class="section-title"><span>Đăng Ký Thành Viên</span></h3>
					</div>
				</div>
				<div class="ah-form flex flex-column flex-hozi-center ah-frame-bg">

					<form action="/dang-ky" method="POST">
						<div>
							<label>Nick Name Bạn Muốn Đặt</label>
							<input type="text" placeholder="Nhập Nick Name của bạn" value="" name="nickname">
						</div>
						<div>
							<label>Địa Chỉ Email</label>
							<input type="email" placeholder="Nhập Email của bạn" value="" name="email">
						</div>
						<div>
							<label>Mật khẩu</label>
							<input type="password" placeholder="Nhập mật khẩu của bạn" name="password">
						</div>
						<div>
							<label>Nhập Lại Mật khẩu</label>
							<input type="password" placeholder="Nhập Lại mật khẩu của bạn" name="password2">
						</div>
						<div>
							<label><img src="<?= $Capcha['images'] ?>" width="100"></label>
							<input type="text" placeholder="Nhập mã xác minh" name="captcha">
							<input type="hidden" value="<?= $Capcha['CapchaID'] ?>" name="capcha_hidden">
						</div>
						<div id="message-line"> <?= $Notice ?></div>
						<div class="flex flex-hozi-center flex-column">
							<div class="flex flex-hozi-center">
								<button type="submit" class="button-default color-white bg-red" name="action_dang_ky" value="submit">Đăng Ký</button>
								<b style="padding: 10px;">Hoặc</b>
								<a href="/login" class="button-default bg-green margin-5-0 padding-10-20">Đăng Nhập</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>

</html>