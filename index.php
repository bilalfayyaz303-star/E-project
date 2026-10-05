<?php
require_once("base/header.php");
require_once("dashboard/config/db.php");

/* =========================
   LATEST SONGS
========================= */

$query = "
    SELECT 
        songs.*,
        artists.artist_name,
        categories.category_name
    FROM songs
    LEFT JOIN artists 
        ON songs.artist_id = artists.id
    LEFT JOIN categories 
        ON songs.category_id = categories.id
    ORDER BY songs.id DESC
    LIMIT 6
";

$songsResult = mysqli_query($conn, $query);


/* =========================
   COUNTS
========================= */

$songCount = 0;
$artistCount = 0;
$categoryCount = 0;

/* Songs */
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM songs");
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $songCount = (int)$row['total'];
}

/* Artists */
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM artists");
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $artistCount = (int)$row['total'];
}

/* Categories */
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM categories");
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $categoryCount = (int)$row['total'];
}
?>

<style>
/* =====================================================
   SOUND WAVES HOME PAGE ONLY
===================================================== */

/* HERO */
.sw-home-hero {
    position: relative;
    min-height: 650px;
    padding: 110px 0 90px;
    display: flex;
    align-items: center;
    background:
        linear-gradient(
            90deg,
            rgba(22, 3, 38, 0.96),
            rgba(22, 3, 38, 0.78),
            rgba(22, 3, 38, 0.35)
        ),
        url("img/hero-bg.png") center center / cover no-repeat;
    overflow: hidden;
}

.sw-home-content {
    position: relative;
    z-index: 2;
}

.sw-home-subtitle {
    display: block;
    color: #df3079;
    font-size: 15px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    margin-bottom: 15px;
}

.sw-home-title {
    color: #ffffff;
    font-size: 58px;
    line-height: 1.12;
    font-weight: 700;
    margin: 0 0 22px;
}

.sw-home-title span {
    color: #df3079;
}

.sw-home-description {
    color: #c7c2cb;
    font-size: 16px;
    line-height: 1.8;
    max-width: 560px;
    margin-bottom: 30px;
}

/* HERO BUTTONS */
.sw-home-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.sw-home-btn {
    display: inline-block;
    padding: 14px 28px;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    text-decoration: none !important;
    transition: all 0.3s ease;
}

.sw-home-btn-primary {
    background: #df3079;
    color: #ffffff !important;
}

.sw-home-btn-primary:hover {
    background: #ffffff;
    color: #df3079 !important;
}

.sw-home-btn-outline {
    border: 1px solid rgba(255,255,255,0.5);
    color: #ffffff !important;
    background: transparent;
}

.sw-home-btn-outline:hover {
    background: #ffffff;
    color: #290849 !important;
}

/* HERO IMAGE */
.sw-home-image {
    position: relative;
    z-index: 2;
    text-align: center;
}

.sw-home-image img {
    width: 100%;
    max-width: 470px;
    max-height: 480px;
    object-fit: contain;
    filter: drop-shadow(0 20px 35px rgba(0,0,0,0.55));
}

/* STATISTICS */
.sw-home-stats {
    background: #290849;
    padding: 25px 0;
}

.sw-home-stat {
    text-align: center;
    padding: 8px 15px;
}

.sw-home-stat-number {
    display: block;
    color: #df3079;
    font-size: 28px;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 7px;
}

.sw-home-stat-label {
    color: #d2ccd8;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
}

/* SONG SECTION */
.sw-home-songs {
    background: #111111;
    padding: 85px 0 100px;
    position: relative;
    z-index: 1;
}

.sw-home-heading {
    text-align: center;
    margin-bottom: 45px;
}

.sw-home-heading-small {
    display: block;
    color: #df3079;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.sw-home-heading h2 {
    color: #ffffff;
    font-size: 40px;
    font-weight: 700;
    margin: 0;
}

.sw-home-heading p {
    color: #99939f;
    font-size: 15px;
    max-width: 600px;
    margin: 12px auto 0;
}

/* ROW FLEX FOR EQUAL CARD HEIGHTS */
#sw-latest-songs .row {
    display: flex;
    flex-wrap: wrap;
}

#sw-latest-songs .row > [class*='col-'] {
    display: flex;
    flex-direction: column;
}

/* SONG CARD - FIXED EQUAL HEIGHT & FLEXBOX */
.sw-song-card {
    display: flex;
    flex-direction: column;
    width: 100%;
    height: 100%;
    background: #1b1a22;
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.sw-song-card:hover {
    transform: translateY(-6px);
    border-color: rgba(223,48,121,0.35);
    box-shadow: 0 15px 35px rgba(0,0,0,0.35);
}

/* COVER IMAGE FIX */
.sw-song-cover {
    position: relative;
    width: 100%;
    height: 220px;
    flex-shrink: 0;
    overflow: hidden;
    background: #272532;
}

.sw-song-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.sw-song-card:hover .sw-song-cover img {
    transform: scale(1.05);
}

/* PLACEHOLDER */
.sw-song-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #21172a, #302137);
}

.sw-song-placeholder i {
    color: #df3079;
    font-size: 55px;
    opacity: 0.65;
}

/* CATEGORY BADGE */
.sw-song-category {
    position: absolute;
    top: 14px;
    right: 14px;
    background: #df3079;
    color: #ffffff;
    padding: 5px 11px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    max-width: 75%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    z-index: 2;
}

/* CARD BODY */
.sw-song-body {
    padding: 20px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    justify-content: space-between;
}

.sw-song-title {
    color: #ffffff;
    font-size: 18px;
    font-weight: 700;
    margin: 0 0 8px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.sw-song-artist {
    color: #99939f;
    font-size: 13px;
    margin: 0 0 20px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.sw-song-artist i {
    color: #df3079;
    margin-right: 5px;
}

/* AUDIO PLAYER STYLING */
.sw-song-audio {
    width: 100% !important;
    max-width: 100% !important;
    height: 38px;
    display: block;
    margin-top: auto;
    border-radius: 20px;
    outline: none;
}

/* VIEW ALL */
.sw-home-view-all {
    text-align: center;
    margin-top: 40px;
}

.sw-home-view-btn {
    display: inline-block;
    border: 1px solid #df3079;
    color: #ffffff !important;
    padding: 13px 28px;
    text-decoration: none !important;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: all 0.3s ease;
}

.sw-home-view-btn:hover {
    background: #df3079;
    color: #ffffff !important;
}

/* EMPTY SONGS */
.sw-home-empty {
    text-align: center;
    background: #1b1a22;
    border: 1px dashed #3c3544;
    padding: 60px 20px;
}

.sw-home-empty i {
    color: #df3079;
    font-size: 45px;
    margin-bottom: 15px;
}

.sw-home-empty h3 {
    color: #ffffff;
    font-size: 22px;
    margin-bottom: 8px;
}

.sw-home-empty p {
    color: #99939f;
    margin: 0;
}

/* RESPONSIVE */
@media (max-width: 991px) {
    .sw-home-title { font-size: 48px; }
    .sw-home-image { margin-top: 40px; }
}

@media (max-width: 767px) {
    .sw-home-hero { min-height: auto; padding: 80px 0 70px; }
    .sw-home-title { font-size: 38px; }
    .sw-home-description { font-size: 15px; }
    .sw-home-buttons { display: block; }
    .sw-home-btn { display: block; text-align: center; margin-bottom: 10px; }
    .sw-home-heading h2 { font-size: 32px; }
    .sw-home-songs { padding: 65px 0 70px; }
    .sw-song-cover { height: 220px; }
}

@media (max-width: 480px) {
    .sw-home-title { font-size: 33px; }
    .sw-home-heading h2 { font-size: 28px; }
}
</style>

<!-- HOME HERO -->
<section class="sw-home-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="sw-home-content">
                    <span class="sw-home-subtitle">Welcome to Sound Waves</span>
                    <h1 class="sw-home-title">
                        Feel the Beat.<br>
                        <span>Live the Music.</span>
                    </h1>
                    <p class="sw-home-description">
                        Discover amazing music, explore talented artists,
                        and enjoy your favorite tracks all in one place.
                        Your music journey starts here.
                    </p>
                    <div class="sw-home-buttons">
                        <a href="#sw-latest-songs" class="sw-home-btn sw-home-btn-primary">
                            <i class="fa fa-play"></i>&nbsp; Listen Now
                        </a>
                        <a href="discography.php" class="sw-home-btn sw-home-btn-outline">
                            Explore Music
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="sw-home-image">
                    <img src="img/about/about.png" alt="Sound Waves">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STATISTICS -->
<section class="sw-home-stats">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="sw-home-stat">
                    <span class="sw-home-stat-number"><?php echo $songCount; ?></span>
                    <span class="sw-home-stat-label">Songs</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sw-home-stat">
                    <span class="sw-home-stat-number"><?php echo $artistCount; ?></span>
                    <span class="sw-home-stat-label">Artists</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sw-home-stat">
                    <span class="sw-home-stat-number"><?php echo $categoryCount; ?></span>
                    <span class="sw-home-stat-label">Categories</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- LATEST SONGS -->
<section id="sw-latest-songs" class="sw-home-songs">
    <div class="container">
        <div class="sw-home-heading">
            <span class="sw-home-heading-small">Fresh From The Studio</span>
            <h2>Latest Tracks</h2>
            <p>Explore the newest songs added to our Sound Waves music collection.</p>
        </div>

        <div class="row">
            <?php if ($songsResult && mysqli_num_rows($songsResult) > 0): ?>
                <?php while ($song = mysqli_fetch_assoc($songsResult)): ?>
                    <?php
                    $coverFile = ltrim((string)($song['cover_image'] ?? ''), '/');
                    $audioFile = ltrim((string)($song['audio_file'] ?? ''), '/');

                    $coverExists = false;
                    if ($coverFile !== '') {
                        $coverExists = file_exists(__DIR__ . '/' . $coverFile);
                    }

                    $songTitle = $song['title'] ?? 'Untitled Song';
                    $artistName = $song['artist_name'] ?? 'Unknown Artist';
                    $categoryName = $song['category_name'] ?? 'Music';
                    $duration = $song['duration'] ?? '';
                    ?>

                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="sw-song-card">
                            <!-- COVER -->
                            <div class="sw-song-cover">
                                <?php if ($coverExists): ?>
                                    <img src="<?php echo htmlspecialchars($coverFile); ?>" alt="<?php echo htmlspecialchars($songTitle); ?>">
                                <?php else: ?>
                                    <div class="sw-song-placeholder">
                                        <i class="fa fa-music"></i>
                                    </div>
                                <?php endif; ?>
                                <span class="sw-song-category">
                                    <?php echo htmlspecialchars($categoryName); ?>
                                </span>
                            </div>

                            <!-- BODY -->
                            <div class="sw-song-body">
                                <div>
                                    <h3 class="sw-song-title">
                                        <?php echo htmlspecialchars($songTitle); ?>
                                    </h3>
                                    <p class="sw-song-artist">
                                        <i class="fa fa-user"></i>
                                        <?php echo htmlspecialchars($artistName); ?>
                                        <?php if ($duration !== ''): ?>
                                            &nbsp; • &nbsp;
                                            <i class="fa fa-clock-o"></i>
                                            <?php echo htmlspecialchars($duration); ?>
                                        <?php endif; ?>
                                    </p>
                                </div>

                                <?php if ($audioFile !== ''): ?>
                                    <audio class="sw-song-audio" controls preload="none">
                                        <source src="<?php echo htmlspecialchars($audioFile); ?>" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                <?php else: ?>
                                    <p style="color:#df3079; font-size:13px; margin:0;">
                                        Audio file not available
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="sw-home-empty">
                        <i class="fa fa-music"></i>
                        <h3>No Songs Available</h3>
                        <p>Songs added from the dashboard will automatically appear here.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- VIEW ALL -->
        <?php if ($songCount > 6): ?>
            <div class="sw-home-view-all">
                <a href="discography.php" class="sw-home-view-btn">
                    View All Songs <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
require_once("base/footer.php");
?>