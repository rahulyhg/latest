<?php

namespace Application\Plugin;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class TablePlugin extends AbstractPlugin {

    protected $dbAdapter;

    public function __construct(Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    public function getUser($id = null) {
        $data = $this->dbAdapter->query(
                "SELECT * FROM tbl_user WHERE id='$id'"
                
                 , Adapter::QUERY_MODE_EXECUTE);
        
        
         return $data->current();
    }
    
//    public function getUserInfo($id = null) {
//        $data = $this->dbAdapter->query(
//                "SELECT * FROM tbl_user WHERE id='$id'"
//                
//                 , \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
//        
//        
//         return $data->current();
//    }
     public function getUserInfoById($id = null, $field=null) {

        if ($id == null) {
            return false;
        }
        if ($field == null) {
            $fieldName = ' * ';
        }else{
            $fieldName = $field;
        }

        
        $userinfo = $this->dbAdapter->query("select $fieldName from tbl_user_info where user_id='$id'", Adapter::QUERY_MODE_EXECUTE);
        $resultSet = new ResultSet;
        $resultSet->initialize($userinfo);
        return $resultSet->current();
    }

}
