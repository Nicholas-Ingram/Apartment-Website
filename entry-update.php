<?php include("DB/conn.php");

    update_entry([
        "ID" => $_POST['entryID'],
        "Date" => $_POST['entryDate'],
        "owner" => $_POST['entryOwner'],
        "Title" => $_POST['entryTitle'],
        "Body" => $_POST['entryBody']
    ]);

    $onLocalhost = strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ? true : false;

    if ($onLocalhost == false) {
        header("Location:index.php?date=".$_POST['Date']);
    } else {
        header("Location: http://localhost/Apartment-Website/index.php?date=".$_POST['Date']);
    }

 ?>
