<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Zend\Mail;  
use Zend\Mime;  
use Zend\Mime\Part as MimePart;  
use Zend\Mime\Message as MimeMessage; 

class PagesController extends AppController
{
	protected $_contactTable;
	
	public function aboutAction()
    {
        return new ViewModel();
    }
	public function signupAction()
    {
        return new ViewModel();
    }
	public function entertainAction()
    {   
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $entertain = array(3=>"Jokes",4=>"SMS",5=>"Poems");
         

        foreach ($entertain as $key => $value) {

            $sql = "select tbl_post.*,tbl_user.*,tbl_post.id as postid,tbl_post.created_date as postdate from tbl_post inner join tbl_user 
        on tbl_post.user_id=tbl_user.id where (tbl_post.post_category=$key && tbl_post.IsActive=1) order by tbl_post.id DESC";

            $PostData=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

            $entertainarr[$value] = $PostData;
        }
         

        return new ViewModel(array("Fun"=>$entertainarr));
        
    }
		public function jokeAction()
    {
        return new ViewModel();
    }

    public function staticpagesAction()
    {
         if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
        }

        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $sql = "select * from tbl_static_pages where (tab_id=$id && IsActive=1)";
                        
         $PageData=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

         // foreach ($PageData as $page) {
         //    $pagecontents["page"] = $page->page_title;
         // }
         // print_r($PageData->page_title);
         // die;

        return new ViewModel(array("PageData"=>$PageData));
    }

		public function smsAction()
    {
        return new ViewModel();
    }
		public function poemAction()
    {
        return new ViewModel();
    }
		public function devotionalAction()
    {
        // $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        // $sql = "select tbl_post.*,tbl_user.*,tbl_post.id as postid,tbl_post.created_date as postdate from tbl_post inner join tbl_user 
        // on tbl_post.user_id=tbl_user.id where (tbl_post.post_category=7 && tbl_post.IsActive=1) order by tbl_post.id DESC";
        

        //     /******Fetch all Members Data from db*********/             
        //  $PostData=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

        //  // print_r($PostData);die;

        // return new ViewModel(array("PostData"=>$PostData));
    }
	public function devotionalviewAction()
    {   
       //   if($this->params()->fromRoute('id')>0){
       //      $id = $this->params()->fromRoute('id');
       //  }
       //  else $id = Null;

       // $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

       //  $sql = "select tbl_post.*,tbl_user.*,tbl_user_info.*,tbl_post.id as postid ,tbl_post.created_date as postdate from tbl_post inner join tbl_user 
       //  on tbl_post.user_id=tbl_user.id inner join tbl_user_info 
       //  on tbl_post.user_id=tbl_user_info.user_id where (tbl_post.id=$id)";
        

       //      *****Fetch all Members Data from db********             
       //   $PostSingle=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
       //   foreach ($PostSingle as $Post) {
       //          $posts['title'] = $Post->title;
       //          $posts['image'] = $Post->image;
       //          $posts['description'] = $Post->description;
       //          $posts['full_name'] = $Post->full_name;
       //          $posts['created_date'] = $Post->postdate;
       //   }
       //   // print_r($posts);die;

       //  return new ViewModel(array("posts"=>$posts));
        
    }

    public function postcatAction()
    {
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
        }
        else $id = Null;

         $catname=$adapter->query("select * from tbl_postcategory where id=$id", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
         foreach ($catname as $cat) {
            $category = $cat->category_name;
         }

        $sql = "select tbl_post.*,tbl_user.*,tbl_post.id as postid,tbl_post.created_date as postdate from tbl_post inner join tbl_user 
        on tbl_post.user_id=tbl_user.id where (tbl_post.post_category=$id && tbl_post.IsActive=1) order by tbl_post.id DESC";
                        
         $PostData=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
         // print_r($PostData);die;

        return new ViewModel(array("PostData"=>$PostData,"category"=>$category));

    }
	
	public function healthfoodAction()
    {
        // $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        // $sql = "select tbl_post.*,tbl_user.*,tbl_post.id as postid,tbl_post.created_date as postdate from tbl_post inner join tbl_user 
        // on tbl_post.user_id=tbl_user.id where (tbl_post.post_category=6 && tbl_post.IsActive=1) order by tbl_post.id DESC";
        

        //     /******Fetch all Members Data from db*********/             
        //  $PostData=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

        //  // print_r($PostData);die;

        // return new ViewModel(array("PostData"=>$PostData));
    }
	
	public function healthfoodviewAction()
    {
       //  if($this->params()->fromRoute('id')>0){
       //      $id = $this->params()->fromRoute('id');
       //  }
       //  else $id = Null;

       // $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

       //  $sql = "select tbl_post.*,tbl_user.*,tbl_user_info.*,tbl_post.id as postid ,tbl_post.created_date as postdate from tbl_post inner join tbl_user 
       //  on tbl_post.user_id=tbl_user.id inner join tbl_user_info 
       //  on tbl_post.user_id=tbl_user_info.user_id where (tbl_post.id=$id)";
        

                      
       //   $PostSingle=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
       //   foreach ($PostSingle as $Post) {
       //          $posts['title'] = $Post->title;
       //          $posts['image'] = $Post->image;
       //          $posts['description'] = $Post->description;
       //          $posts['full_name'] = $Post->full_name;
       //          $posts['created_date'] = $Post->postdate;
       //   }
       //   // print_r($posts);die;

       //  return new ViewModel(array("posts"=>$posts));
    }

    public function postviewAction()
    {
       if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
        }
        else $id = Null;

       $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $sql = "select tbl_post.*,tbl_user.*,tbl_user_info.*,tbl_post.id as postid ,tbl_post.created_date as postdate from tbl_post inner join tbl_user 
        on tbl_post.user_id=tbl_user.id inner join tbl_user_info 
        on tbl_post.user_id=tbl_user_info.user_id where (tbl_post.id=$id)";
            
            $session = new Container('user');
                  $user_id=(empty($session->offsetGet('id')))? 0:$session->offsetGet('id');
                  $user_name=(empty($session->offsetGet('username')))? "not_user":$session->offsetGet('username');
          
                  // print_r($user_name);die;
            /******Fetch all Members Data from db*********/             
         $PostSingle=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
         foreach ($PostSingle as $Post) {
                $posts['id'] = $Post->postid;
                $posts['user_id'] = $user_id;
                $posts['user_name'] = $user_name;
                $posts['title'] = $Post->title;
                $posts['image'] = $Post->image;
                $posts['description'] = $Post->description;
                $posts['full_name'] = $Post->full_name;
                $posts['created_date'] = $Post->postdate;
         }
         $Comments = $this->PostsComments($Post->postid);

         $sqlviews = "INSERT INTO tbl_posts_views (post_id, user_id, user_name, ip_address)
SELECT * FROM (SELECT '$Post->postid','$user_id','$user_name','".$_SERVER['REMOTE_ADDR']."') AS tmp
WHERE NOT EXISTS (
    SELECT * FROM tbl_posts_views WHERE (post_id='$Post->postid' && ip_address='".$_SERVER['REMOTE_ADDR']."')
) LIMIT 1;";
          $adapter->query($sqlviews, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);


         $viewscounts = "SELECT post_id FROM tbl_posts_views WHERE (post_id='$Post->postid')";
          $viewscounts = $adapter->query($viewscounts, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->count();

                $posts['views'] = $viewscounts;

          

        return new ViewModel(array("posts"=>$posts,"PostComments"=>$Comments)); 


    }

    public function AddCommentAction()
    {   
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $created_date =date('Y-m-d h:i:s');
        $modified_date = date('Y-m-d h:i:s');
         $session = new Container('user');
                  $user_email=(empty($session->offsetGet('email')))? "not_user":$session->offsetGet('email');

        $sql = "insert into `tbl_posts_comments`(`post_id`, `user_id`, `sender_name`, `sender_email`, `comment_desc`,
         `IsActive`, `created_date`, `modified_date`, `modified_by`) VALUES 
(".$_POST['post_id'].",".$_POST['user_id'].",'".$_POST['user_name']."','".$user_email."','".$_POST['commentBody']."','0'
    ,'".$created_date."','".$modified_date."',0)";
          $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

         return $this->redirect()->toRoute('application/default', array(
                            'action' => 'postview',
                            'controller' => 'pages',
                            'id' => $_POST['post_id']
                ));

    }

    public function PostsComments($postid)
    {
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $sql = "select *,tbl_user_info.*,tbl_post.* from `tbl_posts_comments` as tps 
        left join tbl_user_info on tps.user_id=tbl_user_info.user_id 
        left join tbl_post on tps.post_id=tbl_post.id 
        where (tps.IsActive=1 && tps.post_id='$postid') order by tps.id DESC ";
//         $sql = "select *
// FROM ``tbl_posts_comments`` ";
         $Comments=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        
        return $Comments;
    }
	
	public function contactAction()
    {	
        if($this->params()->fromRoute('id')==1){
            $msg = "Message sent successfully";
        }
        else $msg = "";

		$contactform = new \Application\Form\ContactForm();
		$request=$this->getRequest();
		if($request->isPost())
		{				
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
<td>'".$page->name."'</td>
</tr>
<tr>
<td>Phone Number</td>
<td>".$page->phone_no."</td>
</tr>
<tr>
<td>Email</td>
<td>".$page->email."</td>
</tr>
<tr>
<td>Message</td>
<td>".$page->message."</td>
</tr>
</tbody>
</table>";  
  
 
 
    $this->mailsetup($content);
     
         
				$id=$this->getContactTable()->saveContact($page);				
				return $this->redirect()->toRoute('application/default', array(
							'action' => 'contact',
							'controller' => 'pages',
                            "id" => 1
				));
			}  
		}

        $sql = "select * from tbl_rustagi_institutions";

        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /******Fetch all Members Data from db*********/             
         $InstData=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

          $CommunityData = array();  

         foreach($InstData as $idata){

            $result[] = $idata;
                $MemberData=$adapter->query("select * from tbl_rustagi_institutions_members where institute_id='".$idata->id."'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                if(count($MemberData)>0){
                    $CommunityData[$idata->id] = $MemberData;
                }
                 
         }

          
         $filters_data = $this->sidebarFilters();
          
        return new ViewModel(array('InstData'=>$result,'CommunityData'=>$CommunityData,"filters_data"=>$filters_data,"form"=>$contactform,"message"=>$msg));
    }
	public function historyAction()
    {
        return new ViewModel();
    }
	public function teamAction()
    {
        return new ViewModel();
    }
	public function visionAction()
    {
        return new ViewModel();
    }
	public function communitiesAction()
    {   
        $sql = "select * from tbl_rustagi_institutions";

        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /******Fetch all Members Data from db*********/             
         $InstData=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

          $CommunityData = array();  

         foreach($InstData as $idata){

            $result[] = $idata;
                $MemberData=$adapter->query("select * from tbl_rustagi_institutions_members where institute_id='".$idata->id."'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                if(count($MemberData)>0){
                    $CommunityData[$idata->id] = $MemberData;
                }
                 
         }

          
         $filters_data = $this->sidebarFilters();
          
        return new ViewModel(array('InstData'=>$result,'CommunityData'=>$CommunityData,"filters_data"=>$filters_data));

    }
    public function sidebarFilters()
    {
       $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
       // $select=$this->getServiceLocator()->get('Zend\Db\sql\Expression');

        $filters_array = array("country"=>"tbl_country","city"=>"tbl_city","state"=>"tbl_state");

        foreach($filters_array as $key =>$table){

            $filters_data[$key] = $adapter->query("select * from ".$table."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        }
        return $filters_data;
    }

    public function institutefiltersAction()
    {
        
        $sql = "select * from tbl_rustagi_institutions where ".$_POST['type']." =".$_POST['value']." ";

        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /******Fetch all Members Data from db*********/             
         $InstData=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

          $CommunityData = array();  

         foreach($InstData as $idata){

            $result[] = $idata;
                $MemberData=$adapter->query("select * from tbl_rustagi_institutions_members where institute_id='".$idata->id."'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                if(count($MemberData)>0){
                    $CommunityData[$idata->id] = $MemberData;
                }
                 
         }


         if($_POST['type']=="country"){

                $state_name=$this->getStateTable()->getStateListByCountryCode($_POST['value']);

                $output[] = "<option>---Select---state---</option>";
         
                    foreach($state_name as $states)
                        {
                             $output[] = "<option value=".$states['id'].">".$states['state_name']."</option>";
                        }
         
                    $output[] = "</select>";
                    echo "<div id='CSCresults' ftyle='state' style='display:none;'>".join("",$output)."</div>";
             }

             if($_POST['type']=="state"){

                $city_name=$this->getCityTable()->getCityListByStateCode($_POST['value']);

                $output[] = "<option>---Select---city---</option>";
         
                    foreach($city_name as $cities)
                        {
                             $output[] = "<option value=".$cities['id'].">".$cities['city_name']."</option>";
                        }
         
                    $output[] = "</select>";
                    echo "<div id='CSCresults' ftyle='city' style='display:none;'>".join("",$output)."</div>";
             }



        $view = new ViewModel(array('InstData'=>$result,'CommunityData'=>$CommunityData));
        $view->setTerminal(true);
        return $view;
        
        exit();
    }

	public function branchesAction()
    {
        return new ViewModel();
    }
	public function galleryAction()
    {
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $Events_photos=$adapter->query("select * from tbl_upcoming_events ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        // print_r($Events_photos);die;
        return new ViewModel(array("Events_photos"=>$Events_photos));
    }
	
	
	#################################################
	 public function getContactTable() {

        if (!$this->_contactTable) {
            $sm = $this->getServiceLocator();
            $this->_contactTable = $sm->get('Application\Model\ContactTable');
        }
        return $this->_contactTable;
    }
	####### Function to make Drop down for User Type #########

    public function contactfiltersAction()
    {
       $querystring = explode(",",$_POST['querystringarray']);

       foreach ($querystring as $key => $value) { 

                $string = explode("=",$value);

                // if(preg_match("/0$/",$value)==true)
                if($string[1] == null || $string[1] == "null")
                    continue;
                else $querypart.= $value." && ";
       }

        if($querypart==""){
            $querypart=0;
        }

       $refinestring = rtrim($querypart," &&");

       $sql = "select * from tbl_rustagi_institutions where (".$refinestring.") ";
       // print_r($sql);
        // echo $_POST['querystringarray'];
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /******Fetch all Members Data from db*********/             
         $InstData=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

          $CommunityData = array();  

         foreach($InstData as $idata){

            $result[] = $idata;
                $MemberData=$adapter->query("select * from tbl_rustagi_institutions_members where institute_id='".$idata->id."'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                if(count($MemberData)>0){
                    $CommunityData[$idata->id] = $MemberData;
                }
                 
         }

        $view = new ViewModel(array('InstData'=>$result,'CommunityData'=>$CommunityData));
        $view->setTerminal(true);
        return $view;
         

        exit();
    }

    public function mailsetup($content)
    {

        $options = new Mail\Transport\SmtpOptions(array(  
            'name' => 'localhost',  
            'host' => 'smtp.gmail.com',  
            'port'=> 587,  
            'connection_class' => 'login',  
            'connection_config' => array(  
                'username' => 'funstartswithyou15@gmail.com',  
                'password' => 'watchmyvideos',  
                'ssl'=> 'tls',  
            ),  
        ));  

        $html = new MimePart($content);  
        $html->type = "text/html";  
        $body = new MimeMessage();  
        $body->setParts(array($html));  
  
// instance mail   
$mail = new Mail\Message();  
$mail->setBody($body); // will generate our code html from template.phtml  
$mail->setFrom('munanshu.madaank23@gmail.com','Sender Name');  
$mail->setTo('php1@hello42cab.com');  
$mail->setSubject("Rustagi Contact Mail");  
  
$transport = new Mail\Transport\Smtp($options);  
$status = $transport->send($mail);


    }
	
}
?>
