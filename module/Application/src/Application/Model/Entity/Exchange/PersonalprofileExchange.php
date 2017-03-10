<?php

namespace Application\Model\Entity;

class PersonalprofileExchange {

    public $id;
    public $profile_for;
    public $profile_for_others;
    public $name_title_user;
    public $full_name;
    public $alternate_mobile_no;
    public $phone_no;
    public $gender;
    public $native_place;
    public $address;
    public $address_line2;
    public $country;
    public $state;
    public $city;
    public $zip_pin_code;
    public $dob;
    public $age;
    public $any_disability;
    public $color_complexion;
    public $body_type;
    public $height;
    public $blood_group;
    //public $marital_status;
    public $gothra_gothram;
    public $gothra_gothram_other;
    public $religion;
    public $religion_other;
    public $modified_date;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->profile_for = (isset($data['profile_for'])) ? $data['profile_for'] : null;
        $this->profile_for_others = (isset($data['profile_for_others'])) ? $data['profile_for_others'] : null;
        $this->name_title_user = (isset($data['name_title_user'])) ? $data['name_title_user'] : null;
        $this->full_name = (isset($data['full_name'])) ? $data['full_name'] : null;
        $this->alternate_mobile_no = (isset($data['alternate_mobile_no'])) ? $data['alternate_mobile_no'] : null;
        $this->phone_no = (isset($data['phone_no'])) ? $data['phone_no'] : null;
        $this->gender = (isset($data['gender'])) ? $data['gender'] : null;
        $this->native_place = (isset($data['native_place'])) ? $data['native_place'] : null;
        $this->address = (isset($data['address'])) ? $data['address'] : null;
        $this->address_line2 = (isset($data['address_line2'])) ? $data['address_line2'] : null;
        $this->country = (isset($data['country'])) ? $data['country'] : null;
        $this->state = (isset($data['state'])) ? $data['state'] : null;
        $this->city = (isset($data['city'])) ? $data['city'] : null;
        $this->zip_pin_code = (isset($data['zip_pin_code'])) ? $data['zip_pin_code'] : null;
        $this->dob = (isset($data['dob'])) ? $data['dob'] : null;
        $this->age = (isset($data['age'])) ? $data['age'] : null;
        $this->any_disability = (isset($data['any_disability'])) ? $data['any_disability'] : null;
        $this->color_complexion = (isset($data['color_complexion'])) ? $data['color_complexion'] : null;
        $this->body_type = (isset($data['body_type'])) ? $data['body_type'] : null;
        $this->height = (isset($data['height'])) ? $data['height'] : null;
        $this->blood_group = (isset($data['blood_group'])) ? $data['blood_group'] : null;
        //$this->marital_status = (isset($data['marital_status'])) ? $data['marital_status'] : null;
        $this->gothra_gothram = (isset($data['gothra_gothram'])) ? $data['gothra_gothram'] : null;
        $this->gothra_gothram_other = (isset($data['gothra_gothram_other'])) ? $data['gothra_gothram_other'] : null;
        $this->religion = (isset($data['religion'])) ? $data['religion'] : null;
        $this->religion_other = (isset($data['religion_other'])) ? $data['religion_other'] : null;
        return $this;
    }

    public function exchangeArrayTable($data) {
        $userData['profile_for'] = (null!==$data->profile_for) ? $data->profile_for : null;
//        $userData['profile_for'] = (isset($data['profile_for'])) ? $data['profile_for'] : null;
//        $userData['profile_for_others'] = (isset($data['profile_for_others'])) ? $data['profile_for_others'] : null;
//        $userData['name_title_user'] = (isset($data['name_title_user'])) ? $data['name_title_user'] : null;
        $userData['myname'] = (null!==$data->full_name) ? $data->full_name : null;
//        $userData['alternate_mobile_no'] = (isset($data['alternate_mobile_no'])) ? $data['alternate_mobile_no'] : null;
//        $userData['phone_no'] = (isset($data['phone_no'])) ? $data['phone_no'] : null;
//        $userData['gender'] = (isset($data['gender'])) ? $data['gender'] : null;
//        $userData['native_place'] = (isset($data['native_place'])) ? $data['native_place'] : null;
//        $userData['address'] = (isset($data['address'])) ? $data['address'] : null;
//        $userData['address_line2'] = (isset($data['address_line2'])) ? $data['address_line2'] : null;
//        $userData['country'] = (isset($data['country'])) ? $data['country'] : null;
//        $userData['state'] = (isset($data['state'])) ? $data['state'] : null;
//        $userData['city'] = (isset($data['city'])) ? $data['city'] : null;
//        $userData['zip_pin_code'] = (isset($data['zip_pin_code'])) ? $data['zip_pin_code'] : null;
//        $userData['dob'] = (isset($data['dob'])) ? $data['dob'] : null;
//        $userData['age'] = (isset($data['age'])) ? $data['age'] : null;
//        $userData['any_disability'] = (isset($data['any_disability'])) ? $data['any_disability'] : null;
//        $userData['color_complexion'] = (isset($data['color_complexion'])) ? $data['color_complexion'] : null;
//        $userData['body_type'] = (isset($data['body_type'])) ? $data['body_type'] : null;
//        $userData['height'] = (isset($data['height'])) ? $data['height'] : null;
//        $userData['blood_group'] = (isset($data['blood_group'])) ? $data['blood_group'] : null;
//        //$this->marital_status = (isset($data['marital_status'])) ? $data['marital_status'] : null;
//        $userData['gothra_gothram'] = (isset($data['gothra_gothram'])) ? $data['gothra_gothram'] : null;
//        $userData['gothra_gothram_other'] = (isset($data['gothra_gothram_other'])) ? $data['gothra_gothram_other'] : null;
//        $userData['religion'] = (isset($data['religion'])) ? $data['religion'] : null;
//        $userData['religion_other'] = (isset($data['religion_other'])) ? $data['religion_other'] : null;
        return $userData;
    }

//    public function exchangeArray($data) {
//        $this->id = (isset($data['id'])) ? $data['id'] : null;
//        $this->profileFor = (isset($data['profile_for'])) ? $data['profile_for'] : null;
//        $this->profileForOthers = (isset($data['profile_for_others'])) ? $data['profile_for_others'] : null;
//        $this->nameTitleUser = (isset($data['name_title_user'])) ? $data['name_title_user'] : null;
//        $this->fullName= (isset($data['myname'])) ? $data['myname'] : null;
//        $this->alternateMobileNo = (isset($data['alternate_mobile_no'])) ? $data['alternate_mobile_no'] : null;
//        $this->phoneNo = (isset($data['phone_no'])) ? $data['phone_no'] : null;
//        $this->gender = (isset($data['gender'])) ? $data['gender'] : null;
//        $this->nativePlace = (isset($data['native_place'])) ? $data['native_place'] : null;
//        $this->address = (isset($data['address'])) ? $data['address'] : null;
//        $this->addressLine2 = (isset($data['address_line2'])) ? $data['address_line2'] : null;
//        $this->country = (isset($data['country'])) ? $data['country'] : null;
//        $this->state = (isset($data['state'])) ? $data['state'] : null;
//        $this->city = (isset($data['city'])) ? $data['city'] : null;
//        $this->zipPinCode = (isset($data['zip_pin_code'])) ? $data['zip_pin_code'] : null;
//        $this->dob = (isset($data['dob'])) ? $data['dob'] : null;
//        $this->age = (isset($data['age'])) ? $data['age'] : null;
//        $this->anyDisability = (isset($data['any_disability'])) ? $data['any_disability'] : null;
//        $this->colorComplexion = (isset($data['color_complexion'])) ? $data['color_complexion'] : null;
//        $this->bodyType = (isset($data['body_type'])) ? $data['body_type'] : null;
//        $this->height = (isset($data['height'])) ? $data['height'] : null;
//        $this->bloodGroup = (isset($data['blood_group'])) ? $data['blood_group'] : null;
//        //$this->marital_status = (isset($data['marital_status'])) ? $data['marital_status'] : null;
//        $this->gothraGothram = (isset($data['gothra_gothram'])) ? $data['gothra_gothram'] : null;
//        $this->gothraGothramOther = (isset($data['gothra_gothram_other'])) ? $data['gothra_gothram_other'] : null;
//        $this->religion = (isset($data['religion'])) ? $data['religion'] : null;
//        $this->religionOther = (isset($data['religion_other'])) ? $data['religion_other'] : null;
//        return $this;
//    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
