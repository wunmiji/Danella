<?= $this->include('include/header'); ?>

<main>
    <section class="mb-5">
        <?= $this->renderSection('corousel'); ?>
    </section>
    <?= $this->renderSection('content') ?>
</main>

<?= $this->include('include/footer'); ?>