<?php
function db_connect() {

    $db = mysqli_connect('localhost', 'root', '', 'portal');

    if (mysqli_connect_errno($db) > 0) {
        die('Unable to connect to database: [' . 
        mysqli_connect_error($db) .']');
    }

return $db;
}
?>
