<?php

namespace Application\Controller;

use Zend\Db\Adapter\Adapter;
use Zend\View\Model\ViewModel;
use Application\Service\MembershipServiceInterface;
use Zend\View\Model\JsonModel;

class MembershipController extends AppController {

    protected $postService;

    public function __construct(MembershipServiceInterface $postService) {
        $this->postService = $postService;
    }

    public function indexAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        
        $photo=  $this->getProfilePhoto($user_id);
        //\Zend\Debug\Debug::dump($photo);
        
        $invitation = $this->getReceivedRequestCount($user_id);
        $accepted = $this->getAcceptedRequestCount($user_id);
        $sent = $this->getSentRequestCount($user_id);
        $declineRequest = $this->getDeclineRequestCount($user_id); 
        
        $GroomData = $adapter->query("select 
            tbl_user_info.user_id as uid,
            tbl_city.city_name, 
            tbl_rustagi_branches.branch_name, 
            tbl_user.id,
            tbl_user_info.profile_photo,
            tbl_user_info.name_title_user,
            tbl_user_info.full_name,
            tbl_user_info.age,
            tbl_user_info.height,
            tbl_user_info.city,
            tbl_user_info.address,
            tbl_user_info.about_yourself_partner_family,
            tbl_user_gallery.image_path, 
           
            tbl_profession.profession 
            FROM tbl_user 
		 INNER JOIN tbl_user_info on tbl_user_info.user_id=tbl_user.id
		
                 INNER JOIN tbl_profession on tbl_user_info.profession=tbl_profession.id
                 LEFT JOIN tbl_user_gallery ON tbl_user_info.user_id=tbl_user_gallery.user_id AND tbl_user_gallery.profile_pic=1
	         inner join tbl_user_roles on tbl_user_info.user_id=tbl_user_roles.user_id 
		 inner join tbl_rustagi_branches on tbl_user_info.branch_ids=tbl_rustagi_branches.branch_id 
		 inner join tbl_city on tbl_user_info.city=tbl_city.id 
		 where tbl_user_roles.IsMember='1'  ORDER BY tbl_user.id DESC", Adapter::QUERY_MODE_EXECUTE);

        $filters_data = $this->sidebarFilters();

        return new ViewModel(array(
            "GroomData" => $GroomData,
            "filters_data" => $filters_data,
            'invitation' => $invitation,
            'accepted' => $accepted,
            'sent' => $sent,
            'declineRequest' => $declineRequest,
            'photo' => $photo,
            
            
        ));
    }

    public function profileViewAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $userId = $userSession->offsetGet('id');
        $userTypeId=$userSession->offsetGet('user_type_id');
        $user_id = intval($this->params()->fromQuery('member_id'));
        $userservice = new \Application\Mapper\UserDbSqlMapper($adapter);
        $familyInfo = $userservice->getFamilyInfoById($user_id);
        
        
        $invitation = $this->getReceivedRequestCount($userId);
        $accepted = $this->getAcceptedRequestCount($userId);
        $sent = $this->getSentRequestCount($userId);
        $declineRequest = $this->getDeclineRequestCount($userId); 
        
        
        $commanData = array();
        $commanData["officecountry"] = '';
        $commanData["officestate"] = '';
        $commanData["officecity"] = '';
        if ($user_id != '') {
            $UserData = $adapter->query("select tbl_user.email,tbl_user.mobile_no,tbl_user_info.*,tbl_height.*,
		 tbl_profession.profession,tbl_city.city_name as city,tbl_state.state_name as state,tbl_country.country_name as country,
		 tbl_education_field.education_field,tbl_education_level.education_level,tbl_religion.religion_name as religion,tbl_gothra_gothram.gothra_name as caste,tbl_designation.designation,tbl_annual_income.annual_income FROM tbl_user
		INNER JOIN tbl_user_info on tbl_user.id=tbl_user_info.user_id
		
		INNER JOIN tbl_profession on tbl_user_info.profession=tbl_profession.id
		LEFT JOIN tbl_city on tbl_user_info.city=tbl_city.id
		left join tbl_height on tbl_user_info.height=tbl_height.id
		LEFT JOIN tbl_state on tbl_user_info.state=tbl_state.id
		LEFT JOIN tbl_country on tbl_user_info.country=tbl_country.id
		LEFT JOIN tbl_education_field on tbl_user_info.education_field=tbl_education_field.id
		LEFT JOIN tbl_education_level on tbl_user_info.education_level=tbl_education_level.id
		LEFT JOIN tbl_religion on tbl_user_info.religion=tbl_religion.id
		LEFT JOIN tbl_gothra_gothram on tbl_user_info.gothra_gothram=tbl_gothra_gothram.id
		LEFT JOIN tbl_designation on tbl_user_info.designation=tbl_designation.id
		LEFT JOIN tbl_annual_income on tbl_user_info.annual_income=tbl_annual_income.id
		WHERE tbl_user.id='$user_id' AND tbl_user_info.user_id='$user_id'", Adapter::QUERY_MODE_EXECUTE);
            $records = array();
            foreach ($UserData as $result) {
                $records[] = $result;
            }
            foreach ($records as $userinfo) {
                $office_country = $userinfo->office_country;
                $office_state = $userinfo->office_state;
                $office_city = $userinfo->office_city;
                if ($office_country != '') {
                    $countryName = $this->getOfficialData('tbl_country', $office_country, 'country_name');
                    $commanData["officecountry"] = $countryName;
                }
                if ($office_state != '') {
                    $stateName = $this->getOfficialData('tbl_state', $office_state, 'state_name');
                    $commanData["officestate"] = $stateName;
                }
                if ($office_city != '') {
                    $cityName = $this->getOfficialData('tbl_city', $office_city, 'city_name');
                    $commanData["officecity"] = $cityName;
                }
            }

        
        } else {
            $UserData = array();
        }
        
        $filters_data = $this->sidebarFilters();
// new coding
        $data = $adapter->query("select * from tbl_user_gallery where user_id='$user_id' ORDER BY id DESC limit 6", Adapter::QUERY_MODE_EXECUTE)->toArray();

        foreach ($data as $P_data) {
            foreach ($P_data as $key => $value) {

                if ($key == "image_path")
                    $Pphotos[] = $value;
            }
        }
//Family data 
        foreach ($familyInfo->brotherData as $brothres) {

            $ids[] = $brothres['user_id'];
        }
        foreach ($familyInfo->sisterData as $sisters) {

            $ids[] = $sisters['user_id'];
        }
        $ids[] = $familyInfo->familyInfoArray['father_id'];
        if($familyInfo->familyInfoArray['mother_id']=null){
            $ids[] = $familyInfo->familyInfoArray['mother_id'];
        }
        //$ids[] = $familyInfo->familyInfoArray['mother_id'];
        //$errors = array_filter($ids);
        //\Zend\Debug\Debug::dump($ids);

//if (!empty($errors)) {
        if (!empty($errors)) {
        $Fdata = $adapter->query("select * from tbl_user_gallery where user_id IN (" . implode(',', $ids) . ") ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
//}else{
    //$Fphotos=array();
//}
        foreach ($Fdata as $F_data) {
            $Fphotos[] = $F_data['image_path'];
        }
        shuffle($Fphotos);
        }
        shuffle($Pphotos);
        
        
        $data_gallery = $adapter->query("select * from tbl_user_gallery where user_id='$user_id' ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
        
        if($userId!=""){
        $acceptedMember = $this->getAcceptedInvitationList($userId);  
        $preferredMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'preferredMembers']);
        $selectedMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'selectedMembers']);
        }
        
        return new ViewModel(array("userinfo" => $records,
            "officeData" => $commanData,
            "filters_data" => $filters_data,
            "Pphotos" => $Pphotos,
            "F_photos" => $Fphotos,
            "gallery_data" => $data_gallery,
            'userSummary' => $userservice->userSummaryById($user_id),
            'familyInfo' => $familyInfo,
            'acceptedMember' => $acceptedMember,
            'selectedMemberInfo' => $selectedMemberInfo,
             'invitation' => $invitation,
            'accepted' => $accepted,
            'sent' => $sent,
            'declineRequest' => $declineRequest,
            'preferredMemberInfo' => $preferredMemberInfo,
            ));
    }

    public function communityMembersAction() {
        return new ViewModel();
    }
    public function sendRequestAction(){ 
            $msg=['request'=>'not Valid', 'status'=>302, 'error'=>'data not saved'];
            $request=$this->getRequest();       
            if($request->isPost()){
              $userId=$this->authUser()->getUser()->id;  
              $type=$request->getPost('type');
              $sendUserId=$request->getPost('uid');         // var_dump($userId);exit;
              if($this->postService->saveSendRequestMemberInvitation($userId,$type,$sendUserId)){
               $msg=['request'=>'', 'status'=>200, 'error'=>null];   
              }
              return new JsonModel($msg);

            }

        }
    public function filtersAction() {

        if (isset($_POST['range_filter'])) {
            $value = explode("-", $_POST['value']);
            $where = "where tbl_user_roles.IsMember='1' and tui." . $_POST['type'] . " BETWEEN " . $value[0] . " AND " . $value[1] . "";
        } else if ($_POST['type'] == "full_name") {
            $where = "where tbl_user_roles.IsMember='1' and tui." . $_POST['type'] . " LIKE '" . $_POST['value'] . "%'";
        } else {
            $where = "where tbl_user_roles.IsMember='1' and tui." . $_POST['type'] . "='" . $_POST['value'] . "'";
        }

        if ($_POST['type'] == "country") {
            $state_name = $this->getStateTable()->getStateListByCountryCode($_POST['value']);
            $output[] = "<option>---Select---state---</option>";
            foreach ($state_name as $states) {
                $output[] = "<option value=" . $states['id'] . ">" . $states['state_name'] . "</option>";
            }
            $output[] = "</select>";
            echo "<div id='CSCresults' ftyle='state' style='display:none;'>" . join("", $output) . "</div>";
        }

        if ($_POST['type'] == "state") {
            $city_name = $this->getCityTable()->getCityListByStateCode($_POST['value']);
            $output[] = "<option>---Select---city---</option>";
            foreach ($city_name as $cities) {
                $output[] = "<option value=" . $cities['id'] . ">" . $cities['city_name'] . "</option>";
            }
            $output[] = "</select>";
            echo "<div id='CSCresults' ftyle='city' style='display:none;'>" . join("", $output) . "</div>";
        }

        $sql = "select tui.*,tui.user_id as uid,tbl_rustagi_branches.branch_name,tbl_user_roles.*,tbl_religion.religion_name,tbl_profession.profession,tbl_education_field.education_field,tbl_city.city_name,tbl_height.height,tbl_state.state_name,tbl_country.country_name,tbl_education_level.education_level from tbl_user_info as tui 
			inner join tbl_profession on tui.profession=tbl_profession.id 
			left join tbl_religion on tui.religion=tbl_religion.id 
			left join tbl_education_field on tui.education_field=tbl_education_field.id 
			left join tbl_city on tui.city=tbl_city.id 
			left join tbl_state on tui.state=tbl_state.id 
			left join tbl_country on tui.country=tbl_country.id 
			left join tbl_height on tui.height=tbl_height.id 
			left JOIN tbl_education_level on tui.education_level=tbl_education_level.id
			inner join tbl_user_roles on tui.user_id=tbl_user_roles.user_id 
			inner join tbl_rustagi_branches on tui.branch_ids=tbl_rustagi_branches.branch_id 
			 
			" . $where;

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $GroomData = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $view = new ViewModel(array('GroomData' => $GroomData));
        $view->setTerminal(true);
        return $view;
    }

    public function sidebarFilters() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $filters_array = array("country" => "tbl_country", "profession" => "tbl_profession",
            "city" => "tbl_city", "state" => "tbl_state",
            "education_level" => "tbl_education_field",
            "designation" => "tbl_designation", "height" => "tbl_height");

        foreach ($filters_array as $key => $table) {
            $filters_data[$key] = $adapter->query("select * from " . $table . "", Adapter::QUERY_MODE_EXECUTE);
        }
        return $filters_data;
    }

    public function membershipfiltersAction() {
        
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        //$user_id = intval($this->params()->fromQuery('member_id'));
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        //AND tui.user_id!=$user_id;

        //$type = $_POST['Type'];
        //$where = "WHERE 1 ";
//        if ($type == "Latest") {
//            $where = "AND tbl_user_roles.IsMember='1' order by tui.created_date DESC limit 20";
//        } else if ($type == "IsExecutive") {
//            $where = "AND tbl_user_roles." . $_POST['Type'] . "='1' order by tui.id DESC ";
//        } else {
//            $where = "AND (tbl_user_roles.IsMember='1' and tui." . $_POST['Type'] . ">60)";
//        }

        $where = "";

        if (isset($_POST['Country_name'])) {

            $where.=" AND tui.country=" . $_POST['Country_name'];
        }
        if (isset($_POST['State_name'])) {

            $where.=" AND tui.state=" . $_POST['State_name'];
        }
        if (isset($_POST['City_name'])) {

            $where.=" AND tui.city=" . $_POST['City_name'];
        }
        if ($_POST['Zip_pin_code'] != '') {
            $where.=" AND tui.zip_pin_code='" . $_POST['Zip_pin_code'] . "'";
        }
        if ($_POST['Phone_no'] != '') {
            $where.=" AND tui.phone_no='" . $_POST['Phone_no'] . "'";
        }
        if ($_POST['Full_name'] != '') {
            $where.=" AND tui.full_name='" . $_POST['Full_name'] . "'";
        }
        if ($_POST['Office_email'] != '') {
            $where.=" AND tui.office_email='" . $_POST['Office_email'] . "'";
        }
        if ($_POST['Ref_no'] != '') {
            $where.=" AND tui.ref_no='" . $_POST['Ref_no'] . "'";
        }

        if ($_POST['ageMin'] != '' && $_POST['ageMax'] != '') {
            $where.=" AND age BETWEEN '" . $_POST['ageMin'] . "' AND '" . $_POST['ageMax'] . "'";
        }

        if ($_POST['annualIncomeMin'] != '' && $_POST['annualIncomeMax'] != '') {
            $where.=" AND annual_income BETWEEN '" . $_POST['annualIncomeMin'] . "' AND '" . $_POST['annualIncomeMax'] . "'";
        }

        if (isset($_POST['Height'])) {
            $where.=" AND tui.height=" . $_POST['Height'];
        }
        if (isset($_POST['Profession'])) {
            $where.=" AND tui.profession=" . $_POST['Profession'];
        }
        if (isset($_POST['Education_field'])) {
            $where.=" AND tui.education_field=" . $_POST['Education_field'];
        }
        if (isset($_POST['Designation'])) {
            $where.=" AND tui.designation=" . $_POST['Designation'];
        }
        if (isset($_POST['Marital_status'])) {
            $where.=" AND tui.marital_status='" . $_POST['Marital_status'] . "'";
        }
        if (isset($_POST['Manglik_dossam'])) {
            $where.=" AND tui.manglik_dossam='" . $_POST['Manglik_dossam'] . "'";
        }

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $sql = "SELECT tui.*,tui.user_id as uid,
                       tbl_user_roles.*,
                       tbl_rustagi_branches.branch_name,
                      
                       tbl_religion.religion_name,
                       tbl_profession.profession,
                       tbl_education_field.education_field,
                       tbl_city.city_name,
                       tbl_height.height,tbl_state.state_name,
                       tbl_country.country_name,
                       tbl_education_level.education_level,
                       tbl_user_gallery.image_path,
                       tbl_user.id
                       FROM tbl_user_info as tui 
			INNER JOIN tbl_profession on tui.profession=tbl_profession.id 
			LEFT JOIN tbl_religion on tui.religion=tbl_religion.id 
			LEFT JOIN tbl_education_field on tui.education_field=tbl_education_field.id 
			LEFT JOIN tbl_city on tui.city=tbl_city.id 
			LEFT JOIN tbl_state on tui.state=tbl_state.id 
			LEFT JOIN tbl_country on tui.country=tbl_country.id 
			LEFT JOIN tbl_height on tui.height=tbl_height.id 
			LEFT JOIN tbl_education_level on tui.education_level=tbl_education_level.id
                        LEFT JOIN tbl_user_gallery ON tui.user_id=tbl_user_gallery.user_id AND tbl_user_gallery.profile_pic=1
			INNER JOIN tbl_user_roles on tui.user_id=tbl_user_roles.user_id 
			INNER JOIN tbl_rustagi_branches on tui.branch_ids=tbl_rustagi_branches.branch_id 
			 
                        INNER JOIN tbl_user on tui.user_id=tbl_user.id
                        WHERE tbl_user_roles.IsMember='1' " . $where . " ORDER BY tbl_user.id DESC";

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $Members = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $view = new ViewModel(array('memberData' => $Members));
        // $view->setTemplate('application/membership/filters');
        $view->setTerminal(true);
        return $view;
    }

    public function sortmembersAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        // $select=$this->getServiceLocator()->get('Zend\Db\sql\Expression');
        $type = $_POST['Type'];

        if ($type == "Latest") {

            $where = "where tbl_user_roles.IsMember='1' order by tui.created_date DESC limit 20";
        } else if ($type == "IsExecutive") {

            $where = "where tbl_user_roles." . $_POST['Type'] . "='1' order by tui.id DESC ";
        } else {
            $where = "where (tbl_user_roles.IsMember='1' and tui." . $_POST['Type'] . ">60)";
        }

        $sql = "select tui.*,tui.user_id as uid,tbl_user_roles.*,
            tbl_rustagi_branches.branch_name,tbl_religion.religion_name,
            tbl_profession.profession,tbl_education_field.education_field,
            tbl_city.city_name,tbl_height.height,tbl_state.state_name,tbl_country.country_name,
            tbl_user_gallery.image_path,
            tbl_education_level.education_level 
               FROM tbl_user_info as tui 
			inner join tbl_profession on tui.profession=tbl_profession.id 
			left join tbl_religion on tui.religion=tbl_religion.id 
			left join tbl_education_field on tui.education_field=tbl_education_field.id 
			left join tbl_city on tui.city=tbl_city.id 
			left join tbl_state on tui.state=tbl_state.id 
			left join tbl_country on tui.country=tbl_country.id 
			left join tbl_height on tui.height=tbl_height.id 
			left JOIN tbl_education_level on tui.education_level=tbl_education_level.id
                        LEFT JOIN tbl_user_gallery ON tui.user_id=tbl_user_gallery.user_id AND tbl_user_gallery.profile_pic=1
			inner join tbl_user_roles on tui.user_id=tbl_user_roles.user_id 
			inner join tbl_rustagi_branches on tui.branch_ids=tbl_rustagi_branches.branch_id  " . $where;
			

        // echo $sql;	 
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $Members = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        /*         * ****Return to View Model******** */
        $view = new ViewModel(array('memberData' => $Members));
        $view->setTemplate('application/membership/membershipfilters');
        $view->setTerminal(true);
        return $view;

        exit();
    }

}

?>
