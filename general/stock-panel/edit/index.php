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
if (!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}

// Look for credentials from post - login page
if ((isset($_POST['email'])) and (isset($_POST['password'])))
{
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $_POST['password'];
    unset($_POST['email']);
    unset($_POST['password']);
    header("location: /homepage");
}

$email = $_SESSION['email'];
$password = $_SESSION['password'];
$restaurant_id = "";

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



?>
<!doctype html>
<html lang="en" data-theme="dark">
   <head>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/json2html/2.2.1/json2html.min.js"></script>
           <link rel="shortcut icon" href="../images/Favicon-tonda.png" type="image/png"/>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
      <meta name="color-scheme" content="dark light">
      <title>Tech Order</title>
        <link rel="shortcut icon" href="/../../../images/Favicon-tonda.png" type="image/png">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
      <link rel="stylesheet" type="text/css" href="../../main.css">
      <link rel="stylesheet" type="text/css" href="../../utils.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
       <script src="../../../../bootstrap-treeview/js/bootstrap-treeview.js"></script>
       <script type="module" src="../../../Bootstrap/bootstrap.js"></script>

     
   </head>
   <body>
      <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
          <?php
require "../../navbar/index.php";
nav4(5); ?>
         <div class="flex-lg-1 h-screen overflow-y-lg-auto">
       
            <header>
               <div class="container-fluid">
                  <div class="border-bottom pt-6">
                     <div class="row align-items-center">
                        <div class="col-sm col-12">
                           <h1 class="h2 ls-tight"><span class="d-inline-block me-3"></span> <?php echo $restaurant_name ?></h1>
                        </div>
                        <div class="col-sm-auto col-12 mt-4 mt-sm-0">
                        
                        </div>
                     </div>
                    
                  </div>
               </div>
            </header>
            <main class="py-6 bg-surface-secondary">
          
               <div class="container-fluid">
                  <div class="row g-6 mb-6">
                     
                     <div class="col">
                        <div class="card h-full">
                           <div class="card-body">
                              <div class="card-title d-flex align-items-center">
                              
                              
                              </div>
                              
<?php

if (isset($_GET['id']))
{

    $query = "SELECT * FROM magazzino WHERE id = " . $_GET['id'];
    $res = mysqli_query($conn, $query);
    while ($magazzino = mysqli_fetch_assoc($res))
    {

        if (isset($_GET['del']))
        {
            $ingredient = $_GET['del'];

            $query = "SELECT * FROM magazzino WHERE restaurant_id = $restaurant_id";
            $res = mysqli_query($conn, $query);
            while ($c = mysqli_fetch_assoc($res))
            {
                $stock = json_decode($c['stock']);
                foreach ($stock as $category => $subcategories)
                {
                    foreach ($subcategories as $subcategory => $elements)
                    {
                        foreach ($elements as $element => $quantity)
                        {
                            if ($element == $ingredient)
                            {
                                unset($stock
                                    ->$category
                                    ->$subcategory->$element);
                            }
                        }
                    }
                }

                $query = "UPDATE magazzino SET stock = '" . json_encode($stock) . "' WHERE id = " . $c['ID'];
                mysqli_query($conn, $query);
            }
            echo '<script>window.location.href = "./?id=' . $_GET['id'] . '"</script>';

        }

        if (isset($_POST['add']))
        {
            $ingredient = $_POST['add'];
            $add_subcategory = $_POST['add_subcategory'];

            $query = "SELECT * FROM magazzino WHERE restaurant_id = $restaurant_id";
            $res = mysqli_query($conn, $query);
            while ($c = mysqli_fetch_assoc($res))
            {
                $stock = json_decode($c['stock']);
                foreach ($stock as $category => $subcategories)
                {
                    foreach ($subcategories as $subcategory => $elements)
                    {
                        if ($subcategory == $add_subcategory)
                        {
                            $stock
                                ->$category
                                ->$subcategory->{$ingredient} = 0;
                        }
                    }
                }

                $query = "UPDATE magazzino SET stock = '" . json_encode($stock) . "' WHERE id = " . $c['ID'];
                mysqli_query($conn, $query);
            }

            echo '<script>window.location.href = "./?id=' . $_GET['id'] . '"</script>';

        }

        echo '
    <h3 class="mb-3">Modifica ' . $magazzino['nome'] . '</h3>
    <div class="row">
        <div class="col-4">
            <div class="form-group mb-3">
              <input type="input" class="form-control" id="input-search" style="font-size: 12px" placeholder="Trova elemento..." value="">
            </div>
            
            <div class="" id="output-search">
            </div>
        </div>
        
        <div class="col">
            <div id="stock-tree" class="treeview"></div>
        </div>
    </div>
    ';

        $stock = json_decode($magazzino['stock']);
        $tree = [];

        foreach ($stock as $category => $subcategories)
        {
            $_category = new stdClass();
            $_category->text = $category;

            foreach ($subcategories as $subcategory => $elements)
            {
                $_subcategory = new stdClass();
                $_subcategory->text = $subcategory;

                foreach ($elements as $element => $quantity)
                {
                    $_element = new stdClass();
                    $_element->text = $element;
                    $_element->icon = "bi bi-dash-square-fill";
                    $_element->color = "red";

                    $_subcategory->nodes[] = $_element;
                }
                $add_node = new stdClass();
                $add_node->text = "Aggiungi";
                $add_node->icon = "bi bi-plus-square-fill";
                $add_node->color = "green";

                echo '
<form action="./?id=' . $_GET['id'] . '" method="POST">
    <div class="modal fade" id="' . $subcategory . '-modal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Aggiungi Ingrediente</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input class="form-control" name="add" placeholder="Nome Ingrediente..."></input>
            <input class="d-none" name="add_subcategory" value="' . $subcategory . '"></input>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
            <button type="submit" class="btn btn-primary">Aggiungi</button>
          </div>
        </div>
      </div>
    </div>
</form>';

                $_subcategory->nodes[] = $add_node;

                $_category->nodes[] = $_subcategory;
            }

            $tree[] = $_category;
        }

        $encoded_tree = json_encode($tree);

?>
    
    <script>
   
    var $tree = $('#stock-tree').treeview({
        data: JSON.parse('<?php echo $encoded_tree ?>'),
        levels: 1,
        expandIcon: 'bi bi-plus',
        collapseIcon: 'bi bi-dash',
        searchResultColor: '#03fc20',
        onNodeSelected: function(event, node){
            if(!('nodes' in node)){
                if(node.text == "Aggiungi") {
                     window.bootstrap = bootstrap;
                    
                    var subcategory = $('#stock-tree').treeview('getParent', node).text;
                    var modal = new bootstrap.Modal($('#'+subcategory+'-modal'));
                    modal.toggle();
                }
                else{
                    if(confirm("Sei sicuro di voler cancellare questo ingrediente?\nQuesta azione NON PUO' ESSERE CANCELLATA!")){
                        window.location.href = "./?id="+<?php echo $_GET['id'] ?>+"&del="+node.text;
                    }
                }
            }
        }
        
    });
    
    var search = function(e) {
          $('#stock-tree').treeview('collapseAll');
        
          //queue treeview search
          var pattern = $('#input-search').val();
          var options = {
            ignoreCase: true,
            exactMatch: false,
            revealResults: true
          };
          var results = $tree.treeview('search', [ pattern, options ]);
          
          //add to results div
          var output = '<p>' + results.length + ' risultati per "'+pattern+'": </p>';
          $.each(results, function(index, result){
              output += '<p> • ' + result.text + '</p>';
          });
          if(results.length == 0) output = '';
          $('#output-search').html(output);
        }
    $('#input-search').on('keyup', search);
    
    </script>
    
    <?php

    }
}

else
{
    echo "Errore: magazzino non trovato";
}

?>
                                
                                 </div>
                              </div>
                           </div>
                        </div>
                      
                 
                           </div>
                        </div>
                     </div>
                  </div>
                    <div class="row ">
                  
               </div>
            </main>
         </div>
      </div>
      <script src="../../main.js"></script>
   </body>
</html>
