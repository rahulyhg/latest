<?php

namespace Admin\Service;

use Admin\Mapper\BranchMapperInterface;
use Admin\Service\BranchServiceInterface;

class BranchService implements BranchServiceInterface {

    protected $branchMapper;

    public function __construct(BranchMapperInterface $branchMapper) {
        $this->branchMapper=$branchMapper;
    }
    
    
    
    public function getAmmir() {
        return $this->branchMapper->getAmmir();
    }
    
    public function getAmmirById($id) {
        return $this->branchMapper->getAmmirById($id);
    }
    
//    public function test() {
//        return $this->branchMapper->test();
//    }
    
   
    //Branch
    
    
    public function getBranchList() {
        return $this->branchMapper->getBranchList();
    }
    
    public function SaveBranch($branchObject) {
        return $this->branchMapper->SaveBranch($branchObject);
    }
    
    public function getBranch($id) {
        return $this->branchMapper->getBranch($id);
    }
    
    public function branchSearch($data) {
        return $this->branchMapper->branchSearch($data);
    }
    
    public function performSearchBranch($field) {
        return $this->branchMapper->performSearchBranch($field);
    }
    
    public function getBranchRadioList($status) {
        return $this->branchMapper->getBranchRadioList($status);
    }
    
    public function viewByBranchId($table, $id) {
        return $this->branchMapper->viewByBranchId($table, $id);
    }
    
    public function delete($table, $id) {
        return $this->branchMapper->delete($table, $id);
    }    
    
    public function changeStatus($table, $id, $data, $modified_by) {
        return $this->branchMapper->changeStatus($table, $id, $data, $modified_by);
    }
    
    public function changeStatusAll($table, $ids, $data) {
        return $this->branchMapper->changeStatusAll($table, $ids, $data);
    }
    
    public function deleteMultiple($table, $ids) {
        return $this->branchMapper->deleteMultiple($table, $ids);
    }
    
    public function getBranchListByCityCode($City_ID) {
        return $this->branchMapper->getBranchListByCityCode($City_ID);
    } 
    
    public function getBranchListByCountry($country_id) {
        return $this->branchMapper->getBranchListByCountry($country_id);
    }
    
    public function getBranchByBranchId($table, $id) {
        return $this->branchMapper->getBranchByBranchId($table, $id);
    }
    
    public function getBranchByBranchCityId($table, $id) {
        return $this->branchMapper->getBranchByBranchCityId($table, $id);
    }
    
    
       
}
