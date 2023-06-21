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
      <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary" style="background-color: white !important;">
           
          <div class="flex-lg-1 h-screen overflow-y-lg-auto">
    

             <main class="py-6 bg-surface-secondary" style="background-color:#ffffff !important">
           
      
           <div class="container-fluid">
                         <?php
       require "../menu-sopra/index.php";
pit4(6); ?>
 <h1 style="margin-right:5%; margin-left:5%" class="h2 ls-tight"><span class="d-inline-block me-3"></span>Menus</h1><hr>
<div class="row g-1 mb-6" style="margin-left:5%; margin-right:5%">
    

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
<button   onclick="location.href=`/waiter-orders/select-menu.php?r='.$code["ID"].'`;"  class="card '.$border.'" style="border-width: thin">
<div class="card-body" style="padding-bottom:0px;">
<div class="row">
<div class="col"><span class="h6 font-semibold  d-block mb-2 text-uppercase" style=" color: black; font-size: 20px">'.$code["name"].'</span></div>




</div>

</div>


</button>

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
    echo '<span class="h4 font-semibold text-muted text-sm d-block mb-2 text-uppercase" style="margin-left: 1%;  font-size:20px !important;">Bar</span> 
    <div  class="row row-cols-5 my-3" style="margin-right:10px; padding-bottom:0px !important;margin-top: 0px !important; border-color: #8e8d92;">';
    for($i = 0; $i < $bar_number; $i++) { echo $codes_array[$i]; $j++;} //porco dio se sono intelligente
    echo '</div>';
}

if($beach_number > 0){
    echo '<span class="h4 font-semibold text-muted text-sm d-block mb-2 text-uppercase" style="margin-left: 1%;font-size:20px !important;">Beach</span> 
    <div class="row row-cols-5 my-3" style="margin-right:10px;padding-bottom:0px !important; margin-top: 0px !important; border-color: #8e8d92; ">';
    for($i = 0; $i < $beach_number; $i++) { echo $codes_array[$j]; $j++;}
    echo '</div>';
}

if($restaurant_number > 0){
    echo '<span class="h4 font-semibold text-muted text-sm d-block mb-2 text-uppercase" style="margin-left: 1%;  font-size:20px !important;">restaurant</span> 
    <div class="row row-cols-5 my-3" style="margin-right:10px; margin-top: 0px !important; padding-bottom:0px !important; border-color: #8e8d92;">';
    for($i = 0; $i < $restaurant_number; $i++) { echo $codes_array[$j]; $j++;}
    echo '</div></div>';
}

if($staff_number > 0){
    echo '<span style="margin-left:5%" class="h4 font-semibold text-muted text-sm d-block mb-2 text-uppercase" style="margin-left: 1%;font-size:20px !important;">staff</span> 
    <div  style="margin-left:5%"  class="row row-cols-5 my-3" style="margin-right:10px; margin-top: 0px !important; padding-bottom:0px !important; border-color: #8e8d92; ">';
    for($i = 0; $i < $staff_number; $i++) { echo $codes_array[$j]; $j++;}
    echo '</div></div>';
}

?>  </div> </div>
              </div>  </div>
             </main>
          </div>
       </div>
       <script src="./main.js"></script>
    </body>
 </html>
