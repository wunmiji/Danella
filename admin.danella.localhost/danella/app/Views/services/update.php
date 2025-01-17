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

				<form method="POST" action="<?= base_url('services/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/update'); ?>"
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
							<textarea name="description" id="descriptionTextarea" class="form-control"
								placeholder="Enter Description" rows="3"><?= esc($data->description); ?></textarea>
							<?php if ($validation->getError('description')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('description'); ?>
								</span>
							<?php endif; ?>
						</div>

						<div class="mb-4">
							<div class="single-file-upload">
								<div class="drop-zone py-5 text-center" id="dropzone" data-output="div-uploaded-file"
									data-multiple="false" data-bs-toggle="modal" data-bs-target="#filesModal">
									<i class='bx bx-cloud-upload fs-1'></i>
									<p class="fs-6" id="fileText"></p>
									<?php if (isset($dataImage->fileSrc)): ?>
										<input type="hidden" id="fileHidden" value="<?= esc(json_encode($dataImage)); ?>">
									<?php endif; ?>
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
							<input type="hidden" id="textHiddenInput" name="text" value="<?= esc($dataText->text); ?>">
							<?php if ($validation->getError('text')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('text'); ?>
								</span>
							<?php endif; ?>
						</div>
					</div>

					<div id="div-faqs-section">
						<div class="d-flex justify-content-between align-items-center form-title">
							<span class="card-form-title">FAQ</span>
							<button id="plus-button"><i class='bx bx-plus bx-sm'></i></button>
							<input type="hidden" id="faqsHidden" name="faqsHidden" value="<?= esc($dataFaqs); ?>">
						</div>

						<div id="div-faqs"></div>
					</div>

					<!-- Submit button -->
					<button type="submit" name="submit" id="submit" class="btn primary-btn"
						onclick="saveContent()">Update</button>
				</form>
			</div>
		</div>
	</div>
</div>


<!-- files_modal -->
<?= $this->include('include/files_modal'); ?>



<?= $this->endSection(); ?>