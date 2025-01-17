<?= $this->extend('layouts/default_sidebar'); ?>

<?= $this->section('corousel'); ?>

<!-- corousel-section -->
<?php $dataCarousel = [
	'dataCarouselImage' => '/assets/images/services-featured-area.jpg',
	'dataCarouselTitle' => 'Driving Towards a <br> Renewable-Powered Future',
	'dataCarouselSubTitle' => 'Some representative placeholder content for the third slide of this carousel.',
	'dataCarouselBreadCrumb' => ['/' => 'Home', '/blog' => 'Blog'],
	'dataCarouselBreadCrumbActive' => $data->title,
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>
<?= $this->endSection(); ?>


<!-- service-details-section -->
<?= $this->section('content'); ?>

<?= $this->include('include/main_details'); ?>

<div class="card">
	<div class="card-body">
		<h5 class="card-title fw-bold mb-4">Blog Author</h5>
		<div class="d-flex flex-sm-nowrap flex-wrap gap-3">
			<div class="flex-shrink-0">
				<img src="<?= $dataAuthor->fileSrc; ?>" class="object-fit-cover" alt="<?= $dataAuthor->fileName ?>"
					style="width: 100px; height: 100px;">
			</div>
			<div class="flex-grow-1">
				<h4 class="text-break"><?= $dataAuthor->name; ?></h4>
				<h6 class="text-break"><?= $dataAuthor->description; ?></h6>
			</div>
		</div>
	</div>
</div>


<?= $this->endSection(); ?>


<!-- sidebar -->
<?= $this->section('sidebar'); ?>

<div class="card">
	<div class="card-body">
		<h5 data-anima class="card-title fw-bold mb-4">Blog Information</h5>
		<dl>
			<div>
				<dt data-anima>Published Date</dt>
				<dd data-anima class="text-break">
					<?= $data->publishedDate; ?>
				</dd>
			</div>
			<div class="my-4">
				<dt data-anima>Summary</dt>
				<dd data-anima class="text-break">
					<?= $data->summary; ?>
				</dd>
			</div>
			<div>
				<?php if (!empty($dataCategories)): ?>
					<dt data-anima>Categories</dt>
					<dd class="d-flex flex-column">
						<?php foreach ($dataCategories as $key => $value): ?>
							<a class="text-break secondary-light-text-color" href="/services/<?= $value->serviceSlug ?>"
								data-anima>
								<?= $value->name; ?>
							</a>
						<?php endforeach; ?>
					</dd>
				<?php endif; ?>
			</div>
			<div class="my-4">
				<dt data-anima>Share</dt>
				<dd class="d-flex column-gap-4">
					<?php $baseUrl = base_url("/blog/" . $data->slug); ?>
					<a class="secondary-light-text-color" target="_blank" title="Share post via Facebook"
						href="https://www.facebook.com/share.php?u=<?= $baseUrl; ?>">
						<i class='bx bxl-facebook bx-sm'></i>
					</a>
					<?php $twitterLink = 'https://twitter.com/intent/tweet/?text=' . $data->title . '&url=' . $baseUrl ?>
					<a class="secondary-light-text-color" title="Share post via Twitter" href="<?= $twitterLink; ?>">
						<i class='bx bxl-twitter bx-sm'></i>
					</a>
					<a class="secondary-light-text-color" target="_blank"
						href="mailto:?subject=<?= $data->title; ?>&body=<?= $baseUrl; ?>" title="Share post via Email">
						<i class='bx bx-envelope bx-sm'></i>
					</a>
				</dd>
			</div>
		</dl>

	</div>
</div>

<div class="card">
	<div class="card-body">
		<h5 data-anima class="card-title fw-bold mb-4">Related Blog</h5>
		<div class="d-flex flex-column row-gap-3">
			<?php foreach ($relatedBlogs as $relatedBlog): ?>
				<?php $relatedBlogImage = $relatedBlog->image; ?>
				<div class="d-flex column-gap-2">
					<div class="flex-shrink-0">
						<img width="100px" height="85px" class="object-fit-cover" src="<?= $relatedBlogImage->fileSrc; ?>"
							alt="<?= $relatedBlogImage->fileName ?>">
					</div>
					<div class="flex-grow-1 d-flex flex-column">
						<small data-anima><?= $relatedBlog->publishedDate; ?></small>
						<a data-anima href="#"
							class="lh-sm small fw-bold secondary-text-color"><?= $relatedBlog->title; ?></a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<?= $this->include('include/get_in_touch'); ?>

<?= $this->endSection(); ?>