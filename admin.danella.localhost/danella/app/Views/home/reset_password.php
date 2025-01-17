<?= $this->extend('layouts/login'); ?>




<?= $this->section('title'); ?>
<h6>Reset Password</h6>
<?= $this->endSection(); ?>




<?= $this->section('content'); ?>
<?php $validation = \Config\Services::validation(); ?>
<?= view_cell('\App\Cells\AlertCell::alertPost'); ?>


<form method="POST" action="<?= base_url('/reset-password'); ?>"
    onSubmit="document.getElementById('submit').disabled=true;">
    <?= csrf_field(); ?>


    <div class="mb-4">
        <input type="password" name="new_password" class="form-control quicksand-semibold" id="newPasswordInput"
            placeholder="New Password">
        <?php if ($validation->getError('new_password')): ?>
            <span class="text-danger text-sm">
                <?= $error = $validation->getError('new_password'); ?>
            </span>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <input type="password" name="confrim_new_password" class="form-control quicksand-semibold"
            id="confirmNewPasswordInput" placeholder="Confirm New Password">
        <?php if ($validation->getError('confrim_new_password')): ?>
            <span class="text-danger text-sm">
                <?= $error = $validation->getError('confrim_new_password'); ?>
            </span>
        <?php endif; ?>
    </div>

    <div class="d-flex flex-column align-items-center row-gap-2">
        <input type="hidden" name="tokenHidden" value="<?= esc($token); ?>">
        <button class="btn rounded-0 fs-5 primary-btn quicksand-semibold w-100" type="submit" id="submit"
            name="submit">Reset
            Password</button>
    </div>

</form>

<?= $this->endSection(); ?>