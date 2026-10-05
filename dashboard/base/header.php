<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

require_once("config/db.php");

$currentPage = basename($_SERVER['PHP_SELF']);
$userName = htmlspecialchars($_SESSION['user_name'] ?? 'Admin User');
$userRole = htmlspecialchars(ucfirst($_SESSION['user_role'] ?? 'Admin'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Musical Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid position-relative d-flex p-0">
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary mb-0"><i class="fa fa-music me-2"></i>Musical</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/user.jpg" alt="User" style="width: 40px; height: 40px; object-fit: cover;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-white"><?php echo $userName; ?></h6>
                        <span class="text-muted small"><?php echo $userRole; ?></span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php" class="nav-item nav-link <?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">
                        <i class="fa fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a href="add_song.php" class="nav-item nav-link <?php echo $currentPage === 'add_song.php' ? 'active' : ''; ?>">
                        <i class="fa fa-plus-circle me-2"></i>Add Song
                    </a>
                    <a href="manage_songs.php" class="nav-item nav-link <?php echo $currentPage === 'manage_songs.php' ? 'active' : ''; ?>">
                        <i class="fa fa-compact-disc me-2"></i>Manage Songs
                    </a>
                    <div class="border-top border-dark my-3 mx-3"></div>
                    <a href="../index.php" class="nav-item nav-link" target="_blank">
                        <i class="fa fa-globe me-2"></i>Live Website
                    </a>
                    <a href="../logout.php" class="nav-item nav-link text-danger">
                        <i class="fa fa-sign-out-alt me-2"></i>Sign Out
                    </a>
                </div>
            </nav>
        </div>

        <div class="content">
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h3 class="text-primary mb-0"><i class="fa fa-music"></i></h3>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0 text-white">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle text-white d-flex align-items-center" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/user.jpg" alt="User" style="width: 36px; height: 36px; object-fit: cover;">
                            <span class="d-none d-lg-inline-flex"><?php echo $userName; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0 shadow">
                            <span class="dropdown-item-text text-muted small">Signed in as <strong><?php echo $userName; ?></strong></span>
                            <div class="dropdown-divider"></div>
                            <a href="../index.php" class="dropdown-item" target="_blank"><i class="fa fa-globe me-2"></i>View Website</a>
                            <div class="dropdown-divider"></div>
                            <a href="../logout.php" class="dropdown-item text-danger"><i class="fa fa-sign-out-alt me-2"></i>Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>