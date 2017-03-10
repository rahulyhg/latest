<?php

namespace Admin\Controller;

use Admin\Form\NewscategoryFilter;
use Admin\Form\NewscategoryForm;
use Admin\Form\NewsFilter;
use Admin\Form\NewsForm;
use Admin\Model\Entity\Newscategories;
use Admin\Model\Entity\Newses;
use Admin\Service\AdminServiceInterface;
use Admin\Service\NewsServiceInterface;
use Common\Service\CommonServiceInterface;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class NewsController extends AppController {

    protected $data = '';
    protected $commonService;
    protected $adminService;
    protected $newsService;

    public function __construct(CommonServiceInterface $commonService, AdminServiceInterface $adminService, NewsServiceInterface $newsService) {

        $this->commonService = $commonService;
        $this->adminService = $adminService;
        $this->newsService = $newsService;
    }

    public function indexnewsAction() {
//        echo  "hello";exit;
//        $newses = $this->getNewsTable()->fetchAll();
        $newses = $this->newsService->getNewsList()->toArray();
        
        //\Zend\Debug\Debug::dump($newses);exit;

        return new ViewModel(array(
            'newses' => $newses));
    }

    public function addnewsAction() {
       
        $session= new \Zend\Session\Container('admin');
//        print_r($session);exit;
//        echo $session->offsetGet('id');
         $user_id = $session->offsetGet('id');
         $email_id = $session->offsetGet('email');
         $user_data = array($user_id,$email_id);
       
        $categoryNameList = $this->newsService->getAllNewscategory();

        NewsForm::$category_nameList = $categoryNameList;
       

        $form = new NewsForm();
//        echo   "hello";exit;
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            //print_r($_POST); die;
//            \Zend\Debug\Debug::dump($request);
//            exit;
//            echo  "<pre>";
//            print_r($this->getRequest()->getFiles()->toArray());exit;

            $mergedata = array_merge(
                    $this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray() ,$user_data
            );
            
//            echo  "<pre>";
//            print_r($mergedata);exit;

            //$newsEntity = new Newses();

            //$form->setInputFilter(new NewsFilter());
            $form->setData($mergedata);
                //echo "hello";exit;

            if ($form->isValid()) {
                //echo "hello";exit;

                //$newsEntity->exchangeArray($form->getData());

                //$this->getNewsTable()->saveNews($newsEntity);$_POST
                $res= $this->newsService->saveNews($mergedata);
                

//                return $this->redirect()->toRoute('admin', array(
//                            'action' => 'indexnews',
//                            'controller' => 'news'
//                ));
                //return new JsonModel(array("response" => $res));
                return $this->redirect()->toRoute('admin/news', array('action' => 'indexnews'));
            } else {

                foreach ($form->getmessages() as $key => $value) {
                    $errors[] = array("element" => $key, "errors" => $value['isEmpty']);
                }
                return new JsonModel(array("errors" => $errors, "FormId" => $_POST['FormId']));
            }
        }

        return new ViewModel(array('form' => $form));
        
    }

    public function editnewsAction() {
//        echo  "hello";exit;
//        $categoryNameList = $this->getNewscategoryTable()->customFields(array('id', 'category_name'));
        $categoryNameList = $this->newsService->getAllNewscategory();

        NewsForm::$category_nameList = $categoryNameList;
        
        
        $session= new \Zend\Session\Container('admin');
//        print_r($session);exit;
//        echo $session->offsetGet('id');
         $user_id = $session->offsetGet('id');
         $email_id = $session->offsetGet('email');
         $user_data = array($user_id,$email_id);

        $form = new NewsForm();
        if ($this->params()->fromRoute('id') > 0) {
            $id = $this->params()->fromRoute('id');
//            $news = $this->getNewsTable()->getNews($id);
            $news = $this->newsService->getNews($id);
            // print_r($state);die;
            $form->bind($news);
            $form->get('submit')->setAttribute('value', 'Save');
            // $this->editAction($form)
            
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
//            echo  "hello";exit;

            $mergedata = array_merge(
                    $this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray(),$user_data
            );

//            $newsEntity = new Newses();$this->getRequest()->getFiles()->toArray()

//            $form->setInputFilter(new NewsFilter());
            //$form->setData($mergedata);


            if ($form->isValid()) {
//                echo  "hello";exit;

                // $newsEntity = $form->getData();
//                $newsEntity->exchangeArray($form->getData());
                // print_r($newsEntity);die;
//                $this->getNewsTable()->SaveNews($newsEntity);
                $res= $this->newsService->saveNews($mergedata);//$form->getData()

//                return $this->redirect()->toRoute('admin', array(
//                            'action' => 'indexnews',
//                            'controller' => 'news'
//                ));
                return $this->redirect()->toRoute('admin/news', array('action' => 'indexnews'));
            }
        }

        return new ViewModel(array('form' => $form, 'id' => $id));
    }

    public function deletenewsAction() {
//        echo  "hello";exit;

        $id = $this->params()->fromRoute('id');
        // print_r($id);
//        $state = $this->getNewsTable()->deleteNews($id);
        $state= $this->adminService->delete('tbl_news', $id);
//        return $this->redirect()->toRoute('admin', array(
//                    'action' => 'indexnews',
//                    'controller' => 'news'
//        ));
        return $this->redirect()->toRoute('admin/news', array('action' => 'indexnews'));
    }

    public function viewnewsAction() {
        $id = $this->params()->fromRoute('id');

//        $Info = $this->getNewsTable()->getNewsjoin($id);
        $Info = $this->newsService->viewByNewsId('tbl_news', $id);
        
//        echo  "<pre>";
//                print_r($Info);exit;


        return new ViewModel(array('Info' => $Info));
    }
    
    public function changestatusAction() {

        //$data = (object) $_POST;
        $request=$this->getRequest();
        //$return = $this->getReligionTable()->updatestatus($data);
        $result= $this->adminService->changeStatus('tbl_news', $request->getPost('id'), $request->getPost());
        // print_r($return);
        return new JsonModel($result);
        //exit();
    }

    //category code
    
    public function indexnewscategoryAction() {
//        $newscategories = $this->getNewscategoryTable()->fetchAll();
        $newscategories = $this->newsService->getNewscategoryList()->toArray();

        // print_r($newsecategories);die;
        return new ViewModel(array(
            'newscategories' => $newscategories, 'action'=>'indexnewscategory'));
    }

    public function addnewscategoryAction() {
//        echo "hello";exit;

        $form = new NewscategoryForm();
        $form->get('submit')->setAttribute('value', 'Add');
        
        $session= new \Zend\Session\Container('admin');
        $user_id = $session->offsetGet('id');
         $email_id = $session->offsetGet('email');
         $remote = new \Zend\Http\PhpEnvironment\RemoteAddress;
         $user_ip = $remote->getIpAddress();
         $user_data = array($user_id,$email_id,$user_ip);
         
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $mergedata = array_merge(
                    $this->getRequest()->getPost()->toArray() ,$user_data
            ); 
            $form->setData($mergedata);
//            $newscategoryEntity = new Newscategories();

//            $form->setInputFilter(new NewscategoryFilter());
            //$form->setData($request->getPost());


            if ($form->isValid()) {

//                $newscategoryEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                //$this->getNewscategoryTable()->SaveNewscategory($newscategoryEntity);
                $res= $this->newsService->SaveNewscategory($mergedata);
                

//                return $this->redirect()->toRoute('admin', array(
//                            'action' => 'indexnewscategory',
//                            'controller' => 'news'
//                ));
                return $this->redirect()->toRoute('admin/news', array('action' => 'indexnewscategory'));
            }
        }

        return new ViewModel(array('form' => $form));
    }

    public function editnewscategoryAction() {


        $form = new NewscategoryForm();
        if ($this->params()->fromRoute('id') > 0) {
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
//            $newscategory = $this->getNewscategoryTable()->getNewscategory($id);
            $newscategory= $this->newsService->getNewscategory($id);
            // print_r($religion);die;
            $form->bind($newscategory);
            $form->get('submit')->setAttribute('value', 'Save');
            // $this->editAction($form)
        }
        
        $session= new \Zend\Session\Container('admin');
        $user_id = $session->offsetGet('id');
         $email_id = $session->offsetGet('email');
         $remote = new \Zend\Http\PhpEnvironment\RemoteAddress;
         $user_ip = $remote->getIpAddress();
         $user_data = array($user_id,$email_id,$user_ip);
         
        $request = $this->getRequest();
        if ($request->isPost()) {
            
             
            $mergedata = array_merge(
                    $this->getRequest()->getPost()->toArray() ,$user_data
            ); 
            $form->setData($mergedata);
//            $newscategoryEntity = new Newscategories();

//            $form->setInputFilter(new NewscategoryFilter());
            //$form->setData($request->getPost());


            if ($form->isValid()) {

//                $newscategoryEntity = $form->getData();
                // print_r($newscategoryEntity);die;
//                $this->getNewscategoryTable()->SaveNewscategory($newscategoryEntity);
                $res= $this->newsService->SaveNewscategory($mergedata);

//                return $this->redirect()->toRoute('admin', array(
//                            'action' => 'indexnewscategory',
//                            'controller' => 'news'
//                ));
                return $this->redirect()->toRoute('admin/news', array('action' => 'indexnewscategory'));
            }
        }

        return new ViewModel(array('form' => $form, 'id' => $id));
    }

    public function deletenewscategoryAction() {

        $id = $this->params()->fromRoute('id');
//        $state = $this->getNewscategoryTable()->deleteNewscategory($id);
        $state= $this->adminService->delete('tbl_newscategory', $id);
//        return $this->redirect()->toRoute('admin', array(
//                    'action' => 'indexnewscategory',
//                    'controller' => 'news'
//        ));
        return $this->redirect()->toRoute('admin/news', array('action' => 'indexnewscategory'));
    }

    public function viewnewscategoryAction() {
        $id = $this->params()->fromRoute('id');

//        $Info = $this->getNewscategoryTable()->getNewscategory($id);
        $Info = $this->newsService->viewByNewscategoryId('tbl_newscategory', $id);

        return new ViewModel(array('Info' => $Info));
    }
    
    public function ajaxradiosearchAction() {
        $status = $_POST['is_active'];
//        echo  "<pre>";
//        print_r($status);exit;
        //$this->data = array("IsActive=$status");
        $this->data = $status;

        //$religions = $this->getReligionTable()->fetchAll($this->data);
        $newscategories = $this->newsService->getNewscategoryRadioList($_POST['is_active'])->toArray();
//        echo  "<pre>";
//        print_r($newscategories);exit;
        // return new ViewModel(array('countries' => $countries));

        $view = new ViewModel(array('newscategories' => $newscategories));
        $view->setTemplate('admin/news/newscategoryList');
        $view->setTerminal(true);
        return $view;
//        return new ViewModel(array(
//            'newscategories' => $newscategories));
    }
    
    public function newscategorysearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
//        echo  "<pre>";
//        print_r($data);die;

        //$result = $adapter->query("select * from tbl_religion where religion_name like '$data%' ", Adapter::QUERY_MODE_EXECUTE);
        $result = $this->newsService->newscategorySearch($data);


        $view = new ViewModel(array("Results" => $result));
        $view->setTerminal(true);
        return $view;
        exit();
    }
    
    public function performsearchAction() {
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        //$field1 = empty($_POST['religion_name']) ? "" : "religion_name like '" . $_POST['religion_name'] . "%'";
        
        //$sql = "select * from tbl_religion where " . $field1 . "";
       // $sql = rtrim($sql, "&&");
        //$results = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $results = $this->newsService->performSearchNewscategory($_POST['category_name']);

        $view = new ViewModel(array("results" => $results));
        $view->setTerminal(true);
        return $view;


        exit();
    }
    
    public function categorychangestatusAction() {
        $session= new \Zend\Session\Container('admin');
       $user_id = $session->offsetGet('id');
        //$data = (object) $_POST;
        $request=$this->getRequest();
        //$return = $this->getReligionTable()->updatestatus($data);
        $result= $this->adminService->changeStatus('tbl_newscategory', $request->getPost('id'), $request->getPost(), $user_id);
        // print_r($return);
        return new JsonModel($result);
        //exit();
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

            $new_image = PUBLIC_PATH . '/NewsImages/' . $name;
            $new_image_thumb = PUBLIC_PATH . '/NewsImages/thumb/100x100/' . $name;
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
                $imgidpath = "/NewsImages/" . $name;

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


                        $new_image = PUBLIC_PATH . '/NewsImages/' . $name;
                        $new_image_thumb = PUBLIC_PATH . '/NewsImages/thumb/100x100/' . $name;
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
                            $imgidpath = "/NewsImages/" . $name;
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
