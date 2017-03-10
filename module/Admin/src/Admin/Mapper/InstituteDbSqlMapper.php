<?php

namespace Admin\Mapper;

use Admin\Model\Entity\Institutes;
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

class InstituteDbSqlMapper implements InstituteMapperInterface {      

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
    
//    public function test() {
//        $data = "hello amir";
//        return   $data;
//    }
    
   
    
    //Institute
    
   
    public function getInstituteList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
//        $statement = $this->dbAdapter->query("SELECT tbl_rustagi_institutions.*, tal.id as adminid, tal.username as username FROM tbl_rustagi_institutions 
//                LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_rustagi_institutions.modified_by OR tal.id=tbl_rustagi_institutions.created_by ORDER BY `order_val` ASC");
        
                $statement = $this->dbAdapter->query("SELECT tbl_rustagi_institutions.*, tbl_country.country_name,tbl_state.state_name, tbl_city.city_name ,tal.id as adminid, tal.username as username FROM tbl_rustagi_institutions 
                    LEFT JOIN tbl_city  ON tbl_city.id=tbl_rustagi_institutions.city LEFT JOIN tbl_state  ON tbl_state.id=tbl_rustagi_institutions.state
                    LEFT JOIN tbl_country  ON tbl_country.id=tbl_rustagi_institutions.country LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_rustagi_institutions.modified_by OR tal.id=tbl_rustagi_institutions.created_by ORDER BY `order_val` ASC");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Institutes());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function SaveInstitute($instituteObject) {
//                print_r($instituteObject);
//                exit;
//        $instituteData = $this->hydrator->extract($instituteObject);
//        //print_r($educatioData);
//        //exit;
//        unset($instituteData['id']); // Neither Insert nor Update needs the ID in the array
//
//        if ($instituteObject->getId()) {
////            echo  "<pre>";
////            echo  "hello";exit;
//            $statement = $this->dbAdapter->query("UPDATE tbl_rustagi_institutions 
//                SET institute_name=:institute_name,
//                    is_active=:is_active
//                    WHERE id=:id");
//            //Debug::dump($id);
//            //exit;
//            $parameters = array(
//                'id' => $instituteObject->getId(),
//                'institute_name' => $instituteObject->getInstituteName(),
//                'is_active' => $instituteObject->getIsActive(),
//            );
//            $result = $statement->execute($parameters);
//            
//            if ($result)
//                    return "success";
//                else
//                    return "couldn't update";
//        } else {
//             $statement = $this->dbAdapter->query("INSERT INTO tbl_rustagi_institutions 
//                 (institute_name, is_active, created_date)
//                 values(:institute_name, :is_active, now())");
//                 
//           
//            $parameters = array(
//                'institute_name' => $instituteObject->getInstituteName(),
//                'is_active' => $instituteObject->getIsActive(),
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
//                $instituteObject->setId($newId);
//            }
//
//            //print_r($educationFieldsObject);
//            //exit;
//            
//        }
        if ($instituteObject['id']) {
           
            $postData = array();
            $postData['institute_name'] = $instituteObject['institute_name'];
            $postData['operated_by'] = $instituteObject['operated_by'];
            $postData['institute_address'] = $instituteObject['institute_address'];
            $postData['institute_type'] = $instituteObject['institute_type'];
            $postData['purpose'] = $instituteObject['purpose'];
            $postData['country'] = $instituteObject['country'];
            $postData['state'] = $instituteObject['state'];
            $postData['city'] = $instituteObject['city'];
            $postData['is_active'] = $instituteObject['is_active'];
            //$postData['country_id'] = $instituteObject['country_id'];
            //$postData['master_country_id'] = $instituteObject['master_country_id'];            
            //$postData['image']      =  $instituteObject['image'];
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['modified_by']      = $instituteObject[0];
            $postData['created_by']      = $instituteObject[0];
            $postData['ip']      = $instituteObject[2];
            

            

            $action = new Update('tbl_rustagi_institutions');
            $action->set($postData);
            $action->where(array('id = ?' => $instituteObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } else {

            
            $postData = array();
            $postData['institute_name'] = $instituteObject['institute_name'];
            $postData['operated_by'] = $instituteObject['operated_by'];
            $postData['institute_address'] = $instituteObject['institute_address'];
            $postData['institute_type'] = $instituteObject['institute_type'];
            $postData['purpose'] = $instituteObject['purpose'];
            $postData['country'] = $instituteObject['country'];
            $postData['state'] = $instituteObject['state'];
            $postData['city'] = $instituteObject['city'];
            $postData['is_active'] = $instituteObject['is_active'];
            //$postData['country_id'] = $instituteObject['country_id'];
            //$postData['master_country_id'] = $instituteObject['master_country_id'];            
            //$postData['image']      =  $instituteObject['image'];
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $instituteObject[0];
            $postData['ip']      = $instituteObject[2];
            

            

            $action = new Insert('tbl_rustagi_institutions');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
            $institutionsId = $result->getGeneratedValue();
            
            //case 2:
            $postData2 = array();
            $institutionsId = $result->getGeneratedValue();
            $postData2['order_val'] = $institutionsId;
            
            $action2 = new Update('tbl_rustagi_institutions');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $institutionsId));
            $sql2 = new Sql($this->dbAdapter);
            $stmt2 = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt2->execute();
            
            //for sponser organizer
             $postData3 = array();
            $size2 = count($instituteObject['member_id']);
//            echo $size;exit;
            //$eventId = $this->tableGateway->lastInsertValue;
            //$eventId = $this->tableGateway->adapter->getDriver()->getLastGeneratedValue();
            
            //echo  $eventId;exit;
            for($i=0;$i<$size2;$i++){
            $postData3['institute_id']           = $institutionsId;
            $postData3['member_id']           = $instituteObject['member_id'][$i];            
            
            //$postData3['subevent_id']        = 0;
            //$postData3['created_date']       = date("Y-m-d h:i:s");
            //$postData3['ip']                 = $instituteObject[2];
            
            $action3 = new Insert('tbl_rustagi_institutions_members');
            $action3->values($postData3);
            //$action->set($postData);
            //$action->where(array('spons_id = ?' => $sponsermasterObject['spons_id']));
            $sql3 = new Sql($this->dbAdapter);
            $stmt = $sql3->prepareStatementForSqlObject($action3);
            $result = $stmt->execute();
            
            
       }
       if ($result)
                return "success";
            else
                return "couldn't update";
       
        }
        
    }
    
     public function getInstitute($id) {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_rustagi_institutions WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Institutes());
        }
    }
    
    public function instituteSearch($data) {
//        echo   "<pre>";
//        echo  $data;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_rustagi_institutions WHERE institute_name like '" . $data . "%'");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Institutes());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function performSearchInstitute($field) {
//        echo   "<pre>";
//        echo  $field;exit;
        $field1 = empty($field) ? "" : "institute_name like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_rustagi_institutions WHERE " . $field1 . "");
        

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
            $resultSet = new HydratingResultSet($this->hydrator, new Institutes());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function getInstituteByInstituteId($table, $id) {

        //echo $id;exit;
        //$statement = $this->dbAdapter->query("SELECT * FROM $table WHERE branch_id=:branch_id");
        $statement = $this->dbAdapter->query("SELECT tbl_rustagi_institutions.*, tbl_city.city_name,tbl_state.state_name,tbl_country.country_name, tal.id as adminid, tal.username as username 
                                            FROM tbl_rustagi_institutions left join tbl_city on tbl_rustagi_institutions.city=tbl_city.id left join tbl_state on tbl_state.id=tbl_city.state_id 
                                                left join tbl_country on tbl_country.id=tbl_state.country_id LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_rustagi_institutions.modified_by 
                                                OR tal.id=tbl_rustagi_institutions.created_by  where
tbl_rustagi_institutions.id=:id  ORDER BY `order_val` ASC;");
        
        
        //$adapter->query('SELECT * FROM `artist` WHERE `id` = ?', array(5));

        $parameters = array(
            'id' => $id,
        );
        //print_r($statement);
        ///exit;
        $result = $statement->execute($parameters);
//        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
//            return $this->hydrator->hydrate($result->current(), new Branchs());
//        }
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Institutes());

            return $resultSet->initialize($result)->toArray();
           
        }
        //print_r($result->current());exit;
//        if ($result) {
//            $respArr = array('status' => "Deleted SuccessFully");getBranchList
//        } else {
//            $respArr = array('status' => "Couldn't deleted");
//        }
//
        //return $result;
    }
    
    public function getInstituteByInstituteCityId($table, $id) {

        //echo $id;exit;
        //$statement = $this->dbAdapter->query("SELECT * FROM $table WHERE branch_id=:branch_id");
        $statement = $this->dbAdapter->query("SELECT tbl_rustagi_institutions.*, tbl_city.city_name,tbl_state.state_name,tbl_country.country_name, tal.id as adminid, tal.username as username 
                                            FROM tbl_rustagi_institutions left join tbl_city on tbl_rustagi_institutions.city=tbl_city.id left join tbl_state on tbl_state.id=tbl_city.state_id 
                                                left join tbl_country on tbl_country.id=tbl_state.country_id LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_rustagi_institutions.modified_by 
                                                OR tal.id=tbl_rustagi_institutions.created_by  where
tbl_rustagi_institutions.city=:city  ORDER BY `order_val` ASC;");
        
        
        //$adapter->query('SELECT * FROM `artist` WHERE `id` = ?', array(5));

        $parameters = array(
            'city' => $id,
        );
        //print_r($statement);
        ///exit;
        $result = $statement->execute($parameters);
//        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
//            return $this->hydrator->hydrate($result->current(), new Branchs());
//        }
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Institutes());

            return $resultSet->initialize($result)->toArray();
           
        }
        //print_r($result->current());exit;
//        if ($result) {
//            $respArr = array('status' => "Deleted SuccessFully");getBranchList
//        } else {
//            $respArr = array('status' => "Couldn't deleted");
//        }
//
        //return $result;
    }
    
    public function getInstituteRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT tbl_rustagi_institutions.*, tbl_country.country_name,tbl_state.state_name, tbl_city.city_name ,tal.id as adminid, tal.username as username FROM tbl_rustagi_institutions 
                    LEFT JOIN tbl_city  ON tbl_city.id=tbl_rustagi_institutions.city LEFT JOIN tbl_state  ON tbl_state.id=tbl_rustagi_institutions.state
                    LEFT JOIN tbl_country  ON tbl_country.id=tbl_rustagi_institutions.country LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_rustagi_institutions.modified_by OR tal.id=tbl_rustagi_institutions.created_by   WHERE tbl_rustagi_institutions.is_active=:is_active ORDER BY `order_val` ASC");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Institutes());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }  else {
            return FALSE;
        }
    }
    
    public function viewByInstituteId($table, $id) {

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
            return $this->hydrator->hydrate($result->current(), new Institutes());
        }
        //print_r($result->current());exit;
//        if ($result) {
//            $respArr = array('status' => "Deleted SuccessFully");getInstituteList
//        } else {
//            $respArr = array('status' => "Couldn't deleted");
//        }
//
        //return $result;
    }
    
    public function getInstituteListByCityCode($City_ID) {
//            echo  "<pre>";
//            print_r($Country_ID);
//            exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_rustagi_institutions 
                WHERE city = :city");
        $parameters = array(
            'city' => $City_ID,
        );
                    
        $result = $statement->execute($parameters);
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Institutes());

            return $resultSet->initialize($result)->toArray();
           
        }
    }
    
    public function getallMember() {
        
        $statement = $this->dbAdapter->query("SELECT tbl_user.id as member_id,tbl_user_info.full_name FROM tbl_user LEFT JOIN tbl_user_info ON tbl_user.id=tbl_user_info.user_id AND 

tbl_user.user_type_id=tbl_user_info.user_type_id WHERE  tbl_user.user_type_id=1 AND tbl_user_info.user_type_id=1");
        
        
        
        $result = $statement->execute();
        
        foreach ($result as $list) {
            $memberlist[$list['member_id']] = $list['full_name'];
        }
        
        return $memberlist;
        

    }
   
    
    
    
    
    
    

}
