<?php

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class CityTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() 
    {//            echo  "<pre>";
//            print_r($data);die;
        $resultSet = $this->tableGateway->select(function (Select $select) {
                $select->join('tbl_state','tbl_city.state_id = tbl_state.id',array("state_name"),Select::JOIN_INNER);
                //$select->where($data);
                $select->order('id ASC');
        });

        return $resultSet;    
        
        
    }

    public function getCity($id) {
        $resultSet = $this->tableGateway->select(array('id'=>$id))->current();
        return $resultSet;
    }

    public function getCityjoin($id) {
        $resultSet = $this->tableGateway->select(function (Select $select) use($id){
            $select->where(array('tbl_city.id'=>$id));
            $select->join('tbl_state','tbl_city.state_id = tbl_state.id',array('state_name'));
        })->current();

        return $resultSet;
    }
    
    public function fetchAll2($data = '') {
//        $resultSet = $this->tableGateway->select(function (Select $select) use($data){
//            $select->where(array('tbl_city.IsActive'=>$data));
//            $select->join('tbl_state','tbl_city.state_id = tbl_state.id',array('state_name'));
//        });
        
        
        $resultSet = $this->tableGateway->select(function (Select $select) use($data) {
                $select->join('tbl_state','tbl_city.state_id = tbl_state.id',array("state_name"),Select::JOIN_INNER);
                $select->where(array('tbl_city.IsActive'=>$data));
               
        });
        
//        echo  "<pre>";
//       print_r($resultSet);die;
        return $resultSet;
        
    }

    public function deleteCity($id) {
        $resultSet = $this->tableGateway->delete(array('id'=>$id));
        return $resultSet;
    }

    public function SaveCity($cityEntity)
    {
    	$cityEntity->created_date = (empty($cityEntity->created_date))? date('Y-m-d h:i:s'):$cityEntity->created_date;
                $cityEntity->modified_date = (empty($cityEntity->modified_date))? date('Y-m-d h:i:s'):$cityEntity->modified_date;
                
                $Cstatus = empty($cityEntity->IsActive) ? 0 : 1;
                
    	$data = array(
            'city_name' => $cityEntity->city_name,
    		'state_id' => $cityEntity->state_id,
    		'IsActive' => $Cstatus,    		
    		'modified_by' => "1"
    		);
        if($cityEntity->id==0){
            
            $dateData=array(
                 'created_date' => $cityEntity->created_date,
                 'modified_date' => $cityEntity->modified_date,
            );
            
             $dataInput= array_merge($data,$dateData);
            $result = $this->tableGateway->insert($dataInput);
            
            if ($result)
                return "success";
            else
                return "couldn't update";
        }
        else {
            if ($this->getCity($cityEntity->id)) {
                
            $dateData=array(
                 'modified_date' => $cityEntity->modified_date,
            );
            
            $dataUpdate= array_merge($data,$dateData);

                $result = $this->tableGateway->update($dataUpdate, array('id' => $cityEntity->id));
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


    public function customFields($columns)
    {   
        $cityName = $this->tableGateway->select(function(Select $select) use($columns){
            $select->order('id ASC');
            $select->columns($columns);
        })->toArray();

        foreach ($cityName as $list) {
            $citynamelist[$list['id']] = $list['city_name'];
        }
        // print_r($countrynamelist);die;
        return $citynamelist;
    }
    
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
