<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="theme-color" content="#234556" />
<meta name="msapplication-navbutton-color" content="#234556" />
<meta name="apple-mobile-web-app-status-bar-style" content="#234556" />
<link rel="apple-touch-icon" sizes="152x152" href="<?= $cf['favico'] ?>" />
<link rel="shortcut icon" href="<?= $cf['favico'] ?>" type="image/x-icon" />
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />

<!-- SEO -->
<?php
	$currentTitle = isset($title) ? $title : $cf['title'];
	$currentDescription = isset($description) ? $description : $cf['description'];
	
	// Xử lý image cho Open Graph
	$currentImage = '';
	if (isset($image)) $currentImage = $image;
	elseif (isset($og_image)) $currentImage = $og_image;
	elseif (isset($Movie['image']) && !empty($Movie['image'])) $currentImage = $Movie['image'];
	elseif (isset($cf['logo']) && !empty($cf['logo'])) $currentImage = $cf['logo'];
	elseif (isset($cf['favico']) && !empty($cf['favico'])) $currentImage = $cf['favico'];
	
	// Đảm bảo image URL là absolute
	if ($currentImage && strpos($currentImage, 'http') !== 0 && strpos($currentImage, '//') !== 0) $currentImage = URL . '/' . ltrim($currentImage, '/');
	
	// Xử lý canonical URL - đảm bảo là absolute URL
	$canonicalUrl = isset($canonical) ? $canonical : URL_LOAD;
	if (strpos($canonicalUrl, 'http') !== 0) $canonicalUrl = URL . '/' . ltrim($canonicalUrl, '/');
	
	// Xử lý og:url - đảm bảo là absolute URL
	$ogUrl = isset($og_url) ? $og_url : URL_LOAD;
	if (strpos($ogUrl, 'http') !== 0) $ogUrl = URL . '/' . ltrim($ogUrl, '/');
	
	// Xác định og:type
	$ogType = isset($og_type) ? $og_type : (isset($Movie) ? 'video.movie' : 'website');
?>
<title><?= htmlspecialchars($currentTitle, ENT_QUOTES, 'UTF-8') ?></title>
<meta name="description" content="<?= htmlspecialchars($currentDescription, ENT_QUOTES, 'UTF-8') ?>" />
<link rel="canonical" href="<?= $canonicalUrl ?>" />

<!-- Open Graph -->
<meta property="og:type" content="<?= $ogType ?>" />
<meta property="og:locale" content="vi_VN" />
<meta property="og:title" content="<?= htmlspecialchars($currentTitle, ENT_QUOTES, 'UTF-8') ?>" />
<meta property="og:description" content="<?= htmlspecialchars($currentDescription, ENT_QUOTES, 'UTF-8') ?>" />
<meta property="og:url" content="<?= $ogUrl ?>" />
<meta property="og:site_name" content="<?= $cf['title'] ?>" />
<?php if ($currentImage): ?>
<meta property="og:image" content="<?= $currentImage ?>" />
<meta property="og:image:secure_url" content="<?= $currentImage ?>" />
<meta property="og:image:type" content="image/jpeg" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:image:alt" content="<?= htmlspecialchars($currentTitle, ENT_QUOTES, 'UTF-8') ?>" />
<?php endif; ?>

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image" />
<?php if (isset($cf['twitter_site']) && !empty($cf['twitter_site'])): ?>
<meta name="twitter:site" content="<?= $cf['twitter_site'] ?>" />
<?php endif; ?>
<meta name="twitter:title" content="<?= htmlspecialchars($currentTitle, ENT_QUOTES, 'UTF-8') ?>" />
<meta name="twitter:description" content="<?= htmlspecialchars($currentDescription, ENT_QUOTES, 'UTF-8') ?>" />
<?php if ($currentImage): ?>
<meta name="twitter:image" content="<?= $currentImage ?>" />
<meta name="twitter:image:alt" content="<?= htmlspecialchars($currentTitle, ENT_QUOTES, 'UTF-8') ?>" />
<?php endif; ?>

<!-- Article Meta (nếu là trang article) -->
<?php if (isset($articlePublishedTime)): ?>
<meta property="article:published_time" content="<?= $articlePublishedTime ?>" />
<?php endif; ?>
<?php if (isset($articleModifiedTime)): ?>
<meta property="article:modified_time" content="<?= $articleModifiedTime ?>" />
<?php endif; ?>
<?php if (isset($articleAuthor)): ?>
<meta property="article:author" content="<?= $articleAuthor ?>" />
<?php endif; ?>
<?php if (isset($articleSection)): ?>
<meta property="article:section" content="<?= $articleSection ?>" />
<?php endif; ?>

<?= loadSchemaSEO([
	'title' => $currentTitle,
	'description' => $currentDescription,
	'url' => $canonicalUrl
]) ?>
<!-- End SEO -->
<?= un_htmlchars($cf['googletagmanager']) ?>

<!-- DNS Prefetch & Preconnect -->
<link rel="dns-prefetch" href="https://cdn.jsdelivr.net/" />
<link rel="dns-prefetch" href="https://cdnjs.cloudflare.com/" />
<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin />
<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin />
<?php if (isset($cf['googletagmanager']) && !empty($cf['googletagmanager'])): ?>
<link rel="preconnect" href="https://www.googletagmanager.com" crossorigin />
<link rel="dns-prefetch" href="https://www.googletagmanager.com" />
<?php endif; ?>
<style id="wp-img-auto-sizes-contain-inline-css">
	img:is([sizes="auto" i], [sizes^="auto," i]) {
		contain-intrinsic-size: 3000px 1500px;
	}
</style>
<link rel="stylesheet" href="/themes/new-theme/css/bootstrap.min.css" />

<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<link href="/themes/styles/css.css?v=1.4.0" rel="stylesheet" />
<style rel="stylesheet" id="global-styles-inline-css" href="/themes/new-theme/css/global.css"></style>
<link rel="stylesheet" href="/themes/new-theme/css/halim-icon-font.css" />
<link rel="stylesheet" href="/themes/new-theme/css/style.css" />
<link rel="stylesheet" href="/themes/new-theme/css/index.css" />
<link rel="stylesheet" href="/themes/new-theme/css/main.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="<?= URL ?>/themes/js/jwplayer.js?v=1.0.8"></script>
<script type="text/javascript">
	jwplayer.key = "ITWMv7t88JGzI0xPwW8I0+LveiXX9SWbfdmt0ArUSyc=";
</script>
<style>
	#header .site-title {
		background: url(<?= $cf['logo'] ?>) no-repeat top left;
		background-size: contain;
		text-indent: -9999px;
	}
</style>

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
	var isMB = false;
	(function(a, b) {
		if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) isMB = true;
	})(navigator.userAgent || navigator.vendor || window.opera, '<?= URL ?>');
</script>
<script type="text/javascript" src="<?= URL ?>/themes/js_ob/object.js?v=1.7.4"></script>
<script type="text/javascript" src="<?= URL ?>/themes/js_ob/class.js?v=1.7.4"></script>
<script type="text/javascript" src="<?= URL ?>/themes/js_ob/function.js?v=1.7.4"></script>