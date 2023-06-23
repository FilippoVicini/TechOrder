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

// FIRST CHECK IF DELETE TABLE
// exit order
if(isset($_GET['ordine_uscito'])){
    $get_food = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `food` WHERE ID = ".$_GET['food']));
    $get_table = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tables WHERE ID = ".$_GET['table_id']));
    
    $ordine_uscito_id = $_GET['ordine_uscito'];
    $drink = $get_food['drink'];
    
    if($drink == 1){
        $food_recipe = $get_food['recipe'];
    
    
        // get stock
    
        $stock_id = "";
        switch($get_table['type']){
            case "bar":
                $stock_id = "24";
                break;
            case "restaurant":
                $stock_id = "23";
                break;
            case "beach":
                $stock_id = "26";
                break;
            default: 
                break;
        }
        
        $magazzino = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM magazzino WHERE id = ".$stock_id));
        $stock = json_decode($magazzino['stock']);

        // parse recipe
        $object_recipe = json_decode($food_recipe);
        foreach($object_recipe as $ingredient=>$requirement){
            
            foreach($stock as $category=>$subcategories){
                foreach($subcategories as $subcategory=>$elements){
                    foreach($elements as $element=>$quantity){
                        if($element == $ingredient){
                            $new_amount = ($quantity - $requirement > 0 ) ? ($quantity - $requirement) : 0;
                            $stock->$category->$subcategory->$element = $new_amount;
                        }
                    }
                }
            }
            
        }
        $new_stock = json_encode($stock);
        mysqli_query($conn, "UPDATE magazzino SET stock = '$new_stock' WHERE id = $stock_id");
    }
    
    $timestamp = date("Y-m-d H:i:s");
    $sql_update = "UPDATE orders SET `status` = 'exit', `datetime_exit`='$timestamp' WHERE `ID`='$ordine_uscito_id'";
    
    mysqli_query($conn, $sql_update);
    
    header("Location: /tavoli-camerieri-mfwaiter/");

}

//exit table
if(isset($_GET['tavolo_uscito'])){
    $table_id = $_GET['tavolo_uscito'];
    $timestamp = date("Y-m-d H:i:s");
    $sql_update = "UPDATE orders SET `status` = 'exit', `datetime_exit`='$timestamp' WHERE restaurant_id = $restaurant_id AND `table_id`='$table_id' AND status = 'preparing'";

    if (mysqli_query($conn, $sql_update)) {
    $ok = 'ok';
    } else {
    echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
    }
    header("Location: /tavoli-camerieri-mfwaiter/");
}



// Ok now that the hard login part is done, let's build the TABLES page

require '../menu-sopra/index.php' ;
pit4(4);
echo '
<meta http-equiv="refresh" content="20">
<body class="modern">'; 


// Now let's build the smart-big-box
echo '<div class="bigbox">';



// check number of tables active for that restaurtant
$sql_tables = "SELECT * FROM tables WHERE `restaurant_id` = '$restaurant_id' ORDER BY `ID` ASC";
$tables_result = mysqli_query($conn, $sql_tables);
$table_quantity = mysqli_num_rows($tables_result);



// And close the second box
echo '</div>';
// And close the second box
echo '</div>';



// Show tables information; we got table information 15 lines of code above! in table result!
echo '<title>Waiter</title>
<div class="row row-cols-3 row-cols-sm-3 row-cols-md-3 row-cols-lg-3" style="width: 90%; margin:auto">';
$p=0;
if (mysqli_num_rows($tables_result) > 0) {
    while($table = mysqli_fetch_assoc($tables_result)) {
       
        $table_id = $table['ID'];
        $table_name = $table['name'];
        
        $table_link = 'http://mf-shores.it/menu/?r=' . $table['ID']; 
        $sql_orders = "SELECT * FROM orders WHERE `table_id` = '$table_id' AND status='preparing' ORDER BY status ASC";
        $orders_result = mysqli_query($conn, $sql_orders);
        
        $sql_orders_notready = "SELECT * FROM orders WHERE `table_id` = '$table_id' AND status='active'";
        $orders_result_notready = mysqli_query($conn, $sql_orders_notready);
        
    if (mysqli_num_rows($orders_result) > 0) {
    $no_orders = FALSE;
      
        $stocazzo='#0ec94d';
         $sql_orders_ = "SELECT * FROM orders WHERE `table_id` = '$table_id'";
        $orders_result_ = mysqli_query($conn, $sql_orders_);
while($order=mysqli_fetch_assoc($orders_result_)) {
    if($order['status']=='accepted') $stocazzo='#ffd42e';
    elseif($order['status']=='active') $stocazzo='#ededed';
}
        echo '<div class="piccola_tavoli_fighi_cucina col-auto" style="display: inline-block; padding-bottom:10px; background-color:'.$stocazzo.'">
        <h1 class="text-center" style="margin:0">Tavolo: ' . $table['name'] . '
        <span style="float:right; margin-top:2%;">
        
        </span></h1>';
        
        
   echo '<center><hr>
   ';
   if($stocazzo == "#0ec94d") echo '<button class="btn btn-light fw-bold" style="color:blue" onclick="window.location.href = `/tavoli-camerieri-mfwaiter?tavolo_uscito='.$table_id.'`"><i class="bi bi-check-circle-fill" style="margin-right:10px"></i>USCITO TUTTO</button>';
   
   
   
        if(mysqli_num_rows($orders_result_notready)>0)echo'<h5 class="muted mt-2">Ancora da preparare: '.mysqli_num_rows($orders_result_notready).'</h5>';
   echo'</center><br>
        ';
        $maxcount = mysqli_num_rows($orders_result);
            $count = 0;
            while($order = mysqli_fetch_assoc($orders_result)) {
                // So the food id is...
                $food_id = $order['food_id'];
$food_status = $order['status'];
               
                // What about the food name?
                $sql_food = "SELECT * FROM food WHERE `ID` = '$food_id'";
                $food_result = mysqli_query($conn, $sql_food);
                
$bgcolor = "bg-warning";
if ($food_status == 'active') $bgcolor="bg-secondary";
if ($food_status == 'preparing') $bgcolor="bg-primary";
                if (mysqli_num_rows($food_result) > 0) {
                    while($food = mysqli_fetch_assoc($food_result)) {
                      echo'<div class="badge '.$bgcolor.' text-wrap mx-2 my-3 fs-3" onclick="event.preventDefault();

                window.location.href = `/tavoli-camerieri-mfwaiter?ordine_uscito=' . $order['ID'] . '&table_id='.$order['table_id'].'&food='.$food['ID'].'`">';
                        $food_name = $food['name'];
                        $count = $count + 1;
                        echo' <span syle="maxlength: 5">' . $food_name. ' </span>
                   </div> ';}
                   
                }else{
                    echo '<div class="badge bg-danger text-wrap mx-2 my-3 fs-3">Error</div>';
                }
            }
        echo'

        </div>';
    }
}
$p++;
}

// End of list
echo '</div><center>


<br>
</center>';

// Add a table
echo '

</div>
</div>
';
echo '<br><br><footer class="fixed-bottom mt-auto py-3 bg-light">
  <div class="container" style="max-width:400px !important;">
    <span class="text-muted" style="text-align:center !important;"> Copyright <a href="https://mf-digital.com/"> MF-Digital.</a> All rights reserved.</span>
  </div>
</footer>';


?>