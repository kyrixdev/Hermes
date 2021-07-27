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
$users_sql = "SELECT * FROM `users`";
$data = mysqli_query($db, $users_sql);
?>
<div class="middle">
    <div class="heading">
        <h3 class="text-xl font-bold">Users List</h3>
        <div class="date">
            <?php echo $today; ?>
        </div>
    </div>
    <div class="orders mx-8">
	
    <div class="searchbar rounded flex items-center w-full p-3 shadow-sm">
       <button class="mr-4 outline-none focus:outline-none"><svg class=" w-5 text-gray-600 h-5 cursor-pointer" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
       <input type="search" name="search-order" id="search-order" onkeyup="search_orders()" placeholder="Search for user" x-model="q" class="rounded-md w-full pl-4 text-sm outline-none focus:outline-none bg-transparent">
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
                
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                ID
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                USERNAEM
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                FULL NAME
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                JOINED
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                ROLE
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
              </th>

            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
          <?php
              $users = array();
              while ($user = $data->fetch_assoc())
              {
              $users[] = $user;
              }
              if (is_array($users) || is_object($user))
              {
              foreach ($users as $user)
              {
               
          ?>

            <tr class="tr-dp" id="<?php echo $user['id']; ?>">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                <img class="w-8 h-8" src="<?php echo $user['photo']; ?>">
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
 
                <div class="text-sm text-green-500"><?php echo $user['id'];?></div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                <?php echo $user['username']; ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                <?php echo $user['firstname'] ,' ', $user['lastname']; ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                <?php echo $user['date']; ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                <?php 
                    if($user['role'] == "0"){
                      echo "Owner";
                  }
                  elseif($user['role'] == "1"){
                    echo "Admin";
                  }
                  elseif($user['role'] == "2"){
                    echo "Worker";
                  }
                  else{
                    echo "Customer";
                  }
                ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
              <?php $idd = $user['id'];?>
              <div class="modal-container">
              <input id="modal-toggle" type="checkbox">
              <label class="btnn" for="modal-toggle">Click me</label> 
              <label class="modal-backdrop" for="modal-toggle"></label> 
                <div class="modal-content">
                  <label class="modal-close" for="modal-toggle">&#x2715;</label>
                  <?php
                  if($role === "Owner"){
                  ?>
                  <h2 class="text-xl mb-8">Give Permissions :</h2>
                  <form method="post">
                      <input type="hidden" name="ticket_id" value="<?php echo $user['id']; ?>">
                      <input name="admin" type="submit" value="Admin" class="btnn">
                      <input name="worker" type="submit" value="Worker" class="btnn">
                      <input name="customer" type="submit" value="Customer" class="btnn">
                      <br>
                      <h2 class="text-xl my-8">Block IP (Be carful):</h2>
                      <button class="btnn" value="block ip" name="block" type="submit">Block IP</button>
                  </form>
                  
                  <label class="modal-content-btn" for="modal-toggle">OK</label>
                  <?php } ?>   
                </div>        
              </div>  
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

if(isset($_POST['admin'])){ 
  $accept = "UPDATE `users` SET `role`= '1' WHERE `id` = '$idd' ";
  mysqli_query($db,$accept)
  or die(mysqli_error($db));
  header("Location: users.php");
}
if(isset($_POST['worker'])){ 
  $accept = "UPDATE `users` SET `role`= '2' WHERE `id` = '$idd' ";
  mysqli_query($db,$accept)
  or die(mysqli_error($db));
  header("Location: orders.php");
}
if(isset($_POST['customer'])){ 
  $accept = "UPDATE `users` SET `role`= '3' WHERE `id` = '$idd' ";
  mysqli_query($db,$accept)
  or die(mysqli_error($db));
  header("Location: orders.php");
}
?>