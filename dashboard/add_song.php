<?php
require_once("base/header.php");

$categories = mysqli_query($conn, "SELECT id, category_name FROM categories ORDER BY category_name ASC");
$artists = mysqli_query($conn, "SELECT id, artist_name FROM artists ORDER BY artist_name ASC");

$flashSuccess = $_SESSION['flash_success'] ?? '';
$flashError = $_SESSION['flash_error'] ?? '';
unset($_SESSION['flash_success'], $_SESSION['flash_error']);
?>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4 justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="bg-secondary rounded p-4 p-sm-5 shadow">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 pb-3 border-bottom border-dark">
                    <div>
                        <h4 class="mb-1 text-white"><i class="fa fa-plus-circle text-primary me-2"></i>Add New Song</h4>
                        <p class="text-muted small mb-0">Fill in the track information and upload the audio and cover assets.</p>
                    </div>
                    <div>
                        <a href="manage_songs.php" class="btn btn-outline-light btn-sm">
                            <i class="fa fa-list me-1"></i>View All Songs
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

                <form action="upload_song_process.php" method="POST" enctype="multipart/form-data" class="needs-validation">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="songTitle" class="form-label text-white">Song Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="songTitle" class="form-control bg-dark text-white border-0 py-2" placeholder="e.g. Midnight Memories" required>
                        </div>

                        <div class="col-md-4">
                            <label for="duration" class="form-label text-white">Duration <span class="text-danger">*</span></label>
                            <input type="text" name="duration" id="duration" class="form-control bg-dark text-white border-0 py-2" placeholder="e.g. 03:45" pattern="^[0-9]{1,2}:[0-9]{2}$" title="Format: MM:SS (e.g. 03:45)" required>
                        </div>

                        <div class="col-md-6">
                            <label for="categorySelect" class="form-label text-white">Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="categorySelect" class="form-select bg-dark text-white border-0 py-2" required>
                                <option value="" disabled selected>-- Select Category --</option>
                                <?php if ($categories): ?>
                                    <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                                        <option value="<?php echo (int)$cat['id']; ?>">
                                            <?php echo htmlspecialchars($cat['category_name']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="artistSelect" class="form-label text-white">Artist <span class="text-danger">*</span></label>
                            <select name="artist_id" id="artistSelect" class="form-select bg-dark text-white border-0 py-2" required>
                                <option value="" disabled selected>-- Select Artist --</option>
                                <?php if ($artists): ?>
                                    <?php while ($art = mysqli_fetch_assoc($artists)): ?>
                                        <option value="<?php echo (int)$art['id']; ?>">
                                            <?php echo htmlspecialchars($art['artist_name']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="audioFile" class="form-label text-white">Audio File (MP3, WAV, OGG, M4A) <span class="text-danger">*</span></label>
                            <input type="file" name="audio_file" id="audioFile" class="form-control bg-dark text-white border-0" accept="audio/*,.mp3,.wav,.ogg,.m4a" required>
                            <div class="form-text text-muted">Supported formats: MP3, WAV, OGG, M4A up to 50MB.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="coverImage" class="form-label text-white">Cover Image (JPG, PNG, WEBP) <span class="text-danger">*</span></label>
                            <input type="file" name="cover_image" id="coverImage" class="form-control bg-dark text-white border-0" accept="image/*,.jpg,.jpeg,.png,.webp,.jfif" required>
                            <div class="form-text text-muted">Recommended square dimension (500x500px).</div>
                        </div>

                        <div class="col-12 mt-4 pt-2 border-top border-dark d-flex gap-2">
                            <button type="submit" name="save_song" class="btn btn-primary px-4 py-2 fw-bold">
                                <i class="fa fa-cloud-upload-alt me-2"></i>Save & Publish Track
                            </button>
                            <a href="manage_songs.php" class="btn btn-dark px-4 py-2">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once("base/footer.php");
?>