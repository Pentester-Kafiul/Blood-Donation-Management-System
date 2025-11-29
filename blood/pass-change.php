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

// Handle password change form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = md5($_POST['current_password']);
    $newPassword = md5($_POST['new_password']);
    $confirmPassword = md5($_POST['confirm_password']);

    if ($currentPassword !== $user['password']) {
        $error = "Current password is incorrect.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "New passwords do not match.";
    } else {
        $updateQuery = "UPDATE users SET password='$newPassword' WHERE email='$email'";
        mysqli_query($con, $updateQuery);
        $success = "Password changed successfully.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <?php include("include/navbar.php"); ?>
    <div class="flex min-h-screen pt-16">
        <?php include("include/aside.php"); ?>

        <main class="flex-1 ml-64 p-8">
            <div class="max-w-xl mx-auto bg-white rounded-lg shadow p-8">
                <h2 class="text-2xl font-bold mb-6 text-center text-red-600">Change Password</h2>

                <?php if (!empty($error)): ?>
                    <div class="mb-4 text-red-600 font-semibold"><?= $error ?></div>
                <?php elseif (!empty($success)): ?>
                    <div class="mb-4 text-green-600 font-semibold"><?= $success ?></div>
                <?php endif; ?>

                <form method="POST" action="" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Current Password</label>
                        <input type="password" name="current_password" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="new_password" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input type="password" name="confirm_password" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500">
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
