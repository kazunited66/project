<?php
session_start();
include "dbConnect.php";

$is_signupError = 0;

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $address = $_POST["addr"];
    $pwd = $_POST["password"];
    $hash = password_hash($pwd, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (firstName,lastName,address,email,password_hash) VALUES ('" . $fname . "','" . $lname . "','" . $address . "', '" . $email . "','" . $hash . "')";

    $result = mysqli_query($conn, $query);
    
    // record inserted successfully
    if ($result) {
        // login process
        $query2 = "SELECT * FROM users WHERE email = ? LIMIT 1";
        
        $stmt = mysqli_prepare($conn, $query2);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);

        $result2 = mysqli_stmt_get_result($stmt);
        
        if($result === false) {
            $row_count = 0;
        } else {
            $row_count = mysqli_num_rows($result2);
        }

        if ($row_count > 0){
            $row = mysqli_fetch_array($result2);
        
            $_SESSION["email"] = $email;
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["user_last_name"] = $lname;
        }
        
    } else {
        $is_signupError = 1;
    }
    
    mysqli_close($conn);
}
?>

<script type="text/javascript">
    if(<?php echo $is_signupError; ?> === 1) {
        alert('Signup failed');
        location.replace('Signup.html');
    } else {
        alert('Signup successfully');
        location.replace('Home.php');
    }
</script>