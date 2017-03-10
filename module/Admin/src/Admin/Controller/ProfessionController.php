<?php

namespace Admin\Controller;

use Admin\Form\ProfessionFilter;
use Admin\Form\ProfessionForm;
use Admin\Model\Entity\Professions;
use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class ProfessionController extends AppController
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
         //$professions = $this->getProfessionTable()->fetchAll($this->data);
         $professions = $this->adminService->getProfessionList()->toArray();
            //echo   "<pre>";
          //print_r($professions);die;
         // print_r($cities);die;
		 
		   
		$form = new ProfessionForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'professions' => $professions,'form'=> $form, 'action'=>'index'));
			
    }

    public function AddAction()
    {
        $form = new ProfessionForm();
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
            //$professionEntity = new Professions();

               //$form->setInputFilter(new ProfessionFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$professionEntity->exchangeArray($form->getData());
                // print_r($professionEntity);die;
                //$res = $this->getProfessionTable()->SaveProfession($professionEntity);
                $res= $this->adminService->SaveProfession($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'profession'
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
        $form = new ProfessionForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            //$profession = $this->getProfessionTable()->getProfession($id);
            $profession= $this->adminService->getProfession($id);
            // print_r($profession);die;
            $form->bind($profession);
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
            //$professionEntity = new Professions();

               //$form->setInputFilter(new ProfessionFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$professionEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getProfessionTable()->SaveProfession($professionEntity);
                $res= $this->adminService->SaveProfession($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'profession'
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
            //$profession = $this->getProfessionTable()->deleteProfession($id);
            $profession= $this->adminService->delete('tbl_profession', $id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'profession'
//                ));
            return $this->redirect()->toRoute('admin/profession', array('action' => 'index'));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getProfessionTable()->getProfession($id);

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function viewByIdAction(){
        
        $id = $this->params()->fromRoute('id');

        //$Info = $this->getCountryTable()->getCountry($id);
        //$info = $this->getProfessionTable()->getProfession($id);
        $info = $this->adminService->viewByProfessionId('tbl_profession', $id);

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
        //$return = $this->getProfessionTable()->updatestatus($data);
        $result= $this->adminService->changeStatus('tbl_profession', $request->getPost('id'), $request->getPost(), $user_id);
        // print_r($return);
        return new JsonModel($result);
        //exit();
    }
    
    public function delmultipleAction() {
        $ids = $_POST['chkdata'];
        //$result = $this->getProfessionTable()->delmultiple($ids);
        $result= $this->adminService->deleteMultiple('tbl_profession', $ids);

        echo $result;
        exit();
    }
    
    public function changeStatusAllAction() {
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $sql = "update tbl_profession set IsActive=" . $_POST['val'] . " where id IN (" . $_POST['ids'] . ")";
//        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $result= $this->adminService->changeStatusAll('tbl_profession', $_POST['ids'], $_POST['val']);

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

        //$professions = $this->getProfessionTable()->fetchAll($this->data);
        $professions = $this->adminService->getProfessionRadioList($_POST['is_active'])->toArray();
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('professions' => $professions));
        $view->setTemplate('admin/profession/professionList');
        $view->setTerminal(true);
        return $view;
        }  else {
            $this->data = $status;

        //$professions = $this->getProfessionTable()->fetchAll($this->data);
        $professions = $this->adminService->getProfessionRadioList($_POST['is_active']);
        // return new ViewModel(array('countries' => $countries));
        if($professions){
            $professions = $professions->toArray();
        }else{
            $professions;
        }

        $view = new ViewModel(array('professions' => $professions));
        $view->setTemplate('admin/profession/professionList');
        $view->setTerminal(true);
        return $view;
        }
    }
    
     public function performsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        //$field1 = empty($_POST['profession']) ? "" : "profession like '" . $_POST['profession'] . "%'";
        
        //$sql = "select * from tbl_profession where " . $field1 . "";
       // $sql = rtrim($sql, "&&");
        //$results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $results = $this->adminService->performSearchProfession($_POST['profession']);

        $view = new ViewModel(array("results" => $results));
        $view->setTerminal(true);
        return $view;


        exit();
    }
    
    public function professionsearchAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
//        echo  "<pre>";
//        print_r($data);die;

        //$result = $adapter->query("select * from tbl_profession where profession like '$data%' ", Adapter::QUERY_MODE_EXECUTE);
        $result = $this->adminService->professionSearch($data);

        $view = new ViewModel(array("Results" => $result));
        $view->setTerminal(true);
        return $view;
        exit();
    }
   
}