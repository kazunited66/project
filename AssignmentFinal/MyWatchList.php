<?php
if(!isset($_SESSION)){
    session_start();
}

include "dbConnect.php";
if (!$conn) {
    die("connection failed: " . mysqli_connect_error());
}

$query = "SELECT movies.movie_id, movies.title, movies.release_year, genres.genre_name, directors.director_name, actors.actor_name, movies.description, movies.language, movies.ImageURL FROM movies INNER JOIN genres ON movies.genre_id=genres.genre_id INNER JOIN directors ON movies.director_id=directors.director_id LEFT JOIN movieactors ON movies.movie_id = movieactors.movie_id LEFT JOIN actors ON movieactors.actor_id = actors.actor_id WHERE movies.movie_id IN (SELECT movie_id FROM watchlist WHERE user_id = ?)";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
mysqli_close($conn);

if($result === false) {
    $row_count = 0;
} else {
    $row_count = mysqli_num_rows($result);
}

$watchList = [];

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
                
        echo '<div class="col-md-3 p-3" >';
        
        echo '<div class="card h-100">';
        echo '<a href="DetailView.php?id='.$id.'">';
        echo '<img src='.$img2.' class="card-img-top" alt="image"></a>';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">'.$title.'</h5>';
        echo '<p class="card-text">Director: '.$director.'<br>Release year:'.$release.'<br> Actor:'.$actor.'</p>';
        
        echo '<input type="button" class="watchlist-button btn btn-primary" data-mid="' . $id . '" value="－Watchlist">';
        
        echo '</div></a></div></div>';
          
    }
}
