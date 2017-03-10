<?php

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class StarsignTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($data = '') {
        $resultSet = $this->tableGateway->select($data);

        return $resultSet;
    }

    public function getStarsign($id) {
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

    public function deleteStarsign($id) {
        $resultSet = $this->tableGateway->delete(array('id'=>$id));
        return $resultSet;
    }

    public function SaveStarsign($starsignEntity)
    {
    	$starsignEntity->created_date = (empty($starsignEntity->created_date))? date('Y-m-d h:i:s'):$starsignEntity->created_date;
                $starsignEntity->modified_date = (empty($starsignEntity->modified_date))? date('Y-m-d h:i:s'):$starsignEntity->modified_date;
                
                $Cstatus = empty($starsignEntity->IsActive) ? 0 : 1;
                
    	$data = array(
            'star_sign_name' => $starsignEntity->star_sign_name,
    		'IsActive' => $Cstatus,    		
    		'modified_by' => "1"
    		);
        if($starsignEntity->id==0){
            //$resultSet = $this->tableGateway->insert($data);
            $dateData=array(
                 'created_date' => $starsignEntity->created_date,
                 'modified_date' => $starsignEntity->modified_date,
            );
            
            $dataInput= array_merge($data,$dateData);
            $result = $this->tableGateway->insert($dataInput);
            if ($result)
                return "success";
            else
                return "couldn't update";
        }
        else {
             if ($this->getStarsign($starsignEntity->id)) {
                
            $dateData=array(
                 'modified_date' => $starsignEntity->modified_date,
            );
            
            $dataUpdate= array_merge($data,$dateData);

                $result = $this->tableGateway->update($dataUpdate, array('id' => $starsignEntity->id));
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
