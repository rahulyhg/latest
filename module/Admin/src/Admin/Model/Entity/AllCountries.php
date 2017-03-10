<?php

namespace Admin\Model\Entity;

class AllCountries {

    public $id;
    public $country_name;
    public $dial_code;
    public $country_code;

    public function exchangeArray($data) {

        $this->id = (!empty($data['id'])) ? $data['id'] : null;

        $this->country_name = (!empty($data['country_name'])) ? $data['country_name'] : null;

        $this->dial_code = (!empty($data['dial_code'])) ? $data['dial_code'] : null;

        $this->country_code = (!empty($data['country_code'])) ? $data['country_code'] : null;

    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
   