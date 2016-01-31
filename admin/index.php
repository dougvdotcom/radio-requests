<?
session_start();
require_once("../conn.inc.php");
$message = "";

if(isset($_SESSION['login']) && $_SESSION['login'] != "") {
	header('Location: menu.php');
}
else {
	if(isset($_POST['submit'])) {
		$un = trim(mysql_escape_string($_POST['user']));
		$pw = trim(mysql_escape_string($_POST['pass']));
		$sql = "SELECT * FROM adminlist WHERE admin_username = '$un' AND admin_password = '$pw'";
		$rs = mysql_query($sql) or die('Cannot get admin login query');
		if(mysql_num_rows($rs) > 0) {
			$_SESSION['login'] = $un;
			header('Location: menu.php');
		}
		else {
			$message = "<p>Login attempt failed. Please check your credentials and try again.</p>\n";
		}
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
<title>Admin Login</title>
</head>
<body>
<h1>Admin Login</h1>
<? echo $message; ?>
<form id="form1" name="form1" method="post" action="">
  <table>
    <tr>
      <td>User name: </td>
      <td><input name="user" type="text" id="user" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td>Password:</td>
      <td><input name="pass" type="password" id="pass" size="20" maxlength="20" /></td>
    </tr>
  </table>
  <br />
  <input name="submit" type="submit" id="submit" value="Submit" />
</form>
<p>&nbsp;</p>
</body>
</html>
