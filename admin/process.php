<?php 
session_start();
include_once '../dbConfig.php';

$id = $_SESSION['id'];
$sql = "SELECT * FROM `users` WHERE `id` = '$id'";
$login = $db->query($sql);
if($row = $login->fetch_assoc()){
    $id = $row['id'];
    $username = $row['username'];
    $first_name = $row['firstname'];
    $last_name = $row['lastname'];
    $photo_url = $row['photo'];
    $date = $row['date'];
    $role = $row['role'];
    if($role == "0"){
        $role = "Owner";
    }
    elseif($role == "1"){
        $role = "Admin";
    }
    elseif($role == "2"){
        $role = "Worker";
    }
    else{
        $role = "Customer";
    }
}
else{
    header('Location: ../home.php');
}

$today = date("m-d-Y H:i");  


// Reply ticket
if(isset($_POST['submit_reply'])){ 

    $ticket_id = $_POST['ticket_id'];
    $user = $id;
    $msg = $_POST["Message"];
    $ticket = "INSERT INTO `tickets_reply` (`ticket`, `user`, `msg`, `time`) VALUES ('$ticket_id', '$user', '$msg', '$today')";
    if ($db->query($ticket) === TRUE) {
        header('Location: view.php?id='.$ticket_id.'');
    } else {
        echo "Error: " . $ticket . "<br>" . $db->error;
    }
}
if(isset($_POST['accept'])){ 
    $ticket_id = $_POST['ticket_id'];
    $accept = "UPDATE `tickets` SET `status`= 'Worked on' WHERE `id` = '$ticket_id' ";
    mysqli_query($db,$accept)
    or die(mysqli_error($db));
    header('Location: view.php?id='.$ticket_id.'');
}
if(isset($_POST['decline'])){ 
    $ticket_id = $_POST['ticket_id'];
    $accept = "UPDATE `tickets` SET `status`= 'Finished' WHERE `id` = '$ticket_id' ";
    mysqli_query($db,$accept)
    or die(mysqli_error($db));
    header("Location: tickets.php");
}
if(isset($_POST['finished'])){ 
    $ticket_id = $_POST['ticket_id'];
    $accept = "UPDATE `tickets` SET `status`= 'Finished' WHERE `id` = '$ticket_id' ";
    mysqli_query($db,$accept)
    or die(mysqli_error($db));
    header("Location: tickets.php");
}
?>