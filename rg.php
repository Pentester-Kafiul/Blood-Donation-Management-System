<?php
include("include/connection.php");

function processImageUpload($image, $phone, $filePath) {
    $ext = explode(".", $image['name']);
    $ext = end($ext);
    $date = date("D:M:Y");
    $time = date("h:i:s");
    $image11 = md5($date . $time . $phone);
    $imagename = $image11 . "." . $ext;

    if (move_uploaded_file($image['tmp_name'], "$filePath$imagename")) {
        return $imagename;
    }
    return null;
}

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $bloodGroup = $_POST['bloodGroup'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $occupation = $_POST['occupation'];
    $chatId = $_POST['chatId'];
    $password = md5($_POST['password']);
    $image = $_FILES['image'];

    $filePath = "image/user/";
    $imagename = processImageUpload($image, $phone, $filePath);

    $query = "INSERT INTO users VALUES('$email', '$name', '$bloodGroup', '$phone', '$address', '$gender', '$occupation', '$chatId', '$imagename', '$password')";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Successfully Registered!');</script>";
        echo "<script>window.location.href='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

