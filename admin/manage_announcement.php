<?php
require_once('includes/header.php');
require_once('../db_connect.php');
$obj = new database();


if(isset($_POST['submit'])) {
    $message = $obj->validate($_POST['message']);
    $status = isset($_POST['status']) ? 1 : 0;
    $bg_color = $obj->validate($_POST['bg_color']);
    $text_color = $obj->validate($_POST['text_color']);
    
    if($status == 1) {
        $obj->query("UPDATE announcements SET status = 0");
    }
    $f = array('message', 'status', 'bg_color', 'text_color');
    $v = array($message, $status, $bg_color, $text_color);
    $insert = $obj->insert('announcements', $f , $v);
    if($insert) {
        $success_message = "Announcement added successfully!";
    } else {
        $error_message = "Error adding announcement: " . mysqli_error($obj);
    }
    header('Location: manage_announcement.php');
    exit();
}

if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if($obj->query("DELETE FROM announcements WHERE id = $id")) {
        $success_message = "Announcement deleted successfully!";
    } else {
        $error_message = "Error deleting announcement: " . mysqli_error($conn);
    }
    header('Location: manage_announcement.php');
    exit();
}

$obj->query("SELECT * FROM announcements ORDER BY id DESC");
$results = $obj->rows();
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <?php if(isset($success_message)): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p><?php echo $success_message; ?></p>
        </div>
    <?php endif; ?>

    <?php if(isset($error_message)): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p><?php echo $error_message; ?></p>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Manage Announcement Bar</h2>
        </div>
        
        <div class="p-6">
            <form method="post" action="" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Announcement Message
                    </label>
                    <input type="text" name="message" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Background Color
                        </label>
                        <div class="flex items-center space-x-3">
                            <input type="color" name="bg_color" value="#ff0000"
                                class="h-10 w-20 border border-gray-300 rounded-md shadow-sm">
                            <div class="text-sm text-gray-500">Choose background color</div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Text Color
                        </label>
                        <div class="flex items-center space-x-3">
                            <input type="color" name="text_color" value="#ffffff"
                                class="h-10 w-20 border border-gray-300 rounded-md shadow-sm">
                            <div class="text-sm text-gray-500">Choose text color</div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center">
                    <label class="flex items-center space-x-3 text-sm font-medium text-gray-700">
                        <input type="checkbox" name="status" class="h-4 w-4 text-blue-600 rounded border-gray-300">
                        <span>Make this announcement active</span>
                    </label>
                </div>

                <div>
                    <button type="submit" name="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Announcement
                    </button>
                </div>
            </form>

            <div class="mt-10">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Current Announcements</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preview</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach($results as $row){ ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-900">
                                    <?php echo htmlspecialchars($row['message']); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="p-2 rounded" style="background-color: <?php echo $row['bg_color']; ?>; color: <?php echo $row['text_color']; ?>">
                                        Sample Text
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if($row['status']): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Inactive
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="?delete=<?php echo $row['id']; ?>" 
                                       onclick="return confirm('Are you sure you want to delete this announcement?')"
                                       class="text-red-600 hover:text-red-900">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('includes/footer.php'); ?>
