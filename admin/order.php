<?php 
ob_start();
session_start();
include_once 'header.php';
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
        $access = "1";
    }
    elseif($role == "1"){
        $role = "Admin";
        $access = "1";
    }
    elseif($role == "2"){
        $role = "Worker";
        $access = "1";
    }
    else{
        $role = "Customer";
        $access = "0";
    }
}
if($access != "1"){
    header('location: ../home.php');
}
$today = date("j M Y, l"); 

if ($_GET['logout']) {
  setcookie('tg_user', '');
  header('Location: ../home.php');
  session_destroy();
}
if($_GET["order"]){
    $order_id = $_GET["order"];
}
  $order_sql = "SELECT * FROM `orders` WHERE id = '$order_id' ";
  $order = $db->query($order_sql);
  if($row = $order->fetch_assoc()){
      $order_id = $row['id'];
      $order_user = $row['user'];
      $country = $row['country'];
      $option = $row['option'];
      $courier = $row['courier'];
      $weight = $row['weight'];
      $price = $row['price'];
      $status = $row['status'];
      $file = $row['file'];
      $added = $row['added'];
      $note = $row['note'];
  }

  $user_pic = $db->query("SELECT `photo` FROM `users` WHERE id = '$order_user'");
  $userpic = mysqli_fetch_array($user_pic);
?>

<div class="middle">
    <div class="heading">
        <h3 class="text-xl font-bold">Order Information</h3>
        <div class="date">
            <?php echo $today; ?>
        </div>
    </div>
    <div class="py-6 flex flex-col justify-center sm:py-12">
  <div class="flex space-x-4 px-4 justify-around">
    <!-- CARD -->
    <div class="order-card w-28 md:w-96 md:rounded-3xl rounded-full shadow-md relative flex flex-col items-center justify-between md:items-start py-5 md:p-5 transition-all duration-150">
      <!-- IMG PROFILE -->
      <img class="rounded-full w-16 h-16 shadow-sm absolute -top-8 transform md:scale-110 duration-700" src="<?php echo $userpic['photo']; ?>" alt="" />

      <!-- TEXTS -->
      <div class="transform -rotate-90 md:rotate-0 align-middle text-2xl font-semibold text-gray-200 text-center m-auto md:m-0 md:mt-8">
          <span class="block text-base text-left">
            <?php
                            $user = $order_user;
                            $user_sql = $db->query("SELECT * FROM `users` WHERE id = '$user'");
                            $userinfo = mysqli_fetch_array($user_sql);
            echo $userinfo['username']; ?>
          </span>
        Order #<?php echo $order_id; ?>
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 ml-32">
                  <?php echo $status; ?>
        </span>
    </div>
      <ul class="text-lg text-gray-300 font-light hidden md:flex mt-8">
        <li class="font-bold">
            OPTION
            <span class="block text-base font-normal"><?php echo $option; ?></span>
        </li>
        <li class="font-bold mx-12">
            COURIER
            <span class="block text-base font-normal"><?php echo $courier; ?></span>
        </li>
        <li class="font-bold">
            WEIGHT
            <span class="block text-base font-normal"><?php echo $weight; ?></span>
        </li>
      </ul>
      <ul class="text-lg text-gray-300 font-light hidden md:flex mt-8">
        <li class="font-bold">
            PRICE
            <span class="block text-base font-normal"><?php echo $price; ?></span>
        </li>
        <li class="font-bold mx-16">
            COUNTRY
            <span class="block text-base font-normal"><?php echo $country; ?></span>
        </li>
        <br>
        <li class="font-bold">
            STATUS
            <span class="block text-base font-normal"><?php echo $status; ?></span>
        </li>
      </ul>

      <!-- BUTTONS -->
      <div class="flex w-full justify-around my-4">
      <form method="post" class="flex">
        <button onclick="window.open('../uploads/<?php echo $file; ?> ','_blank');" type="button" class=" rounded-full w-16 h-16 shadow-sm bg-yellow-400 bg-opacity-40 backdrop-blur-lg">
            <i class='bx bx-file text-3xl'></i>
        </button>
        <?php 
        if($status === "Processing"){
        ?>
        <button type="submit" name="accept" id="accept" class="mx-8 md:block | rounded-full w-16 h-16 shadow-sm bg-green-400 bg-opacity-40 backdrop-blur-lg">
            <i class='bx bx-check-circle text-3xl'></i>
        </button>
        <button type="submit" name="decline" id="decline" class="md:block | rounded-full w-16 h-16 shadow-sm bg-red-400 bg-opacity-40 backdrop-blur-lg">
            <i class='bx bx-x-circle text-3xl'></i>
        </button>
        <?php
        }
        ?>
        <?php 
        if($status === "Accepted"){
        ?>
        <button type="submit" name="decline" id="decline" class="md:block | rounded-full w-16 h-16 shadow-sm bg-red-400 bg-opacity-40 backdrop-blur-lg">
            <i class='bx bx-x-circle text-3xl'></i>
        </button>
        <?php
        }
        ?>
        <?php 
        if($status === "Declined"){
        ?>

        <?php
        }
        ?>
       </form>
      </div>
      <?php
        if($status == "Accepted"){
            echo "<p class='block m-auto'>This order is managed by $note</p>";
        }
        ?>
    </div>
  </div>
</div>

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
            <h3 class="text-lg text-gray-600"><?php echo $role; ?></h3>
        </div>
        <nav class="info">
            <li><i class='bx bxs-id-card'></i> ID: <span> <?php echo $id ?> </span> </li>
            <li><i class='bx bxs-user' ></i>Username: <span> <?php echo $username ?> </span> </li>
            <li><i class='bx bxs-coin'></i>Balance: <span> <?php echo $user_ip ?>   </span> </li>
            <li><i class='bx bxs-calendar-check' ></i> Joined: <span> <?php echo $date ?> </span> </li>
    </div>
    <?php
        if($role = "Owner" || $role = "Admin" || $role = "Worker"){
            echo '<a href="../admin/" class="btn btn-admin"> <i class="bx bxs-lock-alt"></i> Staff Dashboard </a>';
        }
    ?>
</div>


<?php
include_once 'footer.php';
if(isset($_POST['accept'])){ 
    $accept = "UPDATE `orders` SET `status`= 'Accepted',`note`= 'Accepted by $username'   WHERE `id` = '$order_id' ";
    mysqli_query($db,$accept)
    or die(mysqli_error($db));
    header("Location: orders.php");
}
if(isset($_POST['decline'])){ 
    $accept = "UPDATE `orders` SET `status`= 'Declined',`note`= 'Declined by $username'   WHERE `id` = '$order_id' ";
    mysqli_query($db,$accept)
    or die(mysqli_error($db));
    header("Location: orders.php");
}
?>