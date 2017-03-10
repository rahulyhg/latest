<?php
namespace WebServices\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use WebServices\Service\CommonServicesInterface;
use WebServices\Service\LoginServicesInterface;
use WebServices\WebServiceConstant;
class LoginServicesController extends AbstractRestfulController{

    protected $loginServices;
    protected $commonServices;
    public function __construct(CommonServicesInterface $commonService, LoginServicesInterface $loginService) {
        $this->commonServices=$commonService;
        $this->loginServices=$loginService;
    }
    
    
    public function indexAction() {
        die('login');
        
    }
    
    /**
     * Checking User Exiting 
     * @method Only Post data accepted
     * @param  String| $loginEmail, $loginPassword,($loginType is optional)
     * @return Status(USERMEMBER:1, USERMATRIMONIAL:2, USEREXITINGINBOTH:4)
     * @return resp(USERNOTEXIT: 0, USEREXIT:1, USERINACTIVE: 2 , USERINVAILDPARAMETER:3, USEREXITINGINBOTH:4, USERAUTHORIZE:5)
     * @return id
     * @return loginType (USERMEMBER:1, USERMATRIMONIAL:2)
     * @return token  for securtiy token
     * @throws Exception\DomainException if param is missing or invalid
     * 
     */
    
    public function loginAction(){ 
        $msg=[];         
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data=$this->commonServices->getArrayDataFromObject($request->getPost()); 
           $allParam=['loginEmail','loginPassword','loginType'];
           $notMandParam=['loginType'];         
           if($this->commonServices->isAllVaildParam($allParam, $data, $notMandParam))
           {             
               $userTypeDetails = $this->loginServices->getTypeUserByLogin($data['loginEmail'],md5($data['loginPassword']), $data['loginType']); 
              if($userTypeDetails){                 // var_dump($userTypeDetails); exit;
                    if($userTypeDetails['loginType']== WebServiceConstant::USEREXITINBOTH){                                         
                    $msg=['resp'=>4,'status'=>  WebServiceConstant::USEREXITINBOTHMSG,'id'=>null,'loginType'=>$userTypeDetails['loginType'],'token'=>null];
                    }else{ 
                     $isUserActive = $this->loginServices->isUserActive($userTypeDetails['is_active']);
                        if(!$isUserActive){   //var_dump($userTypeDetails); exit;                 
                        $resendMessages= $this->commonServices->resendOtp($userTypeDetails);
                        $resendMessages['status']= WebServiceConstant::USERINACTIVEMSG; 
                        $resendMessages['id']= null; 
                        $resendMessages['loginType']= $userTypeDetails['loginType']; 
                        $resendMessages['token']=$userTypeDetails['token'];
                        $msg= $resendMessages; 
                        }else{
                            $msg=['resp'=>1,'status'=>  WebServiceConstant::USEREXITMSG,'id'=>$userTypeDetails['id'],'loginType'=>$userTypeDetails['loginType'],'token'=>$userTypeDetails['token']];  
                        }
                    } 
               
                }else{
                    $msg=['resp'=>0,'status'=>  WebServiceConstant::USERNOTEXITMSG,'id'=>null,'loginType'=>null,'token'=>null];  
            }   
             
           }else{               
                $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG,'id'=>null,'loginType'=>null,'token'=>null];    
           }
           
           }
           
           return $this->commonServices->sendResponse($msg);
                     
        }
        
        
    /**
     * Received from user details for signUp
     *
     * @param  String| $userName, String| $password, String|email, int|$loginType, int|$mobile,  int|id(optional)
     * @return String| status(FAILURE, SUCEESS)
     * @return String| error
     * @return int|id array|$data (if user create and data Exit)
     * @return token  for securtiy token
     * @author vishal  
     * 
     */  

  public function signUpAction(){   
        $msg=[];
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data=$this->commonServices->getArrayDataFromObject($request->getPost());           
           $allParam=['userName','password','email','mobile','loginType'];
           $notMandatory=['id'];
           if($data['loginType']===WebServiceConstant::USERMEMBER){
            $notMandatory=['profileCreatedFor'];   
           }
           if($this->commonServices->isAllVaildParam($allParam, $data,$notMandatory)){ 
                switch (true){
                    case $this->commonServices->isUserNameExit($data['userName'],$data['loginType'],$data['id']):
                        $msg=['resp'=>0,'error'=> WebServiceConstant::USERNAMENOTAVILMSG, 'status'=>'failure',$id=>null, 'token'=>null];
                        break;
                    case $this->commonServices->isUserEmailExit($data['email'],$data['loginType'],$data['id']):
                        $msg=['resp'=>0,'error'=> WebServiceConstant::EMAILNAMENOTAVILMSG, 'status'=>'failure', $id=>null, 'token'=>null];
                       // var_dump('ddfg',$msg); exit;
                        break;
                    case $this->commonServices->isUserMobileExit($data['mobile'],$data['loginType'],$data['id']):
                        $msg=['resp'=>0,'error'=> WebServiceConstant::MOBILENUMBEREXITMSG, 'status'=>'failure', $id=>null, 'token'=>null];
                        break;
                    default: 
                       $id= $this->loginServices->saveUser($data,$data['loginType']); //var_dump($id); exit;
                        if($id){
                           $caste= $this->commonServices->getCaste();                           //var_dump($cast); exit;
                           $country= $this->commonServices->getCountry();
                           $profession= $this->commonServices->getProfession(); 
                           $nationality=$this->commonServices->getNationality();
                           $gothraGothram=$this->commonServices->getGothraGothram();
                           $token=$this->commonServices->getTokenByLoginId($id,$data['loginType']);
                        }
                        $msg=['resp'=>1,'error'=>null, 'status'=>'success','id'=>$id,'loginType'=>$data['loginType'], 'token'=>$token,'caste'=>$caste,'country'=>$country,
                            'profession'=>$profession,'gothraGothram'=>$gothraGothram,'nationality'=>$nationality];
                         break;
                } 
    
           }else{
              $msg=['resp'=>3,'error'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'status'=>'failure','id'=>null,'token'=>null]; 
           }
          return $this->commonServices->sendResponse($msg);
          
            
        }
        
    }
    
    /**
     * save user details
     *
     * @param  Array| $data['userSalutation', 'name', lname'dob','fatherSalutation',
               'fname','flname','nationality','address','country','state','city','profession','religion','community',subCommunity,gotra
               'nativePlace','id','cc','loginType', refferalKey, 'religionOther','communityOther','subCommunityOther','gotraOther', gender, profileCreatedFor,professionOther,branchOther], 
     * @return loginType
     * @return id (if user save details)
     * @return code (sent Otp code to user)
     * @return  token  for securtiy token
     * @author vishal 
     * 
     */
    
    public function signUpDetailsAction(){ 
        //$msg=[];        var_dump('dfsf'); exit;
       
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();   
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getArrayDataFromObject($request->getPost());          
           $allParam=['userSalutation', 'name','lname','dob','fatherSalutation','refferalKey',
               'fname','flname','nationality','address','country','state','city','profession','religion','community','subCommunity','gotra',
               'nativePlace','id','loginType','branch','gender', 'profileCreatedFor','professionOther','religionOther','communityOther',
               'subCommunityOther','gotraOther','branchOther'];           //var_dump($allParam,$data); exit;
           $notMandParam=['nativePlace','branch','refferalKey','professionOther','religionOther','communityOther','subCommunityOther','gotraOther','branchOther'];
           if($data['loginType']==WebServiceConstant::USERMEMBER){              // var_dump('fgeg'); exit;
             $notMandParam[]='profileCreatedFor';  
           }
           $refferalkey='testkey';
           if(isset($data['refferalKey'])&& !empty($data['refferalKey']))
           {               
             $refferalkey=$this->commonServices->getRefferalKeyByRefferal($data['refferalKey'], $data['loginType']);  
           } //var_dump(!empty($refferalkey)); exit;
           if(($this->commonServices->isAllVaildParam($allParam,$data, $notMandParam)) && !empty($refferalkey) ){ //die('ff'); exit;
              if($this->loginServices->saveUserInfo($data, $data['loginType'])){
                $token=$this->commonServices->getTokenByLoginId($data['id'],$data['loginType']);                //var_dump($token); exit;
                $mobile=$this->commonServices->getMobileNumberById($data['id'],$data['loginType']);
                $code="";
                if($mobile){
                   $code=$this->commonServices->sendOtp($mobile, $data['loginType']); 
                }
                
                $msg=['resp'=>1,'error'=>'null', 'status'=>  WebServiceConstant::DETAILEDSAVEDMSG,'id'=>$data['id'],'loginType'=>$data['loginType'],'token'=>$token,'code'=>$code];
              }else{
                $msg=['resp'=>0,'error'=>'null', 'status'=>  WebServiceConstant::DETAILEDNOTSAVEDMSG];   
              }
           }else{
                $msg=['resp'=>3,'error'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'status'=>'failure','id'=>null]; 
           }
        }
          return $this->commonServices->sendResponse($msg);
    
    
    }
    
    /**
     * Checking user exiting and send otp 
     
     * @param  String| $mobile, ($loginType is optional)
     * @return Status(USERMEMBER:1, USERMATRIMONIAL:2, USEREXITINGINBOTH:4)
     * @return resp(DATANOTFOUND: 0, DATAFOUND:1, USERINVAILDPARAMETER:3 )
     * @return id
     * @return loginType (USERMEMBER:1, USERMATRIMONIAL:2)
     * @return token  for securtiy token
     * @throws Exception\DomainException if param is missing or invalid
     * 
     */
    public function sendOtpForgetPasswordAction() {
    $msg=[];    
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
            $data = $this->commonServices->getArrayDataFromObject($request->getPost());          
           $allParam=['mobile','loginType'];           
           $notMandParam=['loginType'];           //var_dump($notMandParam); exit;
           if($this->commonServices->isAllVaildParam($allParam, $data, $notMandParam)){//var_dump($data); exit;
             $userTypeDetails= $this->loginServices->getUserDetailsByMobile($data['mobile'],$data['loginType']);
       
           if($userTypeDetails){
                if($userTypeDetails['loginType']== WebServiceConstant::USEREXITINBOTH){ 
                     $msg=['resp'=>4,'status'=>  WebServiceConstant::USEREXITINBOTHMSG,'id'=>null,'loginType'=>$userTypeDetails['loginType'],'token'=>null];
                }else{                   
                     $resendMessages= $this->commonServices->resendOtp($userTypeDetails);  
                     $resendMessages['resp']='1';
                     $resendMessages['status']=  WebServiceConstant::USEREXITMSG;
                     $resendMessages['id']= $userTypeDetails['id'];   
                     $resendMessages['token']=$userTypeDetails['token'];
                     $msg= $resendMessages; 
                     }
           }else{
                $msg=['resp'=>0,'status'=>  WebServiceConstant::USERNOTEXITMSG,'loginType'=>null, 'id'=>null,'token'=>null];
            }
           }else{
                $msg=['resp'=>3,'error'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'status'=>'failure','id'=>null,'token'=>null]; 
           }
           
           return $this->commonServices->sendResponse($msg);

        } 
    }   
    
    /**
     * resend otp to  user 
     *
     * @param  int|$id, int|$loginType, int|$mobile String| token 
     * @return otp
     * @return int|id (if user Exit)
     * @return loginType (USERMEMBER:1, USERMATRIMONIAL:2)
     * @return resp(DATANOTFOUND: 0, DATAFOUND:1, USERINVAILDPARAMETER:3 )
     * @return token  for securtiy token
     * @author vishal  
     * 
     */
        public function resendOtpAction() {
        $msg=[];
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getArrayDataFromObject($request->getPost());          
            $allParam=['mobile','loginType','id','token'];           
           if($this->commonServices->isAllVaildParam($allParam, $data)){
               $userTypeDetails= $this->loginServices->getUserDetailsByMobile($data['mobile'],$data['loginType']);
              $msg=['resp'=>0,'status'=>  WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false','id'=>null,'token'=>$data['token'],'loginType'=>$data['loginType']];
               if($userTypeDetails){
                    $resendMessages= $this->commonServices->resendOtp($userTypeDetails);
                     $resendMessages['resp']='1';
                     $resendMessages['status']=  WebServiceConstant::FOUNDMSG;
                     $resendMessages['id']= $data['id'];   
                     $resendMessages['token']=$data['token'];
                     $msg= $resendMessages;
                }
                
           }else{
               $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false','id'=>null,'token'=>$data['token'],'loginType'=>$data['loginType']];   
           }
                
           return $this->commonServices->sendResponse($msg);
        }
        
        }
        
    /**
     * Confirm otp received from user 
     *
     * @param  String| $code, int|$id, int|$loginType, int|$mobile String| token int|actionType(signUp:1, forgetPassword:2)  
     * @return otp
     * @return int|id (if user Exit)
     * @return loginType (USERMEMBER:1, USERMATRIMONIAL:2)
     * @return resp(DATANOTFOUND: 0, DATAFOUND:1, USERINVAILDPARAMETER:3 )
     * @return token  for securtiy token
     * @author vishal  
     * 
     */
        public function confirmOtpAction() {
            
            
        $msg=[];
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getArrayDataFromObject($request->getPost());          
           $allParam=['code','mobile','loginType','id','token','actionType'];           
           if($this->commonServices->isAllVaildParam($allParam, $data)){ //var_dump($data); exit;
               $msg=['resp'=>0,'status'=>  WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false','id'=>null,'token'=>$data['token'],'loginType'=>$data['loginType']];
               if($this->commonServices->isSameOtp($data['code'],$data['loginType'],$data['mobile'],$data['actionType']))
                {                  
                   $msg=['resp'=>1,'status'=>  WebServiceConstant::FOUNDMSG, 'flag'=>'true','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
                }
              
           }else{
               $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false','id'=>null,'token'=>$data['token'],'loginType'=>$data['loginType']];   
           }
                
           return $this->commonServices->sendResponse($msg);
        }
        
        }
        
        
     /**
     * Update the password
     *
     * @param  String| $password, int|$id, int|$loginType, int|$mobile, String|token
     * @return status(NOTUPDATE, UPDATE, USERINVAILDPARAMETER )
     * @return resp(NOTUPDATE: 0, UPDATE:1, USERINVAILDPARAMETER:3 )
     * @return Boolean|flag(True|false)
     * @author vishal 
     * 
     */
      
        public function updatePasswordAction() {
       
        $msg=[];
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getArrayDataFromObject($request->getPost());          
           $allParam=['password','mobile','loginType','id','token'];
              if($this->commonServices->isAllVaildParam($allParam, $data)){              
               $msg=['resp'=>0,'status'=>  WebServiceConstant::NOTUPDATEMSG, 'flag'=>'false','token'=>$data['token']];
               if($this->loginServices->updatePassword($data['id'],$data['mobile'],$data['loginType'],  md5($data['password'])))
                {                  
                   $msg=['resp'=>1,'status'=>  WebServiceConstant::UPDATEMSG, 'flag'=>'true','token'=>$data['token']];
                }
              
           }else{
               $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false', 'token'=>$data['token']];   
           }
                
           return $this->commonServices->sendResponse($msg);
        }
    }
}
