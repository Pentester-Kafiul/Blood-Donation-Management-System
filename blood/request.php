<?php
session_start();
include("include/connection.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Handle new request submission
if (isset($_POST['request_blood'])) {
    $bloodGroup = $_POST['bloodGroup'];
    $quantity = $_POST['quantity'];
    $request_date = date("Y-m-d");
    $status = "0"; // Pending status by default

    $query = "INSERT INTO request (email, bloodGroup, quantity, request_date, status) VALUES ('$email', '$bloodGroup', '$quantity', '$request_date', '$status')";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Blood request submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error submitting request: " . mysqli_error($con) . "');</script>";
    }
}

// Handle delete request
if (isset($_GET['delete_request_id'])) {
    $request_id = $_GET['delete_request_id'];

    $delete_query = "DELETE FROM request WHERE id='$request_id' AND status='0'";

    if (mysqli_query($con, $delete_query)) {
        echo "<script>alert('Request deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting request: " . mysqli_error($con) . "');</script>";
    }
}

// Fetch user's previous requests
$user_requests_query = "SELECT * FROM request WHERE email='$email'";
$user_requests_result = mysqli_query($con, $user_requests_query);

// Fetch matching donors from bloodbank
$donors_query = "SELECT bloodbank.name, users.phone as phone, bloodbank.email AS email, bloodbank.bloodGroup AS bloodGroup, bloodbank.last_donated 
FROM bloodbank, request, users 
WHERE bloodbank.bloodGroup = request.bloodGroup 
AND request.status = '0' 
AND bloodbank.status = '0' 
AND request.email = '$email'
AND users.email = bloodbank.email";
$donors_result = mysqli_query($con, $donors_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Request</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <?php include("include/navbar.php"); ?>

    <!-- Main Layout -->
<div class="flex pt-16">        <!-- Sidebar -->
        <div class="w-64">
            <?php include("include/aside.php"); ?>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-4">Blood Request</h1>

            <!-- New Request Form -->
            <form method="POST" class="bg-white p-6 rounded-lg shadow-md mb-8">
                <h2 class="text-xl font-semibold mb-4">Request Blood</h2>
                <div class="mb-4">
                    <label for="bloodGroup" class="block text-sm font-medium text-gray-700">Blood Group</label>
                    <select name="bloodGroup" id="bloodGroup" class="w-full px-4 py-2 border rounded-lg">
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
                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity (In Bags)</label>
                    <input type="number" name="quantity" id="quantity" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                <button type="submit" name="request_blood" class="bg-red-600 text-white px-6 py-2 rounded-lg shadow-lg hover:bg-red-700">
                    Submit Request
                </button>
            </form>

            <!-- User's Previous Requests -->
            <h2 class="text-2xl font-semibold mb-4">Your Previous Requests</h2>
            <table class="w-full bg-white rounded-lg shadow-md mb-8">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">Request ID</th>
                        <th class="px-4 py-2">Blood Group</th>
                        <th class="px-4 py-2">Quantity</th>
                        <th class="px-4 py-2">Request Date</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($request = mysqli_fetch_assoc($user_requests_result)) { ?>
                        <tr class="border-b">
                            <td class="px-4 py-2">#<?php echo $request['id']; ?></td>
                            <td class="px-4 py-2"><?php echo $request['bloodGroup']; ?></td>
                            <td class="px-4 py-2"><?php echo $request['quantity']; ?></td>
                            <td class="px-4 py-2"><?php echo $request['request_date']; ?></td>
                            <td class="px-4 py-2">
                                <?php
                                if ($request['status'] == '0') echo "Pending";
                                elseif ($request['status'] == '1') echo "Success";
                                else echo "Failed";
                                ?>
                            </td>
                            <td class="px-4 py-2">
                                <?php if ($request['status'] == '0') { ?>
                                    <a href="?delete_request_id=<?php echo $request['id']; ?>" class="text-red-600 hover:underline">Delete</a>
                                <?php } else { ?>
                                    <span class="text-gray-500">Not Editable</span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Matching Donors -->
            <h2 class="text-2xl font-semibold mb-4">Available Donors</h2>
            <table class="w-full bg-white rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Phone</th>
                        <th class="px-4 py-2">Blood Group</th>
                        <th class="px-4 py-2">Last Donated</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($donor = mysqli_fetch_assoc($donors_result)) { ?>
                        <tr class="border-b">
                            <td class="px-4 py-2"><?php echo $donor['name']; ?></td>
                            <td class="px-4 py-2"><?php echo $donor['email']; ?></td>
                            <td class="px-4 py-2"><?php echo $donor['phone']; ?></td>
                            <td class="px-4 py-2"><?php echo $donor['bloodGroup']; ?></td>
                            <td class="px-4 py-2"><?php echo $donor['last_donated']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>