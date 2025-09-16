<?php
	if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
	if (!$_SESSION['admin']) die(header("location:" . URL . "/admin_movie/login"));
	$table = "vat_pham";
	$stt = 0;
	$NumPage = GetParam("p") ? GetParam("p") : 1;
	$type = !empty($_GET['type']) ? $_GET['type'] : 'non';
	$LinkPage = URL . "/admin_movie/cua_hang_vat_pham/$type.html?p=";
	$LinkPageNoItem = URL . "/admin_movie/cua_hang_vat_pham";
	$listItem = categoryStore();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php
		$title_admin = "Cửa hàng vật phẩm";
		require_once("defult/head.php");
	?>
	<style>
		#current-item {
			width: auto;
		}

		.col-12:has(#current-item) {
			display: flex;
			align-items: center;
			column-gap: 10px;
		}
	</style>
</head>

<body>
	<?php require_once("defult/loader.php"); ?>
	<!-- tap on top starts-->
	<div class="tap-top"><i data-feather="chevrons-up"></i></div>
	<!-- tap on tap ends-->
	<!-- page-wrapper Start-->
	<div class="page-wrapper compact-wrapper" id="pageWrapper">
		<!-- Page Header Start-->
		<?php require_once("defult/header.php"); ?>
		<!-- Page Header Ends                              -->
		<!-- Page Body Start-->
		<div class="page-body-wrapper">
			<!-- Page Sidebar Start-->
			<?php require_once("defult/sidebar.php"); ?>
			<!-- Page Sidebar Ends-->
			<div class="page-body">
				<div class="container-fluid">
					<div class="page-title">
						<div class="row">
							<div class="col-12">
								<h3><?= $title_admin ?></h3>
								<select id="current-item" class="form-control">
									<?php foreach($listItem as $k => $v):?>
										<option value="<?=$k?>" <?= $type==$k ? 'selected' : '' ?>><?=$v?></option>
									<?php endforeach?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="container-fluid general-widget">
					<div class="row">
						<div class="card col-lg-12" id="Edit_Item" style="display: none;">
							<div class="card-header">
								<h4 class="card-title">Trình Chỉnh Sửa Trực Quan DATABASE</h4>
							</div>
							<div class="card-body" id="BodyEditerAjax"></div>
						</div>
						<div class="card col-lg-12" id="NewItem">
							<div class="card-header">
								<h4 class="card-title">Thêm vật phẩm mới</h4>
							</div>
							<div class="card-body">
								<form submit-ajax="ngockush" form-action="AddNewDatabase" action="<?= URL ?>/admin/server/api" method="POST" form-check="true">
									<input type="text" class="form-control" name="table" value="<?= $table ?>" style="display: none;">
									<input type="text" class="form-control" name="New[type]" value="<?= $type ?>" style="display: none;">
									<div class="form-group row">
										<div class="col-12 mb-3">
											<label>Tên</label>
											<input type="text" class="form-control" name="New[name]">
										</div>
										<div class="col-lg-12 col-md-12 mb-3">
											<label>Hình ảnh</label>
											<div class="input-group">
												<input class="form-control" type="text" name="New[image]">
												<button type="button" class="btn btn-primary" onclick="$('#image').click();">Chọn File</button>
												<input id="image" type="file" style="display: none;" onchange="UploadImagesBase64(this, 'store/<?= $type ?>');" accept="image/*" />
											</div>
										</div>
										<div class="col-12 mb-3">
											<label>Giá tiền</label>
											<input type="number" class="form-control" name="New[price]">
										</div>
										<?php if ($type == 'dan-duoc'): ?>
											<div class="col-12 mb-3">
												<label>Kinh nghiệm</label>
												<input type="number" class="form-control" name="New[exp]">
											</div>
										<?php endif; ?>
										<div class="col-12 text-center mb-3">
											<button class="btn btn-outline-info mt-" type="submit">Thêm Mới</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="card col-lg-12">
							<div class="card-header">
								<h4 class="card-title">Danh Sách</h4>
								<button class="btn btn-danger-gradien" type="button" onclick="MultiDel('<?= $table ?>');">Xóa Đã Chọn</button>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th scope="col"><input class="form-check-input" id="chontatca" type="checkbox"></th>
												<th scope="col">#</th>
												<th scope="col">Tên</th>
												<th scope="col">Hình ảnh</th>
												<th scope="col">Giá tiền</th>
												<?php if ($type == 'dan-duoc'): ?>
													<th scope="col">Kinh nghiệm</th>
												<?php endif; ?>
												<th scope="col">Thao Tác</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$P = CheckPages($table, "WHERE type = '$type'", $cf['limits'], $NumPage);
											if ($P['total'] >= 1) {
												$arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "$table WHERE type = '$type' ORDER BY price DESC LIMIT {$P['start']},{$cf['limits']}");
												while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
													$stt++;
											?>
													<tr id="<?= $table ?>_<?= $row['id'] ?>">
														<td>
															<input class="form-check-input" name="multi_del" type="checkbox" value="<?= $row['id'] ?>">
														</td>
														<th scope="row"><?= $stt ?></th>
														<td><?= $row['name'] ?></td>
														<td><?= ($row['image'] ? "<img src=\"{$row['image']}\" width=\"50\" height=\"auto\">" : 'Không có ảnh') ?></td>
														<td><?= numberFormat($row['price']) ?></td>
														<?php if ($type == 'dan-duoc'): ?>
															<td><?= numberFormat($row['exp']) ?></td>
														<?php endif; ?>
														<td>
															<div class="btn-group" role="group">
																<button class="btn btn-primary btn-xs" type="button" onclick="LoadFormEdit('<?= $table ?>',<?= $row['id'] ?>);">Edit</button>
																<button class="btn btn-danger btn-xs" type="button" onclick="TableXoa('<?= $table ?>',<?= $row['id'] ?>);">Xóa</button>
															</div>
														</td>
													</tr>
											<?php }
											} ?>
										</tbody>
									</table>
								</div>
								<?= view_pages_admin($P['total'], $cf['limits'], $NumPage, $LinkPage) ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	<?php require_once("defult/footer.php"); ?>
</body>
<script>
	$('body').on('change', '#current-item', function() {
		let item = $(this).val();
		let currentItem = '<?=$type?>';
		
		if (item != currentItem) {
			window.location.href=`<?=$LinkPageNoItem?>/${item}.html`;
		}
	});
</script>									
</html>