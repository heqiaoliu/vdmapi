<?php
/*
* @constant TYPE='type'
* @constant PARAM='param'
*/

define('TYPE','type');
define('PARAM','param');
define('ERRMSG_TYPE','Invalid or missing Type of the request');
define('ERRMSG_PARAM','Invalid or missing Parameters of the request');
define('ERRMSG_PARAMFORMAT','Wrong Parameter format');
define('ERRCODE_TYPE',3);
define('ERRCODE_PARAM',4);
define('ERRCODE_PARAMFORMAT',5);
function parseQuery($query){
	$pmPARAM;
	parse_str($query,$pmParam);
	if(!array_key_exists(TYPE,$pmParam)){
		throw new Exception(ERRMSG_TYPE,ERRCODE_TYPE);
		return;
	}
	if(!array_key_exists(PARAM,$pmParam)){
		throw new Exception(ERRMSG_PARAM,ERRCODE_PARAM);
		return;
	}
	return $pmParam;
}

function checkParam($paramStr){
	$msg;
	$code;
	$paramArr=json_decode($paramStr);
	switch(json_last_error()){
		case JSON_ERROR_NONE:
			break;
		default:
			throw new Exception(ERRMSG_PARAMFORMAT,ERRCODE_PARAMFORMAT);
	}
	return $paramArr;	
}
?>
