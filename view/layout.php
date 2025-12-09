<!DOCTYPE html>
<html lang="vi">

<head>
	<?php require_once(ROOT_DIR . '/view/head.php'); ?>
	<?php if (isset($additional_head)) echo $additional_head; ?>
</head>

<body class="home blog wp-embed-responsive wp-theme-halimmovies wp-child-theme-halimmovies-child halimthemes halimmovies">
	<!-- Header -->
	<?php require_once(ROOT_DIR . '/view/header.php'); ?>

	<!-- Navbar -->
	<?php require_once(ROOT_DIR . '/view/navbar.php'); ?>

	<!-- Main Content -->
	<div class="container">
		<?php
		if (isset($content)) {
			echo $content;
		}
		else {
			// Fallback: include content file n
			if (isset($content_file)) include($content_file);
		}
		?>
	</div>
	<!-- End Main Content -->

	<div id="ah_toast"></div>

	<!-- Footer -->
	<?php require_once(ROOT_DIR . '/view/footer.php'); ?>
</body>

</html>