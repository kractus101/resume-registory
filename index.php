<?php
require_once "pdo.php";
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php";
?>
<title>Keya Bhadreshkumar Adhyaru- Autos Database</title>
</head>
<body>
<?php
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    #unset($_SESSION['success']);
}
?>


<div class="container">
<h1>Welcome to Automobiles Database</h1>
<?
if ( $row== null ) {
    echo "No rows found";
}
?>
<?php
if(!isset($_SESSION['success']))
{

echo('<p><a href="login.php">Please log in</a></p>');

echo('<p>Attempt to <a href="add.php">Add Data</a> without logging in </p>');
  
}
?>

<?php
if(isset($_SESSION['success']))
{   
    echo('<table border="1">'."\n");
    $stmt = $pdo->query("SELECT make,model, year, mileage, auto_id FROM auto");
    echo("<tr><th>Make</th><th>model</th><th>year</th><th>mileage</th><th>Action</th></tr>");    
    while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo "<tr><td>";
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
}
    echo ("</table>"."\n");



    echo('<p><a href="add.php">Add New Entry </a></p>');
    echo('<p><a href="logout.php">Logout</a></p>');
    return;
    unset($_SESSION['success']);
}

?>

</div>
</body>
</html>