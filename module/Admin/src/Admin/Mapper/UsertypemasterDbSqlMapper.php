<?php

namespace Admin\Mapper;

use Admin\Model\Entity\Usertypemasters;
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

class UsertypemasterDbSqlMapper implements UsertypemasterMapperInterface {

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
    
    public function test() {
        return  "Hello World";
    }
   
    
    //Usertypemaster
    
   
    public function getUsertypemasterList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT tbl_user_type.*, tal.id as adminid, tal.username as username FROM tbl_user_type 
                LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_user_type.modified_by OR tal.id=tbl_user_type.created_by ORDER BY `order_val` ASC");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Usertypemasters());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function SaveUsertypemaster($usertypemasterObject) {
//                print_r($educationFieldsObject);
//                exit;
//        $usertypemasterData = $this->hydrator->extract($usertypemasterObject);
//        //print_r($educatioData);
//        //exit;
//        unset($usertypemasterData['id']); // Neither Insert nor Update needs the ID in the array
//
//        if ($usertypemasterObject->getId()) {
////            echo  "<pre>";
////            echo  "hello";exit;
//            $statement = $this->dbAdapter->query("UPDATE tbl_user_type 
//                SET user_type=:user_type,
//                    is_active=:is_active
//                    WHERE id=:id");
//            //Debug::dump($id);
//            //exit;
//            $parameters = array(
//                'id' => $usertypemasterObject->getId(),
//                'user_type' => $usertypemasterObject->getUsertypemasterName(),
//                'is_active' => $usertypemasterObject->getIsActive(),
//            );
//            $result = $statement->execute($parameters);
//            
//            if ($result)
//                    return "success";
//                else
//                    return "couldn't update";
//        } else {
//             $statement = $this->dbAdapter->query("INSERT INTO tbl_user_type 
//                 (user_type, is_active, created_date)
//                 values(:user_type, :is_active, now())");
//                 
//           
//            $parameters = array(
//                'user_type' => $usertypemasterObject->getUsertypemasterName(),
//                'is_active' => $usertypemasterObject->getIsActive(),
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
//                $usertypemasterObject->setId($newId);
//            }
//
//            //print_r($educationFieldsObject);
//            //exit;
//            
//        }
        if ($usertypemasterObject['id']) {
           
            $postData = array();
            $postData['user_type'] = $usertypemasterObject['user_type'];
            $postData['is_active'] = $usertypemasterObject['is_active'];
            //$postData['country_id'] = $usertypemasterObject['country_id'];
            //$postData['master_country_id'] = $usertypemasterObject['master_country_id'];            
            //$postData['image']      =  $usertypemasterObject['image'];
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['modified_by']      = $usertypemasterObject[0];
            $postData['created_by']      = $usertypemasterObject[0];
            $postData['ip']      = $usertypemasterObject[2];
            

            

            $action = new Update('tbl_user_type');
            $action->set($postData);
            $action->where(array('id = ?' => $usertypemasterObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } else {

            
            $postData = array();
            $postData['user_type'] = $usertypemasterObject['user_type'];
            $postData['is_active'] = $usertypemasterObject['is_active'];
            //$postData['country_id'] = $usertypemasterObject['country_id'];
            //$postData['master_country_id'] = $usertypemasterObject['master_country_id'];            
            //$postData['image']      =  $usertypemasterObject['image'];
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $usertypemasterObject[0];
            $postData['ip']      = $usertypemasterObject[2];
            

            

            $action = new Insert('tbl_user_type');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
            //case 2:
            $postData2 = array();
            $usertypeId = $result->getGeneratedValue();
            $postData2['order_val'] = $usertypeId;
            
            $action2 = new Update('tbl_user_type');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $usertypeId));
            $sql2 = new Sql($this->dbAdapter);
            $stmt2 = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt2->execute();
            
            if ($result)
                return "success";
            else
                return "couldn't update";
       }
        
    }
    
     public function getUsertypemaster($id) {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_user_type WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Usertypemasters());
        }
    }
    
    public function usertypemasterSearch($data) {
//        echo   "<pre>";
//        echo  $data;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_user_type WHERE user_type like '" . $data . "%'");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Usertypemasters());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function performSearchUsertypemaster($field) {
//        echo   "<pre>";
//        echo  $field;exit;
        $field1 = empty($field) ? "" : "user_type like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_user_type WHERE " . $field1 . "");
        

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
            $resultSet = new HydratingResultSet($this->hydrator, new Usertypemasters());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function getUsertypemasterRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT tbl_user_type.* ,tal.id as adminid, tal.username as username FROM tbl_user_type  LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_user_type.modified_by OR tal.id=tbl_user_type.created_by WHERE is_active=:is_active");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Usertypemasters());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }  else {
            return FALSE;
        }
    }
    
    public function viewByUsertypemasterId($table, $id) {

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
            return $this->hydrator->hydrate($result->current(), new Usertypemasters());
        }
        //print_r($result->current());exit;
//        if ($result) {
//            $respArr = array('status' => "Deleted SuccessFully");getUsertypemasterList
//        } else {
//            $respArr = array('status' => "Couldn't deleted");
//        }
//
        //return $result;
    }
    
   
    
    
    
    
    
    

}
