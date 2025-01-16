<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - MediCare</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
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
                    <a href="index.php" class="text-gray-600 hover:text-blue-700">Home</a>
                    <a href="about.php" class="text-gray-600 hover:text-blue-700">About Us</a>
                    <a href="products.php" class="text-blue-900 hover:text-blue-700 font-semibold">Products</a>
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
            <a href="about.php" class="block py-2 px-4 text-sm hover:bg-blue-100">About Us</a>
            <a href="products.php" class="block py-2 px-4 text-sm hover:bg-blue-100">Products</a>
            <a href="contact.php" class="block py-2 px-4 text-sm hover:bg-blue-100">Contact</a>
        </div>
    </nav>

    <!-- Products Content -->
    <main class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-blue-900 mb-8 text-center">Our Medical Products</h1>

        <!-- Product Categories -->
        <div class="flex flex-wrap justify-center gap-4 mb-8">
            <button class="category-btn active bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700" data-category="all">
                All Products
            </button>
            <button class="category-btn bg-gray-200 text-gray-700 px-6 py-2 rounded-full hover:bg-blue-700 hover:text-white" data-category="equipment">
                Medical Equipment
            </button>
            <button class="category-btn bg-gray-200 text-gray-700 px-6 py-2 rounded-full hover:bg-blue-700 hover:text-white" data-category="supplies">
                Medical Supplies
            </button>
            <button class="category-btn bg-gray-200 text-gray-700 px-6 py-2 rounded-full hover:bg-blue-700 hover:text-white" data-category="medicines">
                Medicines
            </button>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6" id="products-grid">
            <!-- Products will be loaded dynamically via PHP/MySQL -->
        </div>
    </main>

    <!-- Footer -->
    <?php
    include_once('components/footer.php')
    ?>
    <!-- END Footer -->

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

        // Category buttons functionality
        document.querySelectorAll('.category-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('.category-btn').forEach(btn => {
                    btn.classList.remove('active', 'bg-blue-600', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700');
                });

                // Add active class to clicked button
                this.classList.remove('bg-gray-200', 'text-gray-700');
                this.classList.add('active', 'bg-blue-600', 'text-white');

                // Get category and load products
                const category = this.dataset.category;
                loadProducts(category);
            });
        });

        // Function to load products via AJAX
        function loadProducts(category) {
            $.ajax({
                url: 'get_products.php',
                method: 'POST',
                data: { category: category },
                success: function(response) {
                    $('#products-grid').html(response);
                },
                error: function() {
                    console.error('Error loading products');
                }
            });
        }

        // Load all products by default
        loadProducts('all');
    </script>
    <script src="js/theme.js"></script>
</body>
</html>
