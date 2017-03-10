<?php

namespace Admin\Controller;

use Admin\Form\SubcommunityFilter;
use Admin\Form\SubcommunityForm;
use Admin\Model\Entity\Subcommunitys;
use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Admin\Service\SubcommunityServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class SubcommunityController extends AppController
{   
    protected $data = '';//array();
    protected $commonService;
    protected $adminService;
    protected $subcommunityService;

    public function __construct(CommonServiceInterface $commonService, AdminServiceInterface $adminService, SubcommunityServiceInterface $subcommunityService) {
        $this->commonService = $commonService;
        $this->adminService = $adminService;
        $this->subcommunityService = $subcommunityService;
    }
    
    public function indexAction()
    {   //$tests = $this->subcommunityService->test();
        //print_r($tests);exit;
        //echo  "hello";exit;
         //$subcommunitys = $this->getSubsubcommunityTable()->fetchAll($this->data);
         $subcommunitys = $this->subcommunityService->getSubcommunitysList()->toArray();
//            echo   "<pre>";
//          print_r($subcommunitys);die;
         $communityNameList = $this->subcommunityService->getAllCommunitylist();

        SubcommunityForm::$community_nameList = $communityNameList;
		 
		 $form = new SubcommunityForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'subcommunitys' => $subcommunitys,'form'=> $form, 'action'=>'index'));
			

       // return new ViewModel(array(
         //   'subcommunitys' => $subcommunitys));
    }

    public function AddAction()
    {
        $communityNameList = $this->subcommunityService->getAllCommunitylist();

        SubcommunityForm::$community_nameList = $communityNameList;
        
        $form = new SubcommunityForm();
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
            //$subcommunityEntity = new Subcommunitys();

               //$form->setInputFilter(new SubcommunityFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$subcommunityEntity->exchangeArray($form->getData());
                // print_r($communityEntity);die;
                //$res = $this->getSubcommunityTable()->SaveSubcommunity($subcommunityEntity);
                $res= $this->subcommunityService->SaveSubcommunity($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'subcommunity'
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
        $communityNameList = $this->subcommunityService->getAllCommunitylist();

        SubcommunityForm::$community_nameList = $communityNameList;

        $form = new SubcommunityForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            //$subcommunity = $this->getSubcommunityTable()->getSubcommunity($id);
            $subcommunity= $this->subcommunityService->getSubcommunity($id);
            // print_r($community);die;
            $form->bind($subcommunity);
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
            //$subcommunityEntity = new Subcommunitys();

               //$form->setInputFilter(new SubcommunityFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$subcommunityEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getSubcommunityTable()->SaveSubcommunity($subcommunityEntity);
                $res= $this->subcommunityService->SaveSubcommunity($mergedata);
//
//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'subcommunity'
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
            //$subcommunity = $this->getSubcommunityTable()->deleteSubcommunity($id);
            $subcommunity= $this->adminService->delete('tbl_caste', $id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'subcommunity'
//                ));
            return $this->redirect()->toRoute('admin/subcommunity', array('action' => 'index'));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getSubcommunityTable()->getSubcommunity($id);

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function viewByIdAction(){
        
        $id = $this->params()->fromRoute('id');

        //$Info = $this->getCountryTable()->getCountry($id);
        //$info = $this->getSubcommunityTable()->getSubcommunity($id);
        $info = $this->subcommunityService->viewBySubcommunityId('tbl_caste', $id);

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
        //$return = $this->getSubcommunityTable()->updatestatus($data);
        $result= $this->adminService->changeStatus('tbl_caste', $request->getPost('id'), $request->getPost(), $user_id);
        // print_r($return);
        return new JsonModel($result);
        //exit();
    }
    
    public function delmultipleAction() {
        $ids = $_POST['chkdata'];
        //$result = $this->getSubcommunityTable()->delmultiple($ids);
        $result= $this->adminService->deleteMultiple('tbl_caste', $ids);

        echo $result;
        exit();
    }
    
    public function changeStatusAllAction() {
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $sql = "update subcommunity set IsActive=" . $_POST['val'] . " where id IN (" . $_POST['ids'] . ")";
//        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $result= $this->adminService->changeStatusAll('tbl_caste', $_POST['ids'], $_POST['val']);

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

        //$subcommunitys = $this->getSubcommunityTable()->fetchAll($this->data);
        $subcommunitys = $this->subcommunityService->getSubcommunityRadioList($_POST['is_active'])->toArray();
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('subcommunitys' => $subcommunitys));
        $view->setTemplate('admin/subcommunity/subcommunityList');
        $view->setTerminal(true);
        return $view;
        }  else {
            $this->data = $status;

        //$subcommunitys = $this->getSubcommunityTable()->fetchAll($this->data);
        $subcommunitys = $this->subcommunityService->getSubcommunityRadioList($_POST['is_active']);
        // return new ViewModel(array('countries' => $countries));
        if($subcommunitys){
            $subcommunitys = $subcommunitys->toArray();
        }else{
            $subcommunitys;
        }

        $view = new ViewModel(array('subcommunitys' => $subcommunitys));
        $view->setTemplate('admin/subcommunity/subcommunityList');
        $view->setTerminal(true);
        return $view;
        }
    }
    
    public function performsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        //$field1 = empty($_POST['caste_name']) ? "" : "caste_name like '" . $_POST['caste_name'] . "%'";
        
        //$sql = "select * from tbl_caste where " . $field1 . "";
       // $sql = rtrim($sql, "&&");
        //$results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $results = $this->subcommunityService->performSearchSubcommunity($_POST['community_id'],$_POST['caste_name']);

        $view = new ViewModel(array("results" => $results));
        $view->setTerminal(true);
        return $view;


        exit();
    }
    
    public function subcommunitysearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
//        echo  "<pre>";
//        print_r($data);die;

        //$result = $adapter->query("select * from tbl_caste where caste_name like '$data%' ", Adapter::QUERY_MODE_EXECUTE);
        $result = $this->subcommunityService->subcommunitySearch($data,$_POST['fieldname']);


        $view = new ViewModel(array("Results" => $result));
        $view->setTerminal(true);
        return $view;
        exit();
    }
   
}