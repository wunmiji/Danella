<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between">
	<div class="fw-bold fs-5 gray-color">
		<?= $title; ?>
	</div>
</div>

<?= view_cell('\App\Cells\AlertCell::alertPost'); ?>



<div class="pt-4 row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<?php $validation = \Config\Services::validation(); ?>

				<?php $action = "/file-manager/" . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . "/update"; ?>
				<form method="POST" action="<?= $action; ?>"
					onSubmit="document.getElementById('submit').disabled=true;">
					<div>
						<div class="card-form-title">Basic</div>

						<div class="mb-4">
							<input type="text" name="name" id="nameInput" value="<?= esc($data->name); ?>"
								class="form-control" placeholder="Enter Name" />
							<?php if ($validation->getError('name')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('name'); ?>
								</span>
							<?php endif; ?>
						</div>

						<div class="mb-4">
							<textarea type="text" name="description" id="descriptionInput" class="form-control"
								placeholder="Enter Description" rows="5"><?= esc($data->description); ?></textarea>
							<?php if ($validation->getError('description')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('description'); ?>
								</span>
							<?php endif; ?>
						</div>

					</div>

					<!-- Submit button -->
					<button type="submit" name="submit" class="btn primary-btn">Update</button>
				</form>
			</div>
		</div>
	</div>
</div>




<?= $this->endSection(); ?>