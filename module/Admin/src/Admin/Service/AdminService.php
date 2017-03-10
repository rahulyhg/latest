<?php

namespace Admin\Service;

use Admin\Mapper\AdminMapperInterface;
use Admin\Service\AdminServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;

class AdminService implements AdminServiceInterface {

    protected $adminMapper;
    protected $dbAdapter;
    protected $resultSet;

    public function __construct(AdminMapperInterface $adminMapper, AdapterInterface $dbAdapter) {
        $this->adminMapper = $adminMapper;
        $this->dbAdapter = $dbAdapter;
        $this->resultSet = new ResultSet();
    }
    
    //education field
    
    public function getAmmir() {
        return $this->adminMapper->getAmmir();
    }
    
    public function getAmmirById($id) {
        return $this->adminMapper->getAmmirById($id);
    }
    
    public function saveEducationField($educationfieldEntity) {
        return $this->adminMapper->saveEducationField($educationfieldEntity);
    }
    
     public function getEducationFieldList() {
        return $this->adminMapper->getEducationFieldList();
    }
    
    public function getEducationField($id) {
        return $this->adminMapper->getEducationField($id);
    }     
    
     public function getEducationFieldRadioList($status) {
        return $this->adminMapper->getEducationFieldRadioList($status);
    }
    
    public function changeStatus($table, $ids,  $data, $modified_by){
        return $this->adminMapper->changeStatus($table, $ids,  $data, $modified_by);
    }
    
    public function changeStatusAll($table, $ids, $data){
        return $this->adminMapper->changeStatusAll($table, $ids,  $data);
    }
    
    public function delete($table, $id){
        return $this->adminMapper->delete($table, $id);
    }
    
    public function deleteMultiple($table, $ids){
        return $this->adminMapper->deleteMultiple($table, $ids);
    }
    
    public function viewById($table, $id){
        return $this->adminMapper->viewById($table, $id);
    }
    
    
    public function performSearchEducationField($field){
        return $this->adminMapper->performSearchEducationField($field);
    }
    
    
    
    public function educationFieldSearch($data){
        return $this->adminMapper->educationFieldSearch($data);
    }
    
    //country    
    
    public function getCountriesList() {
        return $this->adminMapper->getCountriesList();
    }
    
    public function getCountryRadioList($status) {
        return $this->adminMapper->getCountryRadioList($status);
    }
    
    public function viewByCountryId($table, $id){
        return $this->adminMapper->viewByCountryId($table, $id);
    }
   
    public function saveCountry($countryEntity) {
        return $this->adminMapper->saveCountry($countryEntity);
    }
    
    public function getCountry($id) {
        return $this->adminMapper->getCountry($id);
    }
    
    public function performSearchCountry($field,$field2,$field3) {
        return $this->adminMapper->performSearchCountry($field,$field2,$field3);
    }
    
    public function countrySearch($data) {
        return $this->adminMapper->countrySearch($data);
    }
    
    public function getAllRegion() {
        return $this->adminMapper->getAllRegion();
    }
    
    //state
    
    public function getStatesList() {
        return $this->adminMapper->getStatesList();
    }
    
    public function customFields() {
        return $this->adminMapper->customFields();
    }
    
    
    public function performSearchState($field,$field2) {
        return $this->adminMapper->performSearchState($field,$field2);
    }
    
    public function saveState($stateObject) {
        return $this->adminMapper->saveState($stateObject);
    }
    
    public function getState($id) {
        return $this->adminMapper->getState($id);
    }
    
    public function getStateRadioList($status) {
        return $this->adminMapper->getStateRadioList($status);
    }
    
    public function viewByStateId($table, $id) {
        return $this->adminMapper->viewByStateId($table, $id);
    }
    
    public function stateSearch($data,$field) {
        return $this->adminMapper->stateSearch($data,$field);
    }
    
    
    //city
    public function getCitiesList() {
        return $this->adminMapper->getCitiesList();
    }
    
    public function getStateListByCountryCode($Country_ID) {
        return $this->adminMapper->getStateListByCountryCode($Country_ID);
    }
    
    public function getCityListByStateCode($State_ID) {
        return $this->adminMapper->getCityListByStateCode($State_ID);
    }
    
    public function getCityListByCountry($country_id) {
        return $this->adminMapper->getCityListByCountry($country_id);
    }
    
    public function getCityListByState($state_id) {
        return $this->adminMapper->getCityListByState($state_id);
    }
    
    public function getCityListByCity($city_id) {
        return $this->adminMapper->getCityListByCity($city_id);
    }
    
    public function customFieldsState() {
        return $this->adminMapper->customFieldsState();
    }
    
    public function SaveCity($cityObject) {
        return $this->adminMapper->SaveCity($cityObject);
    }
    
    public function getCity($id) {
        return $this->adminMapper->getCity($id);
    }
    
    public function getCityRadioList($status) {
        return $this->adminMapper->getCityRadioList($status);
    }
    
    public function viewByCityId($table, $id) {
        return $this->adminMapper->viewByCityId($table, $id);
    }
    
    
    
    
    //Religion
    
    
    public function getReligionList() {
        return $this->adminMapper->getReligionList();
    }
    
    public function SaveReligion($religionObject) {
        return $this->adminMapper->SaveReligion($religionObject);
    }
    
    public function getReligion($id) {
        return $this->adminMapper->getReligion($id);
    }
    
    public function religionSearch($data) {
        return $this->adminMapper->religionSearch($data);
    }
    
    public function performSearchReligion($field) {
        return $this->adminMapper->performSearchReligion($field);
    }
    
    public function getReligionRadioList($status) {
        return $this->adminMapper->getReligionRadioList($status);
    }
    
    public function viewByReligionId($table, $id) {
        return $this->adminMapper->viewByReligionId($table, $id);
    }
    
    //Gothras
    
    public function getGothrasList() {
        return $this->adminMapper->getGothrasList();
    }
    
    public function SaveGothra($gothraObject) {
        return $this->adminMapper->SaveGothra($gothraObject);
    }
    
    public function getGothra($id) {
        return $this->adminMapper->getGothra($id);
    }
    
    public function gothraSearch($data,$field) {
        return $this->adminMapper->gothraSearch($data,$field);
    }
    
    public function performSearchGothra($field,$field2) {
        return $this->adminMapper->performSearchGothra($field,$field2);
    }
    
    public function getGothraRadioList($status) {
        return $this->adminMapper->getGothraRadioList($status);
    }
    
    public function viewByGothraId($table, $id) {
        return $this->adminMapper->viewByGothraId($table, $id);
    }
    
    public function getAllCastlist() {
        return $this->adminMapper->getAllCastlist();
    }
    
    //Starsign
    
    
    public function getStarsignList() {
        return $this->adminMapper->getStarsignList();
    }
    
    public function SaveStarsign($starsignObject) {
        return $this->adminMapper->SaveStarsign($starsignObject);
    }
    
    public function getStarsign($id) {
        return $this->adminMapper->getStarsign($id);
    }
    
    public function starsignSearch($data) {
        return $this->adminMapper->starsignSearch($data);
    }
    
    public function performSearchStarsign($field) {
        return $this->adminMapper->performSearchStarsign($field);
    }
    
    public function getStarsignRadioList($status) {
        return $this->adminMapper->getStarsignRadioList($status);
    }
    
    public function viewByStarsignId($table, $id) {
        return $this->adminMapper->viewByStarsignId($table, $id);
    }
    
    //Zodiacsign
    
    public function getZodiacsignList() {
        return $this->adminMapper->getZodiacsignList();
    }
    
    public function SaveZodiacsign($zodiacsignObject) {
        return $this->adminMapper->SaveZodiacsign($zodiacsignObject);
    }
    
    public function getZodiacsign($id) {
        return $this->adminMapper->getZodiacsign($id);
    }
    
    public function zodiacsignSearch($data) {
        return $this->adminMapper->zodiacsignSearch($data);
    }
    
    public function performSearchZodiacsign($field) {
        return $this->adminMapper->performSearchZodiacsign($field);
    }
    
    public function getZodiacsignRadioList($status) {
        return $this->adminMapper->getZodiacsignRadioList($status);
    }
    
    public function viewByZodiacsignId($table, $id) {
        return $this->adminMapper->viewByZodiacsignId($table, $id);
    }
    
    //Profession
    
    public function getProfessionList() {
        return $this->adminMapper->getProfessionList();
    }
    
    public function SaveProfession($id) {
        return $this->adminMapper->SaveProfession($id);
    }
    
    public function getProfession($id) {
        return $this->adminMapper->getProfession($id);
    }
    
    public function professionSearch($data) {
        return $this->adminMapper->professionSearch($data);
    }
    
    public function performSearchProfession($field) {
        return $this->adminMapper->performSearchProfession($field);
    }
    
    public function getProfessionRadioList($status) {
        return $this->adminMapper->getProfessionRadioList($status);
    }
    
    public function viewByProfessionId($table, $id) {
        return $this->adminMapper->viewByProfessionId($table, $id);
    }
    
    //Designation
    
    public function getDesignationList() {
        return $this->adminMapper->getDesignationList();
    }
    
    public function SaveDesignation($designationObject) {
        return $this->adminMapper->SaveDesignation($designationObject);
    }
    
    public function getDesignation($id) {
        return $this->adminMapper->getDesignation($id);
    }
    
    public function designationSearch($data) {
        return $this->adminMapper->designationSearch($data);
    }
    
    public function performSearchDesignation($field) {
        return $this->adminMapper->performSearchDesignation($field);
    }
    
    public function getDesignationRadioList($status) {
        return $this->adminMapper->getDesignationRadioList($status);
    }
    
    public function viewByDesignationId($table, $id) {
        return $this->adminMapper->viewByDesignationId($table, $id);
    }
    
    //Education level
    
    public function getEducationlevelList() {
        return $this->adminMapper->getEducationlevelList();
    }
    
    public function SaveEducationlevel($educationlevelObject) {
        return $this->adminMapper->SaveEducationlevel($educationlevelObject);
    }
    
    public function getEducationlevel($id) {
        return $this->adminMapper->getEducationlevel($id);
    }
    
    public function getEducationlevelRadioList($status) {
        return $this->adminMapper->getEducationlevelRadioList($status);
    }
    
    public function viewByEducationlevelId($table, $id) {
        return $this->adminMapper->viewByEducationlevelId($table, $id);
    }
    
    public function educationLevelSearch($data) {
        return $this->adminMapper->educationLevelSearch($data);
    }
    
    public function performSearchEducationlevel($field) {
        return $this->adminMapper->performSearchEducationlevel($field);
    }
    
    //member...
    
    
    
    public function getUserPersonalDetailByUserId($id) {
        return $this->adminMapper->getUserPersonalDetailByUserId($id);
    }
    
    public function getUserPersonalDetailById($id) {
        return $this->adminMapper->getUserPersonalDetailById($id);
    }
    
    public function SavePersonalProfile($personalDetailsObject) {
        return $this->adminMapper->SavePersonalProfile($personalDetailsObject);
    }
    
    public function getUserEducationAndCareerDetailById($id) {
        return $this->adminMapper->getUserEducationAndCareerDetailById($id);
    }
    
    public function SaveEducationAndCareer($educationAndCareerObject) {
        return $this->adminMapper->SaveEducationAndCareer($educationAndCareerObject);
    }
    
    public function getUserLocationDetailById($id) {
        return $this->adminMapper->getUserLocationDetailById($id);
    }
    
    public function SaveLocation($locationObject) {
        return $this->adminMapper->SaveLocation($locationObject);
    }
    
    public function SavePostDetail($postObject) {
        return $this->adminMapper->SavePostDetail($postObject);
    }
    
    //Get country state and city list
    
    public function getCountryList() {
        return $this->adminMapper->getCountryList();
    }
    
    public function getStateList() {
        return $this->adminMapper->getStateList();
    }
    
    public function getCityList() {
        return $this->adminMapper->getCityList();
    }
    
    //Get member dashboad...
    
    public function getMemberdashboardById($id) {
        return $this->adminMapper->getMemberdashboardById($id);
    }
    
    public function SaveMemberdashboard($memberdashboardObject) {
        return $this->adminMapper->SaveMemberdashboard($memberdashboardObject);
    }
    
    //Get matrimonial dashboad...
    
    public function getMatrimonialdashboardById($id) {
        return $this->adminMapper->getMatrimonialdashboardById($id);
    }
    
    public function SaveMatrimonialdashboard($matrimonialdashboardObject) {
        return $this->adminMapper->SaveMatrimonialdashboard($matrimonialdashboardObject);
    }
    
//    public function getUserPersonalDetailByIdMatrimonial($user_id) {
//        return $this->adminMapper->getUserPersonalDetailByIdMatrimonial($user_id);
//    }
    
    
    public function getUserPersonalDetailByIdMatrimonial($user_id) {
        //echo  $user_id; exit;
        $statement = $this->dbAdapter->query("SELECT 
                 tui.*, 
                 tu.email, 
                 tu.mobile_no, 
                 tup.* ,
                 tuam.*,
                 tugm.* 
             FROM tbl_user_info_matrimonial as tui
               LEFT JOIN tbl_user_matrimonial as tu ON tui.user_id=tu.id
               LEFT JOIN tbl_user_professional_matrimonial as tup ON tui.user_id=tup.user_id
               LEFT JOIN tbl_user_gallery_matrimonial as tugm ON tugm.user_id=tui.user_id
               LEFT JOIN tbl_user_address_matrimonial as tuam ON tuam.user_id=tui.user_id
               WHERE tui.user_id=:user_id");
        $parameters = array(
            'user_id' => $user_id
        );
        $result = $statement->execute($parameters);

        return $result->current();

        //return $this->hydrator->hydrate($result->current(), new UserInfo());
    }
    
    public function saveUserPersonalDetailsMatrimonial($formData) {

        //Debug::dump($formData);exit;

        $sql = new Sql($this->dbAdapter);

        $userData['name_title_user'] = $formData['name_title_user'];
        $userData['full_name'] = $formData['full_name'];
        $userData['last_name'] = $formData['last_name'];
        $userData['gender'] = $formData['gender'];
        $userData['dob'] = Date('Y-m-d', strtotime($formData['dob']));
        $userData['birth_time'] = $formData['birth_time'];
        $userData['birth_place'] = $formData['birth_place'];

        $userData['marital_status'] = $formData['marital_status'];
        $userData['children'] = $formData['children'];
        $userData['no_of_kids'] = $formData['no_of_kids'];

        $userData['native_place'] = $formData['native_place'];
        // $userData['dob'] = $formData['star_sign'];
        $userData['blood_group'] = $formData['blood_group'];
        //$userData['dob'] = $formData['skin_tone'];
        //$userData['dob'] = $formData['star_sign'];
        $userData['zodiac_sign_raasi'] = $formData['zodiac_sign_raasi'];
        //$userData['dob'] = $formData['sevvai_dosham'];
        $userData['religion'] = $formData['religion'];
        $userData['community'] = $formData['community'];
        $userData['religion_other'] = $formData['religion_other'];
        $userData['gothra_gothram'] = $formData['gothra_gothram'];
        $userData['gothra_gothram_other'] = $formData['gothra_gothram_other'];
        $userData['smoke'] = $formData['smoke'];
        $userData['manglik_dossam'] = $formData['manglik_dossam'];
        $userData['height'] = $formData['height'];
        $userData['color_complexion'] = $formData['color_complexion'];
        $userData['any_disability'] = $formData['any_disability'];
        $userData['body_type'] = $formData['body_type'];
        $userData['body_weight'] = $formData['body_weight'];
        $userData['body_weight_type'] = $formData['body_weight_type'];
        $userData['alternate_mobile_no'] = $formData['alternate_mobile_no'];
        $userData['phone_no'] = $formData['phone_no'];
        $userData['religion'] = $formData['religion'];
        $userData['religion_other'] = $formData['religion_other'];
        $userData['gothra_gothram'] = $formData['gothra_gothram'];
        $userData['gothra_gothram_other'] = $formData['gothra_gothram_other'];
        $userData['caste'] = $formData['caste'];
        //$userData['caste_other'] = $formData['caste_other'];
        $userData['sub_caste'] = $formData['sub_caste'];
        $userData['mother_tongue_id'] = $formData['mother_tongue_id'];
        $userData['manglik_dossam'] = $formData['manglik_dossam'];
        $userData['star_sign'] = $formData['star_sign'];
        $userData['drink'] = $formData['drink'];
        $userData['smoke'] = $formData['smoke'];
        $userData['meal_preference'] = $formData['meal_preference'];
        //$MemberbasicForm->get('religion')->setValue($info['religion']);
        //$userData['body_weight_type'] = $formData['body_weight_type'];
        //$userData['created_date'] = date("Y-m-d H:i:s");
        $userData['user_id'] = $formData['user_id'];
        //Debug::dump($userData);exit;
        $action = new Update('tbl_user_info_matrimonial');
        $action->set($userData);
        $action->where(array('user_id = ?' => $userData['user_id']));
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        //Debug::dump($result);exit;

        unset($userData);

        $userData['address'] = $formData['address'];
        $userData['country'] = $formData['country'];
        $userData['state'] = $formData['state'];
        $userData['city'] = $formData['city'];
        $userData['pincode'] = $formData['zip_pin_code'];
        //$userData['created_date'] = date("Y-m-d H:i:s");
        $userData['user_id'] = $formData['user_id'];


        $action = new Update('tbl_user_address_matrimonial');
        $action->set($userData);
        $action->where(array('user_id = ?' => $userData['user_id']));
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if ($result)
                return "success";
            else
                return "couldn't update";
    }
    
    public function userSummaryByIdMatrimonial($user_id) {
//        echo  "hello";exit;
        $statement = $this->dbAdapter->query("SELECT tui.*, 
             tu.email, 
             tu.mobile_no, 
             tp.profession as profession_name, 
             tuam.*,
             tuem.*,
             tel.*,
             tup.*,
             td.*,
             tai.*,
             tr.*,
             tef.*,
             tugm.*
             FROM tbl_user_info_matrimonial as tui
               LEFT JOIN tbl_user_matrimonial as tu ON tui.user_id=tu.id
               LEFT JOIN tbl_user_professional_matrimonial as tup ON tui.user_id=tup.user_id
               LEFT JOIN tbl_profession as tp ON tup.profession=tp.id
               LEFT JOIN tbl_designation as td ON td.id=tup.designation
               LEFT JOIN tbl_annual_income as tai ON tai.id=tup.annual_income
               LEFT JOIN tbl_religion as tr ON tr.id=tui.religion
               LEFT JOIN tbl_user_education_matrimonial as tuem ON tuem.user_id=tui.user_id
               LEFT JOIN tbl_education_level as tel ON tel.id=tuem.education_level_id
               LEFT JOIN tbl_education_field as tef ON tef.id=tuem.education_field_id
               LEFT JOIN tbl_user_gallery_matrimonial as tugm ON tugm.user_id=tui.user_id AND tugm.user_type='U' AND 
               tugm.image_type=1
               LEFT JOIN tbl_user_address_matrimonial as tuam ON tuam.user_id=tui.user_id
               WHERE tui.user_id=:user_id ORDER BY tugm.id DESC");
        $parameters = array(
            'user_id' => $user_id
        );
        $result = $statement->execute($parameters);
        //Debug::dump($result->current());
        return $result->current();
    }
    
    public function getEducationAndCareerByIdMatrimonial($user_id) {
        $statement = $this->dbAdapter->query("SELECT 
             tupm.* , 
             tuem.*, 
             tuem.id as education_id, 
             tupm.id as profession_id
             FROM tbl_user_professional_matrimonial as tupm 
             LEFT JOIN tbl_user_education_matrimonial as tuem ON tuem.user_id=:user_id WHERE tupm.user_id=:user_id");
        $parameters = array(
            'user_id' => $user_id
        );
        $result = $statement->execute($parameters);
        //Debug::dump($result);
        return $result->current();

        //return $this->hydrator->hydrate($result->current(), new UserInfo());
    }
    
    public function saveEducationAndCareerDetailMatrimonial($formData) {
        $sql = new Sql($this->dbAdapter);

        if (isset($formData['education_id']) && !empty($formData['education_id'])) {
            $userData['education_level_id'] = $formData['education_level'];
            $userData['education_field_id'] = $formData['education_field'];
            $userData['user_id'] = $formData['user_id'];

            $action = new Update('tbl_user_education_matrimonial');
            $action->set($userData);
            $action->where(array('user_id = ?' => $userData['user_id']));
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            unset($userData);
        } else {
            $userData['education_level_id'] = $formData['education_level'];
            $userData['education_field_id'] = $formData['education_field'];
            $userData['user_id'] = $formData['user_id'];
            $action = new Insert('tbl_user_education_matrimonial');
            $action->values($userData);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            unset($userData);
        }



        if (isset($formData['profession_id']) && !empty($formData['profession_id'])) {
            $userData['employer'] = $formData['employer'];
            $userData['designation'] = $formData['designation'];
            $userData['specialize_profession'] = $formData['specialize_profession'];
            $userData['annual_income'] = $formData['annual_income'];
            $userData['profession'] = $formData['profession'];
            $userData['office_name'] = $formData['office_name'];
            $userData['office_email'] = $formData['office_email'];
            $userData['office_website'] = $formData['office_website'];
            $userData['office_phone'] = $formData['office_phone'];
            $userData['office_address'] = $formData['office_address'];
            $userData['office_country'] = $formData['office_country'];
            $userData['office_state'] = $formData['office_state'];
            $userData['office_city'] = $formData['office_city'];
            $userData['office_pincode'] = $formData['office_pincode'];
            $userData['annual_income_status'] = $formData['annual_income_status'];
            $userData['user_id'] = $formData['user_id'];

            $action = new Update('tbl_user_professional_matrimonial');
            $action->set($userData);
            $action->where(array('user_id = ?' => $userData['user_id']));
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            unset($userData);
        } else {
            $userData['employer'] = $formData['employer'];
            $userData['designation'] = $formData['designation'];
            $userData['specialize_profession'] = $formData['specialize_profession'];
            $userData['annual_income'] = $formData['annual_income'];
            $userData['profession'] = $formData['profession'];
            $userData['office_name'] = $formData['office_name'];
            $userData['office_email'] = $formData['office_email'];
            $userData['office_website'] = $formData['office_website'];
            $userData['office_phone'] = $formData['office_phone'];
            $userData['office_address'] = $formData['office_address'];
            $userData['office_country'] = $formData['office_country'];
            $userData['office_state'] = $formData['office_state'];
            $userData['office_city'] = $formData['office_city'];
            $userData['office_pincode'] = $formData['office_pincode'];
            $userData['annual_income_status'] = $formData['annual_income_status'];
            $userData['user_id'] = $formData['user_id'];

            $action = new Insert('tbl_user_education_matrimonial');
            $action->values($userData);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            unset($userData);
        }
        
        if ($result)
                return "success";
            else
                return "couldn't update";
    }
    
}
