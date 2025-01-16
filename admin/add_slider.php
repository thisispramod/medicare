<?php
session_start();
require_once('../db_connect.php');
$obj = new database();
// Check if not logged in
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}


$message = '';
$errors = [];
$max_file_size = 5 * 1024 * 1024; // 5MB
$allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];

// Create upload directory if it doesn't exist
$upload_dir = '../images/slider';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate title
    $title = trim($_POST['title'] ?? '');
    if (empty($title)) {
        $errors['title'] = 'Title is required';
    } elseif (strlen($title) > 255) {
        $errors['title'] = 'Title must be less than 255 characters';
    }

    // Validate description (optional)
    $description = trim($_POST['description'] ?? '');
    if (strlen($description) > 1000) {
        $errors['description'] = 'Description must be less than 1000 characters';
    }

    // Validate status
    $status = $_POST['status'] ?? '';
    if (!in_array($status, ['active', 'inactive'])) {
        $errors['status'] = 'Invalid status value';
    }

    // Validate image
    if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
        $errors['image'] = 'Image is required';
    } else {
        $file = $_FILES['image'];
        
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            switch ($file['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $errors['image'] = 'File is too large';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $errors['image'] = 'File was only partially uploaded';
                    break;
                default:
                    $errors['image'] = 'Error uploading file';
            }
        } else {
            // Validate file size
            if ($file['size'] > $max_file_size) {
                $errors['image'] = 'File size must be less than 5MB';
            }

            // Validate file type
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            if (!in_array($mime_type, $allowed_types)) {
                $errors['image'] = 'Invalid file type. Only JPG, JPEG, PNG & GIF files are allowed';
            }
        }
    }

    // If no errors, process the form
    if (empty($errors)) {
        try {
            // Generate unique filename
            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $new_filename = 'slider_' . date('Ymd_His') . '_' . uniqid() . '.' . $file_extension;
            $target_path = $upload_dir . '/' . $new_filename;
            
            // Move uploaded file
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                // Prepare database values
                $title = $obj->validate($title);
                $description = $obj->validate($description);
                $image_path = 'images/slider/' . $new_filename;
                
                // Insert into database
                $f = array('title', 'description', 'image_path', 'status');
                $v = array($title, $description, $image_path, $status);
                $insert = $obj-insert('sliders', $f , $v); 
                if ($insert) {
                    $_SESSION['success_message'] = "Slider added successfully!";
                    header("Location: dashboard.php");
                    exit;
                } else {
                    throw new Exception("Database error: " . mysqli_error($obj));
                }
            } else {
                throw new Exception("Error moving uploaded file.");
            }
        } catch (Exception $e) {
            $errors['system'] = $e->getMessage();
            // If there was an error, remove the uploaded file if it exists
            if (file_exists($target_path)) {
                unlink($target_path);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Slider - MediCare Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .error-field {
            border-color: #EF4444 !important;
        }
        .error-message {
            color: #EF4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .required-field::after {
            content: '*';
            color: #EF4444;
            margin-left: 4px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Admin Header -->
    <header class="bg-blue-900 text-white">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">MediCare Admin</h1>
                <div class="flex items-center space-x-4">
                    <a href="dashboard.php" class="text-white hover:text-blue-200">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                    </a>
                    <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Add New Slider</h2>

            <?php if (!empty($errors)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul class="list-disc list-inside">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="space-y-6" id="sliderForm" novalidate>
                <div class="form-group">
                    <label for="title" class="block text-gray-700 font-medium mb-2 required-field">Title</label>
                    <input type="text" id="title" name="title" required
                        value="<?php echo htmlspecialchars($title ?? ''); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        data-validate="required|maxLength:255">
                    <div class="error-message" data-error="title"></div>
                    <p class="text-sm text-gray-500 mt-1">Maximum 255 characters</p>
                </div>

                <div class="form-group">
                    <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        data-validate="maxLength:1000"
                    ><?php echo htmlspecialchars($description ?? ''); ?></textarea>
                    <div class="error-message" data-error="description"></div>
                    <p class="text-sm text-gray-500 mt-1">Maximum 1000 characters</p>
                </div>

                <div class="form-group">
                    <label for="image" class="block text-gray-700 font-medium mb-2 required-field">Image</label>
                    <input type="file" id="image" name="image" required accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        data-validate="required|fileType:image/*|fileSize:5">
                    <div class="error-message" data-error="image"></div>
                    <div class="text-sm text-gray-500 mt-1">
                        <p>Allowed formats: JPG, JPEG, PNG, GIF</p>
                        <p>Maximum file size: 5MB</p>
                    </div>
                    <div id="imagePreview" class="mt-2 hidden">
                        <img src="#" alt="Preview" class="max-w-xs rounded">
                    </div>
                </div>

                <div class="form-group">
                    <label for="status" class="block text-gray-700 font-medium mb-2 required-field">Status</label>
                    <select id="status" name="status" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        data-validate="required">
                        <option value="">Select Status</option>
                        <option value="active" <?php echo (isset($status) && $status === 'active') ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo (isset($status) && $status === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                    <div class="error-message" data-error="status"></div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-300">
                        Add Slider
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
    $(document).ready(function() {
        const form = $('#sliderForm');
        const fields = form.find('[data-validate]');
        
        // Validation rules
        const rules = {
            required: function(value) {
                return value && value.trim() !== '';
            },
            maxLength: function(value, length) {
                return !value || value.length <= length;
            },
            fileType: function(file, types) {
                if (!file) return true;
                const fileType = file.type;
                return types.split(',').some(type => {
                    if (type === 'image/*') {
                        return fileType.startsWith('image/');
                    }
                    return fileType === type;
                });
            },
            fileSize: function(file, sizeMB) {
                if (!file) return true;
                return file.size <= sizeMB * 1024 * 1024;
            }
        };

        // Error messages
        const errorMessages = {
            required: 'This field is required',
            maxLength: (length) => `Maximum ${length} characters allowed`,
            fileType: 'Invalid file type',
            fileSize: (size) => `File size must be less than ${size}MB`
        };

        // Validate single field
        function validateField(field) {
            const $field = $(field);
            const value = field.type === 'file' ? field.files[0] : $field.val();
            const validations = $field.data('validate').split('|');
            let isValid = true;
            let errorMessage = '';

            validations.forEach(validation => {
                const [rule, param] = validation.split(':');
                if (rules[rule]) {
                    const valid = rules[rule](value, param);
                    if (!valid && !errorMessage) {
                        isValid = false;
                        errorMessage = param ? errorMessages[rule](param) : errorMessages[rule];
                    }
                }
            });

            // Update UI
            $field.toggleClass('error-field', !isValid);
            const errorElement = $(`[data-error="${field.name}"]`);
            errorElement.text(errorMessage);

            return isValid;
        }

        // Real-time validation
        fields.each(function() {
            $(this).on('input change blur', function() {
                validateField(this);
            });
        });

        // Image preview
        $('#image').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').removeClass('hidden');
                    $('#imagePreview img').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

        // Form submission
        form.on('submit', function(e) {
            let isValid = true;
            
            // Validate all fields
            fields.each(function() {
                if (!validateField(this)) {
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                // Scroll to first error
                const firstError = $('.error-field').first();
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 500);
                }
            }
        });
    });
    </script>
</body>
</html>
