<?php

namespace Application\Model\Entity;

class User implements UserInterface {

    public $id;
    public $refNo;
    public $userTypeId;
    public $username;
    public $password;
    public $email;
    public $mobileNo;
    public $activationKey;
    public $isActive;
    public $isUsed;
    public $loginStatus;
    public $ip;
    public $createdDate;
    public $modifiedDate;
    public $modifiedBy;
    
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

    function getMobileNo() {
        return $this->mobileNo;
    }

    function getActivationKey() {
        return $this->activationKey;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function getIsUsed() {
        return $this->isUsed;
    }

    function getLoginStatus() {
        return $this->loginStatus;
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

    function setMobileNo($mobileNo) {
        $this->mobileNo = $mobileNo;
    }

    function setActivationKey($activationKey) {
        $this->activationKey = $activationKey;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    function setIsUsed($isUsed) {
        $this->isUsed = $isUsed;
    }

    function setLoginStatus($loginStatus) {
        $this->loginStatus = $loginStatus;
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
