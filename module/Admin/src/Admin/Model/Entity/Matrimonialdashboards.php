<?php

namespace Admin\Model\Entity;

class Matrimonialdashboards {

    public $id;
    public $imageName;
    public $fullName;
    public $name;
    public $address;
    public $nativePlace;
    public $mobileNo;
    public $isActive;   
    public $modifiedDate;
    public $modifiedBy;    
    public $ip;
    public $username;

//    public function exchangeArray($data) {
//
//        $this->id = (!empty($data['id'])) ? $data['id'] : null;
//
//        $this->religion_name = (!empty($data['religion_name'])) ? $data['religion_name'] : null;
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

    function getImageName() {
        return $this->imageName;
    }

    function getFullName() {
        return $this->fullName;
    }

    function getName() {
        return $this->name;
    }

    function getAddress() {
        return $this->address;
    }

    function getNativePlace() {
        return $this->nativePlace;
    }

    function getMobileNo() {
        return $this->mobileNo;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function getModifiedDate() {
        return $this->modifiedDate;
    }

    function getModifiedBy() {
        return $this->modifiedBy;
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

    function setImageName($imageName) {
        $this->imageName = $imageName;
    }

    function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setNativePlace($nativePlace) {
        $this->nativePlace = $nativePlace;
    }

    function setMobileNo($mobileNo) {
        $this->mobileNo = $mobileNo;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    function setModifiedDate($modifiedDate) {
        $this->modifiedDate = $modifiedDate;
    }

    function setModifiedBy($modifiedBy) {
        $this->modifiedBy = $modifiedBy;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

    function setUsername($username) {
        $this->username = $username;
    }





}
   