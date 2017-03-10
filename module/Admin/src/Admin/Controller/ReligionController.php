<?php

namespace Admin\Controller;

use Admin\Form\ReligionFilter;
use Admin\Form\ReligionForm;
use Admin\Model\Entity\Religions;
use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class ReligionController extends AppController
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
         //$religions = $this->getReligionTable()->fetchAll($this->data);
         $religions = $this->adminService->getReligionList()->toArray();
            //echo   "<pre>";
          //print_r($religions);die;
         // print_r($cities);die;
		 
		   
		$form = new ReligionForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'religions' => $religions,'form'=> $form, 'action'=>'index'));
			
    }

    public function AddAction()
    {
        $form = new ReligionForm();
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
            //$religionEntity = new Religions();

               //$form->setInputFilter(new ReligionFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$religionEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                //$res = $this->getReligionTable()->SaveReligion($religionEntity);
                $res= $this->adminService->SaveReligion($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'religion'
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
        $form = new ReligionForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            //$religion = $this->getReligionTable()->getReligion($id);
            $religion= $this->adminService->getReligion($id);
            // print_r($religion);die;
            $form->bind($religion);
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
            //$religionEntity = new Religions();

               //$form->setInputFilter(new ReligionFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$religionEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getReligionTable()->SaveReligion($religionEntity);
                $res= $this->adminService->SaveReligion($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'religion'
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
            //$religion = $this->getReligionTable()->deleteReligion($id);
            $religion= $this->adminService->delete('tbl_religion', $id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'religion'
//                ));
            return $this->redirect()->toRoute('admin/religion', array('action' => 'index'));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getReligionTable()->getReligion($id);

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function viewByIdAction(){
        
        $id = $this->params()->fromRoute('id');

        //$Info = $this->getCountryTable()->getCountry($id);
        //$info = $this->getReligionTable()->getReligion($id);
        $info = $this->adminService->viewByReligionId('tbl_religion', $id);

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
        //$return = $this->getReligionTable()->updatestatus($data);
        $result= $this->adminService->changeStatus('tbl_religion', $request->getPost('id'), $request->getPost(), $user_id);
        // print_r($return);
        return new JsonModel($result);
        //exit();
    }
    
    public function delmultipleAction() {
        $ids = $_POST['chkdata'];
        //$result = $this->getReligionTable()->delmultiple($ids);
        $result= $this->adminService->deleteMultiple('tbl_religion', $ids);

        echo $result;
        exit();
    }
    
    public function changeStatusAllAction() {
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $sql = "update tbl_religion set IsActive=" . $_POST['val'] . " where id IN (" . $_POST['ids'] . ")";
//        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $result= $this->adminService->changeStatusAll('tbl_religion', $_POST['ids'], $_POST['val']);
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

        //$religions = $this->getReligionTable()->fetchAll($this->data);
        $religions = $this->adminService->getReligionRadioList($_POST['is_active'])->toArray();
        // return new ViewModel(array('countries' => $countries));
//        echo "<pre>";
//        print_r($religions);exit;

        $view = new ViewModel(array('religions' => $religions));
        $view->setTemplate('admin/religion/religionList');
        $view->setTerminal(true);
        return $view;
        }else{
            $this->data = $status;

        //$religions = $this->getReligionTable()->fetchAll($this->data);
        $religions = $this->adminService->getReligionRadioList($_POST['is_active']);
        //\Zend\Debug\Debug::dump($religions);exit;
        if($religions){
            $religions = $religions->toArray();
        }else{
            $religions;
        }
        // return new ViewModel(array('countries' => $countries));
//        echo "<pre>";
//        print_r($religions);exit;

        $view = new ViewModel(array('religions' => $religions));
        $view->setTemplate('admin/religion/religionList');
        $view->setTerminal(true);
        return $view;
        }
    }
    
    public function performsearchAction() {
//        echo  "hello";exit;
//            echo  "<pre>";
//            print_r($_POST['religion_name']);exit;
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        //$field1 = empty($_POST['religion_name']) ? "" : "religion_name like '" . $_POST['religion_name'] . "%'";
        
        //$sql = "select * from tbl_religion where " . $field1 . "";
       // $sql = rtrim($sql, "&&");
        //$results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $religions = $this->adminService->performSearchReligion($_POST['religion_name']);

        $view = new ViewModel(array("religions" => $religions));
        //$view->clearVariables('admin/religion/religionList');
        //$view->setTemplate('admin/religion/performsearch');
        $view->setTerminal(true);
        return $view;


        exit();
        
//        return new ViewModel(array(
//            'religions' => $religions));
        //$view = new ViewModel(array("religions" => $religions));
        //$view->setTemplate('admin/religion/performsearch');
        //$view->setTerminal(true);
        //return $view;


        //exit();
    }
    
    public function religionsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
//        echo  "<pre>";
//        print_r($data);die;

        //$result = $adapter->query("select * from tbl_religion where religion_name like '$data%' ", Adapter::QUERY_MODE_EXECUTE);
        $result = $this->adminService->religionSearch($data);


        $view = new ViewModel(array("Results" => $result));
        $view->setTerminal(true);
        return $view;
        exit();
    }
   
}