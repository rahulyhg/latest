<?php

namespace Admin\Model\Entity;

class Newses {

    public $id;
    public $title;
    public $description;
    public $isActive;
    public $newsCategoryId;
    public $categoryName;
    public $username;
    public $createdBy;
    public $image;
    public $imagePath;
    public $createdDate;
    public $modifiedDate;
    public $modifiedBy;

//    public function exchangeArray($data) {
//
//        $this->id = (!empty($data['id'])) ? $data['id'] : null;
//
//        $this->title = (!empty($data['title'])) ? $data['title'] : null;
//
//        $this->description = (!empty($data['description'])) ? $data['description'] : null;
//
//        $this->is_active = (!empty($data['is_active'])) ? $data['is_active'] : null;
//
//        $this->news_category_id = (!empty($data['news_category_id'])) ? $data['news_category_id'] : null;
//
//        $this->category_name = (!empty($data['category_name'])) ? $data['category_name'] : null;
//
//        $this->image = (!empty($data['image'])) ? $data['image'] : null;
//        
//        $this->image_path = (!empty($data['image_path'])) ? $data['image_path'] : null;
//
//        $this->created_date = (!empty($data['created_date'])) ? $data['created_date'] : null;
//        
//        $this->modified_date = (!empty($data['modified_date'])) ? $data['modified_date'] : null;
//
//        $this->username = (!empty($data['username'])) ? $data['username'] : null;
//        
//        $this->modified_by = (!empty($data['modified_by'])) ? $data['modified_by'] : null;
//        
//    }
//
//    public function getArrayCopy() {
//        return get_object_vars($this);
//    }
    
    function getId() {
        return $this->id;
    }

    function getTitle() {
        return $this->title;
    }

    function getDescription() {
        return $this->description;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function getNewsCategoryId() {
        return $this->newsCategoryId;
    }

    function getCategoryName() {
        return $this->categoryName;
    }

    function getCreatedBy() {
        return $this->createdBy;
    }

    function getImage() {
        return $this->image;
    }

    function getImagePath() {
        return $this->imagePath;
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

    function setTitle($title) {
        $this->title = $title;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    function setNewsCategoryId($newsCategoryId) {
        $this->newsCategoryId = $newsCategoryId;
    }

    function setCategoryName($categoryName) {
        $this->categoryName = $categoryName;
    }

    function setCreatedBy($createdBy) {
        $this->createdBy = $createdBy;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setImagePath($imagePath) {
        $this->imagePath = $imagePath;
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


    function getUsername() {
        return $this->username;
    }

    function setUsername($username) {
        $this->username = $username;
    }




}
   