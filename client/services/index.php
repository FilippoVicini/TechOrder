<?php
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
<link href="../../Bootstrap/bootstrap.css" rel="stylesheet">
<link href="./styles.css" rel="stylesheet">

<link href="./helo.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/styles.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        </head>
        <body class="modern">';
        
         if(isset($_POST['new_code_name'])){
     $name = $_POST['new_code_name'];
     $type = $_POST['new_code_option']; 
        $sql_code = "SELECT * FROM tables WHERE `restaurant_id` = '$restaurant_id' ORDER BY type ASC";
$code_result = mysqli_query($conn, $sql_code);
 
$code_quantity = mysqli_num_rows($code_result);
 
 
$codes_array = array();

}
$table_id = 0;
if(isset($_GET["r"])){
    $table_id = $_GET["r"];
    $_SESSION["table"] = $table_id;


// Query the name of that restaurant

$sql_table = "SELECT * FROM tables WHERE `ID` = '$table_id'";
$table_result = mysqli_query($conn, $sql_table);
$table_type = "";

if (mysqli_num_rows($table_result) > 0) {
    while($table = mysqli_fetch_assoc($table_result)) {
    // get the restaurant
    $restaurant_id = $table['restaurant_id'];
    $table_type = $table['type'];
    $_SESSION["restaurant"] = $restaurant_id;
    };
};

$table_link = 'http://mf-shores.it/menu/?r=' . $table_id . ''; 
$sql_name = "SELECT `name` FROM restaurants WHERE `ID` = '$restaurant_id'";
$name_result = mysqli_query($conn, $sql_name);

if (mysqli_num_rows($name_result) > 0) {
    while($name = mysqli_fetch_assoc($name_result)) {
        
    // Print the restaurant name as a title
    
      echo "<body  style=\"background-image: linear-gradient(to right, #ECE9E6 , #FFFFFF);\">";
    


?>
<html style="
    --main: hsl(13, 68.5%, 49.8%);
    --main-darker: hsl(13, 78.5%, 8.8%);
    --main-transparent: hsla(13, 68.5%, 49.8%, 0.15);
    --main-ultra-transparent: hsla(13, 68.5%, 49.8%, 0.05);
    --accent: hsl(99, 36.5%, 79.6%);
    --accent-darker: hsl(99, 29.5%, 62.6%);
    --accent-darkest: hsl(99, 29.5%, 47.6%);
    --background: #fff;
    --background-opacity9: hsla(1, 100%, 100%, 0.9);
  ">

                <header>
                <div class="headerContent" >
                  <div  class="switcher">
                    <div class="btn-group b-dropdown dropdown" >
                     <button aria-haspopup="true" aria-expanded="false" type="button" class="btn btn-outline-red " >
            <?php echo $name['name']   ?>
                      </button>
                
                    </div>
                  </div>
                
                  <p  class="tableNumber">
                    <span data-v-5b37a644="">
                     <?php echo  $table_id   ?>
                      
                    </span>
                  </p>
                </div>
              </header>
              
    
              <div class="differentCards">
                <div  class="cardsDISABLE">
                  <div class="flicking-viewport" id="cardSelector" style="
                      touch-action: pan-y;
                      user-select: none;
                      -webkit-user-drag: none;
                      --after-opacity: 0; height: 7%
                    ">
                    <div class="flicking-camera" style="transform: translate(0px); background-image: linear-gradient(to right, #ECE9E6 , #FFFFFF);">
                      
                      <button  class="button-after" style="width:33%;  border: none; height:100%">
                        <h5  class="cardName">Menu</h5>
                      </button>
                      <button  class="activeClass" style="width:33%;  border: none; ">
                        <h5 class="cardName" style="padding-bottom:15px; ">Servizi</h5>
                      </button>
                      <button class="button-after" style="width:33%;  border: none; height:100%">
                        <h5 class="cardName" style="padding-bottom:15px; ">Info</h5>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              
<div style="text-align:center; height:100%; background-color: #fefefe" role="group">
    </html>
   
       
<?php

echo'<div >
<div class="container">
  <div class="row">';

switch ($table_type){
    case "bar":
        $query = "SELECT * FROM menu WHERE restaurant_id = ".$_SESSION['restaurant']." AND type = 'bar'";
        $res = mysqli_query($conn, $query);
        while($menu = mysqli_fetch_assoc($res)){
            echo '<div class="card   rounded-5 shadow-lg "  style="width: 40%; margin:5%; height:150px"  onclick="location.href = `../menus/orders/?t='.$table_id.'&m='.$menu['ID'].'`"><h3 style="margin-top:35%">'.$menu['name'].'</h3></div><br>';
        }
        break;
        
    case "restaurant":
        $query = "SELECT * FROM menu WHERE restaurant_id = ".$_SESSION['restaurant']." AND type = 'restaurant'";
        $res = mysqli_query($conn, $query);
        while($menu = mysqli_fetch_assoc($res)){
            echo '<div class="card card-cover  overflow-hidden  rounded-5 shadow-lg col-auto"   style="width: 40%; margin:5%; height:150px"  onclick="location.href = `../menus/orders/?t='.$table_id.'&m='.$menu['ID'].'`"><h3 style="margin-top:35%">'.$menu['name'].'</h3></div><br>';
        }
        break;
        
    case "beach":
        $query = "SELECT * FROM menu WHERE restaurant_id = ".$_SESSION['restaurant']." AND type = 'beach'";
        $res = mysqli_query($conn, $query);
        while($menu = mysqli_fetch_assoc($res)){
            echo '<div class="card  rounded-5 shadow-lg "  style="width: 40%; margin:5%; height:150px"  onclick="location.href = `../menus/orders/?t='.$table_id.'&m='.$menu['ID'].'`"><h3 style="margin-top:35%">'.$menu['name'].'</h3></div><br>';
        }
        break;
        
    case "client":
        $query = "SELECT * FROM menu WHERE restaurant_id = ".$_SESSION['restaurant']." AND type != 'staff' ORDER BY type"; //client sees all menus except staff
        $res = mysqli_query($conn, $query);
            
        while($menu = mysqli_fetch_assoc($res)){
            
            $color = "";
            switch($menu["type"]){
                case "restaurant":
                    $color = "btn-success";
                    break;
                    
                case "beach":
                    $color = "btn-info";
                    break;
                    
                case "bar":
                    $color = "btn-warning";
                    break;
                    
                case "service":
                    $color = "btn-primary";
            }
        
            echo '<button class="btn '.$color.' mb-1" onclick="location.href = `../menus/orders/?t='.$table_id.'&m='.$menu['ID'].'`"><h3 style="margin-top:35%">'.$menu['name'].'</h3></button><br>';
        }
        break;
        
    case "staff":
        $query = "SELECT * FROM menu WHERE restaurant_id = ".$_SESSION['restaurant']." AND type = 'staff'"; //client sees all menus except staff
        $res = mysqli_query($conn, $query);
        
        while($menu = mysqli_fetch_assoc($res)){
            echo '<div class="card  rounded-5 shadow-lg "   style="width: 40%; margin:5%; height:150px"   onclick="location.href = `../menus/orders/?t='.$table_id.'&m='.$menu['ID'].'`"><h3>'.$menu['name'].'</h3></div><br>';
        }
        
}
    
echo '

</div>
</div></div>


</div></div></div></body>
';

}
}
} else {
    echo "<center>Error. We can't get data about the restaurant you are looking for.</center>";
}



  

?> 
