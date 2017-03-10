<?php

namespace Application\Form\Entity;

interface SingUpFormInterface {

    function getId();

    function getRefNo();
    
    function getReferralkey();

    function getUserId();

    function setUserId($userId);

    function getUserTypeId();

    function getUsername();

    function getPassword();

    function getEmail();
    
    function getDob();

    function getMobileNo();

    function getActivationKey();

    function getIsActive();

    function getIsUsed();

    function getLoginStatus();

    function getIp();

    function getNameTitleUser();

    function getFullName();

    function getFatherName();

    function getGender();

    function getAddress();

    function getCountry();

    function getState();

    function getCity();

    function getRustagiBranch();

    function getRustagiBranchOther();

    function getProfession();

    function getProfessionOther();

    function getNativePlace();

    function getProfileFor();

    function getProfileForOthers();

    function getZipPinCode();

    function getGothraGothram();

    function getGothraGothramOther();

    function getReligion();

    function getReligionOther();

    function getCreatedDate();

    function getModifiedDate();

    function getModifiedBy();

    function setId($id);

    function setRefNo($refNo);

    function setUserTypeId($userTypeId);

    function setUsername($username);
    
    function setReferralKey($referralkey);

    function setPassword($password);

    function setEmail($email);
    
    function setDob($dob);

    function setMobileNo($mobileNo);

    function setActivationKey($activationKey);

    function setIsActive($isActive);

    function setIsUsed($isUsed);

    function setLoginStatus($loginStatus);

    function setIp($ip);

    function setNameTitleUser($nameTitleUser);

    function setFullName($fullName);

    function setFatherName($fatherName);

    function setGender($gender);

    function setAddress($address);

    function setCountry($country);

    function setState($state);

    function setCity($city);

    function setRustagiBranch($rustagiBranch);

    function setRustagiBranchOther($rustagiBranchOther);

    function setProfession($profession);

    function setProfessionOther($professionOther);

    function setNativePlace($nativePlace);

    function setProfileFor($profileFor);

    function setProfileForOthers($profileForOthers);

    function setZipPinCode($zipPinCode);

    function setGothraGothram($gothraGothram);

    function setGothraGothramOther($gothraGothramOther);

    function setReligion($religion);

    function setReligionOther($religionOther);

    function setCreatedDate($createdDate);

    function setModifiedDate($modifiedDate);

    function setModifiedBy($modifiedBy);
}
