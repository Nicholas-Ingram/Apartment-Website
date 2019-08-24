<?php include('DB/conn.php');

    add_entry([
        "Date" => $_POST['entryDate'],
        "Title" => $_POST['entryTitle'],
        "Body" => $_POST['entryBody'],
        "owner" => $_POST['entryOwner']
    ]);

	$onLocalhost = strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ? true : false;
	var_dump($onLocalhost);

	if ($onLocalhost == false) {
    	header("Location:index.php?date=".$_POST['entryDate']);
	} else {
		header("Location: http://localhost/Apartment-Website/index.php?date=".$_POST['entryDate']);
	}

 ?>
