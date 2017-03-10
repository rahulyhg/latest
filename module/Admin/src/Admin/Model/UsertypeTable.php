<?php

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class UsertypeTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($data = '') {
        
        if($data==0 && $data!=''){
            
            $resultSet = $this->tableGateway->select(function(Select $select){
            $select->where('is_active=0');
            $select->order('order_val ASC');
        });
        return $resultSet;
        }if($data==1){
        $resultSet = $this->tableGateway->select(function(Select $select){
            $select->where('is_active=1');
            $select->order('order_val ASC');
        });
        return $resultSet;
        }if($data==''){
            $resultSet = $this->tableGateway->select(function(Select $select){
            //$select->where('is_active=0');
            $select->order('order_val ASC');
        });
        return $resultSet;
            
        }
    }
    
    public function fetchAll2($data = '') {
        $resultSet = $this->tableGateway->select($data);
        return $resultSet;
//        $resultSet = $this->tableGateway->select(function(Select $select){
//            $select->order('order_val ASC');
//        });
//        return $resultSet;
    }

    public function fetchAllActive() {
        $resultSet = $this->tableGateway->select(function(Select $select){
            $select->where('is_active=1');
        });
        return $resultSet;
    }

    public function getUsertype($id) {
        $resultSet = $this->tableGateway->select(array('id'=>$id))->current();
        return $resultSet;
    }

    // public function getStatejoin($id) {
    //     $resultSet = $this->tableGateway->select(function (Select $select) use($id){
    //         $select->where(array('tbl_state.id'=>$id));
    //         $select->join('tbl_country','tbl_state.country_id = tbl_country.id',array('country_name'));
    //     })->current();

    //     return $resultSet;
    // }

    public function deleteUsertype($id) {
        $resultSet = $this->tableGateway->delete(array('id'=>$id));
        return $resultSet;
    }

    public function updateUsertype($uid,$utype) {
        $resultSet = $this->tableGateway->update($utype,array('user_id'=>$uid));
        if($resultSet){
            $respArr = array('status'=>"Updated SuccessFully");
        }   
            
        else $respArr = array('status'=>"Couldn't update");

        return $respArr;
    }
    
    public function updatestatus($data) {
        $changedata = array('is_active' => $data->is_active);
        // return "dfgdgdfgd";
        $status = $this->tableGateway->update($changedata, array('id' => $data->id));

        if ($status) {
            $respArr = array('status' => "Updated SuccessFully");
        } else
            $respArr = array('status' => "Couldn't update");

        return $respArr;
    }

    public function SaveUsertype($usertypeEntity)
    {      $usertypeEntity->created_date = (empty($usertypeEntity->created_date))? date('Y-m-d h:i:s'):$usertypeEntity->created_date;
                $usertypeEntity->modified_date = (empty($usertypeEntity->modified_date))? date('Y-m-d h:i:s'):$usertypeEntity->modified_date;
                
                $Cstatus = empty($usertypeEntity->is_active) ? 0 : 1;
                
    	$data = array(
            'user_type' => $usertypeEntity->user_type,
    		'is_active' => $Cstatus,    		
    		'modified_by' => "1"
    		);
        if($usertypeEntity->id==0){
            //$resultSet = $this->tableGateway->insert($data);
            
             $dateData=array(
                 'created_date' => $usertypeEntity->created_date,
                 'modified_date' => $usertypeEntity->modified_date,
            );
            
            $dataInput= array_merge($data,$dateData);
            $result = $this->tableGateway->insert($dataInput);
            if ($result)
                return "success";
            else
                return "couldn't update";
        }
        else {
           if ($this->getUsertype($usertypeEntity->id)) {
                
            $dateData=array(
                 'modified_date' => $usertypeEntity->modified_date,
            );
            
            $dataUpdate= array_merge($data,$dateData);

                $result = $this->tableGateway->update($dataUpdate, array('id' => $usertypeEntity->id));
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

}
