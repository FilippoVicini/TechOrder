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

// FIRST CHECK IF DELETE TABLE

// delete table
if(isset($_GET['delete_table'])){
    // if it's needed, change the table status to deleted and set deleted datetime
    $delete_table = $_GET['delete_table'];
    $timestamp = date("Y-m-d H:i:s");
    $sql_update = "UPDATE tables SET `status` = 'deleted' WHERE `ID`='$delete_table'";

                if (mysqli_query($conn, $sql_update)) {
                $ok = 'ok';
                } else {
                echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
                }
                
}

// SECOND CHECK IF ADD TABLE
if(isset($_POST['new_table_name'])){
    // if it's needed, add a table
    $new_table_name = $_POST['new_table_name'];
    $timestamp = date("Y-m-d H:i:s");
    $sql_update = "INSERT INTO tables (`name`, `restaurant_id`, `status`) VALUES ('$new_table_name', '$restaurant_id', 'active')";

                if (mysqli_query($conn, $sql_update)) {
                $ok = 'ok';
                } else {
                echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
                }
}

// THIRD CHECK IF MODIFY COPERTO
if(isset($_POST['coperto'])){
    // if it's needed, add a table
    $new_coperto = $_POST['coperto'];
    $timestamp = date("Y-m-d H:i:s");
    $sql_update = "UPDATE food SET `price` = '$new_coperto' WHERE `restaurant_id`='$restaurant_id' AND `status`='coperto' ";

                if (mysqli_query($conn, $sql_update)) {
                $ok = 'ok';
                } else {
                echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
                }
}


// Ok now that the hard login part is done, let's build the TABLES page

require '../menu-sopra/index.php' ;
pit4(5);
echo '<meta http-equiv="refresh" content="200000">
        <body class="modern">
<center>
        
</div>

<div class="MF-DigitalWaiter_title_panel">
            <h1 class="MF-DigitalWaiter_title" style="font-family: montserrat !important;">ORDINI SPIAGGIA</h1>
        </div>
            <br><p class="MF-DigitalWaiter_subtitle-login" style="text-align:center; margin-top:-30; color: lightgrey;" style="text-align:center; margin-top:-30">Developed by:
<a href= "https://www.mf-digital.com" class="MF-DigitalWaiter_subtitle-login" style="text-align:center; margin-top:-30; color: lightgrey;"> MF-Digital ®️
</a>
 
        
        </div>
        
        </center>'; 


// Now let's build the smart-big-box

echo '<div class="bigbox">';

// The first section
echo '';

// check number of tables active for that restaurtant

$sql_tables = "SELECT * FROM tables WHERE `restaurant_id` = '$restaurant_id' AND `status` = 'active' ORDER BY `ID` ASC";
$tables_result = mysqli_query($conn, $sql_tables);

$table_quantity = mysqli_num_rows($tables_result);



// And close the second box
echo '</div>';

// The COPERTO section
echo '';




// And close the second box
echo '</div>';

// Show tables information; we got table information 15 lines of code above! in table result!
echo '<div class="row row-cols-5 row-cols-sm-5 row-cols-md-5 row-cols-lg-5 align-items-stretch" style="width: 99%; margin:auto">';
if (mysqli_num_rows($tables_result) > 0) {
    while ($table = mysqli_fetch_assoc($tables_result)) {
        $table_id = $table["ID"];
        $table_name = $table["name"];

        $table_link = "../../menu/?r=" . $table["ID"];
        $sql_orders = "SELECT * FROM orders WHERE `table_id` = '$table_id' AND (status='accepted' OR status='preparing' OR status='active') AND drink = 0 AND pizzeria = 1 ORDER BY status ASC";
        $orders_result = mysqli_query($conn, $sql_orders);

        $sql_orders_notready = "SELECT * FROM orders WHERE `table_id` = '$table_id' AND pizzeria = 0 AND status='active'";
        $orders_result_notready = mysqli_query($conn, $sql_orders_notready);

        if (mysqli_num_rows($orders_result) > 0) {
            $no_orders = false;

            echo '<div class="piccola_tavoli_fighi_cucina col pop" style="display: inline-block; padding-bottom:10px;" onclick="window.location=`' .
                "../../ordini-pertavolo/?table_id=" .
                $table_id .
                '`">
        
        <h2 class="text-center" style="margin:0"><h4 class="text-table">Tavolo</h4> <h4 class="number-table"> ' .
                $table["name"] .
                '</h4>
        <span style="float:right; margin-top:1%;">
        
        </span></h2>
   <center><hr style="margin:1%">
        <h6 class="muted mt-2" style="font-size:15px">Ordini da preparare: ' .
                mysqli_num_rows($orders_result_notready) .
                '</h6>
   </center>
        ';

            $maxcount = mysqli_num_rows($orders_result);
            $count = 0;
            while ($order = mysqli_fetch_assoc($orders_result)) {
                // So the food id is...
                $food_id = $order["food_id"];
                $food_status = $order["status"];
                // food priority
                $food_priority = $order["portata"] + 1;
                // What about the food name?
                $sql_food = "SELECT * FROM food WHERE `ID` = '$food_id'";
                $food_result = mysqli_query($conn, $sql_food);

                $bgcolor = "bg-warning";
                if ($food_status == "active") {
                    $bgcolor = "bg-secondary";
                }
                if ($food_status == "preparing") {
                    $bgcolor = "bg-primary";
                }
                if (mysqli_num_rows($food_result) > 0) {
                    while ($food = mysqli_fetch_assoc($food_result)) {
                        echo '<div class="badge ' .
                            $bgcolor .
                            ' text-wrap mx-2 my-1" >';

                        $food_name = $food["name"];
                        $count = $count + 1;
                        echo "[" . $food_priority . "] " . $food_name;
                        $sum = $sum + $food["price"];
                        echo " </div>";
                    }
                } else {
                    echo "error in getting food name line 196 of code ask assistance";
                }
            }
            echo '

        </div>';
        }
    }
}

// End of list
echo '</div><center>


<br>
</center>';

// Add a table
echo '

</div>
</div>
<br>';
echo '<br><br><footer class="fixed-bottom mt-auto py-3 bg-light">
  <div class="container" style="max-width:400px !important;">
    <span class="text-muted" style="text-align:center !important;"> Copyright <a href="https://mf-digital.com/"> MF-Digital.</a> All rights reserved.</span>
  </div>
</footer>';

?>
