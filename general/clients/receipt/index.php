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

$table_id = $_GET['t_id'];
$restaurant_id = 0;

$query = "SELECT * FROM tables WHERE id = $table_id";
$res = mysqli_query($conn, $query);
while($table = mysqli_fetch_assoc($res)) $restaurant_id = $table['restaurant_id'];

echo '<head>
<meta http-equiv="refresh" content="15">
 <link href="../Bootstrap/bootstrap.css" rel="stylesheet">
   <link rel="shortcut icon" href="/images/Favicon-tonda.png" type="image/png"/>
 <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link rel="stylesheet" href="/styles.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
      

        </head>
        <body class="modern">
        </center>';
        


echo'<center><div class="rounded shadow py-2 mt-4 mb-4" style="width: 90%">
<h5 class="mb-4 fw-bold px-3">IL TUO ORDINE</h5>';
        $sql_orders = "SELECT * FROM orders WHERE `restaurant_id` = '$restaurant_id' AND table_id = $table_id";
        $orders_result = mysqli_query($conn, $sql_orders);
$totale = 0;
$grigio = 0;
$giallo = 0;
$blu  = 0;
$verde = 0;

while($order = mysqli_fetch_assoc($orders_result)) {
    if($order['drink'] == 0){
        if($order['status'] == 'accepted') $grigio++;
        if($order['status'] == 'preparing') $giallo++;
        if($order['status'] == 'exit') $blu++;
        if($order['status'] == 'paid') $verde++;
        
        $totale++;
    }
    
}

if ($grigio == 0) $grigio = "";
if ($giallo == 0) $giallo = "";
if ($blu == 0) $blu = "";
if ($verde == 0) $verde = "";

$grigio_ = ($grigio/$totale)*100;
$giallo_ = ($giallo/$totale)*100;
$blu_ = ($blu/$totale)*100;
$verde_ = ($verde/$totale)*100;

$sql_table = "SELECT * FROM tables WHERE `restaurant_id` = '$restaurant_id' AND id = $table_id";
$orders_table = mysqli_query($conn, $sql_table);
$table_name = '';
while($table = mysqli_fetch_assoc($orders_table)){
    $table_name = $table['name'];
}

$done = false;
if($verde == $totale) {echo '<center><h3 class="mb-3">Pagamento Completato!</h3></center>'; $done = true;}
else if($grigio+$giallo+$blu+$verde == 0) echo '<center><h3 class="mb-3">In Attesa...</h3></center>';


        echo'<center><div class="progress w-75" style="height:2.75vh; border-radius:20px">
        
  <div class="progress-bar-striped progress-bar-animated text-dark font-monospace fw-bold fs-6" role="progressbar" style="width: '.$grigio_.'%; background-color: silver; color: white !important" aria-valuenow="'.$grigio_.'" aria-valuemin="0" aria-valuemax="100">'.$grigio.'</div>
  
  <div class="progress-bar-striped progress-bar-animated text-dark font-monospace fw-bold fs-6 bg-warning" role="progressbar" style="width: '.$giallo_.'%; color: white !important" aria-valuenow="'.$giallo_.'" aria-valuemin="0" aria-valuemax="100">'.$giallo.'</div>
  
  <div class="progress-bar-striped progress-bar-animated text-dark font-monospace fw-bold fs-6 bg-primary" role="progressbar" style="width: '.$blu_.'%; color: white !important" aria-valuenow="'.$blu_.';" aria-valuemin="0" aria-valuemax="100">'.$blu.'</div>
  
    <div class="progress-bar-striped progress-bar-animated text-dark font-monospace fw-bold fs-6 bg-success" role="progressbar" style="width: '.$verde_.'%; color: white !important" aria-valuenow="'.$verde_.';" aria-valuemin="0" aria-valuemax="100">'.$verde.'</div>
  
</div>


<h6 class="px-2 mt-3 mb-4" style="font-size: 15px"><span class="bg-secondary rounded px-1 text-light">Mandati</span>   <span class="bg-warning rounded px-1 text-light">Cucinati</span>   <span class="bg-primary rounded px-1 text-light">Usciti</span>   <span class="bg-success rounded px-1 text-light">Pagati</span></h6>

<hr class="w-100" style="margin-bottom: 0.5vh; border: 0.75px dashed black; background-color: transparent">
<h6 class="text-muted fw-bold text-end px-3">Resoconto Tavolo '.$table_name.'</h6>
<hr class="w-100" style="margin-bottom: 0.5vh; margin-top: 0.5vh; border: 0.75px dashed black; background-color: transparent">
<div class="py-4">
';

    $sql_orders = "SELECT * FROM orders WHERE `restaurant_id` = '$restaurant_id' AND table_id = $table_id AND (`status` = 'active' OR `status` = 'preparing' OR `status` = 'accepted' OR `status` = 'paid' OR `status` = 'exit')";
    $orders_result = mysqli_query($conn, $sql_orders);

$totale = 0;
while($order = mysqli_fetch_assoc($orders_result)) {
    $food_id = $order['food_id'];
    $sql_food_w = "SELECT * FROM food WHERE `restaurant_id` = '$restaurant_id' AND ID = $food_id";
    $orders_food_w = mysqli_query($conn, $sql_food_w);
    while($food = mysqli_fetch_assoc($orders_food_w)){
        $name = $food['name'];
        $price = $food['price']; $totale += $price;
        $currency = $food['currency'];
        $loool = $order['status'] == 'paid' ? 'text-success' : 'text-muted';
        echo '<div class="d-flex">
        <h6 class="me-auto px-2 text-start">'.$name.'</h6>
        <h6 class="px-2 font-monospace '.$loool.'">'.$price.$currency.'</h6>
        </div>';
    }
}

$lol = $done ? "text-success" : "text-muted";
echo '</div>
<hr class="w-100" style="margin-bottom: 0.5vh; margin-top: 0.5vh; border: 0.75px">
<h5 class="text-end px-3">Totale: <span class="font-monospace '.$lol.'">'.$totale.'€</span></h5>
</div></center>';



       echo' <center><a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
      <img src="/images/MF (1).svg" width="25%" height="25%" title="Logo of a company" alt="MF Waiter Logo" />
    </a></center>';

?>
