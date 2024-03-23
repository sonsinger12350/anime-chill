<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
FireWall();
?>
<style>
    .material-icons-menu {
        display: grid;
        font-size: 20px;
        text-align: center;
    }

    .fa-search {
        top: 9px;
        font-size: 20px;
        color: #666;
        right: 0;
    }

    #drop-down-2 .row-1 .avatar {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: visible;
        width: 85px;
        height: 85px;
    }

    #drop-down-2 .row-1 .avatar img:not(.avatar-frame) {
        width: 75px;
        height: auto;
        border-radius: 50%;
    }

    #drop-down-2 .row-1 .avatar .avatar-frame {
        position: absolute;
        width: 90px;
        height: auto;
        top: -5px;
        left: -3px;
    }
</style>
<div id="navbar">
    <div style="background: #000;">
        <!-- <div class="logo" style="float: left;">
            <a href="/"><img src="<?= $cf['logo'] ?>" alt="logo animehay" /></a>
        </div> -->
        
    <div>
        <div id="MenuHeader" class="w-100-percent flex-column">
            <div class="tab-links flex-1" style="width: 100%;height: 100%;">
                <a style="border: 1px solid #545454;" href="https://ktruyen.online"><span class="material-icons-round material-icons-menu">
                        book
                    </span>
                    <div class="item-label">Truyện Tranh</div>
                </a>
                <a style="border: 1px solid #545454;" href="/tin-moi.html"><span class="material-icons-round material-icons-menu">
                        grade
                    </span>
                    <div class="item-label">Tin Tức</div>
                </a>
                <a style="border: 1px solid #545454;" href="/lich-chieu-phim.html"><span class="material-icons-round material-icons-menu">
                        calendar_today
                    </span>
                    <div class="item-label">Lịch Chiếu</div>
                </a>
                <a style="border: 1px solid #545454;" href="/tai-khoan/nap-xu"><span class="material-icons-round material-icons-menu margin-0-5">
                        monetization_on
                    </span>
                    <div class="item-label">Nạp Xu</div>
                </a>
                <a style="border: 1px solid #545454;" href="/tai-khoan/cua-hang"><span class="material-icons-round material-icons-menu">
                        shopping_cart
                    </span>
                    <div class="item-label">Cửa Hàng</div>
                </a>
                <a style="border: 1px solid #545454;" href="/huong-dan" ><span class="material-icons-round material-icons-menu">
                        library_books
                    </span>
                    <div class="item-label">Hướng Dẫn</div>
                </a>
                <!--
                <?php if (!$_author_cookie) { ?>
                    <a href="/login" class="item-tab-link" style="border: 1px solid #545454;"><span class="material-icons-round material-icons-menu margin-0-5" >login</span>
                        <div class="item-label">Đăng Nhập</div>
                    </a>
                <?php } else { ?>
                    <a style="border: 1px solid #545454;" href="#" onclick="clickEventDropDown(this,'account_circle','Hồ Sơ');" class="toggle-dropdown" bind="drop-down-2">
                        <span class="material-icons-round material-icons-menu">account_circle</span>
                        <div class="item-label">Hồ Sơ</div>
                    </a>
                <?php } ?>
                -->
            </div>
            <div class="tab-content">
                <div id="tab-cate" class="item-tab-content">
                    <div class="flex flex-wrap">
                        <?php
                        $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "category ORDER BY id DESC");
                        while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <a href="/the-loai/<?= $row['slug'] ?>.html" title="Thể loại <?= $row['name'] ?>"><?= $row['name'] ?></a>
                        <?php } ?>
                        <a href="/loc-phim/<?= base64_encode("[[],[],[1],[]]") ?>" title="Phim Lẻ">Phim Lẻ</a>
                        <a href="/loc-phim/<?= base64_encode("[[],[],[2],[]]") ?>" title="Phim Bộ">Phim Bộ</a>
                    </div>
                </div>
                <div id="tab-years" class="item-tab-content">
                    <div class="flex flex-wrap">
                        <?php
                        $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "year ORDER BY id DESC");
                        while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <a href="/loc-phim/<?= base64_encode("[[],[{$row['year']}],[],[]]") ?>"><?= $row['year'] ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php if ($_author_cookie) { ?>
                <div id="drop-down-2" class="dropdown-menu bg-black flex-column">
                    <div class="row-1 flex flex-column flex-hozi-center">
                        <div class="avatar">
                            <img src="<?= $user['avatar'] ?>" />
                            <img src="<?= $user['frame'] ?>" alt="" class="avatar-frame">
                        </div>
                        <div class="nickname fs-17 fw-700 margin-t-10 color-yellow"><?= $user['nickname'] ?></div>
                    </div>
                    <!-- <a href="/tai-khoan/dong-bo" class="flex flex-hozi-center"><span class="material-icons-round margin-0-5">
                            sync
                        </span> Đồng bộ</a> -->
                    <a href="/tai-khoan/ho-so" class="flex flex-hozi-center"><span class="material-icons-round margin-0-5">
                            account_box
                        </span> Thông tin</a>
                    <a href="/thay-doi-mat-khau" class="flex flex-hozi-center"><span class="material-icons-round margin-0-5">
                            password
                        </span>Thay đổi mật khẩu</a>
                    <a href="/dang-xuat" onclick="localStorage.removeItem('async_follow')" class="flex flex-hozi-center"><span class="material-icons-round margin-0-5">
                            logout
                        </span>Đăng xuất</a>
                </div>
                <div id="drop-down-3" class="dropdown-menu bg-black flex-column">
                    <div class="fw-500 margin-10 flex flex-hozi-center">
                        <div class="flex-1 fs-19">Thông Báo</div>
                        <div>
                            <a href="/thong-bao">Xem tất cả</a>
                        </div>
                    </div>
                    <div id="list-item-notification" class="scroll-bar"></div>
                </div>
            <?php } ?>

        </div>
    </div>
</div>
<script>
    var live_search = new liveSearch;
    live_search.action();
    var isLoadNoti = false;

    function DropDown(this_dropdown, icon_default = "Null", NameLabel = "Thông Báo") {
        if ($(this_dropdown).hasClass("active")) {
            var panel = $(this_dropdown).attr('bind');
            setTimeout(function() {
                $('.tab-links a.active').removeClass('active');
                $(`#${panel}`).removeClass("display-block");
            }, 50);
            return;
        }
        $(this_dropdown).addClass('active');
        var panel = $(this_dropdown).attr('bind');
        $(panel).fadeIn(this_dropdown);
        return false;
    }

    function clickEventDropDown(this_dropdown, icon_default = "Null", NameLabel = "") {
        var _name = this_dropdown.getAttribute("bind");
        var _dropdown_menu = document.getElementById(_name);
        if (!_dropdown_menu.style.display || _dropdown_menu.style.display === "none") {
            this_dropdown.innerHTML = `<span class="material-icons-round material-icons-menu">highlight_off</span>`;
            if (icon_default !== "expand_more") {
                this_dropdown.style.backgroundColor = "#ab3e3e";
            }
            _dropdown_menu.style.display = "flex";
            setTimeout(function() {
                _dropdown_menu.style.transform = "scale(1)";
            }, 50)
        } else {
            _dropdown_menu.style = null;
            this_dropdown.style = null;
            setTimeout(function() {
                $(`#${_name}`).removeClass("display-block");
                $(this_dropdown).removeClass("active");
            }, 50);
            this_dropdown.innerHTML = `<span class="material-icons-round material-icons-menu">${icon_default}</span><div class="item-label">${NameLabel}</div>`;
        }
    }
</script>