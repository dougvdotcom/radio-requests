<?
/*
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
*/

session_start();
if(!isset($_SESSION['login']) || $_SESSION['login'] == "") {
	header('Location: index.php');
}
require_once("../conn.inc.php");
$id = $_GET['id'];

$rs = mysql_query("DELETE FROM djlist WHERE dj_id = $id") or die('Cannot delete record');
header('Location: dj_list.php');
?>
