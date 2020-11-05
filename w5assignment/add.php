<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['name']) || strlen($_SESSION['name']) < 1 ) {
    die("ACCESS DENIED");
}

if ( isset($_POST['cancel']) ) {
    header('Location: index.php');
    return;
}

if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) 
    && isset($_POST['model'])) {
    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1
        || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
        $_SESSION['errorMessage']="All fields are required";
    }
    else if ( ! (is_numeric($_POST['year']) && is_numeric($_POST['mileage']))) {
        $_SESSION['errorMessage']="Mileage and year must be numeric";
    }
    else {
        $stmt = $pdo->prepare('INSERT INTO autos
            (make, model, year, mileage) VALUES ( :mk, :mo, :yr, :mi)');
        $stmt->execute(array(
            ':mk' => htmlentities($_POST['make']),
            ':mo' => htmlentities($_POST['model']),
            ':yr' => htmlentities($_POST['year']),
            ':mi' => htmlentities($_POST['mileage']))
        );
        $_SESSION['success']="Record added";
        header("Location: index.php");
        return;
    }
    header("Location: add.php");
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
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
    <p>Model: <input type="text" name="model"></p>
    <p>Year: <input type="text" name="year"></p>
    <p>Mileage: <input type="text" name="mileage"></p>
    <p><input type="submit" name="Add" value="Add">
    <input type="submit" name="cancel" value="Cancel"></p>
</form>
</div>
</body>
</html>