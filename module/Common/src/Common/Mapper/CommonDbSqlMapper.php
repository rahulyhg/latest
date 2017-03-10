<?php

namespace Common\Mapper;

use Common\Model\Entity\User;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\Hydrator\ClassMethods;
use WebServices\TableName;
use PDO;

class CommonDbSqlMapper implements CommonMapperInterface {

    protected $dbAdapter;
    protected $resultSet;
    protected $hydrator;

    public function __construct(AdapterInterface $dbAdapter) {


        $this->dbAdapter = $dbAdapter;
        $this->resultSet = new ResultSet();
        $this->hydrator = new ClassMethods();
    }

    public function getCountryById($id) {
        
    }

    public function getCountryList($columns = array('id', 'country_name')) {
        $table = new TableGateway('tbl_country', $this->dbAdapter);
        $rowset = $table->select(function (Select $select) use ($columns) {
                    $select->where(array('is_active' => 1));
                    $select->order('id ASC');
                    $select->columns($columns);
                })->toArray();
        foreach ($rowset as $c) {
            $list[$c[$columns[0]]] = $c[$columns[1]];
        }
        return $list;
    }

    public function getStateById() {
        
    }

    public function getStateListByCountryCode($country_id) {
        $table = new TableGateway('tbl_state', $this->dbAdapter);
        $rowset = $table->select(array('country_id' => $country_id,'is_active'=>1))->toArray();
        if (count($rowset)) {
            return $rowset;
        } else {
            return null;
        }
    }

    public function getStateList($columns = array('id', 'state_name')) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_state');
        $select->columns($columns);
        $select->where(array('is_active' => 1));
        $select->order('id ASC');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //return $this->hydrator->hydrate($result->current(), new User());
            $rowset = $this->resultSet->initialize($result);
            foreach ($rowset->toArray() as $c) {
                $list[$c[$columns[0]]] = $c[$columns[1]];
            }
            return $list;
            //return $result->current();
        }
    }

    public function getCityList($columns = array('id', 'city_name')) {
        $table = new TableGateway('tbl_city', $this->dbAdapter);
        $rowset = $table->select(function (Select $select) use ($columns) {
                    $select->order('id ASC');
                    $select->columns($columns);
                })->toArray();
        foreach ($rowset as $c) {
            $list[$c[$columns[0]]] = $c[$columns[1]];
        }
        return $list;
    }

    public function getCityById() {
        
    }

    public function getCityListByStateCode($stateId) {
        $table = new TableGateway('tbl_city', $this->dbAdapter);
        $rowset = $table->select(array('state_id' => $stateId,'is_active'=> 1))->toArray();
        if (count($rowset)) {
            return $rowset;
        } else {
            return null;
        }
    }
    
    public function getCommunityListByRelgionId($religionId) {
        $table = new TableGateway('community', $this->dbAdapter);
        $rowset = $table->select(array('religion_id' => $religionId,'is_active'=> 1))->toArray();
        if (count($rowset)) {
            return $rowset;
        } else {
            return null;
        }
    }
    
    public function getCasteListByCommunityId($communityId) {
        $table = new TableGateway('tbl_caste', $this->dbAdapter);
        $rowset = $table->select(array('community_id' => $communityId,'is_active'=> 1))->toArray();
        if (count($rowset)) {
            return $rowset;
        } else {
            return null;
        }
    }

    public function getBrachListByCity($cityId) {
        $table = new TableGateway('tbl_rustagi_branches', $this->dbAdapter);
        $rowset = $table->select(array('branch_city_id' => $cityId,'is_active'=>1))->toArray();
        if (count($rowset)) {
            return $rowset;
        } else {
            return null;
        }
    }
    
    
    public function getGothraListByCaste($casteId) {
        $table = new TableGateway('tbl_gothra_gothram', $this->dbAdapter);
        $rowset = $table->select(array('caste_id' => $casteId,'is_active'=>1))->toArray();
        if (count($rowset)) {
            return $rowset;
        } else {
            //return null;
            $casteId=0;
            $rowset = $table->select(array('caste_id' => $casteId,'is_active'=>1))->toArray();
            return $rowset;
        }
    }

    public function getAnnualIncomeList($columns = array('id', 'annual_income')) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_annual_income');
        $select->columns($columns);
        $select->where(array('is_active' => 1));
        $select->order('id ASC');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //return $this->hydrator->hydrate($result->current(), new User());
            $rowset = $this->resultSet->initialize($result);
            foreach ($rowset->toArray() as $c) {
                $list[$c[$columns[0]]] = $c[$columns[1]];
            }
            return $list;
            //return $result->current();
        }
    }
    
    public function getZodiacSignRaasiList($columns = array('id', 'zodiac_sign_name')) {

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_zodiac_sign_raasi');
        $select->columns($columns);
        $select->where(array('is_active' => 1));
        $select->order('id ASC');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //return $this->hydrator->hydrate($result->current(), new User());
            $rowset = $this->resultSet->initialize($result);
            foreach ($rowset->toArray() as $c) {
                $list[$c[$columns[0]]] = $c[$columns[1]];
            }
            return $list;
            //return $result->current();
        }
    }

    public function getDesignationList($columns = array('id', 'designation')) {

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_designation');
        $select->columns($columns);
        $select->where(array('is_active' => 1));
        $select->order('order_val ASC');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //return $this->hydrator->hydrate($result->current(), new User());
            $rowset = $this->resultSet->initialize($result);
            foreach ($rowset->toArray() as $c) {
                $list[$c[$columns[0]]] = $c[$columns[1]];
            }
            return $list;
            //return $result->current();
        }
    }

    public function getEducationFieldList($columns = array('id', 'education_field')) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_education_field');
        $select->columns($columns);
        $select->where(array('is_active' => 1));
        $select->order('order_val ASC');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //return $this->hydrator->hydrate($result->current(), new User());
            $rowset = $this->resultSet->initialize($result);
            foreach ($rowset->toArray() as $c) {
                $list[$c[$columns[0]]] = $c[$columns[1]];
            }
            return $list;
            //return $result->current();
        }
    }

    public function getEducationLevelList($columns = array('id', 'education_level')) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_education_level');
        $select->columns($columns);
        $select->where(array('is_active' => 1));
        $select->order('order_val ASC');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //return $this->hydrator->hydrate($result->current(), new User());
            $rowset = $this->resultSet->initialize($result);
            foreach ($rowset->toArray() as $c) {
                $list[$c[$columns[0]]] = $c[$columns[1]];
            }
            return $list;
            //return $result->current();
        }
    }

    public function getGotraList($columns = array('id', 'gothra_name')) {
        $table = new TableGateway('tbl_gothra_gothram', $this->dbAdapter);
        $rowset = $table->select(function (Select $select) use ($columns) {
            $select->where(array('is_active' => 1));
            $select->order('id ASC');
            $select->columns($columns);
        });

        foreach ($rowset->toArray() as $c) {
            $list[$c[$columns[0]]] = $c[$columns[1]];
        }
        return $list;
    }

    public function getHeightList($columns = array('id', 'height')) {

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_height');
        $select->columns($columns);
        $select->where(array('is_active' => 1));
        $select->order('id ASC');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();



        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //return $this->hydrator->hydrate($result->current(), new User());
            $rowset = $this->resultSet->initialize($result);
            //return $rowset->toArray();
            foreach ($rowset->toArray() as $c) {
                $list[$c[$columns[0]]] = $c[$columns[1]];
            }
            return $list;
            //return $result->current();
        }
    }

    public function getProfessionList($columns = array('id', 'profession')) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_profession');
        $select->columns($columns);
        $select->where(array('is_active' => 1));
        $select->order('id ASC');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //return $this->hydrator->hydrate($result->current(), new User());
            $rowset = $this->resultSet->initialize($result);
            foreach ($rowset->toArray() as $c) {
                $list[$c[$columns[0]]] = $c[$columns[1]];
            }
            return $list;
            //return $result->current();
        }
    }
    
    public function getCastList($columns = array('id', 'caste_name')) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_caste');
        $select->columns($columns);
        $select->where(array('is_active' => 1));
        $select->order('id ASC');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //return $this->hydrator->hydrate($result->current(), new User());
            $rowset = $this->resultSet->initialize($result);
            foreach ($rowset->toArray() as $c) {
                $list[$c[$columns[0]]] = $c[$columns[1]];
            }
            return $list;
            //return $result->current();
        }
    }

    public function getReligionList($columns = array('id', 'religion_name')) {

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_religion');
        $select->columns($columns);
        $select->where(array('is_active' => 1));
        $select->order('id ASC');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //return $this->hydrator->hydrate($result->current(), new User());
            $rowset = $this->resultSet->initialize($result);
            foreach ($rowset->toArray() as $c) {
                $list[$c[$columns[0]]] = $c[$columns[1]];
            }
            return $list;
            //return $result->current();
        }
    }
    
    public function getCommunityList($columns = array('id', 'community_name')) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('community');
        $select->columns($columns);
        $select->where(array('is_active' => 1));
        $select->order('id ASC');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //return $this->hydrator->hydrate($result->current(), new User());
            $rowset = $this->resultSet->initialize($result);
            foreach ($rowset->toArray() as $c) {
                $list[$c[$columns[0]]] = $c[$columns[1]];
            }
            return $list;
            //return $result->current();
        }
    }

    public function getUserById($id) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_user');
        $select->where(array('id = ?' => $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new User());
        }
    }

    public function getUserType($columns = array('id', 'user_type')) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_user_type');
        $select->columns($columns);
        $select->where(array('is_active' => 1));
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //return $this->hydrator->hydrate($result->current(), new User());
            $rowset = $this->resultSet->initialize($result);
            foreach ($rowset->toArray() as $c) {
                $list[$c[$columns[0]]] = $c[$columns[1]];
            }
            return $list;
            //return $result->current();
        }
    }

    public function getAffluenceLevelStatusList() {
        $affluencelevel_status = array("Affluent" => "Affluent",
            "Upper Middle Class" => "Upper Middle Class",
            "Middle Class" => "Middle Class",
            "Lower Middle Class" => "Lower Middle Class");
        return $affluencelevel_status;
    }

    public function getAge() {
        $AGE = array();
        for ($i = 1; $i <= 150;) {
            $AGE[$i] = $i;
            $i++;
        }
        return $AGE;
    }

    public function getBloodGroupList() {
        $blood_group = array("Dont Know" => "Dont Know", "A+" => "A+", "A-" => "A-", "B+" => "B+", "B-" => "B-", "AB+" => "AB+", "AB-" => "AB-", "O+" => "O+", "O-" => "O-");
        return $blood_group;
    }

    public function getEmploymentStatusList() {
        $Employment_status = array("Homemaker" => "Homemaker",
            "Employed" => "Employed",
            "Business" => "Business",
            "Professional" => "Professional",
            "Retired" => "Retired",
            "Not Employed" => "Not Employed",
            "Passed Away" => "Passed Away",
            "Others" => "Others");
        return $Employment_status;
    }

    public function getFamilyValuesStatusList() {

        $familyvalues_status = array("Traditional" => "Traditional",
            "Moderate" => "Moderate",
            "Liberal" => "Liberal");
        return $familyvalues_status;
    }

    public function getGothraList() {
        
    }

    public function getLiveStatusList() {
        $LiveStatus = array("Alive" => "Alive", "Passed Away" => "Passed Away");
        return $LiveStatus;
    }

    public function getMeritalStatusList() {
        $marital_status = array("Single" => "Single",
            "Married" => "Married",
            "Divorced" => "Divorced",
            "Widowed" => "Widowed",
            "Separated" => "Separated");
        return $marital_status;
    }

    public function getNameTitleList() {
        $NameTitle = array("Mr" => "Mr",
            "Mrs" => "Mrs",
            "Miss" => "Miss",
            "Dr" => "Dr",
            "Prof" => "Prof",
            "Retd" => "Retd",
            "Major" => "Major",
            "Sh" => "Sh",
            "Smt" => "Smt");
        return $NameTitle;
    }

    public function getPostCategoryList() {

        $statement = $this->dbAdapter->query("select id, category_name from tbl_post_category");
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {

            $rowset = $this->resultSet->initialize($result);

            foreach ($rowset->toArray() as $c) {
                $list[$c['id']] = $c['category_name'];
            }

            return $list;
        }
    }

    public function getRustagiBranchList($columns = array('branch_id', 'branch_name')) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_rustagi_branches');
        $select->columns($columns);
        $select->where(array('is_active' => 1));
        $select->order('branch_id ASC');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //return $this->hydrator->hydrate($result->current(), new User());
            $rowset = $this->resultSet->initialize($result);
            foreach ($rowset->toArray() as $c) {
                $list[$c[$columns[0]]] = $c[$columns[1]];
            }
            return $list;
            //return $result->current();
        }
    }

    public function getWorkingWithCompanyList() {

        $Working_with = array("Private Company" => "Private Company",
            "Government / Public Sector" => "Government / Public Sector",
            "Defense / Civil Services" => "Defense / Civil Services",
            "Business / Self Employed" => "Business / Self Employed",
            "Non Working" => "Non Working",
            "Others" => "Others");
        return $Working_with;
    }

    public function profileForList() {
        $profilrFor = array("Myself" => "Myself",
            "Brother" => "Brother",
            "Sister" => "Sister",
            "Son" => "Son",
            "Daughter" => "Daughter",
            "Cousin" => "Cousin",
            "Others" => "Others");
        return $profilrFor;
    }

    public function bindAccountForm($formObject, $modelObject) {
        //$formObject->setAddress($modelObject->getAddress());
        return $modelObject;
    }

    public function bindAccountModel($modelObject, $formObject) {
        
    }

    public function bodyTypeList() {
        return array("Average" => "Average",
            "Athletic" => "Athletic",
            "Slim" => "Slim",
            "Heavy" => "Heavy");
    }

    public function disabilityList() {
        return array("None" => "None", "Physical disability" => "Physical disability");
    }

    public function genderList() {
        return array("Male" => "Male", "Female" => "Female");
    }

    public function skinToneList() {
        return array("Very Fair" => "Very Fair",
            "Fair" => "Fair",
            "Wheatish" => "Wheatish",
            "Dark" => "Dark");
    }
      
    public function getCasteList($columns = array('id', 'caste_name')) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_caste');
        $select->columns($columns);
        $select->where(array('is_active' => 1));
        $select->order('id ASC');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //return $this->hydrator->hydrate($result->current(), new User());
            $rowset = $this->resultSet->initialize($result);
            foreach ($rowset->toArray() as $c) {
                $list[$c[$columns[0]]] = $c[$columns[1]];
            }
            return $list;
            //return $result->current();
        }
    }
    
    public function getStarSignList($columns = array('id', 'star_sign_name')) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_star_sign');
        $select->columns($columns);
        $select->where(array('is_active' => 1));
        $select->order('id ASC');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //return $this->hydrator->hydrate($result->current(), new User());
            $rowset = $this->resultSet->initialize($result);
            foreach ($rowset->toArray() as $c) {
                $list[$c[$columns[0]]] = $c[$columns[1]];
            }
            return $list;
            //return $result->current();
        }
    }
    
    public function getMotherTongueList($columns = array('id', 'mother_tongue')) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_mother_tongue');
        $select->columns($columns);
        $select->where(array('is_active' => 1));
        $select->order('id ASC');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            //return $this->hydrator->hydrate($result->current(), new User());
            $rowset = $this->resultSet->initialize($result);
            foreach ($rowset->toArray() as $c) {
                $list[$c[$columns[0]]] = $c[$columns[1]];
            }
            return $list;
            //return $result->current();
        }
        
    }
    
    public function getManglikDossamlist() {
        return array(
            "Don't Know" => "Don't Know",
            "Yes" => "Yes",
            "No" => "No");
    }
    
    public function getMealPrefernceList() {
        return array("Veg" => "Veg",
            "Non-Veg" => "Non-Veg",
            "Occasionally Non-Veg" => "Occasionally Non-Veg",
            "Eggetarian" => "Eggetarian",
            "Jain" => "Jain",
            "Vegan" => "Vegan");
    }
    
    public function getDrinkSmokeList() {
        return array("No" => "No",
            "Yes" => "Yes",
            "Occasionally" => "Occasionally");
    }
    public function getCommunityNamesListByRelgionId($relgionId){        //var_dump($relgionId); exit;
        $data=[];
        if($relgionId==null){
            $data=null;
        }else{
       $sql= new Sql($this->dbAdapter);
        $select= $sql->select(TableName::COMMUNITYTABLE)
                ->columns(['id','community_name'])
                ->where(['religion_id'=>$relgionId,'is_active'=>1]);
       $result= $sql->prepareStatementForSqlObject($select);     
        $communityArr =$result->execute(PDO::FETCH_ASSOC)->getResource()->fetchAll();
        foreach ($communityArr as $key => $val){           
         $data[$val['id']]=$val['community_name'];
        }
       }
     return $data;
    }
    
    public function getCasteNameListByCommunityId($communityId){
       $data=[];
        if($communityId==null){
            $data=null;
        }else{
       $sql= new Sql($this->dbAdapter);
        $select= $sql->select(TableName::CASTETABLE)
                ->columns(['id','caste_name'])
                ->where(['community_id'=>$communityId,'is_active'=>1]);
       $result= $sql->prepareStatementForSqlObject($select);     
        $communityArr =$result->execute(PDO::FETCH_ASSOC)->getResource()->fetchAll();
        foreach ($communityArr as $key => $val){           
         $data[$val['id']]=$val['caste_name'];
        }
       }
     return $data; 
    }
    
    public function getGothraNameListByCastId($casteId){
       $data=[];
        if($casteId==null){
            $data=null;
        }else{
       $sql= new Sql($this->dbAdapter);
        $select= $sql->select(TableName::GOTHRAGOTHRAMTABLE)
                ->columns(['id','gothra_name'])
                ->where(['caste_id'=>$casteId,'is_active'=>1]);
       $result= $sql->prepareStatementForSqlObject($select);     
        $communityArr =$result->execute(PDO::FETCH_ASSOC)->getResource()->fetchAll();
        foreach ($communityArr as $key => $val){           
         $data[$val['id']]=$val['gothra_name'];
        }
       }
     return $data;   
    }
}
