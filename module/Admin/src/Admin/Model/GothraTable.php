<?php

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class GothraTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($data = '') 
    {
        //echo  "hi";
        $resultSet = $this->tableGateway->select($data);

        return $resultSet;
    }
    
    public function getGothra($id) {
        $resultSet = $this->tableGateway->select(array('id'=>$id))->current();
        return $resultSet;
    }

//    public function getGothra($id) {
//        $resultSet = $this->tableGateway->select(array('id'=>$id))->current();
//        return $resultSet;
//    }

    // public function getStatejoin($id) {
    //     $resultSet = $this->tableGateway->select(function (Select $select) use($id){
    //         $select->where(array('tbl_state.id'=>$id));
    //         $select->join('tbl_country','tbl_state.country_id = tbl_country.id',array('country_name'));
    //     })->current();

    //     return $resultSet;
    // }

    public function deleteGothra($id) {
        $resultSet = $this->tableGateway->delete(array('id'=>$id));
        return $resultSet;
    }

    public function SaveGothra($gothraEntity)
    {
    	$gothraEntity->created_date = (empty($gothraEntity->created_date))? date('Y-m-d h:i:s'):$gothraEntity->created_date;
                $gothraEntity->modified_date = (empty($gothraEntity->modified_date))? date('Y-m-d h:i:s'):$gothraEntity->modified_date;
                
                $Cstatus = empty($gothraEntity->IsActive) ? 0 : 1;
                
    	$data = array(
            'gothra_name' => $gothraEntity->gothra_name,
    		'IsActive' => $Cstatus,    		
    		'modified_by' => "1"
    		);
        if($gothraEntity->id==0){
            //$resultSet = $this->tableGateway->insert($data);
             $dateData=array(
                 'created_date' => $gothraEntity->created_date,
                 'modified_date' => $gothraEntity->modified_date,
            );
            
            $dataInput= array_merge($data,$dateData);
            $result = $this->tableGateway->insert($dataInput);
            if ($result)
                return "success";
            else
                return "couldn't update";
        }
        else {
            if ($this->getGothra($gothraEntity->id)) {
                
            $dateData=array(
                 'modified_date' => $gothraEntity->modified_date,
            );
            
            $dataUpdate= array_merge($data,$dateData);

                $result = $this->tableGateway->update($dataUpdate, array('id' => $gothraEntity->id));
                if ($result)
                    return "success";
                else
                    return "couldn't update";
            } else {
                return "couldn't update";
                throw new \Exception('Users id does not exist');
            }
        }
    }

    //  public function customFields($columns)
    // {   
    //     $stateName = $this->tableGateway->select(function(Select $select) use($columns){
    //         $select->order('id ASC');
    //         $select->columns($columns);
    //     })->toArray();

    //     foreach ($stateName as $list) {
    //         $statenamelist[$list['id']] = $list['state_name'];
    //     }
    //     // print_r($statenamelist);die;
    //     return $statenamelist;
    // }
    
    public function updatestatus($data) {
        $changedata = array('IsActive' => $data->IsActive);
        // return "dfgdgdfgd";
        $status = $this->tableGateway->update($changedata, array('id' => $data->id));

        if ($status) {
            $respArr = array('status' => "Updated SuccessFully");
        } else
            $respArr = array('status' => "Couldn't update");

        return $respArr;
    }
    
    public function delmultiple($data = '') {
        $resultSet = $this->tableGateway->delete("id in($data)");
        return $resultSet;
    }

}
