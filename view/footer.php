<?php 
	$key_seo = json_decode($cf['key_seo'], true);
?>
<footer id="footer" class="clearfix">
	<div class="container footer-columns">
		<div class="row container">
			<div class="widget about col-xs-12 col-sm-4 col-md-4">
				<div class="footer-logo">
					<img class="img-responsive" src="<?= $cf['logo'] ?>" alt="<?= $cf['title'] ?>" />
					<span class="social"> </span>
				</div>
			</div>
			<div id="custom_html-2" class="widget_text widget widget_custom_html col-xs-12 col-sm-6 col-md-4">
				<h4 class="widget-title"></h4>
				<div class="textwidget custom-html-widget">
					<?php if ($key_seo) { ?>
						<?php foreach ($key_seo as $key => $value) { ?>
							<a rel="dofollow" href="<?= $value['url'] ?>" target="_blank"><?= $value['name'] ?></a>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</footer>
<div class="footer-credit">
	<div class="container credit">
		<div class="row container">
			<div class="col-xs-12 col-sm-4 col-md-6">
				©
				<a href="<?= URL ?>" title="Copyright ® 2025 <?= $cf['title'] ?>">
					Copyright ® 2025
					<h1 style="font-size: 100%; display: inline-block"><?= $cf['title'] ?></h1>
				</a>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-6 text-right pull-right">
				<p class="blog-info">
					<a href="<?= URL ?>/sitemap.xml" target="_blank" rel="noopener">Sitemap</a>
				</p>
			</div>
		</div>
	</div>
</div>

<div id="easy-top"></div>
<div class="modal-html"></div>

<!-- Login Modal -->
<div class="modal fade" id="login-modal-custom" tabindex="-1" role="dialog" aria-labelledby="login-modal-label">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="login-modal-label">Đăng Nhập</h4>
			</div>
			<div class="modal-body">
				<div id="login-message"></div>
				<form id="login-form-custom">
					<div class="form-group">
						<label for="login-email">Email</label>
						<input type="email" class="form-control" id="login-email" name="email" placeholder="Nhập email của bạn" autocomplete="email" required>
					</div>
					<div class="form-group">
						<label for="login-password">Mật khẩu</label>
						<input type="password" class="form-control" id="login-password" name="password" placeholder="Nhập mật khẩu của bạn" autocomplete="current-password" required>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block" id="login-submit-btn">
							<span class="login-btn-text">Đăng nhập</span>
							<span class="login-btn-loading" style="display: none;">
								<i class="fa fa-spinner fa-spin"></i> Đang xử lý...
							</span>
						</button>
					</div>
					<div class="form-group text-center" style="margin: 12px 0;">
						<span style="padding: 0 10px;">Hoặc</span>
					</div>
					<div class="form-group">
						<a href="#" class="btn btn-block login-google-btn" id="google-login-btn" style="display: flex; align-items: center; justify-content: center; background-color: #4285f4; color: #fff; border-radius: 4px; text-decoration: none; padding: 10px;">
							<p class="google-icon">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
									<path fill="#4285F4" d="M20.64 12.2045c0-.6381-.0573-1.2518-.1636-1.8409H12v3.4814h4.8436c-.2086 1.125-.8427 2.0782-1.7959 2.7164v2.2581h2.9087c1.7018-1.5668 2.6836-3.874 2.6836-6.615z"></path>
									<path fill="#34A853" d="M12 21c2.43 0 4.4673-.806 5.9564-2.1805l-2.9087-2.2581c-.8059.54-1.8368.859-3.0477.859-2.344 0-4.3282-1.5831-5.036-3.7104H3.9574v2.3318C5.4382 18.9832 8.4818 21 12 21z"></path>
									<path fill="#FBBC05" d="M6.964 13.71c-.18-.54-.2822-1.1168-.2822-1.71s.1023-1.17.2823-1.71V7.9582H3.9573A8.9965 8.9965 0 0 0 3 12c0 1.4523.3477 2.8268.9573 4.0418L6.964 13.71z"></path>
									<path fill="#EA4335" d="M12 6.5795c1.3214 0 2.5077.4541 3.4405 1.346l2.5813-2.5814C16.4632 3.8918 14.426 3 12 3 8.4818 3 5.4382 5.0168 3.9573 7.9582L6.964 10.29C7.6718 8.1627 9.6559 6.5795 12 6.5795z"></path>
								</svg>
							</p>
							<span>Đăng nhập bằng <b>Google</b></span>
						</a>
					</div>
					<div class="alert alert-info" style="margin-top: 15px; font-size: 12px;">
						<i class="fa fa-info-circle"></i> Mật khẩu mặc định khi lần đầu đăng nhập bằng Google là: <strong style="color: #ffa400">123456</strong>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/4.1.5/lazysizes.min.js"></script>
<script src="/themes/new-theme/js/bootstrap.min.js" id="bootstrap-js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="/themes/new-theme/js/main.js?v=<?= time() ?>"></script>