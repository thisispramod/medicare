<?php
require_once 'db_connect.php';
$obj = new database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $obj->validate($_POST['name']);
    $email = $obj->validate($_POST['email']);
    $phone = $obj->validate($_POST['phone']);
    $subject = $obj->validate($_POST['subject']);
    $message = $obj->validate($_POST['message']);

    $f = array('name','email','phone','subject','message');
    $v = array($name, $email, $phone, $subject, $message);
    $insert = $obj->insert('contacts', $f, $v); 

    if ($insert === TRUE) {
        echo "<script>
                alert('Thank you for contacting us! We will get back to you soon.');
                window.location.href = 'contact.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $obj->error . "');
                window.location.href = 'contact.php';
              </script>";
    }
}
 
?>
