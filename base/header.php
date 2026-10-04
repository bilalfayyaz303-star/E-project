<?php

session_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$currentScript = basename($_SERVER['PHP_SELF']);
$headerClass = ($currentScript === 'index.php') ? 'header' : 'header header--normal';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Sound Waves Music Portal">
    <meta name="keywords" content="music, songs, artists, playlist">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sound Waves - Music Portal</title>

    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/barfiller.css" type="text/css">
    <link rel="stylesheet" href="css/nowfont.css" type="text/css">
    <link rel="stylesheet" href="css/rockville.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">

    <style>
    /* =========================================
       HEADER NAVIGATION
       ========================================= */

    .header__nav {
        flex: 1;
        min-width: 0;
        white-space: nowrap;
    }

    /* Keep ALL main navigation items on one line */
    .header__nav > ul {
        display: flex !important;
        align-items: center;
        justify-content: flex-end;
        flex-wrap: nowrap !important;
        white-space: nowrap;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    /* Prevent navigation items from wrapping */
    .header__nav > ul > li {
        flex-shrink: 0 !important;
        white-space: nowrap;
        display: flex;
        align-items: center;
    }

    /* Navigation links */
    .header__nav ul li a {
        transition: color 0.2s ease;
        white-space: nowrap;
    }

    .header__nav > ul > li > a {
        white-space: nowrap;
    }


    /* =========================================
       AUTH BUTTONS
       ========================================= */

    .nav-auth-btn {
        padding: 6px 14px !important;
        border-radius: 4px;
        font-size: 13px !important;
        text-transform: uppercase;
        font-weight: 600;
        display: inline-block;
        line-height: normal !important;
        white-space: nowrap !important;
        flex-shrink: 0 !important;
    }


    /* =========================================
       SIGN IN
       ========================================= */

    .btn-signin {
        border: 1px solid #df3079;
        color: #ffffff !important;
        background: transparent;
        margin-right: 6px;
    }

    .btn-signin:hover {
        background: #df3079;
        color: #ffffff !important;
    }


    /* =========================================
       REGISTER / SIGN UP
       ========================================= */

    .btn-signup {
        background: #df3079;
        color: #ffffff !important;
        border: 1px solid #df3079;
    }

    .btn-signup:hover {
        background: #c62568;
        color: #ffffff !important;
    }


    /* =========================================
       DASHBOARD
       ========================================= */

    .btn-dashboard {
        background: #2a2e39;
        border: 1px solid #4a5162;
        color: #ffffff !important;
        margin-right: 6px;
    }

    .btn-dashboard:hover {
        background: #df3079;
        border-color: #df3079;
        color: #ffffff !important;
    }


    /* =========================================
       LOGOUT
       ========================================= */

    .btn-logout {
        background: #ff3366;
        color: #ffffff !important;
    }

    .btn-logout:hover {
        background: #ffffff;
        color: #ff3366 !important;
    }


    /* =========================================
       PAGES DROPDOWN
       ========================================= */

    .header__nav .dropdown {
        white-space: normal;
    }

    .header__nav .dropdown li {
        white-space: nowrap;
    }

    .header__nav .dropdown li a {
        white-space: nowrap;
    }


    /* =========================================
       RESPONSIVE DESKTOP NAVIGATION
       ========================================= */

    @media (min-width: 992px) {

        .header__nav > ul {
            flex-wrap: nowrap !important;
        }

        .header__nav > ul > li {
            flex-shrink: 0 !important;
        }

    }


    /* =========================================
       TABLET / SMALL DESKTOP
       Reduce spacing so everything stays inline
       ========================================= */

    @media (min-width: 992px) and (max-width: 1199px) {

        .header__nav > ul > li > a {
            padding-left: 8px !important;
            padding-right: 8px !important;
            font-size: 13px;
        }

        .nav-auth-btn {
            padding: 5px 10px !important;
            font-size: 12px !important;
        }

    }
</style>

</head>
<body>
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <header class="<?php echo $headerClass; ?>">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2 col-md-2">
                    <div class="header__logo">
                        <a href="index.php">
                            <img src="img/logo.png" alt="Sound Waves">
                        </a>
                    </div>
                </div>
                <div class="col-lg-10 col-md-10">
                    <div class="header__nav d-flex justify-content-between align-items-center">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li class="<?php echo ($currentScript === 'index.php') ? 'active' : ''; ?>">
                                    <a href="index.php">Home</a>
                                </li>
                                <li class="<?php echo ($currentScript === 'discography.php') ? 'active' : ''; ?>">
                                    <a href="discography.php">Discography</a>
                                </li>
                                <li class="<?php echo ($currentScript === 'about.php') ? 'active' : ''; ?>">
                                    <a href="about.php">About</a>
                                </li>
                                <li class="<?php echo ($currentScript === 'tours.php') ? 'active' : ''; ?>">
                                    <a href="tours.php">Tours</a>
                                </li>
                                <li class="<?php echo ($currentScript === 'videos.php') ? 'active' : ''; ?>">
                                    <a href="videos.php">Videos</a>
                                </li>
                                <li class="<?php echo in_array($currentScript, ['blog.php', 'blog-details.php'], true) ? 'active' : ''; ?>">
                                    <a href="#">Pages</a>
                                    <ul class="dropdown">
                                        <li><a href="blog.php">Blog</a></li>
                                        <li><a href="blog-details.php">Blog Details</a></li>
                                    </ul>
                                </li>
                                <li class="<?php echo ($currentScript === 'contact.php') ? 'active' : ''; ?>">
                                    <a href="contact.php">Contact</a>
                                </li>

                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <li>
                                        <a href="dashboard/index.php" class="nav-auth-btn btn-dashboard">
                                            <i class="fa fa-tachometer"></i> Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a href="logout.php" class="nav-auth-btn btn-logout">
                                            <i class="fa fa-sign-out"></i> Logout
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li>
                                        <a href="dashboard/signin.php" class="nav-auth-btn btn-signin">
                                            Sign In
                                        </a>
                                    </li>
                                    <li>
                                        <a href="dashboard/signup.php" class="nav-auth-btn btn-signup">
                                            Register
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>

                        <div class="header__right__social d-none d-xl-block">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>