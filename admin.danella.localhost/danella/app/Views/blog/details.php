<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between">
	<div class="fw-bold fs-5 gray-color">
		<?= $title; ?>
	</div>
</div>

<?= view_cell('\App\Cells\AlertCell::alertPost'); ?>

<?php $dataCardHeader = [
	'detailsCoverImageSrc' => $dataImage->fileSrc,
	'detailsCoverImageAlt' => $dataImage->fileName,
	'detailsAvatarIcon' => "<i class='bx bx-news bx-lg white-color'></i>",
	'name' => $data->title,
	'status' => $data->status,
	'updateHref' => '/blog/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/update',
	'statusHref' => '/blog/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/status',
	'deleteHref' => '/blog/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/delete',
	'buttons' => [],
] ?>
<?= view_cell('\App\Cells\DetailsCell::detailsCardHeader', $dataCardHeader); ?>


<div class="row g-3 my-3">
	<div class="col-lg-5 col-md-6 col-12">
		<?php $basicRow = [
			'rows' => [
				'Title' => $data->title,
				'Published Date' => $data->publishedDate ?? 'Not Published',
				'Summary' => $data->summary,
				'Created' => $data->createdDateTime,
				'Last Modified' => $data->modifiedDateTime ?? 'Never Modified',
			],
			'height' => 31, // Add 1rem for gap space
		] ?>
		<?= view_cell('\App\Cells\DetailsCell::basicDl', $basicRow); ?>
	</div>

	<div class="col-lg-7 col-md-6 col-12">
		<div class="row g-3">
			<div class="col-12">
				<div class="card" style="height: 15rem;">
					<div class="card-header card-header-title">Author</div>
					<div class="card-body overflow-y-auto">
						<div class="d-flex">
							<div class="flex-shrink-0">
								<img src="<?= $dataAuthor->fileSrc; ?>" alt="<?= $dataAuthor->fileName; ?>">
							</div>
							<div class="flex-grow-1 ms-3">
								<div class="fw-bold"><?= $dataAuthor->name; ?></div>
								<div><?= $dataAuthor->description; ?></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="card" style="height: 15rem;">
					<div class="card-header card-header-title">Categories</div>
					<div class="card-body overflow-y-auto">
						<ul class="ps-0">
							<?php if (empty($dataCategories)): ?>
								<small>No data yet</small>
							<?php else: ?>
								<?php foreach ($dataCategories as $key => $service): ?>
									<li class="py-3 fw-normal">
										<i class='bx bxs-circle small pe-3'></i>
										<?= $service->name; ?>
									</li>
								<?php endforeach; ?>
							<?php endif; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<!-- data_text -->
<?= $this->include('include/data_text'); ?>


<?= $this->endSection(); ?>