<?php

namespace WebServices\Controller;
use Zend\Mvc\Controller\AbstractRestfulController;
use WebServices\Service\LoginServicesInterface;
use WebServices\Service\CommonServicesInterface;
use WebServices\Service\UserServicesInterface;
use WebServices\TableName;
use WebServices\WebServiceConstant;

class UserServicesController extends AbstractRestfulController{
    
    protected $loginService;
    protected $commonService;
    protected $userService;
    public function __construct(CommonServicesInterface $commonService,
                                LoginServicesInterface $loginService,
                                UserServicesInterface $userService) {
        
        $this->loginService= $loginService;
        $this->commonService=$commonService;
        $this->userService=$userService;
    }
    
    public function indexAction(){
        die('heelo');
    }
    
    /**
     * Getting Customer Details  
     * @param Int $id, $loginType  
     * @param String  $token Authtoken
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER)
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
           $data=$this->commonService->getArrayDataFromObject($request->getPost());           //var_dump($data); exit;
           $allParam=['id','loginType','token'];
           if($this->commonService->isAllVaildParam($allParam,$data)){ 
               $msg=['resp'=>0,'status'=>  WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'detials'=>null];
               $data= $this->userService->getCustomerDetailsById($data['id'], $data['loginType']);
               if($data){
                $msg=['resp'=>1,'status'=>  WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'detials'=>$data];
               }
            }else{
                $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false', 'detials'=>null]; 
            }
           return $this->commonService->sendResponse($msg);
        }  
    }
    
     /**
     * Getting Customer Details  
     * @param Int $id, $loginType  
     * @param String  $token Authtoken
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| detials
     * @author vishal 
     * 
     */ 
    
    public function getAboutUsDetailsAction(){
      $msg=[];      //var_dump('ddd'); exit;
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data=$this->commonService->getArrayDataFromObject($request->getPost());           //var_dump($data); exit;
           $allParam=['id','loginType','token'];
           if($this->commonService->isAllVaildParam($allParam,$data)){ 
               $msg=['resp'=>0,'status'=>  WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'detials'=>null];
               $data= $this->userService->getCustomerDetailsById($data['id'], $data['loginType']);
               if($data){
                $msg=['resp'=>1,'status'=>  WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'detials'=>$data];
               }
            }else{
                $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false', 'detials'=>null]; 
            }
           return $this->commonService->sendResponse($msg);
        }    
    
        
    }
    
    /**
     * Set About Your Self 
     * @param Int $id, $loginType String|aboutYourSelf
     * @param String  $token Authtoken
     * @return status(NOTUPDATE, UPDATE, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return int|id,int|loginType, String|Token
     * @author vishal 
     * 
     */ 
    
    public function setAboutYourSelfAction(){
      $msg=[];      //var_dump('ddd'); exit;
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data=$this->commonService->getArrayDataFromObject($request->getPost());           //var_dump($data); exit;
           $allParam=['id','loginType','token','aboutYourSelf'];
           if($this->commonService->isAllVaildParam($allParam,$data)){ 
               $msg=['resp'=>0,'status'=>  WebServiceConstant::NOTUPDATEMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType'] ];
                if($this->userService->setAboutYourSelf($data['id'], $data['loginType'],$data['aboutYourSelf'])){
                $msg=['resp'=>1,'status'=>  WebServiceConstant::UPDATEMSG, 'flag'=>'true','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               }
            }else{
                $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']]; 
            }
           return $this->commonService->sendResponse($msg);
        }    
    
        
    }
    
     /**
     * Getting Customer Profile Percentage 
     * @param Int $id, $loginType
     * @param String  $token Authtoken
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| percentage
     * @author vishal 
     * 
     */ 
    
    public function getProfilePercentageAction(){
      $msg=[];      //var_dump('ddd'); exit;
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data=$this->commonService->getArrayDataFromObject($request->getPost());           //var_dump($data); exit;
           $allParam=['id','loginType','token'];
           if($this->commonService->isAllVaildParam($allParam,$data)){ 
               $msg=['resp'=>0,'status'=>  WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'percentage'=>null, 'id'=>$data['id'], 'loginType'=>$data['loginType'], 'token'=>$data['token']];
               $percentage= $this->userService->getProfilePercentage($data['id'], $data['loginType']);
               if($percentage){
                $msg=['resp'=>1,'status'=>  WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'percentage'=>$percentage, 'id'=>$data['id'], 'loginType'=>$data['loginType'], 'token'=>$data['token']];
               }
            }else{
                $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false', 'percentage'=>null, 'id'=>$data['id'], 'loginType'=>$data['loginType'], 'token'=>$data['token']]; 
            }
           return $this->commonService->sendResponse($msg);
        }    
    
        
    }
    
    /**
     * Set Physical Details
     * @param Int $id, $loginType int|$height, String|$bodyType, String|$skinTone, String|$disability, String|$bloodGroup, String|$bodyWeight
     * @param String  $token Authtoken
     * @return status(NOTUPDATE, UPDATE, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return int|id,int|loginType, String|Token
     * @author vishal 
     * 
     */ 
    
    public function setPhysicalDetailsAction(){
      $msg=[];      //var_dump('ddd'); exit;
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data=$this->commonService->getArrayDataFromObject($request->getPost());           //var_dump($data); exit;
           $allParam=['id','loginType','token','height','bodyType','skinTone','anyDisability','bloodGroup','bodyWeight','weightType'];
           $notMandParam=['skinTone','bloodGroup','bodyWeight','weightType']; 
           if($this->commonService->isAllVaildParam($allParam,$data,$notMandParam)){ 
               $msg=['resp'=>0,'status'=>  WebServiceConstant::NOTUPDATEMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               if($this->userService->setPhysicalDetails($data['id'], $data['loginType'],$data)){
                $msg=['resp'=>1,'status'=>  WebServiceConstant::UPDATEMSG, 'flag'=>'true','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               }
            }else{
                $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']]; 
            }
           return $this->commonService->sendResponse($msg);
        }    
    
        
    }
    
     /**
     * Set Personal Details
     * @param Int $id, $loginType String|$materialStatus, String|$alternativeMobile, String|$haveChildren, String|$numberOfChildren
     * @param String  $token Authtoken
     * @return status(NOTUPDATE, UPDATE, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return int|id,int|loginType, String|Token 
     * @author vishal 
     * 
     */ 
    
    public function setPersonalDetailsAction(){
      $msg=[];      //var_dump('ddd'); exit;
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data=$this->commonService->getArrayDataFromObject($request->getPost());           //var_dump($data); exit;
           $allParam=['id','loginType','token','maritalStatus','alternativeMobile','haveChildren','numberOfChildren'];
           $notMandParam=['alternativeMobile','haveChildren','numberOfChildren']; 
           if($this->commonService->isAllVaildParam($allParam,$data,$notMandParam)){ 
               $msg=['resp'=>0,'status'=>  WebServiceConstant::NOTUPDATEMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               if($this->userService->setPersonalDetails($data['id'], $data['loginType'],$data)){
                $msg=['resp'=>1,'status'=>  WebServiceConstant::UPDATEMSG, 'flag'=>'true','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               }
            }else{
                $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']]; 
            }
           return $this->commonService->sendResponse($msg);
        }    
    }
    
    /**
     * Set Astro Details
     * @param Int $id, $loginType Time|$birthTime, String|$birthPlace, int|$zodiacSign, String|$manglikDosham, String|$nakshatra
     * @param String  $token Authtoken
     * @return status(NOTUPDATE, UPDATE, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return int|id,int|loginType, String|Token
     * @author vishal 
     * 
     */ 
    
    public function setAstroDetailsAction(){
      $msg=[];      //var_dump('ddd'); exit;
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data=$this->commonService->getArrayDataFromObject($request->getPost());           //var_dump($data); exit;
           $allParam=['id','loginType','token','birthTime','birthPlace','zodiacSign','manglikDosham','nakshatra'];
           $notMandParam=['birthTime','manglikDosham']; 
           if($this->commonService->isAllVaildParam($allParam,$data,$notMandParam)){ 
               $msg=['resp'=>0,'status'=>  WebServiceConstant::NOTUPDATEMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               if($this->userService->setAstroDetails($data['id'], $data['loginType'],$data)){
                $msg=['resp'=>1,'status'=>  WebServiceConstant::UPDATEMSG, 'flag'=>'true','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               }
            }else{
                $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']]; 
            }
           return $this->commonService->sendResponse($msg);
        }    
    }
    
     /**
     * Set Religious Background Details
     * @param Int $id, $loginType int|$religion, String|$community, int|$subCommunity, String|$gothraGothram, String|$motherTongue, String|gothraGothramOther, String|relgionOther
     * @param String  $token Authtoken
     * @return status(NOTUPDATE, UPDATE, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return int|id,int|loginType, String|Token
     * @author vishal 
     * 
     */ 
    
    public function setReligiousBackgroundDetailsAction(){
      $msg=[];      //var_dump('ddd'); exit;
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data=$this->commonService->getArrayDataFromObject($request->getPost());           //var_dump($data); exit;
           $allParam=['id','loginType','token','religion','community','subCommunity','gothraGothram','motherTongue', 'gothraGothramOther', 'relgionOther'];
           $notMandParam=['gothraGothramOther','relgionOther','community','gothraGothram','subCommunity']; 
           if($this->commonService->isAllVaildParam($allParam,$data,$notMandParam)){ 
               $msg=['resp'=>0,'status'=>  WebServiceConstant::NOTUPDATEMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               if($this->userService->setReligiousBackgroundDetails($data['id'], $data['loginType'],$data)){
                $msg=['resp'=>1,'status'=>  WebServiceConstant::UPDATEMSG, 'flag'=>'true','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               }
            }else{
                $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']]; 
            }
           return $this->commonService->sendResponse($msg);
        }    
    }
    
    /**
     * Set life style Details
     * @param Int $id, $loginType int|$drink, String|$smoke, int|$diet
     * @param String  $token Authtoken
     * @return status(NOTUPDATE, UPDATE, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return int|id,int|loginType, String|Token
     * @author vishal 
     * 
     */ 
    
    public function setLifeStyleDetailsAction(){
      $msg=[];      
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data=$this->commonService->getArrayDataFromObject($request->getPost());           //var_dump($data); exit;
           $allParam=['id','loginType','token','drink','smoke','diet'];
           $notMandParam=['drink','smoke','diet']; 
           if($this->commonService->isAllVaildParam($allParam,$data,$notMandParam)){ 
               $msg=['resp'=>0,'status'=>  WebServiceConstant::NOTUPDATEMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               if($this->userService->setLifeStyleDetails($data['id'], $data['loginType'],$data)){
                $msg=['resp'=>1,'status'=>  WebServiceConstant::UPDATEMSG, 'flag'=>'true','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               }
            }else{
                $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']]; 
            }
           return $this->commonService->sendResponse($msg);
        }    
    }
    
    /**
     * Set Education Carrier Details
     * @param Int $id, $loginType int|$educationLevel, String|$educationLevelOther, int|$educationField, String|$educationFieldOther, String|$workingWith, String|workingWithOther, int|$designation, String|$designationOther, int|profession, String|professionOther, int|annualIncome
     * @param String  $token Authtoken
     * @return status(NOTUPDATE, UPDATE, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return int|id,int|loginType, String|Token
     * @author vishal 
     * 
     */ 
    
    public function setEducationCarrierAction(){
      $msg=[];      
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data=$this->commonService->getArrayDataFromObject($request->getPost());           //var_dump($data); exit;
           $allParam=['id','loginType','token','educationLevel','educationLevelOther','educationField', 'educationFieldOther', 'workingWith','workingWithOther','designation','designationOther','profession','professionOther', 'annualIncome','annualIncomeStatus'];
           $notMandParam=['educationLevelOther','educationFieldOther','designationOther','professionOther','workingWithOther']; 
           if($this->commonService->isAllVaildParam($allParam,$data,$notMandParam)){ 
               $msg=['resp'=>0,'status'=>  WebServiceConstant::NOTUPDATEMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               if($this->userService->setEducationCarrier($data['id'], $data['loginType'],$data)){
                $msg=['resp'=>1,'status'=>  WebServiceConstant::UPDATEMSG, 'flag'=>'true','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               }
            }else{
                $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']]; 
            }
           return $this->commonService->sendResponse($msg);
        }    
    }
    
    /**
     * Set company Details
     * @param Int $id, $loginType String|$cname, String|$cemail, int|$country, int|$state, int|$city, String|$address, String|$contactNumber, int|pincode, String|cwebsite
     * @param String  $token Authtoken
     * @return status(NOTUPDATE, UPDATE, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return int|id,int|loginType, String|Token
     * @author vishal 
     * 
     */ 
    public function setCompanyDetailsAction(){
      $msg=[];      
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data=$this->commonService->getArrayDataFromObject($request->getPost());           //var_dump($data); exit;
           $allParam=['id','loginType','token','cname','cemail','country','state', 'city', 'address','contactNumber','pincode','cwebsite'];
           $notMandParam=['cname','cemail','country','state', 'city', 'address','contactNumber','pincode','cwebsite']; 
           if($this->commonService->isAllVaildParam($allParam,$data,$notMandParam)){ 
               $msg=['resp'=>0,'status'=>  WebServiceConstant::NOTUPDATEMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               if($this->userService->setCompanyDetails($data['id'], $data['loginType'],$data)){
                $msg=['resp'=>1,'status'=>  WebServiceConstant::UPDATEMSG, 'flag'=>'true','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               }
            }else{
                $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']]; 
            }
           return $this->commonService->sendResponse($msg);
        }    
    }
    
     /**
     * Set Parents Details
     * @param Int $id, $loginType, int|motherTongue String|$fvalue, Date(Y-m-d)|$fdob, int|$fstatus, Date(Y-m-d)|$fdod, String|$fabout, String|$msalutation, String|$mname, String|mlname, Date(Y-m-d)|$mdob, int|$mstatus, Date(Y-m-d)|$mdod, String|$mabout
     * @param String  $token Authtoken
     * @return status(NOTUPDATE, UPDATE, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return int|id,int|loginType, String|Token
     * @author vishal 
     * 
     */ 
    public function setParentDetailsAction(){
      $msg=[];      
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data=$this->commonService->getArrayDataFromObject($request->getPost());           //var_dump($data); exit;
           $allParam=['id','loginType','token','fvalue','motherTongue','fdob', 'fstatus', 'fdod','fabout', 'msalutation', 'mname', 'mlname','mdob', 'mstatus', 'mdod', 'mabout'];   
           $notMandParam=['fdob','fdod','mdob','mdod']; 
           if($this->commonService->isAllVaildParam($allParam,$data,$notMandParam)){ 
               $msg=['resp'=>0,'status'=>  WebServiceConstant::NOTUPDATEMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               if($this->userService->setParentDetails($data['id'], $data['loginType'],$data)){
                $msg=['resp'=>1,'status'=>  WebServiceConstant::UPDATEMSG, 'flag'=>'true','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               }
            }else{
                $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']]; 
            }
           return $this->commonService->sendResponse($msg);
        }    
    }
    
    /**
     * Set Brother Details
     * @param Int $id, $loginType Int|$numBrother, Array|brother[String|$bsalutation, String|$bname, String|blname, Date(Y-m-d)|$bdob, int|$bstatus, Date(Y-m-d)|$bdod,String|$bmatrialStatus String|$babout] 
     * @param String  $token Authtoken
     * @return status(NOTUPDATE, UPDATE, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return int|id,int|loginType, String|Token
     * @author vishal 
     * 
     */ 
    public function setBrotherDetailsAction(){
      $msg=[];      
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data=$this->commonService->getArrayDataFromObject($request->getPost());           //var_dump($data); exit;
           $allParam=['id','loginType','token','numBrother','bsalutation', 'bname', 'blname','bdob', 'bstatus', 'bdod','bmatrialStatus','babout'];  
           $notMandParam=['bdob','bdod'];           
           foreach ($data['brother'] as $key){    
               $key['id']=$data['id'];
               $key['loginType']=$data['loginType'];
               $key['token']=$data['token'];
               $key['numBrother']=$data['numBrother'];
               $flag=$this->commonService->isAllVaildParam($allParam,$key,$notMandParam);             //  var_dump($flag); exit;
           }
          if($flag){ 
               $msg=['resp'=>0,'status'=>  WebServiceConstant::NOTUPDATEMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               if($this->userService->setBrotherDetails($data['id'], $data['loginType'],$data)){
                $msg=['resp'=>1,'status'=>  WebServiceConstant::UPDATEMSG, 'flag'=>'true','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               }
            }else{
                $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']]; 
            }
           return $this->commonService->sendResponse($msg);
        }    
    }
    
    /**
     * Set Sister Details
     * @param Int $id, $loginType Int|$numSister, Array|sister[String|$ssalutation, String|$sname, String|slname, Date(Y-m-d)|$sdob, int|$sstatus, Date(Y-m-d)|$sdod,String|$smatrialStatus String|$sabout] 
     * @param String  $token Authtoken
     * @return status(NOTUPDATE, UPDATE, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return int|id,int|loginType, String|Token
     * @author vishal 
     * 
     */ 
    public function setSisterDetailsAction(){
      $msg=[];      
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data=$this->commonService->getArrayDataFromObject($request->getPost());           //var_dump($data); exit;
           $allParam=['id','loginType','token','numSister','ssalutation', 'sname', 'slname','sdob', 'sstatus', 'sdod','smatrialStatus','sabout'];  
           $notMandParam=['sdob','sdod'];           
           foreach ($data['sister'] as $key){    
               $key['id']=$data['id'];
               $key['loginType']=$data['loginType'];
               $key['token']=$data['token'];
               $key['numSister']=$data['numSister'];
               $flag=$this->commonService->isAllVaildParam($allParam,$key,$notMandParam);             //  var_dump($flag); exit;
           } 
          if($flag){ 
               $msg=['resp'=>0,'status'=>  WebServiceConstant::NOTUPDATEMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               if($this->userService->setSisterDetails($data['id'], $data['loginType'],$data)){
                $msg=['resp'=>1,'status'=>  WebServiceConstant::UPDATEMSG, 'flag'=>'true','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']];
               }
            }else{
                $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false','id'=>$data['id'],'token'=>$data['token'],'loginType'=>$data['loginType']]; 
            }
           return $this->commonService->sendResponse($msg);
        }    
    }
}