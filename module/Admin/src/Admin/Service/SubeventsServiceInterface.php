<?php

namespace Admin\Service;

interface SubeventsServiceInterface {
    
    
    
    public function getAmmir();
    
    //added by amir
    public function test();
    
        
    //Events
    
    public function getSubeventsList();
    
    public function saveSubevents($subeventsObject);
    
    public function viewBySubeventsId($table, $id);
    
    public function getSubevents($id);
    
    public function getallSponsermaster();
    
    public function getallSponsertype();
    
    public function getallOrganiser();
    
    public function delete($table, $id);
            
    public function changeStatus($table, $id, $data);
    
    public function customFieldsCity();
    
    public function getallEvents();
    
    
    
    
    
    
}
