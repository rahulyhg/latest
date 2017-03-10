<?php

namespace Admin\Mapper;

use Admin\Model\Entity\Subevents;
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

class SubeventsDbSqlMapper implements SubeventsMapperInterface {

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

    //Events


    public function getSubeventsList() {
        //echo  "hello";exit;
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT tbl_subevent.*,tal.id as adminid, tal.username as username
             FROM `tbl_subevent` LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_subevent.modified_by OR tal.id=tbl_subevent.created_by ORDER BY order_val ASC");


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
            $resultSet = new HydratingResultSet($this->hydrator, new Subevents());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }

    public function saveSubevents($subeventsObject) {

       // Debug::dump($subeventsObject);exit;
        $sql = new Sql($this->dbAdapter);

        if ($subeventsObject['subevent_id']) {
            //echo "hello";
            //exit;

            $postData = array();
            $startdate = date_create($subeventsObject['start_date']);
            $enddate = date_create($subeventsObject['end_date']);
            
            //Debug::dump($startdate);exit;
            
            $postData['event_id'] = $subeventsObject['event_id'];
            $postData['title'] = $subeventsObject['title'];
            $postData['start_date'] = date_format($startdate, "Y-m-d");
            $postData['end_date'] = date_format($enddate, "Y-m-d");
            $postData['start_time'] = $subeventsObject['start_time'];
            $postData['end_time'] = $subeventsObject['end_time'];
            $postData['fees'] = $subeventsObject['fees'];
            $postData['venue'] = $subeventsObject['venue'];
            $postData['is_active'] = $subeventsObject['is_active'];
            if ($subeventsObject['post_image_flag'] == 1) {
                $postData['image'] = $subeventsObject['image'];
            }
            $postData['modified_by'] = $subeventsObject['user_id'];

            $action = new Update('tbl_subevent');
            $action->set($postData);
            $action->where(array('subevent_id = ?' => $subeventsObject['subevent_id']));
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            
            
            if (isset($subeventsObject['sponser_event_id'])) {
                foreach ($subeventsObject['sponser_event_id'] as $key => $value) {
                    if (isset($value) && $value != '') {

                        $sponserData['spons_id'] = $subeventsObject['spons_id'][$key];
                        $sponserData['spons_type_id'] = $subeventsObject['spons_type_id'][$key];
                        
                        $action = new Update('tbl_event_sponser_ext');
                        $action->set($sponserData);
                        $action->where(array('event_sponser_ext_id' => $value));
                        $stmt = $sql->prepareStatementForSqlObject($action);
                        $result = $stmt->execute();
                    }
                }

                
            }
           
            if (isset($subeventsObject['organiser_event_id'])) {
                foreach ($subeventsObject['organiser_event_id'] as $key => $value) {
                    if (isset($value) && $value != '') {

                        $organiserData['organiser_id'] = $subeventsObject['organiser_id'][$key];
                                               
                        $action = new Update('tbl_event_organiser_ext');
                        $action->set($organiserData);
                        $action->where(array('event_organiser_ext_id = ?' => $value));
                        $stmt = $sql->prepareStatementForSqlObject($action);
                        $result = $stmt->execute();
                    }
                }

                
            }
            
            //add some more organiser and sponser
            
            if (isset($subeventsObject['new_spons_id'])) {
                foreach ($subeventsObject['new_spons_id'] as $key => $value) {
                    if (isset($value) && $value != '') {

                        $newSponserData['spons_id'] = $subeventsObject['new_spons_id'][$key];
                        $newSponserData['spons_type_id'] = $subeventsObject['new_spons_type_id'][$key];
                        $newSponserData['event_id'] = $subeventsObject['event_id'];
                        $newSponserData['subevent_id'] = $subeventsObject['subevent_id'];
                        $newSponserData['created_date'] = date("Y-m-d h:i:s");

                        $action = new Insert('tbl_event_sponser_ext');
                        $action->values($newSponserData);
                        $stmt = $sql->prepareStatementForSqlObject($action);
                        $result = $stmt->execute();
                    }
                }
            }
            
            if (isset($subeventsObject['new_organiser_id'])) {
                foreach ($subeventsObject['new_organiser_id'] as $key => $value) {
                    if (isset($value) && $value != '') {

                        $newOrganiserData['organiser_id'] = $subeventsObject['new_organiser_id'][$key];
                        $newOrganiserData['event_id'] = $subeventsObject['event_id'];
                        $newOrganiserData['subevent_id'] = $subeventsObject['subevent_id'];
                        $newOrganiserData['created_date'] = date("Y-m-d h:i:s");

                        $action = new Insert('tbl_event_organiser_ext');
                        $action->values($newOrganiserData);
                        $stmt = $sql->prepareStatementForSqlObject($action);
                        $result = $stmt->execute();
                    }
                }
            }
            
            if ($subeventsObject['post_image_flag'] == 1) {
                $image = SUBEVENTS_IMAGE_PATH . $subeventsObject['post_image_update'];
                $image_thumb = SUBEVENTS_IMAGE_THUMB_PATH . $subeventsObject['post_image_update'];
                unlink($image);
                unlink($image_thumb);
            }
        } else {


            $sdate = date_create($subeventsObject['start_date']);
            $edate = date_create($subeventsObject['end_date']);
            $eventId = $subeventsObject['event_id'];

            $postData = array();
            $postData['title'] = $subeventsObject['title'];
            $postData['event_id'] = $eventId;
            $postData['start_date'] = date_format($sdate, "Y-m-d H:i:s");
            $postData['end_date'] = date_format($edate, "Y-m-d H:i:s");
            $postData['start_time'] = $subeventsObject['start_time'];
            $postData['end_time'] = $subeventsObject['end_time'];
            $postData['fees'] = $subeventsObject['fees'];
            $postData['venue'] = $subeventsObject['venue'];
            $postData['image'] = $subeventsObject['image'];
            $postData['is_active'] = $subeventsObject['is_active'];
            $postData['created_date'] = date("Y-m-d h:i:s");
            $postData['created_by'] = $subeventsObject[0];
            $postData['ip'] = $subeventsObject[2];

            $action = new Insert('tbl_subevent');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            $subeventId = $result->getGeneratedValue();
           
            //for sponser master
            
            $postData2 = array();
            $size = count($subeventsObject['spons_id']);

            for ($i = 0; $i < $size; $i++) {
                $postData2['spons_id'] = $subeventsObject['spons_id'][$i];
                $postData2['spons_type_id'] = $subeventsObject['spons_type_id'][$i];
                $postData2['event_id'] = $eventId;
                $postData2['subevent_id'] = $subeventId;
                $postData2['created_date'] = date("Y-m-d h:i:s");
                $postData2['ip'] = $subeventsObject[2];

                $action2 = new Insert('tbl_event_sponser_ext');
                $action2->values($postData2);
                $sql2 = new Sql($this->dbAdapter);
                $stmt = $sql2->prepareStatementForSqlObject($action2);
                $result = $stmt->execute();
            }


            //for sponser organizer
            $postData3 = array();
            $size2 = count($subeventsObject['organiser_id']);

            for ($i = 0; $i < $size2; $i++) {
                $postData3['organiser_id'] = $subeventsObject['organiser_id'][$i];
                $postData3['event_id'] = $eventId;
                $postData3['subevent_id'] = $subeventId;
                $postData3['created_date'] = date("Y-m-d h:i:s");
                $postData3['ip'] = $subeventsObject[2];

                $action3 = new Insert('tbl_event_organiser_ext');
                $action3->values($postData3);
                $sql3 = new Sql($this->dbAdapter);
                $stmt = $sql3->prepareStatementForSqlObject($action3);
                $result = $stmt->execute();
            }
        }
    }

    public function customFieldsCity() {
        //echo  "hello";exit;
        $statement = $this->dbAdapter->query("SELECT id,city_name FROM tbl_city WHERE 1");

        $result = $statement->execute();

        foreach ($result as $list) {
            $citynamelist[$list['id']] = $list['city_name'];
        }

        return $citynamelist;
    }

    public function viewBySubeventsId($table, $id) {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        /* SELECT tbl_upcoming_events.*,tbl_country.country_name,tbl_state.state_name, tbl_city.city_name FROM tbl_upcoming_events LEFT JOIN 

          tbl_country ON(tbl_upcoming_events.country_id=tbl_country.id)  LEFT JOIN tbl_state

          ON(tbl_upcoming_events.state_id=tbl_state.id)  LEFT JOIN tbl_city

          ON(tbl_upcoming_events.city_id=tbl_city.id) WHERE tbl_upcoming_events.id=:id */

        $statement = $this->dbAdapter->query("SELECT * FROM tbl_subevent WHERE subevent_id=:subevent_id");

        $parameters = array(
            'subevent_id' => $id,
        );

        $result = $statement->execute($parameters);


        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Subevents());
        }
    }

    public function getSubevents($id) {
        //$statement = $this->dbAdapter->query("SELECT * FROM tbl_event WHERE event_id=:event_id");
        //SELECT ev.*, ese.spons_id,ese
        //.spons_type_id FROM tbl_event ev LEFT JOIN  tbl_event_sponser_ext ese ON(ev.event_id=ese.event_id) WHERE ev.event_id=:event_id
//        $statement = $this->dbAdapter->query("SELECT ev.*, ese.spons_id,ese
//               .spons_type_id FROM tbl_event ev LEFT JOIN  tbl_event_sponser_ext ese ON(ev.event_id=ese.event_id) WHERE ev.event_id=:event_id" );
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_subevent WHERE subevent_id=:subevent_id");
        $parameters = array(
            'subevent_id' => $id
        );
        $result = $statement->execute($parameters);
//        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
//            //return $this->hydrator->hydrate($result, new Events());
//            $resultSet = new HydratingResultSet($this->hydrator, new Events());
//             return $resultSet->initialize($result);
//        }

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //$resultSet = new HydratingResultSet($this->hydrator, new Events());
            //return $resultSet->initialize($result);
            return $this->hydrator->hydrate($result->current(), new Subevents());
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

    public function getallEvents() {
        $date = date('Y-m-d h:i:s');
        $statement = $this->dbAdapter->query("SELECT event_id,event_title FROM tbl_event WHERE is_active=1 AND (event_date<'" . $date . "') ");

        $result = $statement->execute();

        foreach ($result as $list) {
            $eventnamelist[$list['event_id']] = $list['event_title'];
        }

        return $eventnamelist;
    }

    public function changeStatus($table, $id, $data) {
        $statement = $this->dbAdapter->query("UPDATE $table SET is_active=:is_active WHERE subevent_id=:subevent_id");
        //Debug::dump($id);
        //exit;
        $parameters = array(
            'subevent_id' => $id,
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
        $statement = $this->dbAdapter->query("DELETE FROM $table where subevent_id=:subevent_id");
        //Debug::dump($statement);exit;
        $parameters = array(
            'subevent_id' => $id
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

     public function getSponserBySubEventId($subevent_id) {
        
        
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_event_sponser_ext WHERE subevent_id=:subevent_id");
        $parameters = array(
            'subevent_id' => $subevent_id
        );
        $result = $statement->execute($parameters);
        //return $event_id;exit;
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
           return $this->resultSet->initialize($result)->toArray();
           
        }
    }
    
    public function getOrganiserBySubEventId($subevent_id) {
        
        
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_event_organiser_ext WHERE subevent_id=:subevent_id");
        $parameters = array(
            'subevent_id' => $subevent_id
        );
        $result = $statement->execute($parameters);
        //return $event_id;exit;
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
           return $this->resultSet->initialize($result)->toArray();
           
        }
    }
    
}
