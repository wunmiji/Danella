<?= $this->extend('layouts/login'); ?>




<?= $this->section('title'); ?>
<h6>Forget Password</h6>
<?= $this->endSection(); ?>






<?= $this->section('content'); ?>
<?php $validation = \Config\Services::validation(); ?>
<?= view_cell('\App\Cells\AlertCell::alertPost'); ?>


<form method="POST" action="<?= base_url('/forget-password'); ?>"
    onSubmit="document.getElementById('submit').disabled=true;">
    <?= csrf_field(); ?>

    <div class="mb-4">
        <input type="email" class="form-control p-3 quicksand-semibold" name="email" value="<?= set_value('email'); ?>"
            placeholder="Email">
        <?php if ($validation->getError('email')): ?>
            <span class="text-danger text-sm">
                <?= $error = $validation->getError('email'); ?>
            </span>
        <?php endif; ?>
    </div>

    <div class="d-flex flex-column align-items-center row-gap-2">
        <button class="btn rounded-0 fs-5 primary-btn quicksand-semibold w-100" type="submit" id="submit"
            name="submit">Send
            Reset Link</button>
    </div>

</form>

<?= $this->endSection(); ?>