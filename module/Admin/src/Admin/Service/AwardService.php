<?php

namespace Admin\Service;

use Admin\Mapper\AwardMapperInterface;
use Admin\Service\AwardServiceInterface;

class AwardService implements AwardServiceInterface {

    protected $awardMapper;

    public function __construct(AwardMapperInterface $awardMapper) {
        $this->awardMapper=$awardMapper;
    }
    
    //education field
    
    public function getAmmir() {
        return $this->awardMapper->getAmmir();
    }
    
    public function getAmmirById($id) {
        return $this->awardMapper->getAmmirById($id);
    }
    
    public function test() {
        return $this->awardMapper->test();
    }
    
     //Award
    
    
    public function getAwardList() {
        return $this->awardMapper->getAwardList();
    }
    
    public function SaveAward($awardObject) {
        return $this->awardMapper->SaveAward($awardObject);
    }
    
    public function getAward($id) {
        return $this->awardMapper->getAward($id);
    }
    
    public function awardSearch($data) {
        return $this->awardMapper->awardSearch($data);
    }
    
    public function performSearchAward($field) {
        return $this->awardMapper->performSearchAward($field);
    }
    
    public function getAwardRadioList($status) {
        return $this->awardMapper->getAwardRadioList($status);
    }
    
    public function viewByAwardId($table, $id) {
        return $this->awardMapper->viewByAwardId($table, $id);
    }
    
    
    
    
    
}
