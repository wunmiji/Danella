<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, noodp, noarchive, noimageindex" />
    <title>
        <?= 'DanellaTech - ' . $title; ?>
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

    <!-- other css through controller -->
    <?= $css_files ?? ''; ?>

    <!-- Custom styles -->
    <link href="/assets/css/custom/styles.css" rel="stylesheet" />
</head>

<body>
    <div class="d-flex h-100 w-100" id="wrapper">
        <aside class="d-flex flex-column">
            <div class="app-header d-flex align-items-center second-bg-color">
                <a href="/" class="px-4">
                    <img src="<?= base_url('assets/brand/danellatech-logo.svg'); ?>" alt="">
                </a>
            </div>

            <div class="overflow-y-auto h-100 pt-3 second-bg-color">
                <div class="d-flex flex-column">
                    <div class="gray-link-color">
                        <a class="sidebar-icons" href="/dashboard">
                            <i class='bx bx-home'></i>
                            <span>Dashboard</span>
                        </a>
                    </div>

                    <div class="gray-link-color">
                        <a class="sidebar-icons" href="/employees">
                            <i class='bx bx-user'></i>
                            <span>Employee</span>
                        </a>
                    </div>

                    <div class="gray-link-color">
                        <a class="sidebar-icons" href="/blog">
                            <i class='bx bx-news'></i>
                            <span>Blog</span>
                        </a>
                    </div>

                    <div class="gray-link-color">
                        <a class="sidebar-icons" href="/projects">
                            <i class='bx bx-list-ul'></i>
                            <span>Project</span>
                        </a>
                    </div>

                    <div class="gray-link-color">
                        <a class="sidebar-icons" href="/services">
                            <i class='bx bx-cog'></i>
                            <span>Service</span>
                        </a>
                    </div>

                    <div class="gray-link-color">
                        <a class="sidebar-icons" href="/testimonials">
                            <i class='bx bx-comment'></i>
                            <span>Testimonial</span>
                        </a>
                    </div>

                    <div class="gray-link-color">
                        <a class="sidebar-icons" href="/file-manager">
                            <i class='bx bx-folder'></i>
                            <span>File Manager</span>
                        </a>
                    </div>

                    <div class="gray-link-color">
                        <a class="sidebar-icons" href="/file-managerr">
                            <i class='bx bx-folder'></i>
                            <span>File Managerr</span>
                        </a>
                    </div>

                </div>
            </div>
        </aside>

        <main class="overflow-y-auto d-flex flex-column row-gap-4">
            <header>
                <nav class="navbar navbar-expand-lg p-0 app-header sticky-top second-bg-color">
                    <div class="container-fluid d-flex justify-content-between">
                        <div class="d-flex flex-row">
                            <div class="ms-md-2 ms-1  gray-link-color">
                                <a class="nav-icons" onclick="asideFunction()">
                                    <i class="bx bx-menu-alt-left fs-2"></i>
                                </a>
                            </div>
                        </div>

                        <div class="d-flex flex-row">
                            <div class="me-md-3 me-2 btn-group">
                                <a class="nav-icons gray-link-color" role="button" data-bs-toggle="dropdown"
                                    data-bs-display="static" aria-expanded="false">
                                    <img src="<?= session()->get('employeeImage'); ?>"
                                        alt="<?= session()->get('employeeImageAlt'); ?>" width="30" height="30"
                                        class="rounded-circle">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end rounded-0">
                                    <li class="">
                                        <div class="dropdown-header text-uppercase">
                                            <h6><?= session()->get('employeeName'); ?></h6>
                                        </div>
                                    </li>
                                    <li class="">
                                        <a class="dropdown-item" href="/employees">
                                            <i class='bx bx-user fs-5 me-2'></i>
                                            <span>My Profile</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a class="dropdown-item" href="/employees">
                                            <i class='bx bx-cog fs-5 me-2'></i>
                                            <span>Settings</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a class="dropdown-item" href="/logout">
                                            <i class='bx bx-log-out fs-5 me-2'></i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>

            <section class="container-fluid px-3 px-md-4">
                <?= $this->renderSection('content') ?>
            </section>

            <footer class="py-3">
                <div class="container-fluid px-3 px-md-4 py-0">
                    <div class="d-flex justify-content-center">
                        <?php $founded = 2017; ?>
                        <?php $footerCopyrightYear = ($founded != date('Y')) ? ($founded . '-' . date('Y')) : $founded; ?>
                        <span data-anima>Danellatech.com © <?= $footerCopyrightYear; ?>.</span>
                        <a href="#" class="mx-2" data-anima>Omobolaji Micheal Adewunmi</a>
                        <span data-anima>All right reserved.</span>
                    </div>
                </div>
            </footer>
        </main>
    </div>


    <!-- js -->
    <script src="/assets/js/library/bootstrap.bundle.js"></script>
    <script src="/assets/js/library/jquery-3.7.1.min.js"></script>

    <!-- other js through controller -->
    <?= $js_files ?? ''; ?>

    <script>
        function asideFunction() {
            var x = document.getElementById("wrapper");
            x.classList.toggle("toggled");
        }
    </script>
</body>

</html>