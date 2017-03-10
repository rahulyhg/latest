<?php

namespace Admin\Controller;

use Admin\Form\SponsermasterFilter;
use Admin\Form\SponsermasterForm;
use Admin\Model\Entity\Sponsermasters;
use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Admin\Service\SponsermasterServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class SponsermasterController extends AppController
{
    protected $data = '';//array();
    protected $commonService;
    protected $adminService;
    protected $sponsermasterService;

    public function __construct(CommonServiceInterface $commonService, AdminServiceInterface $adminService, SponsermasterServiceInterface $sponsermasterService) {
        $this->commonService = $commonService;
        $this->adminService=$adminService;
        $this->sponsermasterService=$sponsermasterService;
    }
    
    public function indexAction()
    {   //echo  "hello";exit;
//        $tests = $this->sponsermasterService->test();
//        print_r($tests);exit;
         //$religions = $this->getReligionTable()->fetchAll($this->data);
         $sponsermasters = $this->sponsermasterService->getSponsermasterList()->toArray();
//            echo   "<pre>";
//          print_r($sponsermasters);die;
         // print_r($cities);die;
		 
		   
//		$form = new SponsermasterForm();
//         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'sponsermasters' => $sponsermasters));
			
    }

    public function addsponsermasterAction()
    {   //echo   "hello";exit;
        
        $countryNameList = $this->adminService->customFields();
        $cityNameList = $this->sponsermasterService->customFieldsCity();
        $stateNameList = $this->adminService->customFieldsState();      

        SponsermasterForm::$country_nameList = $countryNameList;
        SponsermasterForm::$city_nameList = $cityNameList;
        SponsermasterForm::$state_nameList = $stateNameList;
      
      $session= new \Zend\Session\Container('admin');
        $user_id = $session->offsetGet('id');
         $email_id = $session->offsetGet('email');
         $remote = new \Zend\Http\PhpEnvironment\RemoteAddress;
         $user_ip = $remote->getIpAddress();
         $user_data = array($user_id,$email_id,$user_ip);
        
        $designationNameList = $this->sponsermasterService->getAllDesignation();
//        \Zend\Debug\Debug::dump($designationNameList);exit;
        SponsermasterForm::$designation_nameList = $designationNameList;
         
        $form = new SponsermasterForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){
                //print_r($_POST); die;
//            \Zend\Debug\Debug::dump($request);
//            exit;
            //$religionEntity = new Religions();

               //$form->setInputFilter(new ReligionFilter());
               //$form->setData($request->getPost());
            
            $mergedata = array_merge(
                    $this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray(), $user_data
            );
            
            $form->setData($mergedata);

               if($form->isValid()){

                //$religionEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                //$res = $this->getReligionTable()->SaveReligion($religionEntity);
                $res= $this->sponsermasterService->SaveSponsermaster($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'religion'
//                ));
                //return new JsonModel(array("response" => $res));
                return $this->redirect()->toRoute('admin/sponsermaster', array('action' => 'index'));
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
        $countryNameList = $this->adminService->customFields();
        $cityNameList = $this->sponsermasterService->customFieldsCity();
        $stateNameList = $this->adminService->customFieldsState();      

        SponsermasterForm::$country_nameList = $countryNameList;
        SponsermasterForm::$city_nameList = $cityNameList;
        SponsermasterForm::$state_nameList = $stateNameList;
        
        $designationNameList = $this->sponsermasterService->getAllDesignation();
//        \Zend\Debug\Debug::dump($designationNameList);exit;
        SponsermasterForm::$designation_nameList = $designationNameList;
        
        $session= new \Zend\Session\Container('admin');
        $user_id = $session->offsetGet('id');
         $email_id = $session->offsetGet('email');
         $user_data = array($user_id,$email_id);
         
        $form = new SponsermasterForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
//            echo   $id;die;
            //$religion = $this->getReligionTable()->getReligion($id);
            $sponsermaster= $this->sponsermasterService->getSponsermaster($id);
//             print_r($sponsermaster);die;
            $form->bind($sponsermaster);
            $form->get('submit')->setAttribute('value', 'Save');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        
        if($request->isPost()){

            //$religionEntity = new Religions();

               //$form->setInputFilter(new ReligionFilter());
              // $form->setData($request->getPost());
                 $mergedata = array_merge(
                    $this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray(),$user_data
            );

               if($form->isValid()){

                //$religionEntity = $form->getData();
                // print_r($cityEntity);die;
                //$res = $this->getReligionTable()->SaveReligion($religionEntity);
                //$res= $this->adminService->SaveReligion($form->getData());
                $res= $this->sponsermasterService->SaveSponsermaster($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'religion'
//                ));
//                    $response = $this->getResponse();
//                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
//                    $response->setContent(json_encode(array("response" => $res)));
//                    return $response;
                return $this->redirect()->toRoute('admin/sponsermaster', array('action' => 'index'));
               } 
        }    

       
        return new ViewModel(array('form' => $form, 'id' => $id));

    }

    public function deleteAction()
    {
         
            $id = $this->params()->fromRoute('id');
            //$religion = $this->getReligionTable()->deleteReligion($id);
            $religion= $this->sponsermasterService->delete('tbl_sponser_master', $id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'religion'
//                ));
            return $this->redirect()->toRoute('admin/sponsermaster', array('action' => 'index'));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getReligionTable()->getReligion($id);

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function viewByIdAction(){
        
        $id = $this->params()->fromRoute('id');

        //$Info = $this->getCountryTable()->getCountry($id);
        //$info = $this->getReligionTable()->getReligion($id);
        $info = $this->adminService->viewByReligionId('tbl_religion', $id);

        // echo"<pre>"; print_r($Info);die;
        $view=new ViewModel(array('info'=>$info));
        $view->setTerminal(true);
        return $view;
        
    }
    
    public function changestatusAction() {

        //$data = (object) $_POST;
        $request=$this->getRequest();
        //$return = $this->getReligionTable()->updatestatus($data);
        $result= $this->sponsermasterService->changeStatus('tbl_sponser_master', $request->getPost('spons_id'), $request->getPost('is_active'));
        // print_r($return);
        return new JsonModel($result);
        //exit();
    }
    
    public function delmultipleAction() {
        $ids = $_POST['chkdata'];
        //$result = $this->getReligionTable()->delmultiple($ids);
        $result= $this->adminService->deleteMultiple('tbl_religion', $ids);

        echo $result;
        exit();
    }
    
    public function changeStatusAllAction() {
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $sql = "update tbl_religion set IsActive=" . $_POST['val'] . " where id IN (" . $_POST['ids'] . ")";
//        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $result= $this->adminService->changeStatusAll('tbl_religion', $_POST['ids'], $_POST['val']);
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

        //$religions = $this->getReligionTable()->fetchAll($this->data);
        $religions = $this->adminService->getReligionRadioList($_POST['is_active']);
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('religions' => $religions));
        $view->setTemplate('admin/religion/religionList');
        $view->setTerminal(true);
        return $view;
    }
    
    public function performsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        //$field1 = empty($_POST['religion_name']) ? "" : "religion_name like '" . $_POST['religion_name'] . "%'";
        
        //$sql = "select * from tbl_religion where " . $field1 . "";
       // $sql = rtrim($sql, "&&");
        //$results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $results = $this->adminService->performSearchReligion($_POST['religion_name']);

        $view = new ViewModel(array("results" => $results));
        $view->setTerminal(true);
        return $view;


        exit();
    }
    
    public function religionsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
//        echo  "<pre>";
//        print_r($data);die;

        //$result = $adapter->query("select * from tbl_religion where religion_name like '$data%' ", Adapter::QUERY_MODE_EXECUTE);
        $result = $this->adminService->religionSearch($data);


        $view = new ViewModel(array("Results" => $result));
        $view->setTerminal(true);
        return $view;
        exit();
    }
    
    public function viewsponsermasterAction() {
        $id = $this->params()->fromRoute('id');
                //echo   $id;exit;
//        $Info = $this->getNewsTable()->getNewsjoin($id);
        $Info = $this->sponsermasterService->viewBySponsermasterId($id);
        
//        echo  "<pre>";
//                print_r($Info);exit;


        return new ViewModel(array('Info' => $Info));
    }
    
    //added by amir
    //crop image function
    
    public function croppostimageAction() {
            //echo  "hello";exit;
        //print_r($_POST);exit;
        //print_r($ref_no);
        //exit;

        if ($_POST['cropenabled'] == "Enable") {

//            $session = new Container('user');
//            $user_id = $session->offsetGet('id');
//            $ref_no = $session->offsetGet('ref_no');
//            $user_name = $session->offsetGet('full_name');
            // $user_id = $_POST['uid'];
            //  $ref_no = $_POST['ref_no'];
            // $user_name = "Unknown";
            $name = time() . $_FILES['file']['name'];
            $original_image = $_FILES['file']['tmp_name'];

            $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            //die;
            // $user_folder = $user_id . "__" . $user_name;

            $new_image = PUBLIC_PATH . '/SponserImages/' . $name;
            $new_image_thumb = PUBLIC_PATH . '/SponserImages/thumb/100x100/' . $name;
// TODO: satya
            $image_quality = '95';



// Get dimensions of the original image
            list( $current_width, $current_height ) = getimagesize($original_image);

// Get coordinates x and y on the original image from where we
// will start cropping the image, the data is taken from the hidden fields of form.
            $x1 = $_POST['x1'];
            $y1 = $_POST['y1'];
            $x2 = $_POST['x2'];
            $y2 = $_POST['y2'];
            $width = $_POST['width'];
            $height = $_POST['height'];
            //print_r( $_POST ); //die;
// Define the final size of the image here ( cropped image )
            $crop_width = 200;
            $crop_height = 200;
// Create our small image
            $new = imagecreatetruecolor($crop_width, $crop_height);

// Create original image
            $current_image = imagecreatefromjpeg($original_image);
// resampling ( actual cropping )
            imagecopyresampled($new, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height);
// this method is used to create our new image
            $result = imagejpeg($new, $new_image, $image_quality);

            //echo print_r($result);
//thumb start
            $crop_width = 30;
            $crop_height = 30;
            $thumbNew = imagecreatetruecolor($crop_width, $crop_height);
            imagecopyresampled($thumbNew, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height);
            $thumb = imagejpeg($thumbNew, $new_image_thumb, $image_quality);

            if (!in_array($ext, array('jpg', 'jpeg'))) {
                return new JsonModel(array("Status" => 0, "message" => "only jpeg files are allowed"));
            }

            if ($result) {
                //echo "Mohit"; die;
                $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                //*********Insert in Gallery Table******
                // $already = $adapter->query("select user_id from tbl_family_info where user_id=$user_id",\Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->count();
                // 	if($already == 0){
                // 		$adapter->query("insert into ".$_POST['table_name']."('user_id','".$_POST['field_name']."') values($user_id,'/uploads/$user_folder/$name')", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                // 	}	
                // else 
                /* $statement = $adapter->query("INSERT INTO tbl_user_gallery (user_id, ref_no, image_path, profile_pic) 
                  VALUES ('$user_id','$ref_no','$user_folder/$name', '$profile_pic')");


                  $res = $statement->execute();
                  $imgid = $res->getGeneratedValue(); */
                //print_r($statement);
                //exit;
                //*********Select Images to Render******
                // $data=$adapter->query("select ".$_POST['field_name']." from tbl_family_info where user_id='$user_id'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);


                $response = 'File uploaded Successfully.';
                //for testing purpose
                $imgidpath = "/SponserImages/" . $name;

                //for Live Purpose
                // $imgidpath = "/uploads/$user_folder/$name";

                return new JsonModel(array("Status" => 1, "data" => $imgidpath, "imgid" => $imgid));
            } else {

                return new JsonModel(array("Status" => 0, "message" => "couldn't crop image some error occured"));
            }
        } else {
            //$response = $this->familyimages($_POST, $_FILES);
            $resp = $this->getResponse();
            $resp->getHeaders()->addHeaderLine('Content-Type', 'application/json');

            //$img_relation = trim($post['field_name']);
            $name = $_FILES['file']['name'];
            $tmpName = $_FILES['file']['tmp_name'];
            $error = $_FILES['file']['error'];
            $size = $_FILES['file']['size'];
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            switch ($error) {
                case UPLOAD_ERR_OK:
                    $valid = true;
                    //validate file extensions
                    if (!in_array($ext, array('jpg'))) {
                        $valid = false;
                        $response = "Invalid file extension. Only( jpg ) are allowed";
                    }
                    //validate file size
                    if ($size / 1024 / 1024 > 2) {
                        $valid = false;
                        $response = "File size is exceeding 2MB maximum allowed size.";
                    }
                    //upload file
                    if ($valid) {

                        // return $post;
                        $bashPath = PUBLIC_PATH;


                        $name = time() . $name;


                        $new_image = PUBLIC_PATH . '/SponserImages/' . $name;
                        $new_image_thumb = PUBLIC_PATH . '/SponserImages/thumb/100x100/' . $name;
                        $image_quality = '95';





// Get dimensions of the original image
                        list( $current_width, $current_height ) = getimagesize($tmpName);

// Get coordinates x and y on the original image from where we
// will start cropping the image, the data is taken from the hidden fields of form.
                        $x1 = $_POST['x1'];
                        $y1 = $_POST['y1'];
                        $x2 = $_POST['x2'];
                        $y2 = $_POST['y2'];
                        $width = $_POST['width'];
                        $height = $_POST['height'];
//                        //print_r( $_POST ); die;
// Define the final size of the image here ( cropped image )
                        $crop_width = 200;
                        $crop_height = 200;
// Create our small image
                        $new = imagecreatetruecolor($crop_width, $crop_height);

// Create original image
                        $current_image = imagecreatefromjpeg($tmpName);
// resampling ( actual cropping )
                        imagecopyresampled($new, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height);
// this method is used to create our new image
                        $result = imagejpeg($new, $new_image, $image_quality);


//thumb start
                        $crop_width = 30;
                        $crop_height = 30;
                        $thumbNew = imagecreatetruecolor($crop_width, $crop_height);
                        $current_image = imagecreatefromjpeg($tmpName);
                        imagecopyresampled($thumbNew, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height);
                        $thumb = imagejpeg($thumbNew, $new_image_thumb, $image_quality);



                        //exit;
                        if ($result) {


                            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                            //*********Insert in Gallery Table******
                            //$adapter->query("update " . $post['table_name'] . " set " . $post['field_name'] . "='/uploads/$user_folder/$name' where user_id=$user_id ", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                            //*********Select Images to Render******
                            // $data=$adapter->query("select ".$post['field_name']." from tbl_family_info where user_id='$user_id'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                            $response = 'File uploaded Successfully.';
                            // return $data;
//for testing purpose		
                            $imgidpath = "/SponserImages/" . $name;
                            $resp->setContent(json_encode(array("Status" => 1, "data" => $imgidpath, "imgid" => $imgid)));
//for live purpose
// $imgidpath = "/uploads/$user_folder/$name";
                            //        $resp->setContent(json_encode(array("Status"=>1,"data"=>$imgidpath,"imgid"=>$post['field_name'])));

                            return $resp;

                            // return new JsonModel(array("Status"=>1,"data"=>$targetPath));
                            // return new JsonModel(array("Status"=>"true","message"=>$response,"family_data"=>$data));							
                        } else {
                            $response = "Error! File Couldn't uploaded";
                        }
                    }
                    break;
                case UPLOAD_ERR_INI_SIZE:
                    $response = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $response = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $response = 'The uploaded file was only partially uploaded.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $response = 'No file was uploaded.';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $response = 'Missing a temporary folder.';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $response = 'Failed to write file to disk.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $response = 'File upload stopped by extension.';
                    break;
                default:
                    $response = 'Unknown error';
                    break;
            }

            $resp->setContent(json_encode(array("Status" => 0, "message" => $response)));
            return $resp;
        }

        //exit;
    }
   
}