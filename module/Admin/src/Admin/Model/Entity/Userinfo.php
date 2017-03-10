<?php

namespace Admin\Model\Entity;

class Userinfo implements UserInfoInterface
{

    protected $id;
    protected $refNo;
    protected $referralKey;
    protected $userId;
    protected $userTypeId;
    protected $commMemId;
    protected $commMemStatus;
    protected $financialYear;
    protected $membershipPaid;
    protected $profileFor;
    protected $profileForOthers;
    protected $nameTitleUser;
    protected $fullName;
    protected $alternateMobileNo;
    protected $phoneNo;
    protected $gender;
    protected $nativePlace;
    protected $address;
    protected $addressLine2;
    protected $country;
    protected $state;
    protected $city;
    protected $zipPinCode;
    protected $aboutYourselfPartnerFamily;
    protected $aboutMe;
    protected $dob;
    protected $age;
    protected $bloodGroup;
    protected $skinTone;
    protected $maritalStatus;
    protected $noOfChilds;
    protected $starSign;
    protected $zodiacSignRaasi;
    protected $sevvaiDosham;
    protected $caste;
    protected $casteOther;
    protected $religion;
    protected $religionOther;
    protected $gothraGothram;
    protected $gothraGothramOther;
    protected $mealPreference;
    protected $drink;
    protected $smoke;
    protected $manglikDossam;
    protected $height;
    protected $colorComplexion;
    protected $anyDisability;
    protected $bodyType;
    protected $educationLevel;
    protected $educationLevelOther;
    protected $educationField;
    protected $educationFieldOther;
    protected $specializationMajor;
    protected $specializeProfession;
    protected $employmentStatus;
    protected $employmentStatusOther;
    protected $profession;
    protected $professionOther;
    protected $workplaceInfo;
    protected $officeName;
    protected $officeEmail;
    protected $officeAddress;
    protected $officeCountry;
    protected $officeState;
    protected $officeCity;
    protected $officePincode;
    protected $officePhone;
    protected $officeWebsite;
    protected $workingWith;
    protected $workingWithOther;
    protected $designation;
    protected $designationOther;
    protected $annualIncome;
    protected $annualIncomeStatus;
    protected $profilePhoto;
    protected $noOfBrothers;
    protected $noOfBrothersMarried;
    protected $noOfSisters;
    protected $noOfSistersMarried;
    protected $branchIds;
    protected $branchIdsOther;
    protected $ip;
    protected $createdDate;
    protected $modifiedDate;
    protected $motherTongueId;
    protected $subCaste;
    protected $bodyWeight;
    protected $bodyWeightType;
    protected $birthTime;
    protected $birthPlace;

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

    function getCommMemId() {
        return $this->commMemId;
    }

    function getCommMemStatus() {
        return $this->commMemStatus;
    }

    function getFinancialYear() {
        return $this->financialYear;
    }

    function getMembershipPaid() {
        return $this->membershipPaid;
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

    function getAlternateMobileNo() {
        return $this->alternateMobileNo;
    }

    function getPhoneNo() {
        return $this->phoneNo;
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

    function getAboutYourselfPartnerFamily() {
        return $this->aboutYourselfPartnerFamily;
    }

    function getAboutMe() {
        return $this->aboutMe;
    }

    function getDob() {
        return $this->dob;
    }

    function getAge() {
        return $this->age;
    }

    function getBloodGroup() {
        return $this->bloodGroup;
    }

    function getSkinTone() {
        return $this->skinTone;
    }

    function getMaritalStatus() {
        return $this->maritalStatus;
    }

    function getNoOfChilds() {
        return $this->noOfChilds;
    }

    function getStarSign() {
        return $this->starSign;
    }

    function getZodiacSignRaasi() {
        return $this->zodiacSignRaasi;
    }

    function getSevvaiDosham() {
        return $this->sevvaiDosham;
    }

    function getCaste() {
        return $this->caste;
    }

    function getCasteOther() {
        return $this->casteOther;
    }

    function getReligion() {
        return $this->religion;
    }

    function getReligionOther() {
        return $this->religionOther;
    }

    function getGothraGothram() {
        return $this->gothraGothram;
    }

    function getGothraGothramOther() {
        return $this->gothraGothramOther;
    }

    function getMealPreference() {
        return $this->mealPreference;
    }

    function getDrink() {
        return $this->drink;
    }

    function getSmoke() {
        return $this->smoke;
    }

    function getManglikDossam() {
        return $this->manglikDossam;
    }

    function getHeight() {
        return $this->height;
    }

    function getColorComplexion() {
        return $this->colorComplexion;
    }

    function getAnyDisability() {
        return $this->anyDisability;
    }

    function getBodyType() {
        return $this->bodyType;
    }

    function getEducationLevel() {
        return $this->educationLevel;
    }

    function getEducationLevelOther() {
        return $this->educationLevelOther;
    }

    function getEducationField() {
        return $this->educationField;
    }

    function getEducationFieldOther() {
        return $this->educationFieldOther;
    }

    function getSpecializationMajor() {
        return $this->specializationMajor;
    }

    function getSpecializeProfession() {
        return $this->specializeProfession;
    }

    function getEmploymentStatus() {
        return $this->employmentStatus;
    }

    function getEmploymentStatusOther() {
        return $this->employmentStatusOther;
    }

    function getProfession() {
        return $this->profession;
    }

    function getProfessionOther() {
        return $this->professionOther;
    }

    function getWorkplaceInfo() {
        return $this->workplaceInfo;
    }

    function getOfficeName() {
        return $this->officeName;
    }

    function getOfficeEmail() {
        return $this->officeEmail;
    }

    function getOfficeAddress() {
        return $this->officeAddress;
    }

    function getOfficeCountry() {
        return $this->officeCountry;
    }

    function getOfficeState() {
        return $this->officeState;
    }

    function getOfficeCity() {
        return $this->officeCity;
    }

    function getOfficePincode() {
        return $this->officePincode;
    }

    function getOfficePhone() {
        return $this->officePhone;
    }

    function getOfficeWebsite() {
        return $this->officeWebsite;
    }

    function getWorkingWith() {
        return $this->workingWith;
    }

    function getWorkingWithOther() {
        return $this->workingWithOther;
    }

    function getDesignation() {
        return $this->designation;
    }

    function getDesignationOther() {
        return $this->designationOther;
    }

    function getAnnualIncome() {
        return $this->annualIncome;
    }

    function getAnnualIncomeStatus() {
        return $this->annualIncomeStatus;
    }

    function getProfilePhoto() {
        return $this->profilePhoto;
    }

    function getNoOfBrothers() {
        return $this->noOfBrothers;
    }

    function getNoOfBrothersMarried() {
        return $this->noOfBrothersMarried;
    }

    function getNoOfSisters() {
        return $this->noOfSisters;
    }

    function getNoOfSistersMarried() {
        return $this->noOfSistersMarried;
    }

    function getBranchIds() {
        return $this->branchIds;
    }

    function getBranchIdsOther() {
        return $this->branchIdsOther;
    }

    function getIp() {
        return $this->ip;
    }

    function getCreatedDate() {
        return $this->createdDate;
    }

    function getModifiedDate() {
        return $this->modifiedDate;
    }

    function getMotherTongueId() {
        return $this->motherTongueId;
    }

    function getSubCaste() {
        return $this->subCaste;
    }

    function getBodyWeight() {
        return $this->bodyWeight;
    }

    function getBodyWeightType() {
        return $this->bodyWeightType;
    }

    function getBirthTime() {
        return $this->birthTime;
    }

    function getBirthPlace() {
        return $this->birthPlace;
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

    function setCommMemId($commMemId) {
        $this->commMemId = $commMemId;
    }

    function setCommMemStatus($commMemStatus) {
        $this->commMemStatus = $commMemStatus;
    }

    function setFinancialYear($financialYear) {
        $this->financialYear = $financialYear;
    }

    function setMembershipPaid($membershipPaid) {
        $this->membershipPaid = $membershipPaid;
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

    function setAlternateMobileNo($alternateMobileNo) {
        $this->alternateMobileNo = $alternateMobileNo;
    }

    function setPhoneNo($phoneNo) {
        $this->phoneNo = $phoneNo;
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

    function setAboutYourselfPartnerFamily($aboutYourselfPartnerFamily) {
        $this->aboutYourselfPartnerFamily = $aboutYourselfPartnerFamily;
    }

    function setAboutMe($aboutMe) {
        $this->aboutMe = $aboutMe;
    }

    function setDob($dob) {
        $this->dob = $dob;
    }

    function setAge($age) {
        $this->age = $age;
    }

    function setBloodGroup($bloodGroup) {
        $this->bloodGroup = $bloodGroup;
    }

    function setSkinTone($skinTone) {
        $this->skinTone = $skinTone;
    }

    function setMaritalStatus($maritalStatus) {
        $this->maritalStatus = $maritalStatus;
    }

    function setNoOfChilds($noOfChilds) {
        $this->noOfChilds = $noOfChilds;
    }

    function setStarSign($starSign) {
        $this->starSign = $starSign;
    }

    function setZodiacSignRaasi($zodiacSignRaasi) {
        $this->zodiacSignRaasi = $zodiacSignRaasi;
    }

    function setSevvaiDosham($sevvaiDosham) {
        $this->sevvaiDosham = $sevvaiDosham;
    }

    function setCaste($caste) {
        $this->caste = $caste;
    }

    function setCasteOther($casteOther) {
        $this->casteOther = $casteOther;
    }

    function setReligion($religion) {
        $this->religion = $religion;
    }

    function setReligionOther($religionOther) {
        $this->religionOther = $religionOther;
    }

    function setGothraGothram($gothraGothram) {
        $this->gothraGothram = $gothraGothram;
    }

    function setGothraGothramOther($gothraGothramOther) {
        $this->gothraGothramOther = $gothraGothramOther;
    }

    function setMealPreference($mealPreference) {
        $this->mealPreference = $mealPreference;
    }

    function setDrink($drink) {
        $this->drink = $drink;
    }

    function setSmoke($smoke) {
        $this->smoke = $smoke;
    }

    function setManglikDossam($manglikDossam) {
        $this->manglikDossam = $manglikDossam;
    }

    function setHeight($height) {
        $this->height = $height;
    }

    function setColorComplexion($colorComplexion) {
        $this->colorComplexion = $colorComplexion;
    }

    function setAnyDisability($anyDisability) {
        $this->anyDisability = $anyDisability;
    }

    function setBodyType($bodyType) {
        $this->bodyType = $bodyType;
    }

    function setEducationLevel($educationLevel) {
        $this->educationLevel = $educationLevel;
    }

    function setEducationLevelOther($educationLevelOther) {
        $this->educationLevelOther = $educationLevelOther;
    }

    function setEducationField($educationField) {
        $this->educationField = $educationField;
    }

    function setEducationFieldOther($educationFieldOther) {
        $this->educationFieldOther = $educationFieldOther;
    }

    function setSpecializationMajor($specializationMajor) {
        $this->specializationMajor = $specializationMajor;
    }

    function setSpecializeProfession($specializeProfession) {
        $this->specializeProfession = $specializeProfession;
    }

    function setEmploymentStatus($employmentStatus) {
        $this->employmentStatus = $employmentStatus;
    }

    function setEmploymentStatusOther($employmentStatusOther) {
        $this->employmentStatusOther = $employmentStatusOther;
    }

    function setProfession($profession) {
        $this->profession = $profession;
    }

    function setProfessionOther($professionOther) {
        $this->professionOther = $professionOther;
    }

    function setWorkplaceInfo($workplaceInfo) {
        $this->workplaceInfo = $workplaceInfo;
    }

    function setOfficeName($officeName) {
        $this->officeName = $officeName;
    }

    function setOfficeEmail($officeEmail) {
        $this->officeEmail = $officeEmail;
    }

    function setOfficeAddress($officeAddress) {
        $this->officeAddress = $officeAddress;
    }

    function setOfficeCountry($officeCountry) {
        $this->officeCountry = $officeCountry;
    }

    function setOfficeState($officeState) {
        $this->officeState = $officeState;
    }

    function setOfficeCity($officeCity) {
        $this->officeCity = $officeCity;
    }

    function setOfficePincode($officePincode) {
        $this->officePincode = $officePincode;
    }

    function setOfficePhone($officePhone) {
        $this->officePhone = $officePhone;
    }

    function setOfficeWebsite($officeWebsite) {
        $this->officeWebsite = $officeWebsite;
    }

    function setWorkingWith($workingWith) {
        $this->workingWith = $workingWith;
    }

    function setWorkingWithOther($workingWithOther) {
        $this->workingWithOther = $workingWithOther;
    }

    function setDesignation($designation) {
        $this->designation = $designation;
    }

    function setDesignationOther($designationOther) {
        $this->designationOther = $designationOther;
    }

    function setAnnualIncome($annualIncome) {
        $this->annualIncome = $annualIncome;
    }

    function setAnnualIncomeStatus($annualIncomeStatus) {
        $this->annualIncomeStatus = $annualIncomeStatus;
    }

    function setProfilePhoto($profilePhoto) {
        $this->profilePhoto = $profilePhoto;
    }

    function setNoOfBrothers($noOfBrothers) {
        $this->noOfBrothers = $noOfBrothers;
    }

    function setNoOfBrothersMarried($noOfBrothersMarried) {
        $this->noOfBrothersMarried = $noOfBrothersMarried;
    }

    function setNoOfSisters($noOfSisters) {
        $this->noOfSisters = $noOfSisters;
    }

    function setNoOfSistersMarried($noOfSistersMarried) {
        $this->noOfSistersMarried = $noOfSistersMarried;
    }

    function setBranchIds($branchIds) {
        $this->branchIds = $branchIds;
    }

    function setBranchIdsOther($branchIdsOther) {
        $this->branchIdsOther = $branchIdsOther;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

    function setCreatedDate($createdDate) {
        $this->createdDate = $createdDate;
    }

    function setModifiedDate($modifiedDate) {
        $this->modifiedDate = $modifiedDate;
    }

    function setMotherTongueId($motherTongueId) {
        $this->motherTongueId = $motherTongueId;
    }

    function setSubCaste($subCaste) {
        $this->subCaste = $subCaste;
    }

    function setBodyWeight($bodyWeight) {
        $this->bodyWeight = $bodyWeight;
    }

    function setBodyWeightType($bodyWeightType) {
        $this->bodyWeightType = $bodyWeightType;
    }

    function setBirthTime($birthTime) {
        $this->birthTime = $birthTime;
    }

    function setBirthPlace($birthPlace) {
        $this->birthPlace = $birthPlace;
    }


    function getReferralKey() {
        return $this->referralKey;
    }

    function setReferralKey($referralKey) {
        $this->referralKey = $referralKey;
    }





}
