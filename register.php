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



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
    <nav class="bg-red-600 text-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <a href="index.php" class="text-3xl font-bold tracking-wide">Donate Blood</a>

            <a href="login.php" class="bg-white text-red-600 px-4 py-2 rounded-lg shadow-lg font-semibold hover:bg-gray-100 transition">Donate Now</a>
        </div>
    </nav>


<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-2xl font-bold mb-6 text-center text-red-600">Donor or Reciver Register</h2>
            <form action="register.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                <!-- Email -->
                <div>
                    <label for="email" class="block font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" required>
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" required>
                </div>

                <!-- Blood Group -->
                <div>
                    <label for="bloodGroup" class="block font-medium text-gray-700">Blood Group</label>
                    <select id="bloodGroup" name="bloodGroup" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" required>
                        <option value="">Select Blood Group</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block font-medium text-gray-700">Phone</label>
                    <input type="number" id="phone" name="phone" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" required>
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block font-medium text-gray-700">Address</label>
                    <textarea id="address" name="address" rows="3" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" required></textarea>
                </div>

                <!-- Gender -->
                <div>
                    <label class="block font-medium text-gray-700">Gender</label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="gender" value="Male" class="form-radio text-red-600" required>
                            <span class="ml-2">Male</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="gender" value="Female" class="form-radio text-red-600" required>
                            <span class="ml-2">Female</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="gender" value="Other" class="form-radio text-red-600" required>
                            <span class="ml-2">Other</span>
                        </label>
                    </div>
                </div>

                <!-- Occupation -->
                <div>
                    <label for="occupation" class="block font-medium text-gray-700">Occupation</label>
                    <input type="text" id="occupation" name="occupation" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>

                <!-- Chat ID -->
                <div>
                    <label for="chatId" class="block font-medium text-gray-700">Chat ID</label>
                    <input type="number" id="chatId" name="chatId" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>

                <!-- Profile Image -->
                <div>
                    <label for="image" class="block font-medium text-gray-700">Profile Image</label>
                    <input type="file" id="image" name="image" accept="image/*" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" required>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" name="register" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg shadow-lg font-semibold hover:bg-red-700 transition">Register</button>
                </div>
            </form>
        </div>
    </div>
    <footer class="bg-red-600 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Donate Blood. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
