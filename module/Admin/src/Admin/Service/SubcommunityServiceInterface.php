<?php

namespace Admin\Service;

interface SubcommunityServiceInterface {
    
    
    
    public function getAmmir();

    public function getAmmirById($id);
    
    public function test();
    
    
    //Subcommunity...
    
    public function getSubcommunitysList();
    
    public function SaveSubcommunity($subcommunityObject);
    
    public function getSubcommunity($id);
    
    public function subcommunitySearch($data,$field);
    
    public function performSearchSubcommunity($field,$field2);
    
    public function getSubcommunityRadioList($status);
    
    public function viewBySubcommunityId($table, $id);
    
    public function getAllCommunitylist();
    
    
}
