<html>
<head>
<title>Patient Portal</title>
<body>
<?php
    require_once "db.php";
    
    $db = db_connect();

    include "header.php";

    if (isset($_GET) && $_GET['action'] == "delete" && !empty($_GET['id'])) {
        $checkAdmin = "SELECT admin FROM users WHERE id='" . 
            $_SESSION['id'] . "'";
        $adminQuery = mysqli_query($db, $checkAdmin);
        if (!$adminQuery) {
            die("Error checking admin privs: " . mysqli_error($db));
        }
        $adminRow = mysqli_fetch_row($adminQuery);
        if ($adminRow[0] == "1") {
            $queryString = "DELETE FROM patients WHERE id='" . 
                $_GET['id'] . "'";
            $query = mysqli_query($db, $queryString);
            if (!$query) {
                die("Error deleting record from database: " . 
                    mysqli_error($db));
            }
        }
        else {
            header("Location: http://www.metropolis-general.com/portal.php");
            die();
        }
    }

    $query = "SELECT * FROM patients";
    $results = mysqli_query($db, $query);
    if (!$results) {
        echo "<br>Error retrieving records: " . mysqli_error($db);
    }
    else {
        echo "<br><table style='text-align: center; margin: 0 auto'>";
        echo "<tr><th>Patient Number</th>";
        echo "<th>First Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Sex</th>";
        echo "<th>Date of Birth</th>";
        echo "<th>Notes</th></tr>";
       
        while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
            echo "<tr><td>" . $row['id'] . "</td>";
            echo "<td>" . $row['firstName'] . "</td>";
            echo "<td>" . $row['lastName'] . "</td>";
            echo "<td>" . $row['sex'] . "</td>";
            echo "<td>" . $row['birthDate'] . "</td>";
            echo "<td>" . $row['notes'] . "</td>";
            echo "<td><a href=modify.php?id=" . $row['id'] . ">Edit Record</a>";
            $queryString = "SELECT admin FROM users WHERE id='" . 
                $_SESSION['id'] . "'";
            $query = mysqli_query($db, $queryString);
            $adminRow = mysqli_fetch_row($query);
            if ($adminRow[0] == "1") {
                echo "<td><a onClick=\"javascript: " . 
                    "return confirm('Are you sure you want to delete this " .
                    "record?');\" href=portal.php?action=delete&id=" . 
                    $row['id'] . ">Delete Record</a>";
            }
        }
        echo "</table></div>";
    }          
?>
</body>
</html>
