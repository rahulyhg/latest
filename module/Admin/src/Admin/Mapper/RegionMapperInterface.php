<?php

namespace Admin\Mapper;

interface RegionMapperInterface {

    
    
   public function getAmmir();
   
   public function getAmmirById($id);
   
   
   //Region
   
   public function getRegionList();
   
   public function SaveRegion($regionObject);
   
   public function getRegion($id);
   
   public function regionSearch($data);
   
   public function performSearchRegion($field);
   
   public function getRegionRadioList($status);
   
   public function viewByRegionId($table, $id);
   
   
   
   
   
   
}
