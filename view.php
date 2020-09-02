<?php
    session_start();
    require_once "pdo.php";

   if ( ! isset($_SESSION['email']) ) { 
    die('Not logged in');
  } 
  
       if ( isset($_POST['logout']) ) {
        header('Location: index.php');
        return;
    }

  
  if ( isset($_POST['add']))
{

            $stmt= null;
            $rows=$_SESSION['row'];
            if($rows=== null){
            echo('<p style="color: red;">Data not inserted</p>'."\n");
            }
            else{
                echo('<p style="color: green;">Record inserted</p>'."\n");
                }

            }   
$sql1="SELECT make, year, mileage, FROM auto";
$stmt = $pdo->prepare($sql1);
$stmt = $pdo->query($sql1);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt==null;
  

?>
<h1>Tracking Autos <? echo ($_SESSION['email']); ?> </h1>


<?php

echo "<h1>Automobiles</h1>";
if ( isset($_SESSION["success"]) ) {

    echo('<p style="color: green;">'.($_SESSION['success'])."</p>\n");
    foreach ( $rows as $r ) {
        echo($r['year']."".$r['make']."/".$r['mileage']);
        echo "<br/>";
    } 


}  

?>
<p>
<a href="add.php">Add New</a>
<? echo "|"; ?>
<a href="logout.php">Log Out</a>
</p>

