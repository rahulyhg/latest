<?php

namespace Admin\Mapper;

use Admin\Model\Entity\EducationFields;
use Admin\Model\Entity\Countries;
use Admin\Model\Entity\States;
use Admin\Model\Entity\Cities;
use Admin\Model\Entity\Religions;
use Admin\Model\Entity\Gothras;
use Admin\Model\Entity\Starsigns;
use Admin\Model\Entity\Zodiacsigns;
use Admin\Model\Entity\Professions;
use Admin\Model\Entity\Designations;
use Admin\Model\Entity\Educationlevels;
use Admin\Model\Entity\Memberdashboards;
use Admin\Model\Entity\Matrimonialdashboards;
use Admin\Model\Entity\Userinfo;
//use Application\Model\Entity\UserInfo;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
//use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Insert;
//use Zend\Db\Sql\Sql;
//use Zend\Db\Sql\Update;
use Zend\Debug\Debug;
use Zend\Stdlib\Hydrator\ClassMethods;

class AdminDbSqlMapper implements AdminMapperInterface {

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
    
    public function getEducationField($id) {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }

    public function getEducationFieldList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT tbl_education_field.*, tal.id as adminid, tal.username as username FROM tbl_education_field 
                LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_education_field.modified_by OR tal.id=tbl_education_field.created_by ORDER BY `order_val` ASC");
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
            $resultSet = new HydratingResultSet($this->hydrator, new EducationFields());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }

    //added by amir
    public function getEducationFieldRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT tbl_education_field.* ,tal.id as adminid, tal.username as username FROM tbl_education_field  LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_education_field.modified_by OR tal.id=tbl_education_field.created_by WHERE is_active=:is_active");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new EducationFields());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }  else {
            return FALSE;
        }
    }

    public function saveEducationField($educationFieldsObject) {
//                print_r($educationFieldsObject);
//                exit;
//        $educatioData = $this->hydrator->extract($educationFieldsObject);
//        //print_r($educatioData);
//        //exit;
//        unset($educatioData['id']); // Neither Insert nor Update needs the ID in the array
//
//        if ($educationFieldsObject->getId()) {
////            echo  "<pre>";
////            echo  "hello";exit;
//            $statement = $this->dbAdapter->query("UPDATE tbl_education_field 
//                SET education_field=:education_field,
//                    is_active=:is_active
//                    WHERE id=:id");
//            //Debug::dump($id);
//            //exit;
//            $parameters = array(
//                'id' => $educationFieldsObject->getId(),
//                'education_field' => $educationFieldsObject->getEducationField(),
//                'is_active' => $educationFieldsObject->getIsActive(),
//            );
//            $result = $statement->execute($parameters);
//            
//            if ($result)
//                    return "success";
//                else
//                    return "couldn't update";
//        } else {
//             $statement = $this->dbAdapter->query("INSERT INTO tbl_education_field 
//                 (education_field, is_active, created_date)
//                 values(:education_field, :is_active, now())");
//                 
//           
//            $parameters = array(
//                'education_field' => $educationFieldsObject->getEducationField(),
//                'is_active' => $educationFieldsObject->getIsActive(),
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
//                $educationFieldsObject->setId($newId);
//            }
//
//            //print_r($educationFieldsObject);
//            //exit;
//            
//        }
        
        if ($educationFieldsObject['id']) {
           
            $postData = array();
            $postData['education_field'] = $educationFieldsObject['education_field'];
            $postData['is_active'] = $educationFieldsObject['is_active'];
            //$postData['country_id'] = $educationFieldsObject['country_id'];
            //$postData['master_country_id'] = $educationFieldsObject['master_country_id'];            
            //$postData['image']      =  $educationFieldsObject['image'];
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['modified_by']      = $educationFieldsObject[0];
            $postData['created_by']      = $educationFieldsObject[0];
            $postData['ip']      = $educationFieldsObject[2];
            

            

            $action = new Update('tbl_education_field');
            $action->set($postData);
            $action->where(array('id = ?' => $educationFieldsObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } else {

            
            $postData = array();
            $postData['education_field'] = $educationFieldsObject['education_field'];
            $postData['is_active'] = $educationFieldsObject['is_active'];
            //$postData['country_id'] = $educationFieldsObject['country_id'];
            //$postData['master_country_id'] = $educationFieldsObject['master_country_id'];            
            //$postData['image']      =  $educationFieldsObject['image'];
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $educationFieldsObject[0];
            $postData['ip']      = $educationFieldsObject[2];
            

            

            $action = new Insert('tbl_education_field');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
            //case 2:
            $postData2 = array();
            $educationfieldId = $result->getGeneratedValue();
            $postData2['order_val'] = $educationfieldId;
            
            $action2 = new Update('tbl_education_field');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $educationfieldId));
            $sql2 = new Sql($this->dbAdapter);
            $stmt2 = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt2->execute();
            
            if ($result)
                return "success";
            else
                return "couldn't update";
       }
    }

    public function changeStatus($table, $id, $data, $modified_by) {
        $statement = $this->dbAdapter->query("UPDATE $table SET is_active=:is_active, modified_by=:modified_by, created_by=:created_by, modified_date=:modified_date WHERE id=:id");
//        Debug::dump($modified_by);
//        exit;
        $parameters = array(
            'id' => $id,
            'is_active' => $data['is_active'],
            'modified_by' => $modified_by,
            'created_by' => $modified_by,
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

    public function changeStatusAll($table, $ids, $data) {
//        echo  "<pre>";
//        print_r($ids);exit;
//        print_r(explode(",",$ids));
//        exit;
        $ids = $this->dbAdapter->getPlatform()->quoteValueList(explode(",", $ids));
        //$placeholder=  str_repeat('?, ', count(explode(",",$ids))-1).'?';
        //echo $placeholder;
        //exit;
        $statement = $this->dbAdapter->query("UPDATE $table set is_active=:is_active where id IN ($ids)");
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

    public function delete($table, $id) {
//        echo  "<pre>";
//        print_r($id);exit;
        $statement = $this->dbAdapter->query("DELETE FROM $table where id=:id");
        //Debug::dump($statement);exit;
        $parameters = array(
            'id' => $id
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

    public function deleteMultiple($table, $ids) {
//        echo   "<pre>";
//        print_r($ids);exit;
        $ids = $this->dbAdapter->getPlatform()->quoteValueList(explode(",", $ids));
        $statement = $this->dbAdapter->query("DELETE FROM $table where id IN($ids)");

//        $parameters = array(
//            'ids' => $ids,
//        );
        $result = $statement->execute();
    }

    public function viewById($table, $id) {

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
            return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
        //print_r($result->current());exit;
//        if ($result) {
//            $respArr = array('status' => "Deleted SuccessFully");
//        } else {
//            $respArr = array('status' => "Couldn't deleted");
//        }
//
        //return $result;
    }
    
    
    public function performSearchEducationField($field) {
//        echo   "<pre>";
//        echo  $field;exit;
        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field WHERE " . $field1 . "");
        

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
            $resultSet = new HydratingResultSet($this->hydrator, new EducationFields());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function educationFieldSearch($data) {
//        echo   "<pre>";
//        echo  $data;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field WHERE education_field like '" . $data . "%'");
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
            $resultSet = new HydratingResultSet($this->hydrator, new EducationFields());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    //country sql method
    
    
    public function getCountriesList() {
//            Debug::dump($status);
//        exit;
//        echo   "<pre>";echo  "hello3";exit;
        //if(isset($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_country ORDER BY `order_val` ASC");
        $statement = $this->dbAdapter->query("SELECT tbl_country.*,tal.id as adminid,
            tal.username as username
            FROM tbl_country 
                
                LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_country.modified_by OR tal.id=tbl_country.created_by
                 ORDER BY order_val ASC;");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Countries());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    
    public function getCountryRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT tbl_country.*, tal.id as adminid, tal.username as username  FROM tbl_country LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_country.modified_by OR tal.id=tbl_country.created_by  WHERE is_active=:is_active");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Countries());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }else{
            return FALSE;
        }
    }
    
    
    public function viewByCountryId($table, $id) {

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
            return $this->hydrator->hydrate($result->current(), new Countries());
        }
        
    }
    
    public function saveCountry($countryObject) {
//        \Zend\Debug\Debug::dump($countryObject);exit;
//        echo  "<pre>";
//        print_r($countryObject);
//                exit;
        //$countryData = $this->hydrator->extract($countryObject);
        //print_r($educatioData);
        //exit;
       // unset($countryData['id']); // Neither Insert nor Update needs the ID in the array

        
        if (empty($countryObject['country_name'])) {
            
            return "Insert same country name below then edit";
            
        }
        
        if ($countryObject['id'] && isset($countryObject['country_name'])) {
//            echo  "<pre>";
//            echo  "hello";exit;
//            $statement = $this->dbAdapter->query("UPDATE tbl_country 
//                SET country_name=:country_name,
//                    dial_code=:dial_code,
//                    country_code=:country_code,
//                    master_country_id=:master_country_id
//                    WHERE id=:id");
//            //Debug::dump($id);
//            //exit;
//            $parameters = array(
//                'id' => $countryObject->getId(),
//                'country_name' => $countryObject->getCountryName(),
//                'dial_code' => $countryObject->getDialCode(),
//                'country_code' => $countryObject->getCountryCode(),
//                'master_country_id' => $countryObject->getMasterCountryId()
//                //'is_active' => $educationFieldsObject->getIsActive(),
//            );
//            $result = $statement->execute($parameters);
//            
//            if ($result)
//                    return "success";
//                else
//                    return "couldn't update";
            $postData = array();
            $postData['country_name'] = $countryObject['country_name'];
            $postData['currency'] = $countryObject['currency'];
            $postData['region_id'] = $countryObject['region_id'];
            $postData['dial_code'] = $countryObject['dial_code'];
            $postData['country_code'] = $countryObject['country_code'];
            $postData['master_country_id'] = $countryObject['master_country_id'];            
            //$postData['image']      =  $newsObject['image'];
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['modified_by']      = $countryObject[0];
            $postData['created_by']      = $countryObject[0];
            $postData['ip']      = $countryObject[2];
            
//            echo "<pre>";
//            print_r($postData['image']);exit;
            

            $action = new Update('tbl_country');
            $action->set($postData);
            $action->where(array('id = ?' => $countryObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } else {
//             $statement = $this->dbAdapter->query("INSERT INTO tbl_country 
//                 (country_name, is_active, dial_code, country_code, master_country_id,  created_by, ip, created_date)
//                 values(:country_name, 0, :dial_code, :country_code, :master_country_id, :created_by, :ip, now())");
//                 
//           
//            $parameters = array(
//                'country_name' => $countryObject['country_name'],
//                //'is_active' => $countryObject->getIsActive(),
//                'dial_code' => $countryObject['dial_code'],
//                'country_code' => $countryObject['country_code'],
//                'master_country_id' => $countryObject['master_country_id'],
//                'created_by' => $countryObject[0],
//                'ip' => $countryObject[2],
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
//                $educationFieldsObject->setId($newId);
//            }
//
//            //print_r($educationFieldsObject);
//            //exit;
//            
            $postData = array();
            $postData['country_name'] = $countryObject['country_name'];
            $postData['currency'] = $countryObject['currency'];
            $postData['region_id'] = $countryObject['region_id'];
            $postData['dial_code'] = $countryObject['dial_code'];
            $postData['country_code'] = $countryObject['country_code'];
            $postData['master_country_id'] = $countryObject['master_country_id'];            
            //$postData['image']      =  $newsObject['image'];
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $countryObject[0];
            $postData['ip']      = $countryObject[2];
            
//            echo "<pre>";
//            print_r($postData['image']);exit;
            

            $action = new Insert('tbl_country');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
//            case 2:
            $postData2 = array();
            $countryId = $result->getGeneratedValue();
            $postData2['order_val'] = $countryId;
            
            $action2 = new Update('tbl_country');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $countryId));
            $sql2 = new Sql($this->dbAdapter);
            $stmt2 = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt2->execute();
            
            if ($result)
                return "success";
            else
                return "couldn't update";
       }
    }
    
    
    public function getCountry($id) {
        //echo   "<pre>";echo  $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_country WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Countries());
        }
    }
    
    
    public function performSearchCountry($field,$field2,$field3) {
//        echo   "<pre>";
//        echo  $field3;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $field1 = empty($field) ? "" : "country_name like '" . $field . "%' &&";
        $field4 = empty($field2) ? "" : "country_code like '" . $field2 . "%' &&";
        $field5 = empty($field3) ? "" : "dial_code like '" . $field3 . "%' ";
        
        $sql = "select * from tbl_country where " . $field1 . $field4 . $field5 . "";
        $sql = rtrim($sql, "&&");
        
        $statement = $this->dbAdapter->query($sql);
        

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
            $resultSet = new HydratingResultSet($this->hydrator, new Countries());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function countrySearch($data) {
//        echo   "<pre>";
//        echo  $data;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_country WHERE country_name like '" . $data . "%'");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Countries());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function getAllRegion() {
        
        $statement = $this->dbAdapter->query("SELECT id,region_name FROM tbl_region WHERE 1");
        
        $result = $statement->execute();
        
        foreach ($result as $list) {
            $regionnamelist[$list['id']] = $list['region_name'];
        }
        
//        Debug::dump($regionnamelist);
//        exit;
        
        return $regionnamelist;
        

    }
    
    public function getCountryList() {
        
        $statement = $this->dbAdapter->query("SELECT id,country_name FROM tbl_country WHERE 1");
        
        $result = $statement->execute();
        
        foreach ($result as $list) {
            $countrynamelist[$list['id']] = $list['country_name'];
        }
        
//        Debug::dump($countrynamelist);
//        exit;
        
        return $countrynamelist;
        

    }
    
    public function getStateList() {
        
        $statement = $this->dbAdapter->query("SELECT id,state_name FROM tbl_state WHERE 1");
        
        $result = $statement->execute();
        
        foreach ($result as $list) {
            $statenamelist[$list['id']] = $list['state_name'];
        }
        
//        Debug::dump($statenamelist);
//        exit;
        
        return $statenamelist;
        

    }
    
    public function getCityList() {
        
        $statement = $this->dbAdapter->query("SELECT id,city_name FROM tbl_city WHERE 1");
        
        $result = $statement->execute();
        
        foreach ($result as $list) {
            $citynamelist[$list['id']] = $list['city_name'];
        }
        
//        Debug::dump($citynamelist);
//        exit;
        
        return $citynamelist;
        

    }
    
    //state sql
    
    public function getStatesList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT tbl_state.*, tbl_country.country_name AS country_name ,tal.id as adminid, tal.username as username
            FROM tbl_state INNER JOIN tbl_country ON tbl_state.country_id = tbl_country.id LEFT JOIN tbl_admin_login as tal ON 
            tal.id=tbl_state.modified_by OR tal.id=tbl_state.created_by ORDER BY `order_val` ASC");
        
        
//        SELECT tbl_country.*,tal.id as adminid,
//            tal.username as username
//            FROM tbl_country 
//                
//                LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_country.modified_by OR tal.id=tbl_country.created_by
//                 ORDER BY order_val ASC
        
                    
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
            $resultSet = new HydratingResultSet($this->hydrator, new States());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function customFields() {
        //echo   "<pre>";echo  "hello";exit;
//        $countryName = $this->tableGateway->select(function(Select $select) use($columns) {
//                    $select->order('id ASC');
//                    $select->columns($columns);
//                })->toArray();
//
//        foreach ($countryName as $list) {
//            $countrynamelist[$list['id']] = $list['country_name'];
//        }
        // print_r($countrynamelist);die;
//        return $countrynamelist;
        //
        $statement = $this->dbAdapter->query("SELECT id,country_name FROM tbl_country WHERE 1");
        
        $result = $statement->execute();
        
        foreach ($result as $list) {
            $countrynamelist[$list['id']] = $list['country_name'];
        }
        // print_r($countrynamelist);die;
        return $countrynamelist;
        
//        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
//            $resultSet = new HydratingResultSet($this->hydrator, new States());
//
//            return $resultSet->initialize($result);
//            //return $this->hydrator->hydrate($result->current(), new EducationFields());
//        }
    }
    
    
    public function performSearchState($field,$field2) {
//        echo   "<pre>";
//        echo  $field2;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
//        $field1 = empty($field) ? "" : "country_name like '" . $field . "%' &&";
//        $field4 = empty($field2) ? "" : "country_code like '" . $field2 . "%' &&";
//        $field5 = empty($field3) ? "" : "dial_code like '" . $field3 . "%' ";
        $field3 = empty($field)? "": "tbl_state.country_id= '".$field."' &&";   
        $field4 = empty($field2)? "": " tbl_state.state_name like '".$field2."%' "; 
        
//        $sql = "select * from tbl_country where " . $field1 . $field4 . $field5 . "";
        
        $sql = "select tbl_state.*,tbl_country.country_name AS country_name from tbl_state inner join 
             tbl_country on tbl_state.country_id = tbl_country.id 
         where ".$field3.$field4."";
        $sql = rtrim($sql, "&&");
//        echo   "<pre>";
//                print_r($sql);exit;
        $statement = $this->dbAdapter->query($sql);
        

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
            $resultSet = new HydratingResultSet($this->hydrator, new States());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    
    public function saveState($stateObject) {
//                print_r($stateObject);
//                exit;
//        $stateData = $this->hydrator->extract($stateObject);
//        //print_r($educatioData);
//        //exit;
//        unset($stateData['id']); // Neither Insert nor Update needs the ID in the array
//
//        if ($stateObject->getId()) {
////            echo  "<pre>";
////            echo  "hello";exit;
//            $statement = $this->dbAdapter->query("UPDATE tbl_state 
//                SET state_name=:state_name,
//                    is_active=:is_active,
//                    country_id=:country_id                    
//                    WHERE id=:id");
//            //Debug::dump($id);
//            //exit;
//            $parameters = array(
//                'id' => $stateObject->getId(),
//                'state_name' => $stateObject->getStateName(),
//                'is_active' => $stateObject->getIsActive(),
//                'country_id' => $stateObject->getCountryId()
//                //'master_country_id' => $countryObject->getMasterCountryId()
//                //'is_active' => $educationFieldsObject->getIsActive(),
//            );
//            $result = $statement->execute($parameters);
//            
//            if ($result)
//                    return "success";
//                else
//                    return "couldn't update";
//        } else {
//             $statement = $this->dbAdapter->query("INSERT INTO tbl_state 
//                 (state_name, is_active,country_id, created_date)
//                 values(:state_name, :is_active,:country_id, now())");
//                 
//           
//            $parameters = array(
//                'state_name' => $stateObject->getStateName(),
//                //'is_active' => $countryObject->getIsActive(),
//                'is_active' => $stateObject->getIsActive(),
//                'country_id' => $stateObject->getCountryId()
//                //'master_country_id' => $countryObject->getMasterCountryId(),
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
//                $stateObject->setId($newId);
//            }
//
//            //print_r($educationFieldsObject);
//            //exit;
//            
//        }
        if (empty($stateObject['state_name'])) {
            
            return "Insert same state name below then edit";
            
        }
            if ($stateObject['id'] && isset($stateObject['state_name'])) {
           
            $postData = array();
            $postData['state_name'] = $stateObject['state_name'];
            $postData['state_code'] = $stateObject['state_code'];
            $postData['is_active'] = $stateObject['is_active'];
            $postData['country_id'] = $stateObject['country_id'];
            $postData['master_state_id'] = $stateObject['master_state_id'];            
            //$postData['image']      =  $stateObject['image'];
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['modified_by']      = $stateObject[0];
            $postData['created_by']      = $stateObject[0];
            $postData['ip']      = $stateObject[2];
            

            $action = new Update('tbl_state');
            $action->set($postData);
            $action->where(array('id = ?' => $stateObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } else {

            
            $postData = array();
            $postData['state_name'] = $stateObject['state_name'];
            $postData['state_code'] = $stateObject['state_code'];
            $postData['is_active'] = $stateObject['is_active'];
            $postData['country_id'] = $stateObject['country_id'];
            $postData['master_state_id'] = $stateObject['master_state_id'];            
            //$postData['image']      =  $stateObject['image'];
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $stateObject[0];
            $postData['ip']      = $stateObject[2];
            

            

            $action = new Insert('tbl_state');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
            //case 2:
            $postData2 = array();
            $stateId = $result->getGeneratedValue();
            $postData2['order_val'] = $stateId;
            
            $action2 = new Update('tbl_state');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $stateId));
            $sql2 = new Sql($this->dbAdapter);
            $stmt2 = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt2->execute();
            
            if ($result)
                return "success";
            else
                return "couldn't update";
       }
                
    }
    
    
    public function getState($id) {
        //echo   "<pre>";echo  $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_state WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new States());
        }
    }
    
    public function getStateRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT tbl_state.*,tbl_country.country_name ,tal.id as adminid, tal.username as username  FROM tbl_state INNER JOIN tbl_country ON(tbl_country.id=tbl_state.country_id) LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_state.modified_by OR tal.id=tbl_state.created_by WHERE tbl_state.is_active=:is_active");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new States());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }else{
            return FALSE;
        }
    }
    
    
    public function viewByStateId($table, $id) {

        //echo $id;exit;
//        $statement = $this->dbAdapter->query("SELECT * FROM $table WHERE id=:id");
        $statement = $this->dbAdapter->query("SELECT tbl_state.*,tbl_country.country_name FROM tbl_state INNER JOIN tbl_country ON(tbl_country.id=tbl_state.country_id) WHERE tbl_state.id=:id");
        
        //$adapter->query('SELECT * FROM `artist` WHERE `id` = ?', array(5));

        $parameters = array(
            'id' => $id,
        );
        //print_r($statement);
        ///exit;
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new States());
        }
        
    }
    
    
    public function stateSearch($data,$field) {
//        echo   "<pre>";
//        echo  $field;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        
        $countryname = (empty($fieldname = $field))?"":" && tbl_state.country_id=".$field;
//        \Zend\Debug\Debug::dump($statement);exit;
        //$statement = $this->dbAdapter->query("SELECT * FROM tbl_religion WHERE religion_name like '" . $data . "%'");
        $statement = $this->dbAdapter->query("select * from tbl_state inner join tbl_country on tbl_state.country_id = tbl_country.id
            where (tbl_state.state_name like '$data%' ".$countryname.")");

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
            $resultSet = new HydratingResultSet($this->hydrator, new States());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    //city
    
    public function getCitiesList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT tbl_city.*, tbl_state.state_name AS state_name  ,tal.id as adminid, tal.username as username FROM tbl_city 
                INNER JOIN tbl_state ON tbl_city.state_id = tbl_state.id  LEFT JOIN tbl_admin_login as tal ON 
            tal.id=tbl_city.modified_by OR tal.id=tbl_city.created_by ORDER BY `order_val` ASC");
        
//        SELECT tbl_state.*, tbl_country.country_name AS country_name ,tal.id as adminid, tal.username as username
//            FROM tbl_state INNER JOIN tbl_country ON tbl_state.country_id = tbl_country.id LEFT JOIN tbl_admin_login as tal ON 
//            tal.id=tbl_state.modified_by OR tal.id=tbl_state.created_by ORDER BY `order_val` ASC
        
                    
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
            $resultSet = new HydratingResultSet($this->hydrator, new Cities());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    
//    public function getCountriesList() {
////            Debug::dump($status);
////        exit;
//        //if(isset($status)){
//        $statement = $this->dbAdapter->query("SELECT tbl_city.*, tbl_state.state_name AS state_name FROM tbl_city 
//                INNER JOIN tbl_state ON tbl_city.state_id = tbl_state.id");
//        
//                    
//        $result = $statement->execute();
//        //}
//        // if(isset($status)){
////        Debug::dump($status);
////        exit;
////        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field  WHERE is_active=:is_active");
////        $parameters = array(
////            'is_active' => $status,
////        );
//        //$result = $statement->execute($parameters);
//        //$result = $statement->execute();
//        //}
//        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
//            $resultSet = new HydratingResultSet($this->hydrator, new Cities());
//
//            return $resultSet->initialize($result);
//            //return $this->hydrator->hydrate($result->current(), new EducationFields());
//        }
//    }
    
    
    public function getStateListByCountryCode($Country_ID) {
//            echo  "<pre>";
//            print_r($Country_ID);
//            exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_state 
                WHERE country_id = :country_id");
        $parameters = array(
            'country_id' => $Country_ID,
        );
                    
        $result = $statement->execute($parameters);
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
            $resultSet = new HydratingResultSet($this->hydrator, new States());

            return $resultSet->initialize($result)->toArray();
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    
    public function getCityListByStateCode($State_ID) {
//            echo  "<pre>";
//            print_r($Country_ID);
//            exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_city 
                WHERE state_id = :state_id");
        $parameters = array(
            'state_id' => $State_ID,
        );
                    
        $result = $statement->execute($parameters);
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Cities());

            return $resultSet->initialize($result)->toArray();
           
        }
    }
    
    public function getCityListByCountry($country_id) {
//            echo  "<pre>";
//            print_r($country_id);
//            exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_state WHERE country_id=:country_id");
        $parameters = array(
            'country_id' => $country_id,
        );
                    //$sql = "SELECT * FROM tbl_state WHERE country_id=".$_POST['Country_id']."";
        $results = $statement->execute($parameters);
        
        if ($results instanceof ResultInterface && $results->isQueryResult() && $results->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new States());

             $resultSet->initialize($results);
           
        }
//        echo  "<pre>";
//        print_r($results);exit;
        $i=0;
            $data = array();
            foreach($results as $result){
               
               $data[$i] = $result['id'];
               
                $i++;
            }
            
             $states_id = implode(',',$data);
//             print_r($states_id);exit;
             
             $statement2 = $this->dbAdapter->query("SELECT tbl_city.*,tbl_state.state_name FROM tbl_city INNER JOIN tbl_state ON 
                    tbl_city.state_id=tbl_state.id where tbl_city.state_id IN($states_id)");
             $results1 = $statement2->execute();
             
             if ($results1 instanceof ResultInterface && $results1->isQueryResult() && $results1->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Cities());

          return   $resultSet->initialize($results1);
           
        }
             
             
    }
    
    public function getCityListByState($state_id) {
//            echo  "<pre>";
//            print_r($Country_ID);
//            exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT tbl_city.*,tbl_state.state_name FROM tbl_city INNER JOIN tbl_state ON 
                    tbl_city.state_id=tbl_state.id where tbl_city.state_id=:state_id");
        $parameters = array(
            'state_id' => $state_id,
        );
                    
        $result = $statement->execute($parameters);
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Cities());

            return $resultSet->initialize($result);
           
        }
    }
    
    public function getCityListByCity($city_id) {
//            echo  "<pre>";
//            print_r($Country_ID);
//            exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT tbl_city.*,tbl_state.state_name FROM tbl_city INNER JOIN tbl_state ON 
                    tbl_city.state_id=tbl_state.id where tbl_city.id=:city_id");
        $parameters = array(
            'city_id' => $city_id,
        );
                    
        $result = $statement->execute($parameters);
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Cities());

            return $resultSet->initialize($result);
           
        }
    }
    
    public function customFieldsState() {        
        
        //$statement = $this->dbAdapter->query("SELECT id,state_name FROM tbl_state WHERE 1");
        $sql="SELECT id,master_state_id,state_name FROM tbl_state WHERE 1";
        $statement = $this->dbAdapter->query($sql);
        
        $result = $statement->execute();
        
        foreach ($result as $list) {
            $statenamelist[$list['id'].'-'.$list['master_state_id']] = $list['state_name'];
        }
        
        return $statenamelist;        
   
    }
    
    public function SaveCity($cityObject) {
//                echo  "<pre>";
//                print_r($cityObject);
//                exit;
//        $cityData = $this->hydrator->extract($cityObject);
//        //print_r($educatioData);
//        //exit;
//        unset($cityData['id']); // Neither Insert nor Update needs the ID in the array
//
//        if ($cityObject->getId()) {
////            echo  "<pre>";
////            echo  "hello";exit;
//            $statement = $this->dbAdapter->query("UPDATE tbl_city 
//                SET city_name=:city_name,
//                    state_id=:state_id
//                    WHERE id=:id");
//            //Debug::dump($id);
//            //exit;
//            $parameters = array(
//                'id' => $cityObject->getId(),
//                'city_name' => $cityObject->getCityName(),
//                'state_id' => $cityObject->getStateId(),
//            );
//            $result = $statement->execute($parameters);
//            
//            if ($result)
//                    return "success";
//                else
//                    return "couldn't update";
//        } else {
//             $statement = $this->dbAdapter->query("INSERT INTO tbl_city 
//                 (city_name, state_id, created_date)
//                 values(:city_name, :state_id, now())");
//                 
//           
//            $parameters = array(
//                'city_name' => $cityObject->getCityName(),
//                'state_id' => $cityObject->getStateId()
//                //'is_active' => $cityObject->getIsActive(),
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
//                $cityObject->setId($newId);
//            }
//
//            //print_r($educationFieldsObject);
//            //exit;
//            
//        }
        
        if (empty($cityObject['city_name'])) {
            
            return "Insert same city name below then edit";
            
        }
        
        if ($cityObject['id'] && isset($cityObject['city_name'])) {
           
            $postData = array();
            $postData['city_name'] = $cityObject['city_name'];
            $postData['city_code'] = $cityObject['city_code'];
            //$postData['is_active'] = 0;
            $postData['state_id'] = $cityObject['state_id'];
            $postData['master_city_id'] = $cityObject['master_city_id'];            
            $postData['image']      =  $cityObject['image'];
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['modified_by']      = $cityObject[0];
            $postData['created_by']      = $cityObject[0];
            $postData['ip']      = $cityObject[2];
            

            

            $action = new Update('tbl_city');
            $action->set($postData);
            $action->where(array('id = ?' => $cityObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if($cityObject['post_image_flag']==1){
            $image = PUBLIC_PATH . '/CityImages/' . $cityObject['post_image_update'];
            $image_thumb = PUBLIC_PATH . '/CityImages/thumb/100x100/' . $cityObject['post_image_update'];
            unlink($image);
            unlink($image_thumb);
            }
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } else {

            
            $postData = array();
            $postData['city_name'] = $cityObject['city_name'];
            $postData['city_code'] = $cityObject['city_code'];
            $postData['is_active'] = 0;
            $state_id=  explode('-',$cityObject['state_id']);
            $postData['state_id'] = $state_id[0];
            $postData['master_city_id'] = $cityObject['master_city_id'];            
            $postData['image']      =  $cityObject['image'];
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $cityObject[0];
            $postData['ip']      = $cityObject[2];
            
            //die;
            

            $action = new Insert('tbl_city');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
            //case 2:
            $postData2 = array();
            $cityId = $result->getGeneratedValue();
            $postData2['order_val'] = $cityId;
            
            $action2 = new Update('tbl_city');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $cityId));
            $sql2 = new Sql($this->dbAdapter);
            $stmt2 = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt2->execute();
            
            if ($result)
                return "success";
            else
                return "couldn't update";
       }
        
    }
    
    public function getCity($id) {
        //echo   "<pre>";echo  $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_city WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Cities());
        }
    }
    
    
    public function getCityRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT tbl_city.*,tbl_state.state_name ,tal.id as adminid, tal.username as username FROM tbl_city INNER JOIN tbl_state ON(tbl_state.id=tbl_city.state_id) LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_city.modified_by OR tal.id=tbl_city.created_by WHERE tbl_city.is_active=:is_active");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Cities());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }else{
            return FALSE;
        }
    }
    
    public function viewByCityId($table, $id) {

        //echo $id;exit;
//        $statement = $this->dbAdapter->query("SELECT * FROM $table WHERE id=:id");
        $statement = $this->dbAdapter->query("SELECT tbl_city.*,tbl_state.state_name FROM tbl_city INNER JOIN tbl_state ON(tbl_state.id=tbl_city.state_id) WHERE tbl_city.id=:id");
        
        //$adapter->query('SELECT * FROM `artist` WHERE `id` = ?', array(5));

        $parameters = array(
            'id' => $id,
        );
        //print_r($statement);
        ///exit;
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Cities());
        }
        
    }
    
    //Religion
    
   
    public function getReligionList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT tbl_religion.*, tal.id as adminid, tal.username as username FROM tbl_religion 
                LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_religion.modified_by OR tal.id=tbl_religion.created_by ORDER BY `order_val` ASC");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Religions());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function SaveReligion($religionObject) {
//                print_r($educationFieldsObject);
//                exit;
//        $religionData = $this->hydrator->extract($religionObject);
//        //print_r($educatioData);
//        //exit;
//        unset($religionData['id']); // Neither Insert nor Update needs the ID in the array
//
//        if ($religionObject->getId()) {
////            echo  "<pre>";
////            echo  "hello";exit;
//            $statement = $this->dbAdapter->query("UPDATE tbl_religion 
//                SET religion_name=:religion_name,
//                    is_active=:is_active
//                    WHERE id=:id");
//            //Debug::dump($id);
//            //exit;
//            $parameters = array(
//                'id' => $religionObject->getId(),
//                'religion_name' => $religionObject->getReligionName(),
//                'is_active' => $religionObject->getIsActive(),
//            );
//            $result = $statement->execute($parameters);
//            
//            if ($result)
//                    return "success";
//                else
//                    return "couldn't update";
//        } else {
//             $statement = $this->dbAdapter->query("INSERT INTO tbl_religion 
//                 (religion_name, is_active, created_date)
//                 values(:religion_name, :is_active, now())");
//                 
//           
//            $parameters = array(
//                'religion_name' => $religionObject->getReligionName(),
//                'is_active' => $religionObject->getIsActive(),
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
//                $religionObject->setId($newId);
//            }
//
//            //print_r($educationFieldsObject);
//            //exit;
//            
//        }
        if ($religionObject['id']) {
           
            $postData = array();
            $postData['religion_name'] = $religionObject['religion_name'];
            $postData['is_active'] = $religionObject['is_active'];
            //$postData['country_id'] = $religionObject['country_id'];
            //$postData['master_country_id'] = $religionObject['master_country_id'];            
            //$postData['image']      =  $religionObject['image'];
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['modified_by']      = $religionObject[0];
            $postData['created_by']      = $religionObject[0];
            $postData['ip']      = $religionObject[2];
            

            

            $action = new Update('tbl_religion');
            $action->set($postData);
            $action->where(array('id = ?' => $religionObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } else {

            
            $postData = array();
            $postData['religion_name'] = $religionObject['religion_name'];
            $postData['is_active'] = $religionObject['is_active'];
            //$postData['country_id'] = $religionObject['country_id'];
            //$postData['master_country_id'] = $religionObject['master_country_id'];            
            //$postData['image']      =  $religionObject['image'];
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $religionObject[0];
            $postData['ip']      = $religionObject[2];
            

            

            $action = new Insert('tbl_religion');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
            //case 2:
            $postData2 = array();
            $religionId = $result->getGeneratedValue();
            $postData2['order_val'] = $religionId;
            
            $action2 = new Update('tbl_religion');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $religionId));
            $sql2 = new Sql($this->dbAdapter);
            $stmt2 = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt2->execute();
            
            if ($result)
                return "success";
            else
                return "couldn't update";
       }
        
    }
    
     public function getReligion($id) {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_religion WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Religions());
        }
    }
    
    public function religionSearch($data) {
//        echo   "<pre>";
//        echo  $data;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_religion WHERE religion_name like '" . $data . "%'");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Religions());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function performSearchReligion($field) {
//        echo   "<pre>";
//        echo  $field;exit;
        $field1 = empty($field) ? "" : "religion_name like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_religion WHERE " . $field1 . "");
        

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
            $resultSet = new HydratingResultSet($this->hydrator, new Religions());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function getReligionRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        
        $statement = $this->dbAdapter->query("SELECT tbl_religion.* ,tal.id as adminid, tal.username as username  FROM tbl_religion  LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_religion.modified_by OR tal.id=tbl_religion.created_by WHERE is_active=:is_active");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
       
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
             //Debug::dump($result);exit;
            $resultSet = new HydratingResultSet($this->hydrator, new Religions());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }else{
            //Debug::dump('$result');exit;
            return FALSE;
        }
        
    }
    
    public function viewByReligionId($table, $id) {

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
            return $this->hydrator->hydrate($result->current(), new Religions());
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
    
    //Gothras
    
    public function getGothrasList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        /*$statement = $this->dbAdapter->query("SELECT tbl_gothra_gothram.*, tal.id as adminid, tal.username as username FROM tbl_gothra_gothram 
                LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_gothra_gothram.modified_by OR tal.id=tbl_gothra_gothram.created_by ORDER BY `order_val` ASC");*/
        
        $statement = $this->dbAdapter->query("SELECT tbl_gothra_gothram.*, tbl_caste.caste_name, tal.id as adminid, tal.username as username FROM tbl_gothra_gothram 
                    LEFT JOIN tbl_caste ON tbl_caste.id=tbl_gothra_gothram.caste_id
                LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_gothra_gothram.modified_by OR tal.id=tbl_gothra_gothram.created_by ORDER BY `order_val` ASC");
        
        
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
            $resultSet = new HydratingResultSet($this->hydrator, new Gothras());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function SaveGothra($gothraObject) {
//                print_r($educationFieldsObject);
//                exit;
//        $gothraData = $this->hydrator->extract($gothraObject);
//        //print_r($educatioData);
//        //exit;
//        unset($gothraData['id']); // Neither Insert nor Update needs the ID in the array
//
//        if ($gothraObject->getId()) {
////            echo  "<pre>";
////            echo  "hello";exit;
//            $statement = $this->dbAdapter->query("UPDATE tbl_gothra_gothram 
//                SET gothra_name=:gothra_name,
//                    is_active=:is_active
//                    WHERE id=:id");
//            //Debug::dump($id);
//            //exit;
//            $parameters = array(
//                'id' => $gothraObject->getId(),
//                'gothra_name' => $gothraObject->getGothraName(),
//                'is_active' => $gothraObject->getIsActive(),
//            );
//            $result = $statement->execute($parameters);
//            
//            if ($result)
//                    return "success";
//                else
//                    return "couldn't update";
//        } else {
//             $statement = $this->dbAdapter->query("INSERT INTO tbl_gothra_gothram 
//                 (gothra_name, is_active, created_date)
//                 values(:gothra_name, :is_active, now())");
//                 
//           
//            $parameters = array(
//                'gothra_name' => $gothraObject->getGothraName(),
//                'is_active' => $gothraObject->getIsActive(),
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
//                $gothraObject->setId($newId);
//            }
//
//            //print_r($educationFieldsObject);
//            //exit;
//            
//        }
         if ($gothraObject['id']) {
           
            $postData = array();
            $postData['gothra_name'] = $gothraObject['gothra_name'];
            $postData['is_active'] = $gothraObject['is_active'];
            $postData['caste_id'] = $gothraObject['caste_id'];
            //$postData['master_country_id'] = $gothraObject['master_country_id'];            
            //$postData['image']      =  $gothraObject['image'];
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['modified_by']      = $gothraObject[0];
            $postData['created_by']      = $gothraObject[0];
            $postData['ip']      = $gothraObject[2];
            

            

            $action = new Update('tbl_gothra_gothram');
            $action->set($postData);
            $action->where(array('id = ?' => $gothraObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } else {

            
            $postData = array();
            $postData['gothra_name'] = $gothraObject['gothra_name'];
            $postData['is_active'] = $gothraObject['is_active'];
            $postData['caste_id'] = $gothraObject['caste_id'];
            //$postData['master_country_id'] = $gothraObject['master_country_id'];            
            //$postData['image']      =  $gothraObject['image'];
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $gothraObject[0];
            $postData['ip']      = $gothraObject[2];
            

            

            $action = new Insert('tbl_gothra_gothram');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
            //case 2:
            $postData2 = array();
            $gothraId = $result->getGeneratedValue();
            $postData2['order_val'] = $gothraId;
            
            $action2 = new Update('tbl_gothra_gothram');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $gothraId));
            $sql2 = new Sql($this->dbAdapter);
            $stmt2 = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt2->execute();
            
            if ($result)
                return "success";
            else
                return "couldn't update";
       }
        
    }
    
    public function getGothra($id) {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_gothra_gothram WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Gothras());
        }
    }
    
    
    /*public function gothraSearch($data) {
//        echo   "<pre>";
//        echo  $data;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_gothra_gothram WHERE gothra_name like '" . $data . "%'");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Gothras());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }*/
    
    public function gothraSearch($data,$field) {
//        echo   "<pre>";
//        echo  $field;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        
        $casteid = (empty($fieldname = $field))?"":" && tbl_gothra_gothram.caste_id=".$field;
//        \Zend\Debug\Debug::dump($statement);exit;
        //$statement = $this->dbAdapter->query("SELECT * FROM tbl_religion WHERE religion_name like '" . $data . "%'");
        $statement = $this->dbAdapter->query("select * from tbl_gothra_gothram inner join tbl_caste on tbl_gothra_gothram.caste_id = tbl_caste.id
            where (tbl_gothra_gothram.gothra_name like '$data%' ".$casteid.")");

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
            $resultSet = new HydratingResultSet($this->hydrator, new Gothras());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    /*public function performSearchGothra($field) {
//        echo   "<pre>";
//        echo  $field;exit;
        $field1 = empty($field) ? "" : "gothra_name like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_gothra_gothram WHERE " . $field1 . "");
        

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
            $resultSet = new HydratingResultSet($this->hydrator, new Gothras());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }*/
    
    public function performSearchGothra($field,$field2) {
//        echo   "<pre>";
//        echo  $field2;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
//        $field1 = empty($field) ? "" : "country_name like '" . $field . "%' &&";
//        $field4 = empty($field2) ? "" : "country_code like '" . $field2 . "%' &&";
//        $field5 = empty($field3) ? "" : "dial_code like '" . $field3 . "%' ";
        $field3 = empty($field)? "": "tbl_gothra_gothram.caste_id= '".$field."' &&";   
        $field4 = empty($field2)? "": " tbl_gothra_gothram.gothra_name like '".$field2."%' "; 
        
//        $sql = "select * from tbl_country where " . $field1 . $field4 . $field5 . "";
        
        $sql = "select tbl_gothra_gothram.*,tbl_caste.caste_name AS caste_name from tbl_gothra_gothram inner join 
             tbl_caste on tbl_gothra_gothram.caste_id = tbl_caste.id 
         where ".$field3.$field4."";
        $sql = rtrim($sql, "&&");
//        echo   "<pre>";
//                print_r($sql);exit;
        $statement = $this->dbAdapter->query($sql);
        

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
            $resultSet = new HydratingResultSet($this->hydrator, new Gothras());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function getGothraRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT tbl_gothra_gothram.* , tbl_caste.caste_name ,tal.id as adminid, tal.username as username  FROM tbl_gothra_gothram LEFT JOIN tbl_caste ON tbl_caste.id=tbl_gothra_gothram.caste_id  LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_gothra_gothram.modified_by OR tal.id=tbl_gothra_gothram.created_by WHERE tbl_gothra_gothram.is_active=:is_active");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Gothras());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }  else {
            return FALSE;
        }
    }
    
    public function viewByGothraId($table, $id) {

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
            return $this->hydrator->hydrate($result->current(), new Gothras());
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
    
    public function getAllCastlist() {
        
        $statement = $this->dbAdapter->query("SELECT id,caste_name FROM tbl_caste WHERE 1");
        
        $result = $statement->execute();
        
        foreach ($result as $list) {
            $castenamelist[$list['id']] = $list['caste_name'];
        }
        
        return $castenamelist;
        

    }
    
    //Starsign
    
    public function getStarsignList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT tbl_star_sign.*, tal.id as adminid, tal.username as username FROM tbl_star_sign 
                LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_star_sign.modified_by OR tal.id=tbl_star_sign.created_by ORDER BY `order_val` ASC");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Starsigns());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function SaveStarsign($starsignObject) {
//                print_r($educationFieldsObject);
//                exit;
//        $starsignData = $this->hydrator->extract($starsignObject);
//        //print_r($educatioData);
//        //exit;
//        unset($starsignData['id']); // Neither Insert nor Update needs the ID in the array
//
//        if ($starsignObject->getId()) {
////            echo  "<pre>";
////            echo  "hello";exit;
//            $statement = $this->dbAdapter->query("UPDATE tbl_star_sign 
//                SET star_sign_name=:star_sign_name,
//                    is_active=:is_active
//                    WHERE id=:id");
//            //Debug::dump($id);
//            //exit;
//            $parameters = array(
//                'id' => $starsignObject->getId(),
//                'star_sign_name' => $starsignObject->getStarSignName(),
//                'is_active' => $starsignObject->getIsActive(),
//            );
//            $result = $statement->execute($parameters);
//            
//            if ($result)
//                    return "success";
//                else
//                    return "couldn't update";
//        } else {
//             $statement = $this->dbAdapter->query("INSERT INTO tbl_star_sign 
//                 (star_sign_name, is_active, created_date)
//                 values(:star_sign_name, :is_active, now())");
//                 
//           
//            $parameters = array(
//                'star_sign_name' => $starsignObject->getStarSignName(),
//                'is_active' => $starsignObject->getIsActive(),
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
//                $starsignObject->setId($newId);
//            }
//
//            //print_r($educationFieldsObject);
//            //exit;
//            
//        }
        
        if ($starsignObject['id']) {
           
            $postData = array();
            $postData['star_sign_name'] = $starsignObject['star_sign_name'];
            $postData['is_active'] = $starsignObject['is_active'];
            //$postData['country_id'] = $gothraObject['country_id'];
            //$postData['master_country_id'] = $gothraObject['master_country_id'];            
            //$postData['image']      =  $gothraObject['image'];
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['modified_by']      = $starsignObject[0];
            $postData['created_by']      = $starsignObject[0];
            $postData['ip']      = $starsignObject[2];
            

            

            $action = new Update('tbl_star_sign');
            $action->set($postData);
            $action->where(array('id = ?' => $starsignObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } else {

            
            $postData = array();
            $postData['star_sign_name'] = $starsignObject['star_sign_name'];
            $postData['is_active'] = $starsignObject['is_active'];
            //$postData['country_id'] = $starsignObject['country_id'];
            //$postData['master_country_id'] = $starsignObject['master_country_id'];            
            //$postData['image']      =  $starsignObject['image'];
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $starsignObject[0];
            $postData['ip']      = $starsignObject[2];
            

            

            $action = new Insert('tbl_star_sign');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
            //case 2:
            $postData2 = array();
            $starsignId = $result->getGeneratedValue();
            $postData2['order_val'] = $starsignId;
            
            $action2 = new Update('tbl_star_sign');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $starsignId));
            $sql2 = new Sql($this->dbAdapter);
            $stmt2 = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt2->execute();
            
            if ($result)
                return "success";
            else
                return "couldn't update";
       }
    }
    
    public function getStarsign($id) {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_star_sign WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Starsigns());
        }
    }
    
    public function starsignSearch($data) {
//        echo   "<pre>";
//        echo  $data;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_star_sign WHERE star_sign_name like '" . $data . "%'");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Starsigns());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function performSearchStarsign($field) {
//        echo   "<pre>";
//        echo  $field;exit;
        $field1 = empty($field) ? "" : "star_sign_name like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_star_sign WHERE " . $field1 . "");
        

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
            $resultSet = new HydratingResultSet($this->hydrator, new Starsigns());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function getStarsignRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT tbl_star_sign.* ,tal.id as adminid, tal.username as username FROM tbl_star_sign  LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_star_sign.modified_by OR tal.id=tbl_star_sign.created_by  WHERE is_active=:is_active");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Starsigns());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }  else {
            return FALSE;
        }
    }
    
    public function viewByStarsignId($table, $id) {

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
            return $this->hydrator->hydrate($result->current(), new Starsigns());
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
    
    //Zodiacsign
    
    public function getZodiacsignList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT tbl_zodiac_sign_raasi.*, tal.id as adminid, tal.username as username FROM tbl_zodiac_sign_raasi 
                LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_zodiac_sign_raasi.modified_by OR tal.id=tbl_zodiac_sign_raasi.created_by ORDER BY `order_val` ASC");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Zodiacsigns());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function SaveZodiacsign($zodiacsignObject) {
//                print_r($educationFieldsObject);
//                exit;
//        $zodiacsignData = $this->hydrator->extract($zodiacsignObject);
//        //print_r($educatioData);
//        //exit;
//        unset($zodiacsignData['id']); // Neither Insert nor Update needs the ID in the array
//
//        if ($zodiacsignObject->getId()) {
////            echo  "<pre>";
////            echo  "hello";exit;
//            $statement = $this->dbAdapter->query("UPDATE tbl_zodiac_sign_raasi 
//                SET zodiac_sign_name=:zodiac_sign_name,
//                    is_active=:is_active
//                    WHERE id=:id");
//            //Debug::dump($id);
//            //exit;
//            $parameters = array(
//                'id' => $zodiacsignObject->getId(),
//                'zodiac_sign_name' => $zodiacsignObject->getZodiacSignName(),
//                'is_active' => $zodiacsignObject->getIsActive(),
//            );
//            $result = $statement->execute($parameters);
//            
//            if ($result)
//                    return "success";
//                else
//                    return "couldn't update";
//        } else {
//             $statement = $this->dbAdapter->query("INSERT INTO tbl_zodiac_sign_raasi 
//                 (zodiac_sign_name, is_active, created_date)
//                 values(:zodiac_sign_name, :is_active, now())");
//                 
//           
//            $parameters = array(
//                'zodiac_sign_name' => $zodiacsignObject->getZodiacSignName(),
//                'is_active' => $zodiacsignObject->getIsActive(),
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
//                $zodiacsignObject->setId($newId);
//            }
//
//            //print_r($educationFieldsObject);
//            //exit;
//            
//        }
        
        if ($zodiacsignObject['id']) {
           
            $postData = array();
            $postData['zodiac_sign_name'] = $zodiacsignObject['zodiac_sign_name'];
            $postData['is_active'] = $zodiacsignObject['is_active'];
            //$postData['country_id'] = $zodiacsignObject['country_id'];
            //$postData['master_country_id'] = $zodiacsignObject['master_country_id'];            
            //$postData['image']      =  $zodiacsignObject['image'];
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['modified_by']      = $zodiacsignObject[0];
            $postData['created_by']      = $zodiacsignObject[0];
            $postData['ip']      = $zodiacsignObject[2];
            

            

            $action = new Update('tbl_zodiac_sign_raasi');
            $action->set($postData);
            $action->where(array('id = ?' => $zodiacsignObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } else {

            
            $postData = array();
            $postData['zodiac_sign_name'] = $zodiacsignObject['zodiac_sign_name'];
            $postData['is_active'] = $zodiacsignObject['is_active'];
            //$postData['country_id'] = $zodiacsignObject['country_id'];
            //$postData['master_country_id'] = $zodiacsignObject['master_country_id'];            
            //$postData['image']      =  $zodiacsignObject['image'];
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $zodiacsignObject[0];
            $postData['ip']      = $zodiacsignObject[2];
            

            

            $action = new Insert('tbl_zodiac_sign_raasi');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
            //case 2:
            $postData2 = array();
            $zodiacsignId = $result->getGeneratedValue();
            $postData2['order_val'] = $zodiacsignId;
            
            $action2 = new Update('tbl_zodiac_sign_raasi');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $zodiacsignId));
            $sql2 = new Sql($this->dbAdapter);
            $stmt2 = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt2->execute();
            
            if ($result)
                return "success";
            else
                return "couldn't update";
       }
    }
    
    public function getZodiacsign($id) {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_zodiac_sign_raasi WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Zodiacsigns());
        }
    }
    
    public function zodiacsignSearch($data) {
//        echo   "<pre>";
//        echo  $data;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_zodiac_sign_raasi WHERE zodiac_sign_name like '" . $data . "%'");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Zodiacsigns());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function performSearchZodiacsign($field) {
//        echo   "<pre>";
//        echo  $field;exit;
        $field1 = empty($field) ? "" : "zodiac_sign_name like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_zodiac_sign_raasi WHERE " . $field1 . "");
        

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
            $resultSet = new HydratingResultSet($this->hydrator, new Zodiacsigns());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function getZodiacsignRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT tbl_zodiac_sign_raasi.* ,tal.id as adminid, tal.username as username FROM tbl_zodiac_sign_raasi  LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_zodiac_sign_raasi.modified_by OR tal.id=tbl_zodiac_sign_raasi.created_by  WHERE is_active=:is_active");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Zodiacsigns());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }  else {
            return FALSE;
        }
    }
    
    public function viewByZodiacsignId($table, $id) {

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
            return $this->hydrator->hydrate($result->current(), new Zodiacsigns());
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
    
    //Profession
    
    public function getProfessionList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT tbl_profession.*, tal.id as adminid, tal.username as username FROM tbl_profession 
                LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_profession.modified_by OR tal.id=tbl_profession.created_by ORDER BY `order_val` ASC");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Professions());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function SaveProfession($professionObject) {
//                print_r($educationFieldsObject);
//                exit;
//        $professionData = $this->hydrator->extract($professionObject);
//        //print_r($educatioData);
//        //exit;
//        unset($professionData['id']); // Neither Insert nor Update needs the ID in the array
//
//        if ($professionObject->getId()) {
////            echo  "<pre>";
////            echo  "hello";exit;
//            $statement = $this->dbAdapter->query("UPDATE tbl_profession 
//                SET profession=:profession,
//                    is_active=:is_active
//                    WHERE id=:id");
//            //Debug::dump($id);
//            //exit;
//            $parameters = array(
//                'id' => $professionObject->getId(),
//                'profession' => $professionObject->getProfession(),
//                'is_active' => $professionObject->getIsActive(),
//            );
//            $result = $statement->execute($parameters);
//            
//            if ($result)
//                    return "success";
//                else
//                    return "couldn't update";
//        } else {
//             $statement = $this->dbAdapter->query("INSERT INTO tbl_profession 
//                 (profession, is_active, created_date)
//                 values(:profession, :is_active, now())");
//                 
//           
//            $parameters = array(
//                'profession' => $professionObject->getProfession(),
//                'is_active' => $professionObject->getIsActive(),
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
//                $professionObject->setId($newId);
//            }
//
//            //print_r($educationFieldsObject);
//            //exit;
//            
//        }
        
        if ($professionObject['id']) {
           
            $postData = array();
            $postData['profession'] = $professionObject['profession'];
            $postData['is_active'] = $professionObject['is_active'];
            //$postData['country_id'] = $professionObject['country_id'];
            //$postData['master_country_id'] = $professionObject['master_country_id'];            
            //$postData['image']      =  $professionObject['image'];
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['modified_by']      = $professionObject[0];
            $postData['created_by']      = $professionObject[0];
            $postData['ip']      = $professionObject[2];
            

            

            $action = new Update('tbl_profession');
            $action->set($postData);
            $action->where(array('id = ?' => $professionObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } else {

            
            $postData = array();
            $postData['profession'] = $professionObject['profession'];
            $postData['is_active'] = $professionObject['is_active'];
            //$postData['country_id'] = $professionObject['country_id'];
            //$postData['master_country_id'] = $professionObject['master_country_id'];            
            //$postData['image']      =  $professionObject['image'];
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $professionObject[0];
            $postData['ip']      = $professionObject[2];
            

            

            $action = new Insert('tbl_profession');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
            //case 2:
            $postData2 = array();
            $professionId = $result->getGeneratedValue();
            $postData2['order_val'] = $professionId;
            
            $action2 = new Update('tbl_profession');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $professionId));
            $sql2 = new Sql($this->dbAdapter);
            $stmt2 = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt2->execute();
            
            if ($result)
                return "success";
            else
                return "couldn't update";
       }
    }
    
    public function getProfession($id) {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_profession WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Professions());
        }
    }
    
    
    public function professionSearch($data) {
//        echo   "<pre>";
//        echo  $data;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_profession WHERE profession like '" . $data . "%'");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Professions());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function performSearchProfession($field) {
//        echo   "<pre>";
//        echo  $field;exit;
        $field1 = empty($field) ? "" : "profession like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_profession WHERE " . $field1 . "");
        

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
            $resultSet = new HydratingResultSet($this->hydrator, new Professions());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function getProfessionRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT tbl_profession.* ,tal.id as adminid, tal.username as username FROM tbl_profession  LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_profession.modified_by OR tal.id=tbl_profession.created_by WHERE is_active=:is_active");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Professions());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }  else {
            return FALSE;
        }
    }
    
     public function viewByProfessionId($table, $id) {

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
            return $this->hydrator->hydrate($result->current(), new Professions());
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
    
    //Designation
    
    public function getDesignationList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT tbl_designation.*, tal.id as adminid, tal.username as username FROM tbl_designation 
                LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_designation.modified_by OR tal.id=tbl_designation.created_by ORDER BY `order_val` ASC");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Designations());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function SaveDesignation($designationObject) {
//                print_r($educationFieldsObject);
//                exit;
//        $designationData = $this->hydrator->extract($designationObject);
//        //print_r($educatioData);
//        //exit;
//        unset($designationData['id']); // Neither Insert nor Update needs the ID in the array
//
//        if ($designationObject->getId()) {
////            echo  "<pre>";
////            echo  "hello";exit;
//            $statement = $this->dbAdapter->query("UPDATE tbl_designation 
//                SET designation=:designation,
//                    is_active=:is_active
//                    WHERE id=:id");
//            //Debug::dump($id);
//            //exit;
//            $parameters = array(
//                'id' => $designationObject->getId(),
//                'designation' => $designationObject->getDesignation(),
//                'is_active' => $designationObject->getIsActive(),
//            );
//            $result = $statement->execute($parameters);
//            
//            if ($result)
//                    return "success";
//                else
//                    return "couldn't update";
//        } else {
//             $statement = $this->dbAdapter->query("INSERT INTO tbl_designation 
//                 (designation, is_active, created_date)
//                 values(:designation, :is_active, now())");
//                 
//           
//            $parameters = array(
//                'designation' => $designationObject->getDesignation(),
//                'is_active' => $designationObject->getIsActive(),
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
//                $designationObject->setId($newId);
//            }
//
//            //print_r($educationFieldsObject);
//            //exit;
//            
//        }
        
        if ($designationObject['id']) {
           
            $postData = array();
            $postData['designation'] = $designationObject['designation'];
            $postData['is_active'] = $designationObject['is_active'];
            //$postData['country_id'] = $designationObject['country_id'];
            //$postData['master_country_id'] = $designationObject['master_country_id'];            
            //$postData['image']      =  $designationObject['image'];
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['modified_by']      = $designationObject[0];
            $postData['created_by']      = $designationObject[0];
            $postData['ip']      = $designationObject[2];
            

            

            $action = new Update('tbl_designation');
            $action->set($postData);
            $action->where(array('id = ?' => $designationObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } else {

            
            $postData = array();
            $postData['designation'] = $designationObject['designation'];
            $postData['is_active'] = $designationObject['is_active'];
            //$postData['country_id'] = $designationObject['country_id'];
            //$postData['master_country_id'] = $designationObject['master_country_id'];            
            //$postData['image']      =  $designationObject['image'];
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $designationObject[0];
            $postData['ip']      = $designationObject[2];
            

            

            $action = new Insert('tbl_designation');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
            //case 2:
            $postData2 = array();
            $designationId = $result->getGeneratedValue();
            $postData2['order_val'] = $designationId;
            
            $action2 = new Update('tbl_designation');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $designationId));
            $sql2 = new Sql($this->dbAdapter);
            $stmt2 = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt2->execute();
            
            if ($result)
                return "success";
            else
                return "couldn't update";
       }
    }
    
    public function getDesignation($id) {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_designation WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Designations());
        }
    }
    
    public function designationSearch($data) {
//        echo   "<pre>";
//        echo  $data;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_designation WHERE designation like '" . $data . "%'");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Designations());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function performSearchDesignation($field) {
//        echo   "<pre>";
//        echo  $field;exit;
        $field1 = empty($field) ? "" : "designation like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_designation WHERE " . $field1 . "");
        

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
            $resultSet = new HydratingResultSet($this->hydrator, new Designations());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function getDesignationRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT tbl_designation.* ,tal.id as adminid, tal.username as username FROM tbl_designation  LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_designation.modified_by OR tal.id=tbl_designation.created_by WHERE is_active=:is_active");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Designations());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }  else {
            return FALSE;
        }
    }
    
    public function viewByDesignationId($table, $id) {

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
            return $this->hydrator->hydrate($result->current(), new Designations());
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
    
    //Education level
    
    public function getEducationlevelList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT tbl_education_level.*, tal.id as adminid, tal.username as username FROM tbl_education_level 
                LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_education_level.modified_by OR tal.id=tbl_education_level.created_by ORDER BY `order_val` ASC");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Educationlevels());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    
    public function SaveEducationlevel($educationlevelObject) {
//                print_r($educationFieldsObject);
//                exit;
//        $educationlevelData = $this->hydrator->extract($educationlevelObject);
//        //print_r($educatioData);
//        //exit;
//        unset($educationlevelData['id']); // Neither Insert nor Update needs the ID in the array
//
//        if ($educationlevelObject->getId()) {
////            echo  "<pre>";
////            echo  "hello";exit;
//            $statement = $this->dbAdapter->query("UPDATE tbl_education_level 
//                SET education_level=:education_level,
//                    is_active=:is_active
//                    WHERE id=:id");
//            //Debug::dump($id);
//            //exit;
//            $parameters = array(
//                'id' => $educationlevelObject->getId(),
//                'education_level' => $educationlevelObject->getEducationLevel(),
//                'is_active' => $educationlevelObject->getIsActive(),
//            );
//            $result = $statement->execute($parameters);
//            
//            if ($result)
//                    return "success";
//                else
//                    return "couldn't update";
//        } else {
//             $statement = $this->dbAdapter->query("INSERT INTO tbl_education_level 
//                 (education_level, is_active, created_date)
//                 values(:education_level, :is_active, now())");
//                 
//           
//            $parameters = array(
//                'education_level' => $educationlevelObject->getEducationLevel(),
//                'is_active' => $educationlevelObject->getIsActive(),
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
//                $educationlevelObject->setId($newId);
//            }
//
//            //print_r($educationFieldsObject);
//            //exit;
//            
//        }
        
        if ($educationlevelObject['id']) {
           
            $postData = array();
            $postData['education_level'] = $educationlevelObject['education_level'];
            $postData['is_active'] = $educationlevelObject['is_active'];
            //$postData['country_id'] = $educationlevelObject['country_id'];
            //$postData['master_country_id'] = $educationlevelObject['master_country_id'];            
            //$postData['image']      =  $educationlevelObject['image'];
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['modified_by']      = $educationlevelObject[0];
            $postData['created_by']      = $educationlevelObject[0];
            $postData['ip']      = $educationlevelObject[2];
            

            

            $action = new Update('tbl_education_level');
            $action->set($postData);
            $action->where(array('id = ?' => $educationlevelObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } else {

            
            $postData = array();
            $postData['education_level'] = $educationlevelObject['education_level'];
            $postData['is_active'] = $educationlevelObject['is_active'];
            //$postData['country_id'] = $educationlevelObject['country_id'];
            //$postData['master_country_id'] = $educationlevelObject['master_country_id'];            
            //$postData['image']      =  $educationlevelObject['image'];
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $educationlevelObject[0];
            $postData['ip']      = $educationlevelObject[2];           

            $action = new Insert('tbl_education_level');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
            //case 2:
            $postData2 = array();
            $edulevelId = $result->getGeneratedValue();
            $postData2['order_val'] = $edulevelId;
            
            $action2 = new Update('tbl_education_level');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $edulevelId));
            $sql2 = new Sql($this->dbAdapter);
            $stmt2 = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt2->execute();
            
            if ($result)
                return "success";
            else
                return "couldn't update";
       }
    }
    
    public function getEducationlevel($id) {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_level WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Educationlevels());
        }
    }
    
    public function getEducationlevelRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT tbl_education_level.* ,tal.id as adminid, tal.username as username FROM tbl_education_level  LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_education_level.modified_by OR tal.id=tbl_education_level.created_by WHERE is_active=:is_active");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Educationlevels());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }  else {
            return FALSE;
        }
    }
    
    public function viewByEducationlevelId($table, $id) {

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
            return $this->hydrator->hydrate($result->current(), new Educationlevels());
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
    
    public function educationLevelSearch($data) {
//        echo   "<pre>";
//        echo  $data;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_level WHERE education_level like '" . $data . "%'");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Educationlevels());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function performSearchEducationlevel($field) {
//        echo   "<pre>";
//        echo  $field;exit;
        $field1 = empty($field) ? "" : "education_level like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_level WHERE " . $field1 . "");
        

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
            $resultSet = new HydratingResultSet($this->hydrator, new Educationlevels());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    //member...
    public function getUserPersonalDetailByUserId($id) {

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_user_info');
        $select->where(array('id = ?' => $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {

            //return $result->current();
            return $this->hydrator->hydrate($result->current(), new UserInfo());
        }
    }
    
    public function getUserPersonalDetailById($id) {

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_user_info');
        $select->where(array('user_id = ?' => $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        
//         $statement = $this->dbAdapter->query("SELECT * FROM tbl_user_info WHERE user_id=:user_id");
//        
//
//        $parameters = array(
//            'user_id' => $id
//        );
//       
//        $result = $statement->execute($parameters);

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {

            //return $result->current();
            return $this->hydrator->hydrate($result->current(), new Userinfo());
        }
    }
    
    //SavePersonalProfile
    //write code here ...
    
    public function SavePersonalProfile($personalDetailsObject) {
                //print_r($personalDetailsObject);
                //exit;
//        Debug::dump($personalDetailsObject['dob']);
//        exit;
        //$userData = $this->hydrator->extract($personalDetailsObject);
        //$userData = array_filter((array) $userData, function ($val) {
            //return !is_null($val);
        //});
        //$userData['dob'] = '2016-01-01';//date("Y-m-d",  strtotime($userData['dob']));
//        Debug::dump($userData['dob']);
//        exit;
        //$remote = new RemoteAddress;
        //$this->ip = $remote->getIpAddress();
        //$sql = new Sql($this->dbAdapter);



        /*$action = new Update('tbl_user_info');
        $action->set($userData);
        $action->where(array('id = ?' => $userData['id']));
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();*/
        
       
        if ($personalDetailsObject['id']) {
            
//            echo  "<pre>";
//            print_r($personalDetailsObject['id']);exit;
//            echo  "hello";exit;
            $postData = array();
            
            $postData['profile_for'] = (!empty($personalDetailsObject['profile_for'])) ? $personalDetailsObject['profile_for'] : null;
            
            $postData['profile_for_others'] = (!empty($personalDetailsObject['profile_for_others'])) ? $personalDetailsObject['profile_for_others'] : null;
//            echo  "<pre>";
//            print_r($postData['profile_for_others']);exit;
            $postData['name_title_user'] = (!empty($personalDetailsObject['name_title_user'])) ? $personalDetailsObject['name_title_user'] : null;
            $postData['full_name'] = (!empty($personalDetailsObject['full_name'])) ? $personalDetailsObject['full_name'] : null;
            $postData['dob'] = (!empty($personalDetailsObject['dob'])) ? $personalDetailsObject['dob'] : null;
            $postData['birth_time'] = (!empty($personalDetailsObject['birth_time'])) ? $personalDetailsObject['birth_time'] : null;            
            $postData['height']      =  (!empty($personalDetailsObject['height'])) ? $personalDetailsObject['height'] : null;
            
            $postData['color_complexion']      =  (!empty($personalDetailsObject['color_complexion'])) ? $personalDetailsObject['color_complexion'] : null;
            $postData['blood_group']      =  (!empty($personalDetailsObject['blood_group'])) ? $personalDetailsObject['blood_group'] : null;
            $postData['body_weight']      =  (!empty($personalDetailsObject['body_weight'])) ? $personalDetailsObject['body_weight'] : null;
            $postData['body_weight_type']      =  (!empty($personalDetailsObject['body_weight_type'])) ? $personalDetailsObject['body_weight_type'] : null;
            $postData['alternate_mobile_no']      =  (!empty($personalDetailsObject['alternate_mobile_no'])) ? $personalDetailsObject['alternate_mobile_no'] : null;
            $postData['gender']      =  (!empty($personalDetailsObject['gender'])) ? $personalDetailsObject['gender'] : null;
            
            $postData['age']      =  (!empty($personalDetailsObject['age'])) ? $personalDetailsObject['age'] : null;
            $postData['birth_place']      =  (!empty($personalDetailsObject['birth_place'])) ? $personalDetailsObject['birth_place'] : null;
            $postData['body_type']      =  (!empty($personalDetailsObject['body_type'])) ? $personalDetailsObject['body_type'] : null;
            $postData['any_disability']      =  (!empty($personalDetailsObject['any_disability'])) ? $personalDetailsObject['any_disability'] : null;
            $postData['native_place']      =  (!empty($personalDetailsObject['native_place'])) ? $personalDetailsObject['native_place'] : null;
            
            $postData['zodiac_sign_raasi']      =  (!empty($personalDetailsObject['zodiac_sign_raasi'])) ? $personalDetailsObject['zodiac_sign_raasi'] : null;
            $postData['phone_no']      =  (!empty($personalDetailsObject['phone_no'])) ? $personalDetailsObject['phone_no'] : null;
            $postData['religion']      =  (!empty($personalDetailsObject['religion'])) ? $personalDetailsObject['religion'] : null;
            $postData['religion_other']      =  (!empty($personalDetailsObject['religion_other'])) ? $personalDetailsObject['religion_other'] : null;
            $postData['gothra_gothram']      =  (!empty($personalDetailsObject['gothra_gothram'])) ? $personalDetailsObject['gothra_gothram'] : null;
            $postData['gothra_gothram_other']      =  (!empty($personalDetailsObject['gothra_gothram_other'])) ? $personalDetailsObject['gothra_gothram_other'] : null;
            
            $postData['caste']      =  (!empty($personalDetailsObject['caste'])) ? $personalDetailsObject['caste'] : null;
            $postData['sub_caste']      =  (!empty($personalDetailsObject['sub_caste'])) ? $personalDetailsObject['sub_caste'] : null;
            $postData['mother_tongue_id']      =  (!empty($personalDetailsObject['mother_tongue_id'])) ? $personalDetailsObject['mother_tongue_id'] : null;
            $postData['manglik_dossam']      =  (!empty($personalDetailsObject['manglik_dossam'])) ? $personalDetailsObject['manglik_dossam'] : null;
            $postData['star_sign']      =  (!empty($personalDetailsObject['star_sign'])) ? $personalDetailsObject['star_sign'] : null;
            
            $postData['drink']      =  (!empty($personalDetailsObject['drink'])) ? $personalDetailsObject['drink'] : null;
            $postData['smoke']      =  (!empty($personalDetailsObject['smoke'])) ? $personalDetailsObject['smoke'] : null;
            $postData['meal_preference']      =  (!empty($personalDetailsObject['meal_preference'])) ? $personalDetailsObject['meal_preference'] : null;
            $postData['address']      =  (!empty($personalDetailsObject['address'])) ? $personalDetailsObject['address'] : null;
            $postData['address_line2']      =  (!empty($personalDetailsObject['address_line2'])) ? $personalDetailsObject['address_line2'] : null;
            
            $postData['country']      =  (!empty($personalDetailsObject['country'])) ? $personalDetailsObject['country'] : null;
            $postData['state']      =  (!empty($personalDetailsObject['state'])) ? $personalDetailsObject['state'] : null;
            $postData['city']      =  (!empty($personalDetailsObject['city'])) ? $personalDetailsObject['city'] : null;
            $postData['branch_ids']      =  (!empty($personalDetailsObject['branch_ids'])) ? $personalDetailsObject['branch_ids'] : null;
            $postData['branch_ids_other']      =  (!empty($personalDetailsObject['branch_ids_other'])) ? $personalDetailsObject['branch_ids_other'] : null;
            
            $postData['zip_pin_code']      =  (!empty($personalDetailsObject['zip_pin_code'])) ? $personalDetailsObject['zip_pin_code'] : null;
//            $postData['image']      =  $personalDetailsObject['image'];
//            $postData['image']      =  $personalDetailsObject['image'];
//            $postData['image']      =  $personalDetailsObject['image'];
//            $postData['image']      =  $personalDetailsObject['image'];
            
            $postData['modified_date']      = date("Y-m-d h:i:s");
            //$postData['modified_by']      = $personalprofileObject[0];
            //$postData['created_by']      = $personalprofileObject[0];
            //$postData['ip']      = $personalprofileObject[2];
            

            

            $action = new Update('tbl_user_info');
            $action->set($postData);
            $action->where(array('id = ?' => $personalDetailsObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } 
    }
    
    
    public function SaveEducationAndCareer($educationAndCareerObject) {
//                print_r($educationAndCareerObject);
//                exit;
//        Debug::dump($personalDetailsObject['dob']);
//        exit;
        //$userData = $this->hydrator->extract($personalDetailsObject);
        //$userData = array_filter((array) $userData, function ($val) {
            //return !is_null($val);
        //});
        //$userData['dob'] = '2016-01-01';//date("Y-m-d",  strtotime($userData['dob']));
//        Debug::dump($userData['dob']);
//        exit;
        //$remote = new RemoteAddress;
        //$this->ip = $remote->getIpAddress();
        //$sql = new Sql($this->dbAdapter);



        /*$action = new Update('tbl_user_info');
        $action->set($userData);
        $action->where(array('id = ?' => $userData['id']));
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();*/
        
       
        if ($educationAndCareerObject['id']) {
            
//            echo  "<pre>";
//            print_r($educationAndCareerObject['id']);exit;
//            echo  "hello";exit;
            $postData = array();
            
            $postData['education_level'] = (!empty($educationAndCareerObject['education_level'])) ? $educationAndCareerObject['education_level'] : null;
            
            $postData['education_level_other'] = (!empty($educationAndCareerObject['education_level_other'])) ? $educationAndCareerObject['education_level_other'] : null;
//            echo  "<pre>";
//            print_r($postData['profile_for_others']);exit;
            $postData['education_field'] = (!empty($educationAndCareerObject['education_field'])) ? $educationAndCareerObject['education_field'] : null;
            $postData['education_field_other'] = (!empty($educationAndCareerObject['education_field_other'])) ? $educationAndCareerObject['education_field_other'] : null;
            $postData['working_with'] = (!empty($educationAndCareerObject['working_with'])) ? $educationAndCareerObject['working_with'] : null;
            $postData['working_with_other'] = (!empty($educationAndCareerObject['working_with_other'])) ? $educationAndCareerObject['working_with_other'] : null;            
            $postData['designation']      =  (!empty($educationAndCareerObject['designation'])) ? $educationAndCareerObject['designation'] : null;
            
            $postData['designation_other']      =  (!empty($educationAndCareerObject['designation_other'])) ? $educationAndCareerObject['designation_other'] : null;
            $postData['specialize_profession']      =  (!empty($educationAndCareerObject['specialize_profession'])) ? $educationAndCareerObject['specialize_profession'] : null;
            $postData['annual_income']      =  (!empty($educationAndCareerObject['annual_income'])) ? $educationAndCareerObject['annual_income'] : null;
            $postData['profession']      =  (!empty($educationAndCareerObject['profession'])) ? $educationAndCareerObject['profession'] : null;
            $postData['office_name']      =  (!empty($educationAndCareerObject['office_name'])) ? $educationAndCareerObject['office_name'] : null;
            $postData['office_email']      =  (!empty($educationAndCareerObject['office_email'])) ? $educationAndCareerObject['office_email'] : null;
            
            $postData['office_country']      =  (!empty($educationAndCareerObject['office_country'])) ? $educationAndCareerObject['office_country'] : null;
            $postData['office_phone']      =  (!empty($educationAndCareerObject['office_phone'])) ? $educationAndCareerObject['office_phone'] : null;
            $postData['office_state']      =  (!empty($educationAndCareerObject['office_state'])) ? $educationAndCareerObject['office_state'] : null;
            $postData['office_pincode']      =  (!empty($educationAndCareerObject['office_pincode'])) ? $educationAndCareerObject['office_pincode'] : null;
            $postData['office_city']      =  (!empty($educationAndCareerObject['office_city'])) ? $educationAndCareerObject['office_city'] : null;
            
            $postData['office_website']      =  (!empty($educationAndCareerObject['office_website'])) ? $educationAndCareerObject['office_website'] : null;
            $postData['office_address']      =  (!empty($educationAndCareerObject['office_address'])) ? $educationAndCareerObject['office_address'] : null;
            $postData['annual_income_status']      =  (!empty($educationAndCareerObject['annual_income_status'])) ? $educationAndCareerObject['annual_income_status'] : null;
//            $postData['religion_other']      =  (!empty($educationAndCareerObject['religion_other'])) ? $educationAndCareerObject['religion_other'] : null;
//            $postData['gothra_gothram']      =  (!empty($educationAndCareerObject['gothra_gothram'])) ? $educationAndCareerObject['gothra_gothram'] : null;
//            $postData['gothra_gothram_other']      =  (!empty($educationAndCareerObject['gothra_gothram_other'])) ? $educationAndCareerObject['gothra_gothram_other'] : null;
//            
//            $postData['caste']      =  (!empty($educationAndCareerObject['caste'])) ? $educationAndCareerObject['caste'] : null;
//            $postData['sub_caste']      =  (!empty($educationAndCareerObject['sub_caste'])) ? $educationAndCareerObject['sub_caste'] : null;
//            $postData['mother_tongue_id']      =  (!empty($educationAndCareerObject['mother_tongue_id'])) ? $educationAndCareerObject['mother_tongue_id'] : null;
//            $postData['manglik_dossam']      =  (!empty($educationAndCareerObject['manglik_dossam'])) ? $educationAndCareerObject['manglik_dossam'] : null;
//            $postData['star_sign']      =  (!empty($educationAndCareerObject['star_sign'])) ? $educationAndCareerObject['star_sign'] : null;
//            
//            $postData['drink']      =  (!empty($educationAndCareerObject['drink'])) ? $educationAndCareerObject['drink'] : null;
//            $postData['smoke']      =  (!empty($educationAndCareerObject['smoke'])) ? $educationAndCareerObject['smoke'] : null;
//            $postData['meal_preference']      =  (!empty($educationAndCareerObject['meal_preference'])) ? $educationAndCareerObject['meal_preference'] : null;
//            $postData['address']      =  (!empty($educationAndCareerObject['address'])) ? $educationAndCareerObject['address'] : null;
//            $postData['address_line2']      =  (!empty($educationAndCareerObject['address_line2'])) ? $educationAndCareerObject['address_line2'] : null;
//            
//            $postData['country']      =  (!empty($educationAndCareerObject['country'])) ? $educationAndCareerObject['country'] : null;
//            $postData['state']      =  (!empty($educationAndCareerObject['state'])) ? $educationAndCareerObject['state'] : null;
//            $postData['city']      =  (!empty($educationAndCareerObject['city'])) ? $educationAndCareerObject['city'] : null;
//            $postData['branch_ids']      =  (!empty($educationAndCareerObject['branch_ids'])) ? $educationAndCareerObject['branch_ids'] : null;
//            $postData['branch_ids_other']      =  (!empty($educationAndCareerObject['branch_ids_other'])) ? $educationAndCareerObject['branch_ids_other'] : null;
//            
//            $postData['zip_pin_code']      =  (!empty($educationAndCareerObject['zip_pin_code'])) ? $educationAndCareerObject['zip_pin_code'] : null;
//            $postData['image']      =  $personalDetailsObject['image'];
//            $postData['image']      =  $personalDetailsObject['image'];
//            $postData['image']      =  $personalDetailsObject['image'];
//            $postData['image']      =  $personalDetailsObject['image'];
            
            $postData['modified_date']      = date("Y-m-d h:i:s");
            //$postData['modified_by']      = $personalprofileObject[0];
            //$postData['created_by']      = $personalprofileObject[0];
            //$postData['ip']      = $personalprofileObject[2];
            

            

            $action = new Update('tbl_user_info');
            $action->set($postData);
            $action->where(array('id = ?' => $educationAndCareerObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } 
    }
    
    
    public function SaveLocation($locationObject) {
        //echo "hello";exit;
//                  echo   "<pre>";
//                print_r($locationObject);
//                exit;
//        Debug::dump($locationObject);
//        exit;
        //$userData = $this->hydrator->extract($personalDetailsObject);
        //$userData = array_filter((array) $userData, function ($val) {
            //return !is_null($val);
        //});
        //$userData['dob'] = '2016-01-01';//date("Y-m-d",  strtotime($userData['dob']));
//        Debug::dump($userData['dob']);
//        exit;
        //$remote = new RemoteAddress;
        //$this->ip = $remote->getIpAddress();
        //$sql = new Sql($this->dbAdapter);



        /*$action = new Update('tbl_user_info');
        $action->set($userData);
        $action->where(array('id = ?' => $userData['id']));
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();*/
        
       
        if ($locationObject['id']) {
            
//            echo  "<pre>";
//            print_r($locationObject['id']);exit;
//            echo  "hello";exit;
            $postData = array();
            
            $postData['country'] = (!empty($locationObject['country'])) ? $locationObject['country'] : null;
            
            $postData['state'] = (!empty($locationObject['state'])) ? $locationObject['state'] : null;
//            echo  "<pre>";
//            print_r($postData['profile_for_others']);exit;
            $postData['city'] = (!empty($locationObject['city'])) ? $locationObject['city'] : null;
            $postData['native_place'] = (!empty($locationObject['native_place'])) ? $locationObject['native_place'] : null;
            $postData['zip_pin_code'] = (!empty($locationObject['zip_pin_code'])) ? $locationObject['zip_pin_code'] : null;
            $postData['address'] = (!empty($locationObject['address'])) ? $locationObject['address'] : null;            
            $postData['office_name']      =  (!empty($locationObject['office_name'])) ? $locationObject['office_name'] : null;
            
            $postData['office_address']      =  (!empty($locationObject['office_address'])) ? $locationObject['office_address'] : null;
            $postData['office_email']      =  (!empty($locationObject['office_email'])) ? $locationObject['office_email'] : null;
            $postData['office_country']      =  (!empty($locationObject['office_country'])) ? $locationObject['office_country'] : null;
            $postData['office_state']      =  (!empty($locationObject['office_state'])) ? $locationObject['office_state'] : null;
            $postData['office_city']      =  (!empty($locationObject['office_city'])) ? $locationObject['office_city'] : null;
            //$postData['office_email']      =  (!empty($locationObject['office_email'])) ? $locationObject['office_email'] : null;
            
            //$postData['office_country']      =  (!empty($locationObject['office_country'])) ? $locationObject['office_country'] : null;
            $postData['office_phone']      =  (!empty($locationObject['office_phone'])) ? $locationObject['office_phone'] : null;
            //$postData['office_state']      =  (!empty($locationObject['office_state'])) ? $locationObject['office_state'] : null;
            $postData['office_pincode']      =  (!empty($locationObject['office_pincode'])) ? $locationObject['office_pincode'] : null;
            //$postData['office_city']      =  (!empty($locationObject['office_city'])) ? $locationObject['office_city'] : null;
            
            $postData['office_website']      =  (!empty($locationObject['office_website'])) ? $locationObject['office_website'] : null;
            //$postData['office_address']      =  (!empty($locationObject['office_address'])) ? $locationObject['office_address'] : null;
            //$postData['annual_income_status']      =  (!empty($locationObject['annual_income_status'])) ? $locationObject['annual_income_status'] : null;
//            $postData['religion_other']      =  (!empty($educationAndCareerObject['religion_other'])) ? $educationAndCareerObject['religion_other'] : null;
//            $postData['gothra_gothram']      =  (!empty($educationAndCareerObject['gothra_gothram'])) ? $educationAndCareerObject['gothra_gothram'] : null;
//            $postData['gothra_gothram_other']      =  (!empty($educationAndCareerObject['gothra_gothram_other'])) ? $educationAndCareerObject['gothra_gothram_other'] : null;
//            
//            $postData['caste']      =  (!empty($educationAndCareerObject['caste'])) ? $educationAndCareerObject['caste'] : null;
//            $postData['sub_caste']      =  (!empty($educationAndCareerObject['sub_caste'])) ? $educationAndCareerObject['sub_caste'] : null;
//            $postData['mother_tongue_id']      =  (!empty($educationAndCareerObject['mother_tongue_id'])) ? $educationAndCareerObject['mother_tongue_id'] : null;
//            $postData['manglik_dossam']      =  (!empty($educationAndCareerObject['manglik_dossam'])) ? $educationAndCareerObject['manglik_dossam'] : null;
//            $postData['star_sign']      =  (!empty($educationAndCareerObject['star_sign'])) ? $educationAndCareerObject['star_sign'] : null;
//            
//            $postData['drink']      =  (!empty($educationAndCareerObject['drink'])) ? $educationAndCareerObject['drink'] : null;
//            $postData['smoke']      =  (!empty($educationAndCareerObject['smoke'])) ? $educationAndCareerObject['smoke'] : null;
//            $postData['meal_preference']      =  (!empty($educationAndCareerObject['meal_preference'])) ? $educationAndCareerObject['meal_preference'] : null;
//            $postData['address']      =  (!empty($educationAndCareerObject['address'])) ? $educationAndCareerObject['address'] : null;
//            $postData['address_line2']      =  (!empty($educationAndCareerObject['address_line2'])) ? $educationAndCareerObject['address_line2'] : null;
//            
//            $postData['country']      =  (!empty($educationAndCareerObject['country'])) ? $educationAndCareerObject['country'] : null;
//            $postData['state']      =  (!empty($educationAndCareerObject['state'])) ? $educationAndCareerObject['state'] : null;
//            $postData['city']      =  (!empty($educationAndCareerObject['city'])) ? $educationAndCareerObject['city'] : null;
//            $postData['branch_ids']      =  (!empty($educationAndCareerObject['branch_ids'])) ? $educationAndCareerObject['branch_ids'] : null;
//            $postData['branch_ids_other']      =  (!empty($educationAndCareerObject['branch_ids_other'])) ? $educationAndCareerObject['branch_ids_other'] : null;
//            
//            $postData['zip_pin_code']      =  (!empty($educationAndCareerObject['zip_pin_code'])) ? $educationAndCareerObject['zip_pin_code'] : null;
//            $postData['image']      =  $personalDetailsObject['image'];
//            $postData['image']      =  $personalDetailsObject['image'];
//            $postData['image']      =  $personalDetailsObject['image'];
//            $postData['image']      =  $personalDetailsObject['image'];
            
            $postData['modified_date']      = date("Y-m-d h:i:s");
            //$postData['modified_by']      = $personalprofileObject[0];
            //$postData['created_by']      = $personalprofileObject[0];
            //$postData['ip']      = $personalprofileObject[2];
            

            

            $action = new Update('tbl_user_info');
            $action->set($postData);
            $action->where(array('id = ?' => $locationObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } 
    }
    
    public function SavePostDetail($postObject) {
//                print_r($postObject);
//                exit;
//        Debug::dump($postObject);
//        exit;
        //$userData = $this->hydrator->extract($personalDetailsObject);
        //$userData = array_filter((array) $userData, function ($val) {
            //return !is_null($val);
        //});
        //$userData['dob'] = '2016-01-01';//date("Y-m-d",  strtotime($userData['dob']));
//        Debug::dump($userData['dob']);
//        exit;
        //$remote = new RemoteAddress;
        //$this->ip = $remote->getIpAddress();
        //$sql = new Sql($this->dbAdapter);



        /*$action = new Update('tbl_user_info');
        $action->set($userData);
        $action->where(array('id = ?' => $userData['id']));
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();*/
        
       
        if ($postObject['id']) {
            
//            echo  "<pre>";
//            print_r($educationAndCareerObject['id']);exit;
//            echo  "hello";exit;
            $postData = array();
            
            $postData['post_category'] = (!empty($postObject['post_category'])) ? $postObject['post_category'] : null;
            
            $postData['title'] = (!empty($postObject['title'])) ? $postObject['title'] : null;
//            echo  "<pre>";
//            print_r($postData['profile_for_others']);exit;
            $postData['image'] = (!empty($postObject['image'])) ? $postObject['image'] : null;
            $postData['language'] = (!empty($postObject['language'])) ? $postObject['language'] : null;
            $postData['description'] = (!empty($postObject['description'])) ? $postObject['description'] : null;
            //$postData['address'] = (!empty($postObject['address'])) ? $postObject['address'] : null;            
            //$postData['office_name']      =  (!empty($postObject['office_name'])) ? $postObject['office_name'] : null;
            
            //$postData['office_address']      =  (!empty($postObject['office_address'])) ? $postObject['office_address'] : null;
            //$postData['office_email']      =  (!empty($postObject['office_email'])) ? $postObject['office_email'] : null;
            //$postData['office_country']      =  (!empty($postObject['office_country'])) ? $postObject['office_country'] : null;
            //$postData['office_state']      =  (!empty($postObject['office_state'])) ? $postObject['office_state'] : null;
            //$postData['office_city']      =  (!empty($postObject['office_city'])) ? $postObject['office_city'] : null;
            //$postData['office_email']      =  (!empty($locationObject['office_email'])) ? $locationObject['office_email'] : null;
            
            //$postData['office_country']      =  (!empty($locationObject['office_country'])) ? $locationObject['office_country'] : null;
            //$postData['office_phone']      =  (!empty($postObject['office_phone'])) ? $postObject['office_phone'] : null;
            //$postData['office_state']      =  (!empty($locationObject['office_state'])) ? $locationObject['office_state'] : null;
            //$postData['office_pincode']      =  (!empty($postObject['office_pincode'])) ? $postObject['office_pincode'] : null;
            //$postData['office_city']      =  (!empty($locationObject['office_city'])) ? $locationObject['office_city'] : null;
            
            //$postData['office_website']      =  (!empty($postObject['$postObject'])) ? $postObject['office_website'] : null;
            //$postData['office_address']      =  (!empty($locationObject['office_address'])) ? $locationObject['office_address'] : null;
            //$postData['annual_income_status']      =  (!empty($locationObject['annual_income_status'])) ? $locationObject['annual_income_status'] : null;
//            $postData['religion_other']      =  (!empty($educationAndCareerObject['religion_other'])) ? $educationAndCareerObject['religion_other'] : null;
//            $postData['gothra_gothram']      =  (!empty($educationAndCareerObject['gothra_gothram'])) ? $educationAndCareerObject['gothra_gothram'] : null;
//            $postData['gothra_gothram_other']      =  (!empty($educationAndCareerObject['gothra_gothram_other'])) ? $educationAndCareerObject['gothra_gothram_other'] : null;
//            
//            $postData['caste']      =  (!empty($educationAndCareerObject['caste'])) ? $educationAndCareerObject['caste'] : null;
//            $postData['sub_caste']      =  (!empty($educationAndCareerObject['sub_caste'])) ? $educationAndCareerObject['sub_caste'] : null;
//            $postData['mother_tongue_id']      =  (!empty($educationAndCareerObject['mother_tongue_id'])) ? $educationAndCareerObject['mother_tongue_id'] : null;
//            $postData['manglik_dossam']      =  (!empty($educationAndCareerObject['manglik_dossam'])) ? $educationAndCareerObject['manglik_dossam'] : null;
//            $postData['star_sign']      =  (!empty($educationAndCareerObject['star_sign'])) ? $educationAndCareerObject['star_sign'] : null;
//            
//            $postData['drink']      =  (!empty($educationAndCareerObject['drink'])) ? $educationAndCareerObject['drink'] : null;
//            $postData['smoke']      =  (!empty($educationAndCareerObject['smoke'])) ? $educationAndCareerObject['smoke'] : null;
//            $postData['meal_preference']      =  (!empty($educationAndCareerObject['meal_preference'])) ? $educationAndCareerObject['meal_preference'] : null;
//            $postData['address']      =  (!empty($educationAndCareerObject['address'])) ? $educationAndCareerObject['address'] : null;
//            $postData['address_line2']      =  (!empty($educationAndCareerObject['address_line2'])) ? $educationAndCareerObject['address_line2'] : null;
//            
//            $postData['country']      =  (!empty($educationAndCareerObject['country'])) ? $educationAndCareerObject['country'] : null;
//            $postData['state']      =  (!empty($educationAndCareerObject['state'])) ? $educationAndCareerObject['state'] : null;
//            $postData['city']      =  (!empty($educationAndCareerObject['city'])) ? $educationAndCareerObject['city'] : null;
//            $postData['branch_ids']      =  (!empty($educationAndCareerObject['branch_ids'])) ? $educationAndCareerObject['branch_ids'] : null;
//            $postData['branch_ids_other']      =  (!empty($educationAndCareerObject['branch_ids_other'])) ? $educationAndCareerObject['branch_ids_other'] : null;
//            
//            $postData['zip_pin_code']      =  (!empty($educationAndCareerObject['zip_pin_code'])) ? $educationAndCareerObject['zip_pin_code'] : null;
//            $postData['image']      =  $personalDetailsObject['image'];
//            $postData['image']      =  $personalDetailsObject['image'];
//            $postData['image']      =  $personalDetailsObject['image'];
//            $postData['image']      =  $personalDetailsObject['image'];
            
            $postData['modified_date']      = date("Y-m-d h:i:s");
            //$postData['modified_by']      = $personalprofileObject[0];
            //$postData['created_by']      = $personalprofileObject[0];
            //$postData['ip']      = $personalprofileObject[2];
            

            

            $action = new Update('tbl_post');
            $action->set($postData);
            $action->where(array('id = ?' => $postObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } 
    }
    
    
    
    
    public function getUserEducationAndCareerDetailById($id) {
        //$columns = ($columns == false) ? array('*') : $columns;

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_user_info');
        //$select->columns($columns);
        $select->where(array('user_id = ?' => $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {

            return $this->hydrator->hydrate($result->current(), new Userinfo());
        }
    }
    
    public function getUserLocationDetailById($id) {
        //$columns = ($columns == false) ? array('*') : $columns;

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_user_info');
        //$select->columns($columns);
        $select->where(array('user_id = ?' => $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {

            return $this->hydrator->hydrate($result->current(), new Userinfo());
        }
    }    
    
    //Get member dashboad...
    
    public function getMemberdashboardById($id) {
        //echo   "<pre>";echo  $id;exit;
        $statement = $this->dbAdapter->query("select tui.user_id,tui.user_type_id,tui.full_name,tui.address,tui.native_place,tui.membership_paid,
            tbl_user.*,tbl_user_roles.IsMember,tbl_user_roles.IsExecutive from tbl_user_info tui LEFT JOIN tbl_user on tui.user_id = tbl_user.id 
            LEFT JOIN tbl_user_roles on tbl_user.id = tbl_user_roles.user_id WHERE tui.user_type_id=1 AND tbl_user.id =:id
         ");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Memberdashboards());
        }
    }
    
    public function SaveMemberdashboard($memberdashboardObject) {
        //echo "hello";exit;
//                  echo   "<pre>";
//                print_r($memberdashboardObject);
//                exit;
//        Debug::dump($memberdashboardObject);
//        exit;
        
        if ($memberdashboardObject['id']) {
            
//            echo  "<pre>";
//            print_r($memberdashboardObject['id']);exit;
//            echo  "hello";exit;
            $postData = array();
            
            $postData['full_name'] = (!empty($memberdashboardObject['full_name'])) ? $memberdashboardObject['full_name'] : null;            
            $postData['address'] = (!empty($memberdashboardObject['address'])) ? $memberdashboardObject['address'] : null;
            $postData['native_place'] = (!empty($memberdashboardObject['native_place'])) ? $memberdashboardObject['native_place'] : null;
            
            $postData2 = array();
            
            $postData2['mobile_no'] = (!empty($memberdashboardObject['mobile_no'])) ? $memberdashboardObject['mobile_no'] : null;            
            $postData2['is_active'] = (!empty($memberdashboardObject['is_active'])) ? $memberdashboardObject['is_active'] : null;
            $postData2['modified_date']      = date("Y-m-d h:i:s");
            $postData2['modified_by']      = $memberdashboardObject[0];
            //$postData2['created_by']      = $memberdashboardObject[0];
            $postData2['ip']      = $memberdashboardObject[2];
            
            //case 1:
            $action = new Update('tbl_user_info');
            $action->set($postData);
            $action->where(array('user_id = ?' => $memberdashboardObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            //case 2:
            $action2 = new Update('tbl_user');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $memberdashboardObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt->execute();
            
            if($result){
            if ($result2){
                return "success";
            } else{
                return "couldn't update";
            }
            
            }else{
                return "couldn't update";
            }
            
        } 
    }
    
    //Get matrimonial dashboad...
    
    public function getMatrimonialdashboardById($id) {
        //echo   "<pre>";echo  $id;exit;
        /*$statement = $this->dbAdapter->query("select tui.user_id,tui.user_type_id,tui.full_name,tui.address,tui.native_place,tui.membership_paid,
            tbl_user.*,tbl_user_roles.IsMember,tbl_user_roles.IsExecutive from tbl_user_info tui LEFT JOIN tbl_user on tui.user_id = tbl_user.id 
            LEFT JOIN tbl_user_roles on tbl_user.id = tbl_user_roles.user_id WHERE tui.user_type_id=2 AND tbl_user.id =:id
         ");*/
        
        /*$statement = $this->dbAdapter->query("SELECT tui.user_id, tui.full_name, ma.address, tui.native_place, tui.membership_paid, um. * , fim.name, tbl_user_gallery_matrimonial.image_name
            FROM tbl_user_matrimonial um
            LEFT JOIN tbl_user_info_matrimonial tui ON um.id = tui.user_id
            LEFT JOIN tbl_family_info_matrimonial fim ON um.id = fim.user_id
            LEFT JOIN tbl_user_gallery_matrimonial ON um.id = tbl_user_gallery_matrimonial.user_id
            LEFT JOIN tbl_user_address_matrimonial ma ON um.id = ma.user_id
            WHERE fim.relation_id =1
            AND um.id =:id
            
         ");*/
        
        $statement = $this->dbAdapter->query("SELECT tui.user_id, tui.full_name, ma.address, tui.native_place, tui.membership_paid, um. * , fim.name, gm.image_name
                    FROM tbl_user_matrimonial um 
                    LEFT JOIN tbl_user_info_matrimonial tui ON um.id = tui.user_id
                    LEFT JOIN tbl_family_info_matrimonial fim ON um.id = fim.user_id
                    LEFT OUTER JOIN tbl_user_gallery_matrimonial gm ON gm.user_id = um.id
                    AND gm.id = (
                    SELECT gm1.id
                    FROM tbl_user_gallery_matrimonial gm1
                    WHERE gm1.user_id = um.id
                    AND gm1.image_name IS NOT NULL
                    AND gm1.user_type = 'U'
                    AND gm1.image_type =1
                    ORDER BY gm1.image_name ASC
                    LIMIT 1 )
                    LEFT JOIN tbl_user_address_matrimonial ma ON um.id = ma.user_id
                    WHERE fim.relation_id =1 AND um.id =:id
                    ORDER BY tui.user_id DESC
                    LIMIT 0 , 10
            
         ");
        
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Matrimonialdashboards());
        }
    }
    
    public function SaveMatrimonialdashboard($matrimonialdashboardObject) {
        //echo "hello";exit;
//                  echo   "<pre>";
//                print_r($memberdashboardObject);
//                exit;
//        Debug::dump($memberdashboardObject);
//        exit;
        
        if ($matrimonialdashboardObject['id']) {
            
//            echo  "<pre>";
//            print_r($matrimonialdashboardObject['id']);exit;
//            echo  "hello";exit;
            $postData = array();
            
            $postData['full_name'] = (!empty($matrimonialdashboardObject['full_name'])) ? $matrimonialdashboardObject['full_name'] : null;
            $postData['full_name'] = (!empty($matrimonialdashboardObject['full_name'])) ? $matrimonialdashboardObject['full_name'] : null;
            $postData['address'] = (!empty($matrimonialdashboardObject['address'])) ? $matrimonialdashboardObject['address'] : null;
            $postData['native_place'] = (!empty($matrimonialdashboardObject['native_place'])) ? $matrimonialdashboardObject['native_place'] : null;
            
            
            $postData2 = array();
            
            $postData2['mobile_no'] = (!empty($matrimonialdashboardObject['mobile_no'])) ? $matrimonialdashboardObject['mobile_no'] : null;            
            $postData2['is_active'] = (!empty($matrimonialdashboardObject['is_active'])) ? $matrimonialdashboardObject['is_active'] : null;
            $postData2['modified_date']      = date("Y-m-d h:i:s");
            $postData2['modified_by']      = $matrimonialdashboardObject[0];
            //$postData2['created_by']      = $matrimonialdashboardObject[0];
            $postData2['ip']      = $matrimonialdashboardObject[2];
            
            $postData3 = array();
            
            $postData3['name'] = (!empty($matrimonialdashboardObject['name'])) ? $matrimonialdashboardObject['name'] : null;
            
            //case 1:
            $action = new Update('tbl_user_info');
            $action->set($postData);
            $action->where(array('user_id = ?' => $matrimonialdashboardObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            //case 2:
            $action2 = new Update('tbl_user');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $matrimonialdashboardObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt->execute();
            
            //case 3:
            $action3 = new Update('tbl_family_info_matrimonial');
            $action3->set($postData3);
            $action3->where(array('user_id = ?' => $matrimonialdashboardObject['id'],'relation_id = ?' => '1'));            
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action3);
            $result3 = $stmt->execute();
            
            if($result){
            if ($result2){
                return "success";
            } else{
                return "couldn't update";
            }
            
            }else{
                return "couldn't update";
            }
            
        } 
    }
    
   /* public function getUserPersonalDetailByIdMatrimonial($user_id) {
        //echo  $user_id; exit;
        $statement = $this->dbAdapter->query("SELECT 
                 tui.*, 
                 tu.email, 
                 tu.mobile_no, 
                 tup.* ,
                 tuam.*,
                 tugm.* 
             FROM tbl_user_info_matrimonial as tui
               LEFT JOIN tbl_user_matrimonial as tu ON tui.user_id=tu.id
               LEFT JOIN tbl_user_professional_matrimonial as tup ON tui.user_id=tup.user_id
               LEFT JOIN tbl_user_gallery_matrimonial as tugm ON tugm.user_id=tui.user_id
               LEFT JOIN tbl_user_address_matrimonial as tuam ON tuam.user_id=tui.user_id
               WHERE tui.user_id=:user_id");
        $parameters = array(
            'user_id' => $user_id
        );
        $result = $statement->execute($parameters);

        return $result->current();

        //return $this->hydrator->hydrate($result->current(), new UserInfo());
    } */
    
    
    
    
    

}
