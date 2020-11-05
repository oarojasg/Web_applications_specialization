<?php
echo "<pre>\n";
$pdo=new PDO('mysql:host=localhost;port=3307;dbname=misc','oscar','1016044909');
//$stmt=$pdo->query("SELECT * FROM users");
//while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
//	print_r($row);
//}
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo "</pre>\n";