<?php

session_start();

include("../db_con.php");
include("../data/recieve.php");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shaka </title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="../assets/js/swal.js"></script>
</head>

<body>
    <div class="container p-5">
        <?php if (isset($_GET['success'])) { ?>
            <script>
                setTimeout(function () {
                    swal("Success", "<?= $_GET['success'] ?>", "success");
                },
                    100);
            </script>

        <?php } ?>

        <?php if (isset($_GET['error'])) { ?>
            <script>
                setTimeout(function () {
                    swal("Failed", "<?= $_GET['error'] ?>", "error");
                },
                    100);
            </script>

        <?php } ?>
        <div class="bg_white p-5">
            <h2 class="text_blue text-center">Login</h2>
            <?php
            if (isset($_POST['login'])) {
                $email = $_POST['email'];
                $pass = $_POST['pass'];


                $user = recieveProfile($conn);
                $_email = $user['email'];
                $_pass = $user['password'];

                // $h_pass = password_hash($_pass, PASSWORD_BCRYPT);

                             
                if(password_verify($pass,$_pass) && $email==$_email){

                    $_SESSION['id'] = '1';
                    header('location:index.php');
                }else{
                    $err = "Invalid Email or Password";
                    header("location:login.php?error=$err");
                }


            }
            ?>
            <form class="p-5" method="POST">
                <input name="email" type="email" class="form-control p-2 my-3" placeholder="Email Address">

                <input name="pass" type="password" class="form-control p-2 my-3" placeholder="Password">

                <button type="submit" name="login" class="btn bg_blue text-warning">Login</button>

            </form>
        </div>
    </div>
</body>

</html>