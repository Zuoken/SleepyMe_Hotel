<? $this->load->helper('sleepyme_helper'); ?>
<!DOCTYPE html>
<html>
<head>
	<title><?=$title; ?></title>
	<link href = "<?=assetUrl(); ?>css/sleepyme.css" rel="stylesheet" type="text/css">		
	<?
		if ($title == 'Home'){
			echo '<style>#homeLink p {background: linear-gradient(yellow, green);}</style>';
		} elseif ($title == 'Rooms and Rates'){
			echo '<style>#roomsLink p {background: linear-gradient(yellow, green);}</style>';
		} elseif ($title == 'Reservations'){
			echo '<style>#reservationsLink p {background: linear-gradient(yellow, green);}';
			echo '#left-side {display: inline-block; vertical-align: top;}';
			echo '#right-side {display: inline-block; vertical-align: top;}';
			echo "#error-messages {clear: both; color: red; text-align: center; border: 1px solid red; width: 500px; background-color: white; margin: auto;}";
			echo '#navbar ul {list-style: none; text-align: center;} #navbar ul li {display: inline; margin: 0 5px 0 5px; padding: 0 5px 0 5px; border: 1px solid black;}';
			echo '#navbar a {text-decoration: none;} #navbar a:hover {background-color: darkgreen; color: white;}';
			echo '#selected {background-color: darkblue; color: white; padding-left: 5px; padding-right: 5px;} #previous {}';
			echo '#submit{background-color: darkorange; color: white; font-weight: bold;}';
			echo '#presentChoices {background-color: white; padding: 10px;} #presentChoices p {margin: 0; padding: 0;} #presentChoices h3 {color: green; margin: 0; padding: 0;}';
			echo '#availableRooms #availBody {padding: 10px; background-color: white;} #availableRooms h4 {background-color: green; margin: 10px 0 0 0; padding: 5px; font-weight: bold; color: white;}';
			echo '#unavailableRooms #availBody {padding: 10px; background-color: white;} #unavailableRooms h4 {background-color: red; margin: 10px 0 0 0; padding: 5px; font-weight: bold; color: white;}';
			echo 'table {border: 1px solid black; border-collapse: collapse; width: 100%;} table tr {border: 1px solid black;} table td {border: 1px solid black;} table th {border: 1px solid black;}';
			echo '#roomInfo h4 {background-color: black; margin: 10px 0 0 0; padding: 5px; font-weight: bold; color: white;} #roomInfo #availBody {padding: 10px; background-color: white;}';
			echo '#confirmation h3 {color: green;} #confirmation #confirmationBody {background-color: white; padding: 10px;} #confirmation #confirmationBody p {margin: 0;}';
			echo "#confirmation-message {clear: both; color: green; text-align: center; border: 1px solid green; width: 500px; background-color: white; margin: auto;}";
			echo '</style>';
			echo '<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">';
  			echo '<script src="//code.jquery.com/jquery-1.10.2.js"></script>';
  			echo '<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>';
			echo '<script>$(function() {$("#arrivalDate").datepicker({minDate: 0, maxDate: "+1Y"});});</script>';
			echo '<script>$(function() {$("#departureDate").datepicker({minDate: +1, maxDate: "+1Y"});});</script>';
		} elseif ($title == 'Contact'){
			echo '<style>#contactLink p {background: linear-gradient(yellow, green);} h3 {color: green;}';
			echo 'th {text-align: right;} input {width: 200px;} textarea {width: 300px;}</style>';
			echo $map['js'];
		} elseif ($title == "Admin Rooms") {
			echo "\t" . '<script src="' . assetUrl() . 'js/ckeditor_4.5.4_standard/ckeditor/ckeditor.js"></script>' . "\r\n";
		} elseif ($title == "Admin Reservations") {
			echo "<style>#no_rooms{color: red;} #no_rooms a {text-decoration: none; color: red;}";
			echo "#calendar{float: left;} #room_panel{float: right;}";
			echo "</style>";
		}
	?>
</head>
<body>
	<header>
		<a href='index.php?/home' id='sleepyMeLogo'><img src="<?=assetUrl(); ?>img/sleepyme.png"></a>
		<ul>	
			<li id='homeLink'><a href=<?=site_url().'/home'; ?>><p>Home</p></a></li>
			<li id='roomsLink'><a href=<?=site_url().'/rooms'; ?>><p>Our Rooms and Rates</p></a></li>
			<li id='reservationsLink'><a href=<?=site_url().'/reservations'; ?>><p>Reservations</p></a></li>
			<li id='contactLink'><a href=<?=site_url().'/contact'; ?>><p>Contact</p></a></li>
		</ul>
	</header>
	<div id='bodyContent'>