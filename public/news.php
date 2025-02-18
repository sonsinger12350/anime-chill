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
?>
<!DOCTYPE html>
<html lang="vi">

<head>
	
	<title><?= ("{$Movie['name']} {$Movie['seo_title']} | Trang Web VietSub + Thuyết Minh Phim Anime") ?></title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes"/>
	<meta name="title" content="<?= ("{$Movie['name']} {$Movie['seo_title']} | Trang Web VietSub + Thuyết Minh Phim Anime") ?>" />
	<meta name="revisit-after" content="1 days" />
	<meta name="description" content="<?= ("{$Movie['name']}, {$Movie['other_name']} {$Movie['seo_title']} | Trang Web VietSub + Thuyết Minh Phim Anime | HHChina.tv | bilibili | iqiyi | Hoạt hình trung quốc | {$Movie['seo_tap']} | hhkungfu | hhpanda | hhtq | hhninja | hoathinh3d | hh3d | hhtq3d | animehay | hhdragon | hhchina | hhtqvip | Xem phim anime hay nhất | Xem phim anime online miễn phí |Phim hoạt hình trung quốc hay nhất | #Hoạt Hình Trung Quốc #hoạt hình phép thuật #anime tu tien #hoạt hình trung quốc thuyết minh #hhpanda#hoat hinh trung quoc #hoạt hình tiên hiệp #anime tien hiep #hhpanda đấu la đại lục #dau la dai luc#hoạt hình trung quốc #hoạt hình cổ trang #hoat hinh trung #hhpanda #hhninja#anime china #Animehay # animehay.pro #hhtq #hhtq3d #hhtqtv #hhtq tv #hhtq.tv #hhtqvip # hhtq.vip # hhtq .vip #hhninja.xyz #hhninja xyz #hhninja .xyz #animevietsub #animevietsub cc #hhpandatv #hhpanda tv #hhpanda.tv #hhpanda .tv #kkhungfu.tv #hhkungfu .tv #hhkungfutv #hoat hinh tien hiep #hoạt hình trung quốc 3d #hhkungfu #hoat hinh 3d#anime trung quốc #hoat hinh tu tien #hoạt hình trung quốc 2d #hhpandatv #hoathinh3d#hoạt hình tu tiên #anime trung quoc #hoạt hình trung quốc hay nhất #hhkungfutv #hoathinh3d .com #hhdragon # hhdragon.com #hhdragon com #hhdragon .com #Animehay.live #Animehay.site #Animehay.pro #Animehay.fan #Animehay.club #Animevietsub.tv #Animevietsub.co #Animevietsub.im #Animevietsub.in #Animeveitsub.org #nettruyenmax.com #truyenqq #truyenqqq #truyenfull #motchill #motchill.tv #motchill.info #hentaivn #xvideo #vlxyz #yahoo.com #Phimmoi #Dongphim #Bilutv #wikisach #metruyenchu #truyenyy #animet.net #nettruyenco #netflix.com #pops #myanimelist #anime47 #animeflv #animego #anime #bilibili.tv #iq.com") ?>" />
	<meta name="keywords" content="<?= (Keyword($Movie['keyword']) ? Keyword($Movie['keyword']) : $Movie['name'] ) ?>" />
	<meta itemprop="name" content="<?= ("{$Movie['name']} {$Movie['seo_title']} | Trang Web VietSub + Thuyết Minh Phim Anime | HHChina.tv | bilibili.tv | iq.com | Hoạt hình trung quốc | Animehay") ?>" />
	<meta name="language" content="Vietnamese, English" />
	<link rel="canonical" href="<?= URL ?>/news/<?= $Movie['slug'] ?>.html" />
	<link rel="icon" href="<?= $cf['favico'] ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta charset="utf-8">
	<meta property="og:type" content="website" />
	<meta name="csrf-token" content="<?= $_SESSION['csrf-token'] ?>">
	<?php if ($_author_cookie) { ?>
		<meta name="_accesstoken" content="<?= $_COOKIE['_accesstoken'] ?>">
	<?php } ?>

	<meta property="og:title" content="<?= ("{$Movie['name']} {$Movie['seo_title']} | Trang Web VietSub + Thuyết Minh Phim Anime") ?>" />
	<meta property="og:description" content="<?= ("{$Movie['name']}, {$Movie['other_name']} {$Movie['seo_title']} | Trang Web VietSub + Thuyết Minh Phim Anime | HHChina.tv | bilibili | iqiyi | Hoạt hình trung quốc | {$Movie['seo_tap']} | hhkungfu | hhpanda | hhtq | hhninja | hoathinh3d | hh3d | hhtq3d | animehay | hhdragon | hhchina | hhtqvip | Xem phim anime hay nhất | Xem phim anime online miễn phí |Phim hoạt hình trung quốc hay nhất | #Hoạt Hình Trung Quốc #hoạt hình phép thuật #anime tu tien #hoạt hình trung quốc thuyết minh #hhpanda#hoat hinh trung quoc #hoạt hình tiên hiệp #anime tien hiep #hhpanda đấu la đại lục #dau la dai luc#hoạt hình trung quốc #hoạt hình cổ trang #hoat hinh trung #hhpanda #hhninja#anime china #Animehay # animehay.pro #hhtq #hhtq3d #hhtqtv #hhtq tv #hhtq.tv #hhtqvip # hhtq.vip # hhtq .vip #hhninja.xyz #hhninja xyz #hhninja .xyz #animevietsub #animevietsub cc #hhpandatv #hhpanda tv #hhpanda.tv #hhpanda .tv #kkhungfu.tv #hhkungfu .tv #hhkungfutv #hoat hinh tien hiep #hoạt hình trung quốc 3d #hhkungfu #hoat hinh 3d#anime trung quốc #hoat hinh tu tien #hoạt hình trung quốc 2d #hhpandatv #hoathinh3d#hoạt hình tu tiên #anime trung quoc #hoạt hình trung quốc hay nhất #hhkungfutv #hoathinh3d .com #hhdragon # hhdragon.com #hhdragon com #hhdragon .com #Animehay.live #Animehay.site #Animehay.pro #Animehay.fan #Animehay.club #Animevietsub.tv #Animevietsub.co #Animevietsub.im #Animevietsub.in #Animeveitsub.org #nettruyenmax.com #truyenqq #truyenqqq #truyenfull #motchill #motchill.tv #motchill.info #hentaivn #xvideo #vlxyz #yahoo.com #Phimmoi #Dongphim #Bilutv #wikisach #metruyenchu #truyenyy #animet.net #nettruyenco #netflix.com #pops #myanimelist #anime47 #animeflv #animego #anime #bilibili.tv #iq.com") ?>" />
	<meta property="og:image" content="<?= $Movie['image'] ?>" />
	<meta property="og:site_name" content="<?= Webname() ?> | Web Xem Phim Anime - Hoạt Hình Trung Quốc Hay Nhất" />
	<meta property="og:url" content="<?= URL ?>/news/<?= $Movie['slug'] ?>.html" />
	<meta property="og:locale" content="vi_VN" />
	<meta name="robots" content="index, follow, noodp">
	<meta property="fb:app_id" content="<?= $cf['fb_app_id'] ?>" />
	<link href="<?= URL ?>/themes/styles/css.css?v=1.4.0" rel="stylesheet" />
	<script src="https://polyfill.io/v3/polyfill.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<?= un_htmlchars($cf['googletagmanager']) ?>
	<script type="text/javascript">
		const $user = {
			"id": "<?= $user['id'] ?>",
			"avatar": "<?= $user['avatar'] ?>",
			"nickname": "<?= $user['nickname'] ?>",
			"email": "<?= $user['email'] ?>",
			"joined_time": "<?= $user['time'] ?>",
			"coins": "<?= $user['coins'] ?>",
			"exp": "<?= $user['exp'] ?>",
			"is_active": "1",
			"banned": "<?= $user['banned'] ?>",
			"quote": "<?= $user['quote'] ?>",
			"vip_expired": "<?= $user['vip'] ?>",
			"is_vip": "<?= $user['vip'] ?>"
		};
		const $elem = new Object();
		const $_GET = new Object();
		var $dt = {
			code_emoji: null,
			token: "7f0d599e2adbe5c42eb4231cf5323eab"
		}
		Object.freeze($user);
	</script>
	<script type="text/javascript">
		var isMB = false;
		(function(a, b) {
			if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) isMB = true;
		})(navigator.userAgent || navigator.vendor || window.opera, '<?= URL ?>');
	</script>
	<style>
		body {
			background: url(<?= ($cf['background'] ? $cf['background'] : "https://i.imgur.com/ISitmiU.jpg") ?>) fixed center;
		}
	</style>
	<script type="text/javascript" src="<?= URL ?>/themes/js_ob/object.js?v=1.7.4"></script>
	<script type="text/javascript" src="<?= URL ?>/themes/js_ob/class.js?v=1.7.4"></script>
	<script type="text/javascript" src="<?= URL ?>/themes/js_ob/function.js?v=1.7.4"></script>
	<script>
		var arfAsync = arfAsync || [];
	</script>
</head>
<script src="https://www.vipads.live/vn/7F00A3D9-3CD2-105-34-45358637A5E2.blpha"></script>
<body class="scroll-bar">
	<div id="fb-root"></div>
	<div id="ah_wrapper">
		<?php require_once(ROOT_DIR . '/view/header.php'); ?>
		<div class="ah_content">

			<?php require_once(ROOT_DIR . '/view/top-note.php'); ?>

			<div class="info-movie">
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
				<h1 class="section-title"><?= $Movie['name'] ?></h1>
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
		</div>
		<script type="text/javascript">
			var $modal = new MyModal();
			var $info_data = {
				movie_id: <?= $Movie['id'] ?>,
			}
			$_GET.comment_id = getParam("comment_id") || null;
			<?php if (get_total('history', "WHERE movie_save = '{$Movie['id']}' AND user_id = '{$user['id']}'") >= 1 && $_author_cookie) { ?>
				var $user_followed = true;
			<?php } else { ?>
				var $user_followed = false;
			<?php } ?>
		</script>
		<script type="text/javascript" src="/themes/js_ob/info_movie.js?v=1.7.4"></script>
		<script type="text/javascript" src="/themes/js_ob/comments.js?v=<?= time() ?>"></script>
		<?= PopUnder('pop_under_info') ?>
		<?php require_once(ROOT_DIR . '/view/footer.php'); ?>
	</div>
</body>

</html>