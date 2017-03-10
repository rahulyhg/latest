<?php

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class UsersRolesTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();

        return $resultSet;
    }

    
    public function userrole($user_id) {
        $resultSet = $this->tableGateway->select(array("user_id=$user_id"))->toArray();

        return $resultSet;
    }

    public function chckdup($id) {
        $resultSet = $this->tableGateway->select(array('user_id'=>$id))->current();
        return $resultSet;
    }

    public function SaveRole($data)
    {   
        
        //echo "just for testing";exit;

        $already = $this->chckdup($data['user_id']);
        if(empty($already)){
            
            $user_id = (empty($UserRoles['uid']))? 0:$UserRoles['uid'];
            $updata['IsMember'] = ($data['IsMember']=="on")? 1:0;
            $updata['IsExecutive'] = ($data['IsExecutive']=="on")? 1:0;
            $updata['IsMatrimonial'] = ($data['IsMatrimonial']=="on")? 1:0;
            $updata['created_date'] = date('Y-m-d h:i:s');
            $updata['last_modified'] = date('Y-m-d h:i:s');
            $updata['modified_by'] = 1;
            $updata['user_id'] = $data['user_id'];
                
                $result = $this->tableGateway->insert($updata);
            if($result)
                return "Assigned successfully";
            else return "couldn't assign";       

             
        }
        else {

             
            $updata['IsMember'] = ($data['IsMember']=="on")? 1:0;
            $updata['IsExecutive'] = ($data['IsExecutive']=="on")? 1:0;
            $updata['IsMatrimonial'] = ($data['IsMatrimonial']=="on")? 1:0;
            $updata['last_modified'] = date('Y-m-d h:i:s');
            $updata['modified_by'] = 1;

            $result = $this->tableGateway->update($updata, array('id' => $data['insert_id']));
            if($result)
                return "Updated successfully";
            else return "No changes are made to update";   

             
       }
    }
    


   

}
