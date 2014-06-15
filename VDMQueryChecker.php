<?php
/**
 * Class: VDMQueryChecker
 * Description: VDMQuery
 */
class VDMQueryChecker{
	public static $TYPE="type",$PARAM="param",$ERR=[
		"M_QUERY"=>[300,"Request query is not found."],
		"M_TYPE"=>[310,"Request type is not found."],
		"M_PARAM"=>[320,"Request parameter is not found."],
		"I_TYPE"=>[311,"Request type is invalid."],
		"I_PARAM"=>[321,"Request parameter is in the wrong format."]
	];
	public static function checkToken($query){
		if(!array_key_exists(self::$TYPE,$query)){
			throw new Exception(self::$ERR["M_TYPE"][1],self::$ERR["M_TYPE"][0]);
			return;
		}
		if(!array_key_exists(self::$PARAM,$query)){
			throw new Exception(self::$ERR["M_PARAM"][1],self::$ERR["M_PARAM"][0]);
			return;
		}
		return $query;
	}

	public static function checkParam($pStr){
		$arr=json_decode($pStr);
		switch(json_last_error()){
			case JSON_ERROR_NONE:
				break;
			default:
				throw new Exception(self::$ERR["I_PARAM"][1],self::$ERR["I_PARAM"][0]);
		}
		return $arr;
	}
}



?>
