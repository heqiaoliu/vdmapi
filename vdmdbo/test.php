<?php
ini_set('display_errors', 'On');
include_once("/var/www/html/data/security/DBObject.php");
include_once("PMPlate.php");

$db=VDMDB::get();
$p=new PMPlate();
$p->setDatabaseConnection($db);
$p->getPlateList();

?>
