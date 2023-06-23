 <?php
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
     header("location: /account");
 }
 
 $email = $_SESSION['email'];
 $password = $_SESSION['password'];
 
 
 // Check the account exists and get data of the restaurant
 
 $sql_exist = "SELECT * FROM restaurants WHERE `email` = '$email'";
 $exist_result = mysqli_query($conn, $sql_exist);
 
 if (mysqli_num_rows($exist_result) > 0) {
     while($exist = mysqli_fetch_assoc($exist_result)) {
         // Now check if the password is correct
         if($exist['password'] != $password){
             // The password is not correct so redirect to login
             unset($_SESSION['email']);
             unset($_SESSION['password']);
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
     unset($_SESSION['email']);
     unset($_SESSION['password']);
     $_SESSION['error'] = "This Email is not registered.";
     header("location: /login");
     exit;
 }
 // else, the password is correct so it's ok to continue

 
 
 if(isset($_POST['new_menu_name'])){
     $name = $_POST['new_menu_name'];
     $type = $_POST['new_menu_option'];
     
     
     $quesklcna = "INSERT INTO menu (`name`, `restaurant_id`, `type`, `status`) VALUES ('".$name."', ".$restaurant_id.", '".$type."', 'disabled')";
     mysqli_query($conn, $quesklcna);
     
     header("Location: ./");
     exit();
 }
 
 if(isset($_GET['remove_menu'])){
     $menu_id = $_GET['remove_menu'];
     $query = "DELETE FROM menu WHERE ID = ".$menu_id;
     mysqli_query($conn, $query);
     
     header("Location: ./");
     exit();
 }
 

 
 
 ?>
 <!doctype html>
 <html lang="en" data-theme="dark">
    <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
       <meta name="color-scheme" content="dark light">
       <title>TechOrder</title>
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
       <link rel="shortcut icon" href="/../../../images/Favicon-tonda.png" type="image/png">
       <link rel="stylesheet" type="text/css" href="./main.css">
       <link rel="stylesheet" type="text/css" href="./utils.css">
      
    </head>
    <body>
      <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
           <?php
       require "../../navbar/index.php";
nav4(4); ?>
          <div class="flex-lg-1 h-screen overflow-y-lg-auto">
        
             <header>
                <div class="container-fluid">
                   <div class="border-bottom pt-6">
                      <div class="row align-items-center">
                         <div class="col-sm col-12">
                            <h1 class="h2 ls-tight"><span class="d-inline-block me-3"></span> Menu Control</h1>
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

<div class="row g-1 mb-6">
    

<?php 

$sql_menu = "SELECT * FROM menu WHERE `restaurant_id` = '$restaurant_id' ORDER BY type ASC";
$menu_result = mysqli_query($conn, $sql_menu);

$menu_quantity = mysqli_num_rows($menu_result);
 
 
$menus_array = array();

if (mysqli_num_rows($menu_result) > 0) {
while($menu = mysqli_fetch_assoc($menu_result)) {

$current_menu = "";

    $border = "";
    
    switch($menu["type"]){
        case "restaurant":
            $border = "border-success";
            break;
            
        case "beach":
            $border = "border-info";
            break;
            
        case "bar":
            $border = "border-warning";
            break;
            
        case "service":
            $border = "border-primary";
            break;

    }
    
$elements = 0;

$query = "SELECT * FROM categories WHERE restaurant_id = $restaurant_id AND menu_id = ".$menu["ID"];
$result = mysqli_query($conn, $query);
while($category = mysqli_fetch_assoc($result)){
    $query = "SELECT * FROM food WHERE restaurant_id = $restaurant_id AND category_id = ".$category["ID"];
    $elements += mysqli_num_rows(mysqli_query($conn, $query));
}
    
$current_menu .= '
<div class="col-auto my-1">
<div class="card '.$border.' pb-4" style="border-width: thin">
<div class="card-body" style="padding-bottom:0px;">
<div class="row">
<div class="col"><span class="h6 font-semibold text-muted text-sm d-block mb-2 text-uppercase">'.$elements.' ELEMENTI</span> <span class="h3 font-bold mb-0"> ' . $menu["name"]. '</span></div>
<div class="col-auto">
<button class="btn-warning text-white text-lg rounded" onclick="window.location=`'. 'http://michele-media.it/general/control-panel/menu-control/edit?menu_id=' .$menu["ID"] . '`"><i class="bi bi-pencil"></i></button>
<button class="btn-danger text-white text-lg rounded" onclick="if(confirm(`Are you sure? This action CANNOT be reversed.`)){window.location=`./?remove_menu='.$menu["ID"].'`}"><i class="bi bi-trash"></i></button>
</div>
</div>

</div>
</div>

</div>

';

$menus_array[] = $current_menu;
}}

$query = "SELECT * FROM menu WHERE `restaurant_id` = '$restaurant_id' AND type = 'restaurant'";
$restaurant_number = mysqli_num_rows(mysqli_query($conn, $query));

$query = "SELECT * FROM menu WHERE `restaurant_id` = '$restaurant_id' AND type = 'service'";
$service_number = mysqli_num_rows(mysqli_query($conn, $query));

$query = "SELECT * FROM menu WHERE `restaurant_id` = '$restaurant_id' AND type = 'beach'";
$beach_number = mysqli_num_rows(mysqli_query($conn, $query));

$query = "SELECT * FROM menu WHERE `restaurant_id` = '$restaurant_id' AND type = 'bar'";
$bar_number = mysqli_num_rows(mysqli_query($conn, $query));


$j = 0;

if($bar_number > 0){
    echo '<span class="h6 font-semibold text-muted text-sm d-block mb-2 text-uppercase">bar</span> 
    <div class="row row-cols-4 my-3" style="margin-right:10px; padding-bottom:0px !important; border-color: #8e8d92;">';
    for($i = 0; $i < $bar_number; $i++) { echo $menus_array[$j]; $j++;} //porco dio se sono intelligente
    echo '</div><hr>';
}

if($beach_number > 0){
    echo '<span class="h6 font-semibold text-muted text-sm d-block mb-2 text-uppercase">beach</span> 
    <div class="row row-cols-4 my-3" style="margin-right:10px; padding-bottom:0px !important; border-color: #8e8d92;">';
    for($i = 0; $i < $beach_number; $i++) { echo $menus_array[$j]; $j++;} //porco dio se sono intelligente
    echo '</div><hr>';
}

if($restaurant_number > 0){
    
    echo '<span class="h6 font-semibold text-muted text-sm d-block mb-2 text-uppercase">restaurant</span> 
    <div class="row row-cols-4 my-3" style="margin-right:10px; padding-bottom:0px !important; border-color: #8e8d92;">';
    for($i = 0; $i < $restaurant_number; $i++) { echo $menus_array[$j]; $j++;} //porco dio se sono intelligente
    echo '</div><hr>';
}

if($service_number > 0){
    echo '<span class="h6 font-semibold text-muted text-sm d-block mb-2 text-uppercase">service</span> 
    <div class="row row-cols-4 my-3" style="margin-right:10px;padding-bottom:0px !important;border-color: #8e8d92; ">';
    for($i = 0; $i < $service_number; $i++) { echo $menus_array[$j]; $j++;}
    echo '</div><hr>';
}



             
echo '
<div class="card" style="margin: 3%;">
<div class="card-body" style="padding-bottom:10px;">
<div class="row">
<div class="col"><span class="h3 font-bold mb-0">NUOVO MENU</span></div>
<form action="" method="POST">
    <center>

        <input id="nameinput" placeholder="nome menu" class="form-control" name="new_menu_name"></input>
        
        <select class="form-select" style="font-size: 15px" name="new_menu_option">
            <option value="bar">Bar</option>
            <option value="beach">Spiaggia</option>
            <option value="restaurant">Ristorante</option>
            <option value="service">Servizio</option>
        </select>
        
        <br>
        <button class="btn btn-success">Aggiungi</button>
    </center>
    </form>
</div>
</div>
</div>

</div>';?> 
</div>
             </div>
             </main>
          </div>
       </div>
       <script src="./main.js"></script>
    </body>
 </html>
