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
	'detailsAvatarIcon' => "<i class='bx bx-folder bx-lg white-color'></i>",
	'name' => 'File Manager',
] ?>
<?= view_cell('\App\Cells\DetailsCell::detailsCardHeader', $dataCardHeader); ?>



<div class="row g-3 my-2">
	<div class="col">
		<div class="card" style="max-height: 70rem;">
			<div class="card-header card-header-title">Modal Single Example</div>
			<div class="card-body">
				<div class="single-file-upload">
					<div class="drop-zone py-5 text-center" id="dropzone"
						data-file-manager="<?= esc($dataFileManagerPrivateId); ?>" data-output="div-uploaded-file"
						data-multiple="true" data-bs-toggle="modal" data-bs-target="#filesModal">
						<i class='bx bx-cloud-upload fs-1'></i>
						<p class="fs-6" id="fileText"></p>
					</div>
					<div id="div-uploaded-file"></div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="row g-3 my-2">
	<div class="col">
		<div class="card" style="max-height: 70rem;">
			<div class="card-header d-flex justify-content-between">
				<div class="card-header-title">Explorer</div>
				<?php if (
					$dataFileManagerPrivateId != $dataPrivateId &&
					'Trash' != $dataPrivateId &&
					'Favourite' != $dataPrivateId
				): ?>
					<div class="d-flex column-gap-3">
						<a href="/file-managerr/<?= $dataPrivateId; ?>/create-folder" title="Add Folder"
							class="d-flex gray-link-color"><i class="bx bx-folder-plus bx-sm align-self-end"></i></a>
						<a href="/file-managerr/<?= $dataPrivateId; ?>/create-file" title="Add File"
							class="d-flex gray-link-color"><i class="bx bxs-file-plus bx-sm align-self-end"></i></a>
					</div>
				<?php endif; ?>

			</div>
			<div class="card-body overflow-y-auto">
				<div>
					<?php $breadCrumbLastElement = array_pop($dataBreadCrumbArray); ?>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<?php foreach ($dataBreadCrumbArray as $key => $value): ?>
								<li class="breadcrumb-item">
									<a class="py-1 px-2" style="background-color: rgba(185, 187, 189, 0.2);"
										href="/file-managerr/<?= $key; ?>"><?= $value; ?></a>
								</li>
							<?php endforeach; ?>
							<li class="breadcrumb-item active" aria-current="page"><?= $breadCrumbLastElement; ?></li>
						</ol>
					</nav>
				</div>
				<div class="row">
					<div class="col-md-3 col-4">
						<div class="d-flex flex-column row-gap-4">
							<div>
								<small class="font-monospace">P L A C E S</small>
								<div class="d-flex flex-column row-gap-3 mt-2">
									<a href="/file-managerr/Favourite"
										class="d-flex align-items-center column-gap-2 fs-6 gray-link-color">
										<i class='bx bxs-heart' style="font-size: 1.25rem;"></i>
										Favourite
									</a>
									<?php foreach ($places as $key => $value): ?>
										<a href="/file-managerr/<?= $value->privateId; ?>"
											class="d-flex align-items-center column-gap-2 fs-6 gray-link-color">
											<?php $fileManagerIcon = ''; ?>
											<?php if ($value->name == 'Home')
												$fileManagerIcon = 'bx-home'; ?>
											<?php if ($value->name == 'Documents')
												$fileManagerIcon = 'bx-file'; ?>
											<?php if ($value->name == 'Videos')
												$fileManagerIcon = 'bxs-videos'; ?>
											<?php if ($value->name == 'Pictures')
												$fileManagerIcon = 'bx-images'; ?>
											<i class='bx <?= $fileManagerIcon; ?>' style="font-size: 1.25rem;"></i>
											<?= $value->name; ?>
										</a>
									<?php endforeach; ?>
									<a href="/file-managerr/Trash"
										class="d-flex align-items-center column-gap-2 fs-6 gray-link-color">
										<i class='bx bxs-trash' style="font-size: 1.25rem;"></i>
										Trash
									</a>
								</div>
							</div>

						</div>

					</div>
					<div class="col-md-9 col-8">
						<?php if ($dataFileManagerPrivateId == $dataPrivateId): ?>
							<div>Later things</div>
						<?php else: ?>
							<div class="table-responsive">
								<table id="table" class="table table-hover">
									<thead>
										<tr>
											<th scope="col">#</th>
											<th scope="col">Name</th>
											<th scope="col">Size</th>
											<?php if ($dataPrivateId != 'Trash'): ?>
												<th scope="col">Favourite</th>
											<?php endif; ?>
											<th scope="col">Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php if (empty($datas)): ?>
											<tr class="text-center">
												<td colspan="1000">No data yet</td>
											</tr>
										<?php else: ?>
											<?php $index = 0; ?>
											<?php foreach ($datas as $key => $value): ?>
												<?php $index++; ?>
												<tr>
													<th scope="row">
														<?= $index; ?>
													</th>
													<td class="pe-4 text-wrap">
														<?php if ($value->isDirectory): ?>
															<a class="" href="/file-managerr/<?= $value->privateId ?>">
																<?= $value->name; ?>
															</a>
														<?php else: ?>
															<?= $value->name; ?>
														<?php endif; ?>
													</td>
													<td scope="row">
														<?= esc($value->size); ?>
													</td>
													<?php if ($dataPrivateId != 'Trash'): ?>
														<th scope="row">
															<a href="/file-managerr/<?= $value->privateId; ?>/favourite">
																<?php if ($value->isFavourite): ?>
																	<i class='bx bxs-heart' style="font-size: 1.25rem;"></i>
																<?php else: ?>
																	<i class='bx bx-heart' style="font-size: 1.25rem;"></i>
																<?php endif; ?>
															</a>
														</th>
													<?php endif; ?>
													<td class="pe-4 text-nowrap text-start">
														<div class="btn-group">
															<a role="button" data-bs-toggle="dropdown" aria-expanded="false">
																<i class='bx bx-dots-horizontal bx-sm'></i>
															</a>

															<ul class="dropdown-menu rounded-0">
																<?php if ($dataPrivateId == 'Trash'): ?>
																	<li>
																		<a class="dropdown-item"
																			href="/file-managerr/<?= $value->privateId; ?>/restore">Restore</a>
																	</li>
																<?php endif; ?>
																<?php if ($value->isDirectory): ?>
																	<li>
																		<a class="dropdown-item"
																			href="/file-managerr/<?= $value->privateId; ?>/update-folder">Update</a>
																	</li>
																<?php else: ?>
																	<?php if (
																		str_starts_with($value->mimetype, 'image') ||
																		str_starts_with($value->mimetype, 'video') ||
																		str_starts_with($value->mimetype, 'audio')
																	): ?>
																		<li>
																			<a class="dropdown-item" data-bs-toggle="modal"
																				data-bs-target="#viewModal"
																				data-src="<?= $value->urlPath; ?>"
																				data-name="<?= $value->name; ?>"
																				data-mime="<?= $value->mimetype; ?>">View</a>
																		</li>
																	<?php endif; ?>
																	<?php if ($dataPrivateId != 'Trash'): ?>
																		<li>
																			<?php $renameHref = '/file-managerr/' . $value->privateId . '/rename'; ?>
																			<a class="dropdown-item" href="<?= $renameHref; ?>"
																				data-href="<?= $renameHref; ?>"
																				data-name="<?= esc($value->name); ?>" data-bs-toggle="modal"
																				data-bs-target="#renameModal">Rename</a>
																		</li>
																	<?php endif; ?>
																	<li>
																		<?php $downloadHref = '/file-managerr/' . $value->privateId . '/download'; ?>
																		<a class="dropdown-item"
																			href="<?= $downloadHref; ?>">Download</a>
																	</li>
																<?php endif; ?>
																<li>
																	<?php
																	$parentPathValueArray = explode('/', esc($value->parentPath));
																	array_shift($parentPathValueArray);
																	$fileManagerValue = ucwords(str_replace("-", " ", array_shift($parentPathValueArray)));
																	array_unshift($parentPathValueArray, $fileManagerValue);
																	$parentPathValue = implode('/', $parentPathValueArray);
																	?>
																	<a class="dropdown-item" data-bs-toggle="modal"
																		data-src="<?= esc($value->urlPath); ?>"
																		data-name="<?= esc($value->name); ?>"
																		data-description="<?= esc($value->description); ?>"
																		data-mime="<?= esc($value->mimetype); ?>"
																		data-size="<?= esc($value->size); ?>"
																		data-parent-path="<?= $parentPathValue; ?>"
																		data-is-directory="<?= esc($value->isDirectory); ?>"
																		data-extension="<?= esc($value->extension); ?>"
																		data-added="<?= esc($value->createdDateTime); ?>"
																		data-modified="<?= esc($value->lastModified); ?>"
																		data-bs-target="#infoModal">Info</a>
																</li>
																<?php if ($dataPrivateId == 'Trash'): ?>
																	<li>
																		<?php $deleteHref = '/file-managerr/' . $value->privateId . '/delete/'; ?>
																		<a class="dropdown-item" href="<?= $deleteHref; ?>"
																			data-href="<?= $deleteHref; ?>" data-bs-toggle="modal"
																			data-bs-target="#deleteModal">Delete</a>
																	</li>
																<?php elseif ($dataPrivateId != 'Trash'): ?>
																	<li>
																		<a class="dropdown-item"
																			href="/file-managerr/<?= $value->privateId; ?>/trash">Trash</a>
																	</li>
																<?php endif; ?>
															</ul>
														</div>
													</td>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>
									</tbody>
								</table>
							</div>
						<?php endif; ?>
					</div>
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

<!-- files_modal -->
<?= $this->include('include/filess_modal'); ?>

<?= $this->endSection(); ?>