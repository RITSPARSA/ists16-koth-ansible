<?php
    $db = mysqli_connect('localhost', 'root', '', 'portal');
    if (!$db) {
        die("Header: Could not connect to database: " . 
            mysqli_connect_error($db));
    }

    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == 0) {
        header("Location: http://www.metropolis-general.com/login.php");
        die();
    }

    $portalLink = "<a href='portal.php'>Records</a> ";
    $settingLink = "<a href='settings.php'>Account Settings</a> ";

    $queryString = "SELECT admin FROM users WHERE id='" . $_SESSION['id'] .
        "'";
    $query = mysqli_query($db, $queryString);

    if (!$query) {
        die("Header: Couldn't determine admin status from db: " . 
            mysqli_error($db));
    }

    $row = mysqli_fetch_row($query);
    if ($row[0] == 1) {        
        $userMgmtLink = "<a href='manage.php'>Admin Panel</a> ";
    }
    else {
        $userMgmtLink = " ";
    }

    $newRecordLink = "<a href='new_record.php'>New Patient</a> ";
    $logOutLink = "<a href='logout.php'>Log Out</a>";
    $startDiv = "<div style='text-align:center'>";
    $endDiv = "</div>";
    switch ($_SERVER['PHP_SELF']) {
        case "/manage.php":
            printf("%s %s", $startDiv, $portalLink);
            printf("%s", $settingLink);
            printf("%s", "<strong>Manage Users</strong> ");
            printf("%s", $newRecordLink);
            printf("%s %s", $logOutLink, $endDiv);
            break;
        case "/new_user.php":
            printf("%s %s", $startDiv, $portalLink);
            printf("%s", $settingLink);
            printf("%s", "<strong>Manage Users</strong> ");
            printf("%s", $newRecordLink);
            printf("%s %s", $logOutLink, $endDiv);
            break;
        case "/settings.php":
            printf("%s %s", $startDiv, $portalLink);
            printf("%s", "<strong>Account Settings</strong> ");
            printf("%s", $userMgmtLink);
            printf("%s", $newRecordLink);
            printf("%s %s", $logOutLink, $endDiv);
            break;
        case "/new_record.php":
            printf("%s %s", $startDiv, $portalLink);
            printf("%s", $settingLink);
            printf("%s", $userMgmtLink);
            printf("%s", "<strong>New Patient</strong> ");
            printf("%s %s", $logOutLink, $endDiv);
            break;
        case "/portal.php":
            printf("%s %s", $startDiv, "<strong>Records</strong> ");
            printf("%s", $settingLink);
            printf("%s", $userMgmtLink);
            printf("%s", $newRecordLink);
            printf("%s %s", $logOutLink, $endDiv);
            break;
        default:
            printf("%s %s", $startDiv, $portalLink);
            printf("%s", $settingLink);
            printf("%s", $userMgmtLink);
            printf("%s", $newRecordLink);
            printf("%s %s", $logOutLink, $endDiv);
    }
?>
