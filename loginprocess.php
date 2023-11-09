<?php
    include('connection.php');
    if (isset($_POST['submit'])) {
        
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['pass']);
     

        $sql = "SELECT * from signup1 WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
    /*$email = mysqli_fetch_array($result, MYSQLI_ASSOC); */

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $email = $row["email"];
        $password = $row["pass"];
        if (password_verify($password, $password)) {
            header("Location: welcome.php");
        } else {
            echo "<div class='alert alert-danger'>Password does not match";
        }
    } else {
        echo "<div class='alert alert-danger'>Email does not match";
    }
        
       
         
    }
    ?>