/**
 * Cơ chế lưu lịch sử xem phim mới
 * Sử dụng cookie khi chưa đăng nhập, database khi đã đăng nhập
 */

// Override hàm saveHistory cũ (nếu có)
if (typeof saveHistory === 'function') {
    // Lưu hàm cũ
    var oldSaveHistory = saveHistory;
}

// Hàm lưu lịch sử mới
function saveHistoryNew() {
    if (typeof $info_data === 'undefined') {
        return;
    }
    
    const movie_id = $info_data.movie_id;
    const episode_id = $info_data.id;
    const episode_name = $info_data.no_ep;
    
    if (!movie_id || !episode_id) {
        return;
    }
    
    // Gọi API để lưu lịch sử
    if (typeof axios !== 'undefined') {
        axios.post('/server/api', {
            action: 'save_history',
            movie_id: movie_id,
            episode_id: episode_id,
            episode_name: episode_name
        }).then(function(response) {
            // Lưu thành công
            if (response.data && response.data.status === 'success') {
                // Có thể thêm thông báo nếu cần
            }
        }).catch(function(error) {
            console.error('Lỗi lưu lịch sử:', error);
        });
    } else {
        // Fallback: sử dụng fetch nếu không có axios
        fetch('/server/api', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=save_history&movie_id=' + movie_id + '&episode_id=' + episode_id + '&episode_name=' + encodeURIComponent(episode_name)
        }).catch(function(error) {
            console.error('Lỗi lưu lịch sử:', error);
        });
    }
}

// Gọi hàm lưu lịch sử khi trang load xong
document.addEventListener('DOMContentLoaded', function() {
    // Đợi một chút để đảm bảo $info_data đã được khởi tạo
    setTimeout(function() {
        if (typeof $info_data !== 'undefined') {
            saveHistoryNew();
        }
    }, 500);
});

// Override hàm saveHistory cũ nếu có
if (typeof oldSaveHistory === 'function') {
    window.saveHistory = function() {
        // Gọi hàm mới
        saveHistoryNew();
        // Có thể gọi hàm cũ nếu cần (nhưng không nên)
        // oldSaveHistory();
    };
}

