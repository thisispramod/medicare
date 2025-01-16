<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - MediCare</title>
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
                    <a href="products.php" class="text-gray-600 hover:text-blue-700">Products</a>
                    <a href="contact.php" class="text-blue-900 hover:text-blue-700 font-semibold">Contact</a>
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

    <!-- Contact Content -->
    <main class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-blue-900 mb-8 text-center">Contact Us</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-6xl mx-auto">
            <!-- Contact Information -->
            <div>
                <h2 class="text-2xl font-bold text-blue-900 mb-6">Get in Touch</h2>
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="text-blue-600 text-2xl mt-1">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg">Our Location</h3>
                            <p class="text-gray-600">123 Medical Center Dr<br>New York, NY 10001</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="text-blue-600 text-2xl mt-1">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg">Phone Number</h3>
                            <p class="text-gray-600">+1 234 567 890</p>
                            <p class="text-gray-600">+1 234 567 891</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="text-blue-600 text-2xl mt-1">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg">Email Address</h3>
                            <p class="text-gray-600">info@medicalcenter.com</p>
                            <p class="text-gray-600">support@medicalcenter.com</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="text-blue-600 text-2xl mt-1">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg">Working Hours</h3>
                            <p class="text-gray-600">Monday - Friday: 9:00 AM - 6:00 PM</p>
                            <p class="text-gray-600">Saturday: 9:00 AM - 4:00 PM</p>
                            <p class="text-gray-600">Sunday: Closed</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div>
                <h2 class="text-2xl font-bold text-blue-900 mb-6">Send us a Message</h2>
                <form id="contactForm" action="process_contact.php" method="POST" class="space-y-6">
                    <div class="form-group">
                        <label for="name" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Your Name</label>
                        <input type="text" id="name" name="name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="error-message text-red-500 text-sm mt-1 hidden">This field is required</span>
                    </div>
                    <div class="form-group">
                        <label for="email" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Email Address</label>
                        <input type="email" id="email" name="email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="error-message text-red-500 text-sm mt-1 hidden">Please enter a valid email address</span>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Phone Number</label>
                        <input type="tel" id="phone" name="phone"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="error-message text-red-500 text-sm mt-1 hidden">Please enter a valid phone number</span>
                    </div>
                    <div class="form-group">
                        <label for="subject" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Subject</label>
                        <input type="text" id="subject" name="subject"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="error-message text-red-500 text-sm mt-1 hidden">This field is required</span>
                    </div>
                    <div class="form-group">
                        <label for="message" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Message</label>
                        <textarea id="message" name="message" rows="5"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        <span class="error-message text-red-500 text-sm mt-1 hidden">This field is required</span>
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-300">
                        Send Message
                    </button>
                </form>
            </div>
        </div>

        <!-- Map Section -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-blue-900 mb-6 text-center">Our Location</h2>
            <div class="w-full h-96 bg-gray-300 rounded-lg">
                <!-- Replace with your Google Maps iframe -->
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387193.30596073366!2d-74.25986548248684!3d40.69714941932609!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2s!4v1645454332348!5m2!1sen!2s"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                    class="rounded-lg"></iframe>
            </div>
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

        // Form validation
        $(document).ready(function() {
            // Custom validation styles
            function showError(element, message) {
                $(element)
                    .addClass('border-red-500')
                    .removeClass('border-gray-300')
                    .siblings('.error-message')
                    .text(message)
                    .removeClass('hidden');
            }

            function hideError(element) {
                $(element)
                    .removeClass('border-red-500')
                    .addClass('border-gray-300')
                    .siblings('.error-message')
                    .addClass('hidden');
            }

            // Real-time validation
            $('#contactForm input, #contactForm textarea').on('input', function() {
                validateField($(this));
            });

            function validateField($field) {
                const value = $field.val().trim();
                const fieldId = $field.attr('id');

                switch(fieldId) {
                    case 'name':
                        if (value === '') {
                            showError($field, 'Name is required');
                            return false;
                        }
                        if (value.length < 2) {
                            showError($field, 'Name must be at least 2 characters');
                            return false;
                        }
                        break;

                    case 'email':
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (value === '') {
                            showError($field, 'Email is required');
                            return false;
                        }
                        if (!emailRegex.test(value)) {
                            showError($field, 'Please enter a valid email address');
                            return false;
                        }
                        break;

                    case 'phone':
                        const phoneRegex = /^\+?[\d\s-]{10,}$/;
                        if (value === '') {
                            showError($field, 'Phone number is required');
                            return false;
                        }
                        if (!phoneRegex.test(value)) {
                            showError($field, 'Please enter a valid phone number');
                            return false;
                        }
                        break;

                    case 'subject':
                        if (value === '') {
                            showError($field, 'Subject is required');
                            return false;
                        }
                        if (value.length < 5) {
                            showError($field, 'Subject must be at least 5 characters');
                            return false;
                        }
                        break;

                    case 'message':
                        if (value === '') {
                            showError($field, 'Message is required');
                            return false;
                        }
                        if (value.length < 10) {
                            showError($field, 'Message must be at least 10 characters');
                            return false;
                        }
                        break;
                }

                hideError($field);
                return true;
            }

            // Form submission
            $('#contactForm').on('submit', function(e) {
                e.preventDefault();
                let isValid = true;

                // Validate all fields
                $('#contactForm input, #contactForm textarea').each(function() {
                    if (!validateField($(this))) {
                        isValid = false;
                    }
                });

                if (isValid) {
                    // Show loading state
                    const $submitButton = $(this).find('button[type="submit"]');
                    const originalText = $submitButton.text();
                    $submitButton.html('<i class="fas fa-spinner fa-spin"></i> Sending...').prop('disabled', true);

                    // Submit form using AJAX
                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            // Show success message
                            alert('Thank you for your message! We will get back to you soon.');
                            $('#contactForm')[0].reset();
                        },
                        error: function() {
                            // Show error message
                            alert('An error occurred. Please try again later.');
                        },
                        complete: function() {
                            // Restore button state
                            $submitButton.html(originalText).prop('disabled', false);
                        }
                    });
                }
            });
        });
    </script>
    <script src="js/theme.js"></script>
</body>
</html>
