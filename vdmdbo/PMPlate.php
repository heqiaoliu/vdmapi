<?php
include_once 'Model.php';

class PMPlate extends Model{
	const PLATEOBJ='PlateObject';
	public function getByPlateid($plate_id){
		try{
			$this->stmt=$this->db->prepare("select pwn.well_id,pwn.well_num,pmc.medium_ctrl_name as medium_control_name,ms.medium_supplement_name,ppc.supplement_conc from pm_plate_compound ppc, pm_medium_control pmc, medium_supplement ms,plate p,pm_well_num pwn where p.plate_name=? and ppc.plate_id=p.plate_id and ppc.medium_control_id=pmc.medium_ctrl_id and ppc.medium_supplement_id=ms.medium_supplement_id and pwn.well_id=ppc.well_id order by pwn.well_id");
			if($this->stmt->execute(array($plate_id))){
				$temp=array();
				$this->stmt->setFetchMode(PDO::FETCH_CLASS,self::PLATEOBJ);
				if(!$row=$this->stmt->fetch(PDO::FETCH_CLASS))
					throw new Exception(parent::ERRMSG_NULLDATA,parent::ERRCODE_NULLDATA);
				do{
					$temp[parent::DATA][$row->well_num]=$row;
				}while($row=$this->stmt->fetch(PDO::FETCH_CLASS));
				$temp[parent::D_COUNT]=$this->stmt->rowCount();
				return $temp;
			}
		}
		catch(PDOException $e){
			throw new Exception(parent::ERRMSG_DBREQ,parent::ERRCODE_DBREQ);
		}
	}
}
class PlateObject{
	function __construct(){
		$this->well_id=intval($this->well_id);	
		$this->supplement_conc=doubleval($this->supplement_conc);
	}
}

?>
