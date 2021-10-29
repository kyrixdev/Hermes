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
        <h3 class="text-xl font-bold">Deposit</h3>
        <div class="date">
          <?php echo $today; ?>
        </div>
    </div>
    <div class="deposit mx-8">
	
    <div class="card card-body">
        <form method="POST" id="deposit-form" data-bonus="">
            <div class="row justify-between">
                <div class="col-md-6">
                    <label class="mb-sm-3">Payment method:</label>
                    <div class="row">
                             <div class="col-xl-4 col-sm-8">
                                 <label class="card-radio-label mb-sm-0">
                                     <input type="radio" name="currency" value="" class="card-radio-input">
                                     <button type="button" class="card-radio focus:outline-none text-yellow-600 text-sm py-2.5 px-5 rounded-md hover:bg-yellow-50 flex items-center">
                                        <i class='bx bxl-bitcoin'></i>
                                        Cryptocurrency
                                    </button>
                                 </label>
                             </div>
                     </div>
                </div>
                <div class="col-sm-4">
                    <label class="mb-sm-3">Amount:</label>
                    <input type="number" name="Amount" id="deposit-amount" class="form-control border-primary form-control-lg h1 text-center font-weight-light" min="10" max="10000" step="0.01" placeholder="$0.00" value="">
                </div>
                <div class="col-sm-2 pr-sm-4">
                    <label class="mb-sm-3">&nbsp;</label>
                    <input type="submit" value="Deposit now" class="focus:outline-none font-bold text-white text-sm py-2.5 px-5 rounded-md bg-yellow-500 hover:bg-yellow-600 hover:shadow-lg flex items-center">
                </div>
            </div>
        <input type="hidden" name="csrf" value="5f57823d-9c66-b99c-1251-f86c588dc52d"></form>
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
                Amount
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                Method
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                Transaction
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                Status
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                Date
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr class="tr-dp">
              <td class="px-6 py-4 whitespace-nowrap">
                  <div class="ml-4">
                    <div class="text-sm font-medium font-semibold text-gray-200">
                      1
                    </div>
                  </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-semibold text-green-500">$100</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap font-semibold text-sm text-gray-200">
                Cryptocurrency
              </td>
              <td class="px-6 py-4 whitespace-nowrap font-semibold text-sm text-gray-200">
                
               </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  Paid
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap font-semibold text-sm text-gray-200">
                07/15/2021 20:00
              </td>
            </tr>
            <tr class="tr-dp">
              <td class="px-6 py-4 whitespace-nowrap">
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-200">
                      1
                    </div>
                  </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-green-500">$100</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                Cryptocurrency
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                
               </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  Paid
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                07/15/2021 20:00
              </td>
            </tr>
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
        if($role == "Owner" || $role == "Admin" || $role == "Worker"){
            echo '<a href="admin/" class="btn btn-admin"> <i class="bx bxs-lock-alt"></i> Staff Dashboard </a>';
        }
    ?>
</div>

<?php
include_once 'footer.php';
?>