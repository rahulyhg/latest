<?php

namespace Admin\Model\Entity;

class Gothras {

    public $id;
    public $casteId;
    public $gothraName;
    public $casteName;
    public $isActive;
    public $createdDate;
    public $modifiedDate;
    public $modifiedBy;
    public $createdBy;
    public $ip;
    public $username;

//    public function exchangeArray($data) {
//
//        $this->id = (!empty($data['id'])) ? $data['id'] : null;
//
//        $this->gothra_name = (!empty($data['gothra_name'])) ? $data['gothra_name'] : null;
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

    function getCasteId() {
        return $this->casteId;
    }

    function getGothraName() {
        return $this->gothraName;
    }

    function getCasteName() {
        return $this->casteName;
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

    function getCreatedBy() {
        return $this->createdBy;
    }

    function getIp() {
        return $this->ip;
    }

    function getUsername() {
        return $this->username;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCasteId($casteId) {
        $this->casteId = $casteId;
    }

    function setGothraName($gothraName) {
        $this->gothraName = $gothraName;
    }

    function setCasteName($casteName) {
        $this->casteName = $casteName;
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

    function setCreatedBy($createdBy) {
        $this->createdBy = $createdBy;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

    function setUsername($username) {
        $this->username = $username;
    }


}
   