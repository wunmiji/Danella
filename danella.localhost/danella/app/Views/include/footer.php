<!-- footer -->
<footer class="footer-bg-color pt-5">
	<div class="container">
		<div class="row gx-5 py-5">
			<div class="col-md-6 col-sm-12 col-12">
				<div class="mb-4">
					<figure>
						<img src="<?= '/assets/brand/danellatech-footer-logo.svg'; ?>" alt="Logo" width="190">
					</figure>
				</div>
				<div class="footer-body-color">
					<p data-anima>Lorem ipsum dolor sit amet, consectetur adipiscing elit, quis nostrud
						exercitation ullamco laboris nisi ut aliquip
						ex ea commodo consequat..</p>
					<ul class="nav list-unstyled d-flex mx-0 px-0 pt-3">
						<li class="">
							<a class="text-body-secondary" href="<?= $information['facebook']; ?>">
								<i class='bx bxl-facebook-circle bx-sm'></i>
							</a>
						</li>
						<li class="ms-3">
							<a class="text-body-secondary" href="<?= $information['instagram']; ?>">
								<i class='bx bxl-instagram-alt bx-sm'></i>
							</a>
						</li>
						<li class="ms-3">
							<a class="text-body-secondary" href="<?= $information['linkedin']; ?>">
								<i class='bx bxl-linkedin-square bx-sm'></i>
							</a>
						</li>
						<li class="ms-3">
							<a class="text-body-secondary" href="<?= $information['twitter']; ?>">
								<i class='bx bxl-twitter bx-sm'></i>
							</a>
						</li>
						<li class="ms-3">
							<a class="text-body-secondary" href="<?= $information['youtube']; ?>">
								<i class='bx bxl-youtube bx-sm'></i>
							</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="col-md-3 col-sm-12 col-12">
				<div class="mb-4 footer-title-color quicksand-bold">
					<h5 data-anima>Quick Links</h5>
				</div>
				<div class="footer-body-color">
					<ul class="nav flex-column row-gap-1">
						<li class="nav-item"><a data-anima href="/" class="nav-link px-0">Home</a></li>
						<li class="nav-item"><a data-anima href="/about" class="nav-link px-0">About</a></li>
						<li class="nav-item"><a data-anima href="/services" class="nav-link px-0">Services</a></li>
						<li class="nav-item"><a data-anima href="/projects" class="nav-link px-0">Projects</a></li>
						<li class="nav-item"><a data-anima href="/contact" class="nav-link px-0">Contact</a></li>
					</ul>
				</div>
			</div>

			<div class="col-md-3 col-sm-12 col-12">
				<div class="mb-4 footer-title-color quicksand-bold">
					<h5 data-anima>Others</h5>
				</div>
				<div class="footer-body-color">
					<ul class="nav flex-column row-gap-1">
						<li class="nav-item"><a data-anima href="/blog" class="nav-link px-0">Blog</a></li>
						<li class="nav-item"><a data-anima href="/testimonials" class="nav-link px-0">Testimonials</a>
						</li>
						<li class="nav-item"><a data-anima href="/privacy" class="nav-link px-0">Privacy</a></li>
						<li class="nav-item"><a data-anima href="/terms" class="nav-link px-0">Terms</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-copyright-bg-color">
		<div class="container">
			<div class="d-flex justify-content-center py-4 footer-body-color">
				<?php $founded = $information['founded']; ?>
				<?php $footerCopyrightYear = ($founded != date('Y')) ? ($founded  . '-' . date('Y')) : $founded;?> 
				<span data-anima>Danellatech.com © <?= $footerCopyrightYear; ?>.</span>
				<a href="#" class="mx-2" data-anima>Omobolaji Micheal Adewunmi</a>
				<span data-anima>All right reserved.</span>
			</div>
		</div>

	</div>
</footer>

<!-- js -->
<script src="/assets/js/library/bootstrap.bundle.js"></script>
<script src="/assets/js/library/jquery-3.7.1.min.js"></script>
<script type="module" src="/assets/js/library/animaview.min.js"></script>

<!-- custom js -->
<script type="module" src="/assets/js/custom/floating_ui.js"></script>
<script type="module" src="/assets/js/custom/animaview.js"></script>

<!-- other js_files through controller -->
<?= $js_files ?? ''; ?>



</body>

</html>