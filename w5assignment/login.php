<!-- The model -->

<?php // Do not put any HTML above this line
session_start();
// Redirect the browser to view.php

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
    header("Location: logout.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';//php123

//$failure = false;  // If we have no POST data

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    unset($_SESSION['name']);
    
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION['failure'] = "Email and password are required";
    } else {
        if (strpos($_POST['email'],'@') <= 0) {
            $_SESSION['failure'] = "Email must have an at-sign (@)";
        }
        else {
            $check = hash('md5', $salt.$_POST['pass']);
            if ( $check == $stored_hash ) {
                // Redirect the browser to game.php
                //header("Location: game.php?name=".urlencode('Oscar'));
                $_SESSION['name'] = $_POST['email'];
                error_log("Login success ".$_POST['email']);
                header("Location: index.php");
                return;
            } else {
                error_log("Login fail ".$_POST['email']." $check");
                $_SESSION['failure'] = "Incorrect password";
            }
        }  
    }
    header("Location: login.php");
    return;
}

// Fall through into the View
?>

<!-- The view -->

<!DOCTYPE html>
<html>
<head>
    <?php require_once "bootstrap.php"; ?> 
<!-- <?php //require_once "bootstrap.php"; ?> -->
<title>Oscar Alejandro Rojas Gallego</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( isset($_SESSION['failure']) ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($_SESSION['failure'])."</p>\n");
    unset($_SESSION['failure']);
}
?>

<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="email" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="password" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
 <a href="index.php">Cancel</a>
<!-- <input type="submit" name="cancel" value="Cancel"> -->
</form>
<p></p>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
</p>
</div>
</body>
