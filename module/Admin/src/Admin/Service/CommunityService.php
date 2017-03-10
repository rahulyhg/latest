<?php

namespace Admin\Service;

use Admin\Mapper\CommunityMapperInterface;
use Admin\Service\CommunityServiceInterface;

class CommunityService implements CommunityServiceInterface {

    protected $communityMapper;

    public function __construct(CommunityMapperInterface $communityMapper) {
        $this->communityMapper=$communityMapper;
    }
    
    
    
    public function getAmmir() {
        return $this->communityMapper->getAmmir();
    }
    
    public function getAmmirById($id) {
        return $this->communityMapper->getAmmirById($id);
    }
    
    public function test() {
        return $this->communityMapper->test();
    }
    
   
    //Community...
    
    public function getCommunitysList() {
        return $this->communityMapper->getCommunitysList();
    }
    
    public function SaveCommunity($communityObject) {
        return $this->communityMapper->SaveCommunity($communityObject);
    }
    
    public function getCommunity($id) {
        return $this->communityMapper->getCommunity($id);
    }
    
    public function communitySearch($data,$field) {
        return $this->communityMapper->communitySearch($data,$field);
    }
    
    public function performSearchCommunity($field,$field2) {
        return $this->communityMapper->performSearchCommunity($field,$field2);
    }
    
    public function getCommunityRadioList($status) {
        return $this->communityMapper->getCommunityRadioList($status);
    }
    
    public function viewByCommunityId($table, $id) {
        return $this->communityMapper->viewByCommunityId($table, $id);
    }
    
    public function getAllReligionlist() {
        return $this->communityMapper->getAllReligionlist();
    }
    
    
    
    
       
}
