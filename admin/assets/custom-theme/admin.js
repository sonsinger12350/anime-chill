$('#chontatca').on('click', function() {
    $('input:checkbox').not(this).prop('checked', this.checked);
});
var MultiDel = async(table) => {
    var array = [];
    $('input[name="multi_del"]:checked').each(function() {
        array.push($(this).val());
    });
    if (array.length < 1) {
        AlertWarning("Bạn Chưa Chọn Trường Nào Cả");
        return;
    }
    const data = {
        table: table,
        arr: array,
        action: "multitype_detele"
    }
    let res = await Ajax("/admin/server/api", "POST", data);
    if (res.code != 200) {
        AlertWarning("Xóa Không Thành Công");
        return;
    }
    AlertSuccess(res.message, true);
}
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
var AlertWarning = function(message) {
    Swal.fire({
        html: message,
        iconHtml: `<img src="/admin/assets/icon/warning.png" width="50" height="50">`,
        confirmButtonText: 'Đồng Ý',
        customClass: {
            confirmButton: "btn btn-primary",
            icon: 'no-border'
        }
    });
}
var AlertSuccess = function(message, reload = true) {
    Swal.fire({
        html: message,
        iconHtml: `<img src="/admin/assets/icon/success.png" width="50" height="50">`,
        buttonsStyling: true,
        confirmButtonText: "Đồng Ý",
        customClass: {
            confirmButton: "btn btn-primary",
            icon: 'no-border'
        }
    }).then(function(result) {
        if (reload == false) {
            return;
        }
        window.location.reload();
    });
}

function PushEpname(num, e) {
    EpisodeArr[num].epname = $(e).val();
}

function PushServer(num, n, e) {
    EpisodeArr[num].server[n].server_link = $(e).val();
}
$("form[submit-ajax=Episode]").submit(function(e) {
    e.preventDefault();
    let _this = this;
    let url = $(_this).attr("action");
    let method = $(_this).attr("method");
    let href = $(_this).attr("href");
    let CheckEmpty = $(_this).attr("form-check");
    if ($(_this).attr("form-action")) {
        let FormAction = $(_this).attr("form-action");
        var data = JSON.stringify({
            data: EpisodeArr,
            action: FormAction,
            movie_id: $('#movie_id').val()
        });
    } else {
        var data = JSON.stringify({
            data: EpisodeArr
        });
    }
    console.log(CheckEmpty);
    if (CheckEmpty == "true") {
        if (data.indexOf('=&') > -1 || data.substr(data.length - 1) == '=') {
            AlertWarning('Vui Lòng Không Được Bỏ Trống Trường Nào');
            return
        }
    }
    let button = $(_this).find("button[type=submit]");
    if (button.attr("order")) {
        Swal.fire({
            title: "Bạn Có Chắc Chắn Thực Hiện Hành Động Này",
            text: button.attr("order"),
            icon: "warning",
            showCancelButton: true,
            cancelButtonColor: "#d33",
            confirmButtonText: "Thực Hiện",
            cancelButtonText: "Đóng",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: "warning",
                    title: "Đang Xử Lý Vui Lòng Không Tắt Trình Duyệt",
                    timer: 180000,
                    timerProgressBar: true,
                    showCancelButton: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });
                submitForm(url, method, href, data, button);
            }
        });
    } else {
        submitForm(url, method, href, data, button);
    }
});
$("form[submit-ajax=ngockush]").submit(function(e) {
    e.preventDefault();
    let _this = this;
    let url = $(_this).attr("action");
    let method = $(_this).attr("method");
    let href = $(_this).attr("href");
    let CheckEmpty = $(_this).attr("form-check");
    if ($(_this).attr("form-action")) {
        let FormAction = $(_this).attr("form-action");
        var data = $(_this).serialize() + `&action=${FormAction}`;
    } else {
        var data = $(_this).serialize();
    }
    console.log(CheckEmpty);
    if (CheckEmpty == "true") {
        if (data.indexOf('=&') > -1 || data.substr(data.length - 1) == '=') {
            AlertWarning('Vui Lòng Không Được Bỏ Trống Trường Nào');
            return
        }
    }
    let button = $(_this).find("button[type=submit]");
    if (button.attr("order")) {
        Swal.fire({
            title: "Bạn Có Chắc Chắn Thực Hiện Hành Động Này",
            text: button.attr("order"),
            icon: "warning",
            showCancelButton: true,
            cancelButtonColor: "#d33",
            confirmButtonText: "Thực Hiện",
            cancelButtonText: "Đóng",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: "warning",
                    title: "Đang Xử Lý Vui Lòng Không Tắt Trình Duyệt",
                    timer: 180000,
                    timerProgressBar: true,
                    showCancelButton: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });
                submitForm(url, method, href, data, button);
            }
        });
    } else {
        submitForm(url, method, href, data, button);
    }
});

function submitForm(url, method, href, data, button) {
    let textButton = button.html();
    let setting = {
        type: method,
        url,
        data,
        dataType: "json",
        beforeSend: function() {
            button.prop("disabled", !0).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xử lý...');
        },
        complete: function() {
            button.prop("disabled", !1).html(textButton);
        },
        success: function(response) {
            if (button.attr("callback")) {
                window[`${button.attr("callback")}`](response);
            }
            if (response.code == 200) {
                Swal.fire({
                    html: response.message,
                    iconHtml: `<img src="/admin/assets/icon/success.png" width="50" height="50">`,
                    buttonsStyling: true,
                    confirmButtonText: "Đồng Ý",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        icon: 'no-border'
                    }
                }).then(function(result) {
                    window.location.reload();
                });
            } else {
                AlertWarning(response.message);
            }
        },
        error: function(error) {
            console.log(error);
        },
    };
    $.ajax(setting);
}
var Ajax = (async(url, method, data, type = 'json') => {
    return new Promise((resolve, reject) => {
        let setting = {
            type: method,
            url: url,
            data: data,
            dataType: type,
            success: function(response) {
                resolve(response);
            },
            error: function(error) {
                console.log(error);
            },
        };
        $.ajax(setting);
    });
});
var SearhMovieLive = (async(input) => {
    let Keyword = input.value;
    if (Keyword.length < 3) {
        return
    }
    $("#SearchMovieModel").modal('show');
    if (Keyword == '') {
        $('#ModalSearch').html(``);
        return
    }
    const data = {
        action: "SearchMovie",
        keyword: Keyword
    }
    $('#ModalSearch').html(`<div class="mt-4 text-center fs-5"><span class="spinner-border spinner-border-lg fs-5" role="status" aria-hidden="true"></span> Đang xử lý...</div>`);
    let res = await Ajax("/admin/server/api", "POST", data);
    if (res.code != 200) {
        $('#ModalSearch').html(`<div class="EmptyMessage fs-5 text-danger">Không Tìm Thấy Phim Nào</div>`);
        return;
    }
    $('#ModalSearch').html(res.message);

});
var DangXuatTaiKhoan = (async() => {
    const data = {
        action: "DangXuat"
    }
    let res = await Ajax("/admin/server/api", "POST", data);
    if (res.code != 200) {
        AlertWarning("Đăng Xuất Tài Khoản Không Thành Công");
        return;
    }
    location.reload();
});
var TableXoa = (async(table, id) => {
    Swal.fire({
        title: "Bạn Có Chắc Chắn Thực Hiện Hành Động Này",
        icon: "warning",
        showCancelButton: true,
        cancelButtonColor: "#d33",
        confirmButtonText: "Thực Hiện",
        cancelButtonText: "Đóng",
    }).then(async(result) => {
        if (result.isConfirmed) {
            const data = {
                action: "XoaTable",
                table: table,
                id: id
            }
            let res = await Ajax("/admin/server/api", "POST", data);
            if (res.code != 200) {
                AlertWarning(res.message);
                return;
            }
            $(`#${table}_${id}`).remove();
            AlertSuccess(res.message);
        }
    });
});
var EditerForm = (async(table, id) => {
    const data = {
        action: "EditerForm",
        table: table,
        id: id
    }
    let res = await Ajax("/admin/server/api", "POST", data);
    if (res.code != 200) {
        AlertWarning(res.message);
        return;
    }
    $('#NewItem').hide();
    $('#BodyEditerAjax').html(res.message);
    $('#Edit_Item').show();
});

function isURL(str) {
    var regex = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
    var pattern = new RegExp(regex);
    return pattern.test(str);
}

function RemoveServer(ServerID) {
    $(`#${ServerID}`).remove();
    Num -= 1;
}
var GetLink = (async(input) => {
    let URL = $(input).val();
    if (!isURL(URL)) {
        console.log(`Failled URL => ${URL}`);
        return;
    }
    const data = {
        action: "getlink",
        link: URL
    }
    $(input).val(`Đang Lấy Link Chờ Chút...`);
    $(input).prop('disabled', true);
    let res = await Ajax("/admin/server/api", "POST", data);
    if (res.code == 200) {
        $(input).prop('disabled', false);
        $(input).val(res.message).trigger("input");
    } else {
        $(input).prop('disabled', false);
        $(input).val(res.message).trigger("input");
    }
});
var LoadFormEdit = (async(FormEdit, id) => {
    const data = {
        action: "EditerForm",
        FormEdit: FormEdit,
        id: id
    }
    let res = await Ajax("/admin/server/edit", "POST", data, 'text');
    if (res == '') {
        AlertWarning("Load Trình Chỉnh Sửa Không Thành Công");
        return;
    }
    $('#NewItem').hide();
    $('#BodyEditerAjax').html(res).end();
    $('html, body').animate({
        scrollTop: $("#Edit_Item").offset().top
    }, 100);
    $('#Edit_Item').show();

});
var SendDataToServer = (async(Send_data, reload = true) => {
    let res = await Ajax("/admin/server/api", "POST", Send_data, 'json');
    if (res == '') {
        AlertWarning("Server Lỗi Thực Hiện Không Thành Công");
        return;
    }
    if (res.code == 200) {
        AlertSuccess(res.message, reload);
    } else {
        AlertWarning(res.message);
    }

});
var UploadImages = (async(InputFile, width, height) => {
    $(`input[name="New[${InputFile.id}]"]`).val('Xin Chờ Đang Tải Lên....');
    $(`input[name="New[${InputFile.id}]"]`).prop("disabled", true);
    var $files = $(InputFile).get(0).files;
    if ($files.length) {
        if ($files[0].size > $(InputFile).data('max-size') * 1024) {
            Swal.fire({
                title: 'Thông Báo',
                text: 'Dung Lượng File Quá Lớn',
                icon: 'error',
                confirmButtonText: 'Đồng Ý'
            });
            return false;
        }
        var settings = {
            async: false,
            crossDomain: true,
            processData: false,
            contentType: false,
            type: 'POST',
            url: "/admin/server/api",
            headers: {
                Accept: 'application/json',
            },
            mimeType: 'multipart/form-data',
        };

        var formData = new FormData();
        formData.append('image', $files[0]);
        formData.append('action', 'UploadImages');
        formData.append('width', width);
        formData.append('height', height);
        settings.data = formData;
        $.ajax(settings).done(function(response) {
            if (JSON.parse(response).code == 200) {
                $(`input[name="New[${InputFile.id}]"]`).val(JSON.parse(response).message);
                $(`input[name="data[${InputFile.id}]"]`).val(JSON.parse(response).message);
                $(`input[name="New[${InputFile.id}]"]`).prop("disabled", false);
            } else {
                $(`input[name="New[${InputFile.id}]"]`).val(JSON.parse(response).message);
                $(`input[name="data[${InputFile.id}]"]`).val(JSON.parse(response).message);
                $(`input[name="New[${InputFile.id}]"]`).prop("disabled", false);
            }
        });
    }
});
var UploadImagesBase64 = (async(InputFile, folder = '') => {
    $(`input[name="New[${InputFile.id}]"]`).val('Xin Chờ Đang Tải Lên....');
    $(`input[name="New[${InputFile.id}]"]`).prop("disabled", true);
    var img = InputFile.files[0];
    var reader = new FileReader();
    reader.onloadend = function() {
        //console.log(reader.result);

        var settings = {
            async: false,
            crossDomain: true,
            processData: false,
            contentType: false,
            type: 'POST',
            url: "/admin/server/api",
            headers: {
                Accept: 'application/json',
            },
            mimeType: 'multipart/form-data',
        };
        var formData = new FormData();
        formData.append('image', reader.result);
        formData.append('action', 'UploadImagesBase64');
        formData.append('folder', folder);
        settings.data = formData;
        $.ajax(settings).done(function(response) {
            if (JSON.parse(response).code == 200) {
                $(`input[name="New[${InputFile.id}]"]`).val(JSON.parse(response).message);
                $(`input[name="data[${InputFile.id}]"]`).val(JSON.parse(response).message);
                $(`input[name="New[${InputFile.id}]"]`).prop("disabled", false);
            } else {
                $(`input[name="New[${InputFile.id}]"]`).val(JSON.parse(response).message);
                $(`input[name="data[${InputFile.id}]"]`).val(JSON.parse(response).message);
                $(`input[name="New[${InputFile.id}]"]`).prop("disabled", false);
            }
        });
    }
    reader.readAsDataURL(img);
});
$('#add-fast-server').click(function() {
    var _this = $(this),
        movie_id = _this.attr('data-movie');
    $.post('/admin/server/api', {
        action: 'add-fast-server',
        movie_id
    }).done(function(res) {
        const { code, message } = res;
        AlertSuccess(message);
    });
});
$('#upgrade-episode-server').click(function() {
    var _this = $(this),
        movie_id = _this.attr('data-movie');
    $.post('/admin/server/api', {
        action: 'upgrade-episode-server',
        movie_id
    }).done(function(res) {
        const { code, message } = res;
        AlertSuccess(message);
    });
});
$('.set-trang-thai').click(function() {
    var _this = $(this),
        movie_type = _this.attr('data-type'),
        list_movie = [];
    $('input[name="multi_del"]:checked').each(function() {
        list_movie.push($(this).val());
    });
    if (list_movie.length < 1) {
        AlertWarning("Bạn Chưa Chọn Trường Nào Cả");
        return;
    }
    $.post('/admin/server/api', {
        action: 'set-trang-thai',
        list_movie,
        movie_type
    }).done(function(res) {
        const { code, message } = res;
        AlertSuccess(message);
    });
});

$('.clean-server').on('click', function() {
    let server = $(this).val();
    let name = $(this).attr('data-name');
    
    if (server) {
        Swal.fire({
            title: "Bạn Có Chắc Chắn Thực Hiện Hành Động Này",
            icon: "warning",
            showCancelButton: true,
            cancelButtonColor: "#d33",
            confirmButtonText: "Thực Hiện",
            cancelButtonText: "Đóng",
        }).then(async(result) => {
            if (result.isConfirmed) {
                $.post('/admin/server/api', {
                    action: 'clean-server',
                    server,
                    name
                }).done(function(res) {
                    const { code, message } = res;
                    AlertSuccess(message);
                });

                return true;
            }
        });
    }
});

$('.manager-links').off('click').on('click', function() {
    let movie = $(this).val();

    if (movie) {
        $.post('/admin/server/api', {
            action: 'get-server-by-movie',
            movie
        }).done(function(res) {
            let modal = $('#ManagerLinkModal');
            modal.find('#select_server').html(res.message);
            modal.find('[name="movie_selected"]').val(movie);
            const { code, message } = res;
            modal.modal('show');
        });
        return false;
    }
});

$('[name="select_server"]').off('change').on('change', function() {
    let modal = $(this).closest('#ManagerLinkModal');
    let server = $(this).val();
    let movie = modal.find('[name="movie_selected"]').val();

    if (server && movie) {
        $.post('/admin/server/api', {
            action: 'get-link-episode-by-server',
            server,movie
        }).done(function(res) {
            modal.find('[name="list_links"]').html(res.message);
        });

        return true;
    }
});

$('#sync-server-episode').off('click').on('click', function() {
    let movie = $(this).val();

    if (!movie) {
        return false;
    }
    
    Swal.fire({
        title: "Bạn Có Chắc Chắn Thực Hiện Hành Động Này",
        icon: "warning",
        showCancelButton: true,
        cancelButtonColor: "#d33",
        confirmButtonText: "Thực Hiện",
        cancelButtonText: "Đóng",
    }).then(async(result) => {
        if (result.isConfirmed) {
            $.post('/admin/server/api', {
                action: 'sync-server-episode',
                movie
            }).done(function(res) {
                AlertSuccess(res.message, true);
            });
    
            return true;
        }
    });
});