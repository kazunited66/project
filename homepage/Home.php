<?php
session_start();
$login_user_name = '';

if (isset($_SESSION['user_last_name'])) {
    $login_user_name = $_SESSION['user_last_name'];
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
    .filtering-info{
      padding-left: 20px;
      font-size: 20px;
      font-weight: bold;   
    }
    
    .search-info{
      padding-left: 20px;
      font-size: 20px;
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
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Category
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php
          $category_list = getCategoryList();
          
          foreach ($category_list as $category) {
              echo '<a class="dropdown-item" href="?category=' . $category . '">' . $category . '</a>';
          }
          ?>
        </div>
      </li>
    </ul>
    
    <form class="d-flex" role="search" action="" method="get">
        <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
      
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
      <li class="nav-item">
        <a class="nav-link" href="Account.php" id="account"><i class="material-icons">person</i> <?php echo htmlspecialchars($login_user_name); ?></a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="logout.php" id="logout"><i class="material-icons">logout</i>Logout</a>
      </li>
    <?php
    }
    ?>
    </ul>
  </nav>

  <!--displays the data obtained from php -->
  <div class="container p-3">
    <div class="filtering-info">
        <?php
        if(isset($_GET['category'])) {
            echo 'Category：' . htmlspecialchars($_GET['category']);
        }
        ?>
    </div>
    <div class="search-info">
        <?php
        if(isset($_GET['search'])) {
            echo 'Search：' . htmlspecialchars($_GET['search']);
        }
        ?>
    </div>
    <div class="row gy-3 p-3" id="div1">
        <?php include 'data.php'; ?>    
    </div>
  </div>
</body>

<!--ajax script-->
<script>
  (function () {
    $('.watchlist-button').click(function () {
        var clickedButton = event.target;
        
        $(clickedButton).prop("disabled", true);

        var userId = <?php echo $_SESSION['user_id']; ?>;
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
// Function that returns a list of categories
function getCategoryList() {
    include "dbConnect.php";
    
    if (!$conn) {
        die("connection failed: " . mysqli_connect_error());
    }
    $query = "SELECT genre_name FROM genres;";

    $result = mysqli_query($conn,$query);
    mysqli_close($conn);
    
    $fetch_result = $result->fetch_all(MYSQLI_ASSOC);
    $category_list = ['ALL'];
    
    foreach ($fetch_result as $array) {
        $category_list[] = $array['genre_name'];
    }
    
    return $category_list;
}
