<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between">
	<div class="fw-bold fs-5 gray-color">
		<?= $title; ?>
	</div>
</div>

<?= view_cell('\App\Cells\AlertCell::alertPost'); ?>

<?php $dataCardHeader = [
	'detailsCoverImageSrc' => '/assets/images/background-image.jpg',
	'detailsCoverImageAlt' => 'Cover Image',
	'detailsAvatarIcon' => "<i class='bx bx-folder-open bx-lg white-color'></i>",
	'name' => $data->name,
	'deleteHref' => '/file-manager/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/delete',
	'updateHref' => '/file-manager/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/update',
	'buttons' => [
		'<a href="/file-manager/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/create' . '" class="btn primary-btn">New File</a>'
	],
] ?>
<?= view_cell('\App\Cells\DetailsCell::detailsCardHeader', $dataCardHeader); ?>


<div class="row g-3 my-3">
	<div class="col-md-4 col-12">
		<?php $basicRow = [
			'rows' => [
				'Name' => $data->name,
				'Type' => $data->typeValue,
				'Count' => ($dataCountFiles == 1) ? $dataCountFiles . ' File' : $dataCountFiles . ' Files',
				'Size' => $dataSumFiles,
				'Description' => $data->description,
				'Created' => $data->createdDateTime,
				'Last Modified' => $data->modifiedDateTime ?? 'Never Modified',
			],
			'height' => 50,
		] ?>
		<?= view_cell('\App\Cells\DetailsCell::basicDl', $basicRow); ?>
	</div>

	<div class="col-md-8 col-12">
		<div class="card" style="max-height: 50rem;">
			<div class="card-header card-header-title">Files</div>
			<div class="card-body overflow-y-auto">
				<?= $this->include('include/search_table'); ?>

				<div class="table-responsive scrollbar">
					<table id="table" class="table table-hover overflow-y-scroll">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Name</th>
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
										<td class="pe-4 text-nowrap text-start">
											<div class="btn-group">
												<a role="button" data-bs-toggle="dropdown" aria-expanded="false">
													<i class='bx bx-dots-horizontal bx-sm'></i>
												</a>

												<ul class="dropdown-menu rounded-0">
													<li>
														<?php $renameHref = '/file-manager/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/rename/' . \App\Libraries\SecurityLibrary::encryptUrlId($value->id); ?>
														<a class="dropdown-item" href="<?= $renameHref; ?>"
															data-href="<?= $renameHref; ?>"
															data-name="<?= esc($value->fileName); ?>" data-bs-toggle="modal"
															data-bs-target="#renameModal">Rename</a>
													</li>
													<?php if (
														str_starts_with($value->fileMimetype, 'image') ||
														str_starts_with($value->fileMimetype, 'video') ||
														str_starts_with($value->fileMimetype, 'audio')
													): ?>
														<li>
															<a class="dropdown-item" data-bs-toggle="modal"
																data-bs-target="#viewModal" data-src="<?= $value->fileSrc; ?>"
																data-name="<?= $value->fileName; ?>"
																data-mime="<?= $value->fileMimetype; ?>">View</a>
														</li>
													<?php endif; ?>
													<li>
														<a class="dropdown-item" data-bs-toggle="modal"
															data-src="<?= $value->fileSrc; ?>"
															data-name="<?= $value->fileName; ?>"
															data-mime="<?= $value->fileMimetype; ?>"
															data-size="<?= $value->fileSize; ?>"
															data-extension="<?= $value->fileExtension; ?>"
															data-added="<?= $value->createdDateTime; ?>"
															data-modified="<?= $value->fileLastModified; ?>"
															data-bs-target="#infoModal">Info</a>
													</li>
													<li>
														<?php $downloadHref = '/file-manager/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/download/' . \App\Libraries\SecurityLibrary::encryptUrlId($value->id); ?>
														<a class="dropdown-item" href="<?= $downloadHref; ?>">Download</a>
													</li>
													<li>
														<?php $deleteInfoHref = '/file-manager/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/delete/' . \App\Libraries\SecurityLibrary::encryptUrlId($value->id); ?>
														<a class="dropdown-item" href="<?= $deleteInfoHref; ?>"
															data-href="<?= $deleteInfoHref; ?>" data-bs-toggle="modal"
															data-bs-target="#deleteModal">Delete</a>
													</li>
												</ul>
											</div>
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




<!-- Rename modal -->
<div class="modal fade" id="renameModal" tabindex="-1" aria-labelledby="renameModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content rounded-0">
			<div class="modal-header border-0">
				<div class="card-header card-header-title">Rename File</div>
			</div>
			<div class="modal-body" id="renameModalBodyDiv">
				<form method="POST" id="renameModalForm">
					<div class="mb-4">
						<input type="text" name="name" id="nameModalInput" class="form-control"
							placeholder="Enter Name" />
					</div>

					<!-- Submit button -->
					<button type="submit" name="submit" class="btn primary-btn">Rename</button>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- view_modal -->
<?= $this->include('include/view_modal'); ?>

<!-- Info modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content rounded-0">
			<div class="modal-header border-0">
				<div class="card-header card-header-title">Info</div>
			</div>
			<div class="modal-body" id="infoModalBodyDiv"></div>
		</div>
	</div>
</div>

<!-- delete_modal -->
<?= $this->include('include/delete_modal'); ?>

<?= $this->endSection(); ?>