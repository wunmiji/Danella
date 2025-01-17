<?= $this->extend('layouts/default'); ?>

<?= $this->section('corousel'); ?>

<!-- corousel-section -->
<?php $dataCarousel = [
	'dataCarouselImage' => '/assets/images/services-featured-area.jpg',
	'dataCarouselTitle' => 'What we do',
	'dataCarouselSubTitle' => 'At our core, we are dedicated to providing solutions that make a difference. <br> By constantly innovating and staying ahead of trends, <br> we aim to exceed expectations and set new standards in the industry.',
	'dataCarouselBreadCrumb' => ['/' => 'Home'],
	'dataCarouselBreadCrumbActive' => 'Services',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>


<?= $this->section('content'); ?>

<!-- services-section -->
<section class="mb-5">
	<div class="container">
		<?php if (empty($data)): ?>
			<?= $this->include('include/empty_data'); ?>
		<?php else: ?>
			<div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 g-5">
				<?php $index = 0; ?>
				<?php foreach ($data as $key => $value): ?>
					<?php $index++; ?>
					<div class="col">
						<!-- service -->
						<div class="card h-100">
							<div class="card-img-top-div">
								<?php $dataImage = $value->image ?>
								<img src="<?= $dataImage->fileSrc; ?>" class="card-img-top" alt="<?= $dataImage->fileName; ?>">
							</div>
							<div class="card-body h-100 d-flex flex-column">
								<small class="fw-semibold primary-text-color">
									<?= sprintf('%02d', $index); ?> - S E R V I C E
								</small>
								<a href="/services/<?= $value->slug; ?>" class="card-title fs-3 lh-sm fw-semibold">
									<?= $value->name; ?>
								</a>
								<h6 class="card-text"
									style="-webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; display: -webkit-box;">
									<?= $value->description; ?>
								</h6>
							</div>
						</div>

					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

</section>
<?= $this->endSection(); ?>