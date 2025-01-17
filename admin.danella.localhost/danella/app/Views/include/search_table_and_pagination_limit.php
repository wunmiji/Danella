<div class="d-flex justify-content-between">
    <div class="w-100">
        <?= $this->include('include/search_table'); ?>
    </div>
    <div>
        <select class="form-select" id="paginationLimit" onchange="location = this.value;"
            aria-label="Default select example">
            <option disabled>Limit</option>
            <?php foreach ($paginationLimitArray as $value): ?>
                <option value="<?= base_url($query_url . 'page=' . $queryPage . '&limit=' . $value); ?>"
                    <?= ($value == $queryLimit) ? 'selected' : ''; ?>><?= $value; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>