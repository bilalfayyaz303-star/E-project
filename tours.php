<?php
require_once("base/header.php");
?>

<section class="countdown countdown--page spad set-bg" data-setbg="img/countdown-bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="countdown__text">
                    <h1>Sound Waves World Tour</h1>
                    <h4>Music festival countdown</h4>
                </div>
                <div class="countdown__timer" id="countdown-time">
                    <div class="countdown__item">
                        <span>14</span>
                        <p>days</p>
                    </div>
                    <div class="countdown__item">
                        <span>08</span>
                        <p>hours</p>
                    </div>
                    <div class="countdown__item">
                        <span>42</span>
                        <p>minutes</p>
                    </div>
                    <div class="countdown__item">
                        <span>15</span>
                        <p>seconds</p>
                    </div>
                </div>
                <div class="buy__tickets">
                    <a href="contact.php" class="primary-btn">Reserve Passes</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="tours spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 order-lg-1">
                <div class="tours__item__text">
                    <h2>Electric Horizon Festival</h2>
                    <div class="tours__text__widget">
                        <ul>
                            <li>
                                <i class="fa fa-clock-o"></i>
                                <span>8:00pm</span>
                                <span>Nov 20, 2026</span>
                            </li>
                            <li>
                                <i class="fa fa-map-marker"></i>
                                Funkhaus Berlin, Berlin, Germany
                            </li>
                        </ul>
                        <div class="price">$ 45.00</div>
                    </div>
                    <div class="tours__text__desc">
                        <p>Held in Europe’s electronic music capital, featuring premier acoustic sets and DJ collaborations.</p>
                        <p>An evening showcasing sound system innovation and curated headline live sets.</p>
                    </div>
                    <a href="contact.php" class="primary-btn border-btn">Book Tickets</a>
                </div>
            </div>
            <div class="col-lg-6 order-lg-2">
                <div class="tours__item__pic">
                    <img src="img/tours/tour-1.jpg" alt="Tour 1">
                </div>
            </div>
            <div class="col-lg-6 order-lg-4">
                <div class="tours__item__text tours__item__text--right">
                    <h2>Sunset Acoustic Arena</h2>
                    <div class="tours__text__widget">
                        <ul>
                            <li>
                                <i class="fa fa-clock-o"></i>
                                <span>7:30pm</span>
                                <span>Dec 05, 2026</span>
                            </li>
                            <li>
                                <i class="fa fa-map-marker"></i>
                                Greek Theatre, Los Angeles, CA
                            </li>
                        </ul>
                        <div class="price">$ 55.00</div>
                    </div>
                    <div class="tours__text__desc">
                        <p>Under the stars with intimate arrangements from our celebrated roster of vocalists and instrumentalists.</p>
                        <p>A memorable sonic experience crafted specifically for live concert lovers.</p>
                    </div>
                    <a href="contact.php" class="primary-btn border-btn">Book Tickets</a>
                </div>
            </div>
            <div class="col-lg-6 order-lg-3">
                <div class="tours__item__pic tours__item__pic--left">
                    <img src="img/tours/tour-2.jpg" alt="Tour 2">
                </div>
            </div>
            <div class="col-lg-6 order-lg-5">
                <div class="tours__item__text">
                    <h2>Winter Bass Summit</h2>
                    <div class="tours__text__widget">
                        <ul>
                            <li>
                                <i class="fa fa-clock-o"></i>
                                <span>9:00pm</span>
                                <span>Dec 31, 2026</span>
                            </li>
                            <li>
                                <i class="fa fa-map-marker"></i>
                                O2 Arena, London, UK
                            </li>
                        </ul>
                        <div class="price">$ 65.00</div>
                    </div>
                    <div class="tours__text__desc">
                        <p>Ring in the New Year with the biggest bass drops, synth progressions, and audiovisual spectacles.</p>
                        <p>Complete with immersive light mapping and exclusive track premieres.</p>
                    </div>
                    <a href="contact.php" class="primary-btn border-btn">Book Tickets</a>
                </div>
            </div>
            <div class="col-lg-6 order-lg-6">
                <div class="tours__item__pic tours__item__pic--last">
                    <img src="img/tours/tour-3.jpg" alt="Tour 3">
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once("base/footer.php");
?>