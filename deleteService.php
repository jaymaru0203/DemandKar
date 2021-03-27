<?php
require('config.php');
if(!isset($_SESSION['email'])){
    header('Location: login.php');
    exit;
}

if(isset($_POST['deleteService'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM services WHERE id='$id'";
    if($conn->query($sql)===TRUE){
        header('Location: serviceCenter.php');
    }
    else{
        echo "Service Could Not be Deleted. Please go Back.";
    }
}

?>
