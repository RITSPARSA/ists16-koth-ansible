<?php
    include "header.php";
    include "manage_header.php";
    require "db.php";

    if (isset($_POST) && (isset($_POST['backup']) || 
        isset($_POST['restore']) || isset($_POST['delete'])) ) {
        if (isset($_POST['backup'])) {
            if (!empty($_POST['filename'])) {
                $filename = $_POST['filename'];
            }
            else {
                date_default_timezone_set("America/New_York");
                $dateString = date("ymd_His");
                $filename = "db_dump_" . $dateString . ".sql";
            }
            $command = "mysqldump --user root --add-drop-database " .
                "portal > /var/www/html/backups/" . $filename;
            shell_exec($command);
        }
        else if (isset($_POST['restore'])) {
            if (empty($_POST['filename'])) {
                echo "Error: Please specify filename to restore from.";
            }
            else {
                $filename = "/var/www/html/backups/" . $_POST['filename'];
                shell_exec("mysqladmin -u root -f drop portal");
                shell_exec("mysqladmin -u root -f create portal");
                shell_exec("mysql -u root portal < " . $filename);
            }
        }
        else {
            if (empty($_POST['filename'])) {
                echo "Error; Please specify filename to delete.";
            }
            else {
                $filename = "/var/www/html/backups/" . $_POST['filename'];
                $output = shell_exec("rm -f " . $filename);
                echo $output;
            }
        }
    }
?>
<html>
<head>
<title>Database Management</title>
</head>
<body>
<?php
    chdir("/var/www/html/backups");
    $output = shell_exec("ls -al");
    $output = str_replace("\n", "<br>", $output);
    echo "<br><div style='text-align: center;'> $output";
?>
<form action='db_mgmt.php' method='post'>
Filename: <input name='filename' type='text'><br>
<button type="submit" name='backup'>Backup</button>
<button type="submit" name='restore'>Restore</button>
<button type="submit" name='delete'>Delete File</button>
</form>

</body>
</html>
