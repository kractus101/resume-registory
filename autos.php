<?php

if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}
$name = htmlentities($_GET['name']);
require_once "pdo.php";



if ( isset($_POST['make']) && isset($_POST['year']) 
     && isset($_POST['mileage']))
{

    $ma=htmlentities($_POST['make']);
    $y=htmlentities($_POST['year']);
    $m=htmlentities($_POST['mileage']);
            if(strlen($ma && $y && $m)<1)
            {
                echo "All Fields are required!!";
                ($_SERVER['PHP_SELF']);
            }
            else
            {
                if(is_numeric($y) && is_numeric($m))
               {

                $sql= "INSERT INTO auto (make, year, mileage) VALUES ( :mk, :yr, :mi)";
                $stmt = $pdo->prepare($sql);
        
                 $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                 $stmt->execute([
                ':mk' => $ma,
                ':yr' => $y,
                ':mi' => $m
                 ]);
            $stmt= null;
            if($row=== null){
            echo('<p style="color: red;">Data not inserted</p>'."\n");
            }
            else{
                echo('<p style="color: green;">Record inserted</p>'."\n");
                }

            }   

            else{
                echo ('<p style="color: red;">mileage and year must be numeric</p>'."\n");
                ($_SERVER['PHP_SELF']);  
            }
        
    
            }
}
     
     $sql1="SELECT make, year, mileage FROM auto";
     $stmt = $pdo->prepare($sql1);
     $stmt = $pdo->query($sql1);
     $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
     $stmt==null;
?>
<h1>Tracking Autos <? echo $name;?> </h1>
<form method="post">
<p>Make:
<input type="text" name="make" size="50"></p>
<p>Year:
<input type="text" name="year"></p>
<p>Mileage:
<input type="text" name="mileage"></p>
<p><input type="submit" value="Add New"/>
<input type="submit" value="Logout" name="logout"/></p>
</form>
</body>
</html>

<?php
echo "<h1>Automobiles</h1>";
foreach ( $row as $r ) {
     echo($r['year']."".$r['make']."/".$r['mileage']);
     echo "<br/>";
} 
?>
<?
if ( isset($_POST['logout'] ) ) {
    // Redirect the browser to autos.php
    header('Location: index.php');
    return;
}
?>
                                                                                                                  