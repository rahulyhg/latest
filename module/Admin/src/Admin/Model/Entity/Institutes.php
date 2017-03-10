<?php

namespace Admin\Model\Entity;

class Institutes {

    public $id;
    public $instituteName;
    public $operatedBy;
    public $instituteAddress;
    public $instituteType;
    public $purpose;
    public $isActive;
    public $orderVal;
    public $createdDate;
    public $modifiedDate;
    public $createdBy;
    public $modifiedBy;
    public $country;
    public $city;
    public $state;
    public $countryName;
    public $stateName;
    public $cityName;
    public $memberId;
    public $ip;
    public $username;

//    public function exchangeArray($data) {
//
//        $this->id = (!empty($data['id'])) ? $data['id'] : null;
//
//        $this->institute_name = (!empty($data['institute_name'])) ? $data['institute_name'] : null;
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

    function getInstituteName() {
        return $this->instituteName;
    }

    function getOperatedBy() {
        return $this->operatedBy;
    }

    function getInstituteAddress() {
        return $this->instituteAddress;
    }

    function getInstituteType() {
        return $this->instituteType;
    }

    function getPurpose() {
        return $this->purpose;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function getOrderVal() {
        return $this->orderVal;
    }

    function getCreatedDate() {
        return $this->createdDate;
    }

    function getModifiedDate() {
        return $this->modifiedDate;
    }

    function getCreatedBy() {
        return $this->createdBy;
    }

    function getModifiedBy() {
        return $this->modifiedBy;
    }

    function getCountry() {
        return $this->country;
    }

    function getCity() {
        return $this->city;
    }

    function getState() {
        return $this->state;
    }

    function getCountryName() {
        return $this->countryName;
    }

    function getStateName() {
        return $this->stateName;
    }

    function getCityName() {
        return $this->cityName;
    }

    function getMemberId() {
        return $this->memberId;
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

    function setInstituteName($instituteName) {
        $this->instituteName = $instituteName;
    }

    function setOperatedBy($operatedBy) {
        $this->operatedBy = $operatedBy;
    }

    function setInstituteAddress($instituteAddress) {
        $this->instituteAddress = $instituteAddress;
    }

    function setInstituteType($instituteType) {
        $this->instituteType = $instituteType;
    }

    function setPurpose($purpose) {
        $this->purpose = $purpose;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    function setOrderVal($orderVal) {
        $this->orderVal = $orderVal;
    }

    function setCreatedDate($createdDate) {
        $this->createdDate = $createdDate;
    }

    function setModifiedDate($modifiedDate) {
        $this->modifiedDate = $modifiedDate;
    }

    function setCreatedBy($createdBy) {
        $this->createdBy = $createdBy;
    }

    function setModifiedBy($modifiedBy) {
        $this->modifiedBy = $modifiedBy;
    }

    function setCountry($country) {
        $this->country = $country;
    }

    function setCity($city) {
        $this->city = $city;
    }

    function setState($state) {
        $this->state = $state;
    }

    function setCountryName($countryName) {
        $this->countryName = $countryName;
    }

    function setStateName($stateName) {
        $this->stateName = $stateName;
    }

    function setCityName($cityName) {
        $this->cityName = $cityName;
    }

    function setMemberId($memberId) {
        $this->memberId = $memberId;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

    function setUsername($username) {
        $this->username = $username;
    }


}
   