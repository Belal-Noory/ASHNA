<?php
require("./init.php");
$sysAdmin = new SystemAdmin();

// Company Messages
$allMessages_data = $sysAdmin->getWebsiteMsg();
$allMessages = $allMessages_data->fetchAll(PDO::FETCH_OBJ);

// FAQs
$all_faqs = $sysAdmin->getWebsiteFAQs();
$faqs = $all_faqs->fetchAll(PDO::FETCH_OBJ);

$base = $_SERVER['REQUEST_URI'];
$base = parse_url($base);
$parts = explode("/", $base['path']);
$path = $parts[1];

$res = helper::is_localhost();
if ($res == "local") {
  $home = "/" . $path;
} else {
  $home = "";
}
?>
<!doctype html>
<html lang="en">

<head>
  <title>ASHNA BABUR</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="ASHNA BABUR accounting software, expections in accounting">
    <meta name="keywords" content="ashna babur, ashna, ashna babur accounting system, accounting software, msp services, ashna msp, ashna, best msp in afghanistan, afghanistan">
    <meta name="author" content="Belal Noory">
  <link rel="icon" href="ashna.ico" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo $home ?>/app-assets/fonts/icomoon/style.css">
  <link rel="stylesheet" href="<?php echo $home ?>/app-assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $home ?>/app-assets/css/jquery-ui.css">
  <link rel="stylesheet" href="<?php echo $home ?>/app-assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="<?php echo $home ?>/app-assets/css/owl.theme.default.min.css">
  <link rel="stylesheet" href="<?php echo $home ?>/app-assets/css/owl.theme.default.min.css">
  <link rel="stylesheet" href="<?php echo $home ?>/app-assets/css/jquery.fancybox.min.css">
  <link rel="stylesheet" href="<?php echo $home ?>/app-assets/css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="<?php echo $home ?>/app-assets/fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="<?php echo $home ?>/app-assets/css/aos.css">
  <link rel="stylesheet" href="<?php echo $home ?>/app-assets/css/style.css">
  <style>
    .capital {
      font-variant: small-caps;
    }
  </style>
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
  <div id="overlayer"></div>
  <div class="loader">
    <div class="spinner-border text-primary" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  <div class="site-wrap">
    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
    <header class="site-navbar js-sticky-header site-navbar-target" role="banner">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-6 col-xl-2">
            <h1 class="mb-0 site-logo"><a href="#" class="h2 mb-0">ASHNA<span class="text-primary">.</span> </a></h1>
          </div>
          <div class="col-12 col-md-10 d-none d-xl-block">
            <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                <li><a href="#home-section" class="nav-link">Home</a></li>
                <li class="has-children">
                  <a href="#about-section" class="nav-link">About Us</a>
                  <ul class="dropdown">
                    <li><a href="#team-section" class="nav-link">Team</a></li>
                    <li><a href="#pricing-section" class="nav-link">Pricing</a></li>
                    <li><a href="#faq-section" class="nav-link">FAQ</a></li>
                    <li><a href="#services-section" class="nav-link">Services</a></li>
                  </ul>
                </li>
                <li><a href="#testimonials-section" class="nav-link">Company Message</a></li>
                <li class="has-children">
                  <a href="#" class="nav-link">Logins</a>
                  <ul class="dropdown">
                    <li><a href="/business" class="nav-menu">Bussiness</a></li>
                    <li><a href="/saraf" class="nav-menu">Saraf</a></li>
                  </ul>
                </li>
                <li><a href="#contact-section" class="nav-link">Contact</a></li>
                <li class="social"><a href="#contact-section" class="nav-link"><span class="icon-facebook"></span></a></li>
                <li class="social"><a href="#contact-section" class="nav-link"><span class="icon-twitter"></span></a></li>
                <li class="social"><a href="#contact-section" class="nav-link"><span class="icon-linkedin"></span></a></li>
              </ul>
            </nav>
          </div>
          <div class="col-6 d-inline-block d-xl-none ml-md-0 py-3" style="position: relative; top: 3px;"><a href="#" class="site-menu-toggle js-menu-toggle float-right"><span class="icon-menu h3"></span></a></div>
        </div>
      </div>
    </header>

    <div class="site-blocks-cover overlay" style="background-image: url(<?php echo $home ?>/app-assets/images/hero_2.jpg);" data-aos="fade" id="home-section">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-10 mt-lg-5 text-center">
            <div class="single-text owl-carousel">
              <div class="slide">
                <h1 class="text-uppercase" data-aos="fade-up">Accounting Solutions</h1>
                <p class="mb-5 desc" data-aos="fade-up" data-aos-delay="100">
                  ASHNA BABUR Accounting software provides unique accounting management for Sarafes.</p>
                <div data-aos="fade-up" data-aos-delay="100">
                  <a href="#contact-section" class="btn  btn-primary mr-2 mb-2">Get In Touch</a>
                </div>
              </div>

              <div class="slide">
                <h1 class="text-uppercase" data-aos="fade-up">Financing Solutions</h1>
                <p class="mb-5 desc" data-aos="fade-up" data-aos-delay="100">Accurate finance management with ASHNA accounting software.</p>
                <div data-aos="fade-up" data-aos-delay="100">
                  <a href="#contact-section" class="btn  btn-primary mr-2 mb-2">Get In Touch</a>
                </div>
              </div>

              <div class="slide">
                <h1 class="text-uppercase" data-aos="fade-up">Staff Management</h1>
                <p class="mb-5 desc" data-aos="fade-up" data-aos-delay="100">We know its hard for sarafi or small organization to focuse on staff management as they are all busy with daily operation management, dont worry we can handle it accurately.</p>
                <div data-aos="fade-up" data-aos-delay="100">
                  <a href="#contact-section" class="btn  btn-primary mr-2 mb-2">Get In Touch</a>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <a href="#next" class="mouse smoothscroll">
        <span class="mouse-icon">
          <span class="mouse-wheel"></span>
        </span>
      </a>
    </div>

    <div class="site-section cta-big-image" id="about-section">
      <div class="container">
        <div class="row mb-5 justify-content-center">
          <div class="col-md-8 text-center">
            <h2 class="section-title mb-3 capital" data-aos="fade-up" data-aos-delay="">We have transformed accounting</h2>
            <p class="lead" data-aos="fade-up" data-aos-delay="100">ASHNA BABUR exchange and financial accounting software available to you everywhere and at any time. In Ashna you will experience creative ideas and unique possibilities</p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 mb-5 text-center" data-aos="fade-up" data-aos-delay="">
            <img src="<?php echo $home ?>/business/app-assets/images/logo/ashna.png" alt="loading" class="img-fluid w-50">
          </div>
          <div class="col-lg-6 ml-auto" data-aos="fade-up" data-aos-delay="100">
            <h3 class="text-black mb-4 capital">Why ASHNA BABUR Financial Accounting System?</h3>
            <p>ASHNA BABUR accounting software is designed and offered by smart packages suitable for the exchange system, for smartening and organizing financial and accounting information of businesses. Comprehensive reports and easy-to-use. ASHNA software allow money changers to make financial decisions more efficiently.
              Also, the first priority of experts and developers of ASHNA accounting software is the needs and desires of customers, which is considered in product development.
              Your company's accountants can monitor your company's financial performance using a smartphone, tablet or personal computer. You only need a medium speed internet connection to work with familiar web exchange accounting software.</p>
          </div>
        </div>
        <div class="row mb-5 justify-content-center">
          <div class="col-md-8 text-center">
            <h3 class="section-title mb-3 capital" data-aos="fade-up" data-aos-delay="">The best integrated accounting and finance software</h3>
            <p class="lead" data-aos="fade-up" data-aos-delay="100">
              Familiar exchange and financial accounting software is designed to be suitable for exchange companies and monetary services. With the help of this software, you can calculate all the financial and accounting matters of your company in the fastest time.
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section bg-light" id="next">
      <div class="container">
        <div class="row mb-5 justify-content-center">
          <div class="col-md-8 text-center">
            <h3 class="section-title mb-3 capital" data-aos="fade-up" data-aos-delay="">Why is Ashna your solution?</h3>
            <p class="lead" data-aos="fade-up" data-aos-delay="100">
              Simply identify and manage all of your company's financial needs.
            </p>
          </div>
        </div>
        <div class="row mb-5">
          <div class="col-md-3 text-center" data-aos="fade-up" data-aos-delay="">
            <lord-icon src="https://cdn.lordicon.com/soseozvi.json" trigger="loop" style="width:120px;height:120px">
            </lord-icon>
            <h3 class="card-title">User interface and easy access</h3>
            <p>Beautiful user interface of familiar accounting software designed to facilitate the use of users to manage finances and accounting in the simplest and fastest way.</p>
          </div>

          <div class="col-md-3 text-center" data-aos="fade-up" data-aos-delay="200">
            <lord-icon src="https://cdn.lordicon.com/huwchbks.json" trigger="loop" style="width:120px;height:120px">
            </lord-icon>
            <h3 class="card-title">Maximum information security</h3>
            <p>Familiar with the latest data security methods and encryption methods, ensures 100% security of your information.</p>
          </div>

          <div class="col-md-3 text-center" data-aos="fade-up" data-aos-delay="100">
            <lord-icon src="https://cdn.lordicon.com/yyecauzv.json" trigger="loop" style="width:120px;height:120px">
            </lord-icon>
            <h3 class="card-title">Privacy</h3>
            <p>In accordance with the agreement, all customer information is confidential and will not be disclosed to any third party.</p>
          </div>

          <div class="col-md-3 text-center" data-aos="fade-up" data-aos-delay="100">
            <lord-icon src="https://cdn.lordicon.com/pithnlch.json" trigger="loop" style="width:120px;height:120px">
            </lord-icon>
            <h3 class="card-title">Peace of mind</h3>
            <p>The latest technologies and coverage of your complete needs along with data storage and access from everywhere means all your needs safely.</p>
          </div>

          <div class="col-md-3 text-center" data-aos="fade-up" data-aos-delay="100">
            <lord-icon src="https://cdn.lordicon.com/rwotyanb.json" trigger="loop" style="width:120px;height:120px">
            </lord-icon>
            <h3 class="card-title">Multilanguage</h3>
            <p>ASHNA BABUR Software with accurate financial calculations and minimizing accounting errors can save costs and prevent time wastage.</p>
          </div>

          <div class="col-md-3 text-center" data-aos="fade-up" data-aos-delay="100">
            <lord-icon src="https://cdn.lordicon.com/jvucoldz.json" trigger="loop" style="width:120px;height:120px">
            </lord-icon>
            <h3 class="card-title">Establishment</h3>
            <p>The most important factor in the success or failure of an accounting software in a company is how it is deployed. ASHNA BABUR implementation team with the benefit of the highest standards in the world will make this possible for you.</p>
          </div>

          <div class="col-md-3 text-center" data-aos="fade-up" data-aos-delay="100">
            <lord-icon src="https://cdn.lordicon.com/wxnxiano.json" trigger="loop" style="width:120px;height:120px">
            </lord-icon>
            <h3 class="card-title">Education</h3>
            <p>One of the important factors that has a significant impact on productivity is that during the deployment, in addition to practical tips, we will fully teach you how to work with the software.</p>
          </div>

          <div class="col-md-3 text-center" data-aos="fade-up" data-aos-delay="100">
            <lord-icon src="https://cdn.lordicon.com/zpxybbhl.json" trigger="loop" style="width:120px;height:120px">
            </lord-icon>
            <h3 class="card-title">Permanent support services</h3>
            <p>ASHNA BABUR experts and support team are ready to answer you at all hours of the working day by phone and online chat.</p>
          </div>
        </div>
      </div>
    </div>

    <section class="site-section testimonial-wrap" id="testimonials-section" data-aos="fade">
      <div class="slide-one-item home-slider owl-carousel">
        <?php
        foreach ($allMessages as $message) {
        ?>
          <div>
            <div class="testimonial">
              <div class="container">
                <div class="row mb-5">
                  <div class="col-12 text-center">
                    <h2 class="section-title mb-3"><?php echo $message->title; ?></h2>
                  </div>
                </div>
              </div>
              <blockquote class="mb-5">
                <p>&ldquo;<?php echo $message->details; ?>&rdquo;</p>
              </blockquote>
            </div>
          </div>
        <?php } ?>
      </div>
    </section>

    <!-- <section class="site-section border-bottom" id="team-section">
      <div class="container">
        <div class="row mb-5 justify-content-center">
          <div class="col-md-8 text-center">
            <h2 class="section-title mb-3" data-aos="fade-up" data-aos-delay="">Meet Team</h2>
            <p class="lead" data-aos="fade-up" data-aos-delay="100">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="">
            <div class="team-member">
              <figure>
                <ul class="social">
                  <li><a href="#"><span class="icon-facebook"></span></a></li>
                  <li><a href="#"><span class="icon-twitter"></span></a></li>
                  <li><a href="#"><span class="icon-linkedin"></span></a></li>
                  <li><a href="#"><span class="icon-instagram"></span></a></li>
                </ul>
                <img src="<?php echo $home ?>/app-assets/images/person_1.jpg" alt="Image" class="img-fluid">
              </figure>
              <div class="p-3">
                <h3>Kaiara Spencer</h3>
                <span class="position">Accountant</span>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="team-member">
              <figure>
                <ul class="social">
                  <li><a href="#"><span class="icon-facebook"></span></a></li>
                  <li><a href="#"><span class="icon-twitter"></span></a></li>
                  <li><a href="#"><span class="icon-linkedin"></span></a></li>
                  <li><a href="#"><span class="icon-instagram"></span></a></li>
                </ul>
                <img src="<?php echo $home ?>/app-assets/images/person_2.jpg" alt="Image" class="img-fluid">
              </figure>
              <div class="p-3">
                <h3>Dave Simpson</h3>
                <span class="position">Bank Teller</span>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
            <div class="team-member">
              <figure>
                <ul class="social">
                  <li><a href="#"><span class="icon-facebook"></span></a></li>
                  <li><a href="#"><span class="icon-twitter"></span></a></li>
                  <li><a href="#"><span class="icon-linkedin"></span></a></li>
                  <li><a href="#"><span class="icon-instagram"></span></a></li>
                </ul>
                <img src="<?php echo $home ?>/app-assets/images/person_3.jpg" alt="Image" class="img-fluid">
              </figure>
              <div class="p-3">
                <h3>Ben Thompson</h3>
                <span class="position">Bank Teller</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> -->

    <!-- <section class="site-section bg-light" id="pricing-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-12 text-center" data-aos="fade-up">
            <h2 class="section-title mb-3">Pricing</h2>
          </div>
        </div>
        <div class="row mb-5">
          <div class="col-md-6 mb-4 mb-lg-0 col-lg-4" data-aos="fade-up" data-aos-delay="">
            <div class="pricing">
              <h3 class="text-center text-black">Basic</h3>
              <div class="price text-center mb-4 ">
                <span><span>$47</span> / year</span>
              </div>
              <ul class="list-unstyled ul-check success mb-5">
                <li>Officia quaerat eaque neque</li>
                <li>Possimus aut consequuntur incidunt</li>
                <li class="remove">Lorem ipsum dolor sit amet</li>
                <li class="remove">Consectetur adipisicing elit</li>
                <li class="remove">Dolorum esse odio quas architecto sint</li>
              </ul>
            </div>
          </div>

          <div class="col-md-6 mb-4 mb-lg-0 col-lg-4 pricing-popular" data-aos="fade-up" data-aos-delay="100">
            <div class="pricing">
              <h3 class="text-center text-black">Premium</h3>
              <div class="price text-center mb-4 ">
                <span><span>$200</span> / year</span>
              </div>
              <ul class="list-unstyled ul-check success mb-5">

                <li>Officia quaerat eaque neque</li>
                <li>Possimus aut consequuntur incidunt</li>
                <li>Lorem ipsum dolor sit amet</li>
                <li>Consectetur adipisicing elit</li>
                <li class="remove">Dolorum esse odio quas architecto sint</li>
              </ul>
            </div>
          </div>

          <div class="col-md-6 mb-4 mb-lg-0 col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <div class="pricing">
              <h3 class="text-center text-black">Professional</h3>
              <div class="price text-center mb-4 ">
                <span><span>$750</span> / year</span>
              </div>
              <ul class="list-unstyled ul-check success mb-5">
                <li>Officia quaerat eaque neque</li>
                <li>Possimus aut consequuntur incidunt</li>
                <li>Lorem ipsum dolor sit amet</li>
                <li>Consectetur adipisicing elit</li>
                <li>Dolorum esse odio quas architecto sint</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="row site-section" id="faq-section">
          <div class="col-12 text-center" data-aos="fade">
            <h2 class="section-title">Frequently Ask Questions</h2>
          </div>
        </div>
        <div class="row">
          <?php foreach ($faqs as $faq) { ?>
            <div class="col-lg-6">
              <div class="mb-5" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-black h4 mb-4"><?php echo $faq->question; ?></h3>
                <p><?php echo $faq->answer; ?></p>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </section> -->

    <section class="site-section bg-light" id="contact-section" data-aos="fade">
      <div class="container">
        <div class="row mb-5">
          <div class="col-12 text-center">
            <h2 class="section-title mb-3 capital">Contact Us</h2>
          </div>
        </div>
        <div class="row mb-5">
          <div class="col-md-4 text-center">
            <p class="mb-4">
              <span class="icon-room d-block h2 text-primary"></span>
              <span>Kabul, Afghanistan</span>
            </p>
          </div>
          <div class="col-md-4 text-center">
            <p class="mb-4">
              <span class="icon-phone d-block h2 text-primary"></span>
              <a href="#">+93 (0) 795 769 595 | +93 (0) 772 436 628</a>
            </p>
          </div>
          <div class="col-md-4 text-center">
            <p class="mb-0">
              <span class="icon-mail_outline d-block h2 text-primary"></span>
              <a href="#">Info@AshnaMSP.com</a>
            </p>
          </div>
        </div>
      </div>
    </section>

    <footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-9">
            <div class="row">
              <div class="col-md-6">
                <h2 class="footer-heading mb-4">About Us</h2>
                <p>ASHNA BABUR exchange and financial accounting software available to you everywhere and at any time. In ASHNA BABUR you will experience creative ideas and unique possibilities</p>
              </div>
              <div class="col-md-3 ml-auto">
                <h2 class="footer-heading mb-4">Quick Links</h2>
                <ul class="list-unstyled">
                  <li><a href="#about-section" class="smoothscroll">About Us</a></li>
                  <li><a href="#testimonials-section" class="smoothscroll">Company Message</a></li>
                  <li><a href="#contact-section" class="smoothscroll">Contact Us</a></li>
                </ul>
              </div>
              <div class="col-md-3 footer-social">
                <h2 class="footer-heading mb-4">Follow Us</h2>
                <a href="#" class="pl-0 pr-3"><span class="icon-facebook"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-twitter"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-linkedin"></span></a>
              </div>
            </div>
          </div>
        </div>
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <div class="border-top pt-5">
              <p>Copyright &copy;
                <script>
                  document.write(new Date().getFullYear());
                </script> All rights reserved | Developed by <a href="#" target="_blank">ASHNA BABUR SYSTEM</a>
              </p>
            </div>
          </div>

        </div>
      </div>
    </footer>
  </div> <!-- .site-wrap -->

  <script src="<?php echo $home ?>/app-assets/js/jquery-3.3.1.min.js"></script>
  <script src="<?php echo $home ?>/app-assets/js/jquery-ui.js"></script>
  <script src="<?php echo $home ?>/app-assets/js/popper.min.js"></script>
  <script src="<?php echo $home ?>/app-assets/js/bootstrap.min.js"></script>
  <script src="<?php echo $home ?>/app-assets/js/owl.carousel.min.js"></script>
  <script src="<?php echo $home ?>/app-assets/js/jquery.countdown.min.js"></script>
  <script src="<?php echo $home ?>/app-assets/js/jquery.easing.1.3.js"></script>
  <script src="<?php echo $home ?>/app-assets/js/aos.js"></script>
  <script src="<?php echo $home ?>/app-assets/js/jquery.fancybox.min.js"></script>
  <script src="<?php echo $home ?>/app-assets/js/jquery.sticky.js"></script>
  <script src="<?php echo $home ?>/app-assets/js/isotope.pkgd.min.js"></script>
  <script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
  <script src="<?php echo $home ?>/app-assets/js/main.js"></script>
</body>

</html>