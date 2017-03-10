<?php

namespace Application\Model\Entity;

class Memberbasic implements MemberbasicInterface {

    public $id;
    public $profileFor;
    public $profileForOthers;
    public $nameTitleUser;
    public $fullName;
    public $alternateMobileNumber;
    public $phoneNumber;
    public $gender;
    public $nativePlace;
    public $address;
    public $addressLine2;
    public $country;
    public $state;
    public $city;
    public $zipPinCode;
    public $dob;
    public $age;
    public $anyDisability;
    public $colorComplexion;
    public $bodyType;
    public $height;
    public $bloodGroup;
    //public $marital_status;
    public $gothraGothram;
    public $gothraGothramOther;
    public $religion;
    public $religionOther;
    
    function getId() {
        return $this->id;
    }

    function getProfileFor() {
        return $this->profileFor;
    }

    function getProfileForOthers() {
        return $this->profileForOthers;
    }

    function getNameTitleUser() {
        return $this->nameTitleUser;
    }

    function getFullName() {
        return $this->fullName;
    }

    function getAlternateMobileNumber() {
        return $this->alternateMobileNumber;
    }

    function getPhoneNumber() {
        return $this->phoneNumber;
    }

    function getGender() {
        return $this->gender;
    }

    function getNativePlace() {
        return $this->nativePlace;
    }

    function getAddress() {
        return $this->address;
    }

    function getAddressLine2() {
        return $this->addressLine2;
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

    function getZipPinCode() {
        return $this->zipPinCode;
    }

    function getDob() {
        return $this->dob;
    }

    function getAge() {
        return $this->age;
    }

    function getAnyDisability() {
        return $this->anyDisability;
    }

    function getColorComplexion() {
        return $this->colorComplexion;
    }

    function getBodyType() {
        return $this->bodyType;
    }

    function getHeight() {
        return $this->height;
    }

    function getBloodGroup() {
        return $this->bloodGroup;
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

    function setId($id) {
        $this->id = $id;
    }

    function setProfileFor($profileFor) {
        $this->profileFor = $profileFor;
    }

    function setProfileForOthers($profileForOthers) {
        $this->profileForOthers = $profileForOthers;
    }

    function setNameTitleUser($nameTitleUser) {
        $this->nameTitleUser = $nameTitleUser;
    }

    function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    function setAlternateMobileNumber($alternateMobileNumber) {
        $this->alternateMobileNumber = $alternateMobileNumber;
    }

    function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }

    function setGender($gender) {
        $this->gender = $gender;
    }

    function setNativePlace($nativePlace) {
        $this->nativePlace = $nativePlace;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setAddressLine2($addressLine2) {
        $this->addressLine2 = $addressLine2;
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

    function setZipPinCode($zipPinCode) {
        $this->zipPinCode = $zipPinCode;
    }

    function setDob($dob) {
        $this->dob = $dob;
    }

    function setAge($age) {
        $this->age = $age;
    }

    function setAnyDisability($anyDisability) {
        $this->anyDisability = $anyDisability;
    }

    function setColorComplexion($colorComplexion) {
        $this->colorComplexion = $colorComplexion;
    }

    function setBodyType($bodyType) {
        $this->bodyType = $bodyType;
    }

    function setHeight($height) {
        $this->height = $height;
    }

    function setBloodGroup($bloodGroup) {
        $this->bloodGroup = $bloodGroup;
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




}
