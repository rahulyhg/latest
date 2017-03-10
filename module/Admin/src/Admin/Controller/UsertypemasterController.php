<?php

namespace Admin\Controller;

use Admin\Form\UsertypemasterFilter;
use Admin\Form\UsertypemasterForm;
use Admin\Model\Entity\Usertypemasters;
use Admin\Service\AdminServiceInterface;
use Admin\Service\UsertypemasterServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class UsertypemasterController extends AppController
{
    protected $data = '';//array();
    protected $commonService;
    protected $adminService;
    protected $usertypemasterService;

    public function __construct(CommonServiceInterface $commonService, AdminServiceInterface $adminService, UsertypemasterServiceInterface $usertypemasterService) {
        $this->commonService = $commonService;
        $this->adminService=$adminService;
        $this->usertypemasterService=$usertypemasterService;
    }
    
    public function indexAction()
    {   //echo  "hello";exit;
//    $result = $this->usertypemasterService->test();
//    echo  $result;exit;
         //$usertypemasters = $this->getUsertypemasterTable()->fetchAll($this->data);
         $usertypemasters = $this->usertypemasterService->getUsertypemasterList()->toArray();
//            echo   "<pre>";
//          print_r($usertypemasters);die;
         // print_r($cities);die;
		 
		   
		$form = new UsertypemasterForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'usertypemasters' => $usertypemasters,'form'=> $form, 'action'=>'index'));
			
    }

    public function AddAction()
    {
        $form = new UsertypemasterForm();
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
            //$usertypemasterEntity = new Usertypemasters();

               //$form->setInputFilter(new UsertypemasterFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$usertypemasterEntity->exchangeArray($form->getData());
                // print_r($usertypemasterEntity);die;
                //$res = $this->getUsertypemasterTable()->SaveUsertypemaster($usertypemasterEntity);
                $res= $this->usertypemasterService->SaveUsertypemaster($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'usertypemaster'
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
        $form = new UsertypemasterForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            //$usertypemaster = $this->getUsertypemasterTable()->getUsertypemaster($id);
            $usertypemaster= $this->usertypemasterService->getUsertypemaster($id);
            // print_r($usertypemaster);die;
            $form->bind($usertypemaster);
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
            //$usertypemasterEntity = new Usertypemasters();

               //$form->setInputFilter(new UsertypemasterFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$usertypemasterEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getUsertypemasterTable()->SaveUsertypemaster($usertypemasterEntity);
                $res= $this->usertypemasterService->SaveUsertypemaster($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'usertypemaster'
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
            //$usertypemaster = $this->getUsertypemasterTable()->deleteUsertypemaster($id);
            $usertypemaster= $this->adminService->delete('tbl_user_type', $id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'usertypemaster'
//                ));
            return $this->redirect()->toRoute('admin/usertypemaster', array('action' => 'index'));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getUsertypemasterTable()->getUsertypemaster($id);

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function viewByIdAction(){
        
        $id = $this->params()->fromRoute('id');

        //$Info = $this->getCountryTable()->getCountry($id);
        //$info = $this->getUsertypemasterTable()->getUsertypemaster($id);
        $info = $this->usertypemasterService->viewByUsertypemasterId('tbl_user_type', $id);

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
        //$return = $this->getUsertypemasterTable()->updatestatus($data);
        $result= $this->adminService->changeStatus('tbl_user_type', $request->getPost('id'), $request->getPost(), $user_id);
        // print_r($return);
        return new JsonModel($result);
        //exit();
    }
    
    public function delmultipleAction() {
        $ids = $_POST['chkdata'];
        //$result = $this->getUsertypemasterTable()->delmultiple($ids);
        $result= $this->adminService->deleteMultiple('tbl_user_type', $ids);

        echo $result;
        exit();
    }
    
    public function changeStatusAllAction() {
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $sql = "update tbl_user_type set IsActive=" . $_POST['val'] . " where id IN (" . $_POST['ids'] . ")";
//        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $result= $this->adminService->changeStatusAll('tbl_user_type', $_POST['ids'], $_POST['val']);
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

        //$usertypemasters = $this->getUsertypemasterTable()->fetchAll($this->data);
        $usertypemasters = $this->usertypemasterService->getUsertypemasterRadioList($_POST['is_active'])->toArray();
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('usertypemasters' => $usertypemasters));
        $view->setTemplate('admin/usertypemaster/usertypemasterList');
        $view->setTerminal(true);
        return $view;
        }  else {
            $this->data = $status;

        //$usertypemasters = $this->getUsertypemasterTable()->fetchAll($this->data);
        $usertypemasters = $this->usertypemasterService->getUsertypemasterRadioList($_POST['is_active']);
        // return new ViewModel(array('countries' => $countries));
        if($usertypemasters){
            $usertypemasters = $usertypemasters->toArray();
        }else{
            $usertypemasters;
        }

        $view = new ViewModel(array('usertypemasters' => $usertypemasters));
        $view->setTemplate('admin/usertypemaster/usertypemasterList');
        $view->setTerminal(true);
        return $view;
        }
    }
    
    public function performsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        //$field1 = empty($_POST['user_type']) ? "" : "user_type like '" . $_POST['user_type'] . "%'";
        
        //$sql = "select * from tbl_user_type where " . $field1 . "";
       // $sql = rtrim($sql, "&&");
        //$results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $results = $this->usertypemasterService->performSearchUsertypemaster($_POST['user_type']);

        $view = new ViewModel(array("results" => $results));
        $view->setTerminal(true);
        return $view;


        exit();
    }
    
    public function usertypemastersearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
//        echo  "<pre>";
//        print_r($data);die;

        //$result = $adapter->query("select * from tbl_user_type where user_type like '$data%' ", Adapter::QUERY_MODE_EXECUTE);
        $result = $this->usertypemasterService->usertypemasterSearch($data);


        $view = new ViewModel(array("Results" => $result));
        $view->setTerminal(true);
        return $view;
        exit();
    }
   
}