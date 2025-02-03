<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>EduQuizHub</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <link href="{{asset('assets/main_site_assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/main_site_assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/main_site_assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('assets/main_site_assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/main_site_assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <link href="{{asset('assets/main_site_assets/css/main.css')}}" rel="stylesheet">
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">EduQuiz</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{url('/')}}" class="active">Home<br></a></li>
          <li><a href="#aboutSection">About</a></li>
          <li><a href="{{'quizes'}}">Quizes</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="courses.html">Login</a>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <img src="{{asset('assets/main_site_assets/img/hero-bg.jpg')}}" alt="" data-aos="fade-in">

      <div class="container">
        <h2 data-aos="fade-up" data-aos-delay="100">Learning Today,<br>Leading Tomorrow</h2>
        <p data-aos="fade-up" data-aos-delay="200">Practice For Compitative Exams With Us & Reach Your Goals</p>
        <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
          <a href="courses.html" class="btn-get-started">Get Started</a>
        </div>
      </div>

    </section><!-- /Hero Section -->

   <!-- About Section -->
    <section id="aboutSection" class="about section">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
          <img src="{{asset('assets/main_site_assets/img/about.jpg')}}" class="img-fluid" alt="EduQuiz About">
        </div>

        <div class="col-lg-6 order-2 order-lg-1 content" data-aos="fade-up" data-aos-delay="200">
          <h3>Learning Today, Leading Tomorrow</h3>
          <p class="fst-italic">
            Practice for competitive exams with EduQuiz and achieve your goals. Our platform offers various quizzes designed to boost your knowledge and help you prepare effectively.
          </p>
          <ul>
            <li><i class="bi bi-check-circle"></i> <span>Variety of quizzes for different competitive exams.</span></li>
            <li><i class="bi bi-check-circle"></i> <span>Track your progress and improve with feedback.</span></li>
            <li><i class="bi bi-check-circle"></i> <span>Interactive learning environment with real-time performance analysis.</span></li>
          </ul>
          <a href="#" class="read-more"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </section><!-- /About Section -->

<!-- Counts Section -->
<section id="counts" class="section counts light-background">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

      <div class="row gy-4">

        <div class="col-lg-3 col-md-6">
          <div class="stats-item text-center w-100 h-100">
            <span data-purecounter-start="0" data-purecounter-end="500" data-purecounter-duration="1" class="purecounter"></span>
            <p>Students</p>
          </div>
        </div><!-- End Stats Item -->

        <div class="col-lg-3 col-md-6">
          <div class="stats-item text-center w-100 h-100">
            <span data-purecounter-start="0" data-purecounter-end="20" data-purecounter-duration="1" class="purecounter"></span>
            <p>Quizzes</p>
          </div>
        </div><!-- End Stats Item -->

        <div class="col-lg-3 col-md-6">
          <div class="stats-item text-center w-100 h-100">
            <span data-purecounter-start="0" data-purecounter-end="5" data-purecounter-duration="1" class="purecounter"></span>
            <p>Mock Tests</p>
          </div>
        </div><!-- End Stats Item -->

        <div class="col-lg-3 col-md-6">
          <div class="stats-item text-center w-100 h-100">
            <span data-purecounter-start="0" data-purecounter-end="10" data-purecounter-duration="1" class="purecounter"></span>
            <p>Subjects Covered</p>
          </div>
        </div><!-- End Stats Item -->

      </div>

    </div>

  </section><!-- /Counts Section -->


  <!-- Why Us Section -->
<section id="why-us" class="section why-us">

    <div class="container">

      <div class="row gy-4">

        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
          <div class="why-box">
            <h3>Why Choose Us?</h3>
            <p>
              We provide a comprehensive platform for practicing quizzes and mock tests tailored for competitive exams.
              Our platform is designed to help you achieve your goals with accuracy, ease, and efficiency.
              Whether you're preparing for JEE, NEET, Bank Exams, or programming tests, we've got you covered.
            </p>
            <div class="text-center">
              <a href="#" class="more-btn"><span>Learn More</span> <i class="bi bi-chevron-right"></i></a>
            </div>
          </div>
        </div><!-- End Why Box -->

        <div class="col-lg-8 d-flex align-items-stretch">
          <div class="row gy-4" data-aos="fade-up" data-aos-delay="200">

            <div class="col-xl-4">
              <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                <i class="bi bi-bar-chart"></i>
                <h4>Comprehensive Analytics</h4>
                <p>Track your performance with detailed reports and insights for every quiz and mock test.</p>
              </div>
            </div><!-- End Icon Box -->

            <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
              <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                <i class="bi bi-laptop"></i>
                <h4>Wide Range of Tests</h4>
                <p>Practice with quizzes and mock tests for 10th, 12th, JEE, NEET, Bank exams, and more.</p>
              </div>
            </div><!-- End Icon Box -->

            <div class="col-xl-4" data-aos="fade-up" data-aos-delay="400">
              <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                <i class="bi bi-award"></i>
                <h4>Expertly Curated Questions</h4>
                <p>Our tests are designed by experts to mirror the difficulty and style of real exams.</p>
              </div>
            </div><!-- End Icon Box -->

          </div>
        </div>

      </div>

    </div>

  </section><!-- /Why Us Section -->

<!-- Features Section -->
<section id="features" class="features section mb-3">

    <div class="container">

      <div class="row gy-4">

        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="features-item">
            <i class="bi bi-heart-pulse" style="color: #ffbb2c;"></i>
            <h3><a href="" class="stretched-link">NEET</a></h3>
          </div>
        </div><!-- End Feature Item -->

        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="features-item">
            <i class="bi bi-lightbulb" style="color: #5578ff;"></i>
            <h3><a href="" class="stretched-link">JEE</a></h3>
          </div>
        </div><!-- End Feature Item -->

        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="300">
          <div class="features-item">
            <i class="bi bi-bank" style="color: #e80368;"></i>
            <h3><a href="" class="stretched-link">SBI PO</a></h3>
          </div>
        </div><!-- End Feature Item -->

        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="400">
          <div class="features-item">
            <i class="bi bi-clipboard-check" style="color: #e361ff;"></i>
            <h3><a href="" class="stretched-link">SBI Clerk</a></h3>
          </div>
        </div><!-- End Feature Item -->

        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="500">
          <div class="features-item">
            <i class="bi bi-book" style="color: #47aeff;"></i>
            <h3><a href="" class="stretched-link">10th Standard</a></h3>
          </div>
        </div><!-- End Feature Item -->

        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="600">
          <div class="features-item">
            <i class="bi bi-book-half" style="color: #ffa76e;"></i>
            <h3><a href="" class="stretched-link">12th Standard</a></h3>
          </div>
        </div><!-- End Feature Item -->

        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="700">
          <div class="features-item">
            <i class="bi bi-award" style="color: #11dbcf;"></i>
            <h3><a href="" class="stretched-link">Other Exams</a></h3>
          </div>
        </div><!-- End Feature Item -->

      </div>

    </div>

  </section><!-- /Features Section -->

  </main>

  <br>

  <footer id="footer" class="footer position-relative light-background my-3 ">

    <br><br>

    <div class="container copyright text-center ">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">EduQuiz</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Designed by EduQuiz
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{asset('assets/main_site_assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/main_site_assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{asset('assets/main_site_assets/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('assets/main_site_assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('assets/main_site_assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
  <script src="{{asset('assets/main_site_assets/vendor/swiper/swiper-bundle.min.js')}}"></script>

  <!-- Main JS File -->
  <script src="{{asset('assets/main_site_assets/js/main.js')}}"></script>

</body>

</html>
