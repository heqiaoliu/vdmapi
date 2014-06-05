<?php
/************************************************
// FILE:            Model.php
// object type:     abstract class
// AUTHOR: Nick Turner , Heqiao Liu
// PURPOSE:         Model is an abstract class that define few necessary functions of database models.
//                  For each class extends Model, it inherits:
//			* void fucntion setDatabaseConnection(DBObject)
//			  param type:DBObject
//			  The function set database connection as the DBObject.
//
// NOTES:           Error reporting needed
// Last Motified by HQ Liu: Sep 25 2013
***************************************************/
abstract class Model {
	const ERRCODE_DBREQ=101,ERRCODE_NULLDATA=102,
	DATA='data',D_COUNT='count',
	ERRMSG_DBREQ="Unbable to use this function. Error Code:101.",
	ERRMSG_NULLDATA="No data for this Request. Error Code:102.";
    protected $db = NULL;

    public function __construct() {
	}


    public function setDatabaseConnection($databaseConnection) {
        $this->db = $databaseConnection;
    }
}

?>
