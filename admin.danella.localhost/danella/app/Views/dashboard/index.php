<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>
<div class="d-flex fw-bold fs-5 gray-color"><?= $title; ?></div>

<?= view_cell('\App\Cells\AlertCell::alertPost'); ?>

<div class="row g-4">
	<div class="col-md-12 col-12">
		<div class="card" style="height: 20rem;">
			<div class="card-header d-flex justify-content-between">
				<div class="card-header-title">Achievement</div>
				<div>
					<select class="form-select" id="projectPerMonthYear" aria-label="Default select example">
						<option disabled>Year</option>
						<?php for ($i = $founded; $i <= date('Y'); $i++): ?>
							<option value="<?= $i; ?>" <?= ($i == date('Y')) ? 'selected' : ''; ?>><?= $i; ?></option>
						<?php endfor; ?>
					</select>
				</div>
			</div>
			<div class="card-body overflow-y-auto">
				<canvas id="achievementCanvas" data-project-per-month="<?= esc($projectPerMonth); ?>"
					data-blog-per-month="<?= esc($blogPerMonth); ?>" class="w-100" style="height: 97%;">
					<p>Your browser does not support the canvas element.</p>
				</canvas>
			</div>
		</div>
	</div>

	<div class="col-md-6 col-12">
		<div class="card" style="height: 35rem;">
			<div class="card-header card-header-title">Service</div>
			<div class="card-body overflow-y-auto">
				<canvas id="serviceCanvas" data-service-name="<?= esc($serviceName); ?>"
					data-service-per-project="<?= esc($servicePerProject); ?>"
					data-service-per-blog="<?= esc($servicePerBlog); ?>" class="w-100" style="height: 97%;">
					<p>Your browser does not support the canvas element.</p>
				</canvas>

			</div>
		</div>
	</div>

	<div class="col-md-6 col-12">
		<div class="card" style="height: 35rem;">
			<div class="card-header card-header-title">File Manager</div>
			<div class="card-body overflow-y-auto">
				<canvas id="fileManagerCanvas" data-file-used-space="<?= esc($usedSpace); ?>"
					data-file-total-space="<?= esc($totalSpace); ?>" data-file-free-space="<?= esc($freeSpace); ?>"
					class="w-100" style="height: 97%;">
					<p>Your browser does not support the canvas element.</p>
				</canvas>
			</div>
		</div>
	</div>
</div>


<?= $this->endSection(); ?>