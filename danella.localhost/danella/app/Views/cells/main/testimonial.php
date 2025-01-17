<!-- testimonial -->
<div>
    <div class="d-flex align-items-end">
        <div class="flex-shrink-0">
            <img src="<?= $dataTestimonialImageSrc; ?>" alt="<?= $dataTestimonialImageAlt; ?>"
                style="width: 80px; height: 80px;">
        </div>
        <div class="flex-grow-1 ms-2 text-start">
            <h5 data-anima class="card-title mb-2 fw-semibold">
                <?= $dataTestimonialName; ?>
            </h5>
            <small data-anima class="fw-semibold">
                <?= $dataTestimonialPosition; ?>
            </small>
        </div>
    </div>
    <div class="card-text mt-4 mb-3 position-relative">
        <div data-anima>
            <?= $dataTestimonialNote; ?>
        </div>
        <div class="position-absolute bottom-0 end-0 z-0 opacity-25">
            <i class='bx bxs-quote-right bx-lg'></i>
        </div>
    </div>
</div>