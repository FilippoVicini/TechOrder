<?php
session_start();

if (!isset($_SESSION['valid_until']))
{
    // Invalid Session
    echo "<script>window.location.replace('../error.php')</script>";
}
else
{
    if ($_SESSION['valid_until'] < time())
    {
        // Session timed out
        session_destroy();
        echo "<script>window.location.replace('../error.php')</script>";
    }

    else
    {
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
        echo '
    <link rel="shortcut icon" href="/images/Favicon-tonda.png" type="image/png"/>
<div class="align-middle">
    <html>

';
        echo '<head> 
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script type="text/javascript">
<title>TechOrder</title>
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: "en"}, "google_translate_element");
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link href="../Bootstrap/bootstrap.css" rel="stylesheet">
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

        if (isset($_POST['new_code_name']))
        {
            $name = $_POST['new_code_name'];
            $type = $_POST['new_code_option'];
            $sql_code = "SELECT * FROM tables WHERE `restaurant_id` = '$restaurant_id' ORDER BY type ASC";
            $code_result = mysqli_query($conn, $sql_code);

            $code_quantity = mysqli_num_rows($code_result);

            $codes_array = array();

        }
        $table_id = 0;
        if (isset($_GET["t"]))
        {
            $table_id = $_GET["t"];
            $_SESSION["table"] = $table_id;

            // Query the name of that restaurant
            $sql_table = "SELECT * FROM tables WHERE `ID` = '$table_id'";
            $table_result = mysqli_query($conn, $sql_table);
            $table_type = "";

            if (mysqli_num_rows($table_result) > 0)
            {
                while ($table = mysqli_fetch_assoc($table_result))
                {
                    // get the restaurant
                    $restaurant_id = $table['restaurant_id'];
                    $table_type = $table['type'];
                    $_SESSION["restaurant"] = $restaurant_id;
                };
            };

            $table_link = 'http://michele-media.it/client/menus/?t=' . $table_id . '';
            $sql_name = "SELECT `name` FROM restaurants WHERE `ID` = '$restaurant_id'";
            $name_result = mysqli_query($conn, $sql_name);

            if (mysqli_num_rows($name_result) > 0)
            {
                while ($name = mysqli_fetch_assoc($name_result))
                {

                    // Print the restaurant name as a title
                    echo "<body style=\"background-image: linear-gradient(to right, #ECE9E6 , #FFFFFF);\" >";

?>
<img src="../images/Saly-2.png" style="width: 100%"> </img>

    
          <div class="d-flex flex-column  p-5 pb-3 text-white text-shadow-1" style="padding: 0 !important">
            <h2 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold" style="margin-top: 2% !important; padding-top:0 !important; text-align: center; color: #da6b4b; font-size: 40px; font-weight: bold;">La Rivoluzione. <br> Inizia Ora.</h2>
          
    <?php echo '  <a href=" ' . $table_link . ' "><div style="margin-top: 5%; width: 50%; background-color:#e3b98c; font-size: 17px" class="button"> ' . $name['name'] . '</div></a>'; ?>
         <a href="http://mf-digital.com/">  <div onclick="location.href='http://google.com/" style="margin-top: 3%; width: 40%;  background-color: #ca9e76; font-size: 13px; "class="button">Scopri di più</div></a>

<?php
                }
            }
        }
        else
        {
            echo "<center>Error. We cant get data about the restaurant you are looking for.</center>";
        }

    }
}

?>
