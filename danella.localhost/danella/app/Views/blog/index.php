<?= $this->extend('layouts/default_sidebar'); ?>

<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<?php $dataCarousel = [
	'dataCarouselImage' => '/assets/images/services-featured-area.jpg',
	'dataCarouselTitle' => 'What we do',
	'dataCarouselSubTitle' => 'At our core, we are dedicated to providing solutions that make a difference. <br> By constantly innovating and staying ahead of trends, <br> we aim to exceed expectations and set new standards in the industry.',
	'dataCarouselBreadCrumb' => ['/' => 'Home'],
	'dataCarouselBreadCrumbActive' => 'Blog',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>







<!-- blog-list-section -->
<?= $this->section('content'); ?>

<div>
	<div id="alertDiv"></div>

	<?php if (empty($data)): ?>
		<?= $this->include('include/empty_data'); ?>
	<?php else: ?>
		<div id="dataDiv" class="row row-cols-md-2 row-cols-1 g-5">
			<?= $this->include('include/load_blogs'); ?>
		</div>
	<?php endif; ?>

	<div id="loadMoreDiv"></div>
</div>



<?= $this->include('include/load_more'); ?>


<?= $this->endSection(); ?>







<!-- sidebar -->
<?= $this->section('sidebar'); ?>

<?= $this->include('include/get_in_touch'); ?>

<?= $this->endSection(); ?>