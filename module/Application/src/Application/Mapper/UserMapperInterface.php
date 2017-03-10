<?php

namespace Application\Mapper;

use Application\Form\Entity\SingUpFormInterface;
use Application\Model\Entity\PersonalDetailsInterface;

interface UserMapperInterface {

    public function getUserById($id);

    public function getUserInfoById($id, $columns);
    
    public function userSummaryById($id);

    public function getRegisteredUserById($id);
    
    public function getRegisteredUserByActivationCode($id, $activationCode);

    public function getUserEducationById($id);

    public function getUserCareerById($id);

    public function getUserMatrimonialById($id);

    public function getMemberInfoById($id);
    
    public function getUserAboutById($id);
    
    public function saveUserAbout($userAboutData);
    
    public function getUserPersonalDetailById($id);
    
    public function saveUserPersonalDetails($personalDetailsObject);
    
    public function saveUserProfessionDetails($professionDetailsData);
    
    public function educationDetailById($id);

    public function saveUser(SingUpFormInterface $object);
    
    public function saveUserSignUp(SingUpFormInterface $userObject);
    
    public function saveUserEducationDetails($educationDetailsData);
 
    public function saveAcitivationSmsCode($userId, $number, $code, $time);

    public function saveUserInfo($infoData);

    public function saveUserEducation($educationInfo);

    public function saveUserCareer($careerInfo);
    
    public function getUserProfessionById($id, $columns);
    
    public function getUserEducationAndCareerDetailById($id, $columns);
    
    public function saveUserEducationAndCareerDetail($educationAndCareerData);

    public function saveUserMatrimonial($matrimonialInfo);

    public function checkAlreadyExist($fieldName, $value);
    
    public function ProfileBar($user_id);

    public function removeUser($id);
    
    public function getUserPostById($user_id);
    
    public function saveUserPost($userPostData);
    
    public function getFamilyInfoById($user_id);
    
    public function saveFamilyInfo($user_id, $familyData);
    
    public function getFirstParent($user_id);
    
    public function getAllChild($id);
    
    public function getMyChild($id);
    
    public function getRelationIds($id);
}
