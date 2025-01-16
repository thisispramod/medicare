<?php
// Create slider images directory if it doesn't exist
$slider_dir = '../images/slider';
if (!file_exists($slider_dir)) {
    mkdir($slider_dir, 0777, true);
}

// Set proper permissions
chmod($slider_dir, 0777);

echo "Directory structure checked and created if necessary.";
?>
