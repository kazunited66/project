<?php
session_start();
include "dbConnect.php";
if(!$conn){
    die("connection failed: ". mysqli_connect_error());
}
else{
    $email = $_POST["email"];
    $pwd = $_POST["password"];
}

$is_loginError = 0;

$query1="SELECT * FROM users WHERE email ='".$email."' LIMIT 1";
$result1 = mysqli_query($conn,$query1);

if (mysqli_num_rows($result1)>0){
    $row = mysqli_fetch_array($result1);
    if (password_verify($pwd,$row["password_hash"])){

        $_SESSION["email"] = $email;
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["user_last_name"] = $row["lastName"];
        header("Location: Home.php");

    } else {
        $is_loginError = 1;
    }
} else {
    $is_loginError = 1;
}

?>

<script type="text/javascript">  
    if(<?php echo $is_loginError; ?> === 1) {
        alert('Email or password is incorrect');
    }
    
    location.replace('Login.html');
</script>