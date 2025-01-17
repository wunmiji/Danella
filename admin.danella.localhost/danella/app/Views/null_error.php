<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between">
	<div class="fw-bold fs-5 gray-color">
		<?= $title; ?>
	</div>
</div>

<section class="my-5">
	<div class="row">
		<?= view_cell('\App\Cells\ErrorCell::error'); ?>
	</div>
</section>


<?= $this->endSection(); ?>