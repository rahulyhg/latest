<?php

namespace Application\Form\Entity;

use Application\Form\Entity\SingUpFormInterface;
use Zend\Http\PhpEnvironment\RemoteAddress;

class SignUpFormEntity implements SingUpFormInterface {

    public $id;
    public $refNo;
    public $userId;
    public $userTypeId;
    public $username;
    public $password;
    public $email;
    public $mobileNo;
    public $dob;
    public $activationKey;
    public $isActive;
    public $isUsed;
    public $loginStatus;
    public $ip;
    public $nameTitleUser;
    public $fullName;
    public $userNewId;
    public $fatherName;
    public $fatherId;
    public $gender;
    public $address;
    public $country;
    public $state;
    public $city;
    public $rustagiBranch;
    public $rustagiBranchOther;
    public $profession;
    public $professionOther;
    public $nativePlace;
    public $profileFor;
    public $profileForOthers;
    public $zipPinCode;
    public $gothraGothram;
    public $gothraGothramOther;
    public $religion;
    public $religionOther;
    public $createdDate;
    public $modifiedDate;
    public $modifiedBy;
    public $referralkey;

    function __construct() {
        $this->createdDate = date("Y-m-d H:i:s");
        $this->modifiedDate = date("Y-m-d H:i:s");
        $remote = new RemoteAddress;
        $this->ip = $remote->getIpAddress();
    }

   
    function getId() {
        return $this->id;
    }

    function getRefNo() {
        return $this->refNo;
    }

    function getUserId() {
        return $this->userId;
    }

    function getUserTypeId() {
        return $this->userTypeId;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getEmail() {
        return $this->email;
    }
    
    function getDob() {
        return $this->dob;
    }

    function getMobileNo() {
        return $this->mobileNo;
    }

    function getActivationKey() {
        return $this->activationKey;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function getIsUsed() {
        return $this->isUsed;
    }

    function getLoginStatus() {
        return $this->loginStatus;
    }

    function getIp() {
        return $this->ip;
    }

    function getNameTitleUser() {
        return $this->nameTitleUser;
    }

    function getFullName() {
        return $this->fullName;
    }
    
    function getUserNewId() {
        return $this->userNewId;
    }

    function getFatherName() {
        return $this->fatherName;
    }
    
    function getfatherId() {
        return $this->fatherId;
    }

    function getGender() {
        return $this->gender;
    }

    function getAddress() {
        return $this->address;
    }

    function getCountry() {
        return $this->country;
    }

    function getState() {
        return $this->state;
    }

    function getCity() {
        return $this->city;
    }

    function getRustagiBranch() {
        return $this->rustagiBranch;
    }

    function getRustagiBranchOther() {
        return $this->rustagiBranchOther;
    }

    function getProfession() {
        return $this->profession;
    }

    function getProfessionOther() {
        return $this->professionOther;
    }

    function getNativePlace() {
        return $this->nativePlace;
    }

    function getProfileFor() {
        return $this->profileFor;
    }

    function getProfileForOthers() {
        return $this->profileForOthers;
    }

    function getZipPinCode() {
        return $this->zipPinCode;
    }

    function getGothraGothram() {
        return $this->gothraGothram;
    }

    function getGothraGothramOther() {
        return $this->gothraGothramOther;
    }

    function getReligion() {
        return $this->religion;
    }

    function getReligionOther() {
        return $this->religionOther;
    }

    function getCreatedDate() {
        return $this->createdDate;
    }

    function getModifiedDate() {
        return $this->modifiedDate;
    }

    function getModifiedBy() {
        return $this->modifiedBy;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setRefNo($refNo) {
        $this->refNo = $refNo;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setUserTypeId($userTypeId) {
        $this->userTypeId = $userTypeId;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setEmail($email) {
        $this->email = $email;
    }
    
    function setDob($dob) {
        $this->dob = $dob;
    }

    function setMobileNo($mobileNo) {
        $this->mobileNo = $mobileNo;
    }

    function setActivationKey($activationKey) {
        $this->activationKey = $activationKey;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    function setIsUsed($isUsed) {
        $this->isUsed = $isUsed;
    }

    function setLoginStatus($loginStatus) {
        $this->loginStatus = $loginStatus;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

    function setNameTitleUser($nameTitleUser) {
        $this->nameTitleUser = $nameTitleUser;
    }

    function setFullName($fullName) {
        $this->fullName = $fullName;
    }
       
    function setUserNewId($userNewId) {
        $this->userNewId = $userNewId;
    }

    function setFatherName($fatherName) {
        $this->fatherName = $fatherName;
    }
    
    function setFatherId($fatherId) {
        $this->fatherId = $fatherId;
    }

    function setGender($gender) {
        $this->gender = $gender;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setCountry($country) {
        $this->country = $country;
    }

    function setState($state) {
        $this->state = $state;
    }

    function setCity($city) {
        $this->city = $city;
    }

    function setRustagiBranch($rustagiBranch) {
        $this->rustagiBranch = $rustagiBranch;
    }

    function setRustagiBranchOther($rustagiBranchOther) {
        $this->rustagiBranchOther = $rustagiBranchOther;
    }

    function setProfession($profession) {
        $this->profession = $profession;
    }

    function setProfessionOther($professionOther) {
        $this->professionOther = $professionOther;
    }

    function setNativePlace($nativePlace) {
        $this->nativePlace = $nativePlace;
    }

    function setProfileFor($profileFor) {
        $this->profileFor = $profileFor;
    }

    function setProfileForOthers($profileForOthers) {
        $this->profileForOthers = $profileForOthers;
    }

    function setZipPinCode($zipPinCode) {
        $this->zipPinCode = $zipPinCode;
    }

    function setGothraGothram($gothraGothram) {
        $this->gothraGothram = $gothraGothram;
    }

    function setGothraGothramOther($gothraGothramOther) {
        $this->gothraGothramOther = $gothraGothramOther;
    }

    function setReligion($religion) {
        $this->religion = $religion;
    }

    function setReligionOther($religionOther) {
        $this->religionOther = $religionOther;
    }

    function setCreatedDate($createdDate) {
        $this->createdDate = $createdDate;
    }

    function setModifiedDate($modifiedDate) {
        $this->modifiedDate = $modifiedDate;
    }

    function setModifiedBy($modifiedBy) {
        $this->modifiedBy = $modifiedBy;
    }


    function getReferralkey() {
        return $this->referralkey;
    }

    function setReferralkey($referralkey) {
        $this->referralkey = $referralkey;
    }



}
