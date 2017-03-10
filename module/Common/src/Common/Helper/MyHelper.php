<?php

namespace Common\Helper;

use Application\Model\Entity\Family;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Sql;
use Zend\View\Helper\AbstractHelper;

class MyHelper extends AbstractHelper {

    protected $model, $sql, $resultSet;

    public function __construct($model, $dbAdapter) {
        $this->model = $dbAdapter;
        $this->sql = new Sql($this->model);
        $this->resultSet = new \Zend\Db\ResultSet\ResultSet();
    }

    public function findage($dob) {

        $dob = date('d-m-Y', strtotime($dob));
        date_default_timezone_set('Asia/Calcutta');
        $localtime = getdate();
        $today = $localtime['mday'] . "-" . $localtime['mon'] . "-" . $localtime['year'];
        $dob_a = explode("-", $dob);
        $today_a = explode("-", $today);
        $dob_d = $dob_a[0];
        $dob_m = $dob_a[1];
        $dob_y = $dob_a[2];
        $today_d = $today_a[0];
        $today_m = $today_a[1];
        $today_y = $today_a[2];
        $years = $today_y - $dob_y;
        $months = $today_m - $dob_m;
        if ($today_m . $today_d < $dob_m . $dob_d) {
            $years--;
            $months = 12 + $today_m - $dob_m;
        }

        if ($today_d < $dob_d) {
            $months--;
        }

        $firstMonths = array(1, 3, 5, 7, 8, 10, 12);
        $secondMonths = array(4, 6, 9, 11);
        $thirdMonths = array(2);

        if ($today_m - $dob_m == 1) {
            if (in_array($dob_m, $firstMonths)) {
                array_push($firstMonths, 0);
            } elseif (in_array($dob_m, $secondMonths)) {
                array_push($secondMonths, 0);
            } elseif (in_array($dob_m, $thirdMonths)) {
                array_push($thirdMonths, 0);
            }
        }
        echo "$years years $months months";
    }

    public function ageByDob($dob) {

        $dob = date('d-m-Y', strtotime($dob));
        date_default_timezone_set('Asia/Calcutta');
        $localtime = getdate();
        $today = $localtime['mday'] . "-" . $localtime['mon'] . "-" . $localtime['year'];
        $dob_a = explode("-", $dob);
        $today_a = explode("-", $today);
        $dob_d = $dob_a[0];
        $dob_m = $dob_a[1];
        $dob_y = $dob_a[2];
        $today_d = $today_a[0];
        $today_m = $today_a[1];
        $today_y = $today_a[2];
        $years = $today_y - $dob_y;
        $months = $today_m - $dob_m;
        if ($today_m . $today_d < $dob_m . $dob_d) {
            $years--;
            $months = 12 + $today_m - $dob_m;
        }

        if ($today_d < $dob_d) {
            $months--;
        }

        $firstMonths = array(1, 3, 5, 7, 8, 10, 12);
        $secondMonths = array(4, 6, 9, 11);
        $thirdMonths = array(2);

        if ($today_m - $dob_m == 1) {
            if (in_array($dob_m, $firstMonths)) {
                array_push($firstMonths, 0);
            } elseif (in_array($dob_m, $secondMonths)) {
                array_push($secondMonths, 0);
            } elseif (in_array($dob_m, $thirdMonths)) {
                array_push($thirdMonths, 0);
            }
        }
        echo "$years";
    }

    public function myCoolModelMethod() {
        return $this->model->fetchAll();
    }

    public function PopPosts() {
        $sql = "SELECT tbl_post.*,tbl_user_info.full_name from tbl_post 
            left join tbl_user_info on (tbl_post.user_id = tbl_user_info.user_id)
            WHERE tbl_post.is_active=1 order by view_count DESC limit 2";
        $results = $this->model->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
        return $results;
    }

    public function PostCat($cat = '') {
        $postQuery = "SELECT tbl_post.*,tbl_user_info.full_name     
from tbl_post left join tbl_user_info on (tbl_post.user_id = tbl_user_info.user_id)
where tbl_post.post_category='$cat' and tbl_post.is_active=1 group by tbl_post.id order by tbl_post.id DESC limit 2";
        $results = $this->model->query($postQuery, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
        return $results;
    }

    public function CurrNews() {
        $sql = "select tn.*,tal.username from tbl_news as tn inner join tbl_admin_login as tal on tn.modified_by=tal.id "
                . "WHERE tn.is_active=1 order by tn.id DESC limit 2";
        $results = $this->model->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
        return $results;
    }

    public function ContentLength($string) {
        // strip tags to avoid breaking any html
        $string = strip_tags($string);

        if (strlen($string) > 70) {

            // truncate string
            $stringCut = substr($string, 0, 70);

            // make sure it ends in a word so assassinate doesn't become ass...
            $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '...';
        }
        echo $string;
    }

    public function postByCatName($name) {
        //$adapter->query('SELECT * FROM `artist` WHERE `id` = ?', array(5));
        //$name=  htmlentities($name);
        //echo $name;
        //exit;
//        $sql = "SELECT * FROM tbl_post_category WHERE category_name=:name";
//        $statement = $this->model->query($sql);
//
//        $parameters = array(
//            'name' => $name
//            
//        );
//
//        $results=$statement->execute($parameters);
//        foreach ($results as $row){
//            print_r($row);
//        }
        //return $results;
    }

    public function dateDMY($date) {
        return date('d-m-Y', strtotime($date));
    }

    public function CommentCount($post_id) {
        $sql = "select post_id from tbl_posts_comments where post_id='$post_id' and  is_active=1";
        $CommentCounts = $this->model->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->count();
        return $CommentCounts;
    }

    public function getCommunityMemberChild($parent = 0) {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "SELECT * FROM tbl_communities WHERE parent_id=$parent";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
        return $row;
    }

    public function getCommunityMemberById($id = 1) {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "SELECT * FROM tbl_communities WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
        return $row;
    }

    public function getCommunityMemberByParentId($parent_id = 1) {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "SELECT * FROM tbl_communities WHERE parent_id=$parent_id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
        return $row;
    }

    public function getBranchNameById($id) {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "SELECT * FROM tbl_rustagi_branches WHERE branch_id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
        return $row;
    }

    public function getCountryNameById($id) {
        $sql = "SELECT * FROM tbl_country WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }

    public function getStateNameById($id) {
        $sql = "SELECT * FROM tbl_state WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }

    public function getCityNameById($id) {
        $sql = "SELECT * FROM tbl_city WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }

    public function getProfilePicByUsergId($user_id) {
        $sql = "SELECT * FROM tbl_user_gallery WHERE profile_pic=1 AND user_id=$user_id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }

    public function getSubeventSponser($event_id, $subevent_id) {
        $sql = "SELECT ese.*,sm.* FROM tbl_event_sponser_ext as ese "
                . "left join tbl_sponser_master as sm on (ese.spons_id = sm.spons_id)"
                . "WHERE ese.event_id='$event_id' and ese.subevent_id='$subevent_id'";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
        return $row;
    }

    public function getSubeventOrganiser($event_id, $subevent_id) {
        $sql = "SELECT eoe.*,ui.full_name,ui.alternate_mobile_no,ug.image_path FROM tbl_event_organiser_ext as eoe "
                . "left join tbl_user_info as ui on (eoe.organiser_id = ui.user_id)"
                . "left join tbl_user_gallery as ug on (eoe.organiser_id = ug.user_id)"
                . "WHERE eoe.event_id='$event_id' and eoe.subevent_id='$subevent_id'"
                . "and ug.profile_pic=1";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
        return $row;
    }

    public function getProfession($id) {
        $sql = "SELECT * FROM tbl_profession Where id='$id'";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }

    public function getHeightById($id) {
        $sql = "SELECT * FROM tbl_height WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }

    public function getReligionNameById($id) {
        $sql = "SELECT * FROM tbl_religion WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }

    public function getCommunityNameById($id) {
        $sql = "SELECT * FROM community WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }

    public function getCasteNameById($id) {
        $sql = "SELECT * FROM tbl_caste WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }

    public function getGothraGothramNameById($id) {
        $sql = "SELECT * FROM tbl_gothra_gothram WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }

    public function getEducationLevelNameById($id) {
        $sql = "SELECT * FROM tbl_education_level WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }

    public function getEducationFieldNameById($id) {
        $sql = "SELECT * FROM tbl_education_field WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }

    public function getDesignationNameById($id) {
        $sql = "SELECT * FROM tbl_designation WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }

    public function getAnnualIncomeById($id) {
        $sql = "SELECT * FROM tbl_annual_income WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }

    public function getZodiacSignRassiById($id) {
        $sql = "SELECT * FROM tbl_zodiac_sign_raasi WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }

    public function getStarSignById($id) {
        $sql = "SELECT * FROM tbl_star_sign WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }

    public function getMotherTongueById($id) {
        $sql = "SELECT * FROM tbl_mother_tongue WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }

    public function getDrinkingStatus($val) {
        // Yes, No, Occasionally
        if ($val == "Yes") {
            $status = "Drinking";
            $imgName = "drink_icon.jpg";
        } elseif ($val == "Occasionally") {
            $status = "Drink Occasionally";
            $imgName = "drink_icon.jpg";
        } else {
            $status = "Does`nt Drink";
            $imgName = "dosenotdrink_icon.jpg";
        }
        return array('status' => $status, 'imgName' => $imgName);
    }

    public function getSmokingStatus($val) {
        // Yes, No, Occasionally
        if ($val == "Yes") {
            $status = "Smoking";
            $imgName = "smoke_icon.jpg";
        } elseif ($val == "Occasionally") {
            $status = "Smoke Occasionally";
            $imgName = "smoke_icon.jpg";
        } else {
            $status = "Does`nt Smoke";
            $imgName = "dosenotsmoke_icon.jpg";
        }
        return array('status' => $status, 'imgName' => $imgName);
    }

    public function getVegetarianStatus($val) {
        // Veg, Non-Veg, Occasionally Non-Veg ,Eggetarian, Jain, Vegan
        if ($val == "Non-Veg") {
            $status = "Non-Vegetarian";
            $imgName = "non-vegetarian_icon.jpg";
        } elseif ($val == "Occasionally Non-Veg") {
            $status = "Occasionally Non-Vegetarian";
            $imgName = "non-vegetarian_icon.jpg";
        } elseif ($val == "Eggetarian") {
            $status = "Eggetarian";
            $imgName = "egg_icon.jpg";
        } else {
            $status = "Vegetarian";
            $imgName = "bhesitarian.jpg";
        }
        return array('status' => $status, 'imgName' => $imgName);
    }

    public function getActiveStatusById($id) {
        $sql = "SELECT * FROM tbl_user WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        $res = $row['is_active'];
        if ($res == 1)
            $status = 'Active';
        else
            $status = 'De-Active';
        return $status;
    }

    public function getModifiedEmail($email) {
        $email = explode('@', $email);
        $email = substr($email[0], 0, 3) . 'xxxxxxxx@' . $email[1];
        return $email;
    }

    public function getModifiedMobileNo($mobile) {
        $mobile = substr($mobile, 0, 2) . 'xxxxx' . substr($mobile, -3);
        return $mobile;
    }

    public function getFamilyInfoByIdMatrimonial($user_id, $relation_id) {

        $sql = new Sql($this->model);
        $select = $sql->select('tbl_family_info_matrimonial');
        $select->where(array('user_id = ?' => $user_id, 'relation_id = ?' => $relation_id));
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        return $result->current();
    }

    function myDate($date) {

        if ($date === "0000-00-00" || $date == NULL || $date === false) {
            return "00-00-0000";
        } else {
            return date("d-m-Y", strtotime($date));
        }
    }

    public function userSummaryByIdMatrimonial($user_id) {

        $statement = "SELECT tui.*, 
             tu.email, 
             tu.mobile_no, 
             tp.*, 
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
               WHERE tui.user_id='$user_id' ORDER BY tugm.id DESC";
//        $parameters = array(
//            'user_id' => $user_id
//        );
        $result = $this->model->query($statement, Adapter::QUERY_MODE_EXECUTE);
        //$result = $statement->execute($parameters);
        //Debug::dump($result->current());
        return $result->current();
    }

    public function getFamilyInfoById($user_id) {
//        $allParent=$this->getFirstParent($user_id);
//        $myChild = $this->getAllChild($user_id);
//        $allChild = $this->getAllChild($user_id);
//        $myFatherId=$allParent[0];
//        $myGrandFatherId=$allParent[1];
//        $brotherArray=$this->my_array_search($this->getAllChild($myFatherId), 'father_id', $myFatherId);
//        $keyMy = array_search($user_id, array_column($brotherArray, 'user_id'));
//        unset($brotherArray[$keyMy]);
//        //array_reduce($a, 'array_merge', array());
//        $myBrotherData=$this->my_array_search(array_values($brotherArray), 'gender', 'Male');
//        $mySisterData=$this->my_array_search(array_values($brotherArray), 'gender', 'Female');
        //$mybrotherId=$mybrotherData['user_id'];
        //Debug::dump($this->my_array_search($child, 'father_id', '38'));
        //Debug::dump($allChild);
        $family = new Family();
        $familyInfo = array();


        $statement = $this->model->query("SELECT tui.created_by, tui.name_title_user, tui.full_name, 
            tui.dob,tui.dod, tui.live_status,tui.ref_no,tui.about_yourself_partner_family,
            tui.profile_photo, tui.gender, tui.family_values_status, tui.user_id as user_id,
            tfr.user_id as user_id_rel, tfr.father_id, tfr.mother_id, tfr.wife_id, tfr.husband_id  FROM tbl_user_info as tui 
            LEFT JOIN tbl_family_relation as tfr 
                ON tui.user_id=tfr.user_id WHERE tui.user_id=:user_id");
        $parameters = array(
            'user_id' => $user_id
        );
        $statementGallery = $this->model->query("SELECT * FROM tbl_user_gallery WHERE user_id=:user_id AND profile_pic=1");
        $parameters = array(
            'user_id' => $user_id
        );
        $result = $statement->execute($parameters);
        $userInfo = $result->current();
        //Debug::dump($userInfo);
        $family->setUserId($userInfo['user_id']);
        $family->setFamilyValues($userInfo['family_values_status']);

// father
        $parameters = array(
            'user_id' => $userInfo['father_id']
        );
        $result = $statement->execute($parameters);
        $fatherInfo = $result->current();
        $familyInfo['father_id'] = $fatherInfo['user_id'];
        $familyInfo['father_created_by'] = $fatherInfo['created_by'];
        $familyInfo['father_ref_no'] = $fatherInfo['ref_no'];
        $familyInfo['name_title_father'] = $fatherInfo['name_title_user'];
        $familyInfo['father_name'] = $fatherInfo['full_name'];
        $familyInfo['father_dob'] = $fatherInfo['dob'];
        $familyInfo['father_dod'] = $fatherInfo['dod'];
        $familyInfo['father_status'] = $fatherInfo['live_status'];
        $familyInfo['father_photo'] = $fatherInfo['profile_photo'];
        $familyInfo['about_father'] = $fatherInfo['about_yourself_partner_family'];
        $parametersGallery = array(
            'user_id' => $fatherInfo['user_id']
        );
        $resultGallery = $statementGallery->execute($parametersGallery);
        $GalleryInfo['father'] = $resultGallery->current();

        $family->setFatherId($fatherInfo['user_id']);
        $family->setNameTitleFather($fatherInfo['name_title_user']);
        $family->setFatherName($fatherInfo['full_name']);
        $family->setFatherDob(date('d-m-Y', strtotime($fatherInfo['dob'])));
        $family->setFatherDod(date('d-m-Y', strtotime($fatherInfo['dod'])));
        $family->setFatherStatus($fatherInfo['live_status']);
        $family->setFatherPhoto($fatherInfo['profile_photo']);


// mother
        $parameters = array(
            'user_id' => $userInfo['mother_id']
        );
        $result = $statement->execute($parameters);
        $motherInfo = $result->current();
        $familyInfo['mother_id'] = $motherInfo['user_id'];
        $familyInfo['mother_created_by'] = $motherInfo['created_by'];
        $familyInfo['mother_ref_no'] = $motherInfo['ref_no'];
        $familyInfo['name_title_mother'] = $motherInfo['name_title_user'];
        $familyInfo['mother_name'] = $motherInfo['full_name'];
        $familyInfo['mother_dob'] = $motherInfo['dob'];
        $familyInfo['mother_dod'] = $motherInfo['dod'];
        $familyInfo['mother_status'] = $motherInfo['live_status'];
        $familyInfo['mother_photo'] = $motherInfo['profile_photo'];
        $familyInfo['about_mother'] = $motherInfo['about_yourself_partner_family'];
        $parametersGallery = array(
            'user_id' => $motherInfo['user_id']
        );
        $resultGallery = $statementGallery->execute($parametersGallery);
        $GalleryInfo['mother'] = $resultGallery->current();

        $family->setMotherId($motherInfo['user_id']);
        $family->setNameTitleMother($motherInfo['name_title_user']);
        $family->setMotherName($motherInfo['full_name']);
        $family->setMotherDob(date('d-m-Y', strtotime($motherInfo['dob'])));
        $family->setMotherDod(date('d-m-Y', strtotime($motherInfo['dod'])));
        $family->setMotherStatus($motherInfo['live_status']);
        $family->setMotherPhoto($motherInfo['profile_photo']);


// spouse wife
        if ($userInfo['gender'] === "Male") {
            $parameters = array(
                'user_id' => $userInfo['wife_id']
            );
            $result = $statement->execute($parameters);
            $wifeInfo = $result->current();
            $familyInfo['spouse_id'] = $wifeInfo['user_id'];
            $familyInfo['spouse_created_by'] = $wifeInfo['created_by'];
            $familyInfo['spouse_ref_no'] = $wifeInfo['ref_no'];
            $familyInfo['name_title_spouse'] = $wifeInfo['name_title_user'];
            $familyInfo['spouse_name'] = $wifeInfo['full_name'];
            $familyInfo['spouse_dob'] = $wifeInfo['dob'];
            $familyInfo['spouse_status'] = $wifeInfo['live_status'];
            $familyInfo['spouse_photo'] = $wifeInfo['profile_photo'];
            $familyInfo['about_spouse'] = $wifeInfo['about_yourself_partner_family'];
            $parametersGallery = array(
                'user_id' => $wifeInfo['user_id']
            );
            $resultGallery = $statementGallery->execute($parametersGallery);
            $GalleryInfo['spouse'] = $resultGallery->current();

            $family->setSpouseId($wifeInfo['user_id']);
            $family->setNameTitleSpouse($wifeInfo['name_title_user']);
            $family->setSpouseName($wifeInfo['full_name']);
            $family->setSpouseDob(date('d-m-Y', strtotime($wifeInfo['dob'])));
            $family->setSpouseDiedOn(date('d-m-Y', strtotime($wifeInfo['dod'])));
            $family->setSpouseStatus($wifeInfo['live_status']);
            $family->setSpousePhoto($wifeInfo['profile_photo']);
        }
// spouse husband
        if ($userInfo['gender'] === "Female") {
            $parameters = array(
                'user_id' => $userInfo['husband_id']
            );
            $result = $statement->execute($parameters);
            $husbandInfo = $result->current();
            $familyInfo['spouse_id'] = $husbandInfo['user_id'];
            $familyInfo['spouse_created_by'] = $husbandInfo['created_by'];
            $familyInfo['spouse_ref_no'] = $husbandInfo['ref_no'];
            $familyInfo['name_title_spouse'] = $husbandInfo['name_title_user'];
            $familyInfo['spouse_name'] = $husbandInfo['full_name'];
            $familyInfo['spouse_dob'] = $husbandInfo['dob'];
            $familyInfo['spouse_status'] = $husbandInfo['live_status'];
            $familyInfo['spouse_photo'] = $husbandInfo['profile_photo'];
            $familyInfo['about_spouse'] = $wifeInfo['about_yourself_partner_family'];
            $parametersGallery = array(
                'user_id' => $husbandInfo['user_id']
            );
            $resultGallery = $statementGallery->execute($parametersGallery);
            $GalleryInfo['spouse'] = $resultGallery->current();

            $family->setSpouseId($husbandInfo['user_id']);
            $family->setNameTitleSpouse($husbandInfo['name_title_user']);
            $family->setSpouseName($husbandInfo['full_name']);
            $family->setSpouseDob(date('d-m-Y', strtotime($husbandInfo['dob'])));
            $family->setSpouseDiedOn(date('d-m-Y', strtotime($wifeInfo['dod'])));
            $family->setSpouseStatus($husbandInfo['live_status']);
            $family->setSpousePhoto($husbandInfo['profile_photo']);
        }

// grand father
        $parameters = array(
            'user_id' => $fatherInfo['father_id']
        );
        $result = $statement->execute($parameters);
        $grandFatherInfo = $result->current();
        $familyInfo['grand_father_id'] = $grandFatherInfo['user_id'];
        $familyInfo['grand_father_created_by'] = $grandFatherInfo['created_by'];
        $familyInfo['grand_father_ref_no'] = $grandFatherInfo['ref_no'];
        $familyInfo['name_title_grand_father'] = $grandFatherInfo['name_title_user'];
        $familyInfo['grand_father_name'] = $grandFatherInfo['full_name'];
        $familyInfo['grand_father_dob'] = $grandFatherInfo['dob'];
        $familyInfo['grand_father_status'] = $grandFatherInfo['live_status'];
        $familyInfo['grand_father_photo'] = $grandFatherInfo['profile_photo'];
        $familyInfo['about_grand_father'] = $grandFatherInfo['about_yourself_partner_family'];
        $parametersGallery = array(
            'user_id' => $grandFatherInfo['user_id']
        );
        $resultGallery = $statementGallery->execute($parametersGallery);
        $GalleryInfo['grand_father'] = $resultGallery->current();

        $family->setGrandFatherId($grandFatherInfo['user_id']);
        $family->setNameTitleGrandFather($grandFatherInfo['name_title_user']);
        $family->setGrandFatherName($grandFatherInfo['full_name']);
        $family->setGrandFatherDob(date('d-m-Y', strtotime($grandFatherInfo['dob'])));
        $family->setGrandFatherDod(date('d-m-Y', strtotime($grandFatherInfo['dod'])));
        $family->setGrandFatherStatus($grandFatherInfo['live_status']);
        $family->setGrandFatherPhoto($grandFatherInfo['profile_photo']);


// grand mother
        $parameters = array(
            'user_id' => $fatherInfo['mother_id']
        );
        $result = $statement->execute($parameters);
        $grandMotherInfo = $result->current();
        $familyInfo['grand_mother_id'] = $grandMotherInfo['user_id'];
        $familyInfo['grand_mother_created_by'] = $grandMotherInfo['created_by'];
        $familyInfo['grand_mother_ref_no'] = $grandMotherInfo['ref_no'];
        $familyInfo['name_title_grand_mother'] = $grandMotherInfo['name_title_user'];
        $familyInfo['grand_mother_name'] = $grandMotherInfo['full_name'];
        $familyInfo['grand_mother_dob'] = $grandMotherInfo['dob'];
        $familyInfo['grand_mother_status'] = $grandMotherInfo['live_status'];
        $familyInfo['grand_mother_photo'] = $grandMotherInfo['profile_photo'];
        $familyInfo['about_grand_mother'] = $grandMotherInfo['about_yourself_partner_family'];

        $parametersGallery = array(
            'user_id' => $grandMotherInfo['user_id']
        );
        $resultGallery = $statementGallery->execute($parametersGallery);
        $GalleryInfo['grand_mother'] = $resultGallery->current();

        $family->setGrandMotherId($grandMotherInfo['user_id']);
        $family->setNameTitleGrandMother($grandMotherInfo['name_title_user']);
        $family->setGrandMotherName($grandMotherInfo['full_name']);
        $family->setGrandMotherDob(date('d-m-Y', strtotime($grandMotherInfo['dob'])));
        $family->setGrandMotherDod(date('d-m-Y', strtotime($grandMotherInfo['dod'])));
        $family->setGrandMotherStatus($grandMotherInfo['live_status']);
        $family->setGrandMotherPhoto($grandMotherInfo['profile_photo']);

// grand grand mother
        $parameters = array(
            'user_id' => $grandFatherInfo['mother_id']
        );
        $result = $statement->execute($parameters);
        $grandGrandMotherInfo = $result->current();
        $familyInfo['grand_grand_mother_id'] = $grandGrandMotherInfo['user_id'];
        $familyInfo['grand_grand_mother_created_by'] = $grandGrandMotherInfo['created_by'];
        $familyInfo['grand_grand_mother_ref_no'] = $grandGrandMotherInfo['ref_no'];
        $familyInfo['name_title_grand_grand_mother'] = $grandGrandMotherInfo['name_title_user'];
        $familyInfo['grand_grand_mother_name'] = $grandGrandMotherInfo['full_name'];
        $familyInfo['grand_grand_mother_dob'] = $grandGrandMotherInfo['dob'];
        $familyInfo['grand_grand_mother_status'] = $grandGrandMotherInfo['live_status'];
        $familyInfo['grand_grand_mother_photo'] = $grandGrandMotherInfo['profile_photo'];
        $familyInfo['about_grand_grand_mother'] = $grandGrandMotherInfo['about_yourself_partner_family'];

        $parametersGallery = array(
            'user_id' => $grandGrandMotherInfo['user_id']
        );
        $resultGallery = $statementGallery->execute($parametersGallery);
        $GalleryInfo['grand_grand_mother'] = $resultGallery->current();


        $family->setGrandGrandMotherId($grandGrandMotherInfo['user_id']);
        $family->setNameTitleGrandGrandMother($grandGrandMotherInfo['name_title_user']);
        $family->setGrandGrandMotherName($grandGrandMotherInfo['full_name']);
        $family->setGrandGrandMotherDob(date('d-m-Y', strtotime($grandGrandMotherInfo['dob'])));
        $family->setGrandGrandMotherDod(date('d-m-Y', strtotime($grandGrandMotherInfo['dod'])));
        $family->setGrandGrandMotherStatus($grandGrandMotherInfo['live_status']);
        $family->setGrandGrandMotherPhoto($grandGrandMotherInfo['profile_photo']);


// grand grand father
        $parameters = array(
            'user_id' => $grandFatherInfo['father_id']
        );
        $result = $statement->execute($parameters);
        $grandGrandFatherInfo = $result->current();
        $familyInfo['grand_grand_father_id'] = $grandGrandFatherInfo['user_id'];
        $familyInfo['grand_grand_father_created_by'] = $grandGrandFatherInfo['created_by'];
        $familyInfo['grand_grand_father_ref_no'] = $grandGrandFatherInfo['ref_no'];
        $familyInfo['name_title_grand_grand_father'] = $grandGrandFatherInfo['name_title_user'];
        $familyInfo['grand_grand_father_name'] = $grandGrandFatherInfo['full_name'];
        $familyInfo['grand_grand_father_dob'] = $grandGrandFatherInfo['dob'];
        $familyInfo['grand_grand_father_status'] = $grandGrandFatherInfo['live_status'];
        $familyInfo['grand_grand_father_photo'] = $grandGrandFatherInfo['profile_photo'];
        $familyInfo['about_grand_grand_father'] = $grandGrandFatherInfo['about_yourself_partner_family'];

        $parametersGallery = array(
            'user_id' => $grandGrandFatherInfo['user_id']
        );
        $resultGallery = $statementGallery->execute($parametersGallery);
        $GalleryInfo['grand_grand_father'] = $resultGallery->current();


        $family->setGrandGrandFatherId($grandGrandFatherInfo['user_id']);
        $family->setNameTitleGrandGrandFather($grandGrandFatherInfo['name_title_user']);
        $family->setGrandGrandFatherName($grandGrandFatherInfo['full_name']);
        $family->setGrandGrandFatherDob(date('d-m-Y', strtotime($grandGrandFatherInfo['dob'])));
        $family->setGrandGrandFatherDod(date('d-m-Y', strtotime($grandGrandFatherInfo['dod'])));
        $family->setGrandGrandFatherStatus($grandGrandFatherInfo['live_status']);
        $family->setGrandGrandFatherPhoto($grandGrandFatherInfo['profile_photo']);

// brother

        $sql = new Sql($this->model);
        $select = $sql->select(array('tui' => 'tbl_user_info'));
        $select->join(array('tfr' => 'tbl_family_relation'), 'tui.user_id=tfr.user_id', array('user_id_rel' => 'user_id', 'father_id'), $select::JOIN_LEFT);
        $select->join(array('tug' => 'tbl_user_gallery'), 'tui.user_id=tug.user_id', array('image_path'), $select::JOIN_LEFT);
        $select->columns(array('brother_created_by' => 'created_by', 'name_title_user', 'brother_name' => 'full_name',
            'dob', 'dod', 'live_status',
            'profile_photo', 'gender', 'family_values_status', 'ref_no', 'user_id' => 'user_id', 'marital_status', 'about_yourself_partner_family',
        ));
        $select->where(array('tfr.father_id = ?' => $userInfo['father_id']));
        $select->where(array('tui.user_id != ?' => $user_id), Predicate::OP_AND);
        $select->where(array('tui.gender = ?' => 'Male'), Predicate::OP_AND);
        //echo  $select->getSqlString($this->model->getPlatform());
        $stmt = $sql->prepareStatementForSqlObject($select);

        $result = $stmt->execute();

        //$resultSet = new HydratingResultSet($this->hydrator, $family);

        $resultSet = $this->resultSet->initialize($result);
        $brotherData = $resultSet->toArray();
//        foreach ($brotherData as $brotherDatas) {
//            $parametersGallery = array(
//                'user_id' => $grandGrandFatherInfo['user_id']
//            );
//            $resultGallery = $statementGallery->execute($parametersGallery);
//            $GalleryInfo['brother'] = $resultGallery->current();
//        }
        //Debug::dump($brotherData);
        $family->setNumbor($resultSet->count() > 0 ? $resultSet->count() : '');

// Sister

        $sql = new Sql($this->model);
        $select = $sql->select(array('tui' => 'tbl_user_info'));
        $select->join(array('tfr' => 'tbl_family_relation'), 'tui.user_id=tfr.user_id', array('user_id_rel' => 'user_id', 'father_id'), $select::JOIN_LEFT);
        $select->join(array('tug' => 'tbl_user_gallery'), 'tui.user_id=tug.user_id', array('image_path'), $select::JOIN_LEFT);
        $select->columns(array('sister_created_by' => 'created_by', 'name_title_user', 'sister_name' => 'full_name',
            'dob', 'dod', 'live_status',
            'profile_photo', 'gender', 'family_values_status', 'ref_no', 'user_id' => 'user_id', 'marital_status', 'about_yourself_partner_family',
        ));
        $select->where(array('tfr.father_id = ?' => $userInfo['father_id']));
        $select->where(array('tui.user_id != ?' => $user_id), Predicate::OP_AND);
        $select->where(array('tui.gender = ?' => 'Female'), Predicate::OP_AND);

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        //$resultSet = new HydratingResultSet($this->hydrator, $family);

        $resultSet = $this->resultSet->initialize($result);
        //Debug::dump($resultSet);
        $sisterData = $resultSet->toArray();

// Kids

        $sql = new Sql($this->model);
        $select = $sql->select(array('tui' => 'tbl_user_info'));
        $select->join(array('tfr' => 'tbl_family_relation'), 'tui.user_id=tfr.user_id', array('user_id_rel' => 'user_id', 'father_id'), $select::JOIN_LEFT);
        $select->join(array('tug' => 'tbl_user_gallery'), 'tui.user_id=tug.user_id', array('image_path'), $select::JOIN_LEFT);
        $select->columns(array('kids_created_by' => 'created_by', 'name_title_user', 'kids_name' => 'full_name',
            'dob', 'dod', 'live_status',
            'profile_photo', 'gender', 'family_values_status', 'ref_no', 'user_id' => 'user_id', 'marital_status', 'about_yourself_partner_family',
        ));
        $select->where(array('tfr.father_id = ?' => $user_id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        //$resultSet = new HydratingResultSet($this->hydrator, $family);

        $resultSet = $this->resultSet->initialize($result);
        //Debug::dump($resultSet);
        $kidsData = $resultSet->toArray();
        //Debug::dump($kidsData);
        //$family->setNumbor($brotherData->count() > 0 ? $brotherData->count() : '');


        return (object) array('userInfo' => $userInfo,
                    'familyInfoObject' => $family,
                    'brotherData' => $brotherData,
                    'sisterData' => $sisterData,
                    'kidsData' => $kidsData,
                    'familyInfoArray' => $familyInfo,
                    'GalleryInfo' => $GalleryInfo);
        //return $family;
        //Debug::dump($fatherInfo);
        //exit;
//        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
//
//            $userInfo = $this->hydrator->hydrate($result->current(), new UserInfo());
//            $family = $this->hydrator->hydrate($result->current(), new \Application\Model\Entity\Family());
//            //$c = (object)array_merge((array)$userInfo, (array)$user);
//            return (object) array('userInfo' => $userInfo, 'family' => $family);
//
//            //return $this->hydrator->hydrate($result->current(), new \Application\Model\Entity\Family());
//            //return $result->current();
//        }
    }

    public function getGenderById($id) {
        $sql = "SELECT gender FROM tbl_user_info_matrimonial WHERE user_id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row['gender'];
    }

    public function getFatherInfoById($id) {
        $sql = "SELECT name FROM tbl_family_info_matrimonial WHERE user_id='$id' and relation_id=1";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row['name'];
    }

    public function setLimitCharacter($data, $limit = 12) {       // var_dump($data);exit;
        $string = trim($data);
        if (strlen($string) > $limit) {
            $string = substr($string, 0, $limit) . '...';
        }
        return $string;
    }

    public function getFeature($subpackage_id, $feature_id) {
        $sql = "select * FROM tbl_membership_subpackage_ext where subpackage_id=$subpackage_id AND feature_id=$feature_id";

        $packages = $this->model->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->current();
        return $packages;
    }

}
