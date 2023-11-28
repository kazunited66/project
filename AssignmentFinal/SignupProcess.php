<?php

include "dbConnect.php";
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
    echo $query;
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "<p>something went wrong:</p> " . $query;
    } else {
        echo " <p>record inserted successfully</p>";
    }
}
