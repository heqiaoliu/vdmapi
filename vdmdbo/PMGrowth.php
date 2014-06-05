<?php
include_once 'Model.php';
class PMGrowth extends Model{
	const GROWTHOBJ='GrowthObject',FETCH_GM='fetchGrowthMeasure',
	SEL_T_G="select time,growth_measurement from pm_growth where exp_id=? and well_id=? order by time asc";
	public function getByExpWell($expid,$wellid){
		try{
			$this->stmt=$this->db->prepare(self::SEL_T_G);
			if($this->stmt->execute(array($expid,$wellid))){
				if(!$temp[parent::DATA]=$this->stmt->fetchAll(PDO::FETCH_FUNC,self::FETCH_GM))
					throw new Exception(parent::ERRMSG_NULLDATA,parent::ERRCODE_NULLDATA);
				$temp[parent::D_COUNT]=$this->stmt->rowCount();
				return $temp;
			}
		}
		catch(PDOException $e){
			throw new Exception(parent::ERRMSG_DBREQ,parent::ERRCODE_DBREQ);
		}
	}
}
function fetchGrowthMeasure($time,$growth_measurement){
	return floatval($growth_measurement);
}

class GrowthObject{
	function __construct(){
		$this->time=intval($this->time);
		$this->growth_measurement=floatval($this->growth_measurement);
	}
}
?>
