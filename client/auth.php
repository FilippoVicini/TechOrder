<?php
session_start();

if(isset($_GET['t'])){
    $_SESSION['valid_until'] = time() + 60 * 30; // 30 minutes from page access
    echo '<script>window.location.replace("./main/?t='.$_GET['t'].'")</script>';
}
else {
    echo 'PAGINA NON TROVATA: URL INVALIDO';
}

?>