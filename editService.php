<?php
require('config.php');
if(!isset($_SESSION['email'])){
    header('Location: login.php');
    exit;
}

if(isset($_POST['editService'])){
    $name = $_POST['serviceNameEdit'];
    $price = $_POST['servicePriceEdit'];
    $id = $_GET['id'];
    $sql = "UPDATE services SET serviceName='$name', servicePrice='$price' WHERE id='$id'";
    if($conn->query($sql)===TRUE){
        header('Location: serviceCenter.php');
    }
    else{
        echo "Service Could Not be Edited. Please go Back.";
    }
}

?>
