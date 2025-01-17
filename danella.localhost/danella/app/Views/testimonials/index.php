<?= $this->extend('layouts/default'); ?>

<?= $this->section('corousel'); ?>

<!-- corousel-section -->
<?php $dataCarousel = [
	'dataCarouselImage' => '/assets/images/clients-featured-area.jpg',
	'dataCarouselTitle' => 'What they say about us',
	'dataCarouselSubTitle' => 'Our service has garnered positive feedback for its exceptional quality. <br> We prioritize our customers needs and ensure prompt assistance and support.',
	'dataCarouselBreadCrumb' => ['/' => 'Home'],
	'dataCarouselBreadCrumbActive' => 'Testimonials',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>


<?= $this->section('content'); ?>

<!-- testimonials-section -->
<section class="mb-5">
	<div class="container">
		<div id="alertDiv"></div>

		<?php if (empty($data)): ?>
			<?= $this->include('include/empty_data'); ?>
		<?php else: ?>
			<div id="dataDiv" class="row row-cols-lg-3 row-cols-md-2 row-cols-1 g-5">
				<?= $this->include('include/load_testimonials'); ?>
			</div>
		<?php endif; ?>

		<div id="loadMoreDiv"></div>
	</div>
</section>


<?= $this->include('include/load_more'); ?>

<?= $this->endSection(); ?>