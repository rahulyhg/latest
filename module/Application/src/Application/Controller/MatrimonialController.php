<?php

namespace Application\Controller;

use Application\Mapper\UserDbSqlMapper;
use Application\Service\MatrimonialServiceInterface;
use Application\Service\ProfileServiceInterface;
use Application\Service\UserServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Debug\Debug;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class MatrimonialController extends AppController {
    
    protected $metrimonialService;
    protected $profileService;
    protected $userService;
    protected $commonService;

    public function __construct(MatrimonialServiceInterface $metrimonialService,
            ProfileServiceInterface $profileService, CommonServiceInterface $commonService, UserServiceInterface $userService) {
        $this->metrimonialService = $metrimonialService;
        $this->profileService = $profileService;
        $this->userService = $userService;
        $this->commonService = $commonService;
        
    }

    public function indexAction() {
            //\Zend\Debug\Debug::dump($this->metrimonialService->findAllPosts());
            
            
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /*         * ****Fetch Groom Data******** */
        $statement = $adapter->query("SELECT tui.*, 
             tu.email, 
             tu.mobile_no, 
             tui.user_id as uid,
             tp.*, tp.profession as profession_name, 
             tuam.*,
             tuem.*,
             tel.*,
             tup.*,
             td.*,
             th.height as height_name,
             tai.*,
             tr.*,
             tc.*,
             tcountry.country_name,
             tstate.state_name,
             tcity.city_name,
             tef.*,
             tinvitation.*,
             TIMESTAMPDIFF(YEAR, tui.dob, CURDATE()) AS age,
             tugm.*
             FROM tbl_user_info_matrimonial as tui
               LEFT JOIN tbl_user_matrimonial as tu ON tui.user_id=tu.id
               LEFT JOIN tbl_user_professional_matrimonial as tup ON tui.user_id=tup.user_id
               LEFT JOIN tbl_profession as tp ON tup.profession=tp.id
               LEFT JOIN tbl_designation as td ON td.id=tup.designation
               LEFT JOIN tbl_annual_income as tai ON tai.id=tup.annual_income
               LEFT JOIN tbl_religion as tr ON tr.id=tui.religion
               LEFT JOIN tbl_height as th ON th.id=tui.height
               LEFT JOIN tbl_caste as tc ON tc.id=tui.caste
               LEFT JOIN tbl_user_education_matrimonial as tuem ON tuem.user_id=tui.user_id
               LEFT JOIN tbl_education_level as tel ON tel.id=tuem.education_level_id
               LEFT JOIN tbl_education_field as tef ON tef.id=tuem.education_field_id
               LEFT JOIN tbl_user_gallery_matrimonial as tugm ON tugm.user_id=tui.user_id AND tugm.user_type='U' AND 
               tugm.image_type=1
               LEFT JOIN tbl_user_address_matrimonial as tuam ON tuam.user_id=tui.user_id
               LEFT JOIN tbl_country as tcountry ON tcountry.id=tuam.country 
               LEFT JOIN tbl_state as tstate ON tstate.id=tuam.state 
               LEFT JOIN tbl_city as tcity ON tcity.id=tuam.city 
               LEFT JOIN tbl_matrimonial_invitation as tinvitation ON tinvitation.user_id=tu.id
               WHERE tui.gender=:gender Group by(tugm.user_id) ORDER BY tugm.id DESC");
               $parameters = array(
                  'gender' => 'Male'
              );
        $result = $statement->execute($parameters);
        $resultSet=new ResultSet();
        $GroomData=$resultSet->initialize($result)->toArray();
        //\Zend\Debug\Debug::dump($GroomData);exit;

        /*         * ****Fetch Brides Data******** */
        $statement = $adapter->query("SELECT tui.*, 
             tu.email, 
             tu.mobile_no, 
             tui.user_id as uid,
             tp.*, tp.profession as profession_name, 
             tuam.*,
             tuem.*,
             tel.*,
             tup.*,
             td.*,
             th.height as height_name,
             tai.*,
             tr.*,
             tc.*,
             tcountry.country_name,
             tstate.state_name,
             tcity.city_name,
             tinvitation.*,
             tef.*,
             TIMESTAMPDIFF(YEAR, tui.dob, CURDATE()) AS age,
             tugm.*
             FROM tbl_user_info_matrimonial as tui
               LEFT JOIN tbl_user_matrimonial as tu ON tui.user_id=tu.id
               LEFT JOIN tbl_user_professional_matrimonial as tup ON tui.user_id=tup.user_id
               LEFT JOIN tbl_profession as tp ON tup.profession=tp.id
               LEFT JOIN tbl_designation as td ON td.id=tup.designation
               LEFT JOIN tbl_annual_income as tai ON tai.id=tup.annual_income
               LEFT JOIN tbl_religion as tr ON tr.id=tui.religion
               LEFT JOIN tbl_height as th ON th.id=tui.height
               LEFT JOIN tbl_caste as tc ON tc.id=tui.caste
               LEFT JOIN tbl_user_education_matrimonial as tuem ON tuem.user_id=tui.user_id
               LEFT JOIN tbl_education_level as tel ON tel.id=tuem.education_level_id
               LEFT JOIN tbl_education_field as tef ON tef.id=tuem.education_field_id
               LEFT JOIN tbl_user_gallery_matrimonial as tugm ON tugm.user_id=tui.user_id AND tugm.user_type='U' AND 
               tugm.image_type=1
               LEFT JOIN tbl_user_address_matrimonial as tuam ON tuam.user_id=tui.user_id
                LEFT JOIN tbl_country as tcountry ON tcountry.id=tuam.country 
               LEFT JOIN tbl_state as tstate ON tstate.id=tuam.state 
               LEFT JOIN tbl_city as tcity ON tcity.id=tuam.city 
               LEFT JOIN tbl_matrimonial_invitation as tinvitation ON tinvitation.user_id=tu.id
               WHERE tui.gender=:gender Group by(tugm.user_id) ORDER BY tugm.id DESC");
               $parameters = array(
                  'gender' => 'Female'
              );
        $result = $statement->execute($parameters);
        $resultSet=new ResultSet();
        $BridesData=$resultSet->initialize($result)->toArray();
        //\Zend\Debug\Debug::dump($this->authUser()->isLogin());exit;
        
        
        /*         * ****Return to View Model******** */
        $filters_data = $this->sidebarFilters();
        if ($this->authUser()->isLogin()) {
            $sidebarLeft = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarLeftMatrimonial', 'userSummary' => $userSummary]);
            $sidebarRight = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarRightMatrimonial']);
        }

        $viewModel = new ViewModel(array(
            "GroomData" => $GroomData,
            "BridesData" => $BridesData, 
            "filters_data" => $filters_data,
                ));
        if ($this->authUser()->isLogin()) {
            $viewModel->addChild($sidebarLeft, 'sidebarLeft');
            $viewModel->addChild($sidebarRight, 'sidebarRight');
        }
        return $viewModel;
    }

    public function listViewAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $search_for = trim($this->params()->fromQuery('search_for'));
        if ($search_for == 'Female') {
            $type = 'Brides';
        } elseif ($search_for == 'Male') {
            $type = 'Grooms';
        } else {
            $type = 'Matrimonial User';
        }
        /*         * ****Fetch User Data******** */
        if ($search_for != '') {
            $statement = $adapter->query("SELECT tui.*, 
             tu.email, 
             tu.mobile_no, 
             tui.user_id as uid,
             tp.*, tp.profession as profession_name, 
             tuam.*,
             tuem.*,
             tel.*,
             tup.*,
             td.*,
             th.height as height_name,
             tai.*,
             tr.*,
             tc.*,
             tcountry.country_name,
             tstate.state_name,
             tcity.city_name,
             tef.*,
             TIMESTAMPDIFF(YEAR, tui.dob, CURDATE()) AS age,
             tugm.*
             FROM tbl_user_info_matrimonial as tui
               LEFT JOIN tbl_user_matrimonial as tu ON tui.user_id=tu.id
               LEFT JOIN tbl_user_professional_matrimonial as tup ON tui.user_id=tup.user_id
               LEFT JOIN tbl_profession as tp ON tup.profession=tp.id
               LEFT JOIN tbl_designation as td ON td.id=tup.designation
               LEFT JOIN tbl_annual_income as tai ON tai.id=tup.annual_income
               LEFT JOIN tbl_religion as tr ON tr.id=tui.religion
               LEFT JOIN tbl_height as th ON th.id=tui.height
               LEFT JOIN tbl_caste as tc ON tc.id=tui.caste
               LEFT JOIN tbl_user_education_matrimonial as tuem ON tuem.user_id=tui.user_id
               LEFT JOIN tbl_education_level as tel ON tel.id=tuem.education_level_id
               LEFT JOIN tbl_education_field as tef ON tef.id=tuem.education_field_id
               LEFT JOIN tbl_user_gallery_matrimonial as tugm ON tugm.user_id=tui.user_id AND tugm.user_type='U' AND 
               tugm.image_type=1
               LEFT JOIN tbl_user_address_matrimonial as tuam ON tuam.user_id=tui.user_id
                LEFT JOIN tbl_country as tcountry ON tcountry.id=tuam.country 
               LEFT JOIN tbl_state as tstate ON tstate.id=tuam.state 
               LEFT JOIN tbl_city as tcity ON tcity.id=tuam.city 
               WHERE tui.gender=:gender Group by(tugm.user_id) ORDER BY tugm.id DESC");
               $parameters = array(
                  'gender' => $search_for
              );
        $result = $statement->execute($parameters);
        $resultSet=new ResultSet();
        $UserData=$resultSet->initialize($result)->toArray();
        } else {
            $statement = $adapter->query("SELECT tui.*, 
             tu.email, 
             tu.mobile_no, 
             tui.user_id as uid,
             tp.*, tp.profession as profession_name, 
             tuam.*,
             tuem.*,
             tel.*,
             tup.*,
             td.*,
             th.height as height_name,
             tai.*,
             tr.*,
             tc.*,
             tcountry.country_name,
             tstate.state_name,
             tcity.city_name,
             tef.*,
             TIMESTAMPDIFF(YEAR, tui.dob, CURDATE()) AS age,
             tugm.*
             FROM tbl_user_info_matrimonial as tui
               LEFT JOIN tbl_user_matrimonial as tu ON tui.user_id=tu.id
               LEFT JOIN tbl_user_professional_matrimonial as tup ON tui.user_id=tup.user_id
               LEFT JOIN tbl_profession as tp ON tup.profession=tp.id
               LEFT JOIN tbl_designation as td ON td.id=tup.designation
               LEFT JOIN tbl_annual_income as tai ON tai.id=tup.annual_income
               LEFT JOIN tbl_religion as tr ON tr.id=tui.religion
               LEFT JOIN tbl_height as th ON th.id=tui.height
               LEFT JOIN tbl_caste as tc ON tc.id=tui.caste
               LEFT JOIN tbl_user_education_matrimonial as tuem ON tuem.user_id=tui.user_id
               LEFT JOIN tbl_education_level as tel ON tel.id=tuem.education_level_id
               LEFT JOIN tbl_education_field as tef ON tef.id=tuem.education_field_id
               LEFT JOIN tbl_user_gallery_matrimonial as tugm ON tugm.user_id=tui.user_id AND tugm.user_type='U' AND 
               tugm.image_type=1
               LEFT JOIN tbl_user_address_matrimonial as tuam ON tuam.user_id=tui.user_id
                LEFT JOIN tbl_country as tcountry ON tcountry.id=tuam.country 
               LEFT JOIN tbl_state as tstate ON tstate.id=tuam.state 
               LEFT JOIN tbl_city as tcity ON tcity.id=tuam.city 
               WHERE tui.gender='Male' OR tui.gender='Female' Group by(tugm.user_id) ORDER BY tugm.id DESC");
              
        $result = $statement->execute();
        $resultSet=new ResultSet();
        $UserData=$resultSet->initialize($result)->toArray();
        }
        $filters_data = $this->sidebarFilters();
        // print_r($UserData);die;
         if ($this->authUser()->isLogin()) {
            $sidebarLeft = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarLeftMatrimonial', 'userSummary' => $userSummary]);
            $sidebarRight = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarRightMatrimonial']);
        }
        $viewModel= new ViewModel(array("userinfo" => $UserData, "userType" => $type, "filters_data" => $filters_data));
         if($this->authUser()->isLogin()) {
        $viewModel->addChild($sidebarLeft, 'sidebarLeft');
        $viewModel->addChild($sidebarRight, 'sidebarRight');
        }
        return $viewModel;
    }

    public function profileViewAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        //$userSession = $this->getUser()->session();
        //$userId = $userSession->offsetGet('id');
        //$userTypeId=$userSession->offsetGet('user_type_id');

        if(intval($this->params()->fromQuery('groom_id'))){
            $user_id = intval($this->params()->fromQuery('groom_id'));
        }
        if(intval($this->params()->fromQuery('bride_id'))){
            $user_id = intval($this->params()->fromQuery('bride_id'));
        }
       
        //$user_id = $this->params()->fromQuery('matrimony_id');
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        //$user_id = intval($this->params()->fromQuery('member_id'));
        //$userSession = $this->getUser()->session();
        //$user_id = $userSession->offsetGet('id');
        //$ref_no = $userSession->offsetGet('ref_no');
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        //$info = $this->userService->getUserPersonalDetailByIdMatrimonial($user_id);
        //$percentage = $this->userService->ProfileBarMatrimonial($user_id);
        //$pro_per = array($percentage, $this->profileBarTemplate($percentage));
        $brotherData = $this->userService->getBrotherMatrimonial($user_id);
        $fatherData = $this->userService->getFatherMatrimonial($user_id);
        $motherData = $this->userService->getMotherMatrimonial($user_id);
        $sisterData = $this->userService->getSisterMatrimonial($user_id);
        $kidsData = $this->userService->getKidMatrimonial($user_id);
        $spouseData = $this->userService->getSpouseMatrimonial($user_id);
        //Debug::dump($this->userService->userSummaryByIdMatrimonial($user_id));exit;
        $userSummary = $this->userService->userSummaryByIdMatrimonial($user_id);
        //Debug::dump($user_id);exit;
        $sql = "select * from tbl_user_gallery_matrimonial where user_id='$user_id' AND user_type='U' AND image_type='1' ORDER BY id DESC";
        $profile_pic = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
       if ($this->authUser()->isLogin()) {
            $sidebarLeft = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarLeftMatrimonial', 'userSummary' => $userSummary]);
            $sidebarRight = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarRightMatrimonial']);
        }
        
       // Debug::dump($userSummary);exit;
        $filters_data = $this->sidebarFilters();
        $viewModel = new ViewModel(
                array('userSummary' => $userSummary,
            'url' => 'personal-profile',
            'profile_pic' => $profile_pic,
            'user_id' => $user_id,
            'brotherData' => $brotherData,
            'fatherData' => $fatherData,
            'motherData' => $motherData,
            'sisterData' => $sisterData,
            'kidsData' => $kidsData,
            'spouseData' => $spouseData,
            "filters_data" => $filters_data
           )
        );
        //$viewModel->setTemplate('application/profile/view-profile-matrimonial.phtml');
        if($this->authUser()->isLogin()) {
        $viewModel->addChild($sidebarLeft, 'sidebarLeft');
        $viewModel->addChild($sidebarRight, 'sidebarRight');
        }
        return $viewModel;
    }

    public function sidebarFilters() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $filters_array = array("country" => "tbl_country", "profession" => "tbl_profession", "city" => "tbl_city"
            , "state" => "tbl_state", "education_level" => "tbl_education_field", "designation" => "tbl_designation"
            , "height" => "tbl_height");
        foreach ($filters_array as $key => $table) {
            $filters_data[$key] = $adapter->query("select * from " . $table . " WHERE is_active=1", Adapter::QUERY_MODE_EXECUTE);
        }
        return $filters_data;
    }

    public function matrimonyfiltersAction() {
        $where = "";

        if (isset($_POST['Country_name'])) {

            $where.=" AND tuam.country=" . $_POST['Country_name'];
        }
        if (isset($_POST['State_name'])) {

            $where.=" AND tuam.state=" . $_POST['State_name'];
        }
        if (isset($_POST['City_name'])) {

            $where.=" AND tuam.city=" . $_POST['City_name'];
        }
        if ($_POST['Zip_pin_code'] != '') {
            $where.=" AND tuam.pincode='" . $_POST['Zip_pin_code'] . "'";
        }
        if ($_POST['Phone_no'] != '') {
            $where.=" AND tui.phone_no='" . $_POST['Phone_no'] . "'";
        }
        if ($_POST['Full_name'] != '') {
            $where.=" AND tui.full_name='" . $_POST['Full_name'] . "'";
        }
        if ($_POST['Office_email'] != '') {
            $where.=" AND tup.office_email='" . $_POST['Office_email'] . "'";
        }
        if ($_POST['Ref_no'] != '') {
            $where.=" AND tui.ref_no='" . $_POST['Ref_no'] . "'";
        }

        if ($_POST['ageMin'] != '' && $_POST['ageMax'] != '') {
            $where.=" AND TIMESTAMPDIFF(YEAR, tui.dob, CURDATE()) BETWEEN '" . $_POST['ageMin'] . "' AND '" . $_POST['ageMax'] . "'";
        }

//        if ($_POST['annualIncomeMin'] != '' && $_POST['annualIncomeMax'] != '') {
//            $where.=" AND tup.annual_income BETWEEN '" . $_POST['annualIncomeMin'] . "' AND '" . $_POST['annualIncomeMax'] . "'";
//        }

        if (isset($_POST['Height'])) {
            $where.=" AND tui.height=" . $_POST['Height'];
        }
        if (isset($_POST['Profession'])) {
            $where.=" AND tup.profession=" . $_POST['Profession'];
        }
        if (isset($_POST['Education_field'])) {
            $where.=" AND tuem.education_field_id=" . $_POST['Education_field'];
        }
        if (isset($_POST['Designation'])) {
            $where.=" AND tup.designation=" . $_POST['Designation'];
        }
        if (isset($_POST['Marital_status'])) {
            $where.=" AND tui.marital_status='" . $_POST['Marital_status'] . "'";
        }
        if (isset($_POST['Manglik_dossam'])) {
            $where.=" AND tui.manglik_dossam='" . $_POST['Manglik_dossam'] . "'";
        }
        
        $where.=" Group by(tugm.user_id) ORDER BY tugm.id DESC ";


        //echo "<pre>";
        //echo  $where;exit;
        //$Gtype = $_POST['SearchType'];


        if ($_POST['Female'] == 'Female') {
            $sql = "SELECT tui.*, 
             tu.email, 
             tu.mobile_no, 
             tui.user_id as uid,
             tp.*, tp.profession as profession_name, 
             tuam.*,
             tuem.*,
             tel.*,
             tup.*,
             td.*,
             th.height as height_name,
             tai.*,
             tr.*,
             tc.*,
             tcountry.country_name,
             tstate.state_name,
             tcity.city_name,
             tef.*,
             TIMESTAMPDIFF(YEAR, tui.dob, CURDATE()) AS age,
             tugm.*
             FROM tbl_user_info_matrimonial as tui
               LEFT JOIN tbl_user_matrimonial as tu ON tui.user_id=tu.id
               LEFT JOIN tbl_user_professional_matrimonial as tup ON tui.user_id=tup.user_id
               LEFT JOIN tbl_profession as tp ON tup.profession=tp.id
               LEFT JOIN tbl_designation as td ON td.id=tup.designation
               LEFT JOIN tbl_annual_income as tai ON tai.id=tup.annual_income
               LEFT JOIN tbl_religion as tr ON tr.id=tui.religion
               LEFT JOIN tbl_height as th ON th.id=tui.height
               LEFT JOIN tbl_caste as tc ON tc.id=tui.caste
               LEFT JOIN tbl_user_education_matrimonial as tuem ON tuem.user_id=tui.user_id
               LEFT JOIN tbl_education_level as tel ON tel.id=tuem.education_level_id
               LEFT JOIN tbl_education_field as tef ON tef.id=tuem.education_field_id
               LEFT JOIN tbl_user_gallery_matrimonial as tugm ON tugm.user_id=tui.user_id AND tugm.user_type='U' AND 
               tugm.image_type=1
               LEFT JOIN tbl_user_address_matrimonial as tuam ON tuam.user_id=tui.user_id
                LEFT JOIN tbl_country as tcountry ON tcountry.id=tuam.country 
               LEFT JOIN tbl_state as tstate ON tstate.id=tuam.state 
               LEFT JOIN tbl_city as tcity ON tcity.id=tuam.city 
               WHERE tui.gender='".$_POST['Female']."' " . $where;

            //exit;
        }
        if ($_POST['Male'] == 'Male') {
            $sql1 = "SELECT tui.*, 
             tu.email, 
             tu.mobile_no, 
             tui.user_id as uid,
             tp.*, tp.profession as profession_name, 
             tuam.*,
             tuem.*,
             tel.*,
             tup.*,
             td.*,
             th.height as height_name,
             tai.*,
             tr.*,
             tc.*,
             tcountry.country_name,
             tstate.state_name,
             tcity.city_name,
             tef.*,
             TIMESTAMPDIFF(YEAR, tui.dob, CURDATE()) AS age,
             tugm.*
             FROM tbl_user_info_matrimonial as tui
               LEFT JOIN tbl_user_matrimonial as tu ON tui.user_id=tu.id
               LEFT JOIN tbl_user_professional_matrimonial as tup ON tui.user_id=tup.user_id
               LEFT JOIN tbl_profession as tp ON tup.profession=tp.id
               LEFT JOIN tbl_designation as td ON td.id=tup.designation
               LEFT JOIN tbl_annual_income as tai ON tai.id=tup.annual_income
               LEFT JOIN tbl_religion as tr ON tr.id=tui.religion
               LEFT JOIN tbl_height as th ON th.id=tui.height
               LEFT JOIN tbl_caste as tc ON tc.id=tui.caste
               LEFT JOIN tbl_user_education_matrimonial as tuem ON tuem.user_id=tui.user_id
               LEFT JOIN tbl_education_level as tel ON tel.id=tuem.education_level_id
               LEFT JOIN tbl_education_field as tef ON tef.id=tuem.education_field_id
               LEFT JOIN tbl_user_gallery_matrimonial as tugm ON tugm.user_id=tui.user_id AND tugm.user_type='U' AND 
               tugm.image_type=1
               LEFT JOIN tbl_user_address_matrimonial as tuam ON tuam.user_id=tui.user_id
                LEFT JOIN tbl_country as tcountry ON tcountry.id=tuam.country 
               LEFT JOIN tbl_state as tstate ON tstate.id=tuam.state 
               LEFT JOIN tbl_city as tcity ON tcity.id=tuam.city 
               WHERE tui.gender='".$_POST['Male']."' " . $where;
        }


        
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        
        if ($_POST['Female'] == 'Female' && $_POST['Male'] == 'Male') {
            $BridesData = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
            $GroomData = $adapter->query($sql1, Adapter::QUERY_MODE_EXECUTE)->toArray();
            $view = new ViewModel(array('BridesData' => $BridesData, 'GroomData' => $GroomData, "type" => 'both'));
            $view->setTerminal(true);
            return $view;
        } else {
            if ($_POST['Female'] == 'Female') {
                $BridesData = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
                $view = new ViewModel(array('BridesData' => $BridesData, "type" => 'female'));
                $view->setTerminal(true);
                return $view;
            }
            if ($_POST['Male'] == 'Male') {
                $GroomData = $adapter->query($sql1, Adapter::QUERY_MODE_EXECUTE)->toArray();
                $request = $this->getRequest();
                $view = new ViewModel(array('GroomData' => $GroomData, "type" => 'male'));
                $view->setTerminal(true);
                return $view;
            }
        }
    }
    
    public function interestAction(){
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $request=$this->getRequest();
        $post=$request->getPost();
        $sent=$post['uid'];
        $type=$post['type'];
        if($type=="yes"){ $typeNo=1;}
        if($type=="maybe"){ $typeNo=2;}
        if($type=="no"){ $typeNo=3;}
        if($type=='yes'){
        $sql="INSERT INTO tbl_matrimonial_invitation (user_id, sent, type) values ($user_id , $sent, $typeNo)";
        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        }
         if($type=='maybe'){
        $sql="INSERT INTO tbl_matrimonial_invitation (user_id, sent, type) values ($user_id , $sent, $typeNo)";
        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        }
         if($type=='no'){
        $sql="INSERT INTO tbl_matrimonial_invitation (user_id, sent, type) values ($user_id , $sent, $typeNo)";
        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        }
        //$result=array('djdhjdj','hhdhdhd');
        return new JsonModel(array('result'=>''));

    }
    
    public function sendRequestAction(){ 
        $msg=['request'=>'not Valid', 'status'=>302, 'error'=>'data not saved'];
        $request=$this->getRequest();       
        if($request->isPost()){
          $userId=$this->authUser()->getUser()->id;  
          $type=$request->getPost('type');
          $sendUserId=$request->getPost('uid');         // var_dump($userId);exit;
          if($this->metrimonialService->saveSendRequestMatriMonialInvitation($userId,$type,$sendUserId)){
           $msg=['request'=>'', 'status'=>200, 'error'=>null];   
          }
          return new JsonModel($msg);
            
        }
        
    }


    public function showallimagesAction() {

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $session = new Container('user');
        $user_id = $session->offsetGet('id');
        $ref_no = $session->offsetGet('ref_no');
        $this->userService=new UserDbSqlMapper($adapter);
        $familyInfo = $this->userService->getFamilyInfoById($user_id);

        //print_r($familyInfo);
        //exit;




        //print_r($ids);
        //$ids['sister'] = $brothres['user_id'];
//        foreach ($familyInfo->brotherData as $brothres) {
//            print_r($brothres);
//            $ids['father'] = $brothres['user_id'];
//        }
        //exit;
        if ($_POST['type'] == "Personal") {
            $data = $adapter->query("select * from tbl_user_gallery where user_id='$user_id' OR ref_no='$ref_no' ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE)->toArray();
            foreach ($data as $P_data) {
                foreach ($P_data as $key => $value) {

                    if ($key == "image_path")
                        $photos[] = array($value, $P_data['id']);
                }
            }

//for testing purpose
//    		$action = $server_url = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost()."/rustagi/account/delselected";
//for live purpose
            //$action = $server_url = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost() . "/account/delselected";
            //$action = $this->url()->fromRoute('profile', array('action' => 'delselected'));
            //$output[] = "<input class='btn btn-default' type='button' style='float:right;' onclick='delselected(&quot;showallimages&quot;,&quot;$action&quot;,delselectedresults)' value='delete selected'><br><br>";

            foreach ($photos as $key => $value) {
                $title = (!(int) $value[1]) ? ucwords(str_replace("_", " ", $value[1])) : "";
                //echo '<pre>';
                //print_r($value);

                $output[] = '<div class="col-sm-3"><img src="/uploads/' . $value[0] . '" onmouseover="showchck(this)" onmouseout="hidechck(this)" onclick="selectchk(this)" class="moreimgthambdeleat imghover"/>

   
    <div class="familytitles">' . $title . '</div>
    </div>';
            }
            $output[] = "<input type='hidden' name='type' value='" . $_POST['type'] . "'><input type='hidden' name='uid' value='" . $user_id . "'>";
            // echo join("",$output);
        } else {

//print_r(implode(',', $ids));
            //exit;
            //$action = $server_url = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost() . "/account/delselected";
            //$action = $this->url()->fromRoute('profile', array('action' => 'delselected'));
            //echo $action;
            //$action='dcvdvfdb';
            //$output[] = "<input class='btn btn-default' type='button' style='float:right;' onclick='delselected(&quot;showallimages&quot;,&quot;$action&quot;,delselectedresults)' value='delete selected'><br><br>";
            foreach ($familyInfo->brotherData as $brothres) {

                $idsBrothers[] = $brothres['user_id'];
            }
            $Fdata = $adapter->query("select * from tbl_user_gallery where user_id IN (" . implode(',', $idsBrothers) . ") ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
            foreach ($Fdata as $F_data) {
                //print_r($F_data);
                $title = 'Brother photo';
                $Name = '';

                $output[] = '<div class="col-sm-3"><img src="/uploads/' . $F_data['image_path'] . '" onmouseover="showchck(this)" onmouseout="hidechck(this)" onclick="selectchk(this)" class="moreimgthambdeleat imghover"/>
                               
                                <div class="familytitles">' . $title . '</div>
                                <div class="familytitles">' . $Name . '</div>
                            </div>';
            }
            foreach ($familyInfo->sisterData as $sisters) {

                $idsSisters[] = $sisters['user_id'];
            }
            $Fdata = $adapter->query("select * from tbl_user_gallery where user_id IN (" . implode(',', $idsSisters) . ") ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
            foreach ($Fdata as $F_data) {
                //print_r($F_data);
                $title = 'Sister photo';
                $Name = '';

                $output[] = '<div class="col-sm-3"><img src="/uploads/' . $F_data['image_path'] . '" onmouseover="showchck(this)" onmouseout="hidechck(this)" onclick="selectchk(this)" class="moreimgthambdeleat imghover"/>
                               
                                <div class="familytitles">' . $title . '</div>
                                <div class="familytitles">' . $Name . '</div>
                            </div>';
            }
            $father_id = $familyInfo->familyInfoArray['father_id'];
            $Fdata = $adapter->query("select * from tbl_user_gallery where user_id='$father_id' ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
            foreach ($Fdata as $F_data) {
                //print_r($F_data);
                $title = 'Father photo';
                $Name = '';

                $output[] = '<div class="col-sm-3"><img src="/uploads/' . $F_data['image_path'] . '" onmouseover="showchck(this)" onmouseout="hidechck(this)" onclick="selectchk(this)" class="moreimgthambdeleat imghover"/>
                             
                                <div class="familytitles">' . $title . '</div>
                                <div class="familytitles">' . $Name . '</div>
                            </div>';
            }
            $mother_id = $familyInfo->familyInfoArray['mother_id'];
            $Fdata = $adapter->query("select * from tbl_user_gallery where user_id='$mother_id' ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
            foreach ($Fdata as $F_data) {
                //print_r($F_data);
                $title = 'Mother photo';
                $Name = '';

                $output[] = '<div class="col-sm-3"><img src="/uploads/' . $F_data['image_path'] . '" onmouseover="showchck(this)" onmouseout="hidechck(this)" onclick="selectchk(this)" class="moreimgthambdeleat imghover"/>
                               
                                <div class="familytitles">' . $title . '</div>
                                <div class="familytitles">' . $Name . '</div>
                            </div>';
            }



            $output[] = "<input type='hidden' name='type' value='" . $_POST['type'] . "'><input type='hidden' name='uid' value='" . $user_id . "'>";
        }

        echo join("", $output);
        // echo "<pre>";
        // print_r($photos);
        die;
    }
    
    

}

?>
