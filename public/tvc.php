<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
FireWall();
$url = (GetParam("url") ? GetParam("url") : die());
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        * {
            margin: 0;
            padding: 0
        }

        html,
        body {
            background: #000000 url('https://i.imgur.com/rS3fZQx.png');
            background-repeat: no-repeat;
            background-position: center;
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
        }

        #jwplayer {
            position: absolute;
            width: 100%;
            height: 100%;
        }
    </style>
    <script data-cfasync="false" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script data-cfasync="false" src="https://ssl.p.jwpcdn.com/player/v/8.21.1/jwplayer.js"></script>
</head>

<body>
    <div id="jwplayer">Trình duyệt của bạn không hỗ trợ xem phim bằng Player HTML5. Vui lòng cài đặt Chrome hoặc Firefox</div>
    <script data-cfasync="false">
        // var ads	= ['/preload/five88.php','/preload/789club.php','/preload/loadmibet.php','/preload/b52.php','/guide1/pre-11bet.xml?sv=3.1','/preload/188bet.php'];
        // var arrPreroll = ads[Math.floor((Math.random() * 6) + 1)];
        var arrPreroll = "<?= URL ?>/player-ads.xml";
        var currentVolume;
        var skipDelay = 15,
            displaySkip = false,
            skipTimeOut = false,
            reloadTimes = 0,
            timeToSeek = 0,
            manualSeek = false,
            seekTimeOut, playTimeout, playAds = 0,
            maxAds = 1;
        var firstSource = [{
            file: "<?= URL ?>/assets/video/1s_blank.mp4",
            type: "mp4",
            label: "360p",
            default: true
        }];

        var link = "<?= $url ?>";
        var advertising = {
            client: 'vast',
            admessage: 'Quảng cáo còn XX giây.',
            skipoffset: 5,
            skiptext: 'Bỏ qua quảng cáo',
            skipmessage: 'Bỏ qua sau xxs',
            width: '100%',
            height: '100%',
            autostart: true,
            schedule: {
                preroll: {
                    offset: 'pre',
                    tag: arrPreroll,
                },
            }
        };
        var playerInstance = jwplayer('jwplayer');
        playerInstance.setup({
            key: "ITWMv7t88JGzI0xPwW8I0+LveiXX9SWbfdmt0ArUSyc=",
            width: '100%',
            height: '100%',
            sources: firstSource,
            startparam: 'start',
            primary: 'html5',
            preload: 'auto',
            autostart: true,
            captions: {
                color: '#f3f368',
                fontSize: 20,
                backgroundOpacity: 0,
                fontfamily: 'Helvetica',
                edgeStyle: 'raised'
            },
            advertising: advertising,
        });
        playerInstance.setVolume(50);
        var IframeMovie = jQuery("#jwplayer").html(`<iframe width="100%" height="100%" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" src="${link}" frameborder="0" allowfullscreen=""></iframe>`);
        playerInstance.on('play', function() {
            playerInstance.setCurrentCaptions(1);
            if (playAds <= maxAds) {
                playerInstance.remove();
                IframeMovie;
            } else {
                if (currentVolume > 0) {
                    playerInstance.setVolume(currentVolume);
                    currentVolume = 0
                }
            }
        }).on("adSkipped", function(event) {
            playerInstance.remove();
            IframeMovie;
        }).on("adComplete", function(event) {
            playerInstance.remove();
            IframeMovie;
        }).on('error', function(message) {
            playerInstance.remove();
            IframeMovie;
        }).on('complete', function() {
            playerInstance.remove();
            IframeMovie;
        });
    </script>
</body>

</html>