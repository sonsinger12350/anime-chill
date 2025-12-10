<?php
$kw = isset($_GET['s']) ? sql_escape($_GET['s']) : '';
?>
<header id="header">
	<div class="container">
		<div class="row" id="headwrap">
			<div class="col-md-3 col-sm-6 slogan">
				<h1 class="site-title">
					<a class="logo" href="<?=  URL  ?>" rel="home">HHKUNGFU – Xem Phim Hoạt Hình Kungfu Trung Quốc VietSub Thuyết Minh Mới Nhất</a>
				</h1>
			</div>
			<div class="col-md-5 col-sm-6 halim-search-form hidden-xs">
				<div class="header-nav">
					<div class="col-xs-12">
						<form id="search-form-pc" name="halimForm" role="search" action="<?= URL ?>/tim-kiem" method="GET">
							<div class="form-group">
								<div class="input-group col-xs-12">
									<input type="text" name="s" value="<?= $kw ?>" class="form-control" placeholder="Tìm kiếm phim..." autocomplete="off" required="" />
									<i class="animate-spin hl-spin4 hidden"></i>
								</div>
							</div>
						</form>
						<ul class="ui-autocomplete ajax-results hidden"></ul>
					</div>
				</div>
			</div>

			<div class="col-md-4 col-xs-12 menu-right">
				<div class="nav-items header-nav-items">
					<a href="<?= URL ?>/lich-su" title="Lịch sử xem">
						<div>
							<i class="fa-solid fa-clock-rotate-left"></i>
						</div>
					</a>
					<a href="<?= URL ?>/bookmark" title="Bookmark">
						<div>
							<i class="fa-solid fa-bookmark"></i>
						</div>
					</a>
					<?php if (!isset($_author_cookie)) { ?>
						<button id="userInfo" type="button" class="navbar-toggle-pc collapsed pull-right" data-toggle="dropdown" aria-expanded="true" onclick="openLoginModalCustom();" aria-label="Đăng nhập">
							<i class="fa-solid fa-right-to-bracket"></i>
						</button>
					<?php } else { ?>
						<button id="userInfo" type="button" class="navbar-toggle-pc collapsed pull-right" data-toggle="dropdown" aria-expanded="true" aria-label="Thông tin người dùng">
							<i class="fa-solid fa-circle-user"></i>
						</button>
						<ul class="dropdown-menu" aria-labelledby="userInfo">
							<li>
								<a href="<?= URL ?>/author/<?= $user['id'] ?>"><i class="fa-solid fa-user"></i> Cá nhân</a>
							</li>
							<li>
								<a href="<?= URL ?>/dang-xuat"><i class="fa-solid fa-power-off"></i> Đăng xuất</a>
							</li>
						</ul>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</header>