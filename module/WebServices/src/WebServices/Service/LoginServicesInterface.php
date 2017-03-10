<?php

namespace WebServices\Service;

interface LoginServicesInterface{
    
     public function getTypeUserByLogin($loginEmail, $loginPassword, $loginType=null);
     
     public function getTypeUser($loginEmail, $loginPassword);
     
     public function isUserActive($isActive);
     
     public function saveUser($data,$loginType);
     
     public function saveUserInfo(array $data, $loginType);
     
     public function getUserDetailsByMobile($mobile, $loginType=null);
     
     public function updatePassword($id,$mobile,$loginType,$password);
}