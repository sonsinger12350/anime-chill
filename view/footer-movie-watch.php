<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
FireWall();
?>
<div class="vip_user" data-vip="<?= $user['vip'] ?? 0 ?>"> </div>
<script>
	$(function() {
		$(window).scroll(function() {
			if ($(this).scrollTop() > 500)
				$('#top-up').fadeIn(400);
			else
				$('#top-up').fadeOut(100);
		});
		$("#top-up").click(function() {
			$("html, body").animate({
				scrollTop: 0
			}, {
				duration: 300
			})
		});
	});
</script>
<?php
	$scriptAds = json_decode($cf['script_fooj'], true);

	if (!empty($scriptAds['script'])) {
		$activeScript = 0;
		$canShowAds = canShowAds('script_fooj', $scriptAds['time_distance'], $scriptAds['number_displayed']);

		if ($canShowAds) {
			if (!empty($scriptAds)) {
				if (!empty($user['vip'])) {
					if ($user['vip'] <> 1) {
						$activeScript = 1;
						echo un_htmlchars($scriptAds['script']);
					}
				} else {
					$activeScript = 1;
					echo un_htmlchars($scriptAds['script']);
				}
			}
		}

		if ($activeScript && $_SESSION['ads']['script_fooj'] < $scriptAds['number_displayed']) {
			$_SESSION['ads']['script_fooj'] += 1;
		}
	}
?>