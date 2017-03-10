<?php

namespace Admin\Service;

use Admin\Mapper\RegionMapperInterface;
use Admin\Service\RegionServiceInterface;

class RegionService implements RegionServiceInterface {

    protected $regionMapper;

    public function __construct(RegionMapperInterface $regionMapper) {
        $this->regionMapper=$regionMapper;
    }
    
    
    
    public function getAmmir() {
        return $this->regionMapper->getAmmir();
    }
    
    public function getAmmirById($id) {
        return $this->regionMapper->getAmmirById($id);
    }
    
   
    //Region
    
    
    public function getRegionList() {
        return $this->regionMapper->getRegionList();
    }
    
    public function SaveRegion($regionObject) {
        return $this->regionMapper->SaveRegion($regionObject);
    }
    
    public function getRegion($id) {
        return $this->regionMapper->getRegion($id);
    }
    
    public function regionSearch($data) {
        return $this->regionMapper->regionSearch($data);
    }
    
    public function performSearchRegion($field) {
        return $this->regionMapper->performSearchRegion($field);
    }
    
    public function getRegionRadioList($status) {
        return $this->regionMapper->getRegionRadioList($status);
    }
    
    public function viewByRegionId($table, $id) {
        return $this->regionMapper->viewByRegionId($table, $id);
    }
    
       
}
