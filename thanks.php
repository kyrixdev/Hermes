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
        $amount = '15$';
    }
    elseif($option == "FTID 3"){
        $amount = '25$';
    }
    elseif($option == "LIT"){
        $amount = '30$';
    }
    else{
        $amount = '50$';
    }
    echo $amount;
    echo "<br>";
    $courier = $_POST['courier'];
    echo $courier;
    echo "<br>";
    $weight = $_POST['weight'];
    echo $weight;
    echo "<br>";
    $tracking = $_POST['tracking'];
    echo $tracking;
    echo "<br>";
    $status = 'Processing';
    echo $status;
    echo "<br>";
    $date = date("m-d-y g:i");
    echo $date;
    echo "<br>";
    $file = $_FILES['file']['name'];
    $target = "uploads/".basename($file);
    $file_tmp =$_FILES['file']['tmp_name'];
    echo $file_tmp;
    echo $target;
    echo "<br>";
    if(move_uploaded_file($file_tmp , $target)){
        $upload = "INSERT INTO `orders` (`user`, `country`, `option`, `courier`, `weight`, `price`, `track`, `status`, `file`, `added`) VALUES ('$user', '$country', '$option', '$courier', '$weight', '$amount', '$tracking', '$status', '$file', '$date')";
        if ($db->query($upload) === TRUE) {
            header('location: index.php');
        } else {
            echo "Error: " . $upload . "<br>" . $db->error;
        }
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