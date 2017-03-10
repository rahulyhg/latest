<?php

namespace Admin\Service;

use Admin\Mapper\EventmasterMapperInterface;
use Admin\Service\EventmasterServiceInterface;

class EventmasterService implements EventmasterServiceInterface {

    protected $eventmasterMapper;

    public function __construct(EventmasterMapperInterface $eventmasterMapper) {
        $this->eventmasterMapper=$eventmasterMapper;
    }
    
    //education field
    
    public function getAmmir() {
        return $this->awardMapper->getAmmir();
    }
    
    public function getAmmirById($id) {
        return $this->awardMapper->getAmmirById($id);
    }
    
    public function test() {
        return $this->eventmasterMapper->test();
    }
    
     //Eventmaster
    
    public function getEventmasterList($status) {
        return $this->eventmasterMapper->getEventmasterList($status);
    }
    
    public function SaveEventmaster($eventmasterObject) {
        return $this->eventmasterMapper->SaveEventmaster($eventmasterObject);
    }
    
    public function getEventmaster($id) {
        return $this->eventmasterMapper->getEventmaster($id);
    }
    
    public function eventmasterSearch($data) {
        return $this->eventmasterMapper->eventmasterSearch($data);
    }
    
    public function performSearchEventmaster($field) {
        return $this->eventmasterMapper->performSearchEventmaster($field);
    }
    
    public function getEventmasterRadioList($status) {
        return $this->eventmasterMapper->getEventmasterRadioList($status);
    }
    
    public function viewByEventmasterId($table, $id) {
        return $this->eventmasterMapper->viewByEventmasterId($table, $id);
    }
    
    
    
    
    
}
