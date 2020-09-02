<?php

session_start();
#$name = htmlentities($_GET['name']);

require_once "pdo.php";
if(isset($_POST['cancel']))
{
    header('Location: index.php');
    return;
}


if ( isset($_SESSION["success"]) && isset($_SESSION["email"]) ) {
    
    if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) 
    && isset($_POST['mileage']))
{

    $ma=htmlentities($_POST['make']);
    $mo=htmlentities($_POST['model']);
    $y=htmlentities($_POST['year']);
    $m=htmlentities($_POST['mileage']);
            if(strlen($ma)<1)
            {
                $_SESSION['error']= "Make is required!!";
                ($_SERVER['PHP_SELF']);
            }
            if((strlen($ma) && strlen($mo) && strlen($y) && strlen($m))<1)
            {
                echo "All fields are required!!";
                ($_SERVER['PHP_SELF']);

            }

            else
            {
                if(is_numeric($y) && is_numeric($m))
               {

                $sql= "INSERT INTO auto (make,model, year, mileage) VALUES ( :mk,:mo, :yr, :mi)";
                $stmt = $pdo->prepare($sql);
        
                 $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                 $stmt->execute([
                ':mk' => $ma,
                ':mo' => $mo,
                ':yr' => $y,
                ':mi' => $m
                 ]);
                $_SESSION['success'] = 'Record Added';
                 
                 if(isset($_POST['add']))
                {
                     header('Location: index.php');
                     return;
                }

                 }
                 else{     
                     
                    $_SESSION['error']="mileage and year must be numeric";
                    header("Location: add.php");
                    return;
                
                }
               

                }
            }


}
else{
    die('ACCESS DENIED');

}
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}


?>
<h1>Tracking Autos <? echo ($_SESSION["email"]);?> </h1>
<form method="post">
<p>Make:
<input type="text" name="make" size="50"></p>
<p>Model:
<input type="text" name="model"></p>
<p>Year:
<input type="text" name="year"></p>
<p>Mileage:
<input type="text" name="mileage"></p>
<p><input type="submit" value="Add New" name="add"/>
<input type="submit" value="cancel" name="cancel"/></p>
</form>
</body>
</html>
