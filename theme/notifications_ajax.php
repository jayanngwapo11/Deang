<?php
// Notifications AJAX endpoint - returns unread count + recent list as JSON.
require_once(__DIR__ . "/../include/initialize.php");
global $mydb;

$act = isset($_POST['act']) ? $_POST['act'] : (isset($_GET['act']) ? $_GET['act'] : 'list');

header('Content-Type: application/json');

/* -----------------------------------------------------------------
   Mark one or all notifications as read.
   ----------------------------------------------------------------- */
if ($act === 'mark_read') {
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	if ($id > 0) {
		$mydb->InsertThis("UPDATE `tblnotifications` SET `IsRead` = 1 WHERE `NotificationID` = '".$id."'");
	}
	echo json_encode(array('ok' => true));
	exit;
}

if ($act === 'mark_all_read') {
	$mydb->InsertThis("UPDATE `tblnotifications` SET `IsRead` = 1 WHERE `IsRead` = 0");
	echo json_encode(array('ok' => true));
	exit;
}

/* -----------------------------------------------------------------
   Default: list the most recent notifications + unread count.
   ----------------------------------------------------------------- */
$mydb->setQuery("SELECT NotificationID, Title, Message, Type, LinkURL, IsRead, DateCreated
	FROM `tblnotifications`
	ORDER BY DateCreated DESC
	LIMIT 10");

$list = array();
foreach ($mydb->loadResultList() as $r) {
	$list[] = array(
		'id'      => $r->NotificationID,
		'title'   => $r->Title,
		'message' => $r->Message,
		'type'    => $r->Type,
		'link'    => $r->LinkURL,
		'isRead'  => (int)$r->IsRead,
		'created' => $r->DateCreated
	);
}

$mydb->setQuery("SELECT NotificationID FROM `tblnotifications` WHERE `IsRead` = 0");
$unreadCount = $mydb->num_rows();

echo json_encode(array(
	'unreadCount' => $unreadCount,
	'notifications' => $list
));
?>