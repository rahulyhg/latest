<?php

namespace Admin\Controller;

use Admin\Form\RegionFilter;
use Admin\Form\RegionForm;
use Admin\Model\Entity\Regions;
use Admin\Service\AdminServiceInterface;
use Admin\Service\RegionServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class RegionController extends AppController
{
    protected $data = '';//array();
    protected $commonService;
    protected $adminService;
    protected $regionService;

    public function __construct(CommonServiceInterface $commonService, AdminServiceInterface $adminService, RegionServiceInterface $regionService) {
        $this->commonService = $commonService;
        $this->adminService=$adminService;
        $this->regionService=$regionService;
    }
    
    public function indexAction()
    {   //echo  "hello";exit;
         //$regions = $this->getRegionTable()->fetchAll($this->data);
         $regions = $this->regionService->getRegionList()->toArray();
            //echo   "<pre>";
          //print_r($regions);die;
         // print_r($cities);die;
		 
		   
		$form = new RegionForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'regions' => $regions,'form'=> $form, 'action'=>'index'));
			
    }

    public function AddAction()
    {
        $form = new RegionForm();
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
            //$regionEntity = new Regions();

               //$form->setInputFilter(new RegionFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$regionEntity->exchangeArray($form->getData());
                // print_r($regionEntity);die;
                //$res = $this->getRegionTable()->SaveRegion($regionEntity);
                $res= $this->regionService->SaveRegion($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'region'
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
        $form = new RegionForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            //$region = $this->getRegionTable()->getRegion($id);
            $region= $this->regionService->getRegion($id);
            // print_r($region);die;
            $form->bind($region);
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
            //$regionEntity = new Regions();

               //$form->setInputFilter(new RegionFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$regionEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getRegionTable()->SaveRegion($regionEntity);
                $res= $this->regionService->SaveRegion($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'region'
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
            //$region = $this->getRegionTable()->deleteRegion($id);
            $region= $this->adminService->delete('tbl_region', $id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'region'
//                ));
            return $this->redirect()->toRoute('admin/region', array('action' => 'index'));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getRegionTable()->getRegion($id);

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function viewByIdAction(){
        
        $id = $this->params()->fromRoute('id');

        //$Info = $this->getCountryTable()->getCountry($id);
        //$info = $this->getRegionTable()->getRegion($id);
        $info = $this->regionService->viewByRegionId('tbl_region', $id);

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
        //$return = $this->getRegionTable()->updatestatus($data);
        $result= $this->adminService->changeStatus('tbl_region', $request->getPost('id'), $request->getPost(), $user_id);
        // print_r($return);
        return new JsonModel($result);
        //exit();
    }
    
    public function delmultipleAction() {
        $ids = $_POST['chkdata'];
        //$result = $this->getRegionTable()->delmultiple($ids);
        $result= $this->adminService->deleteMultiple('tbl_region', $ids);

        echo $result;
        exit();
    }
    
    public function changeStatusAllAction() {
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $sql = "update tbl_region set IsActive=" . $_POST['val'] . " where id IN (" . $_POST['ids'] . ")";
//        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $result= $this->adminService->changeStatusAll('tbl_region', $_POST['ids'], $_POST['val']);
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

        //$regions = $this->getRegionTable()->fetchAll($this->data);
        $regions = $this->regionService->getRegionRadioList($_POST['is_active'])->toArray();
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('regions' => $regions));
        $view->setTemplate('admin/region/regionList');
        $view->setTerminal(true);
        return $view;
        }  else {
            $this->data = $status;

        //$regions = $this->getRegionTable()->fetchAll($this->data);
        $regions = $this->regionService->getRegionRadioList($_POST['is_active']);
        // return new ViewModel(array('countries' => $countries));
        if($regions){
            $regions = $regions->toArray();
        }else{
            $regions;
        }

        $view = new ViewModel(array('regions' => $regions));
        $view->setTemplate('admin/region/regionList');
        $view->setTerminal(true);
        return $view;
        }
    }
    
    public function performsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        //$field1 = empty($_POST['region_name']) ? "" : "region_name like '" . $_POST['region_name'] . "%'";
        
        //$sql = "select * from tbl_region where " . $field1 . "";
       // $sql = rtrim($sql, "&&");
        //$results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $results = $this->regionService->performSearchRegion($_POST['region_name']);

        $view = new ViewModel(array("results" => $results));
        $view->setTerminal(true);
        return $view;


        exit();
    }
    
    public function regionsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
//        echo  "<pre>";
//        print_r($data);die;

        //$result = $adapter->query("select * from tbl_region where region_name like '$data%' ", Adapter::QUERY_MODE_EXECUTE);
        $result = $this->regionService->regionSearch($data);


        $view = new ViewModel(array("Results" => $result));
        $view->setTerminal(true);
        return $view;
        exit();
    }
   
}