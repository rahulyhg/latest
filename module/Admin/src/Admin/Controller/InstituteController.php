<?php

namespace Admin\Controller;

use Admin\Form\InstituteFilter;
use Admin\Form\InstituteForm;
use Admin\Model\Entity\Institutes;
use Admin\Service\InstituteServiceInterface;
use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class InstituteController extends AppController
{
    protected $data = '';//array();
    protected $commonService;
    protected $adminService;
    protected $instituteService;

    public function __construct(CommonServiceInterface $commonService, AdminServiceInterface $adminService, InstituteServiceInterface $instituteService) {
        $this->commonService = $commonService;
        $this->adminService=$adminService;
        $this->instituteService=$instituteService;
    }
    
    public function indexAction()
    {   //echo  "hello";exit;
//        $data = $this->instituteService->test();
//        echo  $data;exit;
         //$institutes = $this->getInstituteTable()->fetchAll($this->data);
         $institutes = $this->instituteService->getInstituteList()->toArray();
         
         $countryNameList = $this->adminService->getCountryList();
        //\Zend\Debug\Debug::dump($countryNameList);exit;
         
        InstituteForm::$country_nameList = $countryNameList;
        
        //echo  "hello";exit;
        $stateNameList = $this->adminService->getStateList();
       //\Zend\Debug\Debug::dump($stateNameList);exit;
        InstituteForm::$state_nameList = $stateNameList;
        $cityNameList = $this->adminService->getCityList();
        //\Zend\Debug\Debug::dump($regionNameList);exit;
        InstituteForm::$city_nameList = $cityNameList;
        
        $memberList = $this->instituteService->getallMember();
        //\Zend\Debug\Debug::dump($memberList);exit;
        InstituteForm::$member_List = $memberList;
//            echo   "<pre>";
//          print_r($institutes);die;
          //print_r($cities);die;
		 
		   
		$form = new InstituteForm();
         $form->get('submit')->setAttribute('value', 'Add');
         $filters_data = $this->getCountries();
         
        return new ViewModel(array(
            'institutes' => $institutes,'form'=> $form, 'action'=>'index', "filters_data" => $filters_data));
        echo "hello";exit;
			
    }

    public function AddAction()
    {   //echo  "hello";exit;
        $countryNameList = $this->adminService->getCountryList();
        //\Zend\Debug\Debug::dump($countryNameList);exit;
         
        InstituteForm::$country_nameList = $countryNameList;
        
        //echo  "hello";exit;
        $stateNameList = $this->adminService->getStateList();
       //\Zend\Debug\Debug::dump($stateNameList);exit;
        InstituteForm::$state_nameList = $stateNameList;
        $cityNameList = $this->adminService->getCityList();
        //\Zend\Debug\Debug::dump($regionNameList);exit;
        InstituteForm::$city_nameList = $cityNameList;
        
        $memberList = $this->instituteService->getallMember();
        //\Zend\Debug\Debug::dump($memberList);exit;
        InstituteForm::$member_List = $memberList;
        
        
        $form = new InstituteForm();
        $form->get('submit')->setAttribute('value', 'Add');
        
        $session = new \Zend\Session\Container('admin');
        $user_id = $session->offsetGet('id');
         $email_id = $session->offsetGet('email');
         $remote = new \Zend\Http\PhpEnvironment\RemoteAddress;
         $user_ip = $remote->getIpAddress();
         $user_data = array($user_id,$email_id,$user_ip);
         
        $request = $this->getRequest();
        if($request->isPost()){
            
            //\Zend\Debug\Debug::dump($request->getPost());exit;
            
             $mergedata = array_merge(
                    $this->getRequest()->getPost()->toArray() ,$user_data
            ); 
            $form->setData($mergedata);
            //$instituteEntity = new Institutes();

               //$form->setInputFilter(new InstituteFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$instituteEntity->exchangeArray($form->getData());
                // print_r($instituteEntity);die;
                //$res = $this->getInstituteTable()->SaveInstitute($instituteEntity);
                $res = $this->instituteService->SaveInstitute($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'institute'
//                ));
                return new JsonModel(array("response" => $res));
               } else {

                foreach ($form->getmessages() as $key => $value) {
                    $errors[] = array("element" => $key, "errors" => $value['isEmpty']);
                }
                return new JsonModel(array("errors" => $errors, "FormId" => $_POST['FormId']));
            }
        }

        return new ViewModel(array('form'=> $form));
        
    }

    public function editAction()
    {   
        $countryNameList = $this->adminService->getCountryList();
        //\Zend\Debug\Debug::dump($countryNameList);exit;
         
        InstituteForm::$country_nameList = $countryNameList;
        
        //echo  "hello";exit;
        $stateNameList = $this->adminService->getStateList();
       //\Zend\Debug\Debug::dump($stateNameList);exit;
        InstituteForm::$state_nameList = $stateNameList;
        $cityNameList = $this->adminService->getCityList();
        //\Zend\Debug\Debug::dump($regionNameList);exit;
        InstituteForm::$city_nameList = $cityNameList;
        
        $form = new InstituteForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            //$institute = $this->getInstituteTable()->getInstitute($id);
            $institute = $this->instituteService->getInstitute($id);
            // print_r($institute);die;
            $form->bind($institute);
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
                $res = $this->instituteService->SaveInstitute($mergedata);

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

    public function deleteAction()
    {
         
            $id = $this->params()->fromRoute('id');
            //$institute = $this->getInstituteTable()->deleteInstitute($id);
            $institute = $this->adminService->delete('tbl_rustagi_institutions', $id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'institute'
//                ));
            return $this->redirect()->toRoute('admin/institute', array('action' => 'index'));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getInstituteTable()->getInstitute($id);

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function viewByIdAction(){
        
        $id = $this->params()->fromRoute('id');

        //$Info = $this->getCountryTable()->getCountry($id);
        //$info = $this->getInstituteTable()->getInstitute($id);
        $info = $this->instituteService->viewByInstituteId('tbl_rustagi_institutions', $id);

        // echo"<pre>"; print_r($Info);die;
        $view=new ViewModel(array('info'=>$info));
        $view->setTerminal(true);
        return $view;
        
    }
    
    public function changestatusAction() {
       $session = new \Zend\Session\Container('admin');
       $user_id = $session->offsetGet('id');
        //$data = (object) $_POST;
        $request=$this->getRequest();
        //$return = $this->getInstituteTable()->updatestatus($data);
        $result = $this->adminService->changeStatus('tbl_rustagi_institutions', $request->getPost('id'), $request->getPost(), $user_id);
        // print_r($return);
        return new JsonModel($result);
        //exit();
    }
    
    public function delmultipleAction() {
        $ids = $_POST['chkdata'];
        //$result = $this->getInstituteTable()->delmultiple($ids);
        $result = $this->adminService->deleteMultiple('tbl_rustagi_institutions', $ids);

        echo $result;
        exit();
    }
    
    public function changeStatusAllAction() {
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $sql = "update tbl_rustagi_institutions set IsActive=" . $_POST['val'] . " where id IN (" . $_POST['ids'] . ")";
//        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $result = $this->adminService->changeStatusAll('tbl_rustagi_institutions', $_POST['ids'], $_POST['val']);
        if ($result)
            echo "updated all";
        else
            echo "couldn't update";
        exit();
        //return new JsonModel($result);
    }
    
    public function ajaxradiosearchAction() {
        $status = $_POST['is_active'];
//        echo   "<pre>";
//        print_r($status);exit;
        //$this->data = array("IsActive=$status");
        if($status==1){
        $this->data = $status;

        //$institutes = $this->getInstituteTable()->fetchAll($this->data);
        $institutes = $this->instituteService->getInstituteRadioList($_POST['is_active'])->toArray();
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('institutes' => $institutes));
        $view->setTemplate('admin/institute/instituteList');
        $view->setTerminal(true);
        return $view;
        }  else {
            $this->data = $status;

        //$institutes = $this->getInstituteTable()->fetchAll($this->data);
        $institutes = $this->instituteService->getInstituteRadioList($_POST['is_active']);
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('institutes' => $institutes));
        $view->setTemplate('admin/institute/instituteList');
        $view->setTerminal(true);
        return $view;
        }
    }
    
    public function performsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        //$field1 = empty($_POST['institute_name']) ? "" : "institute_name like '" . $_POST['institute_name'] . "%'";
        
        //$sql = "select * from tbl_rustagi_institutions where " . $field1 . "";
       // $sql = rtrim($sql, "&&");
        //$results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        /*$results = $this->instituteService->performSearchInstitute($_POST['institute_name']);

        $view = new ViewModel(array("results" => $results));
        $view->setTerminal(true);
        return $view;


        exit();*/
        if(isset($_POST['Country_id']) && isset($_POST['State_id']) && isset($_POST['City_id']) && isset($_POST['Institute_id'])){
//            
            $results1 = $this->instituteService->getInstituteByInstituteId('tbl_rustagi_institutions',$_POST['Institute_id']);
//            echo "<pre>";
//            print_r($results1);exit;

            $view = new ViewModel(array("results" => $results1));
            $view->setTerminal(true);
            return $view;
            
        }
        
        if(isset($_POST['Country_id']) && isset($_POST['State_id']) && isset($_POST['City_id'])){
//            
            $results2 = $this->instituteService->getInstituteByInstituteCityId('tbl_rustagi_institutions',$_POST['City_id']);
//            echo "<pre>";
//            print_r($results1);exit;

            $view = new ViewModel(array("results" => $results2));
            $view->setTerminal(true);
            return $view;
            
        }
        
        if(!isset($_POST['Country_id']) || !isset($_POST['State_id']) || !isset($_POST['City_id'])){
//            
            $results3 = $this->instituteService->getInstituteByInstituteCityId('tbl_rustagi_institutions',$_POST['City_id']);
//            echo "<pre>";
//            print_r($results1);exit;

            $view = new ViewModel(array("results" => $results3));
            $view->setTerminal(true);
            return $view;
            
        }
    }
    
    public function institutesearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
//        echo  "<pre>";
//        print_r($data);die;

        //$result = $adapter->query("select * from tbl_rustagi_institutions where institute_name like '$data%' ", Adapter::QUERY_MODE_EXECUTE);
        $result = $this->instituteService->instituteSearch($data);


        $view = new ViewModel(array("Results" => $result));
        $view->setTerminal(true);
        return $view;
        exit();
    }
    
    public function getCountries() {
//        echo  "<pre>";
//        echo "hello";exit;
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $filters_array = array("country" => "tbl_country", "profession" => "tbl_profession", "city" => "tbl_city"
//            , "state" => "tbl_state", "education_level" => "tbl_education_field", "designation" => "tbl_designation"
//            , "height" => "tbl_height");
//        foreach ($filters_array as $key => $table) {
//            $filters_data[$key] = $adapter->query("select * from " . $table . "", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
//        }
        
        $filters_data = $this->adminService->getCountriesList();
//        \Zend\Debug\Debug::dump($filters_data);
//        exit;
        return $filters_data;
    }
    
    public function getInstituteNameAction() {
//        $Request = $this->getRequest();
//        if ($Request->isPost()) {
//            $State_ID = $Request->getPost("State_ID");
            $City_ID = $_POST['City_ID'];
//            $city_name = $this->getCityTable()->getCityListByStateCode($State_ID);
            $institute_name = $this->instituteService->getInstituteListByCityCode($City_ID);
            //\Zend\Debug\Debug::dump($branch_name);exit;
            if (count($institute_name))
                return new JsonModel(array("Status" => "Success", "citylist" => $institute_name));
            else
                return new JsonModel(array("Status" => "Failed", "citylist" => NULL));
       // }
    }
   
}