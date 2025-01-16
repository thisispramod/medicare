<?php

// Function to download and save image
function downloadImage($url, $path) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);
    curl_close($ch);
    file_put_contents($path, $data);
}

// Slider images
$slider_images = [
    'https://img.freepik.com/free-photo/young-handsome-physician-medical-robe-with-stethoscope_1303-17818.jpg',
    'https://img.freepik.com/free-photo/medical-banner-with-doctor-wearing-coat_23-2149611193.jpg',
    'https://img.freepik.com/free-photo/team-young-specialist-doctors-standing-corridor-hospital_1303-21199.jpg'
];

// Product images
$product_images = [
    'thermometer' => 'https://img.freepik.com/free-photo/thermometer-medical-equipment_1150-19027.jpg',
    'bp-monitor' => 'https://img.freepik.com/free-photo/blood-pressure-gauge_1150-11731.jpg',
    'first-aid-kit' => 'https://img.freepik.com/free-photo/first-aid-kit-white-background_1150-15411.jpg',
    'masks' => 'https://img.freepik.com/free-photo/medical-masks-blue_1157-33483.jpg',
    'pain-relief' => 'https://img.freepik.com/free-photo/pills-white-surface_144627-48461.jpg',
    'vitamin-c' => 'https://img.freepik.com/free-photo/vitamin-c-pills-white-surface_144627-48498.jpg'
];

// Download slider images
foreach ($slider_images as $key => $url) {
    $path = __DIR__ . '/images/slider/slider' . ($key + 1) . '.jpg';
    downloadImage($url, $path);
    echo "Downloaded slider image " . ($key + 1) . "<br>";
}

// Download product images
foreach ($product_images as $name => $url) {
    $path = __DIR__ . '/images/products/' . $name . '.jpg';
    downloadImage($url, $path);
    echo "Downloaded product image: " . $name . "<br>";
}

echo "All images have been downloaded successfully!";
?>
