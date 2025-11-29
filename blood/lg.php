<?php
session_start();
?>

<?php
include("include/connection.php");
if(isset($_POST['login']))
{
	$email=$_POST['email'];
	$password=$_POST['password'];

	$sql="select email, password from (table name) where email='$email' and password='$password'";
			$ad=mysqli_query($con,$sql);
            if(mysqli_num_rows($ad)==1)
            {
                $_SESSION['email']=$email;
                header("Location: home.php");
            }
            else
            {
                echo "<p style='color: red;'>Incorrect UserId or Password</p>";
            }
	
}
?>
