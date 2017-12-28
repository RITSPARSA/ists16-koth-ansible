<html>
<head>
<title>Account Settings</title>
<body>

<?php
    require_once "db.php";
    include "header.php";
    session_start();
?>

<br><div style="text-align: center">
<form action="settings.php" method="post">
<?php
    function queryWrapper($queryString) {
    	$db = db_connect();
        $query = mysqli_query($db, $queryString);
        if (!$query) {
            echo "Error accessing database: " . mysqli_error($db);
        }
        $row = mysqli_fetch_row($query);
        return $row[0];
    }
    echo "Password: <input type=\"password\" name=\"password\"><br>";

    $email = queryWrapper("select email from users where id = '" . 
        $_SESSION['id'] . "'");
    echo "Email: <input type=\"text\" name=\"email\" value='" .
         $email . "'><br>";

    $firstName = queryWrapper("select firstName from users where id = '" .
        $_SESSION['id'] . "'");
    echo "First Name: <input type=\"text\" name=\"firstname\" value='" .
        $firstName . "'><br>";

    $lastName = queryWrapper("select lastName from users where id = '" .
        $_SESSION['id'] . "'");
    echo "Last Name: <input type=\"text\" name=\"lastname\" value='" .
        $lastName . "'><br>";

    $phoneNumber = queryWrapper("select phoneNumber from users where id = '" .
        $_SESSION['id'] . "'");
    echo "Phone Number: <input type=\"text\" name=\"phonenumber\" value='" .
        $phoneNumber . "'><br>";

    echo "<input type='submit' value='Submit' name='submit'>";
?>
</form>
<?php
    $db = db_connect();
    if (!$db) {
        echo "Error connecting to database: " . mysqli_error($db);
    }
    $password = mysqli_query($db, "SELECT password FROM users WHERE id = " .
        $_SESSION['id']);

    function update_if_different($original, $new, $field) {
        global $db;
        if (isset($new) && !empty($new) && $new != $original) {
            $queryString = "UPDATE users SET " . $field . "=" . "'" . 
             $new . "'" . " WHERE id =" . $_SESSION['id'];
            $query = mysqli_query($db, $queryString);
            if (!$query) {
                echo "Error querying database: " . mysqli_error($db);
            }
        }
    }
    if (isset($_POST['submit'])) {
        update_if_different($password, $_POST['password'], "password");
        update_if_different($email, $_POST['email'], "email");
        update_if_different($firstName, $_POST['firstname'], "firstName");
        update_if_different($lastName, $_POST['lastname'], "lastName");
        update_if_different($phoneNumber, $_POST['phonenumber'], "phoneNumber");
    }
?>
</body>
<html>
