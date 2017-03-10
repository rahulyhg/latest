<?php

namespace Admin\Service;

interface AwardServiceInterface {
    
    //education field
    
    public function getAmmir();

    public function getAmmirById($id);
    
    public function test();
    
    //Award
    
    public function getAwardList();
    
    public function SaveAward($awardObject);
    
    public function getAward($id);
    
    public function awardSearch($data);
    
    public function performSearchAward($field);
    
    public function getAwardRadioList($status);
    
    public function viewByAwardId($table, $id);
    
    
    
}
