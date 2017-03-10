<?php

namespace Admin\Service;

interface SponsertypeServiceInterface {
    
    
    
    public function getAmmir();
    
    //added by amir
    public function test();
    
    //Religion
    
    public function getSponsertypeList();
    
    public function SaveSponsertype($sponsertypeObject);
    
    public function getSponsertype($id);
    
    public function sponsertypeSearch($data);
    
    public function performSearchSponsertype($field);
    
    public function getSponsertypeRadioList($status);
    
    public function viewBySponsertypeId($table, $id);
    
    public function changeStatus($table, $id, $data, $modified_by);
    
    public function delete($table, $id);
    
    public function changeStatusAll($table, $ids, $data);
    
    public function deleteMultiple($table, $ids);
    
    
    
    
    
    
    
}
