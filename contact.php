<?php
require_once("base/header.php");

$messageSent = false;
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['contact_submit'])) {
    $contactName = trim($_POST['name'] ?? '');
    $contactEmail = trim($_POST['email'] ?? '');
    $contactMessage = trim($_POST['message'] ?? '');

    if (!empty($contactName) && !empty($contactEmail) && !empty($contactMessage)) {
        $messageSent = true;
    }
}
?>

<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="index.php"><i class="fa fa-home"></i> Home</a>
                    <span>Contact</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="map">
    <div class="container">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2942.5524090066037!2d-71.10245469994108!3d42.47980730490846!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89e3748250c43a43%3A0xe1b9879a5e9b6657!2sWinter%20Street%20Public%20Parking%20Lot!5e0!3m2!1sen!2sbd!4v1577299251173!5m2!1sen!2sbd"
            height="500" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</div>

<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="contact__address">
                    <div class="section-title">
                        <h2>Contact Info</h2>
                    </div>
                    <p>Have questions about bookings, track licenses, or collaboration opportunities? Reach out to our music studio team.</p>
                    <ul>
                        <li>
                            <i class="fa fa-map-marker"></i>
                            <h5>Studio Address</h5>
                            <p>742 Evergreen Terrace, Suite 100, Los Angeles, CA</p>
                        </li>
                        <li>
                            <i class="fa fa-phone"></i>
                            <h5>Studio Hotline</h5>
                            <span>+1 (800) 555-0199</span>
                            <span>+1 (800) 555-0144</span>
                        </li>
                        <li>
                            <i class="fa fa-envelope"></i>
                            <h5>Direct Inquiries</h5>
                            <p>support@soundwaves.com</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="contact__form">
                    <div class="section-title">
                        <h2>Get In Touch</h2>
                    </div>
                    <p>Send us a direct message and our artists management representative will respond within 24 hours.</p>

                    <?php if ($messageSent): ?>
                        <div class="alert alert-success" role="alert">
                            Thank you for your message! Our team will get back to you shortly.
                        </div>
                    <?php endif; ?>

                    <form action="contact.php" method="POST">
                        <div class="input__list">
                            <input type="text" name="name" placeholder="Your Name" required>
                            <input type="email" name="email" placeholder="Your Email" required>
                            <input type="text" name="subject" placeholder="Subject">
                        </div>
                        <textarea name="message" placeholder="Write your message here..." required></textarea>
                        <button type="submit" name="contact_submit" class="site-btn">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once("base/footer.php");
?>