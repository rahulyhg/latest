<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Zend\Mail;
use Zend\Mime;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;

ini_set("display_errors", 1);

class IndexController extends AppController {

    protected $_contactTable;
    protected $indexService;

    public function __construct(\Application\Service\IndexServiceInterface $indexService) {
        $this->indexService = $indexService;
    }

    public function indexAction() {
   //\Zend\Debug\Debug::dump( $this->MyPlugin()->getCommunityMemberType('0',array(2,3,2,4),'0'));
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        foreach ($this->indexService->getExecutiveMember() as $exData) {


            $exedata['uid'] = $exData->uid;
            $exedata['id'] = $exData->id;
            $exedata['city_name'] = $exData->city_name;
            $exedata['state_id'] = $exData->state_id;
            $exedata['is_active'] = $exData->is_active;
            $exedata['full_name'] = $exData->full_name;
            $exedata['last_name'] = $exData->last_name;
            $exedata['address'] = $exData->address;
            $exedata['profession'] = $exData->profession;
            $exedata['age'] = $exData->age;
            $exedata['height'] = $exData->height;
            $exedata['city'] = $exData->city;
            $exedata['gender'] = $exData->gender;
            $exedata['category_name'] = $exData->category_name;


            if ($exData->father_id > 0) {
                $eddd = $adapter->query("SELECT full_name FROM tbl_user_info WHERE user_id=$exData->father_id", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
                $exedata['father_name'] = $eddd[0]['full_name'];
            } else {
                $exedata['father_name'] = '';
            }
            $propicsql = $adapter->query("SELECT * FROM tbl_user_gallery WHERE user_id=$exData->uid AND profile_pic=1 ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
            if (isset($propicsql[0]['image_path'])) {
                $exedata['profile_photo'] = $propicsql[0]['image_path'];
            } else {
                $exedata['profile_photo'] = '';
//                if ($exedata['gender'] == 'Male') {
//                    $exedata['profile_pc'] = 'default_user.png';
//                } else {
//                    $exedata['profile_pc'] = 'default_user.png';
//                }
            }
            //$exedata['father_name']=$ddd[0]['full_name'];
            //$userservice->userSummaryById($GrData->uid);
            $executivedata[] = $exedata;
//            echo '<pre>';
//        print_r($propicsql[0]['image_path']);
        }
//        foreach ($executivedata as $exdatas){
//            $edata[]=$exdatas;
//        }
//        \Zend\Debug\Debug::dump($edata);

        /*         * ****Fetch all Members Data from db******** */
//        $GroomData = $adapter->query("select tbl_user.id as uid,tbl_city.*,tbl_user_info.profile_photo,tbl_user_info.full_name,tbl_user_info.age,tbl_user_info.height,tbl_user_info.city,tbl_user_info.address,tbl_user_info.about_yourself_partner_family,tbl_family_info.father_name,tbl_profession.profession from tbl_user 
//		 INNER JOIN tbl_user_info on tbl_user_info.user_id=tbl_user.id
//		 INNER JOIN tbl_city on tbl_user_info.city=tbl_city.id
//		 INNER JOIN tbl_family_info on tbl_user.id=tbl_family_info.user_id
//         INNER JOIN tbl_profession on tbl_user_info.profession=tbl_profession.id
//         INNER JOIN tbl_user_roles on tbl_user_info.user_id=tbl_user_roles.user_id	
//		 		 
//		 where tbl_user_roles.IsMember='1'  ORDER BY tbl_user.id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);



        /*         * ****Return to View Model******** */
//        $date = date('Y-m-d h:i:s');
//        $Upcoming_events = $adapter->query("select * from tbl_upcoming_events where (event_date>'" . $date . "' && IsActive=1) ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
//        $ExecMembers = $adapter->query("select tbl_communities.category_name,tbl_user_info.user_id as uid,tbl_user.id,tbl_city.*,tbl_user_info.profile_photo,tbl_user_info.full_name,tbl_user_info.age,tbl_user_info.height,tbl_user_info.city,tbl_user_info.address,tbl_user_info.about_yourself_partner_family,tbl_family_info.father_name,tbl_profession.profession from tbl_user 
//		 INNER JOIN tbl_user_info on tbl_user_info.user_id=tbl_user.id
//		 INNER JOIN tbl_city on tbl_user_info.city=tbl_city.id
//		 INNER JOIN tbl_family_info on tbl_user.id=tbl_family_info.user_id
//         INNER JOIN tbl_profession on tbl_user_info.profession=tbl_profession.id		 
//		 INNER JOIN tbl_user_roles on tbl_user_info.user_id=tbl_user_roles.user_id
//		 INNER JOIN tbl_communities on tbl_user_info.comm_mem_id = tbl_communities.id		 
//		 where tbl_user_roles.IsExecutive='1'  ORDER BY tbl_user.id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        // foreach ($ExecMembers as $exe) {
        // 	echo $exe->uid;
        // }
        // print_r($ExecMembers);die;
        //$GroomData = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE); 
        $userservice = new \Application\Mapper\UserDbSqlMapper($adapter);
       //echo '<pre>';
        //print_r($this->indexService->getMatrimonialData()); die;
        foreach ($this->indexService->getGroomData() as $GrData) {

            $groomdata['uid'] = $GrData->uid;
            $groomdata['id'] = $GrData->id;
            $groomdata['city_name'] = $GrData->city_name;
            $groomdata['state_id'] = $GrData->state_id;
            $groomdata['is_active'] = $GrData->is_active;
            $groomdata['full_name'] = $GrData->full_name;
            $groomdata['last_name'] = $GrData->last_name;
            $groomdata['address'] = $GrData->address;
            $groomdata['profession'] = $GrData->profession;
            $groomdata['age'] = $GrData->age;
            $groomdata['height'] = $GrData->height;
            $groomdata['city'] = $GrData->city;
            $groomdata['gender'] = $GrData->gender;


            if ($GrData->father_id > 0) {
                $ddd = $adapter->query("SELECT full_name,last_name FROM tbl_user_info WHERE user_id=$GrData->father_id", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
                $groomdata['father_name'] = $ddd[0]['full_name'];
                $groomdata['last_name'] = $ddd[0]['last_name'];
            } else {
                $groomdata['father_name'] = '';
                $groomdata['last_name'] = '';
            }
            $propicsql = $adapter->query("SELECT * FROM tbl_user_gallery WHERE user_id=$GrData->uid AND profile_pic=1 ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
            if (isset($propicsql[0]['image_path'])) {
                $groomdata['profile_photo'] = $propicsql[0]['image_path'];
            } else {
                $groomdata['profile_photo'] = '';
//                if ($groomdata['gender'] == 'Male') {
//                    $groomdata['profile_pc'] = 'default_user.png';
//                } else {
//                    $groomdata['profile_pc'] = 'default_user.png';
//                }
            }
            //$groomdata['father_name']=$ddd[0]['full_name'];
            //$userservice->userSummaryById($GrData->uid);
            $grdata[] = $groomdata;
//            echo '<pre>';
//        print_r($propicsql[0]['image_path']);
        }

//        echo '<pre>';
//        print_r($grdata);
        
        //\Zend\Debug\Debug::dump($this->indexService->getMatrimonialData());exit;
        $matrimonialbridedata=$this->indexService->getMatrimonialBrideData();
        $matrimonialgroomdata=$this->indexService->getMatrimonialGroomData();
        //$this->indexService->getMatrimonialData();
        
//          foreach ($this->indexService->getMatrimonialData() as $MatData) {
//
//            $matdata['uid'] = $MatData->uid;
//            $matdata['id'] = $MatData->id;
//            $matdata['city_name'] = $MatData->city_name;
//            $matdata['state_id'] = $MatData->state_id;
//            $matdata['is_active'] = $MatData->is_active;
//            $matdata['full_name'] = $MatData->full_name;
//            $matdata['address'] = $MatData->address;
//            $matdata['profession'] = $MatData->profession;
//            $matdata['age'] = $MatData->age;
//            $matdata['height'] = $MatData->height;
//            $matdata['city'] = $MatData->city;
//            $matdata['gender'] = $MatData->gender;
//
//
//            if ($MatData->father_id > 0) {
//                $ddd = $adapter->query("SELECT full_name FROM tbl_user_info WHERE user_id=$MatData->father_id", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
//                $matdata['father_name'] = $ddd[0]['full_name'];
//            } else {
//                $matdata['father_name'] = '';
//            }
//            $propicsql = $adapter->query("SELECT * FROM tbl_user_gallery WHERE user_id=$MatData->uid AND profile_pic=1 ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
//            if (isset($propicsql[0]['image_path'])) {
//                $matdata['profile_photo'] = $propicsql[0]['image_path'];
//            } else {
//                $matdata['profile_photo'] = '';
//            }
//            $matrimonialdata[] = $matdata;
//
//        }
        
        $this->flashMessenger()->addMessage(array('success' => 'Custom success message to be here...'));
        if (isset($grdata)) {
            $grdata = $grdata;
        } else {
            $grdata = array();
        }
        if (isset($executivedata)) {
            $executivedata = $executivedata;
        } else {
            $executivedata = array();
        }
        
        if (isset($matrimonialbridedata)) {
            $matrimonialbridedata = $matrimonialbridedata;
        } else {
            $matrimonialbridedata = array();
        }
        
        if (isset($matrimonialgroomdata)) {
            $matrimonialgroomdata = $matrimonialgroomdata;
        } else {
            $matrimonialgroomdata = array();
        }
//        echo "<pre>";
//        print_r($matrimonialdata);
//        echo "</pre>";
        return new ViewModel(array("GroomData" => $grdata,
            "Upcoming_events" => $this->indexService->getUpcomingEvents(),
            "ExecMembers" => $executivedata,
            "MatriData" => $matrimonialbridedata,
            "MatriGroomData" => $matrimonialgroomdata));
    }

    public function viewProfileAction() {

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $param = $this->params()->fromRoute('param', false);
        //\Zend\Debug\Debug::dump($param);
        //exit;
        if ($param == 'entertain') {
            $sql = "SELECT * FROM tbl_post_category WHERE category_name=:name1 OR category_name=:name2 OR category_name=:name3";
            $statement = $adapter->query($sql);

            $parameters = array(
                'name1' => 'Jokes',
                'name2' => 'sms',
                'name3' => 'Poems'
            );

            $postresults = $statement->execute($parameters);
            //\Zend\Debug\Debug::dump($postresults);

            foreach ($postresults as $postresults) {
                $sql = "SELECT * FROM tbl_post WHERE post_category=" . $postresults['id'];
                $postList[$postresults['category_name']] = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            }
//
//            foreach ($postList['sms'] as $postList) {
//                \Zend\Debug\Debug::dump($postList);
////                foreach ($postList as $data) {
////                   
////                    $mydata[]=$data;
////                }
//            }
             //\Zend\Debug\Debug::dump($mydata);
            //exit;
            //\Zend\Debug\Debug::dump($listdata);

            //echo $postresults['id'];
            //exit;
            
                $viewModel = new ViewModel(array(
                    'Fun' => $postList
                ));
                $viewModel->setTemplate('application/index/entertain.phtml');

                return $viewModel;
           
        }

        $sql = "SELECT * FROM tbl_post_category WHERE category_name=:name";
        $statement = $adapter->query($sql);

        $parameters = array(
            'name' => urldecode($param)
        );

        $postresults = $statement->execute($parameters)->current();
        //foreach ($results as $row){
        //print_r($postresults);
        //}
        //echo $postresults['id'];
        //exit;
        if (count($postresults) > '0') {
            $sql = "SELECT * FROM tbl_post WHERE post_category=" . $postresults['id'];
            $postList = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            $viewModel = new ViewModel(array(
                'data' => $postList
            ));
            $viewModel->setTemplate('application/index/postlist.phtml');

            return $viewModel;
        }
    }

    public function aboutAction() {


        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "select * from tbl_pages where page_name='about'";
        $data = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->current();
        return new ViewModel(array('data' => $data));
    }

    public function historyAction() {

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "select * from tbl_pages where page_name='history'";
        $data = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->current();
        return new ViewModel(array('data' => $data));
    }

    public function communitiesAction() {
        $sql = "select * from tbl_rustagi_institutions";

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /*         * ****Fetch all Members Data from db******** */
        $InstData = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

        $CommunityData = array();

        foreach ($InstData as $idata) {

            $result[] = $idata;
            $MemberData = $adapter->query("select * from tbl_rustagi_institutions_members where institute_id='" . $idata->id . "'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            if (count($MemberData) > 0) {
                $CommunityData[$idata->id] = $MemberData;
            }
        }


        $filters_data = $this->sidebarFilters();

        return new ViewModel(array('InstData' => $result, 'CommunityData' => $CommunityData, "filters_data" => $filters_data));
    }

    public function visionAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "select * from tbl_pages where page_name='vision'";
        $data = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->current();
        return new ViewModel(array('data' => $data));
    }

    public function contactAction() {
        if ($this->params()->fromRoute('id') == 1) {
            $msg = "Message sent successfully";
        } else
            $msg = "";

        $contactform = new \Application\Form\ContactForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $page = new \Application\Model\Entity\Contact();
            $contactform->setInputFilter($page->getInputFilter());
            $contactform->setData($request->getPost());
            $data = (array) $request->getPost();
            if ($contactform->isValid()) {

                $page->exchangeArray($data);
                unset($page->inputFilter);
                // print_r($page); exit;
//                  // $this->renderer = $this->getServiceLocator()->get('ViewRenderer');  
                $content = "<table border=1>
<tbody>
<tr>
<td>Name</td>
<td>'" . $page->name . "'</td>
</tr>
<tr>
<td>Phone Number</td>
<td>" . $page->phone_no . "</td>
</tr>
<tr>
<td>Email</td>
<td>" . $page->email . "</td>
</tr>
<tr>
<td>Message</td>
<td>" . $page->message . "</td>
</tr>
</tbody>
</table>";



                $this->mailsetup($content);

                //exit;
                $id = $this->getContactTable()->saveContact($page);
                // Something works
                $this->flashMessenger()->addMessage('Mail sent successfully . We will get back to you within 24 hrs. Thank you');

                return $this->redirect()->toRoute('contact');
            }
        }

        $sql = "select * from tbl_rustagi_institutions";

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /*         * ****Fetch all Members Data from db******** */
        $InstData = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

        $CommunityData = array();

        foreach ($InstData as $idata) {

            $result[] = $idata;
            $MemberData = $adapter->query("select * from tbl_rustagi_institutions_members where institute_id='" . $idata->id . "'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            if (count($MemberData) > 0) {
                $CommunityData[$idata->id] = $MemberData;
            }
        }


        $filters_data = $this->sidebarFilters();

        return new ViewModel(array('InstData' => $result, 'CommunityData' => $CommunityData, "filters_data" => $filters_data, "form" => $contactform, "message" => $msg));
    }

    public function photoGalleryAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $Events_photos = $adapter->query("select * from tbl_upcoming_events ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        // print_r($Events_photos);die;
        return new ViewModel(array("Events_photos" => $Events_photos));
    }

    public function sidebarFilters() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        // $select=$this->getServiceLocator()->get('Zend\Db\sql\Expression');

        $filters_array = array("country" => "tbl_country", "city" => "tbl_city", "state" => "tbl_state");

        foreach ($filters_array as $key => $table) {

            $filters_data[$key] = $adapter->query("select * from " . $table . "", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        }
        return $filters_data;
    }

    public function mailsetup($content) {
        //\Zend\Debug\Debug::dump($content);exit;

        $options = new Mail\Transport\SmtpOptions(array(
            'name' => 'localhost',
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'connection_class' => 'login',
            'connection_config' => array(
                'username' => 'funstartswithyou15@gmail.com',
                'password' => 'watchmyvideos',
                'ssl' => 'tls',
            ),
        ));

//        $options = new Mail\Transport\SmtpOptions();  
//        $options->setHost('smtp.gmail.com')
//            ->setConnectionClass('login')
//            ->setName('smtp.gmail.com')
//            ->setConnectionConfig(array(
//                'username' => 'funstartswithyou15@gmail.com',
//                'password' => 'watchmyvideos',
//                'ssl' => 'tls',
//            ));


        $html = new MimePart($content);
        $html->type = "text/html";
        $body = new MimeMessage();
        $body->setParts(array($html));
//        \Zend\Debug\Debug::dump($body);exit;
// instance mail   
        $mail = new Mail\Message();
        $mail->setBody($body); // will generate our code html from template.phtml  
        $mail->setFrom('munanshu.madaank23@gmail.com', 'Sender Name');
        $mail->setTo('amirraza278@gmail.com'); // php1@hello42cab.com
        $mail->setSubject("Rustagi Contact Mail");

//\Zend\Debug\Debug::dump($mail);exit;
        $transport = new Mail\Transport\Smtp($options);
        $status = $transport->send($mail);
    }

    public function getContactTable() {

        if (!$this->_contactTable) {
            $sm = $this->getServiceLocator();
            $this->_contactTable = $sm->get('Application\Model\ContactTable');
        }
        return $this->_contactTable;
    }

    public function feeAction() {
        return new ViewModel();
    }

    public function membershipfeeAction() {
        return new ViewModel();
    }

    public function matrimonialfeeAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql="select * FROM tbl_membership_subpackage where package_id=2";
        $sqlfeature="select * FROM tbl_membership_features";     
        $packages= $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
        $features= $adapter->query($sqlfeature, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
        

        return new ViewModel(array("packages" => $packages,'features'=>$features));
    }

    public function advertisewithusAction() {
        return new ViewModel();
    }

	public function termsOfUseAction() {
        return new ViewModel();
    }
	
	public function careerAction() {
        return new ViewModel();
    }


//    public function healthAndFoodAction(){
//        return new ViewModel();
//    }
}

?>