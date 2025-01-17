<section class="my-4">
    <?php if (!empty(session()->getFlashData('success'))): ?>
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class='bx bxs-check-circle me-2'></i>
            <div data-anima>
                <?= session()->getFlashData('success'); ?>
            </div>
        </div>
    <?php elseif (!empty(session()->getFlashData('fail'))): ?>
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class='bx bxs-error me-2'></i>
            <div data-anima>
                <?= session()->getFlashData('fail'); ?>
            </div>
        </div>
    <?php endif; ?>
</section>