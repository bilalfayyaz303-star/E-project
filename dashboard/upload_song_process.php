<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

require_once("config/db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['save_song'])) {
    $title = trim($_POST['title'] ?? '');
    $categoryId = (int)($_POST['category_id'] ?? 0);
    $artistId = (int)($_POST['artist_id'] ?? 0);
    $duration = trim($_POST['duration'] ?? '');

    if (empty($title) || $categoryId <= 0 || $artistId <= 0 || empty($duration)) {
        $_SESSION['flash_error'] = "All text fields and dropdown selections are required.";
        header("Location: add_song.php");
        exit();
    }

    if (!isset($_FILES['audio_file']) || $_FILES['audio_file']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['flash_error'] = "Please select a valid audio file to upload.";
        header("Location: add_song.php");
        exit();
    }

    if (!isset($_FILES['cover_image']) || $_FILES['cover_image']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['flash_error'] = "Please select a valid cover image to upload.";
        header("Location: add_song.php");
        exit();
    }

    $audioName = $_FILES['audio_file']['name'];
    $imageName = $_FILES['cover_image']['name'];

    $audioExt = strtolower(pathinfo($audioName, PATHINFO_EXTENSION));
    $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

    $allowedAudio = ['mp3', 'wav', 'ogg', 'm4a', 'aac'];
    $allowedImages = ['jpg', 'jpeg', 'png', 'webp', 'jfif'];

    if (!in_array($audioExt, $allowedAudio, true)) {
        $_SESSION['flash_error'] = "Invalid audio format. Allowed: MP3, WAV, OGG, M4A, AAC.";
        header("Location: add_song.php");
        exit();
    }

    if (!in_array($imageExt, $allowedImages, true)) {
        $_SESSION['flash_error'] = "Invalid image format. Allowed: JPG, JPEG, PNG, WEBP, JFIF.";
        header("Location: add_song.php");
        exit();
    }

    $audioDir = __DIR__ . "/../uploads/audio/";
    $imageDir = __DIR__ . "/../uploads/images/";

    if (!is_dir($audioDir)) {
        mkdir($audioDir, 0777, true);
    }
    if (!is_dir($imageDir)) {
        mkdir($imageDir, 0777, true);
    }

    $uniqueAudioName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $audioExt;
    $uniqueImageName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $imageExt;

    $audioTargetPath = $audioDir . $uniqueAudioName;
    $imageTargetPath = $imageDir . $uniqueImageName;

    $dbAudioPath = "uploads/audio/" . $uniqueAudioName;
    $dbImagePath = "uploads/images/" . $uniqueImageName;

    if (move_uploaded_file($_FILES['audio_file']['tmp_name'], $audioTargetPath) &&
        move_uploaded_file($_FILES['cover_image']['tmp_name'], $imageTargetPath)) {

        $stmt = mysqli_prepare($conn, "INSERT INTO songs (title, artist_id, category_id, audio_file, cover_image, duration) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "siisss", $title, $artistId, $categoryId, $dbAudioPath, $dbImagePath, $duration);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            $_SESSION['flash_success'] = "Track '{$title}' was successfully uploaded and published!";
            header("Location: manage_songs.php");
            exit();
        } else {
            mysqli_stmt_close($stmt);
            if (file_exists($audioTargetPath)) {
                unlink($audioTargetPath);
            }
            if (file_exists($imageTargetPath)) {
                unlink($imageTargetPath);
            }
            $_SESSION['flash_error'] = "Failed to save track details into database.";
            header("Location: add_song.php");
            exit();
        }
    } else {
        $_SESSION['flash_error'] = "Failed to move uploaded files to destination folder.";
        header("Location: add_song.php");
        exit();
    }
} else {
    header("Location: add_song.php");
    exit();
}