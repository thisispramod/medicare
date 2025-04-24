<?php 
require_once('db_connect.php');
$obj = new database();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Website - Home</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <style>
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
    </style>
</head>
<body>
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

    <!-- Hero Slider -->
    <div class="swiper-container h-[500px]">
        <div class="swiper-wrapper">
            <?php 
                $obj->query("SELECT * FROM sliders ORDER BY created_at DESC");
                $sliders = $obj->rows(); 
            ?>
            <?php if($sliders){ ?>
                <?php foreach($sliders as $slider){ ?>
                <div class="swiper-slide relative">
                    <img src="<?php echo htmlspecialchars($slider['image_path']); ?>"  
                         alt="<?php echo htmlspecialchars($slider['title']); ?>" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                        <div class="text-center text-white px-4">
                            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                                <?php echo htmlspecialchars($slider['title']); ?>
                            </h1>
                            <?php if(!empty($slider['description'])){?>
                            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                                <?php echo htmlspecialchars($slider['description']); ?>
                            </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php  
            }}else{ 
            ?>
                <div class="swiper-slide relative">
                    <img src="images/slider/default.jpg" alt="Welcome to MediCare 1" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                        <div class="text-center text-white px-4">
                            <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome to MediCare</h1>
                            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">Your Health is Our Priority</p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="swiper-button-next text-white"></div>
        <div class="swiper-button-prev text-white"></div>
        <div class="swiper-pagination"></div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.swiper-container', {
            loop: true,
            effect: 'fade',
            speed: 1000,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    });
    </script>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12">
        <!-- Services Section -->
        <section class="mb-16">
            <h2 class="text-3xl font-bold text-center text-blue-900 mb-8">Our Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="text-4xl text-blue-600 mb-4"><i class="fas fa-user-md"></i></div>
                    <h3 class="text-xl font-semibold mb-2">Expert Doctors</h3>
                    <p class="text-gray-600">Our team of experienced medical professionals is here to provide you with the best care.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="text-4xl text-blue-600 mb-4"><i class="fas fa-clinic-medical"></i></div>
                    <h3 class="text-xl font-semibold mb-2">Modern Facilities</h3>
                    <p class="text-gray-600">State-of-the-art medical facilities equipped with the latest technology.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="text-4xl text-blue-600 mb-4"><i class="fas fa-heartbeat"></i></div>
                    <h3 class="text-xl font-semibold mb-2">Emergency Care</h3>
                    <p class="text-gray-600">24/7 emergency services available for immediate medical attention.</p>
                </div>
            </div>
        </section>
    </main>

    <?php
    include_once('components/footer.php')
    ?>

    <script>
        // Mobile menu toggle
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            document.querySelector('.mobile-menu').classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.mobile-menu') && !event.target.closest('.mobile-menu-button')) {
                document.querySelector('.mobile-menu').classList.add('hidden');
            }
        });
    </script>
    <script src="js/theme.js"></script>
</body>
</html>
