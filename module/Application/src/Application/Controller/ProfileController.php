<?php

namespace Application\Controller;

use Application\Form\AboutForm;
use Application\Form\EducationAndCareerForm;
use Application\Form\EducationForm;
use Application\Form\FamilyInfoForm;
use Application\Form\Filter\EducationAndCareerFormFilter;
use Application\Form\Filter\Family;
use Application\Form\Filter\PersonolDetailFormFilter;
use Application\Form\MetrimoniForm;
use Application\Form\PersonolDetailForm;
use Application\Form\PostForm;
use Application\Form\ProfessionForm;
use Application\Model\Entity\Career;
use Application\Model\Entity\Matrimoni;
use Application\Service\ProfileServiceInterface;
use Application\Service\UserServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Debug\Debug;
use Zend\Json\Json;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mvc\Controller\AbstractController;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\TemplateMapResolver;

class ProfileController extends AppController {

    protected $data = array();
    protected $accountService;
    protected $userService;
    protected $commonService;

    /**
     * Attache les évènements
     * @see AbstractController::attachDefaultListeners()
     */
    protected function attachDefaultListeners() {
        parent::attachDefaultListeners();

        $events = $this->getEventManager();
        $events->attach('dispatch', array($this, 'preDispatch'), 100);
        $events->attach('dispatch', array($this, 'postDispatch'), -100);
    }

    /**
     * Avant l'action
     * @param MvcEvent $e
     */
    public function preDispatch(MvcEvent $e) {
        $this->checkUserLogin();

//         $actioList=array('personal-profile', 'education-and-career');
//         if(in_array($this->params('action'), $actioList)){
//           $this->checkUserLogin();
//         }
    }

    /**
     * Après l'action
     * @param MvcEvent $e
     */
    public function postDispatch(MvcEvent $e) {
        
    }

    public function __construct(ProfileServiceInterface $accountService, CommonServiceInterface $commonService, UserServiceInterface $userService) {
        $this->accountService = $accountService;
        $this->userService = $userService;
        $this->commonService = $commonService;
    }

    public function indexAction() {
        $auth = new AuthenticationService();
        if (!$auth->hasIdentity() && !in_array($auth->getIdentity()->role, array('user'))) {
            return $this->redirect()->toRoute('user', array('action' => 'login'));
            //return $this->toRoute('user',array('action'=>'login'));
        }

        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $data = $adapter->query("select * from tbl_post WHERE is_active=1 ORDER BY id DESC limit 5", Adapter::QUERY_MODE_EXECUTE)->toArray();

        $invitation = $this->getReceivedRequestCount($user_id);
        $sent = $this->getSentRequestCount($user_id);
        $accepted = $this->getAcceptedRequestCount($user_id);

        $acceptedMember = $this->getAcceptedInvitationList($user_id);
        $percentage = $this->userService->ProfileBar($user_id);
        $pro_per = array($percentage, $this->profileBarTemplate($percentage));
        $familyInfo = $this->userService->getFamilyInfoById($user_id);
        $recievedInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'received']);
        $sentInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sent']);
        $acceptedInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'accepted']);
        $newMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'newMembers']);
        $selectedMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'selectedMembers']);
        //// New Code ///
        $sentInvitationList = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'invitationSentMembers']);
        $receivedInvitationList = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'invitationReceivedMembers']);
        //Debug::dump($newMemberInfo);

        $declineRequest = $this->getDeclineRequestCount($user_id);
        $preferredMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'preferredMembers']);
        $MemberbasicForm='';
        return new ViewModel(array("form" => $MemberbasicForm,
            'userSummary' => $this->userService->userSummaryById($user_id),
            'url' => 'personal-profile',
            'post' => $data,
            'invitation' => $invitation,
            'sent' => $sent,
            'accepted' => $accepted,
            'acceptedMember' => $acceptedMember,
            "percent" => $pro_per,
            'receivedMember' => $recievedInfo,
            'sentInfo' => $sentInfo,
            'acceptedInfo' => $acceptedInfo,
            'newMemberInfo' => $newMemberInfo->newMember,
            'selectedMemberInfo' => $selectedMemberInfo,
            "postCategory" => $this->commonService->getPostCategoryList(),
            'familyInfo' => $familyInfo,
            'sentInvitationList' => $sentInvitationList,
            'receivedInvitationList' => $receivedInvitationList,
            'declineRequest' => $declineRequest,
            'preferredMemberInfo' => $preferredMemberInfo));
    }

    public function profileAction() {
        
    }

    public function personalProfileAction() {

       
        //$this->checkLogin();
        //exit;
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        //Debug::dump($userSession->offsetGet('user_type'));
        if ($userSession->offsetGet('user_type') == '1') {
            
            //$personalDetails = new PersonalDetails();
            $info = $this->userService->getUserPersonalDetailById($user_id);
           // var_dump($info); exit;
            $religion=$info->getReligion();
            $community=$info->getCommunity();
            $caste=$info->getCaste();
            $gotra=$info->getGothraGothram();
            $info->setDob(date("d-m-Y", strtotime($info->getDob())));
            $familyInfo = $this->userService->getFamilyInfoById($user_id);
            $MemberbasicForm = new PersonolDetailForm($this->commonService, $religion,$community,$caste);

            $MemberbasicForm->bind($info);
            $request = $this->getRequest();
            if ($request->isPost()) {
                //$page = new Memberbasic();
                //$MemberbasicForm->setInputFilter($page->getInputFilter());
                $MemberbasicForm->setData($request->getPost());
                $MemberbasicForm->setInputFilter(new PersonolDetailFormFilter());
              //  $data = (array) $request->getPost();              //  var_dump($data); exit;
                if ($MemberbasicForm->isValid()) {                    //var_dump('ddd'); exit;
                    //$personalDetailsExchange=new \Application\Model\Entity\PersonalprofileExchange();
                    //$ddad=$personalDetailsExchange->exchangeArrayTable($hydrator->extract($MemberbasicForm->getData()));
                    //Debug::dump($request->getPost()->submit);
                    //exit;
                    $this->userService->saveUserPersonalDetails($info);
                    //exit;
//                $page->exchangeArray($data);
//                unset($page->inputFilter);
//                $page->dob = date('Y-m-d', strtotime($page->dob));
//                $id = $this->getUserInfoTable()->saveUserData($page);
                    // if($id>0){
                    //   }
//                if ($button == "Save") {
//                    return $this->redirect()->toRoute('application/default', array(
//                                'action' => 'memberbasic',
//                                'controller' => 'account'
//                    ));
//                }
                    if ($request->getPost()->submit == "Save & Next") {
                        $this->redirect()->toRoute("profile", array(
                            "action" => "education-and-career",
                        ));
                    }
                }
            }

            $percentage = $this->userService->ProfileBar($user_id);
            $pro_per = array($percentage, $this->profileBarTemplate($percentage));
            //Debug::dump($this->userService->userSummaryById($user_id));
            return new ViewModel(array("form" => $MemberbasicForm,
                'userSummary' => $this->userService->userSummaryById($user_id),
                'url' => 'personal-profile',
                'familyInfo' => $familyInfo,
                "percent" => $pro_per));
        }
        if ($userSession->offsetGet('user_type') == '2') {
            //Debug::dump('satya');
            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $MemberbasicForm = new \Application\Form\PersonolDetailMatrimonialForm($this->commonService);

            //$info = $this->userService->getUserPersonalDetailById($user_id);
            $info = $this->userService->getUserPersonalDetailByIdMatrimonial($user_id);
            //Debug::dump($info);exit;
            //Debug::dump($this->userService->getUserPersonalDetailByIdMatrimonial($user_id));exit;    
            //$info->setDob(date("d-m-Y", strtotime($info->getDob())));
            //$familyInfo = $this->userService->getFamilyInfoById($user_id);
            $MemberbasicForm->get('profile_for')->setValue($info['profile_for']);
            $MemberbasicForm->get('name_title_user')->setValue($info['name_title_user']);
            $MemberbasicForm->get('full_name')->setValue($info['full_name']);
            $MemberbasicForm->get('last_name')->setValue($info['last_name']);
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
            $MemberbasicForm->get('community')->setValue($info['community']);
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



//            $MemberbasicForm->get('religion')->setValue($info['religion']);
//            $MemberbasicForm->get('religion')->setValue($info['religion']);
//            $MemberbasicForm->get('religion')->setValue($info['religion']);
//            $MemberbasicForm->get('religion')->setValue($info['religion']);
            //$MemberbasicForm->get('height')->setValue($info['height']);
            $MemberbasicForm->get('address')->setValue($info['address']);
            $MemberbasicForm->get('country')->setValue($info['country']);
            $MemberbasicForm->get('state')->setValue($info['state']);
            $MemberbasicForm->get('city')->setValue($info['city']);
            $MemberbasicForm->get('zip_pin_code')->setValue($info['pincode']);
            //$MemberbasicForm->bind($info);
            $request = $this->getRequest();
            if ($request->isPost()) {
                //$page = new Memberbasic();
                //$MemberbasicForm->setInputFilter($page->getInputFilter());
                $MemberbasicForm->setData($request->getPost());
                $MemberbasicForm->setInputFilter(new \Application\Form\Filter\PersonolDetailMatrimonialFormFilter());
                //$data = (array) $request->getPost();
                if ($MemberbasicForm->isValid()) {
                    $formdata = $MemberbasicForm->getData();                  //  var_dump($formdata); exit;
                    $formdata['user_id'] = $user_id;
                    //$personalDetailsExchange=new \Application\Model\Entity\PersonalprofileExchange();
                    //$ddad=$personalDetailsExchange->exchangeArrayTable($hydrator->extract($MemberbasicForm->getData()));
                    //Debug::dump($request->getPost()->submit);
                    //exit;
                    $this->userService->saveUserPersonalDetailsMatrimonial($formdata);
                    //exit;
//                $page->exchangeArray($data);
//                unset($page->inputFilter);
//                $page->dob = date('Y-m-d', strtotime($page->dob));
//                $id = $this->getUserInfoTable()->saveUserData($page);
                    // if($id>0){
                    //   }
//                if ($button == "Save") {
//                    return $this->redirect()->toRoute('application/default', array(
//                                'action' => 'memberbasic',
//                                'controller' => 'account'
//                    ));
//                }
                    if ($request->getPost()->submit == "Save & Next") {
                        $this->redirect()->toRoute("profile", array(
                            "action" => "education-and-career",
                        ));
                    }
                    return new JsonModel($_POST);
                }
                else{
                    echo $errors = $MemberbasicForm->getMessages();
                    Debug::dump($errors);
                    exit;
                }
            }

            $percentage = $this->userService->ProfileBarMatrimonial($user_id);
            $pro_per = array($percentage, $this->profileBarTemplate($percentage));
            //Debug::dump($this->userService->userSummaryByIdMatrimonial($user_id));exit;
            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

            $sql = "select * from tbl_user_gallery_matrimonial where user_id='$user_id' AND user_type='U' AND image_type='1' ORDER BY id DESC";
            $image = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
            
            $sidebarLeft = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarLeftMatrimonial']);
            $sidebarRight = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarRightMatrimonial']);
            
            $viewModel = new ViewModel(array("form" => $MemberbasicForm,
                'userSummary' => $this->userService->userSummaryByIdMatrimonial($user_id),
                'url' => 'personal-profile',
                'profile_pic' => $image,
                'user_id' => $user_id,
                "percent" => $pro_per));
            if ($request->isXmlHttpRequest()) {
                $viewModel->setTemplate('application/profile/personal-profile-matrimonial.phtml');
                $viewModel->setTerminal(true);
            } else {
                $viewModel->setTemplate('application/profile/personal-profile-matrimonial-ajax.phtml');
            }
              
            $viewModel->addChild($sidebarLeft, 'sidebarLeft');
            $viewModel->addChild($sidebarRight, 'sidebarRight');
            return $viewModel;
        }
    }

    public function LogoutAction() {
        $session = new Container('user');
        $session->getManager()->getStorage()->clear('user');
        return $this->redirect()->toRoute("application/default", array('controller' => 'index', 'action' => 'index'));
    }

    public function personalDetailAction() {

        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $MemberbasicForm = new PersonolDetailForm($this->commonService);
        //$personalDetails = new PersonalDetails();
        $info = $this->userService->getUserPersonalDetailById($user_id);
        $MemberbasicForm->bind($info);
        $request = $this->getRequest();
        if ($request->isPost()) {
            //$page = new Memberbasic();
            //$MemberbasicForm->setInputFilter($page->getInputFilter());
            $MemberbasicForm->setData($request->getPost());
            //$data = (array) $request->getPost();
            if ($MemberbasicForm->isValid()) {
                //$personalDetailsExchange=new \Application\Model\Entity\PersonalprofileExchange();
                //$ddad=$personalDetailsExchange->exchangeArrayTable($hydrator->extract($MemberbasicForm->getData()));
                //Debug::dump($request->getPost()->submit);
                //exit;
                $this->userService->saveUserPersonalDetails($info);
                //exit;
//                $page->exchangeArray($data);
//                unset($page->inputFilter);
//                $page->dob = date('Y-m-d', strtotime($page->dob));
//                $id = $this->getUserInfoTable()->saveUserData($page);
                // if($id>0){
                //   }
//                if ($button == "Save") {
//                    return $this->redirect()->toRoute('application/default', array(
//                                'action' => 'memberbasic',
//                                'controller' => 'account'
//                    ));
//                }
                if ($request->getPost()->submit == "Save & Next") {
                    $this->redirect()->toRoute("application/default", array(
                        "action" => "editeducation",
                        "controller" => "account",
                    ));
                }
            }
        }

        $percentage = $this->userService->ProfileBar($user_id);
        $pro_per = array($percentage, $this->profileBarTemplate($percentage));

        return new ViewModel(array("form" => $MemberbasicForm,
            'userSummary' => $this->userService->userSummaryById($user_id),
            "percent" => $pro_per));
    }

    public function educationAndCareerAction() {

        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        if ($userSession->offsetGet('user_type') == '1') {
            $form = new EducationAndCareerForm($this->commonService);
            $data = $this->userService->getUserEducationAndCareerDetailById($user_id);
            $familyInfo = $this->userService->getFamilyInfoById($user_id);
            $form->bind($data);
            $request = $this->getRequest();

            if ($request->isPost()) {
                $form->setInputFilter(new EducationAndCareerFormFilter());
                $form->setData($request->getPost());
                if ($form->isValid()) {

                    $this->userService->saveUserEducationAndCareerDetail($data);
                    if ($request->getPost()->submit == "Save & Next") {
                        $this->redirect()->toRoute("profile", array(
                            "action" => "family-detail",
                        ));
                    }
                }
            }
            //$data_gallery = $adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
            $percentage = $this->userService->ProfileBar($user_id);
            $pro_per = array($percentage, $this->profileBarTemplate($percentage));
            //Debug::dump($pro_per);




            return new ViewModel(array("form" => $form,
                'userSummary' => $this->userService->userSummaryById($user_id),
                'url' => 'education-and-career',
                'familyInfo' => $familyInfo,
                "percent" => $pro_per));
        }
        if ($userSession->offsetGet('user_type') == '2') {
            $form = new \Application\Form\EducationAndCareerFormMatrimonial($this->commonService);
            $info = $this->userService->getEducationAndCareerByIdMatrimonial($user_id);
            //Debug::dump($info);
            //$familyInfo = $this->userService->getFamilyInfoById($user_id);
            //$form->bind($data);
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
            $form->get('office_state')->setValue($info['office_city']);
            $form->get('office_city')->setValue($info['education_level_id']);
            $form->get('office_address')->setValue($info['office_address']);
            $form->get('office_pincode')->setValue($info['office_pincode']);
            $form->get('annual_income_status')->setValue($info['annual_income_status']);
            $request = $this->getRequest();

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


            $viewModel = new ViewModel(array("form" => $form,
                //'userSummary' => $this->userService->userSummaryByIdMatrimonial($user_id),
                'url' => 'education-and-career',
                'user_id' => $user_id,
                    //'familyInfo' => $familyInfo,
                    //"percent" => $pro_per
            ));
            $viewModel->setTemplate('application/profile/education-and-career-matrimonial.phtml');
            $viewModel->setTerminal(true);
            return $viewModel;
        }
    }

    public function educationAction() {

        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $EducationForm = new EducationForm($this->commonService);
        //$educationDetails = new Education();
        $info = $this->userService->educationDetailById($user_id);
        $EducationForm->bind($info);
        $request = $this->getRequest();




//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $session = new Container('user');
//        $user_id = $session->offsetGet('id');
//        $ref_no = $session->offsetGet('ref_no');
//        $education_level = $this->getEducationLevelTable()->selectList(array('id', 'education_level'));
//        EducationForm::$educationList = $education_level;
//        $education_field = $this->getEducationFieldTable()->selectList(array('id', 'education_field'));
//        EducationForm::$education_fieldList = $education_field;
//        EducationForm::$Employment_status = $this->EmploymentStatus();
//        $professionList = $this->getProfessionTable()->selectList(array('id', 'profession'));
//        EducationForm::$professionTypeList = $professionList;
//        $udata = $this->getUserInfoTable()->GetUserEducation($session->offsetGet('id'));
//        $EducationForm = new EducationForm();
//        $info = $this->userService->educationDetailById($user_id);
//        $educationDetails = new Education();
//        $EducationForm->bind($educationDetails->exchangeArray($info));
//        $request = $this->getRequest();
        if ($request->isPost()) {
//            $page = new Education();
//            $EducationForm->setInputFilter($page->getInputFilter());

            $EducationForm->setData($request->getPost());
            //$data = (array) $request->getPost();
            if ($EducationForm->isValid()) {

                //Debug::dump($info);
                //exit;
                $this->userService->saveUserEducationDetails($info);
//                unset($page->inputFilter);
//                $id = $this->getUserInfoTable()->saveUserEducation($page);
                // if($id>0){
                // return $this->redirect()->toRoute('application/default', array(
                // 			'action' => 'editeducation',
                // 			'controller' => 'account'
                // ));
                //   }


                if ($request->getPost()->submit == "Save & Next") {
                    $this->redirect()->toRoute("application/default", array(
                        "action" => "editcareer",
                        "controller" => "account",
                    ));
                }
            }
        }
        //$data_gallery = $adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
        //$pro_per = $this->ProfileBar();

        return new ViewModel(array("form" => $EducationForm));
    }

    public function professionAction() {

        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $professionForm = new ProfessionForm($this->commonService);
        //$educationDetails = new Education();
        $info = $this->userService->getUserProfessionById($user_id, array('id', 'ref_no'));
        //Debug::dump($info);
        //exit;
        $professionForm->bind($info);
        $request = $this->getRequest();

//        $CareerForm = new CareerForm();
//        $CareerForm->bind($udata);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $page = new Career();
            $CareerForm->setInputFilter($page->getInputFilter());
            $CareerForm->setData($request->getPost());
            $data = (array) $request->getPost();
            //if($CareerForm->isValid()) {					/
            $page->exchangeArray($data);
            unset($page->inputFilter);
            $id = $this->getUserInfoTable()->saveUserCareer($page);
            // if($id>0){
            // return $this->redirect()->toRoute('application/default', array(
            // 			'action' => 'editcareer',
            // 			'controller' => 'account'
            // ));
            //   }


            if ($request->getPost()->submit == "Save & Next") {
                $this->redirect()->toRoute("application/default", array(
                    "action" => "family",
                    "controller" => "account",
                ));
            }
            //}          			
        }
        //$data_gallery = $adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
        //$pro_per = $this->ProfileBar();

        return new ViewModel(array("form" => $professionForm));
    }

    public function familyDetailAction() {
        //copy(PUBLIC_PATH.'/temp/14786025545.jpg', PUBLIC_PATH . "/uploads/197__Unknown/14786025545.jpg");
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        if ($userSession->offsetGet('user_type') == '1') {
            FamilyInfoForm::$Employment_status = $this->LiveStatus();
            FamilyInfoForm::$Family_Values = $this->FamilyValuesStatus();
            FamilyInfoForm::$Name_Title = $this->GetNameTitle();
            //$familyInfo = $this->getFamilyInfoTable()->getFamilyInfo($session->offsetGet('id'));
            // print_r($udata->mother_photo);die;
            $FamilyInfoForm = new FamilyInfoForm();
            $familyInfo = $this->userService->getFamilyInfoById($user_id);           // var_dump($familyInfo); exit;           
            //$userInfo = $this->userService->getUserInfoById($user_id, array('marital_status'));
            $userInfo = $this->userService->getUserInfoById($user_id);
            //Debug::dump($userInfo);
            //Debug::dump($familyInfo->brotherData);
            //\Zend\Debug\Debug::dump($this->userService->getFamilyInfoById($user_id));
            //exit;
            //$FamilyInfoForm->get('user_id')->setValue($session->offsetGet('id'));
//        foreach ($familyInfo->brotherData as $results) {
//            \Zend\Debug\Debug::dump($results);
//        }
            //\Zend\Debug\Debug::dump($familyInfo->brotherData);
            //exit;
            //\Zend\Debug\Debug::dump($familyInfo->familyInfoObject);
            $FamilyInfoForm->bind($familyInfo->familyInfoObject);
            $FamilyInfoForm->get('father_dod')->setValue($this->myDate($familyInfo->familyInfoArray['dod']));
            $request = $this->getRequest();
            //print_r($request->isPost());
            //exit;
            if ($request->isPost()) {
            //print_r($request->getPost());
            //exit;
                $this->userService->saveFamilyInfo($user_id, $request->getPost());
                if ($request->getPost()->submit == "Save & Next") {
                    $this->redirect()->toRoute("profile", array(
                        "action" => "post",
                    ));
                }

                $this->redirect()->toRoute("profile", array(
                    "action" => "family-detail",
                ));

                // Debug::dump($request->getPost());
                //exit;
                //$page = new Family();
//            $FamilyInfoForm->setInputFilter(new Family());
//            $FamilyInfoForm->setData($request->getPost());
//            if ($FamilyInfoForm->isValid()) {
//                //Debug::dump($request->getPost());
//                //exit;
//                $this->userService->saveFamilyInfo($user_id, $request->getPost());
//                $this->redirect()->toRoute("profile", array(
//                    "action" => "family-detail",
//                ));
//                //Debug::dump();
//                //exit;
//            } elseif (!$FamilyInfoForm->isValid()) {
//
//                $errors = $FamilyInfoForm->getMessages();
//                foreach ($errors as $key => $row) {
//                    if (!empty($row) && $key != 'submit') {
//                        foreach ($row as $keyer => $rower) {
//                            //save error(s) per-element that
//                            //needed by Javascript
//                            $messages[$key][] = $rower;
//                        }
//                    }
//                }
//            }
                // Debug::dump($messages);
                // exit;
                // \Zend\Debug\Debug::dump($request->getPost());
            }


            $percentage = $this->userService->ProfileBar($user_id);
            $pro_per = array($percentage, $this->profileBarTemplate($percentage));
            //Debug::dump($pro_per);


            $broDataJson = Json::encode($familyInfo->brotherData);
            $sisDataJson = Json::encode($familyInfo->sisterData);
            $kidsDataJson = Json::encode($familyInfo->kidsData);

            //Debug::dump($familyInfo->brotherData); 
            //Debug::dump($familyInfo->sisterData); 
            // Debug::dump($familyInfo->kidsData);
            // Debug::dump($familyInfo->familyInfoArray);
            return new ViewModel(array("form" => $FamilyInfoForm,
                'userInfo' => $userInfo,
                'familyInfoObject' => $familyInfo->familyInfoObject,
                'brotherData' => $familyInfo->brotherData,
                'sisterData' => $familyInfo->sisterData,
                'kidsData' => $familyInfo->kidsData,
                'broDataJson' => $broDataJson,
                'sisDataJson' => $sisDataJson,
                'kidsDataJson' => $kidsDataJson,
                'familyInfoArray' => $familyInfo->familyInfoArray,
                'GalleryInfo' => $familyInfo->GalleryInfo,
                'userSummary' => $this->userService->userSummaryById($user_id),
                'url' => 'family-detail',
                'familyInfo' => $familyInfo,
                'user_id' => $user_id,
                "percent" => $pro_per));
        }
        if ($userSession->offsetGet('user_type') == '2') {
            //\Application\Form\FamilyInfoFormMatrimonial::$Employment_status = $this->LiveStatus();
            \Application\Form\FamilyInfoFormMatrimonial::$Family_Values = $this->FamilyValuesStatus();
            \Application\Form\FamilyInfoFormMatrimonial::$Name_Title = $this->GetNameTitle();
            $userInfo = $this->userService->getUserInfoByIdMatrimonial($user_id);
            $brotherData = $this->userService->getBrotherMatrimonial($user_id);
            $fatherData = $this->userService->getFatherMatrimonial($user_id);
            $motherData = $this->userService->getMotherMatrimonial($user_id);
            $sisterData = $this->userService->getSisterMatrimonial($user_id);
            $kidsData = $this->userService->getKidMatrimonial($user_id);
            $spouseData = $this->userService->getSpouseMatrimonial($user_id);
            //Debug::dump($fatherData);exit;
            //$familyInfo = $this->getFamilyInfoTable()->getFamilyInfo($session->offsetGet('id'));
            //print_r($userInfo);die;
            $FamilyInfoForm = new \Application\Form\FamilyInfoFormMatrimonial();
            //$familyInfo = $this->userService->getFamilyInfoById($user_id);
            //$userInfo = $this->userService->getUserInfoById($user_id, array('marital_status'));
            //$userInfo = $this->userService->getUserInfoById($user_id);
            //Debug::dump($userInfo);
            //Debug::dump($familyInfo->brotherData);
            //\Zend\Debug\Debug::dump($this->userService->getFamilyInfoById($user_id));
            //exit;
            //$FamilyInfoForm->get('user_id')->setValue($session->offsetGet('id'));
//        foreach ($familyInfo->brotherData as $results) {
//            \Zend\Debug\Debug::dump($results);
//        }
            //\Zend\Debug\Debug::dump($familyInfo->brotherData);
            //exit;
            //\Zend\Debug\Debug::dump($familyInfo->familyInfoObject);
            //$FamilyInfoForm->bind($familyInfo->familyInfoObject);
            //$FamilyInfoForm->get('marital_status')->setValue($userInfo['marital_status']);
            $FamilyInfoForm->get('family_values')->setValue($userInfo['family_values_status']);
            $FamilyInfoForm->get('name_title_father')->setValue($fatherData['title']);
            $FamilyInfoForm->get('father_name')->setValue($fatherData['name']);
            $FamilyInfoForm->get('father_last_name')->setValue($fatherData['last_name']);
            $FamilyInfoForm->get('father_dob')->setValue($this->myDate($fatherData['dob']));
            $FamilyInfoForm->get('father_status')->setValue($fatherData['status']);
            $FamilyInfoForm->get('father_dod')->setValue($this->myDate($fatherData['dod']));
            $FamilyInfoForm->get('about_father')->setValue($fatherData['about']);
            $FamilyInfoForm->get('father_id')->setValue($fatherData['id']);


            $FamilyInfoForm->get('name_title_mother')->setValue($motherData['title']);
            $FamilyInfoForm->get('mother_name')->setValue($motherData['name']);
            $FamilyInfoForm->get('mother_last_name')->setValue($motherData['last_name']);
            $FamilyInfoForm->get('mother_dob')->setValue($this->myDate($motherData['dob']));
            $FamilyInfoForm->get('mother_status')->setValue($motherData['status']);
            $FamilyInfoForm->get('mother_dod')->setValue($this->myDate($motherData['dod']));
            $FamilyInfoForm->get('about_mother')->setValue($motherData['about']);
            $FamilyInfoForm->get('mother_id')->setValue($motherData['id']);



            $request = $this->getRequest();
            //Debug::dump($this->myDate($spouseData['dob']));
            //exit;
            if ($request->isPost()) {
                $formdata = $request->getPost();
                if ($formdata['brother_id_delete']) {
                    $this->userService->deleteBrotherMatrimonial($formdata['brother_id_delete']);
                    //Debug::dump($request->getPost());
                }


                $formdata['user_id'] = $user_id;
                $this->userService->saveFamilyInfoMatrimonial($formdata);

                if ($request->getPost()->submit == "Save & Next") {
                    $this->redirect()->toRoute("profile", array(
                        "action" => "post",
                    ));
                }


                //echo 'satya';
//            $this->redirect()->toRoute("profile", array(
//                "action" => "family-detail",
//            ));
            }





//        $broDataJson = Json::encode($familyInfo->brotherData);
//        $sisDataJson = Json::encode($familyInfo->sisterData);
//        $kidsDataJson = Json::encode($familyInfo->kidsData);
            //Debug::dump($brotherData); 
            // exit;
            //Debug::dump($userInfo); 
            // Debug::dump($familyInfo->kidsData);
            // Debug::dump($familyInfo->familyInfoArray);
            $viewModel = new ViewModel(array("form" => $FamilyInfoForm,
                'userInfo' => $userInfo,
//            'familyInfoObject' => $familyInfo->familyInfoObject,
                'brotherData' => $brotherData,
                'fatherData' => $fatherData,
                'motherData' => $motherData,
                'sisterData' => $sisterData,
                'kidsData' => $kidsData,
                'spouseData' => $spouseData,
//            'kidsData' => $familyInfo->kidsData,
//            'broDataJson' => $broDataJson,
//            'sisDataJson' => $sisDataJson,
//            'kidsDataJson' => $kidsDataJson,
//            'familyInfoArray' => $familyInfo->familyInfoArray,
//            'GalleryInfo' => $familyInfo->GalleryInfo,
//            'userSummary' => $this->userService->userSummaryById($user_id),
//            'url' => 'family-detail',
//            'familyInfo' => $familyInfo,
            ));

            $viewModel->setTemplate('application/profile/family-detail-matrimonial.phtml');
            $viewModel->setTerminal(true);
            return $viewModel;
        }
    }

    public function matrimoniAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $session = new Container('user');
        $user_id = $session->offsetGet('id');
        $ref_no = $session->offsetGet('ref_no');
        $religion_name = $this->getReligionTable()->selectList(array('id', 'religion_name'));
        $gothra_name = $this->getGothraTable()->selectList(array('id', 'gothra_name'));
        MetrimoniForm::$gothra_nameList = $gothra_name;
        MetrimoniForm::$religion_nameList = $religion_name;
        MetrimoniForm::$blood_group = $this->BloodGroup();
        MetrimoniForm::$marital_status = $this->MeritalStatus();
        $MetrimoniForm = new MetrimoniForm();
        $udata = $this->getUserInfoTable()->GetUserMatrimoni($session->offsetGet('id'));
        $MetrimoniForm = new MetrimoniForm();
        $id = $udata->id;
        $MetrimoniForm->bind($udata);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $page = new Matrimoni();
            $MetrimoniForm->setInputFilter($page->getInputFilter());
            $MetrimoniForm->setData($request->getPost());
            $data = (array) $request->getPost();
            if ($MetrimoniForm->isValid()) {
                $page->exchangeArray($data);
                unset($page->inputFilter);
                $page->id = $id;
                $page->user_id = $session->offsetGet('id');
                $id = $this->getUserInfoTable()->saveUserMatrimoni($page);
                if ($id > 0) {
                    return $this->redirect()->toRoute('application/default', array(
                                'action' => 'editmatrimoni',
                                'controller' => 'account'
                    ));
                }
            }
        }
        $data_gallery = $adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);

        $pro_per = $this->ProfileBar();


        return new ViewModel(array("form" => $MetrimoniForm, "gallery_data" => $data_gallery));
    }

    public function aboutAction() {

        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');

        //Debug::dump($ref_no)
        if ($userSession->offsetGet('user_type') == '1') {

            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $form = new AboutForm();
            $info = $this->userService->getUserAboutById($user_id);
            $familyInfo = $this->userService->getFamilyInfoById($user_id);
            //Debug::dump($info);
            //exit;
            $form->bind($info);
            $request = $this->getRequest();
            if ($request->isPost()) {
                $form->setData($request->getPost());
                if ($form->isValid()) {

                    $this->userService->saveUserAbout($info);
                    if ($request->getPost('about_meSave') == "Save & Next") {
                        $this->redirect()->toRoute("profile", array(
                            "action" => "personal-profile",
                        ));
                    }
                }
                //$text = $request->getPost("about_Yourself");
                //Debug::dump(trim($text));
                //exit;
                //$adapter->query("UPDATE tbl_user_info set about_yourself_partner_family='$text' where user_id='$user_id' AND ref_no='$ref_no'", Adapter::QUERY_MODE_EXECUTE);
            }
            //$data = $adapter->query("select about_yourself_partner_family as about_me from tbl_user_info where user_id='$user_id' AND ref_no='$ref_no'", Adapter::QUERY_MODE_EXECUTE);
            //$data_gallery = $adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
            //Debug::dump($request->getPost('about_meSave'));
            // exit;



            $percentage = $this->userService->ProfileBar($user_id);
            $pro_per = array($percentage, $this->profileBarTemplate($percentage));

            return new ViewModel(array("form" => $form,
                'userSummary' => $this->userService->userSummaryById($user_id),
                'url' => 'about',
                'familyInfo' => $familyInfo,
                "percent" => $pro_per));
        }

        if ($userSession->offsetGet('user_type') == '2') {

            //return $_POST;

            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $form = new \Application\Form\AboutFormMatrimonial();
            $info = $this->userService->getUserAboutByIdMatrimonial($user_id);
            //Debug::dump($info);exit;
            //$info = $this->userService->getUserAboutById($user_id);
            //$familyInfo = $this->userService->getFamilyInfoById($user_id);
            //Debug::dump($info);
            //exit;
            //$form->bind($info);
            $form->get('about_me')->setValue($info['about_me']);
            $request = $this->getRequest();
            if ($request->isPost()) {

                $form->setData($request->getPost());

                //return new JsonModel($_POST);


                if ($form->isValid()) {
                    //Debug::dump($form->getData());exit;
                    $this->userService->saveUserAboutMatrimonial($user_id, $form->getData());
                    if ($request->getPost('about_meSave') == "Save & Next") {
                        $this->redirect()->toRoute("profile", array(
                            "action" => "personal-profile",
                        ));
                    }
                    return new JsonModel($_POST);
                }
                //$text = $request->getPost("about_Yourself");
                //Debug::dump(trim($text));
                //exit;
                //$adapter->query("UPDATE tbl_user_info set about_yourself_partner_family='$text' where user_id='$user_id' AND ref_no='$ref_no'", Adapter::QUERY_MODE_EXECUTE);
            }
            //$data = $adapter->query("select about_yourself_partner_family as about_me from tbl_user_info where user_id='$user_id' AND ref_no='$ref_no'", Adapter::QUERY_MODE_EXECUTE);
            //$data_gallery = $adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
            //Debug::dump($request->getPost('about_meSave'));
            // exit;



            $percentage = $this->userService->ProfileBarMatrimonial($user_id);
            $pro_per = array($percentage, $this->profileBarTemplate($percentage));
            //Debug::dump($this->userService->userSummaryByIdMatrimonial($user_id));exit;    

            $viewModel = new ViewModel(array("form" => $form,
                'userSummary' => $this->userService->userSummaryByIdMatrimonial($user_id),
                'url' => 'about',
                'user_id' => $user_id,
                //'familyInfo' => $familyInfo,
                "percent" => $pro_per
            ));
            $viewModel->setTemplate('application/profile/about_matrimonial.phtml');
            $viewModel->setTerminal(true);
            return $viewModel;
        }
    }

    public function galleryMatrimonialAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');

        $sql = "select * from tbl_user_gallery_matrimonial where user_id='$user_id' AND user_type='U' ORDER BY id DESC limit 6";
        $image = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();

        $viewModel = new ViewModel(array(
            'image' => $image,
            //'url' => 'gallery',
            'user_id' => $user_id,
                //'familyInfo' => $familyInfo,
                //"percent" => $pro_per
        ));
        $viewModel->setTemplate('application/profile/gallery-matrimonial.phtml');
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function mygalleryAction() {
        //Debug::dump($this->options->getBasePath());
        //\Zend\Debug\Debug::dump(PUBLIC_PATH);
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $familyInfo = $this->userService->getFamilyInfoById($user_id);

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC limit 6";
        $data = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
        //Debug::dump($data); die;
//        $metadata = new Metadata($adapter);
//        $table = $metadata->getTable("tbl_family_info");
//        $table->getColumns();
//
//        foreach ($table->getColumns() as $column) {
//            if (strpos($column->getName(), "photo")) {
//                $columns[] = $column->getName();
//            }
//        }
        // foreach ($columns as $key => $value) {
        //$Fdata = $adapter->query("select * from tbl_family_info where user_id='$user_id' ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
        // }
//        foreach ($Fdata as $F_data) {
//            foreach ($columns as $key => $value) {
//                if (empty($F_data->$value))
//                    continue;
//                else
//                    $Fphotos[] = $F_data->$value;
//            }
//        }
        if ($data != "") {
            foreach ($data as $P_data) {
                foreach ($P_data as $key => $value) {

                    if ($key == "image_path")
                        $Pphotos[] = $value;
                }
            }
            shuffle($Pphotos);
        }



//        Family data 
        foreach ($familyInfo->brotherData as $brothres) {

            $ids[] = $brothres['user_id'];
        }

        foreach ($familyInfo->sisterData as $sisters) {

            $ids[] = $sisters['user_id'];
        }

        $ids[] = $familyInfo->familyInfoArray['father_id'];
        $ids[] = $familyInfo->familyInfoArray['mother_id'];
        $ids = rtrim(implode(',', $ids), ',');
        //Debug::dump($ids);
        //die;
        //rtrim($my_string,',');
        $sql1 = "select * from tbl_user_gallery where user_id IN ('$ids') ORDER BY id DESC";
        $Fdata = $adapter->query($sql1, Adapter::QUERY_MODE_EXECUTE);
        if ($Fdata != "") {
            foreach ($Fdata as $F_data) {
                $Fphotos[] = $F_data['image_path'];
                //echo '<pre>';
                //print_r($F_data['image_path']);
            }

            //echo '<pre>';
            //print_r($Fphotos);
            shuffle($Fphotos);
        }
        $data_gallery = $adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);

        $percentage = $this->userService->ProfileBar($user_id);
        $pro_per = array($percentage, $this->profileBarTemplate($percentage));

//        return new ViewModel(array("form" => $form,
//            'userSummary' => $this->userService->userSummaryById($user_id),
//            "percent" => $pro_per));

        return new ViewModel(array("Pphotos" => $Pphotos,
            "F_photos" => $Fphotos,
            "gallery_data" => $data_gallery,
            'userSummary' => $this->userService->userSummaryById($user_id),
            'url' => 'mygallery',
            'familyInfo' => $familyInfo,
            "percent" => $pro_per));
    }

    public function showAllImagesMatrimonialGalleryAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $session = new Container('user');
        $user_id = $session->offsetGet('id');
        $ref_no = $session->offsetGet('ref_no');

        $sql = "select * from tbl_user_gallery_matrimonial where user_id='$user_id' AND user_type='U' ORDER BY id DESC limit 6";
        $data = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();

        $viewModel = new JsonModel();
        $viewModel->setVariables($data);
        return $viewModel;
    }

    public function showallimagesAction() {

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $session = new Container('user');
        $user_id = $session->offsetGet('id');
        $ref_no = $session->offsetGet('ref_no');
        $familyInfo = $this->userService->getFamilyInfoById($user_id);






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
            $action = $this->url()->fromRoute('profile', array('action' => 'delselected'));
            $output[] = "<input class='btn btn-default' type='button' style='float:right;' onclick='delselected(&quot;showallimages&quot;,&quot;$action&quot;,delselectedresults)' value='delete selected'><br><br>";

            foreach ($photos as $key => $value) {
                $title = (!(int) $value[1]) ? ucwords(str_replace("_", " ", $value[1])) : "";
                //echo '<pre>';
                //print_r($value);

                $output[] = '<div class="col-sm-3"><img src="/uploads/' . $value[0] . '" onmouseover="showchck(this)" onmouseout="hidechck(this)" onclick="selectchk(this)" class="moreimgthambdeleat imghover"/>

    <div class="deleteimg"> 
    	<input type="checkbox" name="delimages&#91;&#93;" value="' . $value[1] . '" />
    	<input type="hidden" name="id_field" value="' . $value[1] . '" />
        <input type="hidden" name="path" value="' . $value[0] . '" />
    </div>
    <div class="familytitles">' . $title . '</div>
    </div>';
            }
            $output[] = "<input type='hidden' name='type' value='" . $_POST['type'] . "'><input type='hidden' name='uid' value='" . $user_id . "'>";
            // echo join("",$output);
        } else {

//print_r(implode(',', $ids));
            //exit;
            //$action = $server_url = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost() . "/account/delselected";
            $action = $this->url()->fromRoute('profile', array('action' => 'delselected'));
            //echo $action;
            //$action='dcvdvfdb';
            $output[] = "<input class='btn btn-default' type='button' style='float:right;' onclick='delselected(&quot;showallimages&quot;,&quot;$action&quot;,delselectedresults)' value='delete selected'><br><br>";
            foreach ($familyInfo->brotherData as $brothres) {

                $idsBrothers[] = $brothres['user_id'];
            }
            $Fdata = $adapter->query("select * from tbl_user_gallery where user_id IN (" . implode(',', $idsBrothers) . ") ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
            foreach ($Fdata as $F_data) {
                //print_r($F_data);
                $title = 'Brother photo';
                $Name = '';

                $output[] = '<div class="col-sm-3"><img src="/uploads/' . $F_data['image_path'] . '" onmouseover="showchck(this)" onmouseout="hidechck(this)" onclick="selectchk(this)" class="moreimgthambdeleat imghover"/>
                                <div class="deleteimg"> 
    	                           <input type="checkbox" name="delimages&#91;&#93;" value="' . $F_data['id'] . '" />
    	                           <input type="hidden" name="id_field" value="' . $F_data['user_id'] . '" />
                                       
                                </div>
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
                                <div class="deleteimg"> 
    	                           <input type="checkbox" name="delimages&#91;&#93;" value="' . $F_data['id'] . '" />
    	                           <input type="hidden" name="id_field" value="' . $F_data['user_id'] . '" />
                                </div>
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
                                <div class="deleteimg"> 
    	                           <input type="checkbox" name="delimages&#91;&#93;" value="' . $F_data['id'] . '" />
    	                           <input type="hidden" name="id_field" value="' . $F_data['user_id'] . '" />
                                </div>
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
                                <div class="deleteimg"> 
    	                           <input type="checkbox" name="delimages&#91;&#93;" value="' . $F_data['id'] . '" />
    	                           <input type="hidden" name="id_field" value="' . $F_data['user_id'] . '" />
                                </div>
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

    public function delselectedAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        //echo '<pre>';
        //print_r($_POST);
        //exit;
        $sqlData = $adapter->query("SELECT * FROM tbl_user_gallery WHERE id IN(" . $_POST['idfield'] . ")");
        $res = $sqlData->execute();
        if ($_POST['Itype'] == "Personal") {
            foreach ($res as $result) {
                unlink(PUBLIC_PATH . '/uploads/' . $result['image_path']);
                unlink(PUBLIC_PATH . '/uploads/thumb/100x100/' . $result['image_path']);
            }
            $sql = "delete from tbl_user_gallery where id IN(" . $_POST['idfield'] . ")";
        } else if ($_POST['Itype'] == "Family") {
            foreach ($res as $result) {
                unlink(PUBLIC_PATH . '/uploads/' . $result['image_path']);
                unlink(PUBLIC_PATH . '/uploads/thumb/100x100/' . $result['image_path']);
            }
            $sql = "delete from tbl_user_gallery where id IN(" . $_POST['idfield'] . ")";
        }
        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        echo ($result) ? "deleted Successfully" : "Couldn't perform your request";
        die;
    }

    public function AjaxImgUploadAction() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_FILES['img_file']['name'];
            $tmpName = $_FILES['img_file']['tmp_name'];
            $error = $_FILES['img_file']['error'];
            $size = $_FILES['img_file']['size'];
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            switch ($error) {
                case UPLOAD_ERR_OK:
                    $valid = true;
                    //validate file extensions
                    if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif'))) {
                        $valid = false;
                        $response = "Invalid file extension. Only( jpg, jpeg, png, gif ) are allowed";
                    }
                    //validate file size
                    if ($size / 1024 / 1024 > 2) {
                        $valid = false;
                        $response = "File size is exceeding 2MB maximum allowed size.";
                    }
                    //upload file
                    if ($valid) {
                        $bashPath = ROOT_PATH;
                        $session = new Container('user');
                        $user_id = $session->offsetGet('id');
                        $ref_no = $session->offsetGet('ref_no');
                        //$user_name = $session->offsetGet('full_name');
                        $user_name = "Unknown";
                        $user_folder = $user_id . "__" . $user_name;
                        $name = time() . $name;
                        if (!file_exists($bashPath . "/uploads/$user_folder")) {
                            mkdir($bashPath . "/uploads/$user_folder", 0777, true);
                            $targetPath = $bashPath . "/uploads/$user_folder/" . $name;
                            $uploaded = move_uploaded_file($tmpName, $targetPath);
                        } else {
                            $targetPath = $bashPath . "/uploads/$user_folder/" . $name;
                            $uploaded = move_uploaded_file($tmpName, $targetPath);
                        }
                        if ($uploaded) {
                            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                            $QUERY = "UPDATE tbl_user_info set profile_photo='/uploads/$user_folder/$name' WHERE `user_id`='$user_id' AND `ref_no`='$ref_no'";
                            $user = $adapter->query($QUERY, Adapter::QUERY_MODE_EXECUTE);
                            //*****Insert in Gallery Table******
                            $adapter->query("insert into tbl_user_gallery set user_id='$user_id',ref_no='$ref_no',image_path='/uploads/$user_folder/$name',
						 img_relation='user'", Adapter::QUERY_MODE_EXECUTE);
                            $session->profile_photo = "/uploads/$user_folder/$name";
                            $response = 'File uploaded Successfully.';
                            return new JsonModel(array("Status" => "true", "message" => $response, "file_path" => "/uploads/$user_folder/$name"));
                        } else {
                            $response = "Error! File Couldn't uploaded";
                        }
                    }
                    break;
                case UPLOAD_ERR_INI_SIZE:
                    $response = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $response = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $response = 'The uploaded file was only partially uploaded.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $response = 'No file was uploaded.';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $response = 'Missing a temporary folder.';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $response = 'Failed to write file to disk.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $response = 'File upload stopped by extension.';
                    break;
                default:
                    $response = 'Unknown error';
                    break;
            }
            return new JsonModel(array("Status" => "false", "message" => $response));
        }
    }

    public function AjaxImgUploadGalleryAction() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $session = new Container('user');
            //print_r($_POST['cropenabled']);exit;
            if ($_POST['cropenabled'] != "Enable") {
                // if($_POST['img_relation'] !='' && $_FILES['file_upload']['name'] !=''){
                $img_relation = trim($_POST['img_relation']);
                $name = $_FILES['file_upload']['name'];
                $tmpName = $_FILES['file_upload']['tmp_name'];
                $error = $_FILES['file_upload']['error'];
                $size = $_FILES['file_upload']['size'];
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                switch ($error) {
                    case UPLOAD_ERR_OK:
                        $valid = true;
                        //validate file extensions
                        if (!in_array($ext, array('jpg', 'jpeg'))) {
                            $valid = false;
                            $response = "Invalid file extension. Only( jpg, jpeg ) are allowed";
                        }
                        //validate file size
                        if ($size / 1024 / 1024 > 2) {
                            $valid = false;
                            $response = "File size is exceeding 2MB maximum allowed size.";
                        }
                        //upload file
                        if ($valid) {

                            //$bashPath = ROOT_PATH;
                            $session = new Container('user');
                            $user_id = $session->offsetGet('id');
                            $ref_no = $session->offsetGet('ref_no');
                            $userInfo = $this->userService->getUserInfoById($user_id, array('full_name'));
                            //$user_name = $userInfo->getFullName();
                            $user_name = "Unknown";
                            $user_folder = $user_id . "__" . $user_name;
                            $name = time() . $name;
                            //$upload=new \Zend\File\Transfer\Adapter\Http();
                            //$upload->setDestination(PUBLIC_PATH.'/uploads');
                            if (!file_exists(PUBLIC_PATH . "/uploads/$user_folder")) {
                                mkdir(PUBLIC_PATH . "/uploads/$user_folder", 0777, true);
                                $targetPath = PUBLIC_PATH . "/uploads/$user_folder/" . $name;

                                $uploaded = move_uploaded_file($tmpName, $targetPath);
                            } else {
                                $targetPath = PUBLIC_PATH . "/uploads/$user_folder/" . $name;

                                $uploaded = move_uploaded_file($tmpName, $targetPath);
                            }


                            if ($uploaded) {
                                $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                                //*********Insert in Gallery Table******
                                $imagePath = $user_folder . '/' . $name;
                                //echo $imagePath;
                                //exit;
                                $stmt = $adapter->query("insert into tbl_user_gallery set user_id='$user_id',ref_no='$ref_no',image_path='$imagePath',
							 img_relation='user'", Adapter::QUERY_MODE_EXECUTE);

                                //*********Select Images to Render******
                                $data = $adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
                                $response = 'File uploaded Successfully.';
                                return new JsonModel(array("Status" => "true", "message" => $response, "gallery_data" => $data));
                            } else {
                                $response = "Error! File Couldn't uploaded";
                            }
                        }
                        break;
                    case UPLOAD_ERR_INI_SIZE:
                        $response = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        $response = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $response = 'The uploaded file was only partially uploaded.';
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $response = 'No file was uploaded.';
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR:
                        $response = 'Missing a temporary folder.';
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        $response = 'Failed to write file to disk.';
                        break;
                    case UPLOAD_ERR_EXTENSION:
                        $response = 'File upload stopped by extension.';
                        break;
                    default:
                        $response = 'Unknown error';
                        break;
                }
                //  }else{
                // $response = 'All fields are required!';
                //  }            
                return new JsonModel(array("Status" => "false", "message" => $response));
            } else {
                $session = new Container('user');
                $user_id = $session->offsetGet('id');
                $ref_no = $session->offsetGet('ref_no');

                // $ref_no=$session->offsetGet('ref_no');
                $userInfo = $this->userService->getUserInfoById($user_id, array('full_name'));

                //$user_name = $userInfo->getFullName();
                $user_name = "Unknown";
                $name = time() . $_FILES['file_upload']['name'];
                $ext = strtolower(pathinfo($_FILES['file_upload']['name'], PATHINFO_EXTENSION));

                $original_image = $_FILES['file_upload']['tmp_name'];

                $user_folder = $user_id . "__" . $user_name;

                $new_image = PUBLIC_PATH . '/uploads/' . $user_folder . '/' . $name;

                $image_quality = '95';





// Get dimensions of the original image
                list( $current_width, $current_height ) = getimagesize($original_image);

// Get coordinates x and y on the original image from where we
// will start cropping the image, the data is taken from the hidden fields of form.
                $x1 = $_POST['x1'];
                $y1 = $_POST['y1'];
                $x2 = $_POST['x2'];
                $y2 = $_POST['y2'];
                $width = $_POST['width'];
                $height = $_POST['height'];
// print_r( $_POST ); die;
// Define the final size of the image here ( cropped image )
                $crop_width = 200;
                $crop_height = 200;
// Create our small image
                $new = imagecreatetruecolor($crop_width, $crop_height);
// Create original image
                $current_image = imagecreatefromjpeg($original_image);
// resampling ( actual cropping )
                imagecopyresampled($new, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height);
// this method is used to create our new image
                $result = imagejpeg($new, $new_image, $image_quality);

                if (!in_array($ext, array('jpg', 'jpeg'))) {
                    return new JsonModel(array("Status" => 0, "message" => "only jpeg files are allowed"));
                }


                if ($result) {


                    $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                    //*********Insert in Gallery Table******
                    $imagePath = $user_folder . '/' . $name;
                    //echo $imagePath;
                    //exit;
                    $adapter->query("insert into tbl_user_gallery set user_id='$user_id',ref_no='$ref_no',image_path='$imagePath',
							 img_relation='user'", Adapter::QUERY_MODE_EXECUTE);
                    //*********Select Images to Render******
                    $data = $adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
                    $response = 'File uploaded Successfully.';
                    return new JsonModel(array("Status" => "true", "message" => $response, "gallery_data" => $data));
                } else {
                    $response = "Error! File Couldn't uploaded";
                }
            }
        }
    }

    public function ChangeProfImgFrGalleryAction() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST["ImageName"] != '') {
                $ImageName = $_POST["ImageName"];
                $session = new Container('user');
                $user_id = $session->offsetGet('id');
                $ref_no = $session->offsetGet('ref_no');
                $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                $QUERY = "UPDATE tbl_user_info set profile_photo='$ImageName' WHERE `user_id`='$user_id' AND `ref_no`='$ref_no'";
                $user = $adapter->query($QUERY, Adapter::QUERY_MODE_EXECUTE);
                $session->profile_photo = "$ImageName";
                $response = 'Profile updated Successfully.';
                return new JsonModel(array("Status" => "true", "message" => $response, "file_path" => "$ImageName"));
            } else {
                $response = 'No Image was selected!';
            }
        } else {
            $response = 'An-authorize way to upload image!';
        }
        return new JsonModel(array("Status" => "false", "message" => $response));
    }

    public function postAction() {


        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $familyInfo = $this->userService->getFamilyInfoById($user_id);

        if ($this->getRequest()->isXmlHttpRequest()) {
            //print_r($this->getRequest()->getPost()->toArray());
            $platform = $adapter->getPlatform();
            $sql = "INSERT INTO tbl_post (user_id,title, description, post_category, image) values ('" . $user_id . "',
                     " . $platform->quoteValue($_POST['title']) . ",
                     " . $platform->quoteValue($_POST['description']) . ",
                     " . $platform->quoteValue($_POST['post_category']) . ",
                     " . $platform->quoteValue($_POST['image']) . ")";


            $stmt = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);

            return new JsonModel();
        }

        //$postcategories = $this->getPostcategoryTable()->customFields(array('id', 'category_name'));
        //PostForm::$postcategoryList = $postcategories;
        // print_r($postcategories);die;

        $form = new PostForm($this->commonService);
        $slug = $this->params()->fromRoute('slug');
        if ($slug == "edit") {
            $id = $this->params()->fromRoute('id');
            //var_dump($id);
            if ($id) {
                $info = $this->userService->getUserPostById($id);
                //print_r($info['image']);
                //Debug::dump($info);
                $form->bind($info);
            } else {
                $info = new \Application\Model\Entity\Post();
                //$info->getImage();
//$objp->setImage($image);
                // $info=$objp;
            }
        } else if ($slug == "delete") {
            $id = $this->params()->fromRoute('id');
            //var_dump($id);exit;
            if ($id) {
                $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                $sql = "DELETE from tbl_post WHERE id='$id'";

                $result = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                if ($result) {
                    $this->flashMessenger()->addMessage('Deleted');
                    return $this->redirect()->toRoute('profile', array('action' => 'post'));
                }
            }
        } else {
            $info = new \Application\Model\Entity\Post();
        }


        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

//            $page = new Posts();
//            $form->setInputFilter($page->getInputFilter());
//
//            $mergedata = array_merge(
//                    $this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray()
//            );
            // print_r($mergedata);die;
//
//            $form->setData($mergedata);
            // $data = (array) $request->getPost();
            if ($form->isValid()) {
                $mergedata = array_merge(
                        $this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray()
                );
                $mergedata['user_id'] = $user_id;
                //Debug::dump($mergedata);
                //exit;
                //$entity = $page->exchangeArray($postform->getData());
                //unset($page->inputFilter);
                // $session = new Container('user');
                // $user_id=$session->offsetGet('id');
                // 		echo $user_id;
                $this->userService->saveUserPost($mergedata);
//                return $this->redirect()->toRoute('application/default', array(
//                            'action' => 'post',
//                            'controller' => 'account',
//                            "id" => 1
//                ));
            }
        }

        $percentage = $this->userService->ProfileBar($user_id);
        $pro_per = array($percentage, $this->profileBarTemplate($percentage));


        $data = $adapter->query("select * from tbl_post WHERE user_id='$user_id' ORDER BY id DESC limit 6", Adapter::QUERY_MODE_EXECUTE)->toArray();

        return new ViewModel(array("form" => $form,
            'userSummary' => $this->userService->userSummaryById($user_id),
            'url' => 'post',
            'post' => $data,
            "percent" => $pro_per,
            'userPostSummary' => $info,
            'familyInfo' => $familyInfo,
        ));
    }

    /*     * ****Ajax Call***** */

    public function getStateNameAction() {
        $Request = $this->getRequest();
        if ($Request->isPost()) {
            $Country_ID = $Request->getPost("Country_ID");
            $state_name = $this->getStateTable()->getStateListByCountryCode($Country_ID);
            if (count($state_name))
                return new JsonModel(array("Status" => "Success", "statelist" => $state_name));
            else
                return new JsonModel(array("Status" => "Failed", "statelist" => NULL));
        }
    }

    /*     * ****Ajax Call***** */

    public function getCityNameAction() {
        $Request = $this->getRequest();
        if ($Request->isPost()) {
            $State_ID = $Request->getPost("State_ID");
            $city_name = $this->getCityTable()->getCityListByStateCode($State_ID);
            if (count($city_name))
                return new JsonModel(array("Status" => "Success", "statelist" => $city_name));
            else
                return new JsonModel(array("Status" => "Failed", "statelist" => NULL));
        }
    }

    public function cropimageAction() {

        //print_r($_POST);exit;
        //print_r($ref_no);
        //exit;
        //print_r($_POST['cropenabled']);exit;
        if ($_POST['profile_photo_flag'] == '1') {
            $profile_pic = $_POST['profile_photo_flag'];
        } else {
            $profile_pic = '0';
        }
        if ($_POST['cropenabled'] == "Enable") {

//            $session = new Container('user');
//            $user_id = $session->offsetGet('id');
//            $ref_no = $session->offsetGet('ref_no');
//            $user_name = $session->offsetGet('full_name');

            $user_id = $_POST['uid'];
            $ref_no = $_POST['ref_no'];
            $user_name = "Unknown";
            $name = time() . $_FILES['file']['name'];
            $original_image = $_FILES['file']['tmp_name'];

            $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

            $user_folder = $user_id . "__" . $user_name;

            $new_image = PUBLIC_PATH . '/uploads/' . $user_folder . '/' . $name;
            $new_image_thumb = PUBLIC_PATH . '/uploads/thumb/100x100/' . $user_folder . '/' . $name;
// TODO: satya
            $image_quality = '95';

            if (!file_exists(PUBLIC_PATH . "/uploads/$user_folder")) {
                mkdir(PUBLIC_PATH . "/uploads/$user_folder", 0777, true);
                // $targetPath =  ROOT_PATH.'/uploads/'.$user_folder.$name;
                // $uploaded=move_uploaded_file($tmpName,$targetPath);
            }
            if (!file_exists(PUBLIC_PATH . "/uploads/thumb/100x100/$user_folder")) {
                mkdir(PUBLIC_PATH . "/uploads/thumb/100x100/$user_folder", 0777, true);
                // $targetPath =  ROOT_PATH.'/uploads/'.$user_folder.$name;
                // $uploaded=move_uploaded_file($tmpName,$targetPath);
            }

// Get dimensions of the original image
            list( $current_width, $current_height ) = getimagesize($original_image);

// Get coordinates x and y on the original image from where we
// will start cropping the image, the data is taken from the hidden fields of form.
            $x1 = $_POST['x1'];
            $y1 = $_POST['y1'];
            $x2 = $_POST['x2'];
            $y2 = $_POST['y2'];
            $width = $_POST['width'];
            $height = $_POST['height'];
            //print_r( $_POST ); die;
// Define the final size of the image here ( cropped image )
            $crop_width = 200;
            $crop_height = 200;
// Create our small image
            $new = imagecreatetruecolor($crop_width, $crop_height);

// Create original image
            $current_image = imagecreatefromjpeg($original_image);
// resampling ( actual cropping )
            imagecopyresampled($new, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height);
// this method is used to create our new image
            $result = imagejpeg($new, $new_image, $image_quality);


//thumb start
            $crop_width = 30;
            $crop_height = 30;
            $thumbNew = imagecreatetruecolor($crop_width, $crop_height);
            imagecopyresampled($thumbNew, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height);
            $thumb = imagejpeg($thumbNew, $new_image_thumb, $image_quality);

            if (!in_array($ext, array('jpg', 'jpeg'))) {
                return new JsonModel(array("Status" => 0, "message" => "only jpeg files are allowed"));
            }

            if ($result) {
                $image_path_sql = $user_folder . '/' . $name;
                $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                $sql = "SELECT * FROM tbl_user_gallery WHERE user_id=$user_id AND profile_pic=1";

                $predata = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();

                if ($predata->profile_pic == '1') {
                    $sql = "UPDATE tbl_user_gallery SET image_path='$image_path_sql' WHERE user_id='" . $user_id . "' AND profile_pic=1";

                    $statement = $adapter->query($sql);
                    $res = $statement->execute();
                    //print_r($res);
                    //exit;
                    unlink(PUBLIC_PATH . "/uploads/thumb/100x100/" . $predata->image_path);
                    unlink(PUBLIC_PATH . "/uploads/" . $predata->image_path);
                } else {
                    //*********Insert in Gallery Table******
                    $statement = $adapter->query("INSERT INTO tbl_user_gallery (user_id, ref_no, image_path, profile_pic) 
                        VALUES ('$user_id','$ref_no','$image_path_sql', '$profile_pic')");
                    $res = $statement->execute();
                    $imgid = $res->getGeneratedValue();
                }
                //*********Insert in Gallery Table******
                // $already = $adapter->query("select user_id from tbl_family_info where user_id=$user_id",\Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->count();
                // 	if($already == 0){
                // 		$adapter->query("insert into ".$_POST['table_name']."('user_id','".$_POST['field_name']."') values($user_id,'/uploads/$user_folder/$name')", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                // 	}	
                // else 
//                $statement = $adapter->query("INSERT INTO tbl_user_gallery (user_id, ref_no, image_path, profile_pic) 
//                        VALUES ('$user_id','$ref_no','$user_folder/$name', '$profile_pic')");
//
//
//                $res = $statement->execute();
//                $imgid = $res->getGeneratedValue();
                //print_r($statement);
                //exit;
                //*********Select Images to Render******
                // $data=$adapter->query("select ".$_POST['field_name']." from tbl_family_info where user_id='$user_id'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);


                $response = 'File uploaded Successfully.';
                //for testing purpose
                $imgidpath = "$user_folder/$name";

                //for Live Purpose
                // $imgidpath = "/uploads/$user_folder/$name";

                return new JsonModel(array("Status" => 1, "data" => $imgidpath, "imgid" => $imgid));
            } else {
                return new JsonModel(array("Status" => 0, "message" => "couldn't crop image some error occured"));
            }
        } else {
            //$response = $this->familyimages($_POST, $_FILES);
            $resp = $this->getResponse();
            $resp->getHeaders()->addHeaderLine('Content-Type', 'application/json');

            //$img_relation = trim($post['field_name']);
            $name = $_FILES['file']['name'];
            $tmpName = $_FILES['file']['tmp_name'];
            $error = $_FILES['file']['error'];
            $size = $_FILES['file']['size'];
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            switch ($error) {
                case UPLOAD_ERR_OK:
                    $valid = true;
                    //validate file extensions
                    if (!in_array($ext, array('jpg'))) {
                        $valid = false;
                        $response = "Invalid file extension. Only( jpg ) are allowed";
                    }
                    //validate file size
                    if ($size / 1024 / 1024 > 2) {
                        $valid = false;
                        $response = "File size is exceeding 2MB maximum allowed size.";
                    }
                    //upload file
                    if ($valid) {

                        // return $post;
                        $bashPath = PUBLIC_PATH;
                        $user_id = $_POST['uid'];
                        $ref_no = $_POST['ref_no'];
                        $user_name = "Unknown";

                        $user_folder = $user_id . "__" . $user_name;
                        $name = time() . $name;



                        $new_image = PUBLIC_PATH . '/uploads/' . $user_folder . '/' . $name;
                        $new_image_thumb = PUBLIC_PATH . '/uploads/thumb/100x100/' . $user_folder . '/' . $name;
                        $image_quality = '95';

                        //echo "Mohitt"; die;
                        if (file_exists(PUBLIC_PATH . "/uploads/" . $user_folder)) {
                            //if (!file_exists($bashPath . "/uploads/".$user_folder)) {
                            //echo "Mohit"; die;
                            mkdir($bashPath . "/uploads/$user_folder", 0777, true);
                            $targetPath = $bashPath . "/uploads/" . $user_folder . "/" . $name; //die;
                            $uploaded = move_uploaded_file($tmpName, $targetPath);
                        }
                        //echo "aa";die;
                        if (!file_exists(PUBLIC_PATH . "/uploads/thumb/100x100/$user_folder")) {
                            mkdir(PUBLIC_PATH . "/uploads/thumb/100x100/$user_folder", 0777, true);
                            // $targetPath =  ROOT_PATH.'/uploads/'.$user_folder.$name;
                            // $uploaded=move_uploaded_file($tmpName,$targetPath);
                        }

// Get dimensions of the original image
                        //list( $current_width, $current_height ) = getimagesize($tmpName);
// Get coordinates x and y on the original image from where we
// will start cropping the image, the data is taken from the hidden fields of form.
                        //$x1 = $_POST['x1'];
                        //$y1 = $_POST['y1'];
                        //$x2 = $_POST['x2'];
                        //$y2 = $_POST['y2'];
                        //$width = $_POST['width'];
                        //$height = $_POST['height'];
//                        //print_r( $_POST ); die;
// Define the final size of the image here ( cropped image )
                        //$crop_width = 200;
                        //$crop_height = 200;
// Create our small image
                        //$new = imagecreatetruecolor($crop_width, $crop_height);
// Create original image
                        //$current_image = imagecreatefromjpeg($tmpName);
// resampling ( actual cropping )
                        //imagecopyresampled($new, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height);
// this method is used to create our new image
                        //$result = imagejpeg($new, $new_image, $image_quality);
//thumb start
                        $crop_width = 30;
                        $crop_height = 30;
                        $thumbNew = imagecreatetruecolor($crop_width, $crop_height);
                        $current_image = imagecreatefromjpeg($tmpName);
                        imagecopyresampled($thumbNew, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height);
                        $thumb = imagejpeg($thumbNew, $new_image_thumb, $image_quality);



                        //exit;
                        //if ($thumb) {
                        if ($result) {

                            $image_path_sql = $user_folder . '/' . $name;

                            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                            $sql = "SELECT * FROM tbl_user_gallery WHERE user_id=$user_id AND profile_pic=1";

                            $predata = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();

                            if ($predata->profile_pic == '1') {
                                $sql = "UPDATE tbl_user_gallery SET image_path='$image_path_sql' WHERE user_id='" . $user_id . "' AND profile_pic=1";
                                //exit;
                                $statement = $adapter->query($sql);
                                $res = $statement->execute();
                                unlink(PUBLIC_PATH . "/uploads/thumb/100x100/" . $predata->image_path);
                                unlink(PUBLIC_PATH . "/uploads/" . $predata->image_path);
                            } else {
                                //*********Insert in Gallery Table******
                                $statement = $adapter->query("INSERT INTO tbl_user_gallery (user_id, ref_no, image_path, profile_pic) 
                        VALUES ('$user_id','$ref_no','$image_path_sql', '$profile_pic')");
                                $res = $statement->execute();
                                $imgid = $res->getGeneratedValue();
                            }
                            //print_r($predata->profile_pic);
                            //exit;
                            //$adapter->query("update " . $post['table_name'] . " set " . $post['field_name'] . "='/uploads/$user_folder/$name' where user_id=$user_id ", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                            //*********Select Images to Render******
                            // $data=$adapter->query("select ".$post['field_name']." from tbl_family_info where user_id='$user_id'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                            $response = 'File uploaded Successfully.';
                            // return $data;
//for testing purpose		
                            $imgidpath = "$user_folder/$name";
                            $resp->setContent(json_encode(array("Status" => 1, "data" => $imgidpath, "imgid" => $imgid)));
//for live purpose
// $imgidpath = "/uploads/$user_folder/$name";
                            //        $resp->setContent(json_encode(array("Status"=>1,"data"=>$imgidpath,"imgid"=>$post['field_name'])));

                            return $resp;

                            // return new JsonModel(array("Status"=>1,"data"=>$targetPath));
                            // return new JsonModel(array("Status"=>"true","message"=>$response,"family_data"=>$data));							
                        } else {
                            $response = "Error! File Couldn't uploaded";
                        }
                    }
                    break;
                case UPLOAD_ERR_INI_SIZE:
                    $response = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $response = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $response = 'The uploaded file was only partially uploaded.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $response = 'No file was uploaded.';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $response = 'Missing a temporary folder.';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $response = 'Failed to write file to disk.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $response = 'File upload stopped by extension.';
                    break;
                default:
                    $response = 'Unknown error';
                    break;
            }

            $resp->setContent(json_encode(array("Status" => 0, "message" => $response)));
            return $resp;
        }

        //exit;
    }

    public function cropimagebrotherdetailAction() {



        //print_r($_POST);
        //exit;
        if (empty($_POST['uid'])) {

            if ($_POST['cropenabled'] == "Enable") {


                $name = time() . $_FILES['file']['name'];
                $original_image = $_FILES['file']['tmp_name'];

                $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

                $new_image = PUBLIC_PATH . '/temp/' . $name;
                $new_image_thumb = PUBLIC_PATH . '/temp/thumb/100x100/' . $name;

                $image_quality = '95';


                // Get dimensions of the original image
                list( $current_width, $current_height ) = getimagesize($original_image);

                // Get coordinates x and y on the original image from where we
                // will start cropping the image, the data is taken from the hidden fields of form.
                $x1 = $_POST['x1'];
                $y1 = $_POST['y1'];
                $x2 = $_POST['x2'];
                $y2 = $_POST['y2'];
                $width = $_POST['width'];
                $height = $_POST['height'];
                //print_r( $_POST ); die;
                // Define the final size of the image here ( cropped image )
                $crop_width = 200;
                $crop_height = 200;
                // Create our small image
                $new = imagecreatetruecolor($crop_width, $crop_height);

                // Create original image
                $current_image = imagecreatefromjpeg($original_image);
                // resampling ( actual cropping )
                imagecopyresampled($new, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height);
                // this method is used to create our new image
                $result = imagejpeg($new, $new_image, $image_quality);


                //thumb start
                $crop_width = 30;
                $crop_height = 30;
                $thumbNew = imagecreatetruecolor($crop_width, $crop_height);
                imagecopyresampled($thumbNew, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height);
                $thumb = imagejpeg($thumbNew, $new_image_thumb, $image_quality);
                if (!in_array($ext, array('jpg', 'jpeg'))) {
                    return new JsonModel(array("Status" => 0, "message" => "only jpeg files are allowed"));
                }

                return new JsonModel(array("Status" => 1, "image_name" => $name, "image_index" => $_POST['image_index'], 'sel_value' => $_POST['sel_value']));
            } else {

                $name = $_FILES['file']['name'];
                $tmpName = $_FILES['file']['tmp_name'];
                $error = $_FILES['file']['error'];
                $size = $_FILES['file']['size'];
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                $bashPath = PUBLIC_PATH;
                $name = time() . $name;


                $new_image = PUBLIC_PATH . '/temp/' . $name;
                $new_image_thumb = PUBLIC_PATH . '/temp/thumb/100x100/' . $name;
                $image_quality = '95';



                // Get dimensions of the original image
                list( $current_width, $current_height ) = getimagesize($tmpName);

                // Get coordinates x and y on the original image from where we
                // will start cropping the image, the data is taken from the hidden fields of form.
                $x1 = $_POST['x1'];
                $y1 = $_POST['y1'];
                $x2 = $_POST['x2'];
                $y2 = $_POST['y2'];
                $width = $_POST['width'];
                $height = $_POST['height'];
                //print_r( $_POST ); die;
                // Define the final size of the image here ( cropped image )
                $crop_width = 200;
                $crop_height = 200;
                // Create our small image
                $new = imagecreatetruecolor($crop_width, $crop_height);

                // Create original image
                $current_image = imagecreatefromjpeg($tmpName);
                // resampling ( actual cropping )
                imagecopyresampled($new, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height);
                // this method is used to create our new image
                $result = imagejpeg($new, $new_image, $image_quality);


                //thumb start
                $crop_width = 30;
                $crop_height = 30;
                $thumbNew = imagecreatetruecolor($crop_width, $crop_height);
                $current_image = imagecreatefromjpeg($tmpName);
                imagecopyresampled($thumbNew, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height);
                $thumb = imagejpeg($thumbNew, $new_image_thumb, $image_quality);


                return new JsonModel(array("Status" => 1, "image_name" => $name, "image_index" => $_POST['image_index'], 'sel_value' => $_POST['sel_value']));
            }
        } else {
            
        }
    }

    //// Mohit Jain



    public function croppostimageAction() {

        //print_r($_POST);exit;
        //print_r($ref_no);
        //exit;

        if ($_POST['cropenabled'] == "Enable") {

//            $session = new Container('user');
//            $user_id = $session->offsetGet('id');
//            $ref_no = $session->offsetGet('ref_no');
//            $user_name = $session->offsetGet('full_name');
            // $user_id = $_POST['uid'];
            //  $ref_no = $_POST['ref_no'];
            // $user_name = "Unknown";
            $name = time() . $_FILES['file']['name'];
            $original_image = $_FILES['file']['tmp_name'];

            $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            //die;
            // $user_folder = $user_id . "__" . $user_name;

            $new_image = PUBLIC_PATH . '/PostsImages/' . $name;
            $new_image_thumb = PUBLIC_PATH . '/PostsImages/thumb/100x100/' . $name;
// TODO: satya
            $image_quality = '95';



// Get dimensions of the original image
            list( $current_width, $current_height ) = getimagesize($original_image);

// Get coordinates x and y on the original image from where we
// will start cropping the image, the data is taken from the hidden fields of form.
            $x1 = $_POST['x1'];
            $y1 = $_POST['y1'];
            $x2 = $_POST['x2'];
            $y2 = $_POST['y2'];
            $width = $_POST['width'];
            $height = $_POST['height'];
            //print_r( $_POST ); //die;
// Define the final size of the image here ( cropped image )
            $crop_width = 200;
            $crop_height = 200;
// Create our small image
            $new = imagecreatetruecolor($crop_width, $crop_height);

// Create original image
            $current_image = imagecreatefromjpeg($original_image);
// resampling ( actual cropping )
            imagecopyresampled($new, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height);
// this method is used to create our new image
            $result = imagejpeg($new, $new_image, $image_quality);

            //echo print_r($result);
//thumb start
            $crop_width = 30;
            $crop_height = 30;
            $thumbNew = imagecreatetruecolor($crop_width, $crop_height);
            imagecopyresampled($thumbNew, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height);
            $thumb = imagejpeg($thumbNew, $new_image_thumb, $image_quality);

            if (!in_array($ext, array('jpg', 'jpeg'))) {
                return new JsonModel(array("Status" => 0, "message" => "only jpeg files are allowed"));
            }

            if ($result) {
                //echo "Mohit"; die;
                $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                //*********Insert in Gallery Table******
                // $already = $adapter->query("select user_id from tbl_family_info where user_id=$user_id",\Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->count();
                // 	if($already == 0){
                // 		$adapter->query("insert into ".$_POST['table_name']."('user_id','".$_POST['field_name']."') values($user_id,'/uploads/$user_folder/$name')", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                // 	}	
                // else 
                /* $statement = $adapter->query("INSERT INTO tbl_user_gallery (user_id, ref_no, image_path, profile_pic) 
                  VALUES ('$user_id','$ref_no','$user_folder/$name', '$profile_pic')");


                  $res = $statement->execute();
                  $imgid = $res->getGeneratedValue(); */
                //print_r($statement);
                //exit;
                //*********Select Images to Render******
                // $data=$adapter->query("select ".$_POST['field_name']." from tbl_family_info where user_id='$user_id'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);


                $response = 'File uploaded Successfully.';
                //for testing purpose
                $imgidpath = "/PostsImages/" . $name;

                //for Live Purpose
                // $imgidpath = "/uploads/$user_folder/$name";

                return new JsonModel(array("Status" => 1, "data" => $imgidpath, "imgid" => $imgid));
            } else {

                return new JsonModel(array("Status" => 0, "message" => "couldn't crop image some error occured"));
            }
        } else {
            //$response = $this->familyimages($_POST, $_FILES);
            $resp = $this->getResponse();
            $resp->getHeaders()->addHeaderLine('Content-Type', 'application/json');

            //$img_relation = trim($post['field_name']);
            $name = $_FILES['file']['name'];
            $tmpName = $_FILES['file']['tmp_name'];
            $error = $_FILES['file']['error'];
            $size = $_FILES['file']['size'];
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            switch ($error) {
                case UPLOAD_ERR_OK:
                    $valid = true;
                    //validate file extensions
                    if (!in_array($ext, array('jpg'))) {
                        $valid = false;
                        $response = "Invalid file extension. Only( jpg ) are allowed";
                    }
                    //validate file size
                    if ($size / 1024 / 1024 > 2) {
                        $valid = false;
                        $response = "File size is exceeding 2MB maximum allowed size.";
                    }
                    //upload file
                    if ($valid) {

                        // return $post;
                        $bashPath = PUBLIC_PATH;


                        $name = time() . $name;


                        $new_image = PUBLIC_PATH . '/PostsImages/' . $name;
                        $new_image_thumb = PUBLIC_PATH . '/PostsImages/thumb/100x100/' . $name;
                        $image_quality = '95';





// Get dimensions of the original image
                        list( $current_width, $current_height ) = getimagesize($tmpName);

// Get coordinates x and y on the original image from where we
// will start cropping the image, the data is taken from the hidden fields of form.
                        $x1 = $_POST['x1'];
                        $y1 = $_POST['y1'];
                        $x2 = $_POST['x2'];
                        $y2 = $_POST['y2'];
                        $width = $_POST['width'];
                        $height = $_POST['height'];
//                        //print_r( $_POST ); die;
// Define the final size of the image here ( cropped image )
                        $crop_width = 200;
                        $crop_height = 200;
// Create our small image
                        $new = imagecreatetruecolor($crop_width, $crop_height);

// Create original image
                        $current_image = imagecreatefromjpeg($tmpName);
// resampling ( actual cropping )
                        imagecopyresampled($new, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height);
// this method is used to create our new image
                        $result = imagejpeg($new, $new_image, $image_quality);


//thumb start
                        $crop_width = 30;
                        $crop_height = 30;
                        $thumbNew = imagecreatetruecolor($crop_width, $crop_height);
                        $current_image = imagecreatefromjpeg($tmpName);
                        imagecopyresampled($thumbNew, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height);
                        $thumb = imagejpeg($thumbNew, $new_image_thumb, $image_quality);



                        //exit;
                        if ($result) {


                            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                            //*********Insert in Gallery Table******
                            //$adapter->query("update " . $post['table_name'] . " set " . $post['field_name'] . "='/uploads/$user_folder/$name' where user_id=$user_id ", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                            //*********Select Images to Render******
                            // $data=$adapter->query("select ".$post['field_name']." from tbl_family_info where user_id='$user_id'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                            $response = 'File uploaded Successfully.';
                            // return $data;
//for testing purpose		
                            $imgidpath = "/PostsImages/" . $name;
                            $resp->setContent(json_encode(array("Status" => 1, "data" => $imgidpath, "imgid" => $imgid)));
//for live purpose
// $imgidpath = "/uploads/$user_folder/$name";
                            //        $resp->setContent(json_encode(array("Status"=>1,"data"=>$imgidpath,"imgid"=>$post['field_name'])));

                            return $resp;

                            // return new JsonModel(array("Status"=>1,"data"=>$targetPath));
                            // return new JsonModel(array("Status"=>"true","message"=>$response,"family_data"=>$data));							
                        } else {
                            $response = "Error! File Couldn't uploaded";
                        }
                    }
                    break;
                case UPLOAD_ERR_INI_SIZE:
                    $response = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $response = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $response = 'The uploaded file was only partially uploaded.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $response = 'No file was uploaded.';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $response = 'Missing a temporary folder.';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $response = 'Failed to write file to disk.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $response = 'File upload stopped by extension.';
                    break;
                default:
                    $response = 'Unknown error';
                    break;
            }

            $resp->setContent(json_encode(array("Status" => 0, "message" => $response)));
            return $resp;
        }

        //exit;
    }

    public function covertdateageAction() {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');

        $today = date("Y-m-d");
        $dob = $this->convertdate($_POST['value']);

        $years = $this->valdateselection(strtotime($today), strtotime($dob));

        if ($years < '15') {
            $msg = "your age should be greater than 15";
            $respArr = array("status" => 0, "content" => $msg);
        } else
            $respArr = array("status" => 1, "content" => $years);


        $response->setContent(json_encode($respArr));
        return $response;
    }

    public function convertdate($date) {

        $timestamp = strtotime($date);
        $date = date("Y-m-d", $timestamp);
        return $date;
    }

    public function valdateselection($today, $dob) {
        $diff = $today - $dob;
        $years = floor($diff / (365 * 60 * 60 * 24));
        // $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        // $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        return $years;
    }

    public function profileBarTemplate($percentage) {

        $view = new PhpRenderer();
        $resolver = new TemplateMapResolver();
        $resolver->setMap(array(
            'mailTemplate' => __DIR__ . '/../../../view/application/profileBar/profileBar.phtml'
        ));
        $view->setResolver($resolver);

        $viewModel = new ViewModel();
        $viewModel->setTemplate('mailTemplate')->setVariables(array(
            'percentage' => $percentage,
        ));
        $message = $view->render($viewModel);
        //Debug::dump($message);
        //exit;
        return $message;
    }

    public function sentAction() {
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');


        $invitation = $adapter->query("select count('id') as invitation from tbl_member_invitation WHERE user_id=$user_id AND received IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->current();
        $sent = $adapter->query("select * from tbl_member_invitation WHERE user_id=$user_id AND sent IS NOT NULL", Adapter::QUERY_MODE_EXECUTE);
        $accepted = $adapter->query("select count('id') as accepted from tbl_member_invitation WHERE user_id=$user_id AND accepted IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->current();

        foreach ($sent as $key => $value) {
            $sentMember[] = $adapter->query("select tui.*, tug.image_path from tbl_user_info as tui LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $value['sent'] . "'", Adapter::QUERY_MODE_EXECUTE)->current();
            //echo '<pre>';
            //print_r($sentMember);
        }


        return new ViewModel(array(
            //'invitation'=>$invitationMember,
            'sentMember' => $sentMember,
                //'accepted'=>$acceptedMember,
        ));
    }

    public function acceptedAction() {
        $acceptedMember='';
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $accepted = $adapter->query("select * from tbl_member_invitation WHERE user_id=$user_id AND accepted IS NOT NULL", Adapter::QUERY_MODE_EXECUTE);

        foreach ($accepted as $key => $value) {
            $acceptedMember[] = $adapter->query("select tui.*, tug.image_path from tbl_user_info as tui LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $value['accepted'] . "'", Adapter::QUERY_MODE_EXECUTE)->current();
            //echo '<pre>';
            //print_r($sentMember);
        }

        return new ViewModel(array(
            //'invitation'=>$invitationMember,
            'acceptedMember' => $acceptedMember,
                //'accepted'=>$acceptedMember,
        ));
    }

    public function receivedAction() {
        $receivedMember='';
        $memInfo='';
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');


        $received = $adapter->query("select * from tbl_member_invitation WHERE user_id=$user_id AND received IS NOT NULL", Adapter::QUERY_MODE_EXECUTE);
//        echo '<pre>';
//   print_r($invitation);
        foreach ($received as $key => $value) {
            $receivedMember[] = $adapter->query("select tui.*, tug.image_path from tbl_user_info as tui LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $value['received'] . "'", Adapter::QUERY_MODE_EXECUTE)->current();
            $memInfo[] = $value;

            //echo '<pre>';
            //print_r($sentMember);
        }
        //echo '<pre>';
        //print_r($received);

        return new ViewModel(array(
            //'invitation'=>$invitationMember,
            'receivedMember' => $receivedMember,
            'memInfo' => $memInfo,
        ));
    }

    public function interestacceptedAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $request = $this->getRequest();
        $post = $request->getPost();
        $id = $post['id'];
        $uid = $post['uid'];
        $type = $post['type'];
        $sql = "UPDATE tbl_member_invitation SET type=5, received=NULL, accepted='$uid' WHERE type='$type' AND sent='$user_id' AND user_id='$uid' AND id='$id'";
        //$sql = "UPDATE tbl_member_invitation SET received=NULL, accepted=$accepted WHERE id=$id";
        //echo $sql;
        //exit;
        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);

        return new JsonModel(array('result' => ''));
    }

    /// Function for matrimony Invitation Accepted Starts Here ///

    public function matrimonyinterestacceptedAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $request = $this->getRequest();
        $post = $request->getPost();
        $id = $post['id'];
        $uid = $post['uid'];
        $type = $post['type'];
        $sql = "UPDATE tbl_matrimonial_invitation SET type=5, received=NULL, accepted='$uid' WHERE type='$type' AND sent='$user_id' AND user_id='$uid' AND id='$id'";
        //echo $sql = "UPDATE tbl_member_invitation SET received=NULL, accepted=$accepted WHERE sent=$user_id and user_id=$accepted";
        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        //echo $sql;
        //exit;
        return new JsonModel(array('result' => ''));
    }

    /// Function for matrimony Invitation Accepted Ends Here ///

    public function newMembersAction() {
        $newMemberf='';
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "SELECT tu.is_active,tui.*, tug.image_path, tur.*  FROM tbl_user_info as tui "
                . "LEFT JOIN tbl_user_gallery as tug ON tug.user_id=tui.user_id AND tug.profile_pic='1'"
                . "LEFT JOIN tbl_user_roles as tur ON tui.user_id=tur.user_id "
                . "LEFT JOIN tbl_user as tu ON (tu.id=tui.user_id AND tu.is_active=1)"
                //. "LEFT JOIN tbl_member_invitation as tmi ON tui.user_id=tmi.user_id"
                . "WHERE tur.IsMember='1' AND tui.user_id!='$user_id' ORDER BY tui.created_date DESC";
        $newMember = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
        $sql1 = "SELECT * FROM tbl_member_invitation WHERE user_id='$user_id'";
        $invi_member = $adapter->query($sql1, Adapter::QUERY_MODE_EXECUTE)->toArray();

        foreach ($newMember as $newMembers) {
            foreach ($invi_member as $invi_members) {
                if ($newMembers['user_id'] == $invi_members['accepted'] || $newMembers['user_id'] == $invi_members['sent'] || $newMembers['user_id'] == $invi_members['received']) {
                    continue 2;
                }
            }
            $newMemberf[] = $newMembers;
        }

        return new ViewModel(array(
            'newMember' => $newMemberf
        ));
    }

    public function selectedMembersAction() {
        $selectedMembers=$memInfo='';
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $received = $adapter->query("select * from tbl_member_invitation WHERE user_id='$user_id' AND sent IS NOT NULL AND type=2", Adapter::QUERY_MODE_EXECUTE);
        foreach ($received as $key => $value) {
            $selectedMembers[] = $adapter->query("select tui.*, tug.image_path from tbl_user_info as tui LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $value['sent'] . "'", Adapter::QUERY_MODE_EXECUTE)->current();
            $memInfo[] = $value;
        }
        return new ViewModel(array(
            'selectedMembers' => $selectedMembers,
            'memInfo' => $memInfo,
        ));
    }

    public function preferredMembersAction() {
        $preferredMembers=$preferredmemInfo='';
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $preferred = $adapter->query("select * from tbl_member_invitation WHERE (sent='$user_id' OR user_id='$user_id') AND accepted IS NOT NULL AND type=7", Adapter::QUERY_MODE_EXECUTE);
        foreach ($preferred as $key => $value) {
            if ($value['user_id'] == $user_id) {
                $tui_userId = $value['sent'];
            } else {
                $tui_userId = $value['user_id'];
            }
            $preferredMembers[] = $adapter->query("select tui.*, tug.image_path from tbl_user_info as tui LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $tui_userId . "'", Adapter::QUERY_MODE_EXECUTE)->current();
            //$preferredMembers1[] = $adapter->query("select tui.*, tug.image_path from tbl_user_info as tui LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $tui_userId . "'", Adapter::QUERY_MODE_EXECUTE)->current();
            $preferredmemInfo[] = $value;
            //$preferredmemInfo1[] = $value;
        }
        return new ViewModel(array(
            'preferredMembers' => $preferredMembers,
            'preferredMembers1' => $preferredMembers,
            'preferredmemInfo' => $preferredmemInfo,
            'preferredmemInfo1' => $preferredmemInfo,
        ));
    }

    public function declinedMembersAction() {
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "select * from tbl_member_invitation WHERE (type=3 OR type=4) AND (user_id='$user_id' OR sent='$user_id') AND accepted IS NULL AND received IS NULL";
        $declined = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        foreach ($declined as $key => $value) {
            if ($value['user_id'] == $user_id) {
                $tui_userId = $value['sent'];
            } else {
                $tui_userId = $value['user_id'];
            }
            $sql1 = "select tui.*, tug.image_path from tbl_user_info as tui LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $tui_userId . "'";
            $declinedMembers[] = $adapter->query($sql1, Adapter::QUERY_MODE_EXECUTE)->current();
            $declinedmemInfo[] = $value;
        }
        return new ViewModel(array(
            'declinedMembers' => $declinedMembers,
            'declinedmemInfo' => $declinedmemInfo,
        ));
    }

    public function acceptedMembersAction() {
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "select * from tbl_member_invitation WHERE type=5 AND (user_id='$user_id' OR sent='$user_id') AND accepted IS NOT NULL AND received IS NULL";
        $accepted = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        foreach ($accepted as $key => $value) {
            if ($value['user_id'] == $user_id) {
                $tui_userId = $value['sent'];
            } else {
                $tui_userId = $value['user_id'];
            }
            $sql1 = "select tui.*, tug.image_path from tbl_user_info as tui LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $tui_userId . "'";
            $acceptedMembers[] = $adapter->query($sql1, Adapter::QUERY_MODE_EXECUTE)->current();
            $acceptedmemInfo[] = $value;
        }
        return new ViewModel(array(
            'acceptedMembers' => $acceptedMembers,
            'acceptedmemInfo' => $acceptedmemInfo,
        ));
    }

    public function sendRequestAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $request = $this->getRequest();
        $post = $request->getPost();
        $sent = $post['uid'];
        $type = $post['type'];
        if ($type == "yes") {
            $typeNo = 1;
        }
        if ($type == "maybe") {
            $typeNo = 2;
        }
        if ($type == "no") {
            $typeNo = 3;
        }
        if ($type == "request") {
            $typeNo = 4;
        }

        if ($type == 'yes') {
            $sql = "INSERT INTO tbl_member_invitation (user_id, sent, type) values ($user_id , $sent, $typeNo)";
            $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        }
        if ($type == 'maybe') {
            $sql = "INSERT INTO tbl_member_invitation (user_id, sent, type) values ($user_id , $sent, $typeNo)";
            $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        }
        if ($type == 'no') {
            $sql = "INSERT INTO tbl_member_invitation (user_id, sent, type) values ($user_id , $sent, $typeNo)";
            $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        }

        if ($type == 'request') {
            $sql = "INSERT INTO tbl_member_invitation (user_id, sent, type) values ($user_id , $sent, $typeNo)";
            $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        }
        //$result=array('djdhjdj','hhdhdhd');
        return new JsonModel(array('result' => ''));
    }

    //matrimonial start

    public function sentMatrimonialAction() {
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');


        $invitation = $adapter->query("select count('id') as invitation from tbl_matrimonial_invitation WHERE user_id=$user_id AND received IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->current();
        $sent = $adapter->query("select * from tbl_matrimonial_invitation WHERE user_id=$user_id AND sent IS NOT NULL", Adapter::QUERY_MODE_EXECUTE);
        $accepted = $adapter->query("select count('id') as accepted from tbl_matrimonial_invitation WHERE user_id=$user_id AND accepted IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->current();

        foreach ($sent as $key => $value) {
            $sentMember[] = $adapter->query("select tui.*, tug.image_name from tbl_user_info_matrimonial as tui LEFT JOIN tbl_user_gallery_matrimonial as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $value['sent'] . "'", Adapter::QUERY_MODE_EXECUTE)->current();
            //echo '<pre>';
            //print_r($sentMember);
        }


        return new ViewModel(array(
            //'invitation'=>$invitationMember,
            'sentMember' => $sentMember,
                //'accepted'=>$acceptedMember,
        ));
    }

    public function acceptedMatrimonialAction() {
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "select * from tbl_matrimonial_invitation WHERE type=5 AND (user_id='$user_id' OR sent='$user_id') AND accepted IS NOT NULL AND received IS NULL";
        $accepted = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        foreach ($accepted as $key => $value) {
            if ($value['user_id'] == $user_id) {
                $tui_userId = $value['sent'];
            } else {
                $tui_userId = $value['user_id'];
            }
            $sql1 = "select tui.*, tug.image_name from tbl_user_info_matrimonial as tui LEFT JOIN tbl_user_gallery_matrimonial as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $tui_userId . "'";
            $acceptedMembers[] = $adapter->query($sql1, Adapter::QUERY_MODE_EXECUTE)->current();
            $acceptedmemInfo[] = $value;
        }
        return new ViewModel(array(
            'acceptedMembers' => $acceptedMembers,
            'acceptedmemInfo' => $acceptedmemInfo,
        ));
    }

    public function receivedMatrimonialAction() {
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');


        $received = $adapter->query("select * from tbl_matrimonial_invitation WHERE user_id=$user_id AND received IS NOT NULL", Adapter::QUERY_MODE_EXECUTE);
//        echo '<pre>';
//   print_r($invitation);
        foreach ($received as $key => $value) {
            $receivedMember[] = $adapter->query("select tui.*, tug.image_name from tbl_user_info_matrimonial as tui LEFT JOIN tbl_user_gallery_matrimonial as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $value['received'] . "'", Adapter::QUERY_MODE_EXECUTE)->current();
            $memInfo[] = $value;

            //echo '<pre>';
            //print_r($sentMember);
        }
        //echo '<pre>';
        //print_r($received);

        return new ViewModel(array(
            //'invitation'=>$invitationMember,
            'receivedMember' => $receivedMember,
            'memInfo' => $memInfo,
        ));
    }

    public function interestacceptedMatrimonialAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $request = $this->getRequest();
        $post = $request->getPost();
        $id = $post['id'];
        $uid = $post['uid'];
        $type = $post['type'];
        $sql = "UPDATE tbl_matrimonial_invitation SET type=5, received=NULL, accepted='$uid' WHERE type='$type' AND sent='$user_id' AND user_id='$uid' AND id='$id'";
        //$sql = "UPDATE tbl_member_invitation SET received=NULL, accepted=$accepted WHERE id=$id";
        //echo $sql;
        //exit;
        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);

        return new JsonModel(array('result' => ''));
    }

    /// Function for matrimony Invitation Accepted Starts Here ///

    public function matrimonyinterestacceptedMatrimonialAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $request = $this->getRequest();
        $post = $request->getPost();
        $id = $post['id'];
        $uid = $post['uid'];
        $type = $post['type'];
        $sql = "UPDATE tbl_matrimonial_invitation SET type=5, received=NULL, accepted='$uid' WHERE type='$type' AND sent='$user_id' AND user_id='$uid' AND id='$id'";
        //echo $sql = "UPDATE tbl_member_invitation SET received=NULL, accepted=$accepted WHERE sent=$user_id and user_id=$accepted";
        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        //echo $sql;
        //exit;
        return new JsonModel(array('result' => ''));
    }

    /// Function for matrimony Invitation Accepted Ends Here ///



    public function selectedMembersMatrimonialAction() {
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $received = $adapter->query("select * from tbl_matrimonial_invitation WHERE user_id='$user_id' AND sent IS NOT NULL AND type=2", Adapter::QUERY_MODE_EXECUTE);
        foreach ($received as $key => $value) {
            $selectedMembers[] = $adapter->query("select tui.*, tug.image_name from tbl_user_info_matrimonial as tui LEFT JOIN tbl_user_gallery_matrimonial as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $value['sent'] . "'", Adapter::QUERY_MODE_EXECUTE)->current();
            $memInfo[] = $value;
        }
        return new ViewModel(array(
            'selectedMembers' => $selectedMembers,
            'memInfo' => $memInfo,
        ));
    }

    public function preferredMembersMatrimonialAction() {
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $preferred = $adapter->query("select * from tbl_matrimonial_invitation WHERE (sent='$user_id' OR user_id='$user_id') AND accepted IS NOT NULL AND type=7", Adapter::QUERY_MODE_EXECUTE);
        foreach ($preferred as $key => $value) {
            if ($value['user_id'] == $user_id) {
                $tui_userId = $value['sent'];
            } else {
                $tui_userId = $value['user_id'];
            }
            $preferredMembers[] = $adapter->query("select tui.*, tug.image_name from tbl_user_info_matrimonial as tui LEFT JOIN tbl_user_gallery_matrimonial as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $tui_userId . "'", Adapter::QUERY_MODE_EXECUTE)->current();
            //$preferredMembers1[] = $adapter->query("select tui.*, tug.image_path from tbl_user_info as tui LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $tui_userId . "'", Adapter::QUERY_MODE_EXECUTE)->current();
            $preferredmemInfo[] = $value;
            //$preferredmemInfo1[] = $value;
        }
        return new ViewModel(array(
            'preferredMembers' => $preferredMembers,
            'preferredMembers1' => $preferredMembers,
            'preferredmemInfo' => $preferredmemInfo,
            'preferredmemInfo1' => $preferredmemInfo,
        ));
    }

    public function declinedMembersMatrimonialAction() {
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "select * from tbl_matrimonial_invitation WHERE (type=3 OR type=4) AND (user_id='$user_id' OR sent='$user_id') AND accepted IS NULL AND received IS NULL";
        $declined = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        foreach ($declined as $key => $value) {
            if ($value['user_id'] == $user_id) {
                $tui_userId = $value['sent'];
            } else {
                $tui_userId = $value['user_id'];
            }
            $sql1 = "select tui.*, tug.image_name from tbl_user_info_matrimonial as tui LEFT JOIN tbl_user_gallery_matrimonial as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $tui_userId . "'";
            $declinedMembers[] = $adapter->query($sql1, Adapter::QUERY_MODE_EXECUTE)->current();
            $declinedmemInfo[] = $value;
        }
        return new ViewModel(array(
            'declinedMembers' => $declinedMembers,
            'declinedmemInfo' => $declinedmemInfo,
        ));
    }

    public function acceptedMembersMatrimonialAction() {
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "select * from tbl_matrimonial_invitation WHERE type=5 AND (user_id='$user_id' OR sent='$user_id') AND accepted IS NOT NULL AND received IS NULL";
        $accepted = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        foreach ($accepted as $key => $value) {
            if ($value['user_id'] == $user_id) {
                $tui_userId = $value['sent'];
            } else {
                $tui_userId = $value['user_id'];
            }
            $sql1 = "select tui.*, tug.image_name from tbl_user_info_matrimonial as tui LEFT JOIN tbl_user_gallery_matrimonial as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $tui_userId . "'";
            $acceptedMembers[] = $adapter->query($sql1, Adapter::QUERY_MODE_EXECUTE)->current();
            $acceptedmemInfo[] = $value;
        }
        return new ViewModel(array(
            'acceptedMembers' => $acceptedMembers,
            'acceptedmemInfo' => $acceptedmemInfo,
        ));
    }

    public function sendRequestMatrimonialAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $request = $this->getRequest();
        $post = $request->getPost();
        $sent = $post['uid'];
        $type = $post['type'];
        if ($type == "yes") {
            $typeNo = 1;
        }
        if ($type == "maybe") {
            $typeNo = 2;
        }
        if ($type == "no") {
            $typeNo = 3;
        }
        if ($type == "request") {
            $typeNo = 4;
        }

        if ($type == 'yes') {
            $sql = "INSERT INTO tbl_matrimonial_invitation (user_id, sent, type) values ($user_id , $sent, $typeNo)";
            $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        }
        if ($type == 'maybe') {
            $sql = "INSERT INTO tbl_matrimonial_invitation (user_id, sent, type) values ($user_id , $sent, $typeNo)";
            $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        }
        if ($type == 'no') {
            $sql = "INSERT INTO tbl_matrimonial_invitation (user_id, sent, type) values ($user_id , $sent, $typeNo)";
            $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        }

        if ($type == 'request') {
            $sql = "INSERT INTO tbl_matrimonial_invitation (user_id, sent, type) values ($user_id , $sent, $typeNo)";
            $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        }
        //$result=array('djdhjdj','hhdhdhd');
        return new JsonModel(array('result' => ''));
    }

    //matrimonila end
    //meber self profile view
    public function profileViewAction() {

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        //$user_id = intval($this->params()->fromQuery('member_id'));
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        if ($userSession->offsetGet('user_type') == '1') {
            if ($userSession->offsetGet('user_type_id') != '1') {
                echo 'unauthorize access';
                exit;
            }
            $userservice = new \Application\Mapper\UserDbSqlMapper($adapter);
            $familyInfo = $userservice->getFamilyInfoById($user_id);
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
            if ($familyInfo->familyInfoArray['mother_id'] = null) {
                $ids[] = $familyInfo->familyInfoArray['mother_id'];
            }
            //$ids[] = $familyInfo->familyInfoArray['mother_id'];
            //$errors = array_filter($ids);
            //\Zend\Debug\Debug::dump($ids);
//if (!empty($errors)) {


            $Fdata = $adapter->query("select * from tbl_user_gallery where user_id IN (" . implode(',', $ids) . ") ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
//}else{
            //$Fphotos=array();
//}
            foreach ($Fdata as $F_data) {
                $Fphotos[] = $F_data['image_path'];
            }
            shuffle($Fphotos);
            shuffle($Pphotos);
            $data_gallery = $adapter->query("select * from tbl_user_gallery where user_id='$user_id' ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
            //for side bars

            $sent = $this->getSentRequestCount($user_id);
            $accepted = $this->getAcceptedRequestCount($user_id);
            $invitation = $this->getReceivedRequestCount($user_id);
            $declineRequest = $this->getDeclineRequestCount($user_id);

            $acceptedMember = $this->getAcceptedInvitationList($user_id);
            $percentage = $this->userService->ProfileBar($user_id);
            $pro_per = array($percentage, $this->profileBarTemplate($percentage));
            $recievedInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'received']);
            $sentInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sent']);
            $acceptedInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'accepted']);
            $newMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'newMembers']);
            $selectedMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'selectedMembers']);
            $preferredMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'preferredMembers']);
            //  
            //Debug::dump($this->userService->userSummaryById($user_id));
            return new ViewModel(array("userinfo" => $records,
                "officeData" => $commanData,
                "filters_data" => $filters_data,
                "Pphotos" => $Pphotos,
                "F_photos" => $Fphotos,
                "gallery_data" => $data_gallery,
                'userSummary' => $userservice->userSummaryById($user_id),
                'familyInfo' => $familyInfo,
                //for bars
                'acceptedInfo' => $acceptedInfo->acceptedMember,
                'userSummary' => $this->userService->userSummaryById($user_id),
                'invitation' => $invitation,
                'sent' => $sent,
                'accepted' => $accepted,
                'acceptedMember' => $acceptedMember,
                "percent" => $pro_per,
                'receivedMember' => $recievedInfo,
                'sentInfo' => $sentInfo,
                'newMemberInfo' => $newMemberInfo->newMember,
                'selectedMemberInfo' => $selectedMemberInfo,
                "postCategory" => $this->commonService->getPostCategoryList(),
                'declineRequest' => $declineRequest,
                'preferredMemberInfo' => $preferredMemberInfo,
            ));
        }
        if ($userSession->offsetGet('user_type') == '2') {

            $view = new ViewModel();
        }
    }

    //matrimony profile view self
    public function viewProfileAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        //$user_id = intval($this->params()->fromQuery('member_id'));
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');

        if ($userSession->offsetGet('user_type') == '1') {
            $userservice = new \Application\Mapper\UserDbSqlMapper($adapter);
            $familyInfo = $userservice->getFamilyInfoById($user_id);
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
            if ($familyInfo->familyInfoArray['mother_id'] = null) {
                $ids[] = $familyInfo->familyInfoArray['mother_id'];
            }
            //$ids[] = $familyInfo->familyInfoArray['mother_id'];
            //$errors = array_filter($ids);
            //\Zend\Debug\Debug::dump($ids);
//if (!empty($errors)) {


            $Fdata = $adapter->query("select * from tbl_user_gallery where user_id IN (" . implode(',', $ids) . ") ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
//}else{
            //$Fphotos=array();
//}
            foreach ($Fdata as $F_data) {
                $Fphotos[] = $F_data['image_path'];
            }
            shuffle($Fphotos);
            shuffle($Pphotos);
            $data_gallery = $adapter->query("select * from tbl_user_gallery where user_id='$user_id' ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
            //for side bars
            $invitation = $adapter->query("select count('id') as invitation from tbl_member_invitation WHERE user_id=$user_id AND received IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->current();
            $sent = $adapter->query("select count('id') as sent from tbl_member_invitation WHERE user_id=$user_id AND sent IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->current();
            $accepted = $this->getAcceptedRequestCount($user_id);
            $acceptedMember = $this->getAcceptedInvitationList($user_id);
            $percentage = $this->userService->ProfileBar($user_id);
            $pro_per = array($percentage, $this->profileBarTemplate($percentage));
            $recievedInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'received']);
            $sentInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sent']);
            $acceptedInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'accepted']);
            $newMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'newMembers']);
            $selectedMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'selectedMembers']);

            $referralKeyUsedInfo = $this->getreferralKeyUsedCount($user_id);

            $declineRequest = $this->getDeclineRequestCount($user_id);
            //Debug::dump($this->userService->userSummaryById($user_id));
            return new ViewModel(array("userinfo" => $records,
                "officeData" => $commanData,
                "filters_data" => $filters_data,
                "Pphotos" => $Pphotos,
                "F_photos" => $Fphotos,
                "gallery_data" => $data_gallery,
                //'userSummary' => $userservice->userSummaryById($user_id),
                'familyInfo' => $familyInfo,
                //for bars
                'acceptedInfo' => $acceptedInfo->acceptedMember,
                'userSummary' => $this->userService->userSummaryById($user_id),
                'invitation' => $invitation,
                'sent' => $sent,
                'accepted' => $accepted,
                'acceptedMember' => $acceptedMember,
                "percent" => $pro_per,
                'receivedMember' => $recievedInfo,
                'sentInfo' => $sentInfo,
                'newMemberInfo' => $newMemberInfo->newMember,
                'selectedMemberInfo' => $selectedMemberInfo->selectedMembers,
                "postCategory" => $this->commonService->getPostCategoryList(),
                'referralKeyUsedInfo' => $referralKeyUsedInfo,
                'declineRequest' => $declineRequest,
            ));
        }
        if ($userSession->offsetGet('user_type') == '2') {
            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $info = $this->userService->getUserPersonalDetailByIdMatrimonial($user_id);
            $percentage = $this->userService->ProfileBarMatrimonial($user_id);
            $pro_per = array($percentage, $this->profileBarTemplate($percentage));
            $userSummary = $this->userService->userSummaryByIdMatrimonial($user_id);
            $brotherData = $this->userService->getBrotherMatrimonial($user_id);
            $fatherData = $this->userService->getFatherMatrimonial($user_id);
            $motherData = $this->userService->getMotherMatrimonial($user_id);
            $sisterData = $this->userService->getSisterMatrimonial($user_id);
            $kidsData = $this->userService->getKidMatrimonial($user_id);
            $spouseData = $this->userService->getSpouseMatrimonial($user_id);
            //Debug::dump($this->userService->userSummaryByIdMatrimonial($user_id));exit;
            //Debug::dump($userSummary); die;
            $sql = "select * from tbl_user_gallery_matrimonial where user_id='$user_id' AND user_type='U' AND image_type='1' ORDER BY id DESC";
            $profile_pic = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();

            $sidebarLeft = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarLeftMatrimonial']);
            $sidebarRight = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarRightMatrimonial']);

            $viewModel = new ViewModel(
                    array('userSummary' => $this->userService->userSummaryByIdMatrimonial($user_id),
                'url' => 'personal-profile',
                'profile_pic' => $profile_pic,
                'user_id' => $user_id,
                'brotherData' => $brotherData,
                'fatherData' => $fatherData,
                'motherData' => $motherData,
                'sisterData' => $sisterData,
                'kidsData' => $kidsData,
                'spouseData' => $spouseData,
                "percent" => $pro_per)
            );
            $viewModel->addChild($sidebarLeft, 'sidebarLeft');
            $viewModel->addChild($sidebarRight, 'sidebarRight');
            $viewModel->setTemplate('application/profile/view-profile-matrimonial.phtml');
            return $viewModel;
        }
    }

    public function dashboardMatrimonyAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');

        /// Code Line For New Matrimony matches //////
        $newMatrimonyMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'newMembersMatrimonial']);
        $referralKeyUsedInfo = $this->getreferralKeyUsedCountMatrimonial($user_id);
        $percentage = $this->userService->ProfileBarMatrimonial($user_id);
        $pro_per = array($percentage, $this->profileBarTemplate($percentage));

        $sql = "select * from tbl_user_gallery_matrimonial where user_id='$user_id' AND user_type='U' AND image_type='1' ORDER BY id DESC";
        $profile_pic = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        $sqlInvitation = "SELECT * FROM tbl_matrimonial_invitation WHERE user_id='$user_id' OR accepted='$user_id' OR sent='$user_id' OR received='$user_id'";
        $result = $adapter->query($sqlInvitation, Adapter::QUERY_MODE_EXECUTE);
        $resultSet = new \Zend\Db\ResultSet\ResultSet();
        $invitationRows = $resultSet->initialize($result)->toArray();
        $sidebarLeft = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarLeftMatrimonial']);
        $sidebarRight = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarRightMatrimonial']);
        $filters_data=$this->sidebarFilters();
        // Debug::dump($rightSidebar);exit;      
        $viewModel = new ViewModel(array(
            'userSummary' => $this->userService->userSummaryByIdMatrimonial($user_id),
            'invitationRows' => $invitationRows,
            'referralKeyUsedInfo' => $referralKeyUsedInfo,
            'newMemberInfo' => $newMatrimonyMemberInfo->newMatrimonyMember,
            'profile_pic' => $profile_pic,
            'filters_data' => $filters_data,
            "percent" => $pro_per,            
        ));
        $viewModel->addChild($sidebarLeft, 'sidebarLeft');
        $viewModel->addChild($sidebarRight, 'sidebarRight');
        return $viewModel;
    }

    public function matrimonydeclinedAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');

        /// Code Line For New Matrimony matches //////
        $newMatrimonyMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'newMembersMatrimonial']);
        $referralKeyUsedInfo = $this->getreferralKeyUsedCountMatrimonial($user_id);
        $percentage = $this->userService->ProfileBarMatrimonial($user_id);
        $pro_per = array($percentage, $this->profileBarTemplate($percentage));

        $sql = "select * from tbl_user_gallery_matrimonial where user_id='$user_id' AND user_type='U' AND image_type='1' ORDER BY id DESC";
        $profile_pic = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        $sqlInvitation = "SELECT * FROM tbl_matrimonial_invitation WHERE user_id='$user_id' OR accepted='$user_id' OR sent='$user_id' OR received='$user_id'";
        $result = $adapter->query($sqlInvitation, Adapter::QUERY_MODE_EXECUTE);
        $resultSet = new \Zend\Db\ResultSet\ResultSet();
        $invitationRows = $resultSet->initialize($result)->toArray();

        $sidebarLeft = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarLeftMatrimonial']);
        $sidebarRight = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarRightMatrimonial']);
        //Debug::dump($recievedInfo);exit;      
        $viewModel = new ViewModel(array(
            'userSummary' => $this->userService->userSummaryByIdMatrimonial($user_id),
            'invitationRows' => $invitationRows,
            'referralKeyUsedInfo' => $referralKeyUsedInfo,
            'newMemberInfo' => $newMatrimonyMemberInfo->newMatrimonyMember,
            'profile_pic' => $profile_pic,
        ));

        $viewModel->addChild($sidebarLeft, 'sidebarLeft');
        $viewModel->addChild($sidebarRight, 'sidebarRight');
        return $viewModel;
    }

    public function memberdeclinedAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        if ($userSession->offsetGet('user_type_id') != '1') {
            echo 'unauthorize access';
            exit;
        }

        $referralKeyUsedInfo = $this->getreferralKeyUsedCount($user_id);
        $sent = $this->getSentRequestCount($user_id);
        $accepted = $this->getAcceptedRequestCount($user_id);
        $invitation = $this->getReceivedRequestCount($user_id);
        $declineRequest = $this->getDeclineRequestCount($user_id);

        $acceptedMember = $this->getAcceptedInvitationList($user_id);
        $selectedMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'selectedMembers']);
        $declinedMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'declinedMembers']);
        $preferredMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'preferredMembers']);
//'declinedMembers' => $declinedMembers,
        //'declinedmemInfo' => $declinedmemInfo,
        //Debug::dump($declinedMemberInfo->declinedmemInfo);
        return new ViewModel(array(
            'userSummary' => $this->userService->userSummaryById($user_id),
            'referralKeyUsedInfo' => $referralKeyUsedInfo,
            'invitation' => $invitation,
            'sent' => $sent,
            'accepted' => $accepted,
            'declineRequest' => $declineRequest,
            'declinedMemberInfo' => $declinedMemberInfo,
            'acceptedMember' => $acceptedMember,
            'selectedMemberInfo' => $selectedMemberInfo,
            'preferredMemberInfo' => $preferredMemberInfo,
        ));
    }

    public function memberinvitationreceivedAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        if ($userSession->offsetGet('user_type_id') != '1') {
            echo 'unauthorize access';
            exit;
        }

        $referralKeyUsedInfo = $this->getreferralKeyUsedCount($user_id);
        $sent = $this->getSentRequestCount($user_id);
        $accepted = $this->getAcceptedRequestCount($user_id);
        $invitation = $this->getReceivedRequestCount($user_id);
        $declineRequest = $this->getDeclineRequestCount($user_id);

        $acceptedMember = $this->getAcceptedInvitationList($user_id);
        $selectedMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'selectedMembers']);
        $receivedInvitationList = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'invitationReceivedMembers']);
        $preferredMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'preferredMembers']);

        return new ViewModel(array(
            'userSummary' => $this->userService->userSummaryById($user_id),
            'referralKeyUsedInfo' => $referralKeyUsedInfo,
            'invitation' => $invitation,
            'sent' => $sent,
            'accepted' => $accepted,
            'declineRequest' => $declineRequest,
            'receivedInvitationList' => $receivedInvitationList,
            'acceptedMember' => $acceptedMember,
            'selectedMemberInfo' => $selectedMemberInfo,
            'preferredMemberInfo' => $preferredMemberInfo,
        ));
    }

    public function memberinvitationsentAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        if ($userSession->offsetGet('user_type_id') != '1') {
            echo 'unauthorize access';
            exit;
        }

        $referralKeyUsedInfo = $this->getreferralKeyUsedCount($user_id);
        $sent = $this->getSentRequestCount($user_id);
        $accepted = $this->getAcceptedRequestCount($user_id);
        $invitation = $this->getReceivedRequestCount($user_id);
        $declineRequest = $this->getDeclineRequestCount($user_id);

        $acceptedMember = $this->getAcceptedInvitationList($user_id);
        $selectedMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'selectedMembers']);
        $sentInvitationList = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'invitationSentMembers']);
        $preferredMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'preferredMembers']);

        return new ViewModel(array(
            'userSummary' => $this->userService->userSummaryById($user_id),
            'referralKeyUsedInfo' => $referralKeyUsedInfo,
            'invitation' => $invitation,
            'sent' => $sent,
            'accepted' => $accepted,
            'declineRequest' => $declineRequest,
            'sentInvitationList' => $sentInvitationList,
            'acceptedMember' => $acceptedMember,
            'selectedMemberInfo' => $selectedMemberInfo,
            'preferredMemberInfo' => $preferredMemberInfo,
        ));
    }

    //profile view matrimony other
    public function profileViewMatrimonyAction() {
        $user_id = $this->params()->fromQuery('matrimony_id');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        //$user_id = intval($this->params()->fromQuery('member_id'));
        //$userSession = $this->getUser()->session();
        //$user_id = $userSession->offsetGet('id');
        //$ref_no = $userSession->offsetGet('ref_no');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $info = $this->userService->getUserPersonalDetailByIdMatrimonial($user_id);
        $percentage = $this->userService->ProfileBarMatrimonial($user_id);
        $pro_per = array($percentage, $this->profileBarTemplate($percentage));
        $userSummary = $this->userService->userSummaryByIdMatrimonial($user_id);
        $brotherData = $this->userService->getBrotherMatrimonial($user_id);
        $fatherData = $this->userService->getFatherMatrimonial($user_id);
        $motherData = $this->userService->getMotherMatrimonial($user_id);
        $sisterData = $this->userService->getSisterMatrimonial($user_id);
        $kidsData = $this->userService->getKidMatrimonial($user_id);
        $spouseData = $this->userService->getSpouseMatrimonial($user_id);
        //Debug::dump($this->userService->userSummaryByIdMatrimonial($user_id));exit;
        $userSummary = $this->userService->userSummaryByIdMatrimonial($user_id);

        $sql = "select * from tbl_user_gallery_matrimonial where user_id='$user_id' AND user_type='U' AND image_type='1' ORDER BY id DESC";
        $profile_pic = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        $sidebarLeft = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarLeftMatrimonial', 'userSummary' => $userSummary]);
        $sidebarRight = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarRightMatrimonial']);
        $viewModel = new ViewModel(
                array('userSummary' => $this->userService->userSummaryByIdMatrimonial($user_id),
            'url' => 'personal-profile',
            'profile_pic' => $profile_pic,
            'user_id' => $user_id,
            'brotherData' => $brotherData,
            'fatherData' => $fatherData,
            'motherData' => $motherData,
            'sisterData' => $sisterData,
            'kidsData' => $kidsData,
            'spouseData' => $spouseData,
            "percent" => $pro_per)
        );
        //$viewModel->setTemplate('application/profile/view-profile-matrimonial.phtml');
        $viewModel->addChild($sidebarLeft, 'sidebarLeft');
        $viewModel->addChild($sidebarRight, 'sidebarRight');
        return $viewModel;
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

    //profile view member other
    public function profileViewMemberAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        if ($userSession->offsetGet('user_type_id') != '1') {
            echo 'unauthorize access';
            exit;
        }
        $member_id = intval($this->params()->fromQuery('member_id'));
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $userservice = new \Application\Mapper\UserDbSqlMapper($adapter);
        $familyInfo = $userservice->getFamilyInfoById($member_id);
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
        $data = $adapter->query("select * from tbl_user_gallery where user_id='$member_id' ORDER BY id DESC limit 6", Adapter::QUERY_MODE_EXECUTE)->toArray();

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
        if ($familyInfo->familyInfoArray['mother_id'] = null) {
            $ids[] = $familyInfo->familyInfoArray['mother_id'];
        }
        //$ids[] = $familyInfo->familyInfoArray['mother_id'];
        //$errors = array_filter($ids);
        //\Zend\Debug\Debug::dump($ids);
//if (!empty($errors)) {


        $Fdata = $adapter->query("select * from tbl_user_gallery where user_id IN (" . implode(',', $ids) . ") ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
//}else{
        //$Fphotos=array();
//}
        foreach ($Fdata as $F_data) {
            $Fphotos[] = $F_data['image_path'];
        }
        //echo "Mohit"; die;
        shuffle($Fphotos);
        shuffle($Pphotos);
        $data_gallery = $adapter->query("select * from tbl_user_gallery where user_id='$user_id' ORDER BY id DESC", Adapter::QUERY_MODE_EXECUTE);
        //for side bars
        $invitation = $adapter->query("select count('id') as invitation from tbl_member_invitation WHERE user_id=$user_id AND received IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->current();
        $sent = $adapter->query("select count('id') as sent from tbl_member_invitation WHERE user_id=$user_id AND sent IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->current();
        $accepted = $adapter->query("select count('id') as accepted from tbl_member_invitation WHERE user_id=$user_id AND accepted IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->current();

        $acceptedMember = $this->getAcceptedInvitationList($user_id);
        $percentage = $this->userService->ProfileBar($member_id);
        $pro_per = array($percentage, $this->profileBarTemplate($percentage));
        $recievedInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'received']);
        $sentInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sent']);
        $acceptedInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'accepted']);
        $newMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'newMembers']);
        $selectedMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'selectedMembers']);
        $preferredMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'preferredMembers']);
        //  
        //Debug::dump($this->userService->userSummaryById($user_id));
        return new ViewModel(array("userinfo" => $records,
            "officeData" => $commanData,
            "filters_data" => $filters_data,
            "Pphotos" => $Pphotos,
            "F_photos" => $Fphotos,
            "gallery_data" => $data_gallery,
            //'userSummary' => $userservice->userSummaryById($user_id),
            'familyInfo' => $familyInfo,
            //for bars
            'acceptedInfo' => $acceptedInfo->acceptedMember,
            'userSummary' => $this->userService->userSummaryById($member_id),
            'invitation' => $invitation,
            'sent' => $sent,
            'accepted' => $accepted,
            'acceptedMember' => $acceptedMember,
            "percent" => $pro_per,
            'receivedMember' => $recievedInfo,
            'sentInfo' => $sentInfo,
            'newMemberInfo' => $newMemberInfo->newMember,
            'selectedMemberInfo' => $selectedMemberInfo,
            "postCategory" => $this->commonService->getPostCategoryList(),
            'preferredMemberInfo' => $preferredMemberInfo,
        ));
    }

    public function changePasswordAction() {



        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        //$user_id = intval($this->params()->fromQuery('member_id'));
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $userTypeId = $userSession->offsetGet('user_type_id');
        $mobile_no = $userSession->offsetGet('mobile_no');
        $ref_no = $userSession->offsetGet('ref_no');
        if ($userSession->offsetGet('user_type') == '1') {


            $userservice = new \Application\Mapper\UserDbSqlMapper($adapter);
            $familyInfo = $userservice->getFamilyInfoById($user_id);
            $commanData = array();
            $commanData["officecountry"] = '';
            $commanData["officestate"] = '';
            $commanData["officecity"] = '';
            $msg = "";
            //save change password start...
            $old_password2 = md5($_POST['old_password2']);

            if ($this->getRequest()->isPost()) {
                //echo  "hello";exit;
                if (empty($_POST['old_password2']) && empty($_POST['new_password']) && empty($_POST['confirm_password'])) {
                    $msg = "";
                    $old_password_error = "old password should not be empty";
                    $new_password_error = "new password should not be empty";
                    $confirm_password_error = "confirm password should not be empty";
                }
            } else {
                $old_password_error = "";
                $new_password_error = "";
                $confirm_password_error = "";
            }



            if (isset($_POST['old_password2'])) {
                //echo "select * from tbl_mobile where code=" . $_POST['otp']; die;
                $arrdef = $adapter->query("select * from tbl_user where (id='" . $user_id . "' && password='" . $old_password2 . "')", Adapter::QUERY_MODE_EXECUTE);
                $size = $arrdef->count();

                $cpwd = 1;

                if (strcmp($_POST['new_password'], $_POST['confirm_password']) == 0) {
                    //echo  "world";exit;
                    $cpwd = 1;
                } else {
                    $cpwd = 2;
                }
            }

            if ($this->getRequest()->isPost() && !empty($_POST['old_password2']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {


                if ($size != 0 && $cpwd == 1) {

                    //echo "hello";exit;
                    $sql = "UPDATE tbl_user SET password='" . md5($_POST['new_password']) . "' WHERE id='" . $user_id . "' AND mobile_no='" . $mobile_no . "'";

                    $query = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);

                    //on success message
                    //$changePwd = 'Password changed successfully';
                    //$this->flashMessenger()->addMessage(array('success' => 'Password  changed successfully...'));
                    $msg = "Password  changed successfully...";
                } elseif ($size == 0 || $cpwd != 2) {
                    //on failure message
                    //$notchangePwd = 'Password not changed';exit;
                    //$this->flashMessenger()->addMessage(array('success' => 'Password not changed...'));
                    $msg = "<span style='color:red;'>Old Password Or Confirm Password  not matched...</span>";
                }
            }


            //end...


            return new ViewModel(array(
                "postCategory" => $this->commonService->getPostCategoryList(),
                "msg" => $msg,
                "old_password_error" => $old_password_error,
                "new_password_error" => $new_password_error,
                "confirm_password_error" => $confirm_password_error,
            ));
        }

        if ($userSession->offsetGet('user_type') == '2') {
            $userservice = new \Application\Mapper\UserDbSqlMapper($adapter);
            $familyInfo = $userservice->getFamilyInfoById($user_id);
            $commanData = array();
            $commanData["officecountry"] = '';
            $commanData["officestate"] = '';
            $commanData["officecity"] = '';
            $msg = "";
            //save change password start...
            $old_password2 = md5($_POST['old_password2']);

            if ($this->getRequest()->isPost()) {
                //echo  "hello";exit;
                if (empty($_POST['old_password2']) && empty($_POST['new_password']) && empty($_POST['confirm_password'])) {
                    $msg = "";
                    $old_password_error = "old password should not be empty";
                    $new_password_error = "new password should not be empty";
                    $confirm_password_error = "confirm password should not be empty";
                }
            } else {
                $old_password_error = "";
                $new_password_error = "";
                $confirm_password_error = "";
            }



            if (isset($_POST['old_password2'])) {
                //echo "select * from tbl_mobile where code=" . $_POST['otp']; die;
                $arrdef = $adapter->query("select * from tbl_user_matrimonial where (id='" . $user_id . "' && password='" . $old_password2 . "')", Adapter::QUERY_MODE_EXECUTE);
                $size = $arrdef->count();

                $cpwd = 1;

                if (strcmp($_POST['new_password'], $_POST['confirm_password']) == 0) {
                    //echo  "world";exit;
                    $cpwd = 1;
                } else {
                    $cpwd = 2;
                }
            }

            if ($this->getRequest()->isPost() && !empty($_POST['old_password2']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {


                if ($size != 0 && $cpwd == 1) {

                    //echo "hello";exit;
                    $sql = "UPDATE tbl_user_matrimonial SET password='" . md5($_POST['new_password']) . "' WHERE id='" . $user_id . "' AND mobile_no='" . $mobile_no . "'";

                    $query = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);

                    //on success message
                    //$changePwd = 'Password changed successfully';
                    //$this->flashMessenger()->addMessage(array('success' => 'Password  changed successfully...'));
                    $msg = "Password  changed successfully...";
                } elseif ($size == 0 || $cpwd != 2) {
                    //on failure message
                    //$notchangePwd = 'Password not changed';exit;
                    //$this->flashMessenger()->addMessage(array('success' => 'Password not changed...'));
                    $msg = "<span style='color:red;'>Old Password Or Confirm Password  not matched...</span>";
                }
            }


            $sidebarLeft = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarLeftMatrimonial']);


            $viewModel = new ViewModel(array(
                "postCategory" => $this->commonService->getPostCategoryList(),
                "msg" => $msg,
                "old_password_error" => $old_password_error,
                "new_password_error" => $new_password_error,
                "confirm_password_error" => $confirm_password_error,
            ));
            
             $viewModel->addChild($sidebarLeft, 'sidebarLeft');
             return $viewModel;
        }
    }

    //send otp to mobile
//    public function sendOtpByChangePwdAction(){
//        //$mobile=$this->params()->fromPost('number');
//        //echo  "hello amir";exit;
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        //$session=new Container('user');
//        $userSession = $this->getUser()->session();
//        
//        //$user_id='';
//        
//        if($userSession->offsetGet('id')){
//            //echo  "hello amir";exit;
//            //echo $userSession->offsetGet('id');exit;
//            $sqlUser="SELECT * FROM tbl_user WHERE id='".$userSession->offsetGet('id')."'";
//            $userData=$adapter->query($sqlUser, Adapter::QUERY_MODE_EXECUTE)->toArray();
//            $code = rand(1111, 9999);
//            date_default_timezone_set('Asia/Kolkata');
//            $time = date('H:i');
//            $sql="UPDATE tbl_mobile SET code='$code', time='$time' WHERE user_id='".$userSession->offsetGet('id')."'";
//            //exit;
//            $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
//            $this->sendAccountThanksSms($userData[0]['username'], $userSession->offsetGet('mobile_no'), $code);
//            $succarr = array("userid" => $userData[0]['id'], "mobile" => $userData[0]['mobile_no']);
//            return new JsonModel(array("resp" => 1, "message" => "otp sent"));
//            
//        }else{
//           return new JsonModel(array("resp" => 0, "message" => "you are not authorise"));
//        }
//        
//        
//        
//    }

    public function memberAcceptedAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        if ($userSession->offsetGet('user_type_id') != '1') {
            echo 'unauthorize access';
            exit;
        }

        $referralKeyUsedInfo = $this->getreferralKeyUsedCount($user_id);
        $sent = $this->getSentRequestCount($user_id);
        $accepted = $this->getAcceptedRequestCount($user_id);
        $invitation = $this->getReceivedRequestCount($user_id);
        $declineRequest = $this->getDeclineRequestCount($user_id);

        $acceptedMember = $this->getAcceptedInvitationList($user_id);
        $selectedMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'selectedMembers']);
        $acceptedMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'acceptedMembers']);

        $preferredMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'preferredMembers']);

        //Debug::dump($preferredMemberInfo->preferredmemInfo);
        // 'preferredMembers' => $preferredMembers,
        //   'preferredmemInfo' => $preferredmemInfo,

        return new ViewModel(array(
            'userSummary' => $this->userService->userSummaryById($user_id),
            'referralKeyUsedInfo' => $referralKeyUsedInfo,
            'invitation' => $invitation,
            'sent' => $sent,
            'accepted' => $accepted,
            'declineRequest' => $declineRequest,
            'acceptedMemberInfo' => $acceptedMemberInfo,
            'acceptedMember' => $acceptedMember,
            'selectedMemberInfo' => $selectedMemberInfo,
            'preferredMemberInfo' => $preferredMemberInfo,
        ));
    }

    public function memberAcceptedOldAction() {
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $invitation = $adapter->query("select count('id') as invitation from tbl_member_invitation WHERE user_id=$user_id AND received IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->current();
        $sent = $adapter->query("select count('id') as sent from tbl_member_invitation WHERE user_id=$user_id AND sent IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->current();
        $accepted = $adapter->query("select count('id') as accepted from tbl_member_invitation WHERE user_id=$user_id AND accepted IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->current();
        $acceptedMembers = $adapter->query("select * from tbl_member_invitation WHERE user_id=$user_id AND accepted IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->toArray();
        foreach ($acceptedMembers as $key => $value) {
            $acceptedMember[] = $adapter->query("select tui.*, tug.image_path from tbl_user_info as tui LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $value['accepted'] . "'", Adapter::QUERY_MODE_EXECUTE)->current();
            //echo '<pre>';
            //print_r($acceptedMember);
        }
        $percentage = $this->userService->ProfileBar($user_id);
        $pro_per = array($percentage, $this->profileBarTemplate($percentage));
        $familyInfo = $this->userService->getFamilyInfoById($user_id);
        $recievedInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'received']);
        $sentInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sent']);
        $acceptedInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'accepted']);
        $newMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'newMembers']);
        $selectedMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'selectedMembers']);

        //Debug::dump($acceptedInfo->acceptedMember);
        return new ViewModel(array(
            'acceptedInfo' => $acceptedInfo->acceptedMember,
            'userSummary' => $this->userService->userSummaryById($user_id),
            'invitation' => $invitation,
            'sent' => $sent,
            'accepted' => $accepted,
            'acceptedMember' => $acceptedMember,
            "percent" => $pro_per,
            'receivedMember' => $recievedInfo,
            'sentInfo' => $sentInfo,
            'newMemberInfo' => $newMemberInfo->newMember,
            'selectedMemberInfo' => $selectedMemberInfo->selectedMembers,
            "postCategory" => $this->commonService->getPostCategoryList(),
            'familyInfo' => $familyInfo
        ));
    }

    public function memberPreferredAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        if ($userSession->offsetGet('user_type_id') != '1') {
            echo 'unauthorize access';
            exit;
        }

        $referralKeyUsedInfo = $this->getreferralKeyUsedCount($user_id);
        $sent = $this->getSentRequestCount($user_id);
        $accepted = $this->getAcceptedRequestCount($user_id);
        $invitation = $this->getReceivedRequestCount($user_id);
        $declineRequest = $this->getDeclineRequestCount($user_id);

        $acceptedMember = $this->getAcceptedInvitationList($user_id);
        $selectedMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'selectedMembers']);
        $acceptedMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'acceptedMembers']);

        $preferredMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'preferredMembers']);

        //Debug::dump($preferredMemberInfo->preferredmemInfo);
        // 'preferredMembers' => $preferredMembers,
        //   'preferredmemInfo' => $preferredmemInfo,

        return new ViewModel(array(
            'userSummary' => $this->userService->userSummaryById($user_id),
            'referralKeyUsedInfo' => $referralKeyUsedInfo,
            'invitation' => $invitation,
            'sent' => $sent,
            'accepted' => $accepted,
            'declineRequest' => $declineRequest,
            'acceptedMemberInfo' => $acceptedMemberInfo,
            'acceptedMember' => $acceptedMember,
            'selectedMemberInfo' => $selectedMemberInfo,
            'preferredMemberInfo' => $preferredMemberInfo,
        ));
    }

    public function matrimonyPreferredAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');

        /// Code Line For New Matrimony matches //////
        $newMatrimonyMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'newMembersMatrimonial']);
        $referralKeyUsedInfo = $this->getreferralKeyUsedCountMatrimonial($user_id);
        $percentage = $this->userService->ProfileBarMatrimonial($user_id);
        $pro_per = array($percentage, $this->profileBarTemplate($percentage));

        $sql = "select * from tbl_user_gallery_matrimonial where user_id='$user_id' AND user_type='U' AND image_type='1' ORDER BY id DESC";
        $profile_pic = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        $sqlInvitation = "SELECT * FROM tbl_matrimonial_invitation WHERE user_id='$user_id' OR accepted='$user_id' OR sent='$user_id' OR received='$user_id'";
        $result = $adapter->query($sqlInvitation, Adapter::QUERY_MODE_EXECUTE);
        $resultSet = new \Zend\Db\ResultSet\ResultSet();
        $invitationRows = $resultSet->initialize($result)->toArray();
        //Debug::dump($recievedInfo);exit;      
        return new ViewModel(array(
            'userSummary' => $this->userService->userSummaryByIdMatrimonial($user_id),
            'invitationRows' => $invitationRows,
            'referralKeyUsedInfo' => $referralKeyUsedInfo,
            'newMemberInfo' => $newMatrimonyMemberInfo->newMatrimonyMember,
            'profile_pic' => $profile_pic,
        ));
    }

    public function matrimonyAcceptedAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');

        /// Code Line For New Matrimony matches //////
        $newMatrimonyMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'newMembersMatrimonial']);
        $referralKeyUsedInfo = $this->getreferralKeyUsedCountMatrimonial($user_id);
        $percentage = $this->userService->ProfileBarMatrimonial($user_id);
        $pro_per = array($percentage, $this->profileBarTemplate($percentage));

        $sql = "select * from tbl_user_gallery_matrimonial where user_id='$user_id' AND user_type='U' AND image_type='1' ORDER BY id DESC";
        $profile_pic = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        $sqlInvitation = "SELECT * FROM tbl_matrimonial_invitation WHERE user_id='$user_id' OR accepted='$user_id' OR sent='$user_id' OR received='$user_id'";
        $result = $adapter->query($sqlInvitation, Adapter::QUERY_MODE_EXECUTE);
        $resultSet = new \Zend\Db\ResultSet\ResultSet();
        $invitationRows = $resultSet->initialize($result)->toArray();

        $sidebarLeft = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarLeftMatrimonial']);
        $sidebarRight = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarRightMatrimonial']);
        //Debug::dump($recievedInfo);exit;      
        $viewModel = new ViewModel(array(
            'userSummary' => $this->userService->userSummaryByIdMatrimonial($user_id),
            'invitationRows' => $invitationRows,
            'referralKeyUsedInfo' => $referralKeyUsedInfo,
            'newMemberInfo' => $newMatrimonyMemberInfo->newMatrimonyMember,
            'profile_pic' => $profile_pic,
        ));
        $viewModel->addChild($sidebarLeft, 'sidebarLeft');
        $viewModel->addChild($sidebarRight, 'sidebarRight');
        return $viewModel;
    }

    public function memberPendingAction() {

        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');


        $invitation = $adapter->query("select count('id') as invitation from tbl_member_invitation WHERE user_id=$user_id AND received IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->current();
        $sent = $adapter->query("select count('id') as sent from tbl_member_invitation WHERE user_id=$user_id AND sent IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->current();
        $accepted = $adapter->query("select count('id') as accepted from tbl_member_invitation WHERE user_id=$user_id AND accepted IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->current();
        $acceptedMembers = $adapter->query("select * from tbl_member_invitation WHERE user_id=$user_id AND accepted IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->toArray();
        foreach ($acceptedMembers as $key => $value) {
            $acceptedMember[] = $adapter->query("select tui.*, tug.image_path from tbl_user_info as tui LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $value['accepted'] . "'", Adapter::QUERY_MODE_EXECUTE)->current();
            //echo '<pre>';
            //print_r($acceptedMember);
        }
        $percentage = $this->userService->ProfileBar($user_id);
        $pro_per = array($percentage, $this->profileBarTemplate($percentage));
        $familyInfo = $this->userService->getFamilyInfoById($user_id);
        $recievedInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'received']);
        $sentInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sent']);
        $acceptedInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'accepted']);
        $newMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'newMembers']);
        $selectedMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'selectedMembers']);

        return new ViewModel(array(
            'acceptedInfo' => $acceptedInfo->acceptedMember,
            'userSummary' => $this->userService->userSummaryById($user_id),
            'invitation' => $invitation,
            'sent' => $sent,
            'accepted' => $accepted,
            'acceptedMember' => $acceptedMember,
            "percent" => $pro_per,
            'receivedMember' => $recievedInfo,
            'sentInfo' => $sentInfo,
            'newMemberInfo' => $newMemberInfo->newMember,
            'selectedMemberInfo' => $selectedMemberInfo->selectedMembers,
            "postCategory" => $this->commonService->getPostCategoryList(),
            'familyInfo' => $familyInfo
        ));
    }

    public function matrimonyPendingAction() {
        return new ViewModel(array());
    }

    public function memberSelectedAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        if ($userSession->offsetGet('user_type_id') != '1') {
            echo 'unauthorize access';
            exit;
        }

        $sent = $this->getSentRequestCount($user_id);
        $accepted = $this->getAcceptedRequestCount($user_id);
        $invitation = $this->getReceivedRequestCount($user_id);
        $declineRequest = $this->getDeclineRequestCount($user_id);
        //$invitation = $adapter->query("select count('id') as invitation from tbl_member_invitation WHERE user_id=$user_id AND received IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->current();
        //$sent = $adapter->query("select count('id') as sent from tbl_member_invitation WHERE user_id=$user_id AND sent IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->current();
        //$accepted = $adapter->query("select count('id') as accepted from tbl_member_invitation WHERE user_id=$user_id AND accepted IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->current();
//        $acceptedMembers = $adapter->query("select * from tbl_member_invitation WHERE user_id=$user_id AND accepted IS NOT NULL", Adapter::QUERY_MODE_EXECUTE)->toArray();
//        foreach ($acceptedMembers as $key => $value) {
//            $acceptedMember[] = $adapter->query("select tui.*, tug.image_path from tbl_user_info as tui LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $value['accepted'] . "'", Adapter::QUERY_MODE_EXECUTE)->current();
//        }
        $acceptedMember = $this->getAcceptedInvitationList($user_id);
        $percentage = $this->userService->ProfileBar($user_id);
        $pro_per = array($percentage, $this->profileBarTemplate($percentage));
        $familyInfo = $this->userService->getFamilyInfoById($user_id);
        $recievedInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'received']);
        $sentInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sent']);
        $acceptedInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'accepted']);
        $newMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'newMembers']);
        $selectedMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'selectedMembers']);

        $preferredMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'preferredMembers']);

        return new ViewModel(array(
            'acceptedInfo' => $acceptedInfo->acceptedMember,
            'userSummary' => $this->userService->userSummaryById($user_id),
            'invitation' => $invitation,
            'sent' => $sent,
            'accepted' => $accepted,
            'acceptedMember' => $acceptedMember,
            "percent" => $pro_per,
            'receivedMember' => $recievedInfo,
            'sentInfo' => $sentInfo,
            'newMemberInfo' => $newMemberInfo->newMember,
            'selectedMemberInfo' => $selectedMemberInfo,
            "postCategory" => $this->commonService->getPostCategoryList(),
            'familyInfo' => $familyInfo,
            'declineRequest' => $declineRequest,
            'preferredMemberInfo' => $preferredMemberInfo,
        ));
    }

    public function matrimonySelectedAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');

        /// Code Line For New Matrimony matches //////
        $newMatrimonyMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'newMembersMatrimonial']);
        $referralKeyUsedInfo = $this->getreferralKeyUsedCountMatrimonial($user_id);
        $percentage = $this->userService->ProfileBarMatrimonial($user_id);
        $pro_per = array($percentage, $this->profileBarTemplate($percentage));

        $sql = "select * from tbl_user_gallery_matrimonial where user_id='$user_id' AND user_type='U' AND image_type='1' ORDER BY id DESC";
        $profile_pic = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        $sqlInvitation = "SELECT * FROM tbl_matrimonial_invitation WHERE user_id='$user_id' OR accepted='$user_id' OR sent='$user_id' OR received='$user_id'";
        $result = $adapter->query($sqlInvitation, Adapter::QUERY_MODE_EXECUTE);
        $resultSet = new \Zend\Db\ResultSet\ResultSet();
        $invitationRows = $resultSet->initialize($result)->toArray();
        //Debug::dump($recievedInfo);exit;      
        return new ViewModel(array(
            'userSummary' => $this->userService->userSummaryByIdMatrimonial($user_id),
            'invitationRows' => $invitationRows,
            'referralKeyUsedInfo' => $referralKeyUsedInfo,
            'newMemberInfo' => $newMatrimonyMemberInfo->newMatrimonyMember,
            'profile_pic' => $profile_pic,
        ));
    }

    public function confirmRequestAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $request = $this->getRequest();
        $post = $request->getPost();
        $id = $post['id'];
        $uid = $post['uid'];
        $type = $post['type'];
        $request_type = $post['request_type'];

        if ($request_type == "cancel_request") {
            $new_type = 3;
        } elseif ($request_type == "confirm_request") {
            $new_type = 1;
        }
        $sql = "UPDATE tbl_member_invitation SET type='$new_type' WHERE user_id='$user_id' AND sent='$uid' AND type='$type' AND accepted IS NULL AND id='$id'";
        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return new JsonModel(array('result' => ''));
    }

    public function confirmRequestMatrimonialAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $request = $this->getRequest();
        $post = $request->getPost();
        $id = $post['id'];
        $uid = $post['uid'];
        $type = $post['type'];
        $request_type = $post['request_type'];

        if ($request_type == "cancel") {
            $new_type = 3;
        } elseif ($request_type == "confirm") {
            $new_type = 1;
        }
        $sql = "UPDATE tbl_matrimonial_invitation SET type='$new_type' WHERE user_id='$user_id' AND sent='$uid' AND type='$type' AND accepted IS NULL AND id='$id'";
        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return new JsonModel(array('result' => ''));
    }

    public function newMatrimonyMembersAction() {
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $userSummary = $this->userService->userSummaryById($user_id);
        $gender = $userSummary->userInfo->getGender();
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "SELECT tui.*, tug.image_path, tur.*  FROM tbl_user_info as tui "
                . "LEFT JOIN tbl_user_gallery as tug ON tug.user_id=tui.user_id AND tug.profile_pic='1' "
                . "LEFT JOIN tbl_user_roles as tur ON tui.user_id=tur.user_id "
                . "WHERE tur.IsMatrimonial='1' AND tui.gender!='$gender' AND tur.user_id!=$user_id ORDER BY tui.created_date DESC LIMIT 15";
        $newMember = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();

        $sql1 = "SELECT * FROM tbl_member_invitation WHERE user_id='$user_id' OR sent='$user_id'";
        $invi_member = $adapter->query($sql1, Adapter::QUERY_MODE_EXECUTE)->toArray();

        foreach ($newMember as $newMembers) {
            foreach ($invi_member as $invi_members) {
                if ($newMembers[user_id] == $invi_members[user_id] || $newMembers[user_id] == $invi_members[accepted] || $newMembers[user_id] == $invi_members[sent] || $newMembers[user_id] == $invi_members[received]) {
                    continue 2;
                }
            }
            $newMemberf[] = $newMembers;
        }

        return new ViewModel(array(
            'newMatrimonyMember' => $newMemberf
        ));
    }

    public function newMembersMatrimonialAction() {
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $userSummary = $this->userService->userSummaryByIdMatrimonial($user_id);

        $gender = $userSummary['gender'];

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "SELECT tui.*, "
                . "tui.user_id as uid, "
                . "tug.image_name, "
                . "tef.*, "
                . "tel.*, "
                . "tp.*, "
                . "tuam.*, "
                . "tuem.* "
                . "FROM tbl_user_info_matrimonial as tui "
                . "LEFT JOIN tbl_user_education_matrimonial as tuem ON tuem.user_id=tui.user_id "
                . "LEFT JOIN tbl_user_professional_matrimonial as tupm ON tupm.user_id=tui.user_id "
                . "LEFT JOIN tbl_education_field as tef ON tef.id=tuem.education_field_id "
                . "LEFT JOIN tbl_education_level as tel ON tel.id=tuem.education_level_id "
                . "LEFT JOIN tbl_profession as tp ON tp.id=tupm.profession "
                . "LEFT JOIN tbl_user_gallery_matrimonial as tug ON tug.user_id=tui.user_id AND tug.image_type='1' AND tug.user_type='U' "
                . "LEFT JOIN tbl_user_address_matrimonial as tuam ON tuam.user_id=tui.user_id "
                . "WHERE tui.gender!='$gender' AND tui.user_id!='$user_id' GROUP BY(tui.user_id) ORDER BY tui.created_date DESC LIMIT 15";
        $newMember = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();

        $sql1 = "SELECT * FROM tbl_matrimonial_invitation WHERE user_id='$user_id' OR sent='$user_id'";
        $invi_member = $adapter->query($sql1, Adapter::QUERY_MODE_EXECUTE)->toArray();

        foreach ($newMember as $newMembers) {
            foreach ($invi_member as $invi_members) {
                if ($newMembers['user_id'] == $invi_members['user_id'] || $newMembers['user_id'] == $invi_members['accepted'] || $newMembers['user_id'] == $invi_members['sent'] || $newMembers['user_id'] == $invi_members['received']) {
                    continue 2;
                }
            }
            $newMemberf[] = $newMembers;
        }

        return new ViewModel(array(
            'newMatrimonyMember' => $newMemberf
        ));
    }

    public function invitationSentMembersAction() {

        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "select * from tbl_member_invitation WHERE user_id='$user_id' AND type=1 AND accepted IS NULL LIMIT 15";
        $invitationSent = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        foreach ($invitationSent as $key => $value) {
            $inviteSentMembers[] = $adapter->query("select tui.*, tug.image_path from tbl_user_info as tui LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $value['sent'] . "'", Adapter::QUERY_MODE_EXECUTE)->current();
            $memInfoSent[] = $value;
        }
        return new ViewModel(array(
            //'invitation'=>$invitationMember,
            'inviteSentMembers' => $inviteSentMembers,
            'memInfoSent' => $memInfoSent,
        ));
    }

    public function invitationReceivedMembersAction() {
        $inviteReceivedMembers=$memInfoReceived='';
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "select * from tbl_member_invitation WHERE sent='$user_id' AND type=1 AND accepted IS NULL LIMIT 15";
        $invitationReceived = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
//        echo '<pre>';
//   print_r($invitation);
        foreach ($invitationReceived as $key => $value) {
            $inviteReceivedMembers[] = $adapter->query("select tui.*, tug.image_path from tbl_user_info as tui LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id WHERE tui.user_id='" . $value['user_id'] . "'", Adapter::QUERY_MODE_EXECUTE)->current();
            $memInfoReceived[] = $value;

            //echo '<pre>';
            //print_r($sentMember);
        }
        //echo '<pre>';
        //print_r($received);

        return new ViewModel(array(
            //'invitation'=>$invitationMember,
            'inviteReceivedMembers' => $inviteReceivedMembers,
            'memInfoReceived' => $memInfoReceived,
        ));
    }

    public function invitationSentMatrimonialAction() {

        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "select * from tbl_matrimonial_invitation WHERE user_id='$user_id' AND type=1 AND accepted IS NULL LIMIT 15";
        $invitationSent = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        foreach ($invitationSent as $key => $value) {
            $inviteSentMembers[] = $adapter->query("select "
                            . "tui.*, tug.image_name, tuam.*, tup.*, tp.* "
                            . "from tbl_user_info_matrimonial as tui "
                            . "LEFT JOIN tbl_user_address_matrimonial as tuam ON tuam.user_id=tui.user_id "
                            . "LEFT JOIN tbl_user_professional_matrimonial as tup ON tui.user_id=tup.user_id "
                            . "LEFT JOIN tbl_profession as tp ON tp.id=tup.profession "
                            . "LEFT JOIN tbl_user_gallery_matrimonial as tug ON tui.user_id=tug.user_id "
                            . "WHERE tui.user_id='" . $value['sent'] . "' ORDER BY tuam.id DESC", Adapter::QUERY_MODE_EXECUTE)->current();
            $memInfoSent[] = $value;
        }
        return new ViewModel(array(
            //'invitation'=>$invitationMember,
            'inviteSentMembers' => $inviteSentMembers,
            'memInfoSent' => $memInfoSent,
        ));
    }

    public function invitationReceivedMatrimonialAction() {

        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "select * from tbl_matrimonial_invitation WHERE sent='$user_id' AND type=1 AND accepted IS NULL LIMIT 15";
        $invitationReceived = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
//        echo '<pre>';
//   print_r($invitation);
        foreach ($invitationReceived as $key => $value) {
            $inviteReceivedMembers[] = $adapter->query("select "
                            . "tui.*, tug.image_name, tuam.*, tup.*, tp.* "
                            . "from tbl_user_info_matrimonial as tui "
                            . "LEFT JOIN tbl_user_address_matrimonial as tuam ON tuam.user_id=tui.user_id "
                            . "LEFT JOIN tbl_user_professional_matrimonial as tup ON tui.user_id=tup.user_id "
                            . "LEFT JOIN tbl_profession as tp ON tup.designation=tp.id "
                            . "LEFT JOIN tbl_user_gallery_matrimonial as tug ON tui.user_id=tug.user_id "
                            . "WHERE tui.user_id='" . $value['user_id'] . "'", Adapter::QUERY_MODE_EXECUTE)->current();
            $memInfoReceived[] = $value;

            //echo '<pre>';
            //print_r($sentMember);
        }
        //echo '<pre>';
        //print_r($received);

        return new ViewModel(array(
            //'invitation'=>$invitationMember,
            'inviteReceivedMembers' => $inviteReceivedMembers,
            'memInfoReceived' => $memInfoReceived,
        ));
    }

    /// Function for member Invitation Decline Starts Here ///

    public function interestdeclineAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $request = $this->getRequest();
        $post = $request->getPost();
        $id = $post['id'];
        $uid = $post['uid'];
        $type = $post['type'];
        $request_type = $post['request_type'];
        if ($request_type == "sent_request") {
            $new_type = 3;
            $sql = "UPDATE tbl_member_invitation SET type='$new_type' WHERE type='$type' AND sent='$uid' AND user_id='$user_id' AND id='$id'";
        } elseif ($request_type == "recevied_request") {
            $new_type = 4;
            $sql = "UPDATE tbl_member_invitation SET type='$new_type' WHERE type='$type' AND sent='$user_id' AND user_id='$uid' AND id='$id'";
        }

        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return new JsonModel(array('result' => ''));
    }

    /// Function for matrimony Invitation Decline Starts Here ///
    public function interestDeclineMatrimonialAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $request = $this->getRequest();
        $post = $request->getPost();
        $id = $post['id'];
        $uid = $post['uid'];
        $type = $post['type'];
        $request_type = $post['request_type'];
        if ($request_type == "cancel") {
            //echo $request_type;exit;
            $new_type = 3;
            $sql = "UPDATE tbl_matrimonial_invitation SET type='$new_type' WHERE type='$type' AND sent='$uid' AND user_id='$user_id' AND id='$id'";
        } elseif ($request_type == "decline") {
            $new_type = 4;
            $sql = "UPDATE tbl_matrimonial_invitation SET type='$new_type' WHERE type='$type' AND sent='$user_id' AND user_id='$uid' AND id='$id'";
        }

        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return new JsonModel(array('result' => ''));
    }

    /// Function for matrimony Invitation Accepted Yes Starts Here ///
    public function interestAcceptYesMatrimonialAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $request = $this->getRequest();
        $post = $request->getPost();
        $uid = $post['uid'];
        $id = $post['id'];
        $type = $post['type'];
        $sql = "UPDATE tbl_matrimonial_invitation SET type=1 WHERE type='$type' AND sent='$uid' AND user_id='$user_id' AND id='$id'";
        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return new JsonModel(array('result' => ''));
    }

    public function interestacceptyesAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $request = $this->getRequest();
        $post = $request->getPost();
        $uid = $post['uid'];
        $id = $post['id'];
        $type = $post['type'];
        $sql = "UPDATE tbl_member_invitation SET type=1 WHERE type='$type' AND sent='$uid' AND user_id='$user_id' AND id='$id'";
        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return new JsonModel(array('result' => ''));
    }

    /// Function for matrimony Invitation Accepted Yes Ends Here ///
    /// Function for matrimony Invitation Accepted Yes Starts Here ///

    public function acceptsenddeclineRequestAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $request = $this->getRequest();
        $post = $request->getPost();
        $id = $post['id'];
        $uid = $post['uid'];
        $type = $post['type'];
        $request_type = $post['request_type'];

        if ($request_type == "accept_request" && $type == 4) {
            $new_type = 5;
            $accepted = ', accepted="' . $uid . '"';
            $sent = $user_id;
            $user_id = $uid;
        } else if ($request_type == "send_request" && $type == 3) {
            $new_type = 1;
            $accepted = "";
            $sent = $uid;
            $user_id = $user_id;
        }

        $sql = "UPDATE tbl_member_invitation SET type='$new_type' $accepted WHERE type='$type' AND sent='$sent' AND user_id='$user_id' AND id='$id'";
        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return new JsonModel(array('result' => ''));
    }

    public function acceptSendDeclineRequestMatrimonialAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $request = $this->getRequest();
        $post = $request->getPost();
        $id = $post['id'];
        $uid = $post['uid'];
        $type = $post['type'];
        $request_type = $post['request_type'];

        if ($request_type == "accept" && $type == 4) {
            $new_type = 5;
            $accepted = ', accepted="' . $uid . '"';
            $sent = $user_id;
            $user_id = $uid;
        } else if ($request_type == "send" && $type == 3) {
            $new_type = 1;
            $accepted = "";
            $sent = $uid;
            $user_id = $user_id;
        }

        $sql = "UPDATE tbl_matrimonial_invitation SET type='$new_type' $accepted WHERE type='$type' AND sent='$sent' AND user_id='$user_id' AND id='$id'";
        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return new JsonModel(array('result' => ''));
    }

    /// Function for matrimony Invitation Accepted Yes Ends Here ///


    public function unmatchedpreferredRequestAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $request = $this->getRequest();
        $post = $request->getPost();

        $id = $post['id'];
        $uid = $post['uid'];
        $type = $post['type'];
        $request_type = $post['request_type'];

        if ($request_type == "unmatched_request") {
            $new_type = 6;
        } else if ($request_type == "preferred_request") {
            $new_type = 7;
        }

        $sql = "UPDATE tbl_member_invitation SET type='$new_type' WHERE type='$type' AND accepted IS NOT NULL AND id='$id'";
        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return new JsonModel(array('result' => ''));
    }

    public function unmatchedunpreferredRequestAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $request = $this->getRequest();
        $post = $request->getPost();

        $id = $post['id'];
        $uid = $post['uid'];
        $type = $post['type'];
        $request_type = $post['request_type'];

        if ($request_type == "un-matched_request") {
            $new_type = 6;
        } else if ($request_type == "un-preferred_request") {
            $new_type = 5;
        }

        $sql = "UPDATE tbl_member_invitation SET type='$new_type' WHERE type='$type' AND accepted IS NOT NULL AND id='$id'";
        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return new JsonModel(array('result' => ''));
    }

    public function unmatchedpreferredRequestMatrimonialAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $request = $this->getRequest();
        $post = $request->getPost();

        $id = $post['id'];
        $uid = $post['uid'];
        $type = $post['type'];
        $request_type = $post['request_type'];

        if ($request_type == "unmatched") {
            $new_type = 6;
        } else if ($request_type == "preferred") {
            $new_type = 7;
        }

        $sql = "UPDATE tbl_matrimonial_invitation SET type='$new_type' WHERE type='$type' AND accepted IS NOT NULL AND id='$id'";
        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return new JsonModel(array('result' => ''));
    }

    public function unMatchedUnPreferredRequestMatrimonialAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $request = $this->getRequest();
        $post = $request->getPost();

        $id = $post['id'];
        $uid = $post['uid'];
        $type = $post['type'];
        $request_type = $post['request_type'];

        if ($request_type == "un-matched") {
            $new_type = 6;
        } else if ($request_type == "un-preferred") {
            $new_type = 5;
        }

        $sql = "UPDATE tbl_matrimonial_invitation SET type='$new_type' WHERE type='$type' AND accepted IS NOT NULL AND id='$id'";
        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return new JsonModel(array('result' => ''));
    }

    public function sendSmtpMailAction() {

        // Setup SMTP transport using LOGIN authentication
        $transport = new SmtpTransport();
        $options = new SmtpOptions(array(
            'host' => 'mail.rustagisamaj.com',
            'connection_class' => 'login',
            'connection_config' => array(
                'ssl' => 'tls',
                'username' => 'support@rustagisamaj.com',
                'password' => 'Sup@samaj'
            ),
            'port' => 25,
        ));

        $data['name'] = "Mohit Jain";
        $data['username'] = "mohitjain9";
        $data['password'] = "123456";
        $data['email'] = "php@hello42cab.com";
        $data['mobile'] = "9313504429";
        $data['otp'] = "1234";

        $this->renderer = $this->getServiceLocator()->get('ViewRenderer');
        $content = $this->renderer->render('application/mails/register', array(data => $data));

        $html = new MimePart($content);
        $html->type = "text/html";

        $body = new MimeMessage();
        //$body->addPart($html);
        $body->setParts(array($html,));

        $mail = new Message();
        $mail->setBody($body);
        $mail->setFrom('support@rustagisamaj.com', 'Rustagi Samaj');
        $mail->setTo('php@hello42cab.com');
        $mail->setSubject('Test send mail using ZF2');
        $transport->setOptions($options);
        $transport->send($mail);
    }

    public function sendAccountThanksSmsAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $username = 'mohit123';
        $mobileNumber = '9313504429';
        $code = '1234';
        $msg_type = 'welcome_msg';

        $sql = "select * from tbl_sms_template WHERE msg_sku='$msg_type' AND is_active=1";
        $sms_template = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        //Debug::dump($sms_template); die;
        if ($msg_type == "welcome_msg") {
            $array1 = explode('<variable>', $sms_template['message']);
            $array1[0] = $array1[0] . $username;
            $array1[1] = $array1[1] . $code;
            $message = urlencode(implode("", $array1));
        }
        $url = "http://push3.maccesssmspush.com/servlet/com.aclwireless.pushconnectivity.listeners.TextListener?userId=helloalt&pass=helloalt&appid=helloalt&subappid=helloalt&msgtype=1&contenttype=1&selfid=true&to=$mobileNumber&from=Helocb&dlrreq=true&text=$message&alert=1";
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);
    }

    public function saveFamilyPhotosAction() {
        Debug::dump($_POST);
    }

    public function uploadGalleryImagesMatrimonialAction() {
        $post = isset($_POST) ? $_POST : array();
        //print_R($post);die;
        switch ($post['action']) {
            case 'save' :
                $this->saveAvatarTmpGalleryMatrimonial();
                break;
            default:
                $this->changeAvatarGalleryMatrimonial();
        }
    }

    function changeAvatarGalleryMatrimonial() {
        $session = new Container('user');
        $user_id = $session->offsetGet('id');
        $post = isset($_POST) ? $_POST : array();
        $max_width = "500";
        //$userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;
        $path = 'images/tmp';
        //$ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        //$ext = strtolower($_FILES['photoimg']['name']);
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");
        //$name = $_FILES['photoimg']['name'];
        $name = time() . $_FILES['photoimg']['name'];
        $size = $_FILES['photoimg']['size'];
        if (strlen($name)) {
            list($txt, $ext) = explode(".", $name);
            //Debug::dump($ext);
            //Debug::dump($valid_formats);
            //Debug::dump(in_array($ext, $valid_formats));exit;
            if (in_array($ext, $valid_formats)) {

                if ($size < (1024 * 1024)) { // Image size max 1 MB
                    $actual_image_name = 'avatar' . '_' . $user_id . '.' . $ext;
                    //$filePath = $path .'/'.$actual_image_name;
                    $tmp = $_FILES['photoimg']['tmp_name'];
                    //$user_name = "Unknown";
                    //$user_folder = $user_id . "__" . $user_name;

                    $filePath = PUBLIC_PATH . MATRIMONIAL_IMAGE_PATH . $name;

                    //$filePath = PUBLIC_PATH . '/uploads/' . $user_folder . '/' . $name;
                    $filePreview = MATRIMONIAL_IMAGE_PATH . $name;
                    //$filePreview = '/uploads/' . $user_folder . '/' . $name;
                    //echo $filePath;
                    if (move_uploaded_file($tmp, $filePath)) {
                        $width = $this->getWidth($filePath);
                        $height = $this->getHeight($filePath);
                        //Scale the image if it is greater than the width set above
                        if ($width > $max_width) {
                            $scale = $max_width / $width;
                            $uploaded = $this->resizeImage($filePath, $width, $height, $scale);
                        } else {
                            $scale = 1;
                            $uploaded = $this->resizeImage($filePath, $width, $height, $scale);
                        }
                        /* $res = saveAvatar(array(
                          'userId' => isset($userId) ? intval($userId) : 0,
                          'avatar' => isset($actual_image_name) ? $actual_image_name : '',
                          )); */

                        //mysql_query("UPDATE users SET profile_image='$actual_image_name' WHERE uid='$session_id'");
                        //echo "Mohitt"; die; 
                        echo "<img class='photo' file-name='" . $name . "' class='' src='" . $filePreview . '?' . time() . "' class='preview'/>";
                    } else
                        echo "failed";
                } else
                    echo "Image file size max 1 MB";
            } else
                echo "Invalid file format..";
        } else
            echo "Please select image..!";
        exit;
    }

    function saveAvatarTmpGalleryMatrimonial() {
        $session = new Container('user');
        $ref_no = $session->offsetGet('ref_no');
        $user_id = $session->offsetGet('id');
        $post = isset($_POST) ? $_POST : array();
        $userId = isset($post['id']) ? intval($post['id']) : 0;
        $path = PUBLIC_PATH . MATRIMONIAL_IMAGE_PATH;
        $t_width = 300; // Maximum thumbnail width
        $t_height = 300;    // Maximum thumbnail height

        if (isset($_POST['t']) and $_POST['t'] == "ajax") {
            extract($_POST);
            //print_r($_POST);
            //exit;
            $crop_enabled = $_POST['crop_enabled'];
            //$user_name = "Unknown";
            //$user_folder = $user_id . "__" . $user_name;
            $image_quality = '95';

            $imagePath = $path . $_POST['image_name'];
            //$new_image_thumb = PUBLIC_PATH . '/uploads/thumb/100x100/' . $user_folder . '/' . $_POST['image_name'];
            //$temp_path = PUBLIC_PATH . '/temp/' . $_POST['image_name'];

            if ($crop_enabled == "yes") {

                $ratio = ($t_width / $w1);
                $nw = ceil($w1 * $ratio);
                $nh = ceil($h1 * $ratio);
                $nimg = imagecreatetruecolor($nw, $nh);
                $im_src = imagecreatefromjpeg($imagePath);
                imagecopyresampled($nimg, $im_src, 0, 0, $x1, $y1, $nw, $nh, $w1, $h1);
                $result = imagejpeg($nimg, $imagePath, $image_quality);
                //var_dump($result);exit;
//        $crop_width = 30;
//        $crop_height = 30;
//        $thumbNew = imagecreatetruecolor($crop_width, $crop_height);
//        imagecopyresampled($thumbNew, $im_src, 0, 0, $x1, $y1, $crop_width, $crop_height, $w1, $h1);
//        $thumb = imagejpeg($thumbNew, $new_image_thumb, $image_quality);
            } elseif ($crop_enabled == "no") {
                $result = true;
//                $result = copy($temp_path, $imagePath);
//                $result1 = copy($temp_path, $new_image_thumb);
//                $filename = PUBLIC_PATH . '/uploads/thumb/100x100/' . $user_folder . '/' . $_POST['image_name'];
//                $image = imagecreatefromjpeg($filename);
//                list($originalWidth, $originalHeight) = getimagesize($filename);
//
//                // Size of image to create
//                $width = 50;
//                $height = 50;
//
//                $background = imagecreatetruecolor($width, $height); //create the background 130x130
//                $whiteBackground = imagecolorallocate($background, 255, 255, 255);
//                imagefill($background, 0, 0, $whiteBackground); // fill the background with white
//                imagecopyresampled($background, $image, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight); // copy the image to the background
//                header("Content-type: image/jpeg");
//                ImageJpeg($background, $new_image_thumb, $image_quality); //display       
            }
            if ($result) {
                $image_type = 0;
                $user_type = 'U';
                $image_name = $_POST['image_name'];
                $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                //$sql = "SELECT * FROM tbl_user_gallery_matrimonial WHERE user_id='$user_id' AND profile_pic=1";
                //$predata = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
                //*********Insert in Gallery Table******
                $statement = $adapter->query("INSERT INTO tbl_user_gallery_matrimonial (user_id, user_type, image_name, image_type, status) 
                VALUES ('$user_id','$user_type','$image_name', '$image_type', '1')");
                $res = $statement->execute();

                $response = 'File uploaded Successfully.';
            } else {
                $response = "couldn't crop image some error occured.";
            }
        }
        //echo $imagePath.'?'.time();;
        echo $response;
        exit(0);
    }

    public function uploadProfileImagesMatrimonialAction() {
        $post = isset($_POST) ? $_POST : array();
        //print_R($post);die;
        switch ($post['action']) {
            case 'save' :
                $this->saveAvatarTmpProfileMatrimonial();
                break;
            default:
                $this->changeAvatarProfileMatrimonial();
        }
    }

    function changeAvatarProfileMatrimonial() {
        $session = new Container('user');
        $user_id = $session->offsetGet('id');
        $post = isset($_POST) ? $_POST : array();
        $max_width = "500";
        //$userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;
        //$path = 'images/tmp';
        //$ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        //$ext = strtolower($_FILES['photoimg']['name']);
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");
        //$name = $_FILES['photoimg']['name'];
        $name = time() . $_FILES['photoimg']['name'];
        $size = $_FILES['photoimg']['size'];
        if (strlen($name)) {
            list($txt, $ext) = explode(".", $name);
            //Debug::dump($ext);
            //Debug::dump($valid_formats);
            //Debug::dump(in_array($ext, $valid_formats));exit;
            if (in_array($ext, $valid_formats)) {

                if ($size < (1024 * 1024)) { // Image size max 1 MB
                    $actual_image_name = 'avatar' . '_' . $user_id . '.' . $ext;
                    //$filePath = $path .'/'.$actual_image_name;
                    $tmp = $_FILES['photoimg']['tmp_name'];
                    //$user_name = "Unknown";
                    //$user_folder = $user_id . "__" . $user_name;

                    $filePath = PUBLIC_PATH . MATRIMONIAL_IMAGE_PATH . $name;

                    //$filePath = PUBLIC_PATH . '/uploads/' . $user_folder . '/' . $name;
                    $filePreview = MATRIMONIAL_IMAGE_PATH . $name;
                    //$filePreview = '/uploads/' . $user_folder . '/' . $name;
                    //echo $filePath;
                    if (move_uploaded_file($tmp, $filePath)) {
                        $width = $this->getWidth($filePath);
                        $height = $this->getHeight($filePath);
                        //Scale the image if it is greater than the width set above
                        if ($width > $max_width) {
                            $scale = $max_width / $width;
                            $uploaded = $this->resizeImage($filePath, $width, $height, $scale);
                        } else {
                            $scale = 1;
                            $uploaded = $this->resizeImage($filePath, $width, $height, $scale);
                        }
                        /* $res = saveAvatar(array(
                          'userId' => isset($userId) ? intval($userId) : 0,
                          'avatar' => isset($actual_image_name) ? $actual_image_name : '',
                          )); */

                        //mysql_query("UPDATE users SET profile_image='$actual_image_name' WHERE uid='$session_id'");
                        //echo "Mohitt"; die; 
                        echo "<img class='photo' file-name='" . $name . "' class='' src='" . $filePreview . '?' . time() . "' class='preview'/>";
                    } else
                        echo "failed";
                } else
                    echo "Image file size max 1 MB";
            } else
                echo "Invalid file format..";
        } else
            echo "Please select image..!";
        exit;
    }

    function saveAvatarTmpProfileMatrimonial() {
        $session = new Container('user');
        $ref_no = $session->offsetGet('ref_no');
        $user_id = $session->offsetGet('id');
        $post = isset($_POST) ? $_POST : array();
        $userId = isset($post['id']) ? intval($post['id']) : 0;
        $path = PUBLIC_PATH . MATRIMONIAL_IMAGE_PATH;
        $t_width = 300; // Maximum thumbnail width
        $t_height = 300;    // Maximum thumbnail height

        if (isset($_POST['t']) and $_POST['t'] == "ajax") {
            extract($_POST);
            //print_r($_POST);
            //exit;
            $crop_enabled = $_POST['crop_enabled'];
            //$user_name = "Unknown";
            //$user_folder = $user_id . "__" . $user_name;
            $image_quality = '95';

            $imagePath = $path . $_POST['image_name'];
            //$new_image_thumb = PUBLIC_PATH . '/uploads/thumb/100x100/' . $user_folder . '/' . $_POST['image_name'];
            //$temp_path = PUBLIC_PATH . '/temp/' . $_POST['image_name'];

            if ($crop_enabled == "yes") {

                $ratio = ($t_width / $w1);
                $nw = ceil($w1 * $ratio);
                $nh = ceil($h1 * $ratio);
                $nimg = imagecreatetruecolor($nw, $nh);
                $im_src = imagecreatefromjpeg($imagePath);
                imagecopyresampled($nimg, $im_src, 0, 0, $x1, $y1, $nw, $nh, $w1, $h1);
                $result = imagejpeg($nimg, $imagePath, $image_quality);
                //var_dump($result);exit;
//        $crop_width = 30;
//        $crop_height = 30;
//        $thumbNew = imagecreatetruecolor($crop_width, $crop_height);
//        imagecopyresampled($thumbNew, $im_src, 0, 0, $x1, $y1, $crop_width, $crop_height, $w1, $h1);
//        $thumb = imagejpeg($thumbNew, $new_image_thumb, $image_quality);
            } elseif ($crop_enabled == "no") {
                $result = true;
//                $result = copy($temp_path, $imagePath);
//                $result1 = copy($temp_path, $new_image_thumb);
//                $filename = PUBLIC_PATH . '/uploads/thumb/100x100/' . $user_folder . '/' . $_POST['image_name'];
//                $image = imagecreatefromjpeg($filename);
//                list($originalWidth, $originalHeight) = getimagesize($filename);
//
//                // Size of image to create
//                $width = 50;
//                $height = 50;
//
//                $background = imagecreatetruecolor($width, $height); //create the background 130x130
//                $whiteBackground = imagecolorallocate($background, 255, 255, 255);
//                imagefill($background, 0, 0, $whiteBackground); // fill the background with white
//                imagecopyresampled($background, $image, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight); // copy the image to the background
//                header("Content-type: image/jpeg");
//                ImageJpeg($background, $new_image_thumb, $image_quality); //display       
            }
            if ($result) {
                $image_type = 1;
                $user_type = 'U';
                $image_name = $_POST['image_name'];
                $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                //$sql = "SELECT * FROM tbl_user_gallery_matrimonial WHERE user_id='$user_id' AND profile_pic=1";
                //$predata = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
                //*********Insert in Gallery Table******
                $statement = $adapter->query("INSERT INTO tbl_user_gallery_matrimonial (user_id, user_type, image_name, image_type, status) 
                VALUES ('$user_id','$user_type','$image_name', '$image_type', '1')");
                $res = $statement->execute();

                $response = 'File uploaded Successfully.';
            } else {
                $response = "couldn't crop image some error occured.";
            }
        }
        //echo $imagePath.'?'.time();;
        echo $response;
        exit(0);
    }

    public function deleteGalleryImagesMatrimonialAction() {
        //var_dump($_POST);
        $request = $this->getRequest();
        $predicate = new \Zend\Db\Sql\Predicate\Predicate();

        //print_r($request->getPost());
        //explode(',', $request->getPost())
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = new Sql($adapter);
        
        $ids=$request->getPost()['ids'];
        if($ids!=""){
        $sql_select = "SELECT * FROM tbl_user_gallery_matrimonial WHERE id IN($ids)";
        $res = $adapter->query($sql_select, Adapter::QUERY_MODE_EXECUTE)->toArray();
        foreach($res as $val){
            unlink(PUBLIC_PATH.MATRIMONIAL_IMAGE_PATH.$val['image_name']);
        }
        $action = new \Zend\Db\Sql\Delete('tbl_user_gallery_matrimonial');
        $action->where($predicate->in('id', explode(',', $request->getPost()['ids'])));
        $stmt = $sql->prepareStatementForSqlObject($action);
        //Debug::dump($stmt);
        $result = $stmt->execute();
        //print_r(explode(',', $request->getPost()['ids']));
        }
        $view = new JsonModel(array('result' => $result, 'ids' => explode(',', $request->getPost()['ids'])));
        $view->setTerminal(true);
        return $view;
    }

    public function changePasswordMatrimonialAction() {
        
    }

    public function changePasswordMemberAction() {

//            $otp = $_POST['old_password'];
//            echo  $otp;exit;
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        //$user_id = intval($this->params()->fromQuery('member_id'));
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $userTypeId = $userSession->offsetGet('user_type_id');
        $mobile_no = $userSession->offsetGet('mobile_no');
        $ref_no = $userSession->offsetGet('ref_no');
        $userservice = new \Application\Mapper\UserDbSqlMapper($adapter);
        $familyInfo = $userservice->getFamilyInfoById($user_id);
        $commanData = array();
        $commanData["officecountry"] = '';
        $commanData["officestate"] = '';
        $commanData["officecity"] = '';
        $msg = "";
        //save change password start...
        $old_password2 = md5($_POST['old_password2']);

        if ($this->getRequest()->isPost()) {
            //echo  "hello";exit;
            if (empty($_POST['old_password2']) && empty($_POST['new_password']) && empty($_POST['confirm_password'])) {
                $msg = "";
                $old_password_error = "old password should not be empty";
                $new_password_error = "new password should not be empty";
                $confirm_password_error = "confirm password should not be empty";
            }
        } else {
            $old_password_error = "";
            $new_password_error = "";
            $confirm_password_error = "";
        }



        if (isset($_POST['old_password2'])) {
            //echo "select * from tbl_mobile where code=" . $_POST['otp']; die;
            $arrdef = $adapter->query("select * from tbl_user where (id='" . $user_id . "' && password='" . $old_password2 . "')", Adapter::QUERY_MODE_EXECUTE);
            $size = $arrdef->count();

            $cpwd = 1;

            if (strcmp($_POST['new_password'], $_POST['confirm_password']) == 0) {
                //echo  "world";exit;
                $cpwd = 1;
            } else {
                $cpwd = 2;
            }
        }

        if ($this->getRequest()->isPost() && !empty($_POST['old_password2']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {


            if ($size != 0 && $cpwd == 1) {

                //echo "hello";exit;
                $sql = "UPDATE tbl_user SET password='" . md5($_POST['new_password']) . "' WHERE id='" . $user_id . "' AND mobile_no='" . $mobile_no . "'";

                $query = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);

                //on success message
                //$changePwd = 'Password changed successfully';
                //$this->flashMessenger()->addMessage(array('success' => 'Password  changed successfully...'));
                $msg = "Password  changed successfully...";
            } elseif ($size == 0 || $cpwd != 2) {
                //on failure message
                //$notchangePwd = 'Password not changed';exit;
                //$this->flashMessenger()->addMessage(array('success' => 'Password not changed...'));
                $msg = "<span style='color:red;'>Old Password Or Confirm Password  not matched...</span>";
            }
        }


        //end...


        return new ViewModel(array(
            "postCategory" => $this->commonService->getPostCategoryList(),
            "msg" => $msg,
            "old_password_error" => $old_password_error,
            "new_password_error" => $new_password_error,
            "confirm_password_error" => $confirm_password_error,
        ));
    }

    public function sidebarRightMatrimonialAction() {

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');

        /// Code Line For New Matrimony matches //////
        $newMatrimonyMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'newMembersMatrimonial']);
        $referralKeyUsedInfo = $this->getreferralKeyUsedCountMatrimonial($user_id);
        $percentage = $this->userService->ProfileBarMatrimonial($user_id);
        $pro_per = array($percentage, $this->profileBarTemplate($percentage));

        $sql = "select * from tbl_user_gallery_matrimonial where user_id='$user_id' AND user_type='U' AND image_type='1' ORDER BY id DESC";
        $profile_pic = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        $sqlInvitation = "SELECT * FROM tbl_matrimonial_invitation WHERE user_id='$user_id' OR accepted='$user_id' OR sent='$user_id' OR received='$user_id'";
        $result = $adapter->query($sqlInvitation, Adapter::QUERY_MODE_EXECUTE);
        $resultSet = new \Zend\Db\ResultSet\ResultSet();
        $invitationRows = $resultSet->initialize($result)->toArray();
        //Debug::dump($recievedInfo);exit;      
        $viewModel = new ViewModel(array(
            'userSummary' => $this->userService->userSummaryByIdMatrimonial($user_id),
            'invitationRows' => $invitationRows,
            'referralKeyUsedInfo' => $referralKeyUsedInfo,
            'newMemberInfo' => $newMatrimonyMemberInfo->newMatrimonyMember,
            'profile_pic' => $profile_pic,
            'user_id' => $user_id,
        ));

        //$viewModel->setTerminal(true);
        return $viewModel;
    }

    public function sidebarLeftMatrimonialAction() {

        $param = $this->params()->fromRoute('userSummary', false);
        //Debug::dump($param);
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');

        /// Code Line For New Matrimony matches //////
        $newMatrimonyMemberInfo = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'newMembersMatrimonial']);
        $referralKeyUsedInfo = $this->getreferralKeyUsedCountMatrimonial($user_id);
        $percentage = $this->userService->ProfileBarMatrimonial($user_id);
        $pro_per = array($percentage, $this->profileBarTemplate($percentage));

        $sql = "select * from tbl_user_gallery_matrimonial where user_id='$user_id' AND user_type='U' AND image_type='1' ORDER BY id DESC";
        $profile_pic = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        $sqlInvitation = "SELECT * FROM tbl_matrimonial_invitation WHERE user_id='$user_id' OR accepted='$user_id' OR sent='$user_id' OR received='$user_id'";
        $result = $adapter->query($sqlInvitation, Adapter::QUERY_MODE_EXECUTE);
        $resultSet = new \Zend\Db\ResultSet\ResultSet();
        $invitationRows = $resultSet->initialize($result)->toArray();
        //Debug::dump($recievedInfo);exit;      
        $viewModel = new ViewModel(array(
            'userSummary' => $this->userService->userSummaryByIdMatrimonial($user_id),
            'invitationRows' => $invitationRows,
            'referralKeyUsedInfo' => $referralKeyUsedInfo,
            'newMemberInfo' => $newMatrimonyMemberInfo->newMatrimonyMember,
            'profile_pic' => $profile_pic,
            'user_id' => $user_id,
            'param' => $param
        ));

        //$viewModel->setTerminal(true);
        return $viewModel;
    }
    
    public function referralListAction() {
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $ref_no = $userSession->offsetGet('ref_no');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        if ($userSession->offsetGet('user_type') == '1') {
            $variables=array('user_type'=>$userSession->offsetGet('user_type'));
            $viewModel = new ViewModel();
            $viewModel->setVariables($variables);
            return $viewModel;
        }
        if ($userSession->offsetGet('user_type') == '2') {

          
            $filters_data=$this->sidebarFilters();
             $sidebarLeft = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarLeftMatrimonial']);
            $sidebarRight = $this->forward()->dispatch('Application\Controller\Profile', ['action' => 'sidebarRightMatrimonial']);
            $viewModel = new ViewModel();
            $viewModel->setVariables(array(
                'user_type'=>$userSession->offsetGet('user_type'),
                'referral_key_used_by'=>$this->getReferralKeyUsedByListMatrimonial($user_id),
                'filters_data' => $filters_data,
                
            ));
            $viewModel->addChild($sidebarLeft, 'sidebarLeft');
            $viewModel->addChild($sidebarRight, 'sidebarRight');
            return $viewModel;
        }
    }

}

?>
