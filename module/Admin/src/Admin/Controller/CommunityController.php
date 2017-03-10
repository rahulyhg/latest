<?php

namespace Admin\Controller;

use Admin\Form\CommunityFilter;
use Admin\Form\CommunityForm;
use Admin\Model\Entity\Communitys;
use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Admin\Service\CommunityServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class CommunityController extends AppController
{   
    protected $data = '';//array();
    protected $commonService;
    protected $adminService;
    protected $communityService;

    public function __construct(CommonServiceInterface $commonService, AdminServiceInterface $adminService, CommunityServiceInterface $communityService) {
        $this->commonService = $commonService;
        $this->adminService = $adminService;
        $this->communityService = $communityService;
    }
    
    public function indexAction()
    {   //$tests = $this->communityService->test();
        //print_r($tests);exit;
        //echo  "hello";exit;
         //$communitys = $this->getCommunityTable()->fetchAll($this->data);
         $communitys = $this->communityService->getCommunitysList()->toArray();
//            echo   "<pre>";
//          print_r($communitys);die;
         $religionNameList = $this->communityService->getAllReligionlist();

        CommunityForm::$religion_nameList = $religionNameList;
		 
		 $form = new CommunityForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'communitys' => $communitys,'form'=> $form, 'action'=>'index'));
			

       // return new ViewModel(array(
         //   'communitys' => $communitys));
    }

    public function AddAction()
    {
        $religionNameList = $this->communityService->getAllReligionlist();

        CommunityForm::$religion_nameList = $religionNameList;
        
        $form = new CommunityForm();
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
            //$communityEntity = new Communitys();

               //$form->setInputFilter(new CommunityFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$communityEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                //$res = $this->getCommunityTable()->SaveCommunity($communityEntity);
                $res= $this->communityService->SaveCommunity($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'community'
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
        $religionNameList = $this->communityService->getAllReligionlist();

        CommunityForm::$religion_nameList = $religionNameList;

        $form = new CommunityForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            //$community = $this->getCommunityTable()->getCommunity($id);
            $community= $this->communityService->getCommunity($id);
            // print_r($religion);die;
            $form->bind($community);
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
            //$communityEntity = new Communitys();

               //$form->setInputFilter(new CommunityFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$communityEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getCommunityTable()->SaveCommunity($communityEntity);
                $res= $this->communityService->SaveCommunity($mergedata);
//
//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'community'
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
            //$community = $this->getCommunityTable()->deleteCommunity($id);
            $community= $this->adminService->delete('community', $id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'community'
//                ));
            return $this->redirect()->toRoute('admin/community', array('action' => 'index'));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getCommunityTable()->getCommunity($id);

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function viewByIdAction(){
        
        $id = $this->params()->fromRoute('id');

        //$Info = $this->getCountryTable()->getCountry($id);
        //$info = $this->getCommunityTable()->getCommunity($id);
        $info = $this->communityService->viewByCommunityId('community', $id);

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
        //$return = $this->getCommunityTable()->updatestatus($data);
        $result= $this->adminService->changeStatus('community', $request->getPost('id'), $request->getPost(), $user_id);
        // print_r($return);
        return new JsonModel($result);
        //exit();
    }
    
    public function delmultipleAction() {
        $ids = $_POST['chkdata'];
        //$result = $this->getCommunityTable()->delmultiple($ids);
        $result= $this->adminService->deleteMultiple('community', $ids);

        echo $result;
        exit();
    }
    
    public function changeStatusAllAction() {
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $sql = "update community set IsActive=" . $_POST['val'] . " where id IN (" . $_POST['ids'] . ")";
//        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $result= $this->adminService->changeStatusAll('community', $_POST['ids'], $_POST['val']);

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

        //$communitys = $this->getCommunityTable()->fetchAll($this->data);
        $communitys = $this->communityService->getCommunityRadioList($_POST['is_active'])->toArray();
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('communitys' => $communitys));
        $view->setTemplate('admin/community/communityList');
        $view->setTerminal(true);
        return $view;
        }  else {
            $this->data = $status;

        //$communitys = $this->getCommunityTable()->fetchAll($this->data);
        $communitys = $this->communityService->getCommunityRadioList($_POST['is_active']);
        // return new ViewModel(array('countries' => $countries));
        if($communitys){
            $communitys = $communitys->toArray();
        }else{
            $communitys;
        }

        $view = new ViewModel(array('communitys' => $communitys));
        $view->setTemplate('admin/community/communityList');
        $view->setTerminal(true);
        return $view;
        }
    }
    
    public function performsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        //$field1 = empty($_POST['community_name']) ? "" : "community_name like '" . $_POST['community_name'] . "%'";
        
        //$sql = "select * from community where " . $field1 . "";
       // $sql = rtrim($sql, "&&");
        //$results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $results = $this->communityService->performSearchCommunity($_POST['religion_id'],$_POST['community_name']);

        $view = new ViewModel(array("results" => $results));
        $view->setTerminal(true);
        return $view;


        exit();
    }
    
    public function communitysearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
//        echo  "<pre>";
//        print_r($data);die;

        //$result = $adapter->query("select * from community where community_name like '$data%' ", Adapter::QUERY_MODE_EXECUTE);
        $result = $this->communityService->communitySearch($data,$_POST['fieldname']);


        $view = new ViewModel(array("Results" => $result));
        $view->setTerminal(true);
        return $view;
        exit();
    }
   
}