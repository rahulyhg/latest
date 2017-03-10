<?php

namespace Common\Helper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\View\Helper\AbstractHelper;

class MatrimonialHelper extends AbstractHelper {

    protected $model, $sql;

    public function __construct($model, $dbAdapter) {
        $this->model = $dbAdapter;
        $this->sql = new Sql($this->model);
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
        $sql="select tn.*,tal.username from tbl_news as tn inner join tbl_admin_login as tal on tn.modified_by=tal.id "
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
    
    public function getCountryNameById($id){
         $sql = "SELECT * FROM tbl_country WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }
    
    public function getStateNameById($id){
         $sql = "SELECT * FROM tbl_state WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }
    
    public function getCityNameById($id){
         $sql = "SELECT * FROM tbl_city WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }
    
    public function getProfilePicByUsergId($user_id){
            $sql = "SELECT * FROM tbl_user_gallery WHERE profile_pic=1 AND user_id=$user_id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }
    
    public function getSubeventSponser($event_id,$subevent_id) {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "SELECT ese.*,sm.* FROM tbl_event_sponser_ext as ese "
                . "left join tbl_sponser_master as sm on (ese.spons_id = sm.spons_id)"
                . "WHERE ese.event_id='$event_id' and ese.subevent_id='$subevent_id' and ese.is_active=1";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
        return $row;
    }
    
    public function getSubeventOrganiser($event_id,$subevent_id) {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "SELECT eoe.*,ui.full_name,ui.alternate_mobile_no,ug.image_path FROM tbl_event_organiser_ext as eoe "
                . "left join tbl_user_info as ui on (eoe.organiser_id = ui.user_id)"
                . "left join tbl_user_gallery as ug on (eoe.organiser_id = ug.user_id)"
                . "WHERE eoe.event_id='$event_id' and eoe.subevent_id='$subevent_id'"
                . "and eoe.is_active=1 and ug.profile_pic=1";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
        return $row;
    }

    public function getProfession($id){
         $sql = "SELECT * FROM tbl_profession Where id='$id'";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
        
    }
    
    public function getHeightById($id){
         $sql = "SELECT * FROM tbl_height WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }
    
    public function getReligionNameById($id){
         $sql = "SELECT * FROM tbl_religion WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }
    
    public function getCasteNameById($id){
         $sql = "SELECT * FROM tbl_caste WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }
    
    public function getGothraGothramNameById($id){
         $sql = "SELECT * FROM tbl_gothra_gothram WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }
    
    public function getEducationLevelNameById($id){
         $sql = "SELECT * FROM tbl_education_level WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }
    
    public function getEducationFieldNameById($id){
         $sql = "SELECT * FROM tbl_education_field WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }
    
    public function getDesignationNameById($id){
         $sql = "SELECT * FROM tbl_designation WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }
    
    public function getAnnualIncomeById($id){
         $sql = "SELECT * FROM tbl_annual_income WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }
    
    public function getZodiacSignRassiById($id){
        $sql = "SELECT * FROM tbl_zodiac_sign_raasi WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }
    
    public function getStarSignById($id){
         $sql = "SELECT * FROM tbl_star_sign WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }
    
    public function getMotherTongueById($id){
         $sql = "SELECT * FROM tbl_mother_tongue WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }
    
    public function getDrinkingStatus($val){
         // Yes, No, Occasionally
         if($val=="Yes"){
             $status="Drinking";
             $imgName="drink_icon.jpg";
         }elseif($val=="Occasionally"){
             $status="Drink Occasionally";
             $imgName="drink_icon.jpg";
         }else{
             $status="Does`nt Drink";
             $imgName="dosenotdrink_icon.jpg";
         }
         return array('status'=>$status,'imgName'=>$imgName);
    }
    
    public function getSmokingStatus($val){
        // Yes, No, Occasionally
         if($val=="Yes"){
             $status="Smoking";
             $imgName="smoke_icon.jpg";
         }elseif($val=="Occasionally"){
             $status="Smoke Occasionally";
             $imgName="smoke_icon.jpg";
         }else{
             $status="Does`nt Smoke";
             $imgName="dosenotsmoke_icon.jpg";
         }
         return array('status'=>$status,'imgName'=>$imgName);
    }
    
    public function getVegetarianStatus($val){
        // Veg, Non-Veg, Occasionally Non-Veg ,Eggetarian, Jain, Vegan
         if($val=="Non-Veg"){
             $status="Non-Vegetarian";
             $imgName="non-vegetarian_icon.jpg";
         }elseif($val=="Occasionally Non-Veg"){
             $status="Occasionally Non-Vegetarian";
             $imgName="non-vegetarian_icon.jpg";
         }elseif($val=="Eggetarian"){
             $status="Eggetarian";
             $imgName="egg_icon.jpg";
         }else{
             $status="Vegetarian";
             $imgName="bhesitarian.jpg";
         }
         return array('status'=>$status,'imgName'=>$imgName);
    }
    
    public function getActiveStatusById($id){
        $sql = "SELECT * FROM tbl_user WHERE id=$id";
        $row = $this->model->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        $res=$row['is_active'];
        if($res==1)
        $status='Active';
        else
        $status='De-Active';
        return $status;
    }
    
    public function getModifiedEmail($email) {
        $email  =   explode('@',$email);
        $email  =   substr($email[0], 0, 3).'xxxxxxxx@'.$email[1];
        return $email;
    }
    
    public function getModifiedMobileNo($mobile) {
        $mobile=substr($mobile, 0, 2).'xxxxx'.substr($mobile, -3);
        return $mobile;
    }
    
     public function getFamilyInfoByIdMatrimonial($user_id, $relation_id){
        
        $sql = new Sql($this->model);
        $select = $sql->select('tbl_family_info_matrimonial');
        $select->where(array('user_id = ?' => $user_id, 'relation_id = ?' => $relation_id));
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        return $result->current();
        
    }
}
