<?php

namespace Admin\Controller;

use Admin\Form\BranchFilter;
use Admin\Form\BranchForm;
use Admin\Model\Entity\Branchs;
use Admin\Service\BranchServiceInterface;
use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class BranchController extends AppController
{
    protected $data = '';//array();
    protected $commonService;
    protected $adminService;
    protected $branchService;

    public function __construct(CommonServiceInterface $commonService, AdminServiceInterface $adminService, BranchServiceInterface $branchService) {
        $this->commonService = $commonService;
        $this->adminService=$adminService;
        $this->branchService=$branchService;
    }
    
    public function indexAction()
    {   //echo  "hello amir";exit;
//        $data = $this->branchService->test();
//        echo  $data;exit;
         //$branchs = $this->getBranchTable()->fetchAll($this->data);
         $branchs = $this->branchService->getBranchList()->toArray();
            //echo   "<pre>";
          //print_r($branchs);die;
         // print_r($cities);die;
         $countryNameList = $this->adminService->getCountryList();
        //\Zend\Debug\Debug::dump($countryNameList);exit;
         
        BranchForm::$country_nameList = $countryNameList;
        
        //echo  "hello";exit;
        $stateNameList = $this->adminService->getStateList();
       //\Zend\Debug\Debug::dump($stateNameList);exit;
        BranchForm::$state_nameList = $stateNameList;
        $cityNameList = $this->adminService->getCityList();
        //\Zend\Debug\Debug::dump($regionNameList);exit;
        BranchForm::$city_nameList = $cityNameList;
		   
		$form = new BranchForm();
         $form->get('submit')->setAttribute('value', 'Add');
         $filters_data = $this->getCountries();

        return new ViewModel(array(
            'branchs' => $branchs,'form'=> $form, 'action'=>'index', "filters_data" => $filters_data));
			
    }

    public function AddAction()
    {
        $countryNameList = $this->adminService->getCountryList();
        //\Zend\Debug\Debug::dump($regionNameList);exit;
        BranchForm::$country_nameList = $countryNameList;
        
        $stateNameList = $this->adminService->getStateList();
        //\Zend\Debug\Debug::dump($regionNameList);exit;
        BranchForm::$state_nameList = $stateNameList;
        $cityNameList = $this->adminService->getCityList();
        //\Zend\Debug\Debug::dump($regionNameList);exit;
       BranchForm::$city_nameList = $cityNameList;
    
        $form = new BranchForm();
        
        $form->get('submit')->setAttribute('value', 'Add');
        
        $session = new \Zend\Session\Container('admin');
        $user_id = $session->offsetGet('id');
         $email_id = $session->offsetGet('email');
         $remote = new \Zend\Http\PhpEnvironment\RemoteAddress;
         $user_ip = $remote->getIpAddress();
         $user_data = array($user_id,$email_id,$user_ip);
         
         $request = $this->getRequest();
         
         if($request->isPost()){
            $mergedata = array_merge(
                    $this->getRequest()->getPost()->toArray() ,$user_data
            ); 
            $form->setData($mergedata);
            //$branchEntity = new Branchs();

               $form->setInputFilter(new BranchFilter());
                $form->getInputFilter()->get("country")->setRequired(FALSE);
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$branchEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getBranchTable()->SaveBranch($branchEntity);
                $res = $this->branchService->SaveBranch($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'branch'
//                ));
                $response = $this->getResponse();
                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                    $response->setContent(json_encode(array("response" => $res)));
                    return $response;
                   
               }  /*else {

                    foreach ($form->getmessages() as $key => $value) {
                        $errors[] = array("element" => $key, "errors" => $value['isEmpty']);
                    }

                    $response = $this->getResponse();
                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                    $response->setContent(json_encode(array("errors", $errors)));
                    return $response;
                }*/
        }
         
         
         

        $view = new ViewModel(array('form' => $form));
        $view->setTerminal(true);
        return $view;
        
    }

    public function editAction()
    {
        $countryNameList = $this->adminService->getCountryList();
        //\Zend\Debug\Debug::dump($regionNameList);exit;
        BranchForm::$country_nameList = $countryNameList;
        
        $stateNameList = $this->adminService->getStateList();
        //\Zend\Debug\Debug::dump($regionNameList);exit;
        BranchForm::$state_nameList = $stateNameList;
        $cityNameList = $this->adminService->getCityList();
        //\Zend\Debug\Debug::dump($regionNameList);exit;
       BranchForm::$city_nameList = $cityNameList;
        
        $form = new BranchForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            //$branch = $this->getBranchTable()->getBranch($id);
            $branch = $this->branchService->getBranch($id);
//             print_r($branch);die;
            $form->bind($branch);
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
            //$branchEntity = new Branchs();

               //$form->setInputFilter(new BranchFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$branchEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getBranchTable()->SaveBranch($branchEntity);
                $res = $this->branchService->SaveBranch($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'branch'
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
            //echo $id;exit;
            //$branch = $this->getBranchTable()->deleteBranch($id);
            $branch = $this->branchService->delete('tbl_rustagi_branches', $id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'branch'
//                ));
            return $this->redirect()->toRoute('admin/branch', array('action' => 'index'));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getBranchTable()->getBranch($id);

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function viewByIdAction(){
        
        $id = $this->params()->fromRoute('id');

        //$Info = $this->getCountryTable()->getCountry($id);
        //$info = $this->getBranchTable()->getBranch($id);
        $info = $this->branchService->viewByBranchId('tbl_rustagi_branches', $id);

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
        //$return = $this->getBranchTable()->updatestatus($data);
        $result = $this->branchService->changeStatus('tbl_rustagi_branches', $request->getPost('id'), $request->getPost(), $user_id);
        // print_r($return);
        return new JsonModel($result);
        //exit();
    }
    
    public function delmultipleAction() {
        $ids = $_POST['chkdata'];
        //$result = $this->getBranchTable()->delmultiple($ids);
        $result = $this->branchService->deleteMultiple('tbl_rustagi_branches', $ids);

        echo $result;
        exit();
    }
    
    public function changeStatusAllAction() {
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $sql = "update tbl_rustagi_branches set IsActive=" . $_POST['val'] . " where id IN (" . $_POST['ids'] . ")";
//        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $result = $this->branchService->changeStatusAll('tbl_rustagi_branches', $_POST['ids'], $_POST['val']);
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

        //$branchs = $this->getBranchTable()->fetchAll($this->data);
        $branchs = $this->branchService->getBranchRadioList($_POST['is_active'])->toArray();
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('branchs' => $branchs));
        $view->setTemplate('admin/branch/branchList');
        $view->setTerminal(true);
        return $view;
        }  else {
            $this->data = $status;

        //$branchs = $this->getBranchTable()->fetchAll($this->data);
        $branchs = $this->branchService->getBranchRadioList($_POST['is_active']);
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('branchs' => $branchs));
        $view->setTemplate('admin/branch/branchList');
        $view->setTerminal(true);
        return $view;
        }
    }
    
//    public function performsearchAction() {
//        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//
//        //$field1 = empty($_POST['branch_name']) ? "" : "branch_name like '" . $_POST['branch_name'] . "%'";
//        
//        //$sql = "select * from tbl_rustagi_branches where " . $field1 . "";
//       // $sql = rtrim($sql, "&&");
//        //$results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
//        $results = $this->branchService->performSearchBranch($_POST['branch_name']);
//
//        $view = new ViewModel(array("results" => $results));
//        $view->setTerminal(true);
//        return $view;
//
//
//        exit();
//    }
    
    public function performsearchAction() {      
         //echo   "hello";exit;
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
       /* if(isset($_POST['Country_id']) && !isset($_POST['State_id'])){
//             $sql = "SELECT * FROM tbl_state WHERE country_id=".$_POST['Country_id']."";
//            $results = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
//            $resultSet=new \Zend\Db\ResultSet\ResultSet();
//            $resultSet->initialize($results);
           //return $results;
//            $i=0;
//            $data = array();
//            foreach($results as $result){
//               
//               $data[$i] = $result->id;
//               
//                $i++;
//            }
//            
//             $states_id = implode(',',$data);
            //echo  "<pre>";
            //print_r($data2);
            
            //exit;


//            $sql2 = "SELECT tbl_city.*,tbl_state.state_name FROM tbl_city INNER JOIN tbl_state ON "
//                    . "tbl_city.state_id=tbl_state.id where tbl_city.state_id IN($states_id)";
//            $results1 = $adapter->query($sql2, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            $results1 = $this->branchService->getBranchListByCountry($_POST['Country_id']);
//            echo  "<pre>";print_r($results1);
//            exit;

            $view = new ViewModel(array("results" => $results1));
            $view->setTerminal(true);
            return $view;
            
        }*/
        
        /*if(isset($_POST['Country_id']) && isset($_POST['State_id']) && !isset($_POST['City_id'])){
            
//            $sql3 = "SELECT tbl_city.*,tbl_state.state_name FROM tbl_city INNER JOIN tbl_state ON "
//                    . "tbl_city.state_id=tbl_state.id where tbl_city.state_id=".$_POST['State_id']."";
//            $results2 = $adapter->query($sql3, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            $results2 = $this->adminService->getCityListByState($_POST['State_id']);
//            echo  "<pre>";print_r($results);
//            exit;

            $view = new ViewModel(array("results" => $results2));
            $view->setTerminal(true);
            return $view;
            
        }*/
        
        /*if(isset($_POST['Country_id']) && isset($_POST['State_id']) && isset($_POST['City_id']) && !isset($_POST['Branch_id'])){
            
            $sql4 = "SELECT tbl_city.*,tbl_state.state_name FROM tbl_city INNER JOIN tbl_state ON "
                    . "tbl_city.state_id=tbl_state.id where tbl_city.id=".$_POST['City_id']."";
//            $results3 = $adapter->query($sql4, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            $results3 = $this->adminService->getCityListByCity($_POST['City_id']);
//            echo  "<pre>";print_r($results);
//            exit;

            $view = new ViewModel(array("results" => $results3));
            $view->setTerminal(true);
            return $view;
            
        }*/
        
         /*if(isset($_POST['Country_id']) && isset($_POST['State_id']) && isset($_POST['City_id']) && isset($_POST['Branch_id'])){
            
            $sql4 = "SELECT tbl_city.*,tbl_state.state_name FROM tbl_city INNER JOIN tbl_state ON "
                    . "tbl_city.state_id=tbl_state.id where tbl_city.id=".$_POST['City_id']."";
//            $results3 = $adapter->query($sql4, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            $results4 = $this->adminService->getCityListByCity($_POST['City_id']);
//            echo  "<pre>";print_r($results);
//            exit;

            $view = new ViewModel(array("results" => $results4));
            $view->setTerminal(true);
            return $view;
            
        }*/
        
        
        if(isset($_POST['Country_id']) && isset($_POST['State_id']) && isset($_POST['City_id']) && isset($_POST['Branch_id'])){
//            
            $results1 = $this->branchService->getBranchByBranchId('tbl_rustagi_branches',$_POST['Branch_id']);
//            echo "<pre>";
//            print_r($results1);exit;

            $view = new ViewModel(array("results" => $results1));
            $view->setTerminal(true);
            return $view;
            
        }
        
        if(isset($_POST['Country_id']) && isset($_POST['State_id']) && isset($_POST['City_id'])){
//            
            $results2 = $this->branchService->getBranchByBranchCityId('tbl_rustagi_branches',$_POST['City_id']);
//            echo "<pre>";
//            print_r($results1);exit;

            $view = new ViewModel(array("results" => $results2));
            $view->setTerminal(true);
            return $view;
            
        }
        
        if(!isset($_POST['Country_id']) || !isset($_POST['State_id']) || !isset($_POST['City_id'])){
//            
            $results3 = $this->branchService->getBranchByBranchCityId('tbl_rustagi_branches',$_POST['City_id']);
//            echo "<pre>";
//            print_r($results1);exit;

            $view = new ViewModel(array("results" => $results3));
            $view->setTerminal(true);
            return $view;
            
        }
        
       
    }
    
    public function branchsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
//        echo  "<pre>";
//        print_r($data);die;

        //$result = $adapter->query("select * from tbl_rustagi_branches where branch_name like '$data%' ", Adapter::QUERY_MODE_EXECUTE);
        $result = $this->branchService->branchSearch($data);


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
    
    public function getBranchNameAction() {
//        $Request = $this->getRequest();
//        if ($Request->isPost()) {
//            $State_ID = $Request->getPost("State_ID");
            $City_ID = $_POST['City_ID'];
//            $city_name = $this->getCityTable()->getCityListByStateCode($State_ID);
            $branch_name = $this->branchService->getBranchListByCityCode($City_ID);
            //\Zend\Debug\Debug::dump($branch_name);exit;
            if (count($branch_name))
                return new JsonModel(array("Status" => "Success", "citylist" => $branch_name));
            else
                return new JsonModel(array("Status" => "Failed", "citylist" => NULL));
       // }
    }
   
}