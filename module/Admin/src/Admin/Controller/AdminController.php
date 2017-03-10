<?php

namespace Admin\Controller;

use Admin\Form\MemberdashboardFilter;
use Admin\Form\MemberdashboardForm;
use Admin\Form\MatrimonialdashboardFilter;
use Admin\Form\MatrimonialdashboardForm;
use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Authentication\AuthenticationService;
use Admin\Model\Entity\Memberdashboards;
use Admin\Model\Entity\Matrimonialdashboards;
use Zend\Db\Adapter\Adapter;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class AdminController extends AppController {
    
    protected $commonService;
    protected $adminService;

    public function __construct(CommonServiceInterface $commonService, AdminServiceInterface $adminService) {
        $this->commonService = $commonService;
        $this->adminService=$adminService;
    }

    public function indexAction() {
        
    }

    public function dashboardAction() {
        $totalusercount = $this->getUserTable()->getInfo(array('is_active=1 && tbl_user_info.user_type_id!=0 && tbl_user_roles.IsMember!=0 || tbl_user_roles.IsMatrimonial!=0'));
        $totaluserpending = $this->getUserTable()->getInfo(array('is_active=1 && tbl_user_info.user_type_id!=0 && (tbl_user_roles.IsMember=0 && tbl_user_roles.IsMatrimonial=0)'));
        $totalIndiaUser = $this->getUserTable()->getInfo(array('is_active=1 && tbl_user_info.country=1 &&  tbl_user_info.user_type_id!=0 && tbl_user_roles.IsMember!=0 || tbl_user_roles.IsMatrimonial!=0'));
        
        $totalmembercount = $this->getUserTable()->getInfo(array('is_active=1 && tbl_user_info.user_type_id=1 && tbl_user_roles.IsMember!=0'));
        $totalmemberpending = $this->getUserTable()->getInfo(array('is_active=1 && tbl_user_info.user_type_id=1 &&  tbl_user_roles.IsMember=0'));
        $totalIndiamember = $this->getUserTable()->getInfo(array('is_active=1 && tbl_user_info.user_type_id=1 && tbl_user_info.country=1 &&  tbl_user_roles.IsMember!=0'));
        
        $matrimonyusercount = $this->getUserTable()->getInfo(array('is_active=1 && tbl_user_roles.IsMatrimonial!=0'));
        $matrimonyuserpending = $this->getUserTable()->getInfo(array('tbl_user_info.user_type_id=2 && is_active=0'));
        
        $BridesUser = $this->getUserTable()->getInfo(array("is_active=1 && tbl_user_info.gender='Female' && tbl_user_roles.IsMatrimonial!=0"));
        $BridesUserPending = $this->getUserTable()->getInfo(array('is_active=0 && tbl_user_info.user_type_id=2 && tbl_user_info.gender="Female" && tbl_user_roles.IsMatrimonial=0'));
        
        $GroomsUser = $this->getUserTable()->getInfo(array("is_active=1 && tbl_user_info.gender='Male' && tbl_user_roles.IsMatrimonial!=0"));
        $GroomsUserPending = $this->getUserTable()->getInfo(array('is_active=1 && tbl_user_info.user_type_id=2 && tbl_user_info.gender="Male" && tbl_user_roles.IsMatrimonial=0'));
        
        $totalcommunitymember = $this->getUserTable()->getInfo(array("tbl_user_info.user_type_id=3 && is_active=1"));
		 

        $members = array("Total Users" => array("World Members" => $totalusercount, "India Members" => $totalIndiaUser, "Pending Approvals" => $totaluserpending),
            "Member Users" => array("World Members" => $totalmembercount, "India Members" => $totalIndiamember, "Pending Approvals" => $totalmemberpending),
			"Matrimony Users" => array("Matrimoni Members" => $matrimonyusercount, "Brides" => $BridesUser, "Pending Brides" => $BridesUserPending, "Grooms" => $GroomsUser, "Pending Grooms" => $GroomsUserPending),
            "Brides Users" => array("Brides" => $BridesUser, "Pending Approvals" => $BridesUserPending),
            "Grooms Users" => array("Grooms" => $GroomsUser, "Pending Approvals" => $GroomsUserPending),
			 "Community User" => array("Totl Member" => $totalcommunitymember,),
        );
        // $TopNewUsers = $this->getUserinfoTable()->TopNew();

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        /*$TopNewUsers = $adapter->query("select tui.*,tbl_user.*,tbl_user.is_active as userstatus
         from tbl_user_info tui LEFT JOIN tbl_user on tui.user_id = tbl_user.id WHERE tui.user_type_id=1
         ORDER BY tui.user_id DESC limit 0, 10 ", Adapter::QUERY_MODE_EXECUTE);*/
        
         $TopNewUsers = $adapter->query("select tui.user_id,tui.user_type_id,tui.full_name,tui.address,tui.native_place,tui.membership_paid,tbl_user.*,tbl_user_roles.IsMember,tbl_user_roles.IsExecutive
         from tbl_user_info tui LEFT JOIN tbl_user on tui.user_id = tbl_user.id LEFT JOIN tbl_user_roles on tbl_user.id = tbl_user_roles.user_id WHERE tui.user_type_id=1
         ORDER BY tui.user_id DESC limit 0, 10", Adapter::QUERY_MODE_EXECUTE);
         
         /*$TopNewMatrimonials = $adapter->query("select tui.user_id,tui.full_name,ma.address,tui.native_place,tui.membership_paid,tbl_user_matrimonial.*,tbl_family_info_matrimonial.name,tbl_user_gallery_matrimonial.image_name,tbl_user_roles.IsMember,tbl_user_roles.IsExecutive
         from tbl_user_info_matrimonial tui LEFT JOIN tbl_user_matrimonial on tui.user_id = tbl_user_matrimonial.id 
		 LEFT JOIN tbl_family_info_matrimonial on tui.user_id = tbl_family_info_matrimonial.user_id 
		 LEFT JOIN tbl_user_gallery_matrimonial on tui.user_id = tbl_user_gallery_matrimonial.user_id 
         LEFT JOIN tbl_user_address_matrimonial ma on ma.user_id = tbl_user_matrimonial.id 
         LEFT JOIN tbl_user_roles on tbl_user_matrimonial.id = tbl_user_roles.user_id WHERE tbl_family_info_matrimonial.relation_id=1
         ORDER BY tui.user_id DESC limit 0, 10;", Adapter::QUERY_MODE_EXECUTE);*/
         
         $TopNewMatrimonials = $adapter->query("SELECT tui.user_id, tui.full_name, ma.address, tui.native_place, tui.membership_paid, um. * , fim.name, gm.image_name
                    FROM tbl_user_matrimonial um 
                    LEFT JOIN tbl_user_info_matrimonial tui ON um.id = tui.user_id
                    LEFT JOIN tbl_family_info_matrimonial fim ON um.id = fim.user_id
                    LEFT OUTER JOIN tbl_user_gallery_matrimonial gm ON gm.user_id = um.id
                    AND gm.id = (
                    SELECT gm1.id
                    FROM tbl_user_gallery_matrimonial gm1
                    WHERE gm1.user_id = um.id
                    AND gm1.image_name IS NOT NULL
                    AND gm1.user_type = 'U'
                    AND gm1.image_type =1
                    ORDER BY gm1.image_name ASC
                    LIMIT 1 )
                    LEFT JOIN tbl_user_address_matrimonial ma ON um.id = ma.user_id
                    WHERE fim.relation_id =1
                    ORDER BY tui.user_id DESC
                    LIMIT 0 , 10
                ", Adapter::QUERY_MODE_EXECUTE);

        return new ViewModel(array("Members" => $members, "TopNewUsers" => $TopNewUsers, "TopNewMatrimonials" => $TopNewMatrimonials));
    }
    
    //edit member dashboard...
    
    public function editAction()
    {   
        //$countryNameList = $this->adminService->getCountryList();
        //\Zend\Debug\Debug::dump($countryNameList);exit;
         
        //InstituteForm::$country_nameList = $countryNameList;
        
        //echo  "hello";exit;
        //$stateNameList = $this->adminService->getStateList();
       //\Zend\Debug\Debug::dump($stateNameList);exit;
        //InstituteForm::$state_nameList = $stateNameList;
        //$cityNameList = $this->adminService->getCityList();
        //\Zend\Debug\Debug::dump($regionNameList);exit;
        //InstituteForm::$city_nameList = $cityNameList;
        
        $form = new MemberdashboardForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
//             echo   $id;die;
            //$institute = $this->getInstituteTable()->getInstitute($id);
            $memberdashboard = $this->adminService->getMemberdashboardById($id);
//             print_r($memberdashboard);die;
            $form->bind($memberdashboard);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }
        
        $session = new \Zend\Session\Container('admin');
        $user_id = $session->offsetGet('id');
         $email_id = $session->offsetGet('email');
         $remote = new \Zend\Http\PhpEnvironment\RemoteAddress;
         $user_ip = $remote->getIpAddress();
         $user_data = array($user_id,$email_id,$user_ip);
         
        $request = $this->getRequest();
        if (!isset($_POST['chkedit'])) {
        if($request->isPost()){
            $mergedata = array_merge(
                    $this->getRequest()->getPost()->toArray() ,$user_data
            ); 
            $form->setData($mergedata);
            //$instituteEntity = new Institutes();

               //$form->setInputFilter(new InstituteFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$instituteEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getInstituteTable()->SaveInstitute($instituteEntity);
                $res = $this->adminService->SaveMemberdashboard($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'institute'
//                ));
                    $response = $this->getResponse();
                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                    $response->setContent(json_encode(array("response" => $res)));
                    return $response;
               } else {

                    foreach ($form->getmessages() as $key => $value) {
                        $errors[] = array("element" => $key, "errors" => $value['isEmpty']);
                    }

                    $response = $this->getResponse();
                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                    $response->setContent(json_encode(array("errors", $errors)));
                    return $response;
                }
        }
        
        }
        
      

        //return new ViewModel(array('form'=> $form,'id'=>$id));
        $view = new ViewModel(array('form' => $form, 'id' => $id));
        $view->setTerminal(true);
        return $view;

    }
    
    //edit matrimonial dashboard...
    
    public function editmatrimonialAction()
    {           
        $form = new MatrimonialdashboardForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
//             echo   $id;die;
            //$institute = $this->getInstituteTable()->getInstitute($id);
            $matrimonialdashboard = $this->adminService->getMatrimonialdashboardById($id);
//             print_r($matrimonialdashboard);die;
            $form->bind($matrimonialdashboard);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }
        
        $session = new \Zend\Session\Container('admin');
        $user_id = $session->offsetGet('id');
         $email_id = $session->offsetGet('email');
         $remote = new \Zend\Http\PhpEnvironment\RemoteAddress;
         $user_ip = $remote->getIpAddress();
         $user_data = array($user_id,$email_id,$user_ip);
         
        $request = $this->getRequest();
        if (!isset($_POST['chkedit'])) {
        if($request->isPost()){
            $mergedata = array_merge(
                    $this->getRequest()->getPost()->toArray() ,$user_data
            ); 
            $form->setData($mergedata);
            //$instituteEntity = new Institutes();

               //$form->setInputFilter(new InstituteFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$instituteEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getInstituteTable()->SaveInstitute($instituteEntity);
                $res = $this->adminService->SaveMatrimonialdashboard($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'institute'
//                ));
                    $response = $this->getResponse();
                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                    $response->setContent(json_encode(array("response" => $res)));
                    return $response;
               } else {

                    foreach ($form->getmessages() as $key => $value) {
                        $errors[] = array("element" => $key, "errors" => $value['isEmpty']);
                    }

                    $response = $this->getResponse();
                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                    $response->setContent(json_encode(array("errors", $errors)));
                    return $response;
                }
        }
        
        }
        
      

        //return new ViewModel(array('form'=> $form,'id'=>$id));
        $view = new ViewModel(array('form' => $form, 'id' => $id));
        $view->setTerminal(true);
        return $view;

    }
    //delete member...
    public function deleteAction()
    {
//         echo  "hello";exit;
            $id = $this->params()->fromRoute('id');
            //$institute = $this->getInstituteTable()->deleteInstitute($id);
            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        /*$TopNewUsers = $adapter->query("select tui.*,tbl_user.*,tbl_user.is_active as userstatus
         from tbl_user_info tui LEFT JOIN tbl_user on tui.user_id = tbl_user.id WHERE tui.user_type_id=1
         ORDER BY tui.user_id DESC limit 0, 10 ", Adapter::QUERY_MODE_EXECUTE);*/
        
         $TopNewUsers = $adapter->query("DELETE FROM tbl_user where id=$id", Adapter::QUERY_MODE_EXECUTE);
         
            return $this->redirect()->toRoute('admin/dashboard', array('action' => 'dashboard'));
    }
    
    //delete member...
    public function deletematrimonialAction()
    {
//         echo  "hello";exit;
            $id = $this->params()->fromRoute('id');
            //$institute = $this->getInstituteTable()->deleteInstitute($id);
            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        /*$TopNewUsers = $adapter->query("select tui.*,tbl_user.*,tbl_user.is_active as userstatus
         from tbl_user_info tui LEFT JOIN tbl_user on tui.user_id = tbl_user.id WHERE tui.user_type_id=1
         ORDER BY tui.user_id DESC limit 0, 10 ", Adapter::QUERY_MODE_EXECUTE);*/
        
         $TopNewUsers = $adapter->query("DELETE FROM tbl_user_matrimonial where id=$id", Adapter::QUERY_MODE_EXECUTE);
         
            return $this->redirect()->toRoute('admin/dashboard', array('action' => 'dashboard'));
    }
    
    public function changestatusAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
       $session = new \Zend\Session\Container('admin');
       $user_id = $session->offsetGet('id');
//       echo  "<pre>";
//        print_r($user_id);exit;
        //$data = (object) $_POST;
        $request=$this->getRequest();
        $id = $request->getPost('id');
        $status = $request->getPost('is_active');
        $modified_date = date("Y-m-d h:i:s");
//        echo  "<pre>";
//        print_r($status);exit;
        //$return = $this->getInstituteTable()->updatestatus($data);
        //$result = $this->adminService->changeStatus('tbl_user', $request->getPost('id'), $request->getPost(), $user_id);
//        echo  "hello";exit;
        $result = $adapter->query("UPDATE tbl_user SET is_active='". $status ."', modified_by='". $user_id ."', modified_date='". $modified_date ."' WHERE id='". $id ."' ", Adapter::QUERY_MODE_EXECUTE);
//         print_r($result);
////        echo  "hello";
//       exit;
        if ($result) {
            $respArr = array('status' => "Updated SuccessFully");
        } else {
            $respArr = array('status' => "Couldn't update");
        }
        
        return new JsonModel($respArr);
//        return $this->redirect()->toRoute('admin/dashboard', array('action' => 'dashboard'));
        //exit();
    }
    
    public function changematrimonialstatusAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
       $session = new \Zend\Session\Container('admin');
       $user_id = $session->offsetGet('id');
//       echo  "<pre>";
//        print_r($user_id);exit;
        //$data = (object) $_POST;
        $request=$this->getRequest();
        $id = $request->getPost('id');
        $status = $request->getPost('is_active');
        $modified_date = date("Y-m-d h:i:s");
//        echo  "<pre>";
//        print_r($status);exit;
        //$return = $this->getInstituteTable()->updatestatus($data);
        //$result = $this->adminService->changeStatus('tbl_user', $request->getPost('id'), $request->getPost(), $user_id);
//        echo  "hello";exit;
        $result = $adapter->query("UPDATE tbl_user_matrimonial SET is_active='". $status ."', modified_by='". $user_id ."', modified_date='". $modified_date ."' WHERE id='". $id ."' ", Adapter::QUERY_MODE_EXECUTE);
//         print_r($result);
////        echo  "hello";
//       exit;
        if ($result) {
            $respArr = array('status' => "Updated SuccessFully");
        } else {
            $respArr = array('status' => "Couldn't update");
        }
        return new JsonModel($respArr);
//        return $this->redirect()->toRoute('admin/dashboard', array('action' => 'dashboard'));
        //exit();
    }
    
    public function viewByMemberIdAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        
        $id = $this->params()->fromRoute('id');
//        echo  "<pre>";
//        print_r($id);exit;
        //$Info = $this->getCountryTable()->getCountry($id);
        //$info = $this->getInstituteTable()->getInstitute($id);
//        $info = $this->instituteService->viewByInstituteId('tbl_rustagi_institutions', $id);
        $sql="select tui.user_id,tui.full_name,tui.address,tui.native_place,tui.membership_paid,tbl_user.* from tbl_user_info tui "
                . "LEFT JOIN tbl_user on tui.user_id = tbl_user.id WHERE tui.user_type_id=1 AND tbl_user.id='". $id ."'";
        $info = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        
        //echo  "<pre>";
        //\Zend\Debug\Debug::dump($info);exit;

        // echo"<pre>"; print_r($Info);die;
        $view = new ViewModel(array('info'=>$info));
        $view->setTerminal(true);
        return $view;
        
        
        
    }
    
    public function viewByMatrimonialIdAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        
        $id = $this->params()->fromRoute('id');
//        echo  "<pre>";
//        print_r($id);exit;
        //$Info = $this->getCountryTable()->getCountry($id);
        //$info = $this->getInstituteTable()->getInstitute($id);
//        $info = $this->instituteService->viewByInstituteId('tbl_rustagi_institutions', $id);
        /*$sql="select tui.user_id,tui.full_name,tui.address,tui.native_place,tui.membership_paid,tbl_user_matrimonial.* from tbl_user_info_matrimonial tui "
                . "LEFT JOIN tbl_user_matrimonial on tui.user_id = tbl_user_matrimonial.id WHERE tbl_user_matrimonial.id='". $id ."'";*/
        
        $sql="SELECT tui.user_id, tui.full_name, ma.address, tui.native_place, tui.membership_paid, um. * , fim.name, gm.image_name
                    FROM tbl_user_matrimonial um 
                    LEFT JOIN tbl_user_info_matrimonial tui ON um.id = tui.user_id
                    LEFT JOIN tbl_family_info_matrimonial fim ON um.id = fim.user_id
                    LEFT OUTER JOIN tbl_user_gallery_matrimonial gm ON gm.user_id = um.id
                    AND gm.id = (
                    SELECT gm1.id
                    FROM tbl_user_gallery_matrimonial gm1
                    WHERE gm1.user_id = um.id
                    AND gm1.image_name IS NOT NULL
                    AND gm1.user_type = 'U'
                    AND gm1.image_type =1
                    ORDER BY gm1.image_name ASC
                    LIMIT 1 )
                    LEFT JOIN tbl_user_address_matrimonial ma ON um.id = ma.user_id
                    WHERE fim.relation_id =1 AND um.id='".$id."'
                    ORDER BY tui.user_id DESC
                    LIMIT 0 , 10
            ";
        
        $info = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        
        //echo  "<pre>";
        //\Zend\Debug\Debug::dump($info);exit;

        // echo"<pre>"; print_r($Info);die;
        $view = new ViewModel(array('info'=>$info));
        $view->setTerminal(true);
        return $view;
        
        
        
    }
    

    public function loginAction() {

        if ($this->getRequest()->isPost()) {

            $request = $this->getRequest();

            $username = $request->getPost('username');

            $login_password = md5($request->getPost('userpass'));



            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

            $QUERY = "SELECT tbl_admin_login.* FROM tbl_admin_login

		WHERE tbl_admin_login.username='$username'  AND tbl_admin_login.password='$login_password' ";

            $user = $adapter->query($QUERY, Adapter::QUERY_MODE_EXECUTE);


            if ($user->count()) {

                $result = $user->current();

                if (!empty($result)) {

                    $admin_session = new Container('admin');

                    foreach ($user->current() as $u => $v)
                        $admin_session->offsetSet($u, $v);

                    // echo "test";die; 
                    return $this->redirect()->toRoute('admin', array(
                                'controller' => 'admin',
                                'action' => 'dashboard'));
                }
            } else {

                return $this->redirect()->toRoute('admin', array(
                            'controller' => 'admin',
                            'action' => 'index'
                ));
            }
        }

        return new ViewModel();
    }

    public function logoutAction() {

        $auth = new AuthenticationService();



        $auth->clearIdentity();

        session_destroy();

        return $this->redirect()->toRoute('admin', array('controller' => 'admin', 'action' => 'index'));
    }

//    public function changestatusAction() {
//
//        $data = (object) $_POST;
//        $return = $this->getUserTable()->updatestatus($data);
//        // print_r($return);
//        return new JsonModel($return);
//        // print_r($_POST);
//        //exit();
//    }

    public function sendotpAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $chkuser = $adapter->query("select * from `tbl_admin_login` where mobile_no=" . $_POST['number'] . "", Adapter::QUERY_MODE_EXECUTE);

        foreach ($chkuser as $user) {
            $userid = $user->id;
        }

        $size = $chkuser->count();
        if ($size == 1) {
            $number = $_POST['number'];
            $code = rand(1111, 9999);
            date_default_timezone_set('Asia/Kolkata');
            $time = date('H:i');

            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $adapter->query(" insert into `tbl_mobile`(`user_id`, `mobile`, `time`, `code`) VALUES ($userid,$number,'" . $time . "',$code)", Adapter::QUERY_MODE_EXECUTE);

            $arrdef = $adapter->query("select * from tbl_sms_template where msg_sku='forgot_password'", Adapter::QUERY_MODE_EXECUTE);

            // $link="http://".$_SERVER['HTTP_HOST']. $_SERVER['PHP_SELF']."login/index/resetpassword?id=$token"
            // $msg_query=mysqli_fetch_array($res);
            foreach ($arrdef as $arr) {
                $msg = $arr->message;
            }
            $array = explode('<variable>', $msg);
            $array[0] = $array[0] . $number;
            $array[1] = $array[1] . $code;
            $text = rawurlencode(implode("", $array));
            // echo $time;
            file_put_contents("mssg.txt", $text);
            $succarr = array("userid" => $userid, "time" => $time, "mobile" => $number, "code" => $code);



            $url = "http://push3.maccesssmspush.com/servlet/com.aclwireless.pushconnectivity.listeners.TextListener?userId=helloalt&pass=helloalt&appid=helloalt&subappid=helloalt&msgtype=1&contenttype=1&selfid=true&to=$number&from=Helocb&dlrreq=true&text=$text&alert=1";
            file_get_contents($url);
            // print_r($arrdef);
            // die;


            $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
            $response->setContent(json_encode(array('resp' => 1, 'success' => $succarr)));

            return $response;
        } else {
            $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
            $response->setContent(json_encode(array("resp" => 0, "error" => "sorry your number doesn't exists")));

            return $response;
        }

        exit();
    }

    public function confirmotpAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $arrdef = $adapter->query("select * from tbl_mobile where (code=" . $_POST['otp'] . " && mobile=" . $_POST['number'] . " &&
        time='" . $_POST['time'] . "')", Adapter::QUERY_MODE_EXECUTE);
        $size = $arrdef->count();

        foreach ($arrdef as $user) {
            $userid = $user->user_id;
        }
        $succarr = array("userid" => $userid);


        if ($size == 1) {
            $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
            $response->setContent(json_encode(array("resp" => 1, "success" => $succarr)));

            return $response;
        } else {
            $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
            $response->setContent(json_encode(array("resp" => 0, "error" => "otp doesn't match")));

            return $response;
        }
        exit();
    }

    public function chgpassAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');



        if ($_POST["pass"] != $_POST["rpass"]) {
            $response->setContent(json_encode(array("resp" => 0, "error" => "password doesn't match please try again")));
        } else {

            $pass = md5($_POST["pass"]);

            $arrdef = $adapter->query("update tbl_admin_login set password='" . $pass . "' where (id='" . $_POST['userid'] . "')", Adapter::QUERY_MODE_EXECUTE);

            $response->setContent(json_encode(array("resp" => 1, "success" => "password changed successfully please login to continue")));
        }
        return $response;
    }

//     public function SendMailAction()
//     {
// //     	$message = new \Zend\Mail\Message();
// // $message->setBody('This is the body');
// // $message->setFrom('myemail@mydomain.com');
// // $message->addTo('phpdevp22@gmail.com');
// // $message->setSubject('Test subject');
// // $smtpOptions = new \Zend\Mail\Transport\SmtpOptions();  
// // $smtpOptions->setHost('smtp.gmail.com')
// //             ->setConnectionClass('login')
// //             ->setName('smtp.gmail.com')
// //             ->setConnectionConfig(array(
// //                 'username' => 'funstartswithyou15@gmail.com',
// //                 'password' => 'watchmyvideos',
// //                 'ssl' => 'tls',
// //             ));
// // $transport = new \Zend\Mail\Transport\Smtp($smtpOptions);
// // $transport->send($message);
//     	// setup SMTP options  
// $options = new Mail\Transport\SmtpOptions(array(  
//             'name' => 'localhost',  
//             'host' => 'smtp.gmail.com',  
//             'port'=> 587,  
//             'connection_class' => 'login',  
//             'connection_config' => array(  
//                 'username' => 'funstartswithyou15@gmail.com',  
//                 'password' => 'watchmyvideos',  
//                 'ssl'=> 'tls',  
//             ),  
// ));  
// $fileContents = fopen("/usr/share/pixmaps/faces/sky.jpg", 'r');
// $attachment = new Mime\Part($fileContent);
// $attachment->type = 'image/jpg';
// $attachment->disposition = Mime\Mime::DISPOSITION_ATTACHMENT;
// // $this->renderer = $this->getServiceLocator()->get('ViewRenderer');  
// $content = "gdgdfgdfgdfgddfg";  
// // make a header as html  
// $html = new MimePart($content);  
// $html->type = "text/html";  
// $body = new MimeMessage();  
// $body->setParts(array($html,$attachment));  
// // instance mail   
// $mail = new Mail\Message();  
// $mail->setBody($body); // will generate our code html from template.phtml  
// $mail->setFrom('munanshu.madaank23@gmail.com','Sender Name');  
// $mail->setTo('phpdevp22@gmail.com');  
// $mail->setSubject('Your Subject');  
// $transport = new Mail\Transport\Smtp($options);  
// $transport->send($mail);
// 	die;
//     }	      
}
