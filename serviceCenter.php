<?php
require('config.php');
if(!isset($_SESSION['email'])){
    header('Location: login.php');
    exit;
}
$sErr = "";
$pErr = "";
$hErr = "";
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
        $hErr = "Profile Updated! Kindly Refresh the Page to see the Changes";
    }
    else{
        $hErr = "Profile Could Not be Updated!";
    }
}

if(isset($_POST['addService'])){
    $serviceName = $_POST['serviceName'];
    $servicePrice = $_POST['servicePrice'];
    $addService = "INSERT INTO services (serviceName, servicePrice, email) VALUES ('$serviceName', '$servicePrice', '$email')";
    if($conn->query($addService) === TRUE){

    }
    else{
        $sErr = "Service Could not be Added!";
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
      $pErr = "Product Image is not an image.<br>";
      $uploadOk = 0;
    }

    if (file_exists($target_file)) {
      $pErr = "Poster with the same name already exists.<br>";
      $uploadOk = 0;
    }

    if ($_FILES["productImage"]["size"] > 5242880) {
      $pErr = "Product Image cannot be more than 5 MB.<br>";
      $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
      $pErr = "Only JPG, JPEG, PNG files are allowed.<br>";
      $uploadOk = 0;
    }

    if ($uploadOk == 0) {
      $pErr = "Product Image was not Uploaded.<br>";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $target_file)) {
        
      } else {
        $pErr = "Product Image was not Uploaded.<br>";
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
      $pErr = "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  else{
      $pErr = "Product was not Added";
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
            text-align: center;
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

        .error{
            color: red;
            text-align: center;
            font-size: 16px;
            padding: 20px;
        }

        .edBtn{
            background: #0f046c;
            color: #fff;
        }

        /* MODAL CSS */

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.8);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        @keyframes example {
            0%   {margin-top: -15%;}
            100% {margin-top: 5%}
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 10px;
            border: 1px solid #373435;
            width: 50%;
            border-radius: 15px;
            animation: example 0.3s ease-out;
        }

        .close, .closeEdit, .closeDelete, .closeSal {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: 900;
            margin-right: 8px;
        }

        .close:hover, .close:focus, .closeEdit:hover, .closeEdit:focus, .closeDelete:hover, .closeDelete:focus, .closeSal:hover, .closeSal:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-label, .modal-input{
            font-size: 16px;
            font-weight: 500;
        }

        hr{
            width: 85%;
            border-bottom: 1px solid #0f046c;
        }
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
  <a href="login.php" style="all: unset; color: inherit;"><button class="tablinks" onclick="openTab(event, 'logout')">Logout</button></a><br><br><hr><br>
  <span class="error">
      <?php 
      
        echo $hErr;
        echo $sErr;
        echo $pErr;
      
      ?>
  </span>
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
        <input type="submit" value="Edit Profile" name="edit" class="button"/>
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
    <td><button style="padding: 5px;" class="edBtn" onclick="document.getElementById('<?php echo 'ee'.$row['id']; ?>').style.display='block'">Edit</button> <button style="padding: 5px;" class="edBtn" onclick="document.getElementById('<?php echo 'de'.$row['id']; ?>').style.display='block'">Delete</button></td> 
</tr>

                    <!-- Edit Modal -->
                      <div id="<?php echo 'ee'.$row['id']; ?>" class="modal">
                        <div class="modal-content">

                          <span class="closeEdit" onclick="document.getElementById('<?php echo 'ee'.$row['id']; ?>').style.display='none'">&times;</span>

                          <form action="editService.php?id=<?php echo $row['id']; ?>" method="POST" style="margin-bottom: 10px; margin-top: -30px; background:none;">
                            <h3 class="heading">Edit Service</h3>
                            <center><hr>

                              <label for="serviceNameEdit" class="modal-label">Service Name: </label>
                              <input type="text" name="serviceNameEdit" id="serviceNameEdit" class="modal-input" style="width: 60%; margin-bottom: 10px; margin-left: 10px;" value="<?php echo $row['serviceName']; ?>"><br><br>
                              
                              <label for="servicePriceEdit" class="modal-label">Service Price: </label>
                              <input type="number" name="servicePriceEdit" id="servicePriceEdit" class="modal-input" style="width: 60%; margin-bottom: 10px; margin-left: 10px;" value="<?php echo $row['servicePrice']; ?>"><br><br>
                              
                              <input type="submit" value="Edit Service" name="editService" class="button">
                              
                            </center>
                            </form>

                        </div>
                      </div>

                      <!-- Delete Modal -->
                      <div id="<?php echo 'de'.$row['id']; ?>" class="modal">
                        <div class="modal-content">

                          <span class="closeDelete" onclick="document.getElementById('<?php echo 'de'.$row['id']; ?>').style.display='none'">&times;</span>

                          <form action="deleteService.php?id=<?php echo $row['id']; ?>" method="POST" style="margin-bottom: 10px;margin-top: -30px; background:none;">
                            <h3 class="heading">Delete Service</h3>
                            <center><hr>
                              <label for="serviceNameDelete" class="modal-label">Service Name: </label>
                              <input type="text" name="serviceNameDelete" id="serviceNameDelete" class="modal-input" style="width: 60%; margin-bottom: 10px; margin-left: 10px;" value="<?php echo $row['serviceName']; ?>" disabled><br><br>
                              <label for="servicePriceDelete" class="modal-label">Service Price: </label>
                              <input type="number" name="servicePriceDelete" id="servicePriceDelete" class="modal-input" style="width: 60%; margin-bottom: 10px; margin-left: 10px;" value="<?php echo $row['servicePrice']; ?>" disabled><br><br>
                              <input type="submit" value="Delete Service" name="deleteService" class="button">
                            </center>
                            </form>

                        </div>
                      </div>
  
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
    <td><button style="padding: 5px;" class="edBtn" onclick="document.getElementById('<?php echo 'pe'.$row['id']; ?>').style.display='block'">Edit</button> <button style="padding: 5px;" class="edBtn" onclick="document.getElementById('<?php echo 'pd'.$row['id']; ?>').style.display='block'">Delete</button></td> 
</tr>

                    <!-- Edit Modal -->
                      <div id="<?php echo 'pe'.$row['id']; ?>" class="modal">
                        <div class="modal-content">

                          <span class="closeEdit" onclick="document.getElementById('<?php echo 'pe'.$row['id']; ?>').style.display='none'">&times;</span>

                          <form action="editProduct.php?id=<?php echo $row['id']; ?>" method="POST" style="margin-bottom: 10px; margin-top: -30px; background:none;">
                            <h3 class="heading">Edit Product</h3>
                            <center><hr>

                              <label for="productNameEdit" class="modal-label">Product Name: </label>
                              <input type="text" name="productNameEdit" id="productNameEdit" class="modal-input" style="width: 60%; margin-bottom: 10px; margin-left: 10px;" value="<?php echo $row['productName']; ?>"><br><br>
                              
                              <label for="productDescriptionEdit" class="modal-label">Product Description: </label>
                              <input type="text" name="productDescriptionEdit" id="productDescriptionEdit" class="modal-input" style="width: 60%; margin-bottom: 10px; margin-left: 10px;" value="<?php echo $row['productDescription']; ?>"><br><br>

                              <select id="productVehicleEdit" name="productVehicleEdit" class="grid-item" required>
                                  <?php $v = $row['productVehicle']; ?>
                                <option value="Car" <?php if($v=="Car"){echo "selected";} ?> >Car</option>
                                <option value="Truck" <?php if($v=="Truck"){echo "selected";} ?> >Truck</option>
                                <option value="Bike" <?php if($v=="Bike"){echo "selected";} ?> >Bike</option>
                                <option value="Others/NA" <?php if($v=="Others/NA"){echo "selected";} ?> >Others/NA</option>
                              </select>

                              <label for="productPriceEdit" class="modal-label">Product Price: </label>
                              <input type="number" name="productPriceEdit" id="productPriceEdit" class="modal-input" style="width: 60%; margin-bottom: 10px; margin-left: 10px;" value="<?php echo $row['productPrice']; ?>"><br><br>
                              
                              <input type="submit" value="Edit Product" name="editProduct" class="button">
                              
                            </center>
                            </form>

                        </div>
                      </div>

                      <!-- Delete Modal -->
                      <div id="<?php echo 'pd'.$row['id']; ?>" class="modal">
                        <div class="modal-content">

                          <span class="closeDelete" onclick="document.getElementById('<?php echo 'pd'.$row['id']; ?>').style.display='none'">&times;</span>

                          <form action="deleteProduct.php?id=<?php echo $row['id']; ?>" method="POST" style="margin-bottom: 10px; margin-top: -30px; background:none;">
                            <h3 class="heading">Delete Product</h3>
                            <center><hr>

                              <label for="productNameDelete" class="modal-label">Product Name: </label>
                              <input type="text" name="productNameDelete" id="productNameDelete" class="modal-input" style="width: 60%; margin-bottom: 10px; margin-left: 10px;" value="<?php echo $row['productName']; ?>" disabled><br><br>
                              
                              <label for="productDescriptionDelete" class="modal-label">Product Description: </label>
                              <input type="text" name="productDescriptionDelete" id="productDescriptionDelete" class="modal-input" style="width: 60%; margin-bottom: 10px; margin-left: 10px;" value="<?php echo $row['productDescription']; ?>" disabled><br><br>

                              <select id="productVehicleDelete" name="productVehicleDelete" class="grid-item" required disabled>
                                  <?php $v = $row['productVehicle']; ?>
                                <option value="Car" <?php if($v=="Car"){echo "selected";} ?> >Car</option>
                                <option value="Truck" <?php if($v=="Truck"){echo "selected";} ?> >Truck</option>
                                <option value="Bike" <?php if($v=="Bike"){echo "selected";} ?> >Bike</option>
                                <option value="Others/NA" <?php if($v=="Others/NA"){echo "selected";} ?> >Others/NA</option>
                              </select>

                              <label for="productPriceDelete" class="modal-label">Product Price: </label>
                              <input type="number" name="productPriceDelete" id="productPriceDelete" class="modal-input" style="width: 60%; margin-bottom: 10px; margin-left: 10px;" value="<?php echo $row['productPrice']; ?>" disabled><br><br>
                              
                              <input type="submit" value="Delete Product" name="deleteProduct" class="button">
                              
                            </center>
                            </form>


                        </div>
                      </div>	
  
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