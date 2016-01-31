<?
session_start();
require_once("../conn.inc.php");

if(isset($_POST['submit'])) {
	//prepare text for SQL
	$un = trim(mysql_escape_string($_POST['user']));
	$pw = trim(mysql_escape_string($_POST['pass']));
	$now = time();
	
	//check credentials
	$sql = "SELECT * FROM djlist WHERE dj_username = '$un' AND dj_password = '$pw'";
	$rs = mysql_query($sql) or die('Cannot check login info');
	
	if(mysql_num_rows($rs) > 0) {
		$row = mysql_fetch_array($rs);
		
		//if credentials are good, make sure DJ is not already signed in
		$sql2 = "SELECT * FROM currentdjlist WHERE current_dj_id = $row[dj_id] AND current_dj_logout_time = 0 ORDER BY current_dj_login_time DESC LIMIT 1";
		$rs2 = mysql_query($sql2) or die('Cannot check current login status');
		
		//not logged in, insert record and set cookie
		//logged in, reset cookie to most recent login
		//redirect to menu page
		if(mysql_num_rows($rs2) == 0) {
			$sql3 = "INSERT INTO currentdjlist (current_dj_id, current_dj_login_time) VALUES ($row[dj_id], $now)";
			$rs3 = mysql_query($sql3) or die('Cannot record current DJ status');
			$_SESSION['sid'] = mysql_insert_id();
		}
		else {
			$row2 = mysql_fetch_array($rs2);
			$_SESSION['sid'] = $row2['current_id'];
		}
		
		header('Location: menu.php');
	}
	else {
		//bad credentials message
		$message = "<p>Sorry, your login did not work. Try again.</p>\n";
	}
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
<title>DJ Login</title>
</head>
<body>
<h1>DJ Login</h1>
<? echo $message; ?>
<form id="form1" name="form1" method="post" action="">
  <table>
    <tr>
      <td>Username:</td>
      <td><input name="user" type="text" id="user" /></td>
    </tr>
    <tr>
      <td>Password:</td>
      <td><input name="pass" type="password" id="pass" /></td>
    </tr>
  </table>
	<br />
    <input name="submit" type="submit" id="submit" value="Submit" />
</form>
<p>&nbsp;</p>
</body>
</html>
