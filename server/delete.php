<?php


include_once 'databaseconf.php';

// Include facility object
include_once 'facility.php';

$facilityCode=htmlspecialchars(strip_tags($_POST['code']));

$database = new Database();
$db = $database->getConnection();
$facility = new Facility($db);
$facility -> voidFacility($facilityCode);

?>