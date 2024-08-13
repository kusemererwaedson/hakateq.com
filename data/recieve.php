<?php 

//get all projects
function recieveAllProjects($conn){
    $query = "SELECT * FROM projects";
    $stmt = $conn->query($query);

    if($stmt == true){
        $projects = $stmt->fetchAll();
        return $projects;
    }else{
        return 0;
    }
}

//get project by id
function recieveProjectById($project_id, $conn){
    $sql = "SELECT * FROM projects WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$project_id]);

    if($stmt->rowCount()==1){
        $project = $stmt->fetch();
        return $project;
    }else{
        return 0;
    }
}

// get all services 
function recieveAllServices($conn){
    $query = "SELECT * FROM services";
    $stmt = $conn->query($query);

    if($stmt == true){
        $services = $stmt->fetchAll();
        return $services;
    }else{
        return 0;
    }
}

// get About data
function recieveAboutData($conn){
    $query = "SELECT * FROM about";
    $stmt = $conn->query($query);

    if($stmt==true){
        $aboutData = $stmt->fetch();
        return $aboutData;
    }else{
        return 0;
    }
    
}

//get welcome messages
function recieveWelcomeData($conn){
    $query = "SELECT * FROM welcome";
    $stmt = $conn->query($query);

    if($stmt==true){
        $welcomeData = $stmt->fetch();
        return $welcomeData;
    }else{
        return 0;
    }
    
}

// get comments 
function recieveComments($conn){
    $query = "SELECT * FROM comments";
    $stmt = $conn->query($query);

    if($stmt==true){
        $comments = $stmt->fetchAll();
        return $comments;
    }else{
        return 0;
    }
    
}

//get news letters
function recieveNewsLetter($conn){
    $query = "SELECT * FROM news_letter";
    $stmt = $conn->query($query);

    if($stmt==true){
        $new_letter = $stmt->fetchAll();
        return $new_letter;
    }else{
        return 0;
    }
    
}

//get profile
function recieveProfile($conn){
    $query = "SELECT * FROM user";
    $stmt = $conn->query($query);

    if($stmt==true){
        $user = $stmt->fetch();
        return $user;
    }else{
        return 0;
    }
    
}

?>