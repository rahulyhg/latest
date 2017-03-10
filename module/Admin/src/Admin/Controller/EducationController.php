<?php

namespace Admin\Controller;

use Admin\Form\EducationfieldFilter;
use Admin\Form\EducationfieldForm;
use Admin\Form\EducationlevelFilter;
use Admin\Form\EducationlevelForm;
use Admin\Model\Entity\EducationFields;
use Admin\Model\Entity\Educationlevels;
use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class EducationController extends AppController
{
    protected  $data='';// = array();
     protected $commonService;
    protected $adminService;

    public function __construct(CommonServiceInterface $commonService, AdminServiceInterface $adminService) {
        $this->commonService = $commonService;
        $this->adminService=$adminService;
    }
    
    public function indexAction()
    {   
         $educations = $this->adminService->getEducationFieldList()->toArray();
         //\Zend\Debug\Debug::dump($educations);
         //exit;
            //echo   "<pre>";
          //print_r($religions);die;
         // print_r($cities);die;
		 
		   
		$form = new EducationfieldForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'educations' => $educations,'form'=> $form, 'action'=>'index'));
			
    }

    public function AddAction()
    {
        $form = new EducationfieldForm();
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
            //$educationfieldEntity = new EducationFields();
//                echo  "<pre>";
//            print_r($educationfieldEntity);exit;
               //$form->setInputFilter(new EducationfieldFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){
                  // print_r($form->getData());
                   //exit;
                //$educationfieldEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
//                $res = $this->getEducationfieldTable()->SaveEducationfield($educationfieldEntity);
                $res= $this->adminService->saveEducationField($mergedata);
                

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
//        echo  "<pre>";
//           echo  "hello";exit;
        $form = new EducationfieldForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
//             echo   $id;die;
//            $education = $this->getEducationfieldTable()->getEducationfield($id);
            $education= $this->adminService->getEducationField($id);
            // print_r($religion);die;
            $form->bind($education);
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
//            $educationfieldEntity = new Educationfields();
//
//               $form->setInputFilter(new EducationfieldFilter());
               //$form->setData($request->getPost());


               if($form->isValid()){

                //$educationfieldEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getEducationfieldTable()->SaveEducationfield($educationfieldEntity);
                $res= $this->adminService->saveEducationField($mergedata);

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
            //print_r($id);exit;
            //$education = $this->getEducationfieldTable()->deleteEducationField($id);
            $result= $this->adminService->delete('tbl_education_field', $id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'religion'
//                ));
            return $this->redirect()->toRoute('admin/education', array('action' => 'index'));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getEducationfieldTable()->getEducationfield($id);//getReligion

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function viewByIdAction(){
        
        $id = $this->params()->fromRoute('id');
//        echo   "<pre>";
//        print_r($id);exit;
        //$Info = $this->getCountryTable()->getCountry($id);
        //$info = $this->getEducationfieldTable()->getEducationfield($id);
          $info = $this->adminService->viewById('tbl_education_field', $id);
          //\Zend\Debug\Debug::dump($info);
         //echo"<pre>"; print_r($info);die;
        $view=new ViewModel(array('info'=>$info));
        $view->setTerminal(true);
        return $view;
        
    }
    
    
    
    public function delmultipleAction() {
        $ids = $_POST['chkdata'];
//       echo   "<pre>";
//        print_r($ids);exit;
        //$result = $this->getEducationfieldTable()->delmultiple($ids);
        $result= $this->adminService->deleteMultiple('tbl_education_field', $ids);

        echo $result;
        exit();
    }
    
    public function changestatusAction() {
        $session= new \Zend\Session\Container('admin');
       $user_id = $session->offsetGet('id');
//        echo   "<pre>";
//        print_r('hello');exit;
        $request=$this->getRequest();
//print_r($request->getPost());
//exit;
        
       $result= $this->adminService->changeStatus('tbl_education_field', $request->getPost('id'), $request->getPost(), $user_id);

//        $data = (object) $_POST;
//        $return = $this->getEducationfieldTable()->updatestatus($data);
//        // print_r($return);
        return new JsonModel($result);
//        exit();
    }
    
    public function changeStatusAllAction() {
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $sql = "update tbl_education_field set IsActive=" . $_POST['val'] . " where id IN (" . $_POST['ids'] . ")";
//        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);

        //$request=$this->getRequest();
        
        $result= $this->adminService->changeStatusAll('tbl_education_field', $_POST['ids'], $_POST['val']);
                if ($result)
            echo "updated all";
        else
            echo "couldn't update";
        exit();
//        return new JsonModel($result);
        
    }
    
    public function ajaxradiosearchAction() {
        $status = $_POST['is_active'];
//        echo  "<pre>";
//        print_r($status);exit;
        //$this->data = array("IsActive=$status");
        if($status==1){
        $this->data = $status;
//        Debug::dump($this->data);
//        exit;
        //$educations = $this->getEducationfieldTable()->fetchAll($this->data);
        $educations = $this->adminService->getEducationFieldRadioList($_POST['is_active'])->toArray();
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('educations' => $educations));
        $view->setTemplate('admin/education/educationfieldList');
        $view->setTerminal(true);
        return $view;
        }  else {
            $this->data = $status;
//        Debug::dump($this->data);
//        exit;
        //$educations = $this->getEducationfieldTable()->fetchAll($this->data);
        $educations = $this->adminService->getEducationFieldRadioList($_POST['is_active']);
        // return new ViewModel(array('countries' => $countries));
        if($educations){
            $educations = $educations->toArray();
        }else{
            $educations;
        }

        $view = new ViewModel(array('educations' => $educations));
        $view->setTemplate('admin/education/educationfieldList');
        $view->setTerminal(true);
        return $view;
        }
    }
    
    public function performsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        //$field1 = empty($_POST['education_field']) ? "" : "education_field like '" . $_POST['education_field'] . "%'";
        
        //$sql = "select * from tbl_education_field where " . $field1 . "";
       // $sql = rtrim($sql, "&&");
        //$results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $results = $this->adminService->performSearchEducationField($_POST['education_field']);
//        \Zend\Debug\Debug::dump($results);exit;
        $view = new ViewModel(array("results" => $results));
        $view->setTerminal(true);
        return $view;


        exit();
    }
    
    public function educationfieldsearchAction() {
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
//        echo  "<pre>";
//        print_r($data);die;

//        $result = $adapter->query("select * from tbl_education_field where education_field like '$data%' ", Adapter::QUERY_MODE_EXECUTE);
        $result = $this->adminService->educationFieldSearch($data);


        $view = new ViewModel(array("Results" => $result));
        $view->setTerminal(true);
        return $view;
        exit();
    }
    
    //Education Level Part added by amir
    
//    public function manageEducationLevelAction()
//    {   
//         //$educations = $this->getEducationlevelTable()->fetchAll($this->data);
//         $educations = $this->adminService->getEducationlevelList()->toArray();
//            //echo   "<pre>";
//          //print_r($educations);die;
//         // print_r($cities);die;
//		 
//		   
//		$form = new EducationlevelForm();
//         $form->get('submit')->setAttribute('value', 'Add');
//        
//        return new ViewModel(array(
//            'educations' => $educations,'form'=> $form, 'action'=>'manageEducationLevel'));
//         //echo    "hi";die;
//			
//    }
//
//    public function AddeduLevelAction()
//    {
//        $form = new EducationlevelForm();
//        $form->get('submit')->setAttribute('value', 'Add');
//        
//        $session= new \Zend\Session\Container('admin');
//        $user_id = $session->offsetGet('id');
//         $email_id = $session->offsetGet('email');
//         $remote = new \Zend\Http\PhpEnvironment\RemoteAddress;
//         $user_ip = $remote->getIpAddress();
//         $user_data = array($user_id,$email_id,$user_ip);
//         
//        $request = $this->getRequest();
//        if($request->isPost()){
//            
//            $mergedata = array_merge(
//                    $this->getRequest()->getPost()->toArray() ,$user_data
//            ); 
//            $form->setData($mergedata);
//            //$educationlevelEntity = new Educationlevels();
//
//               //$form->setInputFilter(new EducationlevelFilter());
//               //$form->setData($request->getPost());
//
//
//               if($form->isValid()){
//
//                //$educationlevelEntity->exchangeArray($form->getData());
//                // print_r($religionEntity);die;
//                //$res = $this->getEducationlevelTable()->SaveEducationlevel($educationlevelEntity);
//                $res= $this->adminService->SaveEducationlevel($mergedata);
//
////                     return $this->redirect()->toRoute('admin', array(
////                            'action' => 'index',
////                            'controller' => 'religion'
////                ));
//                return new JsonModel(array("response" => $res));
//               } else {
//
//                foreach ($form->getmessages() as $key => $value) {
//                    $errors[] = array("element" => $key, "errors" => $value['isEmpty']);
//                }
//                return new JsonModel(array("errors" => $errors, "FormId" => $_POST['FormId']));
//            }
//        }
//
//        return new ViewModel(array('form'=> $form));
//        
//    }
//
//    public function editeduLevelAction()
//    {
//        $form = new EducationlevelForm();
//        if($this->params()->fromRoute('id')>0){
//            $id = $this->params()->fromRoute('id');
//            // echo   $id;die;
//            //$education = $this->getEducationlevelTable()->getEducationlevel($id);
//            $education= $this->adminService->getEducationlevel($id);
//            // print_r($religion);die;
//            $form->bind($education);
//            $form->get('submit')->setAttribute('value', 'Edit');
//            // $this->editAction($form)
//        }
//        
//        $session= new \Zend\Session\Container('admin');
//        $user_id = $session->offsetGet('id');
//         $email_id = $session->offsetGet('email');
//         $remote = new \Zend\Http\PhpEnvironment\RemoteAddress;
//         $user_ip = $remote->getIpAddress();
//         $user_data = array($user_id,$email_id,$user_ip);
//         
//        $request = $this->getRequest();
//        if (!isset($_POST['chkedit'])) {
//        if($request->isPost()){
//            
//            $mergedata = array_merge(
//                    $this->getRequest()->getPost()->toArray() ,$user_data
//            ); 
//            $form->setData($mergedata);
//            //$educationlevelEntity = new Educationlevels();
//
//               //$form->setInputFilter(new EducationlevelFilter());
//               //$form->setData($request->getPost());
//
//
//               if($form->isValid()){
//
//                //$educationlevelEntity = $form->getData();
//                // print_r($cityEntity);die;
//                //$res = $this->getEducationlevelTable()->SaveEducationlevel($educationlevelEntity);
//                $res= $this->adminService->SaveEducationlevel($mergedata);
//
////                     return $this->redirect()->toRoute('admin', array(
////                            'action' => 'index',
////                            'controller' => 'religion'
////                ));
//                    $response = $this->getResponse();
//                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
//                    $response->setContent(json_encode(array("response" => $res)));
//                    return $response;
//               } else {
//
//                    foreach ($form->getmessages() as $key => $value) {
//                        $errors[] = array("element" => $key, "errors" => $value['isEmpty']);
//                    }
//
//                    $response = $this->getResponse();
//                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
//                    $response->setContent(json_encode(array("errors", $errors)));
//                    return $response;
//                }
//        }
//        
//      }
//
//        //return new ViewModel(array('form'=> $form,'id'=>$id));
//        $view = new ViewModel(array('form' => $form, 'id' => $id));
//        $view->setTerminal(true);
//        return $view;
//
//    }
//
//    public function deleteeduLevelAction()
//    {
//         
//            $id = $this->params()->fromRoute('id');
//            //$education = $this->getEducationlevelTable()->deleteEducationLevel($id);
//            $education= $this->adminService->delete('tbl_education_level', $id);
////            return $this->redirect()->toRoute('admin', array(
////                            'action' => 'index',
////                            'controller' => 'religion'
////                ));
//            return $this->redirect()->toRoute('admin/education', array('action' => 'manageEducationLevel'));
//    }
//    
//    public function vieweduLevelAction()
//    {
//        $id = $this->params()->fromRoute('id');
//
//        $Info = $this->getEducationlevelTable()->getEducationlevel($id);//getReligion
//
//        return new ViewModel(array('Info'=> $Info));
//    }
//    
//    public function viewByIdeduLevelAction(){
//        
//        $id = $this->params()->fromRoute('id');
//
//        //$Info = $this->getCountryTable()->getCountry($id);
//        //$info = $this->getEducationlevelTable()->getEducationlevel($id);
//        $info = $this->adminService->viewByEducationlevelId('tbl_education_level', $id);
//
//        // echo"<pre>"; print_r($Info);die;
//        $view=new ViewModel(array('info'=>$info));
//        $view->setTerminal(true);
//        return $view;
//        
//    }
//    
//    public function changestatuseduLevelAction() {
//        $session= new \Zend\Session\Container('admin');
//       $user_id = $session->offsetGet('id');
//        //$data = (object) $_POST;
//        $request=$this->getRequest();
//        //$return = $this->getEducationlevelTable()->updatestatus($data);
//        $result= $this->adminService->changeStatus('tbl_education_level', $request->getPost('id'), $request->getPost(), $user_id);
//        // print_r($return);
//        return new JsonModel($result);
//        //exit();
//    }
//    
//    public function delmultipleeduLevelAction() {
//        $ids = $_POST['chkdata'];
//        //$result = $this->getEducationlevelTable()->delmultiple($ids);
//        $result= $this->adminService->deleteMultiple('tbl_education_level', $ids);
//
//        echo $result;
//        exit();
//    }
//    
//    public function statuschangealleduLevelAction() {
////        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
////        $sql = "update tbl_education_level set IsActive=" . $_POST['val'] . " where id IN (" . $_POST['ids'] . ")";
////        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
//        $result= $this->adminService->changeStatusAll('tbl_education_level', $_POST['ids'], $_POST['val']);
//
////        return new JsonModel($result);
//                if ($result)
//            echo "updated all";
//        else
//            echo "couldn't update";
//        exit();
//    }
//    
//    public function ajaxradiosearcheduLevelAction() {
//        $status = $_POST['is_active'];
//        //$this->data = array("IsActive=$status");
//        $this->data = $status;
//
//        //$educations = $this->getEducationlevelTable()->fetchAll($this->data);
//        $educations = $this->adminService->getEducationlevelRadioList($_POST['is_active'])->toArray();
//        // return new ViewModel(array('countries' => $countries));
//
//        $view = new ViewModel(array('educations' => $educations));
//        $view->setTemplate('admin/education/educationlevelList');
//        $view->setTerminal(true);
//        return $view;
//    }
//    
//    public function performsearchlevelAction() {
////        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
////
////        $field1 = empty($_POST['education_level']) ? "" : "education_level like '" . $_POST['education_level'] . "%'";
////        
////        $sql = "select * from tbl_education_level where " . $field1 . "";
//       // $sql = rtrim($sql, "&&");
//        //$results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
//        $results = $this->adminService->performSearchEducationlevel($_POST['education_level']);
//
//        $view = new ViewModel(array("results" => $results));
//        $view->setTerminal(true);
//        return $view;
//
//
//        exit();
//    }
//    
//    public function educationlevelsearchAction() {
//        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//
//        $data = $_POST['value'];
////       echo  "<pre>";
////       print_r($data);die;
//
//        //$result = $adapter->query("select * from tbl_education_level where education_level like '$data%' ", Adapter::QUERY_MODE_EXECUTE);
//        $result = $this->adminService->educationLevelSearch($data);
//
//
//        $view = new ViewModel(array("Results" => $result));
//        $view->setTerminal(true);
//        return $view;
//        exit();
//    }
    
    
   
}