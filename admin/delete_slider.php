<?php
session_start();
require_once('../db_connect.php');
$obj = new database();

// Check if not logged in
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
 
if (isset($_GET['id'])) {
    $id = $obj->validate($_GET['id']);
    
    // Get image path before deleting
    $query = $obj->query("SELECT image_path FROM sliders WHERE id = '$id'"); 
    $slider = $obj->row();
    
    if ($slider) {
        // Delete the image file
        if (file_exists('../' . $slider['image_path'])) {
            unlink('../' . $slider['image_path']);
        }
        
        // Delete from database
        $query = "DELETE FROM sliders WHERE id = '$id'";
        $obj->query($query);
    }
}

header('Location: dashboard.php');
exit;
