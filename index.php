<?php
	include('DB/conn.php');
	if (isset($_GET['date']))
	{
		$date = $_GET['date'];
	}
	else
	{
		$date = date('m/d/y');
	}

	$owners = array();
	$owners = get_distinct('owner', $date);

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<link rel="shortcut icon" type="image/x-icon" href="/Image/favicon.ico">
	<link rel="apple-touch-icon" href="/Image/apple-touch-icon.png">
    <title></title>

	<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="Style/master.css">

	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
		var dateStr = "<?php echo $date ?>";

		$(function() {
			$("#datepicker").datepicker();
			$("#datepicker").click(function() {
				$("#datepicker").datepicker('show');
			});
			$('#datepicker').datepicker().on('changeDate', function(e) {
				$('#datepicker').change();
			});
			$('#datepicker').change(function () {
				window.location.href = "https://" + window.location.hostname + "/index.php?date=" + $("#datepicker").val();
				// window.location.href = "http://localhost/Apartment-Website/index.php?date=" + $("#datepicker").val();
			});

			$('.drop-datepicker').on('hide.bs.dropdown', function (e) {
				var t = $("#datepicker");
		        var mouseX = event.clientX + document.body.scrollLeft;
		        var mouseY = event.clientY + document.body.scrollTop;
		        if (mouseX >= t.offset().left && mouseX <= t.offset().left + t.width() && mouseY >= t.offset().top && mouseY <= t.offset().top + t.height()) {
		            return false;
		        } else {
					return true;
				}
			});
		});

		function updateDate(amount) {
			var date = new Date(dateStr);
			date.setDate(date.getDate() + amount);

			var month = date.getMonth() + 1;
			var day = date.getDate();
			var year = date.getFullYear();

			if (month < 10) {
				month = "0" + month;
			}

			if (day < 10) {
				day = "0" + day;
			}

			window.location.href = "https://" + window.location.hostname + "/index.php?date=" + month + "/" + day + "/" + year;
			// window.location.href = "http://localhost/Apartment-Website//index.php?date=" + month + "/" + day + "/" + year;
		}
	</script>
  </head>
  <body>
    <section id="dayView" class="p-4">
    	 <section id="dayTitle">

    	 	<h2>Entries on</h2>

			<div>
				<div class="btn-group" role="group" aria-label="btn group">
					<button class="btn cal-sub" type="button" onclick="updateDate(-1);">
						<div class="btn-cal">-</div>
					</button>
					<div class="btn-group" role="group">
						<div class="dropdown drop-datepicker">
							<button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $date; ?></button>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
								<div id="datepicker"></div>
							</div>
						</div>
					</div>
					<button class="btn cal-add" type="button" onclick="updateDate(1);">
						<div class="btn-cal">+</div>
					</button>
				</div>

				<div class="dropdown drop-add-entry">
					<button class="btn dropdown-toggle" type="button" id="dropdownAddEntryButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Create Entry</button>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownAddEntryButton">
						<form action="/entry-create.php" method="post" id="entryForm" name="entryForm">
						<!-- <form action="entry-create.php" method="post" id="entryForm" name="entryForm"> -->
							<input type="hidden" id="entryDate" value="<?php echo $date; ?>" name="entryDate">
							<div class="form-group">
								<label for="entryOwner">Entry Owner</label>
								<input type="text" class="form-control" placeholder="John Doe" id="entryOwner" name="entryOwner">
							</div>
							<div class="form-group">
								<label for="entryTitle">Entry Title</label>
								<input type="text" class="form-control" id="entryTitle" name="entryTitle">
							</div>
							<div class="form-group">
								<label for="entryBody">Entry Body</label>
								<textarea id="entryBody" name="entryBody" form="entryForm" cols="30" rows="3" class="form-control"></textarea>
							</div>
							<button type="submit" class="btn btn-primary">Add Entry</button>
						</form>
					</div>
				</div>
			</div>

    	 </section>
		 <section id="dayBody" <?php if (count($owners) <= 0) {echo "style=\"display:flex;\"";} ?>>

			<?php if (count($owners) > 0): ?>
				<?php foreach ($owners as $key => $value): ?>

					<div class="owner-entries card">
						<div class="card-header owner-header"><?= $value ?></div>
						<div class="entries">
							<div class="entry-container card-body">

								<?php $rows = get_entry($value, $date);
								      foreach ($rows as $rowKey => $rowValue) : ?>

									<div class="card entry-card">
										<div class="card-header">
											<?= $rowValue['Title']; ?>
											<button class="btn-del-entry" value="<?php echo $rowValue['Id']; ?>"><ion-icon name="trash"></ion-icon></button>
											<button class="btn-edit-entry" value="<?php echo $rowValue['Id']; ?>"><ion-icon name="create"></ion-icon></button>
										</div>
										<div class="card-body">
											<p class="card-text"><?= $rowValue['Body']; ?></p>
										</div>
									</div>

								<?php endforeach; ?>
							</div>
						</div>
					</div>

				<?php endforeach; ?>
			<?php else: ?>

				<div class="no-entries">
					<h3>No entries on <?php echo $date ?></h3>
				</div>

			<?php endif; ?>

		 </section>
		 <div class="attribution">Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/"             title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/"             title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
    </section>

	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
  </body>
</html>
