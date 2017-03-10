<?php

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class UserTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();

        return $resultSet;
    }

    public function getusers($data='')
    {
        $resultSet = $this->tableGateway->select($data)->count();

        return $resultSet;

    }

    public function getInfo($data='') {
        $resultSet = $this->tableGateway->select(function (Select $select) use($data){
                $select->join('tbl_user_info','tbl_user.id = tbl_user_info.user_id',array("country","user_type_id","gender"),Select::JOIN_INNER);
                $select->join('tbl_user_roles','tbl_user.id = tbl_user_roles.user_id',array("user_id","IsMember","IsMatrimonial"),Select::JOIN_INNER);
                $select->where($data);
                $select->order('id ASC');
        })->count();
        //echo $sql->getSqlstringForSqlObject($resultSet); die ;
        return $resultSet;
    }

    

    public function updatestatus($data)
    {
        $changedata = array('IsActive'=>$data->IsActive);
        // return "dfgdgdfgd";
        $status = $this->tableGateway->update($changedata,array('id'=>$data->id));
            
        if($status){
            $respArr = array('status'=>"Updated SuccessFully");
        }   
            
        else $respArr = array('status'=>"Couldn't update");

        return $respArr;

    }

    


   

}
