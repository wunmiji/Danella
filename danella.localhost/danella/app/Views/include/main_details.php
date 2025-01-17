<div class="card">
	<img src="<?= $dataImage->fileSrc; ?>" class="card-img-top" alt="<?= $dataImage->fileName; ?>">
	<div class="card-body">
		<h1 class="card-title fw-bold mb-4">
			<?= (isset($data->name)) ? $data->name : $data->title; ?>
		</h1>
		<div class="card-text content-text text-break">
			<?= $dataText->text; ?>
		</div>
	</div>
</div>