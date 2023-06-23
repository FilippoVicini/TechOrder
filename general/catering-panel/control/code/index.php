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

 
 
 if(isset($_POST['new_code_name'])){
     $name = $_POST['new_code_name'];
     $type = $_POST['new_code_option'];
     
     
     $quesklcna = "INSERT INTO tables (`name`, `restaurant_id`, `type`) VALUES ('".$name."', ".$restaurant_id.", '".$type."')";
     mysqli_query($conn, $quesklcna);
     
     header("Location: ./");
     exit();
 }
 

 if(isset($_GET['remove_code'])){
     $code_id = $_GET['remove_code'];
     $query = "DELETE FROM tables WHERE ID = ".$code_id;
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
       <title>MF Digital</title>
       <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
       <link rel="stylesheet" type="text/css" href="./main.css">
       <link rel="shortcut icon" href="/../../../images/Favicon-tonda.png" type="image/png">
       <link rel="stylesheet" type="text/css" href="./utils.css">
      
    </head>
    <body style="font-family: 'Inter', sans-serif;">
      <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
           <?php
       require "../../../../general/assets/navbar/";
nav4(4); ?>
          <div class="flex-lg-1 h-screen overflow-y-lg-auto">
    

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
 <h1 class="h2 ls-tight"><span class="d-inline-block me-3"></span>I Tuoi Codici</h1><hr>
<div class="row g-1 mb-6">
    

<?php 

$sql_code = "SELECT * FROM tables WHERE `restaurant_id` = '$restaurant_id' ORDER BY type ASC";
$code_result = mysqli_query($conn, $sql_code);
 
$code_quantity = mysqli_num_rows($code_result);
 
 
$codes_array = array();

if (mysqli_num_rows($code_result) > 0) {
while($code = mysqli_fetch_assoc($code_result)) {
$current_code = "";

    $border = "";
    switch($code["type"]){
            
        case "bar":
            $border = "border-warning";
            break;
            
        case "restaurant":
            $border = "border-success";
            break;
            
        case "beach":
            $border = "border-info";
            break;
            
        case "staff":
            $border = "border-danger";
    }
    
$current_code .= '
<div class="col-auto my-1">
<div class="card '.$border.'" style="border-width: thin">
<div class="card-body" style="padding-bottom:0px;">
<div class="row">
<div class="col"><span class="h6 font-semibold  d-block mb-2 text-uppercase" style="margin-left: 1%; color: black; font-size: 15px">'.$code["name"].'</span></div>

<div class="col-auto">

<button class="btn-danger text-white text-lg rounded" onclick="if(confirm(`Are you sure? This action CANNOT be reversed.`)){window.location=`./?remove_code='.$code["ID"].'`}"><i class="bi bi-trash"></i></button>
</div>
</div>

</div>

<center style="padding:5px"><img style="boder-radius: 32px" src="https://chart.googleapis.com/chart?chs=177x177&cht=qr&chl=http://michele-media.it/general/client/auth.php?t='.$code["ID"].'"></center>

</div>

</div>

';

$codes_array[] = $current_code;
}}


$query = "SELECT * FROM tables WHERE `restaurant_id` = '$restaurant_id' AND type = 'bar'";
$bar_number = mysqli_num_rows(mysqli_query($conn, $query));

$query = "SELECT * FROM tables WHERE `restaurant_id` = '$restaurant_id' AND type = 'beach'";
$beach_number = mysqli_num_rows(mysqli_query($conn, $query));

$query = "SELECT * FROM tables WHERE `restaurant_id` = '$restaurant_id' AND type = 'restaurant'";
$restaurant_number = mysqli_num_rows(mysqli_query($conn, $query));

$query = "SELECT * FROM tables WHERE `restaurant_id` = '$restaurant_id' AND type = 'staff'";
$staff_number = mysqli_num_rows(mysqli_query($conn, $query));


$j = 0;

if($bar_number > 0){
    echo '<span class="h6 font-semibold text-muted text-sm d-block mb-2 text-uppercase" style="margin-left: 1%;">Bar</span> 
    <div class="row row-cols-5 my-5" style="margin-right:10px; padding-bottom:0px !important; border-color: #8e8d92;">';
    for($i = 0; $i < $bar_number; $i++) { echo $codes_array[$i]; $j++;} //porco dio se sono intelligente
    echo '</div><hr>';
}

if($beach_number > 0){
    echo '<span class="h6 font-semibold text-muted text-sm d-block mb-2 text-uppercase" style="margin-left: 1%;">Beach</span> 
    <div class="row row-cols-5 my-5" style="margin-right:10px;padding-bottom:0px !important;border-color: #8e8d92; ">';
    for($i = 0; $i < $beach_number; $i++) { echo $codes_array[$j]; $j++;}
    echo '</div><hr>';
}

if($restaurant_number > 0){
    echo '<span class="h6 font-semibold text-muted text-sm d-block mb-2 text-uppercase" style="margin-left: 1%;">restaurant</span> 
    <div class="row row-cols-5 my-5" style="margin-right:10px; padding-bottom:0px !important; border-color: #8e8d92;">';
    for($i = 0; $i < $restaurant_number; $i++) { echo $codes_array[$j]; $j++;}
    echo '</div></div><hr>';
}

if($staff_number > 0){
    echo '<span class="h6 font-semibold text-muted text-sm d-block mb-2 text-uppercase" style="margin-left: 1%;">staff</span> 
    <div class="row row-cols-5 my-5" style="margin-right:10px; padding-bottom:0px !important; border-color: #8e8d92;">';
    for($i = 0; $i < $staff_number; $i++) { echo $codes_array[$j]; $j++;}
    echo '</div></div>';
}

             
echo '
<div class="card">
<div class="card-body" style="padding-bottom:0px;">
<div class="row">
<div class="col"><span class="h3 font-bold mb-0">NUOVO CODICE</span></div>
<form action="" method="POST">
    <center>

        <input placeholder="nome codice" class="form-control" name="new_code_name" required></input>
        
        <select name="new_code_option" class="form-select">
            <option value="bar">Bar</option>
            <option value="restaurant">Ristorante Hotel</option>
            <option value="beach">Spiaggia</option>
            <option value="staff">Staff</option>
        </select>
        
        <br>
        <button class="btn btn-success">+</button>
    </center>
    </form>
    
</div>
</div>
</div>

</div>';?>  </div> </div>
              </div>  </div>
             </main>
          </div>
       </div>
       <script src="./main.js"></script>
    </body>
 </html>
