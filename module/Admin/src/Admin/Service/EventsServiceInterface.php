<?php

namespace Admin\Service;

interface EventsServiceInterface {
    
    
    
    public function getAmmir();
    
    //added by amir
    public function test();
    
    public function customFieldsCity();
    
    //Events
    
    public function getEventsList();
    
    public function saveEvents($eventsObject);
    
    public function viewByEventsId($table, $id);
    
    public function getEvents($id);
    
    public function getallSponsermaster();
    
    public function getallSponsertype();
    
    public function getallOrganiser();
    
    public function delete($table, $id);
            
    public function changeStatus($table, $id, $data);
    
    
    
    
    
    
    
    
}
