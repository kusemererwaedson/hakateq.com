<?php
include("../db_con.php");
include("recieve.php");

// add project
if (isset($_POST['add_project'])) {
    $project_title = $_POST['project_title'];
    $project_description = $_POST['project_description'];

    $project_price = $_POST['project_price'];
    $condition = $_POST['condition'];
    $project_link = $_POST['project_link'];

    $imageName = $_FILES['project_image']['name'];
    $imageTmpName = $_FILES['project_image']['tmp_name'];
    move_uploaded_file($imageTmpName, "../assets/images/$imageName");
    $query = "INSERT INTO projects(project_title,project_description,project_image,project_price,project_link,status) VALUES('$project_title','$project_description', '$imageName','$project_price','$project_link','$condition')";
    $stmt = $conn->query($query);

    if ($stmt == true) {
        $sm = "Project was added";
        header("location: ../backend/index.php?id=projects&success=$sm");
    } else {
        $err = "Something went wrong";
        header("location: ../backend/index.php?id=projects&error=$err");
    }
}
//edit project
if (isset($_POST['edit_project'])) {
    $id = $_POST['project_id'];
    $project_title = $_POST['project_title'];
    $project_description = $_POST['project_description'];

    $project_price = $_POST['project_price'];
    $condition = $_POST['condition'];
    $project_link = $_POST['project_link'];

    if ($_FILES['project_image']['name'] != "") {
        $imageName = $_FILES['project_image']['name'];
        $imageTmpName = $_FILES['project_image']['tmp_name'];
        move_uploaded_file($imageTmpName, "../assets/images/$imageName");
        $project_image = $_FILES['project_image']['name'];

    } else {
        $project_image = $_POST['project_image'];
    }

    $query = "UPDATE projects SET project_title='$project_title', project_description='$project_description', project_image='$project_image',project_price='$project_price',project_link='$project_link',status='$condition' WHERE id='$id'";
    $stmt = $conn->query($query);

    if ($stmt == true) {
        $sm = "Updated Successfully";
        header("location: ../backend/index.php?id=projects&success=$sm");
    } else {
        $err = "Something went wrong";
        header("location: ../backend/index.php?id=projects&error=$err");
    }
}

// add service
if (isset($_POST['add_service'])) {

    $service_title = $_POST['service_title'];
    $service_dec = $_POST['service_description'];

    if ($service_title && $service_dec) {
        $sql = "INSERT INTO services(service_title,service_description) VALUES('{$service_title}','$service_dec')";
        $stmt = $conn->query($sql);
        if ($stmt == true) {
            $sm = "Service Was Added";
            header("location: ../backend/index.php?id=services&success=$sm");
        } else {
            $err = "Something went wrong";
            header("location: ../backend/index.php?id=services&error=$err");
        }
    } else {
        $err = "Something went wrong";
        header("location: ../backend/index.php?id=services&error=$err");
    }





}

// update services
if (isset($_POST['update_service'])) {

    $service_id = $_POST['service_id'];
    $service_title = $_POST['service_title'];
    $service_desc = $_POST['service_description'];

    $query = "UPDATE services SET service_title='$service_title', service_description='$service_desc' WHERE id = '$service_id'";
    $stmt = $conn->query($query);

    if ($stmt == true) {
        $sm = "updated Succesfully";
        header("location: ../backend/index.php?id=services&success=$sm");
    } else {
        $err = "Something went wrong try";
        header("location: ../backend/index.php?id=servises&error=$err");
    }

}


// update about
if (isset($_POST['update_about'])) {

    $phone = $_POST['phone'];
    $aboutText = $_POST['aboutText'];

    $query = "UPDATE about SET phone='$phone', about_text='$aboutText'";
    $stmt = $conn->query($query);

    if ($stmt == true) {
        $sm = "Updated Succesfuly";
        header("location: ../backend/index.php?id=about&success=$sm");
    } else {
        $err = "Something went wrong try";
        header("location: ../backend/index.php?id=about&error=$err");
    }

}

//update welcome
if (isset($_POST['update_welcome'])) {

    $welcome_message = $_POST['welcome_message'];
    $slug = $_POST['slug'];

    $query = "UPDATE welcome SET welcome_message='$welcome_message', slug='$slug'";
    $stmt = $conn->query($query);

    if ($stmt == true) {
        $sm = "Updated Succesfuly";
        header("location: ../backend/index.php?id=dashboard&success=$sm");
        exit;
    } else {
        $err = "Something went wrong try";
        header("location: ../backend/index.php?id=dashboard&error=$err");
    }

}

//add news letter
if (isset($_POST['subscribe'])) {
    $email = $_POST['email'];

    if ($email) {
        $query = "INSERT INTO news_letter(email) VALUES('$email')";
        $stmt = $conn->query($query);
        if ($stmt) {
            $sm = "Subscribed";
            header("location: ../index.php?success=$sm");

        } else {
            $err = "Subscription Failed";
            header("location: ../index.php?error=$err");
        }
    } else {
        $err = "Email Required";
        header("location: ../index.php?error=$err");
    }
}

// update profile
if (isset($_POST['update_profile'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];

    $user = recieveProfile($conn);
    $_pass = $user['password'];

    if ($_FILES['profile_image']['name'] != "") {
        $imageName = $_FILES['profile_image']['name'];
        $imageTmpName = $_FILES['profile_image']['tmp_name'];
        move_uploaded_file($imageTmpName, "../assets/images/$imageName");
        $profile_image = $_FILES['profile_image']['name'];

    } else {
        $profile_image = $_POST['profile_image'];
    }

    if (password_verify($old_pass,$_pass)) {
        $h_pass = password_hash($new_pass, PASSWORD_BCRYPT);

        $query = "UPDATE user SET username='$username', email='$email', password='$h_pass', profile='$profile_image'";
        $stmt = $conn->query($query);

        if($stmt==true){
            $sm = "Profie Updated Successfuly";
            header("location: ../backend/index.php?id=edit_profile&success=$sm");

        }else{
            $err = "Some thing went wrong try again!";
            header("location: ../backend/index.php?id=edit_profile&error=$err");
        }

    } else {
          $err = "Old password don't match try again!";
            header("location: ../backend/index.php?id=edit_profile&error=$err");

    }
}

//delete project
if(isset($_POST['remove_project'])){
    $id = $_POST['project_id'];

    $query = "DELETE from projects WHERE id='$id'";
    $stmt = $conn->query($query);
    if($stmt==true){
        $sm = "Project has been deleted";
        header("location: ../backend/index.php?id=projects&success=$sm");
    }else{
        $err = "Some thing went wrong";
        header("location: ../backend/index.php?id=projects&error=$sm");
    }
}
//delete service
if(isset($_POST['remove_service'])){
    $id = $_POST['service_id'];

    $query = "DELETE from services WHERE id='$id'";
    $stmt = $conn->query($query);
    if($stmt==true){
        $sm = "Service has been deleted";
        header("location: ../backend/index.php?id=services&success=$sm");
    }else{
        $err = "Some thing went wrong";
        header("location: ../backend/index.php?id=services&error=$sm");
    }
}
//delete comment
if(isset($_POST['remove_comment'])){
    $id = $_POST['comment_id'];

    $query = "DELETE from comments WHERE id='$id'";
    $stmt = $conn->query($query);
    if($stmt==true){
        $sm = "Comment has been deleted";
        header("location: ../backend/index.php?id=comments&success=$sm");
    }else{
        $err = "Some thing went wrong";
        header("location: ../backend/index.php?id=comments&error=$sm");
    }
}

//delete news-letter
if(isset($_POST['remove_news_letter'])){
    $id = $_POST['news_letter'];

    $query = "DELETE from news_letter WHERE id='$id'";
    $stmt = $conn->query($query);
    if($stmt==true){
        $sm = "Subscriber deleted";
        header("location: ../backend/index.php?id=news-letter&success=$sm");
    }else{
        $err = "Some thing went wrong";
        header("location: ../backend/index.php?id=news-letter&error=$sm");
    }
}



?>