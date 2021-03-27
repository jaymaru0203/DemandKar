<?php
require('config.php');
if(!isset($_SESSION['email'])){
  header('Location: login.php');
  exit;
}

$id = $_GET['id'];
echo "Product ID: $id";
?>