<div id="left-side">
	<div id="contact">
		<h3>Contact us by e-mail and send us your comments!</h3>
		<h5>All fields must be filled in</h5>
		<?php 
			$name = array (
				'name' => 'name',
				'id' => 'name',
				'maxlength' => '50'	
			);
			$address = array (
				'name' => 'address',
				'id' => 'address',
				'maxlength' => '50'
			);
			$postal = array (
				'name' => 'postal',
				'id' =>'postal',
				'maxlength' => '6'	
			);
			$phone = array (
				'name' => 'phone',
				'id' => 'phone',
				'maxlength' => '10'
			);
			$email = array (
				'name' => 'email',
				'id' => 'email',
				'maxlength' => '50'
			);
			$comment = array (
				'name' => 'comment',
				'id' => 'comment',
				'rows' => '10',
				'cols' => '10'
			);
			echo form_open((site_url().'/contact/post'));
		?>
		
		<table id="contact-form">
				<tr>
					<th><?= form_label('Name: ', 'name'); ?></th>
					<td><?= form_input($name); ?></td>
				</tr>
				<tr>
					<th><?= form_label('Address: ', 'address'); ?></th>
					<td><?= form_input($address); ?></td>
				</tr>
				<tr>
					<th><?= form_label('Postal Code: ', 'postal'); ?></th>
					<td><?= form_input($postal); ?></td>
				</tr>
				<tr>
					<th><?= form_label('Phone: ', 'phone'); ?></th>
					<td><?= form_input($phone); ?></td>
				</tr>
				<tr>
					<th><?= form_label('E-mail: ', 'email'); ?></th>
					<td><?= form_input($email); ?></td>
				</tr>
				<tr>
					<th><?= form_label('Comment: ', 'comment'); ?></th>
					<td><?= form_textarea($comment); ?></td>
				</tr>
				<tr>
					<td></td>
					<td><?= form_submit('submit', 'Submit'); ?></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<?= $validation; ?>
						<?= validation_errors(); ?>
					</td>
				</tr>
			</table>
			<?= form_close(); ?>
	</div>
</div>
<div id="right-side">
	<div id="contact-info">
		<h3>Contact Information</h3>
		<ul style='list-style-type: none;'>
			<li><b>Sleepyme Hotel</b></li>
			<li>21 Redwood Rd.</li>
			<li>Tel: (519) 754-7243</li>
			<li>Fax: (519) 123-4576</li>
			<li>Email: reservation@sleepymehotel.com</li>
		</ul>
	</div>
	<div id="map">
		<h3>Map to SleepyMe Hotel</h3>
		<? 	echo $map['html']; ?>
	</div>
</div>
