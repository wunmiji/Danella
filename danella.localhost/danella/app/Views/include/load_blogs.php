<?php if (isset($blogs))
    $data = $blogs; ?>
<?php foreach ($data as $value): ?>
    <div class="col">
        <div class="card h-100">
            <div class="card-img-top">
                <?php $dataImage = $value->image ?>
                <img src="<?= $dataImage->fileSrc; ?>" class="card-img-top" alt="<?= $dataImage->fileName; ?>">
            </div>
            <div class="card-body h-100 d-flex flex-column">
                <small data-anima class="fw-semibold primary-text-color">
                    <?= $value->publishedDate; ?>
                </small>
                <a data-anima href="/blog/<?= $value->slug; ?>" class="card-title fs-3 lh-sm fw-semibold">
                    <?= $value->title; ?>
                </a>
                <h6 data-anima style="-webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; display: -webkit-box;"><?= $value->summary; ?></h6>
            </div>
        </div>
    </div>
<?php endforeach; ?>

