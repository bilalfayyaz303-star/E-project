<?php
require_once("base/header.php");
require_once("dashboard/config/db.php");

$query = "SELECT songs.*, artists.artist_name, categories.category_name 
          FROM songs 
          LEFT JOIN artists ON songs.artist_id = artists.id 
          LEFT JOIN categories ON songs.category_id = categories.id 
          ORDER BY songs.id DESC";

$songsResult = mysqli_query($conn, $query);
?>

<section class="hero spad set-bg" data-setbg="img/hero-bg.png" style="position: relative; padding: 120px 0 90px 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="hero__text">
                    <span style="color: #df3079; text-transform: uppercase; font-size: 16px; letter-spacing: 2px; font-weight: 700; display: block; margin-bottom: 12px;">Welcome to Sound Waves</span>
                    <h1 style="color: #ffffff; font-size: 56px; font-weight: 700; line-height: 1.15; margin-bottom: 24px;">Feel the Beat, Live the Music</h1>
                    <p style="color: #c4c4c4; font-size: 16px; line-height: 1.6; margin-bottom: 32px; max-width: 520px;">Stream the latest tracks, discover emerging artists, and explore our collection of music across all genres.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#trending-songs" class="primary-btn" style="background: #df3079; color: #fff; padding: 14px 32px; font-weight: 700; text-transform: uppercase; border-radius: 4px; text-decoration: none; margin-right: 15px;">Listen Now</a>
                        <a href="discography.php" class="primary-btn" style="background: transparent; border: 2px solid #ffffff; color: #fff; padding: 12px 30px; font-weight: 700; text-transform: uppercase; border-radius: 4px; text-decoration: none;">Discography</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-center">
                <img src="img/about/about.png" alt="Sound Waves Artist" class="img-fluid" style="max-height: 420px; filter: drop-shadow(0 15px 30px rgba(223, 48, 121, 0.3));">
            </div>
        </div>
    </div>
</section>

<section id="trending-songs" class="spad" style="background: #111111; padding: 80px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title center-title text-center mb-5">
                    <h2 style="color: #df3079; text-transform: uppercase; font-size: 16px; letter-spacing: 2px; font-weight: 700;">Latest Releases</h2>
                    <h1 style="color: #ffffff; font-size: 42px; font-weight: 700; margin-top: 8px;">Trending Tracks</h1>
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
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="song-card h-100" style="background: #1b1c24; border-radius: 8px; overflow: hidden; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4); display: flex; flex-direction: column; transition: transform 0.3s ease;">
                            <div style="position: relative; height: 240px; background: #262934; overflow: hidden;">
                                <?php if ($coverExists): ?>
                                    <img src="<?php echo htmlspecialchars($coverFile); ?>" alt="<?php echo htmlspecialchars($song['title']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1b1c24, #2a2e3d);">
                                        <i class="fa fa-music fa-4x" style="color: #df3079; opacity: 0.6;"></i>
                                    </div>
                                <?php endif; ?>
                                <span style="position: absolute; top: 15px; right: 15px; background: #df3079; color: #fff; padding: 4px 12px; font-size: 12px; font-weight: 700; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px;">
                                    <?php echo htmlspecialchars($song['category_name'] ?? 'Music'); ?>
                                </span>
                            </div>

                            <div style="padding: 22px; display: flex; flex-direction: column; flex-grow: 1; justify-content: space-between;">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h4 style="color: #ffffff; font-size: 20px; font-weight: 700; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 75%;">
                                            <?php echo htmlspecialchars($song['title']); ?>
                                        </h4>
                                        <span style="color: #8c92a4; font-size: 13px;">
                                            <i class="fa fa-clock-o me-1"></i><?php echo htmlspecialchars($song['duration'] ?? ''); ?>
                                        </span>
                                    </div>
                                    <p style="color: #8c92a4; font-size: 14px; margin-bottom: 18px;">
                                        <i class="fa fa-user me-1" style="color: #df3079;"></i>
                                        <?php echo htmlspecialchars($song['artist_name'] ?? 'Sound Waves Artist'); ?>
                                    </p>
                                </div>

                                <div>
                                    <audio controls preload="none" style="width: 100%; height: 38px; outline: none; border-radius: 20px;">
                                        <source src="<?php echo htmlspecialchars($audioFile); ?>" type="audio/mpeg">
                                        Your browser does not support audio element.
                                    </audio>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div style="background: #1b1c24; border-radius: 8px; padding: 60px 20px; text-align: center; border: 1px dashed #3a3f50;">
                        <i class="fa fa-music fa-3x mb-3" style="color: #df3079;"></i>
                        <h4 style="color: #ffffff; margin-bottom: 10px;">No Songs Available Right Now</h4>
                        <p style="color: #8c92a4; max-width: 480px; margin: 0 auto 20px;">Our catalog is being updated. Head over to the dashboard to upload new tracks.</p>
                        <a href="dashboard/add_song.php" class="primary-btn" style="background: #df3079; color: #fff; padding: 10px 24px; font-weight: 600; text-transform: uppercase; border-radius: 4px; text-decoration: none;">
                            Upload First Song
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
require_once("base/footer.php");
?>