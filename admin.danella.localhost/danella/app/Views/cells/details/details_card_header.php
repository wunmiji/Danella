<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header position-relative rounded-0 p-0 details-card-header">
                <div class="details-cover-image">
                    <img class="object-fit-cover h-100 w-100" src="<?= $detailsCoverImageSrc ?>"
                        alt="<?= $detailsCoverImageAlt ?>">
                </div>

                <?php if (isset($detailsAvatarImageSrc)): ?>
                    <div class="details-avatar-image mb-3 ms-3">
                        <img class="object-fit-cover h-100 w-100" src="<?= $detailsAvatarImageSrc ?>"
                            alt="<?= $detailsAvatarImageAlt; ?>">
                    </div>
                <?php elseif (isset($detailsAvatarIcon)): ?>
                    <div
                        class="details-avatar-image mb-3 ms-3 d-flex justify-content-center align-items-center primary-lighter-rgba">
                        <?= $detailsAvatarIcon; ?>
                    </div>
                <?php endif ?>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-2">
                            <h3>
                                <?= $name; ?>
                            </h3>
                            <?php if (isset($status)): ?>
                                <?php if ($status): ?>
                                    <span class="badge text-bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge text-bg-danger">Inactive</span>
                                <?php endif ?>
                            <?php endif ?>
                        </div>
                        <div class="d-flex flex-wrap column-gap-3 row-gap-3">
                            <?php if (isset($updateHref)): ?>
                                <a href="<?= $updateHref; ?>" class="btn primary-btn">Update</a>
                            <?php endif; ?>

                            <?php if (isset($statusHref)): ?>
                                <a type="button" href="<?= $statusHref; ?>" class="btn primary-btn" data-bs-toggle="modal"
                                    data-bs-target="#statusModal">
                                    <?= ($status) ? 'Inactive' : 'Active'; ?>
                                </a>
                            <?php endif; ?>

                            <?php if (isset($deleteHref)): ?>
                                <a type="button" href="<?= $deleteHref; ?>" class="btn primary-btn"
                                    data-href="<?= $deleteHref; ?>" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    Delete
                                </a>
                            <?php endif; ?>


                            <?php if (isset($buttons)): ?>
                                <?php foreach ($buttons as $value): ?>
                                    <?= $value; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Delete Modal -->
<?php if (isset($deleteHref)): ?>
    <?= $this->include('include/delete_modal'); ?>
<?php endif; ?>

<!-- Status Modal -->
<?php if (isset($statusHref)): ?>
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header border-0 pt-5 pb-3 m-auto">
                    <i class='bx bx-shocked bx-flashing bx-lg' style="color: #fdc683;"></i>
                </div>
                <div class="modal-body text-center">
                    <h2>Are you certain?</h2>
                    <p>Get ready for a major status update.</p>
                </div>
                <div class="modal-footer border-0 m-auto">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No, Am not!</button>
                    <a href="<?= $statusHref; ?>" type="button" class="btn btn-success">Yes, Am certian!</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>