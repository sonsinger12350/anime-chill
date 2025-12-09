jQuery(function($) {
	$('.icon_overlay[data-toggle="halim-popover"]').popover({ placement: "top", container: "body"});

	$('body').on('click', '#action_showtimes', function(e) {
		let blockShowtimes = $('.halim-showtimes-block.show-pc');

		blockShowtimes.slideToggle(300);
	});

	// Biến lưu filter hiện tại
	var currentFilter = {};

	// Hàm load danh sách phim với filter và pagination
	function loadMovieList(page, filter) {
		// Hiển thị loading
		$('.halim-ajax-popular-post-loading').removeClass('hidden');
		
		let view = $('#view').val();
		let keyword = $('#keyword').val();
		
		// Xác định action dựa trên view
		let action = 'load_movie_list';
		if (view === 'movie-bookmark') action = 'load_bookmarked_movies';
		
		// Chuẩn bị data request
		let requestData = {
			action: action,
			page: page || 1
		};
		
		// Nếu là bookmark thì không cần filter và view
		if (action === 'load_bookmarked_movies') {
			let limit = $('#limit').val();
			requestData.limit = limit;
		}
		else if (view === 'movie-category') {
			requestData.view = view || 'home';
			requestData.filter = {
				...(filter || {}),
				category_id: $('#category_id').val(),
				name: $('#category_name').val()
			};
		}
		else {
			requestData.view = view || 'home';
			requestData.filter = {
				...(filter || {}),
				keyword: keyword || ''
			};
		}
		
		// Gọi AJAX
		$.ajax({
			type: 'POST',
			url: '/server/api',
			contentType: 'application/json',
			dataType: 'json',
			data: JSON.stringify(requestData),
			success: function(response) {
				if (response.status === 'success') {
					// Cập nhật toàn bộ nội dung trong #ajax-showtimes-widget
					$('#ajax-showtimes-widget').html(response.data);
					
					// Scroll to top của danh sách phim
					$('html, body').animate({
						scrollTop: $('#ajax-showtimes-widget').offset().top - 100
					}, 500);
					
					// Re-init popover sau khi load xong
					$('.icon_overlay[data-toggle="halim-popover"]').popover({ placement: "top", container: "body"});
				}
				else {
					alert(response.message || 'Có lỗi xảy ra khi tải dữ liệu');
				}
				
				// Ẩn loading
				$('.halim-ajax-popular-post-loading').addClass('hidden');
			},
			error: function() {
				alert('Có lỗi xảy ra khi tải dữ liệu');
				$('.halim-ajax-popular-post-loading').addClass('hidden');
			}
		});
	}

	// Xử lý click vào weekday để filter theo ngày
	$(document).on('click', '.halim-showtimes-block .weekday', function(e) {
		e.preventDefault();
		
		var day = $(this).data('day');
		if (!day) return;
		
		// Bỏ qua nếu click vào cùng ngày đang active
		if ($(this).hasClass('active')) return;
		
		// Cập nhật active state
		$('.halim-showtimes-block .weekday').removeClass('active');
		$(this).addClass('active');
		
		// Lưu filter day hiện tại
		// Nếu là 'lastupdated', xóa filter day để không filter
		if (day === 'lastupdated') delete currentFilter.day;
		else currentFilter.day = day;
		
		// Load lại danh sách với filter mới, reset về trang 1
		loadMovieList(1, currentFilter);
	});

	// Xử lý AJAX pagination
	$(document).on('click', '.movie-pagination', function(e) {
		e.preventDefault();
		
		var page = $(this).data('page');
		if (!page) return;
		
		// Kiểm tra nếu đang ở trang hiện tại
		if ($(this).parent().find('.current').length > 0 && $(this).parent().find('.current').text() == page) {
			return;
		}
		
		// Load danh sách với filter hiện tại
		loadMovieList(page, currentFilter);
	});

	// Xử lý xóa bookmark từng phim
	$(document).on('click', '.remove-bookmark', function(e) {
		e.preventDefault();
		
		var $removeBtn = $(this);
		var movieId = $removeBtn.attr('id');
		
		if (!movieId) {
			alert('Không tìm thấy ID phim');
			return;
		}
		
		// Xác nhận trước khi xóa
		if (!confirm('Bạn có chắc chắn muốn xóa phim này khỏi danh sách theo dõi?')) return;
		
		// Disable button để tránh click nhiều lần
		$removeBtn.prop('disabled', true);
		
		// Gọi API xóa bookmark
		$.ajax({
			type: 'POST',
			url: '/server/api',
			contentType: 'application/json',
			dataType: 'json',
			data: JSON.stringify({
				action: 'del_follow',
				movie_id: movieId
			}),
			success: function(response) {
				// Xử lý cả trường hợp trả về string 'success' (backward compatibility)
				if (response === 'success' || (response && response.status === 'success')) {
					// Xóa element khỏi DOM
					$removeBtn.closest('.bookmark-list').fadeOut(300, function() {
						$(this).remove();
						
						// Kiểm tra nếu danh sách trống thì load lại
						if ($('.bookmark-list').length === 0) {
							// Load lại danh sách bookmark
							loadMovieList(1, {});
						}
					});
					
					// Hiển thị thông báo thành công
					Toast({
						message: 'Đã xóa phim khỏi bookmark',
						type: 'success'
					});
				}
				else {
					// Hiển thị thông báo lỗi
					var errorMsg = (response && response.result) ? response.result : 'Có lỗi xảy ra khi xóa bookmark';
					Toast({
						message: errorMsg,
						type: 'error'
					});
					
					// Enable lại button
					$removeBtn.prop('disabled', false);
				}
			},
			error: function(xhr, status, error) {
				// Xử lý trường hợp API trả về string 'success' (backward compatibility)
				if (xhr.responseText && xhr.responseText.trim() === 'success') {
					// Xóa element khỏi DOM
					$removeBtn.closest('.bookmark-list').fadeOut(300, function() {
						$(this).remove();
						
						// Kiểm tra nếu danh sách trống thì load lại
						if ($('.bookmark-list').length === 0) {
							// Load lại danh sách bookmark
							loadMovieList(1, {});
						}
					});
					
					// Hiển thị thông báo thành công
					Toast({
						message: 'Đã xóa phim khỏi danh sách theo dõi',
						type: 'success'
					});
				}
				else {
					Toast({
						message: 'Có lỗi xảy ra khi xóa bookmark',
						type: 'error'
					});
					$removeBtn.prop('disabled', false);
				}
			}
		});
	});

	// Xử lý xóa tất cả bookmark
	$(document).on('click', '.remove-all-bookmark', function(e) {
		e.preventDefault();
		
		// Xác nhận trước khi xóa
		if (!confirm('Bạn có chắc chắn muốn xóa tất cả phim đã theo dõi?')) {
			return;
		}
		
		// Hiển thị loading
		$('.halim-ajax-popular-post-loading').removeClass('hidden');
		
		// Gọi API xóa tất cả bookmark
		$.ajax({
			type: 'POST',
			url: '/server/api',
			contentType: 'application/json',
			dataType: 'json',
			data: JSON.stringify({
				action: 'remove_all_bookmarks'
			}),
			success: function(response) {
				if (response.status === 'success') {
					// Load lại danh sách bookmark (sẽ trống)
					loadMovieList(1, {});
					
					// Hiển thị thông báo thành công
					Toast({
						message: response.message || 'Đã xóa tất cả phim đã theo dõi',
						type: 'success'
					});
				}
				else {
					Toast({
						message: response.message || response.result || 'Có lỗi xảy ra khi xóa bookmark',
						type: 'error'
					});
				}
				
				// Ẩn loading
				$('.halim-ajax-popular-post-loading').addClass('hidden');
			},
			error: function() {
				alert('Có lỗi xảy ra khi xóa bookmark');
				$('.halim-ajax-popular-post-loading').addClass('hidden');
			}
		});
	});
});

// Khởi tạo event handlers cho login modal khi DOM ready
jQuery(function($) {
	// Xử lý submit form login
	$(document).on('submit', '#login-form-custom', function(e) {
		e.preventDefault();
		
		var email = $('#login-email').val();
		var password = $('#login-password').val();
		
		// Validate
		if (!email || !password) {
			showLoginMessage('Vui lòng nhập đầy đủ email và mật khẩu', 'error');
			return;
		}
		
		if (!isValidEmail(email)) {
			showLoginMessage('Địa chỉ email không hợp lệ', 'error');
			return;
		}
		
		// Hiển thị loading
		$('#login-submit-btn').prop('disabled', true);
		$('.login-btn-text').hide();
		$('.login-btn-loading').show();
		$('#login-message').hide();
		
		// Gửi request đăng nhập
		$.ajax({
			type: 'POST',
			url: '/server/api',
			contentType: 'application/json',
			dataType: 'json',
			data: JSON.stringify({
				action: 'login',
				email: email,
				password: password
			}),
			success: function(response) {
				if (response.status === 'success') {
					showLoginMessage(response.message || 'Đăng nhập thành công!', 'success');
					// Reload trang sau 1 giây
					setTimeout(function() {
						window.location.href = response.redirect || '/';
					}, 1000);
				}
				else {
					showLoginMessage(response.message || 'Đăng nhập thất bại', 'error');
					$('#login-submit-btn').prop('disabled', false);
					$('.login-btn-text').show();
					$('.login-btn-loading').hide();
				}
			},
			error: function() {
				showLoginMessage('Có lỗi xảy ra khi đăng nhập. Vui lòng thử lại!', 'error');
				$('#login-submit-btn').prop('disabled', false);
				$('.login-btn-text').show();
				$('.login-btn-loading').hide();
			}
		});
	});
	
	// Xử lý Google login
	$(document).on('click', '#google-login-btn', function(e) {
		e.preventDefault();
		
		// Lấy Google auth URL
		$.ajax({
			type: 'POST',
			url: '/server/api',
			contentType: 'application/json',
			dataType: 'json',
			data: JSON.stringify({
				action: 'get_google_auth_url'
			}),
			success: function(response) {
				if (response.status === 'success' && response.auth_url) {
					// Redirect đến Google OAuth
					window.location.href = response.auth_url;
				} else {
					showLoginMessage(response.message || 'Không thể kết nối với Google. Vui lòng thử lại!', 'error');
				}
			},
			error: function() {
				showLoginMessage('Có lỗi xảy ra khi kết nối với Google. Vui lòng thử lại!', 'error');
			}
		});
	});
});

function openLoginModalCustom() {
	// Hiển thị modal
	if ($('#login-modal-custom').length > 0) {
		$('#login-modal-custom').modal('show');
	}
}

// Hàm hiển thị thông báo
function showLoginMessage(message, type) {
	var messageDiv = $('#login-message');
	var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
	
	messageDiv.removeClass('alert-success alert-danger')
		.addClass('alert ' + alertClass)
		.html(message)
		.show();
}

// Hàm validate email
function isValidEmail(email) {
	var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	return re.test(email);
}