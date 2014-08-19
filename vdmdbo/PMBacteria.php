<?php
/**
Testing Use Only;
ini_set('display_errors', 'On');
include_once '/var/www/html/data/api/vdmdbo/Model.php';
include_once '/var/www/html/data/api/vdmdbo/DBObject.php';
*/
class PMBacteria extends Model{
    const BACTOBJ='BactObject';

    function getBacteriaList(){
        try{
            $this->stmt=$this->db->prepare("select b.bacteria_id,b.bact_external_id as bacteria_external_id,b.bact_name as bacteria_name,b.vc_id,b.vector from pm_exp pe left join bacteria b on pe.bacteria_id=b.bacteria_id group by b.bacteria_id");
            if($this->stmt->execute()){
                if(!$temp[parent::DATA]=$this->stmt->fetchAll(PDO::FETCH_CLASS,self::BACTOBJ))
                    throw new Exception(parent::ERRMSG_NULLDATA,parent::ERRCODE_NULLDATA);
                $temp[parent::D_COUNT]=$this->stmt->rowCount();
                return $temp;
            }
        }
        catch(PDOException $e){
            throw new EXception (parent::ERRMSG_DBREQ,parent::ERRCODE_DBREQ);
        }
    }   

    function getBacteriaByBeid($beid){
        try{
            $this->stmt=$this->db->prepare("select bacteria_id,bact_external_id as bacteria_external_id,bact_name as bacteria_name,vc_id,vector from bacteria where bact_external_id=?");
            /*
                Excuete the Query.
                Set fetchMode of FETCH_CLASS to BACTOBJECT -- have to be done.
                Throw NULLDATA Exception if no data returned.
            */
            if($this->stmt->execute(array($beid))){
                $this->stmt->setFetchMode(PDO::FETCH_CLASS,self::BACTOBJ);
                if(!$temp=$this->stmt->fetch(PDO::FETCH_CLASS))
                    throw new Exception(parent::ERRMSG_NULLDATA,parent::ERRCODE_NULLDATA);
                return $temp;
            }
        }
        catch(PDOException $e){
                throw new Exception (parent::ERRMSG_DBREQ,parent::ERRCODE_DBREQ);
        }
    }

	function getBacteriaOfExp($exp_id){
		try{
			$this->stmt=$this->db->prepare("select b.bacteria_id,b.bact_external_id as bacteria_external_id, b.bact_name as bacteria_name, b.vc_id, b.vector from bacteria b right join pm_exp p on b.bacteria_id=p.bacteria_id where p.exp_id=?");
		if($this->stmt->execute(array($exp_id))){
			$this->stmt->setFetchMode(PDO::FETCH_CLASS,self::BACTOBJ);
			if(!$temp=$this->stmt->fetch(PDO::FETCH_CLASS))
				throw new Exception(parent::ERRMSG_NULLDATA,parent::ERRCODE_NULLDATA);
			return $temp;
		}
		}
		catch(PDOException $e){
			throw new Exception(parent::ERRMSG_DBREQ,parent::ERRCODE_DBREQ);
		}
	}   
}
class BactObject{
    function __construct(){
        $this->bacteria_id=intval($this->bacteria_id);
        $this->vc_id=intval($this->vc_id);
    }   
}

?>
