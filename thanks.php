<?php 
session_start();
include_once 'header.php';
include_once 'dbConfig.php';

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
}


if ($_GET['logout']) {
  setcookie('tg_user', '');
  header('Location: home.php');
}
if(!isset($_POST['submit'])) {
    $user = $id;
    echo $user;
    echo "<br>";
    $country = "usa";
    echo $country;
    echo "<br>";
    $option = $_POST['option'];
    echo $option;
    echo "<br>";
    if($option == "FTID 2"){
        $amount = '18$';
    }
    elseif($option == "Label Drop"){
        $amount = '10$';
    }
    elseif($option == "FTID 3"){
        $amount = '25$';
    }
    elseif($option == "LIT"){
        $amount = '35$';
    }
    else{
        $amount = '45$';
    }
    echo $amount;
    echo "<br>";
    $courier = $_POST['courier'];
    echo $courier;
    echo "<br>";
    $weight = $_POST['weight'];
    echo $weight;
    echo "<br>";
    $status = 'Processing';
    echo $status;
    echo "<br>";
    $date = date("m-d-y g:i");
    echo $date;
    echo "<br>";
    $target_dir = "uploads";
    $file_name = $_FILES['file']['name'];
    echo $file_name;
    $file_tmp = $_FILES['file']['tmp_name'];
    echo $file_tmp;
    
    if (move_uploaded_file($file_tmp, $target_dir . $file_name)) {
        $upload = "INSERT INTO `orders` (`user`, `country`, `option`, `courier`, `weight`, `price`, `track`, `status`, `file`, `added`) VALUES ('$user', '$country', '$option', '$courier', '$weight', '$amount', '$tracking', '$status', '$file_name', '$date')";
        if ($db->query($upload) === TRUE) {
            header('location: index.php');
        } else {
            echo "Error: " . $upload . "<br>" . $db->error;
        }
    }
    else {
        echo "<h1>File Upload not successfull</h1>";
    }
}
else{
    header('location: boxing.php');
}

?>
<div class="middle">

</div>
<div class="right">
    <div class="heading">
        <h3 class="text-sm font-bold" style="color: #d0d0d0;">Logout</h3>
        <a href="?logout=1" class="text-xl lougout-icon">
            <i class='bx bx-log-in-circle' style='color: #fb4343;'></i>
        </a>
    </div>
    <div class="account">
        <div class="image shadow-sm">
            <img src="<?php echo $photo_url; ?>" alt="account image">
        </div>
        <div class="name text-center">
            <h3 class="text-xl"><?php echo $first_name ,' ', $last_name; ?></h3>
            <h3 class="text-lg text-gray-600">User</h3>
        </div>
        <nav class="info">
            <li><i class='bx bxs-id-card'></i> ID: <span> <?php echo $id ?> </span> </li>
            <li><i class='bx bxs-user' ></i>Username: <span> <?php echo $username ?> </span> </li>
            <li><i class='bx bxs-coin'></i>Balance: <span> <?php echo $user_ip ?>   </span> </li>
            <li><i class='bx bxs-calendar-check' ></i> Joined: <span> <?php echo $date ?> </span> </li>
    </div>
</div>

<?php
include_once 'footer.php';
?>