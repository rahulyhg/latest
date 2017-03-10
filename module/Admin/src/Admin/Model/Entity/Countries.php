<?php

namespace Admin\Model\Entity;

class Countries {

    public $id;
    public $regionId;
    public $countryName;
    public $currency;
    public $isActive;
    public $dialCode;
    public $countryCode;
    public $orderVal;
    public $createdDate;
    public $modifiedDate;
    public $modifiedBy;
    public $masterCountryId;
    public $createdBy;
    public $ip;
    public $username;

    function getId() {
        return $this->id;
    }

    function getRegionId() {
        return $this->regionId;
    }

    function getCountryName() {
        return $this->countryName;
    }

    function getCurrency() {
        return $this->currency;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function getDialCode() {
        return $this->dialCode;
    }

    function getCountryCode() {
        return $this->countryCode;
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

    function getModifiedBy() {
        return $this->modifiedBy;
    }

    function getMasterCountryId() {
        return $this->masterCountryId;
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

    function setRegionId($regionId) {
        $this->regionId = $regionId;
    }

    function setCountryName($countryName) {
        $this->countryName = $countryName;
    }

    function setCurrency($currency) {
        $this->currency = $currency;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    function setDialCode($dialCode) {
        $this->dialCode = $dialCode;
    }

    function setCountryCode($countryCode) {
        $this->countryCode = $countryCode;
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

    function setModifiedBy($modifiedBy) {
        $this->modifiedBy = $modifiedBy;
    }

    function setMasterCountryId($masterCountryId) {
        $this->masterCountryId = $masterCountryId;
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
   