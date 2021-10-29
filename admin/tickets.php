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

$ticket_sql = "SELECT * FROM `tickets`";
$data = mysqli_query($db, $ticket_sql);

// Refresh Page 
$url1=$_SERVER['REQUEST_URI'];
?>
<div class="middle">
    <div class="heading">
        <h3 class="text-xl font-bold">Tickets</h3>
        <div class="date">
            <?php echo $today; ?>
        </div>
    </div>

    <section class="tickets flex justify-center">
    <div class="rounded-lg mx-4 shadow-lg p-4 bg-main tickets mt-8">
            <h3 class="font-semibold text-lg tracking-wide">Pending Tickets</h3>
            <?php
              $ticket = array();
              while ($ticket = $data->fetch_assoc())
              {
              $tickets[] = $ticket;
              }
              if (is_array($tickets) || is_object($ticket))
              {
              foreach ($tickets as $ticket)
              {
                if($ticket['status'] == 'Pending'){
          ?>
                      <div class="list-group-item">
									<a href="view.php?id=<?php echo $ticket['id']?>">
										<p class="h4 text-lg font-semibold mb-2"><?php echo $ticket['title']; ?></p>
										
										<span class="lead mb-0 mr-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800"><?php echo $ticket['category']; ?></span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800"><?php echo $ticket['status']; ?></span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold text-gray-200"><?php echo $ticket['created']; ?></span>
									</a>
			</div>
            <?php } } }?>    
        </div>

        <div class="rounded-lg mx-4 shadow-lg p-4 bg-main tickets mt-8">
            <h3 class="font-semibold text-lg tracking-wide">Tickets in Progress</h3>
            <?php
              $ticket = array();
              while ($ticket = $data->fetch_assoc())
              {
              $tickets[] = $ticket;
              }
              if (is_array($tickets) || is_object($ticket))
              {
              foreach ($tickets as $ticket)
              {
                if($ticket['status'] == 'Worked on'){
          ?>
                      <div class="list-group-item">
									<a href="view.php?id=<?php echo $ticket['id']?>">
										<p class="h4 text-lg font-semibold mb-2"><?php echo $ticket['title']; ?></p>
										
										<span class="lead mb-0 mr-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800"><?php echo $ticket['category']; ?></span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800"><?php echo $ticket['status']; ?></span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold text-gray-200"><?php echo $ticket['created']; ?></span>
									</a>
			</div>
            <?php } } }?>    
        </div>

        <div class="rounded-lg mx-4 shadow-lg p-4 bg-main tickets mt-8">
            <h3 class="font-semibold text-lg tracking-wide">Finished Tickets</h3>
            <?php
              $ticket = array();
              while ($ticket = $data->fetch_assoc())
              {
              $tickets[] = $ticket;
              }
              if (is_array($tickets) || is_object($ticket))
              {
              foreach ($tickets as $ticket)
              {
                if($ticket['status'] == 'Finished'){
          ?>
                      <div class="list-group-item">
									<a href="view.php?id=<?php echo $ticket['id']?>">
										<p class="h4 text-lg font-semibold mb-2"><?php echo $ticket['title']; ?></p>
										
										<span class="lead mb-0 mr-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800"><?php echo $ticket['category']; ?></span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"><?php echo $ticket['status']; ?></span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold text-gray-200"><?php echo $ticket['created']; ?></span>
									</a>
			</div>
            <?php } } }?>    
        </div>
    </section>

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