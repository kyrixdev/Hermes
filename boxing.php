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
    header('Location: home.php');
}

if ($_GET['logout']) {
  setcookie('tg_user', '');
  header('Location: home.php');
  session_destroy();
}

$today = date("j M Y, l"); 

?>
<div class="middle">
    <div class="heading">
        <h3 class="text-xl font-bold">Submit Order</h3>
        <div class="date">
            <?php echo $today; ?>
        </div>
    </div>

    <section class="order">
        <div class="boxing m-8">
            <form name="order" action="thanks.php" method="post" class="order-form" enctype="multipart/form-data">
                <div class="step">
                    Step 1: <span class="text-gray-700 head">Select Country</span>
                    <input type="radio" name="usa" value="usa" class="card-radio-input" >
                    <button type="button" class="card-radio focus:outline-none text-yellow-600 text-sm py-2.5 px-5 rounded-md border border-yellow-600 hover:bg-yellow-50 flex items-center">
                        United States
                    </button>
                </div>
                <div class="step">
                    Step 2: <span class="text-gray-700 head">Select Option</span>
                    <br>
                    <label class="items-center">
<<<<<<< HEAD
                        <input type="radio" class="form-radio" name="option" value="Label Drop">
                        <span class="ml-2">Label Drop <span style="margin-left: 5.7rem;" class="px-2 inline-flex text-base leading-5 font-semibold rounded-full bg-purple text-white">10$</span></span>
                    </label>
                    <br>
                    <label class="items-center">
                        <input type="radio" class="form-radio" name="option" value="FTID 2">
                        <span class="ml-2">FTID 2 <span style="margin-left: 7.5rem;" class="px-2 inline-flex text-base leading-5 font-semibold rounded-full bg-purple text-white">20$</span></span>
=======
                        <input type="radio" class="form-radio" name="option" value="FTID 2">
                        <span class="ml-2">FTID 2 <span style="margin-left: 7.5rem;" class="px-2 inline-flex text-base leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">15$</span></span>
>>>>>>> e665a55d2383eeccd2f52b18f956be931cba63ee
                    </label>
                    <br>
                    <label class="items-center">
                        <input type="radio" class="form-radio" name="option" value="FTID 3">
<<<<<<< HEAD
                        <span class="ml-2">FTID 3 <span style="margin-left: 7.5rem;" class="px-2 inline-flex text-base leading-5 font-semibold rounded-full bg-purple text-white">25$</span></span>
                    </label>
                    <br>
                    <label class="items-center">
                        <input type="radio" class="form-radio" name="option" value="FTID 5">
                        <span class="ml-2">FTID 5 - Express Labels <span class="px-2 inline-flex text-base leading-5 font-semibold rounded-full bg-purple text-white">45$</span></span>
                    </label>
                    <br>
                    <label class="items-center">
                        <input type="radio" class="form-radio" name="option" value="LIT">
                        <span class="ml-2">LIT<span style="margin-left: 9.3rem;" class="px-2 inline-flex text-base leading-5 font-semibold rounded-full bg-purple text-white">50$</span></span>
                    </label>
                   
=======
                        <span class="ml-2">FTID 3 <span style="margin-left: 7.5rem;" class="px-2 inline-flex text-base leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">25$</span></span>
                    </label>
                    <br>
                    <label class="items-center">
                        <input type="radio" class="form-radio" name="option" value="LIT">
                        <span class="ml-2">LIT<span style="margin-left: 9.3rem;" class="px-2 inline-flex text-base leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">30$</span></span>
                    </label>
                    <br>
                    <label class="items-center">
                        <input type="radio" class="form-radio" name="option" value="FTID 5">
                        <span class="ml-2">FTID 5 - Express Labels <span class="px-2 inline-flex text-base leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">50$</span></span>
                    </label>
>>>>>>> e665a55d2383eeccd2f52b18f956be931cba63ee
                </div>
                <div class="step">
                    Step 3: <span class="text-gray-700 head">Enter Weight</span>
                    <input type="text" name="weight" required="" placeholder="in lbs" class="mt-1 focus:ring-yellow-500 focus:border-yellow-500 text-black block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <br>
                <div class="step">
                    Step 4: <span class="text-gray-700 head">Select Courier</span>
                    <div class="block w-100 text-black">
                        <select name="courier" class="block appearance-none w-full px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                            <option value="UPS">UPS</option>
                            <option value="USPS">USPS</option>
                            <option value="FedEx">FedEx</option>
                            <option value="Pitney Bowes">Pitney Bowes</option>
                        </select>

                    </div>
                </div>
                <br>
                <div class="step">
<<<<<<< HEAD
=======
                    Step 5: <span class="text-gray-700 head">Enter Tracking Number</span>
                    <input type="text" name="tracking" required="" placeholder="XXXXXXXXXXXXX"class="mt-1 focus:ring-yellow-500 focus:border-yellow-500 text-black block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="step">
>>>>>>> e665a55d2383eeccd2f52b18f956be931cba63ee
                    Step 6: <span class="text-gray-700 head">Upload Label</span>
                    <br>
                    <label>
                    <input type="file" name="file" class="" required/>
                    </label>    
                </div>
                <br>
                <div class="step">
                    Step 7: <span class="text-gray-700 head">Place Order</span>
                    <br>
                        <input type="submit" value="Submit Order" class="focus:outline-none text-white text-base font-bold py-2.5 px-5 rounded-md bg-yellow-500 hover:bg-yellow-600 hover:shadow-lg flex items-center">
                </div>

              </div>
            </form>
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
            echo '<a href="admin/" class="btn btn-admin"> <i class="bx bxs-lock-alt"></i> Staff Dashboard </a>';
        }
    ?>
</div>

<?php
include_once 'footer.php';

?>