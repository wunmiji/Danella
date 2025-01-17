<?= $this->extend('layouts/default_sidebar'); ?>

<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<?php $dataCarousel = [
	'dataCarouselImage' => '/assets/images/about-featured-area.jpg',
	'dataCarouselTitle' => 'How we make <br> a difference',
	'dataCarouselSubTitle' => 'By choosing us, customers are not only getting a high-quality service, <br> but they are also making a conscious choice to support a company <br> that is dedicated to making a positive impact on the world.',
	'dataCarouselBreadCrumb' => ['/' => 'Home'],
	'dataCarouselBreadCrumbActive' => 'About',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>





<!-- main-section -->
<?= $this->section('content'); ?>

<!-- about -->
<section class="mb-5 anima-here">
	<div class="container">
		<div class="row g-4">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div>
							<div class="card-title fw-bold">Why Choose Us</div>
							<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
								incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
								exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
								irure
								dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
								pariatur.
								Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
								mollit anim id est laborum.</div>
						</div>

						<div class="my-4">
							<div class="card-title">Our Mission</div>
							<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
								incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
								exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
								irure
								dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
								pariatur.
								Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
								mollit anim id est laborum.</div>
						</div>

						<div>
							<div class="card-title">Our Goal</div>
							<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
								incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
								exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
								irure
								dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
								pariatur.
								Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
								mollit anim id est laborum.</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?= $this->endSection(); ?>




<!-- sidebar -->
<?= $this->section('sidebar'); ?>

<?= $this->include('include/testimonial_swiper'); ?>

<?= $this->include('include/get_in_touch'); ?>

<?= $this->endSection(); ?>
