<?
session_start();
require_once("../conn.inc.php");
if(!isset($_SESSION['sid']) || $_SESSION['sid'] == "") {
	header('Location: index.php');
}
else {
	$sid = $_SESSION['sid'];
	$now = time();
	$sql = "UPDATE currentdjlist SET current_dj_logout_time = $now WHERE current_id = $sid";
	$rs = mysql_query($sql) or die('Cannot log out');
	session_destroy();
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
<title>Log Out</title>
</head>
<body>
<h1>Log Out</h1>
<p>You are now logged out of the system. <a href="index.php">Log in.</a></p>
</body>
</html>
