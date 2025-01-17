<?= $this->extend('layouts/default_sidebar'); ?>

<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<?php $dataCarousel = [
	'dataCarouselImage' => '/assets/images/get-a-quote-featured-area.jpg',
	'dataCarouselTitle' => 'Request a quotation',
	'dataCarouselSubTitle' => $description,
	'dataCarouselBreadCrumb' => ['/' => 'Home'],
	'dataCarouselBreadCrumbActive' => 'Get a quote',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>





<!-- main-section -->
<?= $this->section('content'); ?>

<!-- get-a-quote -->
<div class="get-quote-container">
	<div class="card">
		<div class="card-body">
			<div class="card-title">
				Get a Quote
			</div>
			<p class="card-text">This marks a commendable initial stride.
				Feel free to inquire about any of our services.
				We assure you that we will respond promptly within one. </p>
			<div>
				<?= view_cell('\Cells\AlertCell::contact'); ?>
				<?php $validation = \Config\Services::validation(); ?>
				<form action="<?= base_url('get-quote'); ?>" method="POST">
					<div class="mb-4">
						<input type="text" class="form-control p-3" id="nameInput" placeholder="Name" name="name">
						<?php if ($validation->getError('name')): ?>
							<small class="text-danger text-sm">
								<?= $error = $validation->getError('name'); ?>
							</small>
						<?php endif; ?>
					</div>

					<div class="mb-4">
						<input type="email" class="form-control p-3" id="emailInput" placeholder="Email" name="email">
						<?php if ($validation->getError('email')): ?>
							<small class="text-danger text-sm">
								<?= $error = $validation->getError('email'); ?>
							</small>
						<?php endif; ?>
					</div>

					<div class="row mb-4 row-gap-4">
						<div class="col-md-6 col-12">
							<input type="text" class="form-control p-3" id="companyNameInput" placeholder="Company Name"
								name="company_name">
							<?php if ($validation->getError('company_name')): ?>
								<small class="text-danger text-sm">
									<?= $error = $validation->getError('company_name'); ?>
								</small>
							<?php endif; ?>
						</div>

						<div class="col-md-6 col-12">
							<input type="tel" class="form-control p-3" id="phoneInput" placeholder="Phone Number"
								name="phone">
							<?php if ($validation->getError('phone')): ?>
								<small class="text-danger text-sm">
									<?= $error = $validation->getError('phone'); ?>
								</small>
							<?php endif; ?>
						</div>
					</div>

					<div class="mb-4">
						<div class="services">
							<label class="form-label">Services we offer</label>
							<div class="row row-cols-md-2 row-cols-1">
								<?php foreach ($services as $key => $service): ?>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="<?= $service->name; ?>"
											id="flexCheckDefault" name="services[]">
										<label class="form-check-label" for="flexCheckDefault">
											<?= $service->name; ?>
										</label>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<div class="mb-4">
						<textarea class="form-control p-3" name="message" id="messageTextarea" rows="5"
							placeholder="Kindly summarize your work or project..."></textarea>
						<?php if ($validation->getError('message')): ?>
							<small class="text-danger text-sm">
								<?= $error = $validation->getError('message'); ?>
							</small>
						<?php endif; ?>
					</div>

					<div>
						<button type="submit" name="submit" class="btn rounded-0 fs-5 primary-btn">
							Submit</button>
					</div>

				</form>
			</div>
		</div>

	</div>
</div>

<script>
	const getAQuoteDiv = document.getElementById('getAQuoteDiv');
	getAQuoteDiv.classList.remove("d-lg-block");
</script>

<?= $this->endSection(); ?>





<!-- sidebar -->
<?= $this->section('sidebar'); ?>

<?= $this->include('include/testimonial_swiper'); ?>

<?= $this->include('include/get_in_touch'); ?>

<?= $this->endSection(); ?>