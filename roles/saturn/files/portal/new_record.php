<html>
<head>
<title>New Patient</title>
<body>

<?php
    require_once "db.php";
    include "header.php";
?>

<br><div style="text-align: center">
<form action="new_record.php" method="post">
First Name: <input type="text" name="firstname"><br>
Last Name: <input type="text" name="lastname"><br>
Sex: 
<input type="radio" name="sex" value="M"> Male
<input type="radio" name="sex" value="F"> Female<br>
<?php
    // Automatically generate the date of birth dropdown boxes.
    echo "Date of Birth: <select id='month' name='month'>\n";
    echo "<option value='' selected>Month</option>\n";
    for ($i=1; $i < 13; $i++) {
        printf("%s%02d%s%02d%s", "<option value='", $i, "'>", 
            $i, "</option>\n");
    }
    echo "</select>\n";

    echo "<select id='day' name='day'>\n";
    echo "<option value='' selected>Day</option>\n";
    for ($i=1; $i < 32; $i++) {
        printf("%s%02d%s%02d%s", "<option value='", $i, "'>",
            $i, "</option>\n");
    }
    echo "</select>\n";

    echo "<select id='year' name='year'>\n";
    echo "<option value='' selected>Year</option>\n";
    for ($i=1900; $i < 2018; $i++) {
        printf("%s%4d%s%4d%s", "<option value='", $i, "'>",
            $i, "</option>\n");
    }
    echo "</select><br>\n";
?>
Notes: <textarea name="notes" cols="50" rows="20"></textarea><br>
<input type="submit" name="submit" value="Create Patient">
</form>

<?php
    $db = db_connect();
    if (!$db) {
        echo "Error connecting to database: " . mysqli_error($db);
    }
    if (isset($_POST['submit']) && !empty($_POST['firstname'])
        && !empty($_POST['lastname']) && !empty($_POST['sex'])
        && !empty($_POST['year']) && !empty($_POST['month'])
        && !empty($_POST['day'])) {
        $queryString = "INSERT INTO patients (firstName, lastName, sex, " .
            "birthDate";
        if (!empty($_POST['notes'])) {
            $queryString = $queryString . ", notes";
        }
        $queryString = $queryString . ") VALUES ('" . $_POST['firstname'] 
            . "', '" . $_POST['lastname'] . "', '" . $_POST['sex'] . "', '" . 
            $_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day'] . "'";
        if (!empty($_POST['notes'])) {
            $queryString = $queryString . ", '" . $_POST['notes'] . "'";
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
