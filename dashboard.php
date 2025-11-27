<?php
session_start();
include("../include/connection.php");

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Get current user's email
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-red-600 text-white shadow-lg fixed top-0 w-full z-50">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <a href="dashboard.php" class="text-2xl font-bold">Blood Donation</a>
            <ul class="flex space-x-6">
                <li><a href="dashboard.php" class="hover:text-gray-300">Dashboard</a></li>
                <li><a href="profile.php" class="hover:text-gray-300">Profile</a></li>
                <li><a href="logout.php" class="hover:text-gray-300">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Layout -->
    <div class="flex pt-16">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white fixed h-full left-0 overflow-y-auto">
            <div class="p-4">
                <h2 class="text-xl font-bold mb-4">Menu</h2>
                <ul class="space-y-3">
                    <li>
                        <a href="dashboard.php" class="block px-4 py-2 rounded-lg bg-gray-700">Dashboard</a>
                    </li>
                    <li>
                        <a href="profile.php" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-150">Profile</a>
                    </li>
                    <li>
                        <a href="request.php" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-150">Request Donate</a>
                    </li>
                    <li>
                        <a href="signdonor.php" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-150">Sign As Donor</a>
                    </li>
                    <li>
                        <a href="logout.php" class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-150">Logout</a>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-3xl font-bold mb-8">Dashboard</h1>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Donors -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-gray-500 text-sm font-medium">Total Donors</h3>
                        <p class="text-3xl font-bold text-gray-900">
                            <?php
                            $query = "SELECT COUNT(*) as count FROM bloodbank WHERE status='0'";
                            $result = mysqli_query($con, $query);
                            $row = mysqli_fetch_assoc($result);
                            echo $row['count'];
                            ?>
                        </p>
                    </div>

                    <!-- Active Requests -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-gray-500 text-sm font-medium">Active Requests</h3>
                        <p class="text-3xl font-bold text-gray-900">
                            <?php
                            $query = "SELECT COUNT(*) as count FROM request WHERE status='0'";
                            $result = mysqli_query($con, $query);
                            $row = mysqli_fetch_assoc($result);
                            echo $row['count'];
                            ?>
                        </p>
                    </div>

                    <!-- Total Users -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-gray-500 text-sm font-medium">Total Users</h3>
                        <p class="text-3xl font-bold text-gray-900">
                            <?php
                            $query = "SELECT COUNT(*) as count FROM users";
                            $result = mysqli_query($con, $query);
                            $row = mysqli_fetch_assoc($result);
                            echo $row['count'];
                            ?>
                        </p>
                    </div>

                    <!-- Successful Donations -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-gray-500 text-sm font-medium">Successful Donations</h3>
                        <p class="text-3xl font-bold text-gray-900">
                            <?php
                            $query = "SELECT COUNT(*) as count FROM request WHERE status='1'";
                            $result = mysqli_query($con, $query);
                            $row = mysqli_fetch_assoc($result);
                            echo $row['count'];
                            ?>
                        </p>
                    </div>
                </div>

                <!-- Blood Availability Table -->
                <div class="bg-white rounded-lg shadow-md mb-8">
                    <div class="px-6 py-4 border-b">
                        <h2 class="text-xl font-semibold">Blood Availability</h2>
                    </div>
                    <div class="p-6">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-3 px-4">Blood Group</th>
                                    <th class="text-left py-3 px-4">Available Donors</th>
                                    <th class="text-left py-3 px-4">Active Requests</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $blood_groups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
                                foreach ($blood_groups as $group) {
                                    $donors_query = "SELECT COUNT(*) as count FROM bloodbank WHERE bloodGroup='$group' AND status='0'";
                                    $donors_result = mysqli_query($con, $donors_query);
                                    $donors = mysqli_fetch_assoc($donors_result)['count'];

                                    $requests_query = "SELECT COUNT(*) as count FROM request WHERE bloodGroup='$group' AND status='0'";
                                    $requests_result = mysqli_query($con, $requests_query);
                                    $requests = mysqli_fetch_assoc($requests_result)['count'];
                                ?>
                                <tr class="border-b">
                                    <td class="py-3 px-4"><?php echo $group; ?></td>
                                    <td class="py-3 px-4"><?php echo $donors; ?></td>
                                    <td class="py-3 px-4"><?php echo $requests; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b">
                        <h2 class="text-xl font-semibold">Recent Requests</h2>
                    </div>
                    <div class="p-6">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-3 px-4">Date</th>
                                    <th class="text-left py-3 px-4">Requester</th>
                                    <th class="text-left py-3 px-4">Blood Group</th>
                                    <th class="text-left py-3 px-4">Quantity</th>
                                    <th class="text-left py-3 px-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT r.*, u.name FROM request r 
                                         JOIN users u ON r.email = u.email 
                                         ORDER BY request_date DESC LIMIT 5";
                                $result = mysqli_query($con, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $status_class = $row['status'] == '0' ? 'bg-yellow-100 text-yellow-800' : ($row['status'] == '1' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800');
                                    $status_text = $row['status'] == '0' ? 'Pending' : ($row['status'] == '1' ? 'Success' : 'Failed');
                                ?>
                                <tr class="border-b">
                                    <td class="py-3 px-4"><?php echo $row['request_date']; ?></td>
                                    <td class="py-3 px-4"><?php echo $row['name']; ?></td>
                                    <td class="py-3 px-4"><?php echo $row['bloodGroup']; ?></td>
                                    <td class="py-3 px-4"><?php echo $row['quantity']; ?></td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 rounded-full text-sm <?php echo $status_class; ?>">
                                            <?php echo $status_text; ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>