<?= $this->include('include/header'); ?>

<main>
    <section class="mb-5">
        <?= $this->renderSection('corousel'); ?>
    </section>

    <section class="mb-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-8 col-12 d-flex flex-column row-gap-5">
                    <?= $this->renderSection('content') ?>
                </div>

                <div class="col-md-4 col-12 d-flex flex-column row-gap-5">
                    <?= $this->renderSection('sidebar') ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?= $this->include('include/footer'); ?>