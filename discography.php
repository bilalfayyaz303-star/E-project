
<?php

require_once("base/header.php");
require_once("dashboard/config/db.php");


/*
|--------------------------------------------------------------------------
| FILTERS
|--------------------------------------------------------------------------
*/

$selectedArtist = (int)($_GET['artist_id'] ?? 0);

$selectedCategory = (int)($_GET['category_id'] ?? 0);


/*
|--------------------------------------------------------------------------
| OLD CATEGORY URL SUPPORT
|--------------------------------------------------------------------------
*/

if ($selectedCategory === 0 && isset($_GET['category'])) {
    $selectedCategory = (int)$_GET['category'];
}


/*
|--------------------------------------------------------------------------
| SONGS QUERY
|--------------------------------------------------------------------------
*/

$songsResult = false;

if ($selectedArtist > 0 && $selectedCategory > 0) {

    $stmt = mysqli_prepare(
        $conn,
        "SELECT
            songs.*,
            artists.artist_name,
            categories.category_name
         FROM songs
         LEFT JOIN artists
            ON songs.artist_id = artists.id
         LEFT JOIN categories
            ON songs.category_id = categories.id
         WHERE songs.artist_id = ?
         AND songs.category_id = ?
         ORDER BY songs.id DESC"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $selectedArtist,
        $selectedCategory
    );

    mysqli_stmt_execute($stmt);

    $songsResult = mysqli_stmt_get_result($stmt);

} elseif ($selectedArtist > 0) {

    $stmt = mysqli_prepare(
        $conn,
        "SELECT
            songs.*,
            artists.artist_name,
            categories.category_name
         FROM songs
         LEFT JOIN artists
            ON songs.artist_id = artists.id
         LEFT JOIN categories
            ON songs.category_id = categories.id
         WHERE songs.artist_id = ?
         ORDER BY songs.id DESC"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $selectedArtist
    );

    mysqli_stmt_execute($stmt);

    $songsResult = mysqli_stmt_get_result($stmt);

} elseif ($selectedCategory > 0) {

    $stmt = mysqli_prepare(
        $conn,
        "SELECT
            songs.*,
            artists.artist_name,
            categories.category_name
         FROM songs
         LEFT JOIN artists
            ON songs.artist_id = artists.id
         LEFT JOIN categories
            ON songs.category_id = categories.id
         WHERE songs.category_id = ?
         ORDER BY songs.id DESC"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $selectedCategory
    );

    mysqli_stmt_execute($stmt);

    $songsResult = mysqli_stmt_get_result($stmt);

} else {

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
    ";

    $songsResult = mysqli_query($conn, $query);
}


/*
|--------------------------------------------------------------------------
| CATEGORIES
|--------------------------------------------------------------------------
*/

$categoriesList = mysqli_query(
    $conn,
    "SELECT id, category_name
     FROM categories
     ORDER BY category_name ASC"
);


/*
|--------------------------------------------------------------------------
| ARTISTS
|--------------------------------------------------------------------------
*/

$artistsList = mysqli_query(
    $conn,
    "SELECT id, artist_name
     FROM artists
     ORDER BY artist_name ASC"
);

?>

<!-- =========================================================
     BREADCRUMB
========================================================= -->

<div class="breadcrumb-option">

    <div class="container">

        <div class="row">

            <div class="col-lg-12">

                <div class="breadcrumb__links">

                    <a href="index.php">
                        <i class="fa fa-home"></i>
                        Home
                    </a>

                    <span>Discography</span>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     DISCOGRAPHY
========================================================= -->

<section class="discography spad">

    <div class="container">

        <!-- TITLE -->

        <div class="row align-items-center mb-4">

            <div class="col-lg-5 col-md-12">

                <div class="section-title mb-0">

                    <h2>Our Catalog</h2>

                    <h1>Discography</h1>

                </div>

            </div>


            <!-- CATEGORY FILTER -->

            <div class="col-lg-7 col-md-12 text-lg-right mt-3 mt-lg-0">

                <div
                    class="d-flex flex-wrap justify-content-lg-end"
                    style="gap:8px;"
                >

                    <!-- ALL SONGS -->

                    <a
                        href="discography.php"
                        class="btn btn-sm <?php
                        echo (
                            $selectedArtist === 0 &&
                            $selectedCategory === 0
                        )
                            ? 'btn-danger'
                            : 'btn-outline-secondary text-white';
                        ?>"
                    >
                        All Songs
                    </a>


                    <?php if ($categoriesList): ?>

                        <?php while ($cat = mysqli_fetch_assoc($categoriesList)): ?>

                            <a
                                href="discography.php?category_id=<?php echo (int)$cat['id']; ?>"
                                class="btn btn-sm <?php
                                echo (
                                    $selectedCategory === (int)$cat['id']
                                )
                                    ? 'btn-danger'
                                    : 'btn-outline-secondary text-white';
                                ?>"
                            >
                                <?php
                                echo htmlspecialchars(
                                    $cat['category_name'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>
                            </a>

                        <?php endwhile; ?>

                    <?php endif; ?>

                </div>

            </div>

        </div>


        <!-- ACTIVE FILTER -->

        <?php if ($selectedArtist > 0 || $selectedCategory > 0): ?>

            <div class="row mb-4">

                <div class="col-12">

                    <div
                        style="
                            background:#191c24;
                            padding:15px 20px;
                            border-radius:6px;
                            border-left:4px solid #df3079;
                        "
                    >

                        <span style="color:#8c92a4;">
                            Showing filtered songs
                        </span>

                        <a
                            href="discography.php"
                            style="
                                float:right;
                                color:#df3079;
                                font-weight:700;
                                text-decoration:none;
                            "
                        >
                            <i class="fa fa-times"></i>
                            Clear Filter
                        </a>

                    </div>

                </div>

            </div>

        <?php endif; ?>


        <!-- SONGS -->

        <div class="row">

            <?php if ($songsResult && mysqli_num_rows($songsResult) > 0): ?>

                <?php while ($song = mysqli_fetch_assoc($songsResult)): ?>

                    <?php

                    $coverFile = ltrim(
                        $song['cover_image'] ?? '',
                        '/'
                    );

                    $audioFile = ltrim(
                        $song['audio_file'] ?? '',
                        '/'
                    );

                    $coverExists = false;

                    if (!empty($coverFile)) {

                        $coverExists = file_exists(
                            __DIR__ . '/' . $coverFile
                        );

                    }

                    ?>


                    <!-- SONG CARD -->

                    <div class="col-lg-4 col-md-6 col-sm-6 mb-4">

                        <div
                            class="discography__item"
                            style="
                                background:#191c24;
                                border-radius:8px;
                                overflow:hidden;
                                box-shadow:0 5px 15px rgba(0,0,0,0.3);
                                height:100%;
                            "
                        >

                            <!-- COVER -->

                            <div
                                class="discography__item__pic"
                                style="
                                    height:250px;
                                    position:relative;
                                    overflow:hidden;
                                    background:#262934;
                                "
                            >

                                <?php if ($coverExists): ?>

                                    <img
                                        src="<?php
                                        echo htmlspecialchars(
                                            $coverFile,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                        ?>"
                                        alt="<?php
                                        echo htmlspecialchars(
                                            $song['title'] ?? 'Song',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                        ?>"
                                        style="
                                            width:100%;
                                            height:100%;
                                            object-fit:cover;
                                        "
                                    >

                                <?php else: ?>

                                    <div
                                        style="
                                            width:100%;
                                            height:100%;
                                            display:flex;
                                            align-items:center;
                                            justify-content:center;
                                        "
                                    >

                                        <i
                                            class="fa fa-music fa-3x text-danger"
                                            style="opacity:.5;"
                                        ></i>

                                    </div>

                                <?php endif; ?>


                                <!-- CATEGORY -->

                                <span
                                    style="
                                        position:absolute;
                                        top:12px;
                                        right:12px;
                                        background:#df3079;
                                        color:#fff;
                                        padding:4px 10px;
                                        font-size:11px;
                                        font-weight:700;
                                        border-radius:3px;
                                        text-transform:uppercase;
                                    "
                                >

                                    <?php
                                    echo htmlspecialchars(
                                        $song['category_name'] ?? 'Music',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );
                                    ?>

                                </span>

                            </div>


                            <!-- SONG DETAILS -->

                            <div
                                class="discography__item__text"
                                style="padding:20px;"
                            >

                                <div
                                    class="d-flex justify-content-between align-items-center mb-1"
                                >

                                    <!-- ARTIST -->

                                    <span
                                        style="
                                            color:#df3079;
                                            font-weight:700;
                                            font-size:14px;
                                        "
                                    >

                                        <?php
                                        echo htmlspecialchars(
                                            $song['artist_name']
                                                ?? 'Sound Waves Artist',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                        ?>

                                    </span>


                                    <!-- DURATION -->

                                    <?php if (!empty($song['duration'])): ?>

                                        <span
                                            style="
                                                color:#8c92a4;
                                                font-size:13px;
                                            "
                                        >

                                            <i class="fa fa-clock-o mr-1"></i>

                                            <?php
                                            echo htmlspecialchars(
                                                $song['duration'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            );
                                            ?>

                                        </span>

                                    <?php endif; ?>

                                </div>


                                <!-- TITLE -->

                                <h4
                                    style="
                                        color:#ffffff;
                                        font-size:20px;
                                        font-weight:700;
                                        margin-bottom:15px;
                                        white-space:nowrap;
                                        overflow:hidden;
                                        text-overflow:ellipsis;
                                    "
                                >

                                    <?php
                                    echo htmlspecialchars(
                                        $song['title'] ?? 'Untitled Song',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );
                                    ?>

                                </h4>


                                <!-- AUDIO -->

                                <?php if (!empty($audioFile)): ?>

                                    <audio
                                        controls
                                        preload="none"
                                        style="
                                            width:100%;
                                            height:35px;
                                            outline:none;
                                        "
                                    >

                                        <source
                                            src="<?php
                                            echo htmlspecialchars(
                                                $audioFile,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            );
                                            ?>"
                                            type="audio/mpeg"
                                        >

                                        Your browser does not support
                                        the audio element.

                                    </audio>

                                <?php else: ?>

                                    <p
                                        style="
                                            color:#8c92a4;
                                            margin:0;
                                            font-size:13px;
                                        "
                                    >
                                        Audio file not available.
                                    </p>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                <?php endwhile; ?>


            <?php else: ?>

                <!-- NO SONGS -->

                <div class="col-12">

                    <div
                        class="text-center py-5"
                        style="
                            background:#191c24;
                            border-radius:8px;
                        "
                    >

                        <i
                            class="fa fa-music fa-3x text-muted mb-3"
                        ></i>

                        <h4 class="text-white">
                            No tracks found
                        </h4>

                        <p class="text-muted">
                            Explore other categories or check back later
                            for new releases.
                        </p>

                        <a
                            href="discography.php"
                            class="btn btn-outline-danger btn-sm mt-2"
                        >
                            View All Songs
                        </a>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</section>


<?php

if (isset($stmt) && $stmt) {
    mysqli_stmt_close($stmt);
}

require_once("base/footer.php");

?>

