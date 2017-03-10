<?php

namespace Admin\Controller;

use Admin\Form\GothraFilter;
use Admin\Form\GothraForm;
use Admin\Model\Entity\Gothras;
use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class GothraController extends AppController
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
        
         //$gothras = $this->getGothraTable()->fetchAll($this->data);
         $gothras = $this->adminService->getGothrasList()->toArray();
//            echo   "<pre>";
//          print_r($gothras);die;
         $caasteNameList = $this->adminService->getAllCastlist();

        GothraForm::$caste_nameList = $caasteNameList;
		 
		 $form = new GothraForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'gothras' => $gothras,'form'=> $form, 'action'=>'index'));
			

       // return new ViewModel(array(
         //   'gothras' => $gothras));
    }

    public function AddAction()
    {
        $caasteNameList = $this->adminService->getAllCastlist();

        GothraForm::$caste_nameList = $caasteNameList;
        
        $form = new GothraForm();
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
            //$gothraEntity = new Gothras();

               //$form->setInputFilter(new GothraFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$gothraEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                //$res = $this->getGothraTable()->SaveGothra($gothraEntity);
                $res= $this->adminService->SaveGothra($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'gothra'
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
        $caasteNameList = $this->adminService->getAllCastlist();

        GothraForm::$caste_nameList = $caasteNameList;

        $form = new GothraForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            //$gothra = $this->getGothraTable()->getGothra($id);
            $gothra= $this->adminService->getGothra($id);
            // print_r($religion);die;
            $form->bind($gothra);
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
            //$gothraEntity = new Gothras();

               //$form->setInputFilter(new GothraFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$gothraEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getGothraTable()->SaveGothra($gothraEntity);
                $res= $this->adminService->SaveGothra($mergedata);
//
//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'gothra'
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
            //$gothra = $this->getGothraTable()->deleteGothra($id);
            $gothra= $this->adminService->delete('tbl_gothra_gothram', $id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'gothra'
//                ));
            return $this->redirect()->toRoute('admin/gothra', array('action' => 'index'));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getGothraTable()->getGothra($id);

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function viewByIdAction(){
        
        $id = $this->params()->fromRoute('id');

        //$Info = $this->getCountryTable()->getCountry($id);
        //$info = $this->getGothraTable()->getGothra($id);
        $info = $this->adminService->viewByGothraId('tbl_gothra_gothram', $id);

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
        //$return = $this->getGothraTable()->updatestatus($data);
        $result= $this->adminService->changeStatus('tbl_gothra_gothram', $request->getPost('id'), $request->getPost(), $user_id);
        // print_r($return);
        return new JsonModel($result);
        //exit();
    }
    
    public function delmultipleAction() {
        $ids = $_POST['chkdata'];
        //$result = $this->getGothraTable()->delmultiple($ids);
        $result= $this->adminService->deleteMultiple('tbl_gothra_gothram', $ids);

        echo $result;
        exit();
    }
    
    public function changeStatusAllAction() {
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $sql = "update tbl_gothra_gothram set IsActive=" . $_POST['val'] . " where id IN (" . $_POST['ids'] . ")";
//        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $result= $this->adminService->changeStatusAll('tbl_gothra_gothram', $_POST['ids'], $_POST['val']);

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

        //$gothras = $this->getGothraTable()->fetchAll($this->data);
        $gothras = $this->adminService->getGothraRadioList($_POST['is_active'])->toArray();
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('gothras' => $gothras));
        $view->setTemplate('admin/gothra/gothraList');
        $view->setTerminal(true);
        return $view;
        }  else {
            $this->data = $status;

        //$gothras = $this->getGothraTable()->fetchAll($this->data);
        $gothras = $this->adminService->getGothraRadioList($_POST['is_active']);
        // return new ViewModel(array('countries' => $countries));
        if($gothras){
            $gothras = $gothras->toArray();
        }else{
            $gothras;
        }

        $view = new ViewModel(array('gothras' => $gothras));
        $view->setTemplate('admin/gothra/gothraList');
        $view->setTerminal(true);
        return $view;
        }
    }
    
    public function performsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        //$field1 = empty($_POST['gothra_name']) ? "" : "gothra_name like '" . $_POST['gothra_name'] . "%'";
        
        //$sql = "select * from tbl_gothra_gothram where " . $field1 . "";
       // $sql = rtrim($sql, "&&");
        //$results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $results = $this->adminService->performSearchGothra($_POST['caste_id'],$_POST['gothra_name']);

        $view = new ViewModel(array("results" => $results));
        $view->setTerminal(true);
        return $view;


        exit();
    }
    
    public function gothrasearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
//        echo  "<pre>";
//        print_r($data);die;

        //$result = $adapter->query("select * from tbl_gothra_gothram where gothra_name like '$data%' ", Adapter::QUERY_MODE_EXECUTE);
        $result = $this->adminService->gothraSearch($data,$_POST['fieldname']);


        $view = new ViewModel(array("Results" => $result));
        $view->setTerminal(true);
        return $view;
        exit();
    }
   
}