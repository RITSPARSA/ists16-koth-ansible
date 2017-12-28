<?php 
    include 'db.php'; 
?>

<html>
<head>
<title>Login</title>
<body>

<form action="login.php" method="post">
Username: <input type="text" name="name"><br>
Password: <input type="password" name="password"><br>
Forget your password? Click <a href="change_password.php">here</a>.<br>
<input type="submit" value="Login" name="login">

<?php
    $db = db_connect();

    if (isset($_POST['login']) && !empty($_POST['name'])
        && !empty($_POST['password'])) {
        $query = "SELECT id,username,password FROM users WHERE username = '"
            . $_POST['name'] . "' AND password = '" . $_POST['password']
            . "'";
        $result = mysqli_query($db, $query);
        if (!$result) {
            echo "<br>Error: " . mysqli_error($db);
        }
        else {
            $rowcount = mysqli_num_rows($result);
            if ($rowcount > 0) {
                $row = mysqli_fetch_row($result);
                session_start();
                $_SESSION['id'] = $row[0];
                $_SESSION['loggedin'] = 1;
            }
            else {
                echo "<br>Invalid username or password.";
            }
            mysqli_free_result($result);
            header("Location: http://www.metropolis-general.com/portal.php");
            die();
        }
    }
?>        

</form>

</body>
</html>
