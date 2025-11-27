<?php
session_start();
include("include/connection.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Handle form submission
if (isset($_POST['update_request'])) {
    $request_id = $_POST['request_id'];
    $donor_id = $_POST['donor_id'];
    
    // Start transaction
    mysqli_begin_transaction($con);
    
    try {
        // Update request status
        $update_request = "UPDATE request SET status = '1' WHERE id = ? AND email = ?";
        $stmt = mysqli_prepare($con, $update_request);
        mysqli_stmt_bind_param($stmt, "is", $request_id, $email);
        mysqli_stmt_execute($stmt);
        
        // Update bloodbank status
        $update_donor = "UPDATE bloodbank SET status = '1' WHERE id = ?";
        $stmt = mysqli_prepare($con, $update_donor);
        mysqli_stmt_bind_param($stmt, "i", $donor_id);
        mysqli_stmt_execute($stmt);
        
        // Commit transaction
        mysqli_commit($con);
        echo "<script>alert('Request updated successfully!');</script>";
    } catch (Exception $e) {
        // Rollback on error
        mysqli_rollback($con);
        echo "<script>alert('Error updating request: " . mysqli_error($con) . "');</script>";
    }
}

// Fetch active request and available donors
$query = "SELECT r.id as request_id, r.bloodGroup, r.quantity, r.request_date,
                 b.id as donor_id, b.name as donor_name, b.email as donor_email, 
                 u.phone as donor_phone, b.last_donated
          FROM request r
          LEFT JOIN bloodbank b ON b.bloodGroup = r.bloodGroup AND b.status = '0'
          LEFT JOIN users u ON b.email = u.email
          WHERE r.email = ? AND r.status = '0'";

$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Request</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <?php include("include/navbar.php"); ?>
    <div class="flex min-h-screen pt-16">
        <?php include("include/aside.php"); ?>
        
        <main class="flex-1 ml-64 p-8">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-red-600 px-8 py-4">
                        <h2 class="text-2xl font-bold text-white">Update Blood Request</h2>
                    </div>

                    <div class="p-6">
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <div class="mb-8 p-6 border rounded-lg">
                                    <h3 class="text-xl font-semibold mb-4">Request Details</h3>
                                    <div class="grid grid-cols-2 gap-4 mb-6">
                                        <div>
                                            <p class="text-gray-600">Request ID:</p>
                                            <p class="font-medium">#<?php echo $row['request_id']; ?></p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Blood Group:</p>
                                            <p class="font-medium"><?php echo $row['bloodGroup']; ?></p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Quantity:</p>
                                            <p class="font-medium"><?php echo $row['quantity']; ?> units</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Request Date:</p>
                                            <p class="font-medium"><?php echo $row['request_date']; ?></p>
                                        </div>
                                    </div>

                                    <?php if ($row['donor_id']): ?>
                                        <div class="mb-6">
                                            <h4 class="font-semibold mb-3">Available Donor</h4>
                                            <div class="bg-gray-50 p-4 rounded-lg">
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <p class="text-gray-600">Donor Name:</p>
                                                        <p class="font-medium"><?php echo $row['donor_name']; ?></p>
                                                    </div>
                                                    <div>
                                                        <p class="text-gray-600">Phone:</p>
                                                        <p class="font-medium"><?php echo $row['donor_phone']; ?></p>
                                                    </div>
                                                    <div>
                                                        <p class="text-gray-600">Email:</p>
                                                        <p class="font-medium"><?php echo $row['donor_email']; ?></p>
                                                    </div>
                                                    <div>
                                                        <p class="text-gray-600">Last Donated:</p>
                                                        <p class="font-medium"><?php echo $row['last_donated']; ?></p>
                                                    </div>
                                                </div>
                                                
                                                <form method="POST" class="mt-6">
                                                    <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
                                                    <input type="hidden" name="donor_id" value="<?php echo $row['donor_id']; ?>">
                                                    <button type="submit" name="update_request" 
                                                            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                                            onclick="return confirm('Confirm that you have received the blood?')">
                                                        Confirm Blood Received
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="bg-yellow-50 text-yellow-800 p-4 rounded-lg">
                                            No matching donors available at the moment.
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="text-center py-8">
                                <p class="text-gray-600">No active requests found.</p>
                                <a href="request.php" class="inline-block mt-4 bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">
                                    Create New Request
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>