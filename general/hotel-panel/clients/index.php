<?php
 // Start the session
 session_start();
 
 ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
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

 
 
 if(isset($_POST['new_client_name'])){
     $name = $_POST['new_client_name'];
     $room = $_POST['new_client_room'];
     $people = $_POST['new_client_people'];
     
     $checkin = $_POST['new_client_checkin'];
     $checkout = $_POST['new_client_checkout'];
     
     
     $quesklcna = "INSERT INTO clients (`name`, `room`, `people`, `restaurant_id`, `checkin`, `checkout`) VALUES ('".$name."', ".$room.", '".$people."', '".$restaurant_id."', '".$checkin."', '".$checkout."')";
     mysqli_query($conn, $quesklcna);
     
     $π = "SELECT * FROM clients WHERE restaurant_id = ".$restaurant_id." AND name = '".$name."' AND room = '".$room."'";
     $res = mysqli_query($conn, $π);
     while($client = mysqli_fetch_assoc($res)){
         $query = "UPDATE rooms SET client_id = ".$client['ID']." WHERE id = ".$client['room'];
         mysqli_query($conn, $query);
     }
     
     header("Location: ./");
     exit();
 }
 
 if(isset($_GET['remove_client'])){
     $client_id = $_GET['remove_client'];
     $query = "DELETE FROM clients WHERE ID = ".$client_id;
     mysqli_query($conn, $query);
     
     $query = "UPDATE rooms SET client_id = 0 WHERE client_id = ".$client_id;
     mysqli_query($conn, $query);
     
     header("Location: ./");
     exit();
 }

 $title = "Clienti";
 if(isset($_GET['id'])){
    $query = "SELECT * FROM clients WHERE id = ".$_GET['id'];
    $client_res = mysqli_query($conn, $query);
    while($client = mysqli_fetch_assoc($client_res)){
        $title = $client['name'];
    }
 }
 
 ?>
<!doctype html>
<html lang="en" data-theme="dark">
   <head>
           <link rel="shortcut icon" href="../images/Favicon-tonda.png" type="image/png"/>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
      <meta name="color-scheme" content="dark light">
      <title>MF Digital</title>
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="shortcut icon" href="/../../../images/Favicon-tonda.png" type="image/png">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
      <link rel="stylesheet" type="text/css" href="./main.css">
      <link rel="stylesheet" type="text/css" href="./utils.css">
     
   </head>
   <body style="font-family: 'Inter', sans-serif;">
      <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
          <?php
       require "../../navbar/index.php";
nav4(3); ?>
         
          <div class="flex-lg-1 h-screen overflow-y-lg-auto">
        
             <header>
                <div class="container-fluid">
                   <div class="border-bottom pt-6">
                      <div class="row align-items-center">
                         <div class="col-sm col-12">
                            <h1 class="h2 ls-tight"><span class="d-inline-block me-3"></span><?php echo $title ?></h1>
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

 if(isset($_GET['id'])){ //single user view
    $query = "SELECT * FROM clients WHERE id = ".$_GET['id'];
    $client_res = mysqli_query($conn, $query);
    while($client = mysqli_fetch_assoc($client_res)){
        echo 'Pagamento: '.$client['payment'].'€<br>';
        echo 'Checkin: '.date("jS F", strtotime($client['checkin'])).'<br>';
        echo 'Checkout: '.date("jS F", strtotime($client['checkout'])).'<br><hr>';
        echo 'Tuttli gli ordini di '.$client['name'].':<br>';
    }
     
 }
 
 else {

$query = "SELECT * FROM clients WHERE `restaurant_id` = '$restaurant_id' ORDER BY checkout ASC";
$res = mysqli_query($conn, $query);

$client_quantity = mysqli_num_rows($res);


while($client = mysqli_fetch_assoc($res)) {
    
    
    //fit n° of people somewhere
    //get room name thru id
    $room_name = "Room";
    $query = "SELECT * FROM rooms WHERE id = ".$client['room'];
    $rooms = mysqli_query($conn, $query);
    while($room = mysqli_fetch_assoc($rooms)){
        $room_name = $room['name'];
    }
    

    $border = "border-info";
    
    $checkout = strtotime($client['checkout']);
    if($checkout > strtotime('now')) $border = "border-danger";
    if($checkout > strtotime('+2 day')) $border = "border-warning";
    if($checkout > strtotime('+4 day')) $border = "border-success";
    
    
echo '
<div class="col-auto my-1">
    <div class="card '.$border.' pb-4" style="border-width: thin">
        <div class="card-body" style="padding-bottom:0px;">
    
            <div class="row">
                <div class="col">
                    <span class="h6 font-semibold text-muted text-sm d-block mb-2 text-uppercase">STANZA '.$room_name.'</span> <span class="h3 font-bold mb-0"> ' . $client["name"]. '</span>
                </div>
                    <div class="col-auto">
                    <button class="btn-info text-white text-lg rounded" onclick="window.location.href=`./?id='.$client['ID'].'`"><i class="bi bi-info-circle"></i></button>
                        <button class="btn-danger text-white text-lg rounded" onclick="if(confirm(`Are you sure? This action CANNOT be reversed.`)){window.location.href=`./?remove_client='.$client["ID"].'`}"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
                
                <br>
                
                <div class="col">
                    <span>Checkin: '.date("jS F", strtotime($client['checkin'])).'</span>
                </div>
                
                <div class="col">
                    <span>Checkout: '.date("jS F", strtotime($client['checkout'])).'</span>
                </div>
            </div>
    </div>
</div>

';
}



             
echo '
<center>
<div class="card" style="margin: 3%; width: 50%">
<div class="card-body" style="padding-bottom:30px;">
<div class="row">
<div class="col"><span class="h3 font-bold mb-0">AGGIUNGI CLIENTE</span></div><hr>
<form action="" method="POST">

        <input placeholder="Nome Cliente" class="form-control mb-3" style="width: 50%" name="new_client_name" required></input>
        
        <div class="row" style="width: 80%">
            <div class="col">
                <label for="room-select">Stanza:</label>
                <select id="room-select"class="form-select" style="font-size: 15px; display: inline-block" name="new_client_room">';
                    
                    $query = "SELECT * FROM rooms WHERE client_id = 0";
                    $res = mysqli_query($conn, $query);
                    while($room = mysqli_fetch_assoc($res)){
                        echo '<option value="'.$room['ID'].'">'.$room['name'].'</option>';
                    }
                    
                echo '</select>
            </div>
            
            <div class="col mb-4">
                <label for="room-select">Numero Persone:</label>
                <select class="form-select" style="font-size: 15px;" name="new_client_people">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6+</option>
                </select>
            </div>
        </div>
        
        <div class="row" style="width: 80%">
            <div class="col">
                <label for="checkin-picker">Check-In:</label><br>
                <input name="new_client_checkin" class="form-control" id="checkin-picker" type="date" required></input>
            </div>
            
            <div class="col">
                <label for="checkin-picker">Check-Out:</label><br>
                <input name="new_client_checkout" class="form-control" id="checkin-picker" type="date" required></input>
            </div>
        </div>
        
        <br>
        <button class="btn btn-success">Aggiungi</button>
    </form>
</div>
</div>
</div>

</div>
</center>';
}

?> 
</div>
      <script src="./main.js"></script>
   </body>
</html>