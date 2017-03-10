<?php

namespace Admin\Mapper;

interface InstituteMapperInterface {

    
    
   public function getAmmir();
   
   public function getAmmirById($id);
   
//   public function test();
   
   
   //Institute
   
   public function getInstituteList();
   
   public function SaveInstitute($instituteObject);
   
   public function getInstitute($id);
   
   public function instituteSearch($data);
   
   public function performSearchInstitute($field);
   
   public function getInstituteRadioList($status);
   
   public function viewByInstituteId($table, $id);
   
   public function getInstituteListByCityCode($City_ID);
   
   public function getInstituteByInstituteId($table, $id);
   
   public function getInstituteByInstituteCityId($table, $id);
   
   public function getallMember();
   
   
   
   
   
   
}
