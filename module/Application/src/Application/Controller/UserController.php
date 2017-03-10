<?php

namespace Application\Controller;

use Application\Form\SignupForm;
use Application\Service\UserServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Db\Adapter\Adapter;
use Zend\Debug\Debug;
use Zend\Mail\Transport\Sendmail;
use Zend\Mime\Part;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Application\Form\Filter\SignupFormFilter;

class UserController extends AppController {

    protected $userService;
    protected $commonService;
    protected $hydrator;

    public function __construct(CommonServiceInterface $commonService, UserServiceInterface $userService) {
        $this->userService = $userService;
        $this->commonService = $commonService;
        $this->hydrator = new ClassMethods();
    }

    public function indexAction() {


        var_dump($this->userService->checkAlreadyExist('email', 'satya.comnet@gmail.com'));

        exit;
        //return new ViewModel();
    }

    public function loginUserAction() {


        if ($this->getRequest()->isPost()) {
            $sessionUser=new Container('user');

            $request = $this->getRequest();
            //Debug::dump($request = $this->getRequest());
            //exit;
            //$login_email = $request->getPost('login_email');
            //$login_password = md5($request->getPost('login_password'));

            $matrimonial_user = $request->getPost('matrimonial_user'); //die;
            $member_user = $request->getPost('member_user');
            if ($matrimonial_user == 1) {
                $login_email=$sessionUser->offsetGet('login_email'); 
                $login_password=$sessionUser->offsetGet('login_password'); //exit;
                $userPassValidation = $this->MyPlugin()->checkUserUsernamePassword($login_email, $login_password);
                $tableName = "tbl_user_matrimonial";
                $tableMobile = "tbl_mobile_matrimonial";
                $st = $this->MyPlugin()->checkUserActiveByLoginV1($login_email, $tableName);
                if ($st['userStatus'] == "true" && $st['userActiveStatus'] == 0 && $st['userSignupStatus'] == 1) {
                    $sessionUser = new Container('user');
                    $sessionUser->offsetSet('user_id', $userPassValidation['user_id_matrimonial']);
                    return $this->redirect()->toRoute('user', array('action' => 'signupMatrimonialDetail'));
                }elseif ($st['userStatus'] == "true" && $st['userActiveStatus'] == 0 && $st['userSignupStatus'] == 2) {
                    $userData = $this->MyPlugin()->getMobileByLoginCredentials($login_email, $tableName);
                    //Debug::dump($userData); exit;
                    $session = new Container('otp');
                    $session->offsetSet('mobile', $userData[0]['mobile_no']);
                    $session->offsetSet('user_id_for_opt', $userData[0]['id']);
                    $this->resendOtpActionByMobile($session->offsetGet('mobile'), $tableName, $tableMobile);
                    return $this->redirect()->toRoute('user', array('action' => 'confimotpMatrimonialSignup'));
                }else{
                    $login_status=$this->userLoginAction($login_email,$login_password,$tableName);
                    if($login_status=="true"){
                    return $this->redirect()->toRoute('profile', array('action' => 'dashboard-matrimony'));
                    }
                }
            } elseif($member_user==1) {
                $login_email=$sessionUser->offsetGet('login_email'); 
                $login_password=$sessionUser->offsetGet('login_password'); //exit;
                $userPassValidation = $this->MyPlugin()->checkUserUsernamePassword($login_email, $login_password);
                $tableName = "tbl_user";
                $tableMobile = "tbl_mobile";
                $st = $this->MyPlugin()->checkUserActiveByLoginV1($login_email, $tableName);
                //Debug::dump($st); exit;
                if ($st['userStatus'] == "true" && $st['userActiveStatus'] == 0 && $st['userSignupStatus'] == 1) {
                    $sessionUser = new Container('user');
                    $sessionUser->offsetSet('user_id', $userPassValidation['user_id_member']);
                    return $this->redirect()->toRoute('user', array('action' => 'signupMemberDetail'));
                } elseif ($st['userStatus'] == "true" && $st['userActiveStatus'] == 0 && $st['userSignupStatus'] == 2) {
                    $userData = $this->MyPlugin()->getMobileByLoginCredentials($login_email, $tableName);
                    //Debug::dump($userData); exit;
                    $session = new Container('otp');
                    $session->offsetSet('mobile', $userData[0]['mobile_no']);
                    $session->offsetSet('user_id_for_opt', $userData[0]['id']);
                    $this->resendOtpActionByMobile($session->offsetGet('mobile'), $tableName, $tableMobile);
                    return $this->redirect()->toRoute('user', array('action' => 'confimotpMemberSignup'));
                } else{
                    $login_status=$this->userLoginAction($login_email,$login_password,$tableName);
                    if($login_status=="true"){
                    return $this->redirect()->toRoute('profile');
                    }
                }
            }




//             $sessionUserDetail1=new Container('user');
//        if($sessionUserDetail1->offsetGet('user_type_selected')=='member'){
//            echo "Mohit"; die;
//        }elseif($sessionUserDetail1->offsetGet('user_type_selected')=='matrimonial'){
//             echo "Mohddit"; die;
//        }

            

            $userPassValidation = $this->MyPlugin()->checkUserUsernamePassword($request->getPost('login_email'), md5($request->getPost('login_password')));
            //echo $userPassValidation; die;
            //Debug::dump($userPassValidation);exit;
            //echo $userPassValidation['userMatrimonialStatus'];
            
            if(($request->getPost('login_email')=="") || ($request->getPost('login_password')=="")){
                $message=array('Email or Mobile No. and password should not be blank');
                $this->flashMessenger()->addMessage($message);
                return $this->redirect()->toRoute('user', array("action" => 'login')); 
            }elseif (($userPassValidation['userStatus'] == "false") && ($userPassValidation['userMatrimonialStatus'] == "false")) {
                $message=array('In-valid Email or Mobile No. or Password');
                $this->flashMessenger()->addMessage($message);
                //$viewModel=new ViewModel();
                //$viewModel->setTemplate('application/user/login.phtml');
                //return $viewModel;
                return $this->redirect()->toRoute('user', array("action" => 'login'));

            }elseif (($userPassValidation['userStatus'] == "true") && ($userPassValidation['userMatrimonialStatus'] == "true")) {
                //echo "Exist in Both";
                $sessionUserDetail = new Container('user');
                $sessionUserDetail->offsetSet('login_email', $request->getPost('login_email'));
                $sessionUserDetail->offsetSet('login_password', md5($request->getPost('login_password')));
                $sessionUserDetail->offsetSet('userPassValidation', $userPassValidation);
                return $this->redirect()->toRoute('user', array('action' => 'confirmLogin'));
            } else if ($userPassValidation['userStatus'] == "true") {
                $tableName = "tbl_user";
                $tableMobile = "tbl_mobile";
                $st = $this->MyPlugin()->checkUserActiveByLoginV1($request->getPost('login_email'), $tableName);
                //Debug::dump($st); exit;
                if ($st['userStatus'] == "true" && $st['userActiveStatus'] == 0 && $st['userSignupStatus'] == 1) {
                    $sessionUser = new Container('user');
                    $sessionUser->offsetSet('user_id', $userPassValidation['user_id_member']);
                    return $this->redirect()->toRoute('user', array('action' => 'signupMemberDetail'));
                } elseif ($st['userStatus'] == "true" && $st['userActiveStatus'] == 0 && $st['userSignupStatus'] == 2) {
                    $userData = $this->MyPlugin()->getMobileByLoginCredentials($request->getPost('login_email'), $tableName);
                    //Debug::dump($userData); exit;
                    $session = new Container('otp');
                    $session->offsetSet('mobile', $userData[0]['mobile_no']);
                    $session->offsetSet('user_id_for_opt', $userData[0]['id']);
                    $this->resendOtpActionByMobile($session->offsetGet('mobile'), $tableName, $tableMobile);
                    return $this->redirect()->toRoute('user', array('action' => 'confimotpMemberSignup'));
                }
            } else if ($userPassValidation['userMatrimonialStatus'] == "true") {
                $tableName = "tbl_user_matrimonial";
                $tableMobile = "tbl_mobile_matrimonial";
                $st = $this->MyPlugin()->checkUserActiveByLoginV1($request->getPost('login_email'), $tableName);
                //Debug::dump($st); exit;
                if ($st['userStatus'] == "true" && $st['userActiveStatus'] == 0 && $st['userSignupStatus'] == 1) {
                    $sessionUser = new Container('user');
                    $sessionUser->offsetSet('user_id', $userPassValidation['user_id_matrimonial']);
                    return $this->redirect()->toRoute('user', array('action' => 'signupMatrimonialDetail'));
                } elseif ($st['userStatus'] == "true" && $st['userActiveStatus'] == 0 && $st['userSignupStatus'] == 2) {
                    $userData = $this->MyPlugin()->getMobileByLoginCredentials($request->getPost('login_email'), $tableName);
                    //Debug::dump($userData); exit;
                    $session = new Container('otp');
                    $session->offsetSet('mobile', $userData[0]['mobile_no']);
                    $session->offsetSet('user_id_for_opt', $userData[0]['id']);
                    $this->resendOtpActionByMobile($session->offsetGet('mobile'), $tableName, $tableMobile);
                    return $this->redirect()->toRoute('user', array('action' => 'confimotpMatrimonialSignup'));
                }
            }
            //exit;

            /* if($userPassValidation==true){
              $st=$this->MyPlugin()->checkUserActiveByLogin($request->getPost('login_email'));
              if($st==false){
              $userData=$this->MyPlugin()->getMobileByLoginCredentials($request->getPost('login_email'));
              $session=new Container('otp');
              $session->offsetSet('mobile', $userData[0]['mobile_no']);
              $session->offsetSet('user_id_for_opt', $userData[0]['id']);
              $this->resendOtpActionByMobile($session->offsetGet('mobile'));
              return $this->redirect()->toRoute('user', array('action' => 'confimotpsignup'));
              }
              }
              $tableName=$this->MyPlugin()->checkUserTypeTable($request->getPost('login_email')); */

            //Debug::dump($tableName);exit;
            $username = $request->getPost('login_email');
            $password = $request->getPost('login_password');
            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $authAdapter = new AuthAdapter($dbAdapter);
            $authAdapter->setTableName($tableName);
            if (!filter_var($username, FILTER_VALIDATE_EMAIL) === false) {
                $authAdapter->setIdentityColumn('email');
            } else {
                $authAdapter->setIdentityColumn('mobile_no');
            }
            $authAdapter->setCredentialColumn('password');
            $authAdapter->setCredentialTreatment('md5(?)');
            $authAdapter->setIdentity($username)->setCredential($password);

            $select = $authAdapter->getDbSelect();
            $select->where('is_active = "1"');
            $auth = new AuthenticationService();
            $result = $auth->authenticate($authAdapter);
            //Debug::dump($result->getCode());
            //exit;
            switch ($result->getCode()) {
                case Result::FAILURE_IDENTITY_NOT_FOUND:
                    // do stuff for nonexistent identity
                    $this->flashMessenger()->addMessage($result->getMessages());
                    return $this->redirect()->toRoute('user', array("action" => 'loginUser'));


                    break;

                case Result::FAILURE_CREDENTIAL_INVALID:
                    // do stuff for invalid credential
                    $this->flashMessenger()->addMessage($result->getMessages());
                    return $this->redirect()->toRoute('user', array("action" => 'loginUser'));
                    break;

                case Result::SUCCESS:

                    $storage = $auth->getStorage();
                    $storage->write($authAdapter->getResultRowObject(
                                    null, 'password'
                    ));

                    //\Zend\Debug\Debug::dump($storage->read());
                    //exit;
                    $userSession = $this->getUser()->session();
                    //\Zend\Debug\Debug::dump($userSession);
                    //exit;
                    $userSession->user = $storage->read();
                    foreach ($storage->read() as $u => $v) {
                        $userSession->offsetSet($u, $v);
                    }


                    if ($tableName == 'tbl_user') {
                        $userSession->offsetSet('user_type', '1');
                        $userInfo = $this->userService->getUserInfoById($userSession->offsetGet('id'), array('full_name'));
                        $userSession->offsetSet('full_name', $userInfo->getFullName());
                    } else {
                        $userSession->offsetSet('user_type', '2');
                        $userInfo = $this->userService->getUserInfoByIdMatrimonial($userSession->offsetGet('id'), array('full_name'));
                        $userSession->offsetSet('full_name', $userInfo['full_name']);
                        //Debug::dump($userInfo['full_name']);
                        //exit;
                        //$userSession->offsetSet('full_name', $userInfo->getFullName());
                    }

                    $time = 1209600; // 14 days 1209600/3600 = 336 hours => 336/24 = 14 days
                    //if ($data['rememberme']) $storage->getSession()->getManager()->rememberMe($time); // no way to get the session

                    if ($request->getPost('rememberme')) {
                        $sessionManager = new SessionManager();
                        $sessionManager->rememberMe($time);
                    }
                    break;

                default:
                    // do stuff for other failure
                    break;
            }
            $messages = '';
            foreach ($result->getMessages() as $message) {
                $messages .= "$message\n";
            }

            //Debug::dump($auth->getIdentity()->role);exit;
            if ($auth->hasIdentity() && in_array($auth->getIdentity()->role, array('user'))) {

                if ($userSession->offsetget('user_type') == '1') {
                    return $this->redirect()->toRoute('profile');
                }
                if ($userSession->offsetget('user_type') == '2') {
                    return $this->redirect()->toRoute('profile', array('action' => 'dashboard-matrimony'));
                }

                //\Zend\Debug\Debug::dump($userSession->offsetget('user_type_id'));
                //exit;
                //return $this->redirect()->toRoute('profile');
                //return $this->redirect()->toUrl($this->getRequest()->getHeader('Referer')->getUri());
            }
        }
    }

    public function loginAction() {

        if ($this->getRequest()->isPost()) {


            $request = $this->getRequest();
            //Debug::dump($request = $this->getRequest());
            //exit;
            //$login_email = $request->getPost('login_email');
            //$login_password = md5($request->getPost('login_password'));
            $userPassValidation = $this->MyPlugin()->checkUserUsernamePassword($request->getPost('login_email'), md5($request->getPost('login_password')));
            //Debug::dump($userPassValidation);
            //exit;  
            if ($userPassValidation == true) {
                $st = $this->MyPlugin()->checkUserActiveByLogin($request->getPost('login_email'));
                //Debug::dump($st);
                //exit;
                if ($st == false) {
                    $userData = $this->MyPlugin()->getMobileByLoginCredentials($request->getPost('login_email'));
                    $session = new Container('otp');
                    $session->offsetSet('mobile', $userData[0]['mobile_no']);
                    $session->offsetSet('user_id_for_opt', $userData[0]['id']);
                    $this->resendOtpActionByMobile($session->offsetGet('mobile'));
                    return $this->redirect()->toRoute('user', array('action' => 'confimotpsignup'));
                }
            }

            $username = $request->getPost('login_email');
            //Debug::dump($username);
            //exit;
            $password = $request->getPost('login_password');
            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $authAdapter = new AuthAdapter($dbAdapter);
            $authAdapter->setTableName('tbl_user');
            if (!filter_var($username, FILTER_VALIDATE_EMAIL) === false) {
                $authAdapter->setIdentityColumn('email');
            } else {
                $authAdapter->setIdentityColumn('mobile_no');
            }

            $authAdapter->setCredentialColumn('password');
            $authAdapter->setCredentialTreatment('md5(?)');
            $authAdapter->setIdentity($username)->setCredential($password);
            $select = $authAdapter->getDbSelect();
            $select->where('is_active = "1"');
            $auth = new AuthenticationService();
            $result = $auth->authenticate($authAdapter);
            //Debug::dump($result->getCode());
            //exit;
            switch ($result->getCode()) {
                case Result::FAILURE_IDENTITY_NOT_FOUND:
                    // do stuff for nonexistent identity
                    $this->flashMessenger()->addMessage($result->getMessages());
                    return $this->redirect()->toRoute('user', array("action" => 'login'));
                    break;

                case Result::FAILURE_CREDENTIAL_INVALID:
                    // do stuff for invalid credential
                    $this->flashMessenger()->addMessage($result->getMessages());
                    return $this->redirect()->toRoute('user', array("action" => 'login'));
                    break;

                case Result::SUCCESS:

                    $storage = $auth->getStorage();
                    $storage->write($authAdapter->getResultRowObject(
                                    null, 'password'
                    ));

                    //\Zend\Debug\Debug::dump($storage->read());
                    //exit;
                    $userSession = $this->getUser()->session();
                    $userSession->user = $storage->read();
                    foreach ($storage->read() as $u => $v) {
                        $userSession->offsetSet($u, $v);
                    }
                    $userInfo = $this->userService->getUserInfoById($userSession->offsetGet('id'), array('full_name'));
                    $userSession->offsetSet('full_name', $userInfo->getFullName());
                    //Debug::dump($storage->read());
                    //exit;
                    $time = 1209600; // 14 days 1209600/3600 = 336 hours => 336/24 = 14 days
                    //if ($data['rememberme']) $storage->getSession()->getManager()->rememberMe($time); // no way to get the session

                    if ($request->getPost('rememberme')) {
                        $sessionManager = new SessionManager();
                        $sessionManager->rememberMe($time);
                    }
                    break;

                default:
                    // do stuff for other failure
                    break;
            }
            $messages = '';
            foreach ($result->getMessages() as $message) {
                $messages .= "$message\n";
            }

            if ($auth->hasIdentity() && in_array($auth->getIdentity()->role, array('user'))) {

                if ($userSession->offsetget('user_type_id') == '1') {
                    return $this->redirect()->toRoute('profile');
                }
                if ($userSession->offsetget('user_type_id') == '2') {
                    return $this->redirect()->toRoute('profile', array('action' => 'dashboard-matrimony'));
                }
            }
        }
    }

    public function LogoutAction() {

        $auth = new AuthenticationService();
        $auth->clearIdentity();
        $session = new Container('user');
        $session->getManager()->getStorage()->clear('user');

        return $this->redirect()->toRoute('home');
    }

    public function signupAction() {
        $signupform = new SignupForm($this->commonService);
        $request = $this->getRequest();
        if ($request->isPost()) {
            //$signupFilter = new SignupFormFilter();
            //$signupform->setInputFilter($signupFilter->getInputFilter());
            $signupform->setData($request->getPost());

            $signupFilter = new SignupFormFilter();
            $signupform->setInputFilter($signupFilter);

            if ($signupform->isValid()) {
                $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

//                 try {
//                    $sql = "SELECT COUNT(*) as count FROM tbl_user WHERE email = '".$request->getPost('email')."'";
//                    $data = $dbAdapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
//                    
//                    //Debug::dump($data[0]['count']);
//                    //exit;
////                    $dbAdapter->query($sql);
////                    $res = mysql_query($sql)  or die(mysql_error());
////                    $data = mysql_fetch_assoc($res);
//                    if ($data[0]['count']> 0) {
//                       throw new \Exception("EMAIL ALREADY IN USE");
//                       
//                    }
//                } catch (\Exception $e) {
//                     $signupform->setMessages(array(
//                        'email' => array($e->getMessage())
//                        ));
//                     return new ViewModel(array("form" => $signupform));
//                }

                try {
                    $userInfoObject = $this->userService->saveUserSignUp($signupform->getData());
                } catch (\Exception $e) {
                    return new ViewModel(array("form" => $signupform));
                    //return $this->redirect()->toRoute('user', array('action' => 'signup'));
                }


                //Debug::dump($userInfoObject);
                //exit;
                $number = $signupform->getData()->getMobileNo();
                $code = rand(1111, 9999);
                date_default_timezone_set('Asia/Kolkata');
                $time = date('H:i');
                //echo "Mohitjjj"; //die;
                //echo 'xxx'.$userInfoObject->getUserNewId(); die;  
                if ($userInfoObject->getUserId() != "") {
                    $userId = $userInfoObject->getUserId();
                } else {
                    $userId = $userInfoObject->getUserNewId();
                }
                //echo $userId; die;
                $this->userService->saveAcitivationSmsCode($userId, $number, $code, $time);

                $data['username'] = $userInfoObject->getUsername();
                $data['password'] = $userInfoObject->getPassword();
                $data['name'] = $userInfoObject->getFullName();
                $data['email'] = $userInfoObject->getEmail();
                $data['mobile'] = $userInfoObject->getMobileNo();
                $data['otp'] = $code;
                $data['msg_sku'] = 'welcome_msg';

                $this->sendSms($data);
                //$this->sendAccountThanksSms('satyaprakash', '8527075535', '5555');
                //exit;
                //$this->sendAccountActivationEmail($userInfoObject->getUsername(), $userInfoObject->getFullName(), $userInfoObject->getEmail(), $userInfoObject->getActivationKey());

                $email = $userInfoObject->getEmail();
                //$email="mohitjain2007@gmail.com";
                $subject = "Rustagi Registration OTP Mail";
                $template = "register_otp";



                $this->sendSmtpMail($email, $subject, $template, $data);

                ////Debug::dump($userInfoObject);
                //exit;
                //header("Location:$base"."user/confimotpsignup?userid=$id&number=$number&code=$code&time=$time");
                //********Redirect *********
                $session = new Container('otp');
                $session->offsetSet('mobile', $number);
                $session->offsetSet('user_id_for_opt', $userId);

                return $this->redirect()->toRoute('user', array('action' => 'confimotpsignup'));
            }
        }

        return new ViewModel(array("form" => $signupform));
    }

    public function confirmLoginAction() {
        $userSession = $this->getUser()->session();
        $user_type_id = $userSession->offsetGet('user_type_id');
        if($user_type_id==1){
        return $this->redirect()->toRoute('profile');    
        }elseif($user_type_id==2){
        return $this->redirect()->toRoute('profile', array('action' => 'dashboard-matrimony'));
        }else{
        return new ViewModel();
        }
    }

    public function signup1Action() {

        return new ViewModel(array('data' => $data));
    }

    public function signup2Action() {

        return new ViewModel(array('data' => $data));
    }

    public function signupMatrimonialAction() {
        $sessionState = new Container('userstate');
        $form = new \Application\Form\SignupMatrimonialForm($this->commonService);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            $signupFilter = new \Application\Form\Filter\SignupMatrimonialFormFilter();
            $form->setInputFilter($signupFilter);
            if ($form->isValid()) {
                $data = $form->getData();
                try {
                    $userId = $this->userService->saveUserMatrimonialSignUp($data);
                    $sessionState->state = '1';
                } catch (\Exception $e) {
                    return new ViewModel(array("form" => $form));
                    //return $this->redirect()->toRoute('user', array('action' => 'signup'));
                }
                //$object = (object)array_map(function($item) { return is_array($item) ? (object)$item :  $item;  }, $form->getData());
                //Debug::dump( (object) $form->getData()->mobileNo);


                $number = $data['mobile_no'];
                //Debug::dump($userInfoObject);
                // exit;
                $code = rand(1111, 9999);
                date_default_timezone_set('Asia/Kolkata');
                $time = date('H:i');
                //echo "Mohitjjj"; //die;
                //echo 'xxx'.$userInfoObject->getUserNewId(); die;  
//                if($userInfoObject->getUserId()!=""){
//                 $userId=   $userInfoObject->getUserId();
//                }else{
//                 $userId=   $userInfoObject->getUserNewId();   
//                }
                //echo $userId; die;
                $this->userService->saveAcitivationSmsCodeMatrimonial($userId, $number, $code, $time);

                $data['username'] = $data['username'];
                $data['password'] = $data['password'];
                $data['email'] = $data['email'];
                $data['mobile'] = $data['mobile_no'];
                $data['otp'] = $code;
                $data['msg_sku'] = 'welcome_msg';

                //$this->sendSms($data);

                $email = $data['email'];
                //$email="mohitjain2007@gmail.com";
                $subject = "Rustagi Registration OTP Mail";
                $template = "register_otp";

                $this->sendSmtpMail($email, $subject, $template, $data);

                ////Debug::dump($userInfoObject);
                //exit;
                //header("Location:$base"."user/confimotpsignup?userid=$id&number=$number&code=$code&time=$time");
                //********Redirect *********
                $session = new Container('otp');
                $session->offsetSet('mobile', $number);
                $session->offsetSet('user_id_for_opt', $userId);
                $session->offsetSet('user_id', $userId);

                return $this->redirect()->toRoute('user', array('action' => 'signupMatrimonialDetail'));
            }
            //Debug::dump($request);
        }
        return new ViewModel(array('form' => $form));
    }

    public function signupMatrimonialDetailAction() {
        $session = new Container('otp');
        $sessionState = new Container('userstate');
        $sessionUser = new Container('user');

        if (!empty($sessionUser->offsetGet('user_id'))) {
            $UserId = $sessionUser->offsetGet('user_id');
        } else {
            $UserId = $session->offsetGet('user_id');
        }

//        if($sessionState->state=='2'){
//            return $this->redirect()->toRoute('user', array('action' => 'signupMatrimonial'));
//        }
        
       
        if (!$session->offsetGet('user_id') && !$sessionUser->offsetGet('user_id')) {
            //return false;
        //return $this->redirect()->toRoute('profile', array('action' => 'dashboard-matrimony'));
        $userSession = $this->getUser()->session();
        $user_type_id = $userSession->offsetGet('user_type_id');
        if($user_type_id==1){
        return $this->redirect()->toRoute('profile');    
        }elseif($user_type_id==2){
        return $this->redirect()->toRoute('profile', array('action' => 'dashboard-matrimony'));
        }
            
        }
        //echo $UserId;
        $signupform = new \Application\Form\SignupMatrimonialDetailForm($this->commonService);
        $request = $this->getRequest();
        if ($request->isPost()) {
            //Debug::dump($request->getPost());exit;
            $signupform->setData($request->getPost());
            $signupFilter = new \Application\Form\Filter\SignupMatrimonialDetailFormFilter();

            if ($signupform->isValid()) {
                //Debug::dump($signupform->getData());exit;
                $data = $signupform->getData();
                //$data['user_id']=$session->offsetGet('user_id');
                $data['user_id'] = $UserId;
                //$data=array_push($data,$session->offsetGet('user_id'));
                //Debug::dump($data);exit;
                //$userInfoObject = $this->userService->saveUserMatrimonialDetailSignUp($data);
                //exit;
                try {
                    $userInfoObject = $this->userService->saveUserMatrimonialDetailSignUp($data);
                    $sessionState->state = '2';

                    $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                    $sqlmobile = "SELECT * FROM tbl_mobile_matrimonial WHERE user_id='" . $UserId . "'";
                    $userData = $adapter->query($sqlmobile, Adapter::QUERY_MODE_EXECUTE)->current();
                    $data1['username'] = $data['full_name'];
                    $data1['mobile'] = $userData['mobile'];
                    $data1['otp'] = $userData['code'];
                    $data1['msg_sku'] = 'welcome_msg';

                    $this->sendSms($data1);

                    //exit;
                } catch (\Exception $e) {
                    return new ViewModel(array("form" => $signupform));
                    //return $this->redirect()->toRoute('user', array('action' => 'signup'));
                }




                return $this->redirect()->toRoute('user', array('action' => 'confimotpMatrimonialSignup'));
            }
        }

        return new ViewModel(array("form" => $signupform));
    }

    public function signupMemberAction() {

        $sessionState = new Container('userstatemember');
        $form = new \Application\Form\SignupMemberForm($this->commonService);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            $signupFilter = new \Application\Form\Filter\SignupMemberFormFilter();
            $form->setInputFilter($signupFilter);
            if ($form->isValid()) {
                $data = $form->getData();
                try {
                    $userId = $this->userService->saveUserMemberSignUp($data);
                    $sessionState->state = '1';
                } catch (\Exception $e) {
                    return new ViewModel(array("form" => $form));
                    //return $this->redirect()->toRoute('user', array('action' => 'signup'));
                }
                //$object = (object)array_map(function($item) { return is_array($item) ? (object)$item :  $item;  }, $form->getData());
                //Debug::dump( (object) $form->getData()->mobileNo);


                $number = $data['mobile_no'];
                //Debug::dump($userInfoObject);
                // exit;
                $code = rand(1111, 9999);
                date_default_timezone_set('Asia/Kolkata');
                $time = date('H:i');
                //echo "Mohitjjj"; //die;
                //echo 'xxx'.$userInfoObject->getUserNewId(); die;  
//                if($userInfoObject->getUserId()!=""){
//                 $userId=   $userInfoObject->getUserId();
//                }else{
//                 $userId=   $userInfoObject->getUserNewId();   
//                }
                //echo $userId; die;
                $this->userService->saveAcitivationSmsCodeMember($userId, $number, $code, $time);

                $data['username'] = $data['username'];
                $data['password'] = $data['password'];
                //$data['name']       =   $data[];
                $data['email'] = $data['email'];
                $data['mobile'] = $data['mobile_no'];
                $data['otp'] = $code;
                $data['msg_sku'] = 'welcome_msg';

                //$this->sendSms($data);
                //$this->sendAccountThanksSms('satyaprakash', '8527075535', '5555');
                //exit;
                //$this->sendAccountActivationEmail($userInfoObject->getUsername(), $userInfoObject->getFullName(), $userInfoObject->getEmail(), $userInfoObject->getActivationKey());

                $email = $data['email'];
                //$email="mohitjain2007@gmail.com";
                $subject = "Rustagi Registration OTP Mail";
                $template = "register_otp";



                $this->sendSmtpMail($email,$subject,$template,$data);
                ////Debug::dump($userInfoObject);
                //exit;
                //header("Location:$base"."user/confimotpsignup?userid=$id&number=$number&code=$code&time=$time");
                //********Redirect *********
                $session = new Container('otp');
                $session->offsetSet('mobile', $number);
                $session->offsetSet('user_id_for_opt', $userId);
                $session->offsetSet('user_id', $userId);

                return $this->redirect()->toRoute('user', array('action' => 'signupMemberDetail'));
            }
            //Debug::dump($request);
        }
        return new ViewModel(array('form' => $form));
    }

    public function signupMemberDetailAction() {

        $session = new Container('otp');
        $sessionState = new Container('userstatemember');
        $sessionUser = new Container('user');

        if (!empty($sessionUser->offsetGet('user_id'))) {
            $UserId = $sessionUser->offsetGet('user_id');
        } else {
            $UserId = $session->offsetGet('user_id');
        }

        if ($sessionState->state == '2') {
            return $this->redirect()->toRoute('user', array('action' => 'signupMember'));
        }
        if (!$session->offsetGet('user_id') && !$sessionUser->offsetGet('user_id')) {
            //return false;
            $userSession = $this->getUser()->session();
            $user_type_id = $userSession->offsetGet('user_type_id');
            if($user_type_id==1){
            return $this->redirect()->toRoute('profile');    
            }elseif($user_type_id==2){
            return $this->redirect()->toRoute('profile', array('action' => 'dashboard-matrimony'));
            }
        }

        //echo $UserId;
        $signupform = new \Application\Form\SignupMemberDetailForm($this->commonService);
        $request = $this->getRequest();
        if ($request->isPost()) {
            //Debug::dump($request->getPost());exit;
            $signupform->setData($request->getPost());
            $signupFilter = new \Application\Form\Filter\SignupMemberDetailFormFilter();
            $result=$signupform->setInputFilter($signupFilter);
            
            if ($signupform->isValid()) {
                //Debug::dump($signupform->getData());exit;
                $data = $signupform->getData();
                //$data['user_id']=$session->offsetGet('user_id');
                $data['user_id'] = $UserId;
                //$data=array_push($data,$session->offsetGet('user_id'));
                //Debug::dump($data);exit;
                //$userInfoObject = $this->userService->saveUserMatrimonialDetailSignUp($data);
                //exit;
                try {
                    $userInfoObject = $this->userService->saveUserMemberDetailSignUp($data);
                    //satya
                    //exit;
                    $sessionState->state = '2';
                    $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                    $sqlmobile = "SELECT * FROM tbl_mobile WHERE user_id='" . $UserId . "'";
                    $userData = $adapter->query($sqlmobile, Adapter::QUERY_MODE_EXECUTE)->current();
                    $data1['username'] = $data['full_name'];
                    $data1['mobile'] = $userData['mobile'];
                    $data1['otp'] = $userData['code'];
                    $data1['msg_sku'] = 'welcome_msg';

                    $this->sendSms($data1);
                    //exit;
                } catch (\Exception $e) {
                    return new ViewModel(array("form" => $signupform));
                    //return $this->redirect()->toRoute('user', array('action' => 'signup'));
                }


                //satya

                return $this->redirect()->toRoute('user', array('action' => 'confimotpMemberSignup'));
            }else{
                Debug::dump($result->getMessages()); exit;
                var_dump($signupform->getMessages()); exit;
            }
        }

        return new ViewModel(array("form" => $signupform));
    }

    /*     * ****Ajax Call***** */

    public function getStateNameAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $countryId = $request->getPost("Country_ID");
            $stateName = $this->commonService->getStateListByCountryCode($countryId);
        }
        if (count($stateName)) {
            return new JsonModel(array("Status" => "Success", "statelist" => $stateName));
        } else {
            return new JsonModel(array("Status" => "Failed", "statelist" => null));
        }
    }

    /*     * ****Ajax Call***** */

    public function getCityNameAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $stateId = $request->getPost("State_ID");
            $cityName = $this->commonService->getCityListByStateCode($stateId);
            if (count($cityName))
                return new JsonModel(array("Status" => "Success", "statelist" => $cityName));
            else
                return new JsonModel(array("Status" => "Failed", "statelist" => null));
        }
    }

    /*     * ****Ajax Call***** */

    public function getRustagiBranchAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $cityId = $request->getPost("City_ID");
            $branchName = $this->commonService->getBrachListByCity($cityId);
            if (count($branchName)) {
                return new JsonModel(array("Status" => "Success", "statelist" => $branchName));
            } else {
                return new JsonModel(array("Status" => "Failed", "statelist" => NULL));
            }
        }
    }
    
    /*     * ****Ajax Call***** */

    public function getCommunityNameAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $religionId = $request->getPost("Religion_ID");
            $communityName = $this->commonService->getCommunityListByRelgionId($religionId);
            if (count($communityName))
                return new JsonModel(array("Status" => "Success", "communitylist" => $communityName));
            else
                return new JsonModel(array("Status" => "Failed", "communitylist" => null));
        }
    }
    
     /*     * ****Ajax Call***** */

    public function getCasteNameAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $communityId = $request->getPost("Community_ID");
            $casteName = $this->commonService->getCasteListByCommunityId($communityId);
            if (count($casteName))
                return new JsonModel(array("Status" => "Success", "castelist" => $casteName));
            else
                return new JsonModel(array("Status" => "Failed", "castelist" => null));
        }
    }

    /*     * ****Ajax Call***** */

    public function getGothraListAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $casteId = $request->getPost("Caste_ID");
            $gothraName = $this->commonService->getGothraListByCaste($casteId);
            if (count($gothraName)) {
                return new JsonModel(array("Status" => "Success", "gothralist" => $gothraName));
            } else {
                return new JsonModel(array("Status" => "Failed", "gothralist" => NULL));
            }
        }
    }

    /*     * ****Ajax Call***** */

    public function checkAlreadyExistAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $fieldName = $request->getPost("id");
            $value = $request->getPost("value");
            $size = $this->userService->checkAlreadyExist($fieldName, $value);
        }
        if ($fieldName == "referral_key") {
            if ($size == 0) {
                return new JsonModel(array("id" => $fieldName, "message" => "<p style='color:red;'>Not Valid</p>"));
            } else {
                return new JsonModel(array("id" => $fieldName, "message" => "<p style='color:green;'>Valid</p>"));
            }
        } else {
            if ($size == 0) {
                return new JsonModel(array("id" => $fieldName, "message" => "<p style='color:green;'>Available</p>"));
            } else {
                return new JsonModel(array("id" => $fieldName, "message" => "<p style='color:red;'>Aleardy Exists</p>"));
            }
        }
        exit();
    }

    public function checkAlreadyExistUserMatrimonialAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $fieldName = $request->getPost("id");
            $value = $request->getPost("value");
            $size = $this->userService->checkAlreadyExistUserMatrimonial($fieldName, $value);
        }
        if ($fieldName == "referral_key") {
            if ($size == 0) {
                return new JsonModel(array("id" => $fieldName, "message" => "<p style='color:red;'>Not Valid</p>"));
            } else {
                return new JsonModel(array("id" => $fieldName, "message" => "<p style='color:green;'>Valid</p>"));
            }
        } else {
            if ($size == 0) {
                return new JsonModel(array("id" => $fieldName, "message" => "<p style='color:green;'>Available</p>"));
            } else {
                return new JsonModel(array("id" => $fieldName, "message" => "<p style='color:red;'>Aleardy Exists</p>"));
            }
        }
        exit();
    }

    public function checkAlreadyExistUserMemberAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $fieldName = $request->getPost("id");
            $value = $request->getPost("value");
            $size = $this->userService->checkAlreadyExistUserMember($fieldName, $value);
        }
        if ($fieldName == "referral_key") {
            if ($size == 0) {
                return new JsonModel(array("id" => $fieldName, "message" => "<p style='color:red;'>Not Valid</p>"));
            } else {
                return new JsonModel(array("id" => $fieldName, "message" => "<p style='color:green;'>Valid</p>"));
            }
        } else {
            if ($size == 0) {
                return new JsonModel(array("id" => $fieldName, "message" => "<p style='color:green;'>Available</p>"));
            } else {
                return new JsonModel(array("id" => $fieldName, "message" => "<p style='color:red;'>Aleardy Exists</p>"));
            }
        }
        exit();
    }

    private function sendAccountActivationEmail($username, $name, $email, $acivationCode) {
        //$keycode = $this->generateRandomString(32);
        $view = new \Zend\View\Renderer\PhpRenderer();
        $resolver = new \Zend\View\Resolver\TemplateMapResolver();
        $resolver->setMap(array(
            'mailTemplate' => __DIR__ . '/../../../view/application/mails/accountActivationEmail.phtml'
        ));
        $view->setResolver($resolver);

        $viewModel = new ViewModel();
        $viewModel->setTemplate('mailTemplate')->setVariables(array(
            'username' => $username,
            'name' => $name,
            'email' => $email,
            'activationCode' => $acivationCode,
        ));

        $bodyPart = new \Zend\Mime\Message();
        $bodyMessage = new Part($view->render($viewModel));
        $bodyMessage->type = 'text/html';
        $bodyPart->setParts(array($bodyMessage));
        $message = new \Zend\Mail\Message();
        $message->addFrom('noreply@infinitescript.com', 'IT Training Platform')
                ->addTo($email)
                ->setSubject('Rustagi Account Activation')
                ->setBody($bodyPart)
                ->setEncoding('UTF-8');
        $transport = new Sendmail();
        $transport->send($message);
    }

    private function sendAccountThanksSms($username, $mobileNumber, $code) {
        //$mobileNumber='8527075535';
        //$keycode = $this->generateRandomString(32);
        $view = new \Zend\View\Renderer\PhpRenderer();
        $resolver = new \Zend\View\Resolver\TemplateMapResolver();
        $resolver->setMap(array(
            'mailTemplate' => __DIR__ . '/../../../view/application/sms/accountThanksSms.phtml'
        ));
        $view->setResolver($resolver);

        $viewModel = new ViewModel();
        $viewModel->setTemplate('mailTemplate')->setVariables(array(
            'username' => $username,
            'code' => $code,
        ));
        $message = $view->render($viewModel);
        file_put_contents("thanksSms.txt", $message);
        // echo $text;die;	
        $message = "Hi+$username,+Welcome+to+Rustagi,Thanks+for+Registration,+Please+complete+the+Registration+Formalities+OTP-$code+log+on+to+rustagisabha.com.+Or+Call+42424242";
        $url = "http://push3.maccesssmspush.com/servlet/com.aclwireless.pushconnectivity.listeners.TextListener?userId=helloalt&pass=helloalt&appid=helloalt&subappid=helloalt&msgtype=1&contenttype=1&selfid=true&to=$mobileNumber&from=Helocb&dlrreq=true&text=$message&alert=1";
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);
    }

    public function confimotpsignupAction() {
        $session = new Container('otp');

        //Debug::dump($session->offsetGet('mobile'));

        if ($session->offsetGet('mobile')) {
            $data['resendButton'] = true;
        } else {
            $data['resendButton'] = false;
        }

        $data['userid'] = (int) $this->getRequest()->getQuery('userid');
        $data['number'] = (int) $this->getRequest()->getQuery('number');
        $data['code'] = (int) $this->getRequest()->getQuery('code');
        $data['time'] = $this->getRequest()->getQuery('time');

        return new ViewModel(array("data" => $data));
        // echo $active ; die;
    }

    public function confimotpMatrimonialSignupAction() {
        
        $userSession = $this->getUser()->session();
        $user_type_id = $userSession->offsetGet('user_type_id');
        if($user_type_id==1){
        return $this->redirect()->toRoute('profile');    
        }elseif($user_type_id==2){
        return $this->redirect()->toRoute('profile', array('action' => 'dashboard-matrimony'));
        }
        $session = new Container('otp');

        //Debug::dump($session->offsetGet('mobile'));

        if ($session->offsetGet('mobile')) {
            $data['resendButton'] = true;
        } else {
            $data['resendButton'] = false;
        }

        $data['userid'] = (int) $this->getRequest()->getQuery('userid');
        $data['number'] = (int) $this->getRequest()->getQuery('number');
        $data['code'] = (int) $this->getRequest()->getQuery('code');
        $data['time'] = $this->getRequest()->getQuery('time');

        return new ViewModel(array("data" => $data));
        // echo $active ; die;
    }

    public function confimotpMemberSignupAction() {
        $session = new Container('otp');

        //Debug::dump($session->offsetGet('mobile'));

        if ($session->offsetGet('mobile')) {
            $data['resendButton'] = true;
        } else {
            $data['resendButton'] = false;
        }

        $data['userid'] = (int) $this->getRequest()->getQuery('userid');
        $data['number'] = (int) $this->getRequest()->getQuery('number');
        $data['code'] = (int) $this->getRequest()->getQuery('code');
        $data['time'] = $this->getRequest()->getQuery('time');

        return new ViewModel(array("data" => $data));
        // echo $active ; die;
    }

    public function confirmotpAction() {
        //$isreg = $_POST['is_reg'];
        $data = array();
        $isreg = 1;
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $otp = $_POST['otp'];
        $sql = "select * from tbl_mobile where code='$otp'";
        $arrdef = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $size = $arrdef->count();
        $uid = $arrdef->toArray()[0]['user_id'];

        if ($isreg == 1) {
            if ($size == 1) {
                $update = $this->getUserTable()->activateUser($uid);
                if ($update) {
                    $session = new Container('otp');
                    if ($session->offsetGet('user_id_for_opt')) {
                        $sqlUser = "SELECT * FROM tbl_user WHERE id='" . $session->offsetGet('user_id_for_opt') . "'";
                        $userData = $adapter->query($sqlUser, Adapter::QUERY_MODE_EXECUTE)->toArray();

                        $sqlUserInfo = "SELECT full_name FROM tbl_user_info WHERE user_id='" . $session->offsetGet('user_id_for_opt') . "'";
                        $userDataInfo = $adapter->query($sqlUserInfo, Adapter::QUERY_MODE_EXECUTE)->toArray();

                        $data['username'] = $userData[0]['username'];
                        $data['email'] = $userData[0]['email'];
                        $data['mobile'] = $userData[0]['mobile_no'];
                        $data['name'] = $userDataInfo[0]['full_name'];

                        $subject = "Rustagi Registration Success Mail";
                        $template = "register";
                        $this->sendSmtpMail($userData[0]['email'], $subject, $template, $data);
                        $msg = "Congratulations Registration successful You can proceed to Change Password";
                    }
                } else {
                    $msg = "You are already active or Their is some internal error occured . Please try later";
                }
                $succarr = array("userid" => $uid, "is_reg" => $isreg, "msg" => $msg);
                return new JsonModel(array("resp" => 1, "success" => $succarr));
            } else {
                return new JsonModel(array("resp" => 0, "error" => "otp doesn't match"));
            }
        }
        exit();
    }

    public function confirmotpMatrimonialAction() {
        //$isreg = $_POST['is_reg'];

        $data = array();
        $isreg = 1;
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $otp = $_POST['otp'];
        $sql = "select * from tbl_mobile_matrimonial where code='$otp'";
        $arrdef = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $size = $arrdef->count();
        $uid = $arrdef->toArray()[0]['user_id'];

        if ($isreg == 1) {
            if ($size == 1) {
                $updatesql = "UPDATE tbl_user_matrimonial set is_used=1, is_active=1, signup_status=3 WHERE id=$uid";
                $update = $adapter->query($updatesql, Adapter::QUERY_MODE_EXECUTE);
                //var_dump($update);exit;
                //$update = $this->getUserTable()->activateUser($uid);
                if ($update) {
                    $session = new Container('otp');
                    if ($session->offsetGet('user_id_for_opt')) {
                        $sqlUser = "SELECT * FROM tbl_user_matrimonial WHERE id='" . $session->offsetGet('user_id_for_opt') . "'";
                        $userData = $adapter->query($sqlUser, Adapter::QUERY_MODE_EXECUTE)->toArray();

                        $sqlUserInfo = "SELECT full_name FROM tbl_user_info_matrimonial WHERE user_id='" . $session->offsetGet('user_id_for_opt') . "'";
                        $userDataInfo = $adapter->query($sqlUserInfo, Adapter::QUERY_MODE_EXECUTE)->toArray();

                        $data['username'] = $userData[0]['username'];
                        $data['email'] = $userData[0]['email'];
                        $data['mobile'] = $userData[0]['mobile_no'];
                        $data['name'] = $userDataInfo[0]['full_name'];

                        $subject = "Rustagi Registration Success Mail";
                        $template = "register";
                        $this->sendSmtpMail($userData[0]['email'],$subject,$template,$data);
                        $msg = "Congratulations Registration successful You can proceed to Change Password";
                    }
                } else {
                    $msg = "You are already active or Their is some internal error occured . Please try later";
                }
                $succarr = array("userid" => $uid, "is_reg" => $isreg, "msg" => $msg);
                return new JsonModel(array("resp" => 1, "success" => $succarr));
            } else {
                return new JsonModel(array("resp" => 0, "error" => "otp doesn't match"));
            }
        }
        exit();
    }

    public function confirmotpMemberAction() {
        //$isreg = $_POST['is_reg'];

        $data = array();
        $isreg = 1;
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $otp = $_POST['otp'];
        $sql = "select * from tbl_mobile where code='$otp'";
        $arrdef = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $size = $arrdef->count();
        $uid = $arrdef->toArray()[0]['user_id'];

        if ($isreg == 1) {
            if ($size == 1) {
                $updatesql = "UPDATE tbl_user set is_used=1, is_active=1, signup_status=3 WHERE id=$uid";
                $update = $adapter->query($updatesql, Adapter::QUERY_MODE_EXECUTE);
                //var_dump($update);exit;
                //$update = $this->getUserTable()->activateUser($uid);
                if ($update) {
                    $session = new Container('otp');
                    if ($session->offsetGet('user_id_for_opt')) {
                        $sqlUser = "SELECT * FROM tbl_user WHERE id='" . $session->offsetGet('user_id_for_opt') . "'";
                        $userData = $adapter->query($sqlUser, Adapter::QUERY_MODE_EXECUTE)->toArray();

                        $sqlUserInfo = "SELECT full_name FROM tbl_user_info WHERE user_id='" . $session->offsetGet('user_id_for_opt') . "'";
                        $userDataInfo = $adapter->query($sqlUserInfo, Adapter::QUERY_MODE_EXECUTE)->toArray();

                        $data['username'] = $userData[0]['username'];
                        $data['email'] = $userData[0]['email'];
                        $data['mobile'] = $userData[0]['mobile_no'];
                        $data['name'] = $userDataInfo[0]['full_name'];

                        $subject = "Rustagi Registration Success Mail";
                        $template = "register";
                        $this->sendSmtpMail($userData[0]['email'],$subject,$template,$data);
                        $msg = "Congratulations Registration successful You can proceed to Change Password";
                    }
                } else {
                    $msg = "You are already active or Their is some internal error occured . Please try later";
                }
                $succarr = array("userid" => $uid, "is_reg" => $isreg, "msg" => $msg);
                return new JsonModel(array("resp" => 1, "success" => $succarr));
            } else {
                return new JsonModel(array("resp" => 0, "error" => "otp doesn't match"));
            }
        }
        exit();
    }

    public function changepswdAction() {
        $data = array();
        $isreg = 1;
        $session = new Container('otp');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $old_password = md5($_POST['old_password']);
        $new_password = md5($_POST['new_password']);
        $sql = "select * from tbl_user where password='$old_password' AND id='" . $session->offsetGet('user_id_for_opt') . "'";
        $arrdef = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $size = $arrdef->count();
        $uid = $arrdef->toArray()[0]['id'];

        if ($isreg == 1) {
            if ($size == 1) {
                $update = $this->getUserTable()->changepswdUser($uid, $old_password, $new_password);
                if ($update) {
                    $msg = "Congratulations You have change password You can proceed to login";
                } else {
                    $msg = "You have already change password or their is some internal error occured . Please try later";
                }
                $succarr = array("userid" => $uid, "is_reg" => $isreg, "msg" => $msg);
                return new JsonModel(array("resp" => 1, "success" => $succarr));
            } else {
                return new JsonModel(array("resp" => 0, "error" => "Old password doesn't match"));
            }
        }

        exit();
    }

    public function changePasswordMatrimonialAction() {
        $data = array();
        $isreg = 1;
        $session = new Container('otp');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $old_password = md5($_POST['old_password']);
        $new_password = md5($_POST['new_password']);
        $sql = "select * from tbl_user_matrimonial where password='$old_password' AND id='" . $session->offsetGet('user_id_for_opt') . "'";
        $arrdef = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $size = $arrdef->count();
        $uid = $arrdef->toArray()[0]['id'];

        if ($isreg == 1) {
            if ($size == 1) {
                $sql = "update tbl_user_matrimonial SET password='$new_password' where password='$old_password' AND id='" . $uid . "'";
                $update = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
                //update = $this->getUserTable()->changepswdUser($uid, $old_password, $new_password);
                if ($update) {
                    $msg = "Congratulations You have change password You can proceed to login";
                } else {
                    $msg = "You have already change password or their is some internal error occured . Please try later";
                }
                $succarr = array("userid" => $uid, "is_reg" => $isreg, "msg" => $msg);
                return new JsonModel(array("resp" => 1, "success" => $succarr));
            } else {
                return new JsonModel(array("resp" => 0, "error" => "Old password doesn't match"));
            }
        }

        exit();
    }

    public function confirmotp_oldAction() {
        //$isreg = $_POST['is_reg'];
        $isreg = 1;
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        //$arrdef = $adapter->query("select * from tbl_mobile where (code=" . $_POST['otp'] . " && mobile=" . $_POST['number'] . " && time='" . $_POST['time'] . "')", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        $arrdef = $adapter->query("select * from tbl_mobile where code=" . $_POST['otp'], Adapter::QUERY_MODE_EXECUTE);
        $size = $arrdef->count();

        $uid = $arrdef->toArray()[0]['user_id'];

        //echo $uid;die;
        // foreach ($arrdef as $user) {
        //         $userid = $user->user_id;
        //     }

        if ($isreg == 1) {

            $update = $this->getUserTable()->activateUser($uid);
            if ($update)
                $msg = "Congratulations Registration successful You can proceed to login";
            else
                $msg = "You are already active or Their is some internal error occured . Please try later";
        }

        $succarr = array("userid" => $userid, "is_reg" => $isreg, "msg" => $msg);

        if ($size == 1) {
            return new JsonModel(array("resp" => 1, "success" => $succarr));

            // $response = $this->getResponse();
            // $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
            // $response->setContent(json_encode(array("resp"=>1,"success"=>$succarr)));
            //     return $response;
        } else {
            return new JsonModel(array("resp" => 0, "error" => "otp doesn't match"));

            // $response = $this->getResponse();
            // $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
            // $response->setContent(json_encode(array("resp"=>0,"error"=>"otp doesn't match")));
            //     return $response;
        }
        exit();
    }

    public function confirmotpPopAction() {
        //$isreg = $_POST['is_reg'];
        $isreg = 1;
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        //$arrdef = $adapter->query("select * from tbl_mobile where (code=" . $_POST['otp'] . " && mobile=" . $_POST['number'] . " && time='" . $_POST['time'] . "')", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        $otp    =   $_POST['otp']; 
        $userid =   $_POST['userid'];
        $number =   $_POST['number'];
        $user_type =   $_POST['user_type_data'];
        
        if($user_type=="member_user"){
            $tableName="tbl_user";
            $tableMobile="tbl_mobile";
        }elseif($user_type=="matrimonial_user"){
            $tableName="tbl_user_matrimonial";
            $tableMobile="tbl_mobile_matrimonial";
        }       

        $sql="select * from $tableMobile where code='$otp' AND user_id='$userid' AND mobile='$number'";
        $arrdef = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $size = $arrdef->count();

        $uid = $arrdef->toArray()[0]['user_id'];
        $msg = "OTP has confirm please change your password";
        $succarr = array("userid" => $_POST['userid'], "mobile" => $_POST['number'], "user_type" => $_POST['user_type_data'], "is_reg" => $isreg, "msg" => $msg);

        if ($size == 1) {
            return new JsonModel(array("resp" => 1, "success" => $succarr));
        } else {
            return new JsonModel(array("resp" => 0, "error" => "otp doesn't match"));
        }
        exit();
    }

    public function confirmoldChangePwdAction() {
        $userSession = $this->getUser()->session();
        $uid = $userSession->offsetGet('id');
        if ($userSession->offsetGet('user_type') == '1') {

            //echo  "hello";exit;
            //$isreg = $_POST['is_reg'];
            $isreg = 1;
            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $old_password2 = md5($_POST['old_password2']);
//        echo  "<pre>";
//        echo $old_password;exit;
            //$uid = $arrdef->toArray()[0]['user_id'];
            //$uid = $arrdef->toArray()[0]['id'];
            // $session=new Container('otp');
            //$uid = $session->offsetGet('user_id_for_opt');
//        echo  "<pre>";
//        print_r($userSession);exit;
            //echo  $uid;exit;
            //echo $old_password;exit;
            //$arrdef = $adapter->query("select * from tbl_mobile where (code=" . $_POST['otp'] . " && mobile=" . $_POST['number'] . " && time='" . $_POST['time'] . "')", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            $arrdef = $adapter->query("select * from tbl_user where (id='" . $uid . "' && password='" . $old_password2 . "')", Adapter::QUERY_MODE_EXECUTE);
            $size = $arrdef->count();
//        echo   "<pre>";
//        echo  $size;exit;


            $msg = "OTP has confirm please change your password";
            $succarr = array("userid" => $_POST['userid'], "mobile" => $_POST['number'], "is_reg" => $isreg, "msg" => $msg);
            //echo  $size;exit;
            if ($size == 1) {
                //return new JsonModel(array("resp" => 1, "success" => $succarr));
            } else {
                return new JsonModel(array("resp" => 0, "error" => "old pwd doesn't match"));
            }
            exit();
        }
        if ($userSession->offsetGet('user_type') == '2') {


            //echo  "hello";exit;
            //$isreg = $_POST['is_reg'];
            $isreg = 1;
            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $old_password2 = md5($_POST['old_password2']);
//        echo  "<pre>";
//        echo $old_password;exit;
            //$uid = $arrdef->toArray()[0]['user_id'];
            //$uid = $arrdef->toArray()[0]['id'];
            // $session=new Container('otp');
            //$uid = $session->offsetGet('user_id_for_opt');
//        echo  "<pre>";
//        print_r($userSession);exit;
            //echo  $uid;exit;
            //echo $old_password;exit;
            //$arrdef = $adapter->query("select * from tbl_mobile where (code=" . $_POST['otp'] . " && mobile=" . $_POST['number'] . " && time='" . $_POST['time'] . "')", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            $arrdef = $adapter->query("select * from tbl_user_matrimonial where (id='" . $uid . "' && password='" . $old_password2 . "')", Adapter::QUERY_MODE_EXECUTE);
            $size = $arrdef->count();
//        echo   "<pre>";
//        echo  $size;exit;


            $msg = "OTP has confirm please change your password";
            $succarr = array("userid" => $_POST['userid'], "mobile" => $_POST['number'], "is_reg" => $isreg, "msg" => $msg);
            //echo  $size;exit;
            if ($size == 1) {
                //return new JsonModel(array("resp" => 1, "success" => $succarr));
            } else {
                return new JsonModel(array("resp" => 0, "error" => "old pwd doesn't match"));
            }
            exit();
        }
    }

    public function confirmChangePwdAction() {
        //echo  "hello amir";exit;
        //echo $_POST('new_password');exit;

        if (strcmp($_POST['new_password'], $_POST['confirm_password']) != 0) {

            return new JsonModel(array("resp" => 0, "error" => "confirm password doesn't match"));
        }
//        else {
//            return new JsonModel(array("resp" => 0, "error" => "password doesn't match"));
//        }
        exit();
    }

    public function resendOtpWithSessionAction() {

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $session = new Container('otp');

        if ($session->offsetGet('user_id_for_opt')) {
            $sqlUser = "SELECT * FROM tbl_user WHERE id='" . $session->offsetGet('user_id_for_opt') . "'";
            $userData = $adapter->query($sqlUser, Adapter::QUERY_MODE_EXECUTE)->toArray();
            $code = rand(1111, 9999);
            date_default_timezone_set('Asia/Kolkata');
            $time = date('H:i');
            $sql = "UPDATE tbl_mobile SET code='$code', time='$time' WHERE user_id='" . $session->offsetGet('user_id_for_opt') . "'";
            $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
            
            $data['username'] = $userData[0]['username'];
            $data['mobile'] = $userData[0]['mobile_no'];
            $data['otp'] = $code;
            $data['msg_sku'] = 'welcome_msg';
            $this->sendSms($data);
            //$this->sendAccountThanksSms($userData[0]['username'], $session->offsetGet('mobile'), $code);
            return new JsonModel(array("resp" => 1, "message" => "otp sent"));
        } else {
            return new JsonModel(array("resp" => 0, "message" => "you are not authorise"));
        }
    }

    public function resendOtpWithSessionMatrimonialAction() {

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $session = new Container('otp');

        if ($session->offsetGet('user_id_for_opt')) {
            $sqlUser = "SELECT * FROM tbl_user_matrimonial WHERE id='" . $session->offsetGet('user_id_for_opt') . "'";
            $userData = $adapter->query($sqlUser, Adapter::QUERY_MODE_EXECUTE)->toArray();
            $code = rand(1111, 9999);
            date_default_timezone_set('Asia/Kolkata');
            $time = date('H:i');
            $sql = "UPDATE tbl_mobile_matrimonial SET code='$code', time='$time' WHERE user_id='" . $session->offsetGet('user_id_for_opt') . "'";
            $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
            //$this->sendAccountThanksSms($userData[0]['username'], $session->offsetGet('mobile'), $code);
            $data['username'] = $userData[0]['username'];
            $data['mobile'] = $userData[0]['mobile_no'];
            $data['otp'] = $code;
            $data['msg_sku'] = 'welcome_msg';
            $this->sendSms($data);
            return new JsonModel(array("resp" => 1, "message" => "otp sent"));
        } else {
            return new JsonModel(array("resp" => 0, "message" => "you are not authorise"));
        }
    }

    public function resendOtpActionByMobile($mobile, $table_user, $table_mobile) {
        //Debug::dump($mobile);
        //exit;
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        if ($mobile) {
            $sqlUser = "SELECT * FROM $table_user WHERE mobile_no='$mobile'";
            $userData = $adapter->query($sqlUser, Adapter::QUERY_MODE_EXECUTE)->toArray();
            //echo $userData[0]['username']; exit;
            $code = rand(1111, 9999);
            date_default_timezone_set('Asia/Kolkata');
            $time = date('H:i');
            $sql = "UPDATE $table_mobile SET code='$code', time='$time' WHERE mobile='$mobile'";
            //exit;
            $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
            //$this->sendAccountThanksSms($userData[0]['username'], $mobile, $code);
            $data['username'] = $userData[0]['username'];
            $data['mobile'] = $mobile;
            $data['otp'] = $code;
            $data['msg_sku'] = 'welcome_msg';
            $this->sendSms($data);

            return new JsonModel(array("resp" => 1, "message" => "otp sent"));
        } else {
            return new JsonModel(array("resp" => 0, "message" => "you are not authorise"));
        }
    }

    public function sendOtpByPopAction() {
        $mobile = $this->params()->fromPost('number');
        $user_type = $this->params()->fromPost('user_type');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        if ($mobile) {
            if($user_type=="member_user"){
              $tableName="tbl_user";
              $tableMobile="tbl_mobile";
            }elseif($user_type=="matrimonial_user"){
              $tableName="tbl_user_matrimonial";
              $tableMobile="tbl_mobile_matrimonial";
            }
            
            //$sqlUser = "SELECT * FROM $tableName WHERE mobile_no=$mobile";
            //$userData = $adapter->query($sqlUser, Adapter::QUERY_MODE_EXECUTE)->toArray();
            
            $sql="SELECT * FROM $tableName WHERE mobile_no='$mobile'";
            $arrdef = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
            $size = $arrdef->count();
            
            if ($size == 1) {
            $data=$arrdef->toArray()[0];
            $user_id    =   $data['id'];
            $username  =   $data['username']; 
            //die;
            $code = rand(1111, 9999);
            date_default_timezone_set('Asia/Kolkata');
            $time = date('H:i');
            $sql = "UPDATE $tableMobile SET code='$code', time='$time' WHERE mobile='$mobile'";
            $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
            //$this->sendAccountThanksSms($userData[0]['username'], $mobile, $code);
            $data['username'] = $username;
            $data['mobile'] = $mobile;
            $data['otp'] = $code;
            $data['msg_sku'] = 'forgot_password';

            $this->sendSms($data);
            $succarr = array("userid" => $user_id, "mobile" => $mobile);
            return new JsonModel(array("resp" => 1, "success" => $succarr));
            } else {
            return new JsonModel(array("resp" => 0, "error" => "number doesn't exist"));
            }
            
            
        } else {
            return new JsonModel(array("resp" => 0, "message" => "you are not authorise"));
        }
    }

    //added by amir
//    public function changepasswordAction(){
//        
//        //echo  $_POST['userid'];exit;
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        
//        $userSession = $this->getUser()->session();
//        if(isset($_POST['new_password']) && isset($_POST['confirm_password'])){
//            $sql="UPDATE tbl_user SET password='".md5($_POST['new_password'])."' WHERE id='".$_POST['userid']."' AND mobile_no='".$_POST['mobile']."'";
//           
//            $query=$adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
//           if($query){
//             $succarr = array("msg" => 'password changed');
//            //return new JsonModel(array("resp" => 1, "success" => $succarr));
//           }else{
//            $succarr = array("msg" => 'password could not changed please try again');
//            //return new JsonModel(array("resp" => 0, "success" => $succarr));
//           }
//        }else{
//            $succarr = array("pass" => 0, "rpass" => 0);            //return new JsonModel(array("resp" => 0, "success" => $succarr));
//        }
//        
//        //return new ViewModel(array());
//        return new ViewModel(array(
//            ));
//    
//        
//        
//        
//    }
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
//            //$succarr = array("userid" => $userData[0]['id'], "mobile" => $userData[0]['mobile_no']);
//            //$success = 'otp sent';
//            return new JsonModel(array("resp" => true, "message" => "otp sent"));
//            //return  $success;
//            
//        }else{
//           return new JsonModel(array("resp" => 0, "message" => "you are not authorise"));
//        }       
//    }

    public function sendOtpAction($mobile) {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        if ($mobile) {
            $sqlUser = "SELECT * FROM tbl_user WHERE mobile_no=$mobile";
            $userData = $adapter->query($sqlUser, Adapter::QUERY_MODE_EXECUTE)->toArray();
            $code = rand(1111, 9999);
            date_default_timezone_set('Asia/Kolkata');
            $time = date('H:i');
            $this->userService->saveAcitivationSmsCode($userData[0]['id'], $mobile, $code, $time);
            $this->sendAccountThanksSms($userData[0]['username'], $mobile, $code);
            return new JsonModel(array("resp" => 1, "message" => "otp sent"));
        } else {
            return new JsonModel(array("resp" => 0, "message" => "OTP could not sent"));
        }
    }

    public function changePasswordByPopAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        if (isset($_POST['userid']) && isset($_POST['mobile']) && isset($_POST['pass']) && isset($_POST['rpass']) && isset($_POST['user_type'])) {
            if($_POST['user_type']=="member_user"){
              $tableName="tbl_user";
              $user_type_id='1';
            }elseif($_POST['user_type']=="matrimonial_user"){
              $tableName="tbl_user_matrimonial";
              $user_type_id='2';
            }
            
            $sql = "UPDATE $tableName SET password='" . md5($_POST['pass']) . "' WHERE id='" . $_POST['userid'] . "' AND mobile_no='" . $_POST['mobile'] . "' AND user_type_id='" . $user_type_id . "'";
            $query = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
            if ($query) {
                $succarr = 'password changed';
                return new JsonModel(array("resp" => 1, "success" => $succarr));
            } else {
                $succarr = 'password could not changed please try again';
                return new JsonModel(array("resp" => 0, "success" => $succarr));
            }
        } else {
            $succarr = array("pass" => 0, "rpass" => 0);
            return new JsonModel(array("resp" => 0, "success" => $succarr));
        }
    }

    public function userfiltersAction() { 
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $q = $request->getPost("search");            
            $sqlUser = "select tu.mobile_no,tui.id,tui.user_id,tui.name_title_user,tui.full_name,tui.last_name,tui.live_status,tui.dob,tui.about_yourself_partner_family as about,tui.native_place,tug.image_path "
                    . "from tbl_user_info as tui "
                    . "LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id AND tug.profile_pic='1'"
                    . "JOIN tbl_user as tu ON tu.id=tui.user_id "
                    . "WHERE tui.user_type_id!='2' AND tui.gender='Male' AND tui.full_name like '$q%' order by tui.id"; //echo $sqlUser; exit;
            $userData = $adapter->query($sqlUser, Adapter::QUERY_MODE_EXECUTE)->toArray();
           // print_r($userData); die;
            $view = new ViewModel(array('userData' => $userData, 'q' => $q));
            $view->setTerminal(true);
            return $view;
        }
    }

    public function userbrosisfiltersAction() {
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $q = $request->getPost("search");
            $father_id = $request->getPost("father_id");
            $type = $request->getPost("type");
            if ($type == "sis") {
                $gender = "Female";
            } elseif ($type == "bro") {
                $gender = "Male";
            }
            $sqlUser = "select tu.mobile_no,tui.id,tui.user_id,tui.full_name,tui.last_name,tui.dob,tui.native_place,tug.image_path "
                    . "from tbl_user_info as tui "
                    . "LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id AND tug.profile_pic='1'"
                    . "JOIN tbl_family_relation as tfr ON tui.user_id=tfr.user_id AND tfr.father_id='$father_id'"
                    . "JOIN tbl_user as tu ON tu.id=tui.user_id "
                    . "WHERE tfr.user_id!='$user_id' AND tui.user_type_id!='2' AND tui.gender='$gender' AND tui.full_name like '$q%' order by tui.id";
            $userData = $adapter->query($sqlUser, Adapter::QUERY_MODE_EXECUTE)->toArray();
           // print_r($userData); die;
            $view = new ViewModel(array('userData' => $userData, 'q' => $q));
            $view->setTerminal(true);
            return $view;
        }
    }

    public function newuserfiltersAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $q = $request->getPost("search");
            $sqlUser = "select tu.mobile_no,tui.id,tui.user_id,tui.full_name,tui.dob,tui.native_place,tug.image_path "
                    . "from tbl_user_info as tui "
                    . "LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id AND tug.profile_pic='1'"
                    . "JOIN tbl_user as tu ON tu.id=tui.user_id "
                    . "WHERE tui.user_type_id!='2' AND tu.is_active=0 AND tui.full_name like '$q%' order by tui.id";
            $userData = $adapter->query($sqlUser, Adapter::QUERY_MODE_EXECUTE)->toArray();
            //print_r($userData); die;
            $view = new ViewModel(array('userData' => $userData, 'q' => $q));
            $view->setTerminal(true);
            return $view;
        }
    }

    public function userspousefiltersAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $q = $request->getPost("search");
            $gender = $request->getPost("gender");
            $sqlUser = "select tu.mobile_no,tui.id,tui.user_id,tui.name_title_user,tui.full_name,tui.last_name,tui.live_status,tui.dob,tui.about_yourself_partner_family as about,tui.native_place,tug.image_path "
                    . "from tbl_user_info as tui "
                    . "LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id AND tug.profile_pic='1'"
                    . "JOIN tbl_user as tu ON tu.id=tui.user_id "
                    . "WHERE tui.user_type_id!='2' AND tui.gender!='" . $gender . "' AND tui.full_name like '$q%' order by tui.id";
            $userData = $adapter->query($sqlUser, Adapter::QUERY_MODE_EXECUTE)->toArray();
            //print_r($userData); die;
            $view = new ViewModel(array('userData' => $userData, 'q' => $q, 'gender' => $gender));
            $view->setTerminal(true);
            return $view;
        }
    }

    public function userMotherFiltersAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $q = $request->getPost("search");
            $sqlUser = "select tu.mobile_no,tui.id,tui.user_id,tui.full_name, tui.last_name,tui.dob,tui.native_place,tug.image_path "
                    . "from tbl_user_info as tui "
                    . "LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id AND tug.profile_pic='1'"
                    . "JOIN tbl_user as tu ON tu.id=tui.user_id "
                    . "WHERE tui.user_type_id!='2' AND tui.gender='Female' AND tui.full_name like '$q%' order by tui.id";
            $userData = $adapter->query($sqlUser, Adapter::QUERY_MODE_EXECUTE)->toArray();
            //print_r($userData); die;
            $view = new ViewModel(array('userData' => $userData, 'q' => $q));
            $view->setTerminal(true);
            return $view;
        }
    }

    public function userkidsfiltersAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $q = $request->getPost("search");
            $sqlUser = "select tu.mobile_no,tui.id,tui.user_id,tui.full_name,tui.dob,tui.native_place,tug.image_path "
                    . "from tbl_user_info as tui "
                    . "LEFT JOIN tbl_user_gallery as tug ON tui.user_id=tug.user_id AND tug.profile_pic='1'"
                    . "JOIN tbl_user as tu ON tu.id=tui.user_id "
                    . "WHERE tui.user_type_id!='2' AND tui.full_name like '$q%' order by tui.id";
            $userData = $adapter->query($sqlUser, Adapter::QUERY_MODE_EXECUTE)->toArray();
            //print_r($userData); die;
            $view = new ViewModel(array('userData' => $userData, 'q' => $q));
            $view->setTerminal(true);
            return $view;
        }
    }
    
    public function userLoginAction($login_email,$login_password,$tableName){
        
            $username = $login_email;
            $password = $login_password;
            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $authAdapter = new AuthAdapter($dbAdapter);
            $authAdapter->setTableName($tableName);
            if (!filter_var($username, FILTER_VALIDATE_EMAIL) === false) {
                $authAdapter->setIdentityColumn('email');
            } else {
                $authAdapter->setIdentityColumn('mobile_no');
            }
            $authAdapter->setCredentialColumn('password');
            //$authAdapter->setCredentialTreatment('md5(?)');
            $authAdapter->setIdentity($username)->setCredential($password);

            $select = $authAdapter->getDbSelect();
            $select->where('is_active = "1"');
            $auth = new AuthenticationService();
            $result = $auth->authenticate($authAdapter);
            //Debug::dump($result->getCode());
            //exit;
            switch ($result->getCode()) {
                case Result::FAILURE_IDENTITY_NOT_FOUND:
                    // do stuff for nonexistent identity
                    $this->flashMessenger()->addMessage($result->getMessages());
                    return $this->redirect()->toRoute('user', array("action" => 'login'));


                    break;

                case Result::FAILURE_CREDENTIAL_INVALID:
                    // do stuff for invalid credential
                    $this->flashMessenger()->addMessage($result->getMessages());
                    return $this->redirect()->toRoute('user', array("action" => 'login'));
                    break;

                case Result::SUCCESS:

                    $storage = $auth->getStorage();
                    $storage->write($authAdapter->getResultRowObject(
                                    null, 'password'
                    ));

                   // \Zend\Debug\Debug::dump($storage->read());
                    //exit;
                    $userSession = $this->getUser()->session();
                    //\Zend\Debug\Debug::dump($userSession);
                    //exit;
                    $userSession->user = $storage->read();
                    foreach ($storage->read() as $u => $v) {
                        $userSession->offsetSet($u, $v);
                    }
                    //Debug::dump($userSession->user);
                    //exit;
                    
                    if ($tableName == 'tbl_user') {
                        $userSession->offsetSet('user_type', '1');
                        $userInfo = $this->userService->getUserInfoById($userSession->offsetGet('id'), array('full_name'));
                        $userSession->offsetSet('full_name', $userInfo->getFullName());
                    } else {
                        $userSession->offsetSet('user_type', '2');
                        $userInfo = $this->userService->getUserInfoByIdMatrimonial($userSession->offsetGet('id'), array('full_name'));
                        $userSession->offsetSet('full_name', $userInfo['full_name']);
                        //Debug::dump($userInfo['full_name']);
                        //exit;
                        //$userSession->offsetSet('full_name', $userInfo->getFullName());
                    }
                    //Debug::dump($userInfo);exit;
                    $time = 1209600; // 14 days 1209600/3600 = 336 hours => 336/24 = 14 days
                    //if ($data['rememberme']) $storage->getSession()->getManager()->rememberMe($time); // no way to get the session
                    //echo "Jain";
//                    if ($request->getPost('rememberme')) {
//                        $sessionManager = new SessionManager();
//                        $sessionManager->rememberMe($time);
//                    }
                    break;

                default:
                    // do stuff for other failure
                    break;
            }
            //Debug::dump('bbjhbhb');
            $messages = '';
            foreach ($result->getMessages() as $message) {
                $messages .= "$message\n";
            }
            
            //Debug::dump($auth->getIdentity()->role);exit;
            if ($auth->hasIdentity() && in_array($auth->getIdentity()->role, array('user'))) {
                
               
                    return true;
               
               

                //\Zend\Debug\Debug::dump($userSession->offsetget('user_type_id'));
                //exit;
                //return $this->redirect()->toRoute('profile');
                //return $this->redirect()->toUrl($this->getRequest()->getHeader('Referer')->getUri());
            }
        
    }

}

?>