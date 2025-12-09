<?php

$menuItems = [
	'home' => [
		'label' => 'Trang Chủ',
		'icon' => 'fa-solid fa-house',
		'url' => URL,
	],
	'moi-cap-nhat' => [
		'label' => 'Mới Cập Nhật',
		'icon' => 'fa-solid fa-rotate',
		'url' => URL . '/moi-cap-nhat',
	],
	'lich-chieu' => [
		'label' => 'Lịch Chiếu',
		'icon' => 'fa-regular fa-calendar-days',
		'url' => URL . '/lich-chieu',
	],
	'phim-hoan-thanh' => [
		'label' => 'Hoàn Thành',
		'icon' => 'fa-regular fa-circle-check',
		'url' => URL . '/phim-hoan-thanh',
	],
	'bang-xep-hang-phim' => [
		'label' => 'Top 10 Phim',
		'icon' => 'fa-solid fa-trophy',
		'url' => URL . '/bang-xep-hang-phim',
	],
	'lich-su' => [
		'label' => 'Lịch Sử',
		'icon' => 'fa-solid fa-clock-rotate-left',
		'url' => URL . '/lich-su',
	],
];

$currentUrl = $_SERVER['REQUEST_URI'];
$currentUrl = str_replace(URL, '', $currentUrl);
$currentUrl = trim($currentUrl, '/');
$currentUrl = explode('/', $currentUrl);
$currentUrl = $currentUrl[0];

?>
<style>
	.navbar-toggle i {
		font-size: 18px;
	}
</style>
<div class="navbar-container">
	<div class="container">
		<nav class="navbar halim-navbar main-navigation" role="navigation" data-dropdown-hover="1">
			<div class="navbar-header desktop-mode">
				<button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#halim" aria-expanded="false">
					<span class="sr-only">Menu</span>
					<i class="fa-solid fa-bars"></i>
				</button>

				<button type="button" class="navbar-toggle collapsed pull-right expand-search-form" data-toggle="collapse" data-target="#search-form" aria-expanded="false">
					<i class="fa-solid fa-magnifying-glass"></i>
				</button>
			</div>
			<div class="collapse navbar-collapse" id="halim">
				<div class="menu-menu-container">
					<ul id="menu-menu" class="nav navbar-nav navbar-left">
						<?php foreach ($menuItems as $key => $value) { ?>
							<li class="<?= ($currentUrl == $key) || ($currentUrl == '' && $key == 'home') ? 'active' : '' ?>">
								<a href="<?= $value['url'] ?>">
									<i class="<?= $value['icon'] ?>"></i>
									<?= $value['label'] ?>
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<!-- /.navbar-collapse -->
		</nav>
		<div class="collapse navbar-collapse" id="search-form">
			<div id="mobile-search-form" class="halim-search-form">
				<form id="search-form-pc" name="halimForm" role="search" action="<?= URL ?>/tim-kiem" method="GET">
					<div class="form-group">
						<div class="input-group col-xs-12">
							<input id="search" type="text" name="s" value="<?= $kw ?>" class="form-control" placeholder="Tìm kiếm phim..." autocomplete="off" required="" />
							<i class="animate-spin hl-spin4 hidden"></i>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>