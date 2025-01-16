<?php
require_once 'db_connect.php';
$obj = new database();
$category = isset($_POST['category']) ? $_POST['category'] : 'all';

$sql = "SELECT * FROM products";
if ($category !== 'all') {
    $sql .= " WHERE category = '" . $conn->real_escape_string($category) . "'";
}

$results = $obj->query($sql);
$data = $obj->numRows();
if ($data > 0) {
    foreach($results as $row) {
        ?>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" 
                class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-2"><?php echo htmlspecialchars($row['name']); ?></h3>
                <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($row['description']); ?></p>
                <div class="flex justify-between items-center">
                    <span class="text-2xl font-bold text-blue-600">$<?php echo number_format($row['price'], 2); ?></span>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition duration-300">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo '<div class="col-span-full text-center text-gray-600">No products found in this category.</div>';
}
 
?>
