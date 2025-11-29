
<?php
session_start();
?>

<?php
include("include/connection.php");
if(isset($_POST['login']))
{
	$email = $_POST['email'];
	$password = md5($_POST['password']);

	$sql="select email, password from users where email='$email' and password='$password'";
			$ad=mysqli_query($con,$sql);
            if(mysqli_num_rows($ad)==1)
            {
                $_SESSION['email']=$email;
                echo "<script>alert('Successfully Login!');</script>";
                echo "<script>window.location.href='dashboard.php';</script>";            }
            else
            {
                echo "<script>alert('Incorrect Email or Password');</script>";
            }
	
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-red-600 text-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <a href="index.php" class="text-3xl font-bold tracking-wide">Donate Blood</a>

            <a href="login.php" class="bg-white text-red-600 px-4 py-2 rounded-lg shadow-lg font-semibold hover:bg-gray-100 transition">Donate Now</a>
        </div>
    </nav>
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-2xl font-bold mb-6 text-center text-red-600">User Login</h2>
            <form action="login.php" method="POST" class="space-y-4">
                <!-- Email -->
                <div>
                    <label for="email" class="block font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" required>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" required>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" name="login" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg shadow-lg font-semibold hover:bg-red-700 transition">Login</button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">Don't have an account? <a href="register.php" class="text-red-600 font-bold hover:underline">Register</a></p>
                <p class="text-gray-600 mt-2">Forgot your password? <a href="forgot-password.php" class="text-red-600 font-bold hover:underline">Reset Password</a></p>
            </div>
        </div>
    </div>
    <footer class="bg-red-600 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Donate Blood. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
