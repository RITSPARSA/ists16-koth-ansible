<html>
<head>
<title>Edit Record</title>
<body>

<?php
    require_once "db.php";
    include "header.php";
    session_start();
    $db = db_connect();

    if (!$db) {
        echo "Error connecting to database: " . mysqli_error($db);
    }

    function queryWrapper($queryString) {
    	global $db;
        $query = mysqli_query($db, $queryString);
        if (!$query) {
            echo "Error accessing database: " . mysqli_error($db);
        }
        $row = mysqli_fetch_row($query);
        return $row[0];
    }

    $firstName = queryWrapper("select firstName from patients where id = '" .
        $_GET['id'] . "'");

    $lastName = queryWrapper("select lastName from patients where id = '" .
        $_GET['id'] . "'");

    $sex = queryWrapper("select sex from patients where id = '" .
        $_GET['id'] . "'");

    $dateOfBirth = queryWrapper("select birthDate from patients where id = '" .
        $_GET['id'] . "'");

    date_default_timezone_set("America/New_York");
    $year = date('Y', strtotime($dateOfBirth));
    $month = date('n', strtotime($dateOfBirth));
    $day = date('j', strtotime($dateOfBirth));

    $notes = queryWrapper("select notes from patients where id = '" .
        $_GET['id'] . "'");

    function update_if_different($original, $new, $field) {
        global $db;
        if (isset($new) && !empty($new) && $new != $original) {
            $queryString = "UPDATE patients SET " . $field . "=" . "'" . 
             $new . "'" . " WHERE id =" . $_POST['id'];
            $query = mysqli_query($db, $queryString);
            if (!$query) {
                echo "Error querying database: " . mysqli_error($db);
            }
        }
    }
    if (isset($_POST['submit'])) {
        update_if_different($firstName, $_POST['firstname'], "firstName");
        update_if_different($lastName, $_POST['lastname'], "lastName");
        update_if_different($sex, $_POST['sex'], "sex");
        update_if_different($notes, $_POST['notes'], "notes");
        $newString = $_POST['year'] . "-" . $_POST['month'] . "-" 
            . $_POST['day'];
        $newDateOfBirth = strtotime($newString);
        $newDateOfBirth = date("Y-m-d", $newDateOfBirth);
        update_if_different($dateOfBirth, $newDateOfBirth, "birthDate");
    }
?>

<br><div style="text-align: center">
<?php
    echo "<form action='modify.php?id=" . $_GET['id'] . "' method='post'>";

    $firstName = queryWrapper("select firstName from patients where id = '" .
        $_GET['id'] . "'");

    $lastName = queryWrapper("select lastName from patients where id = '" .
        $_GET['id'] . "'");

    $sex = queryWrapper("select sex from patients where id = '" .
        $_GET['id'] . "'");

    $dateOfBirth = queryWrapper("select birthDate from patients where id = '" .
        $_GET['id'] . "'");

    date_default_timezone_set("America/New_York");
    $year = date('Y', strtotime($dateOfBirth));
    $month = date('n', strtotime($dateOfBirth));
    $day = date('j', strtotime($dateOfBirth));

    $notes = queryWrapper("select notes from patients where id = '" .
        $_GET['id'] . "'");

    echo "First Name: <input type=\"text\" name=\"firstname\" value='" .
        $firstName . "'><br>";

    echo "Last Name: <input type=\"text\" name=\"lastname\" value='" .
        $lastName . "'><br>";

    echo "Sex:\n"; 
    if ($sex == "M") {
        $buttons = "<input type='radio' name='sex' value='M' checked> Male\n" .
            "<input type='radio' name='sex' value='F'> Female<br>\n";
    }
    else {
        $buttons = "<input type='radio' name='sex' value='M'> Male\n" .
            "<input type='radio' name='sex' value='F' checked> Female<br>\n";
    } 

    echo $buttons;

    echo "Date of birth: <select id='month' name='month'" . 
        " autocomplete='off'>\n";
    echo "<option value=''>Month</option>\n";
    for ($i=1; $i < 13; $i++) {
        if ($i == $month) {
            $closeTag = "' selected>";
        }
        else {
            $closeTag = "'>";
        }
        printf("%s%02d%s%02d%s", "<option value='", $i, $closeTag, $i,
            "</option>\n");
    }
    echo "</select>\n";

    echo "<select id='day' name='day' autocomplete='off'>\n";
    echo "<option value=''>Day</option>\n";
    for ($i=1; $i < 32; $i++) {
        if ($i == $day) {
            $closeTag = "' selected>";
        }
        else {
            $closeTag = "'>";
        }       
        printf("%s%02d%s%02d%s", "<option value='", $i, $closeTag, $i,
            "</option>\n");
    }
    echo "</select>\n";

 
    echo "<select id='year' name='year' autocomplete='off'>\n";
    echo "<option value=''>Year</option>\n";
    for ($i=1900; $i < 2018; $i++) {
        if ($i == $year) {
            $closeTag = "' selected>";
        }
        else {
            $closeTag = "'>";
        }       
        printf("%s%4d%s%4d%s", "<option value='", $i, $closeTag, $i,
            "</option>\n");
    }
    echo "</select><br>\n";   

    echo "Notes: <textarea name='notes' cols='50' rows='20'>" . 
        $notes . "</textarea><br>";
    echo "<input type='hidden' value='" . $_GET['id'] . "' name='id'>";
    echo "<input type='submit' value='Submit' name='submit'>";
?>
</form>

</body>
<html>
