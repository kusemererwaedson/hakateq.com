<?php 
session_start();
$_SESSION['id'] = '';
session_destroy();
header( 'location:../backend/login.php');
?>