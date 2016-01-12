<? 
	$step = $this->session->userdata('step');
	$arrivalValue = '';
	$departureValue = '';
	$rooms = 0;
	$nights = 0;
	$selectedRoom = '';
	$rate = 0;
	$totalCharge = 0;
	$firstName = '';
	$lastName = '';
	$email = '';
	$cardName = '';
	$cardType = 'select';
	$cardNum = '';
	$expDateMonth = '';
	$expDateYear = '';
	$secCode = '';
	
	// Set Arrival Date
	if ($this->session->userdata('arrivalDate') != null)
	{
		$arrivalValue = $this->session->userdata('arrivalDate');
	}
	
	// Set Departure Date
	if ($this->session->userdata('departureDate') != null)
	{
		$departureValue = $this->session->userdata('departureDate');
	}
	
	// Determine # nights of stay
	if ($arrivalValue != '' && $departureValue != '')
	{
		$arrivalFormat = strtotime($arrivalValue);
		$departureFormat = strtotime($departureValue);
		$nights = floor(($departureFormat - $arrivalFormat)/(60*60*24));
	}
	
	// Set room selection
	if ($this->session->userdata('roomSelection') != null)
	{
		$selectedRoom = $this->session->userdata('roomSelection');
		$rooms = 1;
	}
	
	// Set room rate	
	if ($this->session->userdata('roomRate') != null)
	{
		$rate = $this->session->userdata('roomRate');
		$totalCharge = $rate * $nights;
	}
	
	// Set first name
	if ($this->session->userdata('fName') != null)
	{
		$firstName = $this->session->userdata('fName');
	}
	
	// Set last name
	if ($this->session->userdata('lName') != null)
	{
		$lastName = $this->session->userdata('lName');
	}
	
	// Set email
	if ($this->session->userdata('email') != null)
	{
		$email = $this->session->userdata('email');
	}
	
	// Set card name
	if ($this->session->userdata('cardName') != null)
	{
		$cardName = $this->session->userdata('cardName');
	}
	
	// Set card number
	if ($this->session->userdata('cardNum') != null)
	{
		$cardNum = $this->session->userdata('cardNum');
	}
	
	// Set card type
	if ($this->session->userdata('cardType') != null)
	{
		$cardType = $this->session->userdata('cardType');
	}
	
	// Set expiry month
	if ($this->session->userdata('expMonth') != null)
	{
		$expDateMonth = $this->session->userdata('expMonth');
	}
	
	// Set expiry Year
	if ($this->session->userdata('expYear') != null)
	{
		$expDateYear = $this->session->userdata('expYear');
	}
	
	// Set security code
	if ($this->session->userdata('secCode') != null)
	{
		$secCode = $this->session->userdata('secCode');
	}
?>

<div id='navbar'>
	<ul>
		<?
			if ($step == 'selectDate') {
				echo "<li id='selected'>Select Date</li>";
				echo "<li>Rooms and Rates</li>";
				echo "<li>Payment and Guest Info</li>";
				echo "<li>Confirmation</li>";
			} elseif ($step == 'selectRooms') {
				echo "<li><a href='".site_url()."/reservations/selectDate/navigate'>Select Date</a></li>";
				echo "<li id='selected'>Rooms and Rates</li>";
				echo "<li>Payment and Guest Info</li>";
				echo "<li>Confirmation</li>";
			} elseif ($step == 'selectPayment') {
				echo "<li><a href='".site_url()."/reservations/selectDate/navigate'>Select Date</a></li>";
				echo "<li><a href='".site_url()."/reservations/selectRooms/navigate'>Rooms and Rates</a></li>";
				echo "<li id='selected'>Payment and Guest Info</li>";
				echo "<li>Confirmation</li>";
			} elseif ($step == 'selectConfirmation') {
				echo "<li><a href='".site_url()."/reservations/selectDate/navigate'>Select Date</a></li>";
				echo "<li><a href='".site_url()."/reservations/selectRooms/navigate'>Rooms and Rates</a></li>";
				echo "<li><a href='".site_url()."/reservations/selectPayment/navigate'>Payment and Guest Info</a></li>";
				echo "<li id='selected'>Confirmation</li>";
			}
		?>
	</ul>
</div>

<? if ($step == 'selectDate'): ?>
	<div id='left-side' style='margin-left: 20%;'>
		<h3>Availability Calendar</h3>
		<?=$calendar; ?>
	</div>
	<div id='right-side' style='margin-right: 20%;'>
		<h3>Reservation Dates</h3>
		<?= form_open((site_url().'/reservations/selectDate/continue'));
			$arrivalData = array(
				'name' => 'arrivalDate',
				'id' => 'arrivalDate',
				'value' => $arrivalValue
			);
			$departureData = array(
				'name' => 'departureDate',
				'id' => 'departureDate',
				'value' => $departureValue
			);
		?>
		<table id="date-form">
			<tr>
				<th style="text-align: right;"><?= form_label('Arrival ', 'arrivalDate'); ?></th>
				<td><?= form_input($arrivalData); ?></td>
			</tr>
			<tr>
				<th style="text-align: right;"><?= form_label('Departure ', 'departureDate'); ?></th>
				<td><?= form_input($departureData); ?></td>
			</tr>				
		</table>
		
	</div>
<? elseif ($step == 'selectRooms'): ?>
	<?= form_open((site_url().'/reservations/selectRooms/continue')); ?>
	<div id='presentChoices'>
		<h3>Your present choices are:</h3>
		<p><span style='font-weight: bold;'>Arrival Date:</span> <?=$arrivalValue ?></p>
		<p><span style='font-weight: bold;'>Departure Date:</span> <?=$departureValue ?></p>
		<p><span style='font-weight: bold;'>Rooms:</span> <?=$rooms ?></p>
		<p><span style='font-weight: bold;'>Nights:</span> <?=$nights ?></p>
		<p><span style='font-weight: bold;'>Selected Room:</span> <?=$selectedRoom ?></p>
		<p><span style='font-weight: bold;'>Total Charge:</span> $<?=$totalCharge ?></p>
	</div>
	<div id="availableRooms">
		<h4>Available Rooms</h4>
		<div id='availBody'>
			<table>
				<tr>
					<th>Room</th>
					<th>Rate</th>
					<td></td>
					<td></td>
				</tr>
				<?
					foreach($available as $room){
						echo "<tr>";
						echo "<td>Room " . $room->room_no . " " . $room->room_description . "</td>";
						echo "<td>$" . $room->room_rate . "</td>";
						echo "<td><a href='".site_url()."/reservations/selectRooms/info/".$room->room_no."'>Info</a></td>";
						echo "<td><a href='".site_url()."/reservations/selectRooms/select/".$room->room_no."'>Select</td>";
						echo "</tr>";
					}
				?>
			</table>
		</div>
	</div>
	<div id="unavailableRooms">
		<h4>Rooms Not Available</h4>
		<div id='availBody'>
			<table>
				<tr>
					<th>Room</th>
					<th>Rate</th>
					<td></td>
				</tr>
				<?
					foreach($booked as $room){
						echo "<tr>";
						echo "<td>Room " . $room->room . " " . $room->room_description . "</td>";
						echo "<td>$" . $room->room_rate . "</td>";
						echo "<td><a href='".site_url()."/reservations/selectRooms/info/".$room->room."'>Info</a></td>";
						echo "</tr>";
					}
				?>				
			</table>
		</div>
	</div>
	<div id='roomInfo'>
		<h4>Room Information</h4>
		<div id='availBody'>
			<?
				if(isset($roomInfo)){
					foreach($roomInfo as $room){
						echo "<p style='margin: 0;'><b>Room #:</b> ".$room->room_no."</p>";
						echo "<p style='margin: 0;'><b>Description:</b> ".$room->room_description."</p>";
						echo "<p style='clear: both; margin: 0;'><b>Rate:</b> $".$room->room_rate."</p>";
						echo $room->long_description."<p style='clear: both;'></p>";
					}
				}
			?>
		</div>
	</div>
<? elseif ($step == 'selectPayment'): ?>
	<?= form_open((site_url().'/reservations/selectPayment/continue'));
		$fNameData = array(
			'name' => 'fName',
			'id' => 'fName',
			'value' => $firstName
		);
		$lNameData = array(
			'name' => 'lName',
			'id' => 'lName',
			'value' => $lastName
		);
		$emailData = array(
			'name' => 'email',
			'id' => 'email',
			'value' => $email
		);
		$cardNameData = array(
			'name' => 'cardName',
			'id' => 'cardName',
			'value' => $cardName
		);
		$cardTypeData = array(
			'select' => 'Select',
			'amex' => 'American Express',
			'euroCard' => 'EuroCard',
			'jcb' => 'JCB International',
			'mc' => 'MasterCard',
			'visa' => 'VISA'
		);
		$cardNumData = array(
			'name' => 'cardNum',
			'id' => 'cardNum',
			'value' => $cardNum,
			'maxlength' => 16
		);
		$expDateMonthData = array(
			"" => "",
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
			'6' => '6',
			'7' => '7',
			'8' => '8',
			'9' => '9',
			'10' => '10',
			'11' => '11',
			'12' => '12'
		);
		$expDateYearData = array(
			"" => "",
			date("Y") => date("Y"),
			date('Y', strtotime('+ 1 year')) => date('Y', strtotime('+ 1 year')),
			date('Y', strtotime('+ 2 years')) => date('Y', strtotime('+ 2 years')),
			date('Y', strtotime('+ 3 years')) => date('Y', strtotime('+ 3 years')),
			date('Y', strtotime('+ 4 years')) => date('Y', strtotime('+ 4 years')),
			date('Y', strtotime('+ 5 years')) => date('Y', strtotime('+ 5 years')),
			date('Y', strtotime('+ 6 years')) => date('Y', strtotime('+ 6 years'))
		);
		$secCodeData = array(
			'name' => 'secCode',
			'id' => 'secCode',
			'value' => $secCode,
			'maxlength' => '4',
			'size' => '3'
		);
	?>
	<div id='left-side' style='margin-left: 20%;'>
		<h3>Personal Information</h3>
		<table>
			<tr>
				<td><?= form_label('First name: ', 'fName'); ?></td>
				<td><?= form_input($fNameData); ?>*</td>	
			</tr>
			<tr>
				<td><?= form_label('Last name: ', 'lName'); ?></td>
				<td><?= form_input($lNameData); ?>*</td>	
			</tr>
			<tr>
				<td><?= form_label('E-mail address: ', 'email'); ?></td>
				<td><?= form_input($emailData); ?>*</td>	
			</tr>
		</table>
	</div>
	<div id='right-side' style='margin-right: 10%;'>
		<h3>Payment Type</h3>
		<table>
			<tr>
				<td><?= form_label('Cardholder name: ', 'cardName'); ?></td>
				<td><?= form_input($cardNameData); ?>*</td>	
			</tr>
			<tr>
				<td><?= form_label('Card Type: ', 'cardType'); ?></td>
				<td><?= form_dropdown('cardType', $cardTypeData, $cardType); ?>*</td>	
			</tr>
			<tr>
				<td><?= form_label('Card Number: ', 'cardNum'); ?></td>
				<td><?= form_input($cardNumData); ?>*</td>	
			</tr>
			<tr>
				<td><?= form_label('Expiration Date: ', 'expDate'); ?></td>
				<td><?= form_dropdown('expDateMonth', $expDateMonthData, $expDateMonth); ?><?= form_dropdown('expDateYear', $expDateYearData, $expDateYear); ?>*</td>
			</tr>
			<tr>
				<td><?= form_label('Security Code: ', 'secCode'); ?></td>
				<td><?= form_input($secCodeData); ?>*</td>	
			</tr>
		</table>		
	</div>
<? elseif ($step == 'selectConfirmation'): ?>
	<?= form_open((site_url().'/reservations/selectConfirmation/continue'));
		$this->session->set_userdata(array(
			'nights' => $nights,
			'totalCharge' => $totalCharge
		));
	?>
	<div id='confirmation'>
		<h3>
			Please confirm that the following information you entered is correct before clicking 
			"Continue" to process your order. If in error, return to one of the previous steps to 
			edit your reservation order. Thank you!
		</h3>
		<div id='confirmationBody'>
			<p><b>Arrival Date: </b><?=$arrivalValue;?><b> Departure Date: </b><?=$departureValue;?></p>
			<p><b>Rooms: </b><?=$rooms;?> <b>Nights: </b><?=$nights;?></p>
			<p><b>Selected Room: </b><?=$selectedRoom;?></p>
			<p><b>Total Charge: $</b><?=$totalCharge;?></p>
			<p><b>Name: </b><?=$firstName;?> <?=$lastName;?></p>
			<p><b>Email: </b><?=$email;?></p>
			<p><b>Cardholder Name: </b><?=$cardName;?></p>
			<p><b>Cardholder Type: </b><?=$cardType;?></p>
			<p><b>Card Number: </b><?=$cardNum;?></p>
			<p><b>Expiry: </b><?=date('M', strtotime($expDateMonth));?> <?=$expDateYear;?></p>
			<p><b>Security Code: </b><?=$secCode;?></p>
		</div>
	</div>
<? elseif ($step == 'confirmed'): ?>
	<?= form_open((site_url().'/reservations')); ?>
	<? if (isset($confirmationMessage) && $confirmationMessage != ''): ?>
		<br style="clear: both;" />
		<br />
		<div id='confirmation-message'>
			<?= $confirmationMessage; ?>
		</div>
		<br />
	<? endif; ?>
<? endif; ?>

<? if (isset($errorMsg) && $errorMsg != ''): ?>
	<br style="clear: both;" />
	<br />
	<div id='error-messages'>
		<?= $errorMsg; ?>
	</div>
	<br />
<? endif; ?>
<p style="text-align: right; clear: both;"><?= form_submit('submit', 'Continue', 'id=submit'); ?></p>
<?= form_close(); ?>	