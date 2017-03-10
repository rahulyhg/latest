<?php

namespace Admin\Service;

use Admin\Mapper\EventsMapperInterface;
use Admin\Service\EventsServiceInterface;

class EventsService implements EventsServiceInterface {

    protected $eventsMapper;

    public function __construct(EventsMapperInterface $eventsMapper) {
        $this->eventsMapper=$eventsMapper;
    }
    
   
    
    public function getAmmir() {
        return $this->eventsMapper->getAmmir();
    }
    
    //added by amir
    public function test() {
        return $this->eventsMapper->test();
    }    
    
    public function customFieldsCity() {
        return $this->eventsMapper->customFieldsCity();
    }
    
    //Events
    
    public function getEventsList() {
        return $this->eventsMapper->getEventsList();
    }
    
    public function saveEvents($eventsObject) {
        return $this->eventsMapper->saveEvents($eventsObject);
    }
    
    public function viewByEventsId($table, $id) {
        return $this->eventsMapper->viewByEventsId($table, $id);
    }
    
    public function getEvents($id) {
        return $this->eventsMapper->getEvents($id);
    }
        
    public function getallSponsermaster() {
        return $this->eventsMapper->getallSponsermaster();
    }
    
    public function getallSponsertype() {
        return $this->eventsMapper->getallSponsertype();
    }
    
    public function getallOrganiser() {
        return $this->eventsMapper->getallOrganiser();
    }
    
    public function delete($table, $id) {
        return $this->eventsMapper->delete($table, $id);
    }
    
    public function changeStatus($table, $id, $data) {
        return $this->eventsMapper->changeStatus($table, $id, $data);
    }
    
    public function getSponserByEventId($event_id) {
        return $this->eventsMapper->getSponserByEventId($event_id);
    }
    
    public function getOrganiserByEventId($event_id) {
        return $this->eventsMapper->getOrganiserByEventId($event_id);
    }
    public function getCityByStateId($state_id) {
        return $this->eventsMapper->getCityByStateId($state_id);
    }
   
    
    
    
    
}
