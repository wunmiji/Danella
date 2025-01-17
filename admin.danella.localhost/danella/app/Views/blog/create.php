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

				<form method="POST" action="<?= base_url('blog/create'); ?>"
					onSubmit="document.getElementById('submit').disabled=true;">
					<div>
						<div class="card-form-title">Basic</div>

						<div class="mb-4">
							<input type="text" name="title" id="titleInput" value="<?= set_value('title'); ?>"
								class="form-control" placeholder="Enter Title" />
							<?php if ($validation->getError('title')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('title'); ?>
								</span>
							<?php endif; ?>
						</div>

						<div class="mb-4">
							<textarea type="text" name="summary" id="summaryTextarea" class="form-control"
								placeholder="Enter Summary" rows="3"><?= set_value('summary'); ?></textarea>
							<?php if ($validation->getError('summary')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('summary'); ?>
								</span>
							<?php endif; ?>
						</div>

						<div class="mb-4">
							<div class="checkbox-services">
								<label class="form-label">Select services</label>
								<?php foreach ($services as $key => $service): ?>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="<?= $service->id; ?>"
											id="flexCheckDefault" name="services[]">
										<label class="form-check-label" for="flexCheckDefault">
											<?= $service->name; ?>
										</label>
									</div>
								<?php endforeach; ?>
							</div>
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
							<div id="editor" class="form-control"></div>
							<input type="hidden" id="textHiddenInput" name="text">
							<?php if ($validation->getError('text')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('text'); ?>
								</span>
							<?php endif; ?>
						</div>

					</div>

					<!-- Submit button -->
					<button type="submit" id="submit" name="submit" class="btn primary-btn">Create</button>
				</form>
			</div>
		</div>
	</div>
</div>



<!-- files_modal -->
<?= $this->include('include/files_modal'); ?>



<?= $this->endSection(); ?>