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

$ticket_sql = "SELECT * FROM `tickets` WHERE `user` = '$id'";
$data = mysqli_query($db, $ticket_sql);

?>
<div class="middle">
    <div class="heading">
        <h3 class="text-xl font-bold">Submit a Ticket</h3>
        <div class="date">
            <?php echo $today; ?>
        </div>
    </div>
    <p class="text-xl text-center font-bold">Open a support ticket to contact us</p>

    <section class="ticketarea flex ml-8">
    <form class="w-full max-w-lg mt-8 bg-main rounded-lg p-4" method="post" action="process.php">
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
            <label class="block uppercase tracking-wide text-gray-200 text-base font-bold mb-2" for="grid-password">
                Title
            </label>
            <input name="title" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:border-gray-500" id="nick" type="text" required>
            <p class="text-gray-600 text-xs italic">Required</p>
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
            <label class="block uppercase tracking-wide text-gray-200 text-base font-bold mb-2" for="grid-password">
                Category
            </label>
            <select name="Category" class="block appearance-none w-full px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" placeholder="Category" data-value="">
								<option value="" disabled="" selected="selected">Select a category...</option>
								
									<option value="Deposit Issues">Deposit Issues</option>
								
									<option value="Order Issues">Order Issues</option>
								
									<option value="Order Delays">Order Delays</option>
								
									<option value="Other">Other</option>								
			</select>
            <p class="text-gray-600 text-xs italic">Required</p>
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
            <label class="block uppercase tracking-wide text-gray-200 text-xs font-bold mb-2" for="grid-password">
                Message
            </label>
            <textarea name="Message" class=" no-resize appearance-none block w-full text-gray-100 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-gray-500 h-48 resize-none" style="border: 1px solid rgba(204, 163, 84, 0.45);" id="message"  required></textarea>
            </div>
        </div>
        <div class="md:flex md:items-center">
            <div class="md:w-1/3">
            <input name="submit_ticket" type="submit" value="Send" class="focus:outline-none text-white text-base font-bold py-2.5 px-5 rounded-md bg-yellow-500 hover:bg-yellow-600 hover:shadow-lg flex items-center">
            </div>
            <div class="md:w-2/3"></div>
        </div>
        </form>  
        <div class="rounded-lg w-full mx-4 shadow-lg p-4 bg-main tickets mt-8">
            <h3 class="font-semibold text-normal tracking-wide">Your Tickets</h3>
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
          ?>
                      <div class="list-group-item">
									<a href="view.php?id=<?php echo $ticket['id']?>">
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
									</a>
			</div>
            <?php } } ?>    
        </div>
        
    </section>
    <?php 

?>
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