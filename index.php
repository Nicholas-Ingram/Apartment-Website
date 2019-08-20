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
    <title></title>

	<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="Style/master.css">

	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
		$(function() {
			$("#datepicker").datepicker();
			$('#datepicker').datepicker().on('changeDate', function(e) {
				$('#datepicker').change();
			});
			$('#datepicker').change(function () {
				window.location.href = "https://" + window.location.hostname + "/index.php?date=" + $('#datepicker').val();
			});

			$('.dropdown').on('hide.bs.dropdown', function (e) {
				var t = $("#edatepicker");
		        var mouseX = event.clientX + document.body.scrollLeft;
		        var mouseY = event.clientY + document.body.scrollTop;
		        if (mouseX >= t.offset().left && mouseX <= t.offset().left + t.width()
		                && mouseY >= t.offset().top && mouseY <= t.offset().top + t.height()) {
		            return false;
		        } else {
					return true;
				}
			});
		});
	</script>
  </head>
  <body>
    <section id="dayView" class="p-4">
    	 <section id="dayTitle">

    	 	<h2 class="ml-5">Entries on: </h2>
			<div class="dropdown">
				<button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $date; ?></button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<div id="datepicker"></div>
				</div>
			</div>

    	 </section>
		 <section id="dayBody">

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
									</div>
									<div class="card-body">
										<h5 class="card-title"><?= $rowValue['Body']; ?></h5>
									</div>
								</div>

							<?php endforeach; ?>
						</div>
					</div>
				</div>

			<?php endforeach; ?>

		 </section>
    </section>

	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
