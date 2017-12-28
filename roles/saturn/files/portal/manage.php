<?php
    require_once "db.php";
    $db = db_connect();

    session_start();

    $adminCheck = "SELECT admin FROM users WHERE id='" . $_SESSION['id'] . "'";
    $adminQuery = mysqli_query($db, $adminCheck);
    $adminRow = mysqli_fetch_row($adminQuery);
    if ($adminRow[0] != "1") {
        header("Location: http://www.metropolis-general.com/portal.php");
        die();
    }

    if (!empty($_GET) && $_GET['action'] == "delete") {
        $queryString = "DELETE FROM users WHERE id='" . $_GET['id'] . "'";
        $query = mysqli_query($db, $queryString);
        if (!$query) {
            die("Error deleting user from database: " . mysqli_error($db));
        }
    }
?>

<html>
<head>
<title>Manage Users</title>
<body>
<?php
    include "header.php";
    include "manage_header.php";

    $query = "SELECT * FROM users";
    $results = mysqli_query($db, $query);
    if (!$results) {
        echo "<br>Error retrieving records: " . mysqli_error($db);
    }
    else {
        echo "<br><table style='text-align: center; margin: 0 auto'>";
        echo "<tr><th>User ID</th>";
        echo "<th>Username</th>";
        echo "<th>Password</th>";
        echo "<th>First Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Email Address</th>";
        echo "<th>Phone Number</th>";
        echo "<th>Admin?</th></tr>";
       
        while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
            echo "<tr><td>" . $row['id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['password'] . "</td>";
            echo "<td>" . $row['firstName'] . "</td>";
            echo "<td>" . $row['lastName'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['phoneNumber'] . "</td>";
            echo "<td>" . $row['admin'] . "</td>";
            echo "<td><a href=user_modify.php?id=" . $row['id'] . 
                ">Edit User</a></td>";
            echo "<td><a onClick=\"javascript: " . 
                "return confirm('Are you sure you want to delete this " . 
                "user?');\" href=manage.php?action=delete&id=" . $row['id'] .
                ">Delete User</a></td></tr>";
        }
        echo "</table></div>";
    }          
?>
</body>
</html>
