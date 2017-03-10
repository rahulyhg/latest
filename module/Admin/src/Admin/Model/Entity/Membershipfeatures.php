<?php

namespace Admin\Model\Entity;

class Membershipfeatures {

    public $featureId;
    public $packageId;
    public $featureName;
    public $packageName;
    public $featureDesc;
    public $isActive;
    public $username;
    public $createdBy;
    public $createdDate;
    public $modifiedDate;
    public $modifiedBy;
    public $ip;

    
    function getFeatureId() {
        return $this->featureId;
    }

    function getPackageId() {
        return $this->packageId;
    }

    function getFeatureName() {
        return $this->featureName;
    }

    function getPackageName() {
        return $this->packageName;
    }

    function getFeatureDesc() {
        return $this->featureDesc;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function getUsername() {
        return $this->username;
    }

    function getCreatedBy() {
        return $this->createdBy;
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

    function getIp() {
        return $this->ip;
    }

    function setFeatureId($featureId) {
        $this->featureId = $featureId;
    }

    function setPackageId($packageId) {
        $this->packageId = $packageId;
    }

    function setFeatureName($featureName) {
        $this->featureName = $featureName;
    }

    function setPackageName($packageName) {
        $this->packageName = $packageName;
    }

    function setFeatureDesc($featureDesc) {
        $this->featureDesc = $featureDesc;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setCreatedBy($createdBy) {
        $this->createdBy = $createdBy;
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

    function setIp($ip) {
        $this->ip = $ip;
    }







}
   