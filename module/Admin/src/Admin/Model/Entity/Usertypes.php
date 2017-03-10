<?php

namespace Admin\Model\Entity;

class Usertypes {

    public $id;
    public $user_type;
    public $is_active;
    public $created_date;
    public $modified_date;
    public $modified_by;

    public function exchangeArray($data) {

        $this->id = (!empty($data['id'])) ? $data['id'] : null;

        $this->user_type = (!empty($data['user_type'])) ? $data['user_type'] : null;

        $this->is_active = (!empty($data['is_active'])) ? $data['is_active'] : 0;

        $this->created_date = (!empty($data['created_date'])) ? $data['created_date'] : null;
        
        $this->modified_date = (!empty($data['modified_date'])) ? $data['modified_date'] : null;

        $this->modified_by = (!empty($data['modified_by'])) ? $data['modified_by'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
   