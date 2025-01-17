<?= $this->extend('layouts/default'); ?>

<?= $this->section('corousel'); ?>

<!-- corousel-section -->
<?php $dataCarousel = [
	'dataCarouselImage' => '/assets/images/contact-featured-area.jpg',
	'dataCarouselTitle' => 'Get in Touch',
	'dataCarouselSubTitle' => 'Stay connected, stay informed, and stay in touch with us.',
	'dataCarouselBreadCrumb' => ['/' => 'Home'],
	'dataCarouselBreadCrumbActive' => 'Contact',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>


<?= $this->section('content'); ?>

<!-- conatact-labels-section -->
<section class="mb-5">
	<div class="container contact-first">
		<div class="row row-cols-lg-4 row-cols-md-2 row-cols-1 g-4">
			<div class="col">
				<div class="card h-100 text-center">
					<div class="card-header">
						<i class='bx bx-current-location bx-lg'></i>
					</div>
					<div class="card-body">
						<div class="card-title">Address</div>
					</div>
					<div class="card-footer pb-3">
						<span>
							<?= $information['address']; ?>
						</span>
					</div>

				</div>
			</div>

			<div class="col">
				<div class="card h-100 text-center">
					<div class="card-header">
						<i class='bx bx-phone-call bx-lg'></i>
					</div>
					<div class="card-body">
						<div class="card-title">Call</div>
					</div>
					<div class="card-footer d-flex flex-column pb-3">
						<?php foreach ($information['call'] as $key => $value): ?>
							<span>
								<?= $value; ?>
							</span>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

			<div class="col">
				<div class="card h-100 text-center">
					<div class="card-header">
						<i class='bx bx-envelope bx-lg'></i>
					</div>
					<div class="card-body">
						<div class="card-title">Email</div>
					</div>
					<div class="card-footer d-flex flex-column pb-3">
						<?php foreach ($information['email'] as $key => $value): ?>
							<span>
								<?= $value; ?>
							</span>
						<?php endforeach; ?>
					</div>
				</div>

			</div>

			<div class="col">
				<div class="card h-100 text-center">
					<div class="card-header">
						<i class='bx bx-time bx-lg'></i>
					</div>
					<div class="card-body">
						<div class="card-title">Working Time</div>
					</div>
					<div class="card-footer d-flex flex-column pb-3">
						<?php foreach ($information['working'] as $key => $value): ?>
							<span>
								<?= $value; ?>
							</span>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

</section>

<!-- conatact-form-section -->
<section class="mb-5">
	<div class="container contact-second">
		<div class="row row-cols-1">
			<div class="col">
				<div class="card p-3">
					<div class="row g-0">
						<div class="col-lg-5 d-none d-lg-block">
							<img src="<?= base_url('/assets/images/contact-mail.png'); ?>"
								class="img-fluid rounded-start" alt="...">
						</div>
						<div class="col-lg-7">
							<div class="card-body">
								<h5 class="card-title fw-bold mb-4">Let's Get in Touch</h5>

								<?= view_cell('\Cells\AlertCell::contact'); ?>
								<?php $validation = \Config\Services::validation(); ?>
								<form action="<?= base_url('contact'); ?>" method="POST">
									<div class="row row-cols-1">
										<div class="col mb-4">
											<input type="text" class="form-control p-3 quicksand-semibold"
												id="nameInput" placeholder="Name" name="name">
											<?php if ($validation->getError('name')): ?>
												<span class="text-danger text-sm">
													<?= $error = $validation->getError('name'); ?>
												</span>
											<?php endif; ?>
										</div>

										<div class="col mb-4">
											<input type="email" class="form-control p-3 quicksand-semibold"
												id="emailInput" placeholder="Email" name="email">
											<?php if ($validation->getError('email')): ?>
												<span class="text-danger text-sm">
													<?= $error = $validation->getError('email'); ?>
												</span>
											<?php endif; ?>
										</div>

										<div class="col mb-4">
											<input type="text" class="form-control p-3 quicksand-semibold"
												id="subjectInput" placeholder="Subject" name="subject">
											<?php if ($validation->getError('subject')): ?>
												<span class="text-danger text-sm">
													<?= $error = $validation->getError('subject'); ?>
												</span>
											<?php endif; ?>
										</div>

										<div class="col mb-4">
											<textarea class="form-control p-3 quicksand-semibold" name="message"
												id="exampleFormControlTextarea1" rows="5"
												placeholder="Message"></textarea>
											<?php if ($validation->getError('message')): ?>
												<span class="text-danger text-sm">
													<?= $error = $validation->getError('message'); ?>
												</span>
											<?php endif; ?>
										</div>

										<div class="col">
											<button type="submit" name="submit"
												class="btn rounded-0 fs-5 primary-btn">Submit</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- map-section -->
<section class="mb-5">
	<div class="contact-third">
		<iframe
			src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.696277357874!2d3.346459767561772!3d6.559970330830981!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b8dfa4ce11487%3A0x326ec2bbcd6ad11!2s58%20Brown%20St%2C%20Mafoluku%20Oshodi%2C%20Lagos%20102214%2C%20Lagos!5e0!3m2!1sen!2sng!4v1710272911001!5m2!1sen!2sng"
			style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
	</div>
</section>

<?= $this->endSection(); ?>