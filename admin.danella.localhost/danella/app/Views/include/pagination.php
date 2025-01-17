<?php if (count($arrayPageCount) > 1): ?>
	<?php $queryLimitPagination = (isset($queryLimit)) ? '&limit=' . $queryLimit : ''; ?>
	<?php $startPagination = 1; ?>
	<?php $endPagination = count($arrayPageCount); ?>
	<div class="d-flex justify-content-between mt-3">
		<div>
			<h6>Showing <?= $queryPage; ?> of <?= $endPagination; ?> pages</h6>
		</div>
		<div class="d-flex column-gap-2">
			<?php $linksPagination = 2; ?>
			<?php $nextQueryCount = $queryPage + 1; ?>
			<?php $prevQueryCount = $queryPage - 1; ?>

			<!-- Button for previous -->
			<?php if (in_array($prevQueryCount, $arrayPageCount)): ?>
				<a class="btn primary-outline-btn" href="<?= base_url($query_url . 'page=' . $prevQueryCount . $queryLimitPagination); ?>">Previous</a>
			<?php endif; ?>

			<!-- Button for array of link -->
			<?php $startLinkPagination = (($queryPage - $linksPagination) > 0) ? $queryPage - $linksPagination : $startPagination; ?>
			<?php $endLinkPagination = (($queryPage + $linksPagination) < $endPagination) ? $queryPage + $linksPagination : $endPagination; ?>

			<?php if ($startPagination != $startLinkPagination): ?>
				<a class="btn primary-outline-btn" href="<?= base_url($query_url . 'page=' . $startPagination . $queryLimitPagination) ?>"><?= $startPagination; ?></a>
				<a class="btn primary-outline-btn" style="cursor: default;">...</a>
			<?php endif; ?>
			<?php for ($i = $startLinkPagination; $i <= $endLinkPagination; $i++): ?>
				<?php $value = $i; ?>
				<a class="btn <?= ($queryPage == $value) ? 'primary-btn' : 'primary-outline-btn' ?> " href="<?= base_url($query_url . 'page=' . $value . $queryLimitPagination) ?>"><?= $value; ?></a>
			<?php endfor; ?>
			<?php if ($endPagination != $endLinkPagination): ?>
				<a class="btn primary-outline-btn" style="cursor: default;">...</a>
				<a class="btn primary-outline-btn" href="<?= base_url($query_url . 'page=' . $endPagination. $queryLimitPagination) ?>"><?= $endPagination; ?></a>
			<?php endif; ?>

			<!-- Button for next -->
			<?php if (in_array($nextQueryCount, $arrayPageCount)): ?>
				<a class="btn primary-outline-btn" href="<?= base_url($query_url . 'page=' . $nextQueryCount . $queryLimitPagination) ?>">Next</a>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>