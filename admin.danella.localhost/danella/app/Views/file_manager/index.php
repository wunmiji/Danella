<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between">
	<div class="fw-bold fs-5 gray-color">
		<?= $title; ?>
	</div>
	<div><a href="/file-manager/create" class="btn primary-btn">New Folder</a></div>
</div>

<?= view_cell('\App\Cells\AlertCell::alertPost'); ?>

<div class="pt-4 row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<div class="card-form-title">Space</div>

				<div class="row row-cols-md-3 row-cols-1">
					<div class="col">
						<span class="fw-semibold me-2">Total Space</span>
						<span class="text-capitalize"><?= $totalSpaceFormat; ?></span>
					</div>

					<div class="col">
						<span class="fw-semibold me-2">Used Space</span>
						<span class="text-capitalize"><?= $usedSpaceFormat; ?></span>
					</div>

					<div class="col">
						<span class="fw-semibold me-2">Free Space</span>
						<span class="text-capitalize"><?= $freeSpaceFormat; ?></span>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>



<div class="pt-4 row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<?= $this->include('include/search_table_and_pagination_limit'); ?>

				<div class="table-responsive scrollbar">
					<table id="table" class="table table-hover">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Name</th>
								<th scope="col">Type</th>
								<th scope="col">Details</th>
							</tr>
						</thead>
						<tbody>
							<?php if (empty($data)): ?>
								<tr class="text-center">
									<td colspan="1000">No data yet</td>
								</tr>
							<?php else: ?>
								<?php $index = ($queryPage - 1) * $queryLimit; ?>
								<?php foreach ($data as $key => $value): ?>
									<?php $index++; ?>
									<tr>
										<th scope="row">
											<?= $index; ?>
										</th>
										<td class="pe-4 text-nowrap">
											<?= $value->name; ?>
										</td>
										<td class="pe-4 text-wrap">
											<?= $value->typeValue; ?>
										</td>
										<td class="pe-4 text-nowrap"><a href="file-manager/<?= \App\Libraries\SecurityLibrary::encryptUrlId($value->id); ?>"
												class="btn primary-btn">Details</a></td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
				</div>

				<?= $this->include('include/pagination'); ?>
			</div>
		</div>
	</div>
</div>


<?= $this->endSection(); ?>