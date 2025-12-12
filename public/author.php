<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$value[2]) die(header('location:' . URL));
ob_start();

$user_id = $value[2];
$userData = GetDataArr('user', "id = $user_id");
$title = "Cá nhân {$userData['nickname']} - {$cf['title']}";
$description = "Xem cá nhân {$userData['nickname']}";
$avatar = !empty($userData['avatar']) ? $userData['avatar'] : 'https://secure.gravatar.com/avatar/55cceb42e9048c6e763a5e9042e67cf6f8b7d6c5baeac913a4aad4069f5512cf?s=200&d=mm&r=g';
$bookmarked_content = renderBookmarkedMovies([
	'user_id' => $user_id,
	'page' => 1,
	'limit' => 100,
	'showPagination' => true,
	'view' => 'author'
]);
$totalBookmarked = renderBookmarkedMovies([
	'user_id' => $user_id,
	'page' => 1,
	'limit' => 100,
	'showPagination' => true,
	'view' => 'author',
	'return_total' => true
]);
$historyMovies = getHistory($user_id);

?>
<style>
	.popular-post {
		padding: 0 12px;
		max-height: 350px;
		overflow-x: hidden;
		border-radius: 3px;
	}

	#form-change-password {
		width: 300px;
	}

	#form-change-password .pass_show {
		position: relative
	}

	#form-change-password .pass_show .ptxt {
		position: absolute;
		top: 50%;
		transform: translateY(-50%);
		right: 10px;
		z-index: 1;
		color: #f36c01;
		cursor: pointer;
		transition: .3s ease all;
	}

	#form-change-password .pass_show .ptxt:hover {
		color: #333333;
	}

	.section-title {
		margin-bottom: 10px;
	}
</style>

<div class="row container" id="wrapper">
	<aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
		<div class="section-bar clearfix">
			<h3 class="section-title">
				<span>Cá nhân</span>
			</h3>

			<div class="profile-sidebar">
				<div class="profile-userpic">
					<img alt="<?= $userData['nickname'] ?>" src="<?= $avatar ?>" srcset="<?= $avatar ?> 2x" class="avatar avatar-200 photo" height="200" width="200" decoding="async">
				</div>
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						<a href="<?= URL ?>/author/<?= $user_id ?>"><?= $userData['nickname'] ?></a>
					</div>
				</div>
				<div class="profile-usermenu">
					<ul class="nav">
						<li class="active">
							<a href="#tab-movie" data-toggle="tab"><i class="fa-solid fa-user"></i> Overview</a>
						</li>
						<?php if ($user_id == $user['id']) { ?>
							<li>
								<a href="#tab-change-password" data-toggle="tab"><i class="fa-solid fa-key"></i> Đổi mật khẩu</a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</aside>

	<main id="main-contents" class="col-xs-12 col-sm-12 col-md-12">
		<section class="tab-content">
			<div role="tabpanel" id="tab-movie" class="tab-pane active">
				<div>
					<div class="section-bar clearfix">
						<h3 class="section-title">
							<span>Danh sách yêu thích</span><span class="count pull-right"><i><?= $totalBookmarked ?></i> item</span>
						</h3>
					</div>

					<div class="halim_box">
						<ul class="halim-bookmark-lists" id="bookmarkList" style="max-height: 350px;">
							<?php echo $bookmarked_content; ?>
						</ul>
					</div>

					<div class="clearfix"></div>
				</div>
				<div class="section-bar clearfix">
					<div class="section-title">
						<span>Recently Visited Posts</span>
					</div>
				</div>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active">
						<div class="popular-post">
							<?php if (!empty($historyMovies)) { ?>
								<?php
								foreach ($historyMovies as $movie) {
									$movieData = GetDataArr('movie', "id = {$movie['movie_id']}");
								?>
									<div class="item post-673">
										<a href="<?= URL ?>/info/<?= $movieData['slug'] ?>.html" title="<?= $movieData['name'] ?>">
											<div class="item-link">
												<img src="<?= $movieData['image'] ?>" data-src="<?= $movieData['image'] ?>" class="blur-up post-thumb lazyloaded" alt="<?= $movieData['name'] ?>" title="<?= $movieData['name'] ?>">
											</div>
											<h3 class="title"><?= $movieData['name'] ?></h3>
										</a>
										<div class="viewsCount"><?= $movieData['view'] ?> lượt xem</div>
									</div>
								<?php } ?>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<div role="tabpanel" id="tab-change-password" class="tab-pane">
				<div>
					<div class="section-bar clearfix">
						<h3 class="section-title">
							<span>Đổi mật khẩu</span>
						</h3>
						<form id="form-change-password">
							<label>Mật khẩu hiện tại</label>
							<div class="form-group pass_show">
								<input type="password" class="form-control" name="current_password" autocomplete="current-password" placeholder="Mật khẩu hiện tại">
								<span class="ptxt">Hiện</span>
							</div>
							<label>Mật khẩu mới</label>
							<div class="form-group pass_show">
								<input type="password" class="form-control" name="new_password" autocomplete="new-password" placeholder="Mật khẩu mới">
								<span class="ptxt">Hiện</span>
							</div>
							<label>Xác nhận mật khẩu mới</label>
							<div class="form-group pass_show">
								<input type="password" class="form-control" name="confirm_new_password" autocomplete="new-password" placeholder="Xác nhận mật khẩu mới">
								<span class="ptxt">Hiện</span>
							</div>
							<div class="form-group"><button type="submit" class="btn btn-success">Cập nhật</button></div>
						</form>
					</div>
				</div>
			</div>
		</section>
		<div class="clearfix"></div>
	</main>


</div>
<script>
	// Xử lý hiển thị/ẩn mật khẩu và submit form bằng AJAX
	jQuery(function($) {
		// Xử lý hiển thị/ẩn mật khẩu
		$(document).on('click', '#form-change-password .ptxt', function() {
			const input = $(this).siblings('input[type="password"], input[type="text"]');

			if (input.attr('type') === 'password') {
				input.attr('type', 'text');
				$(this).text('Ẩn');
			}
			else {
				input.attr('type', 'password');
				$(this).text('Hiện');
			}
		});

		// Xử lý submit form bằng AJAX
		$('#form-change-password').on('submit', function(e) {
			e.preventDefault();

			const form = $(this);
			const currentPassword = form.find('[name="current_password"]').val();
			const newPassword = form.find('[name="new_password"]').val();
			const confirmPassword = form.find('[name="confirm_new_password"]').val();
			const submitBtn = form.find('button[type="submit"]');
			const originalBtnText = submitBtn.html();

			// Validate client-side
			if (!currentPassword || !newPassword || !confirmPassword) {
				Toast({
					message: 'Vui lòng điền đầy đủ thông tin',
					type: 'error'
				});
				return;
			}

			// Disable button và hiển thị loading
			submitBtn.prop('disabled', true).html('Đang xử lý...');

			// Gửi request AJAX
			$.ajax({
				type: 'POST',
				url: '/server/api',
				contentType: 'application/json',
				dataType: 'json',
				data: JSON.stringify({
					action: 'change_password',
					current_password: currentPassword,
					new_password: newPassword,
					confirm_new_password: confirmPassword
				}),
				success: function(response) {
					if (response.status === 'success') {
						Toast({
							message: response.result || 'Đổi mật khẩu thành công',
							type: 'success'
						});
						// Reset form
						form[0].reset();
					}
					else {
						Toast({
							message: response.result || 'Đổi mật khẩu thất bại',
							type: 'error'
						});
					}

					// Enable lại button
					submitBtn.prop('disabled', false).html(originalBtnText);
				},
				error: function() {
					Toast({
						message: 'Có lỗi xảy ra khi đổi mật khẩu. Vui lòng thử lại!',
						type: 'error'
					});
					// Enable lại button
					submitBtn.prop('disabled', false).html(originalBtnText);
				}
			});
		});
	});
</script>
<?php
$content = ob_get_clean();

// Include layout
require_once(ROOT_DIR . '/view/layout.php');
