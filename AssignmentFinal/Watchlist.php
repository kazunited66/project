<?php
if (isset($_POST['data']) && !empty($_POST['data'])) {

    include "dbConnect.php";
    if (!$conn) {
        die("connection failed: " . mysqli_connect_error());
    }
    $dataObj = json_decode($_POST['data'])[0];
    
    $user_id = $dataObj->user_id;
    $movie_id = $dataObj->movie_id;
    $result = false;
    
    if(!empty($user_id) && !empty($movie_id)) {
        if($dataObj->action === 'add') {
            // add watchlist
            $query = "INSERT INTO watchlist (user_id, movie_id) VALUES (?, ?)";
        } else {
            // delete watchlist
            $query = "DELETE FROM watchlist WHERE user_id = ? AND movie_id = ?";
        }
    
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ii', $user_id, $movie_id);
        $result = mysqli_stmt_execute($stmt);
    }
    
    echo json_encode($result);
}