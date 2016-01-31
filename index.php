<?
require_once('conn.inc.php');
?>
<!--
Simple PHP / MySQL Radio Request System
Copyright 2006 Doug Vanderweide
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Request Page</title>
</head>
<body>
<h2>Requests</h2>
<?
$REQUEST_INTERVAL = 300; //seconds between requests
$show = true; //show form boolean; form shown when true
$now = time();

if(isset($_POST['submit'])) {
	//set variables
	$uip = $_SERVER['REMOTE_ADDR'];
	$uname = htmlspecialchars(substr(trim(mysql_escape_string($_POST['person'])), 0, 50));
	$sname = htmlspecialchars(substr(trim(mysql_escape_string($_POST['song'])), 0, 50));
	$message = htmlspecialchars(substr(trim(mysql_escape_string($_POST['msg'])), 0, 255));
	$dj = $_POST['djid'];
	$flood = $now - $REQUEST_INTERVAL;

	if($message == "") {
		$message = " ";
	}

	// we need good data to proceed
	if($uname == "" || $sname == "" || !eregi('^[0-9]{1,4}$', $dj)) {
		echo "<p>Sorry, there was a problem with your request. Please <a href=\"request.php\">try your request again.</a></p>\n";
	}
	else {
	//check for flooding
		$sql = "SELECT * FROM requestiplist WHERE user_ip_addy = '$uip' AND user_ip_time > $flood";
		$rs = mysql_query($sql) or die('Cannot check flooding');
		if(mysql_num_rows($rs) > 0) {
			echo "<p>Sorry, but you've recently requested a song. Please wait a while, then submit a new request.</p>\n";
			$show = false;
		}
		else {
			//add anti-flooding record
			$sql = "INSERT INTO requestiplist(user_ip_addy, user_ip_time) VALUES ('$uip', $now)";
			$rs = mysql_query($sql) or die('Cannot insert anti-flooding record');
			
			//add request
			$sql = "INSERT INTO songrequests (request_dj_id, request_time, request_person_name, request_song_name, request_note) VALUES ($dj, $now, '$uname', '$sname', '$message')";
			$rs = mysql_query($sql) or die('Could not enter song request.'.mysql_error().$sql);
			echo "<p>Thank you for your request! We have added it to our request list.</p>\n";
			$show = false;
		}
	}
}

//get signed-in dj list; if none signed in, don't show form
$sql = "SELECT a.dj_public_name, b.* FROM currentdjlist b LEFT JOIN djlist a ON a.dj_id = b.current_dj_id WHERE b.current_dj_login_time <= $now AND b.current_dj_logout_time = 0 AND b.current_id IS NOT NULL";
$rs = mysql_query($sql) or die('Cannot get DJ list.'.mysql_error());
if(mysql_num_rows($rs) == 0) {
	echo "<p>Sorry, no DJs are available to take requests at this time. Please try again later.</p>";
	$show = false;
}

//show form
if($show == true) {
?>
<p>To make your request, provide the information requested below.</p>
<form method="post">
  <table border="1" cellspacing="0" cellpadding="5">
    <tr>
      <td><div align="right"><strong>Your name: </strong></div></td>
      <td><input name="person" type="text" id="person" value="<? echo $_POST['name']; ?>" size="30" maxlength="50" /></td>
    </tr>
    <tr>
      <td><div align="right"><strong>To DJ: </strong></div></td>
      <td>
		  <select name="djid" id="djid">
<?
			//dynamically create DJ list options
			while($row = mysql_fetch_array($rs)) {
				echo "<option value=\"$row[current_dj_id]\"";
				if($_POST['djid'] == $row['current_dj_id']) { 
					echo " selected";
				}
				echo ">$row[dj_public_name]</option>\n";
			}
?>
		  </select>      
	  </td>
    </tr>
    <tr>
      <td><div align="right"><strong>Song requested: </strong></div></td>
      <td><input name="song" type="text" id="song" value="<? echo $_POST['song']; ?>"  /></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Message to DJ: </strong></div></td>
      <td><textarea name="msg" cols="40" rows="3" id="msg"><? echo $_POST['msg']; ?></textarea></td>
    </tr>
  </table>
	<br />
    <input name="submit" type="submit" id="submit" value="Place Request" />
</form>
<?
}
?>
</body>
</html>
