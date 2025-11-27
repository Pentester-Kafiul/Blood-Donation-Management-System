<?php
session_start();
include("include/connection.php");

if (!isset($_SESSION['email'])) {
    echo "<script>alert('You must log in first!');</script>";
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$email = $_SESSION['email'];
$query = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

// Handle form submission for updating profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $bloodGroup = $_POST['bloodGroup'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $occupation = $_POST['occupation'];
    $chatId = $_POST['chatId'];

    $updateQuery = "UPDATE users SET 
                    name='$name', 
                    bloodGroup='$bloodGroup', 
                    phone='$phone', 
                    address='$address', 
                    gender='$gender', 
                    occupation='$occupation', 
                    chatId='$chatId' 
                    WHERE email='$email'";
    mysqli_query($con, $updateQuery);

    // Refresh user data after update
    $result = mysqli_query($con, $query);
    $user = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <?php include("include/navbar.php"); ?>
    <div class="flex min-h-screen pt-16">
        <?php include("include/aside.php"); ?>
        
        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <!-- Profile Header -->
                    <div class="bg-red-600 px-8 py-6">
                        <h2 class="text-2xl font-bold text-white text-center">My Profile</h2>
                    </div>

                    <!-- Profile Content -->
                    <div class="p-8">
                        <form method="POST" action="" enctype="multipart/form-data" class="space-y-6">
                            <!-- Profile Picture Section -->
                            <div class="flex justify-center mb-8">
                                <div class="relative">
                                    <img 
                                        src="image/user/<?= htmlspecialchars($user['image']); ?>" 
                                        alt="Profile Picture" 
                                        class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg"
                                    >
                                    <label class="absolute bottom-0 right-0 bg-red-600 text-white p-2 rounded-full cursor-pointer shadow-lg hover:bg-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                        <input type="file" name="profile_image" class="hidden">
                                    </label>
                                </div>
                            </div>

                            <!-- Form Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <input 
                                        type="text" 
                                        name="name" 
                                        value="<?= htmlspecialchars($user['name']); ?>" 
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    >
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <input 
                                        type="email" 
                                        value="<?= htmlspecialchars($user['email']); ?>" 
                                        class="w-full px-4 py-2 border rounded-lg bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Blood Group</label>
                                    <select 
                                        name="bloodGroup" 
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    >
                                        <?php
                                        $blood_groups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
                                        foreach ($blood_groups as $group) {
                                            $selected = $user['bloodGroup'] === $group ? 'selected' : '';
                                            echo "<option value='$group' $selected>$group</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                                    <input 
                                        type="tel" 
                                        name="phone" 
                                        value="<?= htmlspecialchars($user['phone']); ?>" 
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    >
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Gender</label>
                                    <select 
                                        name="gender" 
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    >
                                        <option value="Male" <?= $user['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                                        <option value="Female" <?= $user['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                                        <option value="Other" <?= $user['gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Occupation</label>
                                    <input 
                                        type="text" 
                                        name="occupation" 
                                        value="<?= htmlspecialchars($user['occupation']); ?>" 
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    >
                                </div>

                                <div class="md:col-span-2 space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Address</label>
                                    <textarea 
                                        name="address" 
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                        rows="3"
                                    ><?= htmlspecialchars($user['address']); ?></textarea>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-center space-x-4 pt-6">
                                <button 
                                    type="submit" 
                                    name="update_profile"
                                    class="px-6 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                >
                                    Save Changes
                                </button>
                                <a 
                                    href="change_password.php" 
                                    class="px-6 py-2 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                                >
                                    Change Password
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>