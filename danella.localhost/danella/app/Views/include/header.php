<!doctype html>
<html lang="en">

<head>
    <!-- meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- meta-tags -->
    <?= $metatags ?? ''; ?>
    <meta name=”robots” content="index, follow">

    <!-- schema -->
    <?= $schema ?? ''; ?>

    <!-- favicons -->
    <link rel="danellatech-touch-icon" sizes="180x180"
        href="/assets/favicon/danellatech-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/site.webmanifest">

    <!-- css -->
    <link href="/assets/css/library/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/library/animaview.min.css" />
    <link rel="stylesheet" href="/assets/css/library/animate.min.css" />

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">

    <!-- icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- custom css -->
    <link rel="stylesheet" href="/assets/css/custom/animaview.css" />
    <link href="<?= '/assets/css/custom/styles.css'; ?>" rel="stylesheet" />

    <!-- other css_files through controller -->
    <?= $css_files ?? ''; ?>
    
</head>

<body>
    <!-- used by floating_ui library -->
    <div id="floating"></div>

    <!-- header -->
    <header class="">
        <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm bg-color navbar-font">
            <div class="container">
                <a class="navbar-brand py-0" href="/">
                    <img src="<?= base_url('/assets/brand/danellatech-logo.svg'); ?>" alt="Logo" width="150">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mx-auto justify-content-center">
                        <li class="nav-item mx-2">
                            <a data-anima class="nav-link active" aria-current="page" href="/">Home</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a data-anima class="nav-link" href="/about">About</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a data-anima class="nav-link" href="/services">Services</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a data-anima class="nav-link" href="/projects">Projects</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a data-anima class="nav-link" href="/contact">Contact</a>
                        </li>
                    </ul>
                    <div>
                        <a class="btn rounded-0 px-4 fs-5 primary-btn" href="/get-quote">Get a quote
                            <i class='bx bx-right-arrow-alt d-inline'></i>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>