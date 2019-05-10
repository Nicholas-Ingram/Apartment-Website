<?php
	include('DB/conn.php');

	$data = [
		"Date" => "2019-05-10",
		"Title" => "MailGun Post Test",
		"Body" => $_POST['body-plain']
	];
	add_entry($data);
?>
