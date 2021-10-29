<?php 
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
  header('Location: home.php');
}
$order_sql = "SELECT * FROM `orders` ORDER BY `orders`.`status` DESC";
$data = mysqli_query($db, $order_sql);


$peding_orders = "SELECT COUNT(*) as orders FROM `orders` WHERE `status` = 'Processing'";
$peding_orders_sql = mysqli_query($db, $peding_orders);
$pending = mysqli_fetch_assoc($peding_orders_sql);

$declined_orders = "SELECT COUNT(*) as orders FROM `orders` WHERE `status` = 'Declined'";
$declined_orders_sql = mysqli_query($db, $declined_orders);
$declined = mysqli_fetch_assoc($declined_orders_sql);

$accepted_orders = "SELECT COUNT(*) as orders FROM `orders` WHERE `status` = 'Accepted'";
$accepted_orders_sql = mysqli_query($db, $accepted_orders);
$accepted = mysqli_fetch_assoc($accepted_orders_sql);
// Refresh Page 
$url1=$_SERVER['REQUEST_URI'];
<<<<<<< HEAD
//header("Refresh: 10; URL=$url1");
=======
header("Refresh: 5; URL=$url1");
>>>>>>> e665a55d2383eeccd2f52b18f956be931cba63ee
?>
<div class="middle">
    <div class="heading">
        <h3 class="text-xl font-bold">Orders</h3>
        <div class="date">
            <?php echo $today; ?>
        </div>
    </div>
    <div class="orders mx-8">
	
    <div class="cards"">
            <div class="Orders rounded-xl">
                <div class="col-span-12 sm:col-span-6 md:col-span-3 rounded-xl ">
                    <div class="flex flex-row bg-white shadow-sm rounded-xl p-4">
<<<<<<< HEAD
                    <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl bg-gray-300">
                    <i class='bx bx-time-five' style="color: #7d23b7;"></i>
                    </div>
                    <div class="flex flex-col flex-grow ml-4">
                        <div class="text-sm font-medium	text-white">Processing Orders</div>
                        <div class="font-bold text-white text-lg"><?php echo $pending['orders']; ?></div>
=======
                    <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl bg-gray-600">
                    <i class='bx bx-time-five' style="color: #edd184;"></i>
                    </div>
                    <div class="flex flex-col flex-grow ml-4">
                        <div class="text-sm font-medium	text-black">Processing Orders</div>
                        <div class="font-bold text-black text-lg"><?php echo $pending['orders']; ?></div>
>>>>>>> e665a55d2383eeccd2f52b18f956be931cba63ee
                    </div>
                    </div>
                </div>
            </div>
            <div class="Orders rounded-xl mx-8">
                <div class="col-span-12 sm:col-span-6 md:col-span-3 rounded-xl ">
                    <div class="flex flex-row bg-white shadow-sm rounded-xl p-4">
<<<<<<< HEAD
                    <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl bg-gray-300">
                    <i class='bx bx-check' style="color: #7d23b7;"></i>
                    </div>
                    <div class="flex flex-col flex-grow ml-4">
                        <div class="text-sm font-medium	text-white">Accepted Orders</div>
                        <div class="font-bold text-white text-lg"><?php echo $accepted['orders']; ?></div>
=======
                    <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl bg-gray-600">
                    <i class='bx bx-check' style="color: #edd184;"></i>
                    </div>
                    <div class="flex flex-col flex-grow ml-4">
                        <div class="text-sm font-medium	text-black">Accepted Orders</div>
                        <div class="font-bold text-black text-lg"><?php echo $accepted['orders']; ?></div>
>>>>>>> e665a55d2383eeccd2f52b18f956be931cba63ee
                    </div>
                    </div>
                </div>
            </div>
            <div class="balance">
                <div class="col-span-12 sm:col-span-6 md:col-span-3 rounded-xl ">
                    <div class="flex flex-row bg-white shadow-sm rounded-xl p-4">
<<<<<<< HEAD
                    <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl bg-gray-300">
                      
                      <i class='bx bx-x' style="color: #7d23b7;"></i>
                    </div>
                    <div class="flex flex-col flex-grow ml-4">
                        <div class="text-sm font-medium text-white">Declined Orders</div>
                        <div class="font-bold text-white text-lg"><?php echo $declined['orders']; ?></div>
=======
                    <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl bg-gray-600">
                      
                      <i class='bx bx-x' style="color: #edd184;"></i>
                    </div>
                    <div class="flex flex-col flex-grow ml-4">
                        <div class="text-sm font-medium text-black">Declined Orders</div>
                        <div class="font-bold text-black text-lg"><?php echo $declined['orders']; ?></div>
>>>>>>> e665a55d2383eeccd2f52b18f956be931cba63ee
                    </div>
                    </div>
                </div>
            </div>

        </div>

<!-- This example requires Tailwind CSS v2.0+ -->
<div class="flex flex-col">
  <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
      <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="thread-deposit">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                #
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                User
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                Option
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                Courier
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                Weight
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                Price
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
<<<<<<< HEAD
=======
                Track
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
>>>>>>> e665a55d2383eeccd2f52b18f956be931cba63ee
                Status
              </th> 

            </tr>
          </thead>
<<<<<<< HEAD
          <tbody class="divide-y divide-gray-200">
=======
          <tbody class="bg-white divide-y divide-gray-200">
>>>>>>> e665a55d2383eeccd2f52b18f956be931cba63ee
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
                $user = $order['user'];
                $user_sql = $db->query("SELECT * FROM `users` WHERE id = '$user'");
                $userinfo = mysqli_fetch_array($user_sql);
          ?>
            <tr class="tr-dp cursor-pointer" id="<?php echo $order['id']; ?>" onclick="window.open('order.php?order=<?php echo $order['id']?> ','_blank');">
              <td class="px-4 py-4 whitespace-nowrap">
                  <div class="text-left">
                    <div class="text-sm font-medium text-success">
                      <?php echo $order['id']; ?>
                    </div>
                  </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-green-500"><?php echo $userinfo['username']; ?></div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-info">
                <?php echo $order['option']; ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-200">
                <?php echo $order['courier']; ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-200">
                <?php echo $order['weight']; ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap font-semibold text-sm text-price">
                <?php echo $order['price']; ?>
              </td>
<<<<<<< HEAD
=======
              <td class="px-6 py-4 whitespace-nowrap font-semibold text-sm text-gray-200">
                <?php echo $order['track']; ?>
              </td>
>>>>>>> e665a55d2383eeccd2f52b18f956be931cba63ee
              <td class="px-6 py-4 whitespace-nowrap">
                <?php 
                if($order['status'] === "Accepted"){
                ?>
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                <?php 
                }
                elseif($order['status'] === "Declined"){
                ?>
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                <?php 
                }
                else{
                ?>
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                <?php }?>
                  <?php echo $order['status']; ?>
                </span>
              </td>
            </tr>
              
            <?php } } ?>
            <!-- More people... -->
          </tbody>
        </table>
      </div>
    </div>
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
          echo '<a href="../index.php" class="btn btn-admin"> <i class="bx bxs-lock-alt"></i> Back as user </a>';
        }
    ?>
</div>


<?php
include_once 'footer.php';

?>