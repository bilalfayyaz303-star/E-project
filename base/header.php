<?php
require_once('dashboard/config/db.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}




$currentScript = basename($_SERVER['PHP_SELF']);



$artistsResult = false;

$artistsQuery = "
    SELECT id, artist_name
    FROM artists
    ORDER BY artist_name ASC
";

$artistsResult = mysqli_query($conn, $artistsQuery);



$categoriesResult = false;

$categoriesQuery = "
    SELECT id, category_name
    FROM categories
    ORDER BY category_name ASC
";

$categoriesResult = mysqli_query($conn, $categoriesQuery);


/* =========================================================
   HEADER CLASS
========================================================= */

$headerClass = ($currentScript === 'index.php')
    ? 'header'
    : 'header header--normal';

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="description"
        content="Sound Waves Music Portal"
    >

    <meta
        name="keywords"
        content="music, songs, artists, categories, playlist"
    >

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        http-equiv="X-UA-Compatible"
        content="ie=edge"
    >

    <title>Sound Waves - Music Portal</title>


    <!-- =====================================================
         GOOGLE FONT
    ====================================================== -->

    <link
        href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >


    <!-- =====================================================
         BOOTSTRAP
    ====================================================== -->

    <link
        rel="stylesheet"
        href="css/bootstrap.min.css"
        type="text/css"
    >


    <!-- =====================================================
         FONT AWESOME
    ====================================================== -->

    <link
        rel="stylesheet"
        href="css/font-awesome.min.css"
        type="text/css"
    >


    <!-- =====================================================
         OTHER CSS
    ====================================================== -->

    <link
        rel="stylesheet"
        href="css/barfiller.css"
        type="text/css"
    >

    <link
        rel="stylesheet"
        href="css/nowfont.css"
        type="text/css"
    >

    <link
        rel="stylesheet"
        href="css/rockville.css"
        type="text/css"
    >

    <link
        rel="stylesheet"
        href="css/magnific-popup.css"
        type="text/css"
    >

    <link
        rel="stylesheet"
        href="css/owl.carousel.min.css"
        type="text/css"
    >

    <link
        rel="stylesheet"
        href="css/slicknav.min.css"
        type="text/css"
    >

    <link
        rel="stylesheet"
        href="css/style.css"
        type="text/css"
    >


    <!-- =====================================================
         SOUND WAVES NAVBAR CSS
    ====================================================== -->

    <style>


        /* =================================================
           HEADER
        ================================================= */

        .header {

            position: relative;

            z-index: 9999;

        }


        .header__menu {

            display: flex;

            align-items: center;

            width: 100%;

        }


        /* =================================================
           LOGO
        ================================================= */

        .soundwaves-logo {

            display: inline-block;

            text-decoration: none !important;

        }


        .soundwaves-logo h2 {

            margin: 0;

            padding: 0;

            color: #ffffff;

            font-size: 27px;

            font-weight: 700;

            line-height: 1;

        }


        .soundwaves-logo span {

            color: #df3079;

        }


        .soundwaves-logo:hover {

            text-decoration: none;

        }


        /* =================================================
           NAVIGATION
        ================================================= */

        .header__nav {

            flex: 1;

            min-width: 0;

            margin-left: 15px;

        }


        .header__nav > ul {

            display: flex !important;

            align-items: center;

            justify-content: flex-end;

            flex-wrap: nowrap !important;

            list-style: none;

            margin: 0;

            padding: 0;

            white-space: nowrap;

        }


        .header__nav > ul > li {

            position: relative;

            flex-shrink: 0;

            white-space: nowrap;

            margin: 0;

            padding: 0;

        }


        .header__nav > ul > li > a {

            display: block;

            color: #ffffff;

            white-space: nowrap;

            font-size: 14px;

            padding: 22px 10px;

            text-decoration: none;

            transition: all .25s ease;

        }


        .header__nav > ul > li > a:hover {

            color: #df3079;

        }


        /* =================================================
           ACTIVE PAGE
        ================================================= */

        .header__nav > ul > li.active > a {

            color: #df3079;

        }


        /* =================================================
           DROPDOWN
        ================================================= */

        .header__nav li.dropdown {

            position: relative;

        }


        .header__nav li.dropdown > a i {

            margin-left: 5px;

            font-size: 10px;

        }


        .header__nav .dropdown-menu {

            position: absolute;

            top: 100%;

            left: 0;

            min-width: 210px;

            max-height: 420px;

            overflow-y: auto;

            padding: 8px 0;

            margin: 0;

            background: #17121f;

            border: 1px solid rgba(255,255,255,.08);

            border-radius: 4px;

            box-shadow: 0 10px 30px rgba(0,0,0,.4);

            display: none;

            z-index: 99999;

        }


        .header__nav li.dropdown:hover > .dropdown-menu {

            display: block;

        }


        .header__nav .dropdown-menu li {

            display: block;

            width: 100%;

            list-style: none;

        }


        .header__nav .dropdown-menu li a {

            display: block;

            padding: 9px 16px;

            color: #ffffff;

            font-size: 13px;

            text-decoration: none;

            white-space: nowrap;

            transition: all .2s ease;

        }


        .header__nav .dropdown-menu li a:hover {

            color: #ffffff;

            background: #df3079;

        }


        /* =================================================
           DROPDOWN SCROLLBAR
        ================================================= */

        .header__nav .dropdown-menu::-webkit-scrollbar {

            width: 5px;

        }


        .header__nav .dropdown-menu::-webkit-scrollbar-track {

            background: #17121f;

        }


        .header__nav .dropdown-menu::-webkit-scrollbar-thumb {

            background: #df3079;

            border-radius: 10px;

        }


        /* =================================================
           LOGOUT BUTTON
        ================================================= */

        .nav-logout {

            display: inline-flex !important;

            align-items: center;

            justify-content: center;

            padding: 7px 15px !important;

            margin-left: 7px;

            color: #ffffff !important;

            background: #df3079;

            border: 1px solid #df3079;

            border-radius: 4px;

            font-size: 12px !important;

            font-weight: 700;

            text-transform: uppercase;

            line-height: 1.2 !important;

            text-decoration: none !important;

            white-space: nowrap !important;

            transition: all .25s ease;

        }


        .nav-logout:hover {

            color: #ffffff !important;

            background: #c62568;

            border-color: #c62568;

            transform: translateY(-1px);

        }


        .nav-logout i {

            margin-right: 6px;

        }


        /* =================================================
           MOBILE MENU
        ================================================= */

        .header__right {

            display: flex;

            align-items: center;

            margin-left: 10px;

        }


        .canvas__open {

            color: #ffffff;

            cursor: pointer;

            font-size: 22px;

        }


        /* =================================================
           LARGE DESKTOP
        ================================================= */

        @media (min-width: 1200px) {

            .header__nav > ul > li > a {

                padding-left: 10px;

                padding-right: 10px;

            }

        }


        /* =================================================
           LAPTOP
        ================================================= */

        @media (min-width: 992px) and (max-width: 1199px) {

            .header__nav {

                margin-left: 3px;

            }


            .header__nav > ul > li > a {

                padding-left: 5px !important;

                padding-right: 5px !important;

                font-size: 12px !important;

            }


            .nav-logout {

                padding: 6px 9px !important;

                font-size: 11px !important;

            }

        }


        /* =================================================
           TABLET / MOBILE
        ================================================= */

        @media (max-width: 991px) {

            .header__nav {

                display: none;

            }


            .header__right {

                margin-left: auto;

            }

        }


        /* =================================================
           PRELOADER FIX
        ================================================= */

        #preloder {

            display: none !important;

        }


        .loader {

            display: none !important;

        }

    </style>

</head>


<body>


<!-- =====================================================
     HEADER START
====================================================== -->

<header class="<?php echo $headerClass; ?>">

    <div class="container">

        <div class="row align-items-center">


            <!-- =================================================
                 LOGO
            ================================================== -->

            <div class="col-lg-3 col-md-3 col-8">

                <div class="header__logo">

                    <a
                        href="index.php"
                        class="soundwaves-logo"
                    >

                        <h2>

                            Sound
                            <span>Waves</span>

                        </h2>

                    </a>

                </div>

            </div>


            <!-- =================================================
                 NAVIGATION
            ================================================== -->

            <div class="col-lg-9 col-md-9 col-4">

                <div class="header__menu">


                    <nav class="header__nav">

                        <ul>


                            <!-- =================================
                                 HOME
                            ================================== -->

                            <li
                                class="<?php
                                    echo ($currentScript === 'index.php')
                                        ? 'active'
                                        : '';
                                ?>"
                            >

                                <a href="index.php">

                                    Home

                                </a>

                            </li>


                            <!-- =================================
                                 ARTISTS - DYNAMIC
                            ================================== -->

                            <li class="dropdown">

                                <a href="discography.php">

                                    Artists

                                    <i class="fa fa-angle-down"></i>

                                </a>


                                <ul class="dropdown-menu">


                                    <!-- ALL ARTISTS -->

                                    <li>

                                        <a href="discography.php">

                                            All Artists

                                        </a>

                                    </li>


                                    <?php if (
                                        $artistsResult &&
                                        mysqli_num_rows($artistsResult) > 0
                                    ): ?>


                                        <?php while (
                                            $artist =
                                            mysqli_fetch_assoc($artistsResult)
                                        ): ?>

                                            <li>

                                                <a
                                                    href="discography.php?artist_id=<?php
                                                        echo (int)$artist['id'];
                                                    ?>"
                                                >

                                                    <?php
                                                        echo htmlspecialchars(
                                                            $artist['artist_name'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        );
                                                    ?>

                                                </a>

                                            </li>

                                        <?php endwhile; ?>


                                    <?php else: ?>


                                        <li>

                                            <a href="javascript:void(0);">

                                                No Artists Found

                                            </a>

                                        </li>


                                    <?php endif; ?>

                                </ul>

                            </li>


                            <!-- =================================
                                 CATEGORIES - DYNAMIC
                            ================================== -->

                            <li class="dropdown">

                                <a href="discography.php">

                                    Categories

                                    <i class="fa fa-angle-down"></i>

                                </a>


                                <ul class="dropdown-menu">


                                    <!-- ALL CATEGORIES -->

                                    <li>

                                        <a href="discography.php">

                                            All Categories

                                        </a>

                                    </li>


                                    <?php if (
                                        $categoriesResult &&
                                        mysqli_num_rows($categoriesResult) > 0
                                    ): ?>


                                        <?php while (
                                            $category =
                                            mysqli_fetch_assoc($categoriesResult)
                                        ): ?>

                                            <li>

                                                <a
                                                    href="discography.php?category_id=<?php
                                                        echo (int)$category['id'];
                                                    ?>"
                                                >

                                                    <?php
                                                        echo htmlspecialchars(
                                                            $category['category_name'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        );
                                                    ?>

                                                </a>

                                            </li>

                                        <?php endwhile; ?>


                                    <?php else: ?>


                                        <li>

                                            <a href="javascript:void(0);">

                                                No Categories Found

                                            </a>

                                        </li>


                                    <?php endif; ?>

                                </ul>

                            </li>


                            <!-- =================================
                                 SONGS
                            ================================== -->

                            <li
                                class="<?php
                                    echo ($currentScript === 'discography.php')
                                        ? 'active'
                                        : '';
                                ?>"
                            >

                                <a href="discography.php">

                                    Songs

                                </a>

                            </li>


                            <!-- =================================
                                 DISCOGRAPHY
                            ================================== -->

                            <li>

                                <a href="discography.php">

                                    Discography

                                </a>

                            </li>


                            <!-- =================================
                                 VIDEOS
                            ================================== -->

                            <li
                                class="<?php
                                    echo ($currentScript === 'videos.php')
                                        ? 'active'
                                        : '';
                                ?>"
                            >

                                <a href="videos.php">

                                    Videos

                                </a>

                            </li>


                            <!-- =================================
                                 BLOG
                            ================================== -->

                            <li
                                class="<?php
                                    echo ($currentScript === 'blog.php')
                                        ? 'active'
                                        : '';
                                ?>"
                            >

                                <a href="blog.php">

                                    Blog

                                </a>

                            </li>


                            <!-- =================================
                                 TOURS
                            ================================== -->

                            <li
                                class="<?php
                                    echo ($currentScript === 'tours.php')
                                        ? 'active'
                                        : '';
                                ?>"
                            >

                                <a href="tours.php">

                                    Tours

                                </a>

                            </li>


                            <!-- =================================
                                 CONTACT
                            ================================== -->

                            <li
                                class="<?php
                                    echo ($currentScript === 'contact.php')
                                        ? 'active'
                                        : '';
                                ?>"
                            >

                                <a href="contact.php">

                                    Contact

                                </a>

                            </li>


                            <!-- =================================
                                 LOGOUT
                            ================================== -->

                            <li>

                                <a
                                    href="logout.php"
                                    class="nav-logout"
                                >

                                    <i class="fa fa-sign-out"></i>

                                    Logout

                                </a>

                            </li>


                        </ul>

                    </nav>


                    <!-- =========================================
                         MOBILE MENU BUTTON
                    ========================================== -->

                    <div class="header__right">

                        <div class="canvas__open">

                            <i class="fa fa-bars"></i>

                        </div>

                    </div>


                </div>

            </div>

        </div>

    </div>

</header>


<!-- =====================================================
     HEADER END

     Page content yahan se start hoga
====================================================== -->