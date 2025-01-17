<?= $this->extend('layouts/default_sidebar'); ?>

<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<?php $dataCarousel = [
	'dataCarouselImage' => '/assets/images/services-featured-area.jpg',
	'dataCarouselTitle' => 'Driving Towards a <br> Renewable-Powered Future',
	'dataCarouselSubTitle' => 'Some representative placeholder content for the third slide of this carousel.',
	'dataCarouselBreadCrumb' => ['/' => 'Home', '/projects' => 'Projects'],
	'dataCarouselBreadCrumbActive' => $data->name,
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>





<!-- project-details-section -->
<?= $this->section('content'); ?>

<?= $this->include('include/main_details'); ?>

<?php if (!empty($dataGallary)): ?>
	<div class="card">
		<div class="card-body">
			<h5 class="card-title mb-4">Project Gallary</h5>
			<div class="row row-cols-lg-3 row-cols-2 g-4">
				<?php foreach ($dataGallary as $key => $gallary): ?>
					<div class="col">
						<div class="w-100 h-100 position-relative">
							<?php if (str_starts_with($gallary->fileMimetype, 'image')): ?>

								<img class="object-fit-cover" role="button" data-bs-toggle="modal" data-bs-target="#gallaryModal"
									style="width: inherit; height: inherit;" data-src="<?= $gallary->fileSrc; ?>"
									data-name="<?= $gallary->fileName; ?>" data-mime="<?= $gallary->fileMimetype; ?>"
									src="<?= $gallary->fileSrc; ?>" alt="<?= $gallary->fileName; ?>">

							<?php elseif (str_starts_with($gallary->fileMimetype, 'video')): ?>

								<video class="object-fit-cover" role="button" data-bs-toggle="modal" data-bs-target="#gallaryModal"
									style="width: inherit; height: inherit;" data-src="<?= $gallary->fileSrc; ?>"
									data-name="<?= $gallary->fileName; ?>" data-mime="<?= $gallary->fileMimetype; ?>">
									<source src="<?= $gallary->fileSrc; ?>" type="<?= $gallary->fileMimetype; ?>">
									<?= $gallary->fileName; ?>
								</video>
								<i class='bx bx-play-circle bx-lg position-absolute top-50 start-50 translate-middle white-color'
									style="pointer-events: none;"></i>

							<?php endif ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
<?php endif; ?>



<!-- Modal -->
<div class="modal fade" id="gallaryModal" tabindex="-1" aria-labelledby="gallaryModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-fullscreen">
		<div class="modal-content gallary-modal">
			<div class="modal-header border-0 d-flex justify-content-between gallary-close-btn-modal">
				<h1 class="modal-title fs-5" id="gallaryModalLabel"></h1>
				<i class='bx bx-x bx-md' role="button" data-bs-dismiss="modal" aria-label="Close"></i>
			</div>
			<div class="modal-body container d-flex justify-content-center" id="modalBodyDiv">
			</div>
		</div>
	</div>
</div>

<?= $this->endSection(); ?>





<!-- sidebar -->
<?= $this->section('sidebar'); ?>

<div class="card">
	<div class="card-body">
		<h5 data-anima class="card-title fw-bold mb-4">Project Information</h5>
		<dl>
			<div>
				<dt data-anima>Date</dt>
				<dd data-anima>
					<?= $data->date; ?>
				</dd>
			</div>
			<div class="my-4">
				<dt data-anima>Client</dt>
				<dd data-anima>
					<?= $data->client; ?>
				</dd>
			</div>
			<div class="my-4">
				<dt data-anima>Location</dt>
				<dd data-anima>
					<?= $data->location; ?>
				</dd>
			</div>
			<div>
				<?php if (!empty($dataServices)): ?>
					<dt data-anima>Services</dt>
					<?php foreach ($dataServices as $key => $value): ?>
						<div data-anima>
							<?= $value->name; ?>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</dl>

	</div>
</div>

<?= $this->include('include/get_in_touch'); ?>

<?= $this->endSection(); ?>