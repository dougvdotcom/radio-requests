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
<title>DJ List</title>
</head>
<body>
<h1>DJ List</h1>
<?
	$sql = "SELECT * FROM djlist ORDER BY dj_id DESC";
	$rs = mysql_query($sql) or die('Cannot get DJ records');
	if(mysql_num_rows($rs) == 0) {
		echo "<p>There are no DJs.</p>\n";
	}
	else {
		echo "<table>\n";
		echo "\t<tr>\n";
		echo "\t\t<th>Edit</th><th>Public Name</th><th>Delete</th>\n";
		echo "\t</tr>\n";
		while($row = mysql_fetch_array($rs)) {
			echo "\t<tr>\n";
			echo "\t\t<td><a href=\"dj_edit.php?id=$row[dj_id]\">Edit</a></td><td>$row[dj_public_name]</td><td><a href=\"dj_delete.php?id=$row[dj_id]\">Delete</a></td>\n";
			echo "\t</tr>\n";
		}
		echo "</table>\n";
	}
?>
<p><a href="dj_add.php">Add DJ</a> | <a href="menu.php">Menu</a> </p>
<p>&nbsp;</p>
</body>
</html>
