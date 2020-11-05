<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['name']) || strlen($_SESSION['name']) < 1 ) {
    die("ACCESS DENIED");
}

if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) 
    && isset($_POST['model'])) {
    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1
        || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
        $_SESSION['errorMessage']="Missing data";
    }
    else if ( ! (is_numeric($_POST['year']) && is_numeric($_POST['mileage']))) {
        $_SESSION['errorMessage']="Bad data";
    }
    else {
        $stmt = $pdo->prepare('UPDATE autos SET
            make = :mk, model = :mo, year = :yr, mileage = :mi
            WHERE auto_id= :auto_id');
        $stmt->execute(array(
            ':mk' => htmlentities($_POST['make']),
            ':mo' => htmlentities($_POST['model']),
            ':yr' => htmlentities($_POST['year']),
            ':mi' => htmlentities($_POST['mileage']),
            ':auto_id' => htmlentities($_POST['auto_id'])
            )
        );
        $_SESSION['success']="Record updated";
        header("Location: index.php");
        return;
    }
    header('Location: edit.php?auto_id='.$_POST['auto_id']);
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['auto_id']) ) {
  $_SESSION['error'] = "Missing auto_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where auto_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for auto_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['errorMessage']) ) {
    echo '<p style="color:red">'.$_SESSION['errorMessage']."</p>\n";
    unset($_SESSION['errorMessage']);
}

$m = htmlentities($row['make']);
$o = htmlentities($row['model']);
$i = htmlentities($row['mileage']);
$y = htmlentities($row['year']);
$auto_id = $row['auto_id'];
?>
<head>
    <title>Oscar Alejandro Rojas Gallego</title>
</head>
<h1>Edit User</h1>
<form method="post">
<p>Make:
<input type="text" name="make" value="<?= $m ?>"></p>
<p>Model:
<input type="text" name="model" value="<?= $o ?>"></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= $i ?>"></p>
<p>Year:
<input type="text" name="year" value="<?= $y ?>"></p>
<input type="hidden" name="auto_id" value="<?= $auto_id ?>">
<p><input type="submit" value="Save"/>
<a href="index.php">Cancel</a></p>
</form>
