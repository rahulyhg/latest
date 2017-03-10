<?php

namespace Admin\Controller;

use Admin\Form\PagesForm;
use Admin\Form\PagesFilter;
use Admin\Model\Entity\AllPages;
use Admin\Service\AdminServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class PagesController extends AppController {

    protected $commonService;
    protected $adminService;

    public function __construct(CommonServiceInterface $commonService, AdminServiceInterface $adminService) {
        $this->commonService = $commonService;
        $this->adminService = $adminService;
    }

    public function pagesindexAction() {   
        //echo   "hello world";exit;
        /* if($this->params()->fromRoute('id')==100){
          $message = "Page Added Successfully";
          }
          else if($this->params()->fromRoute('id')==101){
          $message = "Page Edited Successfully";
          }
          else if($this->params()->fromRoute('id')==99){
          $message = "Page Deleted Successfully";
          }
          else $message = ""; */
//      print_r($message);die;


        $pages = $this->getPagesTable()->fetchAll()->toArray();
        //\Zend\Debug\Debug::dump($pages);exit;
        // $stateNameList = $this->getStateTable()->customFields(array('id','state_name'));
        // $countryNameList = $this->getCountryTable()->customFields(array('id','country_name'));
        // CityForm::$country_nameList = $countryNameList;
        // CityForm::$state_nameList = $stateNameList;
        // print_r($pages);die;
        $form = new PagesForm();
        $form->get('submit')->setAttribute('value', 'Add');
        //return new ViewModel(array(
        //'AllPages' => $pages,'form'=> $form,'messages'=> $message));
        //echo  "hello";exit;
        return new ViewModel(array(
            'AllPages' => $pages, 'form' => $form));
        //echo  "hello";exit;
    }

    public function pagesaddAction() {
        //echo  "hello";exit;
//        $data = $this->getRequest()->getFiles()->toArray();
//        echo   "<pre>";
//        print_r($data);exit;
        $form = new PagesForm();
        /* if($this->params()->fromRoute('id')>0){
          $id = $this->params()->fromRoute('id');
          $page = $this->getPagesTable()->getPage($id);
          // print_r($country);die;
          $form->bind($page);
          $form->get('submit')->setAttribute('value', 'Edit');
          // $this->editAction($form)
          } */
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        

        if ($request->isPost()) {
//    \Zend\Debug\Debug::dump($request);
//    exit;
            $pagesEntity = new AllPages();

            //$form->setInputFilter(new PagesFilter());
            //echo "hello";exit;
            $form->setData($request->getPost());


            if ($form->isValid()) {
                 //print_r($_POST); die;
                $pagesEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                $res = $this->getPagesTable()->SavePages($_POST);

//                     return $this->redirect()->toRoute('admin', array(
//                            'action' => 'indexusertype',
//                            'controller' => 'master'
//                ));
                //return new JsonModel(array("response" => $res));
                return $this->redirect()->toRoute('admin/pages', array('action' => 'pagesindex'));
            } else {

                foreach ($form->getmessages() as $key => $value) {
                    $errors[] = array("element" => $key, "errors" => $value['isEmpty']);
                }
                return new JsonModel(array("errors" => $errors, "FormId" => $_POST['FormId']));
            }
        }

        return new ViewModel(array('form' => $form));
    }

    public function pageseditAction() {

        //echo  "hello amir";exit;
        $form = new PagesForm();
        if ($this->params()->fromRoute('id') > 0) {
            $id = $this->params()->fromRoute('id');
            $page = $this->getPagesTable()->getPage($id);
            //print_r($page);die;
            $form->bind($page);
            $form->get('submit')->setAttribute('value', 'Save');
            // $this->editAction($form)
        } 
        
//        else
//            $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
//            \Zend\Debug\Debug::dump($request);
//            exit;


            $pagesEntity = (object) $_POST;

            $res = $this->getPagesTable()->SavePages($_POST);

//            if ($res == "success")
//                $mid = 100;
//            else
//                $mid = 101;
            // print_r($res);die;

//            return $this->redirect()->toRoute('admin', array(
//                        'action' => 'index',
//                        'controller' => 'pages',
//                        'id' => $mid
//            ));
            return $this->redirect()->toRoute('admin/pages', array('action' => 'pagesindex'));
        }
        // $view = new ViewModel(array('form'=> $form,'id'=>$id));
        // $view->setTerminal(true);
        // return $view;
        //return new ViewModel(array('form' => $form));
        return new ViewModel(array('form' => $form, 'id' => $id));
    }

    public function changestatusAction() {
//            echo  "hello";exit;
        $data = (object) $_POST;
        $return = $this->getPagesTable()->updatestatus($data);
        // print_r($return);
        return new JsonModel($return);
        exit();
    }

    public function viewpagesAction() {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getPagesTable()->getPage($id);

        return new ViewModel(array('Info' => $Info));
    }

    // public function AddAction()
    // {
    //     $stateNameList = $this->getStateTable()->customFields(array('id','state_name'));
    //     CityForm::$state_nameList = $stateNameList;
    //     // echo"dssd"; die;
    //     $form = new CityForm();
    //     $form->get('submit')->setAttribute('value', 'Add');
    //     $request = $this->getRequest();
    //     if($request->isPost()){
    //         $cityEntity = new Cities();
    //            $form->setInputFilter(new CityFilter());
    //            $form->setData($request->getPost());
    //            if($form->isValid()){
    //             $cityEntity->exchangeArray($form->getData());
    //             // print_r($cityEntity);die;
    //             $this->getCityTable()->SaveCity($cityEntity);
    //                  return $this->redirect()->toRoute('admin', array(
    //                         'action' => 'index',
    //                         'controller' => 'pages'
    //             ));
    //            }
    //     }
    //     return new ViewModel(array('form'=> $form));
    // }
    // public function editAction($form)
    // {
    //     $stateNameList = $this->getStateTable()->customFields(array('id','state_name'));
    //     CityForm::$state_nameList = $stateNameList;
    //     $form = new CityForm();
    //     if($this->params()->fromRoute('id')>0){
    //         $id = $this->params()->fromRoute('id');
    //         $city = $this->getCityTable()->getCity($id);
    //         // print_r($state);die;
    //         $form->bind($city);
    //         $form->get('submit')->setAttribute('value', 'Edit');
    //         // $this->editAction($form)
    //     }
    //     $request = $this->getRequest();
    //     if($request->isPost()){
    //         $cityEntity = new Cities();
    //            $form->setInputFilter(new CityFilter());
    //            $form->setData($request->getPost());
    //            if($form->isValid()){
    //             $cityEntity = $form->getData();
    //             // print_r($cityEntity);die;
    //             $this->getCityTable()->SaveCity($cityEntity);
    //                  return $this->redirect()->toRoute('admin', array(
    //                         'action' => 'index',
    //                         'controller' => 'pages'
    //             ));
    //            }
    //     }
    //     return new ViewModel(array('form'=> $form/*,'id'=>$id*/));
    // }

    public function deleteAction() {
        //echo  "hello";exit;
        $id = $this->params()->fromRoute('id');
//            echo  $id;exit;
        $page = $this->getPagesTable()->deletePage($id);
//            return $this->redirect()->toRoute('admin', array(
//                            'action' => 'index',
//                            'controller' => 'pages',
//                            'id' => 99
//                ));

        return $this->redirect()->toRoute('admin/pages', array('action' => 'pagesindex'));
    }

    /*


      public function viewAction()
      {
      $id = $this->params()->fromRoute('id');

      $Info = $this->getCityTable()->getCityjoin($id);

      return new ViewModel(array('Info'=> $Info));
      }
     */
    
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

            $new_image = PUBLIC_PATH . '/PagesImages/' . $name;
            $new_image_thumb = PUBLIC_PATH . '/PagesImages/thumb/100x100/' . $name;
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
                $imgidpath = "/PagesImages/" . $name;

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


                        $new_image = PUBLIC_PATH . '/PagesImages/' . $name;
                        $new_image_thumb = PUBLIC_PATH . '/PagesImages/thumb/100x100/' . $name;
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
                            $imgidpath = "/PagesImages/" . $name;
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
