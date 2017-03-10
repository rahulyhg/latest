<?php

namespace Admin\Mapper;

interface UsertypemasterMapperInterface {

    
    
   public function getAmmir();
   
   public function getAmmirById($id);
   
   public function test();
   
   
   //Usertypemaster
   
   public function getUsertypemasterList();
   
   public function SaveUsertypemaster($usertypemasterObject);
   
   public function getUsertypemaster($id);
   
   public function usertypemasterSearch($data);
   
   public function performSearchUsertypemaster($field);
   
   public function getUsertypemasterRadioList($status);
   
   public function viewByUsertypemasterId($table, $id);
   
   
   
   
   
   
}
