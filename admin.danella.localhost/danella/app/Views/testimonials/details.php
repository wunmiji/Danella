<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between">
	<div class="fw-bold fs-5 gray-color">
		<?= $title; ?>
	</div>
</div>

<?= view_cell('\App\Cells\AlertCell::alertPost'); ?>

<?php $dataCardHeader = [
	'detailsCoverImageSrc' => '/assets/images/background-image.jpg',
	'detailsCoverImageAlt' => 'Cover Image',
	'detailsAvatarImageSrc' => $dataImage->fileSrc,
	'detailsAvatarImageAlt' => $dataImage->fileName,
	'name' => $data->name,
	'status' => $data->status,
	'updateHref' => '/testimonials/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/update',
	'statusHref' => '/testimonials/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/status',
	'deleteHref' => '/testimonials/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/delete',
	'buttons' => [],
] ?>
<?= view_cell('\App\Cells\DetailsCell::detailsCardHeader', $dataCardHeader); ?>


<div class="row g-3 my-3">
	<div class="cl-lg-6 col-12">
		<?php $basicTable = [
			'rows' => [
				'Name:' => $data->name,
				'Position:' => $data->position,
				'Note:' => $data->note,
				'Created:' => $data->createdDateTime,
				'Last Modified:' => $data->modifiedDateTime ?? 'Never Modified',
			],
		] ?>
		<?= view_cell('\App\Cells\DetailsCell::basic', $basicTable); ?>
	</div>

</div>


<?= $this->endSection(); ?>