<?php

namespace Common\Model\Entity;

class User implements UserInterface {

    protected $id;
    protected $refNo;
    protected $userTypeId;
    protected $username;
    protected $password;
    protected $email;
    protected $mobileNumber;
    protected $activationKey;
    protected $IsActive;
    protected $IsUsed;
    protected $LoginStatus;
    protected $ip;
    protected $createdDate;
    protected $modifiedDate;
    protected $modifiedBy;
  
    function getId() {
        return $this->id;
    }

    function getRefNo() {
        return $this->refNo;
    }

    function getUserTypeId() {
        return $this->userTypeId;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getEmail() {
        return $this->email;
    }

    function getMobileNumber() {
        return $this->mobileNumber;
    }

    function getActivationKey() {
        return $this->activationKey;
    }

    function getIsActive() {
        return $this->IsActive;
    }

    function getIsUsed() {
        return $this->IsUsed;
    }

    function getLoginStatus() {
        return $this->LoginStatus;
    }

    function getIp() {
        return $this->ip;
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

    function setRefNo($refNo) {
        $this->refNo = $refNo;
    }

    function setUserTypeId($userTypeId) {
        $this->userTypeId = $userTypeId;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setMobileNumber($mobileNumber) {
        $this->mobileNumber = $mobileNumber;
    }

    function setActivationKey($activationKey) {
        $this->activationKey = $activationKey;
    }

    function setIsActive($IsActive) {
        $this->IsActive = $IsActive;
    }

    function setIsUsed($IsUsed) {
        $this->IsUsed = $IsUsed;
    }

    function setLoginStatus($LoginStatus) {
        $this->LoginStatus = $LoginStatus;
    }

    function setIp($ip) {
        $this->ip = $ip;
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
