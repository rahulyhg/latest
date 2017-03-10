<?php

namespace Admin\Service;

use Admin\Mapper\SponsertypeMapperInterface;
use Admin\Service\SponsertypeServiceInterface;

class SponsertypeService implements SponsertypeServiceInterface {

    protected $sponsertypeMapper;

    public function __construct(SponsertypeMapperInterface $sponsertypeMapper) {
        $this->sponsertypeMapper=$sponsertypeMapper;
    }
    
   
    
    public function getAmmir() {
        return $this->sponsertypeMapper->getAmmir();
    }
    
    //added by amir
    public function test() {
        return $this->sponsertypeMapper->test();
    }
    
     //Religion
    
    
    public function getSponsertypeList() {
        return $this->sponsertypeMapper->getSponsertypeList();
    }
    
    public function SaveSponsertype($sponsertypeObject) {
        return $this->sponsertypeMapper->SaveSponsertype($sponsertypeObject);
    }
    
    public function getSponsertype($id) {
        return $this->sponsertypeMapper->getSponsertype($id);
    }
    
    public function sponsertypeSearch($data) {
        return $this->sponsertypeMapper->sponsertypeSearch($data);
    }
    
    public function performSearchSponsertype($field) {
        return $this->sponsertypeMapper->performSearchSponsertype($field);
    }
    
    public function getSponsertypeRadioList($status) {
        return $this->sponsertypeMapper->getSponsertypeRadioList($status);
    }
    
    public function viewBySponsertypeId($table, $id) {
        return $this->sponsertypeMapper->viewBySponsertypeId($table, $id);
    }
    
    public function changeStatus($table, $id, $data, $modified_by) {
        return $this->sponsertypeMapper->changeStatus($table, $id, $data, $modified_by);
    }
    
    public function delete($table, $id) {
        return $this->sponsertypeMapper->delete($table, $id);
    }
    
    public function changeStatusAll($table, $ids, $data) {
        return $this->sponsertypeMapper->changeStatusAll($table, $ids, $data);
    }
    
    public function deleteMultiple($table, $ids) {
        return $this->sponsertypeMapper->deleteMultiple($table, $ids);
    }
    
    
    
    
}
