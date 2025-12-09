<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$value[2]) die(header('location:' . URL));
FireWall();
$MovieSlug = sql_escape($value[2]);
if (get_total("news", "WHERE slug = '$MovieSlug'") < 1) die(header('location:' . URL));
$Movie = GetDataArr("news", "slug = '$MovieSlug'");
$NumEpisode = ($Movie['ep_hien_tai'] ? $Movie['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$Movie['id']}'"));
$statut = ($Movie['loai_phim'] == 'Phim Lẻ' ? "{$Movie['movie_duration']} Phút" : "$NumEpisode/{$Movie['ep_num']}");

$newWatched = [];

if (!empty($_SESSION['new_watched'])) {
	$newWatched = $_SESSION['new_watched'];
}

if (!in_array($Movie['id'], $newWatched)) {
	$mysql->update('news', "view = view + 1", 'id = '.$Movie['id']);
	$newWatched[] = $Movie['id'];
	$_SESSION['new_watched'] = $newWatched;
}

$title = "{$Movie['name']} - {$cf['title']}";
$description = "{$Movie['other_name']}";

ob_start();
?>
<div class="row container" id="wrapper">
	<main id="main-content" class="col-xs-12 col-sm-12 col-md-12">
		<div class="info-movie" style="margin-top: 16px;">
			<div id="modal" class="modal" style="display:none">
				<div>
					<div>Đánh giá phim</div>
					<a href="javascript:$modal.toggleModal()"><span class="material-icons-round margin-0-5">
							close
						</span></a>
				</div>
				<div>
					<div class="rated-star flex flex-hozi-center flex-ver-center">
						<?php
						for ($i = 1; $i < 11; $i++) {
							if (json_decode($_COOKIE['vote'], true)[$Movie['id']] >= $i) {
								$css = ' class="active"';
							} else $css = '';
							echo "<span rate='$i'$css><span class=\"material-icons-round\">star</span></span>";
						}
						?>

					</div>
				</div>
			</div>
			<h1 class="section-title" style="line-height: 1.2;"><?= $Movie['name'] ?></h1>
			<br>
			
			<div class="update_time">
				<div>Ngày đăng: <?= $Movie['time'] ?></div>
			</div>
			<br>
			<?php if ($Movie['keyword']) { ?>
				<div class="ah-frame-bg bind_movie">
					<div>
						<h2 class="heading">Page Đề Cử</h2>
					</div>
					<div class="scroll-bar">
						<?php
						$active = 0;
						foreach (json_decode($Movie['keyword'], true) as $key => $value) {
							if ($value['name']) {
						?>
								<a class="ah_key_seo" href="<?= $value['url'] ?>" class="<?= ($active = 1 ? "active" : "") ?>"><?= $value['name'] ?></a>
						<?php }
						} ?>
					</div>
				</div>
			<?php } ?>
			<div>
				<div>
					<br>
					<div style="font-family: Comfortaa;" class="ah-frame-news">
						
						<p><?= un_htmlchars($Movie['content']) ?></p>
					</div>
				</div>
			</div>
			<div class="flex ah-frame-bg flex-wrap">
				<div class="flex flex-wrap flex-1">
					<a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(URL . "/news/{$Movie['slug']}.html") ?>" style="background-color: #2374e1; font-size: 15px;" class="padding-5-15 fs-35 button-default fw-500 fs-15 flex flex-hozi-center" title="Chia Sẻ Lên Facebook" target="_blank"><span class="material-icons-round">share</span>Share</a>
					<a href="https://www.facebook.com/hhchina/" style="background-color: #2374e1;font-size: 15px;" class="padding-5-15 fs-35 button-default fw-500 fs-15 flex flex-hozi-center" title="FanPage Facebook" target="_blank"><span class="material-icons-round">thumb_up</span> Like</a>
					<a href="https://www.facebook.com/motanime247/" style="background-color: #2374e1;font-size: 15px;" class="padding-5-15 fs-35 button-default fw-500 fs-15 flex flex-hozi-center" title="FanPage" target="_blank"><span class="material-icons-round">group</span>Group</a>
				</div>
			</div>
			<div>
				<div class="ah-frame-bg bind_movie">
				<h2 class="heading" >Fanpage Facebook</h2>
				<center><div class="fb-page" data-href="https://www.facebook.com/hhchina/" data-tabs="timeline" data-width="500" data-height="70" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/hhchina/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/hhchina/">HHCHINA.tv</a></blockquote></div></center>
					<br>
				</div>
			</div>
		</div>
	</main>
</div>
<?php
$content = ob_get_clean();

// Include layout
require_once(ROOT_DIR . '/view/layout.php');
