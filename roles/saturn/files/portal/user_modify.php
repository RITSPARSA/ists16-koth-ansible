<html>
<head>
<title>Edit User</title>
</head>
<body>

<?php
    require_once "db.php";
    include "header.php";
    include "manage_header.php";

    $db = db_connect();
    if (!$db) {
        echo "Error connecting to database: " . mysqli_error($db);
    }


    function update_if_different($original, $new, $field) {
        global $db;
        if (isset($new) && !empty($new) && $new != $original) {
            $queryString = "UPDATE users SET " . $field . "=" . "'" . 
             $new . "'" . " WHERE id =" . $_POST['id'];
            $query = mysqli_query($db, $queryString);
            if (!$query) {
                echo "Error updating database: " . mysqli_error($db);
            }
        }
        else if ($field == 'admin') {
            $queryString = "SELECT admin FROM users WHERE id =" . $_POST['id'];
            $query = mysqli_query($db, $queryString);
            if (!$query) {
                echo "Error querying database: " . mysqli_error($db);
            } 
            else {
                $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
                if ($row['admin'] == 1) {
                    $queryString = "UPDATE users SET admin=0 WHERE id =" .
                        $_POST['id'];
                    $query = mysqli_query($db, $queryString);
                    if (!$query) {
                        echo "Error updating database: " . mysqli_error($db);
                    } 
                }
            }
        }
    }
    if (isset($_POST['submit'])) {
        $password = mysqli_query($db, "SELECT password FROM users WHERE " .
        "id=" . $_POST['id']);
        update_if_different($username, $_POST['username'], "username");
        update_if_different($password, $_POST['password'], "password");
        update_if_different($email, $_POST['email'], "email");
        update_if_different($firstName, $_POST['firstname'], "firstName");
        update_if_different($lastName, $_POST['lastname'], "lastName");
        update_if_different($phoneNumber, $_POST['phonenumber'], "phoneNumber");
        update_if_different($admin, $_POST['admin'], "admin");
    }
?>

<br><div style="text-align: center">
<?php
    echo "<form action='user_modify.php?id=" . $_GET['id'] . "' method='post'>";
    function queryWrapper($queryString) {
    	$db = db_connect();
        $query = mysqli_query($db, $queryString);
        if (!$query) {
            echo "Error accessing database: " . mysqli_error($db);
        }
        $row = mysqli_fetch_row($query);
        return $row[0];
    }
    $username = queryWrapper("select username from users where id = '" . 
        $_GET['id'] . "'");
    echo "Username: <input type=\"text\" name=\"username\" value='" .
         $username . "'><br>\n";

    echo "Password: <input type=\"password\" name=\"password\"><br>\n";

    $email = queryWrapper("select email from users where id = '" . 
        $_GET['id'] . "'");
    echo "Email: <input type=\"text\" name=\"email\" value='" .
         $email . "'><br>\n";

    $firstName = queryWrapper("select firstName from users where id = '" .
        $_GET['id'] . "'");
    echo "First Name: <input type=\"text\" name=\"firstname\" value='" .
        $firstName . "'><br>\n";

    $lastName = queryWrapper("select firstName from users where id = '" .
        $_GET['id'] . "'");
    echo "Last Name: <input type=\"text\" name=\"lastname\" value='" .
        $lastName . "'><br>\n";

    $phoneNumber = queryWrapper("select phoneNumber from users where id = '" .
        $_GET['id'] . "'");
    echo "Phone Number: <input type=\"text\" name=\"phonenumber\" value='" .
        $phoneNumber . "'><br>\n";

    $admin = queryWrapper("select admin from users where id = '" .
        $_GET['id'] . "'");
    if ($admin == '0') {
        echo "Admin? <input type=\"checkbox\" id=\"admin\" " . 
            "name=\"admin\" value='1'><br>\n";
    }
    else {
        echo "Admin? <input type=\"checkbox\" id=\"admin\" " . 
            "name=\"admin\" value='1' checked><br>\n";
    }        

    echo "<input type='hidden' value='" . $_GET['id'] . "' name='id'>\n";
    echo "<input type='submit' value='Submit' name='submit'>";
?>
</form>

</body>
</html>
