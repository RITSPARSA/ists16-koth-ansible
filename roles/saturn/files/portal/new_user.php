<html>
<head>
<title>New User</title>
<body>

<?php
    require_once "db.php";
    include "header.php";
    include "manage_header.php";
?>

<br><div style="text-align: center">
<p>Required fields marked with an asterisk (*).</p>
<form action="new_user.php" method="post">
*Username: <input type="username" name="username"><br>
*Password: <input type="password" name="password"><br>
Email: <input type="text" name="email" ><br>
*First Name: <input type="text" name="firstname"><br>
*Last Name: <input type="text" name="lastname"><br>
Phone Number: <input type="text" name="phonenumber"><br>
*Admin? <input type="checkbox" id="admin", name="admin", value="1" checked><br>
<input type='submit' value='Submit' name='submit'>
</form>
<?php
    $db = db_connect();
    if (!$db) {
        die("Error connecting to database: " . mysqli_error($db));
    }
    if (isset($_POST['submit']) && !empty($_POST['username']) &&
        !empty($_POST['password']) && !empty($_POST['firstname']) && 
        !empty($_POST['lastname'])) {
        $queryString = "INSERT INTO users (username, password, firstName, " .
            "lastName, admin";
        if (!empty($_POST['email'])) {
            $queryString = $queryString . ", email";
        }
        if (!empty($_POST['phonenumber'])) {
            $queryString = $queryString . ", phoneNumber";
        }
        // Add values to query if they're set
        $queryString = $queryString . ") values ('" . $_POST['username'] .
            "', '" . $_POST['password'] . "', '" . $_POST['firstname'] .
            "', '" . $_POST['lastname'] . "'";
        if (isset($_POST['admin'])) {
            $queryString = $queryString . ", 1";
        }
        else {
            $queryString = $queryString . ", 0";
        }
        if (!empty($_POST['email'])) {
            $queryString = $queryString . ", '" . $_POST['email'] . "'";
        }
        if (!empty($_POST['phonenumber'])) {
            $queryString = $queryString . ", '" . $_POST['phonenumber'] . "'";
        }
        $queryString = $queryString . ")";
        $query = mysqli_query($db, $queryString);
        if (!$query) {
            die("Error updating database: " . mysqli_error($db));
        }
    }
?>
</body>
<html>
