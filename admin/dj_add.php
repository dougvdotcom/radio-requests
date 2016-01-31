<?
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login'] == "") {
	header('Location: index.php');
}
require_once("../conn.inc.php");
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
<title>Add A DJ</title>
</head>
<body>
<h1>Add A DJ</h1>
<?
if(isset($_POST['submit'])) {
	//prep text
	$pn = substr(trim(mysql_escape_string($_POST['name'])), 0, 50);
	$un = substr(trim(mysql_escape_string($_POST['user'])), 0, 20);
	$pw = substr(trim(mysql_escape_string($_POST['pass1'])), 0, 20);
	
	if($_POST['pass1'] != $_POST['pass2']) {
		echo "<p>Password fields do not match. Please correct this problem and try again.</p>\n";
	}
	elseif($pn == "" || $un == "" || $pw == "") {
		echo "<p>A field is blank or contains only junk. Please correct this problem and try again.</p>\n";
	}
	else {
		$sql = "INSERT INTO djlist (dj_username, dj_password, dj_public_name) VALUES ('$un', '$pw', '$pn')";
		$rs = mysql_query($sql) or die('Cannot insert record');
		echo "<p>DJ record added.</p>\n";
	}

}
?>
<form id="form1" name="form1" method="post" action="">
  <table>
    <tr>
      <td>Publicly Displayed Name </td>
      <td><input name="name" type="text" id="name" value="<? echo $_POST['name']; ?>" /></td>
    </tr>
    <tr>
      <td>Username</td>
      <td><input name="user" type="text" id="user" value="<? echo $_POST['user']; ?>" /></td>
    </tr>
    <tr>
      <td>Password</td>
      <td><input name="pass1" type="password" id="pass1" value="<? echo $_POST['pass1']; ?>" /></td>
    </tr>
    <tr>
      <td>Confirm Password</td>
      <td><input name="pass2" type="password" id="pass2" value="<? echo $_POST['pass2']; ?>" /></td>
    </tr>
  </table>
  <br />
  <input name="submit" type="submit" id="submit" value="Submit" />
</form>
<p><a href="dj_list.php">DJ List</a> | <a href="menu.php">Menu</a></p>
<p>&nbsp;</p>
</body>
</html>
