<?php
include_once 'Model.php';
class PMExperiment extends Model{
	const EXPOBJ='ExpObject';
	public function getByBacteria($bact_ext_id){
		try{
			$this->stmt=$this->db->prepare("select pe.exp_id as experiment_id,pe.bacteria_id,pf.exp_date as experiment_date, pf.file_name,p.plate_id,p.plate_name,pe.replicate_num from pm_exp pe, plate p, pm_files pf where pe.bacteria_id=? and pf.file_id=pe.file_id and pe.plate_id=p.plate_id");
			if($this->stmt->execute(array($bact_ext_id))){
				if(!$temp[parent::DATA]=$this->stmt->fetchAll(PDO::FETCH_CLASS,self::EXPOBJ))
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
class ExpObject{
	function __construct(){
		$this->experiment_id=intval($this->experiment_id);
		$this->plate_id=intval($this->plate_id);
		$this->replicate_num=intval($this->replicate_num);
		$this->bacteria_id=intval($this->bacteria_id);
	}
}

?>
