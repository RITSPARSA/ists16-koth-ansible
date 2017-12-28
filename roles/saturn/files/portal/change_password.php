<?php require_once 'db.php'; ?>

<html>
<head>
<title>Change Password</title>
<body>

<form action="change_password.php" method="post">
Username: <input type="text" name="name"<br>
Password: <input type="password" name="password"><br>
<input type="submit" value="Change Password" name="change">

<?php
	$db = db_connect();
    $email_subject = "Metropolis General Management Portal Password Reset";
    $email_message = "Hello! We have successfully reset your password! Your " .
        "new password is: ";
    $email_message_2 = " If you did not request this, please contact the " .
        "security team immediately.";
	if (isset($_POST['change']) && !empty($_POST['name'])
	    && !empty($_POST['password'])) {
        $newpassword = substr(md5(microtime()),rand(0,26),10);
        $query = "UPDATE users SET password='" . $newpassword . 
           "' WHERE username='" . $_POST['name'] . "'";
        $result = mysqli_query($db, $query);
        if (!$result) {
            echo "<br>Error updating database: " . mysqli_error($db);
        }
        else {
            $query = "SELECT email FROM users WHERE username = '" . 
                $_POST['name'] . "'";
            $result = mysqli_query($db, $query);
            if (!result) {
                echo "<br>Error retrieving email address from database: " .
                    mysqli_error($db);
            }
            else {
                $rowcount = mysqli_num_rows($result);
                $row = mysqli_fetch_row($result);
                if ($rowcount > 0 && !empty($row[0])) {
                    $from = 'From: noreply@metropolis-general.com';
                    $to = $row[0];
                    $message = $email_message . $newpassword . "." . 
                        $email_message_2;
                    $headers = "From: " . $from . "\r\n" .
                        "To: " . $to  . "\r\n" .
                        "Reply-To: noreply@metropolis-general.com" . "\r\n" .
                        "X-Mailer: PHP/" . phpversion();
                    mail($to, $email_subject, $message, $headers);
                    echo "<br>Password reset and email sent!";
                }
                else {
                    echo "<br>Unable to locate email. Did you set an email " .
                        "when you created your account?";
                }
            }
        }
    }
?>

</body>
</html>
