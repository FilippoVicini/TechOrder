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

<html lang="en" data-theme="dark" >
   <head>
           <link rel="shortcut icon" href="../images/Favicon-tonda.png" type="image/png"/>
           <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
      <meta charset="UTF-8">
      <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
      <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
      <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
      <meta name="color-scheme" content="dark light">
      <title>TechOrder</title>
        <link rel="shortcut icon" href="/../../../images/Favicon-tonda.png" type="image/png">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
      <link rel="stylesheet" type="text/css" href="./main.css">
      <link rel="stylesheet" type="text/css" href="./utils.css">
     
   </head>
   <body style="font-family: 'Inter', sans-serif;">
      <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
          <?php
       require "./navbar/index.php";
nav4(1); ?>
         <div class="flex-lg-1 h-screen overflow-y-lg-auto">
       
            <header>
               <div class="container-fluid">
                  <div class="border-bottom pt-6">
                     <div class="row align-items-center">
                        <div class="col-sm col-12">
                           <h1 class="h2 ls-tight"><span class="d-inline-block me-3"></span> <?php echo $restaurant_name ?></h1>
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
                     <div class="col-xl-8">
                        <div class="card">
                           <div class="card-header d-flex align-items-center">
                              <h5 class="mb-0">Orders</h5>
                             
                           </div>
                           <div class="px-4">
                              <div id="chart-line" data-height="300"></div>
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-4">
                        <div class="card h-full">
                           <div class="card-body">
                              <div class="card-title d-flex align-items-center">
                                 <h5 class="mb-0" style="color: #06c">Gestione Ristorazione</h5>
                              
                              </div>
                              <div class="list-group gap-4">
                                 <div class="list-group-item d-flex align-items-center border rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i class="material-icons" style="font-size: 30px; color: #6b7b93">menu_book</i></div>
                                    </div>
                                    <div class="flex-fill"><a href="./control-panel/menu-control/" class="d-block h6 font-semibold mb-1">Menù</a><span class="d-block text-sm text-muted">Per modificare i diversi tipi di menù visti dai clienti e dallo staff</span></div>
                                    <div class="ms-auto text-end">
                                    
                                       </div>
                                    </div>
                                 </div>
                                 <div class="list-group-item d-flex align-items-center border rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i class="bi bi-qr-code-scan" style="font-size: 30px;color:#6b7b93;"></i></div>
                                    </div>
                                    <div class="flex-fill"><a href="./control-panel/code-control/" class="d-block h6 font-semibold mb-1"> Codici</a><span class="d-block text-sm text-muted">La pagina per visulizzare I QR-code/ crearne nuovi e gestirne l'associamento al menù </span></div>
                                    <div class="ms-auto text-end">
                                      
                                    </div>
                                 </div>
                                
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row g-6 mb-6" style="margin-right:2%; margin-left: 2%">
                     <div class="col-xl-3 col-sm-6 col-12">
                   <div class="card"  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#catering-modal">   
                           <div class="card-body">
                              <div class="row">
                                 <div class="col"><span class="h6 font-semibold text-muted text-sm d-block mb-2">Ordinazioni </span> <span class="h3 font-bold mb-0"  >Cucina</span></div>
                                 <div class="col-auto">
                                    <div style="background-color:#5c60f3 !important"class="icon icon-shape bg-tertiary text-white text-lg rounded-circle"><i class="material-icons">menu_book</i></div>
                                 
                                 </div>
                              </div>
                           
                           </div>
                        </div>
                     </div>
                               <div class="modal fade" id="catering-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sezioni Catering</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <button style="margin:10px;"type="button" class="btn btn-secondary" data-bs-dismiss="modal"  onclick="location.href='http://michele-media.it/ordini-tutti/';">Cucina Hotel</button>
          <button style="margin:10px;" type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.href='http://michele-media.it/ordini-tutti-pizzeria/';">Cucina Spiaggia</button>
           <button  style="margin:10px;" type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.href='http://michele-media.it/menu-control/';">Gestione Ristorazione</button>
      </div>
      <div class="modal-footer">
        
       
      </div>
    </div>
  </div>
</div>
                     <div class="col-xl col-sm-6 col-12">
                        <div class="card"  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#magazzino-modal">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col"><span class="h6 font-semibold text-muted text-sm d-block mb-2">Elementi</span> <span class="h3 font-bold mb-0">Ristorazione </span></div>
                                <div class="col-auto">
                                    <div style="background-color: #f4415a !important; " class="icon icon-shape bg-warning text-white text-lg rounded-circle"><i class="material-icons">inventory</i></div>
                                 </div>
                              </div>
               
                           </div>
                        </div>
                     </div>
                                  <div class="modal fade" id="magazzino-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sezioni Magazzino</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.href='http://michele-media.it/general/stock-panel/?id=22';">General</button>
                 <button style="margin:10px;" type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.href='http://michele-media.it/general/stock-panel/?id=23';">Hotel</button>
                   <button style="margin:10px;" type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.href='http://michele-media.it/general/stock-panel/?id=26';">Beach</button>
                   <button  style="margin:10px;" type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.href='http://michele-media.it/general/stock-panel/?id=24';">Bar</button>
                   <button  style="margin:10px;" type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.href='http://michele-media.it/general/stock-panel/?id=25';">Spa</button>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>
               
                     <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card"  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Profile">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col"><span class="h6 font-semibold text-muted text-sm d-block mb-2">Gestione Utente</span></span> <span class="h3 font-bold mb-0">Profile</span></div>
                                 <div class="col-auto">
                                    <div style="background-color: #9f9b9c !important; " class="icon icon-shape bg-warning text-white text-lg rounded-circle"><i class="material-icons">account_circle</i></div>
                                 </div>
                              </div>
             
                           </div>
                        </div>
                        <div class="modal fade" id="Profile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sezioni Profilo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <button style="margin:10px;" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Utente</button>
                 <button style="margin:10px;" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Statistiche</button>
                      <button style="margin:10px;" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Assistenza</button>
      </div>
      <div class="modal-footer">
    
      </div>
    </div>
  </div>
</div>
                     </div>
                  </div>
                  <div class="row g-6 mb-6" style="margin-right: 2%;margin-left: 2%;">
                   <div class="col-xl-4">
                        <div class="card h-full">
                           <div class="card-body">
                              <div class="card-title d-flex align-items-center">
                                 <h5 class="mb-0" style="color: #4361ee">Controllo Ristorazione</h5>
                              
                              </div>
                              <div class="list-group gap-4">
                                 <div class="list-group-item d-flex align-items-center border rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i class="material-icons" style="font-size: 30px; color:#4361ee">menu_book</i></div>
                                    </div>
                                    <div class="flex-fill"><a href="./control-panel/menu-control/" class="d-block h6 font-semibold mb-1">I tuoi Menù</a><span class="d-block text-sm text-muted">Per modificare i diversi tipi di menù visti dai clienti e dallo staff</span></div>
                                    <div class="ms-auto text-end">
                                    
                                       </div>
                                    </div>
                                 </div>
                                 <div class="list-group-item d-flex align-items-center border rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i class="bi bi-qr-code-scan" style="font-size: 30px;color:#4361ee;"></i></div>
                                    </div>
                                    <div class="flex-fill"><a href="./control-panel/code-control/" class="d-block h6 font-semibold mb-1">I tuoi Codici</a><span class="d-block text-sm text-muted">La pagina per visulizzare I QR-code/ crearne nuovi e gestirne l'associamento al menù </span></div>
                                    <div class="ms-auto text-end">
                                      
                                    </div>
                                 </div>
                             
                              </div>
                           </div>
                        </div>    <div class="col-xl-4">
                        <div class="card h-full">
                           <div class="card-body">
                              <div class="card-title d-flex align-items-center">
                                 <h5 class="mb-0" style="color: #f4415a">Magazzino Generale</h5>
                              
                              </div>
                              <div class="list-group gap-4">
                                 <div class="list-group-item d-flex align-items-center border rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i class="material-icons" style="font-size: 30px; color: #f4415a">home</i></div>
                                    </div>
                                    <div class="flex-fill"><a href="./control-panel/menu-control/" class="d-block h6 font-semibold mb-1">Home</a><span class="d-block text-sm text-muted">Una overview generale per visualizzare le funzioni di questa sezione </span></div>
                                    <div class="ms-auto text-end">
                                    
                                       </div>
                                    </div>
                                 </div>
                                 <div class="list-group-item d-flex align-items-center border rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i class="material-icons" style="font-size: 30px; color: #f4415a">visibility</i></div>
                                    </div>
                                    <div class="flex-fill"><a href="./control-panel/code-control/" class="d-block h6 font-semibold mb-1"> Visualizza</a><span class="d-block text-sm text-muted">La pagina per visulizzare lo stato di tutti i Magazzini </span></div>
                                    <div class="ms-auto text-end">
                                      
                                    </div>
                                 </div>
                                 <div class="list-group-item d-flex align-items-center border rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i class="material-icons" style="font-size: 30px; color: #f4415a">manage_accounts</i></div>
                                    </div>
                                    <div class="flex-fill"><a href="./hotel-panel/" class="d-block h6 font-semibold mb-1"> Manage</a><span class="d-block text-sm text-muted">Potrai visualizzare ed associare i QR-code al nome dei clienti nella stanza.</span></div>
                                    <div class="ms-auto text-end">
                                      
                                    </div>
                                 </div>
                                      <div class="list-group-item d-flex align-items-center border rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i class="material-icons" style="font-size: 30px; color: #f4415a">edit</i></div>
                                    </div>
                                    <div class="flex-fill"><a href="./hotel-panel/" class="d-block h6 font-semibold mb-1">Edit</a><span class="d-block text-sm text-muted">Da questa il gestore del magazzino avrà la possibiltà di aggiungere nuovi ingredienti alle macro sezioni presenti nel magazzino generale</span></div>
                                    <div class="ms-auto text-end">
                                      
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div><div class="col-xl-4">
                        <div class="card h-full">
                           <div class="card-body">
                              <div class="card-title d-flex align-items-center">
                                 <h5 class="mb-0" style="color: #d17b24">Controllo Hotel</h5>
                              
                              </div>
                              <div class="list-group gap-4">
                                 <div class="list-group-item d-flex align-items-center border rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i class="material-icons" style="font-size: 30px; color: #d17b24">meeting_room</i></div>
                                    </div>
                                    <div class="flex-fill"><a href="./control-panel/menu-control/" class="d-block h6 font-semibold mb-1">Camere</a><span class="d-block text-sm text-muted">La sezione per visualizzare le camere presenti nell'hotel</span></div>
                                    <div class="ms-auto text-end">
                                    
                                       </div>
                                    </div>
                                 </div>
                             
                                 <div class="list-group-item d-flex align-items-center border rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i class="material-symbols-outlined" style="font-size: 30px; color: #d17b24">location_away</i></div>
                                    </div>
                                    <div class="flex-fill"><a href="./hotel-panel/" class="d-block h6 font-semibold mb-1"> Clienti</a><span class="d-block text-sm text-muted">La sezione per visulazziare i clienti presenti nell'hotel in questo momento</span></div>
                                    <div class="ms-auto text-end">
                                      
                                    </div>
                                 </div>
                                   <div class="list-group-item d-flex align-items-center border rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i class="material-icons" style="font-size: 30px; color: #d17b24">cloud</i></div>
                                    </div>
                                    <div class="flex-fill"><a href="./hotel-panel/" class="d-block h6 font-semibold mb-1"> Channel Manager</a><span class="d-block text-sm text-muted">La sezione per gestire le future prenotazioni nell'hotel</span></div>
                                    <div class="ms-auto text-end">
                                      
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div></div>
                    
                  </div>
               </div>
            </main>
         </div>
      </div>
      <script src="./main.js"></script>
   </body>
</html>