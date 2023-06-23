<?php
function pit4($n)
{
    // cucina normale

    if ($n == 1) {
        echo ' <head>

<link href="../Bootstrap/bootstrap.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<link href="./styles.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <link rel="shortcut icon" href="/images/Favicon-tonda.png" type="image/png"/>
               <div id="select-view-cucina" style="text-align: center;">
               
                <div class="dropdown d-flex  justify-content-center" style="text-align:center !important; ">
               

                       <button class="btn btn-primary btn-lg px-4 border border-4 border border-primary fs-3 font-Montserrat fw-light-bold " style=" margin-right: 3%" onclick="location.href=`/ordini-tutti`;">  Cucina</button>
                <button class="btn btn-menusopra btn-lg px-4 border border-4 border border-menusopra fs-3 font-Montserrat fw-light-bold " style="background-color: #ededed !important; border-color: #ededed !important; color: black" onclick="location.href=`/ordini-tutti-pizzeria`;"> Spiaggia</button>
   
         
            </div></div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/styles.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"</script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        </head>';
    }
    //cassa

    if ($n == 2) {
        echo ' <head>

<link href="../Bootstrap/bootstrap.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<link href="./styles.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <link rel="shortcut icon" href="/images/Favicon-tonda.png" type="image/png"/>
               <div id="select-view-cucina" style="text-align: center;">
               
                <div class="dropdown d-flex  justify-content-center" style="text-align:center !important; ">

                       <button class="btn btn-primary btn-lg px-4 border border-4 border border-primary fs-3 font-Montserrat fw-light-bold " style=" margin-right: 3%" onclick="location.href=`/ordini-tutti`;">  Cassa</button>
                                      
     <button class="btn btn-menusopra btn-lg px-4 border border-4 border border-menusopra fs-3 font-Montserrat fw-light-bold " style="background-color: #ededed !important; border-color:  #ededed !important; color: black; margin-right: 3%" onclick="location.href=`/ordini-tutti-pizzeria`;"> Cucina</button>
                <button class="btn btn-menusopra btn-lg px-4 border border-4 border border-menusopra fs-3 font-Montserrat fw-light-bold " style="background-color: #ededed !important; border-color:  #ededed !important; color: black" onclick="location.href=`http://mf-shores.it/general/`;"> Generale</button>
   
         
            </div></div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/styles.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"</script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        </head>';
    }

    if ($n == 3) {
        echo ' <head>
<link href="../Bootstrap/bootstrap.css" rel="stylesheet">
<link href="./styles.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <link rel="shortcut icon" href="/images/Favicon-tonda.png" type="image/png"/>
               <div id="select-view-cucina" style="text-align: center;">
               
                <div class="dropdown d-flex  justify-content-center" style="text-align:center !important; ">
                <button class="btn btn-menusopra dropdown-toggle btn-lg px-4 border border-4 border border-menusopra fs-3 font-Montserrat fw-light-bold mx-2"  type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-inbox mx-2 mt-1" style="font-size: 35px; "></i>Ordini </button>
                  <ul style="text-align:center; padding-left:40px !important;  padding-right:40px !important;" class="dropdown-menu px-4 fs-3" aria-labelledby="dropdownMenuButton1">

    <li>
    <a  style="width:100% !important;" class="btn btn-outline-primary fw-bold fs-4" href="http://mf-shores.it/ordini-tutti/">CUCINA</a></li>
    <hr style="width:100%;">
    <li>
    <a class="btn btn-outline-primary fw-bold fs-4" href="http://mf-shores.it/ordini-tutti-pizzeria/">SPIAGGIA</a></li>
  </ul>

                       <button class="btn btn-menusopra btn-lg px-4 border border-4 border border-menusopra fs-3 font-Montserrat fw-light-bold mx-2" onclick="location.href=`/tavoli-camerieri-mfwaiter`;">  <i class="bi bi-phone-vibrate mx-2 mt-1" style="font-size: 35px; width:25%"></i> Camerieri </button>
                <button class="btn btn-menusopra btn-lg px-4 border border-4 border border-menusopra fs-3 font-Montserrat fw-light-bold mx-2" onclick="location.href=`/cassa`;"><i class="bi bi-credit-card mx-2 mt-1" style="font-size: 35px;"></i>  Cassa</button>
                <button class="btn btn-primary btn-lg px-4 border border-4 border border-primary fs-3 font-Montserrat fw-light-bold mx-2" onclick="location.href=`/utente-mfwaiter`;">  <i class="bi bi-person mx-2 mt-1" style="font-size: 35px;"></i>
                Utente</button>
         
            </div></div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/styles.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"</script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        </head>';
    }

    // Tavoli-camerieri-mfwaiter
    if ($n == 4) {
        echo ' <head>
<link href="../Bootstrap/bootstrap.css" rel="stylesheet">
<link href="./styles.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <link rel="shortcut icon" href="/images/Favicon-tonda.png" type="image/png"/>
               <div id="select-view-cucina" style="text-align: center;">
               
               

                       <button class="btn btn-primary btn-lg  border border-4 border border-primary fs-3 font-Montserrat fw-light-bold mx-2"  onclick="location.href=`/tavoli-camerieri-mfwaiter`;"> Ordini </button>
                <button class="btn btn-menusopra btn-lg  border border-4 border border-menusopra fs-3 font-Montserrat fw-light-bold mx-2" style="background-color: #ededed !important; border-color: #ededed !important; color: black; margin-right: 3%"  onclick="location.href=`/waiter-menu`;"> Menù </button>
              
         
            </div></div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/styles.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"</script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        </head>';
    }

    // cucina pizzeria
    if ($n == 5) {
        echo ' <head>

<link href="../Bootstrap/bootstrap.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<link href="./styles.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <link rel="shortcut icon" href="/images/Favicon-tonda.png" type="image/png"/>
               <div id="select-view-cucina" style="text-align: center;">
               
                <div class="dropdown d-flex  justify-content-center" style="text-align:center !important; ">
               

                       <button class="btn btn-menusopra btn-lg px-4 border border-4 border border-menusopra fs-3 font-Montserrat fw-light-bold "  style="background-color: #ededed !important; border-color: #ededed !important; color: black; margin-right: 3%"  onclick="location.href=`/ordini-tutti`;">  Cucina</button>
                <button class="btn btn-primary btn-lg px-4 border border-4 border border-primary fs-3 font-Montserrat fw-light-bold "  onclick="location.href=`/ordini-tutti-pizzeria`;"> Spiaggia</button>
   
         
            </div></div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/styles.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"</script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        </head>';
    }
    // waiter-menu 
    if ($n == 6) {
        echo ' <head>
<link href="../Bootstrap/bootstrap.css" rel="stylesheet">
<link href="./styles.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <link rel="shortcut icon" href="/images/Favicon-tonda.png" type="image/png"/>
               <div id="select-view-cucina" style="text-align: center;">
               
               

                        <button type="button" class="btn btn-menusopra btn-lg  border border-4 border border-menusopra fs-3 font-Montserrat fw-light-bold mx-2" style="background-color: #ededed !important; border-color: #ededed !important; color: black; margin-right: 3%"  onclick="location.href=`/tavoli-camerieri-mfwaiter`;"> Ordini </button>
                       <button class="btn btn-primary btn-lg  border border-4 border border-primary fs-3 font-Montserrat fw-light-bold mx-2"  onclick="location.href=`/waiter-menu`;">   Menu </button>
              
              
         
            </div></div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/styles.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"</script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        </head>';
    }
}

?>
