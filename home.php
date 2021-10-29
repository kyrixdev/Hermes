<?php
session_start();
include_once 'dbConfig.php';
define('BOT_USERNAME', 'loginphp_bot'); 
function getTelegramUserData() {
  if (isset($_COOKIE['tg_user'])) {
    $auth_data_json = urldecode($_COOKIE['tg_user']);
    $auth_data = json_decode($auth_data_json, true);
    return $auth_data;
  }
  return false;
}
function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

$user_ip = getUserIP();
if ($_GET['logout']) {
  setcookie('tg_user', '');
  header('Location: index.php');
}

$tg_user = getTelegramUserData();
if ($tg_user !== false) {
  $id = htmlspecialchars($tg_user['id']);
  $username = htmlspecialchars($tg_user['username']);
  $first_name = htmlspecialchars($tg_user['first_name']);
  $last_name = htmlspecialchars($tg_user['last_name']);
  $photo = htmlspecialchars($tg_user['photo_url']);
  $date = date('Y-m-d');
  $role = '3';
  $_SESSION['id'] = $id;
  if (isset($tg_user['username'])) {
    $query = mysqli_query($db, "SELECT * FROM users WHERE id='$id.'");

    if(mysqli_num_rows($query) > 0){
      // does exist
      header('location: index.php');
    }
    else {
      // does not exist
      $sql = "INSERT INTO `users` (`id`, `username`, `firstname`, `lastname`, `role`, `photo`, `date`, `ip`) VALUES ('$id','$username','$first_name','$last_name','$role','$photo', '$date', '$user_ip')";
      if ($db->query($sql) === TRUE) {
          header('location: index.php');
        } else {
          echo "Error: " . $sql . "<br>" . $db->error;
        }
    } 
  } else {
    $html = "<h1>Hello, {$first_name} {$last_name}!</h1>";
  }
  if (isset($tg_user['photo_url'])) {
    $photo_url = htmlspecialchars($tg_user['photo_url']);
    $html .= "<img src=\"{$photo_url}\">";
  }
  $html .= "<p><a href=\"?logout=1\">Log out</a></p>";
} else {
  $bot_username = BOT_USERNAME;
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>/* Explanation in JS tab */

        /* Cool font from Google Fonts! */
        @import url('https://fonts.googleapis.com/css?family=Raleway:900&display=swap');
        
        body {
            margin: 0px;
            background: #000000;
            color: #fff;
        }
        img{
          width: 70%
;
    display: block;
    margin: 0 auto;
        }
        #telegram-login-loginphp_bot{
          display: block;
          margin: 0 auto;
        }

        </style>
</head>
<body>
<!-- Explanation in JS tab -->

<!-- The two texts -->
<div id="container">
  <img src="https://cdn.discordapp.com/attachments/884816091803680858/903043808156069898/Website.gif">
<script async src="https://telegram.org/js/telegram-widget.js?2" data-telegram-login="loginphp_bot" data-size="large" data-auth-url="check_authorization.php"></script>

</div>

<!-- Load Babel -->
<!-- v6 <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script> -->
<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
<!-- Your custom script here -->
<script type="text/babel">
/*
	This pen cleverly utilizes SVG filters to create a "Morphing Text" effect. Essentially, it layers 2 text elements on top of each other, and blurs them depending on which text element should be more visible. Once the blurring is applied, both texts are fed through a threshold filter together, which produces the "gooey" effect. Check the CSS - Comment the #container rule's filter out to see how the blurring works!
*/

const elts = {
	text1: document.getElementById("text1"),
	text2: document.getElementById("text2")
};

// The strings to morph between. You can change these to anything you want!
const texts = [
	"FTID.ART",

];

// Controls the speed of morphing.
const morphTime = 1;
const cooldownTime = 100;

let textIndex = texts.length - 1;
let time = new Date();
let morph = 0;
let cooldown = cooldownTime;

elts.text1.textContent = texts[textIndex % texts.length];
elts.text2.textContent = texts[(textIndex + 1) % texts.length];

function doMorph() {
	morph -= cooldown;
	cooldown = 0;
	
	let fraction = morph / morphTime;
	
	if (fraction > 1) {
		cooldown = cooldownTime;
		fraction = 1;
	}
	
	setMorph(fraction);
}

// A lot of the magic happens here, this is what applies the blur filter to the text.
function setMorph(fraction) {
	// fraction = Math.cos(fraction * Math.PI) / -2 + .5;
	
	elts.text2.style.filter = `blur(${Math.min(8 / fraction - 8, 100)}px)`;
	elts.text2.style.opacity = `${Math.pow(fraction, 0.4) * 100}%`;
	
	fraction = 1 - fraction;
	elts.text1.style.filter = `blur(${Math.min(8 / fraction - 8, 100)}px)`;
	elts.text1.style.opacity = `${Math.pow(fraction, 0.4) * 100}%`;
	
	elts.text1.textContent = texts[textIndex % texts.length];
	elts.text2.textContent = texts[(textIndex + 1) % texts.length];
}

function doCooldown() {
	morph = 0;
	
	elts.text2.style.filter = "";
	elts.text2.style.opacity = "100%";
	
	elts.text1.style.filter = "";
	elts.text1.style.opacity = "0%";
}

// Animation loop, which is called every frame.
function animate() {
	requestAnimationFrame(animate);
	
	let newTime = new Date();
	let shouldIncrementIndex = cooldown > 0;
	let dt = (newTime - time) / 1000;
	time = newTime;
	
	cooldown -= dt;
	
	if (cooldown <= 0) {
		if (shouldIncrementIndex) {
			textIndex++;
		}
		
		doMorph();
	} else {
		doCooldown();
	}
}

// Start the animation.
animate();
</script>

</body>
</html>