<?php

namespace Admin\Service;

interface AdminServiceInterface {
    
    //education field
    
    public function getAmmir();

    public function getAmmirById($id);
    
    public function saveEducationField($educationfieldEntity);
    
    public function getEducationFieldList();
    
    public function getEducationField($id);
    
    public function getEducationFieldRadioList($status);

    public function changeStatus($table, $ids,  $data, $modified_by);

    public function changeStatusAll($table, $ids, $data);

    public function delete($table, $id);

    public function deleteMultiple($table, $ids);
    
    public function viewById($table, $id);
    
    public function performSearchEducationField($field);
    
    public function educationFieldSearch($data);
    
    //country    
    
    public function getCountriesList();
    
    public function getCountryRadioList($status);
    
    public function viewByCountryId($table, $id);
    
    public function saveCountry($countryEntity);
    
    public function getCountry($id);
    
    public function performSearchCountry($field,$field2,$field3);
    
    public function countrySearch($data);
    
    public function getAllRegion();
    
    //state
    
    
    public function getStatesList();
    
    public function customFields();
    
    public function performSearchState($field,$field2);
    
    public function saveState($stateObject);
    
    public function getState($id);
    
    public function getStateRadioList($status);
    
    public function viewByStateId($table, $id);
    
    public function stateSearch($data,$field);
    
    
    //city
    
    public function getCitiesList();
    
    public function getStateListByCountryCode($Country_ID);
    
    public function getCityListByStateCode($State_ID);
    
    public function getCityListByCountry($country_id);
    
    public function getCityListByState($state_id);
    
    public function getCityListByCity($city_id);
    
    public function customFieldsState();
    
    public function SaveCity($cityObject);
    
    public function getCity($id);
    
    public function getCityRadioList($status);
    
    public function viewByCityId($table, $id);
    
    
    
    
    //Religion
    
    public function getReligionList();
    
    public function SaveReligion($religionObject);
    
    public function getReligion($id);
    
    public function religionSearch($data);
    
    public function performSearchReligion($field);
    
    public function getReligionRadioList($status);
    
    public function viewByReligionId($table, $id);
    
    //Gothras
    
    public function getGothrasList();
    
    public function SaveGothra($gothraObject);
    
    public function getGothra($id);
    
    public function gothraSearch($data,$field);
    
    public function performSearchGothra($field,$field2);
    
    public function getGothraRadioList($status);
    
    public function viewByGothraId($table, $id);
    
    public function getAllCastlist();
    
    //Starsign
    
    
    public function getStarsignList();
    
    public function SaveStarsign($starsignObject);
    
    public function getStarsign($id);
    
    public function starsignSearch($data);
    
    public function performSearchStarsign($field);
    
    public function getStarsignRadioList($status);
    
    public function viewByStarsignId($table, $id);
    
    //Zodiacsign
    
    public function getZodiacsignList();
    
    public function SaveZodiacsign($zodiacsignObject);
    
    public function getZodiacsign($id);
    
    public function zodiacsignSearch($data);
    
    public function performSearchZodiacsign($field);
    
    public function getZodiacsignRadioList($status);
    
    public function viewByZodiacsignId($table, $id);
    
    //Profession
    
    public function getProfessionList();
    
    public function SaveProfession($professionObject);
    
    public function getProfession($id);
    
    public function professionSearch($data);
    
    public function performSearchProfession($field);
    
    public function getProfessionRadioList($status);
    
    public function viewByProfessionId($table, $id);
    
    //Designation
    
    public function getDesignationList();
    
    public function SaveDesignation($designationObject);
    
    public function getDesignation($id);
    
    public function designationSearch($data);
    
    public function performSearchDesignation($field);
    
    public function getDesignationRadioList($status);
    
    public function viewByDesignationId($table, $id);
    
    //Education level
    
   public function getEducationlevelList();
    
   public function SaveEducationlevel($educationlevelObject);
   
   public function getEducationlevel($id);
   
   public function getEducationlevelRadioList($status);
   
   public function viewByEducationlevelId($table, $id);
   
   public function educationLevelSearch($data);
   
   public function performSearchEducationlevel($field);
   
   //member...
   
   public function getUserPersonalDetailByUserId($id);
   
   public function getUserPersonalDetailById($id);
   
   public function SavePersonalProfile($personalDetailsObject);
   
   public function getUserEducationAndCareerDetailById($id);
   
   public function SaveEducationAndCareer($educationAndCareerObject);
   
   public function getUserLocationDetailById($id);
   
   public function SaveLocation($locationObject);
   
   public function SavePostDetail($postObject);
   
   //Get country state and city list...
   
   public function getCountryList();
   
   public function getStateList();
   
   public function getCityList();
   
   //Get member dashboard...
   
   public function getMemberdashboardById($id);
   
   public function SaveMemberdashboard($memberdashboardObject);
   
   //Get matrimonial dashboad...
   
   public function getMatrimonialdashboardById($id);
   
   public function SaveMatrimonialdashboard($matrimonialdashboardObject);
   
   //public function getUserPersonalDetailByIdMatrimonial($user_id);
    
    
    
}
