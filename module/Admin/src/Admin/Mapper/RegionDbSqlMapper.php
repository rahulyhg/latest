<?php

namespace Admin\Mapper;

use Admin\Model\Entity\Regions;
use Application\Model\Entity\UserInfo;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Insert;
use Zend\Debug\Debug;
use Zend\Stdlib\Hydrator\ClassMethods;

class RegionDbSqlMapper implements RegionMapperInterface {

    protected $dbAdapter;
    protected $resultSet;
    protected $hydrator;

    public function __construct(AdapterInterface $dbAdapter) {


        $this->dbAdapter = $dbAdapter;
        $this->resultSet = new ResultSet();
        $this->hydrator = new ClassMethods();
    }

    public function getAmmir() {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_user_info");
        $result = $statement->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new UserInfo());
        }
    }

    public function getAmmirById($id) {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_user_info WHERE user_id=:klm");
        $parameters = array(
            'klm' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new UserInfo());
        }
    }
    
   
    
    //Region
    
   
    public function getRegionList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT tbl_region.*, tal.id as adminid, tal.username as username FROM tbl_region 
                LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_region.modified_by OR tal.id=tbl_region.created_by ORDER BY `order_val` ASC");
        $result = $statement->execute();
        //}
        // if(isset($status)){
//        Debug::dump($status);
//        exit;
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field  WHERE is_active=:is_active");
//        $parameters = array(
//            'is_active' => $status,
//        );
        //$result = $statement->execute($parameters);
        //$result = $statement->execute();
        //}
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Regions());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function SaveRegion($regionObject) {
//                print_r($educationFieldsObject);
//                exit;
//        $regionData = $this->hydrator->extract($regionObject);
//        //print_r($educatioData);
//        //exit;
//        unset($regionData['id']); // Neither Insert nor Update needs the ID in the array
//
//        if ($regionObject->getId()) {
////            echo  "<pre>";
////            echo  "hello";exit;
//            $statement = $this->dbAdapter->query("UPDATE tbl_region 
//                SET region_name=:region_name,
//                    is_active=:is_active
//                    WHERE id=:id");
//            //Debug::dump($id);
//            //exit;
//            $parameters = array(
//                'id' => $regionObject->getId(),
//                'region_name' => $regionObject->getRegionName(),
//                'is_active' => $regionObject->getIsActive(),
//            );
//            $result = $statement->execute($parameters);
//            
//            if ($result)
//                    return "success";
//                else
//                    return "couldn't update";
//        } else {
//             $statement = $this->dbAdapter->query("INSERT INTO tbl_region 
//                 (region_name, is_active, created_date)
//                 values(:region_name, :is_active, now())");
//                 
//           
//            $parameters = array(
//                'region_name' => $regionObject->getRegionName(),
//                'is_active' => $regionObject->getIsActive(),
//            );
//            //print_r($parameters);
//            //exit;
//            $result = $statement->execute($parameters);
//            
//            //if ($result) 
//           if ($result)
//                return "success";
//            else
//                return "couldn't update";
//
//        //return $respArr;
//        }
//
//        if ($result instanceof ResultInterface) {
//            if ($newId = $result->getGeneratedValue()) {
//                // When a value has been generated, set it on the object
//                $regionObject->setId($newId);
//            }
//
//            //print_r($educationFieldsObject);
//            //exit;
//            
//        }
        if ($regionObject['id']) {
           
            $postData = array();
            $postData['region_name'] = $regionObject['region_name'];
            $postData['is_active'] = $regionObject['is_active'];
            //$postData['country_id'] = $regionObject['country_id'];
            //$postData['master_country_id'] = $regionObject['master_country_id'];            
            //$postData['image']      =  $regionObject['image'];
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['modified_by']      = $regionObject[0];
            $postData['created_by']      = $regionObject[0];
            $postData['ip']      = $regionObject[2];
            

            

            $action = new Update('tbl_region');
            $action->set($postData);
            $action->where(array('id = ?' => $regionObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } else {

            
            $postData = array();
            $postData['region_name'] = $regionObject['region_name'];
            $postData['is_active'] = $regionObject['is_active'];
            //$postData['country_id'] = $regionObject['country_id'];
            //$postData['master_country_id'] = $regionObject['master_country_id'];            
            //$postData['image']      =  $regionObject['image'];
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $regionObject[0];
            $postData['ip']      = $regionObject[2];
            

            

            $action = new Insert('tbl_region');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
            //case 2:
            $postData2 = array();
            $regionId = $result->getGeneratedValue();
            $postData2['order_val'] = $regionId;
            
            $action2 = new Update('tbl_region');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $regionId));
            $sql2 = new Sql($this->dbAdapter);
            $stmt2 = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt2->execute();
            
            if ($result)
                return "success";
            else
                return "couldn't update";
       }
        
    }
    
     public function getRegion($id) {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_region WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Regions());
        }
    }
    
    public function regionSearch($data) {
//        echo   "<pre>";
//        echo  $data;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_region WHERE region_name like '" . $data . "%'");
//        \Zend\Debug\Debug::dump($statement);exit;

//        $parameters = array(
//            'id' => $id,
//        );
        //print_r($statement);
        ///exit;
        $result = $statement->execute();
//        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
//            return $this->hydrator->hydrate($result->current(), new EducationFields());
//        }
        
         if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Regions());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function performSearchRegion($field) {
//        echo   "<pre>";
//        echo  $field;exit;
        $field1 = empty($field) ? "" : "region_name like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_region WHERE " . $field1 . "");
        

//        $parameters = array(
//            'id' => $id,
//        );
        //print_r($statement);
        ///exit;
        $result = $statement->execute();
//        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
//            return $this->hydrator->hydrate($result->current(), new EducationFields());
//        }
        
         if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Regions());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function getRegionRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT tbl_region.* ,tal.id as adminid, tal.username as username FROM tbl_region  LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_region.modified_by OR tal.id=tbl_region.created_by WHERE is_active=:is_active");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Regions());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }  else {
            return FALSE;
        }
    }
    
    public function viewByRegionId($table, $id) {

        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM $table WHERE id=:id");
        //$adapter->query('SELECT * FROM `artist` WHERE `id` = ?', array(5));

        $parameters = array(
            'id' => $id,
        );
        //print_r($statement);
        ///exit;
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Regions());
        }
        //print_r($result->current());exit;
//        if ($result) {
//            $respArr = array('status' => "Deleted SuccessFully");getRegionList
//        } else {
//            $respArr = array('status' => "Couldn't deleted");
//        }
//
        //return $result;
    }
    
   
    
    
    
    
    
    

}
