<?php

namespace Admin\Controller;

use Admin\Form\ZodiacsignFilter;
use Admin\Form\ZodiacsignForm;
use Admin\Model\Entity\Zodiacsigns;
use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class ZodiacsignController extends AppController
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
         //$zodiacsigns = $this->getZodiacsignTable()->fetchAll($this->data);
         $zodiacsigns = $this->adminService->getZodiacsignList()->toArray();
            //echo   "<pre>";
          //print_r($zodiacsigns);die;
         // print_r($cities);die;
		 
		   
		$form = new ZodiacsignForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'zodiacsigns' => $zodiacsigns,'form'=> $form, 'action'=>'index'));
			
    }

    public function AddAction()
    {
        $form = new ZodiacsignForm();
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
            //$zodiacsignEntity = new Zodiacsigns();

               //$form->setInputFilter(new ZodiacsignFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$zodiacsignEntity->exchangeArray($form->getData());
                // print_r($zodiacsignEntity);die;
                //$res = $this->getZodiacsignTable()->SaveZodiacsign($zodiacsignEntity);
                $res= $this->adminService->SaveZodiacsign($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'zodiacsign'
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
        $form = new ZodiacsignForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            //$zodiacsign = $this->getZodiacsignTable()->getZodiacsign($id);
            $zodiacsign= $this->adminService->getZodiacsign($id);
            // print_r($zodiacsign);die;
            $form->bind($zodiacsign);
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
            //$zodiacsignEntity = new Zodiacsigns();

               //$form->setInputFilter(new ZodiacsignFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$zodiacsignEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getZodiacsignTable()->SaveZodiacsign($zodiacsignEntity);
                $res= $this->adminService->SaveZodiacsign($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'zodiacsign'
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
           // $zodiacsign = $this->getZodiacsignTable()->deleteZodiacsign($id);
            $zodiacsign= $this->adminService->delete('tbl_zodiac_sign_raasi', $id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'zodiacsign'
//                ));
            return $this->redirect()->toRoute('admin/zodiacsign', array('action' => 'index'));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getZodiacsignTable()->getZodiacsign($id);

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function viewByIdAction(){
        
        $id = $this->params()->fromRoute('id');

        //$Info = $this->getCountryTable()->getCountry($id);
        //$info = $this->getZodiacsignTable()->getZodiacsign($id);
        $info = $this->adminService->viewByZodiacsignId('tbl_zodiac_sign_raasi', $id);

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
        //$return = $this->getZodiacsignTable()->updatestatus($data);
        $result= $this->adminService->changeStatus('tbl_zodiac_sign_raasi', $request->getPost('id'), $request->getPost(), $user_id);
        // print_r($return);
        return new JsonModel($result);
        //exit();
    }
    
    public function delmultipleAction() {
        $ids = $_POST['chkdata'];
        //$result = $this->getZodiacsignTable()->delmultiple($ids);
        $result= $this->adminService->deleteMultiple('tbl_zodiac_sign_raasi', $ids);

        echo $result;
        exit();
    }
    
    public function changeStatusAllAction() {
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $sql = "update tbl_zodiac_sign_raasi set IsActive=" . $_POST['val'] . " where id IN (" . $_POST['ids'] . ")";
//        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $result= $this->adminService->changeStatusAll('tbl_zodiac_sign_raasi', $_POST['ids'], $_POST['val']);

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

        //$zodiacsigns = $this->getZodiacsignTable()->fetchAll($this->data);
        $zodiacsigns = $this->adminService->getZodiacsignRadioList($_POST['is_active'])->toArray();
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('zodiacsigns' => $zodiacsigns));
        $view->setTemplate('admin/zodiacsign/zodiacsignList');
        $view->setTerminal(true);
        return $view;
        }  else {
            $this->data = $status;

        //$zodiacsigns = $this->getZodiacsignTable()->fetchAll($this->data);
        $zodiacsigns = $this->adminService->getZodiacsignRadioList($_POST['is_active']);
        // return new ViewModel(array('countries' => $countries));
        if($zodiacsigns){
            $zodiacsigns = $zodiacsigns->toArray();
        }else{
            $zodiacsigns;
        }

        $view = new ViewModel(array('zodiacsigns' => $zodiacsigns));
        $view->setTemplate('admin/zodiacsign/zodiacsignList');
        $view->setTerminal(true);
        return $view;
        }
    }
    
    public function performsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        //$field1 = empty($_POST['zodiac_sign_name']) ? "" : "zodiac_sign_name like '" . $_POST['zodiac_sign_name'] . "%'";
        
        //$sql = "select * from tbl_zodiac_sign_raasi where " . $field1 . "";
       // $sql = rtrim($sql, "&&");
        //$results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $results = $this->adminService->performSearchZodiacsign($_POST['zodiac_sign_name']);

        $view = new ViewModel(array("results" => $results));
        $view->setTerminal(true);
        return $view;


        exit();
    }
    
    public function zodiacsignsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
//        echo  "<pre>";
//        print_r($data);die;

        //$result = $adapter->query("select * from tbl_zodiac_sign_raasi where zodiac_sign_name like '$data%' ", Adapter::QUERY_MODE_EXECUTE);
        $result = $this->adminService->zodiacsignSearch($data);


        $view = new ViewModel(array("Results" => $result));
        $view->setTerminal(true);
        return $view;
        exit();
    }
   
}