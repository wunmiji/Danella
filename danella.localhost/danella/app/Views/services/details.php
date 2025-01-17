<?= $this->extend('layouts/default_sidebar'); ?>

<?= $this->section('corousel'); ?>

<!-- corousel-section -->
<?php $dataCarousel = [
	'dataCarouselImage' => '/assets/images/services-featured-area.jpg',
	'dataCarouselTitle' => 'Driving Towards a <br> Renewable-Powered Future',
	'dataCarouselSubTitle' => 'Some representative placeholder content for the third slide of this carousel.',
	'dataCarouselBreadCrumb' => ['/' => 'Home', '/services' => 'Services'],
	'dataCarouselBreadCrumbActive' => $data->name,
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>
<?= $this->endSection(); ?>


<!-- service-details-section -->
<?= $this->section('content'); ?>

<?= $this->include('include/main_details'); ?>

<?php if (!empty($dataFaqs)): ?>
	<div class="card mt-5">
		<div class="card-body">
			<h5 class="card-title mb-4">Frequently Asked Question</h5>
			<dl class="accordion">
				<?php $index = 0; ?>
				<?php foreach ($dataFaqs as $key => $value): ?>
					<?php $index++; ?>
					<div class="accordion-item">
						<dt>
							<?= $value->question; ?>
						</dt>
						<dd><?= $value->answer; ?></dd>
					</div>
				<?php endforeach; ?>
			</dl>
		</div>
	</div>
<?php endif; ?>

<?= $this->endSection(); ?>


<!-- sidebar -->
<?= $this->section('sidebar'); ?>

<div class="card">
	<div class="card-body">
		<h5 data-anima class="card-title mb-4">Our Services</h5>
		<div class="service-list">
			<?php foreach ($dataServices as $key => $value): ?>
				<a data-anima href="/services/<?= $value->slug; ?>">
					<?= $value->name; ?>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<?= $this->include('include/get_in_touch'); ?>

<?= $this->endSection(); ?>