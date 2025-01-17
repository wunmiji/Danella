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

				<form method="POST" action="<?= base_url('projects/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/update'); ?>"
					onSubmit="document.getElementById('submit').disabled=true;" class="project-form">

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
							<input type="text" name="client" id="clientInput" value="<?= esc($data->client); ?>"
								class="form-control" placeholder="Enter Client" />
							<?php if ($validation->getError('client')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('client'); ?>
								</span>
							<?php endif; ?>
						</div>

						<div class="mb-4">
							<div class="project-services">
								<label class="form-label">Select services</label>
								<?php $match = $dataServices; ?>
								<?php foreach ($services as $key => $service): ?>
									<?php $id = in_array($service->id, $match) ? array_search($service->id, $match) : null; ?>
									<?php $jsonServiceValue = json_encode(array('id' => $id, 'serviceId' => $service->id)); ?>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value='<?= $jsonServiceValue; ?>'
											id="flexCheckDefault" name="services[]" <?= in_array($service->id, $match) ? 'checked' : ''; ?>>
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

						<div class="row">
							<div class="col-sm-6 col-12">
								<div class="mb-4">
									<input type="text" name="location" id="locationInput"
										value="<?= esc($data->location); ?>" class="form-control"
										placeholder="Enter Location" />
									<?php if ($validation->getError('location')): ?>
										<span class="text-danger text-sm">
											<?= $error = $validation->getError('location'); ?>
										</span>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-sm-6 col-12">
								<div class="mb-4">
									<input type="text" name="date" id="dateInput" placeholder="Select Date"
										class="form-control" value="<?= esc($data->date); ?>" data-input>
									<?php if ($validation->getError('date')): ?>
										<span class="text-danger text-sm">
											<?= $error = $validation->getError('date'); ?>
										</span>
									<?php endif; ?>
								</div>
							</div>
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

					<div>
						<div class="card-form-title">Gallary</div>

						<div class="mb-4">
							<div class="single-file-upload">
								<div class="drop-zone py-5 text-center" id="dropszone" data-output="div-uploaded-files"
									data-multiple="true" data-bs-toggle="modal" data-bs-target="#filesModal">
									<i class='bx bx-cloud-upload fs-1'></i>
									<p class="fs-6" id="filesText"></p>
									<input type="hidden" id="filesHidden" value="<?= esc($dataGallary); ?>">
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