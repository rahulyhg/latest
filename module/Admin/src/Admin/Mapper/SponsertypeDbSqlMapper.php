<?php

namespace Admin\Mapper;

use Admin\Model\Entity\Sponsertypes;
//use Admin\Model\Entity\Newscategories;
//use Admin\Model\Entity\Countries;
//use Admin\Model\Entity\States;
//use Admin\Model\Entity\Cities;
//use Admin\Model\Entity\Religions;
//use Admin\Model\Entity\Gothras;
//use Admin\Model\Entity\Starsigns;
//use Admin\Model\Entity\Zodiacsigns;
//use Admin\Model\Entity\Professions;
//use Admin\Model\Entity\Designations;
//use Admin\Model\Entity\Educationlevels;
//use Application\Model\Entity\UserInfo;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Debug\Debug;
use Zend\Stdlib\Hydrator\ClassMethods;

class SponsertypeDbSqlMapper implements SponsertypeMapperInterface {

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
    
    //Sponser type
    
   
    public function getSponsertypeList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT  tbl_sponser_type_master.*,tal.id as adminid,
            tal.username as username
            FROM tbl_sponser_type_master LEFT JOIN  tbl_admin_login as tal ON tal.id=tbl_sponser_type_master.modified_by OR tal.id=tbl_sponser_type_master.created_by ORDER BY order_val ASC");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Sponsertypes());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function SaveSponsertype($sponsertypeObject) {
//                print_r($sponsertypeObject);
//                exit;
        //\Zend\Debug\Debug::dump($sponsertypeObject);exit;
//        $sponsertypeData = $this->hydrator->extract($sponsertypeObject);
//        //print_r($educatioData);
//        //exit;
//        unset($sponsertypeData['id']); // Neither Insert nor Update needs the ID in the array
//
//        if ($sponsertypeObject->getSponsTypeId()) {
////            echo  "<pre>";
////            echo  "hello";exit;
//            $statement = $this->dbAdapter->query("UPDATE tbl_sponser_type_master 
//                SET spons_type_title=:spons_type_title,
//                    is_active=:is_active
//                    WHERE spons_type_id=:spons_type_id");
//            //Debug::dump($id);
//            //exit;
//            $parameters = array(
//                'spons_type_id' => $sponsertypeObject->getSponsTypeId(),
//                'spons_type_title' => $sponsertypeObject->getSponsTypeTitle(),
//                'is_active' => $sponsertypeObject->getIsActive(),
//            );
//            $result = $statement->execute($parameters);
//            
//            if ($result)
//                    return "success";
//                else
//                    return "couldn't update";
//        } else {
//             $statement = $this->dbAdapter->query("INSERT INTO tbl_sponser_type_master 
//                 (spons_type_title, is_active, created_date)
//                 values(:spons_type_title, :is_active, now())");
//                 
//           
//            $parameters = array(
//                'spons_type_title' => $sponsertypeObject->getSponsTypeTitle(),
//                'is_active' => $sponsertypeObject->getIsActive(),
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
//                $sponsertypeObject->setId($newId);
//            }
//
//            //print_r($educationFieldsObject);
//            //exit;
//            
//        }
        
         if ($sponsertypeObject['spons_type_id']) {
           
            $postData = array();
            $postData['spons_type_title'] = $sponsertypeObject['spons_type_title'];
            $postData['is_active'] = $sponsertypeObject['is_active'];
            //$postData['country_id'] = $sponsertypeObject['country_id'];
            //$postData['master_country_id'] = $sponsertypeObject['master_country_id'];            
            //$postData['image']      =  $sponsertypeObject['image'];
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['modified_by']      = $sponsertypeObject[0];
            $postData['created_by']      = $sponsertypeObject[0];
            $postData['ip']      = $sponsertypeObject[2];
            

            

            $action = new Update('tbl_sponser_type_master');
            $action->set($postData);
            $action->where(array('spons_type_id = ?' => $sponsertypeObject['spons_type_id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } else {

            
            $postData = array();
            $postData['spons_type_title'] = $sponsertypeObject['spons_type_title'];
            $postData['is_active'] = $sponsertypeObject['is_active'];
            //$postData['country_id'] = $sponsertypeObject['country_id'];
            //$postData['master_country_id'] = $sponsertypeObject['master_country_id'];            
            //$postData['image']      =  $sponsertypeObject['image'];
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $sponsertypeObject[0];
            $postData['ip']      = $sponsertypeObject[2];
            

            

            $action = new Insert('tbl_sponser_type_master');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
            //case 2:
            $postData2 = array();
            $sponsertypeId = $result->getGeneratedValue();
            $postData2['order_val'] = $sponsertypeId;
            
            $action2 = new Update('tbl_sponser_type_master');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $sponsertypeId));
            $sql2 = new Sql($this->dbAdapter);
            $stmt2 = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt2->execute();
            
            if ($result)
                return "success";
            else
                return "couldn't update";
       }
    }
    
     public function getSponsertype($id) {
//         echo  $id;die;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_sponser_type_master WHERE spons_type_id=:spons_type_id");
        $parameters = array(
            'spons_type_id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Sponsertypes());
        }
    }
    
    public function sponsertypeSearch($data) {
//        echo   "<pre>";
//        echo  $data;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_sponser_type_master WHERE spons_type_title like '" . $data . "%'");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Sponsertypes());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function performSearchSponsertype($field) {
//        echo   "<pre>";
//        echo  $field;exit;
        $field1 = empty($field) ? "" : "spons_type_title like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_sponser_type_master WHERE " . $field1 . "");
        

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
            $resultSet = new HydratingResultSet($this->hydrator, new Sponsertypes());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function getSponsertypeRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT tbl_sponser_type_master.* ,tal.id as adminid, tal.username as username FROM tbl_sponser_type_master  LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_sponser_type_master.modified_by OR tal.id=tbl_sponser_type_master.created_by WHERE is_active=:is_active");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Sponsertypes());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }  else {
            return FALSE;
        }
    }
    
    public function viewBySponsertypeId($table, $id) {

        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM $table WHERE spons_type_id=:spons_type_id");
        //$adapter->query('SELECT * FROM `artist` WHERE `id` = ?', array(5));

        $parameters = array(
            'spons_type_id' => $id,
        );
        //print_r($statement);
        ///exit;
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Sponsertypes());
        }
        //print_r($result->current());exit;
//        if ($result) {
//            $respArr = array('status' => "Deleted SuccessFully");getReligionList
//        } else {
//            $respArr = array('status' => "Couldn't deleted");
//        }
//
        //return $result;
    }
    
    public function changeStatus($table, $id, $data, $modified_by) {
        
        //echo  $data;exit;
        
//        Debug::dump($id);
//        exit;
        $statement = $this->dbAdapter->query("UPDATE $table SET is_active=:is_active, modified_by=:modified_by, created_by=:created_by, modified_date=:modified_date WHERE spons_type_id=:spons_type_id");
        
        $parameters = array(
            'spons_type_id' => $id,
            'is_active' => $data,
            'created_by' => $modified_by,
            'modified_by' => $modified_by,
            'modified_date' => date("Y-m-d h:i:s"),
        );
        $result = $statement->execute($parameters);

        if ($result) {
            $respArr = array('status' => "Updated SuccessFully");
        } else {
            $respArr = array('status' => "Couldn't update");
        }

        return $respArr;
    }
    
    public function delete($table, $id) {
//        echo  "<pre>";
//        print_r($id);exit;
        $statement = $this->dbAdapter->query("DELETE FROM $table where spons_type_id=:spons_type_id");
        //Debug::dump($statement);exit;
        $parameters = array(
            'spons_type_id' => $id
        );
        $result = $statement->execute($parameters);

//        if ($result) {
//            $respArr = array('status' => "Deleted SuccessFully");
//        } else {
//            $respArr = array('status' => "Couldn't deleted");
//        }
//
//        return $respArr;
    }
    
    public function changeStatusAll($table, $ids, $data) {
//        print_r(explode(",",$ids));
//        exit;
        $ids = $this->dbAdapter->getPlatform()->quoteValueList(explode(",", $ids));
        //$placeholder=  str_repeat('?, ', count(explode(",",$ids))-1).'?';
        //echo $placeholder;
        //exit;
        $statement = $this->dbAdapter->query("UPDATE $table set is_active=:is_active where spons_type_id IN ($ids)");
        //print_r($statement);
        //exit;
        $parameters = array(
            //'ids' => $ids,
            'is_active' => $data
        );
        //Debug::dump($statement);
        //exit;
        $result = $statement->execute($parameters);

        if ($result) {
            $respArr = array('status' => "Updated SuccessFully");
        } else {
            $respArr = array('status' => "Couldn't update");
        }

        return $respArr;
    }
    
    public function deleteMultiple($table, $ids) {
//        echo   "<pre>";
//        print_r($ids);exit;
        $ids = $this->dbAdapter->getPlatform()->quoteValueList(explode(",", $ids));
        $statement = $this->dbAdapter->query("DELETE FROM $table where spons_type_id IN($ids)");

//        $parameters = array(
//            'ids' => $ids,
//        );
        $result = $statement->execute();
    }
   
    
    
    
    

}
