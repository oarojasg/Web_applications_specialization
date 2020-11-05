<?php
require_once "connectionTest.php";
// Demand a GET parameter
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}

$errorMessage = false;
if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) ) {
    if ( strlen($_POST['make']) < 1) {
        $errorMessage="Make is required";
    }
    else if ( ! (is_numeric($_POST['year']) && is_numeric($_POST['mileage']))) {
        $errorMessage="Mileage and year must be numeric";
    }
    else {
        $stmt = $pdo->prepare('INSERT INTO autos
            (make, year, mileage) VALUES ( :mk, :yr, :mi)');
        $stmt->execute(array(
            ':mk' => htmlentities($_POST['make']),
            ':yr' => htmlentities($_POST['year']),
            ':mi' => htmlentities($_POST['mileage']))
        );
        $errorMessage="Record inserted";
    }
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
<h1>Tracking Autos for <?= htmlentities($_GET['name']) ?></h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( $errorMessage !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($errorMessage)."</p>\n");
}
?>

<form method="post">
    <p>Make: <input type="text" name="make" size="40"></p>
    <p>Year: <input type="text" name="year"></p>
    <p>Mileage: <input type="text" name="mileage"></p>
    <p><input type="submit" name="Add">
    <input type="submit" name="logout" value="Logout"></p>
</form>

<h2>Automobiles</h2>
<?php
$stmt=$pdo->query("SELECT * FROM autos ORDER BY make ASC");
if ( $stmt->fetch(PDO::FETCH_ASSOC) !== false) {
    echo '<ul>'."\n";
    while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<li>';
        echo($row['year']);
        echo " ";
        echo($row['make']);
        echo " / ";
        echo($row['mileage']);
        echo "</li>"."\n";
    }
    echo '</ul>'."\n";
}
?>
</div>
</body>
</html>
