<?php
require('config.php');
if(isset($_POST['hire'])){
    $service = $_POST['service'];
    $t = count($service);
    for($i=0; $i<$t; $i++){
        echo "<br>$service[$i]";
    }
    $ser = implode(" ", $service);
    $sql = 'SELECT * FROM services WHERE id IN (' . implode(',', $service) . ')';
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        while($row=$result->fetch_assoc()){
            echo $row['serviceName'];
        }
    }
}


?>



