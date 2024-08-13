<?php
session_start();

$sessionId = $_SESSION['id'] ?? '';

if (!$sessionId ) {
    header("location:login.php");
    die();
}

ob_start();

include("../db_con.php");
include("../data/recieve.php");



$projects = recieveAllProjects($conn);
$services = recieveAllServices($conn);
$aboutData = recieveAboutData($conn);
$welcomeData = recieveWelcomeData($conn);
$comments = recieveComments($conn);

$user = recieveProfile($conn);

$id = $_REQUEST['id'] ?? 'dashboard';
$action = $_REQUEST['action'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shaka Admin</title>
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
    <div class="sidebar bg_blue">

        <div class="image">
            <img src="../assets/images/<?= $user['profile'] ?>" alt="">
        </div>
        <h4 class="text-center text-white p-2"><?=$user['username']?></h4>
        <hr>

        <ul class="">
            <li class=" <?php if ('dashboard' == $id) {
                echo "active";
            } ?>">
                <a href="index.php?id=dashboard" class="nav-link">Dashboard</a>
            </li>

            <li class=" <?php if ('projects' == $id) {
                echo " active";
            } ?>">
                <a href="index.php?id=projects" class="nav-link">Projects</a>
            </li>

            <li class="<?php if ('services' == $id) {
                echo "active";
            } ?>">
                <a href="index.php?id=services" class="nav-link">Sevices</a>
            </li>

            <li class="<?php if ('about' == $id) {
                echo "active";
            } ?>">
                <a href="index.php?id=about" class="nav-link">About</a>
            </li>

            <li class="<?php if ('comments' == $id) {
                echo "active";
            } ?>">
                <a href="index.php?id=comments" class="nav-link">Comments</a>
            </li>

            <li class="<?php if ('news-letter' == $id) {
                echo "active";
            } ?>">
                <a href="index.php?id=news-letter" class="nav-link">NewLetter</a>
            </li>
        </ul>

        <a href="../data/logout.php" class="nav-link text-center">Sign Out</a>
    </div>
    <!-- --------------------------------topbar------------------------------------------------- -->
    <div>
        <div class="topbar ">
            <div class="p-3 bg_white">
                <p class="text-end text_blue"><a href="index.php?id=profile" class="nav-link">Profile</a></p>
            </div>
        </div>
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

        <div class="dashboard  p-5">
            <div class="container">
                <!-- ---------------------------------main dashboard ------------------------------------- -->
                <?php if ('dashboard' == $id) {

                    ?>

                    <p>Dashboard</p>
                    <div class="row">
                        <div class="col-md-3">
                            <div class=" bg_blue text-center text-white p-3">
                                <h4>100+</h4>
                                <p>Projects</p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="bg-warning text-center text-white p-3">
                                <h4>100+</h4>
                                <p>Services</p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="bg_blue text-center text-white p-3">
                                <h4>100+</h4>
                                <p>Comments</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bg-success text-center text-white p-3">
                                <h4>100+</h4>
                                <p>Subscribers</p>
                            </div>
                        </div>
                    </div>
                    <form action="../data/send.php" class="bg_white" method="POST">
                        <textarea name="welcome_message" id="" class="form-control my-3" cols="30"
                            rows="6"><?= $welcomeData['welcome_message'] ?></textarea>
                        <input type="text" name="slug" value="<?= $welcomeData['slug'] ?>" class="form-control my-3">

                        <div class="text-center">
                            <button type="submit" name="update_welcome"
                                class="btn text-warning bg_blue my-3">Update</button>
                        </div>

                    </form>
                    <?php
                }

                ?>
                <!-- -------------------------------projects----------------------------------------------------- -->
                <?php if ('projects' == $id) {

                    ?>

                    <p>Projects</p>
                    <a href="index.php?id=add_project"><button
                            class="btn bg_blue float-end text-warning m-2 ">+Project</button></a>
                    <table class="table bg_white">
                        <thead>
                            <tr>
                                <td>
                                    <h6 class="bg_blue p-3 text-white">Name of the Project</h6>
                                </td>
                                <td>
                                    <h6 class="bg_blue p-3 text-white">Price</h6>
                                </td>
                                <td>
                                    <h6 class="bg_blue p-3 text-white">Condtion</h6>
                                </td>
                                <td>
                                    <h6 class="bg_blue p-3 text-white">Action</h6>
                                </td>

                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($projects) {
                                foreach ($projects as $index => $project) {

                                    ?>
                                    <tr>
                                        <td>
                                            <?= $project['project_title'] ?>
                                        </td>
                                        <td>$
                                            <?= $project['project_price'] ?>
                                        </td>
                                        <td>
                                            <?= $project['status'] ?>
                                        </td>
                                        <td>
                                            <button class='btn text_blue' data-bs-toggle='modal'
                                                data-bs-target='#view_project<?= $index ?>'><i class='fa fa-eye'></i></button>

                                            <?php printf("<a href='index.php?action=edit_project&id=%s' class='btn text-warning'><i class='fa fa-edit'></i></a>", $project['id']) ?>

                                            <button class="btn text-danger" data-bs-toggle="modal"
                                                data-bs-target="#remove_project<?= $index ?>"><i class="fa fa-trash"></i></button>
                                        </td>

                                    </tr>
                                    <!-- -------View popup -------- -->
                                    <div class="modal fade" id="view_project<?= $index ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <h4 class="text-center text_blue">
                                                        <?= $project['project_title'] ?>
                                                        <h4>
                                                            <p>
                                                                <?= $project['project_description'] ?>
                                                            </p>
                                                            <img src="../assets/images/<?= $project['project_image'] ?>" alt=""
                                                                width="100%" height="300px">
                                                            <p class="my-2">Condtion: <span class="text-warning">
                                                                    <?= $project['status'] ?>
                                                                </span></p>
                                                            <p class="my-2">Price: <span class="text-warning">$
                                                                    <?= $project['project_price'] ?>
                                                                </span></p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- -------delete project popup -------- -->
                                    <div class="modal fade" id="remove_project<?= $index ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body text-center">
                                                    <p>Do you want to Delete this Project</p>
                                                    <form action="../data/send.php" method="POST">
                                                        <input name="project_id" type="text" value="<?= $project['id'] ?>" hidden>
                                                        <div class="text-center p-3">
                                                            <button type="button" class="btn m-4 bg_blue"
                                                                data-bs-dismiss="modal">No</button>
                                                            <button type="submit" name="remove_project" class="btn btn-danger"
                                                                id="confirmButton">Yes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>

                        </tbody>
                    </table>

                    <?php
                }

                ?>

                <!-- --------------------- addProject--------------------- -->
                <?php if ('add_project' == $id) {

                    ?>
                    <div class="bg_white p-3 w-75">
                        <h4 class="text-center">Add New Project</h4>
                        <form action="../data/send.php" method="POST" enctype="multipart/form-data">
                            <label for="">Name of Project</label>
                            <input type="text" class="form-control my-3" name="project_title" required>
                            <label for="">Description of Project</label>
                            <textarea name="project_description" class="form-control my-3" cols="30" rows="10"
                                required></textarea>

                            <label for=""> Project Screen shot<i class="fas fa-pen text-center"
                                    id="chooseImage"></i></label>
                            <input name="project_image" type="file" id="fileInput" hidden accept="image/*"
                                class="form-control my-3" required>
                            <img src="../assets/images/1.jpeg" class="form-control w-100" height="300px"
                                alt="Current Profile Image" id="profileImage" id="chooseImage">


                            <label for="" class="mt-3">Price of Project</label>
                            <input type="text" class="form-control my-3" name="project_price">
                            <label for="" class="mt-3">Link to Project</label>
                            <input type="text" name="project_link" class="form-control my-3" name="" required>

                            <label>Condition</label><br>
                            <input type="radio" class="m-3" value="Paid" checked name="condition"> Paid
                            <input type="radio" class="m-3" value="Free" name="condition"> Free

                            <button type="submit" name="add_project" class="btn text-warning bg_blue form-control my-3"> Add
                                Project</button>
                        </form>
                    </div>

                    <?php

                } ?>

                <!-- --------------------- editProject--------------------- -->
                <?php if ('edit_project' == $action) {
                    $project_id = $_REQUEST['id'];
                    $project = recieveProjectById($project_id, $conn);

                    ?>
                    <div class="bg_white p-3 w-75">
                        <h4 class="text-center">Edit Project</h4>

                        <form action="../data/send.php" method="POST" enctype="multipart/form-data">
                            <input type="text" name="project_id" value="<?= $project['id']; ?>" hidden>
                            <label for="">Name of Project</label>
                            <input type="text" class="form-control my-3" name="project_title"
                                value="<?= $project['project_title'] ?>" required>
                            <label for="">Description of Project</label>
                            <textarea name="project_description" class="form-control my-3" cols="30"
                                rows="10"><?= $project['project_description'] ?></textarea>

                            <label for=""> Project Screen shot<i class="fas fa-pen text-center"
                                    id="chooseImage"></i></label>
                            <input name="project_image" type="file" id="fileInput" value="<?= $project['project_image'] ?>"
                                hidden accept="image/*" class="form-control my-3">
                            <img src="../assets/images/<?= $project['project_image'] ?>" class="form-control w-100"
                                height="300px" alt="Current project Image" id="profileImage" id="chooseImage">
                            <input type="text" name="project_image" value="<?= $project['project_image'] ?>" hidden>
                            <label for="" class="mt-3">Price of Project</label>
                            <input type="text" class="form-control my-3" name="project_price"
                                value="<?= $project['project_price'] ?>">
                            <label for="" class="mt-3">Link to Project</label>
                            <input type="text" name="project_link" class="form-control my-3"
                                value="<?= $project['project_link'] ?>">

                            <label>Condition</label><br>
                            <?php if ($project['status'] == 'Paid') {
                                ?>
                                <input type="radio" class="m-3" value="Paid" checked name="condition"> Paid

                                <input type="radio" class="m-3" value="Free" name="condition"> Free
                                <?php
                            } else {
                                ?>
                                <input type="radio" class="m-3" value="Paid" name="condition"> Paid

                                <input type="radio" class="m-3" checked value="Free" name="condition"> Free

                                <?php
                            } ?>

                            <button type="submit" name="edit_project" class="btn text-warning bg_blue form-control my-3">
                                Update
                                Project</button>
                        </form>
                    </div>

                    <?php

                } ?>

                <!-- ---------------------------------services ------------------------------------------- -->
                <?php if ('services' == $id) {

                    ?>

                    <p>Services</p>
                    <a href="index.php?id=add_service"><button
                            class="btn bg_blue float-end text-warning m-2 ">+Service</button></a>

                    <table class="table bg_white table-striped">
                        <thead>
                            <tr>
                                <td>
                                    <h6 class="bg_blue p-3 text-white">Service Title</h6>
                                </td>
                                <td>
                                    <h6 class="bg_blue p-3 text-white">Description</h6>
                                </td>
                                <td>
                                    <h6 class="bg_blue p-3 text-white">Action</h6>
                                </td>

                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($services) {
                                foreach ($services as $index => $service) {

                                    ?>

                                    <tr>
                                        <form action="../data/send.php" method="POST">
                                            <input type="text" name="service_id" value="<?= $service['id'] ?>" hidden>
                                            <td><input type="text" name="service_title" class="form-control"
                                                    value="<?= $service['service_title'] ?>"></td>
                                            <td><textarea name="service_description" id="" class="form-control" cols="40"
                                                    rows="5"><?= $service['service_description'] ?></textarea>
                                            </td>
                                            <td>
                                                <button type="submit" name="update_service"
                                                    class="btn text-warning bg_white">Update</button>
                                        </form>
                                        <button class='btn text-danger' data-bs-toggle='modal'
                                            data-bs-target='#remove_service<?= $index ?>'><i class='fa fa-trash'></i></button>
                                        </td>

                                    </tr>
                                    <!-- -------delete service popup -------- -->
                                    <div class="modal fade" id="remove_service<?= $index ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body text-center">
                                                    <p>Are you sure you want to Delete this service </p>
                                                    <form action="../data/send.php" method="POST">
                                                        <input name="service_id" type="text" value="<?= $service['id'] ?>" hidden>
                                                        <div class="text-center p-3">
                                                            <button type="button" class="btn m-4 bg_blue"
                                                                data-bs-dismiss="modal">No</button>
                                                            <button type="submit" name="remove_service" class="btn btn-danger"
                                                                id="confirmButton">Yes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                }
                            } ?>
                        </tbody>

                    </table>

                    <?php
                }

                ?>

                <!-- --------------------- addService--------------------- -->
                <?php if ('add_service' == $id) {

                    ?>
                    <div class="bg_white p-3 w-75">
                        <h4 class="text-center">Add New Service</h4>
                        <form action="../data/send.php" method="POST">
                            <label for="">Service title</label>
                            <input type="text" class="form-control my-3" name="service_title" required>
                            <label for="">Service Description</label>
                            <textarea name="service_description" class="form-control my-3" cols="30" rows="10"
                                required></textarea>
                            <button name="add_service" class="btn text-warning bg_blue form-control my-3"> Add
                                Service</button>
                        </form>
                    </div>

                    <?php

                } ?>


                <!-- ---------------------------------about------------------------------------------- -->
                <?php if ('about' == $id) {

                    ?>

                    <p>About</p>
                    <div class="bg_white">
                        <form action="../data/send.php" enctype="multipart/form-data" method="POST">
                            <label for="" class="m-2 text_blue">Contact</label>
                            <input type="text" name="phone" class="form-control my-2" value="<?= $aboutData['phone']; ?>">

                            <label for="" class="m-2 text_blue">About Me</label>
                            <textarea id="" cols="30" rows="10" class="form-control"
                                name="aboutText"><?= $aboutData['about_text'] ?></textarea>
                            <button type="submit" name="update_about"
                                class="btn bg_blue mt-2 text-warning float-end">Update</button>
                        </form>
                    </div>
                    <?php
                }

                ?>

                <!-- ---------------------------------comments------------------------------------------- -->
                <?php if ('comments' == $id) {

                    ?>

                    <p>Comments</p>

                    <div class="row">

                        <?php
                        if ($comments) {
                            foreach ($comments as $index => $comment) {

                                ?>
                                <div class="col-md-4 mt-3">
                                    <div class="bg_white p-3">
                                        <h4 class="text_blue text-center">
                                            <?= $comment['client_name'] ?>
                                        </h4>
                                        <h5 class="text-center">
                                            <?= $comment['client_phone'] ?>
                                        </h5>
                                        <h6 class="text-center overflow-hidden">
                                            <?= $comment['client_email'] ?>
                                        </h6>

                                        <p>
                                            <?= $comment['message'] ?>
                                        </p>
                                        <div class="text-end">
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#remove_comment<?= $index ?>"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <!-- -------delete comment popup -------- -->
                                <div class="modal fade" id="remove_comment<?= $index ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <p>Are you sure you want to Delete this commet </p>
                                                <form action="../data/send.php" method="POST">
                                                    <input name="comment_id" type="text" value="<?= $comment['id'] ?>" hidden>
                                                    <div class="text-center p-3">
                                                        <button type="button" class="btn m-4 bg_blue"
                                                            data-bs-dismiss="modal">No</button>
                                                        <button type="submit" name="remove_comment" class="btn btn-danger"
                                                            id="confirmButton">Yes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>

                    <?php
                }

                ?>

                <!-- ---------------------------------News-letter------------------------------------------- -->
                <?php if ('news-letter' == $id) {
                    $news_letter = recieveNewsLetter($conn);

                    ?>

                    <p>Subscribers</p>
                    <table class="table bg_white">
                        <tr>
                            <td>
                                <h6 class="bg_blue text-white p-3">Email Address</h6>
                            </td>
                            <td>
                                <h6 class="bg_blue text-white p-3">Action</h6>
                            </td>

                        </tr>
                        <?php
                        if ($news_letter) {
                            foreach ($news_letter as $index => $new) {
                                ?>
                                <tr>
                                    <td>
                                        <?= $new['email'] ?>
                                    </td>

                                    <td>
                                        <div class="text-end">
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#remove_newsLetter<?= $index ?>"><i
                                                    class="fa fa-trash"></i></button>
                                        </div>
                        </div>
                    </div>
                    <!-- -------delete news letter popup -------- -->
                    <div class="modal fade" id="remove_newsLetter<?= $index ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body text-center">
                                    <p>Are you sure you want to Delete this commet </p>
                                    <form action="../data/send.php" method="POST">
                                        <input type="text" name="news_letter" value="<?= $new['id'] ?>" hidden>
                                        <div class="text-center p-3">
                                            <button type="button" class="btn m-4 bg_blue" data-bs-dismiss="modal">No</button>
                                            <button type="submit" name="remove_news_letter" class="btn btn-danger"
                                                id="confirmButton">Yes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    </td>
                    </tr>

                    <?php
                            }
                        } else {
                            echo "<tr>No Subscribers</tr>";
                        }
                        ?>

            </table>
            <?php

            ?>

            <?php
                }

                ?>


        <!-- ----------------------------------profile-------------------------------------- -->
        <?php if ('profile' == $id) {

            ?>

            <p>Profile</p>
            <div class="bg_white p-3 w-75">
                <h4 class="text-center text_blue">My profile</h4>
                <div class="text-center ">
                    <img src="../assets/images/<?= $user['profile'] ?>" alt="" class="rounded-circle" height="150" width="150">
                </div>
                <h5 class="text-center">
                    <?= $user['username'] ?>
                </h5>
                <h5 class="text-center">
                    <?= $user['email'] ?>
                </h5>
                <a href="index.php?id=edit_profile" class="btn bg_blue form-control text-warning">Update Profile</a>

            </div>
            <?php
        }

        ?>

        <!-- ---------------------------------- edit profile-------------------------------------- -->
        <?php if ('edit_profile' == $id) {
            $user = recieveProfile($conn)
                ?>

            <p>Edit Profile</p>
            <div class="bg_white p-3 w-75">
                <h4 class="text-center text_blue">Edit profile</h4>

                <form action="../data/send.php" method="POST" enctype="multipart/form-data">
                    <div class="text-center ">

                        <input type="text" name="profile_image" value="<?=$user['profile']?>" hidden>
                        <input type="file" id="fileInput" name="profile_image" hidden accept="image/*">
                        <img src="../assets/images/<?=$user['profile']?>" class="rounded-circle" alt="Current Profile Image" id="profileImage" width="150" height="150px">
                        <i class="fas fa-pen" id="chooseImage"></i>

                    </div>
                    <input type="text" name="username" class="form-control my-3" value="<?= $user['username'] ?>">
                    <input type="email" name="email" class="form-control my-3" value="<?= $user['email'] ?>">

                    <input type="text" class="form-control my-3" name="old_pass" placeholder="Old Password">
                    <input type="text" class="form-control my-3" name="new_pass" placeholder="New Password">

                    <button type="submit" name="update_profile" class="btn bg_blue form-control text-warning">Update
                        Profile</button>
                </form>
            </div>
            <?php
        }

        ?>
    </div>
    </div>
    </div>



    <script src="../assets/js/app.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa"
        crossorigin="anonymous"></script>
</body>

</html>