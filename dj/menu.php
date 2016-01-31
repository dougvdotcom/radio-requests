<?
session_start();
require_once("../conn.inc.php");
if(!isset($_SESSION['sid']) || $_SESSION['sid'] == "") {
	header('Location: index.php');
}
else {
	$id = $_SESSION['sid'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Current Requests</title>
</head>
<body>
<h1>Current Requests</h1>
<?
$sql = "SELECT a.*, b.* FROM songrequests a LEFT JOIN currentdjlist b ON a.request_dj_id = b.current_dj_id WHERE b.current_id = $id AND b.current_dj_login_time < a.request_time AND b.current_dj_logout_time = 0 ORDER BY a.request_time DESC";
$rs = mysql_query($sql) or die('Cannot get request records'.mysql_error());

if(mysql_num_rows($rs) == 0) {
	echo "<p>You have no requests.</p>\n";
}
else {
	echo "<p>Your requests for this login session are listed below, from most recent to least recent.</p>\n";
	echo "<table>\n";
	echo "\t<tr>\n";
	echo "\t\t<th>Requester Name</th><th>Song Requested</th><th>Request Time</th><th>Note</th>\n";
	echo "\t</tr>\n";
	while($row = mysql_fetch_array($rs)) {
		echo "\t<tr>\n";
		echo "\t\t<td>$row[request_person_name]</td><td>$row[request_song_name]</td><td>".date('m/d/y h:i a', $row['request_time'])."<td>$row[request_note]</td>\n";
		echo "\t</tr>\n";
	}
	echo "</table>\n";
}
?>
<br />
<p><a href="menu.php">Refresh list</a>. 
<p>&nbsp;</p>
<p><a href="logout.php">Log out</a> of the system. [<strong>Warning: </strong>Logging out will remove all your current requests; you will not be able to see your requests for this session.] </p>
<p>&nbsp;</p>
</body>
</html>
