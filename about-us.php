<?php 
require_once('db_connect.php');
$obj = new database();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us - PharmEasy</title>
  <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Slick Carousel CSS & JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> 
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

  <script src="https://cdn.tailwindcss.com"></script>
  <style>
  .slick-dots {
    @apply flex justify-center mt-4;
  }
  @keyframes slideIn {
            from { transform: translateY(-100%); }
            to { transform: translateY(0); }
        }
        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        .announcement-bar {
            animation: slideIn 0.5s ease-out;
        }
        .announcement-content {
            animation: marquee 20s linear infinite;
        }
        .announcement-bar:hover .announcement-content {
            animation-play-state: paused;
        }
        .slick-prev, .slick-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            background: white;
            border-radius: 9999px; /* fully rounded */
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 40px;
            height: 40px;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: black;
        }

        .slick-prev {
            left: -50px; /* adjust based on your layout */
        }

        .slick-next {
            right: -50px; /* adjust based on your layout */
        }
</style>

</head>
<body class="bg-white text-gray-800">
<?php
    $obj->query("SELECT * FROM announcements WHERE status = 1 ORDER BY id DESC LIMIT 1");
    if($obj->numRows() > 0):
        $announcement = $obj->row(); 
    ?>
    <div class="announcement-bar relative overflow-hidden" 
         style="background-color: <?php echo htmlspecialchars($announcement['bg_color']); ?>;">
        <div class="absolute inset-y-0 right-0 w-8 z-10" 
             style="background: linear-gradient(to right, transparent, <?php echo htmlspecialchars($announcement['bg_color']); ?>);">
        </div>
        <div class="absolute inset-y-0 left-0 w-8 z-10" 
             style="background: linear-gradient(to left, transparent, <?php echo htmlspecialchars($announcement['bg_color']); ?>);">
        </div>
        <div class="relative whitespace-nowrap overflow-hidden py-1">
            <div class="announcement-content inline-block"
                 style="color: <?php echo htmlspecialchars($announcement['text_color']); ?>;">
                <div class="flex items-center space-x-2 px-4">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                    <span class="font-medium">
                        <?php echo htmlspecialchars($announcement['announcement_text']); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Top Header -->
    <div class="bg-blue-900 text-white py-2">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <span><i class="fas fa-phone"></i> +1 234 567 890</span>
                <span><i class="fas fa-envelope"></i> info@medicalcenter.com</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="#" class="hover:text-blue-200"><i class="fab fa-facebook"></i></a>
                <a href="#" class="hover:text-blue-200"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-blue-200"><i class="fab fa-instagram"></i></a>
                <button id="themeToggle" class="theme-toggle">
                    <i class="fas fa-moon theme-icon-dark"></i>
                    <i class="fas fa-sun theme-icon-light"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="index.php" class="text-2xl font-bold text-blue-900">MediCare</a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php" class="text-blue-900 hover:text-blue-700 font-semibold">Home</a>
                    <a href="about-us.php" class="text-gray-600 hover:text-blue-700">About Us</a>
                    <a href="products.php" class="text-gray-600 hover:text-blue-700">Products</a>
                    <a href="contact.php" class="text-gray-600 hover:text-blue-700">Contact</a>
                </div>
                <div class="md:hidden">
                    <button class="mobile-menu-button">
                        <i class="fas fa-bars text-blue-900 text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div class="mobile-menu hidden md:hidden">
            <a href="index.php" class="block py-2 px-4 text-sm hover:bg-blue-100">Home</a>
            <a href="about-us.php" class="block py-2 px-4 text-sm hover:bg-blue-100">About Us</a>
            <a href="products.php" class="block py-2 px-4 text-sm hover:bg-blue-100">Products</a>
            <a href="contact.php" class="block py-2 px-4 text-sm hover:bg-blue-100">Contact</a>
        </div>
    </nav>

  <!-- Hero Section -->
  <section class="bg-blue-50 py-16 px-6 text-center">
    <h1 class="text-4xl font-bold text-blue-700 mb-4">Welcome to India’s Leading Digital Healthcare Platform</h1>
    <p class="text-lg max-w-2xl mx-auto">We focus on simplifying healthcare and impacting lives!</p>
  </section>

  <!-- What is PharmEasy -->
  <!-- <section class="py-16 px-6 max-w-5xl mx-auto">
    <h2 class="text-3xl font-semibold mb-6">What is PharmEasy?</h2>
    <p class="text-lg mb-4">
      PharmEasy is a consumer healthcare “super app” that provides on-demand, home-delivered access to a wide range of prescription and OTC pharmaceuticals, comprehensive diagnostic test services, and teleconsultations, thereby serving your healthcare needs.
    </p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8 text-center">
      <div>
        <p class="text-2xl font-bold text-blue-600">25M+</p>
        <p class="text-gray-600">Registered Users</p>
      </div>
      <div>
        <p class="text-2xl font-bold text-blue-600">8.8M+</p>
        <p class="text-gray-600">Orders (FY21)</p>
      </div>
      <div>
        <p class="text-2xl font-bold text-blue-600">2.4M+</p>
        <p class="text-gray-600">Transacting Customers</p>
      </div>
    </div>
  </section> -->

  <!-- Core Values -->
  <section class="bg-gray-100 py-16 px-6">
    <div class="max-w-5xl mx-auto">
      <h2 class="text-3xl font-semibold mb-6 text-center">Our Core Values</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded shadow">
          <h3 class="text-xl font-bold mb-2">Customer First</h3>
          <p>We prioritize our customers' needs and strive to exceed their expectations.</p>
        </div>
        <div class="bg-white p-6 rounded shadow">
          <h3 class="text-xl font-bold mb-2">Integrity</h3>
          <p>We uphold the highest standards of integrity in all our actions.</p>
        </div>
        <div class="bg-white p-6 rounded shadow">
          <h3 class="text-xl font-bold mb-2">Innovation</h3>
          <p>We embrace innovation to provide the best solutions to our customers.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Company Culture -->
  <section class="py-16 px-6 max-w-5xl mx-auto">
  <h2 class="text-3xl font-semibold mb-6 text-center">Our Culture</h2>
  <p class="text-lg mb-8 text-center">
    At PharmEasy, we believe that a great work culture is vital to a company's success. Our team members are encouraged to take ownership and work collaboratively.
  </p>

  <div class="culture-slider">
    <div><img src="images/slider/about-us-img.png" width="50%" hight="50%" alt="Team 1" class="rounded shadow mx-auto" /></div>
    <div><img src="images/slider/about-us-img-1.png" width="50%" hight="50%" alt="Team 2" class="rounded shadow mx-auto" /></div>
    <div><img src="images/slider/about-us-img.png" width="50%" hight="50%" alt="Team 3" class="rounded shadow mx-auto" /></div>
    <div><img src="images/slider/about-us-img.png" width="50%" hight="50%" alt="Team 4" class="rounded shadow mx-auto" /></div>
  </div>
</section>
<?php
    include_once('components/footer.php')
    ?>
</body>
<script>
  $(document).ready(function(){
    $('.culture-slider').slick({
      slidesToShow: 1,
      autoplay: true,
      autoplaySpeed: 3000,
      dots: false,
      arrows: true,
      adaptiveHeight: true,
        prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
      nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>'
    });
  });
</script>
<script src="js/theme.js"></script>
</html>
