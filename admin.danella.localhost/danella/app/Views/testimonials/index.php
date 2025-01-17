<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between">
	<div class="fw-bold fs-5 gray-color">
		<?= $title; ?>
	</div>
	<div><a href="/testimonials/create" class="btn primary-btn">New Testimonial</a></div>
</div>


<?= view_cell('\App\Cells\AlertCell::alertPost'); ?>

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
								<th scope="col">Position</th>
								<th scope="col">Status</th>
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
											<?= $value->position; ?>
										</td>
										<td class="pe-4 text-nowrap">
											<?php if ($value->status): ?>
												<span class="badge text-bg-success">Active</span>
											<?php else: ?>
												<span class="badge text-bg-danger">Inactive</span>
											<?php endif ?>
										</td>
										<td class="pe-4 text-nowrap"><a href="testimonials/<?= \App\Libraries\SecurityLibrary::encryptUrlId($value->id); ?>"
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