<!DOCTYPE php>

<php lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

        <title>Dashboard - JackpotGamer</title>

        <meta name="description" content="" />

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="../../assets/img/favicon.png" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

        <!-- Icons. Uncomment required icon fonts -->
        <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />
        <script src="https://kit.fontawesome.com/b858070c46.js" crossorigin="anonymous"></script>

        <!-- Core CSS -->
        <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
        <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="assets/css/demo.css" />

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

        <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />

        <!-- Page CSS -->

        <!-- Helpers -->
        <script src="assets/vendor/js/helpers.js"></script>

        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="assets/js/config.js"></script>
    </head>

    <body>
        <?php
        session_start(); // Start the session

        // Check if the session variable 'user_id' is NOT set (user is not logged in)
        if (!isset($_SESSION["user_id"])) {
            // Redirect the user to the login page (login.php)
            header("Location: login.php");
            exit();
        }
        // Replace 'jackpotGamer.db' with the path to your existing SQLite database file
        $db_path = '../db/jackpotGamer.db';

        try {
            // Connect to the database
            $db = new SQLite3($db_path);

            // Prepare the SQL statement to retrieve the user's name based on 'user_id'
            $query = "SELECT id, nombre, rol FROM usuarios WHERE id = :user_id";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':user_id', $_SESSION["user_id"], SQLITE3_INTEGER);

            // Execute the statement
            $result = $stmt->execute();
            $user = $result->fetchArray(SQLITE3_ASSOC);

            // Get the user's name
            $user_name = $user["nombre"];

            //get the user's role
            $user_role = $user["rol"];

            //get the user's id
            $user_id = $user["id"];

            // Trim the name if it contains more than one word
            $name_parts = explode(' ', $user_name);
            if (count($name_parts) > 1) {
                $formatted_name = $name_parts[0][0] . '. ' . array_pop($name_parts);
            } else {
                $formatted_name = $user_name;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>

        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <!-- Menu -->

                <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                    <div class="app-brand demo">
                        <a href="index.php" class="app-brand-link">
                            <span class="app-brand-logo demo">
                                <img src="../../assets/img/logo.gif" alt="Brand Logo" class="img-fluid" />
                            </span>

                        </a>

                        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                            <i class="bx bx-chevron-left bx-sm align-middle"></i>
                        </a>
                    </div>

                    <div class="menu-inner-shadow"></div>

                    <ul class="menu-inner py-1">
                        <!-- Dashboard -->
                        <li class="menu-item active">
                            <a href="index.php" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-home"></i>
                                <div data-i18n="Analytics">Inicio</div>
                            </a>
                        </li>

                        <li class="menu-header small text-uppercase">
                            <span class="menu-header-text">Módulos</span>
                        </li>
                        <li class="menu-item">
                            <a href="cards-basic.php" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Boletos</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="cards-basic.php" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Rifas</div>
                            </a>
                        </li>
                    </ul>
                </aside>
                <!-- / Menu -->

                <!-- Layout container -->
                <div class="layout-page">
                    <!-- Navbar -->

                    <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                                <i class="bx bx-menu bx-sm"></i>
                            </a>
                        </div>

                        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                            <!-- Search -->
                            <div class="navbar-nav align-items-center">
                                <div class="nav-item d-flex align-items-center">
                                    ¡Bienvenido, <?php echo $user_name; ?>!
                                </div>
                            </div>
                            <!-- /Search -->

                            <ul class="navbar-nav flex-row align-items-center ms-auto">

                                <!-- User -->
                                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <div class="avatar avatar-online">
                                            <img src="assets/img/avatars/<?php echo $user_id ?>.jpg" alt class="w-px-40 h-auto rounded-circle" />
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar avatar-online">
                                                            <img src="assets/img/avatars/<?php echo $user_id ?>.jpg" alt class="w-px-40 h-auto rounded-circle" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <span class="fw-semibold d-block"><?php echo htmlspecialchars($formatted_name); ?></span>
                                                        <small class="text-muted"><?php echo $user_role ?></small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bx bx-user me-2"></i>
                                                <span class="align-middle">Mi Perfil</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bx bx-cog me-2"></i>
                                                <span class="align-middle">Configuraciones</span>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="procedures/logout.php">
                                                <i class="bx bx-power-off me-2"></i>
                                                <span class="align-middle">Cerrar Sesión</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!--/ User -->
                            </ul>
                        </div>
                    </nav>

                    <!-- / Navbar -->