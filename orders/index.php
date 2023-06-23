<?php

// Start the session



session_start();

$table_id = $_SESSION['table'];

$restaurant_id = $_SESSION["restaurant"];

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

echo '<head>
 <link href="..//Bootstrap/bootstrap.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
   <link rel="shortcut icon" href="/images/Favicon-tonda.png" type="image/png"/>
        <link rel="stylesheet" href="/styles.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
      
        <style>
          body {
            margin: 0;
            padding: 0;
          }

          }
        </style>

        </head>
        <body class="modern">
        

        <div id="title" style="text-align: center; padding-top: 30px;">
            <h1 class="MF-DigitalWaiter_title">MF Waiter</h1>
            <br>
    <center>
    <h2 class="text-center pt-4" style="font-weight:bold; color:#dc3545;">Il tuo ordine è vuoto!</h2></div >
    <br>
<h2 class="text-center pt-1" style="font-weight:100">──────</h2></div >';



// CHECK ERRORI

if(!isset($_SESSION['table'])){
    echo '<center>Sessione scaduta, puoi chiudere<br>
    questa scheda senza problemi.</center>';
    die();
}


if(empty($_POST['orders'])){
    echo '
    <br>
    <center>
    ERRORE: Riprova tra pochi secondi
    <br><br><br>
    <a href="http://mf-shores.it/intromenu/?r='. $table_id . '">Torna indietro</a>
    </center>';
} else {
    $orders = isset($_POST['orders']) ? $_POST['orders'] : array();

    if(empty($orders)){
        echo '
        <br>
        <center>
        ERRORE: il tuo ordine è vuoto!
        <br><br><br>
        <a href="http://mf-shores.it/intromenu/?r='. $table_id . '">Torna indietro</a>
        </center>';
    } else {

    $not_null=FALSE;



    foreach($orders as $quantity) {
        // cerca di capire che item stiamo guardando --> key = food_id
            $key = key($orders);
        

            //controllo hacking scrauso dei bimbi poveri che mettono stringhe html al posto dei numeri
            if(!is_numeric($quantity)){
                echo '
                <br>
                <center>
                Errore
                <br><br><br>
                <a href="http://mf-shores.it/intromenu/?r='. $table_id . '">Torna indietro</a>
                </center>';
                die();
            }
            
            // check che ci sia qualcosa in questo ordine
            if(($quantity!=0) AND (is_numeric($quantity))){
                // stampa cosa è
                // echo $key;
                // stampa quanto è
                // echo '<li>' . $quantity . '</li>';

                $not_null=TRUE;

                $note = isset($_POST['note']) ? $_POST['note'] : array();
                $nota = $note[$key];
                
                $priorities = isset($_POST['priority']) ? $_POST['priority'] : array();
                $priority = $priorities[$key];
                
                $get_order_drink = "SELECT drink FROM food WHERE id = $key";
                $get_order_pizzeria = "SELECT pizzeria FROM food WHERE id = $key";
             
                $order_drink = mysqli_query($conn, $get_order_drink) or die(mysqli_error());//la connesione non funziona 
                $order_pizzeria = mysqli_query($conn, $get_order_pizzeria) or die(mysqli_error());//la connesione non funziona 
                
                $order_drink_result = mysqli_fetch_assoc($order_drink);
                $order_pizzeria_result = mysqli_fetch_assoc($order_pizzeria);
                
                $order_drink_value = $order_drink_result['drink'];
                $order_pizzeria_value = $order_pizzeria_result['pizzeria'];
                
                $status = 'active';
                
                if($order_drink_value == 1) $status = 'preparing';
                //if($order_pizzeria_value == 1) $status = 'preparing';
         
        

                // sì ok molto bello ora andiamo a metterlo nel database
                for ($x = 1; $x <= $quantity; $x++) {
                    
                    $sql = "INSERT INTO orders (`food_id`, `status`, `payment_method`, `table_id`, `restaurant_id`, `note`, `drink`, `pizzeria`, `portata`)
                    VALUES ('$key', '$status', 'cash', '$table_id', '$restaurant_id', '$nota', '$order_drink_value', '$order_pizzeria_value', '$priority')";

                    if (mysqli_query($conn, $sql)) {
                    $ok = 'ok';
                    } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                };
            }

            //spostati al prossimo item
            next($orders);
        }
    }


    //controllo che non sia vuoto
    if($not_null==false){
        echo '
            <br>
            <center>
            ERRORE: il tuo ordine è vuoto!
            <br><br><br>
            <a href="http://mf-shores.it/intromenu/?r='. $table_id . '">Torna indietro</a>
            </center>';
            die();
    }

        
    mysqli_close($conn); 

    echo '
    <br>
    <center>
    

    <div class="gif-bg">
    </div>

    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script>
    $(function() {
     
      });
    });
    </script>

    
    <button class="btn btn-primary" style="font-weight:bold;">ORDINA DI NUOVO</button>
    </center>';
    
    header("Location: http://mf-shores.it/grazie/?t_id=$table_id");
}

$not_null=FALSE;

?>
