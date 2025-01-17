<div class="card" style="height: <?= $height; ?>rem;">
    <div class="card-header card-header-title">Basic</div>
    <div class="card-body overflow-y-auto">
        <dl class="d-flex flex-column row-gap-3">
            <?php foreach ($rows as $key => $value): ?>
                <div>
                    <dt>
                        <?= $key; ?>
                    </dt>
                    <dd>
                        <?= $value; ?>
                    </dd>
                </div>
            <?php endforeach; ?>
        </dl>
    </div>
</div>