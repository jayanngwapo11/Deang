<?php
/* Reusable helper: call this anywhere after adding/changing a record
   to push a new notification. $mydb must already be available. */
function addNotification($title, $message, $type = 'general', $linkUrl = '') {
	global $mydb;

	$sql = "INSERT INTO `tblnotifications` (`Title`, `Message`, `Type`, `LinkURL`)
		VALUES (
			'".$mydb->escape_value($title)."',
			'".$mydb->escape_value($message)."',
			'".$mydb->escape_value($type)."',
			".($linkUrl != '' ? "'".$mydb->escape_value($linkUrl)."'" : "NULL")."
		)";
	$mydb->InsertThis($sql);
}
?>