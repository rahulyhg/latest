<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Form\EventparticipationForm;
use Application\Form\Filter\EventParticipationFormFilter;
use Zend\Db\Adapter\Adapter;
use Zend\Debug\Debug;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class EventsController extends AppController {

    public function indexAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /*         * ****Fetch all Members Data from db******** */
        $date = date('Y-m-d h:i:s');
        $sql = "select * from tbl_event where (event_date>'" . $date . "') and is_active=1 ORDER BY event_id DESC";
        $EventsData = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        /*         * ****Return to View Model******** */
        // $filters_data = $this->sidebarFilters();
        $filters_data = $this->sidebarFilters();

        return new ViewModel(array("EventsData" => $EventsData, "filters_data" => $filters_data));
    }

    public function PreviousAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /*         * ****Fetch all Members Data from db******** */
        $date = date('Y-m-d h:i:s');
        $sql = "select * from tbl_event where (event_date<'" . $date . "') and is_active=1 ORDER BY event_id DESC";
        $EventsData = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        /*         * ****Return to View Model******** */
        // $filters_data = $this->sidebarFilters();
        $filters_data = $this->sidebarFilters();

        return new ViewModel(array("EventsData" => $EventsData, "filters_data" => $filters_data));
    }

    public function ViewAction() {
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');

        if ($this->params()->fromRoute('id') > 0) {
            $id = $this->params()->fromRoute('id');
        } else
            $id = Null;

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $sql_update = "UPDATE tbl_event SET view_count=view_count+1 WHERE event_id='$id'";
        $adapter->query($sql_update, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

        // Query to Count Total Likes for the post ///
        $sql_select = "SELECT view_count,like_count FROM tbl_event WHERE event_id='$id'";
        $totalLikes = $adapter->query($sql_select, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->current();

        // Query to count total likes ////
        $sql1 = "select count(event_like_id) as total_likes from tbl_event_like
        where event_id='$id' and user_id='$user_id'";
        $totalCount = $adapter->query($sql1, Adapter::QUERY_MODE_EXECUTE)->current();

        echo $sql_subevt = "select tn.*,tal.username from tbl_subevent as tn
      inner join tbl_admin_login as tal on tn.created_by=tal.id where tn.event_id='$id' and "
                . "tn.is_active=1";
        $AllSubEvents = $adapter->query($sql_subevt, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

        $sql_evt = "select * from tbl_event where event_id='$id' and is_active=1";
        $Events = $adapter->query($sql_evt, Adapter::QUERY_MODE_EXECUTE)->current();

        $filters_data = $this->sidebarFilters();
        return new ViewModel(array(
            "filters_data" => $filters_data,
            "AllSubEvents" => $AllSubEvents,
            "Events" => $Events,
            'totalLikes' => $totalLikes,
            'totalCount' => $totalCount,
        ));
    }

    public function sidebarFilters() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        // $select=$this->getServiceLocator()->get('Zend\Db\sql\Expression');

        $filters_array = array("country" => "tbl_country", "city" => "tbl_city");

        foreach ($filters_array as $key => $table) {
            $filters_data[$key] = $adapter->query("select * from " . $table . "", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        }
        return $filters_data;
    }

    public function eventsfiltersAction() {
        $date = date('Y-m-d h:i:s');

        if (isset($_POST['pagename'])) {
            if (strpos($_POST['pagename'], 'previous') !== false) {
                $status = "event_date<'" . $date . "' and ";
                $eventType = "Previous Events";
            } else {
                $eventType = "UpComing Events";
                $status = "event_date>'" . $date . "' and ";
            }
        }


        if (isset($_POST['filtaction'])) {
            $sql = "select * from tbl_upcoming_events where (" . $status . " " . $_POST['type'] . " = '" . $_POST['value'] . "') ORDER BY id DESC";
        } else {
            $from = $this->convertdate($_POST['from']);
            $to = $this->convertdate($_POST['to']);
            $chkdatediff = $this->valdateselection($from, $to);

            if ($chkdatediff == false) {
                echo "From should be smaller than to";
                exit();
            }
            $sql = "select * from tbl_upcoming_events where (" . $status . " created_date BETWEEN '" . $from . "' AND '" . $to . "') ORDER BY id DESC";
        }

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /*         * ****Fetch all Members Data from db******** */
        $EventsData = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        /*         * ****Return to View Model******** */
        $view = new ViewModel(array('EventsData' => $EventsData, "Event" => $eventType));
        $view->setTerminal(true);
        return $view;
        exit();
    }

    public function convertdate($date) {

        $timestamp = strtotime($date);
        $date = date("Y/m/d h:i:s", $timestamp);
        return $date;
    }

    public function valdateselection($from, $to) {
        if (strtotime($from) > strtotime($to)) {
            return false;
        } else
            return true;
    }

    /// Function for Like Dislike Button //////
    public function ChangeLikeDislikeAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');

        if (!empty($_POST['event_id']) && !empty($_POST['rel'])) {
            $event_id = $_POST['event_id'];
            $rel = $_POST['rel'];
            $ip = $_SERVER['REMOTE_ADDR'];
            if ($rel == 'Like') {
//---Like----
                $sql1 = "select count(event_like_id) as total_likes from tbl_event_like
        where event_id='$event_id' and user_id='$user_id'";
                $totalCount = $adapter->query($sql1, Adapter::QUERY_MODE_EXECUTE)->current();
                $totalCount = $totalCount->total_likes;
                if ($totalCount == 0) {
                    $sql_insert = "INSERT INTO tbl_event_like (event_id,user_id,created_date,ip) VALUES('$event_id','$user_id',NOW(),'$ip')";
                    $adapter->query($sql_insert, Adapter::QUERY_MODE_EXECUTE);

                    $sql_update = "UPDATE tbl_event SET like_count=like_count+1 WHERE event_id='$event_id'";
                    $adapter->query($sql_update, Adapter::QUERY_MODE_EXECUTE);

                    $sql_select = "SELECT like_count FROM tbl_event WHERE event_id='$event_id'";
                    $totalLikes = $adapter->query($sql_select, Adapter::QUERY_MODE_EXECUTE)->current();
                    $totalLikes->like_count;
                }
            } else {
//---Unlike----
                $sql1 = "select count(event_like_id) as total_likes from tbl_event_like
        where event_id='$event_id' and user_id='$user_id'";
                $totalCount = $adapter->query($sql1, Adapter::QUERY_MODE_EXECUTE)->current();
                $totalCount = $totalCount->total_likes;
                if ($totalCount > 0) {

                    $sql_delete = "DELETE FROM tbl_event_like WHERE event_id='$event_id' and user_id='$user_id'";
                    $result = $adapter->query($sql_delete, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

                    $sql_update = "UPDATE tbl_event SET like_count=like_count-1 WHERE event_id='$event_id'";
                    $adapter->query($sql_update, Adapter::QUERY_MODE_EXECUTE);


                    $sql_select = "SELECT like_count FROM tbl_event WHERE event_id='$event_id'";
                    $totalLikes = $adapter->query($sql_select, Adapter::QUERY_MODE_EXECUTE)->current();
                    $totalLikes->like_count;
                }
            }

            $respArr = array("status" => 1, "data" => $totalLikes);
            return new JsonModel($respArr);
        }
    }

    public function eventParticipationAction() {
        //Debug::dump($this->getEventList());
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        \Application\Form\EventparticipationForm::$eventList = $this->getEventList();
        $form = new EventparticipationForm();
        /* $request = $this->getRequest();
          if ($request->isPost()) {
          $eventparticipationFilter = new EventParticipationFormFilter();
          $eventparticipationform->setInputFilter($eventparticipationFilter->getInputFilter());
          $eventparticipationform->setData($request->getPost());

          if ($eventparticipationform->isValid()) {
          $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
          }
          } */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            $eventparticipationFilter = new EventParticipationFormFilter();
            $form->setInputFilter($eventparticipationFilter);

            //exit;
            if ($form->isValid()) {
                $created_date = date('Y-m-d H:i:s');
                $ip = $_SERVER['REMOTE_ADDR'];
                //echo print_r($_POST); 

                $platform = $adapter->getPlatform();
                $sql = "INSERT INTO tbl_event_participants (participant_name,participant_dob, participant_father_name,"
                        . "participant_grandfather_name, participant_address,participant_phone_no,"
                        . "participant_mobile_no,participant_email,participant_image,created_date,ip) values (
                     " . $platform->quoteValue($_POST['participant_name']) . ",
                     " . $platform->quoteValue($_POST['participant_dob']) . ",
                     " . $platform->quoteValue($_POST['participant_father_name']) . ",
                     " . $platform->quoteValue($_POST['participant_grandfather_name']) . ",
                     " . $platform->quoteValue($_POST['participant_address']) . ",
                     " . $platform->quoteValue($_POST['participant_phone_no']) . ",
                     " . $platform->quoteValue($_POST['participant_mobile_no']) . ",
                     " . $platform->quoteValue($_POST['participant_email']) . ",
                     " . $platform->quoteValue($_POST['image']) . ",
                     " . $platform->quoteValue($created_date) . ",
                     " . $platform->quoteValue($ip) . ")";

                $stmt = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
                $newId = $stmt->getGeneratedValue();
                foreach ($_POST['subevent_id'] as $val) {
                    $sql1 = "INSERT INTO tbl_event_participations (participant_id,event_id,subevent_id,"
                            . "created_date,ip) values (
    " . $newId . ",
    " . $platform->quoteValue($_POST['event_id']) . ",
    " . $platform->quoteValue($val) . ",
    " . $platform->quoteValue($created_date) . ",
    " . $platform->quoteValue($ip) . ")";


                    $stmt1 = $adapter->query($sql1, Adapter::QUERY_MODE_EXECUTE);
                }
            } else {
//                $form->get('event_id')->setMessages(array('Event can`t be blank'));
//                $form->get('subevent_id')->setMessages(array('Sub-Event can`t be blank'));
//                $form->get('participant_name')->setMessages(array('Name can`t be blank','aa'));
//                $form->get('participant_dob')->setMessages(array('DOB can`t be blank'));
//                $form->get('participant_father_name')->setMessages(array('Father Name can`t be blank'));
//                $form->get('participant_grandfather_name')->setMessages(array('Grand Father Name can`t be blank'));
//                $form->get('participant_address')->setMessages(array('Address can`t be blank'));
//                $form->get('participant_phone_no')->setMessages(array('Phone No can`t be blank'));
//                $form->get('participant_mobile_no')->setMessages(array('Mobile No can`t be blank'));
//                $form->get('participant_email')->setMessages(array('Email No can`t be blank'));
                // $form->setMessages($messages)
                //Debug::dump($form->getMessages());  
                //$form->get('participant_phone_no')->setMessages(array('Phone No should be in digits only.'));
            }
        }

        return new ViewModel(array('form' => $form));
    }

    /*     * ****Ajax Call***** */

    public function getSubEventNameAction() {

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        if (!empty($_POST['Event_ID'])) {
            $event_id = $_POST['Event_ID'];
            $sql = "SELECT subevent_id,title,start_time,end_time,start_date from tbl_subevent WHERE event_id='$event_id' and is_active=1";
            $data = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);

            foreach ($data as $val) {
                $val['title'] = $val['title'] . " (From:" . date('H:i A', strtotime($val['start_time'])) . " To:" . date('H:i A', strtotime($val['end_time'])) . " On " . date('d-m-Y', strtotime($val['start_date'])) . ")";
                $output[$val['subevent_id']] = $val['title'];
            }
            //Debug::dump($output); die;
            if ($output != null) {
                $status = "Success";
                $subeventlist = $output;
            } else {
                $status = "UnSuccess";
                $subeventlist = "";
            }
            return new JsonModel(array("Status" => $status, "subeventlist" => $subeventlist));
        }
    }
    
    
        public function croppostimageAction() {

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

            $new_image = PUBLIC_PATH . '/EventsParticipantImages/' . $name;
            $new_image_thumb = PUBLIC_PATH . '/EventsParticipantImages/thumb/100x100/' . $name;
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
               
                $response = 'File uploaded Successfully.';
                //for testing purpose
                $imgidpath = "/EventsParticipantImages/" . $name;

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


                        $new_image = PUBLIC_PATH . '/EventsParticipantImages/' . $name;
                        $new_image_thumb = PUBLIC_PATH . '/EventsParticipantImages/thumb/100x100/' . $name;
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
                            $imgidpath = "/EventsParticipantImages/" . $name;
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

?>
