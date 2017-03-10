<?php

namespace Admin\Mapper;

use Admin\Model\Entity\Branchs;
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

class BranchDbSqlMapper implements BranchMapperInterface {      

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
    
   
    
    //Branch
    
   
    public function getBranchList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT tbl_rustagi_branches.*, tbl_city.city_name,tbl_state.state_name,tbl_country.country_name, tal.id as adminid, tal.username as username 
                                            FROM tbl_rustagi_branches left join tbl_city on tbl_rustagi_branches.branch_city_id=tbl_city.id left join tbl_state on tbl_state.id=tbl_city.state_id 
                                                left join tbl_country on tbl_country.id=tbl_state.country_id LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_rustagi_branches.modified_by 
                                                OR tal.id=tbl_rustagi_branches.created_by ORDER BY `order_val` ASC;");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Branchs());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function SaveBranch($branchObject) {
//                print_r($branchObject);
//                exit;
//        $branchData = $this->hydrator->extract($branchObject);
//        //print_r($educatioData);
//        //exit;
//        unset($branchData['id']); // Neither Insert nor Update needs the ID in the array
//
//        if ($branchObject->getId()) {
////            echo  "<pre>";
////            echo  "hello";exit;
//            $statement = $this->dbAdapter->query("UPDATE tbl_rustagi_branches 
//                SET branch_name=:branch_name,
//                    is_active=:is_active
//                    WHERE id=:id");
//            //Debug::dump($id);
//            //exit;
//            $parameters = array(
//                'id' => $branchObject->getId(),
//                'branch_name' => $branchObject->getBranchName(),
//                'is_active' => $branchObject->getIsActive(),
//            );
//            $result = $statement->execute($parameters);
//            
//            if ($result)
//                    return "success";
//                else
//                    return "couldn't update";
//        } else {
//             $statement = $this->dbAdapter->query("INSERT INTO tbl_rustagi_branches 
//                 (branch_name, is_active, created_date)
//                 values(:branch_name, :is_active, now())");
//                 
//           
//            $parameters = array(
//                'branch_name' => $branchObject->getBranchName(),
//                'is_active' => $branchObject->getIsActive(),
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
//                $branchObject->setId($newId);
//            }
//
//            //print_r($educationFieldsObject);
//            //exit;
//            
//        }
        if ($branchObject['branch_id']) {
           
            $postData = array();
            $postData['branch_name'] = $branchObject['branch_name'];
            $postData['is_active'] = $branchObject['is_active'];
            $postData['branch_city_id'] = $branchObject['branch_city_id'];
            //$postData['master_country_id'] = $branchObject['master_country_id'];            
            //$postData['image']      =  $branchObject['image'];
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['modified_by']      = $branchObject[0];
            $postData['created_by']      = $branchObject[0];
            $postData['ip']      = $branchObject[2];
            

            

            $action = new Update('tbl_rustagi_branches');
            $action->set($postData);
            $action->where(array('branch_id = ?' => $branchObject['branch_id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if ($result)
                return "success";
            else
                return "couldn't update";
            
        } else {

            
            $postData = array();
            $postData['branch_name'] = $branchObject['branch_name'];
            $postData['is_active'] = $branchObject['is_active'];
            $postData['branch_city_id'] = $branchObject['branch_city_id'];
            //$postData['master_country_id'] = $branchObject['master_country_id'];            
            //$postData['image']      =  $branchObject['image'];
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['modified_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $branchObject[0];
            $postData['ip']      = $branchObject[2];
            

            

            $action = new Insert('tbl_rustagi_branches');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
            //case 2:
            $postData2 = array();
            $branchId = $result->getGeneratedValue();
            $postData2['order_val'] = $branchId;
            
            $action2 = new Update('tbl_rustagi_branches');
            $action2->set($postData2);
            $action2->where(array('id = ?' => $branchId));
            $sql2 = new Sql($this->dbAdapter);
            $stmt2 = $sql->prepareStatementForSqlObject($action2);
            $result2 = $stmt2->execute();
            
            if ($result)
                return "success";
            else
                return "couldn't update";
       }
        
    }
    
     public function getBranch($id) {
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_rustagi_branches WHERE branch_id=:branch_id");
        $statement = $this->dbAdapter->query("select tbl_state.country_id as country,tbl_city.state_id as state,tbl_rustagi_branches.*
from tbl_rustagi_branches left join tbl_city on tbl_rustagi_branches.branch_city_id=tbl_city.id left join tbl_state on tbl_city.state_id=tbl_state.id
where tbl_rustagi_branches.branch_id=:branch_id;");
        $parameters = array(
            'branch_id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Branchs());
        }
    }
    
    public function branchSearch($data) {
//        echo   "<pre>";
//        echo  $data;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_rustagi_branches WHERE branch_name like '" . $data . "%'");
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
            $resultSet = new HydratingResultSet($this->hydrator, new Branchs());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function performSearchBranch($field) {
//        echo   "<pre>";
//        echo  $field;exit;
        $field1 = empty($field) ? "" : "branch_name like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_rustagi_branches WHERE " . $field1 . "");
        

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
            $resultSet = new HydratingResultSet($this->hydrator, new Branchs());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function getBranchRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT tbl_rustagi_branches.*, tbl_city.city_name,tbl_state.state_name,tbl_country.country_name, tal.id as adminid, tal.username as username 
                                            FROM tbl_rustagi_branches left join tbl_city on tbl_rustagi_branches.branch_city_id=tbl_city.id left join tbl_state on tbl_state.id=tbl_city.state_id 
                                                left join tbl_country on tbl_country.id=tbl_state.country_id LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_rustagi_branches.modified_by 
                                                OR tal.id=tbl_rustagi_branches.created_by   WHERE tbl_rustagi_branches.is_active=:is_active ORDER BY `order_val` ASC");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Branchs());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }  else {
            return FALSE;
        }
    }
    
    public function viewByBranchId($table, $id) {

        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM $table WHERE branch_id=:branch_id");
        //$adapter->query('SELECT * FROM `artist` WHERE `id` = ?', array(5));

        $parameters = array(
            'branch_id' => $id,
        );
        //print_r($statement);
        ///exit;
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Branchs());
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
    
    public function delete($table, $id) {
//        echo  "<pre>";
//        print_r($id);exit;
        $statement = $this->dbAdapter->query("DELETE FROM $table where branch_id=:branch_id");
        //Debug::dump($statement);exit;
        $parameters = array(
            'branch_id' => $id
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
    
    public function changeStatus($table, $id, $data, $modified_by) {
        $statement = $this->dbAdapter->query("UPDATE $table SET is_active=:is_active, modified_by=:modified_by, created_by=:created_by, modified_date=:modified_date WHERE branch_id=:branch_id");
//        Debug::dump($modified_by);
//        exit;
        $parameters = array(
            'branch_id' => $id,
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
        //print_r(explode(",",$ids));
        //exit;
        $ids = $this->dbAdapter->getPlatform()->quoteValueList(explode(",", $ids));
        //$placeholder=  str_repeat('?, ', count(explode(",",$ids))-1).'?';
        //echo $placeholder;
        //exit;
        $statement = $this->dbAdapter->query("UPDATE $table set is_active=:is_active where branch_id IN ($ids)");
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
        $statement = $this->dbAdapter->query("DELETE FROM $table where branch_id IN($ids)");

//        $parameters = array(
//            'ids' => $ids,
//        );
        $result = $statement->execute();
    }
    
    public function getBranchListByCityCode($City_ID) {
//            echo  "<pre>";
//            print_r($Country_ID);
//            exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_rustagi_branches 
                WHERE branch_city_id = :branch_city_id");
        $parameters = array(
            'branch_city_id' => $City_ID,
        );
                    
        $result = $statement->execute($parameters);
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Branchs());

            return $resultSet->initialize($result)->toArray();
           
        }
    }
    
    public function getBranchListByCountry($country_id) {
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
    
    public function getBranchByBranchId($table, $id) {

        //echo $id;exit;
        //$statement = $this->dbAdapter->query("SELECT * FROM $table WHERE branch_id=:branch_id");
        $statement = $this->dbAdapter->query("SELECT tbl_rustagi_branches.*, tbl_city.city_name,tbl_state.state_name,tbl_country.country_name, tal.id as adminid, tal.username as username 
                                            FROM tbl_rustagi_branches left join tbl_city on tbl_rustagi_branches.branch_city_id=tbl_city.id left join tbl_state on tbl_state.id=tbl_city.state_id 
                                                left join tbl_country on tbl_country.id=tbl_state.country_id LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_rustagi_branches.modified_by 
                                                OR tal.id=tbl_rustagi_branches.created_by  where
tbl_rustagi_branches.branch_id=:branch_id  ORDER BY `order_val` ASC;");
        
        
        //$adapter->query('SELECT * FROM `artist` WHERE `id` = ?', array(5));

        $parameters = array(
            'branch_id' => $id,
        );
        //print_r($statement);
        ///exit;
        $result = $statement->execute($parameters);
//        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
//            return $this->hydrator->hydrate($result->current(), new Branchs());
//        }
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Branchs());

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
   
    public function getBranchByBranchCityId($table, $id) {

        //echo $id;exit;
        //$statement = $this->dbAdapter->query("SELECT * FROM $table WHERE branch_id=:branch_id");
        $statement = $this->dbAdapter->query("SELECT tbl_rustagi_branches.*, tbl_city.city_name,tbl_state.state_name,tbl_country.country_name, tal.id as adminid, tal.username as username 
                                            FROM tbl_rustagi_branches left join tbl_city on tbl_rustagi_branches.branch_city_id=tbl_city.id left join tbl_state on tbl_state.id=tbl_city.state_id 
                                                left join tbl_country on tbl_country.id=tbl_state.country_id LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_rustagi_branches.modified_by 
                                                OR tal.id=tbl_rustagi_branches.created_by  where
tbl_rustagi_branches.branch_city_id=:branch_city_id  ORDER BY `order_val` ASC;");
        
        
        //$adapter->query('SELECT * FROM `artist` WHERE `id` = ?', array(5));

        $parameters = array(
            'branch_city_id' => $id,
        );
        //print_r($statement);
        ///exit;
        $result = $statement->execute($parameters);
//        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
//            return $this->hydrator->hydrate($result->current(), new Branchs());
//        }
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Branchs());

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
   
    
    
    
    
    

}
