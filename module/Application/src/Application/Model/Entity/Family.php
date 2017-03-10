<?php

namespace Application\Model\Entity;

class Family {

    public $id;
    public $userId;
    public $fatherId;
    public $motherId;
    public $wifeId;
    public $husbandId;
    public $spouseId;
    public $grandFatherId;
    public $grandMotherId;
    public $grandGrandFatherId;
    public $grandGrandMotherId;
    public $familyValues;
    public $nameTitleSpouse;
    public $spouseName;
    public $spouseLastName;
    public $spouseStatus;
    public $spouseDob;
    public $spousePhoto;
    public $spouseDiedOn;
    public $nameTitleFather;
    public $fatherName;
    public $fatherLastName;
    public $fatherStatus;
    public $fatherDob;
    public $fatherPhoto;
    public $fatherDod;
    public $nameTitleMother;
    public $motherName;
    public $motherLastName;
    public $motherStatus;
    public $motherDob;
    public $motherPhoto;
    public $motherDod;
    public $nameTitleGrandFather;
    public $grandFatherName;
    public $grandFatherLastName;
    public $grandFatherStatus;
    public $grandFatherDob;
    public $grandFatherPhoto;
    public $grandFatherDod;
    public $nameTitleGrandMother;
    public $grandMotherName;
    public $grandMotherLastName;
    public $grandMotherStatus;
    public $grandMotherDob;
    public $grandMotherPhoto;
    public $grandMotherDod;
    public $nameTitleGrandGrandFather;
    public $GrandGrandFatherName;
    public $grandGrandFatherLastName;
    public $grandGrandFatherStatus;
    public $grandGrandFatherDob;
    public $grandGrandFatherPhoto;
    public $grandGrandFatherDod;
    public $nameTitleGrandGrandMother;
    public $grandGrandMotherName;
    public $grandGrandMotherLastName;
    public $grandGrandMotherStatus;
    public $grandGrandMotherDob;
    public $grandGrandMotherPhoto;
    public $grandGrandMotherDod;
    public $spouseFirstNameTitle;
    public $spouseFatherName;
    public $spouseFatherLastName;
    public $spouseFatherStatus;
    public $spouseFatherDob;
    public $spouseFatherPhoto;
    public $spouseFatherDiedOn;
    public $spouseMotherNameTitle;
    public $spouseMotherName;
    public $spouseMotherLastName;
    public $spouseMotherStatus;
    public $spouseMotherDob;
    public $spouseMotherPhoto;
    public $spouseMotherDiedOn;
    public $nameTitleKids;
    public $kidsName;
    public $kidsLastName;
    public $kidsStatus;
    public $kidsDob;
    public $kidsPhoto;
    public $numbor;
    public $nameTitleBrother;
    public $brotherName;
    public $brotherLastName;
    public $brotherStatus;
    public $brotherDob;
    public $brotherPhoto;
    public $nameTitleSister;
    public $sisterName;
    public $sisterLastName;
    public $sisterStatus;
    public $sisterDob;
    public $sisterPhoto;
    public $nameTitleSpouseSister;
    public $spouseSisterName;
    public $spouseSisterLastName;
    public $spouseSisterStatus;
    public $spouseSisterDob;
    public $spouseSisterPhoto;
    
    function getId() {
        return $this->id;
    }

    function getUserId() {
        return $this->userId;
    }

    function getFatherId() {
        return $this->fatherId;
    }

    function getMotherId() {
        return $this->motherId;
    }

    function getWifeId() {
        return $this->wifeId;
    }

    function getHusbandId() {
        return $this->husbandId;
    }

    function getSpouseId() {
        return $this->spouseId;
    }

    function getGrandFatherId() {
        return $this->grandFatherId;
    }

    function getGrandMotherId() {
        return $this->grandMotherId;
    }

    function getGrandGrandFatherId() {
        return $this->grandGrandFatherId;
    }

    function getGrandGrandMotherId() {
        return $this->grandGrandMotherId;
    }

    function getFamilyValues() {
        return $this->familyValues;
    }

    function getNameTitleSpouse() {
        return $this->nameTitleSpouse;
    }

    function getSpouseName() {
        return $this->spouseName;
    }

    function getSpouseStatus() {
        return $this->spouseStatus;
    }

    function getSpouseDob() {
        return $this->spouseDob;
    }

    function getSpousePhoto() {
        return $this->spousePhoto;
    }

    function getSpouseDiedOn() {
        return $this->spouseDiedOn;
    }

    function getNameTitleFather() {
        return $this->nameTitleFather;
    }

    function getFatherName() {
        return $this->fatherName;
    }

    function getFatherStatus() {
        return $this->fatherStatus;
    }

    function getFatherDob() {
        return $this->fatherDob;
    }

    function getFatherPhoto() {
        return $this->fatherPhoto;
    }

    function getFatherDod() {
        return $this->fatherDod;
    }

    function getNameTitleMother() {
        return $this->nameTitleMother;
    }

    function getMotherName() {
        return $this->motherName;
    }

    function getMotherStatus() {
        return $this->motherStatus;
    }

    function getMotherDob() {
        return $this->motherDob;
    }

    function getMotherPhoto() {
        return $this->motherPhoto;
    }

    function getMotherDod() {
        return $this->motherDod;
    }

    function getNameTitleGrandFather() {
        return $this->nameTitleGrandFather;
    }

    function getGrandFatherName() {
        return $this->grandFatherName;
    }

    function getGrandFatherStatus() {
        return $this->grandFatherStatus;
    }

    function getGrandFatherDob() {
        return $this->grandFatherDob;
    }

    function getGrandFatherPhoto() {
        return $this->grandFatherPhoto;
    }

    function getGrandFatherDod() {
        return $this->grandFatherDod;
    }

    function getNameTitleGrandMother() {
        return $this->nameTitleGrandMother;
    }

    function getGrandMotherName() {
        return $this->grandMotherName;
    }

    function getGrandMotherStatus() {
        return $this->grandMotherStatus;
    }

    function getGrandMotherDob() {
        return $this->grandMotherDob;
    }

    function getGrandMotherPhoto() {
        return $this->grandMotherPhoto;
    }

    function getGrandMotherDod() {
        return $this->grandMotherDod;
    }

    function getNameTitleGrandGrandFather() {
        return $this->nameTitleGrandGrandFather;
    }

    function getGrandGrandFatherName() {
        return $this->GrandGrandFatherName;
    }

    function getGrandGrandFatherStatus() {
        return $this->grandGrandFatherStatus;
    }

    function getGrandGrandFatherDob() {
        return $this->grandGrandFatherDob;
    }

    function getGrandGrandFatherPhoto() {
        return $this->grandGrandFatherPhoto;
    }

    function getGrandGrandFatherDod() {
        return $this->grandGrandFatherDod;
    }

    function getNameTitleGrandGrandMother() {
        return $this->nameTitleGrandGrandMother;
    }

    function getGrandGrandMotherName() {
        return $this->grandGrandMotherName;
    }

    function getGrandGrandMotherStatus() {
        return $this->grandGrandMotherStatus;
    }

    function getGrandGrandMotherDob() {
        return $this->grandGrandMotherDob;
    }

    function getGrandGrandMotherPhoto() {
        return $this->grandGrandMotherPhoto;
    }

    function getGrandGrandMotherDod() {
        return $this->grandGrandMotherDod;
    }

    function getSpouseFirstNameTitle() {
        return $this->spouseFirstNameTitle;
    }

    function getSpouseFatherName() {
        return $this->spouseFatherName;
    }

    function getSpouseFatherStatus() {
        return $this->spouseFatherStatus;
    }

    function getSpouseFatherDob() {
        return $this->spouseFatherDob;
    }

    function getSpouseFatherPhoto() {
        return $this->spouseFatherPhoto;
    }

    function getSpouseFatherDiedOn() {
        return $this->spouseFatherDiedOn;
    }

    function getSpouseMotherNameTitle() {
        return $this->spouseMotherNameTitle;
    }

    function getSpouseMotherName() {
        return $this->spouseMotherName;
    }

    function getSpouseMotherStatus() {
        return $this->spouseMotherStatus;
    }

    function getSpouseMotherDob() {
        return $this->spouseMotherDob;
    }

    function getSpouseMotherPhoto() {
        return $this->spouseMotherPhoto;
    }

    function getSpouseMotherDiedOn() {
        return $this->spouseMotherDiedOn;
    }

    function getNameTitleKids() {
        return $this->nameTitleKids;
    }

    function getKidsName() {
        return $this->kidsName;
    }

    function getKidsStatus() {
        return $this->kidsStatus;
    }

    function getKidsDob() {
        return $this->kidsDob;
    }

    function getKidsPhoto() {
        return $this->kidsPhoto;
    }

    function getNumbor() {
        return $this->numbor;
    }

    function getNameTitleBrother() {
        return $this->nameTitleBrother;
    }

    function getBrotherName() {
        return $this->brotherName;
    }

    function getBrotherStatus() {
        return $this->brotherStatus;
    }

    function getBrotherDob() {
        return $this->brotherDob;
    }

    function getBrotherPhoto() {
        return $this->brotherPhoto;
    }

    function getNameTitleSister() {
        return $this->nameTitleSister;
    }

    function getSisterName() {
        return $this->sisterName;
    }

    function getSisterStatus() {
        return $this->sisterStatus;
    }

    function getSisterDob() {
        return $this->sisterDob;
    }

    function getSisterPhoto() {
        return $this->sisterPhoto;
    }

    function getNameTitleSpouseSister() {
        return $this->nameTitleSpouseSister;
    }

    function getSpouseSisterName() {
        return $this->spouseSisterName;
    }

    function getSpouseSisterStatus() {
        return $this->spouseSisterStatus;
    }

    function getSpouseSisterDob() {
        return $this->spouseSisterDob;
    }

    function getSpouseSisterPhoto() {
        return $this->spouseSisterPhoto;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setFatherId($fatherId) {
        $this->fatherId = $fatherId;
    }

    function setMotherId($motherId) {
        $this->motherId = $motherId;
    }

    function setWifeId($wifeId) {
        $this->wifeId = $wifeId;
    }

    function setHusbandId($husbandId) {
        $this->husbandId = $husbandId;
    }

    function setSpouseId($spouseId) {
        $this->spouseId = $spouseId;
    }

    function setGrandFatherId($grandFatherId) {
        $this->grandFatherId = $grandFatherId;
    }

    function setGrandMotherId($grandMotherId) {
        $this->grandMotherId = $grandMotherId;
    }

    function setGrandGrandFatherId($grandGrandFatherId) {
        $this->grandGrandFatherId = $grandGrandFatherId;
    }

    function setGrandGrandMotherId($grandGrandMotherId) {
        $this->grandGrandMotherId = $grandGrandMotherId;
    }

    function setFamilyValues($familyValues) {
        $this->familyValues = $familyValues;
    }

    function setNameTitleSpouse($nameTitleSpouse) {
        $this->nameTitleSpouse = $nameTitleSpouse;
    }

    function setSpouseName($spouseName) {
        $this->spouseName = $spouseName;
    }

    function setSpouseStatus($spouseStatus) {
        $this->spouseStatus = $spouseStatus;
    }

    function setSpouseDob($spouseDob) {
        $this->spouseDob = $spouseDob;
    }

    function setSpousePhoto($spousePhoto) {
        $this->spousePhoto = $spousePhoto;
    }

    function setSpouseDiedOn($spouseDiedOn) {
        $this->spouseDiedOn = $spouseDiedOn;
    }

    function setNameTitleFather($nameTitleFather) {
        $this->nameTitleFather = $nameTitleFather;
    }

    function setFatherName($fatherName) {
        $this->fatherName = $fatherName;
    }

    function setFatherStatus($fatherStatus) {
        $this->fatherStatus = $fatherStatus;
    }

    function setFatherDob($fatherDob) {
        $this->fatherDob = $fatherDob;
    }

    function setFatherPhoto($fatherPhoto) {
        $this->fatherPhoto = $fatherPhoto;
    }

    function setFatherDod($fatherDod) {
        $this->fatherDod = $fatherDod;
    }

    function setNameTitleMother($nameTitleMother) {
        $this->nameTitleMother = $nameTitleMother;
    }

    function setMotherName($motherName) {
        $this->motherName = $motherName;
    }

    function setMotherStatus($motherStatus) {
        $this->motherStatus = $motherStatus;
    }

    function setMotherDob($motherDob) {
        $this->motherDob = $motherDob;
    }

    function setMotherPhoto($motherPhoto) {
        $this->motherPhoto = $motherPhoto;
    }

    function setMotherDod($motherDod) {
        $this->motherDod = $motherDod;
    }

    function setNameTitleGrandFather($nameTitleGrandFather) {
        $this->nameTitleGrandFather = $nameTitleGrandFather;
    }

    function setGrandFatherName($grandFatherName) {
        $this->grandFatherName = $grandFatherName;
    }

    function setGrandFatherStatus($grandFatherStatus) {
        $this->grandFatherStatus = $grandFatherStatus;
    }

    function setGrandFatherDob($grandFatherDob) {
        $this->grandFatherDob = $grandFatherDob;
    }

    function setGrandFatherPhoto($grandFatherPhoto) {
        $this->grandFatherPhoto = $grandFatherPhoto;
    }

    function setGrandFatherDod($grandFatherDod) {
        $this->grandFatherDod = $grandFatherDod;
    }

    function setNameTitleGrandMother($nameTitleGrandMother) {
        $this->nameTitleGrandMother = $nameTitleGrandMother;
    }

    function setGrandMotherName($grandMotherName) {
        $this->grandMotherName = $grandMotherName;
    }

    function setGrandMotherStatus($grandMotherStatus) {
        $this->grandMotherStatus = $grandMotherStatus;
    }

    function setGrandMotherDob($grandMotherDob) {
        $this->grandMotherDob = $grandMotherDob;
    }

    function setGrandMotherPhoto($grandMotherPhoto) {
        $this->grandMotherPhoto = $grandMotherPhoto;
    }

    function setGrandMotherDod($grandMotherDod) {
        $this->grandMotherDod = $grandMotherDod;
    }

    function setNameTitleGrandGrandFather($nameTitleGrandGrandFather) {
        $this->nameTitleGrandGrandFather = $nameTitleGrandGrandFather;
    }

    function setGrandGrandFatherName($GrandGrandFatherName) {
        $this->GrandGrandFatherName = $GrandGrandFatherName;
    }

    function setGrandGrandFatherStatus($grandGrandFatherStatus) {
        $this->grandGrandFatherStatus = $grandGrandFatherStatus;
    }

    function setGrandGrandFatherDob($grandGrandFatherDob) {
        $this->grandGrandFatherDob = $grandGrandFatherDob;
    }

    function setGrandGrandFatherPhoto($grandGrandFatherPhoto) {
        $this->grandGrandFatherPhoto = $grandGrandFatherPhoto;
    }

    function setGrandGrandFatherDod($grandGrandFatherDod) {
        $this->grandGrandFatherDod = $grandGrandFatherDod;
    }

    function setNameTitleGrandGrandMother($nameTitleGrandGrandMother) {
        $this->nameTitleGrandGrandMother = $nameTitleGrandGrandMother;
    }

    function setGrandGrandMotherName($grandGrandMotherName) {
        $this->grandGrandMotherName = $grandGrandMotherName;
    }

    function setGrandGrandMotherStatus($grandGrandMotherStatus) {
        $this->grandGrandMotherStatus = $grandGrandMotherStatus;
    }

    function setGrandGrandMotherDob($grandGrandMotherDob) {
        $this->grandGrandMotherDob = $grandGrandMotherDob;
    }

    function setGrandGrandMotherPhoto($grandGrandMotherPhoto) {
        $this->grandGrandMotherPhoto = $grandGrandMotherPhoto;
    }

    function setGrandGrandMotherDod($grandGrandMotherDod) {
        $this->grandGrandMotherDod = $grandGrandMotherDod;
    }

    function setSpouseFirstNameTitle($spouseFirstNameTitle) {
        $this->spouseFirstNameTitle = $spouseFirstNameTitle;
    }

    function setSpouseFatherName($spouseFatherName) {
        $this->spouseFatherName = $spouseFatherName;
    }

    function setSpouseFatherStatus($spouseFatherStatus) {
        $this->spouseFatherStatus = $spouseFatherStatus;
    }

    function setSpouseFatherDob($spouseFatherDob) {
        $this->spouseFatherDob = $spouseFatherDob;
    }

    function setSpouseFatherPhoto($spouseFatherPhoto) {
        $this->spouseFatherPhoto = $spouseFatherPhoto;
    }

    function setSpouseFatherDiedOn($spouseFatherDiedOn) {
        $this->spouseFatherDiedOn = $spouseFatherDiedOn;
    }

    function setSpouseMotherNameTitle($spouseMotherNameTitle) {
        $this->spouseMotherNameTitle = $spouseMotherNameTitle;
    }

    function setSpouseMotherName($spouseMotherName) {
        $this->spouseMotherName = $spouseMotherName;
    }

    function setSpouseMotherStatus($spouseMotherStatus) {
        $this->spouseMotherStatus = $spouseMotherStatus;
    }

    function setSpouseMotherDob($spouseMotherDob) {
        $this->spouseMotherDob = $spouseMotherDob;
    }

    function setSpouseMotherPhoto($spouseMotherPhoto) {
        $this->spouseMotherPhoto = $spouseMotherPhoto;
    }

    function setSpouseMotherDiedOn($spouseMotherDiedOn) {
        $this->spouseMotherDiedOn = $spouseMotherDiedOn;
    }

    function setNameTitleKids($nameTitleKids) {
        $this->nameTitleKids = $nameTitleKids;
    }

    function setKidsName($kidsName) {
        $this->kidsName = $kidsName;
    }

    function setKidsStatus($kidsStatus) {
        $this->kidsStatus = $kidsStatus;
    }

    function setKidsDob($kidsDob) {
        $this->kidsDob = $kidsDob;
    }

    function setKidsPhoto($kidsPhoto) {
        $this->kidsPhoto = $kidsPhoto;
    }

    function setNumbor($numbor) {
        $this->numbor = $numbor;
    }

    function setNameTitleBrother($nameTitleBrother) {
        $this->nameTitleBrother = $nameTitleBrother;
    }

    function setBrotherName($brotherName) {
        $this->brotherName = $brotherName;
    }

    function setBrotherStatus($brotherStatus) {
        $this->brotherStatus = $brotherStatus;
    }

    function setBrotherDob($brotherDob) {
        $this->brotherDob = $brotherDob;
    }

    function setBrotherPhoto($brotherPhoto) {
        $this->brotherPhoto = $brotherPhoto;
    }

    function setNameTitleSister($nameTitleSister) {
        $this->nameTitleSister = $nameTitleSister;
    }

    function setSisterName($sisterName) {
        $this->sisterName = $sisterName;
    }

    function setSisterStatus($sisterStatus) {
        $this->sisterStatus = $sisterStatus;
    }

    function setSisterDob($sisterDob) {
        $this->sisterDob = $sisterDob;
    }

    function setSisterPhoto($sisterPhoto) {
        $this->sisterPhoto = $sisterPhoto;
    }

    function setNameTitleSpouseSister($nameTitleSpouseSister) {
        $this->nameTitleSpouseSister = $nameTitleSpouseSister;
    }

    function setSpouseSisterName($spouseSisterName) {
        $this->spouseSisterName = $spouseSisterName;
    }

    function setSpouseSisterStatus($spouseSisterStatus) {
        $this->spouseSisterStatus = $spouseSisterStatus;
    }

    function setSpouseSisterDob($spouseSisterDob) {
        $this->spouseSisterDob = $spouseSisterDob;
    }

    function setSpouseSisterPhoto($spouseSisterPhoto) {
        $this->spouseSisterPhoto = $spouseSisterPhoto;
    }

    function getSpouseLastName() {
        return $this->spouseLastName;
    }

    function getFatherLastName() {
        return $this->fatherLastName;
    }

    function getMotherLastName() {
        return $this->motherLastName;
    }

    function getGrandFatherLastName() {
        return $this->grandFatherLastName;
    }

    function getGrandMotherLastName() {
        return $this->grandMotherLastName;
    }

    function getGrandGrandFatherLastName() {
        return $this->grandGrandFatherLastName;
    }

    function getGrandGrandMotherLastName() {
        return $this->grandGrandMotherLastName;
    }

    function getSpouseFatherLastName() {
        return $this->spouseFatherLastName;
    }

    function getSpouseMotherLastName() {
        return $this->spouseMotherLastName;
    }

    function getKidsLastName() {
        return $this->kidsLastName;
    }

    function getBrotherLastName() {
        return $this->brotherLastName;
    }

    function getSisterLastName() {
        return $this->sisterLastName;
    }

    function getSpouseSisterLastName() {
        return $this->spouseSisterLastName;
    }

    function setSpouseLastName($spouseLastName) {
        $this->spouseLastName = $spouseLastName;
    }

    function setFatherLastName($fatherLastName) {
        $this->fatherLastName = $fatherLastName;
    }

    function setMotherLastName($motherLastName) {
        $this->motherLastName = $motherLastName;
    }

    function setGrandFatherLastName($grandFatherLastName) {
        $this->grandFatherLastName = $grandFatherLastName;
    }

    function setGrandMotherLastName($grandMotherLastName) {
        $this->grandMotherLastName = $grandMotherLastName;
    }

    function setGrandGrandFatherLastName($grandGrandFatherLastName) {
        $this->grandGrandFatherLastName = $grandGrandFatherLastName;
    }

    function setGrandGrandMotherLastName($grandGrandMotherLastName) {
        $this->grandGrandMotherLastName = $grandGrandMotherLastName;
    }

    function setSpouseFatherLastName($spouseFatherLastName) {
        $this->spouseFatherLastName = $spouseFatherLastName;
    }

    function setSpouseMotherLastName($spouseMotherLastName) {
        $this->spouseMotherLastName = $spouseMotherLastName;
    }

    function setKidsLastName($kidsLastName) {
        $this->kidsLastName = $kidsLastName;
    }

    function setBrotherLastName($brotherLastName) {
        $this->brotherLastName = $brotherLastName;
    }

    function setSisterLastName($sisterLastName) {
        $this->sisterLastName = $sisterLastName;
    }

    function setSpouseSisterLastName($spouseSisterLastName) {
        $this->spouseSisterLastName = $spouseSisterLastName;
    }




}
