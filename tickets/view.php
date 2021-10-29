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

if ($_GET['logout']) {
  setcookie('tg_user', '');
  header('Location: ../home.php');
  session_destroy();
}

$today = date("j M Y, l"); 
$ticket_id = $_GET['id'];
$ticket_sql = "SELECT * FROM `tickets` WHERE `id` = '$ticket_id'";
$data = mysqli_query($db, $ticket_sql);


?>
<div class="middle">
    <div class="heading">
        <h3 class="text-xl font-bold">Ticket</h3>
        <div class="date">
            <?php echo $today; ?>
        </div>
    </div>

    <section class="ticketarea flex">
        <div class="rounded-lg w-full mx-4 shadow-lg p-4 bg-main tickets mt-8">
            <div class="main-ticket">
                <div class="list-group-item">
                    <?php
                    if($ticket = $data->fetch_assoc()){
                        $ticket_owner_id = $ticket['user'];
                    ?>
                                        <h1 class="text-lg font-bold"></h1>
										<p class="h4 text-lg font-semibold mb-2"><?php echo $ticket['title']; ?></p>
										
										<span class="lead mb-0 mr-1">
                                        <?php
                                        if($ticket['status'] == 'Pending')
                                        {
                                        ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800"><?php echo $ticket['category']; ?></span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800"><?php echo $ticket['status']; ?></span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold text-gray-200"><?php echo $ticket['created']; ?></span>
                                        <?php
                                        }
                                        elseif($ticket['status'] == 'Worked on'){
                                        ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800"><?php echo $ticket['category']; ?></span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800"><?php echo $ticket['status']; ?></span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold text-gray-200"><?php echo $ticket['created']; ?></span>
										<?php
                                        }
                                        else{
                                        ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800"><?php echo $ticket['category']; ?></span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"><?php echo $ticket['status']; ?></span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold text-gray-200"><?php echo $ticket['created']; ?></span>
                                        <?php     
                                        }
                                        ?>
					<?php
                    
                    $getuser_sql = $db->query("SELECT * FROM `users` WHERE `id` = '$ticket_owner_id'");
                    $getuser = mysqli_fetch_array($getuser_sql);
                    ?>			
			        </div>

                    <div class="flex items-start px-4 py-6">
                    <img class="w-12 h-12 rounded-full object-cover mr-4 shadow" src="<?php echo $getuser['photo'];   ?>" alt="avatar">
                    <div class="">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-yellow-200 -mt-1"><?php echo $getuser['firstname'],' ',$getuser['lastname']; ?> </h2>
                            <small class="text-sm text-gray-100 mx-16"><?php echo $ticket['created']; ?></small>
                        </div>
                        <p class="mt-3 text-gray-100 text-sm">
                            <?php echo $ticket['msg']; ?>
                        </p>
                    </div>
                    </div>
                    <?php } 
                    $ticket_reply_sql = "SELECT * FROM `tickets_reply` WHERE `ticket` = '$ticket_id'";
                    $data_reply = mysqli_query($db, $ticket_reply_sql);
                    while($ticket = $data_reply->fetch_assoc()){
                    $ticket_owner_id = $ticket['user'];
                    $getuser_sql = $db->query("SELECT * FROM `users` WHERE `id` = '$ticket_owner_id'");
                    $getuser = mysqli_fetch_array($getuser_sql);
                    ?>
                    <div class="flex items-start px-4 py-6">
                        <img class="w-12 h-12 rounded-full object-cover mr-4 shadow" src="<?php echo $getuser['photo'];   ?>" alt="avatar">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-yellow-200 -mt-1"><?php echo $getuser['firstname'],' ',$getuser['lastname']; ?> </h2>
                                <small class="text-sm text-gray-100 mx-16"><?php echo $ticket['time']; ?></small>
                            </div>
                            <p class="mt-3 text-gray-100 text-sm">
                                <?php echo $ticket['msg']; ?>
                            </p>
                        </div>
                    </div>
                    <?php } ?>
            </div>
            <div class="w-full px-3">
            <form method="post" action="process.php" >
            <input type="hidden" name="ticket_id" value="<?php echo $ticket_id; ?>">
            <label class="block uppercase tracking-wide text-gray-200 text-xs font-bold mb-2" for="grid-password">
                NEW MESSAGE
            </label>
            <textarea name="Message" class=" no-resize appearance-none block w-full text-gray-100 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-gray-500 h-48 resize-none" style="border: 1px solid rgba(204, 163, 84, 0.45);" id="message"  required></textarea>
            </div>
            <input name="submit_reply" type="submit" value="Send" class="mx-3 focus:outline-none text-white text-base font-bold py-2.5 px-5 rounded-md bg-yellow-500 hover:bg-yellow-600 hover:shadow-lg flex items-center">
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
        if($role == "Owner" || $role == "Admin" || $role == "Worker"){
            echo '<a href="../admin/" class="btn btn-admin"> <i class="bx bxs-lock-alt"></i> Staff Dashboard </a>';
        }
    ?>
</div>

<?php
include_once 'footer.php';
?>