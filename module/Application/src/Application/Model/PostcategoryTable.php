<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class PostcategoryTable extends AbstractTableGateway {

    protected $table = 'tbl_postcategory';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }

    public function fetchAll($data='')
    {
        $row = $this->select();
        if (!$row)
            return false;
         
        return $row;
    }

     public function customFields($columns)
    {   
        $postcategory = $this->select(function(Select $select) use($columns){
            $select->order('id ASC');
            $select->columns($columns);
        })->toArray();

        foreach ($postcategory as $list) {
            $postcategorylist[$list['id']] = $list['category_name'];
        }
        // print_r($statenamelist);die;
        return $postcategorylist;
    }
    

}