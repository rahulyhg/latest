<?php

namespace Admin\Controller;

use Admin\Form\CityFilter;
use Admin\Form\CityForm;
use Admin\Model\Entity\Cities;
use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class CityController extends AppController
{
    protected $data = '';//array();
     protected $commonService;
    protected $adminService;

    public function __construct(CommonServiceInterface $commonService, AdminServiceInterface $adminService) {
        $this->commonService = $commonService;
        $this->adminService=$adminService;
    }
    
    public function indexAction()
    {   //echo  "<pre>";echo "hello";exit;
//         $cities = $this->getCityTable()->fetchAll();
         $cities = $this->adminService->getCitiesList()->toArray();
//         $stateNameList = $this->getStateTable()->customFields(array('id','state_name'));
         $stateNameList = $this->adminService->customFieldsState();
//		 $countryNameList = $this->getCountryTable()->customFields(array('id','country_name'));
                 $countryNameList = $this->adminService->customFields();
        CityForm::$country_nameList = $countryNameList;
        CityForm::$state_nameList = $stateNameList;
        $action = $this->getRequest()->getUri()."/searchboxresults";
         CityForm::$actionName = $action;
//		$form = new StateForm();
//         $form->get('submit')->setAttribute('value', 'Add');
		$form = new CityForm();
         $form->get('submit')->setAttribute('value', 'Add');
         $filters_data = $this->getCountries();
        return new ViewModel(array(
            'cities' => $cities,'form'=> $form, 'action'=>'index', "filters_data" => $filters_data));
    }
    
//    public function updateOrderAction(){
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        //$count = 1;
////        echo "<pre>";
////        print_r($_POST['item']);exit;
//        foreach ($_POST['item'] as $key=>$value){     
//            $sql="UPDATE tbl_city SET order_val ='$key' WHERE id ='$value'";
//            $update = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
//            //$count ++;    
//        }
//        //return true;
//        //die;
//        return new JsonModel(array("response" => true));
//    }

    public function AddAction()
    {   
        //$action = $this->url()->fromRoute('admin/city', array('action' => 'searchboxresults'));
    //  //echo  "<pre>";
//                  echo  "hello";exit;
        //$stateNameList = $this->getStateTable()->customFields(array('id','state_name'));
        $stateNameList = $this->adminService->customFieldsState();
        
        CityForm::$state_nameList = $stateNameList;

        // echo"dssd"; die;

        $form = new CityForm();
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
                    $this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray(), $user_data
            ); 
            $form->setData($mergedata);
            
            //$cityEntity = new Cities();

               $form->setInputFilter(new CityFilter());
               //$form->setData($request->getPost());
               
               if ($form->getInputFilter()->getValue('is_active')==null) {
                $form->getInputFilter()->get('is_active')->setRequired(false);
            }


               if($form->isValid()){

                //$cityEntity->exchangeArray($form->getData());
                // print_r($cityEntity);die;
                //$res = $this->getCityTable()->SaveCity($cityEntity);
//                   echo  "<pre>";
//                  echo  "hello";exit;
                $res= $this->adminService->SaveCity($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'city'
//                ));
                return new JsonModel(array("response" => $res));
               }else {

                foreach ($form->getmessages() as $key => $value) {
                    $errors[] = array("element" => $key, "errors" => $value['isEmpty']);
                }
                return new JsonModel(array("errors" => $errors, "FormId" => $_POST['FormId']));


            }
        }

        return new ViewModel(array('form'=> $form));
        
    }

    public function editAction()
    {   $action = $this->url()->fromRoute('admin/city', array('action' => 'searchboxresults'));
        //$stateNameList = $this->getStateTable()->customFields(array('id','state_name'));
        $stateNameList = $this->adminService->customFieldsState();

        CityForm::$state_nameList = $stateNameList;
        CityForm::$actionName = $action;
        $form = new CityForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            //$city = $this->getCityTable()->getCity($id);
            $city= $this->adminService->getCity($id);
            // print_r($state);die;
            $form->bind($city);
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
                    $this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray(), $user_data
            ); 
            $form->setData($mergedata);
            //$cityEntity = new Cities();

               $form->setInputFilter(new CityFilter());
               //$form->setData($request->getPost());
               
//               if ($form->getInputFilter()->getValue('IsActive') == null) {
//                    $form->getInputFilter()->get('IsActive')->setRequired(false);
//                }


               if($form->isValid()){

                //$cityEntity = $form->getData();
                    // print_r($countryEntity);die;
                    //$res = $this->getCityTable()->SaveCity($cityEntity);
                    $res= $this->adminService->SaveCity($mergedata);

                    $response = $this->getResponse();
                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                    $response->setContent(json_encode(array("response" => $res)));
                    return $response;
               }else {
                   $res= $this->adminService->SaveCity($mergedata);
                   $response = $this->getResponse();
                   $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                   $response->setContent(json_encode(array("response" => $res)));
                   return $response;
//                    foreach ($form->getmessages() as $key => $value) {
//                        $errors[] = array("element" => $key, "errors" => $value['isEmpty']);
//                    }
//
//                    $response = $this->getResponse();
//                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
//                    $response->setContent(json_encode(array("errors", $errors)));
//                    return $response;
                }
        }
      }
        $view = new ViewModel(array('form' => $form, 'id' => $id));
        $view->setTerminal(true);
        return $view;
    }

    public function deleteAction()
    {
         
            $id = $this->params()->fromRoute('id');
//            $state = $this->getCityTable()->deleteCity($id);
            $state= $this->adminService->delete('tbl_city', $id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'city'
//                ));
            return $this->redirect()->toRoute('admin/city', array('action' => 'index'));
    }
    

    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getCityTable()->getCityjoin($id);

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function changestatusAction() {
        $session= new \Zend\Session\Container('admin');
       $user_id = $session->offsetGet('id');
//        $data = (object) $_POST;
//        $return = $this->getCityTable()->updatestatus($data);
//        // print_r($return);
//        return new JsonModel($return);
//        exit();
        $request=$this->getRequest();
        $result= $this->adminService->changeStatus('tbl_city', $request->getPost('id'), $request->getPost(), $user_id);
        return new JsonModel($result);
    }
    
    public function viewByIdAction(){
        
        $id = $this->params()->fromRoute('id');

        //$Info = $this->getCountryTable()->getCountry($id);
        //$info = $this->getCityTable()->getCityjoin($id);
        $info = $this->adminService->viewByCityId('tbl_city', $id);

        // echo"<pre>"; print_r($Info);die;
        $view=new ViewModel(array('info'=>$info));
        $view->setTerminal(true);
        return $view;
        
    }
    
    public function delmultipleAction() {
        $ids = $_POST['chkdata'];
//        $result = $this->getCityTable()->delmultiple($ids);
        $result= $this->adminService->deleteMultiple('tbl_city', $ids);

        echo $result;
        exit();
    }
    
    public function changeStatusAllAction() {
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $sql = "update tbl_city set IsActive=" . $_POST['val'] . " where id IN (" . $_POST['ids'] . ")";
//        $results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);

        $result= $this->adminService->changeStatusAll('tbl_city', $_POST['ids'], $_POST['val']);
//        return new JsonModel($result);
                if ($result)
            echo "updated all";
        else
            echo "couldn't update";
        exit();
    }
    
    public function ajaxradiosearchAction() {
        $status = $_POST['is_active'];
//       echo   "<pre>";
//       print_r($status);die;
       // $this->data = array("IsActive=$status");
        if($status==1){
        $this->data = $status;

        //$cities = $this->getCityTable()->fetchAll2($this->data);
        $cities = $this->adminService->getCityRadioList($_POST['is_active'])->toArray();
//        echo  "<pre>";
//        print_r($cities);die;
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('cities' => $cities));
        $view->setTemplate('admin/city/cityList');
        $view->setTerminal(true);
        return $view;
        }else{
            $this->data = $status;

        //$cities = $this->getCityTable()->fetchAll2($this->data);
        $cities = $this->adminService->getCityRadioList($_POST['is_active']);
        if($cities){
            $cities = $cities->toArray();
        }else{
            $cities;
        }
//        echo  "<pre>";
//        print_r($cities);die;
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('cities' => $cities));
        $view->setTemplate('admin/city/cityList');
        $view->setTerminal(true);
        return $view;
        }
    }
    
    //added by amir
    
    public function getCountries() {
//        echo  "<pre>";
//        echo "hello";exit;
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $filters_array = array("country" => "tbl_country", "profession" => "tbl_profession", "city" => "tbl_city"
//            , "state" => "tbl_state", "education_level" => "tbl_education_field", "designation" => "tbl_designation"
//            , "height" => "tbl_height");
//        foreach ($filters_array as $key => $table) {
//            $filters_data[$key] = $adapter->query("select * from " . $table . "", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
//        }
        
        $filters_data = $this->adminService->getCountriesList();
//        \Zend\Debug\Debug::dump($filters_data);
//        exit;
        return $filters_data;
    }
    
    /*     * ****Ajax Call***** */
    
    public function getStateNameAction() {
//        echo  "<pre>";
//        print_r($_POST['Country_ID']);exit;
//           print_r($Request->getPost("Country_ID"));die;
//        $Request = $this->getRequest();
//        if ($Request->isPost()) {
            $Country_ID = $_POST['Country_ID'];
//            $state_name = $this->getStateTable()->getStateListByCountryCode($Country_ID);
            $state_name = $this->adminService->getStateListByCountryCode($Country_ID);
//            print_r($state_name);
//            exit;
//            echo  "<pre>";
//            \Zend\Debug\Debug::dump($filters_data);exit;
//        }
        if (count($state_name))
                return new JsonModel(array("Status" => "Success", "statelist" => $state_name));
            else
                return new JsonModel(array("Status" => "Failed", "statelist" => NULL));
            
    }

    /*     * ****Ajax Call***** */

    public function getCityNameAction() {
//        $Request = $this->getRequest();
//        if ($Request->isPost()) {
//            $State_ID = $Request->getPost("State_ID");
            $State_ID = $_POST['State_ID'];
//            $city_name = $this->getCityTable()->getCityListByStateCode($State_ID);
            $city_name = $this->adminService->getCityListByStateCode($State_ID);
            if (count($city_name))
                return new JsonModel(array("Status" => "Success", "statelist" => $city_name));
            else
                return new JsonModel(array("Status" => "Failed", "statelist" => NULL));
       // }
    }
    
     public function performsearchAction() {      
//         echo   "hello";exit;
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        if(isset($_POST['Country_id']) && !isset($_POST['State_id'])){
//             $sql = "SELECT * FROM tbl_state WHERE country_id=".$_POST['Country_id']."";
//            $results = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
//            $resultSet=new \Zend\Db\ResultSet\ResultSet();
//            $resultSet->initialize($results);
           //return $results;
//            $i=0;
//            $data = array();
//            foreach($results as $result){
//               
//               $data[$i] = $result->id;
//               
//                $i++;
//            }
//            
//             $states_id = implode(',',$data);
            //echo  "<pre>";
            //print_r($data2);
            
            //exit;


//            $sql2 = "SELECT tbl_city.*,tbl_state.state_name FROM tbl_city INNER JOIN tbl_state ON "
//                    . "tbl_city.state_id=tbl_state.id where tbl_city.state_id IN($states_id)";
//            $results1 = $adapter->query($sql2, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            $results1 = $this->adminService->getCityListByCountry($_POST['Country_id']);
//            echo  "<pre>";print_r($results);
//            exit;

            $view = new ViewModel(array("results" => $results1));
            $view->setTerminal(true);
            return $view;
            
        }
        
        if(isset($_POST['Country_id']) && isset($_POST['State_id']) && !isset($_POST['City_id'])){
            
//            $sql3 = "SELECT tbl_city.*,tbl_state.state_name FROM tbl_city INNER JOIN tbl_state ON "
//                    . "tbl_city.state_id=tbl_state.id where tbl_city.state_id=".$_POST['State_id']."";
//            $results2 = $adapter->query($sql3, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            $results2 = $this->adminService->getCityListByState($_POST['State_id']);
//            echo  "<pre>";print_r($results);
//            exit;

            $view = new ViewModel(array("results" => $results2));
            $view->setTerminal(true);
            return $view;
            
        }
        
        if(isset($_POST['Country_id']) && isset($_POST['State_id']) && isset($_POST['City_id'])){
            
            $sql4 = "SELECT tbl_city.*,tbl_state.state_name FROM tbl_city INNER JOIN tbl_state ON "
                    . "tbl_city.state_id=tbl_state.id where tbl_city.id=".$_POST['City_id']."";
//            $results3 = $adapter->query($sql4, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            $results3 = $this->adminService->getCityListByCity($_POST['City_id']);
//            echo  "<pre>";print_r($results);
//            exit;

            $view = new ViewModel(array("results" => $results3));
            $view->setTerminal(true);
            return $view;
            
        }
        
        
       
    }
    
    public function searchboxresultsAction()
    {
        $data = $_POST['value'];
        $data2 = explode('-',$_POST['stateid']);
        $data2  =   $data2[1];
//        echo  "<pre>";
//        print_r($_POST['field']);exit;
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $result = $adapter->query("select * from tbl_allcities where (id not in (select master_city_id
//            from tbl_city)) && state_id=$data", Adapter::QUERY_MODE_EXECUTE);
        $sql="select * from tbl_allcities where (id not in (select master_city_id
            from tbl_city)) && state_id=$data2 && city_name like '$data%'";
        $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        //\Zend\Debug\Debug::dump($result);exit;
        // $result = $this->getAllCountryTable()->searchresults($data);
        $view = new ViewModel(array("cities" => $result, "parentname" => $_POST['field']));
        $view->setTerminal(true);
        return $view;
        exit();
        
        
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

            $new_image = PUBLIC_PATH . '/CityImages/' . $name;
            $new_image_thumb = PUBLIC_PATH . '/CityImages/thumb/100x100/' . $name;
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
                $imgidpath = "/CityImages/" . $name;

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


                        $new_image = PUBLIC_PATH . '/CityImages/' . $name;
                        $new_image_thumb = PUBLIC_PATH . '/CityImages/thumb/100x100/' . $name;
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
                            $imgidpath = "/CityImages/" . $name;
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