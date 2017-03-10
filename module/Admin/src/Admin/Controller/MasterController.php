<?php

namespace Admin\Controller;

use Admin\Form\DesignationFilter;
use Admin\Form\DesignationForm;
use Admin\Form\EducationfieldFilter;
use Admin\Form\EducationfieldForm;
use Admin\Form\EducationlevelFilter;
use Admin\Form\EducationlevelForm;
use Admin\Form\ProfessionFilter;
use Admin\Form\ProfessionForm;
use Admin\Form\UsertypeFilter;
use Admin\Form\UsertypeForm;
use Admin\Model\Entity\Designations;
use Admin\Model\Entity\Educationfields;
use Admin\Model\Entity\Educationlevels;
use Admin\Model\Entity\Professions;
use Admin\Model\Entity\Usertypes;
use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class MasterController extends AppController
{
    protected $data = array();
    protected $commonService;
    protected $adminService;

    public function __construct(CommonServiceInterface $commonService, AdminServiceInterface $adminService) {
        $this->commonService = $commonService;
        $this->adminService=$adminService;
    }
    public function masterviewAction()
    {
        // echo "fsdgsd";die;
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $masterarray1 = array('region'=>'tbl_region','country'=>'tbl_country','state'=>'tbl_state','city'=>'tbl_city');
        
        $masterarray2 = array('religion'=>'tbl_religion','community'=>'community','subcommunity'=>'tbl_caste','gothra'=>'tbl_gothra_gothram');
        
        $masterarray3 = array('profession'=>'tbl_profession','designation'=>'tbl_designation','education'=>'tbl_education_field','educationlevel'=>'tbl_education_level');

        $masterarray4 = array('branch'=>'tbl_branch','institute'=>'tbl_institute');
        
        $masterarray5 = array('starsign'=>'tbl_star_sign','zodiacsign'=>'tbl_zodiac_sign_raasi','usertypemaster'=>'tbl_user_type','sponsertype'=>'tbl_sponser_type_master','award'=>'tbl_award');
        /*$masterarray2 = array('Usertypemaster'=> array('usertypemaster','tbl_user_type'),'Region'=> array('region','tbl_region'),'Sponsertype'=> array('sponsertype','tbl_sponser_type_master'),'Professions'=> array('profession','tbl_profession'),
            'Designations'=> array('designation','tbl_designation'),'User Types'=> array('usertype','tbl_user_type'),'Award'=> array('award','tbl_award')); */

        foreach ($masterarray1 as $key => $value) {

            $query = "select * from ".$value."";

            $counts = $adapter->query($query, Adapter::QUERY_MODE_EXECUTE)->count();
            // $url = $this->url("admin",array("controller"=>$key,"action"=>"index"));
            $locations[$key] = $counts;
        }
        
        foreach ($masterarray2 as $key => $value) {

            $query = "select * from ".$value."";

            $counts = $adapter->query($query, Adapter::QUERY_MODE_EXECUTE)->count();
            // $url = $this->url("admin",array("controller"=>$key,"action"=>"index"));
            $religions[$key] = $counts;
        }
        
        foreach ($masterarray3 as $key => $value) {

            $query = "select * from ".$value."";

            $counts = $adapter->query($query, Adapter::QUERY_MODE_EXECUTE)->count();
            // $url = $this->url("admin",array("controller"=>$key,"action"=>"index"));
            $educations[$key] = $counts;
        }
        
        foreach ($masterarray4 as $key => $value) {

            $query = "select * from ".$value."";

            $counts = $adapter->query($query, Adapter::QUERY_MODE_EXECUTE)->count();
            // $url = $this->url("admin",array("controller"=>$key,"action"=>"index"));
            $branchs[$key] = $counts;
        }
        
        foreach ($masterarray5 as $key => $value) {

            $query = "select * from ".$value."";

            $counts = $adapter->query($query, Adapter::QUERY_MODE_EXECUTE)->count();
            // $url = $this->url("admin",array("controller"=>$key,"action"=>"index"));
            $misclinous[$key] = $counts;
        }

        /*foreach ($masterarray2 as $key => $value) {

            $query = "select * from ".$value[1]."";

            $counts = $adapter->query($query, Adapter::QUERY_MODE_EXECUTE)->count();
            // $url = $this->url("admin",array("controller"=>$key,"action"=>"index"));
            $countarray1[$key] = array($value[0],$counts);
        }*/
        
        //pages master count
        $query = "select * from tbl_pages";
        $total_pages = $adapter->query($query, Adapter::QUERY_MODE_EXECUTE)->count();
        
        //events master count
        $query = "select * from tbl_event";
        $total_events = $adapter->query($query, Adapter::QUERY_MODE_EXECUTE)->count();
                
        //edufield master count
        $query = "select * from tbl_education_field";
        $total_edufield = $adapter->query($query, Adapter::QUERY_MODE_EXECUTE)->count();   
        
        //edulevel master count
        $query = "select * from tbl_education_level";
        $total_edulevel = $adapter->query($query, Adapter::QUERY_MODE_EXECUTE)->count(); 

        //branch master count
        $query = "select * from tbl_branch";
        $total_branchs = $adapter->query($query, Adapter::QUERY_MODE_EXECUTE)->count(); 

        //institute master count
        $query = "select * from tbl_institute";
        $total_institutes = $adapter->query($query, Adapter::QUERY_MODE_EXECUTE)->count(); 
        //echo "hello";exit;
        
        //community master count
        $query = "select * from community";
        $total_community = $adapter->query($query, Adapter::QUERY_MODE_EXECUTE)->count(); 
        
        //subcommunity master count
        $query = "select * from tbl_caste";
        $total_subcommunity = $adapter->query($query, Adapter::QUERY_MODE_EXECUTE)->count(); 

        // $masterarray3 = array("Matrimony Users")

        $generalusercount = $this->getUserTable()->getusers(array('user_type_id=1'));
        $generaluserpending = $this->getUserTable()->getusers(array('user_type_id=1 && is_active=0'));
        $matrimonyusercount = $this->getUserTable()->getusers(array('user_type_id=2'));
        $matrimonyuserpending = $this->getUserTable()->getusers(array('user_type_id=2 && is_active=0'));
		
		$total=$generalusercount+$matrimonyusercount;
		
        $members = array("General User"=>array($generalusercount,$generaluserpending,'memberuser'),
            "Matrimony User"=>array($matrimonyusercount,$matrimonyuserpending,'matrimonyuser'));

        // echo "<pre>";
        // print_r($generalusercount);die;

        return new ViewModel(array(
            "locations"=>$locations,
            "religions"=>$religions,
            "educations"=>$educations,
            "branchs"=>$branchs,
            "misclinous"=>$misclinous,
            "Members"=>$members,
            "total_members"=>$total,
            "total_pages"=>$total_pages,
            "total_events"=>$total_events,
            "total_branchs"=>$total_branchs,
            "total_institutes"=>$total_institutes,
            "total_edufield"=>$total_edufield,
            "total_community"=>$total_community,
            "total_subcommunity"=>$total_subcommunity,
            "total_edulevel"=>$total_edulevel));
    }

    public function indexedufieldAction()
    {   
         $educationfields = $this->getEducationfieldTable()->fetchAll();
		 
		 
		  $form = new EducationfieldForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'educationfields' => $educationfields,'form'=> $form));

      //  return new ViewModel(array(
            //'educationfields' => $educationfields));
    }




 public function indexexecutivepostAction()
    {   
        
        return new ViewModel(array('indexexecutivepost'));

      //  return new ViewModel(array(
            //'educationfields' => $educationfields));
    }

    public function addedufieldAction()
    {
        

        $form = new EducationfieldForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

            $educationfieldEntity = new Educationfields();

               $form->setInputFilter(new EducationfieldFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $educationfieldEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                $this->getEducationfieldTable()->SaveEducationfield($educationfieldEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexedufield',
                            'controller' => 'master'
                ));
               }
        }

        return new ViewModel(array('form'=> $form));
        
    }

    public function editedufieldAction()
    {
        

        $form = new EducationfieldForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            $educationfield = $this->getEducationfieldTable()->getEducationfield($id);
            // print_r($religion);die;
            $form->bind($educationfield);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if($request->isPost()){

            $educationfieldEntity = new Educationfields();

               $form->setInputFilter(new EducationfieldFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $educationfieldEntity = $form->getData();
                // print_r($cityEntity);die;
                $this->getEducationfieldTable()->SaveEducationfield($educationfieldEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexedufield',
                            'controller' => 'master'
                ));
               }
        }

        return new ViewModel(array('form'=> $form,'id'=>$id));

    }

    public function deleteedufieldAction()
    {
         
            $id = $this->params()->fromRoute('id');
            $state = $this->getEducationfieldTable()->deleteEducationfield($id);
            return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexedufield',
                            'controller' => 'master'
                ));
    }
    
    public function viewedufieldAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getEducationfieldTable()->getEducationfield($id);

        return new ViewModel(array('Info'=> $Info));
    }



    public function indexedulevelAction()
    {   
         $educationlevels = $this->getEducationlevelTable()->fetchAll();
		 
		   $form = new EducationlevelForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'educationlevels' => $educationlevels,'form'=> $form));
		 
		 

       // return new ViewModel(array(
          //  'educationlevels' => $educationlevels));
    }


    public function addedulevelAction()
    {
        

        $form = new EducationlevelForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

            $educationlevelEntity = new Educationlevels();

               $form->setInputFilter(new EducationlevelFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $educationlevelEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                $this->getEducationlevelTable()->SaveEducationlevel($educationlevelEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexedulevel',
                            'controller' => 'master'
                ));
               }
        }

        return new ViewModel(array('form'=> $form));
        
    }



    public function editedulevelAction()
    {
        

        $form = new EducationlevelForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            $educationlevel = $this->getEducationlevelTable()->getEducationlevel($id);
            // print_r($religion);die;
            $form->bind($educationlevel);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if($request->isPost()){

            $educationlevelEntity = new Educationlevels();

               $form->setInputFilter(new EducationlevelFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $educationlevelEntity = $form->getData();
                // print_r($cityEntity);die;
                $this->getEducationlevelTable()->SaveEducationlevel($educationlevelEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexedulevel',
                            'controller' => 'master'
                ));
               }
        }

        return new ViewModel(array('form'=> $form,'id'=>$id));

    }


    public function deleteedulevelAction()
    {
         
            $id = $this->params()->fromRoute('id');
            $state = $this->getEducationlevelTable()->deleteEducationlevel($id);
            return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexedulevel',
                            'controller' => 'master'
                ));
    }
    
    public function viewedulevelAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getEducationlevelTable()->getEducationlevel($id);

        return new ViewModel(array('Info'=> $Info));
    }


    public function indexprofessionAction()
    {   
         $professions = $this->getProfessionTable()->fetchAll();
		 
		  $form = new ProfessionForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'professions' => $professions,'form'=> $form));

       // return new ViewModel(array(
         //   'professions' => $professions));
    }


    public function addprofessionAction()
    {
        
        // echo"sdsd";die;
        $form = new ProfessionForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

            $professionEntity = new Professions();

               $form->setInputFilter(new ProfessionFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $professionEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                $this->getProfessionTable()->SaveProfession($professionEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexprofession',
                            'controller' => 'master'
                ));
               }
        }

        return new ViewModel(array('form'=> $form));
        
    }



    public function editprofessionAction()
    {
        

        $form = new ProfessionForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            $profession = $this->getProfessionTable()->getProfession($id);
            // print_r($religion);die;
            $form->bind($profession);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if($request->isPost()){

            $professionEntity = new Professions();

               $form->setInputFilter(new ProfessionFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $professionEntity = $form->getData();
                
                $this->getProfessionTable()->SaveProfession($professionEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexprofession',
                            'controller' => 'master'
                ));
               }
        }

        return new ViewModel(array('form'=> $form,'id'=>$id));

    }


    public function deleteprofessionAction()
    {
         
            $id = $this->params()->fromRoute('id');
            $state = $this->getProfessionTable()->deleteProfession($id);
            return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexprofession',
                            'controller' => 'master'
                ));
    }
    
    public function viewprofessionAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getProfessionTable()->getProfession($id);

        return new ViewModel(array('Info'=> $Info));
    }



    public function indexdesignationAction()
    {   
         $designations = $this->getDesignationTable()->fetchAll();
		 
		  $form = new DesignationForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'designations' => $designations,'form'=> $form));

        //return new ViewModel(array(
          //  'designations' => $designations));
    }


    public function adddesignationAction()
    {
        
        // echo"sdsd";die;
        $form = new DesignationForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

            $designationEntity = new Designations();

               $form->setInputFilter(new DesignationFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $designationEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                $this->getDesignationTable()->SaveDesignation($designationEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexdesignation',
                            'controller' => 'master'
                ));
               }
        }

        return new ViewModel(array('form'=> $form));
        
    }



    public function editdesignationAction()
    {
        

        $form = new DesignationForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            $designation = $this->getDesignationTable()->getDesignation($id);
            // print_r($religion);die;
            $form->bind($designation);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if($request->isPost()){

            $designationEntity = new Designations();

               $form->setInputFilter(new DesignationFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $designationEntity = $form->getData();
                
                $this->getDesignationTable()->SaveDesignation($designationEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexdesignation',
                            'controller' => 'master'
                ));
               }
        }

        return new ViewModel(array('form'=> $form,'id'=>$id));

    }


    public function deletedesignationAction()
    {
         
            $id = $this->params()->fromRoute('id');
            $state = $this->getDesignationTable()->deleteDesignation($id);
            return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexdesignation',
                            'controller' => 'master'
                ));
    }
    
    public function viewdesignationAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getDesignationTable()->getDesignation($id);

        return new ViewModel(array('Info'=> $Info));
    }



    public function indexusertypeAction()
    {   
         $usertypes = $this->getUsertypeTable()->fetchAll($status)->toArray();
         //\Zend\Debug\Debug::dump($usertypes);exit;

//        return new ViewModel(array(
//            'usertypes' => $usertypes));
        
        return new ViewModel(array(
            'usertypes' => $usertypes, 'action'=>'indexusertype'));
    }


    public function addusertypeAction()
    {
        
//         echo"sdsd";die;
        $form = new UsertypeForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

            $usertypeEntity = new Usertypes();

               $form->setInputFilter(new UsertypeFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $usertypeEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                $res = $this->getUsertypeTable()->SaveUsertype($usertypeEntity);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'indexusertype',
//                            'controller' => 'master'
//                ));
                //return new JsonModel(array("response" => $res));
                return $this->redirect()->toRoute('admin/master', array('action' => 'indexusertype'));
               } else {

                foreach ($form->getmessages() as $key => $value) {
                    $errors[] = array("element" => $key, "errors" => $value['isEmpty']);
                }
                return new JsonModel(array("errors" => $errors, "FormId" => $_POST['FormId']));
            }
        } 

        return new ViewModel(array('form'=> $form));
        
    }



    public function editusertypeAction()
    {
//        echo "hello world";exit;

        $form = new UsertypeForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            $usertype = $this->getUsertypeTable()->getUsertype($id);
//             print_r($usertype);die;
            $form->bind($usertype);
            $form->get('submit')->setAttribute('value', 'Save');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if($request->isPost()){

            $usertypeEntity = new Usertypes();

               $form->setInputFilter(new UsertypeFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $usertypeEntity = $form->getData();
                
                $this->getUsertypeTable()->SaveUsertype($usertypeEntity);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'indexusertype',
//                            'controller' => 'master'
//                ));
                return $this->redirect()->toRoute('admin/master', array('action' => 'indexusertype'));
               } 
               else {

                    foreach ($form->getmessages() as $key => $value) {
                        $errors[] = array("element" => $key, "errors" => $value['isEmpty']);
                    }

                    $response = $this->getResponse();
                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                    $response->setContent(json_encode(array("errors", $errors)));
                    return $response;
                    //return new JsonModel(array("errors" => $errors, "FormId" => $_POST['FormId']));
                }
        }

//        return new ViewModel(array('form'=> $form,'id'=>$id));
        $view = new ViewModel(array('form' => $form, 'id' => $id));
        //$view->setTerminal(true);
        return $view;

    }


    public function deleteusertypeAction()
    {
         
            $id = $this->params()->fromRoute('id');
            $usertype = $this->getUsertypeTable()->deleteUsertype($id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'indexusertype',
//                            'controller' => 'master'
//                ));
            return $this->redirect()->toRoute('admin/master', array('action' => 'indexusertype'));
    }
    
    public function viewusertypeAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getUsertypeTable()->getUsertype($id);

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function changeUserTypeStatusAction() {
//        echo "hello world";exit;
        $data = (object) $_POST;
        $return = $this->getUsertypeTable()->updatestatus($data);
        // print_r($return);
        return new JsonModel($return);
        exit();
    }
    
    public function ajaxusertyperadiosearchAction() {
        $status = $_POST['is_active'];
//        echo   "<pre>";
//        print_r($status);exit;
        $this->data = array('is_active=$status');

        $usertypes = $this->getUsertypeTable()->fetchAll($status)->toArray();
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('usertypes' => $usertypes));
        $view->setTemplate('admin/master/usertypeList');
        $view->setTerminal(true);
        return $view;
    }
    
    public function usertypesearchAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
//        echo  "<pre>";
//        print_r($data);die;

        $result = $adapter->query("select * from tbl_user_type where user_type like '$data%' ", Adapter::QUERY_MODE_EXECUTE);


        $view = new ViewModel(array("Results" => $result));
        $view->setTerminal(true);
        return $view;
        exit();
    }
    
    public function usertypeperformsearchAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $field1 = empty($_POST['user_type']) ? "" : "user_type like '" . $_POST['user_type'] . "%'";
        
        $sql = "select * from tbl_user_type where " . $field1 . "";
       // $sql = rtrim($sql, "&&");
        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);

        $view = new ViewModel(array("results" => $results));
        $view->setTerminal(true);
        return $view;


        exit();
    }

    public function addcommAction()
    {
        $id = $this->params()->fromRoute('id');

       $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
     

         $communities=$adapter->query("select * from tbl_communities where parent_id = $id", 
         Adapter::QUERY_MODE_EXECUTE);

         // foreach ($communities as $comm) {

         //    echo $comm->category_name;

         // }
         $backlinks = $this->backdirectories($id);
         // print_r($backlinks);die;


        return new ViewModel(array("id"=>$id,"Comm"=>$communities,"links"=>$backlinks));


    }

     public function addnewcommAction()
    {
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
     

        $adapter->query("INSERT INTO `tbl_communities`(`category_name`, `parent_id`, `status`)
         VALUES ('".$_POST['newdir']."','".$_POST['parent_id']."',1)",Adapter::QUERY_MODE_EXECUTE);


        return $this->redirect()->toRoute('admin', array(
                            'action' => 'addcomm',
                            'controller' => 'master',
                            'id' => $_POST['parent_id']
                ));

        // print_r($_POST);
        // exit();

    }

    public function backdirectories($currid='')
{   
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

    $i=$currid;
    // print_r($currid);die;
    while($i>0){

        $row =  $adapter->query("select * from tbl_communities where id=".$i."",Adapter::QUERY_MODE_EXECUTE)->toArray();
            // print_r($row[0]['parent_id']);die;
           //for testing purpose
            $links[]= '<a href="/rustagi/admin/master/addcomm/'.$row[0]['id'].'">'.$row[0]['category_name'].'</a> > ';
           
           //for Live Purpose
	   // $links[]= '<a href="/admin/master/addcomm/'.$row[0]['id'].'">'.$row[0]['category_name'].'</a> > ';

        $i = $row[0]['parent_id']; 
        unset($row[0]);
    } 
    return join("",array_reverse($links));
}



   
}
