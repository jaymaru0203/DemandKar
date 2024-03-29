<?php

require('config.php');
if(!isset($_SESSION['email'])){
  header('Location: login.php');
  exit;
}
$email = $_SESSION['email'];
if(isset($_POST['getlatlong'])){
  if(isset($_POST['latitude']) && isset($_POST['longitude'])){
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $searchQuery = $latitude.','.$longitude;

    $buildQuery = http_build_query([
      'access_key' => 'f3cf897892df57307c368f33bcb17d82',
      'query' => $searchQuery
    ]);
    $ch = curl_init(sprintf('%s?%s', 'http://api.positionstack.com/v1/reverse', $buildQuery));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    $address = $result["data"]["0"]["label"];
    
    $sql = "SELECT * FROM position WHERE email='$email'";
    $result = $conn->query($sql);
    if($result->num_rows==0){
      $sql1 = "INSERT INTO position (email, latitude, longitude , address) VALUES('$email', '$latitude', '$longitude', '$address')";
      if($conn->query($sql1) === TRUE){
        header('Location: productpage.php');
      }
      else{
        echo "Kindly Allow Location Tracking to See Relevant Results";
      }      
    }
    else{
      $sql1 = "UPDATE position SET latitude='$latitude', longitude='$longitude', address='$address' WHERE email='$email'";
      if($conn->query($sql1) === TRUE){
        header('Location: productpage.php');
      }
      else{
        echo "Kindly Allow Location Tracking to See Relevant Results";
      } 
    }
  }
  else{
    echo "Kindly Allow Location Tracking to See Relevant Results";
  }
}

if(isset($_POST['getlatlong1'])){
  if(isset($_POST['latitude']) && isset($_POST['longitude'])){
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $searchQuery = $latitude.','.$longitude;

    $buildQuery = http_build_query([
      'access_key' => 'f3cf897892df57307c368f33bcb17d82',
      'query' => $searchQuery
    ]);
    $ch = curl_init(sprintf('%s?%s', 'http://api.positionstack.com/v1/reverse', $buildQuery));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    $address = $result["data"]["0"]["label"];
    
    $sql = "SELECT * FROM position WHERE email='$email'";
    $result = $conn->query($sql);
    if($result->num_rows==0){
      $sql1 = "INSERT INTO position (email, latitude, longitude, address) VALUES('$email', '$latitude', '$longitude', '$address')";
      if($conn->query($sql1) === TRUE){
        header('Location: servicepage.php');
      }
      else{
        echo "Kindly Allow Location Tracking to See Relevant Results";
      }      
    }
    else{
      $sql1 = "UPDATE position SET latitude='$latitude', longitude='$longitude', address='$address' WHERE email='$email'";
      if($conn->query($sql1) === TRUE){
        header('Location: servicepage.php');
      }
      else{
        echo "Kindly Allow Location Tracking to See Relevant Results";
      } 
    }
  }
  else{
    echo "Kindly Allow Location Tracking to See Relevant Results";
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

    <link rel="stylesheet" type="text/css" href="css/homepage.css">

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

    <link rel="stylesheet" href="css/easyzoom.css">


    <title>Home Page</title>

</head>
<body onload="getLocation()">

<div id="wrapper">
  
    
    <div id="pre-loader" class="loader-container">
            <div id="loader">
               <img src="images/loader.gif">
            </div>
    </div>

    <nav class="navbar navbar-expand-md fixed-top main-nav">
        <span href="passenger.php" class="navbar-brand"><img src="images/logo.png" width="100px;"></span>

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
                <a class="dropdown-item" href="profilepage.php">My Profile</a>
                <a class="dropdown-item" href="orderhistory.php">Order History</a>
                <a class="dropdown-item" href="login.php">Logout</a>
              </div>
            </div>      
            </div>

        </div>
    </nav>

<div class="container-fluid screen-1">
  <div class="row m-0">
    <div class="col-lg-6 col-md-6 p-0 align-self-center">
      <div class="row m-0 justify-content-center">
        <div class="main-screen">
      <div class="main-text">The Auto Mechanic That Comes To You</div>
      <div class="sub-text">The Mechanic will come to you for providing Service in your location. Choose your service and hire mechanic. Pay the mechanic online or cash on delivery as per your need.</div>
      <div class="link-button">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
          <input type="number" name="latitude" id="latitude1" value="" hidden step="0.0000001">
          <input type="number" name="longitude" id="longitude1" value="" hidden step="0.0000001">
          <button type="submit" name="getlatlong1" class="hire-mech">Hire</button>
        </form>
          
        </div>
       </div>
      </div>
    </div>
     <div class="col-lg-6 col-md-6 p-0 image-screen">
       <img src="images/car-removebg.png" class="img-responsive fit-image" >
     </div>
  </div>
</div>

<div class="container-fluid screen-2">
  <div class="row m-0">
    <div class="col-lg-6 col-md-6 p-0 image-screen">
       <img src="images/buying.jpg" class="img-responsive fit-image" >
     </div>
    <div class="col-lg-6 col-md-6 p-0 align-self-center">
      <div class="row m-0 justify-content-center">
        <div class="main-screen">
      <div class="main-text">Buy Mechanical Products Near You</div>
      <div class="sub-text">Find best product near by service center. Choose your product and get in best prices. </div>
      <div class="link-button">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
          <input type="number" name="latitude" id="latitude" value="" hidden step="0.0000001">
          <input type="number" name="longitude" id="longitude" value="" hidden step="0.0000001">
          <button type="submit" name="getlatlong" class="hire-mech">Product</button>
        </form>
          
        </div>
       </div>
      </div>
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
   });

   </script>

<script>
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.watchPosition(showPosition);
  } else {
    alert("Geolocation is not supported by this browser.");
  }
}
function showPosition(position) {
  document.getElementById('latitude').value = position.coords.latitude;
  document.getElementById('latitude1').value = position.coords.latitude;
  document.getElementById('longitude').value = position.coords.longitude;
  document.getElementById('longitude1').value = position.coords.longitude;
}
</script>

</body>
</html>


    
