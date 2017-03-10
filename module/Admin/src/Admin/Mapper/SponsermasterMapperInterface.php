<?php

namespace Admin\Mapper;

interface SponsermasterMapperInterface {

    
    
   public function getAmmir();
   
   public function getAmmirById($id);
   
   //added by amir
   public function test();
   
   //Sponser master
   
   public function getSponsermasterList();
   
   public function getAllDesignation();
   
   public function SaveSponsermaster($sponsermasterObject);
   
   public function getSponsermaster($id);
   
   public function viewBySponsermasterId($id);
   
   public function changeStatus($table, $id, $data);
   
   public function delete($table, $id);
   
   public function customFieldsCity();
   
   //News category
   
   public function SaveNewscategory($newsCategoryObject);
   
   public function getNewscategoryList();
   
   public function getNewscategory($id);
   
   public function viewByNewscategoryId($table, $id);
   
   public function getNewscategoryRadioList($status);
   
   public function newscategorySearch($data);
   
   public function performSearchNewscategory($field);
   
   
   
   
   
   
   
}
