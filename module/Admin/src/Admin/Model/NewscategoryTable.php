<?php

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class NewscategoryTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getNewscategory($id) {
        $resultSet = $this->tableGateway->select(array('id'=>$id))->current();
        return $resultSet;
    }

    // public function getNewscategoryjoin($id) {
    //     $resultSet = $this->tableGateway->select(function (Select $select) use($id){
    //         $select->where(array('tbl_state.id'=>$id));
    //         $select->join('tbl_country','tbl_state.country_id = tbl_country.id',array('country_name'));
    //     })->current();

    //     return $resultSet;
    // }

    public function deleteNewscategory($id) {
        $resultSet = $this->tableGateway->delete(array('id'=>$id));
        return $resultSet;
    }



    public function SaveNewscategory($newscategoryEntity)
    {
    	$newscategoryEntity->created_date = (empty($newscategoryEntity->created_date))? date('Y-m-d h:i:s'):$newscategoryEntity->created_date;
                $newscategoryEntity->modified_date = (empty($newscategoryEntity->modified_date))? date('Y-m-d h:i:s'):$newscategoryEntity->modified_date;

    	$data = array(
            'category_name' => $newscategoryEntity->category_name,
    		'IsActive' => $newscategoryEntity->IsActive,
    		'created_date' => $newscategoryEntity->created_date,
    		'modified_date' => $newscategoryEntity->modified_date,
    		'modified_by' => "1"
    		);
        // print_r($data);die;
        if($newscategoryEntity->id==0){
            $resultSet = $this->tableGateway->insert($data);
        }
        else {
            if ($this->getNewscategory($newscategoryEntity->id)) {


                    $this->tableGateway->update($data, array('id' => $newscategoryEntity->id));

                } else {
                    throw new \Exception('Users id does not exist');
                }
        }
    }

     public function customFields($columns)
    {   
        // echo"sdsd";
        $newscategoryName = $this->tableGateway->select(function(Select $select) use($columns){
            $select->order('id ASC');
            $select->columns($columns);
        })->toArray();

        foreach ($newscategoryName as $list) {
            $newscategorylist[$list['id']] = $list['category_name'];
        }
        // print_r($statenamelist);die;
        return $newscategorylist;
    }

}
