<?php

namespace Admin\Service;

interface EventmasterServiceInterface {
    
    //education field
    
    public function getAmmir();

    public function getAmmirById($id);
    
    public function test();
    
   //Eventmaster
    
    public function getEventmasterList($status);
    
    public function SaveEventmaster($eventmasterObject);
    
    public function getEventmaster($id);
    
    public function eventmasterSearch($data);
    
    public function performSearchEventmaster($field);
    
    public function getEventmasterRadioList($status);
    
    public function viewByEventmasterId($table, $id);
    
    
    
}
