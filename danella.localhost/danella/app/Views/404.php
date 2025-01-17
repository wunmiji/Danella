<?= $this->extend('layouts/default'); ?>

<?= $this->section('corousel'); ?>

<!-- corousel-section -->
<?php $dataCarousel = [
	'dataCarouselImage' => '/assets/images/error-featured-area.jpg',
	'dataCarouselTitle' => 'Oops, we couldn\'t <br> find the page',
	'dataCarouselSubTitle' => "It seems the page that you're looking for doesn't exist. </br>Let's get you back to home",
	'dataCarouselBreadCrumb' => ['/' => 'Home'],
	'dataCarouselBreadCrumbActive' => '404 Error',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>


<?= $this->section('content'); ?>

<!-- 404-section -->
<section class="mb-5">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-5 col-md-6 col-sm-8 col-8">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <img src="/assets/images/error-img.png" class="img-fluid mb-5" alt="Error 404 Page Image">
                    <a class="btn rounded-0 fs-5 primary-btn" href="/">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>