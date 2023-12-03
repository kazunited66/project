<?php
session_start();

include_once "dbConnect.php";
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = '';
$movie_id = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $movie_id = $_POST['movie_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $query = "INSERT INTO reviews (user_id, movie_id, rating, comment) VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'iiis', $user_id, $movie_id, $rating, $comment);
    $result = mysqli_stmt_execute($stmt);
    
    if($result === false) {
        $message = "Processing failed";
    } else {
        $message = "Submitted a review";
    }
}
?>

<script type="text/javascript">
    var message = '<?php echo $message; ?>';
    var movieId = '<?php echo $movie_id; ?>';
    var url = 'Home.php';
    
    if(movieId !== '') {
        url = 'DetailView.php?id=' + movieId;
    }
    
    if(message !== '') {
        alert(message);
    }
    
    location.replace(url);
</script>