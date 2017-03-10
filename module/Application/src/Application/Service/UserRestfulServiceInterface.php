<?php


namespace Application\Service;


interface UserRestfulServiceInterface{
    
      
   public function isUserExitDetails($loginEmail, $loginPassword);
   
   public function isUserActive($isActive);
 
    public function resendOtp($userDetails);
   
    public function sendAccountThanksSms($userName, $mobileNumber, $code);
    
    public function getDbAdapter(); 
    
    public function sendResponse($msg);
    
    public function isUserNameExit($userName,$loginType);
    
    public function isUserEmailExit($email,$loginType);
    
    public function isUserMobileExit($mobile,$loginType);
    
    public function getUserDetailsByMobile($mobile, $loginType=null);

        // public function saveUserMatrimonialSignUp($data);
    
   public function saveUser($data,$loginType);
   
   public function getTypeUser($loginEmail, $loginPassword);
   
   public function getTypeUserByLogin($loginEmail, $loginPassword, $loginType);
   
   public function isVaildParamerter(array $receivedParam, $loginType=null);
   
   public function isSameOtp($code,$loginType,$mobile);
   
   public function sendMail($id,$loginType);
   
   public function updatePassword($id,$mobile,$loginType,$password);
   
   public function isVaildLoginType($loginType);
    
   public function getCast();
    
   public function getCountry();

   public function getProfession();
   
   public function getArrayDataFromObject($data);

   
  public function isAllVaildParam(array $allParam, array $data, array $notMandParam = null );
  
  public function saveUserInfo(array $data, $loginType);

  public function getStateByCountryId($id);
  
  public function getCityByStateId($id);
  
  public function getCustomerDetailsById($loginId, $loginType);
  
  public function getPostCategories();
  
  


}

       
