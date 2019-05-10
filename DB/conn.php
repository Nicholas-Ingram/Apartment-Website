<?php
	$url = getenv("CLEARDB_DATABASE_URL");
	$parts = parse_url($url);
	$parts['path'] = explode("/", $parts['path'])[1];

	// Create connection
	$conn = new mysqli($parts['host'], $parts['user'], $parts['pass'], $parts['path']);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	// add_entry(
	// 	[
	// 		"Date" => "2019-05-08",
	// 		"Title" => "Test Entry",
	// 		"Body" => "Test Body"
	// 	]
	// );
	// This function will require an array that has this information:
	//	Date, Title, Body
	// And will store it in the database
	function add_entry($data)
	{
		global $conn;

		// We need to make sure that all ' in the strings are replaced with \'
		$data['Title'] = str_replace("'", "\'", $data['Title']);
		$data['Body'] = str_replace("'", "\'", $data['Body']);
		echo $data['Title'] . " " . $data['Body'];

		$sql = "INSERT INTO entries (Date, Title, Body) VALUES ('{$data['Date']}', '{$data['Title']}', '{$data['Body']}')";

		if ($conn->query($sql) === TRUE) {
		    echo "New record created successfully";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$conn->close();
	}
?>
