<?php
session_start();
include_once 'header.php';
include_once '../dbConfig.php';
define('BOT_USERNAME', 'loginphp_bot'); // place username of your bot here

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

if ($_GET['logout']) {
    setcookie('tg_user', '');
    header('Location: ../home.php');
    session_destroy();
}
if($access != "1"){
    header('location: ../home.php');
}
$today = date("j M Y, l"); 

$order_sql = "SELECT * FROM `orders` ORDER BY `orders`.`status` DESC";
$data = mysqli_query($db, $order_sql);


$orders_num = "SELECT COUNT(*) as orders FROM `orders` WHERE `status` = 'Processing' ";
$orders_num_sql = mysqli_query($db, $orders_num);
$count = mysqli_fetch_assoc($orders_num_sql);
$users = mysqli_query($db, "SELECT COUNT(*) as users FROM `users`");
$users_num = mysqli_fetch_assoc($users);
?>


<div class="middle">
    <div class="heading">
        <h3 class="text-xl font-bold">Dashboard</h3>
        <div class="date">
            <?php echo $today; ?>
        </div>
    </div>

    <div class="main">
        <div class="cards">
            <div class="Orders rounded-xl">
                <div class="col-span-12 sm:col-span-6 md:col-span-3 rounded-xl ">
                    <div class="flex flex-row bg-white shadow-sm rounded-xl p-4">
                    <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl bg-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <div class="flex flex-col flex-grow ml-4">
                        <div class="text-sm font-medium	text-black">Orders</div>
                        <div class="font-bold text-black text-lg"><?php echo $count['orders']; ?></div>
                    </div>
                    </div>
                </div>
            </div>

            <div class="balance">
                <div class="col-span-12 sm:col-span-6 md:col-span-3 rounded-xl ">
                    <div class="flex flex-row bg-white shadow-sm rounded-xl p-4">
                    <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl bg-gray-600">
                        <i class="bx bx-user-circle text-2xl" style="color: #edd184;" ></i>
                    </div>
                    <div class="flex flex-col flex-grow ml-4">
                        <div class="text-sm font-medium text-black">Total Users</div>
                        <div class="font-bold text-black text-lg"><?php echo $users_num["users"]; ?></div>
                    </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="lists">
            <div class="card shadow-sm rounded-xl mb-4">
                            <div class="card-title d-flex rounded-xl justify-content-between align-items-center p-3 mb-0">
                                <div class="mb-0">Orders</div>
                                <a href="orders.php" class="text-muted small">View All</a>
                            </div>
                            <ul class="list-group list-group-flush">
                            <?php
                                $order = array();
                                while ($order = $data->fetch_assoc())
                                {
                                $orders[] = $order;
                                }
                                if (is_array($orders) || is_object($order))
                                {
                                foreach ($orders as $order)
                                {
                            ?>
                                <li class="list-group-item orders">
                                    <span class="text-success"><?php echo '#'.$order['id']; ?></span>                                
                                    <span class="text-muted"> • </span>
                                    <span class="text-info"><?php echo $order['option']; ?></span>
                                    <span class="lead px-2">
                                    <?php 
                                        if($order['status'] === "Accepted"){
                                        ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 float-right	">
                                        <?php 
                                        }
                                        elseif($order['status'] === "Declined"){
                                        ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 float-right	">
                                        <?php 
                                        }
                                        else{
                                        ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 float-right	">
                                        <?php }?>
                                        <?php echo $order['status']; ?>
                                        </span>
                                    </span>
                                </li>
                                <?php } } ?>   
                            </ul>
            </div>
            <div class="card shadow-sm rounded-xl mb-4">
                            <div class="card-title d-flex justify-content-between align-items-center p-3 mb-0">
                                <div class="mb-0">Your Deposits</div>
                                <a href="deposit.php" class="text-muted small">View All</a>
                            </div>
                            <ul class="list-group list-group-flush">
                                
                                <li class="list-group-item">
                                    <span class="text-success">$100.00</span>                                
                                    <span class="text-muted"> • </span>
                                    <span class="text-info">Cryptocurrency</span>
                                    <span class="lead px-2">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Paid
                                    </span>
                                    </span>
                                </li>
                                
                                <li class="list-group-item">
                                    <span class="text-success">$100.00</span>
                                    <span class="text-muted"> • </span>
                                    <span class="text-info">Credit Card | Apple Pay</span>
                                    <span class="lead px-2">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Unpaid
                                    </span>	
                                    </span>
                                </li>

                            </ul>
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
        if($role == "Owner" || $role == "Admin" || $role == "Worker"){
            echo '<a href="../index.php" class="btn btn-admin"> <i class="bx bxs-lock-alt"></i> Back as user </a>';
        }
    ?>
</div>

<?php
include_once 'footer.php';
?>