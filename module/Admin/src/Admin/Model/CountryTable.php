<?php

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class CountryTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($data = '') {
        $resultSet = $this->tableGateway->select($data);
        return $resultSet;
    }

    public function getCountry($id) {
        $resultSet = $this->tableGateway->select(array('id' => $id))->current();
        return $resultSet;
    }

    public function deleteCountry($id) {
        $resultSet = $this->tableGateway->delete(array('id' => $id));
        return $resultSet;
    }

    public function SaveCountry($countryEntity) {
        $countryEntity->created_date = (empty($countryEntity->created_date)) ? date('Y-m-d h:i:s') : $countryEntity->created_date;
        $countryEntity->modified_date = (empty($countryEntity->modified_date)) ? date('Y-m-d h:i:s') : $countryEntity->modified_date;

        $Cstatus = empty($countryEntity->IsActive) ? 0 : 1;
        $data = array(
            'master_country_id' => $countryEntity->master_country_id,
            'country_name' => $countryEntity->country_name,
            'dial_code' => $countryEntity->dial_code,
            'country_code' => $countryEntity->country_code,
            'IsActive' => $Cstatus,
            'modified_by' => "1"
        );
        if ($countryEntity->id == 0) {
            
            $dateData=array(
                 'created_date' => $countryEntity->created_date,
                 'modified_date' => $countryEntity->modified_date,
            );
            
            $dataInput= array_merge($data,$dateData);
            $result = $this->tableGateway->insert($dataInput);
            if ($result)
                return "success";
            else
                return "couldn't update";
        }
        else {
            if ($this->getCountry($countryEntity->id)) {
                
            $dateData=array(
                 'modified_date' => $countryEntity->modified_date,
            );
            
            $dataUpdate= array_merge($data,$dateData);

                $result = $this->tableGateway->update($dataUpdate, array('id' => $countryEntity->id));
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

    public function customFields($columns) {
        $countryName = $this->tableGateway->select(function(Select $select) use($columns) {
                    $select->order('id ASC');
                    $select->columns($columns);
                })->toArray();

        foreach ($countryName as $list) {
            $countrynamelist[$list['id']] = $list['country_name'];
        }
        // print_r($countrynamelist);die;
        return $countrynamelist;
    }

    // public function searchresults($data='')
    // { 
    //   // $where = new Where();
    //     // $where->like('country_name',''.$data.'%');
    //     // "country_name like '$data%'"
    //     $resultSet = $this->tableGateway->select(function(Select $select){
    //         $select->join("allcountries","tbl_country.master_country_id=allcountries.id",array("id"),Select::JOIN_LEFT);
    //         // $select->where('tbl_country.IsActive=1');
    //     });
    //     return $resultSet;
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
