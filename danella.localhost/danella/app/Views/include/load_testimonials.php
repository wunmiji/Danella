<?php if (isset($testimonials)) $data = $testimonials; ?>
<?php foreach ($data as $key => $value): ?>
    <?php $dataImage = $value->image; ?>
    <div class="col">
        <div class="card h-100">
            <div class="card-body">
                <?php $dataTestimonial = [
                    'dataTestimonialImageSrc' => $dataImage->fileSrc,
                    'dataTestimonialImageAlt' => $dataImage->fileName,
                    'dataTestimonialName' => $value->name,
                    'dataTestimonialPosition' => $value->position,
                    'dataTestimonialNote' => $value->note,
                ]; ?>
                <?= view_cell('\App\Cells\MainCell::testimonial', $dataTestimonial); ?>
            </div>

        </div>
    </div>
<?php endforeach; ?>