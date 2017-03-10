<?php

namespace WebServices\Service;

interface UserServicesInterface{
   
  public function getCustomerDetailsById($id, $loginType);   
  
  public function getProfilePercentage($id, $loginType);
  
  public function setAboutYourSelf($id, $loginType, $msg);
  
  public function setPhysicalDetails($id, $loginType,$data);
  
  public function setPersonalDetails($id, $loginType,$data);
  
  public function setAstroDetails($id, $loginType,$data);
  
  public function setReligiousBackgroundDetails($id, $loginType,$data);
  
  public function setLifeStyleDetails($id, $loginType,$data);
  
  public function setEducationCarrier($id, $loginType,$data);
  
  public function setCompanyDetails($id, $loginType,$data);
  
  public function setParentDetails($id, $loginType,$data);
  
  public function setBrotherDetails($id, $loginType,$data);
  
  public function setSisterDetails($id, $loginType,$data);


}
