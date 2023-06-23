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

// Look for credentials
if((!isset($_SESSION['email'])) OR (!isset($_SESSION['password']))){
    $_SESSION['error'] = "Your session expired";
    header("location: /login");
    exit;
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

// Ok now that the hard login part is done, let's build the cucina-mfwaiter page

$order_table = $_GET['table_id'];
$order_priority = $_GET['priority'];


        
    



// --- FIRST CHECK IF CHANGING AN ORDER STATUS IS NEEDED --- //

// accept order
if(isset($_GET['ordine_accettato'])){
    // if it's needed, change the order status to preparing and set preparing datetime
    $ordine_accettato_id = $_GET['ordine_accettato'];
    $timestamp = date("Y-m-d H:i:s");
    $sql_update = "UPDATE orders SET `status` = 'accepted', `datetime_accepted`='$timestamp' WHERE `ID`='$ordine_accettato_id'";

                if (mysqli_query($conn, $sql_update)) {
                $ok = 'ok';
                } else {
                echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
                }
}

// prepare order
if(isset($_GET['prepare_order'])){
    // if it's needed, change the order status to preparing and set preparing datetime
    $prepare_order_id = $_GET['prepare_order'];
    $timestamp = date("Y-m-d H:i:s");
    $sql_update = "UPDATE orders SET `status` = 'preparing', `datetime_preparing`='$timestamp' WHERE `ID`='$prepare_order_id'";

                if (mysqli_query($conn, $sql_update)) {
                $ok = 'ok';
                } else {
                echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
                }
}

// exit order
if(isset($_GET['ordine_uscito'])){
    // if it's needed, change the order status to exit and set exit datetime
    $ordine_uscito_id = $_GET['ordine_uscito'];
    $timestamp = date("Y-m-d H:i:s");
    $sql_update = "UPDATE orders SET `status` = 'exit', `datetime_exit`='$timestamp' WHERE `ID`='$ordine_uscito_id'";

                if (mysqli_query($conn, $sql_update)) {
                $ok = 'ok';
                } else {
                echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
                }
}

// delete order
if(isset($_GET['delete_order'])){
    // if it's needed, change the order status to deleted and set deleted datetime
    $delete_order_id = $_GET['delete_order'];
    $timestamp = date("Y-m-d H:i:s");
    $sql_update = "UPDATE orders SET `status` = 'deleted', `datetime_deleted`='$timestamp' WHERE `ID`='$delete_order_id'";

                if (mysqli_query($conn, $sql_update)) {
                $ok = 'ok';
                } else {
                echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
                }
}




require '../menu-sopra/index.php' ;
pit4(1);
echo '
        <body class="modern">
<center>

 
        
        <div class="MF-DigitalWaiter_title_panel">
            <h1 class="MF-DigitalWaiter_title" style="font-family: montserrat !important;">ORDINI PIZZERIA</h1>
        </div>
            <br><p class="MF-DigitalWaiter_subtitle-login" style="text-align:center; margin-top:-30; color: lightgrey;" style="text-align:center; margin-top:-30">Developed by:
<a href= "https://www.mf-digital.com" class="MF-DigitalWaiter_subtitle-login" style="text-align:center; margin-top:-30; color: lightgrey;"> MF-Digital ®️
</a>
        
        <br><br><button class="btn btn-outline-dark fs-3 font-montserrat fs-5 fw-bold mb-4" onclick="location.href = `/ordini-tutti`"><i class="bi bi-arrow-left-circle" style="margin-right:20px"></i>TUTTI GLI ORDINI</button>';
        
        
    if($order_priority == 0){
        echo'
        <div class="btn-group btn-group-lg" role="group">
          <button type="button" class="btn btn-primary" onclick="window.location.href = `http://mf-shores.it/ordini-pertavolo-pizzeria/?table_id='.$order_table.'&priority=0`">Prima Portata</button>
          <button type="button" class="btn btn-outline-primary" onclick="window.location.href = `http://mf-shores.it/ordini-pertavolo-pizzeria/?table_id='.$order_table.'&priority=1`">Seconda Portata</button>
          <button type="button" class="btn btn-outline-primary" onclick="window.location.href = `http://mf-shores.it/ordini-pertavolo-pizzeria/?table_id='.$order_table.'&priority=2`">Terza Portata</button>
          <button type="button" class="btn btn-outline-primary" onclick="window.location.href = `http://mf-shores.it/ordini-pertavolo-pizzeria/?table_id='.$order_table.'&priority=3`">Tutte le Portate</button>
        </div>
        
        </center>';
    }
    else if($order_priority == 1){
        echo'
        <div class="btn-group btn-group-lg" role="group">
          <button type="button" class="btn btn-outline-primary" onclick="window.location.href = `http://mf-shores.it/ordini-pertavolo-pizzeria/?table_id='.$order_table.'&priority=0`">Prima Portata</button>
          <button type="button" class="btn btn-primary" onclick="window.location.href = `http://mf-shores.it/ordini-pertavolo-pizzeria/?table_id='.$order_table.'&priority=1`">Seconda Portata</button>
          <button type="button" class="btn btn-outline-primary" onclick="window.location.href = `http://mf-shores.it/ordini-pertavolo-pizzeria/?table_id='.$order_table.'&priority=2`">Terza Portata</button>
          <button type="button" class="btn btn-outline-primary" onclick="window.location.href = `http://mf-shores.it/ordini-pertavolo-pizzeria/?table_id='.$order_table.'&priority=3`">Tutte le Portate</button>
        </div>
        
        </center>';
    }
    else if($order_priority == 2){
        echo'
        <div class="btn-group btn-group-lg" role="group">
          <button type="button" class="btn btn-outline-primary" onclick="window.location.href = `http://mf-shores.it/ordini-pertavolo-pizzeria/?table_id='.$order_table.'&priority=0`">Prima Portata </button>
          <button type="button" class="btn btn-outline-primary" onclick="window.location.href = `http://mf-shores.it/ordini-pertavolo-pizzeria/?table_id='.$order_table.'&priority=1`">Seconda Portata</button>
          <button type="button" class="btn btn-primary" onclick="window.location.href = `http://mf-shores.it/ordini-pertavolo-pizzeria/?table_id='.$order_table.'&priority=2`">Terza Portata</button>
          <button type="button" class="btn btn-outline-primary" onclick="window.location.href = `http://mf-shores.it/ordini-pertavolo-pizzeria/?table_id='.$order_table.'&priority=3`">Tutte le Portate</button>
        </div>
        
        </center>';
    }
    else if($order_priority == 3){
                echo'
        <div class="btn-group btn-group-lg" role="group">
          <button type="button" class="btn btn-outline-primary" onclick="window.location.href = `http://mf-shores.it/ordini-pertavolo-pizzeria/?table_id='.$order_table.'&priority=0`">Prima Portata</button>
          <button type="button" class="btn btn-outline-primary" onclick="window.location.href = `http://mf-shores.it/ordini-pertavolo-pizzeria/?table_id='.$order_table.'&priority=1`">Seconda Portata</button>
          <button type="button" class="btn btn-outline-primary" onclick="window.location.href = `http://mf-shores.it/ordini-pertavolo-pizzeria/?table_id='.$order_table.'&priority=2`">Terza Portata</button>
          <button type="button" class="btn btn-primary" onclick="window.location.href = `http://mf-shores.it/ordini-pertavolo-pizzeria/?table_id='.$order_table.'&priority=3`">Tutte le Portate</button>
        </div>
        
        </center>';
    }
        
 echo'      
<center><hr></center>';
 
        
        

// Now let's build the big-order-box     
echo '<div class="bigbox">';

// Get data of orders PHP semi static version (you need to reload the page every time)

$order_table = $_GET['table_id'];
$order_priority = $_GET['priority'];

// FIRST, the 'preparing' orders
$sql_orders = $sql_orders = "SELECT * FROM orders WHERE `restaurant_id` = '$restaurant_id' AND `status` = 'preparing' AND drink = 0 AND pizzeria = 1 AND table_id = $order_table ORDER BY `ID` DESC";
if($order_priority != 3) $sql_orders = "SELECT * FROM orders WHERE `restaurant_id` = '$restaurant_id' AND `status` = 'preparing' AND drink = 0 AND pizzeria = 1 AND table_id = $order_table AND portata = $order_priority ORDER BY `ID` DESC";
$orders_result = mysqli_query($conn, $sql_orders);

if (mysqli_num_rows($orders_result) > 0) {
    $no_orders = FALSE;
    
    while($order = mysqli_fetch_assoc($orders_result)) {
        // So here's our food id of that order
        $food_id = $order['food_id'];
        $table_id = $order['table_id'];
        $order_id = $order['ID'];
        $order_note = $order['note'];
        $order_priority = $order['portata']+1;
        $order_status = $order['status'];
        
        $order_display_string = "";

        switch($order_status){
            case "active": 
                $order_display_string .= '<div class="piccola_grigia" style="padding-bottom:0px !important;">';
                break;
            case "accepted":
                $order_display_string .= '<div class="piccola_exit" style="position: initial; padding-bottom:10px !important;">';
                break;
                
            default: //errore
                break;
        }
        

        // And let's query the food name using the order's food ID
        $sql_food = "SELECT * FROM food WHERE `ID` = '$food_id' AND `status` = 'active'";
        $food_result = mysqli_query($conn, $sql_food);

        if (mysqli_num_rows($orders_result) > 0) {
            $color= array('red','green','orange','blue','pink');
            while($food = mysqli_fetch_assoc($food_result)) {
                // So the food name is... 
                $food_name = $food['name'];
                // Let's pick a color

                $order_display_string .= '<div style="display: block;
           
                float:center;
                "><center><h2 class="food_name font-weight-bold"><span "> </span>' . $food_name . '</h2></center>';
            }
        }
        else $order_display_string .= 'Errore';
        

        // At this point we need to retrieve information about the table name of that order
        $sql_table = "SELECT * FROM tables WHERE `ID` = '$table_id'";
        $table_result = mysqli_query($conn, $sql_table);

        if (mysqli_num_rows($table_result) > 0) {
            while($table = mysqli_fetch_assoc($table_result)) {
                // So the table name and status are... 
                $table_name = $table['name'];
                
                $order_display_string .= ' <span style="font-weight:bold; font-size:20px; background-color:yellow">' . $order_note . '  </span>';
                
                
                $order_display_string .= '<p class="text-right mr-3" style="text-align:right!important; color: #000000; font-weight:bold;"></p></div>'; 
                
                             
            }
        }
        else $order_display_string .= 'errore';
        
        
        // Bottoni
        switch($order_status){
            case "active": 
                $order_display_string .= '<div style=" display:inline-block; margin-bottom:5px"> 
                        <div class="button_container" style="float:none; margin:0;">
                            <button class="btn btn-success btn-lg fs-3 border border-success border border-3 fw-bold font-monserrat" onclick="
                            window.location.href = `/ordini-pertavolo?ordine_accettato=' . $order_id . '&table_id='.$order_table.'`;"">ACCETTA</button>
                            
                            <button class="btn btn-danger btn-lg fs-3 border border-danger border border-3 fw-bold font-monserrat" onclick="if (window.confirm(`Se annulli questo ordine, non potrai più recuperarlo. ATTENZIONE: verrà rimosso anche dalla CASSA`))
                                window.location.href = `/ordini-pertavolo?delete_order=' . $order_id . '&table_id='.$order_table.'`;" style=" font-size: 22px !important; ;">ANNULLA</button>
                        </div>
                    </div>';
                break;
                
            case "accepted":
                $order_display_string .= '<div style="width:60%; display:inline;"> 
                        <div class="button_container" style="float: initial; margin-top:0; margin-bottom: 0;">
                            <button class="btn btn-primary btn-lg fs-3 border border-primary border border-3 fw-bold font-monserrat" onclick="
                            window.location.href = `/ordini-pertavolo?prepare_order=' . $order_id . '&table_id='.$order_table.'`;"><i class="bi bi-check-all" style="margin-right:5px"></i>PRONTO</button>
                           
                        </div>
                    </div>';
                break;
                
            default: //errore / preparing
                break;
        }

        // And close the smart-big-box
        $order_display_string .= '</div>';
        $order_display_array[] = $order_display_string;

    }
}
else $no_orders = TRUE;

// Create rows for each priority & insert $order_display_array[i] accordingly

$query = $sql_orders = "SELECT * FROM orders WHERE `restaurant_id` = '$restaurant_id' AND drink = 0 AND pizzeria = 0 AND table_id = $order_table AND portata = 0 AND status != 'preparing' AND status != 'exit'";
$first = mysqli_num_rows(mysqli_query($conn, $query));

$query = $sql_orders = "SELECT * FROM orders WHERE `restaurant_id` = '$restaurant_id' AND drink = 0 AND pizzeria = 0 AND table_id = $order_table AND portata = 1 AND status != 'preparing' AND status != 'exit'";
$second = mysqli_num_rows(mysqli_query($conn, $query));

$query = $sql_orders = "SELECT * FROM orders WHERE `restaurant_id` = '$restaurant_id' AND drink = 0 AND pizzeria = 0 AND table_id = $order_table AND portata = 2 AND status != 'preparing' AND status != 'exit'";
$third = mysqli_num_rows(mysqli_query($conn, $query));


$j = 0;
if($first > 0){
    
    echo '<div class="d-flex align-items-start bg-light mb-3"> <div class="col pop piccola_grigia" style="margin-right:10px; padding-bottom:0px !important; border-color: #8e8d92;"><h2 >PRIMA PORTATA</h2>';
    for($i = 0; $i < $first; $i++) { echo $order_display_array[$i]; $j++;} //porco dio se sono intelligente
    echo '</div>';
}

if($second > 0){
    echo '<div class="col pop piccola_grigia" style="margin-right:10px;padding-bottom:0px !important;border-color: #8e8d92; "><h2 ">SECONDA PORTATA</h2>';
    for($i = 0; $i < $second; $i++) { echo $order_display_array[$j]; $j++;}
    echo '</div>';
}

if($third > 0){
    echo '<div class="col pop piccola_grigia" style="margin-right:10px; padding-bottom:0px !important; border-color: #8e8d92;"><h2 ">TERZA PORTATA</h2>';
    for($i = 0; $i < $third; $i++) { echo $order_display_array[$j]; $j++;}
    echo '</div></div>';
}


///////////////////





if($no_orders){
        // there are no orders
        echo '<center>
        <br><br><br>
        In attesa di nuovi ordini
        <p id="points"></p>
        </center>
        <script>
        setTimeout(function() {
            var paragraph = document.getElementById("points");
            paragraph.textContent += "• ";
        }, 2000);
        setTimeout(function() {
            var paragraph = document.getElementById("points");
            paragraph.textContent += "• ";
    
        }, 4000);
        setTimeout(function() {
            var paragraph = document.getElementById("points");
            paragraph.textContent += "";
            paragraph.textContent += "•";
    
        }, 6000);
        setTimeout(function() {
            location.reload();
        }, 8000);
    </script>';
}

echo '</body>';
echo '<br><br><footer class="fixed-bottom mt-auto py-3 bg-light">
  <div class="container" style="max-width:400px !important;">
    <span class="text-muted" style="text-align:center !important;"> Copyright <a href="https://mf-digital.com/"> MF-Digital.</a> All rights reserved.</span>
  </div>
</footer>';

?>
