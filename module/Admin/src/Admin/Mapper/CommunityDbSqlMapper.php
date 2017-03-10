<?php

namespace Admin\Mapper;

use Admin\Model\Entity\Communitys;
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

class CommunityDbSqlMapper implements CommunityMapperInterface {

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
       $data = "asdfg";
       return $data;
    }
    
   
    
    //Community...
    
   
    public function getCommunitysList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        /*$statement = $this->dbAdapter->query("SELECT community.*, tal.id as adminid, tal.username as username FROM community 
                LEFT JOIN tbl_admin_login as tal ON tal.id=community.modified_by OR tal.id=community.created_by ORDER BY `order_val` ASC");*/
        
        $statement = $this->dbAdapter->query("SELECT community.*, tbl_religion.religion_name, tal.id as adminid, tal.username as username FROM community 
                    LEFT JOIN tbl_religion ON tbl_religion.id=community.religion_id
                LEFT JOIN tbl_admin_login as tal ON tal.id=community.modified_by OR tal.id=community.created_by ORDER BY `order_val` ASC");
        
        
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
            $resultSet = new HydratingResultSet($this->hydrator, new Communitys());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function SaveCommunity($communityObject) {
//                print_r($educationFieldsObject);
//                exit;
//        $communityData = $this->hydrator->extract($communityObject);
//        //print_r($educatioData);
//        //exit;
//        unset($communityData['id']); // Neither Insert nor Update needs the ID in the array
//
//        if ($communityObject->getId()) {
////            echo  "<pre>";
////            echo  "hello";exit;
//            $statement = $this->dbAdapter->query("UPDATE community 
//                SET community_name=:community_name,
//                    is_active=:is_active
//                    WHERE id=:id");
//            //Debug::dump($id);
//            //exit;
//            $parameters = array(
//                'id' => $communityObject->getId(),
//                'community_name' => $communityObject->getCommunityName(),
//                'is_active' => $communityObject->getIsActive(),
//            );
//            $result = $statement->execute($parameters);
//            
//            if ($result)
//                    return "success";
//                else
//                    return "couldn't update";
//        } else {
//             $statement = $this->dbAdapter->query("INSERT INTO community 
//                 (community_name, is_active, created_date)
//                 values(:community_name, :is_active, now())");
//                 
//           
//            $parameters = array(
//                'community_name' => $communityObject->getCommunityName(),
//                'is_active' => $communityObject->getIsActive(),
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
//                $communityObject->setId($newId);
//            }
//
//            //print_r($educationFieldsObject);
//            //exit;
//            
//        }
         if ($communityObject['id']) {
           
            $postData = array();
            $postData['community_name'] = $communityObject['community_name'];
            $postData['is_active'] = $communityObject['is_active'];
            $postData['religion_id'] = $communityObject['religion_id'];
            //$postData['master_country_id'] = $communityObject['master_country_id'];            
            //$postData['image']      =  $communityObject['image'];
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['modified_by']      = $communityObject[0];
            $postData['created_by']      = $communityObject[0];
            $postData['ip']      = $communityObject[2];
            

            

            $action = new Update('community');
            $action->set($postData);
            $action->where(array('id = ?' => $communityObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } else {

            
            $postData = array();
            $postData['community_name'] = $communityObject['community_name'];
            $postData['is_active'] = $communityObject['is_active'];
            $postData['religion_id'] = $communityObject['religion_id'];
            //$postData['master_country_id'] = $communityObject['master_country_id'];            
            //$postData['image']      =  $communityObject['image'];
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $communityObject[0];
            $postData['ip']      = $communityObject[2];
            

            

            $action = new Insert('community');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
            //case 2:
            $postData2 = array();
            $communityId = $result->getGeneratedValue();
            $postData2['order_val'] = $communityId;
            
            $action2 = new Update('community');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $communityId));
            $sql2 = new Sql($this->dbAdapter);
            $stmt2 = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt2->execute();
            
            if ($result)
                return "success";
            else
                return "couldn't update";
       }
        
    }
    
    public function getCommunity($id) {
        $statement = $this->dbAdapter->query("SELECT * FROM community WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Communitys());
        }
    }
    
    
    /*public function communitySearch($data) {
//        echo   "<pre>";
//        echo  $data;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM community WHERE community_name like '" . $data . "%'");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Communitys());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }*/
    
    public function communitySearch($data,$field) {
//        echo   "<pre>";
//        echo  $field;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        
        $religionid = (empty($fieldname = $field))?"":" && community.religion_id=".$field;
//        \Zend\Debug\Debug::dump($statement);exit;
        //$statement = $this->dbAdapter->query("SELECT * FROM tbl_religion WHERE religion_name like '" . $data . "%'");
        $statement = $this->dbAdapter->query("select * from community inner join tbl_religion on community.religion_id = tbl_religion.id
            where (community.community_name like '$data%' ".$religionid.")");

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
            $resultSet = new HydratingResultSet($this->hydrator, new Communitys());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    /*public function performSearchCommunity($field) {
//        echo   "<pre>";
//        echo  $field;exit;
        $field1 = empty($field) ? "" : "community_name like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM community WHERE " . $field1 . "");
        

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
            $resultSet = new HydratingResultSet($this->hydrator, new Communitys());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }*/
    
    public function performSearchCommunity($field,$field2) {
//        echo   "<pre>";
//        echo  $field2;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
//        $field1 = empty($field) ? "" : "country_name like '" . $field . "%' &&";
//        $field4 = empty($field2) ? "" : "country_code like '" . $field2 . "%' &&";
//        $field5 = empty($field3) ? "" : "dial_code like '" . $field3 . "%' ";
        $field3 = empty($field)? "": "community.religion_id= '".$field."' &&";   
        $field4 = empty($field2)? "": " community.community_name like '".$field2."%' "; 
        
//        $sql = "select * from tbl_country where " . $field1 . $field4 . $field5 . "";
        
        $sql = "select community.*,tbl_religion.religion_name AS religion_name from community inner join 
             tbl_religion on community.religion_id = tbl_religion.id 
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
            $resultSet = new HydratingResultSet($this->hydrator, new Communitys());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function getCommunityRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT community.* , tbl_religion.religion_name ,tal.id as adminid, tal.username as username  FROM community LEFT JOIN tbl_religion ON tbl_religion.id=community.religion_id  LEFT JOIN tbl_admin_login as tal ON tal.id=community.modified_by OR tal.id=community.created_by WHERE community.is_active=:is_active");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Communitys());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }  else {
            return FALSE;
        }
    }
    
    public function viewByCommunityId($table, $id) {

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
            return $this->hydrator->hydrate($result->current(), new Communitys());
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
    
    public function getAllReligionlist() {
        
        $statement = $this->dbAdapter->query("SELECT id,religion_name FROM tbl_religion WHERE 1");
        
        $result = $statement->execute();
        
        foreach ($result as $list) {
            $religionnamelist[$list['id']] = $list['religion_name'];
        }
        
        return $religionnamelist;
        

    }
    
   
    
    
    
    
    
    

}
