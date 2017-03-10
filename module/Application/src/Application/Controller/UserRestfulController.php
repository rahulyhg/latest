<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Application\Service\UserServiceInterface;
use Common\Service\CommonServiceInterface;
use Application\Service\UserRestfulserviceInterface;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Application\Form\Filter\SignupFormFilter;
use Zend\Http\Client as HttpClient;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Application\WebServiceConstant;


class UserRestfulController extends \Zend\Mvc\Controller\AbstractRestfulController{
   
    protected $userService;
    protected $commonService;
    protected $userRestfulService;
    private $userExit ='user exit';
    private $userInActive = 'user inactive';
    private $userActive = 'user Active';
    private $userNotExit= 'user not exit';
    private $userNameExit='username not available';
    private $mobileNumberExit='Mobile already registered with us';
    private $emailNameExit='Email id not available';
    private $inVaildArrugment ='Exception\InvalidArgumentException';
    private $userExitInBoth= 'User exit in both';
    private $notFound='data not found';
    private $found='data found';
    private $detailSaved='detials Saved ';
    private $detailNotSaved='detials Not Saved';


    private $update='data updated';
    private $notUpdate='data not updated';

    const PROCCESS ='1'; 

    const TABLENAME='tbl_user_matrimonial';

    




    public function __construct(CommonServiceInterface $commonService, 
            UserServiceInterface $userService, 
            UserRestfulserviceInterface $userRestfulService) {
    
       
        $this->userService = $userService;
        $this->commonService = $commonService;
        $this->userRestfulService= $userRestfulService;
       
    }
    

    public function indexAction()
    { 
        
    if ($this->getRequest()->isPost()) { 
        $request = $this->getRequest();
        
        $request->getHeaders()->addHeaderLine( 'Content-Type', 'application/json; charset=utf-8' );
        $view= new JsonModel();
        
        $view->setVariables($request->getPost()->toArray());
        $view->setTerminal(true);
        return $view;

        
    }
    }
    
    /**
     * Checking User Exiting 
     *
     * @param  String| $loginEmail, $loginPassword
     * @return User Status
     * @return id
     * @throws Exception\DomainException if param is missing or invalid
     * 
     */
    
    public function loginAction(){ 
        $msg=[];        
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $loginEmail= $request->getPost('loginEmail');          
           $loginPassword= md5($request->getPost('loginPassword'));
           $loginType = $request->getPost('loginType');           //var_dump($loginType); exit;
           if((isset($loginEmail) && !empty($loginEmail)) && (isset($loginPassword) && !empty($loginPassword)))
           { 
            if((isset($loginType) && !empty($loginType) )) {
                $userTypeDetails = $this->userRestfulService->getTypeUserByLogin($loginEmail,$loginPassword, $loginType);   
                }else{
                $userTypeDetails = $this->userRestfulService->getTypeUser($loginEmail,$loginPassword);   
                }
          
               if($userTypeDetails){
                    if($userTypeDetails['loginType']== WebServiceConstant::USEREXITINBOTH){
                    $msg=['resp'=>4,'status'=>$this->userExitInBoth,'id'=>null,'loginType'=>$userTypeDetails['loginType']];
                    }else{ 
                     $isUserActive = $this->userRestfulService->isUserActive($userTypeDetails['is_active']);
                        if(!$isUserActive){   //var_dump($userTypeDetails); exit;                 
                        $resendMessages= $this->userRestfulService->resendOtp($userTypeDetails);
                        $resendMessages['status']= $this->userInActive; 
                        $resendMessages['id']= null; 
                        $resendMessages['loginType']= $userTypeDetails['loginType'];    
                        $msg= $resendMessages; 
                        }else{
                            $msg=['resp'=>1,'status'=>$this->userExit,'id'=>$userTypeDetails['id'],'loginType'=>$userTypeDetails['loginType']];  
                        }
                    } 
               
                }else{
                    $msg=['resp'=>0,'status'=>$this->userNotExit,'id'=>null,'loginType'=>null];  
            }   
             
           }else{   
                $msg=['resp'=>3,'status'=>$this->inVaildArrugment,'id'=>null,'loginType'=>null];    
           }
           
           }
           
           return $this->userRestfulService->sendResponse($msg);
                     
        }
    /**
     * checking the UserName
     *
     * @param  String| $userName, int| $loginType
     * @return boolan| status(true=>found, false=>not found)
     * @return int|resp(1=>found, 0=>not found)
     * @author vishal  
     * 
     */  
        
        public function checkUserNameAction()
        {
           $msg=[];
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $allParam=['userName','loginType'];
           $data=$this->userRestfulService->getArrayDataFromObject($request->getPost());
           if($this->userRestfulService->isAllVaildParam($allParam,$data)){ 
               $status =$this->userRestfulService->isUserNameExit($data['userName'], $data['loginType']);
               $resp=0;
               if($status){
                  $resp=1; 
               }
               $msg=['resp'=>$resp,'status'=>$status]; 
               
           }else{
              $msg=['resp'=>3,'status'=>$this->inVaildArrugment]; 
           }
          return $this->userRestfulService->sendResponse($msg);
          
            
        }
            
        }
        
    /**
     * checking the email
     *
     * @param  String| $email, int| $loginType
     * @return boolan| status(true=>found, false=>not found)
     * @return int|resp(1=>found, 0=>not found)
     * @author vishal  
     * 
     */  
        
        public function checkEmailAction()
        {
           $msg=[];
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $allParam=['email','loginType'];
           $data=$this->userRestfulService->getArrayDataFromObject($request->getPost());
           if($this->userRestfulService->isAllVaildParam($allParam,$data)){ 
               $status =$this->userRestfulService->isUserEmailExit($data['email'], $data['loginType']); // ($data['userName'], $data['loginType']);
               $resp=0;
               if($status){
                  $resp=1; 
               }
               $msg=['resp'=>$resp,'status'=>$status]; 
               
           }else{
              $msg=['resp'=>3,'status'=>$this->inVaildArrugment]; 
           }
          return $this->userRestfulService->sendResponse($msg);
          
            
        }
            
        }

    /**
     * checking the Mobile
     *
     * @param  String| $email, int| $loginType
     * @return boolan| status(true=>found, false=>not found)
     * @return int|resp(1=>found, 0=>not found)
     * @author vishal  
     * 
     */  
        
        public function checkMobileAction()
        {
           $msg=[];
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $allParam=['mobile','loginType'];
           $data=$this->userRestfulService->getArrayDataFromObject($request->getPost());
           if($this->userRestfulService->isAllVaildParam($allParam,$data)){ 
               $status =$this->userRestfulService->isUserMobileExit($data['mobile'], $data['loginType']); // ($data['userName'], $data['loginType']);
               $resp=0;
               if($status){
                  $resp=1; 
               }
               $msg=['resp'=>$resp,'status'=>$status]; 
               
           }else{
              $msg=['resp'=>3,'status'=>$this->inVaildArrugment]; 
           }
          return $this->userRestfulService->sendResponse($msg);
          
            
        }
            
        }

    /**
     * Received from user details for signUp
     *
     * @param  String| $userName, String| $password, String|email, int|$loginType, int|$mobile
     * @return String| status
     * @return boolan|flag
     * @return int|UserId. array|$data (if user create and data Exit)
     * @author vishal  
     * 
     */  

  public function signUpAction(){ 
      
        $msg=[];
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $userName= $request->getPost('userName'); 
           $password= $request->getPost('password');
           $email= $request->getPost('email'); 
           $mobile= $request->getPost('mobile');
           $loginType= $request->getPost('loginType');
           $receviedParam=[$userName,$password,$email,$mobile,$loginType];
           if($this->userRestfulService->isVaildParamerter($receviedParam, $loginType)){ 
                $data =['userName'=>$userName, 'password'=> md5($password), 'email'=>$email, 'mobile'=>$mobile]; 
                switch (true){
                    case $this->userRestfulService->isUserNameExit($userName,$loginType):
                        $msg=['resp'=>0,'error'=>$this->userNameExit, 'status'=>'failure',$id=>null];
                        break;
                    case $this->userRestfulService->isUserEmailExit($email,$loginType):
                        $msg=['resp'=>0,'error'=>$this->emailNameExit, 'status'=>'failure', $id=>null];
                        break;
                    case $this->userRestfulService->isUserMobileExit($mobile,$loginType):
                        $msg=['resp'=>0,'error'=>$this->mobileNumberExit, 'status'=>'failure', $id=>null];
                        break;
                    default:
                       $id= $this->userRestfulService->saveUser($data,$loginType); //var_dump($userId); exit;
                        if($id){
                           $cast= $this->userRestfulService->getCast();                           //var_dump($cast); exit;
                           $country= $this->userRestfulService->getCountry();
                           $profession= $this->userRestfulService->getProfession(); 
                        }
                        $msg=['resp'=>1,'error'=>null, 'status'=>'success','id'=>$id,'loginType'=>$loginType, 'cast'=>$cast,'country'=>$country,'profession'=>$profession];
                         break;
                }
           
           }else{
              $msg=['resp'=>3,'error'=>$this->inVaildArrugment, 'status'=>'failure','id'=>null]; 
           }
          return $this->userRestfulService->sendResponse($msg);
          
            
        }
        
    }
    
    /**
     * save user details
     *
     * @param  Array| $data['cast','userSalutation', 'name','dob','fatherSalutation',
               'fname','address','gender','country','state','city','profession',
               'nativePlace','id','cc','loginType'], 
     * @return loginType
     * @return id (if user save details)
     * @author vishal 
     * 
     */
    
    public function signUpDetailsAction(){ 
        $msg=[];
        
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();   
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->userRestfulService->getArrayDataFromObject($request->getPost());          
           $allParam=['cast','userSalutation', 'name','dob','fatherSalutation',
               'fname','address','gender','country','state','city','profession',
               'nativePlace','id','cc','loginType'];
           $notMandParam=['fatherSalutation','fname','address','nativePlace'];
           if($this->userRestfulService->isAllVaildParam($allParam,$data, $notMandParam) ){ 
              if($this->userRestfulService->saveUserInfo($data, $data['loginType'])){
                $msg=['resp'=>1,'error'=>'null', 'status'=>$this->detailSaved,'id'=>$data['id'],'loginType'=>$data['loginType']];
              }else{
                $msg=['resp'=>0,'error'=>'null', 'status'=>$this->detailNotSaved];   
              }
           }else{
                $msg=['resp'=>3,'error'=>$this->inVaildArrugment, 'status'=>'failure','id'=>null]; 
           }
        }
          return $this->userRestfulService->sendResponse($msg);
    
    
    }
    
    /**
     * send otp to User
     *
     * @param  String| $mobile, Int| $loginType
     * @return otp
     * @return id (if user Exit)
     * @author vishal 
     * 
     */
    public function sendOtpForgetPasswordAction() {
    $msg=[];
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $mobile= $request->getPost('mobile'); 
           $loginType= $request->getPost('loginType');
           if(isset($loginType) && !empty($loginType)){
             $userTypeDetails= $this->userRestfulService->getUserDetailsByMobile($mobile,$loginType);  
           }else{
             $userTypeDetails= $this->userRestfulService->getUserDetailsByMobile($mobile);    
           }
           if($userTypeDetails){
                if($userTypeDetails['loginType']== WebServiceConstant::USEREXITINBOTH){ 
                     $msg=['resp'=>4,'status'=>$this->userExitInBoth,'id'=>null,'loginType'=>$userTypeDetails['loginType']];
                }else{                   
                     $resendMessages= $this->userRestfulService->resendOtp($userTypeDetails);   
                     $resendMessages['status']=$this->userExit;
                     $resendMessages['id']= $userTypeDetails['id'];                   
                     $msg= $resendMessages; 
                     }
           }else{
                $msg=['resp'=>3,'status'=>$this->userNotExit,'loginType'=>null, 'id'=>null];
            }
           }
           return $this->userRestfulService->sendResponse($msg);

        }  
    
     /**
     * Confirm otp received from user 
     *
     * @param  String| $code, int|$id, int|$loginType, int|$mobile
     * @return otp
     * @return boolan|flag
     * @return int|UserId (if user Exit)
     * @author vishal  
     * 
     */
        public function confirmOtpAction() {
            
            
        $msg=[];
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $code= $request->getPost('code'); 
           $loginType= $request->getPost('loginType');
           $id=$request->getPost('id');
           $mobile=$request->getPost('mobile');           
           $receivedParam=[$code,$loginType,$id,$mobile];
           if($this->userRestfulService->isVaildParamerter($receivedParam)){ 
               $msg=['resp'=>0,'status'=>$this->notFound, 'flag'=>'false','userId'=>null];
               if($this->userRestfulService->isSameOtp($code,$loginType,$mobile))
                {                  
                   $msg=['resp'=>1,'status'=>$this->found, 'flag'=>'true','userId'=>$id];
                }
              
           }else{
               $msg=['resp'=>3,'status'=>$this->inVaildArrugment, 'flag'=>'false','userId'=>null];   
           }
                
           return $this->userRestfulService->sendResponse($msg);
        }
        
        }
        
        
     /**
     * Update the password
     *
     * @param  String| $password, int|$id, int|$loginType, int|$mobile
     * @return status
     * @return boolan|flag
     * @return resp (0: failure, 1: success)
     * @author vishal 
     * 
     */
      
        public function updatePasswordAction() {
       
        $msg=[];
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $loginType= $request->getPost('loginType');
           $id=$request->getPost('id');
           $mobile=$request->getPost('mobile');           //var_dump($request->getPost('password')); //exit;  
           $password =  $request->getPost('password');           //var_dump($password); exit;
           $receivedParam=[$id,$mobile,$password,$loginType];           
           if($this->userRestfulService->isVaildParamerter($receivedParam)){ 
               $msg=['resp'=>0,'status'=>$this->notUpdate, 'flag'=>'false'];
               if($this->userRestfulService->updatePassword($id,$mobile,$loginType,  md5($password)))
                {                  
                   $msg=['resp'=>1,'status'=>$this->update, 'flag'=>'true'];
                }
              
           }else{
               $msg=['resp'=>3,'status'=>$this->inVaildArrugment, 'flag'=>'false'];   
           }
                
           return $this->userRestfulService->sendResponse($msg);
        }
        
        
        
    }
    
    /**
     * Getting All Country 
     *
     *  
     * @return status
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| country
     * @author vishal 
     * 
     */
    
    public function getAllCountryAction()
    {
        $msg=[];        
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
                             
          
               $msg=['resp'=>0,'status'=>$this->notFound, 'flag'=>'false', 'country'=>null];
               $country = $this->userRestfulService->getCountry();
               if($country)
                {                  
                   $msg=['resp'=>1,'status'=>$this->found, 'flag'=>'true', 'country'=>$country];
                }
             return $this->userRestfulService->sendResponse($msg); 
           }
                
           
        
    }
    
    
    /**
     * Getting All State crossponding country Id
     *
     * @param  String| $cid, 
     * @return status
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| states
     * @author vishal 
     * 
     */
    
    public function getStateByCountryIdAction()
    {
        $msg=[];        
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
            $id=$request->getPost('cid');                     
           if($id){ 
               $msg=['resp'=>0,'status'=>$this->notFound, 'flag'=>'false'];
               $states=$this->userRestfulService->getStateByCountryId($id);
               if($states)
                {                  
                   $msg=['resp'=>1,'status'=>$this->found, 'flag'=>'true', 'states'=>$states];
                }
              
           }else{
               $msg=['resp'=>3,'status'=>$this->inVaildArrugment, 'flag'=>'false'];   
           }
                
           return $this->userRestfulService->sendResponse($msg);
        }
    }
    
     /**
     * Getting All City crossponding State Id
     *
     * @param  String| $sid, 
     * @return status
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| cities
     * @author vishal 
     * 
     */   
    public function getCityByStateIdAction()
    {
     $msg=[];        
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
            $id=$request->getPost('sid');                     
           if($id){ 
               $msg=['resp'=>0,'status'=>$this->notFound, 'flag'=>'false'];
               $cities=$this->userRestfulService->getCityByStateId($id);
               if($cities)
                {                  
                   $msg=['resp'=>1,'status'=>$this->found, 'flag'=>'true', 'cities'=>$cities];
                }
              
           }else{
               $msg=['resp'=>3,'status'=>$this->inVaildArrugment, 'flag'=>'false'];   
           }
                
           return $this->userRestfulService->sendResponse($msg);
        }   
    }
    
    /**
     * Getting All Cast 
     *
     *  
     * @return status
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| allCast
     * @author vishal 
     * 
     */ 
    public function  getAllCastAction(){
      $msg=[];        
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->userRestfulService->getCast();
            $msg=['resp'=>0,'status'=>$this->notFound, 'flag'=>'false', 'allCast'=>null];
           if($data){                  
            $msg=['resp'=>1,'status'=>$this->found, 'flag'=>'true', 'allCast'=>$data];
            }
           return $this->userRestfulService->sendResponse($msg);
        }     
    }
    
    /**
     * Getting All Profession 
     *
     *  
     * @return status
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| allProfession
     * @author vishal 
     * 
     */ 
    public function  getAllProfessionAction(){
      $msg=[];        
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->userRestfulService->getProfession();
            $msg=['resp'=>0,'status'=>$this->notFound, 'flag'=>'false', 'allCast'=>null];
           if($data){                  
            $msg=['resp'=>1,'status'=>$this->found, 'flag'=>'true', 'allCast'=>$data];
            }
           return $this->userRestfulService->sendResponse($msg);
        }     
    }
    
    /**
     * Getting Customer Details  
     *
     *  
     * @return status
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| detials
     * @author vishal 
     * 
     */ 
    
    public function getCustomerDetailsByIdAction(){
      $msg=[];      //var_dump('ddd'); exit;
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data=$this->userRestfulService->getArrayDataFromObject($request->getPost());           //var_dump($data); exit;
           $allParam=['loginId','loginType'];
           if($this->userRestfulService->isAllVaildParam($allParam,$data)){ 
               $msg=['resp'=>0,'status'=>$this->notFound, 'flag'=>'false', 'detials'=>null];
               $data= $this->userRestfulService->getCustomerDetailsById($data['loginId'], $data['loginType']);
               if($data){
                $msg=['resp'=>1,'status'=>$this->found, 'flag'=>'true', 'detials'=>$data];
               }
            }else{
                $msg=['resp'=>3,'status'=>$this->inVaildArrugment, 'flag'=>'false', 'detials'=>null]; 
            }
           return $this->userRestfulService->sendResponse($msg);
        }  
    }
    /**
     * Getting All PostCategories 
     *
     * @method Post 
     * @return status
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| allPostCategories
     * @author vishal 
     * 
     */ 
    public function getPostCategoriesAction(){
         $msg=[];     
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->userRestfulService->getPostCategories();
            $msg=['resp'=>0,'status'=>$this->notFound, 'flag'=>'false', 'allPostCategories'=>null];
           if($data){                  
            $msg=['resp'=>1,'status'=>$this->found, 'flag'=>'true', 'allPostCategories'=>$data];
            }
           return $this->userRestfulService->sendResponse($msg);
        }     
    }
}