<?php

namespace Admin\Service;

use Admin\Mapper\MembershipfeatureMapperInterface;
use Admin\Service\MembershipfeatureServiceInterface;

class MembershipfeatureService implements MembershipfeatureServiceInterface {

    protected $membershipfeatureMapper;

    public function __construct(MembershipfeatureMapperInterface $membershipfeatureMapper) {
        $this->membershipfeatureMapper=$membershipfeatureMapper;
    }
    
   
    
    public function getAmmir() {
        return $this->newsMapper->getAmmir();
    }
    
    //added by amir
    public function test() {
        return $this->membershipfeatureMapper->test();
    }
    
    //News
    
    
    public function getMembershipfeatureList() {
        return $this->membershipfeatureMapper->getMembershipfeatureList();
    }
    
    
    public function getAllNewscategory() {
        return $this->newsMapper->getAllNewscategory();
    }
    
    public function saveNews($newsObject) {
        return $this->newsMapper->saveNews($newsObject);
    }
    
    public function getNews($id) {
        return $this->newsMapper->getNews($id);
    }
    
    public function viewByNewsId($table, $id) {
        return $this->newsMapper->viewByNewsId($table, $id);
    }
    
    //News category
    
    public function SaveNewscategory($newsCategoryObject) {
        return $this->newsMapper->SaveNewscategory($newsCategoryObject);
    }
    
    public function getNewscategoryList() {
        return $this->newsMapper->getNewscategoryList();
    }
    
    public function getNewscategory($id) {
        return $this->newsMapper->getNewscategory($id);
    }
    
    public function viewByNewscategoryId($table, $id) {
        return $this->newsMapper->viewByNewscategoryId($table, $id);
    }
    
    public function getNewscategoryRadioList($status) {
        return $this->newsMapper->getNewscategoryRadioList($status);
    }
    
    public function newscategorySearch($data) {
        return $this->newsMapper->newscategorySearch($data);
    }
    
    public function performSearchNewscategory($field) {
        return $this->newsMapper->performSearchNewscategory($field);
    }
    
    
    
    
}
