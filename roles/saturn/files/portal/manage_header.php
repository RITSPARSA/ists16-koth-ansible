<?php
    $managementLink = "<a href = 'manage.php'>Manage Users</a> ";
    $newUserLink = "<a href='new_user.php'>New User</a> ";
    $databaseMgmtLink = "<a href='db_mgmt.php'>Database Management</a> ";
    $startDiv = "<div style='text-align:center'>";
    $endDiv = "</div>";
    switch ($_SERVER['REQUEST_URI']) {
        case "/manage.php":
            printf("%s %s", $startDiv, "<strong>Manage Users</strong> ");
            printf("%s", $newUserLink);
            printf("%s %s", $databaseMgmtLink, $endDiv);
            break;
        case "/new_user.php":
            printf("%s %s", $startDiv, $managementLink);
            printf("%s", "<strong>New User</strong>");
            printf("%s %s", $databaseMgmtLink, $endDiv);
            break;
        case "/db_mgmt.php":
            printf("%s %s", $startDiv, $managementLink);
            printf("%s", $newUserLink);
            printf("%s %s", "<strong>Database Management</strong>", $endDiv);
            break;
        default:
            printf("%s %s", $startDiv, $managementLink);
            printf("%s", $newUserLink);
            printf("%s %s", $databaseMgmtLink, $endDiv);
    }
?>
