<!DOCTYPE html>
<html class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
</head>

<body class="h-100">
    <main class="h-100 w-100">
        <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <?= view_cell('\App\Cells\ErrorCell::error'); ?>
            </div>
        </div>
    </main>
</body>

</html>