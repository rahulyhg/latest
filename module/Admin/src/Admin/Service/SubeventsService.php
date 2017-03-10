<?php

namespace Admin\Service;

use Admin\Mapper\SubeventsMapperInterface;
use Admin\Service\SubeventsServiceInterface;

class SubeventsService implements SubeventsServiceInterface {

    protected $subeventsMapper;

    public function __construct(SubeventsMapperInterface $subeventsMapper) {
        $this->subeventsMapper=$subeventsMapper;
    }
    
   
    
    public function getAmmir() {
        return $this->subeventsMapper->getAmmir();
    }
    
    //added by amir
    public function test() {
        return $this->subeventsMapper->test();
    }    
    
       
    //Events
    
    public function getSubeventsList() {
        return $this->subeventsMapper->getSubeventsList();
    }
    
    public function saveSubevents($subeventsObject) {
        return $this->subeventsMapper->saveSubevents($subeventsObject);
    }
    
    public function viewBySubeventsId($table, $id) {
        return $this->subeventsMapper->viewBySubeventsId($table, $id);
    }
    
    public function getSubevents($id) {
        return $this->subeventsMapper->getSubevents($id);
    }
    
    public function getallSponsermaster() {
        return $this->subeventsMapper->getallSponsermaster();
    }
    
    public function getallSponsertype() {
        return $this->subeventsMapper->getallSponsertype();
    }
    
    public function getallOrganiser() {
        return $this->subeventsMapper->getallOrganiser();
    }
    
    public function delete($table, $id) {
        return $this->subeventsMapper->delete($table, $id);
    }
    
    public function changeStatus($table, $id, $data) {
        return $this->subeventsMapper->changeStatus($table, $id, $data);
    }
    
    public function customFieldsCity() {
        return $this->subeventsMapper->customFieldsCity();
    }
    
    public function getallEvents() {
        return $this->subeventsMapper->getallEvents();
    }
    
     public function getSponserBySubEventId($subevent_id) {
        return $this->subeventsMapper->getSponserBySubEventId($subevent_id);
    }
    
    public function getOrganiserBySubEventId($subevent_id) {
        return $this->subeventsMapper->getOrganiserBySubEventId($subevent_id);
    }
    
    
   
    
    
    
    
}
