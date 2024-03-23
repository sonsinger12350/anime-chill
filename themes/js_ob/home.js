var onload_boxchat;
var BoxChatLoad = function () {
    console.log(`Onload => ${$config.boxchat_load}`);
    $(`button[name="boxchat"]`).addClass('btn-active');
    if ($config.boxchat_load == true) {
        LoadHome('Load_Comment_Home');
        onload_boxchat = setInterval(function () {
            LoadHome('Load_Comment_Home');
            $('.chat_div').animate({
                scrollTop: 99999
            }, 0);
        }, 5000);
    } else {
        LoadHome('Load_Comment_Home');
    }
}
var LoadHome = async (action) => {
    if (action == 'LoadComment') {
        BoxChatLoad();
        return;
    }
    if (action == 'top_bxh') {
        $('#BangXepHangProfile').show();
    } else {
        $('#BangXepHangProfile').hide();
    }
    axios.post('/server/api', {
        "action": action,
    }).then(reponse => {
        var res = reponse.data;

        if (res.status != 'success') {
            $('#HomeChatList').html(res.result);
            return;
        }
        if (action == 'Load_Comment_Home') {
            $('#HomeChatList').html(res.result);
        } else {
            $('#HomeListTop').html(res.result);
        }
        
        if (action == 'Load_Comment_Home') {
            $('.chat_div').animate({
                scrollTop: 99999
            }, 0);
            $("#HomeChatList").animate({ scrollTop: $('#HomeChatList').prop("scrollHeight")}, 1000);
        } else if (action == 'top_bxh') {
            clearInterval(onload_boxchat);
            $('#BangXepHangProfile').show();
            $('.chat_div').animate({
                // scrollTop: 0
            }, 0);
        } else {
            clearInterval(onload_boxchat);
        }

    }).catch(e => run_ax = true);
}

function LoadLichChieu(days) {
    let DivLichChieu = $('#LichChieuPhim');
    let Tab = $(`#thu-${days}`);
    if (Tab.hasClass("active")) {
        return;
    }
    $('.lichchieu').removeClass('active');
    Tab.addClass('active');
    let setting = {
        type: "POST",
        url: "/server/lich-chieu",
        data: {
            days: days
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        beforeSend: function () {
            DivLichChieu.html(`<div class="flex flex-space-auto" style="position: relative;width: 100%;">
                                <img src="/themes/img/4M4x.gif" width="150" height="150">
                                <h2 style="bottom: 1px;position:absolute;">Đang Load Lịch Chiếu Xin Chờ ....</h2>
                            </div>`);
        },
        success: function (res) {
            DivLichChieu.html(res.message);
        },
        error: function (error) {
            DivLichChieu.html(`<div class="flex flex-space-auto" style="position: relative;width: 100%;">
                                <img src="/themes/img/05de031e8bcc956934a89d5aa25901b0.gif" width="150" height="150">
                                <h2 style="bottom: 1px;position:absolute;">Load Lịch Chiếu Không Thành Công</h2>
                            </div>`);
        }
    };
    $.ajax(setting);
}
var CommentHome = async () => {
    let CommentText = $('textarea[name="HomeComment"]').val();
    let CMT_Button = $('button[name="CommentButton"]');
    if (!$user.id) {
        Toast({
            message: "Bạn Chưa Đăng Nhập Vui Lòng Đăng Nhập Để Tiếp Tục",
            type: "error"
        });
        return;
    }
    if (!CommentText) {
        Toast({
            message: "Bạn Chưa Nhập Nội Dung Comment",
            type: "error"
        });
        return;
    }
    var Spam = 20;
    const rex = /[\u{1f300}-\u{1f5ff}\u{1f900}-\u{1f9ff}\u{1f600}-\u{1f64f}\u{1f680}-\u{1f6ff}\u{2600}-\u{26ff}\u{2700}-\u{27bf}\u{1f1e6}-\u{1f1ff}\u{1f191}-\u{1f251}\u{1f004}\u{1f0cf}\u{1f170}-\u{1f171}\u{1f17e}-\u{1f17f}\u{1f18e}\u{3030}\u{2b50}\u{2b55}\u{2934}-\u{2935}\u{2b05}-\u{2b07}\u{2b1b}-\u{2b1c}\u{3297}\u{3299}\u{303d}\u{00a9}\u{00ae}\u{2122}\u{23f3}\u{24c2}\u{23e9}-\u{23ef}\u{25b6}\u{23f8}-\u{23fa}]/ug;
    const CommentText_Emjoi = CommentText.replace(rex, match => `&#x${match.codePointAt(0).toString(16)};`);
    await securityCode();
    CMT_Button.prop('disabled', true);
    axios.post('/server/api', {
        "action": "add_comment",
        "movie_id": "all",
        "content": CommentText_Emjoi,
        "reply_comment_id": 0,
        "reply_user_id": 0,
        "hash": null,
        "token": $dt.token
    }).then(reponse => {
        run_ax = true;
        if (reponse.data.status == 'failed') {
            $('textarea[name="HomeComment"]').prop("disabled", true);
            $('textarea[name="HomeComment"]').val(reponse.data.result);
            if (reponse.data.result == 'Vui Lòng Thực Hiện Sau 20s, Càng Ấn Nhiều Đợi Càng Lâu') {
                Toast({
                    message: reponse.data.result,
                    type: "error"
                });
                CMT_Button.prop('disabled', true);
                var TimerSpam = setInterval(() => {
                    Spam--;
                    CMT_Button.html(`${Spam}s`);
                    if (Spam <= 0) {
                        CMT_Button.prop('disabled', false);
                        CMT_Button.html(`Gửi <img src="/themes/img/message.png" width="25" height="25">`);
                        Spam = 20
                        $('textarea[name="HomeComment"]').val('');
                        $('textarea[name="HomeComment"]').prop("disabled", false);
                        clearInterval(TimerSpam);
                    }
                }, 1000);

            } else {
                Toast({
                    message: reponse.data.result,
                    type: "error"
                });
                setTimeout(() => {
                    $('textarea[name="HomeComment"]').val('');
                    $('textarea[name="HomeComment"]').prop("disabled", false);
                    CMT_Button.prop('disabled', false);
                }, 5000);
            }

        } else {
            Toast({
                message: "Gửi bình luận thành công",
                type: "success"
            });
            $('textarea[name="HomeComment"]').val('');
            $('textarea[name="HomeComment"]').prop("disabled", true);
            $('.chat_div').append(`<li style="margin-bottom: 10px;">
                        <div class="boxchat-images">
                            <img class="avatar" src="${$user.avatar}" width="100" height="100" alt="${$user.nickname}">
                            <img class="avatar-frame" src="${$user.frame}">
                        </div>
                            <div class="p-comment-home">
                                <div class="box-chat-nickname" style="color: ${$user.color};">${$user.nickname} (Lv.${$user.level}) ${$user.icon} ${$user['icon-user']} <span class="Time-cmt-home">Vừa Xong</span></div>
                            </div>
                            <div class="boxchat-content">${CommentText}</div>
                    </li>`);
            $('.chat_div').animate({
                scrollTop: 99999
            }, 0);
            var TimerSpam = setInterval(() => {
                Spam--;
                CMT_Button.html(`${Spam}s`);
                if (Spam <= 0) {
                    CMT_Button.prop('disabled', false);
                    $('textarea[name="HomeComment"]').prop("disabled", false);
                    CMT_Button.html(`Gửi <img src="/themes/img/message.png" width="25" height="25">`);
                    Spam = 20
                    clearInterval(TimerSpam);
                }
            }, 1000);
        }
    }).catch(e => run_ax = true)
}