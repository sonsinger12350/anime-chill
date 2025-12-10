<?php
	if (!isset($pagination)) return;

	$total = ceil($pagination['total'] / $limit);
	if ($total <= 1) return;

	// Lấy trang hiện tại từ GET parameter
	$currentPage = isset($_GET['p']) ? intval($_GET['p']) : 1;
	if ($currentPage < 1) $currentPage = 1;
	if ($currentPage > $total) $currentPage = $total;

	// Không cần hàm getPageUrl nữa vì sẽ dùng AJAX

	// Tính toán các trang cần hiển thị
	$showPages = [];
	$range = 2; // Số trang hiển thị mỗi bên của trang hiện tại
	
	// Luôn hiển thị trang đầu
	if ($total > 0) $showPages[1] = true;
	
	// Hiển thị các trang xung quanh trang hiện tại
	for ($i = max(1, $currentPage - $range); $i <= min($total, $currentPage + $range); $i++) {
		$showPages[$i] = true;
	}
	
	// Luôn hiển thị trang cuối
	if ($total > 1) $showPages[$total] = true;
?>
<div class="pagination-wrapper">
	<ul class="page-numbers">
		<?php
		// Nút Previous
		if ($currentPage > 1) {
			$prevPage = $currentPage - 1;
			echo '<li><span class="page-numbers movie-pagination prev" data-page="' . $prevPage . '"><i class="fa-solid fa-angle-left"></i></span></li>';
		}
		
		$prevPage = null;

		foreach ($showPages as $pageNum => $show) {
			// Thêm dấu ... nếu có khoảng trống
			if ($prevPage !== null && $pageNum - $prevPage > 1) echo '<li><span class="page-numbers dots">…</span></li>';
			
			// Hiển thị trang
			if ($pageNum == $currentPage) {
				echo '<li><span aria-current="page" class="page-numbers current">' . $pageNum . '</span></li>';
			}
			else {
				echo '<li><span class="page-numbers movie-pagination" data-page="' . $pageNum . '">' . $pageNum . '</span></li>';
			}
			
			$prevPage = $pageNum;
		}
		
		// Nút Next
		if ($currentPage < $total) {
			$nextPage = $currentPage + 1;
			echo '<li><span class="page-numbers movie-pagination next" data-page="' . $nextPage . '"><i class="fa-solid fa-angle-right"></i></span></li>';
		}
		?>
	</ul>
</div>