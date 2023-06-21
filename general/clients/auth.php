<?php
if(isset($_GET['t'])){
    $_SESSION['valid_until'] = time() + 1800; // 30 minutes
    echo '<script>window.location.replace("./intro/?t='.$_GET['t'].'")</script>';
}
else {
    echo 'Invalid URL';
}

?>