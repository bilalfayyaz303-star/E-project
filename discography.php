<?php
require_once("base/header.php");
require_once("dashboard/config/db.php");

$selectedCat = (int)($_GET['category'] ?? 0);

if ($selectedCat > 0) {
    $stmt = mysqli_prepare($conn, "SELECT songs.*, artists.artist_name, categories.category_name 
                                   FROM songs 
                                   LEFT JOIN artists ON songs.artist_id = artists.id 
                                   LEFT JOIN categories ON songs.category_id = categories.id 
                                   WHERE songs.category_id = ? 
                                   ORDER BY songs.id DESC");
    mysqli_stmt_bind_param($stmt, "i", $selectedCat);
    mysqli_stmt_execute($stmt);
    $songsResult = mysqli_stmt_get_result($stmt);
} else {
    $query = "SELECT songs.*, artists.artist_name, categories.category_name 
              FROM songs 
              LEFT JOIN artists ON songs.artist_id = artists.id 
              LEFT JOIN categories ON songs.category_id = categories.id 
              ORDER BY songs.id DESC";
    $songsResult = mysqli_query($conn, $query);
}

$categoriesList = mysqli_query($conn, "SELECT id, category_name FROM categories ORDER BY category_name ASC");
?>

<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="index.php"><i class="fa fa-home"></i> Home</a>
                    <span>Discography</span>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="discography spad">
    <div class="container">
        <div class="row align-items-center mb-4">
            <div class="col-lg-6 col-md-6">
                <div class="section-title mb-0">
                    <h2>Our Catalog</h2>
                    <h1>Discography</h1>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 text-md-right mt-3 mt-md-0">
                <div class="d-inline-flex align-items-center">
                    <a href="discography.php" class="btn btn-sm <?php echo $selectedCat === 0 ? 'btn-danger' : 'btn-outline-secondary text-white'; ?> mr-2">All Genres</a>
                    <?php if ($categoriesList): ?>
                        <?php while ($cat = mysqli_fetch_assoc($categoriesList)): ?>
                            <a href="discography.php?category=<?php echo (int)$cat['id']; ?>" class="btn btn-sm <?php echo $selectedCat === (int)$cat['id'] ? 'btn-danger' : 'btn-outline-secondary text-white'; ?> mr-2">
                                <?php echo htmlspecialchars($cat['category_name']); ?>
                            </a>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="row">
            <?php if ($songsResult && mysqli_num_rows($songsResult) > 0): ?>
                <?php while ($song = mysqli_fetch_assoc($songsResult)): ?>
                    <?php
                    $coverFile = ltrim($song['cover_image'], '/');
                    $audioFile = ltrim($song['audio_file'], '/');
                    $coverExists = !empty($song['cover_image']) && file_exists(__DIR__ . '/' . $coverFile);
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                        <div class="discography__item" style="background: #191c24; border-radius: 8px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
                            <div class="discography__item__pic" style="height: 250px; position: relative; overflow: hidden; background: #262934;">
                                <?php if ($coverExists): ?>
                                    <img src="<?php echo htmlspecialchars($coverFile); ?>" alt="<?php echo htmlspecialchars($song['title']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-music fa-3x text-danger opacity-50"></i>
                                    </div>
                                <?php endif; ?>
                                <span style="position: absolute; top: 12px; right: 12px; background: #df3079; color: #fff; padding: 4px 10px; font-size: 11px; font-weight: 700; border-radius: 3px; text-transform: uppercase;">
                                    <?php echo htmlspecialchars($song['category_name'] ?? 'Music'); ?>
                                </span>
                            </div>
                            <div class="discography__item__text" style="padding: 20px;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span style="color: #df3079; font-weight: 700; font-size: 14px;">
                                        <?php echo htmlspecialchars($song['artist_name'] ?? 'Sound Waves Artist'); ?>
                                    </span>
                                    <span style="color: #8c92a4; font-size: 13px;">
                                        <i class="fa fa-clock-o mr-1"></i><?php echo htmlspecialchars($song['duration'] ?? ''); ?>
                                    </span>
                                </div>
                                <h4 style="color: #ffffff; font-size: 20px; font-weight: 700; margin-bottom: 15px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <?php echo htmlspecialchars($song['title']); ?>
                                </h4>
                                <audio controls preload="none" style="width: 100%; height: 35px; outline: none;">
                                    <source src="<?php echo htmlspecialchars($audioFile); ?>" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="text-center py-5" style="background: #191c24; border-radius: 8px;">
                        <i class="fa fa-music fa-3x text-muted mb-3"></i>
                        <h4 class="text-white">No tracks found in this category</h4>
                        <p class="text-muted">Explore other categories or check back later for new releases.</p>
                        <a href="discography.php" class="btn btn-outline-danger btn-sm mt-2">View All Categories</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
if (isset($stmt)) {
    mysqli_stmt_close($stmt);
}
require_once("base/footer.php");
?>