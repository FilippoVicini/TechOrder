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



// FIRST CHECK IF THERE IS SOMETHING TO DELETE
if(isset($_GET['delete_food'])){
// if it's needed, change the order status to paid and set paid datetime
$delete_food = $_GET['delete_food'];
$sql_update = "UPDATE food SET `status` = 'deleted' WHERE `ID`= '$delete_food'";

mysqli_query($conn, $sql_update);}

// Category Info
$category_name = "Categoria";
$menu_id = "";
if(isset($_GET['new_food_category'])){
    $query = "SELECT * FROM categories WHERE id = ".$_GET['new_food_category'];
    $res = mysqli_query($conn, $query);
    while($category = mysqli_fetch_assoc($res)){
        $category_name = $category['name'];
        $menu_id = $category['menu_id'];
    }
}

    function startsWith($haystack,$needle,$case=true) {
        if($case){return (strcmp(substr($haystack, 0, strlen($needle)),$needle)===0);}
        return (strcasecmp(substr($haystack, 0, strlen($needle)),$needle)===0);
    }

//Create food
if(isset($_POST['new_food_name'])){
    $name = $_POST['new_food_name'];
    $desc = $_POST['new_food_description'];
    $price = $_POST['new_food_price'];
    $category_id = $_GET['new_food_category'];
    $timestamp = date("Y-m-d");
    
    $drink = 0;
    $pizza = 0;
    $query = "SELECT * FROM categories WHERE id = $category_id";
    $res = mysqli_query($conn, $query);
    while($category = mysqli_fetch_assoc($res)){
        $drink = $category['drink'];
        $pizza = $category['pizzeria'];
    }
    
    $position = 0;
    $query = "SELECT * FROM food WHERE category_id = ".$_GET['new_food_category'];
    $res = mysqli_query($conn, $query);
    while($food = mysqli_fetch_assoc($res)){
        if ($food['position_in_category'] > $position) $position = $food['position_in_category'];
    }
    $position = $position + 1;
    
    $recipe = array();
    foreach($_POST as $key=>$value){
        if(startsWith($key, "new_food_ingredient_") && $value != ""){
            $quantity = $value;
            $ingredient = substr($key, 20);
            $recipe[$ingredient] = $quantity;
        }
    }
    $recipeJSON = json_encode($recipe);
    
    $query = "INSERT INTO food (`name`, `restaurant_id`, `category_id`, `date_added`, `description`, `drink`, `pizzeria`, `position_in_category`, `status`, `currency`, `price`, `recipe`) VALUES ('$name', '$restaurant_id', '$category_id', '$timestamp', '$desc', '$drink', '$pizza', '$position+1', 'active', '€', '$price', '$recipeJSON')";
    mysqli_query($conn, $query);
    
    header("location: ../?menu_id=".$menu_id);
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
       <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
       <link rel="stylesheet" type="text/css" href="./main.css">
       <link rel="stylesheet" type="text/css" href="./utils.css">
      
    </head>
    <body style="font-family: 'Inter', sans-serif;">
      <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
         <?php
       require "../../../../navbar/index.php";
nav4(4); ?>
          <div class="flex-lg-1 h-screen overflow-y-lg-auto">
        
             <header>
                <div class="container-fluid">
                   <div class="border-bottom pt-6">
                      <div class="row align-items-center">
                         <div class="col-sm col-12">
                            <h1 class="h2 ls-tight"><span class="d-inline-block me-3"></span>Aggiungi Elemento in: "<?php echo  $category_name ?>"</h1>
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


?>

<div class="col-auto my-1" style="
    margin-left: 10%;
    margin-right: 10%;
">
<div class="card border-warning pb-4" style="border-width: thin">

<form action="./?new_food_category=<?php echo $_GET['new_food_category'] ?>" method="POST">
<center>
<div id="main" class="piccola_aggcategoria" >
<form action="/utente-mfwaiter/tables.php" method="POST">
<input type="text" maxlength="75"name="new_food_name" style="background-color:#ffffff; border:3px; width:30%; height:50px; font-size: 16px; outline:none; margin-top:1%; margin-bottom:1%; border: 2px solid #ababab; border-radius:10px; color: black" class="px-3" placeholder="Nome del piatto" required>
<br><input type="text" maxlength="75"name="new_food_description" style="background-color:#ffffff; border:3px; width:80%; height:50px; font-size: 16px; outline:none; margin-top:1%; margin-bottom:1%; border: 2px solid #ababab; border-radius:10px; color: black" class="px-3" placeholder="Descrizione" required>
<input class="font-monospace"required type="number" name="new_food_price" step=".10" placeholder="Prezzo" style="background-color: #ffffff; margin-top:1%; margin-bottom:1%; border:none; width: 12.5%; resize: none; font-size: 16px; outline:none; border-radius:10px; padding:10px; padding-right:0; text-align:left; color: black"></input>

        
        
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel">Imposta ricetta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <?php
                $menu_type = "";
                $query = "SELECT * FROM menu WHERE id = ".$menu_id;
                $rest = mysqli_query($conn, $query);
                while($a = mysqli_fetch_assoc($rest)){
                    $menu_type = $a['type'];
                }
                
                $query = "SELECT * FROM magazzino WHERE id = ";
                switch($menu_type){
                    case "bar":
                        $query .= "24";
                        break;
                    case "restaurant":
                        $query .= "23";
                        break;
                    case "beach":
                        $query .= "26";
                        break;
                    default: 
                        break;
                }
                $rest = mysqli_query($conn, $query);
                while($a = mysqli_fetch_assoc($rest)){
                    $stock = json_decode($a['stock']);
                    foreach($stock as $category=>$subcategories){
                        if($category != "Ammenities" && $category != "Bevande"){
                            foreach($subcategories as $subcategory=>$elements){
                                foreach($elements as $element=>$quantity){
                                    echo '<input class="form-control" type="number" placeholder="Quantità di '.$element.'" name="new_food_ingredient_'.$element.'"></input>';
                                }
                            }
                        }
                    }
                }
        
            ?>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">Continua</button>
      </div>
    </div>
  </div>
</div>


<a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle" role="button">Ricetta</a>



<br><button id="add_" class="btn btn-success btn-lg px-5 border border-4 border border-success fs-4 font-Monterrat fw-light-bold mx-3 px-4" style="float:center; margin-top:2%; margin-bottom:2%; ">AGGIUNGI ELEMENTO</button>
</form></div>
</center>


             </main>
          </div>
       </div>
       <script src="./main.js"></script>
    </body>
 </html>
