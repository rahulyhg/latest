<?php

namespace Admin\Controller;

use Admin\Form\DesignationFilter;
use Admin\Form\DesignationForm;
use Admin\Model\Entity\Designations;
use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class DesignationController extends AppController
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
         //$designations = $this->getDesignationTable()->fetchAll($this->data);
         $designations = $this->adminService->getDesignationList()->toArray();
            //echo   "<pre>";
          //print_r($designations);die;
         // print_r($cities);die;
		 
		   
		$form = new DesignationForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'designations' => $designations,'form'=> $form, 'action'=>'index'));
			
    }

    public function AddAction()
    {
        $form = new DesignationForm();
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
            //$designationEntity = new Designations();

               //$form->setInputFilter(new DesignationFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$designationEntity->exchangeArray($form->getData());
                // print_r($designationEntity);die;
                //$res = $this->getDesignationTable()->SaveDesignation($designationEntity);
                $res= $this->adminService->SaveDesignation($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'designation'
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
        $form = new DesignationForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            //$designation = $this->getDesignationTable()->getDesignation($id);
            $designation= $this->adminService->getDesignation($id);
            // print_r($designation);die;
            $form->bind($designation);
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
        if (!isset($_POST['chkedit'])) {
        if($request->isPost()){
            
            $mergedata = array_merge(
                    $this->getRequest()->getPost()->toArray() ,$user_data
            ); 
            $form->setData($mergedata);
            //$designationEntity = new Designations();

               //$form->setInputFilter(new DesignationFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$designationEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getDesignationTable()->SaveDesignation($designationEntity);
                $res= $this->adminService->SaveDesignation($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'designation'
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
            //$designation = $this->getDesignationTable()->deleteDesignation($id);
            $designation= $this->adminService->delete('tbl_designation', $id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'designation'
//                ));
            return $this->redirect()->toRoute('admin/designation', array('action' => 'index'));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getDesignationTable()->getDesignation($id);

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function viewByIdAction(){
        
        $id = $this->params()->fromRoute('id');

        //$Info = $this->getCountryTable()->getCountry($id);
        //$info = $this->getDesignationTable()->getDesignation($id);
        $info = $this->adminService->viewByDesignationId('tbl_designation', $id);

        // echo"<pre>"; print_r($Info);die;
        $view=new ViewModel(array('info'=>$info));
        $view->setTerminal(true);
        return $view;
        
    }
    
    public function changestatusAction() {
        $session= new \Zend\Session\Container('admin');
        $user_id = $session->offsetGet('id');
        //$data = (object) $_POST;
        $request=$this->getRequest();
        //$return = $this->getDesignationTable()->updatestatus($data);
        $result= $this->adminService->changeStatus('tbl_designation', $request->getPost('id'), $request->getPost(), $user_id);
        // print_r($return);
        return new JsonModel($result);
        //exit();
    }
    
    public function delmultipleAction() {
        $ids = $_POST['chkdata'];
        //$result = $this->getDesignationTable()->delmultiple($ids);
        $result= $this->adminService->deleteMultiple('tbl_designation', $ids);

        echo $result;
        exit();
    }
    
    public function changeStatusAllAction() {
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $sql = "update tbl_designation set IsActive=" . $_POST['val'] . " where id IN (" . $_POST['ids'] . ")";
//        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $result= $this->adminService->changeStatusAll('tbl_designation', $_POST['ids'], $_POST['val']);

//        return new JsonModel($result);
                if ($result)
            echo "updated all";
        else
            echo "couldn't update";
        exit();
    }
    
    public function ajaxradiosearchAction() {
        $status = $_POST['is_active'];
        //$this->data = array("IsActive=$status");
        if($status==1){
        $this->data = $status;

        //$designations = $this->getDesignationTable()->fetchAll($this->data);
        $designations = $this->adminService->getDesignationRadioList($_POST['is_active'])->toArray();
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('designations' => $designations));
        $view->setTemplate('admin/designation/designationList');
        $view->setTerminal(true);
        return $view;
        }  else {
            $this->data = $status;

        //$designations = $this->getDesignationTable()->fetchAll($this->data);
        $designations = $this->adminService->getDesignationRadioList($_POST['is_active']);
        // return new ViewModel(array('countries' => $countries));
        if($designations){
            $designations = $designations->toArray();
        }else{
            $designations;
        }

        $view = new ViewModel(array('designations' => $designations));
        $view->setTemplate('admin/designation/designationList');
        $view->setTerminal(true);
        return $view;
        }
    }
    
    public function performsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        //$field1 = empty($_POST['designation']) ? "" : "designation like '" . $_POST['designation'] . "%'";
        
        //$sql = "select * from tbl_designation where " . $field1 . "";
       // $sql = rtrim($sql, "&&");
        //$results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $results = $this->adminService->performSearchDesignation($_POST['designation']);

        $view = new ViewModel(array("results" => $results));
        $view->setTerminal(true);
        return $view;


        exit();
    }
    
    public function designationsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
//        echo  "<pre>";
//        print_r($data);die;

        //$result = $adapter->query("select * from tbl_designation where designation like '$data%' ", Adapter::QUERY_MODE_EXECUTE);
        $result = $this->adminService->designationSearch($data);


        $view = new ViewModel(array("Results" => $result));
        $view->setTerminal(true);
        return $view;
        exit();
    }
   
}