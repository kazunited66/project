<?php
if(!isset($_SESSION)){
    session_start();
}

$login_user_name = '';

if (isset($_SESSION['user_last_name'])) {
    $login_user_name = $_SESSION['user_last_name'];
} else {
    header("Location: Login.html");
}

include_once "dbConnect.php";
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  
  <style>
    .ac-menu-title{
      padding-left: 20px;
      font-size: 30px;
      font-weight: bold;   
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
    </ul>
  </nav>

  <!--displays the data obtained from php -->
  <div class="container p-3">
    <p class="ac-menu-title">My WatchList</p>
    <div class="row gy-3 p-3" id="div1">
        <?php
        if ($row_count > 0) {

            while ($row = mysqli_fetch_array($result)) {
                $id = $row["movie_id"];
                $title = $row["title"];
                $release = $row["release_year"];
                $genre = $row["genre_name"];
                $director = $row["director_name"];
                $actor = $row["actor_name"];
                $description = $row["description"];
                $language = $row["language"];
                $img_url = "Image/" . $row["ImageURL"];

                echo '<div class="col-md-3 p-3" >';

                echo '<div class="card h-100">';
                echo '<a href="DetailView.php?id=' . $id . '">';
                echo '<img src=' . $img_url . ' class="card-img-top" alt="image"></a>';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $title . '</h5>';
                echo '<p class="card-text">Director: ' . $director . '<br>Release year:' . $release . '<br> Actor:' . $actor . '</p>';

                echo '<input type="button" class="watchlist-button btn btn-primary" data-mid="' . $id . '" value="－Watchlist">';

                echo '</div></a></div></div>';
            }
        }
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

        var userId = '<?php if(isset($_SESSION["user_id"])){echo $_SESSION["user_id"];} ?>';
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
