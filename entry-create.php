<?php include('DB/conn.php');

    add_entry([
        "Date" => $_POST['entryDate'],
        "Title" => $_POST['entryTitle'],
        "Body" => $_POST['entryBody'],
        "owner" => $_POST['entryOwner']
    ]);

    header("Location:index.php?date=".$_POST['entryDate']);
	// header("Location: http://localhost/Apartment-Website/index.php?date=".$_POST['entryDate']);

 ?>
