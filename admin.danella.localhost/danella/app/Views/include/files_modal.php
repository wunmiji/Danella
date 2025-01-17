<div class="modal fade" id="filesModal" tabindex="-1" aria-labelledby="filesModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-centered">
		<div class="modal-content rounded-0">
			<div class="modal-header justify-content-between folders-files-modal-header">
				<div class="card-header card-header-title">Files</div>
				<button class="btn primary-btn" id="addFilesModalButton">Add</button>
			</div>
			<div class="modal-body folders-files-modal-body">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-3 col-4 folders-modal-body">
							<div class="overflow-y-auto py-3">
								<?php if (empty($folders)): ?>
									<small>No data yet</small>
								<?php else: ?>
									<?php foreach ($folders as $folder): ?>
										<div class="gray-link-color">
											<a class="modal-sidebar-icons folders-modal-body-link"
												data-folder="<?= esc(json_encode($folder->files)); ?>">
												<i class='bx bx-folder bx-sm'></i>
												<span><?= $folder->name; ?></span>
											</a>
										</div>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
						</div>

						<div class="col-md-9 col-8 overflow-y-auto p-3">
							<div class="row row-cols-lg-4 row-cols-md-3 g-4" id="filesModalBodyDiv">

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>