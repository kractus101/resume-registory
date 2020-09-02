<?php
session_start();
require_once "pdo.php";
if(isset($_POST['cancel']))
{
    header('Location: index.php');
    return;
}
if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) 
    && isset($_POST['mileage']) && isset($_POST['auto_id']))
{

    
            if(strlen($_POST['make'])<1)
            {
                $_SESSION['error']= "Make is required!!";
                header("Location: edit.php?auto_id=".$_POST['auto_id']);
                return;
            }

            if((strlen($_POST['make']) && strlen($_POST['model']) && strlen($_POST['year']) && strlen($_POST['mileage']))>=1)
            {
              if(is_numeric($_POST['year']) && is_numeric($_POST['mileage']))
            { 
                $sql= "UPDATE auto SET make= :mk,
                    model=:mo,
                   year=:yr,mileage=:mi
                    WHERE  auto_id=:auto_id";
            $stmt = $pdo->prepare($sql);
        
            $stmt->execute(array(
            ':mk' => $_POST['make'],
            ':mo' => $_POST['model'],
            ':yr' => $_POST['year'],
            ':mi' => $_POST['mileage'],
            ':auto_id' => $_POST['auto_id']));
            
            
                $_SESSION['success'] = 'Record updated';
                if(isset($_POST['save']))
                {
                     header('Location: index.php');
                     return;
                }
                
            }  
            else{
                $_SESSION['error'] = "mileage and year must be numeric";
                header("Location: edit.php?auto_id=".$_POST['auto_id']);
                return;
            
            }  
            }
            else{
                $_SESSION['error'] = "All fields are required";
                header("Location: edit.php?auto_id=".$_POST['auto_id']);
                return;
            }
                       
            
}             

if ( ! isset($_GET['auto_id']) ) {
    $_SESSION['error'] = "Missing auto_id";
    header('Location: index.php');
    return;
}            
                  
$stmt = $pdo->prepare("SELECT * FROM auto where auto_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for auto_id';
    header( 'Location: index.php' ) ;
    return;
    }                 // Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
$ma = htmlentities($row['make']);
$mo = htmlentities($row['model']);
$y = htmlentities($row['year']);
$m = htmlentities($row['mileage']);
$auto_id = $row['auto_id'];
?>
<h1>Editing Automobile <? echo ($_SESSION['who']); ?> </h1>
<form method="post">
<p>Make:
<input type="text" name="make" value="<?= $ma?>" size="50"></p>
<p>Model:
<input type="text" name="model" value="<?= $mo?>"></p>
<p>Year:
<input type="text" name="year" value="<?= $y?>"></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= $m?>"></p>
<input type="hidden" name="auto_id" value="<?= $auto_id ?>">
<p><input type="submit" value="Save" name="save"/>
<input type="submit" value="cancel" name="cancel"/></p>
</form>
</body>
</html>
