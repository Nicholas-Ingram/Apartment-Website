<?php
	$url = getenv("CLEARDB_DATABASE_URL");
	$parts = parse_url($url);
	$parts['path'] = explode("/", $parts['path'])[1];

	// This function will require an array that has this information:
	//	Date, Title, Body
	// And will store it in the database
	function add_entry($data)
	{
		global $parts;

		// Create connection
		$conn = new mysqli($parts['host'], $parts['user'], $parts['pass'], $parts['path']);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		// Make sure the date string is in the correct format
		$data['Date'] = date('Y-m-d', strtotime($data['Date']));

		// We need to make sure that all ' in the strings are replaced with \'
		$data['Title'] = str_replace("'", "\'", $data['Title']);
		$data['Body'] = str_replace("'", "\'", $data['Body']);
		echo $data['Title'] . " " . $data['Body'];

		$sql = "INSERT INTO entries (Date, Title, Body, owner) VALUES ('{$data['Date']}', '{$data['Title']}', '{$data['Body']}', '{$data['owner']}')";

		if ($conn->query($sql) === TRUE) {
		    echo "New record created successfully";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$conn->close();
	}

	function get_distinct($column, $date)
	{
		global $parts;

		$date = date('Y-m-d', strtotime($date));

		// Create connection
		$conn = new mysqli($parts['host'], $parts['user'], $parts['pass'], $parts['path']);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		$res = $conn->query("SELECT DISTINCT {$column} FROM entries WHERE Date='{$date}'");

		$owners = array();

		$res->data_seek(0);
		while ($row = $res->fetch_assoc()) {
		    array_push($owners, $row['owner']);
		}

		$conn->close();

		return $owners;
	}

	function get_entry($owner, $date)
	{
		global $parts;

		$date = date('Y-m-d', strtotime($date));

		// Create connection
		$conn = new mysqli($parts['host'], $parts['user'], $parts['pass'], $parts['path']);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		$rows = array();

		$res = $conn->query("SELECT * FROM entries WHERE owner='{$owner}' AND Date='{$date}'");

		$res->data_seek(0);
		while ($row = $res->fetch_assoc()) {
		    array_push($rows, $row);
		}

		$conn->close();

		return $rows;
	}
?>
