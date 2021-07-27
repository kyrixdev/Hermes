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
$order_sql = "SELECT * FROM `orders`";
$data = mysqli_query($db, $order_sql);



// Refresh Page 
$url1=$_SERVER['REQUEST_URI'];
header("Refresh: 5; URL=$url1");
?>
<div class="middle">
    <div class="heading">
        <h3 class="text-xl font-bold">Orders</h3>
        <div class="date">
            <?php echo $today; ?>
        </div>
    </div>
    <div class="orders mx-8">
	
    <div class="searchbar rounded flex items-center w-full p-3 shadow-sm">
       <button class="mr-4 outline-none focus:outline-none"><svg class=" w-5 text-gray-600 h-5 cursor-pointer" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
       <input type="search" name="search-order" id="search-order" onkeyup="search_orders()" placeholder="Search for orders" x-model="q" class="rounded-md w-full pl-4 text-sm outline-none focus:outline-none bg-transparent">
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
                Track
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                Status
              </th> 

            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
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
              <td class="px-6 py-4 whitespace-nowrap font-semibold text-sm text-gray-200">
                <?php echo $order['track']; ?>
              </td>
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