<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_SESSION['admin']) die(header("location:" . URL . "/admin_movie/login"));
$table = "the_nap";
$stt = 0;
$NumPage = (GetParam("p") ? sql_escape(GetParam("p")) : 1);

if (GetParam("kw")) {
	$kw = sql_escape(GetParam("kw"));
	$SQL = "WHERE card_code LIKE '%$kw%'";
}
$mysql->query("UPDATE " . DATABASE_FX . "$table SET seen = 1 WHERE seen = 0");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	$title_admin = "Quản Lý Thẻ Nạp";
	require_once("defult/head.php");
	?>
	<style>
		[data-tooltip] {
			position: relative;
			z-index: 2;
			cursor: pointer;
		}

		[data-tooltip]:before,
		[data-tooltip]:after {
			visibility: hidden;
			-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
			filter: progid: DXImageTransform.Microsoft.Alpha(Opacity=0);
			opacity: 0;
			pointer-events: none;
		}

		[data-tooltip]:before {
			position: absolute;
			bottom: 150%;
			left: 50%;
			margin-bottom: 5px;
			margin-left: -80px;
			padding: 7px;
			width: 160px;
			-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
			background-color: #000;
			background-color: hsla(0, 0%, 20%, 0.9);
			color: #fff;
			content: attr(data-tooltip);
			text-align: center;
			font-size: 14px;
			line-height: 1.2;
		}

		[data-tooltip]:after {
			position: absolute;
			bottom: 150%;
			left: 50%;
			margin-left: -5px;
			width: 0;
			border-top: 5px solid #000;
			border-top: 5px solid hsla(0, 0%, 20%, 0.9);
			border-right: 5px solid transparent;
			border-left: 5px solid transparent;
			content: " ";
			font-size: 0;
			line-height: 0;
		}

		[data-tooltip]:hover:before,
		[data-tooltip]:hover:after {
			visibility: visible;
			-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
			filter: progid: DXImageTransform.Microsoft.Alpha(Opacity=100);
			opacity: 1;
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
							<div class="col-12 col-sm-6">
								<h3><?= $title_admin ?></h3>
							</div>
						</div>
					</div>
				</div>
				<div class="container-fluid general-widget">
					<div class="row">
						<div class="card col-lg-12">
							<div class="card-header">
								<div class="row mb-3">
									<div class="col-6">
										<h4 class="card-title">Danh Sách Thẻ Nạp</h4>
										<button class="btn btn-danger-gradien" type="button" onclick="MultiDel('<?= $table ?>');">Xóa Đã Chọn</button>
									</div>
									<div class="col-4">
										<input type="text" class="form-control" id="keyword" placeholder="Nhập Mã Thẻ Cần Tìm">
									</div>
									<div class="col-2">
										<button type="button" class="btn btn-success" onclick="location.href = `<?= $WebsiteSlug ?>?p=<?= $NumPage ?>&kw=${$('#keyword').val()}`">Tìm Kiếm</button>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th scope="col"><input class="form-check-input" id="chontatca" type="checkbox"></th>
												<th scope="col">#</th>
												<th scope="col">Ngày gửi</th>
												<th scope="col">Thành viên</th>
												<th scope="col">Loại thẻ</th>
												<th scope="col">Mệnh giá</th>
												<th scope="col">Serial</th>
												<th scope="col">Mã thẻ</th>
												<th scope="col">Trạng thái</th>
												<th scope="col">Thao tác</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$P = CheckPages($table, "$SQL", $cf['limits'], $NumPage);
											if ($P['total']) {
												$depositCardOptions = getOptionsDepositCard();
												$arr = $mysql->query("SELECT " . DATABASE_FX . "$table.*, " . DATABASE_FX . "user.email
													FROM " . DATABASE_FX . "$table 
													JOIN " . DATABASE_FX . "user ON " . DATABASE_FX . "$table.user_id = " . DATABASE_FX . "user.id
													$SQL 
													ORDER BY FIELD(status, 'Processing', 'Success', 'Cancel'), 
													id DESC 
													LIMIT {$P['start']},{$cf['limits']}
												");
												while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
													$stt++;
													$status = $depositCardOptions['status'][$row['status']];

													if ($row['status'] == 'Cancel') {
														$status = '<span class="bg-' . $status['color'] . ' p-2 rounded" data-tooltip="' . $row['note'] . '">' . $status['text'] . $note .' <i class="fa fa-info-circle" aria-hidden="true"></i></span>';
													}
													else {
														$status = '<span class="bg-' . $status['color'] . ' p-2 rounded">' . $status['text'] . ' </span>';
													}
											?>
													<tr id="<?= $table ?>_<?= $row['id'] ?>">
														<td>
															<input class="form-check-input" name="multi_del" type="checkbox" value="<?= $row['id'] ?>">
														</td>
														<th scope="row"><?= $stt ?></th>
														<td><?= $row['created_at'] ?></td>
														<td><?= $row['email'] ?></td>
														<td><?= $row['card_type'] ?></td>
														<td><?= $row['card_value'] ?></td>
														<td><?= $row['card_serial'] ?></td>
														<td><?= $row['card_code'] ?></td>
														<td><?= $status ?></td>
														<td>
															<div class="btn-group" role="group">
																<button class="btn btn-success btn-xs" type="button" onclick="completeData(<?= $row['id'] ?>);">Hoàn tất</button>
																<button class="btn btn-danger btn-xs" type="button" onclick="cancelData(<?= $row['id'] ?>);">Hủy</button>
																<button class="btn btn-primary btn-xs" type="button" onclick="TableXoa('<?= $table ?>',<?= $row['id'] ?>);">Xóa</button>
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
	async function completeData(id) {
		Swal.fire({
			title: "Hoàn thành thẻ nạp",
			icon: "warning",
			showCancelButton: true,
			cancelButtonColor: "#d33",
			confirmButtonText: "Thực Hiện",
			cancelButtonText: "Đóng",
		}).then(async(result) => {
			if (result.isConfirmed) {
				let data = {
					action: "updateDepositCard",
					id: id,
					"status": "Success"
				}
				let res = await Ajax("/admin/server/api", "POST", data);

				if (res.code != 200) {
					AlertWarning(res.message);
					return;
				}

				AlertSuccess(res.message);
			}
		});
	}

	async function cancelData(id) {
		Swal.fire({
			title: "Hủy thẻ nạp",
			icon: "warning",
			input: 'text',
  			inputPlaceholder: 'Nhập lý do hủy thẻ nạp',
			showCancelButton: true,
			cancelButtonColor: "#d33",
			confirmButtonText: "Thực Hiện",
			cancelButtonText: "Đóng",
		}).then(async(result) => {
			if (result.isConfirmed) {
				let data = {
					action: "updateDepositCard",
					id: id,
					"status": "Cancel",
					note: result.value
				}
				let res = await Ajax("/admin/server/api", "POST", data);

				if (res.code != 200) {
					AlertWarning(res.message);
					return;
				}

				AlertSuccess(res.message);
			}
		});
	}
</script>
</html>