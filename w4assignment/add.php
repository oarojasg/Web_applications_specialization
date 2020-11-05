<?php
require_once "connectionTest.php";
session_start();
// Demand a GET parameter
if ( ! isset($_SESSION['name']) || strlen($_SESSION['name']) < 1  ) {
    die('Not logged in');
}

// If the user requested logout go back to index.php
if ( isset($_POST['cancel']) ) {
    header('Location: view.php');
    return;
}

if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) ) {
    if ( strlen($_POST['make']) < 1) {
        $_SESSION['errorMessage']="Make is required";
    }
    else if ( ! (is_numeric($_POST['year']) && is_numeric($_POST['mileage']))) {
        $_SESSION['errorMessage']="Mileage and year must be numeric";
    }
    else {
        $stmt = $pdo->prepare('INSERT INTO autos
            (make, year, mileage) VALUES ( :mk, :yr, :mi)');
        $stmt->execute(array(
            ':mk' => htmlentities($_POST['make']),
            ':yr' => htmlentities($_POST['year']),
            ':mi' => htmlentities($_POST['mileage']))
        );
        $_SESSION['success']="Record inserted";
        header("Location: view.php");
        return;
    }
    header("Location: add.php");
    return;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Oscar Alejandro Rojas Gallego</title>
<?php require_once "bootstrap.php"; ?> 
</head>
<body>
<div class="container">
<h1>Tracking Autos for <?= htmlentities($_SESSION['name']) ?></h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( isset($_SESSION['errorMessage']) ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($_SESSION['errorMessage'])."</p>\n");
    unset($_SESSION['errorMessage']);
}
?>

<form method="post">
    <p>Make: <input type="text" name="make" size="40"></p>
    <p>Year: <input type="text" name="year"></p>
    <p>Mileage: <input type="text" name="mileage"></p>
    <p><input type="submit" name="Add" value="Add">
    <input type="submit" name="cancel" value="Cancel"></p>
</form>
</div>
</body>
</html>