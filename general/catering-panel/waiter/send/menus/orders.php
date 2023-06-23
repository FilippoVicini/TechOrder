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
echo '
    <link rel="shortcut icon" href="/images/Favicon-tonda.png" type="image/png"/>
<div class="align-middle">
    <form action="/orders/index.php" method="POST">
    <html>

';
echo '<head> 
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link href="../../../Bootstrap/bootstrap.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/styles.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        </head>
        <body class="modern">';

if(isset($_GET["t"])){
    $table_id = $_GET["t"];
    $_SESSION["table"] = $table_id;


// Query the name of that restaurant

$sql_table = "SELECT * FROM tables WHERE `ID` = '$table_id'";
$table_result = mysqli_query($conn, $sql_table);

if (mysqli_num_rows($table_result) > 0) {
    while($table = mysqli_fetch_assoc($table_result)) {
    // get the restaurant
    $restaurant_id = $table['restaurant_id'];
    $table_type = $table['type'];
    $_SESSION["restaurant"] = $restaurant_id;
    };
};

$sql_name = "SELECT `name` FROM restaurants WHERE `ID` = '$restaurant_id'";
$name_result = mysqli_query($conn, $sql_name);

if (mysqli_num_rows($name_result) > 0) {
    while($name = mysqli_fetch_assoc($name_result)) {
    // Print the restaurant name as a title
    
      

    };
};

$table_type = "";


?>


<?php
echo '<head> 
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link href="../Bootstrap/bootstrap.css" rel="stylesheet">
<link href="./styles.css" rel="stylesheet">
<link href="./styless.css" rel="stylesheet">
<link href="./helo.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/styles.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        </head>
        <body class="modern">';

    require "../menu-sopra/index.php";
pit4(6); 
echo '<br>
<button type="button" style="margin-left:37.5%; width: 25%" class="btn btn-outline-dark fs-3 font-montserrat fs-5 fw-bold mb-4" onclick="location.href = `http://mf-shores.it/waiter-orders/select-menu.php?r='.$table_id.'`;"`">I MENU</button>
<button type="button" style="margin-left:37.5%; width: 25%" class="btn btn-outline-dark fs-3 font-montserrat fs-5 fw-bold mb-4" onclick="location.href = `http://mf-shores.it/waiter-menu/`">I TAVOLI</button>

<center>
<h4> '.$table_id.'</h4> </center>
<form action="/orders/index.php" method="POST">';

// Query the categories of that restaurant to build the menu
$menu_id=$_GET['m'];
$home_link = 'http://mf-shores.it/intromenu/?r=' . $table_id . ''; 
$sql_categories = "SELECT * FROM categories WHERE `restaurant_id` = '$restaurant_id' AND menu_id = '$menu_id'";
$categories_result = mysqli_query($conn, $sql_categories);

if (mysqli_num_rows($categories_result) > 0) {
    // output data of each row
    $divcount=0;
    $counter=0;
    while($categories = mysqli_fetch_assoc($categories_result)) {

        $current_category = $categories["ID"];

        // Query the food for each category

        $sql_food = "SELECT * FROM food WHERE `category_id` = '$current_category' AND `status` = 'active' ORDER BY `position_in_category` ASC";
        $food_result = mysqli_query($conn, $sql_food);

        if (mysqli_num_rows($food_result) > 0) {
            // this category has stuff, Building the category title with the data we got for each category
            
               
    echo "<div align='center'><button type='button' style = 'border-radius:10px !important' class = 'shadow p-3 mb-0 bg-body rounded btn btn-menu text-center btn-lg p-3 mb-1 mt-1 rounded border border-1 border border-menusopra' onclick='document.getElementsByClassName(`menu-dropdown`)[".$counter."].classList.toggle(`show`);'>" . $categories["name"]. "</button>
            <div align='center' class='menu-dropdown'>";


   
 
            
            // output data of each row and build the menu utems
            echo '<div class="bigbox"><div class="shadow-sm p-3 mb-2 bg-body rounded piccola-menu-apple" style="display: block; width: 90%; border-radius:10px !important">';
            $i = 0;
            while($food = mysqli_fetch_assoc($food_result)) {
                $divcount=$divcount+1;
                // Building the menu items
                echo '
                        <div class="container">
  <div class="row row-cols-2">
    <div class="col-8" style="text-align: left !important">
      <h5><span style="text-align: left !important; font-size:17px">' . $food["name"]. '</span></h5>
      <span style="float: left">
                            <span style="float: right">
                            <span class="number-input">
    </div>
    <div class="col-4">
                            <span style="float: right">
                            <span class="number-input align-items-center">
                                <button type= "button" onclick="this.parentNode.querySelector(`input[type=number]`).stepDown(); if(this.parentNode.querySelector(`input[type=number]`).value == 0) {document.getElementById(`radio-group-'.$counter.$i.'`).classList.toggle(`collapse`); this.disabled = true}" disabled><i class="bi bi-dash-lg"></i></button>
                                <input class="p-0 quantity" min="0" max="99" name="orders[' . $food["ID"]. ']" value="0" type="number">
                                <button type= "button" onclick="this.parentNode.querySelector(`input[type=number]`).stepUp(); this.parentNode.querySelector(`button`).disabled = false; if(this.parentNode.querySelector(`input[type=number]`).value == 1) document.getElementById(`radio-group-'.$counter.$i.'`).classList.toggle(`collapse`);"><i class="bi bi-plus-lg"></i></button>

</div>
            
                        
                    </div>
     <div class="row row-cols-2">               
    <div class="col" style="text-align: left !important">
      <div class="modal fade" id="exampleModalToggle'.$counter.$i.'" aria-hidden="true" aria-labelledby="exampleModalToggleLabel'.$counter.$i.'" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel'.$counter.$i.'">' . $food["name"]. '</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ' . $food["description"]. '
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="button" data-bs-target="#exampleModalToggle2'.$counter.$i.'" data-bs-toggle="modal">Aggiungi note</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModalToggle2'.$counter.$i.'" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2'.$counter.$i.'" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"id="exampleModalToggleLabel2'.$counter.$i.'">' . $food["name"]. '</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="document.getElementById(`pit3'.$counter.$i.'`).value = ``;"></button>
      </div>
      <div class="modal-body">
        <div id="hideaway' . $divcount . '">
                            <input id="pit3'.$counter.$i.'" name="note[' . $food["ID"]. ']" type="text" placeholder="Scrivi qui ..." style="border:none; width:100%; padding:5px; outline:none"><br>
                            
                        </div>

                        
                        <center>
                    </div>
      <div class="modal-footer">
      <button class="btn btn-outline-secondary" type="button" data-bs-target="#exampleModalToggle'.$counter.$i.'" data-bs-toggle="modal">Info</button>
        <button type="button" class="btn btn-success" data-bs-dismiss="modal" aria-label="Close">Conferma</button>
      </div>
    </div>
  </div>
</div>
<a class="btn btn-outline-primary border border-secondary" data-bs-toggle="modal" href="#exampleModalToggle'.$counter.$i.'" role="button">Info</a>
    </div>
    

<div class="col ms-auto">
      <span style="float: right; color: green; font-size: 20px;">' . $food["price"]. '' . $food["currency"]. '</h4><br>
   <span style="float: right"><br>
    </div>
    </div>
    </div>
  <div class="flex-column collapse" id="radio-group-'.$counter.$i.'">
  <h6>Portata:</h6>
<div class="btn-group" role="group">

    <input type="radio" class="btn-check" name="priority[' . $food["ID"]. ']" id="success-outlined-'.$counter.$i.'" autocomplete="off" value="0" checked>
    <label class="btn btn-outline-primary btn-sm" for="success-outlined-'.$counter.$i.'">Prima</label>

    <input type="radio" class="btn-check" name="priority[' . $food["ID"]. ']" id="warning-outlined-'.$counter.$i.'" value="1" autocomplete="off">
    <label class="btn btn-outline-primary btn-sm" for="warning-outlined-'.$counter.$i.'">Seconda</label>

    <input type="radio" class="btn-check" name="priority[' . $food["ID"]. ']" id="secondary-outlined-'.$counter.$i.'" value="2" autocomplete="off">
    <label class="btn btn-outline-primary btn-sm" for="secondary-outlined-'.$counter.$i.'">Ultima</label>

</div></div>

<hr>


      
                        
                    ';
                // IMPORTANT FIND A WAY TO USE BUTTONS NOT KEYBOARD (look in your safari reading bookmarks)
            
                $i++;
            }
        } else { 
            // this category is empty; 
        }
        echo '</div></div>
        </div>';
        $counter++;
    }
} else {
    echo "<center>0 results</center>";
}

mysqli_close($conn); 


// Close the form
 
echo '<center><br><br><input type="submit" value="Ordina" style="border-radius:10px !important" class="shadow p-3 mb-5 rounded btn btn-primary btn-lg px-5 border border-4 border border-primary fs-5"><br><br>
</form></center>
</div> </div> </div> ';

echo'';

} else {
    echo "<center>Error. We can't get data about the restaurant you are looking for.</center>";
};



  

?>
