<?php


namespace WebServices\Controller;
use Zend\Mvc\Controller\AbstractRestfulController;
use WebServices\Service\CommonServicesInterface;
use WebServices\WebServiceConstant;

class CommonServicesController extends AbstractRestfulController{
    
    private $commonServices;
    
    public function __construct(CommonServicesInterface $commonServices) { 
      $this->commonServices= $commonServices;  
    }
    
    public function indexAction(){
        var_dump('hello'); exit;
    }
    
    /**
     * checking the UserName
     *
     * @param  String| $userName, int| $loginType, int|$id(optional)
     * @return boolan| status(true=>found, false=>not found)
     * @return int|resp(Found:1,NOTFOUND:0, INVAILDPARAMETER:3)
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
               $data=$this->commonServices->getArrayDataFromObject($request->getPost());
               $notMandatory=['id'];
               if($this->commonServices->isAllVaildParam($allParam,$data,$notMandatory)){ 
                   $status =$this->commonServices->isUserNameExit($data['userName'], $data['loginType'],$data['id']);
                   $resp=0;
                   if($status){
                      $resp=1; 
                   }
                   $msg=['resp'=>$resp,'status'=>$status]; 

               }else{
                  $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG]; 
               } 
              return $this->commonServices->sendResponse($msg);

            }
            
        }
        
    /**
     * checking the email
     *
     * @param  String| $email, int| $loginType, int|$id(optional)
     * @return boolan| status(true=>found, false=>not found)
     * @return int|resp(Found:1,NOTFOUND:0, INVAILDPARAMETER:3)
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
               $notMandatory=['id'];
               $data=$this->commonServices->getArrayDataFromObject($request->getPost());
               if($this->commonServices->isAllVaildParam($allParam,$data,$notMandatory)){ 
                   $status =$this->commonServices->isUserEmailExit($data['email'], $data['loginType'],$data['id']); // ($data['userName'], $data['loginType']);
                   $resp=0;
                   if($status){
                      $resp=1; 
                   }
                   $msg=['resp'=>$resp,'status'=>$status]; 

               }else{
                  $msg=['resp'=>3,'status'=> WebServiceConstant::INVAILDARRUGMENTMSG]; 
               }
              return $this->commonServices->sendResponse($msg);


            }
            
        }

    /**
     * checking the Mobile
     *
     * @param  String| $mobile, int| $loginType
     * @return boolan| status(true=>found, false=>not found)
     * @return int|resp(Found:1,NOTFOUND:0, INVAILDPARAMETER:3)
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
               $notMandatory=['id'];
               $data=$this->commonServices->getArrayDataFromObject($request->getPost());
               if($this->commonServices->isAllVaildParam($allParam,$data,$notMandatory)){ 
                   $status =$this->commonServices->isUserMobileExit($data['mobile'], $data['loginType'],$data['id']); // ($data['userName'], $data['loginType']);
                   $resp=0;
                   if($status){
                      $resp=1; 
                   }
                   $msg=['resp'=>$resp,'status'=>$status]; 

               }else{
                  $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG]; 
               }
              return $this->commonServices->sendResponse($msg);


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
                             
          
               $msg=['resp'=>0,'status'=> WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'country'=>null];
               $country = $this->commonServices->getCountry();
               if($country)
                {                  
                   $msg=['resp'=>1,'status'=>WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'country'=>$country];
                }
             return $this->commonServices->sendResponse($msg); 
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
     * @return status(NOTUPDATE, UPDATE, USERINVAILDPARAMETER )
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
               $msg=['resp'=>0,'status'=> WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false'];
               $states=$this->commonServices->getStateByCountryId($id);
               if($states)
                {                  
                   $msg=['resp'=>1,'status'=> WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'states'=>$states];
                }
              
           }else{
               $msg=['resp'=>3,'status'=>WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false'];   
           }
                
           return $this->commonServices->sendResponse($msg);
        }
    }
    
     /**
     * Getting All City crossponding State Id
     *
     * @param  String| $sid, 
     * @return status
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return status(NOTUPDATE, UPDATE, USERINVAILDPARAMETER )
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
               $msg=['resp'=>0,'status'=> WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false'];
               $cities=$this->commonServices->getCityByStateId($id);
               if($cities)
                {                  
                   $msg=['resp'=>1,'status'=>  WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'cities'=>$cities];
                }
              
           }else{
               $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false'];   
           }
                
           return $this->commonServices->sendResponse($msg);
        }   
    }
    
    /**
     * Getting All Caste 
     *
     *  
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER )
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| allCaste
     * @author vishal 
     * 
     */ 
    public function  getAllCasteAction(){
      $msg=[];       
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getCaste();
            $msg=['resp'=>0,'status'=>WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'allCaste'=>null];
           if($data){                  
            $msg=['resp'=>1,'status'=>WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'allCaste'=>$data];
            }
           return $this->commonServices->sendResponse($msg);
        }     
    }
    
    /**
     * Getting All Profession 
     *
     *  
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER )
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
           $data = $this->commonServices->getProfession();
            $msg=['resp'=>0,'status'=>WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'allProfession'=>null];
           if($data){                  
            $msg=['resp'=>1,'status'=> WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'allProfession'=>$data];
            }
           return $this->commonServices->sendResponse($msg);
        }     
    }
    
     /**
     * Getting All PostCategories 
     *
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| allPostCategories
     * @author vishal 
     * 
     */ 
    public function getPostCategoriesAction(){
         $msg=[];        // var_dump('dfdf'); exit;  
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getPostCategories();
            $msg=['resp'=>0,'status'=> WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'allPostCategories'=>null];
           if($data){                  
            $msg=['resp'=>1,'status'=>  WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'allPostCategories'=>$data];
            }
           return $this->commonServices->sendResponse($msg);
        }     
    } 
    
    /**
     * Checking  RefferalKey 
     *
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| refferalKey
     * @author vishal 
     * 
     */ 
    public function checkRefferalKeyByRefferalAction(){
        $msg=[];        // var_dump('dfdf'); exit;  
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data=$this->commonServices->getArrayDataFromObject($request->getPost());
           $allParam=['refferalKey','loginType'];
               
           if($this->commonServices->isAllVaildParam($allParam,$data)){
           $data = $this->commonServices->getRefferalKeyByRefferal($data['refferalKey'], $data['loginType']);
            $msg=['resp'=>0,'status'=> WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'refferalKey'=>null];
           if($data){                  
            $msg=['resp'=>1,'status'=>  WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'refferalKey'=>$data];
            }
           }else{
              $msg=['resp'=>3,'status'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false','refferalKey'=>null];   
            
           }
           return $this->commonServices->sendResponse($msg);
        } 
    }
    
    
    /**
     * Getting All Height
     *
     *  
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER )
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| height
     * @author vishal 
     * 
     */ 
    public function  getHeightAction(){
      $msg=[];       
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getHeight();
            $msg=['resp'=>0,'status'=>WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'height'=>null];
           if($data){                  
            $msg=['resp'=>1,'status'=>WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'height'=>$data];
            }
           return $this->commonServices->sendResponse($msg);
        }     
    }
    
    /**
     * Getting All zodiac signs
     *
     *  
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER )
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| zodiac
     * @author vishal 
     * 
     */ 
    public function  getZodiacSignsAction(){
      $msg=[];       
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getZodiacSigns();
            $msg=['resp'=>0,'status'=>WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'zodiac'=>null];
           if($data){                  
            $msg=['resp'=>1,'status'=>WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'zodiac'=>$data];
            }
           return $this->commonServices->sendResponse($msg);
        }     
    }
    
     /**
     * Getting All star sign(Nakshatra)
     *
     *  
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER )
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| nakshtra
     * @author vishal 
     * 
     */ 
    public function  getNakshatraAction(){
      $msg=[];       
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getNakshatra();
            $msg=['resp'=>0,'status'=>WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'nakshtra'=>null];
           if($data){                  
            $msg=['resp'=>1,'status'=>WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'nakshtra'=>$data];
            }
           return $this->commonServices->sendResponse($msg);
        }     
    }
    
    
    /**
     * Getting All Nationality list
     *
     *  
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER )
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| nationality
     * @author vishal 
     * 
     */ 
    public function getNationalityAction(){
      $msg=[];       
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getNationality();
            $msg=['resp'=>0,'status'=>WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'nationality'=>null];
           if($data){                  
            $msg=['resp'=>1,'status'=>WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'nationality'=>$data];
            }
           return $this->commonServices->sendResponse($msg);
        }     
    }
    
    /**
     * Getting All Gothra list
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER )
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| gothraGothram
     * @author vishal 
     * 
     */ 
    public function getGothraGothramAction(){
      $msg=[];       
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getGothraGothram();
            $msg=['resp'=>0,'status'=>WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'gothraGothram'=>null];
           if($data){                  
            $msg=['resp'=>1,'status'=>WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'gothraGothram'=>$data];
            }
           return $this->commonServices->sendResponse($msg);
        }     
    }
    
     /**
     * Get All Religion list
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER )
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| religion
     * @author vishal 
     * 
     */ 
    public function getReligionAction(){
      $msg=[];       
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getReligion();
            $msg=['resp'=>0,'status'=>WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'religion'=>null];
           if($data){                  
            $msg=['resp'=>1,'status'=>WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'religion'=>$data];
            }
           return $this->commonServices->sendResponse($msg);
        }     
    }
    
     /**
     * Get All Community list
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER )
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| community
     * @author vishal 
     * 
     */ 
    public function getCommunityAction(){
      $msg=[];       
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getCommunity();
            $msg=['resp'=>0,'status'=>WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'community'=>null];
           if($data){                  
            $msg=['resp'=>1,'status'=>WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'community'=>$data];
            }
           return $this->commonServices->sendResponse($msg);
        }     
    }
    
    /**
     * Get All Community By Religion
     * @param  String| $religionId, 
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER )
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| community
     * @author vishal 
     * 
     */ 
    public function getCommunityByReligionIdAction(){
      $msg=[];        
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
            $religionId=$request->getPost('religionId');            //var_dump($religionId); exit;                    
           if($religionId){ 
               $msg=['resp'=>0,'status'=> WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false'];
               $community=$this->commonServices->getCommunityByReligionId($religionId);
               if($community)
                {                  
                   $msg=['resp'=>1,'status'=> WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'community'=>$community];
                }
              
           }else{
               $msg=['resp'=>3,'status'=>WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false'];   
           }
                
           return $this->commonServices->sendResponse($msg);
        }
    }
    /**
     * Get All Sub Community By CommunityId
     * @param  String| $communityId, 
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER )
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| subCommunity
     * @author vishal 
     * 
     */ 
    public function getSubCommunityByCommunityIdAction(){
      $msg=[];        
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
            $communityId=$request->getPost('communityId');            //var_dump($communityId); exit;                    
           if($communityId){ 
               $msg=['resp'=>0,'status'=> WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false'];
               $subCommunity=$this->commonServices->getSubCommunityByCommunityId($communityId);
               if($subCommunity)
                {                  
                   $msg=['resp'=>1,'status'=> WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'subCommunity'=>$subCommunity];
                }
              
           }else{
               $msg=['resp'=>3,'status'=>WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false'];   
           }
                
           return $this->commonServices->sendResponse($msg);
        }
    }
    
     /**
     * Get All Gotra By subCommunityId
     * @param  String| $subCommunityId, 
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER )
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| gotra
     * @author vishal 
     * 
     */ 
    public function getGotraBySubCommunityIdAction(){
      $msg=[];        
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
            $subCommunityId=$request->getPost('subCommunityId');            //var_dump($communityId); exit;                    
           if($subCommunityId){ 
               $msg=['resp'=>0,'status'=> WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false'];
               $gotra=$this->commonServices->getGotraBySubCommunityId($subCommunityId);
               if($gotra)
                {                  
                   $msg=['resp'=>1,'status'=> WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'gotra'=>$gotra];
                }
              
           }else{
               $msg=['resp'=>3,'status'=>WebServiceConstant::INVAILDARRUGMENTMSG, 'flag'=>'false'];   
           }
                
           return $this->commonServices->sendResponse($msg);
        }
    }
    
    
    
    /**
     * Get All Mother Tongue list
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER )
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| motherTongue
     * @author vishal 
     * 
     */ 
    public function getMotherTongueAction(){
      $msg=[];       
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getMotherTongue();
            $msg=['resp'=>0,'status'=>WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'motherTongue'=>null];
           if($data){                  
            $msg=['resp'=>1,'status'=>WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'motherTongue'=>$data];
            }
           return $this->commonServices->sendResponse($msg);
        }     
    }
    
    /**
     * Get All Education level list
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER )
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| educationLevel
     * @author vishal 
     * 
     */ 
    public function getEducationLevelAction(){
      $msg=[];       
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getEducationLevel();
            $msg=['resp'=>0,'status'=>WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'educationLevel'=>null];
           if($data){                  
            $msg=['resp'=>1,'status'=>WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'educationLevel'=>$data];
            }
           return $this->commonServices->sendResponse($msg);
        }     
    }
    /**
     * Get All Education Field list
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER )
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| educationField
     * @author vishal 
     * 
     */ 
    public function getEducationFieldAction(){
      $msg=[];       
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getEducationField();
            $msg=['resp'=>0,'status'=>WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'educationField'=>null];
           if($data){                  
            $msg=['resp'=>1,'status'=>WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'educationField'=>$data];
            }
           return $this->commonServices->sendResponse($msg);
        }     
    }
    
    /**
     * Get All designation list
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER )
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| designation
     * @author vishal 
     * 
     */ 
    public function getDesignationAction(){
      $msg=[];       
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getDesignation();
            $msg=['resp'=>0,'status'=>WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'designation'=>null];
           if($data){                  
            $msg=['resp'=>1,'status'=>WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'designation'=>$data];
            }
           return $this->commonServices->sendResponse($msg);
        }     
    }
    
    /**
     * Get All annual income list
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER )
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| annualIncome
     * @author vishal 
     * 
     */ 
    public function getAnnualIncomeAction(){
      $msg=[];       
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getAnnualIncome();
            $msg=['resp'=>0,'status'=>WebServiceConstant::NOTFOUNDMSG, 'flag'=>'false', 'annualIncome'=>null];
           if($data){                  
            $msg=['resp'=>1,'status'=>WebServiceConstant::FOUNDMSG, 'flag'=>'true', 'annualIncome'=>$data];
            }
           return $this->commonServices->sendResponse($msg);
        }     
    }
}
