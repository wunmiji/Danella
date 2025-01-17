<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between">
	<div class="fw-bold fs-5 gray-color">
		<?= $title; ?>
	</div>
</div>

<?= view_cell('\App\Cells\AlertCell::alertPost'); ?>


<?php $dataCardHeader = [
	'detailsCoverImageSrc' => $dataImage->fileSrc,
	'detailsCoverImageAlt' => $dataImage->fileName,
	'detailsAvatarIcon' => "<i class='bx bx-list-ul bx-lg white-color'></i>",
	'name' => $data->name,
	'status' => $data->status,
	'updateHref' => '/projects/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/update',
	'statusHref' => '/projects/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/status',
	'deleteHref' => '/projects/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/delete',
	'buttons' => [
		'<a href="/projects/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/files" class="btn primary-btn">Files</a>',
	],
] ?>
<?= view_cell('\App\Cells\DetailsCell::detailsCardHeader', $dataCardHeader); ?>


<div class="row g-3 my-3">
	<div class="col-md-5 col-12">
		<?php $basicRow = [
			'rows' => [
				'Name' => $data->name,
				'Client' => $data->client,
				'Location' => $data->location,
				'Date' => $data->date,
				'Created' => $data->createdDateTime,
				'Last Modified' => $data->modifiedDateTime ?? 'Never Modified',
			],
			'height' => 31, // Add 1rem for gap space
		] ?>
		<?= view_cell('\App\Cells\DetailsCell::basicDl', $basicRow); ?>
	</div>

	<div class="col-md-7 col-12 d-flex flex-column row-gap-3">
		<div class="card" style="height: 10rem;">
			<div class="card-header card-header-title">Services</div>
			<div class="card-body overflow-y-auto">
				<ul class="list-group list-group-flush">
					<?php if (empty($dataServices)): ?>
						<small>No data yet</small>
					<?php else: ?>
						<?php foreach ($dataServices as $key => $service): ?>
							<li class="list-group-item px-0 py-3 fw-normal">
								<?= $service->name; ?>
							</li>
						<?php endforeach; ?>
					<?php endif ?>
				</ul>
			</div>
		</div>

		<div class="card" style="height: 20rem;">
			<div class="card-header card-header-title">Gallary</div>
			<div class="card-body overflow-y-auto">
				<?php if (empty($dataGallary)): ?>
					<small>No data yet</small>
				<?php else: ?>
					<div class="row g-3">
						<?php foreach ($dataGallary as $key => $gallary): ?>
							<div class="col-md-4 col-6">
								<div class="card shadow-none h-100 w-100">
									<?php if (str_starts_with($gallary->fileMimetype, 'image')): ?>
										<div class="w-100 h-100 position-relative">
											<img class="rounded-0 object-fit-cover" style="width: inherit; height: inherit;"
												role="button" data-bs-toggle="modal" data-bs-target="#viewModal"
												src="<?= $gallary->fileSrc; ?>" alt="<?= $gallary->fileName; ?>"
												data-src="<?= $gallary->fileSrc; ?>" data-name="<?= $gallary->fileName; ?>"
												data-mime="<?= $gallary->fileMimetype; ?>">
										</div>

										<div class="card-body px-0">
											<small class="card-text">
												<?= $gallary->fileName; ?>
											</small>
										</div>
									<?php elseif (str_starts_with($gallary->fileMimetype, 'video')): ?>
										<div class="w-100 h-100 position-relative">
											<video class="rounded-0 object-fit-cover" style="width: inherit; height: inherit;"
												role="button" data-bs-toggle="modal" data-bs-target="#viewModal"
												data-src="<?= $gallary->fileSrc; ?>" data-name="<?= $gallary->fileName; ?>"
												data-mime="<?= $gallary->fileMimetype; ?>">
												<source src="<?= $gallary->fileSrc; ?>" type="<?= $gallary->fileMimetype; ?>">
												<?= $gallary->fileName; ?>
											</video>
											<i class='bx bx-play-circle bx-lg position-absolute top-50 start-50 translate-middle white-color'
												style="pointer-events: none;"></i>
										</div>

										<div class="card-body px-0">
											<small class="card-text">
												<?= $gallary->fileName; ?>
											</small>
										</div>
									<?php elseif (str_starts_with($gallary->fileMimetype, 'audio')): ?>
										<audio class="card-img-top rounded-0" data-bs-toggle="modal" data-bs-target="#viewModal"
											data-src="<?= $gallary->fileSrc; ?>" data-name="<?= $gallary->fileName; ?>"
											data-mime="<?= $gallary->fileMimetype; ?>" controls>
											<source src="<?= $gallary->fileSrc; ?>" type="<?= $gallary->fileMimetype; ?>">
											<?= $gallary->fileName; ?>
										</audio>
										<div class="card-body px-0">
											<small class="card-text">
												<?= $gallary->fileName; ?>
											</small>
										</div>
									<?php else: ?>
										<img class="image-fluid rounded-0" src="/assets/images/file_mime_type_unknown.png"
											alt="<?= $gallary->fileName; ?>">
										<div class="card-body px-0">
											<small class="card-text">
												<?= $gallary->fileName; ?>
											</small>
										</div>
									<?php endif ?>

								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>


<div class="row my-3">
	<div class="col-12">
		<div class="card" style="max-height: 40rem;">
			<div class="card-header card-header-title">Files</div>
			<div class="card-body overflow-y-auto">
				<div class="table-responsive scrollbar">
					<table id="table" class="table table-hover overflow-y-scroll">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Name</th>
								<th scope="col">Folder Name</th>
								<th scope="col">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php if (empty($dataFiles)): ?>
								<tr class="text-center">
									<td colspan="1000">No data yet</td>
								</tr>
							<?php else: ?>
								<?php $index = 0; ?>
								<?php foreach ($dataFiles as $key => $value): ?>
									<?php $index++; ?>
									<tr>
										<th scope="row">
											<?= $index; ?>
										</th>
										<td class="pe-4 text-wrap">
											<?= $value->fileName; ?>
										</td>
										<td class="pe-4 text-wrap">
											<?= $value->folderName; ?>
										</td>
										<td class="pe-4 text-nowrap text-start">
											<?php $downloadHref = '/file-manager/' . $value->folderId . '/download/' . $value->fileId; ?>
											<a class="" href="<?= $downloadHref; ?>">
												<i class='bx bxs-download bx-sm'></i>
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- data_text -->
<?= $this->include('include/data_text'); ?>






<!-- view_modal -->
<?= $this->include('include/view_modal'); ?>



<?= $this->endSection(); ?>