<?php

namespace Admin\Mapper;

interface BranchMapperInterface {

    
    
   public function getAmmir();
   
   public function getAmmirById($id);
   
//   public function test();
   
   
   //Branch
   
   public function getBranchList();
   
   public function SaveBranch($branchObject);
   
   public function getBranch($id);
   
   public function branchSearch($data);
   
   public function performSearchBranch($field);
   
   public function getBranchRadioList($status);
   
   public function viewByBranchId($table, $id);
   
   public function delete($table, $id);
   
   public function changeStatus($table, $id, $data, $modified_by);
   
   public function changeStatusAll($table, $ids, $data);
   
   public function deleteMultiple($table, $ids);
   
   public function getBranchListByCityCode($City_ID);
   
   public function getBranchListByCountry($country_id);
   
   public function getBranchByBranchId($table, $id);
   
   public function getBranchByBranchCityId($table, $id);
   
   
   
   
   
   
}
