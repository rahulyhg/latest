<?php

namespace Admin\Service;

use Admin\Mapper\SponsermasterMapperInterface;
use Admin\Service\SponsermasterServiceInterface;

class SponsermasterService implements SponsermasterServiceInterface {

    protected $sponsermasterMapper;

    public function __construct(SponsermasterMapperInterface $sponsermasterMapper) {
        $this->sponsermasterMapper=$sponsermasterMapper;
    }
    
   
    
    public function getAmmir() {
        return $this->sponsermasterMapper->getAmmir();
    }
    
    //added by amir
    public function test() {
        return $this->sponsermasterMapper->test();
    }
    
    //Sponser master
    
    
    public function getSponsermasterList() {
        return $this->sponsermasterMapper->getSponsermasterList();
    }
    
    
    public function getAllDesignation() {
        return $this->sponsermasterMapper->getAllDesignation();
    }
    
    public function SaveSponsermaster($sponsermasterObject) {
        return $this->sponsermasterMapper->SaveSponsermaster($sponsermasterObject);
    }
    
    public function getSponsermaster($id) {
        return $this->sponsermasterMapper->getSponsermaster($id);
    }
    
    public function viewBySponsermasterId($id) {
        return $this->sponsermasterMapper->viewBySponsermasterId($id);
    }
    
    public function changeStatus($table, $id, $data) {
        return $this->sponsermasterMapper->changeStatus($table, $id, $data);
    }        
    
    public function delete($table, $id) {
        return $this->sponsermasterMapper->delete($table, $id);
    }        
    
    public function customFieldsCity() {
        return $this->sponsermasterMapper->customFieldsCity();
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
