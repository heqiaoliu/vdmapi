<?php
/**
 * Class: VDMQueryChecker
 * Description: VDMQuery
 */
class VDMQueryChecker{
	public static $TYPE="type",$PARAM="param",$ERR=array(
		"M_QUERY"=>array(300,"Request query is not found."),
		"M_TYPE"=>array(310,"Request type is not found."),
		"M_PARAM"=>array(320,"Request parameter is not found."),
		"I_QUERY"=>array(301,"Request query contains invalid token."),
		"I_TYPE"=>array(311,"Request type is invalid."),
		"I_PARAM"=>array(321,"Request parameter is in the wrong format.")
	), $TOKENS=array("type","param","mid");
	public static function checkToken($query){
		if(sizeof($query)==0){
			throw new Exception(self::$ERR["M_QUERY"][1],self::$ERR["M_QUERY"][0]);
			return;
		}
		foreach ($query as $k=>$v){
			if(in_array($k,self::$TOKENS))
				continue;
			throw new Exception(self::$ERR["I_QUERY"][1],self::$ERR["I_QUERY"][0]);
			break;
		}
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

