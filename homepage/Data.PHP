<?php  //this is the file containing php for displaying image and loading the content to the website
include "dbConnect.php";
if (!$conn) {
    die("connection failed: " . mysqli_connect_error());
}
$query = "SELECT movies.movie_id, movies.title, movies.release_year, genres.genre_name, directors.director_name, actors.actor_name, movies.description, movies.language, movies.ImageURL FROM movies INNER JOIN genres ON movies.genre_id=genres.genre_id INNER JOIN directors ON movies.director_id=directors.director_id LEFT JOIN movieactors ON movies.movie_id = movieactors.movie_id LEFT JOIN actors ON movieactors.actor_id = actors.actor_id";
$result = false;

if(isset($_GET['category']) && $_GET['category'] !== 'ALL') {
    $query = $query . " WHERE genres.genre_name = ? ORDER BY RAND()";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $_GET['category']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
} else if(isset($_GET['search'])) {
    $query = $query . " WHERE movies.title LIKE ? OR genres.genre_name LIKE ? OR directors.director_name LIKE ? OR actors.actor_name LIKE ? ORDER BY RAND()";
    $stmt = mysqli_prepare($conn, $query);
    $param = '%' . $_GET['search'] . '%';
    mysqli_stmt_bind_param($stmt, 'ssss', $param, $param, $param, $param);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

} else {
    $query = $query . " ORDER BY RAND()";
    $result = mysqli_query($conn,$query);
}

if($result === false) {
    $row_count = 0;
} else {
    $row_count = mysqli_num_rows($result);
}

$watchList = [];

// If you are not logged in
if(isset($_SESSION['user_id'])) {
    $watchList = getWatchList($conn, $_SESSION['user_id']);
}

mysqli_close($conn);

if($row_count > 0){

    while($row = mysqli_fetch_array($result)){
        $id = $row["movie_id"];
        $title = $row["title"];
        $release = $row["release_year"];
        $genre = $row["genre_name"];
        $director = $row["director_name"];
        $actor = $row["actor_name"];
        $description = $row["description"];
        $language = $row["language"];
        $img1 = $row["ImageURL"];
        $img2 = "Image/".$img1;
        
        if(in_array($id, $watchList)) {
            $watchlist_value = '－Watchlist';
        } else {
            $watchlist_value = '＋Watchlist';
        }
        
        echo '<div class="col-md-3 p-3" >';
        
        echo '<div class="card h-100">';
        echo '<a href="DetailView.php?id='.$id.'">';
        echo '<img src='.$img2.' class="card-img-top" alt="image"></a>';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">'.$title.'</h5>';
        echo '<p class="card-text">Director: '.$director.'<br>Release year:'.$release.'<br> Actor:'.$actor.'</p>';
        
        // If you are not logged in
        if(isset($_SESSION['user_last_name'])) {
            echo '<input type="button" class="watchlist-button btn btn-primary" data-mid="' . $id . '" value="' . $watchlist_value . '">';
            
        // If you are logged in
        } else {
            echo '<a href="Login.html" class="btn btn-primary">＋Watchlist</a>';
        }
        
        echo '</div></a></div></div>';
          
    }
}

// Function that returns a list of watchlist on login user
function getWatchList($conn, $user_id) {
    
    $query = "SELECT movie_id FROM watchlist WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    $fetch_result = $result->fetch_all(MYSQLI_ASSOC);
    
    $watchlist = [];
    
    foreach ($fetch_result as $array) {
        $watchlist[] = $array['movie_id'];
    }
    
    return $watchlist;
}