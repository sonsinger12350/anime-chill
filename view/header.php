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
        <div class="search-bar flex flex-1 margin-0-10 padding-10">
            <a class="logo" style="padding: 0px 15px;margin-top: auto;" href="/"><img src="<?= $cf['logo'] ?>" alt="logo animehay" /></a>
            <form onsubmit="handlingSearch();return false" class="flex" id="form-search" action="tim-kiem/">
                <input type="text" placeholder="Nhập từ khoá cần tìm..." class="padding-10 bg-black color-gray" style="width: 100%;height: 18px;" name="keyword">
                <button type="submit" class="flex h-38 flex-hozi-center bg-black color-gray">
                    <span class="material-icons-round">search</span>
                </button>
            </form>
            <?php if ($_author_cookie) { ?>
                <a href="javascript:void(0);" id="toggle-notification" onclick="toggleNotification(this);" load_notification="true" class="toggle-dropdown bg-black padding-0-10 h-38 episode_latest flex flex-hozi-center fw-700 load-notification relative" bind="drop-down-3">
                    <?php if (get_total('notice', "WHERE user_id = '{$user['id']}' AND view = 'false'") >= 1) { ?>
                        <span class="badge"><?= get_total('notice', "WHERE user_id = '{$user['id']}' AND view = 'false'") ?></span>
                    <?php } ?>
                    <span class="material-icons-round material-icons-menu">notifications</span>
                </a>
                <?php if (get_total('notice', "WHERE user_id = '{$user['id']}' AND view = 'false'") >= 1) { ?>
                    <script>
                        $('#toggle-notification').on('click', function() {
                            axios.post('/server/api', {
                                "action": "view_all_notice"
                            }).then(reponse => {
                                console.log(reponse);
                            }).catch(e => run_ax = true);
                        });
                    </script>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <!-- <div class="flex flex-hozi-center padding-10">
        <div class="logo">
            <a href="/"><img src="<?= $cf['logo'] ?>" alt="logo animehay" /></a>
        </div>
        <div id="drop-down-4" class="search-bar flex flex-1 margin-0-10 flex-ver-center">
            <form onsubmit="handlingSearch();return false" class="flex" id="form-search" action="tim-kiem/">
                <input type="text" placeholder="Nhập từ khoá..." class="padding-10 bg-black color-gray" name="keyword">
                <button type="submit" class="flex flex-hozi-center bg-black color-gray"><span class="material-icons-round">
                        search
                    </span></button>
            </form>
        </div>
        <div class="nav-items flex-wrap flex">
            <a href="#" onclick="clickEventDropDown(this,'search')" class="toggle-search toggle-dropdown" bind="drop-down-4">
                <span class="material-icons-round">
                    search
                </span>
            </a>
            <a href="#" onclick="clickEventDropDown(this,'reorder')" class="toggle-dropdown" bind="drop-down-1">
                <span class="material-icons-round">
                    reorder
                </span>
            </a>
           <a href="/lich-su"><span class="material-icons-round">
                    history
            </a>
            <a href="/theo-doi"><span class="material-icons-round">
                    bookmarks
                </span></a>
        </div>
    </div> -->

    <div>
        <div id="MenuHeader" class="w-100-percent flex-column">
            <div class="tab-links flex-1" style="width: 100%;height: 100%;">
                <a style="border: 1px solid #545454;" href="#" onclick="DropDown(this, 'category','Thể loại');" class="toggle-dropdown" bind="tab-cate">
                    <span class="material-icons-round material-icons-menu margin-0-5">
                        category
                    </span>
                    <div class="item-label">Thể loại</div>
                </a>
                <a style="border: 1px solid #545454;" href="#" onclick="DropDown(this, 'auto_awesome','Năm');" class="toggle-dropdown" bind="tab-years">
                    <span class="material-icons-round material-icons-menu margin-0-5">
                        auto_awesome
                    </span>
                    <div class="item-label">Năm</div>
                </a>
                <a style="border: 1px solid #545454;" href="/loc-phim/" class="item-tab-link"><span class="material-icons-round material-icons-menu margin-0-5">
                        filter_alt
                    </span>
                    <div class="item-label">Lọc Phim</div>
                </a>
                <a style="border: 1px solid #545454;" href="/theo-doi"><span class="material-icons-round material-icons-menu">
                        bookmarks
                    </span>
                    <div class="item-label">Lưu</div>
                </a>
                <a style="border: 1px solid #545454;" href="/lich-su" ><span class="material-icons-round material-icons-menu">
                        history
                    </span>
                    <div class="item-label">Lịch Sử</div>
                </a>
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
                            <img src="<?= getFrameAvatar($user['avatar_frame']) ?>" alt="" class="avatar-frame">
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