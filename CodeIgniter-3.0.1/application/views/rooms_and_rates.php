<h1 style="color: green; text-align: left;">Our rooms and rates</h1>
<table style="margin: 10px; margin-left: 50px;">
<? foreach($all_rooms as $room): ?>
	<tr>
		<th style="text-align: left; font-size: 1.5em;">Room <?=$room->room_no; ?> <?=$room->room_description; ?> - Rate: $<?=$room->room_rate; ?></th>
	</tr>
	<tr>
		<td><?=$room->long_description; ?></td>
	</tr>
<? endforeach; ?>
</table>
	