<?php

namespace Admin\Service;

use Admin\Mapper\SubcommunityMapperInterface;
use Admin\Service\SubcommunityServiceInterface;

class SubcommunityService implements SubcommunityServiceInterface {

    protected $subcommunityMapper;

    public function __construct(SubcommunityMapperInterface $subcommunityMapper) {
        $this->subcommunityMapper=$subcommunityMapper;
    }
    
    
    
    public function getAmmir() {
        return $this->subcommunityMapper->getAmmir();
    }
    
    public function getAmmirById($id) {
        return $this->subcommunityMapper->getAmmirById($id);
    }
    
    public function test() {
        return $this->subcommunityMapper->test();
    }
    
   
    //Subcommunity...
    
    public function getSubcommunitysList() {
        return $this->subcommunityMapper->getSubcommunitysList();
    }
    
    public function SaveSubcommunity($subcommunityObject) {
        return $this->subcommunityMapper->SaveSubcommunity($subcommunityObject);
    }
    
    public function getSubcommunity($id) {
        return $this->subcommunityMapper->getSubcommunity($id);
    }
    
    public function subcommunitySearch($data,$field) {
        return $this->subcommunityMapper->subcommunitySearch($data,$field);
    }
    
    public function performSearchSubcommunity($field,$field2) {
        return $this->subcommunityMapper->performSearchSubcommunity($field,$field2);
    }
    
    public function getSubcommunityRadioList($status) {
        return $this->subcommunityMapper->getSubcommunityRadioList($status);
    }
    
    public function viewBySubcommunityId($table, $id) {
        return $this->subcommunityMapper->viewBySubcommunityId($table, $id);
    }
    
    public function getAllCommunitylist() {
        return $this->subcommunityMapper->getAllCommunitylist();
    }
    
    
    
    
       
}
