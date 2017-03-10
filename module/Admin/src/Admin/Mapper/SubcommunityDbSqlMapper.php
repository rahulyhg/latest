<?php

namespace Admin\Mapper;

use Admin\Model\Entity\Subcommunitys;
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

class SubcommunityDbSqlMapper implements SubcommunityMapperInterface {

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
    
   
    
    //Subcommunity...
    
   
    public function getSubcommunitysList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        /*$statement = $this->dbAdapter->query("SELECT tbl_caste.*, tal.id as adminid, tal.username as username FROM tbl_caste 
                LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_caste.modified_by OR tal.id=tbl_caste.created_by ORDER BY `order_val` ASC");*/
        
        $statement = $this->dbAdapter->query("SELECT tbl_caste.*, community.community_name, tal.id as adminid, tal.username as username FROM tbl_caste 
                    LEFT JOIN community ON community.id=tbl_caste.community_id
                LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_caste.modified_by OR tal.id=tbl_caste.created_by ORDER BY `order_val` ASC");
        
        
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
            $resultSet = new HydratingResultSet($this->hydrator, new Subcommunitys());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function SaveSubcommunity($subcommunityObject) {
//                print_r($educationFieldsObject);
//                exit;
//        $subcommunityData = $this->hydrator->extract($subcommunityObject);
//        //print_r($educatioData);
//        //exit;
//        unset($subcommunityData['id']); // Neither Insert nor Update needs the ID in the array
//
//        if ($subcommunityObject->getId()) {
////            echo  "<pre>";
////            echo  "hello";exit;
//            $statement = $this->dbAdapter->query("UPDATE tbl_caste 
//                SET caste_name=:caste_name,
//                    is_active=:is_active
//                    WHERE id=:id");
//            //Debug::dump($id);
//            //exit;
//            $parameters = array(
//                'id' => $subcommunityObject->getId(),
//                'caste_name' => $subcommunityObject->getCommunityName(),
//                'is_active' => $subcommunityObject->getIsActive(),
//            );
//            $result = $statement->execute($parameters);
//            
//            if ($result)
//                    return "success";
//                else
//                    return "couldn't update";
//        } else {
//             $statement = $this->dbAdapter->query("INSERT INTO tbl_caste 
//                 (caste_name, is_active, created_date)
//                 values(:caste_name, :is_active, now())");
//                 
//           
//            $parameters = array(
//                'caste_name' => $subcommunityObject->getCommunityName(),
//                'is_active' => $subcommunityObject->getIsActive(),
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
//                $subcommunityObject->setId($newId);
//            }
//
//            //print_r($educationFieldsObject);
//            //exit;
//            
//        }
         if ($subcommunityObject['id']) {
           
            $postData = array();
            $postData['caste_name'] = $subcommunityObject['caste_name'];
            $postData['is_active'] = $subcommunityObject['is_active'];
            $postData['community_id'] = $subcommunityObject['community_id'];
            //$postData['master_country_id'] = $subcommunityObject['master_country_id'];            
            //$postData['image']      =  $subcommunityObject['image'];
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['modified_by']      = $subcommunityObject[0];
            $postData['created_by']      = $subcommunityObject[0];
            $postData['ip']      = $subcommunityObject[2];
            

            

            $action = new Update('tbl_caste');
            $action->set($postData);
            $action->where(array('id = ?' => $subcommunityObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } else {

            
            $postData = array();
            $postData['caste_name'] = $subcommunityObject['caste_name'];
            $postData['is_active'] = $subcommunityObject['is_active'];
            $postData['community_id'] = $subcommunityObject['community_id'];
            //$postData['master_country_id'] = $subcommunityObject['master_country_id'];            
            //$postData['image']      =  $subcommunityObject['image'];
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $subcommunityObject[0];
            $postData['ip']      = $subcommunityObject[2];
            

            

            $action = new Insert('tbl_caste');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
            //case 2:
            $postData2 = array();
            $subcommunityId = $result->getGeneratedValue();
            $postData2['order_val'] = $subcommunityId;
            
            $action2 = new Update('community');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $subcommunityId));
            $sql2 = new Sql($this->dbAdapter);
            $stmt2 = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt2->execute();
            
            if ($result)
                return "success";
            else
                return "couldn't update";
       }
        
    }
    
    public function getSubcommunity($id) {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_caste WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Subcommunitys());
        }
    }
    
    
    /*public function subcommunitySearch($data) {
//        echo   "<pre>";
//        echo  $data;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_caste WHERE caste_name like '" . $data . "%'");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Subcommunitys());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }*/
    
    public function subcommunitySearch($data,$field) {
//        echo   "<pre>";
//        echo  $field;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        
        $communityid = (empty($fieldname = $field))?"":" && tbl_caste.community_id=".$field;
//        \Zend\Debug\Debug::dump($statement);exit;
        //$statement = $this->dbAdapter->query("SELECT * FROM community WHERE community_name like '" . $data . "%'");
        $statement = $this->dbAdapter->query("select * from tbl_caste inner join community on tbl_caste.community_id = community.id
            where (tbl_caste.caste_name like '$data%' ".$communityid.")");

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
            $resultSet = new HydratingResultSet($this->hydrator, new Subcommunitys());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    /*public function performSearchSubcommunity($field) {
//        echo   "<pre>";
//        echo  $field;exit;
        $field1 = empty($field) ? "" : "caste_name like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_caste WHERE " . $field1 . "");
        

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
            $resultSet = new HydratingResultSet($this->hydrator, new Subcommunitys());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }*/
    
    public function performSearchSubcommunity($field,$field2) {
//        echo   "<pre>";
//        echo  $field2;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
//        $field1 = empty($field) ? "" : "country_name like '" . $field . "%' &&";
//        $field4 = empty($field2) ? "" : "country_code like '" . $field2 . "%' &&";
//        $field5 = empty($field3) ? "" : "dial_code like '" . $field3 . "%' ";
        $field3 = empty($field)? "": "tbl_caste.community_id= '".$field."' &&";   
        $field4 = empty($field2)? "": " tbl_caste.caste_name like '".$field2."%' "; 
        
//        $sql = "select * from tbl_country where " . $field1 . $field4 . $field5 . "";
        
        $sql = "select tbl_caste.*,community.community_name AS community_name from tbl_caste inner join 
             community on tbl_caste.community_id = community.id 
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
            $resultSet = new HydratingResultSet($this->hydrator, new Subcommunitys());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function getSubcommunityRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT tbl_caste.* , community.community_name ,tal.id as adminid, tal.username as username  FROM tbl_caste LEFT JOIN community ON community.id=tbl_caste.community_id  LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_caste.modified_by OR tal.id=tbl_caste.created_by WHERE tbl_caste.is_active=:is_active");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Subcommunitys());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }  else {
            return FALSE;
        }
    }
    
    public function viewBySubcommunityId($table, $id) {

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
            return $this->hydrator->hydrate($result->current(), new Subcommunitys());
        }
        //print_r($result->current());exit;
//        if ($result) {
//            $respArr = array('status' => "Deleted SuccessFully");getCommunityList
//        } else {
//            $respArr = array('status' => "Couldn't deleted");
//        }
//
        //return $result;
    }
    
    public function getAllCommunitylist() {
        
        $statement = $this->dbAdapter->query("SELECT id,community_name FROM community WHERE 1");
        
        $result = $statement->execute();
        
        foreach ($result as $list) {
            $communitynamelist[$list['id']] = $list['community_name'];
        }
        
        return $communitynamelist;
        

    }
    
   
}
