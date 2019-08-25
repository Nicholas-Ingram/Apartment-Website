<?php include('DB/conn.php');

    delete_entry($_POST['ID']);

    if ($onLocalhost == false) {
        header("Location:index.php?date=".$_POST['Date']);
    } else {
        header("Location: http://localhost/Apartment-Website/index.php?date=".$_POST['Date']);
    }

 ?>
