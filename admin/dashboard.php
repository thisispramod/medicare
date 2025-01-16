<?php
session_start();
require_once('../db_connect.php');
$obj = new database();
// Check if not logged in
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
 
 
// Get all sliders with error handling
$query = "SELECT * FROM sliders ORDER BY created_at DESC";
$result = $obj->query($query);

if ($result === false) {
    $error = "Error: " . mysqli_error($obj);
    $sliders = [];
} else {
    $sliders = $obj->rows();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MediCare</title>
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
                    <span>Welcome, Admin</span>
                    <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Manage Sliders</h2>
                <a href="add_slider.php" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    <i class="fas fa-plus mr-2"></i>Add New Slider
                </a>
            </div>

            <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <?php echo $error; ?>
            </div>
            <?php endif; ?>

            <!-- Sliders Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left">Image</th>
                            <th class="py-3 px-4 text-left">Title</th>
                            <th class="py-3 px-4 text-left">Description</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($sliders)): ?>
                        <tr>
                            <td colspan="5" class="py-4 px-4 text-center text-gray-500">
                                No sliders found. Click "Add New Slider" to create one.
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($sliders as $slider): ?>
                            <tr class="border-t">
                                <td class="py-3 px-4">
                                    <img src="../<?php echo htmlspecialchars($slider['image_path']); ?>" 
                                         alt="Slider Image" class="w-24 h-16 object-cover rounded">
                                </td>
                                <td class="py-3 px-4"><?php echo htmlspecialchars($slider['title']); ?></td>
                                <td class="py-3 px-4"><?php echo htmlspecialchars($slider['description']); ?></td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 rounded text-sm <?php echo $slider['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                        <?php echo ucfirst(htmlspecialchars($slider['status'])); ?>
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <a href="edit_slider.php?id=<?php echo $slider['id']; ?>" 
                                           class="text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete_slider.php?id=<?php echo $slider['id']; ?>" 
                                           class="text-red-500 hover:text-red-700"
                                           onclick="return confirm('Are you sure you want to delete this slider?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            <!-- Existing cards -->
            
            <!-- Announcement Management Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold mb-4">Announcement Bar</h3>
                <p class="text-gray-600 mb-4">Manage website announcements</p>
                <a href="manage_announcement.php" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Manage Announcements</a>
            </div>
        </div>
    </main>
</body>
</html>
