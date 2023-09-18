<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
FireWall();
?>
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
<div title="Về đầu trang" id="top-up">
    <span class="material-icons-round">
        north
    </span>
</div>
<div class="ah_content">
    <div id="bot-banner-pc">
        <zone id="kyl31w6h"></zone>
    </div>
    <div id="bot-banner-mb">
        <zone id="kyl31w6h"></zone>
    </div>
</div>
<div id="ad-floating-left">
    <zone id="kyl318cb"></zone>
</div>
<div id="ad-floating-right">
    <zone id="kyl31w6h"></zone>
</div>
<div id="popup" class="display-none">
    <zone id="ktimvs9i"></zone>
</div>
<div id="sponsor-balloon" class=""></div>
<script type="text/javascript">
    let item = 4;
    let documentWidth = $(document).width();
    (documentWidth < 768) ? item = 2: null;
    // (documentWidth > 768 && documentWidth < 1000) ? item = 4: null;
    $(document).ready(function() {
        var owl = $('.owl-carousel');
        owl.owlCarousel({
            items: item,
            lazyLoad: true,
            center: true,
            loop: true,
            responsiveClass: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            stagePadding: 50,
        });
        $('.play').on('click', function() {
            owl.trigger('play.owl.autoplay', [100])
        })
        $('.stop').on('click', function() {
            owl.trigger('stop.owl.autoplay')
        })
    });
    $repo_follow._get().map(function(item) {
        var elem_movie = document.getElementById(`movie-id-${item}`);
        if (elem_movie != null) {
            elem_movie.insertAdjacentHTML("beforeend", "<div class='movie-following'><span class='material-icons-round'>stars</span></div>");
        }
    })
</script>
<script type="text/javascript">
    async function updateClickAds(adv_id) {
        await securityCode();
        await axios
            .post("/server/api", {
                action: "update_click_ads",
                adv_id,
                token: $dt.token,
            })
            .then((rps) => {
                let data = rps.data;
                console.log(data);
            });
    }
    const ad_floating_left = document.getElementById("ad-floating-left");
    const ad_floating_right = document.getElementById("ad-floating-right");
    const top_banner_pc = document.getElementById("top-banner-pc");
    const bot_banner_pc = document.getElementById("bot-banner-pc");
    const top_banner_mb = document.getElementById("top-banner-mb");
    const bot_banner_mb = document.getElementById("bot-banner-mb");
    const sponsor_balloon = document.getElementById("sponsor-balloon");
    const position_floating = (document.body.clientWidth - document.getElementById("ah_wrapper").clientWidth) / 2 - 170;

    function createAds(info_ads = {}) {
        let elem = document.createElement("div");
        if (info_ads.position_name == "pop_under") {
            elem.addEventListener("click", function() {
                window.open(info_ads.href, '_blank');
                updateClickAds(info_ads.id);
                this.remove();
            })
        } else {
            let image = document.createElement("img");
            elem.classList.add("hello-you");
            image.src = info_ads.image;
            image.classList.add("w-100-percent");
            elem.appendChild(image);
            elem.addEventListener("click", function() {
                window.open(info_ads.href, '_blank');
                updateClickAds(info_ads.id);
            })
        }

        return elem;
    }

    function loadAds(info_ads = {}) {
        const name_position = info_ads.position_name || null;
        let ads;
        ads = createAds(info_ads);
        try {
            if (!isMB) {
                ad_floating_left.style = `position:fixed;top:50px;left:${position_floating}px;max-width:160px`;
                ad_floating_right.style = `position:fixed;top:50px;right:${position_floating}px;max-width:160px`;
                switch (name_position) {
                    case "floating_left":
                        // if (ad_floating_left == null) throw ("error setup floating_left");
                        ad_floating_left.innerHTML = null;
                        ad_floating_left.appendChild(ads);
                        break;
                    case "floating_right":
                        // if (ad_floating_right == null) throw ("error setup floating_right");
                        ad_floating_right.innerHTML = null;
                        ad_floating_right.appendChild(ads);
                        break;
                    case "top_banner_pc":
                        // if (top_banner_pc == null) throw ("error setup top_banner_pc");
                        //top_banner_pc.innerHTML = null;
                        //top_banner_pc.appendChild(ads);
                        $(top_banner_pc).css('text-align', 'center');
                        $(top_banner_pc).append(`<a onclick="updateClickAds(${info_ads.id});HideCatfish(this);" href="${info_ads.href}" target="_blank">
                                                    <img src="${info_ads.image}" width="980" height="90"></a>`);
                        break;
                    case "bot_banner_pc":
                        // if (bot_banner_pc == null) throw ("error setup bot_banner_pc");
                        //bot_banner_pc.innerHTML = null;
                        bot_banner_pc.appendChild(ads);
                        break;
                    case "banner_balloon_catfish":
                        // if (sponsor_balloon == null) throw ("error setup sponsor_balloon");
                        if (info_ads.num >= 1) {
                            var adsn = info_ads.num - 1;
                            var SizeAds = (adsn * 90);
                            var StyleAds = `style="bottom: ${SizeAds}px;"`;
                        }
                        $(sponsor_balloon).append(`<div onclick="HideCatfish(this);" class="ff-banner banner-balloon catfish" ${StyleAds}><a onclick="updateClickAds(${info_ads.id});" href="${info_ads.href}" target="_blank"><img src="${info_ads.image}" width="728" height="90"></a><div class="banner-close banner-balloon-close"><span class="material-icons-round icon-close" style="padding: 4px;">cancel</span></div></div>`);
                        break;
                    case "banner_player_watch":
                        $('#PlayerAds').append(`<a href="${info_ads.href}" onclick="updateClickAds(${info_ads.id});" target="_blank" style="display: block;">
                            <img src="${info_ads.image}" width="729" height="90">
                        </a>`);
                        break;
                    default:
                        break;
                }
                if (document.body.clientWidth > 1050) {
                    top_banner_pc.querySelector(".hello-you") == null && arfAsync.push("kyl30cr3"); // Top banner PC
                    ad_floating_left.querySelector(".hello-you") == null && arfAsync.push("kyl318cb"); // floating left
                    ad_floating_right.querySelector(".hello-you") == null && arfAsync.push("kyl31w6h"); // floating right
                    arfAsync.push("ktimvs9i"); // popup
                }
            } else {
                switch (name_position) {
                    case "top_banner_mb":
                        // if (top_banner_mb == null) throw ("error setup top_banner_mb");
                        //top_banner_mb.innerHTML = null;
                        top_banner_mb.appendChild(ads);
                        break;
                    case "bot_banner_mb":
                        // if (bot_banner_mb == null) throw ("error setup bot_banner_mb");
                        //bot_banner_mb.innerHTML = null;
                        bot_banner_mb.appendChild(ads);
                        break;
                    case "balloon_catfish_mb":
                        if (info_ads.num >= 1) {
                            var adsn = info_ads.num - 1;
                            var SizeAds = (adsn * 50);
                            var StyleAds = `style="bottom: ${SizeAds}px;"`;
                        }
                        $(sponsor_balloon).append(`<div onclick="HideCatfish(this);" class="ff-banner banner-catfish" ${StyleAds}>
                                                    <a onclick="updateClickAds(${info_ads.id});HideCatfish(this);" href="${info_ads.href}" target="_blank"><img src="${info_ads.image}" width="320" height="50"></a>
                                                    <div class="banner-close banner-catfish-close"><span class="material-icons-round icon-close" style="padding: 4px;">cancel</span></div>
                                                </div>`);
                        break;
                    case "banner_player_watch_mb":
                        $('#PlayerAds').append(`<a href="${info_ads.href}" onclick="updateClickAds(${info_ads.id});" target="_blank" style="display: block;">
                            <img src="${info_ads.image}" width="320" height="50">
                        </a>`);
                        break;
                    default:
                        break;
                }
                top_banner_mb.querySelector(".hello-you") == null && arfAsync.push("kyl3axj2"); // Top banner MB
            }
            if (name_position == "pop_under") {
                if (!$cookie.getItem("pop_under_delay")) {
                    ads.style = "position: fixed;top: 0;width: 100%;height: 100%;z-index: 30";
                    document.body.appendChild(ads);
                } else {
                    $cookie.setItem("pop_under_delay", "1", 1800)
                }
            }
        } catch (error) {
            console.log(error)
        }
    }
    initAds();
    async function initAds() {
        await securityCode();
        await axios
            .post("/server/api", {
                action: "init_ads",
                token: $dt.token,
            })
            .then((rps) => {
                let result = rps.data.data;
                console.log(result);
                if (Array.isArray(result)) {
                    result.forEach(item => {
                        loadAds(item)
                    });
                } else {
                    loadAds({})
                }
            });
    }
    // if (!$user.is_vip) {
    //     initAds();
    // }

    function HideCatfish(element) {
        $(element).hide();
    }

    function Gotopage(NPage, Location) {
        let PageGoto = $(`#PageGotoNum`).val();
        if (PageGoto > NPage) {
            alert(`Danh sách phim này giới hạn ${NPage}`);
            return;
        }
        location.href = `${Location}${PageGoto}`;
    }

    function showPopUpBanner() {
        $('.popUpBannerBox').fadeIn("2000");
    }
    setTimeout(showPopUpBanner, 1000); //thời gian popup bắt đầu hiển thị

    $('.popUpBannerBox').click(function(e) {
        if (!$(e.target).is('.popUpBannerContent, .popUpBannerContent *')) {
            $('.popUpBannerBox').fadeOut("2000");
            return false;
        }
    });
    $('.closeButton').click(function() {
        $('.popUpBannerBox').fadeOut("2000");
        return false;
    });
</script>
<script src="<?= URL ?>/themes/styles/carousel/owl.carousel.min.js"></script>
<div id="ah_toast"></div>
<div class="ah_footer">
    <div class="flex-space-auto">
        <div class="ah_cate_footer">
            <?php
            foreach (json_decode($cf['key_seo'], true) as $key => $value) {
                if ($value['url']) {
                    echo '<a class="ah_key_seo" href="' . $value['url'] . '" title="' . $value['name'] . '">' . $value['name'] . '</a>';
                }
            }
            ?>
        </div>
        <div class="logo-footer">
            <img src="<?= $cf['logo'] ?>" />
        </div>
        <div class="footer-links">
            <ul class="ulclear">
                <li>
                    <a href="/terms" title="Terms of service">Điều khoản và dịch vụ</a>
                </li>
                <li>
                    <a href="/contact" title="Contact">Liên hệ</a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="about-text">
            <?= $cf['description'] ?>
        </div>
    </div>
</div>
<?= un_htmlchars($cf['script_footer']) ?>