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

 
$menu_id = $_GET['menu_id'];
$menu_name = "";

$query = "SELECT * FROM menu WHERE restaurant_id = $restaurant_id AND id = $menu_id";
$result = mysqli_query($conn, $query);
while($menu = mysqli_fetch_assoc($result)) $menu_name = $menu['name'];


if(isset($_POST['new_section_title'])){
    $new_section_title = $_POST['new_section_title'];
    $new_section_description = $_POST['new_section_description'];
    
    $new_section_type = $_POST['new_cat_option'];
    $drink = 0;
    $pizzeria = 0;
    if($new_section_type == "drink") $drink = 1;
        if($type == "beach") $pizzeria = 1;
        
    $timestamp = date("Y-m-d");
    
    $position = 0;
    $get_position = "SELECT * FROM categories WHERE `restaurant_id` = '$restaurant_id' AND menu_id = $menu_id";
    $res = mysqli_query($conn, $get_position);
    
    while($cat = mysqli_fetch_assoc($res)){
        if($cat['position_in_menu'] > $position) $position = $cat['position_in_menu']; //get highest position
    }

    $sql_update = "INSERT INTO categories (`name`, `restaurant_id`, `menu_id`, `date_created`, `description`, `drink`, `pizzeria`,`position_in_menu`, `status`) 
    VALUES ('$new_section_title', $restaurant_id,  $menu_id, '$timestamp', '$new_section_description', $drink, $pizzeria, $position+1, 'active')";

    mysqli_query($conn, $sql_update);
    header("Location: ./?menu_id=".$menu_id);
    exit();
}

 
if(isset($_GET['remove_cat'])){
    $cid = $_GET['remove_cat'];
    
    $query = "DELETE FROM food WHERE restaurant_id = $restaurant_id AND category_id = $cid";
    mysqli_query($conn, $query);
    
    $query = "DELETE FROM categories WHERE restaurant_id = $restaurant_id AND id = $cid";
    mysqli_query($conn, $query);
    
    header("Location: ./?menu_id=".$menu_id);
    exit();
}

if(isset($_GET['remove_food'])){
    $fid = $_GET['remove_food'];
    
    $query = "DELETE FROM food WHERE restaurant_id = $restaurant_id AND id = $fid";
    mysqli_query($conn, $query);
    
    
    header("Location: ./?menu_id=".$menu_id);
    exit();
}

 ?>
 <!doctype html>
 <html lang="en" data-theme="dark">
    <head>
        <link rel="shortcut icon" href="../images/Favicon-tonda.png" type="image/png">
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
       <meta name="color-scheme" content="dark light">
       <title>MF Digital</title>
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
       <link rel="stylesheet" type="text/css" href="./main.css">
       <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
       <link rel="stylesheet" type="text/css" href="./utils.css">
      
    </head>
    <body  style="font-family: 'Inter', sans-serif;">
      <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
         <?php
       require "../../../navbar/index.php";
nav4(4); ?>
          <div class="flex-lg-1 h-screen overflow-y-lg-auto">
        
             <header>
                <div class="container-fluid">
                   <div class="border-bottom pt-6">
                      <div class="row align-items-center">
                         <div class="col-sm col-12">
                            <h1 class="h2 ls-tight"><span class="d-inline-block me-3"></span>Gestisci Menu: "<?php echo  $menu_name ?>"</h1>
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
    </center>
               
            

<div class="card-body" style="padding-bottom:10px; padding: 0.5rem;">
<div class=""> <!-- row? -->
    
    
    
    
    
    
    <?php 
    // Query the categories of that restaurant to build the menu

$sql_categories = "SELECT * FROM categories WHERE `restaurant_id` = '$restaurant_id' AND menu_id = $menu_id ORDER BY `position_in_menu` ASC";
$categories_result = mysqli_query($conn, $sql_categories);
$categories_quantity = mysqli_num_rows($categories_result);




if (mysqli_num_rows($categories_result) > 0) {
// output data of each row
while($categories = mysqli_fetch_assoc($categories_result)) {
    
$type = "standard";
$border = "border-success";
if($categories['pizzeria'] == 1) { $type = "pizza"; $border = "border-danger";}
if($categories['drink'] == 1) {$type = "drink"; $border = "border-info";}

echo '
<div class="col-auto my-4 mx-4">
<div class="card pb-4 '.$border.'" style="border-width: 2px">
<div class="card-body" style="padding-bottom:0px;">

<div class="row">

<div class="col-auto">
<span class="h6 font-semibold text-muted text-sm d-block mb-2 text-uppercase">'.$type.'</span>
<span class="h3 font-bold mb-0"> ' . $categories["name"]. '</span>
</div>


<div class="col-auto">
<button class="btn-danger text-white text-lg rounded"
onclick="if(confirm(`Are you sure? This action CANNOT be reversed.`)){window.location=`./?remove_cat='.$categories["ID"].'&menu_id='.$menu_id.'`}">
<i class="bi bi-trash"></i>
</button>
</div>

</div>

<div class="row row-cols-4 mt-3"> ';


$current_category = $categories["ID"];

$sql_food = "SELECT * FROM food WHERE `category_id` = '$current_category' ORDER BY `position_in_category` ASC";
$food_result = mysqli_query($conn, $sql_food);



if (mysqli_num_rows($food_result) > 0) {
while($food = mysqli_fetch_assoc($food_result)) {
    
echo '
<div class="col-auto">
    <div class="card">
        <div class="card-body rounded">
            <div class="row">
                <div class="col-auto">
                    <span class="h4 fw-bold">'.$food['name'].'</span>
                </div>
                
                <div class="col-auto" style="margin-top: -15px; margin-right: -15px">
                    <button class="btn-danger text-white text-md rounded"
                    onclick="if(confirm(`Are you sure? This action CANNOT be reversed.`)){window.location=`./?remove_food='.$food["ID"].'&menu_id='.$menu_id.'`}">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <span>'.$food['description'].'</span>
                </div>
                
                <div class="col-auto">
                    <span class="fw-bold text-primary font-monospace">'.$food['price'].'€</span>
                </div>
            </div>
        </div>
    </div>
</div>
';
}
} 

echo '
<div class="col">
<div class="card">
<div class="card-body bg-success rounded">
<button style="background-color: #40cc88" onclick="window.location.href = `http://michele-media.it/general/control-panel/menu-control/edit/add-element/?new_food_category=' . $categories['ID'].'`;"><span class="h4 fw-bold text-white">AGGIUNGI</span></button>
</div>
</div>
</div>

</div>
';




echo '

</div> </div>
</div>';


}
}

echo'
<div class="card">
<form action="./?menu_id='. $menu_id .'" method="POST">
<center>
<div class="card-body">
<form action="/utente-mfwaiter/tables.php" method="POST">
<input type="text" maxlength="30"name="new_section_title" class="form-control" placeholder="Nome" required>
<br><input type="text" maxlength="75"name="new_section_description" class="form-control" placeholder="Descrizione" required>
<br>



<select class="form-select" style="font-size: 15px" name="new_cat_option">
<option value="standard">Standard</option>
<option value="drink">Drink</option>
<option value="pizza">Pizza</option>
</select>



<br><button class="btn btn-success btn-lg px-5 border border-4 border border-success fs-4 font-monserrat fw-bold mx-3 px-4" style="float:center; margin-top:1%;" style="float:center; margin-top:2%; ">AGGIUNGI CATEGORIA</button>



</form> </div>'


?>
</center>


</div>


</div>
</div>

</div>
 </div> </div>
              </div>  </div>
             </main>
          </div>
       </div>
       <script src="./main.js"></script>
    </body>
 </html>
