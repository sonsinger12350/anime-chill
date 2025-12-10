<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");

ob_start();
$title = "Top 10 Phim Hay Nhất - {$cf['title']}";
$description = "Xem top 10 phim hay nhất online";
$tabs = [
	'day' => ['label' => 'Ngày', 'column' => 'view_day'],
	'week' => ['label' => 'Tuần', 'column' => 'view_week'],
	'month' => ['label' => 'Tháng', 'column' => 'view_month'],
	'year' => ['label' => 'Năm', 'column' => 'view_year'],
	'all' => ['label' => 'Tất Cả', 'column' => 'view'],
];
$currentTab = 'all';
if (isset($_GET['tab'])) $currentTab = $_GET['tab'];
if (!in_array($currentTab, array_keys($tabs))) $currentTab = 'all';
?>
<div class="row container" id="wrapper">
	<main id="main-content" class="col-xs-12 col-sm-12 col-md-12">
		<div class="clearfix"></div>
		<section id="halim-showtimes-widget" class="halim-showtimes-widget" style="position: relative">
			<div class="clearfix">
				<div class="halim-ajax-popular-post-loading hidden"></div>
				<div class="halim_box" id="ajax-showtimes-widget">
					<h3 class="section-title"><span>Top 10 Phim Hay Nhất</span></h3>
					<div class="section-bar halim_box_top_sortby">
						<?php
						foreach ($tabs as $key => $value) {
							echo '<a href="' . URL . '/bang-xep-hang-phim?tab=' . $key . '" class="top-movies-tab-link ' . ($key == $currentTab ? 'active' : '') . '">' . $value['label'] . '</a>';
						}
						?>
					</div>
				</div>
				<div class="halim_box_top">
					<?php
					$table = 'movie';
					$condition = "WHERE public = 'true'";
					$order = "ORDER BY {$tabs[$currentTab]['column']} DESC, timestap DESC";
					$limit = 10;
					$currentPage = 1;
					$pagination = CheckPages($table, $condition, $limit, $currentPage);

					if ($pagination['total'] >= 1) {
						$sql = "SELECT * FROM " . DATABASE_FX . "$table $condition $order LIMIT {$pagination['start']},$limit";
						// echo '<pre>';print_r($sql);exit;
						$arr = $mysql->query($sql);
						$count = 1;

						while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
							$NumEpisode = ($row['ep_hien_tai'] ? $row['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$row['id']}'"));
							if ($row['loai_phim'] == 'Phim Lẻ') $status = "{$row['movie_duration']} Phút";
							else $status = "$NumEpisode/{$row['ep_num']}";

							$categoryHtml = [];

							if (!empty($row['cate'])) {
								$cate = json_decode($row['cate'], true);

								foreach ($cate as $key => $value) {
									$category = GetDataArr('category', "id = '{$value['cate_id']}'");
									if (!empty($category)) $categoryHtml[] = "<span class='category-name'>{$category['name']}</span>";
								}
							}

							?>
								<article class="flex-item thumb grid-item">
									<div class="halim-item">
										<a class="halim-thumb" href="<?= URL ?>/info/<?= $row['slug'] ?>.html" title="<?= $row['name'] ?>">
											<figure>
												<img src="<?= $row['image'] ?>" class="img-responsive wp-post-image" alt="<?= $row['name'] ?>" decoding="async" loading="lazy">
											</figure>
											<div class="top-movies-status">
												<span class="status-number top<?= $count ?>"><?= $count ?></span>
											</div>
											<div class="icon_overlay"></div>
											<div class="halim-post-title-box">
												<div class="halim-post-title">
													<h2 class="entry-title"><?= $row['other_name'] ?></h2>
													<p class="original_title"><?= $row['name'] ?></p>
												</div>
											</div>
										</a>
									</div>
								</article>
							<?php
							$count++;
						}
					}
					?>
				</div>
			</div>
		</section>
		<div class="clearfix"></div>
	</main>
</div>
<?php
$content = ob_get_clean();

// Include layout
require_once(ROOT_DIR . '/view/layout.php');
