<?php
require('config.php');
if(!isset($_SESSION['email'])){
  header('Location: login.php');
  exit;
}

$userEmail = $_SESSION['email'];
$pos = "SELECT * FROM position WHERE email='$userEmail'";
$res = $conn->query($pos);
if($res->num_rows>0){
  while($r=$res->fetch_assoc()){
    $lat1 = $r['latitude'];
    $long1 = $r['longitude'];
  }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="css/servicepage.css">

     <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <a href="https://icons8.com/icon/15817/up-arrow"></a>
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Raleway&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <title>Service Providers</title>

</head>
<body>

<div id="wrapper">
  

    <!-- <div id="pre-loader" class="loader-container">
            <div id="loader">
               <img src="images/loader.gif">
            </div>
    </div> -->

    <nav class="navbar navbar-expand-md fixed-top main-nav">
        <span href="#" class="navbar-brand"><img src="images/logo.png" width="100px;"></span>

        <button type="button" id="ChangeToggle" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <div id="navbar-hamburger"><i class="fa fa-bars"></i></div>
            <div id="navbar-close" class="hidden"><i class="fa fa-times"></i></div>
        </button>



        <div class="collapse navbar-collapse" id="navbarCollapse">

            <div class="navbar-nav ml-auto">
                <a href="servicepage.php" class="nav-item nav-link active">Hire Mechanic</a>
                <a href="productpage.php" class="nav-item nav-link">Buy Product</a>
             <div class="dropdown show">
              <a class="nav-item nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="images/user.png" width="25px">
              </a>

              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="rofilepage.php">My Profile</a>
                <a class="dropdown-item" href="#">Order History</a>
                <a class="dropdown-item" href="login.php">Logout</a>
              </div>
            </div>      
            </div>

        </div>
    </nav>


    <div class="container-fluid product-main-display">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 p-3">
                        <div class="row">
                        <form class="searchButton" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="searchForm" method="POST">
                          <input type="text" placeholder="Search" name="search" id="search" autocomplete="off">
                          <button type="submit" name="searchbtn"><i class="fa fa-search"></i></button>
                        </form>

                             <!-- <div class="dropdown filter">
                              <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Sort By
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="servicepage.php?sort=rating">Rating</a>
                                <a class="dropdown-item" href="servicepage.php?sort=location">Nearest Location</a>
                                <a class="dropdown-item" href="servicepage.php?sort=responseTime">Response Time</a>
                              </div>
                            </div> -->
                        </div>

                      <?php
                      $sort = "";
                      if(isset($_GET['sort'])){
                        $sort = $_GET['sort'];
                      }
                      if($sort=="rating"){

                      }
                      elseif($sort=="location"){

                      }
                      elseif($sort=="responseTime"){

                      }
                      elseif(isset($_POST['searchbtn'])){
                        $search = $_POST['search'];
                        $sql = "SELECT * FROM serviceCenter WHERE name LIKE '%$search%'";
                      }
                      else{
                        $sql = "SELECT * FROM serviceCenter";
                      }
                      $result = $conn->query($sql);
                      if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){
                      
                      ?>
                        <div class="row  product-page-display justify-content-center mt-3" >
                               <div class="col-lg-12 service-box">
                                <div class="row">
                                 <div class="col-lg-9 col-md-9 col-sm-8 col-xs-6">
                                   <div class="service-title">Service Provider: <span><?php echo $row['name']; ?></span></div>
                                   <?php 
                                   $email = $row['email'];
                                    $resp = "SELECT AVG(arrtime) AS responseTime FROM transaction WHERE scemail='$email'";
                                    $results = $conn->query($resp);
                                    if($results->num_rows==1){
                                      while($r = $results->fetch_assoc()){

                                   ?>
                                   <div class="service-title">Response Time: <?php echo substr($r['responseTime'],0,1)." - Minutes"; }}?><span></span></div>
                                 </div>
                                 <?php 
                                  $email = $row['email'];
                                  $rating = "SELECT AVG(rating) AS ratingAverage FROM review WHERE SCemail='$email'";
                                  $res = $conn->query($rating);
                                  if($res->num_rows==1){
                                    while($Rrow=$res->fetch_assoc()){
                                 ?>
                                 <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                   <div class="service-title ">Rating: <span><?php echo substr($Rrow['ratingAverage'], 0,3); ?></span></div>
                                   <?php }} ?>

                                      <?php
                                      $scEmail = $row['email'];
                                      $pos = "SELECT * FROM position WHERE email='$scEmail'";
                                      $res = $conn->query($pos);
                                      if($res->num_rows>0){
                                        while($r=$res->fetch_assoc()){
                                          $lat2 = $r['latitude'];
                                          $long2 = $r['longitude'];
                                        }
                                      }

                                      // formula to calculate distance between 2 co-ordinates
                                      $theta = $long2 - $long1;
                                      $dist=sin(deg2rad($lat2)) * sin(deg2rad($lat1)) + cos(deg2rad($lat2)) * cos(deg2rad($lat1)) * cos(deg2rad($theta));
                                      $miles = acos($dist);
                                      $miles = rad2deg($miles);
                                      $km = $miles*60*1.1515;
                                      $km = $km*1.609344;
                                      ?>
                                    <div class="service-title ">Distance: <span><?php echo $km; ?> km</span></div>                                  
                                 </div>
                                </div>
                                <div class="modal-btn">
                                    <a href="servicedetail.php?id=<?php echo $row['id']; ?>" class="btn buy-btn">Buy Now</a>
                                    </div>
                               </div>    
                         </div>
                      <?php 
                          }
                        }
                      else{
                          echo "<center><h3>Oops..No Service Provider Available around! But You can Help Your Own Self!</h3> <h4>Head to our Vehicle Servicing Video Tutorials!</h4>";
                          echo "<a href='https://youtube.com/playlist?list=PLU2Rvz_IU_zRnwPSuL_IiBRGBLWnjdkNk'>Tutorials</a></center>";
                      }
                      ?>

            </div>

        </div>


    </div>


</div>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    <!-- Aos JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Slick -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>


    <script type="text/javascript">   
            jQuery(window).on('load', function(){ // makes sure the whole site is loaded
             jQuery('#pre-loader').delay(1200).fadeOut(); // will fade out the white DIV that covers the website.
             });

         $(function() {
            $('#ChangeToggle').click(function() {
            $('#navbar-hamburger').toggleClass('hidden');
            $('#navbar-close').toggleClass('hidden');  
           });
          });
                 

         $(document).ready(function(){
             AOS.init();

            AOS.refresh();

            });

         
  

   </script>

</body>
</html>


    
