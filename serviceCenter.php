<?php
require('config.php');
if(!isset($_SESSION['email'])){
    header('Location: login.php');
    exit;
}
$email = $_SESSION['email'];
$sql = "SELECT * FROM serviceCenter WHERE email = '$email'";
$result = $conn->query($sql);
if($result->num_rows==1){
    while($row = $result->fetch_assoc()){
        $name = $row['name'];
        $mobile = $row['mobile'];
        $id = $row['id'];
    }
}


if(isset($_POST['edit'])){
    if(isset($_POST['name'])){
        $nameEdit = $_POST['name'];
    }
    else{
        $nameEdit = $name;
    }
    if(isset($_POST['mobile'])){
        $mobileEdit = $_POST['mobile'];
    }
    else{
        $mobileEdit = $mobile;
    }
    $edit = "UPDATE serviceCenter SET name='$nameEdit', mobile='$mobileEdit' WHERE email='$email'";
    if($conn->query($edit) === TRUE){

    }
    else{
        echo "Profile Could Not be Updated!";
    }
}

if(isset($_POST['addService'])){
    $serviceName = $_POST['serviceName'];
    $servicePrice = $_POST['servicePrice'];
    $addService = "INSERT INTO services (serviceName, servicePrice, email) VALUES ('$serviceName', '$servicePrice', '$email')";
    if($conn->query($addService) === TRUE){

    }
    else{
        echo "Service Could not be Added!";
    }
}

if(isset($_POST['addProduct'])){
$target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["productImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["productImage"]["tmp_name"]);
    if($check !== false) {
      $uploadOk = 1;
    } else {
      echo "Product Image is not an image.<br>";
      $uploadOk = 0;
    }

    if (file_exists($target_file)) {
      echo "Poster with the same name already exists.<br>";
      $uploadOk = 0;
    }

    if ($_FILES["productImage"]["size"] > 5242880) {
      echo "Product Image cannot be more than 5 MB.<br>";
      $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
      echo "Only JPG, JPEG, PNG files are allowed.<br>";
      $uploadOk = 0;
    }

    if ($uploadOk == 0) {
      echo "Product Image was not Uploaded.<br>";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $target_file)) {
        
      } else {
        echo "Product Image was not Uploaded.<br>";
      }
    }

    $imageadd = htmlspecialchars( basename( $_FILES["productImage"]["name"]));

    // image code ends
    if($uploadOk!=0){
    $productName = $_POST['productName'];
    $productDescription = $_POST['productDescription'];
    $productVehicle = $_POST['productVehicle'];
    $productPrice = $_POST['productPrice'];
    $productImage = $imageadd;

    $sql = "INSERT INTO product (productName, productDescription, productVehicle, productPrice, productImage, email) VALUES ( '$productName', '$productDescription', '$productVehicle', '$productPrice', '$productImage', '$email')";

    if ($conn->query($sql) === TRUE) {
            
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  else{
      echo "***Product was not Added***";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Center</title>
    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
             box-sizing: border-box;
        }
        body{
            background-color: #e75d570d;
            color: #222;
            font-family: 'Raleway', sans-serif;
        }
        .topnav{
            height: 6vh;
            width: 100vw;
            background-color: #fff;
            position: fixed;
            box-shadow: 0px 0.2px 5px #444;
        }
        #logo{
            height: 4vh;
            margin: 1vh 1vw;
        }
        #profile{
            float: right;
            margin: 2vh 3vw;
            font-size: 2vh;
            font-weight: 600;
        }
        /* Style the tab */
        .tab {
          float: left;
          background-color: #fff;
          width: 20%;
          height: 94vh;
          padding-top: 5vh;
          position: fixed;
          top: 6vh;
        }
        h3, h2{
            text-align: center;
            margin: 0.5vh auto 2vh auto;
            color: #0f046c;
        }
        hr{
            width: 75%;
            border: 0.5px solid #888;
            margin: 1vh auto 3vh auto;
        }
        
        /* Style the buttons inside the tab */
        .tab button {
          display: block;
          background-color: inherit;
          color: #333;
          padding: 12px 16px;
          width: 100%;
          border: none;
          outline: none;
          text-align: left;
          cursor: pointer;
          transition: 0.3s;
          font-size: 18px;
        }
        /*#defaultOpen{}*/
        
        /* Change background color of buttons on hover */
        .tab button:hover {
          background-color: #e75d570d;
        }
        
        /* Create an active/current "tab button" class */
        .tab button.active {
          background-color: #e75d570d;
          color: #e75d57;
        }
        
        /* Style the tab content */
        .tabcontent {
          float: right;

          width: 73%;
          min-height: 80vh;
          background-color: #fff;
          margin: 3vw;
          margin-top: 6vw;
          overflow: auto;
        }

        form{
            padding: 3vw;
            margin: 0 0 3vw;
            background-color: #fff;
        }
        input{
            font-size: 16px;
            width: 100%;
            padding: 10px;
            border: none;
            border: 2px solid #ddd;
            border-radius: 5px;
            color: #444;
            margin-bottom: 40px;
            margin-top: 10px;
            -moz-transition: all 0.4s ease-in-out;
            -o-transition: all 0.4s ease-in-out;
            -webkit-transition: all 0.4s ease-in-out;
            transition: all 0.4s ease-in-out;
            background-color: #fff;
        }

        input:focus {
            outline: 0;
            border-color: #0f046c;
          }
          select{
            outline: 0;
            background-color: #fff;
            color: #444;
            font-size: 16px;
          }
          select:focus{
            border-color: #888;
            outline:none;
        }
        label {
            font-size: 18px;
            font-weight: bold;
            color: #444;
            margin-bottom: 15px;
          }
          .button {
            border: 0;
            outline: none;
            border-radius: 0;
            padding: 10px 0;
            font-size: 18px;
            font-weight: 300;
            text-transform: uppercase;
            letter-spacing: 2px;
            border: 3px solid #e75d57;
            border-radius: 7px;
            color: #fff;
            background: #e75d57;
            cursor: pointer;
            -moz-transition: all 0.4s ease-in-out;
            -o-transition: all 0.4s ease-in-out;
            -webkit-transition: all 0.4s ease-in-out;
            transition: all 0.4s ease-in-out;
            width: 45%;
            margin: 10px 1.25%;
          }
          .button:hover, .button:focus { background: #e75d57; color: #fff; }
          ::placeholder{
            opacity: 0.7;
          }
          .grid-container{
            display: grid;
            grid-gap: 10px;
            grid-template-columns: 1fr 1fr;
            margin-bottom: 15px;
            column-gap: 30px;
          }
          .grid-item{
              margin-right: 3vw;
              padding: 0.5vw;
              max-height: 3vw;
          }
          .muted-text{
            color: #aaa;
            font-size: 14px;
            margin: 2vw 1vw;
            display: inline;
          }
          .showAll{
            width: 100%;
            min-height: 20vh;
            background-color: #fff;
            padding: 2vw;
            overflow: auto;
          }
          table{
            width: 95%;
            margin: 2vw auto;
            overflow: auto;
            white-space: nowrap;
          }
          table, td, th{
            border-collapse: collapse;
            border: 0.2px solid #666;
            padding: 10px;
          }
          tr:nth-child(even){
            background-color: #fefefe;
          }
          .statistics{
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            margin: 1vw auto;
            grid-gap: 4vw;
            padding: 2vw 2vw 0 2vw;
          }
          .cards{
            background-color: #eee;
            border-radius: 10px;
            padding: 1vw;
            height: 15vh;
            text-align: center;
            font-size: 24px;
          }
          .statText{
            font-size: 35px;
            color: #0f046c;
          }
          .button1 {
            border: 0;
            outline: none;
            border-radius: 0;
            padding: 10px 0;
            font-size: 18px;
            font-weight: 300;
            text-transform: uppercase;
            letter-spacing: 2px;
            border: 3px solid #e75d57;
            border-radius: 7px;
            color: #fff;
            cursor: pointer;
            -moz-transition: all 0.4s ease-in-out;
            -o-transition: all 0.4s ease-in-out;
            -webkit-transition: all 0.4s ease-in-out;
            transition: all 0.4s ease-in-out;
            width: 25%;
            margin: auto auto;
            zoom: 0.7;
            background: #e75d57;
        }
        .button1:hover, .button1:focus { background: #e75d57; color: #fff; }

        </style>
</head>
<body>
<div class="topnav"><a href="homepage.php">
    <img src="images/logo.png" id="logo"></a>
    <div id="profile"><?php  echo $_SESSION['email'] ?></div>
</div>
<div class="tab">
    <h2><?php echo $name; ?></h2>
  <button class="tablinks" onclick="openCity(event, 'home')" id="defaultOpen">Home</button>
  <button class="tablinks" onclick="openCity(event, 'services')">Services</button>
  <button class="tablinks" onclick="openCity(event, 'products')">Products</button>
  <button class="tablinks" onclick="openCity(event, 'reviews')">Reviews</button>
  <a href="login.php" style="all: unset; color: inherit;"><button class="tablinks" onclick="openTab(event, 'logout')">Logout</button></a>
</div>

<div id="home" class="tabcontent">

<div class="showAll">
<h2>Statistics</h2>
<div class="statistics">
  <div class="cards">Products<br>
  <b class="statText">
  <?php
  $sql1 = "SELECT * FROM product WHERE email='$email'"; //ADD PRODUCT TABLE
  $result = $conn->query($sql1); 
  echo $result->num_rows; 
  ?>
  </b>
  </div>
  <div class="cards">Services<br>
  <b class="statText">
  <?php
  $sql2 = "SELECT * FROM services WHERE email='$email'"; //ADD SERVICE TABLE
  $result = $conn->query($sql2); 
  echo $result->num_rows; 
  ?>
  </b>
  </div>
  <div class="cards">Transactions<br>
  <b class="statText">
  <!-- <?php
  $sql3 = "SELECT * FROM transaction WHERE email='$email'"; //ADD TRANSACTION TABLE
  $result = $conn->query($sql3); 
  echo $result->num_rows; 
  ?> -->
  </b>
  </div>
  <div class="cards">Rating<br>
  <b class="statText">
  <?php
    $sql3 = "SELECT AVG(rating) AS ratingAverage FROM review WHERE SCemail='$email'"; //ADD TRANSACTION TABLE
    $result = $conn->query($sql3); 
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            echo substr($row['ratingAverage'],0,3);
        }
    } 
  ?>
  </b>     
  </div>
</div>
</div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST"  enctype="multipart/form-data">
  <h2>Edit Profile</h2>

    <label for="name">Name</label>
    <input type="text" name="name" id="name" placeholder="Name" value="<?php echo $name; ?>"><br>
    
    <label for="mobile">Mobile Number</label>
    <input type="text" name="mobile" id="mobile" placeholder="Mobile Number" value="<?php echo $mobile; ?>"><br>

    <label for="email">Email ID</label>
    <input type="text" name="email" id="email" placeholder="Email ID" value="<?php echo $email; ?>" disabled><br>

    <center>
        <input type="submit" value="Edit Profile" name="edit" class="button" />
    </center>  
</form> 

</div>

<div id="services" class="tabcontent">
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST"  enctype="multipart/form-data">
  <h2>Add a Service</h2>

    <label for="serviceName">Service Name</label>
    <input type="text" name="serviceName" id="serviceName" placeholder="Service Name" required><br>

    <label for="servicePrice">Service Price</label>
    <input type="number" name="servicePrice" id="servicePrice" placeholder="Service Price" required><br>

<center>
    <input type="submit" value="Add Service" name="addService" class="button" />
</center>  
</form> 

<div class="showAll">
<h2>All Services</h2>
<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Price</th>
    <th>Action</th>
  </tr>
  <?php

$sql = "SELECT * FROM services WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    ?>
<tr>
    <td><?php echo $row['id']; ?></td>   
    <td><?php echo $row['serviceName']; ?></td>   
    <td><?php echo $row['servicePrice']; ?></td>   
    <!-- <td><a href="deleteMovie.php?id=<?php echo $row['id']; ?>"><button style="padding: 5px;">Delete</button></a></td>  -->
    <!-- ADD EDIT AND DELETE LOGIC HERE -->
    <td></td>
  </tr>	
  
<?php }
} else {
  echo "<tr><td colspan='4' style='text-align: center;'>No Services Have Been Added Yet</td></tr>";
}
  ?>
</table>

</div>
</div>

<div id="products" class="tabcontent">
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
  <h2>Add a Product</h2>
  
      <label for="productName">Product Name</label>
      <input type="text" name="productName" id="productName" placeholder="Product Name" required><br>

      <label for="productDescription">Product Description</label>
      <input type="text" name="productDescription" id="productDescription" placeholder="Product Description" required><br>

      <div class="grid-container">

      <label for="productVehicle">For Vehicle</label>

      <label for="productPrice">Product Price</label>

      <select id="productVehicle" name="productVehicle" class="grid-item" required>
          <option value="-1">Select Vehicle</option>
          <option value="Car">Car</option>
          <option value="Truck">Truck</option>
          <option value="Bike">Bike</option>
          <option value="Others/NA">Others/NA</option>
      </select>
  
      <input type="number" name="productPrice" id="productPrice" placeholder="Product Price" required>
      <br>

      </div>
     
      <label for="productImage">Product Image<p class="muted-text">(Kindly Upload an Image file of less than 5000 kb Size)</p></label>
      <input type="file" name="productImage" id="productImage"><br>

  <center>
      <input type="submit" value="Add Product" name="addProduct" class="button" />
  </center>  
  </form> 

  <div class="showAll">
<h2>All Products</h2>
<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Description</th>
    <th>Vehicle</th>
    <th>Price</th>
    <th>Action</th>
  </tr>
  <?php

$sql = "SELECT * FROM product WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    ?>
<tr>
    <td><?php echo $row['id']; ?></td>   
    <td><?php echo $row['productName']; ?></td>   
    <td><?php echo $row['productDescription']; ?></td>   
    <td><?php echo $row['productVehicle']; ?></td>   
    <td><?php echo $row['productPrice']; ?></td>   
    <!-- <td><a href="deleteEvent.php?id=<?php echo $row['id']; ?>"><button style="padding: 5px;">Delete</button></a></td> -->
    <!-- ADD EDIT AND DELETE BUTTONS -->
    <td></td>
  </tr>	
  
<?php }
} else {
  echo "<tr><td colspan='6' style='text-align: center;'>No Products Have Been Added Yet</td></tr>";
}
  ?>
</table>

</div>


</div>

<div id="reviews" class="tabcontent">
<div class="showAll">
<h2>All Reviews</h2>
<table>
  <tr>
    <th>Name</th>
    <th>Email ID</th>
    <th>Rating</th>
    <th>Review</th>
  </tr>
  <?php

$sql = "SELECT * FROM review WHERE SCemail='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    ?>
<tr>
    <td><?php echo $row['name']; ?></td>   
    <td><?php echo $row['Pemail']; ?></td>   
    <td><?php echo $row['rating']; ?></td>   
    <td><?php echo $row['review']; ?></td>
  </tr>	
  
<?php }
} else {
  echo "<tr><td colspan='4' style='text-align: center;'>No Reviews Have Been Added Yet</td></tr>";
}
  ?>
</table>

</div>
</div>

<script>
    function openCity(evt, cityName) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(cityName).style.display = "block";
      evt.currentTarget.className += " active";
    }
    document.getElementById("defaultOpen").click();
</script>
    
</body>
</html>