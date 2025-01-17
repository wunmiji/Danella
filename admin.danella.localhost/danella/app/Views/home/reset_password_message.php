<?= $this->extend('layouts/login'); ?>




<?= $this->section('title'); ?>
<h6>Reset Password</h6>
<?= $this->endSection(); ?>






<?= $this->section('content'); ?>

<?= view_cell('\App\Cells\AlertCell::alertPost'); ?>

<section class="my-4">
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <i class='bx bxs-check-circle me-2'></i>
        <div>
            Your password updated successfully!<br>
            <a class="fs-5 fw-bold" href="/">Click here</a> to login
        </div>
    </div>
</section>

<?= $this->endSection(); ?>