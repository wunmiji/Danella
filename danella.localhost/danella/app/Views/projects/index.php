<?= $this->extend('layouts/default'); ?>

<?= $this->section('corousel'); ?>

<!-- corousel-section -->
<?php $dataCarousel = [
	'dataCarouselImage' => '/assets/images/services-featured-area.jpg',
	'dataCarouselTitle' => 'Our pride',
	'dataCarouselSubTitle' => 'Whether it\'s a residential, commercial, or industrial project, <br> our dedication to quality and customer satisfaction remains unwavering.',
	'dataCarouselBreadCrumb' => ['/' => 'Home'],
	'dataCarouselBreadCrumbActive' => 'Projects',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>


<?= $this->section('content'); ?>

<!-- projects-section -->
<section class="mb-5">
	<div class="container">
		<div id="alertDiv"></div>

		<?php if (empty($data)): ?>
			<?= $this->include('include/empty_data'); ?>
		<?php else: ?>
			<div id="dataDiv" class="row row-cols-lg-3 row-cols-md-2 row-cols-1 g-5">
				<?= $this->include('include/load_projects'); ?>
			</div>
		<?php endif; ?>

		<div id="loadMoreDiv"></div>
	</div>
</section>


<?= $this->include('include/load_more'); ?>



<?= $this->endSection(); ?>