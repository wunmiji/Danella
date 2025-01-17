<!-- corousel -->
<div id="mycarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="<?= $dataCarouselImage; ?>" class="img-fluid" alt="...">
            <div class="carousel-caption">
                <div class="container">
                    <h1>
                        <?= $dataCarouselTitle; ?>
                    </h1>

                    <p>
                        <?= $dataCarouselSubTitle; ?>
                    </p>

                    <?php if (isset($dataCarouselBreadCrumb)): ?>
                        <div class="mb-lg-4">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <?php foreach ($dataCarouselBreadCrumb as $key => $value): ?>
                                        <li class="breadcrumb-item"><a href="<?= $key; ?>">
                                                <?= $value; ?>
                                            </a></li>
                                    <?php endforeach; ?>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <?= $dataCarouselBreadCrumbActive; ?>
                                    </li>
                                </ol>
                            </nav>
                        </div>

                    <?php endif; ?>

                    <div id="getAQuoteDiv" class="d-none d-lg-block carousel-get-quote-btn animate__animated animate__lightSpeedInLeft">
                        <?= view_cell('\App\Cells\MainCell::anchorElement', ['link' => '/get-quote', 'name' => 'Get a quote']); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>