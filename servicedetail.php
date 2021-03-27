<?php
require('config.php');
if(!isset($_SESSION['email'])){
  header('Location: login.php');
  exit;
}
$name = $email = $mobile = "";
if(isset($_GET['id'])){
  $id = $_GET['id'];
  $_SESSION['SCID'] = $id;
}else{
  $id = $_SESSION['SCID'];
}
  $sql = "SELECT * FROM serviceCenter WHERE id='$id'";
  $result = $conn->query($sql);
  if($result->num_rows == 1){
    while($row=$result->fetch_assoc()){
      $name = $row['name'];
      $email = $row['email'];
      $mobile = $row['mobile'];
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

    <link rel="stylesheet" type="text/css" href="css/servicedetail.css">

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

    <title><?php echo $name; ?></title>

</head>
<body>

<div id="wrapper">
  

    <div id="pre-loader" class="loader-container">
            <div id="loader">
               <img src="images/loader.gif">
            </div>
    </div>

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
                <a class="dropdown-item" href="#">My Profile</a>
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

                       <div class="row product-page-display justify-content-center mt-3" >
                          <h3 class="service-text text-center">Service Provider Details</h3>
                         <div class="col-lg-12 service-box">
                                <div class="row m-0 justify-content-between">
               
                                   <div class="service-title">Service Provider Name: <span><?php echo $name; ?></span></div>
                                   <?php
                                   $rating = "SELECT AVG(rating) AS ratingAverage FROM review WHERE SCemail='$email'";
                                   $res = $conn->query($rating);
                                   if($res->num_rows==1){
                                     while($Rrow=$res->fetch_assoc()){
                                  ?>
                                  <div class="service-title  ">Rating: <span><?php echo substr($Rrow['ratingAverage'], 0, 3); ?></span></div>
                                   <?php }} ?>
                                 </div>
                                 <div class="row m-0 justify-content-between">
                                  
                                  <?php $service = "SELECT COUNT(serviceName) AS noServices FROM services WHERE email='$email'";
                                   $ser = $conn->query($service);
                                   if($ser->num_rows==1){
                                     while($Srow=$ser->fetch_assoc()){ ?>
                                   <div class="service-title">No. of Services: <span><?php echo $Srow['noServices']; ?></span></div>
                                   <?php }} ?>

                                     <div class="service-title ">Location: <span>2 km</span></div>
                                 </div>
                                  <div class="row m-0 justify-content-between">
                          
                                   
                                  <div class="service-title">Contact Info: <span><?php echo $mobile; ?></span></div>
                                   <div class="service-title ">Email: <span><?php echo $email; ?></span></div>
                                  
                                 </div>
                                  </div>
                                </div>
                              </div>
                       </div>
                        
                        <div class="row  product-page-display justify-content-center mt-3" >
                          <h3 class="text-center service-text">Services Provided</h3>
                          <div class="table-responsive">
                              <table class="table table-bordered">
                                <thead>
                                  <tr>
                                    <!-- <th scope="col" class="w-10">Sr. No</th> -->
                                    <th scope="col" class="w-40">Services Provided</th>
                                    <th scope="col" class="w-25">Cost</th>
                                    <th scope="col" class="w-25">Select Your Service</th>
                                  </tr>
                                </thead>
                              <form action="paymentpage.php" method="POST">
                                <tbody>
                                <?php 
                                  $sql = "SELECT * FROM services WHERE email='$email'";
                                  $result = $conn->query($sql);
                                  if($result->num_rows > 0){
                                    while($row=$result->fetch_assoc()){
                                ?>
                                  <tr>
                                    <!-- <td scope="row">1</td> -->
                                    <td><?php echo $row['serviceName']; ?></td>
                                    <td><?php echo $row['servicePrice']; ?></td>
                                    <td class="checkbox">
                                      <input type="checkbox" name="service[]" value="<?php echo $row['id']; ?>">
                                    </td>
                                  </tr>
                                  <?php }} ?>

                                </tbody>
                              </table> 
                              <div class="modal-btn text-center">
                                <button type="submit" name="hire" class="btn buy-btn">Hire Services</button>
                              </div>
                            </form>

                          </div>
                          
                         </div><br><br>
                         <h3 class="text-center service-text">Reviews and Rating</h3>
                         <?php
                                      
                              $sql = "SELECT * FROM review WHERE SCemail='$email'";
                              $result = $conn->query($sql);
                              if($result->num_rows>0){
                                while($row=$result->fetch_assoc()){
                                  
                                  ?>
                                    <div class="row product-page-display  mt-3 mb-3">
                                  <div class="media flex-column flex-md-row  comment">
                          <div class="media-body media-body-inset-1" >
                                        <h6><?php echo $row['name']; ?></h6><span class="text-gray"></span>
                            <div class="blog-post-time">
                                          <time datetime="2018-04-24">Rating: <?php echo substr($row['rating'],0,3); ?>/5</time>
                            </div>
                              <p><?php echo $row['review']; ?></p>
                            </div>
                          </div>
                        </div>
                                    <?php }} ?>
                          <div class="row product-page-display justify-content-center mt-3 mb-3">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="comment-form-area" method="POST">
                              <p class="comment-form-comment">
                                  <label>Your review *</label>
                                  <textarea class="comment-notes" name="review" required="required"></textarea>
                              </p>
                               <div class="comment-input">
                                <p class="comment-form-author">
                                    <label>Rating<span class="required">*</span></label>
                                    <input type="number" step="0.1" max="5" min="1" required="required" name="rating" placeholder="1-5">
                                </p>
                               
                            </div>
                              <div class="comment-form-submit">
                                  <input type="submit" value="Submit" name="reviewSubmit" class="comment-submit">
                              </div>
                          </form>

                          <?php
                          
                              if(isset($_POST['reviewSubmit'])){
                                $rating = $_POST['rating'];
                                $review = $_POST['review'];
                                $userEmail = $_SESSION['email'];
                                $SCemail = $email;

                                $sql1 = "SELECT * FROM passenger WHERE email='$userEmail'";
                                $result1 = $conn->query($sql1);
                                if($result1->num_rows > 0){
                                  while($row1 = $result1->fetch_assoc()){
                                    $userName = $row1['name'];
                                  }
                                }
                                $sql2 = "INSERT INTO review (name, Pemail, rating, review, SCemail) VALUES ('$userName', '$userEmail', '$rating', '$review' ,'$SCemail')";
                                if($conn->query($sql2) === TRUE){
                                  header('Location: servicedetail.php');
                                }
                                else{
                                  echo "Could Not Add Review";
                                }

                              }
                          
                          ?>
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

         function myFunction() {
  var dots = document.getElementById("dots");
  var moreText = document.getElementById("more");
  var btnText = document.getElementById("myBtn");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more"; 
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "Read less"; 
    moreText.style.display = "inline";
  }
}

         
  

   </script>

</body>
</html>


    
