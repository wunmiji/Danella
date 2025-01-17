<div class="modal fade" id="filesModal" tabindex="-1" aria-labelledby="filesModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-centered">
		<div class="modal-content rounded-0">
			<div class="modal-header justify-content-between folders-files-modal-header">
				<div class="card-header card-header-title">Files</div>
				<button class="btn primary-btn" id="addFilesModalButton">Add</button>
			</div>
			<div class="modal-body folders-files-modal-body">
				<div class="container-fluid">
					<div class="mt-3">
						<nav aria-label="breadcrumb">
							<ol id="filesModalBreadCrumb" class="breadcrumb">
							</ol>
						</nav>
					</div>
					<div class="row">
						<div class="col-md-3 col-4 folders-modal-body">
							<small class="font-monospace">P L A C E S</small>
							<div class="d-flex flex-column row-gap-3 overflow-y-auto">
								<a id="filesModalPlacesFavourite" class="d-flex align-items-center column-gap-2 fs-6 gray-link-color">
									<i class='bx bxs-heart' style="font-size: 1.25rem;"></i>
									Favourite
								</a>
								<div id="filesModalPlaces" class="d-flex flex-column row-gap-3 ">

								</div>
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