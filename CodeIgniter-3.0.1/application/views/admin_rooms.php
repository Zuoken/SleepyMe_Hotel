<ul id="admin_rooms_nav" style="list-style: none;">
	<li><a style="text-decoration: none;" href=<?=site_url().'/adminrooms/add' ?>>Add A Room</a></li>
	<li><a style="text-decoration: none;" href=<?=site_url().'/adminrooms/display' ?>>Display All Rooms</a></li>
</ul>

<? if ($room_edit == 'add' || $room_edit == 'edit'): ?>
	<form id="room_entry" method='post' action=<?
			if ($room_edit == 'add') {echo site_url().'/adminrooms/insert';}
			else {echo site_url().'/adminrooms/update';}; 
		?>>
		<fieldset>
			<legend>Room Entry Form</legend>
			<table>
				<tr>
					<td>Room No:</td>
					<td><input type="text" name="room_no" required value=
					<? if ($room_edit == 'edit'): ?>
						<? foreach ($room as $rm): ?>
							<?=$rm->room_no; ?>
						<? endforeach; ?>
					<? endif; ?>
					></td>
				</tr>
				<tr>
					<td>Room Description:</td>
					<td><input type="text" name="room_description" required value=
					<? if ($room_edit == 'edit'): ?>
						<? foreach ($room as $rm): ?>
							<?="'".$rm->room_description."'"; ?>
						<? endforeach; ?>
					<? endif; ?>
				></td>
				</tr>
				<tr>
					<td>Room Rate:</td>
					<td><input type="text" name="room_rate" required value=
					<? if ($room_edit == 'edit'): ?>
						<? foreach ($room as $rm): ?>
							<?=$rm->room_rate; ?>
						<? endforeach; ?>
					<? endif; ?>
				></td>
				</tr>
			</table>
			<textarea name="editor" id="editor" rows="10" required cols="80">
				<? if ($room_edit == 'edit'): ?>
					<? foreach ($room as $rm): ?>
						<?=$rm->long_description; ?>
					<? endforeach; ?>
				<? endif; ?>
			</textarea>
			<script>
				var editor = CKEDITOR.replace('editor', {
					filebrowserBrowseUrl : <?="'".assetUrl() . 'js/ckfinder/'."ckfinder.html'"; ?>,
			        filebrowserUploadUrl : <?="'".assetUrl() . 'js/ckfinder/'."core/connector/php/connector.php?command=QuickUpload&type=Images'"; ?>,
					filebrowserImageBrowseUrl : <?="'".assetUrl() . 'js/ckfinder/'."ckfinder.html?Type=Images'"; ?>,
					filebrowserImageUploadUrl : <?="'".assetUrl() . 'js/ckfinder'."/core/connector/php/connector.php?command=QuickUpload&type=Images'"; ?>
				});
				CKFinder.setupCKEditor(editor, <?="'".assetUrl() . 'js/ckfinder/'."'"; ?>);
			</script>
			<br />
			<input type="submit" value="update">
		</fieldset>
	</form>
<? elseif ($room_edit == "display"): ?>
	<table style="margin: 10px; margin-left: 50px; border: 1px solid black; border-collapse: collapse;">
		<tr style="border: 1px solid black;">
			<th style="border: 1px solid black;">Room No</th>
			<th style="border: 1px solid black;">Room Name</th>
			<th style="border: 1px solid black;">Room Description</th>
			<th style="border: 1px solid black;">Rate</th>
			<th style="border: 1px solid black;">Edit</th>
		</tr>
	<? foreach($all_rooms as $room): ?>
		<tr style="border: 1px solid black; collapse: collapse;">
			<td style="border: 1px solid black;"><?=$room->room_no; ?></td>
			<td style="border: 1px solid black;"><?=$room->room_description; ?></td>
			<td style="border: 1px solid black;"><?=$room->long_description; ?></td>
			<td style="border: 1px solid black;"><?=$room->room_rate; ?></td>
			<td style="border: 1px solid black;">
				<a href=<?=site_url().'/adminrooms/edit/'.$room->room_no ?> style="text-decoration: none;">Edit</a>
				<a href=<?=site_url().'/adminrooms/delete/'.$room->room_no ?> style="text-decoration: none;">Delete</a>
			</td>
		</tr>
	<? endforeach; ?>
	</table>
<? endif; ?>