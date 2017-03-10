<?php

namespace Admin\Service;

interface CommunityServiceInterface {
    
    
    
    public function getAmmir();

    public function getAmmirById($id);
    
    public function test();
    
    
    //Community...
    
    public function getCommunitysList();
    
    public function SaveCommunity($communityObject);
    
    public function getCommunity($id);
    
    public function communitySearch($data,$field);
    
    public function performSearchCommunity($field,$field2);
    
    public function getCommunityRadioList($status);
    
    public function viewByCommunityId($table, $id);
    
    public function getAllReligionlist();
    
    
}
