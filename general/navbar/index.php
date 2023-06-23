<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.sandbox.google.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

// Start the session
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
if (isset($_POST["email"]) and isset($_POST["password"])) {
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["password"] = $_POST["password"];
    unset($_POST["email"]);
    unset($_POST["password"]);
    header("location: /homepage");
}

$email = $_SESSION["email"];
$password = $_SESSION["password"];
$restaurant_id = "";

// Check the account exists and get data of the restaurant
$sql_exist = "SELECT * FROM restaurants WHERE `email` = '$email'";
$exist_result = mysqli_query($conn, $sql_exist);

if (mysqli_num_rows($exist_result) > 0) {
    while ($exist = mysqli_fetch_assoc($exist_result)) {
        // Now check if the password is correct
        if ($exist["password"] != $password) {
            // The password is not correct so redirect to login
            $_SESSION["error"] = "Incorrect password.";
            header("location: /login");
            exit();
        }
        // else, the password is correct so it's ok to continue and get the data of the restaurant
        $restaurant_id = $exist["ID"];
        $restaurant_name = $exist["name"];
        $restaurant_email = $exist["email"];
        $restaurant_date_added = $exist["date_added"];
        $restaurant_manager = $exist["manager"];
        $restaurant_language = $exist["language"];
        $restaurant_status = $exist["status"];
    }
} else {
    // the email is not registered in the system, so redirect to login
    $_SESSION["error"] = "This Email is not registered.";
    header("location: /login");
    exit();
}
// else, the password is correct so it's ok to continue
//get order table
$sql_orders = "SELECT * FROM `orders`";
$orders_result = mysqli_query($conn, $sql_orders);

if (isset($_POST["new_ingredient"])) {
    $ingredient_name = $_POST["new_ingredient"];
    $query =
        "INSERT INTO `magazzino`(`ID`, `nome`, `quantità`, `resturant_id`, `date_added`) VALUES ('','" .
        $ingredient_name .
        "','0','" .
        $restaurant_id .
        "','" .
        date("Y-m-d H:i:s") .
        "')";
    mysqli_query($conn, $query);
}

function nav4($n)
{
    // home generale

    if ($n == 1) {
        echo '    <nav class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 navbar-light bg-white border-bottom border-bottom-lg-0 border-end-lg scrollbar" id="sidebar">
            <div class="container-fluid">
               <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button> <a class="navbar-brand d-inline-block py-lg-2 mb-lg-5 px-lg-6 me-0" href="/"></a>
               <div class="navbar-user d-lg-none">
                  <div class="dropdown">
                     <a href="#" id="sidebarAvatar" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar-parent-child"> <span class="avatar-child avatar-badge bg-success"></span></div>
                     </a>
                     <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarAvatar">
                        <a href="#" class="dropdown-item">Profile</a> <a href="#" class="dropdown-item">Settings</a> <a href="#" class="dropdown-item">Billing</a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item">Logout</a>
                     </div>
                  </div>
               </div>
               <div class="collapse navbar-collapse" id="sidebarCollapse">
                  <ul class="navbar-nav">
                      <h4 style=" margin-left: 2rem; color: #06c"  ><a href="http://michele-media.it/general/" style="color: black">Home</a></h4>
                     
                      
                 
                  </ul>
                  <hr class="navbar-divider my-4 opacity-70">
                  <ul class="navbar-nav">
                    <a style="padding:0 !important; margin-right:10px" class="nav-link" href="#catering" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"> <span style="margin-left:30px; color:#4361ee" class="material-symbols-outlined">
restaurant_menu
</span> <li><span  style="color: black !important; font-size:14px !important;" class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide">Catering </span></li></a>
                             <div class="collapse" id="catering">
                     <li class="nav-item">
                        <a  style="margin-left:19px" class="nav-link" href="#sidebar-projects" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-projects"><span style="margin-right:10px; color:#4361ee" class="material-symbols-outlined">
lunch_dining
</span> Cucina </a>
                        <div class="collapse" id="sidebar-projects">
                           <ul class="nav nav-sm flex-column">
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/ordini-tutti/" class="nav-link">Cucina</a></li>
                              <li  style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/tavoli-camerieri-mfwaiter/" class="nav-link">Camerieri</a></li>
                              <li  style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/cassa/" class="nav-link">Cassa</a></li>
                              
                           </ul>
                           
                        </div>
                     
                       <li class="nav-item">
                        <a  style="margin-left:19px"  class="nav-link" href="#sidebar-integrationss" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><span style="margin-right:10px; color:#4361ee" class="material-symbols-outlined">
menu_book
</span>Ristorazione</a>
                        <div class="collapse" id="sidebar-integrationss">
                           <ul class="nav nav-sm flex-column">
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/control-panel/menu-control/" class="nav-link">I tuoi menù</a></li>
                              <li  style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/control-panel/code-control/" class="nav-link">I tuoi QR-code</a></li>
                           </ul>
                        </div>
                     </li></div>
                  </ul>
                   <hr class="navbar-divider my-4 opacity-70">
                   
                  <ul class="navbar-nav">
                  
                      <a style="padding:0 !important; margin-right:10px" class="nav-link" href="#magazzino" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"><span style="margin-left:30px; color:#f4415a"  class="material-symbols-outlined">
inventory_2
</span><li><span class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide" style="color: black !important; font-size:14px !important;" >Magazzino</span></li>       </a>
            
                 
                        <div class="collapse" id="magazzino">
                     <li class="nav-item">
                        <a style="margin-left:19px" class="nav-link" href="#magazzino-generale" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-projects"><i style="margin-right:10px; color:#f4415a" class="material-icons" >manage_accounts</i> Generale</a>
                        <div class="collapse" id="magazzino-generale">
                           <ul class="nav nav-sm flex-column">
                                  <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=22" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=22" class="nav-link">Visualizza</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/manage/?id=22" class="nav-link">Manage</a></li>
                               <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/edit/?id=22" class="nav-link">Rifornimento</a></li>
                         
                              
                           </ul> 
                           
                        </div>
                        <li class="nav-item">
                        <a style="margin-left:19px"   class="nav-link" href="#magazzino-hotel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"><i  style="margin-right:10px; color:#f4415a" class="material-icons">bedroom_parent</i> Hotel
                        </a>
                        <div class="collapse" id="magazzino-hotel">
                           <ul class="nav nav-sm flex-column">
                                             <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=23" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=23" class="nav-link">Visualizza</a></li>
                             
                           </ul>
                        </div>
                     </li>
                       <li class="nav-item">
                        <a style="margin-left:19px"  class="nav-link" href="#magazzino-bar" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="margin-right:10px; color:#f4415a" class="material-icons">nightlife</i>Bar</a>
                        <div class="collapse" id="magazzino-bar">
                           <ul class="nav nav-sm flex-column">
                             <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=24" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=24" class="nav-link">Visualizza</a></li>
                           </ul>
                        </div>
                     </li>
                      <li class="nav-item">
                        <a style="margin-left:19px"  class="nav-link" href="#magazzino-spa" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="margin-right:10px; color:#f4415a" class="material-icons">hot_tub</i>Spa</a>
                        <div class="collapse" id="magazzino-spa">
                           <ul class="nav nav-sm flex-column">
    <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=24" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=24" class="nav-link">Visualizza</a></li>
                           </ul>
                        </div>
                     </li>
                         <li class="nav-item">
                        <a style="margin-left:19px"  class="nav-link" href="#magazzino-beach" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="margin-right:10px; color:#f4415a" class="material-icons">beach_access</i>beach</a>
                        <div class="collapse" id="magazzino-beach">
                           <ul class="nav nav-sm flex-column">
                         <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=26" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=26" class="nav-link">Visualizza</a></li>
                           </ul>
                        </div>
                     </li>
                                </div>
                  </ul>
       
                <hr class="navbar-divider my-4 opacity-70">
                   
                  <ul class="navbar-nav">
                  
                      <a style="padding:0 !important; margin-right:10px" class="nav-link" href="#profilo" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"><span style="margin-left:30px; color:#d17b24"  class="material-symbols-outlined">
account_circle
</span><li><span class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide" style="color: black !important; font-size:14px !important;" >Profilo</span></li>       </a>
            
                 
                        <div class="collapse" id="profilo">
                     <li class="nav-item">
                        <a style="margin-left:19px" class="nav-link" href="#statistiche" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-projects"><i style="margin-right:10px; color:#f4415a" class="material-icons" >manage_accounts</i> Statistiche</a>
                        <div class="collapse" id="statistiche">
                           <ul class="nav nav-sm flex-column">
                                  <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=22" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=22" class="nav-link">Visualizza</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/manage/?id=22" class="nav-link">Manage</a></li>
                               <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/edit/?id=22" class="nav-link">Rifornimento</a></li>
                         
                              
                           </ul> 
                           
                        </div>
                        <li class="nav-item">
                        <a style="margin-left:19px"   class="nav-link" href="#Assistenza" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"><i  style="margin-right:10px; color:#f4415a" class="material-icons">bedroom_parent</i> Assistenza
                        </a>
                        <div class="collapse" id="Assistenza">
                           <ul class="nav nav-sm flex-column">
                                             <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=23" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=23" class="nav-link">Visualizza</a></li>
                             
                           </ul>
                        </div>
                     </li>
                       <li class="nav-item">
                        <a style="margin-left:19px"  class="nav-link" href="#TechOrder" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="margin-right:10px; color:#f4415a" class="material-icons">nightlife</i>TechOrder</a>
                        <div class="collapse" id="TechOrder">
                           <ul class="nav nav-sm flex-column">
                             <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=24" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=24" class="nav-link">Visualizza</a></li>
                           </ul>
                        </div>
                     </li>
                    
                                </div>
                  </ul>

            </div>
         </nav>';
    }
    // Navigazione magazzino
    if ($n == 2) {
        echo '    <nav class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 navbar-light bg-white border-bottom border-bottom-lg-0 border-end-lg scrollbar" id="sidebar">
            <div class="container-fluid">
               <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button> <a class="navbar-brand d-inline-block py-lg-2 mb-lg-5 px-lg-6 me-0" href="/"></a>
               <div class="navbar-user d-lg-none">
                  <div class="dropdown">
                     <a href="#" id="sidebarAvatar" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar-parent-child"> <span class="avatar-child avatar-badge bg-success"></span></div>
                     </a>
                     <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarAvatar">
                        <a href="#" class="dropdown-item">Profile</a> <a href="#" class="dropdown-item">Settings</a> <a href="#" class="dropdown-item">Billing</a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item">Logout</a>
                     </div>
                  </div>
               </div>
               <div class="collapse navbar-collapse" id="sidebarCollapse">
                  <ul class="navbar-nav">
                      <h4 style=" margin-left: 2rem; color: #06c"  ><a href="http://michele-media.it/general/" style="color: black">Home Magazzino</a></h4>
                     
                      
                 
                  </ul>
                  <hr class="navbar-divider my-4 opacity-70">
                  <ul class="navbar-nav">
                    <a style="padding:0 !important; margin-right:10px" class="nav-link" href="#catering" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"> <span style="margin-left:30px; color:#4361ee" class="material-symbols-outlined">
restaurant_menu
</span> <li><span  style="color: black !important; font-size:14px !important;" class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide">Catering </span></li></a>
                             <div class="collapse" id="catering">
                     <li class="nav-item">
                        <a  style="margin-left:19px" class="nav-link" href="#sidebar-projects" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-projects"><span style="margin-right:10px; color:#4361ee" class="material-symbols-outlined">
lunch_dining
</span> Cucina Hotel</a>
                        <div class="collapse" id="sidebar-projects">
                           <ul class="nav nav-sm flex-column">
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/ordini-tutti/" class="nav-link">Cucina</a></li>
                              <li  style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/tavoli-camerieri-mfwaiter/" class="nav-link">Camerieri</a></li>
                              <li  style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/cassa/" class="nav-link">Cassa</a></li>
                              
                           </ul>
                           
                        </div>
                        <li class="nav-item">
                        <a  style="margin-left:19px"  class="nav-link" href="#sidebar-integration" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"><span style="margin-right:10px; color:#4361ee" class="material-symbols-outlined">
tapas
</span>Cucina Spiaggia
                        </a>
                        <div class="collapse" id="sidebar-integration">
                           <ul class="nav nav-sm flex-column">
                                 <li style="color: #515050;margin-left: 20px;"  class="nav-item"><a href="http://michele-media.it/ordini-tutti-pizzeria/" class="nav-link">Cucina</a></li>
                              <li  style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/tavoli-camerieri-mfwaiter/" class="nav-link">Camerieri</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/cassa/" class="nav-link">Cassa</a></li>
                           </ul>
                        </div>
                     </li>
                       <li class="nav-item">
                        <a  style="margin-left:19px"  class="nav-link" href="#sidebar-integrationss" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><span style="margin-right:10px; color:#4361ee" class="material-symbols-outlined">
menu_book
</span>Ristorazione</a>
                        <div class="collapse" id="sidebar-integrationss">
                           <ul class="nav nav-sm flex-column">
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/control-panel/menu-control/" class="nav-link">I tuoi menù</a></li>
                              <li  style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/control-panel/code-control/" class="nav-link">I tuoi QR-code</a></li>
                           </ul>
                        </div>
                     </li></div>
                  </ul>
                   <hr class="navbar-divider my-4 opacity-70">
                   
                  <ul class="navbar-nav">
                  
                      <a style="padding:0 !important; margin-right:10px" class="nav-link" href="#magazzino" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"><span style="margin-left:30px; color:#f4415a"  class="material-symbols-outlined">
inventory_2
</span><li><span class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide" style="color: black !important; font-size:14px !important;" >Magazzino</span></li>       </a>
            
                 
                        <div class="collapse" id="magazzino">
                     <li class="nav-item">
                        <a style="margin-left:19px" class="nav-link" href="#magazzino-generale" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-projects"><i style="margin-right:10px; color:#f4415a" class="material-icons" >manage_accounts</i> Generale</a>
                        <div class="collapse" id="magazzino-generale">
                           <ul class="nav nav-sm flex-column">
                                  <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=22" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=22" class="nav-link">Visualizza</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/manage/?id=22" class="nav-link">Manage</a></li>
                               <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/edit/?id=22" class="nav-link">Rifornimento</a></li>
                         
                              
                           </ul> 
                           
                        </div>
                        <li class="nav-item">
                        <a style="margin-left:19px"   class="nav-link" href="#magazzino-hotel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"><i  style="margin-right:10px; color:#f4415a" class="material-icons">bedroom_parent</i> Hotel
                        </a>
                        <div class="collapse" id="magazzino-hotel">
                           <ul class="nav nav-sm flex-column">
                                             <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=23" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=23" class="nav-link">Visualizza</a></li>
                             
                           </ul>
                        </div>
                     </li>
                       <li class="nav-item">
                        <a style="margin-left:19px"  class="nav-link" href="#magazzino-bar" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="margin-right:10px; color:#f4415a" class="material-icons">nightlife</i>Bar</a>
                        <div class="collapse" id="magazzino-bar">
                           <ul class="nav nav-sm flex-column">
                             <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=24" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=24" class="nav-link">Visualizza</a></li>
                           </ul>
                        </div>
                     </li>
                      <li class="nav-item">
                        <a style="margin-left:19px"  class="nav-link" href="#magazzino-spa" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="margin-right:10px; color:#f4415a" class="material-icons">hot_tub</i>Spa</a>
                        <div class="collapse" id="magazzino-spa">
                           <ul class="nav nav-sm flex-column">
    <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=24" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=24" class="nav-link">Visualizza</a></li>
                           </ul>
                        </div>
                     </li>
                         <li class="nav-item">
                        <a style="margin-left:19px"  class="nav-link" href="#magazzino-beach" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="margin-right:10px; color:#f4415a" class="material-icons">beach_access</i>beach</a>
                        <div class="collapse" id="magazzino-beach">
                           <ul class="nav nav-sm flex-column">
                         <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=26" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=26" class="nav-link">Visualizza</a></li>
                           </ul>
                        </div>
                     </li>
                                </div>
                  </ul>
       
                  <hr class="navbar-divider my-4 opacity-70">
                  <ul class="navbar-nav">
                    <a style="padding:0 !important; margin-right:10px" class="nav-link" href="#hotel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"> <span style="margin-left:30px; color: #ca6702;"  class="material-symbols-outlined">
hotel
</span><li><span style="color: black !important; font-size:14px !important;"  class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide">Hotel </span></li></a>
                    <div class="collapse" id="hotel">
                    <li style="margin-left:19px" class="nav-item"><a href="http://michele-media.it/general/hotel-panel/rooms/" class="nav-link"><span style="margin-right:10px; color: #ca6702;"  class="material-symbols-outlined">meeting_room</span>Camere</a></li>
                              <li style="margin-left:19px" class="nav-item"><a href="http://michele-media.it/general/hotel-panel/clients/" class="nav-link">  <span style="margin-right:10px; color: #ca6702;"  class="material-symbols-outlined">location_away</span> Clienti</a></li>
                    
                
                       <li class="nav-item">
                        <a style="margin-left:19px" class="nav-link" href="#sidebar-integrationss" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="color: #ca6702; font-size:17px" class="material-icons">cloud</i>Channel manager</a>
                        <div class="collapse" id="sidebar-integrationss">
                           <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="http://michele-media.it/general/control-panel/menu-control/" class="nav-link">prenotazioni</a></li>
                              <li class="nav-item"><a href="http://michele-media.it/general/control-panel/code-control/" class="nav-link">calendario</a></li>
                           </ul>
                        </div>
                     </li>
                     </div>
                  </ul>
                   <hr class="navbar-divider my-4 opacity-70">
                  <ul class="navbar-nav">
                  
                    <a style="padding:0 !important; margin-right:10px" class="nav-link" href="#profile" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"> <span style="margin-left:30px; color:#9f9b9c" class="material-symbols-outlined">
account_circle
</span> <li><span style="color: black !important; font-size:14px !important;"  class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide">Profilo</span></li> </a>
                    
                    <div class="collapse" id="profile">
                    
                              <li style="margin-left:19px" class="nav-item"><a href="http://michele-media.it/general/user/profile/" class="nav-link">Profilo</a></li>
                              <li style="margin-left:19px" class="nav-item"><a href="" class="nav-link">Statistiche</a></li>
                              <li style="margin-left:19px" class="nav-item"><a href="" class="nav-link">Assistenza</a>
                               <li style="margin-left:19px"  class="nav-item"><a href="http://mf-digital.com/" class="nav-link">MFDigital</a>
                              </div>
                           </ul>
                 
                  <div class="mt-auto"></div>
                  <div class="my-4 px-lg-6 position-relative">
                     
                     <div class="d-flex gap-3 justify-content-center align-items-center mt-6 d-none">
                        <div><i class="bi bi-moon-stars me-2 text-warning me-2"></i> <span class="text-heading text-sm font-bold">Dark mode</span></div>
                        <div class="ms-auto">
                           <div class="form-check form-switch me-n2"><input class="form-check-input" type="checkbox" id="switch-dark-mode"></div>
                   
                     </div>
                  </div>
               </div>
            </div>
         </nav>';
    }
    // navigazione Hotel
    if ($n == 3) {
        echo '    <nav class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 navbar-light bg-white border-bottom border-bottom-lg-0 border-end-lg scrollbar" id="sidebar">
            <div class="container-fluid">
               <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button> <a class="navbar-brand d-inline-block py-lg-2 mb-lg-5 px-lg-6 me-0" href="/"></a>
               <div class="navbar-user d-lg-none">
                  <div class="dropdown">
                     <a href="#" id="sidebarAvatar" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar-parent-child"> <span class="avatar-child avatar-badge bg-success"></span></div>
                     </a>
                     <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarAvatar">
                        <a href="#" class="dropdown-item">Profile</a> <a href="#" class="dropdown-item">Settings</a> <a href="#" class="dropdown-item">Billing</a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item">Logout</a>
                     </div>
                  </div>
               </div>
               <div class="collapse navbar-collapse" id="sidebarCollapse">
                  <ul class="navbar-nav">
                      <h4 style=" margin-left: 2rem; color: #06c"  ><a href="http://michele-media.it/general/" style="color: black">Home Hotel</a></h4>
                     
                      
                 
                  </ul>
                  <hr class="navbar-divider my-4 opacity-70">
                  <ul class="navbar-nav">
                    <a style="padding:0 !important; margin-right:10px" class="nav-link" href="#catering" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"> <span style="margin-left:30px; color:#4361ee" class="material-symbols-outlined">
restaurant_menu
</span> <li><span  style="color: black !important; font-size:14px !important;" class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide">Catering </span></li></a>
                             <div class="collapse" id="catering">
                     <li class="nav-item">
                        <a  style="margin-left:19px" class="nav-link" href="#sidebar-projects" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-projects"><span style="margin-right:10px; color:#4361ee" class="material-symbols-outlined">
lunch_dining
</span> Cucina Hotel</a>
                        <div class="collapse" id="sidebar-projects">
                           <ul class="nav nav-sm flex-column">
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/ordini-tutti/" class="nav-link">Cucina</a></li>
                              <li  style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/tavoli-camerieri-mfwaiter/" class="nav-link">Camerieri</a></li>
                              <li  style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/cassa/" class="nav-link">Cassa</a></li>
                              
                           </ul>
                           
                        </div>
                        <li class="nav-item">
                        <a  style="margin-left:19px"  class="nav-link" href="#sidebar-integration" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"><span style="margin-right:10px; color:#4361ee" class="material-symbols-outlined">
tapas
</span>Cucina Spiaggia
                        </a>
                        <div class="collapse" id="sidebar-integration">
                           <ul class="nav nav-sm flex-column">
                                 <li style="color: #515050;margin-left: 20px;"  class="nav-item"><a href="http://michele-media.it/ordini-tutti-pizzeria/" class="nav-link">Cucina</a></li>
                              <li  style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/tavoli-camerieri-mfwaiter/" class="nav-link">Camerieri</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/cassa/" class="nav-link">Cassa</a></li>
                           </ul>
                        </div>
                     </li>
                       <li class="nav-item">
                        <a  style="margin-left:19px"  class="nav-link" href="#sidebar-integrationss" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><span style="margin-right:10px; color:#4361ee" class="material-symbols-outlined">
menu_book
</span>Ristorazione</a>
                        <div class="collapse" id="sidebar-integrationss">
                           <ul class="nav nav-sm flex-column">
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/control-panel/menu-control/" class="nav-link">I tuoi menù</a></li>
                              <li  style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/control-panel/code-control/" class="nav-link">I tuoi QR-code</a></li>
                           </ul>
                        </div>
                     </li></div>
                  </ul>
                   <hr class="navbar-divider my-4 opacity-70">
                   
                  <ul class="navbar-nav">
                  
                      <a style="padding:0 !important; margin-right:10px" class="nav-link" href="#magazzino" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"><span style="margin-left:30px; color:#f4415a"  class="material-symbols-outlined">
inventory_2
</span><li><span class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide" style="color: black !important; font-size:14px !important;" >Magazzino</span></li>       </a>
            
                 
                        <div class="collapse" id="magazzino">
                     <li class="nav-item">
                        <a style="margin-left:19px" class="nav-link" href="#magazzino-generale" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-projects"><i style="margin-right:10px; color:#f4415a" class="material-icons" >manage_accounts</i> Generale</a>
                        <div class="collapse" id="magazzino-generale">
                           <ul class="nav nav-sm flex-column">
                                  <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=22" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=22" class="nav-link">Visualizza</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/manage/?id=22" class="nav-link">Manage</a></li>
                               <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/edit/?id=22" class="nav-link">Rifornimento</a></li>
                         
                              
                           </ul> 
                           
                        </div>
                        <li class="nav-item">
                        <a style="margin-left:19px"   class="nav-link" href="#magazzino-hotel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"><i  style="margin-right:10px; color:#f4415a" class="material-icons">bedroom_parent</i> Hotel
                        </a>
                        <div class="collapse" id="magazzino-hotel">
                           <ul class="nav nav-sm flex-column">
                                             <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=23" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=23" class="nav-link">Visualizza</a></li>
                             
                           </ul>
                        </div>
                     </li>
                       <li class="nav-item">
                        <a style="margin-left:19px"  class="nav-link" href="#magazzino-bar" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="margin-right:10px; color:#f4415a" class="material-icons">nightlife</i>Bar</a>
                        <div class="collapse" id="magazzino-bar">
                           <ul class="nav nav-sm flex-column">
                             <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=24" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=24" class="nav-link">Visualizza</a></li>
                           </ul>
                        </div>
                     </li>
                      <li class="nav-item">
                        <a style="margin-left:19px"  class="nav-link" href="#magazzino-spa" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="margin-right:10px; color:#f4415a" class="material-icons">hot_tub</i>Spa</a>
                        <div class="collapse" id="magazzino-spa">
                           <ul class="nav nav-sm flex-column">
    <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=24" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=24" class="nav-link">Visualizza</a></li>
                           </ul>
                        </div>
                     </li>
                         <li class="nav-item">
                        <a style="margin-left:19px"  class="nav-link" href="#magazzino-beach" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="margin-right:10px; color:#f4415a" class="material-icons">beach_access</i>beach</a>
                        <div class="collapse" id="magazzino-beach">
                           <ul class="nav nav-sm flex-column">
                         <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=26" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=26" class="nav-link">Visualizza</a></li>
                           </ul>
                        </div>
                     </li>
                                </div>
                  </ul>
       
                  <hr class="navbar-divider my-4 opacity-70">
                  <ul class="navbar-nav">
                    <a style="padding:0 !important; margin-right:10px" class="nav-link" href="#hotel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"> <span style="margin-left:30px; color: #ca6702;"  class="material-symbols-outlined">
hotel
</span><li><span style="color: black !important; font-size:14px !important;"  class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide">Hotel </span></li></a>
                    <div class="collapse" id="hotel">
                    <li style="margin-left:19px" class="nav-item"><a href="http://michele-media.it/general/hotel-panel/rooms/" class="nav-link"><span style="margin-right:10px; color: #ca6702;"  class="material-symbols-outlined">meeting_room</span>Camere</a></li>
                              <li style="margin-left:19px" class="nav-item"><a href="http://michele-media.it/general/hotel-panel/clients/" class="nav-link">  <span style="margin-right:10px; color: #ca6702;"  class="material-symbols-outlined">location_away</span> Clienti</a></li>
                    
                
                       <li class="nav-item">
                        <a style="margin-left:19px" class="nav-link" href="#sidebar-integrationss" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="color: #ca6702; font-size:17px" class="material-icons">cloud</i>Channel manager</a>
                        <div class="collapse" id="sidebar-integrationss">
                           <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="http://michele-media.it/general/control-panel/menu-control/" class="nav-link">prenotazioni</a></li>
                              <li class="nav-item"><a href="http://michele-media.it/general/control-panel/code-control/" class="nav-link">calendario</a></li>
                           </ul>
                        </div>
                     </li>
                     </div>
                  </ul>
                   <hr class="navbar-divider my-4 opacity-70">
                  <ul class="navbar-nav">
                  
                    <a style="padding:0 !important; margin-right:10px" class="nav-link" href="#profile" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"> <span style="margin-left:30px; color:#9f9b9c" class="material-symbols-outlined">
account_circle
</span> <li><span style="color: black !important; font-size:14px !important;"  class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide">Profilo</span></li> </a>
                    
                    <div class="collapse" id="profile">
                    
                              <li style="margin-left:19px" class="nav-item"><a href="http://michele-media.it/general/user/profile/" class="nav-link">Profilo</a></li>
                              <li style="margin-left:19px" class="nav-item"><a href="" class="nav-link">Statistiche</a></li>
                              <li style="margin-left:19px" class="nav-item"><a href="" class="nav-link">Assistenza</a>
                               <li style="margin-left:19px"  class="nav-item"><a href="http://mf-digital.com/" class="nav-link">MFDigital</a>
                              </div>
                           </ul>
                 
                  <div class="mt-auto"></div>
                  <div class="my-4 px-lg-6 position-relative">
                     
                     <div class="d-flex gap-3 justify-content-center align-items-center mt-6 d-none">
                        <div><i class="bi bi-moon-stars me-2 text-warning me-2"></i> <span class="text-heading text-sm font-bold">Dark mode</span></div>
                        <div class="ms-auto">
                           <div class="form-check form-switch me-n2"><input class="form-check-input" type="checkbox" id="switch-dark-mode"></div>
                   
                     </div>
                  </div>
               </div>
            </div>
         </nav>';
    } // Navigazione Ristorazione
    if ($n == 4) {
        echo '    <nav class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 navbar-light bg-white border-bottom border-bottom-lg-0 border-end-lg scrollbar" id="sidebar">
            <div class="container-fluid">
               <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button> <a class="navbar-brand d-inline-block py-lg-2 mb-lg-5 px-lg-6 me-0" href="/"></a>
               <div class="navbar-user d-lg-none">
                  <div class="dropdown">
                     <a href="#" id="sidebarAvatar" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar-parent-child"> <span class="avatar-child avatar-badge bg-success"></span></div>
                     </a>
                     <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarAvatar">
                        <a href="#" class="dropdown-item">Profile</a> <a href="#" class="dropdown-item">Settings</a> <a href="#" class="dropdown-item">Billing</a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item">Logout</a>
                     </div>
                  </div>
               </div>
               <div class="collapse navbar-collapse" id="sidebarCollapse">
                  <ul class="navbar-nav">
                      <h4 style=" margin-left: 2rem; color: #06c"  ><a href="http://michele-media.it/general/" style="color: black">Home Catering</a></h4>
                     
                      
                 
                  </ul>
                  <hr class="navbar-divider my-4 opacity-70">
                  <ul class="navbar-nav">
                    <a style="padding:0 !important; margin-right:10px" class="nav-link" href="#catering" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"> 
                    <span style="margin-left:30px; color:#4361ee" class="material-symbols-outlined">restaurant_menu</span> 
                    
                    <li><span  style="color: black !important; font-size:14px !important;" class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide">Catering </span></li></a>
                             <div class="collapse" id="catering">
                     <li class="nav-item">
                        <a  style="margin-left:19px" class="nav-link" href="#sidebar-projects" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-projects"><span style="margin-right:10px; color:#4361ee" class="material-symbols-outlined">lunch_dining</span> Cucina Hotel</a>
                        <div class="collapse" id="sidebar-projects">
                           <ul class="nav nav-sm flex-column">
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/ordini-tutti/" class="nav-link">Cucina</a></li>
                              <li  style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/tavoli-camerieri-mfwaiter/" class="nav-link">Camerieri</a></li>
                              <li  style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/cassa/" class="nav-link">Cassa</a></li>
                           </ul>
                        </div>
                        
                     
                       <li class="nav-item">
                        <a  style="margin-left:19px"  class="nav-link" href="#sidebar-integrationss" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><span style="margin-right:10px; color:#4361ee" class="material-symbols-outlined">
menu_book
</span>Ristorazione</a>
                        <div class="collapse" id="sidebar-integrationss">
                           <ul class="nav nav-sm flex-column">
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/control-panel/menu-control/" class="nav-link">I tuoi menù</a></li>
                              <li  style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/control-panel/code-control/" class="nav-link">I tuoi QR-code</a></li>
                           </ul>
                        </div>
                     </li></div>
                  </ul>
                   <hr class="navbar-divider my-4 opacity-70">
                   
                  <ul class="navbar-nav">
                  
                      <a style="padding:0 !important; margin-right:10px" class="nav-link" href="#magazzino" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"><span style="margin-left:30px; color:#f4415a"  class="material-symbols-outlined">
inventory_2
</span><li><span class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide" style="color: black !important; font-size:14px !important;" >Magazzino</span></li>       </a>
            
                 
                        <div class="collapse" id="magazzino">
                     <li class="nav-item">
                        <a style="margin-left:19px" class="nav-link" href="#magazzino-generale" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-projects"><i style="margin-right:10px; color:#f4415a" class="material-icons" >manage_accounts</i> Generale</a>
                        <div class="collapse" id="magazzino-generale">
                           <ul class="nav nav-sm flex-column">
                                  <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=22" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=22" class="nav-link">Visualizza</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/manage/?id=22" class="nav-link">Manage</a></li>
                               <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/edit/?id=22" class="nav-link">Rifornimento</a></li>
                         
                              
                           </ul> 
                           
                        </div>
                        <li class="nav-item">
                        <a style="margin-left:19px"   class="nav-link" href="#magazzino-hotel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"><i  style="margin-right:10px; color:#f4415a" class="material-icons">bedroom_parent</i> Hotel
                        </a>
                        <div class="collapse" id="magazzino-hotel">
                           <ul class="nav nav-sm flex-column">
                                             <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=23" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=23" class="nav-link">Visualizza</a></li>
                             
                           </ul>
                        </div>
                     </li>
                       <li class="nav-item">
                        <a style="margin-left:19px"  class="nav-link" href="#magazzino-bar" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="margin-right:10px; color:#f4415a" class="material-icons">nightlife</i>Bar</a>
                        <div class="collapse" id="magazzino-bar">
                           <ul class="nav nav-sm flex-column">
                             <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=24" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=24" class="nav-link">Visualizza</a></li>
                           </ul>
                        </div>
                     </li>
                      <li class="nav-item">
                        <a style="margin-left:19px"  class="nav-link" href="#magazzino-spa" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="margin-right:10px; color:#f4415a" class="material-icons">hot_tub</i>Spa</a>
                        <div class="collapse" id="magazzino-spa">
                           <ul class="nav nav-sm flex-column">
    <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=24" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=24" class="nav-link">Visualizza</a></li>
                           </ul>
                        </div>
                     </li>
                         <li class="nav-item">
                        <a style="margin-left:19px"  class="nav-link" href="#magazzino-beach" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="margin-right:10px; color:#f4415a" class="material-icons">beach_access</i>beach</a>
                        <div class="collapse" id="magazzino-beach">
                           <ul class="nav nav-sm flex-column">
                         <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=26" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=26" class="nav-link">Visualizza</a></li>
                           </ul>
                        </div>
                     </li>
                                </div>
                  </ul>
       
                  <hr class="navbar-divider my-4 opacity-70">
                  <ul class="navbar-nav">
                    <a style="padding:0 !important; margin-right:10px" class="nav-link" href="#hotel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"> <span style="margin-left:30px; color: #ca6702;"  class="material-symbols-outlined">
hotel
</span><li><span style="color: black !important; font-size:14px !important;"  class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide">Hotel </span></li></a>
                    <div class="collapse" id="hotel">
                    <li style="margin-left:19px" class="nav-item"><a href="http://michele-media.it/general/hotel-panel/rooms/" class="nav-link"><span style="margin-right:10px; color: #ca6702;"  class="material-symbols-outlined">meeting_room</span>Camere</a></li>
                              <li style="margin-left:19px" class="nav-item"><a href="http://michele-media.it/general/hotel-panel/clients/" class="nav-link">  <span style="margin-right:10px; color: #ca6702;"  class="material-symbols-outlined">location_away</span> Clienti</a></li>
                    
                
                       <li class="nav-item">
                        <a style="margin-left:19px" class="nav-link" href="#sidebar-integrationss" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="color: #ca6702; font-size:17px" class="material-icons">cloud</i>Channel manager</a>
                        <div class="collapse" id="sidebar-integrationss">
                           <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="http://michele-media.it/general/control-panel/menu-control/" class="nav-link">prenotazioni</a></li>
                              <li class="nav-item"><a href="http://michele-media.it/general/control-panel/code-control/" class="nav-link">calendario</a></li>
                           </ul>
                        </div>
                     </li>
                     </div>
                  </ul>
                   <hr class="navbar-divider my-4 opacity-70">
                  <ul class="navbar-nav">
                  
                    <a style="padding:0 !important; margin-right:10px" class="nav-link" href="#profile" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"> <span style="margin-left:30px; color:#9f9b9c" class="material-symbols-outlined">
account_circle
</span> <li><span style="color: black !important; font-size:14px !important;"  class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide">Profilo</span></li> </a>
                    
                    <div class="collapse" id="profile">
                    
                              <li style="margin-left:19px" class="nav-item"><a href="http://michele-media.it/general/user/profile/" class="nav-link">Profilo</a></li>
                              <li style="margin-left:19px" class="nav-item"><a href="" class="nav-link">Statistiche</a></li>
                              <li style="margin-left:19px" class="nav-item"><a href="" class="nav-link">Assistenza</a>
                               <li style="margin-left:19px"  class="nav-item"><a href="http://mf-digital.com/" class="nav-link">MFDigital</a>
                              </div>
                           </ul>
                 
                  <div class="mt-auto"></div>
                  <div class="my-4 px-lg-6 position-relative">
                     
                     <div class="d-flex gap-3 justify-content-center align-items-center mt-6 d-none">
                        <div><i class="bi bi-moon-stars me-2 text-warning me-2"></i> <span class="text-heading text-sm font-bold">Dark mode</span></div>
                        <div class="ms-auto">
                           <div class="form-check form-switch me-n2"><input class="form-check-input" type="checkbox" id="switch-dark-mode"></div>
                   
                     </div>
                  </div>
               </div>
            </div>
         </nav>';
    }
    //view-stock
    if ($n == 5) {
        echo '    <nav class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 navbar-light bg-white border-bottom border-bottom-lg-0 border-end-lg scrollbar" id="sidebar">
            <div class="container-fluid">
               <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button> <a class="navbar-brand d-inline-block py-lg-2 mb-lg-5 px-lg-6 me-0" href="/"></a>
               <div class="navbar-user d-lg-none">
                  <div class="dropdown">
                     <a href="#" id="sidebarAvatar" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar-parent-child"> <span class="avatar-child avatar-badge bg-success"></span></div>
                     </a>
                     <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarAvatar">
                        <a href="#" class="dropdown-item">Profile</a> <a href="#" class="dropdown-item">Settings</a> <a href="#" class="dropdown-item">Billing</a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item">Logout</a>
                     </div>
                  </div>
               </div>
               <div class="collapse navbar-collapse" id="sidebarCollapse">
                  <ul class="navbar-nav">
                      <h4 style=" margin-left: 2rem; color: #06c"  ><a href="http://michele-media.it/general/" style="color: black">Home View-Stock</a></h4>
                     
                      
                 
                  </ul>
                  <hr class="navbar-divider my-4 opacity-70">
                  <ul class="navbar-nav">
                    <a style="padding:0 !important; margin-right:10px" class="nav-link" href="#catering" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"> <span style="margin-left:30px; color:#4361ee" class="material-symbols-outlined">
restaurant_menu
</span> <li>
<span  style="color: black !important; font-size:14px !important;" class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide">Catering </span></li></a>
                             <div class="collapse" id="catering">
                     <li class="nav-item">
                        <a  style="margin-left:19px" class="nav-link" href="#sidebar-projects" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-projects"><span style="margin-right:10px; color:#4361ee" class="material-symbols-outlined">
lunch_dining
</span> Cucina Hotel</a>
                        <div class="collapse" id="sidebar-projects">
                           <ul class="nav nav-sm flex-column">
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/ordini-tutti/" class="nav-link">Cucina</a></li>
                              <li  style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/tavoli-camerieri-mfwaiter/" class="nav-link">Camerieri</a></li>
                              <li  style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/cassa/" class="nav-link">Cassa</a></li>
                              
                           </ul>
                           
                        </div>
                        <li class="nav-item">
                        <a  style="margin-left:19px"  class="nav-link" href="#sidebar-integration" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"><span style="margin-right:10px; color:#4361ee" class="material-symbols-outlined">tapas
</span>
</span>Ristorazione</a>
                        <div class="collapse" id="sidebar-integrationss">
                           <ul class="nav nav-sm flex-column">
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/control-panel/menu-control/" class="nav-link">I tuoi menù</a></li>
                              <li  style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/control-panel/code-control/" class="nav-link">I tuoi QR-code</a></li>
                           </ul>
                        </div>
                     </li></div>
                  </ul>
                   <hr class="navbar-divider my-4 opacity-70">
                   
                  <ul class="navbar-nav">
                  
                      <a style="padding:0 !important; margin-right:10px" class="nav-link" href="#magazzino" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"><span style="margin-left:30px; color:#f4415a"  class="material-symbols-outlined">
inventory_2
</span><li><span class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide" style="color: black !important; font-size:14px !important;" >Magazzino</span></li>       </a>
            
                 
                        <div class="collapse" id="magazzino">
                     <li class="nav-item">
                        <a style="margin-left:19px" class="nav-link" href="#magazzino-generale" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-projects"><i style="margin-right:10px; color:#f4415a" class="material-icons" >manage_accounts</i> Generale</a>
                        <div class="collapse" id="magazzino-generale">
                           <ul class="nav nav-sm flex-column">
                                  <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=22" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=22" class="nav-link">Visualizza</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/manage/?id=22" class="nav-link">Manage</a></li>
                               <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/edit/?id=22" class="nav-link">Rifornimento</a></li>
                         
                              
                           </ul> 
                           
                        </div>
                        <li class="nav-item">
                        <a style="margin-left:19px"   class="nav-link" href="#magazzino-hotel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"><i  style="margin-right:10px; color:#f4415a" class="material-icons">bedroom_parent</i> Hotel
                        </a>
                        <div class="collapse" id="magazzino-hotel">
                           <ul class="nav nav-sm flex-column">
                                             <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=23" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=23" class="nav-link">Visualizza</a></li>
                             
                           </ul>
                        </div>
                     </li>
                       <li class="nav-item">
                        <a style="margin-left:19px"  class="nav-link" href="#magazzino-bar" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="margin-right:10px; color:#f4415a" class="material-icons">nightlife</i>Bar</a>
                        <div class="collapse" id="magazzino-bar">
                           <ul class="nav nav-sm flex-column">
                             <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=24" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=24" class="nav-link">Visualizza</a></li>
                           </ul>
                        </div>
                     </li>
                      <li class="nav-item">
                        <a style="margin-left:19px"  class="nav-link" href="#magazzino-spa" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="margin-right:10px; color:#f4415a" class="material-icons">hot_tub</i>Spa</a>
                        <div class="collapse" id="magazzino-spa">
                           <ul class="nav nav-sm flex-column">
    <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=24" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=24" class="nav-link">Visualizza</a></li>
                           </ul>
                        </div>
                     </li>
                         <li class="nav-item">
                        <a style="margin-left:19px"  class="nav-link" href="#magazzino-beach" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="margin-right:10px; color:#f4415a" class="material-icons">beach_access</i>beach</a>
                        <div class="collapse" id="magazzino-beach">
                           <ul class="nav nav-sm flex-column">
                         <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/?id=26" class="nav-link">Home</a></li>
                              <li style="color: #515050;margin-left: 20px;" class="nav-item"><a href="http://michele-media.it/general/stock-panel/view/?id=26" class="nav-link">Visualizza</a></li>
                           </ul>
                        </div>
                     </li>
                                </div>
                  </ul>
       
                  <hr class="navbar-divider my-4 opacity-70">
                  <ul class="navbar-nav">
                    <a style="padding:0 !important; margin-right:10px" class="nav-link" href="#hotel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"> <span style="margin-left:30px; color: #ca6702;"  class="material-symbols-outlined">
hotel
</span><li><span style="color: black !important; font-size:14px !important;"  class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide">Hotel </span></li></a>
                    <div class="collapse" id="hotel">
                    <li style="margin-left:19px" class="nav-item"><a href="http://michele-media.it/general/hotel-panel/rooms/" class="nav-link"><span style="margin-right:10px; color: #ca6702;"  class="material-symbols-outlined">meeting_room</span>Camere</a></li>
                              <li style="margin-left:19px" class="nav-item"><a href="http://michele-media.it/general/hotel-panel/clients/" class="nav-link">  <span style="margin-right:10px; color: #ca6702;"  class="material-symbols-outlined">location_away</span> Clienti</a></li>
                    
                
                       <li class="nav-item">
                        <a style="margin-left:19px" class="nav-link" href="#sidebar-integrationss" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrationss"><i style="color: #ca6702; font-size:17px" class="material-icons">cloud</i>Channel manager</a>
                        <div class="collapse" id="sidebar-integrationss">
                           <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="http://michele-media.it/general/control-panel/menu-control/" class="nav-link">prenotazioni</a></li>
                              <li class="nav-item"><a href="http://michele-media.it/general/control-panel/code-control/" class="nav-link">calendario</a></li>
                           </ul>
                        </div>
                     </li>
                     </div>
                  </ul>
                   <hr class="navbar-divider my-4 opacity-70">
                  <ul class="navbar-nav">
                  
                    <a style="padding:0 !important; margin-right:10px" class="nav-link" href="#profile" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-integrations"> <span style="margin-left:30px; color:#9f9b9c" class="material-symbols-outlined">
account_circle
</span> <li><span style="color: black !important; font-size:14px !important;"  class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide">Profilo</span></li> </a>
                    
                    <div class="collapse" id="profile">
                    
                              <li style="margin-left:19px" class="nav-item"><a href="http://michele-media.it/general/user/profile/" class="nav-link">Profilo</a></li>
                              <li style="margin-left:19px" class="nav-item"><a href="" class="nav-link">Statistiche</a></li>
                              <li style="margin-left:19px" class="nav-item"><a href="" class="nav-link">Assistenza</a>
                               <li style="margin-left:19px"  class="nav-item"><a href="http://mf-digital.com/" class="nav-link">MFDigital</a>
                              </div>
                           </ul>
                 
                  <div class="mt-auto"></div>
                  <div class="my-4 px-lg-6 position-relative">
                     
                     <div class="d-flex gap-3 justify-content-center align-items-center mt-6 d-none">
                        <div><i class="bi bi-moon-stars me-2 text-warning me-2"></i> <span class="text-heading text-sm font-bold">Dark mode</span></div>
                        <div class="ms-auto">
                           <div class="form-check form-switch me-n2"><input class="form-check-input" type="checkbox" id="switch-dark-mode"></div>
                   
                     </div>
                  </div>
               </div>
            </div>
         </nav>';
    }
}


?>
