<div class="card">
	<div class="card-body">
		<h5 class="card-title mb-4">
			Testimonials
		</h5>

		<!-- Slider main container -->
		<div class="swiper">
			<!-- Additional required wrapper -->
			<div class="swiper-wrapper">
				<!-- Slides -->
				<?php foreach ($testimonials as $key => $value): ?>
					<div class="swiper-slide">
						<?php $dataImage = $value->image; ?>
						<?php $dataTestimonial = [
							'dataTestimonialImageSrc' => $dataImage->fileSrc,
							'dataTestimonialImageAlt' => $dataImage->fileName,
							'dataTestimonialName' => $value->name,
							'dataTestimonialPosition' => $value->position,
							'dataTestimonialNote' => $value->note,
						]; ?>
						<?= view_cell('\App\Cells\MainCell::testimonial', $dataTestimonial); ?>
					</div>
				<?php endforeach; ?>
				...
			</div>
			<!-- If we need pagination -->
			<div class="swiper-pagination"></div>
		</div>



	</div>

</div>