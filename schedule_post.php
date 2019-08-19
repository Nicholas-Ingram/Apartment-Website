<?php
	include('DB/conn.php');
	//	We need to take the body text from the post data (what is given from mailgun when the schedule email is received)
	//		and explode it on the line dividers. Then loop through each line and make a new entry for each day.
	$body_parts = explode("----------------------------------", $_POST['body-plain']);
	// Now do a for each loop that will go through each part of the body (except the first array position)
	for($week = 1; $week < count($body_parts); $week++)
	{
		// Remove the days and white space from each line
		$week_parts = preg_split('/(SUN    |MON   |TUE    |WED   |THU    |FRI     |SAT    )/', $body_parts[$week]);
		// Loop through each day
		for($day = 1; $day < count($week_parts); $day++)
		{
			// Get the date from the current day being looked at
			$date_parts = explode("/", substr($week_parts[$day], 0, 5));
			// Remove the wkc953 from the body of the text
			$body_text = substr(str_replace("wkc953", "", $week_parts[$day]), 7);
			// Make sure we aren't adding any NOT SCHEDULED days to the database
			if (strpos($body_text, 'NOT SCHEDULED') === false)
			{
				// Remove all the white space
				$body_text = str_replace(" ", "", $body_text);
				// Create an array that will hold the date, start, and end of the current days schedule
				$schedule = [
					"date" => substr($body_parts[0], -6, -2) . "-" . $date_parts[0] . "-" . $date_parts[1],
					"start" => substr($body_text, 0, 6),
					"end" => substr($body_text, -8)
				];

				// Remove the 0 from the start of the time if it isn't past 10
				if (substr($schedule['start'], 0, 1) == '0') {
					$schedule['start'] = substr($schedule['start'], 1);
				}
				if (substr($schedule['end'], 0, 1) == '0') {
					$schedule['end'] = substr($schedule['end'], 1);
				}

				//Finally send this data to the database
				add_entry([
					"Date" => $schedule['date'],
					"Title" => "Work Schedule",
					"Body" => substr($schedule['start'], 0, -1) . (strpos($schedule['start'], 'A') ? "AM" : "PM") . " to " .
								substr($schedule['end'], 0, -3) . (strpos($schedule['end'], 'A') ? "AM" : "PM"),
					"owner" => "Nick"
				]);
			}
		}
	}
?>
