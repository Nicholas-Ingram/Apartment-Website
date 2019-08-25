<?php include("DB/conn.php");

	$onLocalhost = strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ? true : false;
    $entry = get_entry_from_id($_POST['ID']);
    $entry = $entry[0];

    $onLocalhost = strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ? true : false;

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title></title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="Style/edit.css">

        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script type="text/javascript">
            var date = "<?= $_POST['Date'] ?>";
            var onLocalhost = "<?php echo $onLocalhost ?>";

            function cancelUpdate() {
                if (onLocalhost == 0) {
					window.location.href = "https://" + window.location.hostname + "/index.php?date=" + date;
				} else {
					window.location.href = "http://localhost/Apartment-Website/index.php?date=" + date;
				}
            }
        </script>
    </head>
    <body>
        <form action="<?php echo $onLocalhost == false ? "/entry-update.php" : "entry-update.php"; ?>" method="post" id="entryForm" name="entryForm">
            <input type="hidden" id="entryDate" value="<?= $entry['Date'] ?>" name="entryDate">
            <input type="hidden" id="entryID" value="<?= $entry['ID'] ?>" name="entryDate">
            <div class="form-group">
                <label for="entryOwner">Entry Owner</label>
                <input type="text" class="form-control" value="<?= $entry['owner'] ?>" placeholder="John Doe" id="entryOwner" name="entryOwner">
            </div>
            <div class="form-group">
                <label for="entryTitle">Entry Title</label>
                <input type="text" class="form-control" id="entryTitle" name="entryTitle" value="<?= $entry['Title'] ?>">
            </div>
            <div class="form-group">
                <label for="entryBody">Entry Body</label>
                <textarea id="entryBody" name="entryBody" form="entryForm" cols="30" rows="5" class="form-control"><?= $entry['Body'] ?></textarea>
            </div>
            <div class="btn-group" role="group">
                <button type="submit" class="btn btn-primary">Update Entry</button>
                <button type="button" class="btn btn-danger" onclick="updateEntry();">Cancel</button>
            </div>
        </form>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    </body>
</html>
