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
	'buttons' => [
		'<a href="/employees/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/update" class="btn primary-btn">Update</a>',
		'<a href="/employees/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/update_password" class="btn primary-btn">Update Password</a>'
	],
] ?>
<?= view_cell('\App\Cells\DetailsCell::detailsCardHeader', $dataCardHeader); ?>

<div class="row g-3 my-3">
	<div class="col-12">
		<?php $basicTable = [
			'rows' => [
				'First Name:' => $data->firstName,
				'Last Name:' => $data->lastName,
				'Email:' => $dataContact->email,
				'Mobile:' => $dataContact->mobile,
				'Telephone:' => $dataContact->telephone,
				'Description:' => $data->description,
			],
		] ?>
		<?= view_cell('\App\Cells\DetailsCell::basic', $basicTable); ?>
	</div>
</div>

<?= $this->endSection(); ?>