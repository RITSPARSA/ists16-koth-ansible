<?php
    session_start();
    session_unset();
    $destroyed = session_destroy();
    setcookie("PHPSESSID", "", time()-3600, "/");
    header("Location: login.php");
?>
