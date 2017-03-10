<?php

namespace Admin\Model\Entity;

class Cities {

    public $id;
    public $city_name;
    public $IsActive;
    public $state_id;
    public $country_id;
    public $state_name;
    public $created_date;
    public $modified_date;
    public $modified_by;

    public function exchangeArray($data) {

        $this->id = (!empty($data['id'])) ? $data['id'] : null;

        $this->city_name = (!empty($data['city_name'])) ? $data['city_name'] : null;

        $this->IsActive = (!empty($data['IsActive'])) ? $data['IsActive'] : null;

        $this->state_id = (!empty($data['state_id'])) ? $data['state_id'] : null;
        
        $this->country_id = (!empty($data['country_id'])) ? $data['country_id'] : null;

        $this->created_date = (!empty($data['created_date'])) ? $data['created_date'] : null;
        
        $this->modified_date = (!empty($data['modified_date'])) ? $data['modified_date'] : null;

        $this->modified_by = (!empty($data['modified_by'])) ? $data['modified_by'] : null;
        
        $this->state_name = (!empty($data['state_name'])) ? $data['state_name'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
   