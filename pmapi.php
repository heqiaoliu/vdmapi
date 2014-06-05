<?php
include 'PMQueryParser.php';
include 'vdmdbo/DBObject.php';
include 'vdmdbo/Model.php';
include 'vdmdbo/PMBacteria.php';
include 'vdmdbo/PMExperiment.php';
include 'vdmdbo/PMPlate.php';
include 'vdmdbo/PMGrowth.php';

define('SUC','success');
define('ERRM','error_message');
define('ERRC','error_code');
define('MID','mid');
define('DATA','data');
try{
	//$queries=parseQuery($_SERVER['QUERY_STRING']);
	$queries=$_SERVER['REQUEST_METHOD']==='GET'?$_GET:$_POST;
	$type=$queries['type'];
	$mid=$queries['mid'];
	$params=checkParam($queries['param']);
}catch(Exception $e){
	jsonException($e);
	exit();
}

include_once "vdmdbo.php";

switch($type){
	case 'getBacteriaList':
		getBacteriaList($vdmdbo->getDB(),$mid,$params);
		exit();
		echo 'hello';
	case 'getBacterias':
		getBacterias($vdmdbo->getDB(),$mid,$params);
		exit();
	case 'getExperiments':
		getExperiments($vdmdbo->getDB(),$mid,$params);
		exit();
		echo 'hello';
	case 'getPlates':
		getPlates($vdmdbo->getDB(),$mid,$params);
		exit();
	case 'getGrowth':
		getGrowth($vdmdbo->getDB(),$mid,$params);
		exit();
	default:
		echo '{"success":false,"error_message":"'.ERRMSG_TYPE.$type.'","error_code":'.ERRCODE_TYPE.'}';
		exit();
}
function getBacteriaList($db,$mid){
	$pmObj=new PMBacteria();
	try{
		$pmObj->setDatabaseConnection($db);
		$temp=$pmObj->getBacteriaList();
		$temp[SUC]=true;
		$temp[ERRM]=null;
		$temp[ERRC]=null;
		$temp[MID]=intval($mid);
		echo json_encode($temp);
	}
	catch(Exception $e){
		jsonException($e);
	}
}
function getBacterias($db,$mid,$beids){
	$pmObj=new PMBacteria();
	try{
		$pmObj->setDatabaseConnection($db);
		foreach($beids as $beid){
			$temp[DATA][$beid]=$pmObj->getBacteriaByBeid($beid);
		}
		$temp[SUC]=true;
		$temp[ERRM]=null;
		$temp[ERRC]=null;
		$temp[MID]=intval($mid);
		echo json_encode($temp);
	}catch(Exception $e){
		jsonException($e);
	}
}
function getExperiments($db,$mid,$bids){
	$pmObj=new PMExperiment();
	try{
		$pmObj->setDatabaseConnection($db);
		foreach($bids as $bid)
			$temp[DATA][$bid]=$pmObj->getByBacteria($bid);
		$temp[SUC]=true;
		$temp[ERRM]=null;
		$temp[ERRC]=null;
		$temp[MID]=intval($mid);
		echo json_encode($temp);
	}catch(Exception $e){
		jsonException($e);
	}
}
function getPlates($db,$mid,$pids){
	$pmObj=new PMPlate();
	try{
		$pmObj->setDatabaseConnection($db);
		foreach($pids as $pid)
			$temp[DATA][$pid]=$pmObj->getByPlateid($pid);
		$temp[SUC]=true;
		$temp[ERRM]=null;
		$temp[ERRC]=null;
		$temp[MID]=intval($mid);
		echo json_encode($temp);
	}catch(Exception $e){
		jsonException($e);
	}
}
function getGrowth($db,$mid,$sets){
	$pmObj=new PMGrowth();
	try{
		$pmObj->setDatabaseConnection($db);
		foreach($sets as $set)
			$temp[DATA][$set[0]][$set[1]]=$pmObj->getByExpWell($set[0],$set[1]);
		$temp[SUC]=true;
		$temp[ERRM]=null;
		$temp[ERRC]=null;
		$temp[MID]=intval($mid);
		echo json_encode($temp);
	}catch(Exception $e){
		jsonException($e);
	}
}
function jsonException($e){
	echo '{"success":false,"error_message":"'.$e->getMessage().'","error_code":'.$e->getCode().'}';
}
?>
