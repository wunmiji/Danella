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

				<form method="POST" action="/file-managerr/<?= $dataPrivateId; ?>/create-file" enctype="multipart/form-data"
					onSubmit="document.getElementById('submit').disabled=true;">
					<div>
						<div class="card-form-title">Basic</div>

						<div class="mb-4">
							<div class="single-file-upload">
								<div class="drop-zone py-5 text-center" id="drops-zone">
									<i class='bx bx-cloud-upload fs-1'></i>
									<p class="fs-6" id="filesText"></p>
									<input type="file" accept="<?= $acceptedFileInput; ?>" id="filesInput"
										name="files[]" multiple hidden>
								</div>
								<div id="div-uploaded-files"></div>
							</div>
							<?php if ($validation->getError('files')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('files'); ?>
								</span>
							<?php endif; ?>
						</div>

						<input type="hidden" id="privateIdHiddenInput" name="privateId" value="<?= $dataPrivateId; ?>">

					</div>

					<!-- Submit button -->
					<button type="submit" name="submit" id="submit" class="btn primary-btn">Create</button>
				</form>
			</div>
		</div>
	</div>
</div>




<?= $this->endSection(); ?>