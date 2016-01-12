<h1>Reservation/Room Rental Activity Panel</h1>
<div id="calendar">
	<?=$calendar; ?>
</div>
<div id="room_panel">
	<h2>Date: <?=$date; ?></h2>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		$("a").click(function() {
			$.ajax({
				type:'POST',
				data:{date: this.id},
				url: '<?=site_url('adminreservations/roominfo'); ?>',
				success: function(result) {
					var parsedResult = JSON.parse(result);					
					$('#room_panel').html("<h2>Date: " + parsedResult['date'] + "</h2>");
					for (var i = 0; i < parsedResult['booked'].length; i++) 
					{
						 $('#room_panel').append("<p><b>Room:</b> " + parsedResult['booked'][i]['room'] + "</p>");
						 $('#room_panel').append("<p style='padding-left: 15px;'><b>Guest:</b> " + parsedResult['booked'][i]['first_name'] + " " + parsedResult['booked'][i]['last_name'] + "</p>");
						 $('#room_panel').append("<p style='padding-left: 15px;'><b>Arrival:</b> " + parsedResult['booked'][i]['arrival'] + "</p>");
						 $('#room_panel').append("<p style='padding-left: 15px;'><b>Departure:</b> " + parsedResult['booked'][i]['departure'] + "</p>");
						 $('#room_panel').append("<p style='padding-left: 15px;'><b>Nights:</b> " + parsedResult['booked'][i]['nights'] + "</p>");
					}
					console.log(result);
				}
			});
		});
	});
</script>
