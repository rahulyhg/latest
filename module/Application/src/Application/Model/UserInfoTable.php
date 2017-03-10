<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class UserInfoTable extends AbstractTableGateway {

    protected $table = 'tbl_user_info';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }

	 public function saveUserInfo($Infodata) {
        //$data = $Infodata->getArrayCopy();
        $id = (int) $Infodata['id'];
		$Infodata['ip'] = $_SERVER["REMOTE_ADDR"];		
        if ($id == 0) {
			$Infodata['created_date'] = date("Y-m-d H:i:s");
            if (!$this->insert($Infodata))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getMemberInfo($id)) {
            if (!$this->update($Infodata, array('id' => $id)))
                return false;
            return $id;
        }
        else
            return false;
    }
	public function saveUserData(Entity\Memberbasic $Infodata) {
        $data = $Infodata->getArrayCopy();
        $id = (int) $Infodata->id;
		$data['ip'] = $_SERVER["REMOTE_ADDR"];		
        if ($id == 0) {
			$data['created_date'] = date("Y-m-d H:i:s");
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getMemberInfo($id)) {
            if (!$this->update($data, array('id' => $id)))
                return false;
            return $id;
        }
        else
            return false;
    }
	public function saveUserEducation(Entity\Education $Infodata) {
        $data = $Infodata->getArrayCopy();		 
        $id = (int) $Infodata->id;
		$data['ip'] = $_SERVER["REMOTE_ADDR"];		
        if ($id == 0) {
			$data['created_date'] = date("Y-m-d H:i:s");
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getMemberInfo($id)) {
            if (!$this->update($data, array('id' => $id)))
                return false;
            return $id;
        }
        else
            return false;
    } 
	public function saveUserCareer(Entity\Career $Infodata) {		
        $data = $Infodata->getArrayCopy();       	
        $id = (int) $Infodata->id;
		$data['ip'] = $_SERVER["REMOTE_ADDR"];		
        if ($id == 0) {
			$data['created_date'] = date("Y-m-d H:i:s");
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getMemberInfo($id)) {			
            if (!$this->update($data, array('id' => $id)))
                return false;
            return $id;
        }
        else
            return false;
    }
	public function saveUserMatrimoni(Entity\Matrimoni $Infodata) {
        $data = $Infodata->getArrayCopy();
		//print_r($data);exit;	
        $id = (int) $Infodata->id;
		$data['ip'] = $_SERVER["REMOTE_ADDR"];		
        if ($id == 0) {
			$data['created_date'] = date("Y-m-d H:i:s");
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getMemberInfo($id)) {
            if (!$this->update($data, array('id' => $id)))
                return false;
            return $id;
        }
        else
            return false;
    }
	public function getMemberInfo($id) {
        $row = $this->select(array('id' => (int) $id))->current();
        if (!$row)
            return false;
        //$entity = new Entity\Memberbasic();
        //return $entity->exchangeArray((array)$row);
		return $row;
    }
	public function GetUserDetail($id) {
        $row = $this->select(array('user_id' => (int) $id))->current();
        if (!$row)
            return false;
        $entity = new Entity\Memberbasic();
        return $entity->exchangeArray((array)$row);
		//return $row;
    }
	public function GetUserEducation($id) {
        $row = $this->select(array('user_id' => (int) $id))->current();
        if (!$row)
            return false;
        $entity = new Entity\Education();
        return $entity->exchangeArray((array)$row);
		//return $row;
    }
	public function GetUserCareer($id) {
        $row = $this->select(array('user_id' => (int) $id))->current();
        if (!$row)
            return false;
        $entity = new Entity\Career();
        return $entity->exchangeArray((array)$row);
		//return $row;
    }
	public function GetUserMatrimoni($id) {
        $row = $this->select(array('user_id' => (int) $id))->current();
        if (!$row)
            return false;
        $entity = new Entity\Matrimoni();
        return $entity->exchangeArray((array)$row);
		//return $row;
    }
	
}