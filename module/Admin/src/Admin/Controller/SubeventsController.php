<?php

namespace Admin\Controller;

use Admin\Form\SubeventsFilter;
use Admin\Form\SubeventsForm;
use Admin\Model\Entity\Subevents;
use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Admin\Service\SubeventsServiceInterface;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class SubeventsController extends AppController {

    protected $commonService;
    protected $adminService;
    protected $subeventsService;

    public function __construct(CommonServiceInterface $commonService, AdminServiceInterface $adminService, SubeventsServiceInterface $subeventsService) {
        $this->commonService = $commonService;
        $this->adminService = $adminService;
        $this->subeventsService = $subeventsService;
    }

    public function indexAction() {
//        echo  "hello";
//        exit;
//        $events = $this->eventsService->test();
//        echo  $events;exit;
//        $countryNameList = $this->getCountryTable()->customFields(array('id','country_name'));
        //$countryNameList = $this->adminService->customFields();
//        $cityNameList = $this->getCityTable()->customFields(array('id','city_name'));
        //$cityNameList = $this->subeventsService->customFieldsCity();
//        $stateNameList = $this->getStateTable()->customFields(array('id','state_name'));
        //$stateNameList = $this->adminService->customFieldsState();
        //EventsForm::$country_nameList = $countryNameList;
        // EventsForm::$city_nameList = $cityNameList;
        //EventsForm::$state_nameList = $stateNameList;
        //print_r($cityNameList); die;
        //$form = new EventsForm();
        //$form->get('submit')->setAttribute('value', 'Add This Event');
//         $events = $this->getEventsTable()->fetchAll();
        $subevents = $this->subeventsService->getSubeventsList()->toArray();
        //\Zend\Debug\Debug::dump($subevents);exit;
// print_r("dfghdf");die; 

        return new ViewModel(array(
            'subevents' => $subevents));
    }

    public function subeventsaddAction() {  //echo  "hello";exit;
//        $events = $this->eventsService->test();
//        echo  $events;exit;       
//        $countryNameList = $this->adminService->customFields();
//        $cityNameList = $this->subeventsService->customFieldsCity();
//        $stateNameList = $this->adminService->customFieldsState();        
        $sponsmasterList = $this->subeventsService->getallSponsermaster();
        $sponstypeList = $this->subeventsService->getallSponsertype();
        $organiserList = $this->subeventsService->getallOrganiser();
        $eventList = $this->subeventsService->getallEvents();


        SubeventsForm::$spons_masterList = $sponsmasterList;
        SubeventsForm::$spons_typeList = $sponstypeList;
        SubeventsForm::$organiser_List = $organiserList;
        SubeventsForm::$event_nameList = $eventList;


        $session = new \Zend\Session\Container('admin');
        $user_id = $session->offsetGet('id');
        $email_id = $session->offsetGet('email');
        $remote = new \Zend\Http\PhpEnvironment\RemoteAddress;
        $user_ip = $remote->getIpAddress();
        $user_data = array($user_id, $email_id, $user_ip);

        $form = new SubeventsForm();

        $form->get('submit')->setAttribute('value', 'Add This Event');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $mergedata = array_merge(
                    $this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray(), $user_data
            );
            $form->setData($mergedata);
            if ($form->isValid()) {
                //\Zend\Debug\Debug::dump($mergedata);exit;

                $res = $this->subeventsService->saveSubevents($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'eventsindex',
//                            'controller' => 'events'
//                ));
                return $this->redirect()->toRoute('admin/subevents', array('action' => 'index'));
            } else {

                foreach ($form->getmessages() as $key => $value) {
                    $errors[] = array("element" => $key, "errors" => $value['isEmpty']);
                }
                return new JsonModel(array("errors" => $errors, "FormId" => $_POST['FormId']));
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'sponserMasterList' => $sponsmasterList,
            'sponserTypeList' => $sponstypeList,
            'organiserList' => $organiserList));
    }

    public function subeventseditAction() {
        $session = new \Zend\Session\Container('admin');
        $user_id = $session->offsetGet('id');
        $email_id = $session->offsetGet('email');
        $remote = new \Zend\Http\PhpEnvironment\RemoteAddress;
        $user_ip = $remote->getIpAddress();
        $user_data = array($user_id, $email_id, $user_ip);

        if ($this->params()->fromRoute('id') > 0) {
            $id = $this->params()->fromRoute('id');
            
            $subevents = $this->subeventsService->getSubevents($id);
            $sponsmasterList = $this->subeventsService->getallSponsermaster();
            $sponstypeList = $this->subeventsService->getallSponsertype();
            $organiserList = $this->subeventsService->getallOrganiser();
            $eventList = $this->subeventsService->getallEvents();
            $sponser = $this->subeventsService->getSponserBySubEventId($id);
            $organiser = $this->subeventsService->getOrganiserBySubEventId($id);

            SubeventsForm::$spons_masterList = $sponsmasterList;
            SubeventsForm::$spons_typeList = $sponstypeList;
            SubeventsForm::$organiser_List = $organiserList;
            SubeventsForm::$event_nameList = $eventList;
           
            $form = new SubeventsForm();
            $form->bind($subevents);
            $form->get('start_date')->setValue(date('d-m-Y',strtotime($subevents->getStartDate())));
            $form->get('end_date')->setValue(date('d-m-Y',strtotime($subevents->getEndDate())));
            $form->get('submit')->setAttribute('value', 'Save');
            
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $mergedata = array_merge(
                    $this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray()
            );

            $form->setData($mergedata);

            if ($form->isValid()) {
                //\Zend\Debug\Debug::dump($mergedata);exit;
                $mergedata['user_id']=$user_id;
                $res = $this->subeventsService->saveSubevents($mergedata);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'eventsindex',
//                            'controller' => 'events'
//                ));
                //return $this->redirect()->toRoute('admin/events', array('action' => 'eventsindex'));
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'id' => $id,
            'sponser' => $sponser,
            'organiser' => $organiser,
            'sponserMasterList' => $sponsmasterList,
            'sponserTypeList' => $sponstypeList,
            'organiserList' => $organiserList,
        ));
    }

    public function subeventsdeleteAction() {

        $id = $this->params()->fromRoute('id');
//             print_r($id);exit;
//            $state = $this->getEventsTable()->deleteEvents($id);
        $state = $this->subeventsService->delete('tbl_subevent', $id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'eventsindex',
//                            'controller' => 'events'
//                ));
        return $this->redirect()->toRoute('admin/subevents', array('action' => 'index'));
    }

    public function subeventsviewAction() {
//        $id = $_POST['id'];
        $id = $this->params()->fromRoute('id');
//        echo  "<pre>";
//        echo  $id;exit;
//        $Info = $this->getEventsTable()->getEventsjoin($id);
        $info = $this->subeventsService->viewBySubeventsId('tbl_subevent', $id);

//            echo   "<pre>";
//            print_r($info);exit;
//        \Zend\Debug\Debug::dump($info);exit;

        $view = new ViewModel(array('info' => $info));
        $view->setTerminal(true);
        return $view;
    }

    public function changestatusAction() {

//        $data = (object)$_POST;
        $request = $this->getRequest();
//        $return = $this->getEventsTable()->updatestatus($data);
        $result = $this->subeventsService->changeStatus('tbl_subevent', $request->getPost('subevent_id'), $request->getPost('is_active'));
        // print_r($return);
        //return new JsonModel($return);
        return new JsonModel($result);
        //exit();
    }

    // public function indexnewscategoryAction()
    // {   
    //      $newscategories = $this->getNewscategoryTable()->fetchAll();
    //      // print_r($newsecategories);die;
    //     return new ViewModel(array(
    //         'newscategories' => $newscategories));
    // }
    // public function addnewscategoryAction()
    // {
    //     $form = new NewscategoryForm();
    //     $form->get('submit')->setAttribute('value', 'Add');
    //     $request = $this->getRequest();
    //     if($request->isPost()){
    //         $newscategoryEntity = new Newscategories();
    //            $form->setInputFilter(new NewscategoryFilter());
    //            $form->setData($request->getPost());
    //            if($form->isValid()){
    //             $newscategoryEntity->exchangeArray($form->getData());
    //             // print_r($religionEntity);die;
    //             $this->getNewscategoryTable()->SaveNewscategory($newscategoryEntity);
    //                  return $this->redirect()->toRoute('admin', array(
    //                         'action' => 'indexnewscategory',
    //                         'controller' => 'news'
    //             ));
    //            }
    //     }
    //     return new ViewModel(array('form'=> $form));
    // }
    // public function viewnewscategoryAction()
    // {
    //     $id = $this->params()->fromRoute('id');
    //     $Info = $this->getNewscategoryTable()->getNewscategory($id);
    //     return new ViewModel(array('Info'=> $Info));
    // }


    /*     * ****Ajax Call***** */

    public function getStateNameAction() {
        //echo  "hello";exit;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $countryId = $request->getPost("Country_ID");
            //echo $countryId;exit;
            $stateName = $this->commonService->getStateListByCountryCode($countryId);
            //\Zend\Debug\Debug::dump($stateName);exit;
        }
        if (count($stateName)) {
            return new JsonModel(array("Status" => "Success", "statelist" => $stateName));
        } else {
            return new JsonModel(array("Status" => "Failed", "statelist" => null));
        }
    }

    /*     * ****Ajax Call***** */

    public function getCityNameAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $stateId = $request->getPost("State_ID");
            $cityName = $this->commonService->getCityListByStateCode($stateId);
            if (count($cityName))
                return new JsonModel(array("Status" => "Success", "statelist" => $cityName));
            else
                return new JsonModel(array("Status" => "Failed", "statelist" => null));
        }
    }

    /*     * ****Ajax Call***** */

    public function getRustagiBranchAction() {
        //echo  "hello";exit;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $cityId = $request->getPost("City_ID");
            $branchName = $this->commonService->getBrachListByCity($cityId);
            if (count($branchName)) {
                return new JsonModel(array("Status" => "Success", "statelist" => $branchName));
            } else {
                return new JsonModel(array("Status" => "Failed", "statelist" => NULL));
            }
        }
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

            $new_image = PUBLIC_PATH . '/SubeventsImages/' . $name;
            $new_image_thumb = PUBLIC_PATH . '/SubeventsImages/thumb/100x100/' . $name;
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
                $imgidpath = "/SubeventsImages/" . $name;

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


                        $new_image = PUBLIC_PATH . '/SubeventsImages/' . $name;
                        $new_image_thumb = PUBLIC_PATH . '/SubeventsImages/thumb/100x100/' . $name;
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
                            $imgidpath = "/SubeventsImages/" . $name;
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
    
    public function deleteSponserAction(){
        $request=$this->getRequest();
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        if ($request->isPost()) {
            if($request->getPost()['sponser_id']){
                $sponser_id=$request->getPost()['sponser_id'];
                $query=$adapter->query("DELETE FROM tbl_event_sponser_ext WHERE event_sponser_ext_id=$sponser_id");
                $result = $query->execute();
               //\Zend\Debug\Debug::dump($result);
               // exit;
            }
            
        }
        
        $viewModel=new JsonModel(array('result'=>$result));
        return $viewModel;
    }
    public function deleteOrganiserAction(){
        $request=$this->getRequest();
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        if ($request->isPost()) {
            if($request->getPost()['organiser_id']){
                $organiser_id=$request->getPost()['organiser_id'];
                $query=$adapter->query("DELETE FROM tbl_event_organiser_ext WHERE event_organiser_ext_id=$organiser_id");
                $result = $query->execute();
               //\Zend\Debug\Debug::dump($result);
               // exit;
            }
            
        }
        
        $viewModel=new JsonModel(array('result'=>$result));
        return $viewModel;
    }

}
