<?php

namespace Admin\Model\Entity;

class Users {

    public $id;
    public $user_type_id;
    public $username;
    public $password;
    public $email;
    public $mobile_no;
    public $activation_key;
    public $IsUsed;
    public $LoginStatus;
    public $ip;
    public $IsActive;
    public $created_date;
    public $modified_date;
    public $modified_by;

    public function exchangeArray($data) {

        $this->id = (!empty($data['id'])) ? $data['id'] : null;

        $this->user_type_id = (!empty($data['user_type_id'])) ? $data['user_type_id'] : null;
        $this->username = (!empty($data['username'])) ? $data['username'] : null;
        $this->password = (!empty($data['password'])) ? $data['password'] : null;
        $this->email = (!empty($data['email'])) ? $data['email'] : null;
        $this->mobile_no = (!empty($data['mobile_no'])) ? $data['mobile_no'] : null;
        $this->activation_key = (!empty($data['activation_key'])) ? $data['activation_key'] : null;

        $this->IsActive = (!empty($data['IsActive'])) ? $data['IsActive'] : null;
        $this->IsUsed = (!empty($data['IsUsed'])) ? $data['IsUsed'] : null;
        $this->LoginStatus = (!empty($data['LoginStatus'])) ? $data['LoginStatus'] : null;
        $this->ip = (!empty($data['ip'])) ? $data['ip'] : null;

        $this->created_date = (!empty($data['created_date'])) ? $data['created_date'] : null;
        
        $this->modified_date = (!empty($data['modified_date'])) ? $data['modified_date'] : null;

        $this->modified_by = (!empty($data['modified_by'])) ? $data['modified_by'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
   