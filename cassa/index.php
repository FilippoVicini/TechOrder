<?php
$restaurant_id = "";
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

// Look for credentials
if ((!isset($_SESSION['email'])) or (!isset($_SESSION['password'])))
{
    $_SESSION['error'] = "Login Failed";
    header("location: /login");
    exit;
}

$email = $_SESSION['email'];
$password = $_SESSION['password'];

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
// Ok now that the hard login part is done, let's build the cassa page
require '../menu-sopra/index.php';
pit4(2);
?>
<head> <link href="./styles.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.3.5/signature_pad.min.js" integrity="sha512-kw/nRM/BMR2XGArXnOoxKOO5VBHLdITAW00aG8qK4zBzcLVZ4nzg7/oYCaoiwc8U9zrnsO9UHqpyljJ8+iqYiQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
       var canvas = document.getElementById("signature-pad");

       function resizeCanvas() {
           var ratio = Math.max(window.devicePixelRatio || 1, 1);
           canvas.width = canvas.offsetWidth * ratio;
           canvas.height = canvas.offsetHeight * ratio;
           canvas.getContext("2d").scale(ratio, ratio);
       }
       window.onresize = resizeCanvas;
       resizeCanvas();

       var signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(250,250,250)'
       });

       document.getElementById("clear").addEventListener('click', function(){
        signaturePad.clear();
       })
   </script></head>
   
     <?php echo '  <body class="modern" style="display:block !important; background-color: white !important">
<center>
        <div class="MF-DigitalWaiter_title_panel">
            <h1 class="MF-DigitalWaiter_title" style="font-family: montserrat !important;">ORDINI DA PAGARE</h1>
        </div>
            <br><p class="MF-DigitalWaiter_subtitle-login" style="text-align:center; margin-top:-30; color: lightgrey;" style="text-align:center; margin-top:-30">Developed by:
<a href= "https://www.mf-digital.com" class="MF-DigitalWaiter_subtitle-login" style="text-align:center; margin-top:-30; color: lightgrey;"> MF-Digital ®️
</a>

        </div>
        <br><br><button class="btn btn-outline-dark fs-3 font-montserrat fs-5 fw-bold" onclick="location.href = `/cassa`"><i class="bi bi-arrow-clockwise" style="margin-right:20px"></i>AGGIORNA ORDINI</button>
        

            
        
        </center>';

// --- FIRST CHECK IF CHANGING AN ORDER STATUS IS NEEDED --- //
// pay order
$clean = false;

if (isset($_GET['pay_order_table']) || isset($_POST['pay_order_table']))
{
    $pay_order_table = isset($_GET['pay_order_table']) ? $_GET['pay_order_table'] : $_POST['pay_order_table'];
    $query = "UPDATE orders SET status = 'paid' WHERE table_id = $pay_order_table AND status = 'exit'";
    mysqli_query($conn, $query);

    $clean = true;
}

// add payment to total of client
if (isset($_POST['payment']))
{
    $payment = $_POST['payment'];
    $client_id = $_POST['client'];
    $query = "UPDATE clients SET payment = payment+$payment WHERE id = $client_id"; //sum of payment for hotel clients
    mysqli_query($conn, $query);

    $clean = true;
}

// delete order
if (isset($_GET['delete_order_table']))
{
    $delete_order_table = $_GET['delete_order_table'];
    $sql_update = "DELETE FROM orders WHERE table_id = $delete_order_table";
    mysqli_query($conn, $sql_update);

    $clean = true;
}

// Clean requests
if ($clean)
{
    header("Location: ./");
    exit();
}

// Now let's build the big-order-box
echo '<div class="bigbox">';

// Get data of orders PHP semi static version (you need to reload the page every time)
// FIRST let's get data about the tables of that restaurant
$sql_tables = "SELECT * FROM tables WHERE `restaurant_id` = '$restaurant_id'  ORDER BY `name` ASC";
$tables_result = mysqli_query($conn, $sql_tables);

$no_orders = true;

if (mysqli_num_rows($tables_result) > 0)
{
    // THE UPDATE BUTTON
    echo '<center>
    
    </center>
   
    </center>';

    while ($table = mysqli_fetch_assoc($tables_result))
    {
        // So here's our table data
        $table_id = $table['ID'];
        $table_name = $table['name'];

        // And let's query the food ordered at that table already EXIT status
        $sql_orders = "SELECT * FROM orders WHERE `table_id` = '$table_id' AND `status` = 'exit'";
        $orders_result = mysqli_query($conn, $sql_orders);

        if (mysqli_num_rows($orders_result) > 0)
        {
            $no_orders = false;

            // Well, there is data in this table let's build the single-order-box
            echo '<div class="piccola" style="display: inline-block; padding-bottom:10px; width: -webkit-fill-available;">';

            echo '<div style="display: block;
            width: 50%;
            float:left;
            "><h3 class="food_name">Tavolo: ' . $table_name . '</h3>';

            $sum = 0;

            echo '<br><p style="font-weight:bold; color:green"> DA PAGARE: </p>
            <hr style="width:100px; margin-top:-2.5%; border-color:green; opacity:1">';
            $maxcount = mysqli_num_rows($orders_result);
            $count = 0;
            while ($order = mysqli_fetch_assoc($orders_result))
            {
                // So the food id is...
                $food_id = $order['food_id'];

                // What about the food name?
                $sql_food = "SELECT * FROM food WHERE `ID` = '$food_id'";
                $food_result = mysqli_query($conn, $sql_food);

                if (mysqli_num_rows($food_result) > 0)
                {
                    while ($food = mysqli_fetch_assoc($food_result))
                    {
                        $food_name = $food['name'];
                        $count = $count + 1;
                        echo $food_name;
                        $sum = $sum + $food['price'];
                    }
                    if ($count < $maxcount) echo ', ';
                }
                else
                {
                    echo 'error in getting food name line 196 of code ask assistance';
                }
            }

            // Ok but I'm curious and I want to know if there are other orders not yet EXIT
            $sql_orders = "SELECT * FROM orders WHERE `table_id` = '$table_id' AND (`status` = 'active' OR `status` = 'preparing')";
            $orders_result = mysqli_query($conn, $sql_orders);

            if (mysqli_num_rows($orders_result) > 0)
            {
                echo '<br><br> <p style="font-weight:bold; color:red"> NON USCITI: </p>
                <hr style="width:100px; margin-top:-2.5%; border-color:red; opacity:1">';
                $maxcount = mysqli_num_rows($orders_result);
                $count = 0;
                while ($order = mysqli_fetch_assoc($orders_result))
                {
                    // So the food id is...
                    $food_id = $order['food_id'];

                    // What about the food name?
                    $sql_food = "SELECT * FROM food WHERE `ID` = '$food_id'";
                    $food_result = mysqli_query($conn, $sql_food);

                    if (mysqli_num_rows($food_result) > 0)
                    {
                        while ($food = mysqli_fetch_assoc($food_result))
                        {
                            $food_name = $food['name'];
                            $count = $count + 1;
                            echo $food_name;
                        }
                        if ($count < $maxcount) echo ', ';
                    }
                    else
                    {
                        echo 'error in getting food name line 223 of code ask assistance';
                    }
                }
            }

            // Let's add a div to the right for a couple buttons
            echo '</div>
            
            <div><div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalToggleLabel"">Pagamento Cliente</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body mb-3">
Scegli il cliente che sta pagando:
    <form action="" method="POST">
    <select name="client">';

            $query = "SELECT * FROM clients WHERE restaurant_id = $restaurant_id";
            $clients_res = mysqli_query($conn, $query);

            while ($client = mysqli_fetch_assoc($clients_res))
            {
                $room_name = "Camera";
                $query = "SELECT * FROM rooms WHERE id = " . $client['room'];
                $room_res = mysqli_query($conn, $query);

                while ($room = mysqli_fetch_assoc($room_res))
                {
                    $room_name = $room['name'];
                }

                echo '<option value="' . $client['ID'] . '">' . $room_name . '     (' . $client['name'] . ')</option>';
            }

            echo '
    </select>
    <input type="hidden" name="payment" value="' . $sum . '" />
    <input type="hidden" name="pay_order_table" value="' . $table_id . '" />
    <div class="flex-row">
       <div class="wrapper">
           <canvas id="signature-pad" width="400" height="200"></canvas>
       </div>
       <div class="clear-btn">
           <button id="clear"><span> Clear </span></button>
       </div>
   </div>
    <button class="btn btn-primary">Invia</button>
    </form>
</div>
</div>
</div>
</div>
</div>
            
            
            <div style="width:50%; display:inline;"> 
                <div class="button_container">
                
                <button class="text-align:right!important; btn btn-success btn-lg px-5 fs-3 fw-bold font-monserrat" onclick="

                    window.location.href = `/cassa?pay_order_table=' . $table_id . '`;

                    ">PAGA</button>
                    
                    <a class="text-align:right!important; btn btn-primary btn-lg px-5 fs-3 fw-bold font-monserrat" data-bs-toggle="modal"` href="#exampleModalToggle" role="button">CLIENTE</a>
                    
                    
                    <button class="text-align:right!important; btn btn-danger btn-lg px-4 fs-3 fw-bold font-monserrat" onclick="

                    var ask = window.confirm(`Se annulli questo ordine, non potrai più recuperarlo. ATTENZIONE: verrà rimosso anche dalla CASSA`);
                    if (ask) {
                        window.location.href = `/cassa?delete_order_table=' . $table_id . '`;
                    }

                    ">ANNULLA</button>
                </div>
            </div>
            
            <br><br><br><br><h1 class="text-right mx-3" style="text-align:right!important; color: #106cfc; font-weight:bold;"><i class="bi bi-cash-coin" style="margin-right:10px; color:grey"></i>Totale: ' . $sum . '€</h1><h4 class="text-right mx-3" style="text-align:right!important; color: grey; margin-top:-10;">+ coperto</h4>
            </div>';

        }
    }
}
else
{
    echo 'Non ci sono tavoli nel tuo ristorante';
}

// And close the smart-big-box
echo '</div>';

if ($no_orders)
{
    // there are no orders therefore no tables to show
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

echo ' 
  </body>';

echo '<br><br><footer class="fixed-bottom mt-auto py-3 bg-light">
  <div class="container" style="max-width:400px !important;">
    <span class="text-muted" style="text-align:center !important;"> Copyright <a href="https://mf-digital.com/"> MF-Digital.</a> All rights reserved.</span>
  </div>
</footer>';

?>
