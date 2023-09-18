<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_author_cookie) die(header("location:/login"));
if (!$_SESSION['viewer']) {
    $mysql->update("config", "view = view + 1", "id = 1");
    $_SESSION['viewer'] = "True";
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <?php
    require_once(ROOT_DIR . '/view/head.php');
    ?>
</head>

<body class="scroll-bar">
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        <?php require_once(ROOT_DIR . '/view/header.php'); ?>
        <div class="ah_content">
            <?php require_once(ROOT_DIR . '/view/top-note.php'); ?>

            <div class="flex flex-ver-center">
                <div class="history flex-column inline-flex flex-ver-center" style="flex:0.5">
                    <div class="margin-10-0 bg-gray-2">
                        <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                            <h3 class="section-title"><span>Thông Báo Của Tôi</span></h3>
                        </div>
                    </div>
                    <div id="list-item" class="ah-frame-bg bg-black">
                    </div>
                    <div id="active_show"></div>
                </div>
            </div>
            <script type="text/javascript">
                var loaded_noti = true;
                (function() {
                    Observer("active_show", async function() {
                        if (loaded_noti) {
                            let id_load_more = document.getElementById("list-item").lastElementChild;
                            id_load_more = id_load_more ? parseInt(id_load_more.attributes[1].value) || 0 : 0;
                            console.log(id_load_more);
                            loaded_noti = await loadNotification("list-item", id_load_more, loaded_noti);
                            //if (loaded_noti.status == "failed") 
                            loaded_noti = false;
                        }
                    }, false)
                }())
            </script>
        </div>


        <?php require_once(ROOT_DIR . '/view/footer.php'); ?>
    </div>
</body>

</html>