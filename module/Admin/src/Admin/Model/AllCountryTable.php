<?php

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;


class AllCountryTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    
    public function searchresults($data='')
    { 
      // $where = new Where();
        // $where->like('country_name',''.$data.'%');
        // "country_name like '$data%'"
        $subquery = new Select();
        $resultSet = $subquery->from("tbl_country")->execute();


        // $resultSet = $this->tableGateway->select(function(Select $select){
            
        //     $select->columns(array("*"));
        //     $select->where->notIn('allcountries.id',);
        // });
        return $resultSet;
    }

}
