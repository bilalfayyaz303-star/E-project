<?php
require_once("base/header.php");
?>

<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="index.php"><i class="fa fa-home"></i> Home</a>
                    <span>Blog</span>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="section-title">
                    <h2>Latest Articles</h2>
                    <h1>Music News & Stories</h1>
                </div>
                <div class="blog__large">
                    <div class="blog__large__pic set-bg" data-setbg="img/blog/large-item.jpg">
                        <a href="blog-details.php"><i class="fa fa-share-alt"></i></a>
                    </div>
                    <div class="blog__large__text">
                        <span>Festival Insights</span>
                        <h4><a href="blog-details.php" style="color: #fff; text-decoration: none;">Guidelines for modern music festivals and sound staging - 2026 Edition</a></h4>
                        <p>Explore the evolution of festival stage audio engineering, acoustics calibration, and sound dynamics in outdoor environments.</p>
                        <div class="blog__large__widget">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <ul>
                                        <li>By <span>Sound Waves Editorial</span></li>
                                        <li>Oct 2026</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <ul class="right__widget">
                                        <li>1.2k Views</li>
                                        <li>24 Comments</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic">
                                <img src="img/blog/blog-1.jpg" alt="Blog 1">
                            </div>
                            <div class="blog__item__text">
                                <span>Acoustic Special</span>
                                <h5><a href="blog-details.php" style="color: #fff; text-decoration: none;">World Music Festivals: Unplugged Arrangements and New Voices</a></h5>
                                <ul>
                                    <li>By <span>Sound Waves</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic">
                                <img src="img/blog/blog-2.jpg" alt="Blog 2">
                            </div>
                            <div class="blog__item__text">
                                <span>Behind The Console</span>
                                <h5><a href="blog-details.php" style="color: #fff; text-decoration: none;">How Contemporary Producers Craft Immersive Spatial Mixes</a></h5>
                                <ul>
                                    <li>By <span>Sound Waves</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic">
                                <img src="img/blog/blog-3.jpg" alt="Blog 3">
                            </div>
                            <div class="blog__item__text">
                                <span>Studio Sessions</span>
                                <h5><a href="blog-details.php" style="color: #fff; text-decoration: none;">Analog Warmth vs Digital Precision in Modern Mastering</a></h5>
                                <ul>
                                    <li>By <span>Sound Waves</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic">
                                <img src="img/blog/blog-4.jpg" alt="Blog 4">
                            </div>
                            <div class="blog__item__text">
                                <span>Live Concerts</span>
                                <h5><a href="blog-details.php" style="color: #fff; text-decoration: none;">Upcoming Arena Tours and Global Headlining Highlights</a></h5>
                                <ul>
                                    <li>By <span>Sound Waves</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="blog__sidebar">
                    <div class="blog__sidebar__item">
                        <div class="blog__sidebar__title">
                            <h4>Stay Informed</h4>
                        </div>
                        <p>Subscribe to our weekly newsletter for new artist spotlight releases and track premieres.</p>
                        <form action="#" onsubmit="event.preventDefault(); alert('Subscribed successfully!');">
                            <input type="text" placeholder="Your Name" required>
                            <input type="email" placeholder="Your Email" required>
                            <button type="submit" class="site-btn">Subscribe</button>
                        </form>
                    </div>
                    <div class="blog__sidebar__item">
                        <div class="blog__sidebar__title">
                            <h4>Follow Sound Waves</h4>
                        </div>
                        <div class="blog__sidebar__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-dribbble"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once("base/footer.php");
?>