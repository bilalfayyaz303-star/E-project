<?php
require_once("base/header.php");

// if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
//     echo "<script>
//         location.assign('signin.php');
//     </script>";
//     exit;
// }


$totalSongs = 0;
$songCountQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM songs");
if ($songCountQuery) {
    $totalSongs = (int)mysqli_fetch_assoc($songCountQuery)['total'];
}

$totalArtists = 0;
$artistCountQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM artists");
if ($artistCountQuery) {
    $totalArtists = (int)mysqli_fetch_assoc($artistCountQuery)['total'];
}

$totalCategories = 0;
$catCountQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM categories");
if ($catCountQuery) {
    $totalCategories = (int)mysqli_fetch_assoc($catCountQuery)['total'];
}

$totalUsers = 0;
$userCountQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
if ($userCountQuery) {
    $totalUsers = (int)mysqli_fetch_assoc($userCountQuery)['total'];
}

$recentQuery = "SELECT songs.*, artists.artist_name, categories.category_name 
                FROM songs 
                LEFT JOIN artists ON songs.artist_id = artists.id 
                LEFT JOIN categories ON songs.category_id = categories.id 
                ORDER BY songs.id DESC LIMIT 5";
$recentSongs = mysqli_query($conn, $query ?? $recentQuery);
?>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 shadow">
                <i class="fa fa-music fa-3x text-primary"></i>
                <div class="ms-3 text-end">
                    <p class="mb-2 text-muted small">Total Songs</p>
                    <h4 class="mb-0 text-white"><?php echo $totalSongs; ?></h4>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 shadow">
                <i class="fa fa-user-friends fa-3x text-primary"></i>
                <div class="ms-3 text-end">
                    <p class="mb-2 text-muted small">Artists</p>
                    <h4 class="mb-0 text-white"><?php echo $totalArtists; ?></h4>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 shadow">
                <i class="fa fa-tags fa-3x text-primary"></i>
                <div class="ms-3 text-end">
                    <p class="mb-2 text-muted small">Categories</p>
                    <h4 class="mb-0 text-white"><?php echo $totalCategories; ?></h4>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 shadow">
                <i class="fa fa-users fa-3x text-primary"></i>
                <div class="ms-3 text-end">
                    <p class="mb-2 text-muted small">Users</p>
                    <h4 class="mb-0 text-white"><?php echo $totalUsers; ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4 shadow">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 pb-3 border-bottom border-dark">
            <div>
                <h4 class="mb-1 text-white">Welcome back, <?php echo $userName; ?>!</h4>
                <p class="text-muted small mb-0">Here is a quick overview of your music catalog and recent track uploads.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="add_song.php" class="btn btn-primary btn-sm px-3 fw-bold">
                    <i class="fa fa-plus me-1"></i>Add New Song
                </a>
                <a href="manage_songs.php" class="btn btn-outline-light btn-sm px-3">
                    <i class="fa fa-cog me-1"></i>Manage Catalog
                </a>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="text-white mb-0"><i class="fa fa-clock text-primary me-2"></i>Recently Uploaded Tracks</h5>
            <a href="manage_songs.php" class="text-primary small text-decoration-none">View All</a>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr class="border-bottom border-secondary text-muted text-uppercase small">
                        <th scope="col" style="width: 50px;">#</th>
                        <th scope="col" style="width: 70px;">Cover</th>
                        <th scope="col">Title</th>
                        <th scope="col">Artist</th>
                        <th scope="col">Category</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Audio Preview</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($recentSongs && mysqli_num_rows($recentSongs) > 0): ?>
                        <?php $rowNum = 1; ?>
                        <?php while ($song = mysqli_fetch_assoc($recentSongs)): ?>
                            <?php
                            $coverPath = "../" . ltrim($song['cover_image'], '/');
                            $audioPath = "../" . ltrim($song['audio_file'], '/');
                            $hasValidCover = !empty($song['cover_image']) && file_exists($coverPath);
                            ?>
                            <tr>
                                <td class="text-muted"><?php echo $rowNum++; ?></td>
                                <td>
                                    <?php if ($hasValidCover): ?>
                                        <img src="<?php echo htmlspecialchars($coverPath); ?>" alt="Cover" class="rounded" style="width: 44px; height: 44px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="rounded bg-dark d-flex align-items-center justify-content-center text-primary" style="width: 44px; height: 44px;">
                                            <i class="fa fa-music"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="fw-bold text-white"><?php echo htmlspecialchars($song['title']); ?></div>
                                    <div class="text-muted small">Uploaded <?php echo date('M d, Y', strtotime($song['created_at'])); ?></div>
                                </td>
                                <td><span class="text-light"><?php echo htmlspecialchars($song['artist_name'] ?? 'Unknown Artist'); ?></span></td>
                                <td><span class="badge bg-primary px-2 py-1"><?php echo htmlspecialchars($song['category_name'] ?? 'General'); ?></span></td>
                                <td class="text-muted"><i class="bi bi-clock me-1"></i><?php echo htmlspecialchars($song['duration'] ?? 'N/A'); ?></td>
                                <td>
                                    <audio controls preload="none" style="height: 32px; width: 220px; outline: none;">
                                        <source src="<?php echo htmlspecialchars($audioPath); ?>" type="audio/mpeg">
                                        Audio player not supported.
                                    </audio>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                No songs uploaded yet. <a href="add_song.php" class="text-primary">Click here to add one.</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once("base/footer.php");
?>