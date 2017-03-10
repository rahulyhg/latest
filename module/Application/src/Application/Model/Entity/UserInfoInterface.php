<?php
/**
 * Created by PhpStorm.
 * User: preet
 * Date: 28/8/16
 * Time: 10:36 AM
 */
namespace Application\Model\Entity;

interface UserInfoInterface
{
    function getId();

    function getRefNo();
    
    function getReferralKey();

    function getUserId();

    function getUserTypeId();

    function getCommMemId();

    function getCommMemStatus();

    function getFinancialYear();

    function getMembershipPaid();

    function getProfileFor();

    function getProfileForOthers();

    function getNameTitleUser();

    function getFullName();
    
    function getLastName();
    
    function getAlternateMobileNo();

    function getPhoneNo();

    function getGender();

    function getNativePlace();

    function getAddress();

    function getAddressLine2();

    function getCountry();

    function getState();

    function getCity();

    function getZipPinCode();

    function getAboutYourselfPartnerFamily();

    function getDob();

    function getAge();

    function getBloodGroup();

    function getSkinTone();

    function getMaritalStatus();

    function getNoOfChilds();

    function getStarSign();

    function getZodiacSignRaasi();

    function getSevvaiDosham();

    function getCaste();

    function getCasteOther();

    function getReligion();

    function getReligionOther();
    
    function getCommunity();
    
    function getCommunityOther();

    function getGothraGothram();

    function getGothraGothramOther();

    function getMealPreference();

    function getDrink();

    function getSmoke();

    function getManglikDossam();

    function getHeight();

    function getColorComplexion();

    function getAnyDisability();

    function getBodyType();

    function getEducationLevel();

    function getEducationLevelOther();

    function getEducationField();

    function getEducationFieldOther();

    function getSpecializationMajor();

    function getSpecializeProfession();

    function getEmploymentStatus();

    function getEmploymentStatusOther();

    function getProfession();

    function getProfessionOther();

    function getWorkplaceInfo();

    function getOfficeName();

    function getOfficeEmail();

    function getOfficeAddress();

    function getOfficeCountry();

    function getOfficeState();

    function getOfficeCity();

    function getOfficePincode();

    function getOfficePhone();

    function getOfficeWebsite();

    function getWorkingWith();

    function getWorkingWithOther();

    function getDesignation();

    function getDesignationOther();

    function getAnnualIncome();

    function getAnnualIncomeStatus();

    function getProfilePhoto();

    function getNoOfBrothers();

    function getNoOfBrothersMarried();

    function getNoOfSisters();

    function getNoOfSistersMarried();

    function getBranchIds();

    function getBranchIdsOther();

    function getIp();

    function getCreatedDate();

    function getModifiedDate();

    function setId($id);

    function setRefNo($refNo);
    
    function setReferralKey($referralKey);

    function setUserId($userId);

    function setUserTypeId($userTypeId);

    function setCommMemId($commMemId);

    function setCommMemStatus($commMemStatus);

    function setFinancialYear($financialYear);

    function setMembershipPaid($membershipPaid);

    function setProfileFor($profileFor);

    function setProfileForOthers($profileForOthers);

    function setNameTitleUser($nameTitleUser);

    function setFullName($fullName);
    
    function setLastName($lastName);
    
    function setAlternateMobileNo($alternateMobileNo);

    function setPhoneNo($phoneNo);

    function setGender($gender);

    function setNativePlace($nativePlace);

    function setAddress($address);

    function setAddressLine2($addressLine2);

    function setCountry($country);

    function setState($state);

    function setCity($city);

    function setZipPinCode($zipPinCode);

    function setAboutYourselfPartnerFamily($aboutYourselfPartnerFamily);

    function setDob($dob);

    function setAge($age);

    function setBloodGroup($bloodGroup);

    function setSkinTone($skinTone);

    function setMaritalStatus($maritalStatus);

    function setNoOfChilds($noOfChilds);

    function setStarSign($starSign);

    function setZodiacSignRaasi($zodiacSignRaasi);

    function setSevvaiDosham($sevvaiDosham);

    function setCaste($caste);

    function setCasteOther($casteOther);

    function setReligion($religion);

    function setReligionOther($religionOther);
    
    function setCommunity($community);
    
    function setCommunityOther($communityOther);
            
    function setGothraGothram($gothraGothram);

    function setGothraGothramOther($gothraGothramOther);

    function setMealPreference($mealPreference);

    function setDrink($drink);

    function setSmoke($smoke);

    function setManglikDossam($manglikDossam);

    function setHeight($height);

    function setColorComplexion($colorComplexion);

    function setAnyDisability($anyDisability);

    function setBodyType($bodyType);

    function setEducationLevel($educationLevel);

    function setEducationLevelOther($educationLevelOther);

    function setEducationField($educationField);

    function setEducationFieldOther($educationFieldOther);

    function setSpecializationMajor($specializationMajor);

    function setSpecializeProfession($specializeProfession);

    function setEmploymentStatus($employmentStatus);

    function setEmploymentStatusOther($employmentStatusOther);

    function setProfession($profession);

    function setProfessionOther($professionOther);

    function setWorkplaceInfo($workplaceInfo);

    function setOfficeName($officeName);

    function setOfficeEmail($officeEmail);

    function setOfficeAddress($officeAddress);

    function setOfficeCountry($officeCountry);

    function setOfficeState($officeState);

    function setOfficeCity($officeCity);

    function setOfficePincode($officePincode);

    function setOfficePhone($officePhone);

    function setOfficeWebsite($officeWebsite);

    function setWorkingWith($workingWith);

    function setWorkingWithOther($workingWithOther);

    function setDesignation($designation);

    function setDesignationOther($designationOther);

    function setAnnualIncome($annualIncome);

    function setAnnualIncomeStatus($annualIncomeStatus);

    function setProfilePhoto($profilePhoto);

    function setNoOfBrothers($noOfBrothers);

    function setNoOfBrothersMarried($noOfBrothersMarried);

    function setNoOfSisters($noOfSisters);

    function setNoOfSistersMarried($noOfSistersMarried);

    function setBranchIds($branchIds);

    function setBranchIdsOther($branchIdsOther);

    function setIp($ip);

    function setCreatedDate($createdDate);

    function setModifiedDate($modifiedDate);
    
    function getMotherTongueId();
    
    function getMotherTongueOther();
    
    function setMotherTongueId($motherTongueId);
    
    function setMotherTongueOther($motherTongueOther);
    
    function getSubCaste();
    
    function setSubCaste($subCaste);
    
    function getBodyWeight();
    
    function setBodyWeight($bodyWeight);
    
    function getBodyWeightType();
    
    function setBodyWeightType($bodyWeightType);
    
    function getBirthTime();
    
    function setBirthTime($birthTime);
    
    function getBirthPlace();
    
    function setBirthPlace($birthPlace);
    
}