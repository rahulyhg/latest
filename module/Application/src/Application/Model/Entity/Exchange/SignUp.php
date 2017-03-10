<?php

namespace Application\Model\Entity;

class SignUp implements SignUpInterface
{

    public $id;
    public $ref_no;
    public $user_id;
    public $user_type_id;
    public $username;
    public $password;
    public $email;
    public $mobile_no;
    public $activation_key;
    public $is_active;
    public $is_used;
    public $login_status;
    public $ip;
    public $name_title_user;
    public $full_name;
    public $father_name;
    public $gender;
    public $address;
    public $country;
    public $state;
    public $city;
    public $rustagi_branch;
    public $rustagi_branch_other;
    public $profession;
    public $profession_other;
    public $native_place;
    public $profile_for;
    public $profile_for_others;
    public $zip_pin_code;
    public $gothra_gothram;
    public $gothra_gothram_other;
    public $religion;
    public $religion_other;
    public $created_date;
    public $modified_date;
    public $modified_by;
    
   function __construct() {
        $this->createdDate = date("Y-m-d H:i:s");
        $this->modifiedDate = date("Y-m-d H:i:s");
        $remote = new RemoteAddress;
        $this->ip = $remote->getIpAddress();
    }
    
    public function exchangeArray($data) {
        //left is form field and right is table field
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->ref_no = (isset($data['ref_no'])) ? $data['ref_no'] : null;
        $this->user_id = (isset($data['ref_no'])) ? $data['ref_no'] : null;
        $this->user_type_id = (isset($data['ref_no'])) ? $data['ref_no'] : null;
        $this->username = (isset($data['ref_no'])) ? $data['ref_no'] : null;
        $this->password = (isset($data['ref_no'])) ? $data['ref_no'] : null;
        $this->email = (isset($data['ref_no'])) ? $data['ref_no'] : null;
        $this->mobile_no = (isset($data['ref_no'])) ? $data['ref_no'] : null;
        $this->activation_key = (isset($data['ref_no'])) ? $data['ref_no'] : null;
        $this->is_active = (isset($data['ref_no'])) ? $data['ref_no'] : null;
        $this->is_used = (isset($data['ref_no'])) ? $data['ref_no'] : null;
        $this->login_status = (isset($data['ref_no'])) ? $data['ref_no'] : null;
        $this->ip = (isset($data['ref_no'])) ? $data['ref_no'] : null;
        $this->name_title_user = (isset($data['ref_no'])) ? $data['ref_no'] : null;
        $this->full_name = (isset($data['profile_for'])) ? $data['profile_for'] : null;
        $this->father_name = (isset($data['profile_for_others'])) ? $data['profile_for_others'] : null;
        $this->gender = (isset($data['name_title_user'])) ? $data['name_title_user'] : null;
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
        //left is tbable field and right is form field
        $userData['profile_for'] = (null !== $data->profile_for) ? $data->profile_for : null;
//        $userData['profile_for'] = (isset($data['profile_for'])) ? $data['profile_for'] : null;
//        $userData['profile_for_others'] = (isset($data['profile_for_others'])) ? $data['profile_for_others'] : null;
//        $userData['name_title_user'] = (isset($data['name_title_user'])) ? $data['name_title_user'] : null;
        $userData['full_name'] = (null !== $data->full_name) ? $data->full_name : null;
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

    public function getArrayCopy() {
        return get_object_vars($this);
    }


//    
//    function getId() {
//        return $this->id;
//    }
//
//    function getRefNo() {
//        return $this->refNo;
//    }
//
//    function getUserId() {
//        return $this->userId;
//    }
//
//    function getUserTypeId() {
//        return $this->userTypeId;
//    }
//
//    function getUsername() {
//        return $this->username;
//    }
//
//    function getPassword() {
//        return $this->password;
//    }
//
//    function getEmail() {
//        return $this->email;
//    }
//
//    function getMobileNo() {
//        return $this->mobileNo;
//    }
//
//    function getActivationKey() {
//        return $this->activationKey;
//    }
//
//    function getIsActive() {
//        return $this->isActive;
//    }
//
//    function getIsUsed() {
//        return $this->isUsed;
//    }
//
//    function getLoginStatus() {
//        return $this->loginStatus;
//    }
//
//    function getIp() {
//        return $this->ip;
//    }
//
//    function getNameTitleUser() {
//        return $this->nameTitleUser;
//    }
//
//    function getFullName() {
//        return $this->fullName;
//    }
//
//    function getFatherName() {
//        return $this->fatherName;
//    }
//
//    function getGender() {
//        return $this->gender;
//    }
//
//    function getAddress() {
//        return $this->address;
//    }
//
//    function getCountry() {
//        return $this->country;
//    }
//
//    function getState() {
//        return $this->state;
//    }
//
//    function getCity() {
//        return $this->city;
//    }
//
//    function getRustagiBranch() {
//        return $this->rustagiBranch;
//    }
//
//    function getRustagiBranchOther() {
//        return $this->rustagiBranchOther;
//    }
//
//    function getProfession() {
//        return $this->profession;
//    }
//
//    function getProfessionOther() {
//        return $this->professionOther;
//    }
//
//    function getNativePlace() {
//        return $this->nativePlace;
//    }
//
//    function getProfileFor() {
//        return $this->profileFor;
//    }
//
//    function getProfileForOthers() {
//        return $this->profileForOthers;
//    }
//
//    function getZipPinCode() {
//        return $this->zipPinCode;
//    }
//
//    function getGothraGothram() {
//        return $this->gothraGothram;
//    }
//
//    function getGothraGothramOther() {
//        return $this->gothraGothramOther;
//    }
//
//    function getReligion() {
//        return $this->religion;
//    }
//
//    function getReligionOther() {
//        return $this->religionOther;
//    }
//
//    function getCreatedDate() {
//        return $this->createdDate;
//    }
//
//    function getModifiedDate() {
//        return $this->modifiedDate;
//    }
//
//    function getModifiedBy() {
//        return $this->modifiedBy;
//    }
//
//    function setId($id) {
//        $this->id = $id;
//    }
//
//    function setRefNo($refNo) {
//        $this->refNo = $refNo;
//    }
//
//    function setUserId($userId) {
//        $this->userId = $userId;
//    }
//
//    function setUserTypeId($userTypeId) {
//        $this->userTypeId = $userTypeId;
//    }
//
//    function setUsername($username) {
//        $this->username = $username;
//    }
//
//    function setPassword($password) {
//        $this->password = $password;
//    }
//
//    function setEmail($email) {
//        $this->email = $email;
//    }
//
//    function setMobileNo($mobileNo) {
//        $this->mobileNo = $mobileNo;
//    }
//
//    function setActivationKey($activationKey) {
//        $this->activationKey = $activationKey;
//    }
//
//    function setIsActive($isActive) {
//        $this->isActive = $isActive;
//    }
//
//    function setIsUsed($isUsed) {
//        $this->isUsed = $isUsed;
//    }
//
//    function setLoginStatus($loginStatus) {
//        $this->loginStatus = $loginStatus;
//    }
//
//    function setIp($ip) {
//        $this->ip = $ip;
//    }
//
//    function setNameTitleUser($nameTitleUser) {
//        $this->nameTitleUser = $nameTitleUser;
//    }
//
//    function setFullName($fullName) {
//        $this->fullName = $fullName;
//    }
//
//    function setFatherName($fatherName) {
//        $this->fatherName = $fatherName;
//    }
//
//    function setGender($gender) {
//        $this->gender = $gender;
//    }
//
//    function setAddress($address) {
//        $this->address = $address;
//    }
//
//    function setCountry($country) {
//        $this->country = $country;
//    }
//
//    function setState($state) {
//        $this->state = $state;
//    }
//
//    function setCity($city) {
//        $this->city = $city;
//    }
//
//    function setRustagiBranch($rustagiBranch) {
//        $this->rustagiBranch = $rustagiBranch;
//    }
//
//    function setRustagiBranchOther($rustagiBranchOther) {
//        $this->rustagiBranchOther = $rustagiBranchOther;
//    }
//
//    function setProfession($profession) {
//        $this->profession = $profession;
//    }
//
//    function setProfessionOther($professionOther) {
//        $this->professionOther = $professionOther;
//    }
//
//    function setNativePlace($nativePlace) {
//        $this->nativePlace = $nativePlace;
//    }
//
//    function setProfileFor($profileFor) {
//        $this->profileFor = $profileFor;
//    }
//
//    function setProfileForOthers($profileForOthers) {
//        $this->profileForOthers = $profileForOthers;
//    }
//
//    function setZipPinCode($zipPinCode) {
//        $this->zipPinCode = $zipPinCode;
//    }
//
//    function setGothraGothram($gothraGothram) {
//        $this->gothraGothram = $gothraGothram;
//    }
//
//    function setGothraGothramOther($gothraGothramOther) {
//        $this->gothraGothramOther = $gothraGothramOther;
//    }
//
//    function setReligion($religion) {
//        $this->religion = $religion;
//    }
//
//    function setReligionOther($religionOther) {
//        $this->religionOther = $religionOther;
//    }
//
//    function setCreatedDate($createdDate) {
//        $this->createdDate = $createdDate;
//    }
//
//    function setModifiedDate($modifiedDate) {
//        $this->modifiedDate = $modifiedDate;
//    }
//
//    function setModifiedBy($modifiedBy) {
//        $this->modifiedBy = $modifiedBy;
//    }



    

}
