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


//get order table 
$sql_orders = "SELECT * FROM `orders`";
$orders_result = mysqli_query($conn, $sql_orders);

if (isset($_POST['new_ingredient'])){
    $ingredient_name = $_POST['new_ingredient'];
    $query = "INSERT INTO `magazzino`(`ID`, `nome`, `quantità`, `resturant_id`, `date_added`) VALUES ('','".$ingredient_name."','0','".$restaurant_id."','".date("Y-m-d H:i:s")."')";
    mysqli_query($conn, $query);
}




?>
<!doctype html>
<html lang="en" data-theme="dark">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
      <meta name="color-scheme" content="dark light">
      <title>TechOrder</title>
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
      <link rel="stylesheet" type="text/css" href="./main.css">
      <link rel="shortcut icon" href="../../../images/Favicon-tonda.png" type="image/png">
      <link rel="stylesheet" type="text/css" href="./utils.css">
     
   </head>
   <body style="font-family: 'Inter', sans-serif;">
      <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
          <?php
       require "../../navbar/index.php";
nav4(1); ?>
         <div class="flex-lg-1 h-screen overflow-y-lg-auto">
       
            <header>
               <div class="container-fluid">
                  <div class="border-bottom pt-6">
                     <div class="row align-items-center">
                        <div class="col-sm col-12">
                           <h1 class="h2 ls-tight"><span class="d-inline-block me-3"></span><?php echo $restaurant_name ?></h1>
                        </div>
                        <div class="col-sm-auto col-12 mt-4 mt-sm-0">
                        
                        </div>
                     </div>
                   
                  </div>
               </div>
            </header>
            <main class="py-6 bg-surface-secondary">
          
               <div class="modal fade" id="modalExport" tabindex="-1" aria-labelledby="modalExport" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content shadow-3">
                        <div class="modal-header">
                           <div class="icon icon-shape rounded-3 bg-soft-primary text-primary text-lg me-4"><i class="bi bi-globe"></i></div>
                           <div>
                              <h5 class="mb-1">Share to web</h5>
                              <small class="d-block text-xs text-muted">Publish and share link with anyone</small>
                           </div>
                           <div class="ms-auto">
                              <div class="form-check form-switch me-n2"><input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked="checked"> <label class="form-check-label" for="flexSwitchCheckChecked"></label></div>
                           </div>
                        </div>
                        <div class="modal-body">
                           <div class="d-flex align-items-center mb-5">
                              <div>
                                 <p class="text-sm">Anyone with this link <span class="font-bold text-heading">can view</span></p>
                              </div>
                              <div class="ms-auto"><a href="#" class="text-sm font-semibold">Settings</a></div>
                           </div>
                           <div>
                              <div class="input-group input-group-inline"><input type="email" class="form-control" placeholder="username" value="https://webpixels.io/your-amazing-link"> <span class="input-group-text"><i class="bi bi-clipboard"></i></span></div>
                              <span class="mt-2 valid-feedback">Looks good!</span>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <div class="me-auto"><a href="#" class="text-sm font-semibold"><i class="bi bi-clipboard me-2"></i>Copy link</a></div>
                           <button type="button" class="btn btn-sm btn-neutral" data-bs-dismiss="modal">Close</button> <button type="button" class="btn btn-sm btn-success">Share file</button>
                        </div>
                     </div>
                  </div>
               </div>
           
               <div class="container-fluid">
                       
                  <div class="row g-6 mb-6">
                   
                     <div class="col-xl-4" style="margin-top:7%">
                            <a style="display:block" href="http://justinbieber.com">   
                      <div class="card">
                             
                           <div class="card-body">
                              <div class="row">
                                 <div class="col"><span class="h6 font-semibold text-muted text-sm d-block mb-2">Ristorazione</span> <span class="h3 font-bold mb-0">Cucina Hotel</span></div>
                                 <div class="col-auto">
                                    <div style="background-color: #ff8c00 !important; " class="icon icon-shape bg-primary text-white text-lg rounded-circle"><i class="material-icons">restaurant_menu</i></div>
                                 </div>
                              </div>
                          
                           </div>
                          
                        </div>
                         </a>
                        <a style="display:block" href="http://justinbieber.com">   
                         <div class="card" style="margin-top:3%">
                       <div class="card-body">
                              <div class="row">
                                 <div class="col"><span class="h6 font-semibold text-muted text-sm d-block mb-2">Utente</span> <span class="h3 font-bold mb-0">Cucina spiaggia </span></div>
                                 <div class="col-auto">
                                    <div style="background-color:#ff8c00 !important" class="icon icon-shape bg-primary text-white text-lg rounded-circle"><i class="material-icons">beach_access</i></div>
                                 </div>
                              </div>
               
                           </div>
                           
                        </div>
                        </a>
                        <a style="display:block" href="http://justinbieber.com">  
                             <div class="card"  style="margin-top:3%">
                          <div class="card-body">
                              <div class="row">
                                 <div class="col"><span class="h6 font-semibold text-muted text-sm d-block mb-2">Magazzino</span> <span class="h3 font-bold mb-0">Gestione magazzino</span></div>
                                 <div class="col-auto">
                                    <div style="background-color: #f4415a !important; " class="icon icon-shape bg-warning text-white text-lg rounded-circle"><i class="material-icons">inventory</i></div>
                                 </div>
                              </div>
             
                           </div>
                           
                        </div>
                        </a>
                        <a style="display:block" href="http://justinbieber.com">  
                         <div class="card" style="margin-top:3%">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col"><span class="h6 font-semibold text-muted text-sm d-block mb-2">Hotel</span> <span class="h3 font-bold mb-0">Gestione Hotel</span></div>
                                 <div class="col-auto">
                                   <div style="background-color:#5c60f3 !important" class="icon icon-shape bg-tertiary text-white text-lg rounded-circle"><i class="material-icons">hotel</i></div>
                                 </div>
                              </div>
                             
                           </div>
                           
                        </div>
                        </a>
                     </div>
                     
                     <div class="col-xl-8">
                        <div class="card h-full">
                           <div class="card-body rounded"  style="border: 1px solid #f400a1">
                              <div class="card-title align-items-center mb-0" >
                                 <h3 style=" text-align: center; margin-bottom: 10px !important" class="mb-0">PRIVATE INFO:</h3>
                          
                              </div>
                              <div class="list-group gap-4">
                                 <div class="list-group-item d-flex align-items-center border rounded shadow p-3 bg-white rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i style=" font-size: 35px; color:#1b4ec7f7;" class="bi bi-person-circle"></i></div>
                                    </div>
                                    <div class="flex-fill"><a href="#" class="d-block h6 font-semibold mb-1">Titolare: </a><span class="d-block text-sm text-muted"><?php echo $restaurant_manager ?></span></span></div>
                                 
                                 </div>
                                 <div class="list-group-item d-flex align-items-center border rounded shadow p-3 bg-white rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i style=" font-size: 35px; color: #1b4ec7f7;"  class="bi bi-shop-window"></i></div>
                                    </div>
                                    <div class="flex-fill"><a href="#" class="d-block h6 font-semibold mb-1">Attività commericale: </a><span class="d-block text-sm text-muted"><?php echo $restaurant_name ?></span></div>
                                    <div class="ms-auto text-end">
                                    
                                    </div>
                                 </div>
                                 <div class="list-group-item d-flex align-items-center border rounded shadow p-3 bg-white rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i style=" font-size: 35px; color: #1b4ec7f7;"  class="bi bi-envelope"></i></div>
                                    </div>
                                    <div class="flex-fill"><a href="#" class="d-block h6 font-semibold mb-1">Mail</a><span class="d-block text-sm text-muted"><?php echo $restaurant_email ?></span></div>
                                    <div class="ms-auto text-end">
                                      
                                       </div>
                                    </div>
                                        <div class="list-group-item d-flex align-items-center border rounded shadow p-3 bg-white rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i style=" font-size: 35px; color:#1b4ec7f7;"  class="bi bi-box-arrow-in-right"></i></div>
                                    </div>
                                    <div class="flex-fill"><a href="#" class="d-block h6 font-semibold mb-1">ID </a><span class="d-block text-sm text-muted"><?php echo $restaurant_id ?></span></div>
                                    <div class="ms-auto text-end">
                                    
                                    </div>
                                    
                                 </div>
                                 <div class="list-group-item d-flex align-items-center border rounded shadow p-3 bg-white rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i style=" font-size: 35px; color: #1b4ec7f7;" class="bi bi-asterisk"></i></div>
                                    </div>
                                    <div class="flex-fill"><a href="#" class="d-block h6 font-semibold mb-1">Date Added </a><span class="d-block text-sm text-muted"><?php echo $restaurant_date_added ?></span></div>
                                 
                                 </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row g-6 mb-6" style="
    margin-left: 6px; margin-top:3%; margin-right:6px
">        
                     <div class="col-xl-3 col-sm-6 col-12" style="margin-top:0;">
                <a style="display:block" href="http://justinbieber.com"> 
                        <div class="card">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col"><span class="h6 font-semibold text-muted text-sm d-block mb-2">Pagina</span> <span class="h3 font-bold mb-0">Gestione Menù</span></div>
                                 <div class="col-auto">
                                    <div style="background-color:#06c !important" class="icon icon-shape bg-tertiary text-white text-lg rounded-circle"><i class="material-icons">menu_book</i></div>
                                 </div>
                              </div>
                              <div class="mt-2 mb-0 text-sm"><span class="text-nowrap text-xs text-muted">Since last month</span></div>
                           </div>
                        </div>
                        </a>
                     </div>
                     
                     <div class="col-xl-3 col-sm-6 col-12" style="margin-top:0;">
                         <a style="display:block" href="http://justinbieber.com"> 
                        <div class="card">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col"><span class="h6 font-semibold text-muted text-sm d-block mb-2">Pagina</span> <span class="h3 font-bold mb-0">Gestione Camere</span></div>
                                 <div class="col-auto">
                                    <div style="background-color:#5c60f3 !important" class="icon icon-shape bg-primary text-white text-lg rounded-circle"><i class="material-icons">bed</i></div>
                                 </div>
                              </div>
                              <div class="mt-2 mb-0 text-sm"><span class="text-nowrap text-xs text-muted">Since last week</span></div>
                           </div>
                        </div>
                        </a>
                     </div>
                     <div class="col-xl-3 col-sm-6 col-12" style="margin-top:0;">
                         <a style="display:block" href="http://justinbieber.com"> 
                        <div class="card">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col"><span class="h6 font-semibold text-muted text-sm d-block mb-2">Pagina</span> <span class="h3 font-bold mb-0">Gestione Clienti </span></div>
                                 <div class="col-auto">
                                    <div style="background-color:#f4405a !important;"class="icon icon-shape bg-info text-white text-lg rounded-circle"><i class="material-icons">group_add</i></div>
                                 </div>
                              </div>
                              <div class="mt-2 mb-0 text-sm"><span class="text-nowrap text-xs text-muted">Since last month</span></div>
                           </div>
                        </div>
                        </a>
                     </div>
                     <div class="col-xl-3 col-sm-6 col-12" style="margin-top:0;">
                         <a style="display:block" href="http://justinbieber.com"> 
                        <div class="card">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col"><span class="h6 font-semibold text-muted text-sm d-block mb-2">Pagina</span> <span class="h3 font-bold mb-0">Gestione Codici</span></div>
                                 <div class="col-auto">
                                    <div style="background-color:#06c !important" class="icon icon-shape bg-info text-white text-lg rounded-circle"><i class="bi bi-qr-code-scan" ></i></div>
                                 </div>
                              </div>
                              <div class="mt-2 mb-0 text-sm"><span class="text-nowrap text-xs text-muted">Since last month</span></div>
                           </div>
                        </div>
                     </div>
                   </a>
                  </div>
                 
               </div>
            </main>
         </div>
      </div>
      <script src="./main.js"></script>
   </body>
</html>