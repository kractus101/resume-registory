<?php // Do not put any HTML above this line

// Redirect the browser to view.php

session_start();

#$_SESSION['name'] = $_POST['email'];
#header("Location: view.php");
#return;


$salt = 'XyZzy12*_';
$md5= hash('md5', $salt);
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is meow123
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
$failure = false;  // If we have no POST data
// Check to see if we have some POST data, if we do process it

if ( isset($_POST['email']) && isset($_POST['pass']) )
 {
    #unset($_SESSION['email']);
    $check = hash('md5', $salt.$_POST['pass']);
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION['failure'] = "Email and password are required";
    }   
    else 
    {
        $pass = htmlentities($_POST['pass']);
        $email = htmlentities($_POST['email']);

        if ((strpos($email, '@') === false)) 
        {
            $_SESSION['failure'] = "Email must have an at-sign (@)";
            header("Location: login.php");
            return;
        }
        else
        {
            $check = hash('md5', $salt.$pass);
            if ( $check == $stored_hash ) 
            {
                $_SESSION['email']=$email ;
                error_log("Login success ".$email);
                $_SESSION['success'] = "you are logged in";
                header("Location: index.php?name=".urlencode($email));
                return;
            } 
            else 
            {
                error_log("Login fail ".$pass." $check");
                $_SESSION['failure'] = "Incorrect password";
                header("Location: login.php");
                return;
            }
        }
    }
    }
 

// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Keya Bhadreshkumar Adhyaru Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( isset ($_SESSION['failure']))
{
    echo ('<p style="color:red">'.$_SESSION['failure']."</p>\n");
    unset($_SESSION['failure']);

}


?>
<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="email" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In" name="login">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>


</p>
</div>
</body>
