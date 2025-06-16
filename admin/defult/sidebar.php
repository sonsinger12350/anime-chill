<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper"><a href="<?= URL ?>/admin_movie"><img class="img-fluid for-light" src="<?= $cf['logo'] ?>" alt=""><img class="img-fluid for-dark" src="<?= URL ?>/admin/assets/images/logo/small-white-logo.png" alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="<?= URL ?>/admin_movie"><img class="img-fluid" src="<?= $cf['logo'] ?>" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="<?= URL ?>/admin_movie"><img class="img-fluid" src="<?= $cf['logo'] ?>" alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"> </i></div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="<?= URL ?>/admin_movie/add-movie">
                            <i class="fa fa-smile-o fw-bold fs-6 text-primary"></i>
                            <span>Thêm Phim Mới</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="<?= URL ?>/admin_movie/add-news">
                            <i class="fa fa-smile-o fw-bold fs-6 text-primary"></i>
                            <span>Thêm Tin Mới</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="<?= URL ?>/admin_movie/movie">
                            <i class="fa fa-smile-o fw-bold fs-6 text-primary"></i>
                            <span>Danh Sách Phim</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="<?= URL ?>/admin_movie/news">
                            <i class="fa fa-smile-o fw-bold fs-6 text-primary"></i>
                            <span>Danh Sách News</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="<?= URL ?>/admin_movie/change-password">
                            <i class="fa fa-smile-o fw-bold fs-6 text-primary"></i>
                            <span>Đổi Mật Khẩu</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="<?= URL ?>/admin_movie/category">
                            <i class="fa fa-smile-o fw-bold fs-6 text-primary"></i>
                            <span>Thể Loại</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="<?= URL ?>/admin_movie/year">
                            <i class="fa fa-smile-o fw-bold fs-6 text-primary"></i>
                            <span>Năm Sản Xuất Phim</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="<?= URL ?>/admin_movie/server">
                            <i class="fa fa-smile-o fw-bold fs-6 text-primary"></i>
                            <span>Server Phim</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="<?= URL ?>/admin_movie/admin">
                            <i class="fa fa-smile-o fw-bold fs-6 text-primary"></i>
                            <span>Quản Lý Admin</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i class="fa fa-smile-o fw-bold fs-6 text-primary"></i><span> User Menu</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: none;">
                            <li><a href="/admin_movie/cua_hang_vat_pham/non.html">Quản lý cửa hàng vật phẩm</a></li>
                            <!-- <li><a href="/admin_movie/khung_vien">Quản lý khung viền</a></li> -->
                            <li><a href="/admin_movie/danh_hieu">Thêm Danh Hiệu & Màu Level</a></li>
                            <li><a href="/admin_movie/author/icon">Icon User</a></li>
                            <li><a href="/admin_movie/author">Danh Sách Thành Viên</a></li>
                            <li><a href="/admin_movie/comments">Quản Lý Bình Luận</a></li>
                            <li><a href="/admin_movie/notice">Quản Lý Thông Báo</a></li>
                            <li><a href="/admin_movie/general_info">Cài đặt Thông Tin Chung</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <?php
                            $countCard = get_total('the_nap', "WHERE seen = 0");
                            if ($countCard > 0) $countCard = '<span class="text-danger">(' . $countCard . ')</span>';
                            else $countCard = '';
                        ?>
                        <a class="sidebar-link sidebar-title link-nav" href="<?= URL ?>/admin_movie/the_nap">
                            <i class="fa fa-smile-o fw-bold fs-6 text-primary"></i>
                            <span>Quản Lý Thẻ Nạp <?= $countCard ?></span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="<?= URL ?>/admin_movie/report">
                            <i class="fa fa-smile-o fw-bold fs-6 text-primary"></i>
                            <span>Quản Lý Báo Lỗi</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="<?= URL ?>/admin_movie/lien_he">
                            <i class="fa fa-smile-o fw-bold fs-6 text-primary"></i>
                            <span>Quản Lý Liên Hệ</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="<?= URL ?>/admin_movie/cai_dat">
                            <i class="fa fa-smile-o fw-bold fs-6 text-primary"></i>
                            <span>Cài Đặt</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="<?= URL ?>/admin_movie/ads">
                            <i class="fa fa-smile-o fw-bold fs-6 text-primary"></i>
                            <span>Cài Đặt Quảng Cáo</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="<?= URL ?>/admin_movie/file-manager">
                            <i class="fa fa-smile-o fw-bold fs-6 text-primary"></i>
                            <span>Quản Lý Tệp Tin</span>
                        </a>
                    </li>
                </ul>

            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>