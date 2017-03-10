<?php

namespace Admin\Model\Entity;

class Usertypemasters {

    public $id;
    public $userType;
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
//        $this->user_type = (!empty($data['user_type'])) ? $data['user_type'] : null;
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

    function getUserType() {
        return $this->userType;
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

    function setUserType($userType) {
        $this->userType = $userType;
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
   