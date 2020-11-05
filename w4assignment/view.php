<?php
require_once "connectionTest.php";
session_start();
// Demand a GET parameter
if ( ! isset($_SESSION['name']) || strlen($_SESSION['name']) < 1  ) {
    die('Not logged in');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: logout.php');
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
if ( isset($_SESSION['success']) ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
?>
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

<p><a href="add.php">Add New</a> | <a href="logout.php">Logout</a></p>
</div>
</body>
</html>
