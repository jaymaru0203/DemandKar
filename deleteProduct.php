<?php
require('config.php');
if(!isset($_SESSION['email'])){
    header('Location: login.php');
    exit;
}

if(isset($_POST['deleteProduct'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM product WHERE id='$id'";
    if($conn->query($sql)===TRUE){
        header('Location: serviceCenter.php');
    }
    else{
        echo "Product Could Not be Deleted. Please go Back.";
    }
}

?>
