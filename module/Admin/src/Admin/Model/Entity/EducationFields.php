<?php
namespace Admin\Model\Entity;

class EducationFields {

    public $id;
    public $educationField;
    public $isActive;
    public $createdDate;
    public $modifiedDate;
    public $modifiedBy;
    public $createdBy;
    public $ip;
    public $username;

    function getId() {
        return $this->id;
    }

    function getEducationField() {
        return $this->educationField;
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

    function setEducationField($educationField) {
        $this->educationField = $educationField;
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
   