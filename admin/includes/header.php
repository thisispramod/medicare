<?php
session_start();
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - MediCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-900 text-white px-4 py-3">
        <div class="container mx-auto flex justify-between items-center">
            <a href="dashboard.php" class="text-xl font-bold">MediCare Admin</a>
            <div class="flex items-center space-x-4">
                <a href="dashboard.php" class="hover:text-blue-200">Dashboard</a>
                <a href="logout.php" class="hover:text-blue-200">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mx-auto py-6">
