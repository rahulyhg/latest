<?php

namespace Admin\Service;

use Admin\Mapper\UsertypemasterMapperInterface;
use Admin\Service\UsertypemasterServiceInterface;

class UsertypemasterService implements UsertypemasterServiceInterface {

    protected $usertypemasterMapper;

    public function __construct(UsertypemasterMapperInterface $usertypemasterMapper) {
        $this->usertypemasterMapper=$usertypemasterMapper;
    }
    
    
    
    public function getAmmir() {
        return $this->usertypemasterMapper->getAmmir();
    }
    
    public function getAmmirById($id) {
        return $this->usertypemasterMapper->getAmmirById($id);
    }
    
    public function test() {
        return $this->usertypemasterMapper->test();
    }
    
   
    //Usertypemaster
    
    
    public function getUsertypemasterList() {
        return $this->usertypemasterMapper->getUsertypemasterList();
    }
    
    public function SaveUsertypemaster($usertypemasterObject) {
        return $this->usertypemasterMapper->SaveUsertypemaster($usertypemasterObject);
    }
    
    public function getUsertypemaster($id) {
        return $this->usertypemasterMapper->getUsertypemaster($id);
    }
    
    public function usertypemasterSearch($data) {
        return $this->usertypemasterMapper->usertypemasterSearch($data);
    }
    
    public function performSearchUsertypemaster($field) {
        return $this->usertypemasterMapper->performSearchUsertypemaster($field);
    }
    
    public function getUsertypemasterRadioList($status) {
        return $this->usertypemasterMapper->getUsertypemasterRadioList($status);
    }
    
    public function viewByUsertypemasterId($table, $id) {
        return $this->usertypemasterMapper->viewByUsertypemasterId($table, $id);
    }
    
       
}
