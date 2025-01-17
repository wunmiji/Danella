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
	'detailsAvatarIcon' => "<i class='bx bx-cog bx-lg white-color'></i>",
	'name' => $data->name,
	'status' => $data->status,
	'updateHref' => '/services/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/update',
	'statusHref' => '/services/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/status',
	'deleteHref' => '/services/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/delete',
	'buttons' => [],
] ?>
<?= view_cell('\App\Cells\DetailsCell::detailsCardHeader', $dataCardHeader); ?>


<div class="row g-3 my-3">
	<div class="col-md-5 col-12">
		<?php $basicRow = [
			'rows' => [
				'Name' => $data->name,
				'Description' => $data->description,
				'Created' => $data->createdDateTime,
				'Last Modified' => $data->modifiedDateTime ?? 'Never Modified',
			],
			'height' => 25,
		] ?>
		<?= view_cell('\App\Cells\DetailsCell::basicDl', $basicRow); ?>
	</div>

	<div class="col-md-7 col-12">
		<div class="card" style="height: 25rem;">
			<div class="card-header card-header-title">Faq</div>
			<div class="card-body overflow-y-auto">
				<ul class="list-group list-group-flush">
					<?php if (empty($dataFaqs)): ?>
						<small>No data yet</small>
					<?php else: ?>
						<?php foreach ($dataFaqs as $key => $faq): ?>
							<li class="list-group-item px-0 py-3">
								<h5 class="mb-2 fw-medium">
									<?= $faq->question; ?>
								</h5>
								<small>
									<?= $faq->answer; ?>
								</small>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
</div>



<!-- data_text -->
<?= $this->include('include/data_text'); ?>


<?= $this->endSection(); ?>