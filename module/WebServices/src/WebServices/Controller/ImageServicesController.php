<?php

namespace WebServices\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use WebServices\Service\CommonServicesInterface;
use WebServices\Service\LoginServicesInterface;
use WebServices\Service\UserServicesInterface;
use WebServices\Service\ImageServicesInterface;
use WebServices\Image;
use WebServices\WebServiceConstant;

class ImageServicesController extends AbstractRestfulController{
    
    protected $loginServices;
    protected $commonServices;
    protected $userServices;
    protected $imageServices;
    public function __construct(CommonServicesInterface $commonServices,
                                LoginServicesInterface $loginServices,
                                UserServicesInterface $userServices,
                                ImageServicesInterface $imageServices
                              ) {
        
        $this->loginServices= $loginServices;
        $this->commonServices=$commonServices;
        $this->userServices=$userServices;
        $this->imageServices=$imageServices;
    }
    
    public function indexAction() {
        die('images');
        
    }
    
    /**
     * Uploading the Single as Profile Images  
     * @param Int $id, $loginType, $image(base64endode format)  
     * @param String  $token Authtoken
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| status
     * @return  int|id, loginType, String|token 
     * @author vishal 
     * @see (image Type accepted:'jpeg','jpg','png','bmp') 
     * 
     */ 
    public function userProfileImageUploadAction(){
         $msg=[];
       
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();   
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getArrayDataFromObject($request->getPost());          
           $allParam=['id','loginType', 'image','token'];         //  var_dump(ImagePath::USERPROFILEIMAGE); exit;
           if($this->commonServices->isAllVaildParam($allParam,$data) ){  
               $path=$this->imageServices->userImageUpload($data, Image::USERPROFILEIMAGE);// var_dump($allParam); exit;
              if($path){
                $token=$this->commonServices->getTokenByLoginId($data['id'],$data['loginType']);  
                $msg=['resp'=>1,'error'=>'null', 'status'=>  $path,'id'=>$data['id'],'loginType'=>$data['loginType'],'token'=>$data['token']];
              }else{
                $msg=['resp'=>0,'error'=>'null', 'status'=>  WebServiceConstant::DETAILEDNOTSAVEDMSG,'id'=>$data['id'],'loginType'=>$data['loginType'],'token'=>$data['token']];   
              }
           }else{
                $msg=['resp'=>3,'error'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'status'=>'failure','id'=>$data['id'],'loginType'=>$data['loginType'],'token'=>$data['token']]; 
           }
        }
          return $this->commonServices->sendResponse($msg);
    
    }
    
    /**
     * Uploading the User  Multiple Images  
     * @param Int $id, $loginType, Array| $image(base64endode format)  
     * @param String  $token Authtoken
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| status
     * @return  int|id, loginType, String|token 
     * @author vishal 
     * @see (image Type accepted:'jpeg','jpg','png','bmp') 
     * 
     */ 
    public function userProfileMutlipleImageUploadAction(){
         $msg=[];
       
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();   
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getArrayDataFromObject($request->getPost());          // var_dump($data);exit;        
           $allParam=['id','loginType', 'image','token'];         //  var_dump(ImagePath::USERPROFILEIMAGE); exit;
           if($this->commonServices->isAllVaildParam($allParam,$data) ){  
               $path=$this->imageServices->userMultipleImageUpload($data, Image::USERPROFILEIMAGE);
              if($path){
                $token=$this->commonServices->getTokenByLoginId($data['id'],$data['loginType']);  
                $msg=['resp'=>1,'error'=>'null', 'status'=> $path,'id'=>$data['id'],'loginType'=>$data['loginType'],'token'=>$token];
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
     * Hard Delete the User Profile  Images  
     * @param Int $id, $loginType, Array| $imageId  
     * @param String  $token Authtoken
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| status
     * @author vishal 
     * 
     */ 
    public function userProfileImageHardDeleteAction(){
         $msg=[];
         //var_dump('heelo'); exit;
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();   
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getArrayDataFromObject($request->getPost());          // var_dump($data);exit;        
           $allParam=['id','loginType', 'imageId','token'];         //  var_dump(ImagePath::USERPROFILEIMAGE); exit;
           if($this->commonServices->isAllVaildParam($allParam,$data) ){  
               $response=$this->imageServices->userProfileImageHardDelete($data,$data['loginType']);
              if($response){
                $token=$this->commonServices->getTokenByLoginId($data['id'],$data['loginType']);  
                $msg=['resp'=>1,'error'=>'null', 'status'=> $response,'id'=>$data['id'],'loginType'=>$data['loginType'],'token'=>$token];
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
     * Soft Delete  User  Images  
     * @param Int $id, $loginType, Array| $imageId  
     * @param String  $token Authtoken
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| status
     * @author vishal 
     * 
     */ 
    public function userImageSoftDeleteAction(){
         $msg=[];
       
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();   
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getArrayDataFromObject($request->getPost());          // var_dump($data);exit;        
           $allParam=['id','loginType', 'imageId','token'];         //  var_dump(ImagePath::USERPROFILEIMAGE); exit;
           if($this->commonServices->isAllVaildParam($allParam,$data) ){  
               $response=$this->imageServices->userProfileImageSoftDelete($data,$data['loginType']);
              if($response){
                $token=$this->commonServices->getTokenByLoginId($data['id'],$data['loginType']);  
                $msg=['resp'=>1,'error'=>'null', 'status'=> $response,'id'=>$data['id'],'loginType'=>$data['loginType'],'token'=>$token];
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
     * Get all  User  Images  
     * @param Int $id, $loginType 
     * @param String  $token Authtoken
     * @return status(NOTFOUND, FOUND, USERINVAILDPARAMETER)
     * @return boolan|flag
     * @return resp (0: failure, 1: success, 3:Exception\InvalidArgumentException)
     * @return Array| status
     * @author vishal 
     * 
     */ 
    public function getUserImagesAction(){
         $msg=[];
       
        if($this->getRequest()->isPost()){
           $request = $this->getRequest();   
           $request->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8' );
           $data = $this->commonServices->getArrayDataFromObject($request->getPost());          // var_dump($data);exit;        
           $allParam=['id','loginType', 'token'];               //  var_dump(ImagePath::USERPROFILEIMAGE); exit;
           if($this->commonServices->isAllVaildParam($allParam,$data) ){  
               $response=$this->imageServices->getUserImages($data['id'],$data['loginType']);
              if($response){
                $token=$this->commonServices->getTokenByLoginId($data['id'],$data['loginType']);  
                $msg=['resp'=>1,'error'=>'null', 'status'=> $response,'id'=>$data['id'],'loginType'=>$data['loginType'],'token'=>$token];
              }else{
                $msg=['resp'=>0,'error'=>'null', 'status'=>  WebServiceConstant::DETAILEDNOTSAVEDMSG];   
              }
           }else{
                $msg=['resp'=>3,'error'=>  WebServiceConstant::INVAILDARRUGMENTMSG, 'status'=>'failure','id'=>null]; 
           }
        }
          return $this->commonServices->sendResponse($msg);
       }
}
