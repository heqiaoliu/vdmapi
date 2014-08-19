<?php
ini_set('display_errors', 'On');
include_once("VDMQueryChecker.php");
include_once 'vdmdbo/Model.php';
include_once '../security/DBObject.php';
include_once("vdmdbo/PMBacteria.php");
include_once("vdmdbo/PMExperiment.php");
include_once("vdmdbo/PMPlate.php");
include_once("vdmdbo/PMGrowth.php");
class Pmapi{
	protected static $PMAPI_TYPES=array("getbacterialist","getbacteria","getbacteriaofexp","getexperimentlist","getexperiment","getplatelist","getplate","getgrowth","getexperimentbyfile");
	private static $ERR_JSON='{"success":false,"error_message":"%MSG%","error_code":%CODE%}';
	public static function process(){
		$query=$_SERVER["REQUEST_METHOD"]==="GET"?$_GET:$_POST;
		$tokens=self::checkQuery($query);
		$params=VDMQueryChecker::checkParam($tokens['param']);
		self::branching($tokens['type'],$params,null);	
	}

	private static function branching($type,$param,$mid){
		$type=strtolower($type);
		$temp;
		try{
			switch($type){
				case self::$PMAPI_TYPES[0]:
					$temp= self::getBacteriaList();
					break;
				case self::$PMAPI_TYPES[1]:
					$temp=self::getBacteria($param);
					break;
				case self::$PMAPI_TYPES[2]:
					$temp=self::getBacteriaOfExp($param);
					break;
				case self::$PMAPI_TYPES[3]:
					$temp=self::getExperimentList();
					break;
				case self::$PMAPI_TYPES[4]:
					$temp=self::getExperiment($param);
					break;
				case self::$PMAPI_TYPES[5]:
					$temp=self::getPlateList();
					break;
				case self::$PMAPI_TYPES[6]:
					$temp=self::getPlate($param);
					break;
				case self::$PMAPI_TYPES[7]:
					$temp=self::getGrowth($param);
					break;
				case self::$PMAPI_TYPES[8]:
					$temp=self::getExperimentByFile($param);
					break;
				default:
					$temp=array();
					$temp["success"]=False;
					$temp["error_message"]=VDMQueryChecker::$ERR["I_TYPE"][1];
					$temp["error_code"]=VDMQueryChecker::$ERR["I_TYPE"][0];
				
			}
		}catch(Exception $e){
			echo self::getError($e);
			exit();
		}
		if(!array_key_exists("success",$temp))
			$temp['success']=True;
		$temp['mid']=$mid;
		echo json_encode($temp);
	}

	private static function getBacteriaList(){
		$bact=new PMBacteria();
		$db=VDMDB::get();
		$bact->setDatabaseConnection($db);
		return $bact->getBacteriaList();
	}

	private static function getBacteria($param){
		$bact=new PMBacteria();
		$db=VDMDB::get();
		$bact->setDatabaseConnection($db);
		$temp=array();
		$temp["data"]=array();
		foreach($param as $p)
			$temp["data"][$p]=$bact->getBacteriaByBeid($p);
		return $temp;
	}

	private static function getBacteriaOfExp($param){
		$bact=new PMBacteria();
		$db=VDMDB::get();
		$bact->setDatabaseConnection($db);
		$temp["data"]=array();
		foreach($param as $p)
			$temp["data"][$p]=$bact->getBacteriaOfExp($p);
		return $temp;
	}

	private static function getExperimentList(){
		$exp=new PMExperiment();
		$db=VDMDB::get();
		$exp->setDatabaseConnection($db);
		return $exp->getExperimentList();
	}

	private static function getExperiment($param){
		$exp=new PMExperiment();
		$db=VDMDB::get();
		$exp->setDatabaseConnection($db);
		$temp=array();
		$temp["data"]=array();
		foreach($param as $p)
			$temp["data"][$p]=$exp->getByBacteria($p);
		return $temp;
		
	}

	private static function getPlateList(){
		$plate=new PMPlate();
		$db=VDMDB::get();
		$plate->setDatabaseConnection($db);
		return $plate->getPlateList();
	}

	private static function getPlate($param){
		$plate=new PMPlate();
		$db=VDMDB::get();
		$plate->setDatabaseConnection($db);
		$temp=array();
		$temp["data"]=array();
		foreach($param as $p)
			$temp["data"][$p]=$plate->getByPlateid($p);
		return $temp;
	}

	private static function getGrowth($param){
		$growth=new PMGrowth();
		$db=VDMDB::get();
		$growth->setDatabaseConnection($db);
		$temp=array();
		$temp["data"]=array();
		foreach($param as $p)
			$temp["data"][$p[0]][$p[1]]=$growth->getByExpWell($p[0],$p[1]);
		return $temp;
	}

	private static function getExperimentByFile($param){
		$exp=new PMExperiment();
		$db=VDMDB::get();
		$exp->setDatabaseConnection($db);
		$temp=array();
		$temp["data"]=array();
		foreach($param as $p)
			$temp["data"][$p]=$exp->getByFilename($p);
		return $temp;
	}

	private static function checkQuery($query){
		try{
			return VDMQueryChecker::checkToken($query);
		}catch(Exception $e){
			echo self::getError($e);
			exit();	
		}
	}


	private static function getError($e){
		return str_replace("%CODE%",$e->getCode(),str_replace("%MSG%",$e->getMessage(),self::$ERR_JSON));
	}	
}

try{
Pmapi::process();
}catch(Exception $e){
var_dump($e);
}

?>
