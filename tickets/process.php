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
    header('Location: home.php');
}

$today = date("m-d-Y H:i");  

function generate_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0C2f ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0x2Aff ), mt_rand( 0, 0xffD3 ), mt_rand( 0, 0xff4B )
    );

}

// Submit ticket
if(isset($_POST['submit_ticket'])){ 

    $ticket_id = generate_uuid();
    $user = $id;
    $priority = "0";
    $category = $_POST['Category'];
    $title = $_POST['title'];
    $status = "Pending";
    $msg = $_POST["Message"];
    $ticket = "INSERT INTO `tickets` (`id`, `user`, `priority`, `category`, `title`, `msg`, `status`, `created`) VALUES ('$ticket_id', '$user', '$priority', '$category', '$title', '$msg', '$status', '$today')";
    if ($db->query($ticket) === TRUE) {
        header('Location: view.php?id='.$ticket_id.'');
    } else {
        echo "Error: " . $ticket . "<br>" . $db->error;
    }
}

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

?>