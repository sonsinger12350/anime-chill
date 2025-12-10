<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$value[2]) die(header('location:' . URL));
$MovieSlug = sql_escape($value[2]);
$EpisodeID = sql_escape($value[3]);
FireWall();
if (get_total("movie", "WHERE slug = '$MovieSlug'") < 1) die(header('location:' . URL));
if (get_total("episode", "WHERE id = '$EpisodeID'") < 1) die(header('location:' . URL . "/info/$MovieSlug.html"));
$Movie = GetDataArr("movie", "slug = '$MovieSlug'");
$Ep = GetDataArr("episode", " id = '$EpisodeID'");
$mysql->update("movie", "view = view + 1, view_day = view_day + 1, view_week = view_week + 1, view_month = view_month + 1, view_year = view_year + 1", "id = '{$Movie['id']}'");
$statut = ($Movie['loai_phim'] == 'Phim Lẻ' ? "{$Movie['movie_duration']} Phút" : "$NumEpisode/{$Movie['ep_num']}");

// SEO
$title = "Xem phim {$Movie['name']} - Tập {$Ep['ep_name']} - {$cf['title']}";
$description = strip_tags($Movie['content']);
$image = $Movie['image'];
// End SEO

// ===== NEW LOGIC: GET ALL EPISODES AND SERVERS =====
// Get all episodes of the movie
$allEpisodes = [];
$arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "episode WHERE movie_id = '{$Movie['id']}' ORDER BY ep_num ASC");
while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
    $allEpisodes[] = $row;
}

// Create mapping server => list of episodes
$serverEpisodes = [];

foreach ($allEpisodes as $episode) {
    $servers = json_decode($episode['server'], true);

    if ($servers) {
        foreach ($servers as $server) {
            if (!empty($server['server_link']) && !empty($server['server_name'])) {
				$serverName = $server['server_name'];
                if (!isset($serverEpisodes[$serverName])) $serverEpisodes[$serverName] = [];
                $serverEpisodes[$serverName][] = $episode['ep_num'];
            }
        }
    }
}

// Save current server into Session when accessing page
if (!isset($_SESSION['current_server'])) {
    $_SESSION['current_server'] = null;
}

$ep_num_plus = ($Ep['ep_num'] + 1);
$ep_num = ($Ep['ep_num'] - 1);
if (get_total('episode', "WHERE movie_id = '{$Movie['id']}' AND ep_num = '$ep_num_plus'") >= 1) {
    $EpNext = GetDataArr('episode', "movie_id = '{$Movie['id']}' AND ep_num = '$ep_num_plus'");
    $JsNextEpisode = 'window.location.href = "' . URL . '/watch/' . $Movie['slug'] . '-episode-id-' . $EpNext['id'] . '.html";';
} else $JsNextEpisode = 'Toast({
    message: "Không có tập tiếp theo",
    type: "error"
});
final_ep = true;';

if (get_total('episode', "WHERE movie_id = '{$Movie['id']}' AND ep_num = '$ep_num'") >= 1) {
    $EpNext = GetDataArr('episode', "movie_id = '{$Movie['id']}' AND ep_num = '$ep_num'");
    $JsOldEpisode = 'window.location.href = "' . URL . '/watch/' . $Movie['slug'] . '-episode-id-' . $EpNext['id'] . '.html";';
} else $JsOldEpisode = 'Toast({
    message: "Không có tập trước",
    type: "error"
});
final_ep = true;';

$arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "episode WHERE movie_id = '{$Movie['id']}' ORDER BY id DESC");
while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
    $Active = ($row['id'] == $EpisodeID ? 'active' : '');
    // List Episode
    $ListEpisode .= '
        <a href="' . URL . '/watch/' . $Movie['slug'] . '-episode-id-' . $row['id'] . '.html" title="' . $row['ep_name'] . '" class="' . $Active . '">
            <span>' . $row['ep_name'] . '</span>
        </a>
    ';
}

$listServer = [];
$arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "server ORDER BY id DESC");

while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
    $listServer[$row['id']] = $row['server_name'];
    if ($row['server_player'] == 'player') {
        $SupportServer .= "{$row['server_name']},";
    }
}

if (isset($_POST['send_error'])) {
    $note = sql_escape($_POST['note']);
    if ($note && $EpisodeID && $Movie['id']) {
        if (get_total("report", "WHERE movie_id = '{$Movie['id']}' AND episode_id = '$EpisodeID'") < 1) {
            $mysql->insert("report", "movie_id,episode_id,content", "'{$Movie['id']}','$EpisodeID','$note'");
        }
    }
}
if (isset($_author_cookie)) {
    $day = date('d');
    if (get_total('user_movie', "WHERE movie_id = '{$Movie['id']}' AND user_id = '{$user['id']}' AND day = '$day'") < 1) {
        $mysql->update('user', "exp = exp + 3", "id = '{$user['id']}'");
        $mysql->insert('notice', 'user_id,content,timestap,time', "'{$user['id']}','Bạn Được Cộng 3xp Khi Xem \"{$Movie['name']}\"','" . time() . "','" . DATE . "'");
        $mysql->insert('user_movie', "movie_id,user_id,day", "'{$Movie['id']}','{$user['id']}','$day'");
    }
}
$VastPlayer = (get_total('ads', "WHERE position_name = 'vast_mp4' AND type = 'true'") >= 1 ? "'" . URL . "/player-ads.xml'" : '');
$tvcConfig = !empty($cf['tvc_config']) ? json_decode($cf['tvc_config'], true) : [];

if (!empty($tvcConfig) && empty($user['vip'])) {
    $activeTVC = 0;
    $adsName = 'tvc_ads';
    $canShowAds = canShowAds($adsName, $tvcConfig['time_distance'], $tvcConfig['number_displayed']);
    if ($canShowAds) $activeTVC = 1;
    if ($activeTVC && $_SESSION['ads'][$adsName] < $tvcConfig['number_displayed']) $_SESSION['ads'][$adsName] += 1;
}

if ($cf['tvc_on'] == 'true' && $activeTVC) $tvc = URL . "/tvc?url=";
ob_start();
?>
<style>
	#list_sv .button-default.bg-green {
		background-color: #369e69;
	}

	.title-wrapper.full{
		display: flex;
		align-items: center;
		justify-content: start;
		gap: 12px;
		padding: 0;
	}

	.title-block.watch-page {
		padding: 8px 16px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		flex-wrap: wrap;
		gap: 8px;
	}

	#toggle_follow {
		display: block;
	}

	.halim-rating-container {
		margin: 0;
	}

	.modal {
		height: 112px;
	}

	.info-movie .rated-star span {
		cursor: pointer;
	}

	.ratings_wrapper {
		width: max-content;
		margin: 0;
		float: none;
		z-index: unset;
	}

	.halim-rating-container {
		gap: 8px;
	}

	.ah-frame-bg {
		background: #3333334a !important;
	}

	.showtimes {
		display: flex;
		align-items: center;
		justify-content: start;
		gap: 8px;
		font-weight: 600;
	}

	.info-movie .list_episode .list-item-episode {
		justify-content: start;
		gap: 8px;
		flex-wrap: wrap;
		overflow-x: hidden;
	}

	.info-movie .list_episode .list-item-episode a,
	.info-movie .list_episode .list-item-episode a:visited {
		width: 70px;
		padding: 6px;
		border: 0;
		background: #333;
		color: #fff;
		border-radius: 3px;
	}

	.info-movie .list_episode .list-item-episode a:hover,
	.info-movie .list_episode .list-item-episode a.active {
		background: linear-gradient(to right,#1a2980,#26d0ce);
	}
</style>
<div class="row container single-post info-movie" id="wrapper">
	<main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
		<div class="ah_content">
			<div class="watching-movie">
				<div id="settings-while-watching" class="display-none">
					<div class="flex flex-ver-center flex-hozi-center flex-column align-center">
						<div class="fs-17 fw-500 color-yellow">
							Chỉ áp dụng cho server <?= $SupportServer ?>
						</div>
						<div class="padding-5 fw-500">Tự động chuyển tập mới ở mốc thời gian :</div>
						<label class="switch">
							<input type="checkbox" class="auto-open-next-ep" onchange="aoneEvent(event)"><span class="slider round"></span></label>
						<div class="padding-5">
							<div class="aone-on display-none flex-hozi-center">
								<input name="aone-min" class="bg-black color-white align-center w-50 padding-5" value="0" onchange="aoneMin(event)" type="number" />
								<b class="fs-19 margin-0-5">:</b>
								<input name="aone-sec" class="bg-black color-white align-center w-50 padding-5" value="0" onchange="aoneSec(event)" type="number" />
							</div>
						</div>

						<div class="padding-5 fw-500">Tự động Bỏ Qua Openning :</div>
						<label class="switch">
							<input type="checkbox" class="skip-op" onchange="skipOpEvent(event)"><span class="slider round"></span></label>
						<div class="padding-5">
							<div class="turn-on-skip-op display-none flex-hozi-center">
								<input name="skip-op-min" class="bg-black color-white align-center w-50 padding-5" value="0" onchange="skipOpMin(event)" type="number" />
								<b class="fs-19 margin-0-5">:</b>
								<input name="skip-op-sec" class="bg-black color-white align-center w-50 padding-5" value="0" onchange="skipOpSec(event)" type="number" />
							</div>
						</div>

						<div class="padding-5 fw-500">Tự động bật chế độ Night(<b class="color-red-2">VIP</b>)</div>
						<div>
							<label class="switch"><input type="checkbox" class="auto-turn-on-night-mode" onchange="atonmEvent(event)"><span class="slider round"></span></label>
						</div>
						<div class="padding-5 fw-500">Tự động phóng to khi ấn nút Play</div>
						<div>
							<label class="switch"><input type="checkbox" class="auto-full-screen" onchange="afsEvent(event)"><span class="slider round"></span></label>
						</div>
					</div>
				</div>
				<div id="list_sv" class="flex flex-ver-center margin-10" style="flex-wrap: wrap;">
					<?php
						$Defult = 0;
						$movieServer = (!empty($Ep['server']) && $Ep['server'] != 'null') ? array_column(json_decode($Ep['server'], true), 'server_link', 'server_name') : [];

						// Check current server from session
						$currentServer = !empty($_SESSION['current_server']) ? $_SESSION['current_server'] : $Defult;
						$serverFound = false;
						$alternativeServer = null;

						foreach ($serverEpisodes as $server => $episodes) {
							if (in_array($Ep['ep_num'], $episodes)) {
								$alternativeServer = $server;
								break;
							}
						}

						foreach (array_keys($serverEpisodes) as $s) {
							if (strtolower($currentServer) == strtolower($s)) {
								$currentServer = $s;
								$serverFound = true;
								break;
							}
						}

						if (!$serverFound || !in_array($Ep['ep_num'], $serverEpisodes[$currentServer])) {
							$currentServer = $alternativeServer;
						}
						
						$currentServer = strtolower($currentServer);

						foreach ($listServer as $server) {
							if (!empty($movieServer[$server])) {
								$Defult++;
								$serverName = ServerName($server);

								echo '<a href="javascript:void(0)" class="button-default" id="sv_' . $serverName . '" name="' . $serverName . '">' . $server . '</a>';
							}
						}

						$ServerDF = "startStreaming('" . ServerName($currentServer) . "', 1)";
					?>
				</div>
				<div id="video-player">
					<div class="loading" style="text-align: center;margin-bottom: 15px;">
						<div><img src="<?= URL ?>/themes/img/5Q0v.gif" alt="" width="100px" height="100px;"></div>
						<b>Đang Tải Player Vui Lòng Chờ</b>
					</div>
				</div>
				<script type="text/javascript">
					var $info_play_video = {
						vast: [<?= $VastPlayer ?>],
					}
					var $list_sv = document.getElementById("list_sv");
					var final_ep, next_ep_act = false;
					var aone_time, aone_event, skip_op, skip_op_time = 0;
					
					// Global variable to save server and episode information
					var serverEpisodes = <?= json_encode($serverEpisodes) ?>;
					var currentServer = "<?= $currentServer ?>";

					if (currentServer)  $(`#sv_${currentServer}`).addClass("bg-green");
					else $('#list_sv a').first().addClass("bg-green");
					
					if ($user.is_vip == 1) {
						$info_play_video.vast = null;
					}

					function convertHMS(value) {
						const sec = parseInt(value, 10); // convert value to number if it's string
						let hours = Math.floor(sec / 3600); // get hours
						let minutes = Math.floor((sec - (hours * 3600)) / 60); // get minutes
						let seconds = sec - (hours * 3600) - (minutes * 60); //  get seconds
						// add 0 if value < 10; Example: 2 => 02
						if (hours < 10) {
							hours = "0" + hours;
						}
						if (minutes < 10) {
							minutes = "0" + minutes;
						}
						if (seconds < 10) {
							seconds = "0" + seconds;
						}
						return hours + ':' + minutes + ':' + seconds; // Return is HH : MM : SS
					}

					function setAoneTime() {
						aone_event = $cookie.getItem("aone_event") || 0;
						var aone_min = parseInt($cookie.getItem("aone_min")) || 0;
						var aone_sec = parseInt($cookie.getItem("aone_sec")) || 0;
						if (aone_event) {
							aone_time = aone_min * 60 + aone_sec;
						}
						return aone_time;
					}

					function setSkipOpTime() {
						skip_op = $cookie.getItem("skip_op") || 0;
						var skip_op_min = parseInt($cookie.getItem("skip_op_min")) || 0;
						var skip_op_sec = parseInt($cookie.getItem("skip_op_sec")) || 0;
						if (skip_op)
							skip_op_time = skip_op_min * 60 + skip_op_sec;
						return skip_op_time;

					}

					function initSkip() {
						let get_aone_time = setAoneTime();
						let get_skip_op_time = setSkipOpTime();

						if (get_aone_time <= get_skip_op_time) {
							alert("Cài thời gian chuyển tập mới phải hơn thời gian bỏ qua OP");
							aone_time = 0;
						}
					}
					initSkip();
					var skip_ads = null;

					function loadVideo(s, aa, seek, w, load_hls = false) {
						var jp = jwplayer("video-player");
						jp.setup({
							//sources: s,
							file: s,
							width: w,
							height: "100%",
							aspectratio: "16:9",
							playbackRateControls: [0.75, 1, 1.25, 1.5, 2, 2.5],
							autostart: true,
							volume: 100,
							advertising: {
								client: 'vast',
								admessage: 'Quảng cáo còn XX giây.',
								skipoffset: 5,
								skiptext: 'Bỏ qua quảng cáo',
								skipmessage: 'Bỏ qua sau xxs',
								tag: aa,
							},

						})

						function forwardTenSecond() {
							jp.seek(jp.getPosition() + 10);
						}
						jp.addButton("<?= URL ?>/themes/img/next_episode.png?v=1.1.8", "Tập tiếp theo", nextEpisode, "next-episode");
						jp.addButton("<?= URL ?>/themes/img/forward_10s.png?v=1.1.8", "Tua tiếp 10s", forwardTenSecond, "forward-10s");

						if (seek != 0) {
							jp.seek(seek)
						}
						jp.on('time', function(e) {
							$cookie.setItem('resumevideodata', Math.floor(e.position) + ':' + jp.getDuration(), 82000, window.location.pathname);
							if (aone_event && aone_time) {
								if (e.position > aone_time && !final_ep && !next_ep_act) {
									nextEpisode();
									next_ep_act = true;
								}
							}
						});
						jp.on('adImpression', function() {
							var jw_controls = getElem("video-player");
							skip_ads = document.createElement("div");
							skip_ads.textContent = "Bỏ qua quảng cáo";
							skip_ads.style.position = "absolute";
							skip_ads.style.right = "5px";
							skip_ads.style.top = "5px";
							skip_ads.style.background = "#000";
							skip_ads.style.color = "#fff";
							skip_ads.style.padding = "10px";
							skip_ads.style.zIndex = 1;
							skip_ads.addEventListener("click", function() {
								skip_ads.remove();
								jwplayer().skipAd();
							})
							execDelay(function() {
								jw_controls.insertAdjacentElement("afterbegin", skip_ads);
							}, 5000)
						})
						jp.on('firstFrame', function() {
							// skip_ads.remove();
							var cookieData = $cookie.getItem('resumevideodata');
							if (cookieData) {
								var resumeAt = cookieData.split(':')[0],
									videoDur = cookieData.split(':')[1];
								if (parseInt(resumeAt) < parseInt(videoDur)) {
									Swal.fire({
										title: 'Thông báo',
										html: 'Lần trước bạn đã xem tới <font color="red">' + convertHMS(resumeAt) + "</font><br/>Bạn Có muốn xem tiếp ?",
										showCancelButton: true,
										preConfirm: () => {
											(resumeAt == 0) ? resumeAt = 1: "";
											jp.seek(resumeAt);
										}
									})

								} else if (cookieData && !(parseInt(resumeAt) < parseInt(videoDur))) {}
							}
							if ($cookie.getItem("afs_on")) {
								execDelay(function() {
									jp.setFullscreen(true)
								}, 2000);
							}
						});
						jp.on('ready', function() {
							if ($cookie.getItem("atonm_on")) {
								getElem("toggle-light").click();
							}
						})
						jp.on("seek", function(e) {
							seek = e.offset;
						})

						return jp;
					}

					function nextEpisode() {
						<?= $JsNextEpisode ?>
					}

					function oldEpisode() {
						<?= $JsOldEpisode ?>
					}
					(async () => {
						$.ajaxSetup({
							headers: {
								"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
							},
						});
						var LoadPlayerServer = (async () => {
							return new Promise((resolve, reject) => {
								$.ajax({
									type: "POST",
									url: '/server/ajax/player',
									data: {
										MovieID: <?= $Movie['id'] ?>,
										EpisodeID: <?= $Ep['id'] ?>
									},
									success: function(ResponsePlayer) {
										resolve(ResponsePlayer);
									}
								});
							});
						});
						var PlayerServer = await LoadPlayerServer();
						var startStreaming = (async (name_server, first_server = null) => {
							var _video_player = document.getElementById("video-player");
							var load_video;
							if (PlayerServer.code != 200) {
								$('#video-player').html(`<div style="text-align: center;margin-bottom: 15px;"><img src="/themes/img/error.png" width="100" height="100"><div>${PlayerServer.message}</div></div>`);
								return
							}
							switch (name_server) {
								<?php
								$arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "server ORDER BY id DESC");
								while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
									if ($row['server_player'] == 'player') {
										echo '
								case \'' . ServerName($row['server_name']) . '\':
									var SourceVideo = {
										"file": PlayerServer.src_' . ServerName($row['server_name']) . ',
									}
									load_video = loadVideo(PlayerServer.src_' . ServerName($row['server_name']) . ', $info_play_video.vast, skip_op_time, \'100%\');
									break;';
									} else {
										echo '
								case \'' . ServerName($row['server_name']) . '\':
									_video_player.innerHTML = `<div style="position: relative;padding-bottom: 57.25%"><iframe style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;overflow:hidden;" frameborder="0" src="' . $tvc . '${PlayerServer.src_' . ServerName($row['server_name']) . '}" frameborder="0" scrolling="0" allowfullscreen></iframe></div>`;
									break;';
									}
								?>
								<?php } ?>
								default:
									break;
							}
							first_server == null && $cookie.setItem('server_watching', name_server, 86400);
							$(`#sv_${name_server}`).addClass("bg-green");
						});
						<?= $ServerDF ?>

						list_sv.childNodes.forEach(item => {
							item.addEventListener("click", function(e) {
								list_sv.querySelector(".bg-green").classList.remove("bg-green");
								this.classList.add("bg-green");
								var selectedServer = this.getAttribute("name");
								
								// Save current server into session
								$.ajax({
									type: "POST",
									url: "/server/api",
									contentType: "application/json",
									dataType: "json",
									data: JSON.stringify({
										action: "set_current_server",
										server: selectedServer
									})
								});

								// Update current server
								currentServer = selectedServer;
								
								startStreaming(selectedServer);
							})
						});
						
						// Initialize current server when loading page
						var activeServer = document.querySelector("#list_sv .bg-green");
						if (activeServer) {
							currentServer = activeServer.getAttribute("name");
						}
					})();
				</script>
				<div class="flex flex-ver-center margin-10">
					<div class="button-default flex flex-hozi-center fw-700 bg-blue" id="toggle-light">
						<span class="material-icons-round ">nightlight</span>Night
					</div>
					<button id="report_error" class="button-default flex flex-hozi-center bg-red">
						<span class="material-icons-round">report_problem</span> Báo lỗi
					</button>
					<div>
						<a href="javascript:oldEpisode();" class="button-default padding-5-20 flex flex-hozi-center fw-700">
							<span class="material-icons-round ">arrow_back_ios</span>Trước
						</a>
					</div>
					<div>
						<a href="javascript:nextEpisode();" class="button-default padding-5-20 flex flex-hozi-center fw-700">
							Tiếp<span class="material-icons-round "> arrow_forward_ios</span>
						</a>
					</div>
				</div>
				<div class="title-block watch-page">
					<div class="title-wrapper full">
						<button id="toggle_follow" value="<?= $Movie['id'] ?>" type="button" class="button-default bg-lochinvar watch-btn"><i class="fa-solid fa-bookmark"></i></button>
						<h1 class="entry-title"><a href="<?= URL ?>/info/<?= $Movie['slug'] ?>.html" title="<?= $Movie['name'] ?> <?= $Ep['ep_name'] ?> HD" class="tl"><?= $Movie['name'] ?> - Tập <?= $Ep['ep_name'] ?> HD</a></h1>
					</div>
					<div class="ratings_wrapper single-info">
						<div class="halim-rating-container">
							<div class="halim-star-rating">
								<span class="halim-star-icon">★</span>
								<span class="halim-rating-score"><?= !empty($Movie['vote_all']) ? round($Movie['vote_point']/$Movie['vote_all'], 2) : 0 ?></span>
								<span class="halim-rating-slash">/</span>
								<span class="halim-rating-max">10</span>
								<span class="halim-rating-votes">(<span class="halim_num_votes"><?= $Movie['vote_all'] ?></span> lượt đánh giá)</span>
							</div>
							<button type="button" class="halim-rating-button" id="rated">Đánh Giá</button>
						</div>
					</div>
				</div>
				<div id="PlayerAds" style="text-align: center;"></div>
				<?php if ($Movie['lich_chieu']) {
					foreach (json_decode($Movie['lich_chieu'], true) as $key => $value) {
						if ($value['days'] == 8) {
							$Days .= "Chủ Nhật,";
						} else {
							$Days .= "Thứ {$value['days']},";
						}
					}
				?>
					<div class="ah-frame-bg" style="margin-top: 16px;">
						<div class="showtimes">
							<img src="/assets/images/weekly-calendar.webp" alt="Lịch Chiếu" width="20" height="20">
							<p style="font-size: 16px;"><strong>Lịch Chiếu: <span style="color:#FFA500"><?= $Movie['showtimes'] ?> <span style="color:#FFA500"><?= $Days ?> Hàng Tuần</span></strong></p>
						</div>
					</div>
				<?php } ?>
				<?php if ($Movie['keyword']) { ?>
					<div class=" bind_movie">
						<div>
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
				<div class="list_episode ah-frame-bg" id="list-episode">
					<div class="heading flex flex-space-auto fw-700">
						<span>Danh sách tập</span>
						<span id="newest-ep-is-readed" class="fs-13"></span>
					</div>
					<div class="list-item-episode scroll-bar">
						<?= $ListEpisode ?>
					</div>
				</div>
				<?php if ($cf['cmt_on'] == 'true') { ?>
					<div class="ah-frame-bg">
						<div class="flex flex-space-auto">
							<div class="fw-700 fs-16 color-yellow-2 flex flex-hozi-center"><span class="material-icons-round margin-0-5">
									comment
								</span>Bình luận (<?= number_format(get_total('comment', "WHERE movie_id = '{$Movie['id']}'")) ?>)</div>
							<div id="refresh-comments" class="cursor-pointer"><span class="material-icons-round fs-35">refresh</span></div>
						</div>
						<?php if (!$_author_cookie) { ?>
							<div class="flex flex-ver-center fw-500">
								<a href="/login" class="button-default bg-red">
									Đăng nhập để bình luận
								</a>
							</div>
						<?php } ?>
						<script type="text/javascript" src="/themes/js_ob/fgEmojiPicker.js?v=1.7.4"></script>
						<div id="frame-comment">
						</div>
						<div id="comments" class="margin-t-10" style="width: 100%;overflow: hidden;">
						</div>
					</div>
				<?php } ?>
			</div>

			<script type="text/javascript">
				var $info_data = {
					movie_id: <?= $Movie['id'] ?>,
					id: <?= $Ep['id'] ?>,
					no_ep: "<?= $Ep['ep_name'] ?>"
				}
				$_GET.comment_id = getParam("comment_id") || null;
				<?php if (get_total('history', "WHERE movie_save = '{$Movie['id']}' AND user_id = '{$user['id']}'") >= 1 && $_author_cookie) { ?>
					var $user_followed = true;
				<?php } else { ?>
					var $user_followed = false;
				<?php } ?>
			</script>
			<div class="opacity">
				<h3>Phim <?= $Movie['name'] ?> <?= $Ep['ep_name'] ?> HD</h3>
				<h3><?= $Movie['name'] ?> <?= $Ep['ep_name'] ?> Thuyet minh</h3>
				<h3><?= $Movie['name'] ?> <?= $Ep['ep_name'] ?> vietsub</h3>
				<h3>Xem <?= $Movie['name'] ?> <?= $Ep['ep_name'] ?> hd vietsub</h3>
				<h3><?= $Movie['name'] ?> <?= $Ep['ep_name'] ?></h3>
			</div>
			<div id="modal" class="modal" style="display: block; visibility: hidden; top: 0px; transition: top 0.3s;">
				<div>
					<div>Đánh giá phim</div>
					<a href="javascript:$modal.toggleModal()"><span class="material-icons-round margin-0-5">close</span></a>
				</div>
				<div>
					<div class="rated-star flex flex-hozi-center flex-ver-center">
						<span rate="1"><span class="material-icons-round">star</span></span><span rate="2"><span class="material-icons-round">star</span></span><span rate="3"><span class="material-icons-round">star</span></span><span rate="4"><span class="material-icons-round">star</span></span><span rate="5"><span class="material-icons-round">star</span></span><span rate="6"><span class="material-icons-round">star</span></span><span rate="7"><span class="material-icons-round">star</span></span><span rate="8"><span class="material-icons-round">star</span></span><span rate="9"><span class="material-icons-round">star</span></span><span rate="10"><span class="material-icons-round">star</span></span>
					</div>
				</div>
			</div>

			<script type="text/javascript">
				var $modal = new MyModal();
				
				// Rating functionality
				function initUserRating() {
					try {
						var ratedButton = document.getElementById('rated');
						var ratedStars = document.querySelectorAll('.rated-star span[rate]');
						
						if (ratedButton && ratedStars.length > 0) {
							ratedButton.addEventListener('click', function() {
								$modal.toggleModal();
							});
							
							var canRate = true;
							ratedStars.forEach(function(star) {
								star.addEventListener('click', function(e) {
									if (!canRate) return;
									var rating = parseInt(this.getAttribute('rate'));
									
									canRate = false;
									axios.post('/server/api', {
										action: 'add_rate',
										movie_id: $info_data.movie_id,
										rating: rating
									}).then(function(response) {
										canRate = true;
										var result = response.data;

										if (result.status == 'success') {
											// Highlight selected stars
											ratedStars.forEach(function(s, index) {
												if (index < rating) s.classList.add('active');
												else s.classList.remove('active');
											});

											Toast({
												message: result.result,
												type: 'success'
											});

											setTimeout(function() {
												$modal.toggleModal();
											}, 1000);
										}
										else {
											Toast({
												message: result.result,
												type: 'error'
											});
										}
									}).catch(function(error) {
										canRate = true;
										console.error('Rating error:', error);
									});
								});
							});
						}
					} catch (error) {
						console.error('Init rating error:', error);
					}
				}
				
				// Initialize rating after DOM is ready
				if (document.readyState === 'loading') {
					document.addEventListener('DOMContentLoaded', initUserRating);
				} else {
					initUserRating();
				}
				
				CheckButton();
				$('#toggle_follow').on('click', function(e) {
					var Follow_store = localStorage.getItem("data_follow");
					let data_follow_store = Follow_store ? JSON.parse(Follow_store) : [];
					var index_this_movie = data_follow_store.indexOf($info_data.movie_id);
					var movie_id = $info_data.movie_id
					if (index_this_movie !== -1) {
						data_follow_store.splice(index_this_movie, 1);
						Toast({
							message: "Xoá Theo Dõi Thành Công!",
							type: "error"
						});
						$('#toggle_follow').html(`<span class="material-icons-round material-icons-menu">bookmark_add</span>`);
						$('#toggle_follow').css("background-color", "");
						localStorage.setItem("data_follow", JSON.stringify(data_follow_store));
					} else {
						var data = JSON.parse(Follow_store);
						try {
							data.push(movie_id);
							localStorage.setItem("data_follow", JSON.stringify(data));
						} catch (error) {
							localStorage.setItem("data_follow", JSON.stringify([movie_id]));
						}
						$('#toggle_follow').html(`<span class="material-icons-round">bookmark_remove</span>`);
						$('#toggle_follow').css("background-color", "rgb(125, 72, 72)");
						localStorage.removeItem('async_follow');
						Toast({
							message: "Thêm Vào Theo Dõi Thành Công",
							type: "success"
						});
					}
				});

				function CheckButton() {
					try {
						var Follow_store = localStorage.getItem("data_follow");
						let data_follow_store = Follow_store ? JSON.parse(Follow_store) : [];
						var index_this_movie = data_follow_store.indexOf($info_data.movie_id);
						var movie_id = $info_data.movie_id
						if (index_this_movie !== -1) {
							$('#toggle_follow').html(`<span class="material-icons-round">bookmark_remove</span>`);
							$('#toggle_follow').css("background-color", "rgb(125, 72, 72)");
						}
					} catch (error) {
						console.error(error);
					}
				}
			</script>
		</div>
		<?= PopUnder('pop_under_watch') ?>
		<?php require_once(ROOT_DIR . '/view/footer.php'); ?>
		<script type="text/javascript" src="<?= URL ?>/themes/js_ob/watching.js?v=1.7.4"></script>
		<script type="text/javascript" src="<?= URL ?>/themes/js_ob/history-new.js?v=<?= time() ?>"></script>
		<script type="text/javascript" src="<?= URL ?>/themes/js_ob/comments.js?v=<?= time() ?>"></script>
	</main>
</div>
<?php
$content = ob_get_clean();

// Include layout
require_once(ROOT_DIR . '/view/layout.php');
