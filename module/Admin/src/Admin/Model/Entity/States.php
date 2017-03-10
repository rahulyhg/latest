<?php

namespace Admin\Model\Entity;

class States {

    public $id;
    public $stateName;
    public $stateCode;
    public $isActive;
    public $countryId;
    public $masterStateId;
    public $countryName;
    public $createdDate;
    public $modifiedDate;
    public $modifiedBy;
    public $createdBy;
    public $ip;
    public $username;

    function getId() {
        return $this->id;
    }

    function getStateName() {
        return $this->stateName;
    }

    function getStateCode() {
        return $this->stateCode;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function getCountryId() {
        return $this->countryId;
    }

    function getMasterStateId() {
        return $this->masterStateId;
    }

    function getCountryName() {
        return $this->countryName;
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

    function setStateName($stateName) {
        $this->stateName = $stateName;
    }

    function setStateCode($stateCode) {
        $this->stateCode = $stateCode;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    function setCountryId($countryId) {
        $this->countryId = $countryId;
    }

    function setMasterStateId($masterStateId) {
        $this->masterStateId = $masterStateId;
    }

    function setCountryName($countryName) {
        $this->countryName = $countryName;
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
   