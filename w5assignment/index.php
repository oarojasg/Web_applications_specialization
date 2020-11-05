<?php
require_once "pdo.php";
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Oscar Alejandro Rojas Gallego</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
	<div class="container">
		<h1>Welcome to the Automobiles Database</h1>

		<?php
		if ( isset($_SESSION['error']) ) {
		    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
		    unset($_SESSION['error']);
		}
		if ( isset($_SESSION['success']) ) {
		    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
		    unset($_SESSION['success']);
		}
		if (isset($_SESSION['name'])) {
			echo('<p><table border="1">'."\n");
			$stmt = $pdo->query("SELECT make, model, year, mileage, auto_id FROM autos");
			$countRows = 0;
			while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			    echo "<tr><td>";
			    if ($countRows == 0) {
			    	echo('<strong>Make</strong>');
				    echo("</td><td>");
				    echo('<strong>Model</strong>');
				    echo("</td><td>");
				    echo('<strong>Year</strong>');
				    echo("</td><td>");
				    echo('<strong>Mileage</strong>');
				    echo("</td><td>");
				    echo('<strong>Action</strong>');
				    echo("</td></tr>\n<tr><td>");
			    }  

			    echo(htmlentities($row['make']));
			    echo("</td><td>");
			    echo(htmlentities($row['model']));
			    echo("</td><td>");
			    echo(htmlentities($row['year']));
			    echo("</td><td>");
			    echo(htmlentities($row['mileage']));
			    echo("</td><td>");
			    echo('<a href="edit.php?auto_id='.$row['auto_id'].'">Edit</a> / ');
			    echo('<a href="delete.php?auto_id='.$row['auto_id'].'">Delete</a>');
			    echo("</td></tr>\n");
			    $countRows++;
			}
			if ($countRows == 0) echo("<p>No Rows Found</p>\n");
			echo("</table></p>\n");
			echo('<p><a href="add.php">Add New Entry</a></p>');
			echo('<p><a href="logout.php">Logout</a></p>');
		}
		else {
			echo('<p>');
			echo('<a href="login.php">Please log in</a>');
			echo('</p>');
			echo('<p>');
			echo('Attempt to '); 
			echo('<a href="add.php">add data</a> without logging in.');
			echo('</p>');
		}
		?>

			
	</div>
</body>

	
