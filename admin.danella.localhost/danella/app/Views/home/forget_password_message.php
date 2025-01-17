<?= $this->extend('layouts/login'); ?>




<?= $this->section('title'); ?>
<h6>Forget Password</h6>
<?= $this->endSection(); ?>






<?= $this->section('content'); ?>

<?= view_cell('\App\Cells\AlertCell::alertPost'); ?>

<section class="my-4">
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <i class='bx bxs-check-circle me-2'></i>
        <div>Password reset link sent successfully!</div>
    </div>
</section>

<?= $this->endSection(); ?>