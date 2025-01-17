<?= $this->extend('layouts/default'); ?>

<?= $this->section('corousel'); ?>

<!-- corousel-section -->
<div id="myCarousel" class="carousel slide mb-6">
	<div class="carousel-indicators">
		<button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true"
			aria-label="Slide 1"></button>
		<button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
		<button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
		<button type="button" data-bs-target="#myCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
	</div>
	<div class="carousel-inner">
		<div class="carousel-item active">
			<img src="<?= '/assets/images/featured-area.jpg'; ?>" class="img-fluid" alt="...">
			<div class="carousel-caption">
				<div class="container">
					<h1>Driving Towards a <br> Renewable-Powered Future</h1>
					<p>Some representative placeholder content for the third slide of this
						carousel.
					</p>
					<div class="d-none d-lg-block carousel-get-quote-btn">
						<?= view_cell('\App\Cells\MainCell::anchorElement', ['link' => '/get-quote', 'name' => 'Get a quote']); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="carousel-item">
			<img src="<?= '/assets/images/featured-area-2.jpg'; ?>" class="img-fluid" alt="...">
			<div class="carousel-caption">
				<div class="container">
					<h1>Foster a Sustainable <br> and Dependable Energy System</h1>
					<p>Some representative placeholder content for the third slide of this
						carousel.
					</p>
					<div class="d-none d-lg-block carousel-get-quote-btn">
						<?= view_cell('\App\Cells\MainCell::anchorElement', ['link' => '/get-quote', 'name' => 'Get a quote']); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="carousel-item">
			<img src="<?= '/assets/images/featured-area-3.jpg'; ?>" class="img-fluid" alt="...">
			<div class="carousel-caption">
				<div class="container">
					<h1>Driving Towards a <br> Renewable-Powered Future</h1>
					<p>Some representative placeholder content for the third slide of this
						carousel.
					</p>
					<div class="d-none d-lg-block carousel-get-quote-btn">
						<?= view_cell('\App\Cells\MainCell::anchorElement', ['link' => '/get-quote', 'name' => 'Get a quote']); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="carousel-item">
			<img src="<?= '/assets/images/featured-area-4.jpg'; ?>" class="img-fluid" alt="...">
			<div class="carousel-caption">
				<div class="container">
					<h1>Driving Towards a <br> Renewable-Powered Future</h1>
					<p>Some representative placeholder content for the third slide of this
						carousel.
					</p>
					<div class="d-none d-lg-block carousel-get-quote-btn">
						<?= view_cell('\App\Cells\MainCell::anchorElement', ['link' => '/get-quote', 'name' => 'Get a quote']); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection(); ?>



<?= $this->section('content'); ?>

<!-- about-us-section -->
<section class="mb-5">
	<div class="container">
		<div class="row align-items-center g-4 py-3">
			<div class="col-md-6 col-12">
				<div data-anima class="primary-text-color fw-bold">ABOUT US</div>
				<div data-anima class="secondary-text-color fw-bold display-6">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit
				</div>
				<div data-anima class="fs-6 secondary-light-text-color mt-4">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
					et
					dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
					aliquip
					exea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
					eu
					fugiatnulla pariatur.
				</div>
				<div class="mt-4">
					<div class="row row-cols-md-2 row-cols-1 g-3">
						<div class="d-flex align-items-center">
							<i class='bx bxs-check-circle bx-sm me-3'></i>
							<div data-anima class="fs-6 fw-semibold">Lorem ipsum dolor</div>
						</div>
						<div class="d-flex align-items-center">
							<i class='bx bxs-check-circle bx-sm me-3'></i>
							<div data-anima class="fs-6 fw-semibold">Lorem ipsum dolor</div>
						</div>
						<div class="d-flex align-items-center">
							<i class='bx bxs-check-circle bx-sm me-3'></i>
							<div data-anima class="fs-6 fw-semibold">Lorem ipsum dolor</div>
						</div>
						<div class="d-flex align-items-center">
							<i class='bx bxs-check-circle bx-sm me-3'></i>
							<div data-anima class="fs-6 fw-semibold">Lorem ipsum dolor</div>
						</div>
						<div class="d-flex align-items-center">
							<i class='bx bxs-check-circle bx-sm me-3'></i>
							<div data-anima class="fs-6 fw-semibold">Lorem ipsum dolor</div>
						</div>
						<div class="d-flex align-items-center">
							<i class='bx bxs-check-circle bx-sm me-3'></i>
							<div data-anima class="fs-6 fw-semibold">Lorem ipsum dolor</div>
						</div>
					</div>
				</div>
				<div class="mt-4">
					<?= view_cell('\App\Cells\MainCell::anchorElement', ['link' => '/about', 'name' => 'Read More']); ?>
				</div>
			</div>
			<div class="col-md-6 col-12">
				<div id="index-about-us-img">
					<img class="img-fluid" src="/assets/illustration/Quality-Assurance-color.svg" alt="">
				</div>
			</div>
		</div>
	</div>
</section>

<!-- service-section -->
<section class="secondary-lightt-bg-color" id="index-service-section">
	<div class="container py-5 ">
		<div class="row g-5 align-items-center py-3">
			<div class="col-md-6 col-12 h-100">
				<div id="index-service-img">
					<img class="img-fluid" src="/assets/illustration/undraw_qa_engineers_dg-5-p.svg" alt="">
				</div>
			</div>
			<div class="col-md-6 col-12 h-100">
				<div>
					<div data-anima class="primary-text-color fw-bold mb-2">OUR SERVICES</div>
					<div data-anima class="secondary-text-color fw-bold display-6">
						All our service is unparalleled in quality.
					</div>
					<div data-anima class="fs-6 secondary-light-text-color mt-4">
						Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
						labore
						et
						dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
					</div>
					<div class="mt-4">
						<?= view_cell('\App\Cells\MainCell::anchorElement', ['link' => '/services', 'name' => 'Our Services']); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- contact-section -->
<section>
	<div class="container py-5">
		<div class="primary-bg-color py-5">
			<div class="d-flex flex-wrap justify-content-md-between align-items-md-center px-5 row-gap-3">
				<div class="white-color d-flex flex-column row-gap-3">
					<h3 data-anima class="fw-bold lh-1">
						We stand out from the competition for several reasons.
					</h3>
					<div class="d-flex flex-wrap column-gap-5 row-gap-2">
						<div>
							<h3 id="countUpYears" data-count="<?= $countUpYears ?>" class="fw-bold" data-anima></h3>
							<h6>Years</h6>
						</div>
						<div>
							<h3 id="countUpProjects" data-count="<?= $countUpProjects ?>" class="fw-bold" data-anima>
							</h3>
							<h6>Projects</h6>
						</div>
						<div>
							<h3 id="countUpClients" data-count="<?= $countUpTestimonials ?>" class="fw-bold" data-anima>
							</h3>
							<h6>Clients</h6>
						</div>
					</div>
				</div>
				<div>
					<a class="btn rounded-0 px-4 fs-5 white-primary-btn" href="/contact">Contact Us
						<i class='bx bx-right-arrow-alt d-inline'></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- testimonials-section -->
<section class="secondary-lightt-bg-color">
	<div class="container py-5">
		<div class="py-3 text-center">
			<div data-anima class="primary-text-color fw-bold mb-2">TESTIMONIALS</div>
			<div class="secondary-text-color fw-bold display-6 mb-4">
				<div data-anima>Below are a few testimonials</div>
				<div data-anima>from our valued clients.</div>
			</div>
			<div>
				<div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 g-4">
					<?= $this->include('include/load_testimonials'); ?>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- blog-section -->
<section class="" id="blog-service-section">
	<div class="container py-5 ">
		<div data-anima class="primary-text-color fw-bold mb-2">BLOG</div>
		<div class="secondary-text-color fw-bold display-6 mb-4">
			<div data-anima>Our Latest blog</div>
		</div>
		<div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 g-3 py-3">
			<?= $this->include('include/load_blogs'); ?>
		</div>
	</div>
</section>

<?= $this->endSection(); ?>