<?php

namespace Admin\Model\Entity;

class UserRoles {

    public $id;
    public $user_id;
    public $IsMember;
    public $IsMatrimonial;
    public $IsExecutive;
    public $created_date;
    public $last_date;
    public $modified_by;

    public function exchangeArray($data) {

        $this->id = (!empty($data['id'])) ? $data['id'] : null;

        $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;

        $this->IsMember = (!empty($data['IsMember'])) ? $data['IsMember'] : null;

        $this->IsMatrimonial = (!empty($data['IsMatrimonial'])) ? $data['IsMatrimonial'] : null;

        $this->IsExecutive = (!empty($data['IsExecutive'])) ? $data['IsExecutive'] : null;
         
        $this->created_date = (!empty($data['created_date'])) ? $data['created_date'] : null;
        
        $this->last_date = (!empty($data['last_date'])) ? $data['last_date'] : null;

        $this->modified_by = (!empty($data['modified_by'])) ? $data['modified_by'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
   