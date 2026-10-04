<?php
require_once("base/header.php");

if (isset($_GET['delete_id'])) {
    $deleteId = (int)$_GET['delete_id'];

    if ($deleteId > 0) {
        $findStmt = mysqli_prepare($conn, "SELECT audio_file, cover_image, title FROM songs WHERE id = ?");
        mysqli_stmt_bind_param($findStmt, "i", $deleteId);
        mysqli_stmt_execute($findStmt);
        $songResult = mysqli_stmt_get_result($findStmt);

        if ($songRow = mysqli_fetch_assoc($songResult)) {
            $audioPathOnDisk = __DIR__ . "/../" . $songRow['audio_file'];
            $imagePathOnDisk = __DIR__ . "/../" . $songRow['cover_image'];

            if (!empty($songRow['audio_file']) && file_exists($audioPathOnDisk)) {
                unlink($audioPathOnDisk);
            }
            if (!empty($songRow['cover_image']) && file_exists($imagePathOnDisk)) {
                unlink($imagePathOnDisk);
            }

            $delPlaylists = mysqli_prepare($conn, "DELETE FROM playlist_songs WHERE song_id = ?");
            mysqli_stmt_bind_param($delPlaylists, "i", $deleteId);
            mysqli_stmt_execute($delPlaylists);
            mysqli_stmt_close($delPlaylists);

            $delStmt = mysqli_prepare($conn, "DELETE FROM songs WHERE id = ?");
            mysqli_stmt_bind_param($delStmt, "i", $deleteId);
            mysqli_stmt_execute($delStmt);
            mysqli_stmt_close($delStmt);

            $_SESSION['flash_success'] = "Track '{$songRow['title']}' was removed successfully.";
        }
        mysqli_stmt_close($findStmt);
    }

    header("Location: manage_songs.php");
    exit();
}

$search = trim($_GET['search'] ?? '');

if (!empty($search)) {
    $searchWildcard = "%" . $search . "%";
    $queryStmt = mysqli_prepare($conn, "SELECT songs.*, artists.artist_name, categories.category_name 
                                         FROM songs 
                                         LEFT JOIN artists ON songs.artist_id = artists.id 
                                         LEFT JOIN categories ON songs.category_id = categories.id 
                                         WHERE songs.title LIKE ? OR artists.artist_name LIKE ?
                                         ORDER BY songs.id DESC");
    mysqli_stmt_bind_param($queryStmt, "ss", $searchWildcard, $searchWildcard);
    mysqli_stmt_execute($queryStmt);
    $result = mysqli_stmt_get_result($queryStmt);
} else {
    $query = "SELECT songs.*, artists.artist_name, categories.category_name 
              FROM songs 
              LEFT JOIN artists ON songs.artist_id = artists.id 
              LEFT JOIN categories ON songs.category_id = categories.id 
              ORDER BY songs.id DESC";
    $result = mysqli_query($conn, $query);
}

$flashSuccess = $_SESSION['flash_success'] ?? '';
$flashError = $_SESSION['flash_error'] ?? '';
unset($_SESSION['flash_success'], $_SESSION['flash_error']);
?>

<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4 shadow">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 pb-3 border-bottom border-dark">
            <div>
                <h4 class="mb-1 text-white"><i class="fa fa-compact-disc text-primary me-2"></i>Manage Songs</h4>
                <p class="text-muted small mb-0">Browse, preview, and manage all music tracks in the system.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="add_song.php" class="btn btn-primary btn-sm px-3 fw-bold">
                    <i class="fa fa-plus me-1"></i>Add New Song
                </a>
            </div>
        </div>

        <?php if (!empty($flashSuccess)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-2"></i><?php echo htmlspecialchars($flashSuccess); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($flashError)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($flashError); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row mb-3">
            <div class="col-12 col-md-5 ms-auto">
                <form method="GET" action="manage_songs.php" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm bg-dark text-white border-0" placeholder="Search by title or artist..." value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit" class="btn btn-primary btn-sm px-3">Search</button>
                    <?php if (!empty($search)): ?>
                        <a href="manage_songs.php" class="btn btn-dark btn-sm">Clear</a>
                    <?php endif; ?>
                </form>
            </div>
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
                        <th scope="col">Preview</th>
                        <th scope="col" class="text-end" style="width: 100px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && mysqli_num_rows($result) > 0): ?>
                        <?php $rowCounter = 1; ?>
                        <?php while ($song = mysqli_fetch_assoc($result)): ?>
                            <?php
                            $coverPath = "../" . ltrim($song['cover_image'], '/');
                            $audioPath = "../" . ltrim($song['audio_file'], '/');
                            $hasValidCover = !empty($song['cover_image']) && file_exists($coverPath);
                            ?>
                            <tr>
                                <td class="text-muted"><?php echo $rowCounter++; ?></td>
                                <td>
                                    <?php if ($hasValidCover): ?>
                                        <img src="<?php echo htmlspecialchars($coverPath); ?>" alt="Cover" class="rounded" style="width: 48px; height: 48px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="rounded bg-dark d-flex align-items-center justify-content-center text-primary" style="width: 48px; height: 48px;">
                                            <i class="fa fa-music"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="fw-bold text-white"><?php echo htmlspecialchars($song['title']); ?></div>
                                    <div class="text-muted small">Uploaded: <?php echo date('M d, Y', strtotime($song['created_at'])); ?></div>
                                </td>
                                <td>
                                    <span class="text-light"><?php echo htmlspecialchars($song['artist_name'] ?? 'Unknown Artist'); ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-primary px-2 py-1"><?php echo htmlspecialchars($song['category_name'] ?? 'General'); ?></span>
                                </td>
                                <td class="text-muted">
                                    <i class="bi bi-clock me-1"></i><?php echo htmlspecialchars($song['duration'] ?? 'N/A'); ?>
                                </td>
                                <td>
                                    <audio controls preload="none" style="height: 32px; width: 220px; outline: none;">
                                        <source src="<?php echo htmlspecialchars($audioPath); ?>" type="audio/mpeg">
                                        Your browser does not support audio playback.
                                    </audio>
                                </td>
                                <td class="text-end">
                                    <a href="manage_songs.php?delete_id=<?php echo (int)$song['id']; ?>" 
                                       class="btn btn-sm btn-outline-danger" 
                                       onclick="return confirm('Are you sure you want to permanently delete \'<?php echo addslashes($song['title']); ?>\'?');"
                                       title="Delete Track">
                                        <i class="fa fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="py-4">
                                    <i class="fa fa-music fa-3x text-muted mb-3 d-block"></i>
                                    <h5 class="text-white">No songs found</h5>
                                    <p class="text-muted small">
                                        <?php if (!empty($search)): ?>
                                            No tracks matched your query "<?php echo htmlspecialchars($search); ?>".
                                        <?php else: ?>
                                            There are no tracks uploaded yet. Start by adding your first song.
                                        <?php endif; ?>
                                    </p>
                                    <a href="add_song.php" class="btn btn-primary btn-sm mt-2">
                                        <i class="fa fa-plus me-1"></i>Upload Song
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
if (isset($queryStmt)) {
    mysqli_stmt_close($queryStmt);
}
require_once("base/footer.php");
?>