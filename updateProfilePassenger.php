<?php
require('config.php');
if(!isset($_SESSION['email'])){
    header('Location: login.php');
    exit;
}

if(isset($_POST['update'])){
        $nameEdit = $_POST['name'];
        $mobileEdit = $_POST['mobile'];
        $email = $_SESSION['email'];
    $edit = "UPDATE passenger SET name='$nameEdit', mobile='$mobileEdit' WHERE email='$email'";
    if($conn->query($edit) === TRUE){
        header('Location: passenger.php');
    }
    else{
        $hErr = "Profile Could Not be Updated!";
    }
}

?>