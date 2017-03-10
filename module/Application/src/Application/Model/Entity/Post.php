<?php

namespace Application\Model\Entity;

class Post {

    protected $id;
    protected $postCategory;
    protected $userId;
    protected $language;
    protected $keywords;
    protected $title;
    protected $image;
    protected $description;
    protected $isActive;
    protected $createdBy;
    protected $createdDate;
    protected $modifiedDate;
    //protected $modifiedBy;
    
    
    function getId() {
        return $this->id;
    }

    function getPostCategory() {
        return $this->postCategory;
    }

    function getUserId() {
        return $this->userId;
    }

    function getLanguage() {
        return $this->language;
    }

    function getKeywords() {
        return $this->keywords;
    }

    function getTitle() {
        return $this->title;
    }

    function getImage() {
        return $this->image;
    }

    function getDescription() {
        return $this->description;
    }

    function getIsActive() {
        return $this->isActive;
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

    function setId($id) {
        $this->id = $id;
    }

    function setPostCategory($postCategory) {
        $this->postCategory = $postCategory;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setLanguage($language) {
        $this->language = $language;
    }

    function setKeywords($keywords) {
        $this->keywords = $keywords;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
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




}
