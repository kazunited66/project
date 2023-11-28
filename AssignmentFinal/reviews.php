<?php

include_once "dbConnect.php";
if (!$conn) {
    die("connection failed: " . mysqli_connect_error());
}

$query = " SELECT reviews.review_id, users.firstName, users.lastName, users.email, movies.movie_id, reviews.rating, reviews.comment, reviews.review_date FROM reviews LEFT JOIN users ON reviews.user_id = users.user_id LEFT JOIN movies ON reviews.movie_id = movies.movie_id WHERE movies.movie_id = ? AND users.user_id != ? ORDER BY reviews.created_at DESC";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'ii', $id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result === false) {
    $row_count = 0;
} else {
    $row_count = mysqli_num_rows($result);
}

if ($row_count > 0) {

    echo '<div class="card h-100 p-3 gy-3">';
    echo '<h3>Reviews</h3>';

    while ($row = mysqli_fetch_array($result)) {
        $r_id = $row["review_id"];
        $f_name = $row["firstName"];
        $l_name = $row["lastName"];
        $email = $row["email"];
        $m_id = $row["movie_id"];
        $rating = $row["rating"];
        $comment = $row["comment"];
        $review_date = $row["review_date"];
        $percent = (($rating / 5) * 100);

        echo '<div class="card-body pt-3 gy-3">';
        echo '<h4 class="card-title font-weight-bold text-left">' . htmlspecialchars($f_name) . ' ' . htmlspecialchars($l_name) . '<br><h6 class="text-left">' . htmlspecialchars($email) . '</h6></h4>';

        echo '<p class="card-text comment-text">Comment: ' . nl2br(htmlspecialchars($comment)) . '</p>';
        echo '<div class="progress" style="height:20px">';
        echo '<div class="progress-bar " style="width:' . $percent . '%;">' . htmlspecialchars($rating) . '</div>';
        echo '</div></div><hr/>';
    }
    
    echo '</div>';
}
