<?php
session_start();
$login_user_name = '';
$user_id = '';
$watchlist_value = "";

include "dbConnect.php";
if (!$conn) {
    die("connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("Location:Home.php");
    exit();
}

if (isset($_SESSION['user_last_name']) && isset($_SESSION['user_id'])) {
    $login_user_name = $_SESSION['user_last_name'];
    $user_id = $_SESSION['user_id'];
    
    if (isInWatchList($conn, $user_id, $id)) {
        $watchlist_value = '－Watchlist';
    } else {
        $watchlist_value = '＋Watchlist';
    }
}

// get movie detail
$query="SELECT movies.movie_id, movies.title, movies.release_year, genres.genre_name, directors.director_name, actors.actor_name, movies.description, movies.language, movies.ImageURL FROM movies LEFT JOIN genres ON movies.genre_id = genres.genre_id LEFT JOIN directors ON movies.director_id = directors.director_id LEFT JOIN movieactors ON movies.movie_id = movieactors.movie_id LEFT JOIN actors ON movieactors.actor_id = actors.actor_id WHERE movies.movie_id = ?";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if($result !== false) {

    while ($row = mysqli_fetch_array($result)) {
        $title = $row["title"];
        $release = $row["release_year"];
        $genre = $row["genre_name"];
        $director = $row["director_name"];
        $actor = $row["actor_name"];
        $description = $row["description"];
        $language = $row["language"];
        $imgUrl = "Image/" . $row["ImageURL"];
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>MTReview</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
              integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--ajax scrip-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <style>
            body {
                padding-bottom: 50px;
            }
            
            .comment-text {
                word-wrap: break-word;
            }
            
            .float-l {
                float: left;
            }

            .clear-b {
                clear: both;
            }
            
            .review-form-area {
                margin: 10px 0px;
                padding: 10px 0px;
            }

            .card-img-top{
                width: 100%;
                height: 15vw;
                object-fit: cover;
            }
            /* Remove the navbar's default margin-bottom and rounded borders */
            .navbar {
                margin-bottom: 0;
                border-radius: 0;
            }

            /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
            .row.content {
                height: 450px
            }

            /* Set gray background color and 100% height */
            .sidenav {
                padding-top: 20px;
                background-color: #f1f1f1;
                height: 100%;
            }

            /* Set black background color, white text and some padding */
            footer {
                background-color: #555;
                color: white;
                padding: 15px;
            }

            /* On small screens, set height to 'auto' for sidenav and grid */
            @media screen and (max-width: 767px) {
                .sidenav {
                    height: auto;
                    padding: 15px;
                }

                .row.content {
                    height: auto;
                }
            }
        </style>
    </head>

<body>

<nav class="navbar navbar-expand-sm bg-light navbar-light ">
    <div class="navbar-header">
        <a class="navbar-brand" href="#">MT<b>Review</b></a>
    </div>

    <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="Home.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Movies</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">AboutUs</a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
    <?php
    // If you are not logged in
    if(empty($login_user_name)) {
    ?>
      <li class="nav-item">
        <a class="nav-link" href="Login.html" id="login"><i class="material-icons">person</i> Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Signup.html" id="signup"><i class="material-icons">login</i>SignUP</a>
      </li>
    <?php
    // If you are logged in
    } else {
    ?>
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="material-icons">person</i> <?php echo htmlspecialchars($login_user_name); ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="Account.php">Account</a>
          <a class="dropdown-item" href="MyWatchList.php">MyWatchList</a>
        </div>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="logout.php" id="logout"><i class="material-icons">logout</i>Logout</a>
      </li>
    <?php
    }
    ?>
    </ul>
</nav>
<div class="container ">
    <div class="col text-center">
      <div class="container pt-3" >
          
      </div>
</div>


<div class="container ">
    <div class="col text-center">
        
        <?php
        echo'<div class="h-100">';
        echo'<img src='.$imgUrl.' class="card-img-top w-25 float-l" style="height: auto; margin-right:10px;" alt="image" >';
        echo'<div class="card-body  w-70 float-l">';
        
        echo'<h1 class="card-title font-weight-bold" style="padding-bottom:10px;">'.$title.'</h1>';
        
        echo'<p class="card-text "><h5 class="text-left">Director: '.$director.'<br>Genre: '.$genre.'<br>Release year: '.$release.'<br> Actor: '.$actor.'</h5></p>';
        echo '<p class="card-text"><h5 class="text-left">Description: '.$description.'</h5></p>';
        
        // If you are not logged in
        if(isset($_SESSION['user_last_name'])) {
            echo '<p style="text-align:left; padding-top:10px;"><input type="button" class="watchlist-button btn btn-primary" data-mid="' . $id . '" value="' . $watchlist_value . '"></p>';
            
        // If you are logged in
        } else {
            echo '<p style="text-align:left; padding-top:10px;"><a href="Login.html" class="btn btn-primary">＋Watchlist</a></p>';
        }
        
        echo'</div>';
        echo'<div class="card-body clear-b" >';
        
        echo'</div></div>';
        ?>
        
        <hr/>
        
        <!-- review form -->
        <?php
        if (!empty($user_id)) {
            $my_review = getMyReview($conn, $user_id, $id);
            if(empty($my_review)) {
        ?>
        <div class="row review-form-area">
            <div class="col-7 offset-2">
                <h4>Your Review</h4>
                <form action = "ReviewProcess.php" method = "post">
                    <div class = "form-group row">
                        <label for="rating" class="col-3 col-form-label">rating</label>
                        <div class="col-9">
                            <select id = "rating" name="rating" class="form-control">
                                <option value="5">★5</option>
                                <option value="4">★4</option>
                                <option value="3">★3</option>
                                <option value="2">★2</option>
                                <option value="1">★1</option>
                            </select>
                        </div>
                    </div>
                    <div class = "form-group row">
                        <label for = "comment" class="col-3 col-form-label">comment</label>
                        <div class="col-9">
                            <textarea class = "form-control" id = "comment" required = "" autocomplete = "off" name = "comment" maxlength="4000" rows="6"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="movie_id" value="<?php echo $id; ?>">
                    <input type = "submit" class = "btn btn-primary " value = "Post Review">
                </form>
            </div>
        </div>
        <hr/>
        <?php
            } else {
                echo '<div class="card-body pt-3 gy-3">';
                echo '<h3>Your Review</h3>';
                echo '<h4 class="card-title font-weight-bold text-left">' . htmlspecialchars($my_review['firstName']) . ' ' . htmlspecialchars($my_review['lastName']) . '<br><h6 class="text-left">' . htmlspecialchars($my_review['email']) . '</h6></h4>';

                echo '<p class="card-text comment-text">Comment: ' . nl2br(htmlspecialchars($my_review['comment'])) . '</p>';
                echo '<div class="progress" style="height:20px">';
                echo '<div class="progress-bar " style="width:' . $my_review['percent'] . '%;">' . htmlspecialchars($my_review['rating']) . '</div>';
                echo '</div></div><hr/>';
            }
        }
        ?>
        
        <?php
        // get reviews
        include 'reviews.php';
        mysqli_close($conn);
        ?>
    </div>

</div>
</body>

<!--ajax script-->
<script>
  (function () {
    $('.watchlist-button').click(function () {
        var clickedButton = event.target;
        
        $(clickedButton).prop("disabled", true);

        var userId = '<?php echo $user_id; ?>';
        var movieId = clickedButton.dataset.mid;
        var action = 'add';
        
        if(clickedButton.value === '－Watchlist') {
            action = 'delete';
        }

        var data = [{
            user_id: userId,
            movie_id: movieId,
            action: action
        }];
    
        var loc = location.pathname;
        var dir = loc.substring(0, loc.lastIndexOf('/'));
        var url = dir + '/Watchlist.php';

        data = JSON.stringify(data);

        $.ajax({
            type: "POST",
            url: url,
            data: {
                data: data
            }
        }).done(function (data) {
            var result = JSON.parse(data);
            
            if(result) {
                if(action === 'add') {
                    $(clickedButton).val("－Watchlist");
                } else {
                    $(clickedButton).val("＋Watchlist");
                }
            } else {
                alert("Processing failed");
            }
        }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
            alert("Processing failed");
        });
        
        $(clickedButton).prop("disabled", false);
    });
  })();
</script>

</html>

<?php
// Function that returns the movie in watchlist
function isInWatchList($conn, $user_id, $movie_id) {
    
    $query = "SELECT * FROM watchlist WHERE user_id = ? AND movie_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $user_id, $movie_id);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    
    if(is_null(mysqli_fetch_row($result))) {
        return false;
    }
    
    return true;
}

// Function that returns the my review info
function getMyReview($conn, $user_id, $movie_id) {
    
    $my_review = [];
    
    $query = "SELECT reviews.rating, reviews.comment, users.firstName, users.lastName, users.email FROM reviews LEFT JOIN users ON reviews.user_id = users.user_id WHERE reviews.user_id = ? AND reviews.movie_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $user_id, $movie_id);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    $fetch_result = $result->fetch_all(MYSQLI_ASSOC);
    
    if(!empty($fetch_result)) {
        $my_review = $fetch_result[0];
        $my_review['percent'] = (($my_review['rating'] / 5) * 100);
    }
    
    return $my_review;
}
