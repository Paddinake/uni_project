
<?php
$con = mysqli_connect('localhost','ebusiness016','AbDAzrUMqe','ebusiness016');
if($con){
    echo "<b><span style='color:green'> connected </span> </b>";}
if (mysqli_connect_error()){
    echo "<b><span style='color:red'> Failed to connect to MYSQL: </span> </b>" .mysqli_connect_error();
}

?>