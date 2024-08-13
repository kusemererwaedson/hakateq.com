<?php 
// offline
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "makerjzo_isihaka";

// // online
// $servername = "localhost";
// $username = "makerjzo_shaka";
// $password = "Isihaka1005";
// $dbname = "makerjzo_isihaka";

 try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password);
    // echo"Connected";

 }catch(PDOException $e){
    echo"connection Failed" .$e->getMessage();
 }