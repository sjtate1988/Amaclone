 <!-- This provides the navbar at the top of each page. It changes depending on which user is logged in. -->
<?php
// We check the logged in status of the user through the $_SESSION superglobal.
$loginStatus = false;
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']=true){
  $loginStatus = true;
  $userName = $_SESSION['user']['firstname'];
}
?>

<!-- Amaclone Logo - clicking directs to index.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark pb-0 pt-0 pl-2">
  <a class="navbar-brand p-0" href="index.php"><img src="reso/static/img/amaclone-white.png" class="img" style="width:15%; margin-left:0.6em;" alt="Responsive image"></a>
</nav>

<!-- Navbar -->
<!-- We use the collapsible menu on smaller screens with the usual burger menu icon. -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
<!-- This is the search bar, whose features are implemented on the shop page. This is the particular instance on smaller screens. -->
  <form class="form-inline my-2 my-lg-0 mx-auto position-absolute w-50 navpos"  id="searchMobile" method="get"  action='shop.php'>
    <input class="form-control mr-sm-2 w-75" id="sticazzi" type="search" name="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
  </form>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <!-- Shop by Department drop down menu -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Shop by Department
        </a>
        <!-- For the dropdown elements, we pick out the genres from the table genres. -->
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php
          $genreQuery = 'SELECT * FROM genres';
          $resultsGenre = mysqli_query($con, $genreQuery);
          $resultsGenre = mysqli_fetch_all($resultsGenre, MYSQLI_ASSOC);
          for ($i=0; $i<sizeOf($resultsGenre); $i++){
            echo '<a class="dropdown-item" href=shop.php?genre_id='.$resultsGenre[$i]['genre_id'].'>'.$resultsGenre[$i]['genre'].'</a>';
          }
          ?>
        </div>
      </li>
    </ul>
<!-- Searchbar for destop computers-->
    <form class="form-inline my-2 my-lg-0 mx-auto position-absolute w-50 navpos"  id="searchDesktop" method="get"  action='shop.php'>
      <input class="form-control mr-sm-2 w-75 search_input" type="search" name="search" placeholder="search" aria-label="Search" value="<?php if(isset($_GET['search'])) { echo $_GET['search']; } ?>">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
    </form>

      <!-- If the user is not logged in, this displays the option to register or sign in -->
        <div class="d-flex justify-content-end">

          <ul class="navbar-nav mr-auto px-3">

              <?php if($loginStatus){ ?>
                <li class="nav-item pr-3 text-white" >
              <a class="nav-link text-white" href="logout.php">Log Out</a> </li>
             <?php } else { ?>
               <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               Log in / Register
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="registration.php">Register</a>
              <a class="dropdown-item" href="login.php">Sign In</a>
            </div>
          </li>
          <?php } ?>


      <!-- If the user is logged in, they can view their previous orders here. -->
      <?php if($loginStatus){ ?>
          <li class="nav-item px-3 text-white" >
            <a class="nav-link text-white" href="orders.php" id="orders"><?php echo $userName."'s"; ?> Orders</a>
          </li>
<?php } ?>
      <!-- This lets the customer view their cary and checkout. -->
          <li class="nav-item dropdown px-3 text-white" id="basket">
            <a class="nav-link dropdown-toggle text-white" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="basket">
              <i class="fa fa-shopping-cart text-white" aria-hidden="true" id="basket" style="font-size: 1.5em;"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink" id="cart">
              <a class="dropdown-item" href="cart.php">My Cart</a>
              <a class="dropdown-item" href="checkout.php">Go to Checkout</a>
            </div>
          </li>

      </ul>
  </div>
</div>
</nav>
