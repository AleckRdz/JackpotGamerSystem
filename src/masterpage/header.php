<!DOCTYPE php>
<php lang="en">

<head>

    <meta charset="utf-8">
    <meta name="author" content="templatemo">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

    <title>Jackpot GAMER</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-snapx-photography.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

</head>
<body>

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="index.php" class="logo">
                            <img src="assets/img/logo.gif" alt="SnapX Photography Template">
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="index.php" class="active">Home</a></li>
                            <li class="has-sub">
                                <a href="javascript:void(0)">Photos &amp; Videos</a>
                                <ul class="sub-menu">
                                    <li><a href="contests.php">Contests</a></li>
                                    <li><a href="contest-details.php">Single Contest</a></li>
                                </ul>
                            </li>
                            <li><a href="categories.php">Categories</a></li>
                            <li><a href="users.php">Users</a></li>
                        </ul>
                        <div class="border-button">
                            <a id="modal_trigger" href="#modal" class="sign-in-up"><i class="fa fa-user"></i> Sign In/Up</a>
                        </div>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <div id="modal" class="popupContainer" style="display:none;">
        <div class="popupHeader">
            <span class="header_title">Login</span>
            <span class="modal_close"><i class="fa fa-times"></i></span>
        </div>

        <section class="popupBody">
            <!-- Social Login -->
            <div class="social_login">
                <div class="">
                    <a href="#" class="social_box fb">
                        <span class="icon"><i class="fab fa-facebook"></i></span>
                        <span class="icon_title">Connect with Facebook</span>

                    </a>

                    <a href="#" class="social_box google">
                        <span class="icon"><i class="fab fa-google-plus"></i></span>
                        <span class="icon_title">Connect with Google</span>
                    </a>
                </div>

                <div class="centeredText">
                    <span>Or use your Email address</span>
                </div>

                <div class="action_btns">
                    <div class="one_half"><a href="#" id="login_form" class="btn">Login</a></div>
                    <div class="one_half last"><a href="#" id="register_form" class="btn">Sign up</a></div>
                </div>
            </div>

            <!-- Username & Password Login form -->
            <div class="user_login">
                <form action="" method="post">
                    <label>Email / Username</label>
                    <input name="username" type="text" id="username" />
                    <br />

                    <label>Password</label>
                    <input name="password" type="password" id="password" />
                    <br />

                    <div class="checkbox">
                        <input id="remember" type="checkbox" />
                        <label for="remember">Remember me on this computer</label>
                    </div>

                    <div class="action_btns">
                        <div class="one_half"><a href="#" class="btn back_btn"><i class="fa fa-angle-double-left"></i> Back</a></div>
                        <div class="one_half last"><button type="submit" class="btn btn_red">Login</button></div>
                    </div>
                </form>

                <a href="#" class="forgot_password">Forgot password?</a>
            </div>

            <!-- Register Form -->
            <div class="user_register">
                <form action="" method="post">
                    <label>Username</label>
                    <input name="username" type="text" id="username" />
                    <br />

                    <label>Email Address</label>
                    <input name="email" type="email" id="email" />
                    <br />

                    <label>Password</label>
                    <input name="password" type="password" id="password" />
                    <br />

                    <div class="checkbox">
                        <input id="send_updates" type="checkbox" />
                        <label for="send_updates">Send me occasional email updates</label>
                    </div>

                    <div class="action_btns">
                        <div class="one_half"><a href="#" class="btn back_btn"><i class="fa fa-angle-double-left"></i> Back</a></div>
                        <div class="one_half last"><button type="submit" class="btn btn_red">Register</button></div>
                    </div>
                </form>
            </div>

        </section>
    </div>