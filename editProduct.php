<?php
require('config.php');
if(!isset($_SESSION['email'])){
    header('Location: login.php');
    exit;
}

if(isset($_POST['editProduct'])){
    $name = $_POST['productNameEdit'];
    $description = $_POST['productDescriptionEdit'];
    $vehicle = $_POST['productVehicleEdit'];
    $price = $_POST['productPriceEdit'];
    $id = $_GET['id'];
    $sql = "UPDATE product SET productName='$name', productDescription='$description', productVehicle='$vehicle', productPrice='$price' WHERE id='$id'";
    if($conn->query($sql)===TRUE){
        header('Location: serviceCenter.php');
    }
    else{
        echo "Product Could Not be Edited. Please go Back.";
    }
}

?>
