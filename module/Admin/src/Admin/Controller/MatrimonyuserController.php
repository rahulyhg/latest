<?php

namespace Admin\Controller;

use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Admin\Form\PersonolDetailForm;
use Admin\Form\PersonolDetailMatrimonialForm;
use Admin\Form\EducationAndCareerFormMatrimonial;
use Admin\Form\EducationAndCareerForm;
use Admin\Form\LocationDetailForm;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Admin\Model\Entity\Userinfo;
//use Common\Service\CommonServiceInterface;
// use Admin\Model\Entity\Newscategories;
// use Admin\Form\NewsForm;
// use Admin\Form\NewscategoryForm;
// use Admin\Form\NewsFilter;
// use Admin\Form\NewscategoryFilter;

class MatrimonyuserController extends AppController
{
    protected $commonService;
    protected $adminService;
    //protected $commonService;

    public function __construct(CommonServiceInterface $commonService, AdminServiceInterface $adminService) {
        $this->commonService = $commonService;
        $this->adminService = $adminService;
        //$this->commonService = $commonService;
    }
    
    public function matrimonyuserindexAction()
    {           
  // echo $this->getRequest()->getUri()->getHost();die;

        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /******Fetch all Members Data from db*********/             
        /*$userinfos = $adapter->query("select tui.*,tbl_height.*,tbl_profession.*,tbl_country.*,tbl_state.*,
        tbl_city.*,tbl_caste.*,tbl_religion.*,tbl_star_sign.*,tbl_zodiac_sign_raasi.*,tbl_gothra_gothram.*,tbl_user_type.*,    
        tbl_education_field.*,tbl_education_level.*,tbl_designation.*,tbl_user.*,
        tbl_user.is_active as userstatus from tbl_user_info tui LEFT JOIN tbl_user on 
        tui.user_id=tbl_user.id  
        LEFT JOIN tbl_country on tui.country=tbl_country.id 
        LEFT JOIN tbl_state on 
        tui.state=tbl_state.id LEFT JOIN tbl_city on 
        tui.city=tbl_city.id LEFT JOIN tbl_profession on 
        tui.profession=tbl_profession.id  LEFT JOIN tbl_education_field on 
        tui.education_field=tbl_education_field.id LEFT JOIN tbl_height on 
        tui.height=tbl_height.id LEFT JOIN tbl_user_type on 
        tui.user_type_id=tbl_user_type.id LEFT JOIN tbl_caste on 
        tui.caste=tbl_caste.id LEFT JOIN tbl_religion on 
        tui.religion=tbl_religion.id LEFT JOIN tbl_star_sign on 
        tui.star_sign=tbl_star_sign.id LEFT JOIN tbl_zodiac_sign_raasi on 
        tui.zodiac_sign_raasi=tbl_zodiac_sign_raasi.id LEFT JOIN tbl_gothra_gothram on 
        tui.gothra_gothram=tbl_gothra_gothram.id LEFT JOIN tbl_education_level on 
        tui.education_level=tbl_education_level.id LEFT JOIN tbl_designation on 
        tui.designation=tbl_designation.id
        where tui.user_type_id='2' ORDER BY tui.id DESC", Adapter::QUERY_MODE_EXECUTE);*/
         
        /*$userinfos = $adapter->query("select tui.*,tbl_user_address_matrimonial.*, tbl_height.*,tbl_profession.*,tbl_country.*,tbl_state.*,
        tbl_city.*,tbl_caste.*,tbl_religion.*,tbl_star_sign.*,tbl_zodiac_sign_raasi.*,tbl_gothra_gothram.*,tbl_user_type.*,    
        tbl_education_field.*,tbl_education_level.*,tbl_designation.*,tbl_user_matrimonial.*,
        tbl_user_matrimonial.is_active as userstatus from tbl_user_info_matrimonial tui LEFT JOIN tbl_user_matrimonial on 
        tui.user_id=tbl_user_matrimonial.id  
        LEFT JOIN tbl_country on tbl_user_address_matrimonial.country=tbl_country.id 
        LEFT JOIN tbl_state on 
        tbl_user_address_matrimonial.state=tbl_state.id LEFT JOIN tbl_city on 
        tbl_user_address_matrimonial.city=tbl_city.id LEFT JOIN tbl_profession on 
        tbl_user_professional_matrimonial.profession=tbl_profession.id  LEFT JOIN tbl_education_field on 
        tbl_user_education_matrimonial.education_field_id=tbl_education_field.id LEFT JOIN tbl_height on 
        tui.height=tbl_height.id LEFT JOIN tbl_user_type on 
        tui.user_type_id=tbl_user_type.id LEFT JOIN tbl_caste on 
        tui.caste=tbl_caste.id LEFT JOIN tbl_religion on 
        tui.religion=tbl_religion.id LEFT JOIN tbl_star_sign on 
        tui.star_sign=tbl_star_sign.id LEFT JOIN tbl_zodiac_sign_raasi on 
        tui.zodiac_sign_raasi=tbl_zodiac_sign_raasi.id LEFT JOIN tbl_gothra_gothram on 
        tui.gothra_gothram=tbl_gothra_gothram.id LEFT JOIN tbl_education_level on 
        tbl_user_education_matrimonial.education_level_id=tbl_education_level.id LEFT JOIN tbl_designation on 
        tbl_user_professional_matrimonial.designation=tbl_designation.id
        where tui.user_type_id='2' ORDER BY tui.id DESC", Adapter::QUERY_MODE_EXECUTE);*/
        
        $userinfos = $adapter->query("select tbl_user_matrimonial.*, tui.*,tui.marital_status as user_marital_status,tbl_user_address_matrimonial.*, tbl_user_address_matrimonial.status as addr_status, tbl_country.*, tbl_state.*, tbl_city.*, tbl_profession.*,tbl_profession.profession as profession_name,tbl_education_field.*,tbl_height.*, tbl_caste.*, tbl_religion.*, tbl_star_sign.*,tbl_family_info_matrimonial.*,tbl_family_info_matrimonial.status as family_status,
        tbl_zodiac_sign_raasi.*, tbl_user_professional_matrimonial.*, tbl_gothra_gothram.*,tbl_education_level.*, tbl_designation.*, gm.image_name, 
        tbl_user_matrimonial.is_active as userstatus, tui.dob as me_dob, mt.mother_tongue from tbl_user_info_matrimonial tui LEFT JOIN tbl_user_matrimonial on 
        tui.user_id=tbl_user_matrimonial.id  
                LEFT JOIN tbl_mother_tongue as mt on tui.mother_tongue_id=mt.id
		LEFT JOIN tbl_family_info_matrimonial on tbl_user_matrimonial.id=tbl_family_info_matrimonial.user_id
		LEFT OUTER JOIN tbl_user_gallery_matrimonial gm ON gm.user_id = tbl_user_matrimonial.id
                    AND gm.id = (
                    SELECT gm1.id
                    FROM tbl_user_gallery_matrimonial gm1
                    WHERE gm1.user_id = tbl_user_matrimonial.id
                    AND gm1.image_name IS NOT NULL
                    AND gm1.user_type = 'U'
                    AND gm1.image_type =1
                    ORDER BY gm1.image_name ASC
                    LIMIT 1 )
		LEFT JOIN tbl_user_address_matrimonial on tbl_user_matrimonial.id=tbl_user_address_matrimonial.user_id
        LEFT JOIN tbl_country on tbl_user_address_matrimonial.country=tbl_country.id
		LEFT JOIN tbl_state on tbl_user_address_matrimonial.state=tbl_state.id
		LEFT JOIN tbl_city on tbl_user_address_matrimonial.city=tbl_city.id
		LEFT JOIN tbl_user_professional_matrimonial on tbl_user_professional_matrimonial.user_id=tbl_user_matrimonial.id
		LEFT JOIN tbl_profession on tbl_user_professional_matrimonial.profession=tbl_profession.id
                LEFT JOIN tbl_user_education_matrimonial on tbl_user_education_matrimonial.user_id=tbl_user_matrimonial.id
		LEFT JOIN tbl_education_field on tbl_user_education_matrimonial.education_field_id=tbl_education_field.id
		
		LEFT JOIN tbl_height on tui.height=tbl_height.id LEFT JOIN tbl_caste on tui.caste=tbl_caste.id
		LEFT JOIN tbl_religion on tui.religion=tbl_religion.id LEFT JOIN tbl_star_sign on tui.star_sign=tbl_star_sign.id
		LEFT JOIN tbl_zodiac_sign_raasi on tui.zodiac_sign_raasi=tbl_zodiac_sign_raasi.id LEFT JOIN tbl_gothra_gothram on tui.gothra_gothram=tbl_gothra_gothram.id
		
		LEFT JOIN tbl_education_level on tbl_user_education_matrimonial.education_level_id=tbl_education_level.id
		LEFT JOIN tbl_designation on tbl_user_professional_matrimonial.designation=tbl_designation.id
       
                where relation_id=1 ORDER BY tui.id DESC;", Adapter::QUERY_MODE_EXECUTE)->toArray();
        $i = 0;
        $data = array();
        foreach($userinfos as $info){
            
            
            $data[$i] = $info;
            $user_id = $info['user_id'];
//            echo $user_id;exit;
            $motherinfos = $adapter->query("select * from tbl_family_info_matrimonial WHERE user_id='$user_id' AND relation_id = 2", Adapter::QUERY_MODE_EXECUTE)->toArray();
            $data[$i]['mother_info'] = $motherinfos;
            
            $brotherinfos = $adapter->query("select * from tbl_family_info_matrimonial WHERE user_id='$user_id' AND relation_id = 3", Adapter::QUERY_MODE_EXECUTE)->toArray();
            $data[$i]['brother_info'] = $brotherinfos;
            
            $sisterinfos = $adapter->query("select * from tbl_family_info_matrimonial WHERE user_id='$user_id' AND relation_id = 4", Adapter::QUERY_MODE_EXECUTE)->toArray();
            $data[$i]['sister_info'] = $sisterinfos;
            //$data[$i][] = $data['mother_info'];
//            echo "<pre>";
//            print_r($data);exit;
            $i++;
        }

        return new ViewModel(array(
            'data' => $data));
    }

    public function memberuserindexAction()
    {  
        if(!isset($_POST['user_id'])){
//echo  "hello";exit;
//        if($this->params()->fromRoute('id')==100){
//            $msg = "User Assigned ";
//        }
//        else if($this->params()->fromRoute('id')==101){
//            $msg = "Could not update Some internal Error";
//        }
//         else if($this->params()->fromRoute('id')==102){
//            $msg = "User Already Assigned";
//        }
//        else $msg = "";
//        echo  "hello";exit;
        $MemberbasicForm = new PersonolDetailForm($this->commonService);
        //echo  "hello";exit;
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /******Fetch all Members Data from db*********/             
         $userinfos=$adapter->query("select tui.*,tbl_height.*,tbl_profession.*,tbl_country.*,tbl_state.*,
        tbl_city.*,tbl_caste.*,tbl_religion.*,tbl_star_sign.*,tbl_zodiac_sign_raasi.*,tbl_gothra_gothram.*,tbl_user_type.*,tbl_rustagi_branches.*,    
        tbl_education_field.*,tbl_education_level.*,tbl_designation.*,tbl_user.*,
        tbl_user.is_active as userstatus,tui.user_id as uid from tbl_user_info tui LEFT JOIN tbl_user on 
        tui.user_id=tbl_user.id  
        LEFT JOIN tbl_country on tui.country=tbl_country.id 
        LEFT JOIN tbl_state on 
        tui.state=tbl_state.id LEFT JOIN tbl_city on 
        tui.city=tbl_city.id LEFT JOIN tbl_profession on 
        tui.profession=tbl_profession.id  LEFT JOIN tbl_education_field on 
        tui.education_field=tbl_education_field.id LEFT JOIN tbl_height on 
        tui.height=tbl_height.id LEFT JOIN tbl_user_type on 
        tui.user_type_id=tbl_user_type.id LEFT JOIN tbl_caste on 
        tui.caste=tbl_caste.id LEFT JOIN tbl_religion on 
        tui.religion=tbl_religion.id LEFT JOIN tbl_star_sign on 
        tui.star_sign=tbl_star_sign.id LEFT JOIN tbl_zodiac_sign_raasi on 
        tui.zodiac_sign_raasi=tbl_zodiac_sign_raasi.id LEFT JOIN tbl_gothra_gothram on 
        tui.gothra_gothram=tbl_gothra_gothram.id LEFT JOIN tbl_education_level on 
        tui.education_level=tbl_education_level.id LEFT JOIN tbl_designation on 
        tui.designation=tbl_designation.id
        LEFT JOIN tbl_rustagi_branches on tui.branch_ids=tbl_rustagi_branches.branch_id
         where tui.user_type_id !='0' ORDER BY tui.id DESC", Adapter::QUERY_MODE_EXECUTE);
         

        $communities = $adapter->query("select * from tbl_communities where parent_id=1", Adapter::QUERY_MODE_EXECUTE)->toArray();
        // foreach ($communities as $comms) {
        //    $commtypes[$comms->id] = $comms->category_name;
        // }

        $usertype = $this->getUsertypeTable()->fetchAllActive();
        foreach ($usertype as $utypes) {
           $usertypes[$utypes->id] = $utypes->user_type;
        }


        // foreach ($usertypes as $key => $value) {
            

        // }
        // echo "<pre>";
            // print_r($communities);die;
        return new ViewModel(array("form" => $MemberbasicForm,
            'userinfos' => $userinfos,"usertypes"=>$usertypes,"commtypes"=>$communities,"msg"=>$msg));
        
        }
        else{
            echo  "hello";exit;
            
        }
    }
    
    //added by amir
    
   public function personalProfileMatrimonialAction() {
        
        
            //Debug::dump('amir');exit;
            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            
            $MemberbasicForm = new \Admin\Form\PersonolDetailMatrimonialForm($this->commonService);
            
            $user_id = $_POST['user_id'];
           //echo  $user_id;exit;
            //$info = $this->userService->getUserPersonalDetailById($user_id);
            $info = $this->adminService->getUserPersonalDetailByIdMatrimonial($user_id);
            
//            \Zend\Debug\Debug::dump($info); exit;
            $MemberbasicForm->get('user_id')->setValue($info['user_id']);
            $MemberbasicForm->get('profile_for')->setValue($info['profile_for']);
            $MemberbasicForm->get('name_title_user')->setValue($info['name_title_user']);
            $MemberbasicForm->get('full_name')->setValue($info['full_name']);
            $MemberbasicForm->get('gender')->setValue($info['gender']);
            $MemberbasicForm->get('dob')->setValue(date("d-m-Y", strtotime($info['dob'])));
            $MemberbasicForm->get('birth_time')->setValue($info['birth_time']);
            $MemberbasicForm->get('birth_place')->setValue($info['birth_place']);

            $MemberbasicForm->get('marital_status')->setValue($info['marital_status']);
            $MemberbasicForm->get('children')->setValue($info['children']);
            $MemberbasicForm->get('no_of_kids')->setValue($info['no_of_kids']);

            $MemberbasicForm->get('height')->setValue($info['height']);
            $MemberbasicForm->get('body_type')->setValue($info['body_type']);
            $MemberbasicForm->get('color_complexion')->setValue($info['color_complexion']);
            $MemberbasicForm->get('native_place')->setValue($info['native_place']);
            $MemberbasicForm->get('blood_group')->setValue($info['blood_group']);
            $MemberbasicForm->get('body_type')->setValue($info['body_type']);
            $MemberbasicForm->get('body_weight')->setValue($info['body_weight']);
            $MemberbasicForm->get('body_weight_type')->setValue($info['body_weight_type']);
            $MemberbasicForm->get('zodiac_sign_raasi')->setValue($info['zodiac_sign_raasi']);
            $MemberbasicForm->get('alternate_mobile_no')->setValue($info['alternate_mobile_no']);
            $MemberbasicForm->get('phone_no')->setValue($info['phone_no']);
            $MemberbasicForm->get('religion')->setValue($info['religion']);
            $MemberbasicForm->get('religion_other')->setValue($info['religion_other']);
            $MemberbasicForm->get('gothra_gothram')->setValue($info['gothra_gothram']);
            $MemberbasicForm->get('gothra_gothram_other')->setValue($info['gothra_gothram_other']);
            $MemberbasicForm->get('caste')->setValue($info['caste']);
            //$MemberbasicForm->get('caste_other')->setValue($info['caste_other']);
            $MemberbasicForm->get('sub_caste')->setValue($info['sub_caste']);
            $MemberbasicForm->get('mother_tongue_id')->setValue($info['mother_tongue_id']);
            $MemberbasicForm->get('manglik_dossam')->setValue($info['manglik_dossam']);
            $MemberbasicForm->get('drink')->setValue($info['drink']);
            $MemberbasicForm->get('smoke')->setValue($info['smoke']);
            $MemberbasicForm->get('meal_preference')->setValue($info['meal_preference']);

           
            $MemberbasicForm->get('address')->setValue($info['address']);
            $MemberbasicForm->get('country')->setValue($info['country']);
            $MemberbasicForm->get('state')->setValue($info['state']);
            $MemberbasicForm->get('city')->setValue($info['city']);
            $MemberbasicForm->get('zip_pin_code')->setValue($info['pincode']);
            //$MemberbasicForm->bind($info);
            
           /* $request = $this->getRequest();
            if ($request->isPost()) {
                //echo  "hello";exit;
                //$page = new Memberbasic();
                //$MemberbasicForm->setInputFilter($page->getInputFilter());
                //echo  "<pre>";
                //print_r($request->getPost());exit;
                $MemberbasicForm->setData($request->getPost());
                $MemberbasicForm->setInputFilter(new \Admin\Form\PersonolDetailMatrimonialFormFilter());
                //$data = (array) $request->getPost();
                if ($MemberbasicForm->isValid()) {
                    $formdata = $MemberbasicForm->getData();
                    $formdata['user_id'] = $user_id;
                    
                    //Debug::dump($request->getPost()->submit);
                    //exit;
                    $this->adminService->saveUserPersonalDetailsMatrimonial($formdata);
                    //exit;
               
                    if ($request->getPost()->submit == "Save & Next") {
                        $this->redirect()->toRoute("profile", array(
                            "action" => "education-and-career",
                        ));
                    }
                    return new JsonModel($_POST);
                }
            } */

//            $percentage = $this->userService->ProfileBarMatrimonial($user_id);
//            $pro_per = array($percentage, $this->profileBarTemplate($percentage));
            //Debug::dump($this->userService->userSummaryByIdMatrimonial($user_id));exit;
//            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

//            $sql = "select * from tbl_user_gallery_matrimonial where user_id='$user_id' AND user_type='U' AND image_type='1' ORDER BY id DESC";
//            $image = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
            //echo  "hello2";exit;
            $userSummary = $this->adminService->userSummaryByIdMatrimonial($user_id);
            $viewModel = new ViewModel(array("form" => $MemberbasicForm,
                "userSummary" => $userSummary,));
               
                    
//            if ($request->isXmlHttpRequest()) {
//                $viewModel->setTemplate('application/profile/personal-profile-matrimonial.phtml');
//                $viewModel->setTerminal(true);
//            } else {
//                $viewModel->setTemplate('application/profile/personal-profile-matrimonial-ajax.phtml');
//            }
            
             $viewModel->setTerminal(true);
            //return $view;
            return $viewModel;
        
    } 
    
    public function educationAndCareerMatrimonialAction() {

//        echo  "asdsf";exit;
        
            $form = new \Admin\Form\EducationAndCareerFormMatrimonial($this->commonService);
            $user_id = $_POST['user_id'];
            //echo  $user_id;exit;
            $info = $this->adminService->getEducationAndCareerByIdMatrimonial($user_id);
            //\Zend\Debug\Debug::dump($info);exit;
            //$familyInfo = $this->userService->getFamilyInfoById($user_id);
            //$form->bind($data);
            $form->get('user_id')->setValue($info['user_id']);
            $form->get('education_id')->setValue($info['education_id']);
            $form->get('profession_id')->setValue($info['profession_id']);
            $form->get('education_level')->setValue($info['education_level_id']);
            $form->get('education_field')->setValue($info['education_field_id']);
            $form->get('employer')->setValue($info['employer']);
            $form->get('designation')->setValue($info['designation']);
            $form->get('specialize_profession')->setValue($info['specialize_profession']);
            $form->get('annual_income')->setValue($info['annual_income']);
            $form->get('profession')->setValue($info['profession']);
            $form->get('office_name')->setValue($info['office_name']);
            $form->get('office_email')->setValue($info['office_email']);
            $form->get('office_website')->setValue($info['office_website']);
            $form->get('office_phone')->setValue($info['office_phone']);
            $form->get('office_country')->setValue($info['office_country']);
            $form->get('office_state')->setValue($info['office_state']);
            $form->get('office_city')->setValue($info['office_city']);
            $form->get('office_address')->setValue($info['office_address']);
            $form->get('office_pincode')->setValue($info['office_pincode']);
            $form->get('annual_income_status')->setValue($info['annual_income_status']);
            
          /*  $request = $this->getRequest();

            if ($request->isPost()) {
                $form->setInputFilter(new EducationAndCareerFormFilter());
                $form->setData($request->getPost());
                if ($form->isValid()) {
                    $formdata = $form->getData();
                    $formdata['user_id'] = $user_id;
                    //Debug::dump($formdata);exit;

                    $this->userService->saveEducationAndCareerDetailMatrimonial($formdata);
                    if ($request->getPost()->submit == "Save & Next") {
                        $this->redirect()->toRoute("profile", array(
                            "action" => "family-detail",
                        ));
                    }
                    return new JsonModel($_POST);
                }
            }
            */

            $viewModel = new ViewModel(array("form" => $form,
                //'userSummary' => $this->userService->userSummaryByIdMatrimonial($user_id),
               // 'url' => 'education-and-career',
                'user_id' => $user_id,
                    //'familyInfo' => $familyInfo,
                    //"percent" => $pro_per
            ));
            //$viewModel->setTemplate('application/profile/education-and-career-matrimonial.phtml');
            $viewModel->setTerminal(true);
            return $viewModel;
        
    }
    
    public function  personalprofileAction() {
        //echo  "hello amir";exit;
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $user_id = $_POST['user_id'];
        $MemberbasicForm = new PersonolDetailForm($this->commonService);
        
        //$sqlsingle = "select * from tbl_user_info where user_id=".$user_id;
                
        $info = $this->adminService->getUserPersonalDetailById($user_id);
        //$info = $adapter->query($sqlsingle, Adapter::QUERY_MODE_EXECUTE);
        //\Zend\Debug\Debug::dump($info);exit;
        $MemberbasicForm->bind($info);
        //echo $user_id;exit;
       //$respArr = array('status'=>"Couldn't update");
       
       //$view = new ViewModel(array('form' => $MemberbasicForm,'user'=>'268'));
       $view = new ViewModel(array('form' => $MemberbasicForm));
            $view->setTerminal(true);
            return $view;
            //exit();  
        
        
    }
    
    public function  educationAndCareerAction() {
        //echo  "hello amir";exit;
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $user_id = $_POST['user_id'];
//        echo  $user_id;exit;
        $MemberbasicForm = new EducationAndCareerForm($this->commonService);
        //echo "hello";exit;
        //$sqlsingle = "select * from tbl_user_info where user_id=".$user_id;
                
        $info = $this->adminService->getUserEducationAndCareerDetailById($user_id);
        //$info = $adapter->query($sqlsingle, Adapter::QUERY_MODE_EXECUTE);
        //\Zend\Debug\Debug::dump($info);exit;
        $MemberbasicForm->bind($info);
        //\Zend\Debug\Debug::dump($MemberbasicForm);exit;
        //echo $user_id;exit;
       //$respArr = array('status'=>"Couldn't update");
       
       //$view = new ViewModel(array('form' => $MemberbasicForm,'user'=>'268'));
       $view = new ViewModel(array('form' => $MemberbasicForm));
            $view->setTerminal(true);
            return $view;
            //exit();  
        
        
    }
    
    public function  locationDetailAction() {
        //echo  "hello amir";exit;
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $user_id = $_POST['user_id'];
//        echo  $user_id;exit;
        $MemberbasicForm = new LocationDetailForm($this->commonService);
        //\Zend\Debug\Debug::dump($MemberbasicForm);exit;
        //echo "hello";exit;
        //$sqlsingle = "select * from tbl_user_info where user_id=".$user_id;
                
        $info = $this->adminService->getUserLocationDetailById($user_id);
        //$info = $adapter->query($sqlsingle, Adapter::QUERY_MODE_EXECUTE);
        //\Zend\Debug\Debug::dump($info);exit;
        $MemberbasicForm->bind($info);
        //\Zend\Debug\Debug::dump($MemberbasicForm);exit;
        //echo $user_id;exit;
       //$respArr = array('status'=>"Couldn't update");
       
       //$view = new ViewModel(array('form' => $MemberbasicForm,'user'=>'268'));
       $view = new ViewModel(array('form' => $MemberbasicForm));
            $view->setTerminal(true);
            return $view;
            //exit();  
        
        
    }
    
    
    public function  postDetailAction() {
        //echo  "hello amir";exit;
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $user_id = $_POST['user_id'];
//        echo  $user_id;exit;
        $MemberbasicForm = new PostDetailForm($this->commonService);
        //\Zend\Debug\Debug::dump($MemberbasicForm);exit;
        //echo "hello";exit;
        //$sqlsingle = "select * from tbl_user_info where user_id=".$user_id;
                
        $info = $this->adminService->getUserLocationDetailById($user_id);
        //change above line also...
        //$info = $adapter->query($sqlsingle, Adapter::QUERY_MODE_EXECUTE);
        //\Zend\Debug\Debug::dump($info);exit;
        $MemberbasicForm->bind($info);
        //\Zend\Debug\Debug::dump($MemberbasicForm);exit;
        //echo $user_id;exit;
       //$respArr = array('status'=>"Couldn't update");
       
       //$view = new ViewModel(array('form' => $MemberbasicForm,'user'=>'268'));
       $view = new ViewModel(array('form' => $MemberbasicForm));
            $view->setTerminal(true);
            return $view;
            //exit();  
        
        
    }
    
    public function savePersonalProfileMatrimonialAction()
    {   
         //echo  "hello amir";exit;
        
        $request = $this->getRequest();
       
        if($request->isPost()){
//            echo  "<pre>";
//            print_r($request->getPost());exit;
//            
                $res = $this->adminService->saveUserPersonalDetailsMatrimonial($request->getPost());

                    
                    $response = $this->getResponse();
                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                    $response->setContent(json_encode(array("response" => $res)));
                    return $response;
              
        }
        
    

    }
    
    public function saveeducationAndCareerMatrimonialAction()
    {   
         //echo  "hello amir";exit;
        
        $request = $this->getRequest();
       
        if($request->isPost()){
//            echo  "<pre>";
//            print_r($request->getPost());exit;
//            
                $res = $this->adminService->saveEducationAndCareerDetailMatrimonial($request->getPost());

                    
                    $response = $this->getResponse();
                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                    $response->setContent(json_encode(array("response" => $res)));
                    return $response;
              
        }
        
    

    }
    
    
    
    
     public function savePersonalProfileAction()
    {   
         //echo  "hello amir";exit;
//        $form = new ReligionForm();
//        if($this->params()->fromRoute('id')>0){
//            $id = $this->params()->fromRoute('id');
//            // echo   $id;die;
//            //$religion = $this->getReligionTable()->getReligion($id);
//            $religion= $this->adminService->getReligion($id);
//            // print_r($religion);die;
//            $form->bind($religion);
//            $form->get('submit')->setAttribute('value', 'Edit');
//            // $this->editAction($form)
//        }
//        
//        $session= new \Zend\Session\Container('admin');
//        $user_id = $session->offsetGet('id');
//         $email_id = $session->offsetGet('email');
//         $remote = new \Zend\Http\PhpEnvironment\RemoteAddress;
//         $user_ip = $remote->getIpAddress();
//         $user_data = array($user_id,$email_id,$user_ip);
         
//         $info = $this->adminService->getUserPersonalDetailByUserId($id);
//         $info->setDob(date("d-m-Y", strtotime($info->getDob())));
        $request = $this->getRequest();
        //if (!isset($_POST['chkedit'])) {
        if($request->isPost()){
//            echo  "<pre>";
//            print_r($request->getPost());exit;
//            echo  "hello sir ji";exit;
//            $mergedata = array_merge(
//                    $this->getRequest()->getPost()->toArray() ,$user_data
//            ); 
//            $form->setData($mergedata);
            //$religionEntity = new Religions();

               //$form->setInputFilter(new ReligionFilter());
               //$form->setData($request->getPost());


               //if($form->isValid()){

                //$religionEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getReligionTable()->SaveReligion($religionEntity);
                $res = $this->adminService->SavePersonalProfile($request->getPost());

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'religion'
//                ));
                    $response = $this->getResponse();
                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                    $response->setContent(json_encode(array("response" => $res)));
                    return $response;
              // } 
//               else {
//
//                    foreach ($form->getmessages() as $key => $value) {
//                        $errors[] = array("element" => $key, "errors" => $value['isEmpty']);
//                    }
//
//                    $response = $this->getResponse();
//                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
//                    $response->setContent(json_encode(array("errors", $errors)));
//                    return $response;
//                }
        }
        
     // }

        //return new ViewModel(array('form'=> $form,'id'=>$id));
//        $view = new ViewModel(array());
//        $view->setTerminal(true);
//        return $view;

    }
    
    public function saveEducationAndCareerAction()
    {   
         //echo  "hello amir";exit;
//        $form = new ReligionForm();
//        if($this->params()->fromRoute('id')>0){
//            $id = $this->params()->fromRoute('id');
//            // echo   $id;die;
//            //$religion = $this->getReligionTable()->getReligion($id);
//            $religion= $this->adminService->getReligion($id);
//            // print_r($religion);die;
//            $form->bind($religion);
//            $form->get('submit')->setAttribute('value', 'Edit');
//            // $this->editAction($form)
//        }
//        
//        $session= new \Zend\Session\Container('admin');
//        $user_id = $session->offsetGet('id');
//         $email_id = $session->offsetGet('email');
//         $remote = new \Zend\Http\PhpEnvironment\RemoteAddress;
//         $user_ip = $remote->getIpAddress();
//         $user_data = array($user_id,$email_id,$user_ip);
         
//         $info = $this->adminService->getUserPersonalDetailByUserId($id);
//         $info->setDob(date("d-m-Y", strtotime($info->getDob())));
        $request = $this->getRequest();
        //if (!isset($_POST['chkedit'])) {
        if($request->isPost()){
//            echo  "<pre>";
//            print_r($request->getPost());exit;
//            echo  "hello sir ji";exit;
//            $mergedata = array_merge(
//                    $this->getRequest()->getPost()->toArray() ,$user_data
//            ); 
//            $form->setData($mergedata);
            //$religionEntity = new Religions();

               //$form->setInputFilter(new ReligionFilter());
               //$form->setData($request->getPost());


               //if($form->isValid()){

                //$religionEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getReligionTable()->SaveReligion($religionEntity);
                $res = $this->adminService->SaveEducationAndCareer($request->getPost());

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'religion'
//                ));
                    $response = $this->getResponse();
                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                    $response->setContent(json_encode(array("response" => $res)));
                    return $response;
              // } 
//               else {
//
//                    foreach ($form->getmessages() as $key => $value) {
//                        $errors[] = array("element" => $key, "errors" => $value['isEmpty']);
//                    }
//
//                    $response = $this->getResponse();
//                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
//                    $response->setContent(json_encode(array("errors", $errors)));
//                    return $response;
//                }
        }
        
     // }

        //return new ViewModel(array('form'=> $form,'id'=>$id));
//        $view = new ViewModel(array());
//        $view->setTerminal(true);
//        return $view;

    }
    
    public function saveLocationDetailAction()
    {   
         //echo  "hello amir";exit;
//        $form = new ReligionForm();
//        if($this->params()->fromRoute('id')>0){
//            $id = $this->params()->fromRoute('id');
//            // echo   $id;die;
//            //$religion = $this->getReligionTable()->getReligion($id);
//            $religion= $this->adminService->getReligion($id);
//            // print_r($religion);die;
//            $form->bind($religion);
//            $form->get('submit')->setAttribute('value', 'Edit');
//            // $this->editAction($form)
//        }
//        
//        $session= new \Zend\Session\Container('admin');
//        $user_id = $session->offsetGet('id');
//         $email_id = $session->offsetGet('email');
//         $remote = new \Zend\Http\PhpEnvironment\RemoteAddress;
//         $user_ip = $remote->getIpAddress();
//         $user_data = array($user_id,$email_id,$user_ip);
         
//         $info = $this->adminService->getUserPersonalDetailByUserId($id);
//         $info->setDob(date("d-m-Y", strtotime($info->getDob())));
        $request = $this->getRequest();
        //if (!isset($_POST['chkedit'])) {
        if($request->isPost()){
//            echo  "<pre>";
//            print_r($request->getPost());exit;
//            echo  "hello sir ji";exit;
//            $mergedata = array_merge(
//                    $this->getRequest()->getPost()->toArray() ,$user_data
//            ); 
//            $form->setData($mergedata);
            //$religionEntity = new Religions();

               //$form->setInputFilter(new ReligionFilter());
               //$form->setData($request->getPost());


               //if($form->isValid()){

                //$religionEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getReligionTable()->SaveReligion($religionEntity);
                $res = $this->adminService->SaveLocation($request->getPost());

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'religion'
//                ));
                    $response = $this->getResponse();
                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                    $response->setContent(json_encode(array("response" => $res)));
                    return $response;
              // } 
//               else {
//
//                    foreach ($form->getmessages() as $key => $value) {
//                        $errors[] = array("element" => $key, "errors" => $value['isEmpty']);
//                    }
//
//                    $response = $this->getResponse();
//                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
//                    $response->setContent(json_encode(array("errors", $errors)));
//                    return $response;
//                }
        }
        
     // }

        //return new ViewModel(array('form'=> $form,'id'=>$id));
//        $view = new ViewModel(array());
//        $view->setTerminal(true);
//        return $view;

    }
    
     public function savePostAction()
    {   
         //echo  "hello amir";exit;
//        $form = new ReligionForm();
//        if($this->params()->fromRoute('id')>0){
//            $id = $this->params()->fromRoute('id');
//            // echo   $id;die;
//            //$religion = $this->getReligionTable()->getReligion($id);
//            $religion= $this->adminService->getReligion($id);
//            // print_r($religion);die;
//            $form->bind($religion);
//            $form->get('submit')->setAttribute('value', 'Edit');
//            // $this->editAction($form)
//        }
//        
//        $session= new \Zend\Session\Container('admin');
//        $user_id = $session->offsetGet('id');
//         $email_id = $session->offsetGet('email');
//         $remote = new \Zend\Http\PhpEnvironment\RemoteAddress;
//         $user_ip = $remote->getIpAddress();
//         $user_data = array($user_id,$email_id,$user_ip);
         
//         $info = $this->adminService->getUserPersonalDetailByUserId($id);
//         $info->setDob(date("d-m-Y", strtotime($info->getDob())));
        $request = $this->getRequest();
        //if (!isset($_POST['chkedit'])) {
        if($request->isPost()){
//            echo  "<pre>";
//            print_r($request->getPost());exit;
//            echo  "hello sir ji";exit;
//            $mergedata = array_merge(
//                    $this->getRequest()->getPost()->toArray() ,$user_data
//            ); 
//            $form->setData($mergedata);
            //$religionEntity = new Religions();

               //$form->setInputFilter(new ReligionFilter());
               //$form->setData($request->getPost());


               //if($form->isValid()){

                //$religionEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getReligionTable()->SaveReligion($religionEntity);
                $res = $this->adminService->SavePostDetail($request->getPost());

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'religion'
//                ));
                    $response = $this->getResponse();
                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                    $response->setContent(json_encode(array("response" => $res)));
                    return $response;
              // } 
//               else {
//
//                    foreach ($form->getmessages() as $key => $value) {
//                        $errors[] = array("element" => $key, "errors" => $value['isEmpty']);
//                    }
//
//                    $response = $this->getResponse();
//                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
//                    $response->setContent(json_encode(array("errors", $errors)));
//                    return $response;
//                }
        }
        
     // }

        //return new ViewModel(array('form'=> $form,'id'=>$id));
//        $view = new ViewModel(array());
//        $view->setTerminal(true);
//        return $view;

    }

    public function usertypeinfoAction()
    {   //echo  "helo world";exit;
//        echo $_POST['id'];exit;
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        echo  "helo world";exit;
        
//        $sqlsingle = "select tui.*,tbl_height.*,tbl_profession.*,tbl_country.*,tbl_state.*,
//        tbl_city.*,tbl_caste.*,tbl_religion.*,tbl_star_sign.*,tbl_zodiac_sign_raasi.*,tbl_gothra_gothram.*,tbl_user_type.*,    
//        tbl_family_info.*,tbl_education_field.*,tbl_education_level.*,tbl_designation.*,tbl_user.*,tbl_communities.*,
//        tbl_user.IsActive as userstatus,tui.user_id as uid from tbl_user_info tui LEFT JOIN tbl_user on 
//        tui.user_id=tbl_user.id LEFT JOIN tbl_family_info on tui.user_id=tbl_family_info.user_id 
//        LEFT JOIN tbl_country on tui.country=tbl_country.id 
//        LEFT JOIN tbl_state on 
//        tui.state=tbl_state.id LEFT JOIN tbl_city on 
//        tui.city=tbl_city.id LEFT JOIN tbl_profession on 
//        tui.profession=tbl_profession.id  LEFT JOIN tbl_education_field on 
//        tui.education_field=tbl_education_field.id LEFT JOIN tbl_height on 
//        tui.height=tbl_height.id LEFT JOIN tbl_user_type on 
//        tui.user_type_id=tbl_user_type.id LEFT JOIN tbl_caste on 
//        tui.caste=tbl_caste.id LEFT JOIN tbl_religion on 
//        tui.religion=tbl_religion.id LEFT JOIN tbl_star_sign on 
//        tui.star_sign=tbl_star_sign.id LEFT JOIN tbl_zodiac_sign_raasi on 
//        tui.zodiac_sign_raasi=tbl_zodiac_sign_raasi.id LEFT JOIN tbl_gothra_gothram on 
//        tui.gothra_gothram=tbl_gothra_gothram.id LEFT JOIN tbl_education_level on 
//        tui.education_level=tbl_education_level.id LEFT JOIN tbl_designation on 
//        tui.designation=tbl_designation.id LEFT JOIN tbl_communities on 
//        tui.comm_mem_id=tbl_communities.id LEFT JOIN tbl_user_roles on 
//        tui.user_id=tbl_user_roles.user_id
//        where tbl_user_roles.".$_POST['id']."='1'
//         ORDER BY tui.id DESC";
        if($_POST['id']!='IsMatrimonial'){
        $sqlsingle = "select tui.*,tbl_height.*,tbl_profession.*,tbl_country.*,tbl_state.*,
        tbl_city.*,tbl_caste.*,tbl_religion.*,tbl_star_sign.*,tbl_zodiac_sign_raasi.*,tbl_gothra_gothram.*,tbl_user_type.*,    
        tbl_education_field.*,tbl_education_level.*,tbl_designation.*,tbl_user.*,tbl_communities.*,
        tbl_user.is_active as userstatus,tui.user_id as uid from tbl_user_info tui LEFT JOIN tbl_user on 
        tui.user_id=tbl_user.id  
        LEFT JOIN tbl_country on tui.country=tbl_country.id 
        LEFT JOIN tbl_state on 
        tui.state=tbl_state.id LEFT JOIN tbl_city on 
        tui.city=tbl_city.id LEFT JOIN tbl_profession on 
        tui.profession=tbl_profession.id  LEFT JOIN tbl_education_field on 
        tui.education_field=tbl_education_field.id LEFT JOIN tbl_height on 
        tui.height=tbl_height.id LEFT JOIN tbl_user_type on 
        tui.user_type_id=tbl_user_type.id LEFT JOIN tbl_caste on 
        tui.caste=tbl_caste.id LEFT JOIN tbl_religion on 
        tui.religion=tbl_religion.id LEFT JOIN tbl_star_sign on 
        tui.star_sign=tbl_star_sign.id LEFT JOIN tbl_zodiac_sign_raasi on 
        tui.zodiac_sign_raasi=tbl_zodiac_sign_raasi.id LEFT JOIN tbl_gothra_gothram on 
        tui.gothra_gothram=tbl_gothra_gothram.id LEFT JOIN tbl_education_level on 
        tui.education_level=tbl_education_level.id LEFT JOIN tbl_designation on 
        tui.designation=tbl_designation.id LEFT JOIN tbl_communities on 
        tui.comm_mem_id=tbl_communities.id LEFT JOIN tbl_user_roles on 
        tui.user_id=tbl_user_roles.user_id
        where tbl_user_roles.".$_POST['id']."='1'
         ORDER BY tui.id DESC";

         $userinfos = $adapter->query($sqlsingle, Adapter::QUERY_MODE_EXECUTE);
            
        } else {
            $sqlsingle = "select tui.*,tbl_height.*,tbl_profession.*,tbl_country.*,tbl_state.*,
        tbl_city.*,tbl_caste.*,tbl_religion.*,tbl_star_sign.*,tbl_zodiac_sign_raasi.*,tbl_gothra_gothram.*,tbl_user_type.*,    
        tbl_education_field.*,tbl_education_level.*,tbl_designation.*,tbl_user.*,tbl_communities.*,
        tbl_user.is_active as userstatus,tui.user_id as uid from tbl_user_info tui LEFT JOIN tbl_user on 
        tui.user_id=tbl_user.id  
        LEFT JOIN tbl_country on tui.country=tbl_country.id 
        LEFT JOIN tbl_state on 
        tui.state=tbl_state.id LEFT JOIN tbl_city on 
        tui.city=tbl_city.id LEFT JOIN tbl_profession on 
        tui.profession=tbl_profession.id  LEFT JOIN tbl_education_field on 
        tui.education_field=tbl_education_field.id LEFT JOIN tbl_height on 
        tui.height=tbl_height.id LEFT JOIN tbl_user_type on 
        tui.user_type_id=tbl_user_type.id LEFT JOIN tbl_caste on 
        tui.caste=tbl_caste.id LEFT JOIN tbl_religion on 
        tui.religion=tbl_religion.id LEFT JOIN tbl_star_sign on 
        tui.star_sign=tbl_star_sign.id LEFT JOIN tbl_zodiac_sign_raasi on 
        tui.zodiac_sign_raasi=tbl_zodiac_sign_raasi.id LEFT JOIN tbl_gothra_gothram on 
        tui.gothra_gothram=tbl_gothra_gothram.id LEFT JOIN tbl_education_level on 
        tui.education_level=tbl_education_level.id LEFT JOIN tbl_designation on 
        tui.designation=tbl_designation.id LEFT JOIN tbl_communities on 
        tui.comm_mem_id=tbl_communities.id LEFT JOIN tbl_user_roles on 
        tui.user_id=tbl_user_roles.user_id
        where tbl_user_roles.".$_POST['id']."='2'
         ORDER BY tui.id DESC";

         $userinfos = $adapter->query($sqlsingle, Adapter::QUERY_MODE_EXECUTE);
            
        }
             $usertype = $this->getUsertypeTable()->fetchAllActive();
        foreach ($usertype as $utypes) {
           $usertypes[$utypes->id] = $utypes->user_type;
        }

        $communities = $adapter->query("select * from tbl_communities where parent_id=1", Adapter::QUERY_MODE_EXECUTE)->toArray();

             $view = new ViewModel(array(
            'userinfos' => $userinfos,"usertypes"=>$usertypes,"commtypes"=>$communities));
        $view->setTerminal(true);
        return $view;
        exit();    
         
    }

    /* ajax function call */
    public function changestatusAction()
    {   //echo  "hello world";exit;
        
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        //print_r($_POST);exit;
            $return = $adapter->query("update tbl_user_matrimonial set is_active=".$_POST['is_active']."
             where id=".$_POST['id']."", Adapter::QUERY_MODE_EXECUTE);
//            echo  "hell0";exit;
//        $data = (object)$_POST;
//        $return = $this->getUserTable()->updatestatus($data);
//         print_r($return);exit;
            if($return){
                $out= array('status'=>'updated successfully');
            }else{
                $out= array('status'=>"couldn't updated");
            }
                
        return new JsonModel($out);
        //exit();

    }
    /* ajax function call */

    public function updateusertypeAction()
    {   
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

            $result1 = $adapter->query("update tbl_user_info set user_type_id=".$_POST['usertype']."
             where user_id=".$_POST['uid']."", Adapter::QUERY_MODE_EXECUTE);

            $result2 = $adapter->query("update tbl_user set user_type_id=".$_POST['usertype']."
             where id=".$_POST['uid']."", Adapter::QUERY_MODE_EXECUTE);
         
        if($result1 && $result2){
            $respArr = array('status'=>"Updated SuccessFully");
        }   
            
        else $respArr = array('status'=>"Couldn't update");

        return new JsonModel($respArr);
        

        exit();

    }

    public function updatecommtypeAction()
    {   

        $user_id = $_POST['uid'];
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $catid = (empty($_POST['cid']))? 0: $_POST['cid'];

        if($_POST['cid']==0){
            $sql = "update tbl_user_info set comm_mem_id=".$catid.", financial_year='0000-00-00' ,comm_mem_status='0'  where user_id=".$_POST['user_id']."";
            $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);

            $mngmnt = $adapter->query("select * from tbl_community_mngmnt where ( agent_id=".$_POST['user_id']." && status=1)", Adapter::QUERY_MODE_EXECUTE)->toArray();

             if(count($mngmnt)>0){

              $adapter->query("update tbl_community_mngmnt set status='0'  where (agent_id=".$_POST['user_id'].")", Adapter::QUERY_MODE_EXECUTE);
              // $adapter->query("update tbl_user_info set comm_mem_id='0',financial_year='0000-00-00',comm_mem_status='0'  where (user_id=".$_POST['user_id'].")", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

        
            foreach ($mngmnt as $key => $value) {

                $adapter->query("update tbl_user_info set comm_mem_id='0',financial_year='0000-00-00',comm_mem_id='0'  where (user_id=".$value['sub_agent_id'].")", Adapter::QUERY_MODE_EXECUTE);

                // echo $value['sub_agent_id'];
                }

            }

            echo "<p id='closeCatBox' onclick='closeme()'>X</p><br>Updated SuccessFully";
            exit();
        }
        else {
                $communities = $adapter->query("select * from tbl_communities where id=".$_POST['cid']."", Adapter::QUERY_MODE_EXECUTE)->toArray();
                $SubComm = $adapter->query("select * from tbl_communities where parent_id=".$communities[0]['id']."", Adapter::QUERY_MODE_EXECUTE)->toArray();
                
                $category = array($communities[0],$SubComm);
            }

            // print_r($category);
            $view = new ViewModel(array('categories' => $category,'user' => $_POST ));
        $view->setTerminal(true);
        return $view;
        exit();   
    }

    public function updateusercommAction()
    {   
        $subagentid = $_POST['user_id'];    
        $subagentcatid = $_POST['catid'];    

        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $parent = $adapter->query("select * from tbl_communities where id=".$_POST['catid']."", Adapter::QUERY_MODE_EXECUTE)->toArray();

        $LoneParent = $adapter->query("select * from tbl_communities where id=".$parent[0]['parent_id']."", Adapter::QUERY_MODE_EXECUTE)->toArray();

        $Financial = $adapter->query("select financial_year,comm_mem_id from tbl_user_info where user_id=".$_POST['user_id']."", Adapter::QUERY_MODE_EXECUTE)->toArray();
            $today = date("Y-m-d");


        if($parent[0]['parent_id']==1 && $parent[0]['Head']==2){

            $respArr = array("status"=>1,"Content"=>"This is not a category you can choose its sub");
            // echo "";
        }
        else if(($LoneParent[0]['Head']==2 ) OR ($parent[0]['parent_id']==1 && $parent[0]['Head']==1)){

        
        // echo strtotime($Financial[0]['financial_year']);
            if($Financial[0]['financial_year'] == '0000-00-00'){

                $result = $adapter->query("update tbl_user_info set comm_mem_id='".$_POST['catid']."', financial_year='".$today."' ,comm_mem_status=1
                    where user_id='".$_POST['user_id']."'", Adapter::QUERY_MODE_EXECUTE);
                if($result)
                    $respArr = array("status"=>2,"Content"=>"Updated SuccessFully");

                     
                else $respArr = array("status"=>2,"Content"=>"Couldn't Update");

            }
            else {

               $msg =  $this->updateFinancialYear($Financial[0]['financial_year'],$_POST['catid'],$_POST['user_id']);
                
               $respArr = $msg;

            }
        }       
        else {

            $isHead = $adapter->query("select comm_mem_status from tbl_user_info where user_id=".$subagentid."", Adapter::QUERY_MODE_EXECUTE)->toArray();


            if($isHead[0]['comm_mem_status']==0){

            $HeadCategoryName = $adapter->query("select * from tbl_communities where id=".$parent[0]['parent_id']."", Adapter::QUERY_MODE_EXECUTE)->toArray();
// for testing purpose
//            $action = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost()."/rustagi/admin/matrimonyuser/assignuser";
//for Live Purpose
            $action = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost()."/rustagi/admincontrol/matrimonyuser/assignuser";



            $result = $adapter->query("select tui.user_id,tui.comm_mem_id,tui.financial_year,tui.full_name,tbl_user.* from tbl_user_info as tui inner join tbl_user
                on tui.user_id=tbl_user.id
             where (tui.comm_mem_id='".$parent[0]['parent_id']."' && tui.user_id NOT IN($subagentid))", Adapter::QUERY_MODE_EXECUTE)->toArray();

            if(count($result)){

            $output[] = "<p id='closeCatBox' onclick='closeme()'>X</p><br>";
            $output[] = "<center><h3>Category '".$HeadCategoryName[0]['category_name']."'</h3>";
            $output[] = "<h5>Choose Your Head</h5></center>";
            $output[] = "<form id='AssignUserForm' method='post' action=$action>";
            $output[] = "<input type='hidden' name='subagent' value=$subagentid>";
            $output[] = "<input type='hidden' name='subagentcatid' value=$subagentcatid>";

            foreach ($result as $key => $value) {
                $output[] = "<div style='border:2px solid black;'>Name :  ".$value['full_name']." <br> 
                    Mobile No. : ".$value['mobile_no']." <br> 
                    Financial Year. : ".$value['financial_year']." <br> 
                    <input type='radio' checked='checked' name='Agent' value = ".$value['user_id'].">
                    </div><br>";
            }
                    
            $output[] = "<input type='submit' value='update'></form>" ;
            $content = join("",$output);

            $respArr = array("status"=>4,"Content"=>$content);
        }
        else 
            $respArr = array("status"=>5,"Content"=>"You Need to Assign a head first");
       }
       else {
// for testing purpose
//                $action = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost()."/rustagi/admin/matrimonyuser/unassignparent";
// for live purpose
  $action = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost()."/admincontrol/matrimonyuser/unassignparent";

                        $nextaction = array("action"=>$action,"user_id"=>$subagentid,"callback"=>"unassignparentres");
                        $respArr = array("status"=>8,"Content"=>"You need to unassign this user first","nextaction"=>$nextaction);
       }
    }


        $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
            $response->setContent(json_encode($respArr));
            return $response;

        // print_r($parent[0]['parent_id']);
        exit();
    }


    public function updateFinancialYear($Fyear,$catid,$uid)
    {
        # code...
        $d1 = strtotime($today);
                $d2 = strtotime($Fyear);
                $diff = $d1-$d2;
                $years = floor($diff / (365*60*60*24));
                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    
                    if($days >= 365)
                    {
                         $result = $adapter->query("update tbl_user_info set comm_mem_id='".$catid."', financial_year='".$today."' 
                    where user_id='".$uid."'", Adapter::QUERY_MODE_EXECUTE);
                        if($result)
                           return array("status"=>3,"Content"=>"Financial Year Renewed from today");
                        else return array("status"=>3,"Content"=>"Couldn't Update");
                    }
                    else {
//for Testing Purpose
//                       $action = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost()."/rustagi/admin/matrimonyuser/unassignparent";
//for Live Purpose
     $action = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost()."/admincontrol/matrimonyuser/unassignparent";
                        $nextaction = array("action"=>$action,"user_id"=>$uid,"callback"=>"unassignparentres","fyear"=>$Fyear,"catid"=>$catid);
                        return array("status"=>3,"Content"=>"The Financial Period is not over for this user","nextaction"=>$nextaction);
                    }

        // return $Fyear.$catid.$uid;
    }

    public function assignuserAction()
    {
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

       $result = $adapter->query("select * from tbl_community_mngmnt 
        where (agent_id=".$_POST['Agent']." && sub_agent_id=".$_POST['subagent']." && status=1)", Adapter::QUERY_MODE_EXECUTE);

        if(count($result)==1){
            $msgid = 102;
        }
        else {

            $adapter->query("update tbl_user_info set comm_mem_id='".$_POST['subagentcatid']."',financial_year='".date("Y-m-d")."',comm_mem_status='1'  where user_id=".$_POST['subagent']."", Adapter::QUERY_MODE_EXECUTE);


             $result = $adapter->query("INSERT INTO `tbl_community_mngmnt`(`agent_id`, `sub_agent_id`, `status`)
                  VALUES (".$_POST['Agent'].",".$_POST['subagent'].",1)", Adapter::QUERY_MODE_EXECUTE);
                 if($result){
                        $msgid = 100;
                    }
                    else $msgid = 101;

        }


        return $this->redirect()->toRoute('admin', array(
                            'action' => 'memberuserindex',
                            'controller' => 'matrimonyuser',
                            'id' => $msgid
                ));       
    }


    public function viewassignedAction()
    {   
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $subagent = $adapter->query("select * from tbl_community_mngmnt where (sub_agent_id=".$_POST['sub_id']." && status=1)", Adapter::QUERY_MODE_EXECUTE)->toArray();

        $Agentdetails = $adapter->query("select tui.full_name,tui.comm_mem_id,tui.comm_mem_id,tui.profile_photo,tbl_communities.*,tbl_user.* from tbl_user_info as tui 
          inner join tbl_communities on tui.comm_mem_id = tbl_communities.id   
          inner join tbl_user on tui.user_id = tbl_user.id   
        where tui.user_id=".$subagent[0]['agent_id']."", Adapter::QUERY_MODE_EXECUTE)->toArray();

            $Agentdetails[0]['user_id'] = $subagent[0]['agent_id'];
            $Agentdetails[0]['subagentid'] = $subagent[0]['sub_agent_id'];
            $Agentdetails[0]['subagentname'] = $_POST['subname'];

        $communities = $adapter->query("select * from tbl_communities where parent_id=1", Adapter::QUERY_MODE_EXECUTE)->toArray();


        $view = new ViewModel(array('Agentdetails' => $Agentdetails[0],'communities' => $communities ));
        $view->setTerminal(true);
        return $view;
        exit();  
    }

     public function viewloneassignedAction()
    {   
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');


        $Agentdetails = $adapter->query("select tui.full_name,tui.user_id as uid,tui.comm_mem_id,tui.comm_mem_id,tui.profile_photo,tbl_communities.*,tbl_user.* from tbl_user_info as tui 
          inner join tbl_communities on tui.comm_mem_id = tbl_communities.id   
          inner join tbl_user on tui.user_id = tbl_user.id   
        where tui.user_id=".$_POST['sub_id']."", Adapter::QUERY_MODE_EXECUTE)->toArray();

        $subagent = $adapter->query("select category_name,Head from tbl_communities where (id=".$Agentdetails[0]['parent_id']." && Head=2)", Adapter::QUERY_MODE_EXECUTE)->toArray();


        $view = new ViewModel(array('Agentdetails' => $Agentdetails[0],'subagent' => $subagent[0]));
        $view->setTerminal(true);
        return $view;
        // print_r($subagent);
        exit();  
    }


    public function UnassignCommPosAction()
    {   
        $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );

        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        // $mngmnt = $adapter->query("delete from tbl_community_mngmnt where ( agent_id=".$_POST['agent_id']." && sub_agent_id=".$_POST['sub_agent_id'].")", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if($_POST['Head']!=2){
            $mngmnt = $adapter->query("update tbl_community_mngmnt set status=0 where ( agent_id=".$_POST['agent_id']." && sub_agent_id=".$_POST['sub_agent_id'].")", Adapter::QUERY_MODE_EXECUTE);
        }
        else $mngmnt = true;
        
        $userinfo = $adapter->query("update tbl_user_info set comm_mem_id='0',financial_year='0000-00-00',comm_mem_status='0'  where (user_id=".$_POST['sub_agent_id'].")", Adapter::QUERY_MODE_EXECUTE);

        if($mngmnt && $userinfo){
            $resp = array("Status"=>1,"msg"=>"Unassigned SuccessFully");
        }
        else $resp = array("Status"=>0,"msg"=>"Sorry Couldn't Un-Assign");
            
            $response->setContent(json_encode($resp));

            return $response;
    }

    public function unassignparentAction()
    {
         $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $mngmnt = $adapter->query("select * from tbl_community_mngmnt where ( agent_id=".$_POST['user_id']." && status=1)", Adapter::QUERY_MODE_EXECUTE)->toArray();
        
        $adapter->query("update tbl_user_info set comm_mem_id='0',financial_year='0000-00-00',comm_mem_status='0'  where (user_id=".$_POST['user_id'].")", Adapter::QUERY_MODE_EXECUTE);


        if(count($mngmnt)>0){

              $adapter->query("update tbl_community_mngmnt set status='0'  where (agent_id=".$_POST['user_id'].")", Adapter::QUERY_MODE_EXECUTE);
              // $adapter->query("update tbl_user_info set comm_mem_id='0',financial_year='0000-00-00',comm_mem_status='0'  where (user_id=".$_POST['user_id'].")", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

        
            foreach ($mngmnt as $key => $value) {

                $adapter->query("update tbl_user_info set comm_mem_id='0',financial_year='0000-00-00',comm_mem_status='0'  where (user_id=".$value['sub_agent_id'].")", Adapter::QUERY_MODE_EXECUTE);

                // echo $value['sub_agent_id'];
            }

        }
        echo "updated SuccessFully"; 
        exit();
    }


        
    public function showuserrolesAction()
    {
            // $response = $this->getResponse();
            // $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
            $user_id = $_POST['user_id'];

            $UserRoles = $this->getUsersRolesTable()->userrole($user_id);
            $UserRoles[0]['uid'] = $user_id;

        $view = new ViewModel(array('UserRoles' => $UserRoles[0]));
        $view->setTerminal(true);
        return $view;
      }  
        


        public function manageroleAction()
        {
            $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );

            $userinfo = $adapter->query("select tui.user_id,tui.comm_mem_id,tui.comm_mem_status,tbl_user_roles.* from tbl_user_info as tui 
                LEFT JOIN tbl_user_roles on tui.user_id=tbl_user_roles.user_id
                where tui.user_id='".$_POST['user_id']."'", Adapter::QUERY_MODE_EXECUTE)->toArray();
            
            if($userinfo[0]['IsExecutive'] ==1 && $_POST['IsExecutive'] == ""){
                if($userinfo[0]['comm_mem_id']>0 && $userinfo[0]['comm_mem_status']==1){

                 $respArr = array("status"=>1,"Content"=>"This user is Our Community Member and occupies a designation.You need to unassign it first . Then only You can change its Role");
                }
            }
            else { 

            $chkstatus = $this->getUsersRolesTable()->SaveRole($_POST);
                $respArr = array("status"=>2,"Content"=>$chkstatus);
            }



                $response->setContent(json_encode($respArr));
                return $response;
          } 


          public function memberlistingAction()
           {
            $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );

                $Mtype = $_POST['Mtype'];

                    if($_POST['fieldname']=="full_name"){
                        if($Mtype == "all"){
                            $sql = "select ".$_POST['fieldname']." from ".$_POST['table']." where ".$_POST['fieldname']." LIKE '".$_POST['value']."%' ";
                        }
                        else {
                            $sql = "select tbl.".$_POST['fieldname'].",tur.".$_POST['Mtype']." from ".$_POST['table']." as tui 
                        inner join tbl_user_roles as tur on tui.user_id = tur.user_id
                        where ( tur.".$_POST['Mtype']."='1'  and ".$_POST['fieldname']." LIKE '".$_POST['value']."%' )";
                        }
                    }

            else {
                
                $sql = "select * from ".$_POST['table']." where ".$_POST['fieldname']." LIKE '".$_POST['value']."%' ";
            }


                $list = $adapter->query($sql,Adapter::QUERY_MODE_EXECUTE)->toArray();
                $output[] = '<table  width="100%" style="border:none !important;">
                            <tbody>';
             
                    if(count($list)>0){
                             
                            foreach ($list as $row) {
                                $output[] = '<tr>
                                                <td>
                                                    <a href="">aaa</a>
                                                </td>
                                            </tr>';
                                }
                        }
                        else $output[] = '<p>No matched search</p>';

                        $output[] = '</tbody></table>';
    
                       $data = join("",$output);     
            $respArr = array("status"=>1,"Content"=>$data);

                $response->setContent(json_encode($respArr));
                return $response;
          } 


          public function addtositeAction()
          {
            $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

            $date = date("Y-m-d h:i:s");
            $field = $_POST['fieldname'];
            // $response = $this->getResponse();
            // $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
                $sql = "insert into ".$_POST['table']." (".$_POST['fieldname'].",IsActive,created_date,modified_date,modified_by) values('".$_POST['value']."',1,'$date','$date',1)";
               
               $result = $adapter->query($sql,Adapter::QUERY_MODE_EXECUTE);

               $insertid = $adapter->getDriver()->getLastGeneratedValue();

               if($field == "branch_name")
               $upsql = "update tbl_user_info set branch_ids='$insertid',branch_ids_other='' where user_id ='".$_POST['uid']."'";
                    
                if($field == "profession")
               $upsql = "update tbl_user_info set profession='$insertid',profession_other='' where user_id ='".$_POST['uid']."'";

                if($field == "gothra_name")
               $upsql = "update tbl_user_info set gothra_gothram='$insertid',gothra_gothram_other='' where user_id ='".$_POST['uid']."'";
                


               $updateuser = $adapter->query($upsql,Adapter::QUERY_MODE_EXECUTE);
                
               if($updateuser)
                  echo "Updated SuccessFully";
              else echo "couldn't update";
            // print_r($upsql);
            die;
          }
          
          //added by amir...
          
          public function deleteAction()
          {
         
            $id = $this->params()->fromRoute('id');
            //$religion = $this->getReligionTable()->deleteReligion($id);
            $religion= $this->adminService->delete('tbl_religion', $id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'religion'
//                ));
            return $this->redirect()->toRoute('admin/religion', array('action' => 'index'));
          }
    
   
}
