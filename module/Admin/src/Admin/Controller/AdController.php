<?php

namespace Admin\Controller;

/*use Admin\Form\AwardFilter;
use Admin\Form\AwardForm;
use Admin\Model\Entity\Awards;
use Admin\Service\AdminServiceInterface;
use Admin\Service\AwardServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;*/
use Zend\View\Model\ViewModel;

class AdController extends AppController
{
       
    public function indexAction()
    {   
		//echo  "hello";exit;
        


        return new ViewModel(array());
			
    }

    public function AddAction()
    {
        $form = new AwardForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

            //$awardEntity = new Awards();

               //$form->setInputFilter(new AwardFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                //$awardEntity->exchangeArray($form->getData());
                // print_r($awardEntity);die;
                //$res = $this->getAwardTable()->SaveAward($awardEntity);
                $res= $this->awardService->SaveAward($form->getData());

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'award'
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
        $form = new AwardForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            //$award = $this->getAwardTable()->getAward($id);
            $award= $this->awardService->getAward($id);
            // print_r($award);die;
            $form->bind($award);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if (!isset($_POST['chkedit'])) {
        if($request->isPost()){

            //$awardEntity = new Awards();

               //$form->setInputFilter(new AwardFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                //$awardEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getAwardTable()->SaveAward($awardEntity);
                $res= $this->awardService->SaveAward($form->getData());

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'award'
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
            //$award = $this->getAwardTable()->deleteAward($id);
            $award= $this->adminService->delete('tbl_award', $id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'award'
//                ));
            return $this->redirect()->toRoute('admin/ad', array('action' => 'index'));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getAwardTable()->getAward($id);

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function viewByIdAction(){
        
        $id = $this->params()->fromRoute('id');

        //$Info = $this->getCountryTable()->getCountry($id);
        //$info = $this->getAwardTable()->getAward($id);
        $info = $this->awardService->viewByAwardId('tbl_award', $id);

        // echo"<pre>"; print_r($Info);die;
        $view=new ViewModel(array('info'=>$info));
        $view->setTerminal(true);
        return $view;
        
    }
    
    public function changestatusAction() {

        //$data = (object) $_POST;
        $request=$this->getRequest();
        //$return = $this->getAwardTable()->updatestatus($data);
        $result= $this->adminService->changeStatus('tbl_award', $request->getPost('id'), $request->getPost());
        // print_r($return);
        return new JsonModel($result);
        //exit();
    }
    
    public function delmultipleAction() {
        $ids = $_POST['chkdata'];
        //$result = $this->getAwardTable()->delmultiple($ids);
        $result= $this->adminService->deleteMultiple('tbl_award', $ids);

        echo $result;
        exit();
    }
    
    public function changeStatusAllAction() {
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $sql = "update tbl_award set IsActive=" . $_POST['val'] . " where id IN (" . $_POST['ids'] . ")";
//        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $result= $this->adminService->changeStatusAll('tbl_award', $_POST['ids'], $_POST['val']);
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

        //$awards = $this->getAwardTable()->fetchAll($this->data);
        $awards = $this->awardService->getAwardRadioList($_POST['is_active']);
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('awards' => $awards));
        $view->setTemplate('admin/award/awardList');
        $view->setTerminal(true);
        return $view;
    }
    
    public function performsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        //$field1 = empty($_POST['award_name']) ? "" : "award_name like '" . $_POST['award_name'] . "%'";
        
        //$sql = "select * from tbl_award where " . $field1 . "";
       // $sql = rtrim($sql, "&&");
        //$results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $results = $this->awardService->performSearchAward($_POST['award_name']);

        $view = new ViewModel(array("results" => $results));
        $view->setTerminal(true);
        return $view;


        exit();
    }
    
    public function awardsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
//        echo  "<pre>";
//        print_r($data);die;

        //$result = $adapter->query("select * from tbl_award where award_name like '$data%' ", Adapter::QUERY_MODE_EXECUTE);
        $result = $this->awardService->awardSearch($data);


        $view = new ViewModel(array("Results" => $result));
        $view->setTerminal(true);
        return $view;
        exit();
    }
   
}