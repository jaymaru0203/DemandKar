<?php
require('config.php');
if(!isset($_SESSION['email'])){
  header('Location: login.php');
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="css/productpage.css">

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

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

    <title>Product Page</title>

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
                <a href="servicepage.php" class="nav-item nav-link">Hire Mechanic</a>
                <a href="productpage.php" class="nav-item nav-link active">Buy Product</a>
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
                        <div class="row">
                            <form class="searchButton" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="searchForm" method="POST">
                              <input type="text" placeholder="Search" name="search" id="search" autocomplete="off">
                              <button type="submit" name="searchbtn"><i class="fa fa-search"></i></button>
                            </form>

                            <div class="dropdown filter">
                              <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Filter
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="productpage.php?vehicle=Car">Car</a>
                                <a class="dropdown-item" href="productpage.php?vehicle=Bike">Bike</a>
                                <a class="dropdown-item" href="productpage.php?vehicle=Truck">Truck</a>
                                  <a class="dropdown-item" href="productpage.php?vehicle=Others/NA">Other</a>
                              </div>
                            </div>
                        </div>
                        <div class="row  product-page-display" >
                                <!-- Single Product Item Start -->
                                <?php
                                
                                if(isset($_GET['vehicle'])){
                                  $vehicle = $_GET['vehicle'];
                                  $sql = "SELECT * FROM product WHERE productVehicle='$vehicle'";
                                }
                                elseif(isset($_POST['searchbtn'])){
                                  $search = $_POST['search'];
                                  $sql = "SELECT * FROM product WHERE productName LIKE '%$search%'";
                                }
                                else{
                                  $sql = "SELECT * FROM product";
                                }
                                $result = $conn->query($sql);
                                if($result->num_rows>0){
                                  while($row=$result->fetch_assoc()){
                                
                                ?>
                              <div class="card">
                                  <div class="fix-image">
                                  <img src="uploads/<?php echo $row['productImage']; ?>" class="card-img-top" alt="...">
                                 </div> 
                                  <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['productName']; ?></h5>
                                    <h6 class="card-type"><?php echo $row['productVehicle']; ?></h6>
                                    <p class="card-text"><?php echo $row['productDescription'] ?></p>
                           
                                    <div class="card-price float-left">Rs. <?php echo $row['productPrice']; ?></a>
                                    </div>

                                    <div class="modal-btn">
                                    <a href="#<?php echo $row['id']; ?>" class="btn buy-btn" data-toggle="modal" data-target="#modal<?php echo $row['id']; ?>">Buy Now</a>
                                    </div>
                                  </div>
                               </div>
                               <?php
                               }}
                                else{
                                  echo "<h3><br><br><center>No Products Nearby</center></h3>";
                                }?>
                                     
                         </div>


            </div>

        </div>


    </div>

<?php
    $sql = "SELECT * FROM product";
                                
      $result = $conn->query($sql);
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          ?>
<!-- Modal -->
<div class="modal fade" id="modal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="class-title"><?php echo $row['productName']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6 class="card-type"><?php echo $row['productVehicle']; ?></h6>
        <?php echo $row['productDescription']; ?>
        <div class="card-price">Rs. <?php echo $row['productPrice']; ?></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="checkout.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn buy-btn">Checkout</button></a>
      </div>
    </div>
  </div>
</div>
<?php }} ?>


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

            $('.items').slick({
            infinite: false,
            slidesToShow: 5,
            slidesToScroll: 1,
            arrows:false,
            responsive: [
                {
                  breakpoint: 1024,
                  settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                  }
                },
                {
                  breakpoint: 600,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                  }
                },
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                  }
                }

              ]
            });

            $('.product-swipe-icon-left').click(function(){
              $('.items').slick('slickPrev');
            })

            $('.product-swipe-icon-right').click(function(){
              $('.items').slick('slickNext');
            })

                    $(window).scroll(function(){
                if ($(this).scrollTop() > 100) {
                    $('#back-top').fadeIn();
                } else {
                    $('#back-top').fadeOut();
                }
            });
            
            //Click event to scroll to top
        $('#back-top').click(function(){
            $('html, body').animate({scrollTop : 0},800);
            return false;
        });

            AOS.refresh();

            });

   </script>


</body>
</html>


    
