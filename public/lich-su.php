<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
FireWall();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <?php
    $title = "Lịch Sử Xem Của Bạn - {$cf['title']}";
    $description =  "Lịch Sử Xem Của Bạn - {$cf['title']}";
    require_once(ROOT_DIR . '/view/head.php');
    ?>
</head>

<body class="scroll-bar">
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        <?php require_once(ROOT_DIR . '/view/header.php'); ?>
        <div class="ah_content">
            <?php require_once(ROOT_DIR . '/view/top-note.php'); ?>
            <div class="history">
                <div class="margin-10-0 bg-brown flex flex-space-auto">
                    <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                        <h3 class="section-title"><span>Lịch Sử Xem</span></h3>
                    </div>
                </div>
                <div class="display_axios">
                    <div class="ah_loading">
                        <div class="lds-ellipsis">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                const _0x3047 = ['getItem', 'post', '/server/api', 'getElementsByClassName', 'addEventListener', 'stringify', 'data_history', 'display_axios', 'log', 'innerHTML', 'parse', 'data'];
                (function(_0x150929, _0x209022) {
                    const _0x304767 = function(_0x4e0512) {
                        while (--_0x4e0512) {
                            _0x150929['push'](_0x150929['shift']());
                        }
                    };
                    _0x304767(++_0x209022);
                }(_0x3047, 0x7b));
                const _0x4e05 = function(_0x150929, _0x209022) {
                    _0x150929 = _0x150929 - 0x1c2;
                    let _0x304767 = _0x3047[_0x150929];
                    return _0x304767;
                };
                (() => {
                    const _0x80f4a7 = _0x4e05;
                    document[_0x80f4a7(0x1c3)]('DOMContentLoaded', function(_0xa7e55) {
                        const _0x560c85 = async () => {
                            const _0xa4745d = _0x4e05;
                            try {
                                let _0x142d51 = document[_0xa4745d(0x1c2)](_0xa4745d(0x1c6))[0x0],
                                    _0x45dda4 = await loadHistorymovie(),
                                    _0x2f4f4f = _0x45dda4[_0xa4745d(0x1ca)];
                                _0x142d51[_0xa4745d(0x1c8)] = _0x2f4f4f;
                            } catch (_0x122e7c) {
                                console[_0xa4745d(0x1c7)](_0x122e7c);
                            }
                        };
                        _0x560c85();
                    }), loadHistorymovie = () => {
                        const _0xbb09c4 = _0x80f4a7,
                            _0x1ec641 = localStorage[_0xbb09c4(0x1cb)]('data_history'),
                            _0x4a6ccd = _0x1ec641 ? JSON[_0xbb09c4(0x1c9)](_0x1ec641) : [];
                        return axios[_0xbb09c4(0x1cc)](_0xbb09c4(0x1cd), {
                            'action': _0xbb09c4(0x1c5),
                            'data_history': JSON[_0xbb09c4(0x1c4)](_0x4a6ccd)
                        });
                    };
                })();
            </script>

        </div>
        <?= PopUnder('pop_under_home') ?>
        <?php require_once(ROOT_DIR . '/view/footer.php'); ?>
    </div>
</body>

</html>