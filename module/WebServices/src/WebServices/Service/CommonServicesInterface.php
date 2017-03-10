<?php

namespace WebServices\Service;


interface CommonServicesInterface{
public function getArrayDataFromObject($data);
public function isAllVaildParam(array $allParam, array $data, array $notMandParam = null );
public function isUserNameExit($userName,$loginType,$id=null);
public function isUserEmailExit($email,$loginType,$id=null);
public function isUserMobileExit($mobile,$loginType,$id=null);
public function sendResponse($msg);
public function isVaildLoginType($loginType);
public function getCaste();
public function getCountry();
public function getProfession();
public function getStateByCountryId($id);
public function getCityByStateId($id);
public function getPostCategories();
public function updateTableField($id, $fieldName, $fieldVal,$tableName);
public function resendOtp($userDetails);
public function sendAccountThanksSms($userName, $mobileNumber, $code);
public function getUserTableByLoginType($loginType);
public function getMobileTableByLoginType($loginType);
public function createReferenceNumberMatrimonial($fullName, $id);
public function genRandomString();
public function newInsertData($data ,$tableName);
public function newUpdateData($tableName, array $data , array $condtion);
public function getTokenByLoginId($id,$loginType);
public function newSelectSimpleData($tableName, array $condition); 
public function isSameOtp($code,$loginType,$mobile,$actionType);
public function getUserByIdMobile($id,$mobile,$loginType);
public function getUserInfoTableBYLoginType($loginType);
public function getNationality();
public function getGothraGothram();
public function getGothraGothramByCastId($castId);
public function getRefferalKeyByRefferal($refferalKey, $loginType);
public function sendOtp($mobile, $loginType);
public function getUserDetailsByMobile($mobile,$loginType);
public function getMobileNumberById($id,$loginType);
public function getUserGallaryTableBYLoginType($loginType);
public function deleteOnRequest($table, $condition);
public function filterText($data);
public function getHeight();
public function getZodiacSigns();
public function getNakshatra();
public function getReligion();
public function getMotherTongue();
public function getEducationLevel();
public function getEducationField();
public function getDesignation();
public function getAnnualIncome();
public function getUserProfessionTableByLoginType($loginType);
public function getUserEducationTableByLoginType($loginType);    
public function getUserFamilyInfoTableByLoginType($loginType); 
public function getUserReferalKeyUsedTableByLoginType($loginType);
public function getUniqueString();
public function getRefernceNumberById($id, $loginType);
public function getCommunity();
public function getCommunityByReligionId($religionId);
public function getSubCommunityByCommunityId($communityId);
public function getGotraBySubCommunityId($subCommunityId);
}
