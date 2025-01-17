<?php foreach ($data as $key => $value): ?>
    <?php $index++; ?>
    <?php $dataImage = $value->image; ?>
    <div class="col">
        <!-- project -->
        <div class="project-col">
            <div class="bg-success position-relative" style="height: 400px; width: 100%;">
                <div>
                    <img src="<?= $dataImage->fileSrc; ?>" class="object-fit-cover" alt="<?= $dataImage->fileName; ?>">
                </div>

                <div class="project-col-overlay">
                    <small class="fw-semibold">
                        <?= sprintf('%02d', $index); ?> - P R O J E C T
                    </small>
                    <div>
                        <a href="/projects/<?= $value->slug; ?>" class="fs-4 fw-semibold">
                            <?= $value->name; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>