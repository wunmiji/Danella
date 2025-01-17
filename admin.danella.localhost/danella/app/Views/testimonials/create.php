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

				<form method="POST" action="<?= base_url('testimonials/create'); ?>"
					onSubmit="document.getElementById('submit').disabled=true;">
					<div>
						<div class="card-form-title">Basic</div>

						<div class="mb-4">
							<input type="text" name="name" id="nameInput" value="<?= set_value('name'); ?>"
								class="form-control" placeholder="Enter Name" />
							<?php if ($validation->getError('name')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('name'); ?>
								</span>
							<?php endif; ?>
						</div>

						<div class="mb-4">
							<input type="text" name="position" id="positionInput" value="<?= set_value('position'); ?>"
								class="form-control" placeholder="Enter Position" />
							<?php if ($validation->getError('position')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('position'); ?>
								</span>
							<?php endif; ?>
						</div>

						<div class="mb-4">
							<div class="single-file-upload">
								<div class="drop-zone py-5 text-center" id="dropzone" data-output="div-uploaded-file"
									data-multiple="false" data-bs-toggle="modal" data-bs-target="#filesModal">
									<i class='bx bx-cloud-upload fs-1'></i>
									<p class="fs-6" id="fileText"></p>
								</div>
								<div id="div-uploaded-file"></div>
							</div>
							<?php if ($validation->getError('file')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('file'); ?>
								</span>
							<?php endif; ?>
						</div>

						<div class="mb-4">
							<textarea type="text" name="note" id="noteInput" class="form-control"
								placeholder="Enter Note" rows="5"><?= set_value('note'); ?></textarea>
							<?php if ($validation->getError('note')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('note'); ?>
								</span>
							<?php endif; ?>
						</div>

					</div>

					<!-- Submit button -->
					<button type="submit" name="submit" id="submit" class="btn primary-btn">Create</button>
				</form>
			</div>
		</div>
	</div>
</div>



<!-- files_modal -->
<?= $this->include('include/files_modal'); ?>


<?= $this->endSection(); ?>