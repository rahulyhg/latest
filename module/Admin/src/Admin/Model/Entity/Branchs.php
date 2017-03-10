<?php

namespace Admin\Model\Entity;

class Branchs  
{

    public $branchId;
    public $branchName;
    public $isActive;
    public $createdDate;
    public $modifiedDate;
    public $modifiedBy;
    public $createdBy;
    public $country;
    public $state;
    public $branchCityId;
    public $countryName;
    public $stateName;
    public $cityName;
    public $ip;
    public $username;

//    public function exchangeArray($data) {
//
//        $this->id = (!empty($data['id'])) ? $data['id'] : null;
//
//        $this->branch_name = (!empty($data['branch_name'])) ? $data['branch_name'] : null;
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
    function getBranchId() {
        return $this->branchId;
    }

    function getBranchName() {
        return $this->branchName;
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

    function getCountry() {
        return $this->country;
    }

    function getState() {
        return $this->state;
    }

    function getBranchCityId() {
        return $this->branchCityId;
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

    function getIp() {
        return $this->ip;
    }

    function getUsername() {
        return $this->username;
    }

    function setBranchId($branchId) {
        $this->branchId = $branchId;
    }

    function setBranchName($branchName) {
        $this->branchName = $branchName;
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

    function setCountry($country) {
        $this->country = $country;
    }

    function setState($state) {
        $this->state = $state;
    }

    function setBranchCityId($branchCityId) {
        $this->branchCityId = $branchCityId;
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

    function setIp($ip) {
        $this->ip = $ip;
    }

    function setUsername($username) {
        $this->username = $username;
    }

















    
}
   