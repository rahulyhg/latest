<?php

namespace Admin\Controller;

use Admin\Form\StateFilter;
use Admin\Form\StateForm;
use Admin\Model\Entity\States;
use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class StateController extends AppController
{
    protected $data = '';//array();
     protected $commonService;
    protected $adminService;

    public function __construct(CommonServiceInterface $commonService, AdminServiceInterface $adminService) {
        $this->commonService = $commonService;
        $this->adminService=$adminService;
    }
    
    public function indexAction()
    {               
//         $states = $this->getStateTable()->fetchAll();
         $states = $this->adminService->getStatesList()->toArray();
//          echo   "<pre>";
//          print_r($states);exit;
        //$countryNameList = $this->getCountryTable()->customFields(array('id','country_name'));
        $countryNameList = $this->adminService->customFields();
//        echo  "<pre>";
//                print_r($countryNameList);exit;
		  StateForm::$country_nameList = $countryNameList;
//          $action = $this->getRequest()->getUri()."/searchboxresults";
//         StateForm::$actionName = $action;
		$form = new StateForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'states' => $states,'form'=> $form, 'action'=>'index'));
//        return new ViewModel(array(
//            'countries' => $countries, 'form' => $form, 'action'=>'index'));
    }
    
//    public function updateOrderAction(){
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        //$count = 1;
////        echo "<pre>";
////        print_r($_POST['item']);exit;
//        foreach ($_POST['item'] as $key=>$value){     
//            $sql="UPDATE tbl_state SET order_val ='$key' WHERE id ='$value'";
//            $update = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
//            //$count ++;    
//        }
//        //return true;
//        //die;
//        return new JsonModel(array("response" => true));
//    }

    public function AddAction()
    {   
//        $countryNameList = $this->getCountryTable()->customFields(array('id','country_name'));
        $countryNameList = $this->adminService->customFields();

        StateForm::$country_nameList = $countryNameList;

        // echo"dssd"; die;

        $form = new StateForm();
        $form->get('submit')->setAttribute('value', 'Add');
        
        $session= new \Zend\Session\Container('admin');
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
            $stateEntity = new States();

               $form->setInputFilter(new StateFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                //$stateEntity->exchangeArray($form->getData());
                // print_r($stateEntity);die;
//                $res = $this->getStateTable()->SaveState($stateEntity);
                 $res= $this->adminService->saveState($mergedata);

                //      return $this->redirect()->toRoute('admin', array(
                //             'action' => 'index',
                //             'controller' => 'state'
                // ));
//                $response = $this->getResponse();
//            $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
//            $response->setContent(json_encode(array("response"=>$res)));
//            return $response;
                return new JsonModel(array("response" => $res));
               }
                else {

                    foreach ($form->getmessages() as $key => $value) {
                        $errors[] = array("element"=>$key,"errors"=>$value['isEmpty']);
                    }
                    return new JsonModel(array("errors" => $errors, "FormId" => $_POST['FormId']));
//            $response = $this->getResponse();
//            $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
//            $response->setContent(json_encode(array("errors"=>$errors,"FormId"=>$_POST['FormId'])));
//            return $response;
               }
        }

        return new ViewModel(array('form'=> $form));
        
    }

    public function editAction()
    {   $action = $this->url()->fromRoute('admin/state', array('action' => 'searchboxresults'));
//        $countryNameList = $this->getCountryTable()->customFields(array('id','country_name'));
        $countryNameList = $this->adminService->customFields();
        
        

        StateForm::$country_nameList = $countryNameList;
//for Testing purpose
        //$action =  "http://localhost/rustagi/admin/state/searchboxresults";
         
//for Live Purpose
     //   $action =  "http://rustagisamaj.com/admin/state/searchboxresults";

         StateForm::$actionName = $action;

        $form = new StateForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
//            $state = $this->getStateTable()->getState($id);
            $state= $this->adminService->getState($id);
//             print_r($state);die;
            $form->bind($state);
            //$("form[name=editform] input[name='state_name']").val($state->state_name);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }
        
        $session= new \Zend\Session\Container('admin');
        $user_id = $session->offsetGet('id');
         $email_id = $session->offsetGet('email');
         $remote = new \Zend\Http\PhpEnvironment\RemoteAddress;
         $user_ip = $remote->getIpAddress();
         $user_data = array($user_id,$email_id,$user_ip);
         
        $request = $this->getRequest();
        if( !isset($_POST['chkedit']) ){
        if($request->isPost()){
            
            $mergedata = array_merge(
                    $this->getRequest()->getPost()->toArray() ,$user_data
            ); 
            $form->setData($mergedata);
            
//            $stateEntity = new States();

               $form->setInputFilter(new StateFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

//                $stateEntity = $form->getData();
                //print_r($stateEntity);die;
//                $res = $this->getStateTable()->SaveState($stateEntity);
                $res= $this->adminService->saveState($mergedata);

                     $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
            $response->setContent(json_encode(array("response"=>$res)));
            return $response;
               }
                else {
                    $res= $this->adminService->saveState($mergedata);
                    $response = $this->getResponse();
                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                    $response->setContent(json_encode(array("response" => $res)));
                    return $response;
//                    foreach ($form->getmessages() as $key => $value) {
//                        $errors[] = array("element"=>$key,"errors"=>$value['isEmpty']);
//                    }
//
//            $response = $this->getResponse();
//            $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
//            $response->setContent(json_encode(array("errors"=>$errors,"FormId"=>$_POST['FormId'])));
//            return $response;
               }
        }
      }
       

        $view = new ViewModel(array('form'=> $form,'id'=>$id));
        $view->setTerminal(true);
        return $view;

    }

    public function deleteAction()
    {
         
            $id = $this->params()->fromRoute('id');
            // print_r($id);
//            $state = $this->getStateTable()->deleteState($id);
            $result= $this->adminService->delete('tbl_state', $id);
            //return $this->redirect()->toRoute('admin', array(
                           // 'action' => 'index',
                          //  'controller' => 'state'
              //  ));
            
            return $this->redirect()->toRoute('admin/state', array('action' => 'index'));
    }
    

    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getStateTable()->getStatejoin($id);

            

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function viewByIdAction(){
        
        $id = $this->params()->fromRoute('id');

        //$Info = $this->getCountryTable()->getCountry($id);
//        $info = $this->getStateTable()->getStatejoin($id);
        $info = $this->adminService->viewByStateId('tbl_state', $id);

         //echo"<pre>"; print_r($Info);die;
        $view=new ViewModel(array('info'=>$info));
        $view->setTerminal(true);
        return $view;
        
    }
    
    public function searchboxresultsAction()
    {
//        $value = $_POST['value'];
//        $Cid = $_POST['field'];
//        if($Cid == 0)
//            echo "<p style='color:red'>Please select country</p>";
//        else {
//           $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//           $sql = "select * from tbl_allstates where (id not in (select master_state_id
//            from tbl_state) && state_name like '$value%' && master_country_id=$Cid) ";
//           $result=$adapter->query($sql, Adapter::QUERY_MODE_EXECUTE); 
//
//        $view = new ViewModel(array("results"=>$result));
//        $view->setTerminal(true);
//        return $view;
//        }
//        exit();    
        
        $data = $_POST['value'];
        $data2 = $_POST['countryid'];
//        echo  "<pre>";
//        print_r($data2);exit;
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $result = $adapter->query("select * from tbl_allstates where (id not in (select master_state_id
            from tbl_state)) && country_id=$data2 && state_name like '$data%'", Adapter::QUERY_MODE_EXECUTE);
        //\Zend\Debug\Debug::dump($result);exit;
        // $result = $this->getAllCountryTable()->searchresults($data);
        $view = new ViewModel(array("states" => $result, "parentname" => $_POST['field']));
        $view->setTerminal(true);
        return $view;
        exit();
        
        
    }

    public function changestatusAction()
    {   

//        $data = (object) $_POST;
//        $return = $this->getStateTable()->updatestatus($data);
        
        // print_r($return);
//        return new JsonModel($return);
//        exit();
       $session= new \Zend\Session\Container('admin');
       $user_id = $session->offsetGet('id');
        
        $request=$this->getRequest();
        $result= $this->adminService->changeStatus('tbl_state', $request->getPost('id'), $request->getPost(), $user_id);
        return new JsonModel($result);
    }

    public function delmultipleAction()
    {
        $ids = $_POST['chkdata'];
         $result= $this->adminService->deleteMultiple('tbl_state', $ids);

        echo $result;
        exit();
    }

    public function changeStatusAllAction()
    {
//        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $sql = "update tbl_state set IsActive=".$_POST['val']." where id IN (".$_POST['ids'].")";
//         $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE); 

        
        $result= $this->adminService->changeStatusAll('tbl_state', $_POST['ids'], $_POST['val']);
        
//        return new JsonModel($result);
                 if($result)
            echo "updated all";
        else echo "couldn't update"; 
        exit();
    }

    public function ajaxradiosearchAction()
    {
        $status = $_POST['is_active'];
//       echo  "<pre>";
//       print_r($status);die;
//         $this->data = array("tbl_state.IsActive=$status");
        if($status==1){
         $this->data = $status;

//         $states = $this->getStateTable()->fetchAll($this->data);
         $states = $this->adminService->getStateRadioList($_POST['is_active'])->toArray();
//         echo   "<pre>";
//         print_r($states);die;
         $view = new ViewModel(array('states' => $states));
         $view->setTemplate('admin/state/stateList');
         $view->setTerminal(true);
         return $view;
        }else{
            $this->data = $status;

//         $states = $this->getStateTable()->fetchAll($this->data);
         $states = $this->adminService->getStateRadioList($_POST['is_active']);
         if($states){
            $states = $states->toArray();
        }else{
            $states;
        }
//         echo   "<pre>";
//         print_r($states);die;
         $view = new ViewModel(array('states' => $states));
         $view->setTemplate('admin/state/stateList');
         $view->setTerminal(true);
         return $view;
        }
         


    }

    public function countrysearchAction()
    {
        //$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
        //$countryname = (empty($fieldname = $_POST['fieldname']))?"":" && tbl_state.country_id=".$_POST['fieldname'];

        //$result=$adapter->query("select * from tbl_state inner join tbl_country on tbl_state.country_id = tbl_country.id
           // where (tbl_state.state_name like '$data%' ".$countryname.")", Adapter::QUERY_MODE_EXECUTE); 
        
        $result = $this->adminService->stateSearch($data,$_POST['fieldname']);


        $view = new ViewModel(array("Results"=>$result));
        $view->setTerminal(true);
        return $view;
        // print_r($result);
        exit();  
    }

    public function performsearchAction()
    {
//        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        
         // $field1 = empty($_POST['country_name'])? "": "country_name like '".$_POST['country_name']."%' &&";   
//         $field1 = empty($_POST['country_id'])? "": "tbl_state.country_id= '".$_POST['country_id']."' &&";   
//         $field2 = empty($_POST['state_name'])? "": " tbl_state.state_name like '".$_POST['state_name']."%' ";   
//           
//         $sql = "select `tbl_state`.*,`tbl_country`.`country_name` AS `country_name` from `tbl_state` inner join 
//             tbl_country on tbl_state.country_id = tbl_country.id 
//         where ".$field1.$field2."";         
//         
//         $sql = rtrim($sql,"&&");
//        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE); 
$results = $this->adminService->performSearchState($_POST['country_id'],$_POST['state_name']);
         $view = new ViewModel(array("results"=>$results));
        $view->setTerminal(true);
        return $view;
        exit();

    }
}