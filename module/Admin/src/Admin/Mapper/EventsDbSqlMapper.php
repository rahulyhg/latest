<?php

namespace Admin\Mapper;

use Admin\Model\Entity\Events;
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

class EventsDbSqlMapper implements EventsMapperInterface {

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
    
    
    public function customFieldsCity() {        
        
        $statement = $this->dbAdapter->query("SELECT id,city_name FROM tbl_city WHERE 1");
        
        $result = $statement->execute();
        
        foreach ($result as $list) {
            $citynamelist[$list['id']] = $list['city_name'];
        }
        
        return $citynamelist;        
   
    }
    public function getCityByStateId($state_id) {        
        $state_id=$state_id;
        $statement = $this->dbAdapter->query("SELECT id,city_name FROM tbl_city WHERE state_id=$state_id");
        
        $result = $statement->execute();
        
        foreach ($result as $list) {
            $citynamelist[$list['id']] = $list['city_name'];
        }
        
        return $citynamelist;        
   
    }
    //Events
    
    
    public function getEventsList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT tbl_event.*,tbl_country.country_name,tbl_city.city_name,tal.id as adminid, tal.username as username
             FROM `tbl_event` LEFT JOIN tbl_country ON(tbl_event.event_country=tbl_country.id)  LEFT JOIN tbl_city 
ON(tbl_event.event_city=tbl_city.id) LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_event.modified_by OR tal.id=tbl_event.created_by ORDER BY order_val ASC;");
        
        
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
            $resultSet = new HydratingResultSet($this->hydrator, new Events());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function saveEvents($eventsObject) {
        
        //Debug::dump($eventsObject);exit;
        
        $sql = new Sql($this->dbAdapter);

        if ($eventsObject['event_id']) {
            //echo  "hello";exit;

            $postData = array();
            $date = date_create($eventsObject['event_date']);

            $postData['event_title'] = $eventsObject['event_title'];
            $postData['event_desc'] = $eventsObject['event_desc'];
            $postData['event_date'] = date_format($date, "Y-m-d H:i:s");
            $postData['event_start_time'] = $eventsObject['event_start_time'];
            $postData['event_end_time'] = $eventsObject['event_end_time'];
            $postData['event_country'] = $eventsObject['event_country'];
            $postData['event_state'] = $eventsObject['event_state'];
            $postData['event_city'] = $eventsObject['event_city'];
            $postData['event_branch_id'] = $eventsObject['event_branch_id'];
            $postData['event_branch_other'] = $eventsObject['event_branch_other'];
            $postData['event_venue'] = $eventsObject['event_venue'];
            //$postData['spons_address']      = $eventsObject['image'];
            $postData['is_active'] = $eventsObject['is_active'];
            if ($eventsObject['post_image_flag'] == 1) {
                $postData['image'] = $eventsObject['image'];
            }
            $postData['modified_by'] = $eventsObject['user_id'];


            $action = new Update('tbl_event');
            $action->set($postData);
            $action->where(array('event_id = ?' => $eventsObject['event_id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();


            if (isset($eventsObject['sponser_event_id'])) {
                foreach ($eventsObject['sponser_event_id'] as $key => $value) {
                    if (isset($value) && $value != '') {

                        $sponserData['spons_id'] = $eventsObject['spons_id'][$key];
                        $sponserData['spons_type_id'] = $eventsObject['spons_type_id'][$key];
                        
                        $action = new Update('tbl_event_sponser_ext');
                        $action->set($sponserData);
                        $action->where(array('event_sponser_ext_id' => $value));
                        $stmt = $sql->prepareStatementForSqlObject($action);
                        $result = $stmt->execute();
                    }
                }

                
            }
           
            if (isset($eventsObject['organiser_event_id'])) {
                foreach ($eventsObject['organiser_event_id'] as $key => $value) {
                    if (isset($value) && $value != '') {

                        $organiserData['organiser_id'] = $eventsObject['organiser_id'][$key];
                                               
                        $action = new Update('tbl_event_organiser_ext');
                        $action->set($organiserData);
                        $action->where(array('event_organiser_ext_id = ?' => $value));
                        $stmt = $sql->prepareStatementForSqlObject($action);
                        $result = $stmt->execute();
                    }
                }

                
            }
            
            //add some more organiser and sponser
            
            if (isset($eventsObject['new_spons_id'])) {
                foreach ($eventsObject['new_spons_id'] as $key => $value) {
                    if (isset($value) && $value != '') {

                        $newSponserData['spons_id'] = $eventsObject['new_spons_id'][$key];
                        $newSponserData['spons_type_id'] = $eventsObject['new_spons_type_id'][$key];
                        $newSponserData['event_id'] = $eventsObject['event_id'];
                        $newSponserData['subevent_id'] = 0;
                        $newSponserData['created_date'] = date("Y-m-d h:i:s");

                        $action = new Insert('tbl_event_sponser_ext');
                        $action->values($newSponserData);
                        $stmt = $sql->prepareStatementForSqlObject($action);
                        $result = $stmt->execute();
                    }
                }
            }
            
            if (isset($eventsObject['new_organiser_id'])) {
                foreach ($eventsObject['new_organiser_id'] as $key => $value) {
                    if (isset($value) && $value != '') {

                        $newOrganiserData['organiser_id'] = $eventsObject['new_organiser_id'][$key];
                        $newOrganiserData['event_id'] = $eventsObject['event_id'];
                        $newOrganiserData['subevent_id'] = 0;
                        $newOrganiserData['created_date'] = date("Y-m-d h:i:s");

                        $action = new Insert('tbl_event_organiser_ext');
                        $action->values($newOrganiserData);
                        $stmt = $sql->prepareStatementForSqlObject($action);
                        $result = $stmt->execute();
                    }
                }
            }


            if ($eventsObject['post_image_flag'] == 1) {
                $image = EVENTS_IMAGE_PATH . $eventsObject['post_image_update'];
                $image_thumb = EVENTS_IMAGE_THUMB_PATH . $eventsObject['post_image_update'];
                unlink($image);
                unlink($image_thumb);
            }
        } else {

//            
            //added by amir

            $date = date_create($eventsObject['event_date']);

            $postData = array();
            $postData['event_title'] = $eventsObject['event_title'];
            $postData['event_desc'] = $eventsObject['event_desc'];
            $postData['event_date'] = date_format($date, "Y-m-d H:i:s");
            $postData['event_start_time'] = $eventsObject['event_start_time'];
            $postData['event_end_time'] = $eventsObject['event_end_time'];
            $postData['event_country'] = $eventsObject['event_country'];
            $postData['event_state'] = $eventsObject['event_state'];
            $postData['event_city'] = $eventsObject['event_city'];
            $postData['event_branch_id'] = ($event_branch_id = isset($eventsObject['event_branch_id']) ? $eventsObject['event_branch_id'] : 0);
            $postData['event_branch_other'] = $eventsObject['event_branch_other'];
            $postData['event_venue'] = $eventsObject['event_venue'];
            $postData['image'] = $eventsObject['image'];
            $postData['is_active'] = $eventsObject['is_active'];
            $postData['created_date'] = date("Y-m-d h:i:s");
            $postData['created_by'] = $eventsObject[0];
            $postData['ip'] = $eventsObject[2];

//            echo "<pre>";
//            print_r($postData['image']);exit;


            $action = new Insert('tbl_event');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            $eventId = $result->getGeneratedValue();
            //\Zend\Debug\Debug::dump($data);exit;
            //for sponser master
            $postData2 = array();
            $size = count($eventsObject['spons_id']);
//            echo $size;exit;
            //$eventId = $this->tableGateway->lastInsertValue;
            //$eventId = $this->tableGateway->adapter->getDriver()->getLastGeneratedValue();
            //echo  $eventId;exit;
            for ($i = 0; $i < $size; $i++) {
                $postData2['spons_id'] = $eventsObject['spons_id'][$i];
                $postData2['spons_type_id'] = $eventsObject['spons_type_id'][$i];
                $postData2['event_id'] = $eventId;
                $postData2['subevent_id'] = 0;
                $postData2['created_date'] = date("Y-m-d h:i:s");
                $postData2['ip'] = $eventsObject[2];

                $action2 = new Insert('tbl_event_sponser_ext');
                $action2->values($postData2);
                //$action->set($postData);
                //$action->where(array('spons_id = ?' => $sponsermasterObject['spons_id']));
                $sql2 = new Sql($this->dbAdapter);
                $stmt = $sql2->prepareStatementForSqlObject($action2);
                $result = $stmt->execute();
            }


            //for sponser organizer
            $postData3 = array();
            $size2 = count($eventsObject['organiser_id']);
//            echo $size;exit;
            //$eventId = $this->tableGateway->lastInsertValue;
            //$eventId = $this->tableGateway->adapter->getDriver()->getLastGeneratedValue();
            //echo  $eventId;exit;
            for ($i = 0; $i < $size2; $i++) {
                $postData3['organiser_id'] = $eventsObject['organiser_id'][$i];
                $postData3['event_id'] = $eventId;
                $postData3['subevent_id'] = 0;
                $postData3['created_date'] = date("Y-m-d h:i:s");
                $postData3['ip'] = $eventsObject[2];

                $action3 = new Insert('tbl_event_organiser_ext');
                $action3->values($postData3);
                //$action->set($postData);
                //$action->where(array('spons_id = ?' => $sponsermasterObject['spons_id']));
                $sql3 = new Sql($this->dbAdapter);
                $stmt = $sql3->prepareStatementForSqlObject($action3);
                $result = $stmt->execute();
            }
        }
    }

    public function viewByEventsId($table, $id) {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
       /* SELECT tbl_upcoming_events.*,tbl_country.country_name,tbl_state.state_name, tbl_city.city_name FROM tbl_upcoming_events LEFT JOIN 

tbl_country ON(tbl_upcoming_events.country_id=tbl_country.id)  LEFT JOIN tbl_state

ON(tbl_upcoming_events.state_id=tbl_state.id)  LEFT JOIN tbl_city

ON(tbl_upcoming_events.city_id=tbl_city.id) WHERE tbl_upcoming_events.id=:id*/
        
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_event WHERE event_id=:event_id");
        
        $parameters = array(
            'event_id' => $id,
        );
        
        $result = $statement->execute($parameters);
        
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Events());
        }
    }
    
    public function getEvents($id) {
        //$statement = $this->dbAdapter->query("SELECT * FROM tbl_event WHERE event_id=:event_id");
        //SELECT ev.*, ese.spons_id,ese
               //.spons_type_id FROM tbl_event ev LEFT JOIN  tbl_event_sponser_ext ese ON(ev.event_id=ese.event_id) WHERE ev.event_id=:event_id
//        $statement = $this->dbAdapter->query("SELECT ev.*, ese.spons_id,ese
//               .spons_type_id FROM tbl_event ev LEFT JOIN  tbl_event_sponser_ext ese ON(ev.event_id=ese.event_id) WHERE ev.event_id=:event_id" );
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_event WHERE event_id=:event_id");
        $parameters = array(
            'event_id' => $id
        );
        $result = $statement->execute($parameters);
        /*if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //return $this->hydrator->hydrate($result, new Events());
            $resultSet = new HydratingResultSet($this->hydrator, new Events());
             return $resultSet->initialize($result);
        }*/
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //$resultSet = new HydratingResultSet($this->hydrator, new Events());

           // return $resultSet->initialize($result);
            return $this->hydrator->hydrate($result->current(), new Events());
        }
    }
    
    public function getSponserByEventId($event_id) {
        
        
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_event_sponser_ext WHERE event_id=:event_id AND subevent_id=0");
        $parameters = array(
            'event_id' => $event_id
        );
        $result = $statement->execute($parameters);
        //return $event_id;exit;
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
           return $this->resultSet->initialize($result)->toArray();
           
        }
    }
    
    public function getOrganiserByEventId($event_id) {
        
        
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_event_organiser_ext WHERE event_id=:event_id AND subevent_id=0");
        $parameters = array(
            'event_id' => $event_id
        );
        $result = $statement->execute($parameters);
        //return $event_id;exit;
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
           return $this->resultSet->initialize($result)->toArray();
           
        }
    }
    
    public function getallSponsermaster() {
        
        $statement = $this->dbAdapter->query("SELECT spons_id,spons_name FROM tbl_sponser_master WHERE 1");
        
        $result = $statement->execute();
        
        foreach ($result as $list) {
            $sponsermasterlist[$list['spons_id']] = $list['spons_name'];
        }
        
        return $sponsermasterlist;
        

    }
    
    public function getallSponsertype() {
        
        $statement = $this->dbAdapter->query("SELECT spons_type_id,spons_type_title FROM tbl_sponser_type_master WHERE 1");
        
        $result = $statement->execute();
        
        foreach ($result as $list) {
            $sponsertypelist[$list['spons_type_id']] = $list['spons_type_title'];
        }
        
        return $sponsertypelist;
        

    }
    
    public function getallOrganiser() {
        
        $statement = $this->dbAdapter->query("SELECT tbl_user.id as organiser_id,tbl_user_info.full_name FROM tbl_user LEFT JOIN tbl_user_info ON tbl_user.id=tbl_user_info.user_id AND 

tbl_user.user_type_id=tbl_user_info.user_type_id WHERE  tbl_user.user_type_id=1 AND tbl_user_info.user_type_id=1");
        
        
        
        $result = $statement->execute();
        
        foreach ($result as $list) {
            $organiserlist[$list['organiser_id']] = $list['full_name'];
        }
        
        return $organiserlist;
        

    }
    
    public function changeStatus($table, $id, $data) {
        $statement = $this->dbAdapter->query("UPDATE $table SET is_active=:is_active WHERE event_id=:event_id");
        //Debug::dump($id);
        //exit;
        $parameters = array(
            'event_id' => $id,
            'is_active' => $data['is_active']
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
        $statement = $this->dbAdapter->query("DELETE FROM $table where event_id=:event_id");
        //Debug::dump($statement);exit;
        $parameters = array(
            'event_id' => $id
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
    
    
}
