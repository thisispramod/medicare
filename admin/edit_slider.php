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
$error = '';

// Get slider data
if (isset($_GET['id'])) {
    $id = $obj->validate($_GET['id']);
    $query = $obj->query("SELECT * FROM sliders WHERE id = '$id'"); 
    $slider = $obj->row();

    if (!$slider) {
        header('Location: dashboard.php');
        exit;
    }
} else {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $obj->validate($_POST['title']);
    $description = $obj->validate($_POST['description']);
    $status = $_POST['status'];
    $current_image = $slider['image_path'];

    // Check if new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['image']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);

        if (in_array(strtolower($filetype), $allowed)) {
            // Create unique filename
            $newname = 'slider_' . date('Ymd_His') . '.' . $filetype;
            $target = '../images/slider/' . $newname;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $image_path = 'images/slider/' . $newname;
                
                // Delete old image
                if (file_exists('../' . $current_image)) {
                    unlink('../' . $current_image);
                }
            } else {
                $error = "Error uploading file.";
            }
        } else {
            $error = "Invalid file type. Only JPG, JPEG, PNG & GIF files are allowed.";
        }
    } else {
        $image_path = $current_image;
    }

    if (!$error) {
        // Update database
        $query = "UPDATE sliders SET 
                  title = '$title', 
                  description = '$description', 
                  image_path = '$image_path', 
                  status = '$status' 
                  WHERE id = '$id'";

        if ($obj->query($query)) {
            $message = "Slider updated successfully!";
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Error updating slider: " . mysqli_error($obj);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Slider - MediCare Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Slider</h2>

            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $error; ?></span>
                </div>
            <?php endif; ?>

            <?php if ($message): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $message; ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($slider['title']); ?>" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    ><?php echo htmlspecialchars($slider['description']); ?></textarea>
                </div>

                <div>
                    <label for="image" class="block text-gray-700 font-medium mb-2">Current Image</label>
                    <img src="../<?php echo htmlspecialchars($slider['image_path']); ?>" 
                         alt="Current Slider Image" 
                         class="w-64 h-40 object-cover rounded mb-4">
                    
                    <label for="image" class="block text-gray-700 font-medium mb-2">Upload New Image (optional)</label>
                    <input type="file" id="image" name="image" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-sm text-gray-500 mt-1">Allowed formats: JPG, JPEG, PNG, GIF</p>
                </div>

                <div>
                    <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                    <select id="status" name="status" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="active" <?php echo $slider['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo $slider['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-300">
                        Update Slider
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
