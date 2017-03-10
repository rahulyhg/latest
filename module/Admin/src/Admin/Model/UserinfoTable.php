<?php

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class UserinfoTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select(function (Select $select) {
            $select->join('tbl_user','tbl_user_info.user_id=tbl_user.id');
        });

        return $resultSet;
    }

    public function TopNew() {
        $resultSet = $this->tableGateway->select(function (Select $select){
                $select->join('tbl_user','tbl_user_info.user_id = tbl_user.id',array("*"),Select::JOIN_INNER);
                // $select->join('tbl_family_info','tbl_user_info.user_id = tbl_family_info.user_id',array("*"),Select::JOIN_LEFT);
                $select->order('tbl_user_info.id DESC');
                // $select->limit(10);
        });
        return $resultSet;
    }

    // public function getCity($id) {
    //     $resultSet = $this->tableGateway->select(array('id'=>$id))->current();
    //     return $resultSet;
    // }

    // public function getCityjoin($id) {
    //     $resultSet = $this->tableGateway->select(function (Select $select) use($id){
    //         $select->where(array('tbl_city.id'=>$id));
    //         $select->join('tbl_state','tbl_city.state_id = tbl_state.id',array('state_name'));
    //     })->current();

    //     return $resultSet;
    // }

    // public function deleteCity($id) {
    //     $resultSet = $this->tableGateway->delete(array('id'=>$id));
    //     return $resultSet;
    // }

    // public function SaveCity($cityEntity)
    // {
    // 	$cityEntity->created_date = (empty($cityEntity->created_date))? date('Y-m-d h:i:s'):$cityEntity->created_date;
    //             $cityEntity->modified_date = (empty($cityEntity->modified_date))? date('Y-m-d h:i:s'):$cityEntity->modified_date;

    // 	$data = array(
    //         'city_name' => $cityEntity->city_name,
    // 		'state_id' => $cityEntity->state_id,
    // 		'IsActive' => $cityEntity->IsActive,
    // 		'created_date' => $cityEntity->created_date,
    // 		'modified_date' => $cityEntity->modified_date,
    // 		'modified_by' => "1"
    // 		);
    //     if($cityEntity->id==0){
    //         $resultSet = $this->tableGateway->insert($data);
    //     }
    //     else {
    //         if ($this->getCity($cityEntity->id)) {

    //                 $this->tableGateway->update($data, array('id' => $cityEntity->id));

    //             } else {
    //                 throw new \Exception('Users id does not exist');
    //             }
    //     }

    // }

}
