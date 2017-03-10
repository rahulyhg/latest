<?php

namespace Common\Plugin;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class TablePlugin extends AbstractPlugin {

    protected $dbAdapter;

    public function __construct(Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

//User Data start here

    public function getUser($id = null) {
        $data = $this->dbAdapter->query("SELECT * FROM tbl_user WHERE id='$id'", Adapter::QUERY_MODE_EXECUTE);
        return $data->current();
    }

    public function getUserById($id = null) {
        $data = $this->dbAdapter->query("SELECT * FROM tbl_user WHERE id='$id'", Adapter::QUERY_MODE_EXECUTE);
        return $data->current();
    }

//    public function getUserInfo($id = null) {
//        $data = $this->dbAdapter->query(
//                "SELECT * FROM tbl_user WHERE id='$id'"
//                
//                 , \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
//        
//        
//         return $data->current();
//    }
    public function getUserInfoById($id = null, $field = null) {

        if ($id == null) {
            return false;
        }
        if ($field == null) {
            $fieldName = ' * ';
        } else {
            $fieldName = $field;
        }


        $userinfo = $this->dbAdapter->query("select $fieldName from tbl_user_info where user_id='$id'", Adapter::QUERY_MODE_EXECUTE);
        $resultSet = new ResultSet;
        $resultSet->initialize($userinfo);
        return $resultSet->current();
    }
    
    public function GetUserDetail($id) {
        
        $table = new TableGateway('tbl_user_info', $this->dbAdapter);
        $rowset = $table->select(function(Select $select) use ($id)  {
          
            $select->where(array('user_id'=>(int)$id));
        });
        return $rowset->toArray();
    }



 
//    Static Table data Start here

    public function BloodGroup() {
        $blood_group = array("Dont Know" => "Dont Know", "A+" => "A+", "A-" => "A-", "B+" => "B+", "B-" => "B-", "AB+" => "AB+", "AB-" => "AB-", "O+" => "O+", "O-" => "O-");
        return $blood_group;
    }

    public function MeritalStatus() {
        $marital_status = array("Single" => "Single",
            "Married" => "Married",
            "Divorced" => "Divorced",
            "Widowed" => "Widowed",
            "Separated" => "Separated");
        return $marital_status;
    }

    public function EmploymentStatus() {
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

    public function LiveStatus() {
        $LiveStatus = array("Alive" => "Alive", "Passed Away" => "Passed Away");
        return $LiveStatus;
    }

    public function WorkingWithCompany() {
        $Working_with = array("Private Company" => "Private Company",
            "Government / Public Sector" => "Government / Public Sector",
            "Defense / Civil Services" => "Defense / Civil Services",
            "Business / Self Employed" => "Business / Self Employed",
            "Non Working" => "Non Working",
            "Others" => "Others");
        return $Working_with;
    }

    public function getAge() {
        $age = array();
        for ($i = 1; $i <= 150;) {
            $age[$i] = $i;
            $i++;
        }
        return $age;
    }

    public function AffluenceLevelStatus() {
        $affluencelevel_status = array("Affluent" => "Affluent",
            "Upper Middle Class" => "Upper Middle Class",
            "Middle Class" => "Middle Class",
            "Lower Middle Class" => "Lower Middle Class");
        return $affluencelevel_status;
    }

    public function FamilyValuesStatus() {
        $familyvalues_status = array("Traditional" => "Traditional",
            "Moderate" => "Moderate",
            "Liberal" => "Liberal");
        return $familyvalues_status;
    }

    public function GetNameTitle() {
        $NameTitle = array("Mr" => "Mr",
            "Miss" => "Miss",
            "Dr" => "Dr",
            "Prof" => "Prof",
            "Retd" => "Retd",
            "Major" => "Major",
            "Sh" => "Sh",
            "Smt" => "Smt");
        return $NameTitle;
    }


}
