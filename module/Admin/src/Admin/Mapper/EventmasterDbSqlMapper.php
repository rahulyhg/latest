<?php

namespace Admin\Mapper;

use Admin\Model\Entity\Eventmasters;
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
use Zend\Debug\Debug;
use Zend\Stdlib\Hydrator\ClassMethods;

class EventmasterDbSqlMapper implements EventmasterMapperInterface {

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
    
    
    //Eventmaster
    
        
   
    public function getEventmasterList($status) {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_event");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Eventmasters());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function SaveEventmaster($eventmasterObject) {
//                print_r($eventmasterObject);
//                exit;
        $eventmasterData = $this->hydrator->extract($eventmasterObject);
        //print_r($educatioData);
        //exit;
        unset($eventmasterData['id']); // Neither Insert nor Update needs the ID in the array

        if ($eventmasterObject->getId()) {
//            echo  "<pre>";
//            echo  "hello";exit;
            $statement = $this->dbAdapter->query("UPDATE tbl_event 
                SET event_name=:event_name,
                    is_active=:is_active
                    WHERE id=:id");
            //Debug::dump($id);
            //exit;
            $parameters = array(
                'id' => $eventmasterObject->getId(),
                'event_name' => $eventmasterObject->getEventName(),
                'is_active' => $eventmasterObject->getIsActive(),
            );
            $result = $statement->execute($parameters);
            
            if ($result)
                    return "success";
                else
                    return "couldn't update";
        } else {
             $statement = $this->dbAdapter->query("INSERT INTO tbl_event 
                 (event_name, is_active, created_date)
                 values(:event_name, :is_active, now())");
                 
           
            $parameters = array(
                'event_name' => $eventmasterObject->getEventName(),
                'is_active' => $eventmasterObject->getIsActive(),
            );
            //print_r($parameters);
            //exit;
            $result = $statement->execute($parameters);
            
            //if ($result) 
           if ($result)
                return "success";
            else
                return "couldn't update";

        //return $respArr;
        }

        if ($result instanceof ResultInterface) {
            if ($newId = $result->getGeneratedValue()) {
                // When a value has been generated, set it on the object
                $eventmasterObject->setId($newId);
            }

            //print_r($educationFieldsObject);
            //exit;
            
        }
    }
    
     public function getEventmaster($id) {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_event WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Eventmasters());
        }
    }
    
    public function eventmasterSearch($data) {
//        echo   "<pre>";
//        echo  $data;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_event WHERE event_name like '" . $data . "%'");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Eventmasters());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function performSearchEventmaster($field) {
//        echo   "<pre>";
//        echo  $field;exit;
        $field1 = empty($field) ? "" : "event_name like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_event WHERE " . $field1 . "");
        

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
            $resultSet = new HydratingResultSet($this->hydrator, new Eventmasters());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function getEventmasterRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_event  WHERE is_active=:is_active");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Eventmasters());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function viewByEventmasterId($table, $id) {

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
            return $this->hydrator->hydrate($result->current(), new Eventmasters());
        }
        //print_r($result->current());exit;
//        if ($result) {
//            $respArr = array('status' => "Deleted SuccessFully");getEventmasterList
//        } else {
//            $respArr = array('status' => "Couldn't deleted");
//        }
//
        //return $result;
    }
    
    
    
    
    
    
    

}
