<?php

namespace Admin\Service;

use Admin\Mapper\NewsMapperInterface;
use Admin\Service\NewsServiceInterface;

class NewsService implements NewsServiceInterface {

    protected $newsMapper;

    public function __construct(NewsMapperInterface $newsMapper) {
        $this->newsMapper=$newsMapper;
    }
    
   
    
    public function getAmmir() {
        return $this->newsMapper->getAmmir();
    }
    
    //added by amir
    public function test() {
        return $this->newsMapper->test();
    }
    
    //News
    
    
    public function getNewsList() {
        return $this->newsMapper->getNewsList();
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
