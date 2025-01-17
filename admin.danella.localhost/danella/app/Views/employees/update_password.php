<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between">
    <div class="fw-bold fs-5 gray-color">
        <?= $title; ?>
    </div>
</div>

<?= view_cell('\App\Cells\AlertCell::alertPost'); ?>

<div class="pt-4 row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <?php $validation = \Config\Services::validation(); ?>
                <form method="POST" action="<?= base_url('employees/' . \App\Libraries\SecurityLibrary::encryptUrlId($employee_password->id) . '/update_password'); ?>"
                    onSubmit="document.getElementById('submit').disabled=true;">
                    <?= csrf_field(); ?>

                    <div>
                        <div class="card-form-title">Password</div>

                        <div class="mb-4">
                            <input type="password" name="new_password" class="form-control" id="newPasswordInput"
                                placeholder="New Password">
                            <?php if ($validation->getError('new_password')): ?>
                                <span class="text-danger text-sm">
                                    <?= $error = $validation->getError('new_password'); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <input type="password" name="confrim_new_password" class="form-control"
                                id="confirmNewPasswordInput" placeholder="Confirm New Password">
                            <?php if ($validation->getError('confrim_new_password')): ?>
                                <span class="text-danger text-sm">
                                    <?= $error = $validation->getError('confrim_new_password'); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>


                    <!-- Submit button -->
                    <button type="submit" name="submit" id="submit" class="btn primary-btn">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>