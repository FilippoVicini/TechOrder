<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Start the session
session_start();

$servername = "localhost";
$username = "u286027575_mfwaiter";
$password = "Michele14";
$dbname = "u286027575_waiter";


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Look for credentials from post - login page
if((isset($_POST['email'])) AND (isset($_POST['password']))){
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $_POST['password'];
    unset($_POST['email']);
    unset($_POST['password']);
    header("location: /homepage");
}

$email = $_SESSION['email'];
$password = $_SESSION['password'];
$restaurant_id = "";


// Check the account exists and get data of the restaurant

$sql_exist = "SELECT * FROM restaurants WHERE `email` = '$email'";
$exist_result = mysqli_query($conn, $sql_exist);

if (mysqli_num_rows($exist_result) > 0) {
    while($exist = mysqli_fetch_assoc($exist_result)) {
        // Now check if the password is correct
        if($exist['password'] != $password){
            // The password is not correct so redirect to login
            $_SESSION['error'] = "Incorrect password.";
            header("location: /login");
            exit;
        }
        // else, the password is correct so it's ok to continue and get the data of the restaurant
        $restaurant_id = $exist['ID'];
        $restaurant_name = $exist['name'];
        $restaurant_email = $exist['email'];
        $restaurant_date_added = $exist['date_added'];
        $restaurant_manager = $exist['manager'];
        $restaurant_language = $exist['language'];
        $restaurant_status = $exist['status'];
    }
}else{
    // the email is not registered in the system, so redirect to login
    $_SESSION['error'] = "This Email is not registered.";
    header("location: /login");
    exit;
}
// else, the password is correct so it's ok to continue




?>
<head>
 <link rel="stylesheet" href="./styles.css">
 <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <link rel="shortcut icon" href="/images/Favicon-tonda.png" type="image/png"/>
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
 <link href="../../Bootstrap/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="/styles.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        </head>
        <body class="modern">
<html lang="en"><script type="text/javascript">window.loop11ExtTerritory = true;</script><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Inventario Mf-shores</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sidebars/">

    

    <!-- Bootstrap core CSS -->
<link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Favicons -->
<link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
<link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico">
<meta name="theme-color" content="#7952b3">


  

    

  <div class="sidebar close">
    <div class="logo-details">
   <i class="bi bi-globe" style="margin-top:8%"></i>
      <span class="logo_name">MF-Digital</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="/magazzino/index.php">
          <i class="bx bx-grid-alt" ></i>
          <span class="link_name">HomePage</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="magazzino/index.php">HomePage</a></li>
        </ul>
      </li>
       <li>
        <a href="/magazzino/inventario/index.php">
          <i class="bi bi-archive"  style="height:50px; min-width: 78px; text-align: center; line-height: 50px; padding-top: 14px;"></i>
          <span class="link_name" href="/magazzino/inventario/index.php">Inventario</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="/magazzino/inventario/index.php">Inventario</a></li>
        </ul>
      </li>
      <li>
        <a href="/magazzino/rifornimento/index.php">
          <i class="bi bi-arrow-bar-up"  style="height:50px; min-width: 78px; text-align: center; line-height: 50px; padding-top: 14px;"></i>
          <span class="link_name" href="/magazzino/rifornimento/index.php">Rifornimento</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="/magazzino/rifornimento/index.php">Rifornimento</a></li>
        </ul>
      </li>
       
      <li>
        <div class="iocn-link">
          <a href="../../HomeOrdini/">
            <i class="bx bx-collection" ></i>
            <span class="link_name"> Ristorante</span>
          </a>
          <i class="bx bxs-chevron-down arrow" ></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="../../HomeOrdini/">Ristorante</a></li>
          <li><a href="../../selezionare-cucina">Cucina</a></li>
          <li><a href="../../tavoli-camerieri-mfwaiter">Camerieri</a></li>
          <li><a href="../../utente-mfwaiter">Utente</a></li>
          <li><a href="../../cassa">Cassa</a></li>
        </ul>
      </li>
   
      <li>
        <a href="/magazzino/analytics/index.php">
          <i class="bx bx-pie-chart-alt-2" ></i>
          <span class="link_name">Analytics</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="/magazzino/analytics/index.php">Analytics</a></li>
        </ul>
      </li>
     
    
      <li>
        <a href="http://mf-digital.com/">
          <i class="bx bx-compass" ></i>
          <span class="link_name">Esplora</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="http://mf-digital.com/">Esplora</a></li>
        </ul>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-history"></i>
          <span class="link_name">History</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">History</a></li>
        </ul>
      </li>
      
      <li>
    <div class="profile-details">
      <div class="profile-content">
       
      </div>
      <div class="name-job">
        <div class="profile_name"><?php ".$restaurant_name." ?></div>
    
      </div>
      <i href="http://michele-media.it/login/" class="bx bx-log-out" ></i>
    </div>
  </li>
</ul>
  </div>
  <section class="home-section">
    <div class="home-content"> 
      <i class="bx bx-menu" ></i>
  
   
</div>
</center>



<center>
        <div class="MF-DigitalWaiter_title_panel">
            <h1 class="MF-DigitalWaiter_title" style="font-family: Montserrat !important;">Inventario</h1>
        </div>
            <br><p class="MF-DigitalWaiter_subtitle-login" style="text-align:center; margin-top:-30; color: lightgrey;">Developed by:
<a href="https://www.mf-digital.com" class="MF-DigitalWaiter_subtitle-login" style="text-align:center; margin-top:-30; color: lightgrey;"> MF-Digital ®️
</a>
      
        
     
<?php

$query = "SELECT * FROM `magazzino` WHERE `restaurant_id` = ".$restaurant_id;
$ingredients = mysqli_query($conn, $query);

echo '<center style="
    margin-right: 5%;
    margin-left: 5%;
"> ';

while ($ingredient = mysqli_fetch_assoc($ingredients)){
    $name = $ingredient['nome'];
    $quantity = $ingredient['quantità'];
    $id = $ingredient['ID'];
    $qlength = strlen($quantity) + 1;
    echo "         
    <div class=\"piccola_tavoli_fighi\" style=\"display: inline-block; padding-bottom:10px; width:33%;background: white;\">
        <h3 style=\"margin:0\">".$name."
        <span style=\"float:right; margin-top:2%;\">
        </span></h3>
      
        <center >
        <button type=\"button\" class=\"btn btn-primary\">".$quantity."</button>

  
               
        </center>
        </div> ";


}

?>
    </div>
  </section>
  <script>
  let arrow = document.querySelectorAll(".arrow");
  for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e)=>{
   let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
   arrowParent.classList.toggle("showMenu");
    });
  }
  let sidebar = document.querySelector(".sidebar");
  let sidebarBtn = document.querySelector(".bx-menu");
  console.log(sidebarBtn);
  sidebarBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("close");
  });
  </script>