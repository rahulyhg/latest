<?php

namespace Admin\Model\Entity;

class Eventmasters {

    public $id;
    public $eventName;
    public $isActive;
    public $createdDate;
    public $modifiedDate;
    public $modifiedBy;

//    public function exchangeArray($data) {
//
//        $this->id = (!empty($data['id'])) ? $data['id'] : null;
//
//        $this->event_name = (!empty($data['event_name'])) ? $data['event_name'] : null;
//
//        $this->IsActive = (!empty($data['IsActive'])) ? $data['IsActive'] : null;
//
//        $this->created_date = (!empty($data['created_date'])) ? $data['created_date'] : null;
//        
//        $this->modified_date = (!empty($data['modified_date'])) ? $data['modified_date'] : null;
//
//        $this->modified_by = (!empty($data['modified_by'])) ? $data['modified_by'] : null;
//    }
//
//    public function getArrayCopy() {
//        return get_object_vars($this);
//    }
    function getId() {
        return $this->id;
    }

    function getEventName() {
        return $this->eventName;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function getCreatedDate() {
        return $this->createdDate;
    }

    function getModifiedDate() {
        return $this->modifiedDate;
    }

    function getModifiedBy() {
        return $this->modifiedBy;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setEventName($eventName) {
        $this->eventName = $eventName;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    function setCreatedDate($createdDate) {
        $this->createdDate = $createdDate;
    }

    function setModifiedDate($modifiedDate) {
        $this->modifiedDate = $modifiedDate;
    }

    function setModifiedBy($modifiedBy) {
        $this->modifiedBy = $modifiedBy;
    }


    
}
   