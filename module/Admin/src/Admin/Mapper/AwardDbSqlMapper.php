<?php

namespace Admin\Mapper;

use Admin\Model\Entity\Awards;
//use Admin\Model\Entity\Countries;
//use Admin\Model\Entity\States;
//use Admin\Model\Entity\Cities;
//use Admin\Model\Entity\Awards;
//use Admin\Model\Entity\Gothras;
//use Admin\Model\Entity\Starsigns;
//use Admin\Model\Entity\Zodiacsigns;
//use Admin\Model\Entity\Professions;
//use Admin\Model\Entity\Designations;
//use Admin\Model\Entity\Educationlevels;
use Application\Model\Entity\UserInfo;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Insert;
use Zend\Debug\Debug;
use Zend\Stdlib\Hydrator\ClassMethods;

class AwardDbSqlMapper implements AwardMapperInterface {

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
    
    //added by amir
    
    public function test() {
        
        $data = 'hello world';
        
       return $data;
    }
    
    //Award
    
   
    public function getAwardList() {
//            Debug::dump($status);
//        exit;
//        echo "hello";exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT tbl_award.*, tal.id as adminid, tal.username as username FROM tbl_award 
                LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_award.modified_by OR tal.id=tbl_award.created_by ORDER BY `order_val` ASC");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Awards());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function SaveAward($awardObject) {
//                print_r($awardObject);
//                exit;
//        $awardData = $this->hydrator->extract($awardObject);
//        //print_r($educatioData);
//        //exit;
//        unset($awardData['id']); // Neither Insert nor Update needs the ID in the array
//
//        if ($awardObject->getId()) {
////            echo  "<pre>";
////            echo  "hello";exit;
//            $statement = $this->dbAdapter->query("UPDATE tbl_award 
//                SET award_name=:award_name,
//                    is_active=:is_active
//                    WHERE id=:id");
//            //Debug::dump($id);
//            //exit;
//            $parameters = array(
//                'id' => $awardObject->getId(),
//                'award_name' => $awardObject->getAwardName(),
//                'is_active' => $awardObject->getIsActive(),
//            );
//            $result = $statement->execute($parameters);
//            
//            if ($result)
//                    return "success";
//                else
//                    return "couldn't update";
//        } else {
//             $statement = $this->dbAdapter->query("INSERT INTO tbl_award 
//                 (award_name, is_active, created_date)
//                 values(:award_name, :is_active, now())");
//                 
//           
//            $parameters = array(
//                'award_name' => $awardObject->getAwardName(),
//                'is_active' => $awardObject->getIsActive(),
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
//                $awardObject->setId($newId);
//            }
//
//            //print_r($educationFieldsObject);
//            //exit;
//            
//        }
        
        if ($awardObject['id']) {
           
            $postData = array();
            $postData['award_name'] = $awardObject['award_name'];
            $postData['is_active'] = $awardObject['is_active'];
            //$postData['country_id'] = $awardObject['country_id'];
            //$postData['master_country_id'] = $awardObject['master_country_id'];            
            //$postData['image']      =  $awardObject['image'];
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['modified_by']      = $awardObject[0];
            $postData['created_by']      = $awardObject[0];
            $postData['ip']      = $awardObject[2];
            

            

            $action = new Update('tbl_award');
            $action->set($postData);
            $action->where(array('id = ?' => $awardObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } else {
            //echo  "hello";exit;
            
            $postData = array();
            
            $postData['award_name'] = $awardObject['award_name'];
            $postData['is_active'] = $awardObject['is_active'];            
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $awardObject[0];
            $postData['ip']      = $awardObject[2];
            

            

            $action = new Insert('tbl_award');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
            //case 2:
            $postData2 = array();
            $awardId = $result->getGeneratedValue();
            $postData2['order_val'] = $awardId;
            
            $action2 = new Update('tbl_award');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $awardId));
            $sql2 = new Sql($this->dbAdapter);
            $stmt2 = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt2->execute();
            
            if ($result)
                return "success";
            else
                return "couldn't update";
       }
    }
    
     public function getAward($id) {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_award WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Awards());
        }
    }
    
    public function awardSearch($data) {
//        echo   "<pre>";
//        echo  $data;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_award WHERE award_name like '" . $data . "%'");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Awards());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function performSearchAward($field) {
//        echo   "<pre>";
//        echo  $field;exit;
        $field1 = empty($field) ? "" : "award_name like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_award WHERE " . $field1 . "");
        

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
            $resultSet = new HydratingResultSet($this->hydrator, new Awards());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function getAwardRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT tbl_award.* ,tal.id as adminid, tal.username as username FROM tbl_award  LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_award.modified_by OR tal.id=tbl_award.created_by WHERE is_active=:is_active");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Awards());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }  else {
            return FALSE;
        }
    }
    
    public function viewByAwardId($table, $id) {

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
            return $this->hydrator->hydrate($result->current(), new Awards());
        }
        //print_r($result->current());exit;
//        if ($result) {
//            $respArr = array('status' => "Deleted SuccessFully");getAwardList
//        } else {
//            $respArr = array('status' => "Couldn't deleted");
//        }
//
        //return $result;
    }
    
    
    
    
    
    
    

}
