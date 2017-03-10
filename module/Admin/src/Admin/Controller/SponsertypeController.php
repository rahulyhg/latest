<?php

namespace Admin\Controller;

use Admin\Form\SponsertypeFilter;
use Admin\Form\SponsertypeForm;
use Admin\Model\Entity\Sponsertypes;
use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Admin\Service\SponsertypeServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class SponsertypeController extends AppController
{
    protected $data = '';//array();
    protected $commonService;
    protected $adminService;
    protected $sponsertypeService;

    public function __construct(CommonServiceInterface $commonService, AdminServiceInterface $adminService, SponsertypeServiceInterface $sponsertypeService) {
        $this->commonService = $commonService;
        $this->adminService=$adminService;
        $this->sponsertypeService=$sponsertypeService;
    }
    
    public function indexAction()
    {   
//        echo   "hello amir";exit;
//        $tests = $this->sponsertypeService->test();
//        print_r($tests);exit;
        
         //$sponsertypes = $this->getSponsertypeTable()->fetchAll($this->data);
         $sponsertypes = $this->sponsertypeService->getSponsertypeList()->toArray();
            //echo   "<pre>";
          //print_r($sponsertypes);die;
         // print_r($cities);die;
		 
		   
		$form = new SponsertypeForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'sponsertypes' => $sponsertypes,'form'=> $form, 'action'=>'index'));
			
    }

    public function AddAction()
    {
        
         //\Zend\Debug\Debug::dump($user_data);exit;
         
        $form = new SponsertypeForm();
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
            //$sponsertypeEntity = new Sponsertypes();

               //$form->setInputFilter(new SponsertypeFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$sponsertypeEntity->exchangeArray($form->getData());
                // print_r($sponsertypeEntity);die;
                //$res = $this->getSponsertypeTable()->SaveSponsertype($sponsertypeEntity);
                $res= $this->sponsertypeService->SaveSponsertype($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'sponsertype'
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
    {  //echo  "hello";exit;
        $session= new \Zend\Session\Container('admin');
        $user_id = $session->offsetGet('id');
         $email_id = $session->offsetGet('email');
         $user_data = array($user_id,$email_id);
         
        $form = new SponsertypeForm();
        if($this->params()->fromRoute('id')>0){
            $sponsTypeId = $this->params()->fromRoute('id');
//             echo   $sponsTypeId;die;
            //$sponsertype = $this->getSponsertypeTable()->getSponsertype($spons_type_id);
            $sponsertype= $this->sponsertypeService->getSponsertype($sponsTypeId);
             //print_r($sponsertype);die;
            $form->bind($sponsertype);
            $form->get('submit')->setAttribute('value', 'Add');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if (!isset($_POST['chkedit'])) {
        if($request->isPost()){
             
            $mergedata = array_merge(
                    $this->getRequest()->getPost()->toArray() ,$user_data
            ); 
            $form->setData($mergedata);
            //$sponsertypeEntity = new Sponsertypes();

               //$form->setInputFilter(new SponsertypeFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$sponsertypeEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getSponsertypeTable()->SaveSponsertype($sponsertypeEntity);
                $res= $this->sponsertypeService->SaveSponsertype($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'sponsertype'
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

        //return new ViewModel(array('form'=> $form,'spons_type_id'=>$spons_type_id));
        $view = new ViewModel(array('form' => $form, 'spons_type_id' => $spons_type_id));
        $view->setTerminal(true);
        return $view;

    }

    public function deleteAction()
    {      //echo  "hello";exit;
         
            $sponsTypeId = $this->params()->fromRoute('id');
//            echo  "<pre>";
//            echo  $sponsTypeId;exit;
            //$sponsertype = $this->getSponsertypeTable()->deleteSponsertype($spons_type_id);
            $sponsertype= $this->sponsertypeService->delete('tbl_sponser_type_master', $sponsTypeId);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'sponsertype'
//                ));
            return $this->redirect()->toRoute('admin/sponsertype', array('action' => 'index'));
    }
    
    public function viewAction()
    {
        $spons_type_id = $this->params()->fromRoute('spons_type_id');

        $Info = $this->getSponsertypeTable()->getSponsertype($spons_type_id);

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function viewByIdAction(){
        
        $spons_type_id = $this->params()->fromRoute('id');
//        \Zend\Debug\Debug::dump($spons_type_id);exit;
        //$Info = $this->getCountryTable()->getCountry($spons_type_id);
        //$info = $this->getSponsertypeTable()->getSponsertype($spons_type_id);
        $info = $this->sponsertypeService->viewBySponsertypeId('tbl_sponser_type_master', $spons_type_id);

         //echo"<pre>"; print_r($info);die;
        $view=new ViewModel(array('info'=>$info));
        $view->setTerminal(true);
        return $view;
        
    }
    
    public function changestatusAction() {
        $session= new \Zend\Session\Container('admin');
       $user_id = $session->offsetGet('id');
        //echo  "<pre>";
//           $id =  $request->getPost('sponsTypeId');
//           print_r($id);exit;
//        $data = (object) $_POST;
//        print_r($data);exit;
        $request=$this->getRequest();
//        echo  "<pre>";
//        \Zend\Debug\Debug::dump($request);exit;
        //$return = $this->getSponsertypeTable()->updatestatus($data);
        $result= $this->sponsertypeService->changeStatus('tbl_sponser_type_master', $request->getPost('spons_type_id'), $request->getPost('is_active'), $user_id);
        // print_r($return);
        return new JsonModel($result);
        //exit();
    }
    
    public function delmultipleAction() {
        $spons_type_ids = $_POST['chkdata'];
        //$result = $this->getSponsertypeTable()->delmultiple($spons_type_ids);
        $result= $this->sponsertypeService->deleteMultiple('tbl_sponser_type_master', $spons_type_ids);

        echo $result;
        exit();
    }
    
    public function changeStatusAllAction() {
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $sql = "update tbl_sponser_type_master set IsActive=" . $_POST['val'] . " where spons_type_id IN (" . $_POST['spons_type_ids'] . ")";
//        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $result= $this->sponsertypeService->changeStatusAll('tbl_sponser_type_master', $_POST['spons_type_ids'], $_POST['val']);
        if ($result)
            echo "updated all";
        else
            echo "couldn't update";
        exit();
        //return new JsonModel($result);
    }
    
    public function ajaxradiosearchAction() {
        $status = $_POST['is_active'];
        //$this->data = array("IsActive=$status");
        if($status==1){
        $this->data = $status;

        //$sponsertypes = $this->getSponsertypeTable()->fetchAll($this->data);
        $sponsertypes = $this->sponsertypeService->getSponsertypeRadioList($_POST['is_active'])->toArray();
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('sponsertypes' => $sponsertypes));
        $view->setTemplate('admin/sponsertype/sponsertypeList');
        $view->setTerminal(true);
        return $view;
        }  else {
            $this->data = $status;

        //$sponsertypes = $this->getSponsertypeTable()->fetchAll($this->data);
        $sponsertypes = $this->sponsertypeService->getSponsertypeRadioList($_POST['is_active']);
        // return new ViewModel(array('countries' => $countries));
        if($sponsertypes){
            $sponsertypes = $sponsertypes->toArray();
        }else{
            $sponsertypes;
        }

        $view = new ViewModel(array('sponsertypes' => $sponsertypes));
        $view->setTemplate('admin/sponsertype/sponsertypeList');
        $view->setTerminal(true);
        return $view;
        }
    }
    
    public function performsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        //$field1 = empty($_POST['spons_type_title']) ? "" : "spons_type_title like '" . $_POST['spons_type_title'] . "%'";
        
        //$sql = "select * from tbl_sponser_type_master where " . $field1 . "";
       // $sql = rtrim($sql, "&&");
        //$results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $results = $this->sponsertypeService->performSearchSponsertype($_POST['spons_type_title']);

        $view = new ViewModel(array("results" => $results));
        $view->setTerminal(true);
        return $view;


        exit();
    }
    
    public function sponsertypesearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
//        echo  "<pre>";
//        print_r($data);die;

        //$result = $adapter->query("select * from tbl_sponser_type_master where spons_type_title like '$data%' ", Adapter::QUERY_MODE_EXECUTE);
        $result = $this->sponsertypeService->sponsertypeSearch($data);


        $view = new ViewModel(array("Results" => $result));
        $view->setTerminal(true);
        return $view;
        exit();
    }
   
}