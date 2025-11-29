<?php
session_start();
include("include/connection.php");

if (!isset($_SESSION['email'])) {
    echo "<script>alert('You must log in first!');</script>";
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$email = $_SESSION['email'];
$query = "SELECT name, bloodGroup FROM users WHERE email='$email'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "<script>alert('User not found!');</script>";
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$allowSignAsDonor = false;
$lastStatusQuery = "SELECT status FROM bloodbank WHERE email='$email' ORDER BY last_donated DESC LIMIT 1";
$statusResult = mysqli_query($con, $lastStatusQuery);

if ($statusResult && mysqli_num_rows($statusResult) > 0) {
    $lastStatus = mysqli_fetch_assoc($statusResult)['status'];
    if ($lastStatus == '1') {
        $allowSignAsDonor = true;
    }
} else {
    $allowSignAsDonor = true; // Allow if no previous record exists
}

if (isset($_POST['submit']) && $allowSignAsDonor) {
    $last_donated = $_POST['last_donated'];
    $status = '0'; // Default status as pending

    $insert_query = "INSERT INTO bloodbank (email, last_donated, name, bloodGroup, status) VALUES ('$email', '$last_donated', '{$user['name']}', '{$user['bloodGroup']}', '$status')";

    if (mysqli_query($con, $insert_query)) {
        echo "<script>alert('Donor registration successful!');</script>";
        echo "<script>window.location.href='signdonor.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}

if (isset($_GET['delete']) && isset($_GET['email'])) {
    $delete_email = $_GET['email'];

    $status_check_query = "SELECT status FROM bloodbank WHERE email='$delete_email'";
    $status_check_result = mysqli_query($con, $status_check_query);

    if ($status_check_result && mysqli_num_rows($status_check_result) > 0) {
        $row = mysqli_fetch_assoc($status_check_result);
        if ($row['status'] == '0') {
            $delete_query = "DELETE FROM bloodbank WHERE email='$delete_email'";
            if (mysqli_query($con, $delete_query)) {
                echo "<script>alert('Record deleted successfully.');</script>";
                echo "<script>window.location.href='signdonor.php';</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
            }
        } else {
            echo "<script>alert('Cannot delete record with status other than pending.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Donor</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <?php include("include/navbar.php"); ?>
    <div class="flex min-h-screen pt-16">
        <?php include("include/aside.php"); ?>
        
        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <div class="max-w-4xl mx-auto">
                <!-- Sign as Donor Form Card -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                    <!-- Header -->
                    <div class="bg-red-600 px-8 py-4">
                        <h2 class="text-2xl font-bold text-white text-center">Sign as Donor</h2>
                    </div>

                    <!-- Form Content -->
                    <div class="p-8">
                        <?php if ($allowSignAsDonor): ?>
                        <form method="POST" action="signdonor.php" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <input 
                                        type="text" 
                                        name="name" 
                                        value="<?= htmlspecialchars($user['name']); ?>" 
                                        class="w-full px-4 py-2 border rounded-lg bg-gray-50" 
                                        readonly
                                    >
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Blood Group</label>
                                    <input 
                                        type="text" 
                                        name="bloodGroup" 
                                        value="<?= htmlspecialchars($user['bloodGroup']); ?>" 
                                        class="w-full px-4 py-2 border rounded-lg bg-gray-50" 
                                        readonly
                                    >
                                </div>

                                <div class="space-y-2 md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Last Donated Date</label>
                                    <input 
                                        type="date" 
                                        name="last_donated" 
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                                        required
                                    >
                                </div>
                            </div>

                            <div class="flex justify-center pt-4">
                                <button 
                                    type="submit" 
                                    name="submit" 
                                    class="px-6 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                >
                                    Register as Donor
                                </button>
                            </div>
                        </form>
                        <?php else: ?>
                        <div class="bg-red-50 border-l-4 border-red-500 p-4">
                            <p class="text-red-700">
                                You can only sign as a donor after your previous donation is marked as successful.
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Donor Record Card -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="border-b px-8 py-4">
                        <h3 class="text-xl font-semibold text-gray-800">Your Donor Record</h3>
                    </div>

                    <div class="p-8">
                        <?php
                        $record_query = "SELECT * FROM bloodbank WHERE email='$email'";
                        $record_result = mysqli_query($con, $record_query);

                        if ($record_result && mysqli_num_rows($record_result) > 0):
                        ?>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Blood Group</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Donated</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php while ($record = mysqli_fetch_assoc($record_result)): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($record['name']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($record['bloodGroup']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($record['last_donated']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php 
                                            $status_class = '';
                                            $status_text = '';
                                            
                                            switch($record['status']) {
                                                case '0':
                                                    $status_class = 'bg-yellow-100 text-yellow-800';
                                                    $status_text = 'Pending';
                                                    break;
                                                case '1':
                                                    $status_class = 'bg-green-100 text-green-800';
                                                    $status_text = 'Successful';
                                                    break;
                                                default:
                                                    $status_class = 'bg-red-100 text-red-800';
                                                    $status_text = 'Failed';
                                            }
                                            ?>
                                            <span class="px-2 py-1 text-sm rounded-full <?= $status_class ?>">
                                                <?= $status_text ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php if ($record['status'] == '0'): ?>
                                                <a 
                                                    href="?delete=1&email=<?= htmlspecialchars($record['email']); ?>" 
                                                    class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Are you sure you want to delete this record?')"
                                                >
                                                    Delete
                                                </a>
                                            <?php else: ?>
                                                <span class="text-gray-400">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                            <p class="text-gray-500 text-center py-4">No donor records found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>