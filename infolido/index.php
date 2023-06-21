<?php
header( "refresh: 1200;url=https://google.com/" );
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


// Nel file intromenu/index.php a linea 54 puoi vedere che $restaurant_id viene
// messo in $_SESSION['restaurant_id'], questo significa che possiamo prenderlo
// ovunque nella stessa sessione di navigazione come mostrato qui sotto. 
// Ho anche realizzato che potevamo usare questo in mf waiter invece di fare tantissimi
// ?restaurant_id=x&table_id=y&... ma ovviamente non si fanno domande
$restaurant_id = $_SESSION["restaurant"];



echo '
    <link rel="shortcut icon" href="/images/Favicon-tonda.png" type="image/png"/>
<div class="align-middle">
    <form action="/orders/index.php" method="POST">
    <html>

';
echo '<head> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link href="../Bootstrap/bootstrap.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link rel="stylesheet" href="/styles.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        </head>
        <body class="modern">';


//Prendi informazioni del ristorante con id = $restaurant_id
$sql_restaurant = "SELECT * FROM restaurants WHERE `id` = '$restaurant_id' AND `status` = 'active'";
$restaurant_result = mysqli_query($conn, $sql_restaurant);

//Crea variabili che andremo a modificare se trova un ristorante con id = $restaurant_id
$name = "NOME LIDO";
$desc = "DESCRIZIONE LIDO";

if (!$restaurant_result){
    //errore D:
}
else{
    //Prendi informazioni ristorante e modifica variabili $name e $desc
    while($restaurant = mysqli_fetch_assoc($restaurant_result)){
        $name = $restaurant['name'];
        $desc = $restaurant['shoredescription'];
    }
}



    echo "<body>";
    echo '
    <center>
    <h2 class="MF-DigitalWaiter_title_restaurant_clienti text-dark"><i class="bi bi-shop-window mx-2 mt-1 text-dark"></i>'.$name.'</h2>
            </center>
            <center>
            <p class="MF-DigitalWaiter_subtitle-login" style="text-align:center; margin-top:10px; color: lightgrey;" style="text-align:center; margin-top:-30">Developed by:
<a href= "https://www.mf-digital.com" class="MF-DigitalWaiter_subtitle-login" style="text-align:center; margin-top:-30; color: lightgrey;"> MF-Digital️
</a><hr>
';

echo' <button class="btn btn-outline-primary fw-bold shadow mb-3 border border-white bg-white text-dark" type="button" style="width:85%; height:40%; border-radius:15px">
    <i class="bi bi-shop-window" style="margin-right:5%; width:20%"></i>
    
    <p class="lead" style="font-size:15px !important;">'.$desc.'</p>
</button>';

echo' <footer class="text-center text-white fixed-bottom" style="background-color: #ffffff;">
<div class="d-flex align-items-start bg-light mb-3" style="height: 50px;  margin-bottom:0px !important; ">
<div class="col" onclick="window.location.href = `http://mf-shores.it/menu/?r='.$_SESSION["table"].'`"><img width="30" src="//d2trtkcohkrm90.cloudfront.net/apple_inc_gray/8.png" style="margin-top:10px; "></div></a>
  <div class="col" style="margin-top:10px;"onclick="history.go(-1)" ><i class="bi bi-house-door" style=" font-size:30px; color: #474747; "></i></div>
  <div class="col" style="margin-top:10px;" onclick="window.location.href = `http://mf-shores.it/infolido/`;"><i class="bi bi-geo-fill text-dark" style="font-size:30px; color: #474747;"></i></div>
  
</div>

  <!-- Grid container -->

  <!-- Copyright -->
  
  <!-- Copyright -->
</footer>';
  

?>


