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

				<form method="POST" action="<?= base_url('projects/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/files'); ?>"
					onSubmit="document.getElementById('submit').disabled=true;" class="project-form">

					<div>
						<div class="card-form-title">Files</div>

						<div class="mb-4">
							<div class="single-file-upload">
								<div class="drop-zone py-5 text-center" id="dropszone" data-output="div-uploaded-files"
									data-bs-toggle="modal" data-bs-target="#filesModal">
									<i class='bx bx-cloud-upload fs-1'></i>
									<p class="fs-6" id="filesText"></p>
									<input type="hidden" id="filesHidden" value="<?= esc($dataFiles); ?>">
								</div>
								<div id="div-uploaded-files"></div>
							</div>
							<?php if ($validation->getError('files')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('files'); ?>
								</span>
							<?php endif; ?>
						</div>

					</div>

					<!-- Submit button -->
					<button type="submit" name="submit" id="submit" class="btn primary-btn">Update</button>
				</form>
			</div>
		</div>
	</div>
</div>



<!-- files_modal -->
<?= $this->include('include/files_modal'); ?>


<?= $this->endSection(); ?>