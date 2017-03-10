<?php

namespace Admin\Service;

use Admin\Mapper\InstituteMapperInterface;
use Admin\Service\InstituteServiceInterface;

class InstituteService implements InstituteServiceInterface {

    protected $instituteMapper;

    public function __construct(InstituteMapperInterface $instituteMapper) {
        $this->instituteMapper=$instituteMapper;
    }
    
    
    
    public function getAmmir() {
        return $this->instituteMapper->getAmmir();
    }
    
    public function getAmmirById($id) {
        return $this->instituteMapper->getAmmirById($id);
    }
    
//    public function test() {
//        return $this->instituteMapper->test();
//    }
    
   
    //Institute
    
    
    public function getInstituteList() {
        return $this->instituteMapper->getInstituteList();
    }
    
    public function SaveInstitute($instituteObject) {
        return $this->instituteMapper->SaveInstitute($instituteObject);
    }
    
    public function getInstitute($id) {
        return $this->instituteMapper->getInstitute($id);
    }
    
    public function instituteSearch($data) {
        return $this->instituteMapper->instituteSearch($data);
    }
    
    public function performSearchInstitute($field) {
        return $this->instituteMapper->performSearchInstitute($field);
    }
    
    public function getInstituteRadioList($status) {
        return $this->instituteMapper->getInstituteRadioList($status);
    }
    
    public function viewByInstituteId($table, $id) {
        return $this->instituteMapper->viewByInstituteId($table, $id);
    }
    
    public function getInstituteListByCityCode($City_ID) {
        return $this->instituteMapper->getInstituteListByCityCode($City_ID);
    }
    
    public function getInstituteByInstituteId($table, $id) {
        return $this->instituteMapper->getInstituteByInstituteId($table, $id);
    }
    
    public function getInstituteByInstituteCityId($table, $id) {
        return $this->instituteMapper->getInstituteByInstituteCityId($table, $id);
    }
    
    public function getallMember() {
        return $this->instituteMapper->getallMember();
    }
    
    
       
}
