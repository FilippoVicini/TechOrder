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
if (!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}

// Look for credentials from post - login page
if ((isset($_POST['email'])) and (isset($_POST['password'])))
{
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

if (mysqli_num_rows($exist_result) > 0)
{
    while ($exist = mysqli_fetch_assoc($exist_result))
    {
        // Now check if the password is correct
        if ($exist['password'] != $password)
        {
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
}
else
{
    // the email is not registered in the system, so redirect to login
    $_SESSION['error'] = "This Email is not registered.";
    header("location: /login");
    exit;
}
// else, the password is correct so it's ok to continue


//get order table
$sql_orders = "SELECT * FROM `orders`";
$orders_result = mysqli_query($conn, $sql_orders);

if (isset($_POST['new_ingredient']))
{
    $ingredient_name = $_POST['new_ingredient'];
    $query = "INSERT INTO `magazzino`(`ID`, `nome`, `quantità`, `resturant_id`, `date_added`) VALUES ('','" . $ingredient_name . "','0','" . $restaurant_id . "','" . date("Y-m-d H:i:s") . "')";
    mysqli_query($conn, $query);
}

if (isset($_GET['id']))
{
    if ($_GET['id'] == 22)
    {
        $query = "SELECT * FROM magazzino WHERE id = " . $_GET['id'];
        $res = mysqli_query($conn, $query);
        while ($magazzino = mysqli_fetch_assoc($res))
        {

?>
<!doctype html>
<html lang="en" data-theme="dark">
   <head>
           <link rel="shortcut icon" href="../images/Favicon-tonda.png" type="image/png"/>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
      <meta name="color-scheme" content="dark light">
      <title>TechOrder</title>
      <link rel="stylesheet" href="https://fonts.sandbox.google.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link rel="shortcut icon" href="/../../../images/Favicon-tonda.png" type="image/png">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
      <link rel="stylesheet" type="text/css" href="./main.css">
      <link rel="stylesheet" type="text/css" href="./utils.css">
     
   </head>
   <body>
      <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
          <?php
            require "../navbar/index.php";
            nav4(2); ?>
         <div class="flex-lg-1 h-screen overflow-y-lg-auto">
       
            <header>
               <div class="container-fluid">
                  <div class="border-bottom pt-6">
                     <div class="row align-items-center">
                        <div class="col-sm col-12">
                           <h1 class="h2 ls-tight"><span class="d-inline-block me-3"></span> <?php echo "Magazzino " . $magazzino['nome'] ?></h1>
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
                     
                     <div class="col-xl-6">
                        <div class="card h-full" style="height:100% !important">
                           <div class="card-body">
                              <div class="card-title d-flex align-items-center">
                                 <h5 class="mb-0" style="color: #06c">Controllo Magazzino</h5>
                              
                              </div>
                              <div class="list-group gap-4">
                                 <div class="list-group-item d-flex align-items-center border rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i class="bi bi-menu-up" style="font-size: 30px; color: #6b7b93"></i></div>
                                    </div>
                                    <div class="flex-fill"><button type="button" class="d-block h6 font-semibold mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background-color:#ffffff"> 
View stocks
</button>
<span class="d-block text-sm text-muted">Per visualizzare lo stato del magazzino e dei suoi elementi</span></div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width:60%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Seleziona il magazzino</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.href='http://michele-media.it/general/stock-panel/view/?id=22'">Generale</button>
        <button type="button" class="btn btn-secondary" onclick="location.href='http://michele-media.it/general/stock-panel/view/?id=23'">Hotel</button>
                <button type="button" class="btn btn-secondary" onclick="location.href='http://michele-media.it/general/stock-panel/view/?id=24'">Bar</button>
                        <button type="button" class="btn btn-secondary" onclick="location.href='http://michele-media.it/general/stock-panel/view/?id=26'">Spiaggia</button>
                             <button type="button" class="btn btn-secondary" onclick="location.href='http://michele-media.it/general/stock-panel/view/?id=25'">Spa</button>
      </div>
      
    </div>
  </div>
</div>
                                    <div class="ms-auto text-end">
                                    
                                       </div>
                                    </div>
                                 </div>
                                 <div class="list-group-item d-flex align-items-center border rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><span style="color:#6b7b93;" class="material-symbols-outlined">send</span></div>
                                    </div>
                                    <div class="flex-fill"><a href="http://michele-media.it/general/stock-panel/manage/?id=22" class="d-block h6 font-semibold mb-1"> Rifornimento/share</a><span class="d-block text-sm text-muted">Per aggiungere quantità agli ingredienti già presenti e inviare gli elementi agli altri magazzini. </span></div>
                                    <div class="ms-auto text-end">
                                      
                                    </div>
                                 </div>
                                    <div class="list-group-item d-flex align-items-center border rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><span style="color:#6b7b93" class="material-symbols-outlined">add</span></div>
                                    </div>
                                    <div class="flex-fill"><a href="http://michele-media.it/general/stock-panel/edit/?id=22" class="d-block h6 font-semibold mb-1"> Nuovo ordine </a><span class="d-block text-sm text-muted">Per aggiungere elementi ancora non presenti nel magazzino</span></div>
                                    <div class="ms-auto text-end">
                                      
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-xl-6">
                        <div class="card h-full">
                           <div class="card-body">
                              <div class="card-title d-flex align-items-center">
                                 <h5 class="mb-0" style="color: #06c">Tutti i Magazzini</h5>
                              
                              </div>
                               
                              <div class="list-group gap-4">
                                 <div class="list-group-item d-flex align-items-center border rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i class="bi bi-menu-up" style="font-size: 30px; color: #6b7b93"></i></div>
                                    </div>
                                    <div class="flex-fill"><a href="./control-panel/menu-control/" class="d-block h6 font-semibold mb-1">Hotel</a><span class="d-block text-sm text-muted">Per modificare i diversi tipi di menù visti dai clienti e dallo staff</span></div>
                                    <div class="ms-auto text-end">
                                    
                                       </div>
                                    </div>
                                 </div>
                                 <div class="list-group-item d-flex align-items-center border rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i class="bi bi-qr-code-scan" style="font-size: 30px;color:#6b7b93;"></i></div>
                                    </div>
                                    <div class="flex-fill"><a href="./control-panel/code-control/" class="d-block h6 font-semibold mb-1"> Bar</a><span class="d-block text-sm text-muted">La pagina per visulizzare I QR-code/ crearne nuovi e gestirne l'associamento al menù </span></div>
                                    <div class="ms-auto text-end">
                                      
                                    </div>
                                 </div>
                                 <div class="list-group-item d-flex align-items-center border rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i class="bi bi-shop-window" style="font-size: 30px; color: #6b7b93"></i></div>
                                    </div>
                                    <div class="flex-fill"><a href="./hotel-panel/" class="d-block h6 font-semibold mb-1"> Spa</a><span class="d-block text-sm text-muted">Potrai visualizzare ed associare i QR-code al nome dei clienti nella stanza.</span></div>
                                    <div class="ms-auto text-end">
                                      
                                    </div>
                                 </div>
                                    <div class="list-group-item d-flex align-items-center border rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><i class="bi bi-shop-window" style="font-size: 30px; color: #6b7b93"></i></div>
                                    </div>
                                    <div class="flex-fill"><a href="./hotel-panel/" class="d-block h6 font-semibold mb-1"> Beach</a><span class="d-block text-sm text-muted">Potrai visualizzare ed associare i QR-code al nome dei clienti nella stanza.</span></div>
                                    <div class="ms-auto text-end">
                                      
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row g-6 mb-6" style="margin-right:2%; margin-left: 2%">
                         <h2>View Stock</h2>
                     <div class="col-xl-3 col-sm-6 col-12">
                      
                   <div class="card" onclick="location.href='http://michele-media.it/general/stock-panel/view/?id=23'" >   
                           <div class="card-body">
                              <div class="row">
                                 <div class="col"><span class="h6 font-semibold text-muted text-sm d-block mb-2">Visualizza</span> <span class="h3 font-bold mb-0"  > Hotel</span></div>
                                 <div class="col-auto">
                                    <div  style="background-color:#f4405a !important" class="icon icon-shape bg-tertiary text-white text-lg rounded-circle"><span class="material-symbols-outlined">
visibility
</span></div>
                                 </div>
                              </div>
                           
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card" onclick="location.href='http://michele-media.it/general/stock-panel/view/?id=24'">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col"><span class="h6 font-semibold text-muted text-sm d-block mb-2">Visualizza</span> <span class="h3 font-bold mb-0"> Bar</span></div>
                                 <div class="col-auto">
                                    <div style="background-color:#f4405a !important" class="icon icon-shape bg-primary text-white text-lg rounded-circle"><span class="material-symbols-outlined">
visibility
</span></div>
                                 </div>
                              </div>
               
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-3 col-sm-6 col-12">
                           <div class="card"  onclick="location.href='http://michele-media.it/general/stock-panel/view/?id=25'">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col"><span class="h6 font-semibold text-muted text-sm d-block mb-2">Visualizza</span> <span class="h3 font-bold mb-0"> Spa</span></div>
                                 <div class="col-auto">
                                    <div style="background-color:#f4405a !important" class="icon icon-shape bg-primary text-white text-lg rounded-circle"><span class="material-symbols-outlined">
visibility
</span></div>
                                 </div>
                              </div>
                          
                           </div>
                        </div>
                       
                     </div>
                      <div class="col-xl-3 col-sm-6 col-12">
                           <div class="card"  onclick="location.href='http://michele-media.it/general/stock-panel/view/?id=26'">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col"><span class="h6 font-semibold text-muted text-sm d-block mb-2">Visualizza</span> <span class="h3 font-bold mb-0"> Spiaggia</span></div>
                                 <div class="col-auto">
                                    <div style="background-color:#f4405a !important" class="icon icon-shape bg-primary text-white text-lg rounded-circle"><span class="material-symbols-outlined">
visibility
</span></div>
                                 </div>
                              </div>
                          
                           </div>
                        </div>
                       
                     </div>
                     <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card"   onclick="location.href='http://michele-media.it/general/stock-panel/view/?id=22'">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col"><span class="h6 font-semibold text-muted text-sm d-block mb-2">Visualizza</span></span> <span class="h3 font-bold mb-0"> General</span></div>
                                 <div class="col-auto">
                                    <div style="background-color:#f4405a !important"class="icon icon-shape bg-warning text-white text-lg rounded-circle"><i class="bi bi-minecart-loaded"></i></div>
                                 </div>
                              </div>
             
                           </div>
                        </div>
                     </div>
                  </div>
                  
                  <div class="row g-6 mb-6" style="margin-right:2%; margin-left: 2%">
                                 <h2>Edit Stock</h2>
                     <div class="col-auto col-sm-6 col-12">
                   <div class="card" onclick="location.href='http://michele-media.it/general/stock-panel/manage/?id=22'">   
                           <div class="card-body">
                              <div class="row">
                                 <div class="col"><span class="h6 font-semibold text-muted text-sm d-block mb-2">Modifica</span> <span class="h3 font-bold mb-0">Edit Stock General</span></div>
                                 <div class="col-auto">
                                    <div class="icon icon-shape bg-tertiary text-white text-lg rounded-circle"><i class="bi bi-credit-card"></i></div>
                                 </div>
                              </div>
                           
                           </div>
                        </div>
                     </div>
                     
                     </div>
                  </div>
                    <div class="row ">
                  
               </div>
            </main>
         </div>
      </div>
      <script src="./main.js"></script>
   </body>
</html>

<?php
        }

    }

    $query = "SELECT * FROM magazzino WHERE id = " . $_GET['id'];
    $res = mysqli_query($conn, $query);
    while ($magazzino = mysqli_fetch_assoc($res))
    {

?>
<!doctype html>
<html lang="en" data-theme="dark">
   <head>
           <link rel="shortcut icon" href="../images/Favicon-tonda.png" type="image/png"/>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
      <meta name="color-scheme" content="dark light">
      <title>MF Digital</title>
      <link rel="stylesheet" href="https://fonts.sandbox.google.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link rel="shortcut icon" href="/../../../images/Favicon-tonda.png" type="image/png">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
      <link rel="stylesheet" type="text/css" href="./main.css">
      <link rel="stylesheet" type="text/css" href="./utils.css">
     
   </head>
   <body>
      <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
          <?php
        require "../navbar/index.php";
        nav4(2); ?>
         <div class="flex-lg-1 h-screen overflow-y-lg-auto">
       
            <header>
               <div class="container-fluid">
                  <div class="border-bottom pt-6">
                     <div class="row align-items-center">
                        <div class="col-sm col-12">
                           <h1 class="h2 ls-tight"><span class="d-inline-block me-3"></span> <?php echo "Magazzino " . $magazzino['nome'] ?></h1>
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
                     
                     <div style="width:100% " class="col-xl-6">
                        <div class="card h-full" style="height:100% !important">
                           <div style="width:100%" class="card-body">
                              <div class="card-title d-flex align-items-center">
                                 <h5 class="mb-0" style="color: #06c">Controllo Magazzino</h5>
                              
                              </div>
                        
                                    <div class="list-group-item d-flex align-items-center border rounded">
                                    <div class="me-4">
                                       <div class="avatar rounded-circle"><span style="color:#6b7b93" class="material-symbols-outlined">add</span></div>
                                    </div>
                                    <div class="flex-fill"><a href="http://michele-media.it/general/stock-panel/view/?id=<?php echo $_GET['id'] ?>" class="d-block h6 font-semibold mb-1"> View Stock </a><span class="d-block text-sm text-muted">Per visualizzare le quantità di elementi presenti nel magazzino</span></div>
                                    <div class="ms-auto text-end">
                                      
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     
                     </div>
                  </div>
                
                    <div class="row ">
                  
               </div>
            </main>
         </div>
      </div>
      <script src="./main.js"></script>
   </body>
</html>

<?php
    }

}

else
{
    echo "errore: magazzino non trovato";
}

?>
