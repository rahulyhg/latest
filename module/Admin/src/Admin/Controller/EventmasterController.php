<?php

namespace Admin\Controller;

use Admin\Form\EventmasterFilter;
use Admin\Form\EventmasterForm;
use Admin\Model\Entity\Eventmasters;
use Admin\Service\EventmasterServiceInterface;
use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class EventmasterController extends AppController
{
    protected $data = '';//array();
    protected $commonService;
    protected $adminService;
    protected $eventmasterService;

    public function __construct(CommonServiceInterface $commonService, AdminServiceInterface $adminService, EventmasterServiceInterface $eventmasterService) {
        $this->commonService = $commonService;
        $this->adminService=$adminService;
        $this->eventmasterService=$eventmasterService;
    }
    
    public function indexAction()
    {   //echo   "hello";exit;
//    $tests = $this->eventmasterService->test();
//    print_r($tests);exit;
    //        $events = $this->eventsService->test();
//        echo  $events;exit;
         //$eventmasters = $this->getEventmasterTable()->fetchAll($this->data);
         $eventmasters = $this->eventmasterService->getEventmasterList();
//            echo   "<pre>";
//          print_r($eventmasters);die;
         // print_r($cities);die;
		 
		   
		$form = new EventmasterForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'eventmasters' => $eventmasters,'form'=> $form, 'action'=>'index'));
			
    }

    public function AddAction()
    {
        $form = new EventmasterForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

            //$eventmasterEntity = new Eventmasters();

               //$form->setInputFilter(new EventmasterFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                //$eventmasterEntity->exchangeArray($form->getData());
                // print_r($eventmasterEntity);die;
                //$res = $this->getEventmasterTable()->SaveEventmaster($eventmasterEntity);
                $res= $this->eventmasterService->SaveEventmaster($form->getData());

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'eventmaster'
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
        $form = new EventmasterForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            //$eventmaster = $this->getEventmasterTable()->getEventmaster($id);
            $eventmaster= $this->eventmasterService->getEventmaster($id);
            // print_r($eventmaster);die;
            $form->bind($eventmaster);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if (!isset($_POST['chkedit'])) {
        if($request->isPost()){

            //$eventmasterEntity = new Eventmasters();

               //$form->setInputFilter(new EventmasterFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                //$eventmasterEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getEventmasterTable()->SaveEventmaster($eventmasterEntity);
                $res= $this->eventmasterService->SaveEventmaster($form->getData());

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'eventmaster'
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
            //$eventmaster = $this->getEventmasterTable()->deleteEventmaster($id);
            $eventmaster= $this->adminService->delete('tbl_event', $id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'eventmaster'
//                ));
            return $this->redirect()->toRoute('admin/eventmaster', array('action' => 'index'));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getEventmasterTable()->getEventmaster($id);

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function viewByIdAction(){
        
        $id = $this->params()->fromRoute('id');

        //$Info = $this->getCountryTable()->getCountry($id);
        //$info = $this->getEventmasterTable()->getEventmaster($id);
        $info = $this->eventmasterService->viewByEventmasterId('tbl_event', $id);

        // echo"<pre>"; print_r($Info);die;
        $view=new ViewModel(array('info'=>$info));
        $view->setTerminal(true);
        return $view;
        
    }
    
    public function changestatusAction() {

        //$data = (object) $_POST;
        $request=$this->getRequest();
        //$return = $this->getEventmasterTable()->updatestatus($data);
        $result= $this->adminService->changeStatus('tbl_event', $request->getPost('id'), $request->getPost());
        // print_r($return);
        return new JsonModel($result);
        //exit();
    }
    
    public function delmultipleAction() {
        $ids = $_POST['chkdata'];
        //$result = $this->getEventmasterTable()->delmultiple($ids);
        $result= $this->adminService->deleteMultiple('tbl_event', $ids);

        echo $result;
        exit();
    }
    
    public function changeStatusAllAction() {
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $sql = "update tbl_event set IsActive=" . $_POST['val'] . " where id IN (" . $_POST['ids'] . ")";
//        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $result= $this->adminService->changeStatusAll('tbl_event', $_POST['ids'], $_POST['val']);
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
        $this->data = $status;

        //$eventmasters = $this->getEventmasterTable()->fetchAll($this->data);
        $eventmasters = $this->eventmasterService->getEventmasterRadioList($_POST['is_active']);
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('eventmasters' => $eventmasters));
        $view->setTemplate('admin/eventmaster/eventmasterList');
        $view->setTerminal(true);
        return $view;
    }
    
    public function performsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        //$field1 = empty($_POST['event_name']) ? "" : "event_name like '" . $_POST['event_name'] . "%'";
        
        //$sql = "select * from tbl_event where " . $field1 . "";
       // $sql = rtrim($sql, "&&");
        //$results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $results = $this->eventmasterService->performSearchEventmaster($_POST['event_name']);

        $view = new ViewModel(array("results" => $results));
        $view->setTerminal(true);
        return $view;


        exit();
    }
    
    public function eventmastersearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
//        echo  "<pre>";
//        print_r($data);die;

        //$result = $adapter->query("select * from tbl_event where event_name like '$data%' ", Adapter::QUERY_MODE_EXECUTE);
        $result = $this->eventmasterService->eventmasterSearch($data);


        $view = new ViewModel(array("Results" => $result));
        $view->setTerminal(true);
        return $view;
        exit();
    }
   
}