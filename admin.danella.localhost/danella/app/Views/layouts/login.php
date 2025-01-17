<!DOCTYPE html>
<html class="h-100">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, noodp, noarchive, noimageindex" />
	<title>
		<?= 'DanellaTech | ' . $title; ?>
	</title>

	<!-- favicons -->
	<?= $this->include('include/favicons'); ?>

	<!-- css -->
	<link href="/assets/css/library/bootstrap.min.css" rel="stylesheet">

	<!-- fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

	<!-- icons -->
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

	<!-- custom css -->
	<link href="/assets/css/custom/styles.css" rel="stylesheet" />

	<style>
		body {
			background-image: url('/assets/images/background-image.jpg');
			background-size: cover;
		}

		body::before {
			content: '';
			position: absolute;
			width: 100%;
			height: 100%;
			top: 0;
			left: 0;
			background: rgba(0, 0, 0, 0.3);
			z-index: 0;
		}

		main {
			z-index: 1;
		}
	</style>
</head>

<body class="h-100">
	<main class="h-100 w-100">
		<div class="container h-100">
			<div class="row h-100 justify-content-center align-items-center">
				<div class="col-lg-5 col-md-8 col-sm-10 col-10">
					<div class="card border-0">
						<div class="card-body p-4">
							<div class="d-flex justify-content-between align-items-end mb-5">
								<img style="width: 37%;" src="<?= base_url('assets/brand/danellatech-logo.svg'); ?>"
									alt="">
								<?= $this->renderSection('title') ?>

							</div>
							<?= $this->renderSection('content') ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</body>

</html>