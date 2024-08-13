<?php
session_start();

include('db_con.php');
include("data/recieve.php");

$project_id = $_REQUEST['id'];

$project = recieveProjectById($project_id, $conn);
$aboutData = recieveAboutData($conn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $project['project_title'] ?>
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/swal.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>

    <!-- ------------------------------------nav starts---------------------- -->
    <nav class="navbar navbar-expand-lg navbar-light p-3 bg_white fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand text_blue" href="#">Shaka.com</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a>
                    <a class="nav-link" href="index.php?#projects">Projects</a>
                    <!-- <a class="nav-link" href="#">Browse projects</a> -->
                    <a class="nav-link" href="index.php?#about" tabindex="-1" aria-disabled="true">About Freelancer</a>
                </div>
            </div>
            <div class="float-end">
                <input class="form-control mt-2" type="search" placeholder="Search" aria-label="Search">
            </div>
        </div>
    </nav>
    <!------------------------------ end nav----------------------------------- -->

    <div class="container-fluid">
        <div class="container mt-5">
            <div class="bg_white main_body pt-5 pb-5 p-2">
                <h3 class="text_blue mx-3">
                    <?= $project['project_title'] ?>
                </h3>
                <p class="m-3">
                    <?= $project['project_description'] ?>
                </p>

                <?php if ($project['status'] == "Paid") {
                    echo "<p class='mx-3'>Price<span class='text-warning'> $" . $project['project_price'] . "</span></p>";
                } ?>

                <img src="assets/images/<?= $project['project_image'] ?>" class="form-control my-3 w-75" height="400px"
                    alt="No project Image available">


                <?php if ($project['status'] == "Free") {
                    ?>
                    <a href="<?= $project['project_link'] ?>" class="btn btn-success mx-3 form-control w-50">Download</a>

                    <?php
                } else {
                    if(isset($_POST['paid_download'])){
                        $sm = "Contact the Deloper at +256-778237748 for download details"
                        ?>
                        <script>
                            setTimeout(function () {
                                swal("Success", "<?= $sm; ?>", "success");
                            },
                                100);
                        </script>

                        <?php
                    }
                    ?>
                    <form method="POST">
                        <button name="paid_download" class="btn btn-success mx-3 form-control w-50">Download</button>
                    </form>
                    <?php
                }


                ?>


                <h5 class="m-3">Leave a Comment</h5>
                <div class="row">
                    <?php
                    if (isset($_POST['add_comment'])) {
                        $fname = $_POST['fname'];
                        $phone = $_POST['phone'];
                        $email = $_POST['email'];
                        $msg = $_POST['msg'];


                        $sql = "INSERT INTO comments(client_name, client_phone, client_email, message) VALUES('$fname','$phone','$email','$msg')";
                        $stmt = $conn->query($sql);

                        $sm = "Thank You for your Comment";

                        ?>

                        <script>
                            setTimeout(function () {
                                swal("Success", "<?= $sm; ?>", "success");
                            },
                                100);
                        </script>


                        <?php
                    }
                    ?>
                    <form class="col-md-7" method="POST">
                        <input type="text" name="fname" placeholder="Full Name" class="form-control m-3" id="" required>
                        <input type="text" name="phone" placeholder="Phone Number" class="form-control m-3" id=""
                            required>
                        <input type="text" name="email" placeholder="Email Address" class="form-control m-3" id=""
                            required>
                        <textarea name="msg" id="" cols="30" rows="5" placeholder="Type you comment..."
                            class="form-control m-3" required></textarea>

                        <button type="submit" name="add_comment"
                            class="btn bg_blue form-control m-3 text-warning">Send</button>
                    </form>

                    <div class="col-md-5">
                        <h6 class="text-center">Contact</h6>
                        <div class="bg_white mx-5 p-3">
                            <a href="#" class="nav-link text_blue">
                                <p><i class="fa fa-phone"></i>
                                    <?php echo $aboutData['phone'] ?>
                                </p>
                            </a>
                            <a href="#" class="nav-link text_blue">
                                <p><i class="fa fa-twitter"></i>Twitter</p>
                            </a>
                            <a href="#" class="nav-link text_blue">
                                <p><i class="fa fa-linkedin"></i>LinkedIn</p>
                            </a>
                            <a href="" class="nav-link text_blue">
                                <p><i class="fa fa-facebook"></i>Facebook</p>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>



        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
            integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa"
            crossorigin="anonymous"></script>
</body>

</html>