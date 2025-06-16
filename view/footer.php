<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
FireWall();

$adBlockContent = [
    'ab' => [
        'title' => 'AdBlock',
        'content' => '
            <p>1. Trong phần tiện ích mở rộng của trình duyệt ở góc trên bên phải màn hình, nhấp vào biểu tượng AdBlock <img src="assets\adblock-image\ab_icon.svg">. (Bạn có thể thấy một số nhỏ che một phần biểu tượng.)</p>
            <p>2. Chọn <b>không chạy trên các trang trên trang web này</b>.</p>
            <p>3. Trong hộp thoại Không chạy AdBlock trên các trang web sau, chọn <b>Loại trừ</b>. Biểu tượng AdBlock sau đó sẽ đổi thành hình ảnh "ngón tay cái hướng lên".</p>
        '
    ],
    'abp' => [
        'title' => 'AdBlock Plus',
        'content' => '
            <p>1. Trong phần tiện ích mở rộng của trình duyệt ở góc trên bên phải màn hình, nhấp vào biểu tượng Adblock Plus <img src="assets\adblock-image\abp_icon.svg">. (Bạn có thể thấy một số nhỏ che một phần biểu tượng.)</p>
            <p>2. Nhấp vào biểu tượng Nguồn <img src="assets\adblock-image\abp_power_icon.svg"> và trượt sang trái.</p>
            <p>3. Nhấp vào nút <b>Làm mới</b>.</p>
        '
    ],
    'uo' => [
        'title' => 'uBlock Origin',
        'content' => '
            <p>1. Trong phần tiện ích mở rộng của trình duyệt ở góc trên bên phải màn hình, nhấp vào biểu tượng uBlock Origin <img src="assets\adblock-image\uo_icon.svg">. (Bạn có thể thấy một số nhỏ che một phần biểu tượng.)</p>
            <p>2. Nhấp vào nút Nguồn <img src="assets\adblock-image\uo_power_icon.svg">. Sau đó, nút này sẽ chuyển sang màu xám, nghĩa là quảng cáo không còn bị chặn trên trang web đó nữa.</p>
            <p>3. Nhấp vào nút Làm mới <img src="assets\adblock-image\uo_refresh_icon.svg"></p>
        '
    ],
    'other' => [
        'title' => 'Khác',
        'content' => '
            <p>1. Nhấp vào biểu tượng tiện ích mở rộng chặn quảng cáo được cài đặt trên trình duyệt của bạn.Bạn thường có thể tìm thấy biểu tượng này ở góc trên bên phải của màn hình. Có thể bạn đã cài đặt nhiều hơn 1 trình chặn quảng cáo.</p>
            <p>2. Làm theo hướng dẫn để tắt trình chặn quảng cáo trên trang web bạn muốn xem.Bạn có thể phải chọn một tùy chọn menu hoặc nhấp vào một nút.</p>
            <p>3. Làm theo lời nhắc hoặc nhấp vào nút Làm mới/Tải lại trên trình duyệt của bạn để làm mới trang.</p>
        '
    ]
];
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

<!-- Proccess For Show Ads -->
<script>
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
    $(document).ready(function() {
        var vip = $(".vip_user[data-vip]");
        if (vip.data('vip') != 1) {
            const ad_floating_left = document.getElementById("ad-floating-left");
            const ad_floating_right = document.getElementById("ad-floating-right");
            const top_banner_pc = document.getElementById("top-banner-pc");
            const bot_banner_pc = document.getElementById("bot-banner-pc");
            const top_banner_mb = document.getElementById("top-banner-mb");
            const bot_banner_mb = document.getElementById("bot-banner-mb");
            const sponsor_balloon = document.getElementById("sponsor-balloon");
            const position_floating = (document.body.clientWidth - document.getElementById("ah_wrapper").clientWidth) / 2 - 170;

            function createAds(info_ads = {}) {
                if (!jQuery.isEmptyObject(info_ads)) {
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

                        if (Array.isArray(result)) {
                            result.forEach(item => {
                                loadAds(item)
                            });
                        } else {
                            loadAds({})
                        }
                    });
            }

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
        }
        // Update Delete Banner Ads 
        $('body').on('click', '.ff-banner .icon-close', function() {
            $(this).closest('.ff-banner').empty();
        });
    });
</script>

<!-- // bk_Js Show Ads  -->
<!-- <script type="text/javascript">
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
</script> -->
<!--[End] Proccess For Show Ads -->
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
<?php
if (!empty($user['vip'])) {
    if ($user['vip'] <> 1) {
        echo un_htmlchars($cf['script_footer']);
    }
} else {
    echo un_htmlchars($cf['script_footer']);
}
?>

<style>
    #detect-adblock-modal, #introduction-modal {
        left: 50%;
        transform: translateX(-50%);
        padding: 24px;
    }

    #detect-adblock-modal .modal-dialog {
        padding: 0px;
    }

    #detect-adblock-modal .modal-body {
        text-align: center;
    }

    #detect-adblock-modal .modal-body .close-btn, 
    #introduction-modal .modal-body .close-btn {
        margin-left: auto;
        border-radius: 50%;
        height: 20px;
        width: 20px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    #detect-adblock-modal .modal-body .logo-web {
        width: 60%;
        margin-bottom: 16px;
        margin-top: 8px;
    }

    #detect-adblock-modal .modal-body h4 {
        margin-bottom: 16px;
        font-size: 18px;
    }

    #detect-adblock-modal .modal-body p {
        font-size: 13px;
        margin-bottom: 16px;
        font-weight: 500;
    }

    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1050;
        width: 100vw;
        height: 100vh;
        background-color: #000;
        opacity: 0;
        transition: opacity .15s linear;
    }

    .modal-backdrop:not(.show) {
        z-index: -1;
    }

    .modal-backdrop.show {
        opacity: 0.5;
    }

    #introduction-modal .nav-tabs {
        display: flex;
        flex-wrap: wrap;
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
        border-bottom: 1px solid #dee2e6;
    }

    #introduction-modal .nav-tabs .nav-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        padding: .5rem 1rem 0 1rem;
        color: #e9e9e9;
        text-decoration: none;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out;
        margin-bottom: -1px;
        background: 0 0;
        border: 1px solid transparent;
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
        font-size: 14px;
        font-weight: 400;
    }

    #introduction-modal .nav-tabs .nav-link span {
        border-radius: 10px 10px 0 0;
        height: 4px;
        width: 100%;
    }

    #introduction-modal .nav-tabs .nav-link.active {
        color: #0d6efd;
    }

    #introduction-modal .nav-tabs .nav-link.active span {
        background-color: #1a73e8;
    }

    #introduction-modal .nav-tabs .nav-link .icon {
        width: 40px;
        height: 40px;
        object-fit: cover;
    }

    #introduction-modal .nav-tabs .nav-link i.icon {
        background-color: #f1f3f4;
        border-radius: 50%;
        color: #5f6368;
        display: inline-block;
        font-size: 35px;
        height: 40px;
        line-height: 20px;
        margin-bottom: 2px;
        width: 40px;
    }

    #introduction-modal .tab-content {
        margin-top: 16px;
    }

    #introduction-modal .tab-content .content {
        display: none;
        max-height: 300px;
        overflow: auto;
        padding-top: 24px;
    }

    #introduction-modal .tab-content .content.active {
        display: block;
    }

    #introduction-modal .tab-content .content .content-image {
        width: 400px;
        height: 92px;
        object-fit: cover;
    }

    #introduction-modal .tab-content .content .introdution {
        padding: 16px;
    }

    #introduction-modal .tab-content .content .introdution p {
        color: #e9e9e9;
        font-size: 16px;
        font-weight: 500;
        text-align: left;
        margin-bottom: 8px;
    }

    #introduction-modal .tab-content .content .introdution p img {
        width: 20px;
        height: 20px;
        object-fit: cover;
    }

    @media (max-width: 576px) {
        #detect-adblock-modal,
        #introduction-modal {
            max-width: 90%;
            width: 90%;
        }

        #introduction-modal .nav-tabs .nav-item {
            flex: 1;
        }

        #introduction-modal .tab-content .content .content-image {
            width: 95%;
            height: auto;
        }
    }
</style>
<div class="modal fade" id="detect-adblock-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close close-btn" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <img src="<?= $cf['logo'] ?>" alt="logo-web" class="logo-web">
                <h4>Có vẻ bạn đang sử dụng trình chặn quảng cáo</h4>
                <p>Website chúng mình duy trì nhờ kinh phí kiếm được từ quảng cáo, bạn vui lòng tắt trình chặn quảng cáo để tiếp tục xem phim</p>
                <button class="btn btn-primary btn-grad show-introduction">Bỏ chặn quảng cáo</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="introduction-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close close-btn" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="nav nav-tabs">
                    <?php foreach ($adBlockContent as $k => $v): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $k == 'ab' ? 'active' : '' ?>" href="javascript:void(0)" data-tab="<?= $k ?>">
                                <?php if ($k == 'other'): ?>
                                    <i class="icon">...</i>
                                <?php else: ?>
                                    <img src="assets\adblock-image\<?= $k ?>_icon.svg" alt="<?= $k ?>_icon" class="icon">
                                <?php endif; ?>

                                <?= $v['title'] ?>
                                <span></span>
                            </a>
                        </li>
                    <?php endforeach ?>
                </ul>
                <div class="tab-content">
                    <?php foreach ($adBlockContent as $k => $v): ?>
                        <div class="content <?= $k ?> <?= $k == 'ab' ? 'active' : '' ?>">
                            <?php if ($k != 'other'): ?>
                                <img src="assets\adblock-image\browser_<?= $k ?>.png" alt="content-<?= $k ?>" class="content-image">
                            <?php endif ?>
                            <div class="introdution">
                                <?= $v['content'] ?>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade"></div>

<script>
    function detectAdBlock(callback) {
        let isBlocked = false;

        // image
        let testAd = new Image();
        testAd.src = "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiKkDFLTzotsxETDVY96azVntGpvjnF3wo7caXJscnvFsjQnKoOx0G0daw91AZ-qba-sm8lzB1wGIugf8nxL57loDEwQvWCoyusdPazPj0fTzfN-jsO4ecmDGP8cTjxFeqxAXEwmqhDDvGCbWTidvCBNmpvxSv6xSIfOaLkmyr-tGgn1euk9SoeabfEZGQ/s0/a728x90.gif";
        testAd.style.position = "absolute";
        testAd.style.left = "-9999px";
        
        testAd.onerror = function () {
            isBlocked = true;
        };

        document.body.appendChild(testAd);

        // bait element
        let $bait = $('<div class="ad ads banner-ad"></div>')
            .css({ height: '1px', width: '1px', position: 'absolute', left: '-9999px' })
            .appendTo('body');

        // script
        let scriptBlocked = false;
        let script = document.createElement('script');
        script.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';
        script.onerror = function() { scriptBlocked = true; };
        document.head.appendChild(script);

        setTimeout(function() {
            let isBaitHidden = $bait.is(':hidden') || $bait.height() === 0;

            if (isBlocked || isBaitHidden || scriptBlocked) callback(true);
            else callback(false);

            testAd.remove();
            $bait.remove();
        }, 1000);
    }

    function showModal(action, modal) {
        if (action == 'show') {
            modal.show();
            $(".modal-backdrop").addClass('show');
        }
        else {
            modal.hide();
            $(".modal-backdrop").removeClass('show');
        }
    }

    $(document).ready(function () {
        detectAdBlock(function(isEnabled) {
            if (isEnabled) showModal('show', $("#detect-adblock-modal"));
        });

        $('body').on('click', '.modal .close', function() {
            showModal('hide', $(this).closest('.modal'));
        });

        $('body').on('click', '#detect-adblock-modal .show-introduction', function() {
            showModal('hide', $("#detect-adblock-modal"));
            showModal('show', $("#introduction-modal"));
        });

        $('body').on('click', '#introduction-modal .nav-link', function() {
            let tab = $(this).attr('data-tab');

            $('#introduction-modal .nav-link').removeClass('active');
            $(this).addClass('active');
            $('.tab-content .content').removeClass('active');
            $(`.tab-content .content.${tab}`).addClass('active');
        });
    });

</script>