<?php

namespace Application\Service;

use Application\Form\Entity\SingUpFormInterface;
use Application\Mapper\UserMapperInterface;
use Application\Model\Entity\PersonalDetailsInterface;
use Application\Service\UserServiceInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Debug\Debug;
use Zend\Http\PhpEnvironment\RemoteAddress;

class UserService implements UserServiceInterface {

    protected $userMapper;
    protected $dbAdapter;
    protected $resultSet;

    public function __construct(AdapterInterface $dbAdapter, UserMapperInterface $userMapper) {
        $this->userMapper = $userMapper;
        $this->dbAdapter = $dbAdapter;
        $this->resultSet = new ResultSet();
    }

    public function getUserById($id) {
        return $this->userMapper->getUserById($id);
    }

    public function getUserInfoById($id, $columns = false) {
        return $this->userMapper->getUserInfoById($id, $columns);
    }

    public function getUserProfessionById($id, $columns = false) {
        return $this->userMapper->getUserProfessionById($id, $columns);
    }

    public function getUserEducationAndCareerDetailById($id, $columns = false) {
        return $this->userMapper->getUserEducationAndCareerDetailById($id, $columns);
    }

    public function saveUserEducationAndCareerDetail($educationAndCareerData) {
        return $this->userMapper->saveUserEducationAndCareerDetail($educationAndCareerData);
    }

    public function userSummaryById($id) {
        return $this->userMapper->userSummaryById($id);
    }

    public function getUserAboutById($id) {
        return $this->userMapper->getUserAboutById($id);
    }

    public function saveUserAbout($userAboutData) {
        return $this->userMapper->saveUserAbout($userAboutData);
    }

    public function getUserPersonalDetailById($id) {
        return $this->userMapper->getUserPersonalDetailById($id);
    }

    public function educationDetailById($id) {
        return $this->userMapper->educationDetailById($id);
    }

    public function checkAlreadyExist($fieldName, $value) {
        return $this->userMapper->checkAlreadyExist($fieldName, $value);
    }

    public function getMemberInfoById($id) {
        return $this->userMapper->getMemberInfoById($id);
    }

    public function getRegisteredUserByActivationCode($id, $activationCode) {
        return $this->userMapper->getRegisteredUserByActivationCode($id, $activationCode);
    }

    public function getRegisteredUserById($id) {
        return $this->userMapper->getRegisteredUserById($id);
    }

    public function getUserCareerById($id) {
        return $this->userMapper->getUserCareerById($id);
    }

    public function getUserEducationById($id) {
        return $this->userMapper->getUserEducationById($id);
    }

    public function getUserMatrimonialById($id) {
        return $this->userMapper->getUserMatrimonialById($id);
    }

    public function removeUser($id) {
        return $this->userMapper->removeUser($id);
    }

    public function saveUser($object) {
        return $this->userMapper->saveUser($object);
    }

    public function saveUserSignUp(SingUpFormInterface $userObject) {
        return $this->userMapper->saveUserSignUp($userObject);
    }

    public function saveUserPersonalDetails($personalDetailsObject) {
        return $this->userMapper->saveUserPersonalDetails($personalDetailsObject);
    }

    public function saveUserEducationDetails($educationDetailsData) {
        return $this->userMapper->saveUserEducationDetails($educationDetailsData);
    }

    public function saveUserProfessionDetails($professionDetailsData) {
        return $this->userMapper->saveUserProfessionDetails($educationDetailsData);
    }

    public function saveAcitivationSmsCode($userId, $number, $code, $time) {
        return $this->userMapper->saveAcitivationSmsCode($userId, $number, $code, $time);
    }

    public function saveUserCareer($careerInfo) {
        return $this->userMapper->saveUserCareer($careerInfo);
    }

    public function saveUserEducation($educationInfo) {
        return $this->userMapper->saveUserEducation($educationInfo);
    }

    public function saveUserInfo($infoData) {
        return $this->userMapper->saveUserInfo($infoData);
    }

    public function saveUserMatrimonial($matrimonialInfo) {
        return $this->userMapper->saveUserMatrimonial($matrimonialInfo);
    }

    public function ProfileBar($user_id) {
        return $this->userMapper->ProfileBar($user_id);
    }

    public function getUserPostById($user_id) {
        return $this->userMapper->getUserPostById($user_id);
    }

    public function saveUserPost($userPostData) {
        return $this->userMapper->saveUserPost($userPostData);
    }

    public function getFamilyInfoById($user_id) {
        return $this->userMapper->getFamilyInfoById($user_id);
    }

    public function saveFamilyInfo($user_id, $familyData) {
        return $this->userMapper->saveFamilyInfo($user_id, $familyData);
    }

    public function getAllChild($id) {
        return $this->userMapper->getAllChild($id);
    }

    public function getFirstParent($user_id) {
        return $this->userMapper->getAllChild($user_id);
    }

    public function getMyChild($id) {
        return $this->userMapper->getAllChild($id);
    }

    public function getRelationIds($id) {
        return $this->userMapper->getAllChild($id);
    }

    public function checkAlreadyExistUserMatrimonial($fieldName, $value) {
        if ($fieldName == "referral_key") {
            $sql = "select " . $fieldName . " from tbl_user_matrimonial where " . $fieldName . " = '" . $value . "'";
        } else {
            $sql = "select " . $fieldName . " from tbl_user_matrimonial where " . $fieldName . " like '" . $value . "%'";
        }

        $data = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $data->count();
    }

    public function checkAlreadyExistUserMember($fieldName, $value) {
        if ($fieldName == "referral_key") {
            $sql = "select " . $fieldName . " from tbl_user where " . $fieldName . " = '" . $value . "'";
        } else {
            $sql = "select " . $fieldName . " from tbl_user where " . $fieldName . " like '" . $value . "%'";
        }

        $data = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $data->count();
    }

    public function saveUserMatrimonialSignUp($data) {
        //Debug::dump($data);exit;
        $sql = new Sql($this->dbAdapter);
        $userData['username'] = $data['username'];
        $userData['password'] = md5($data['password']);
        $userData['email'] = $data['email'];
        $userData['mobile_no'] = $data['mobile_no'];
        $userData['username'] = $data['username'];
        $userData['user_type_id'] = '2';
        $userData['signup_status'] = '1';
        $userData['activation_key'] = md5($data['email']);
        $remote = new RemoteAddress;
        $userData['ip'] = $remote->getIpAddress();
        $userData['created_date'] = date("Y-m-d H:i:s");
        $userData['Modified_Date'] = date("Y-m-d H:i:s");
        $action = new Insert('tbl_user_matrimonial');
        $action->values($userData);
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface) {
            if ($newId = $result->getGeneratedValue()) {
                return $newId;
            }
        }
        //Debug::dump($userData);exit;
    }

    public function saveUserMemberSignUp($data) {
        //Debug::dump($data);exit;
        $sql = new Sql($this->dbAdapter);
        $userData['username'] = $data['username'];
        $userData['password'] = md5($data['password']);
        $userData['email'] = $data['email'];
        $userData['mobile_no'] = $data['mobile_no'];
        $userData['username'] = $data['username'];
        $userData['role'] = 'user';
        $userData['user_type_id'] = '1';
        $userData['signup_status'] = '1';
        $userData['activation_key'] = md5($data['email']);
        $remote = new RemoteAddress;
        $userData['ip'] = $remote->getIpAddress();
        $userData['created_date'] = date("Y-m-d H:i:s");
        $userData['Modified_Date'] = date("Y-m-d H:i:s");
        $action = new Insert('tbl_user');
        $action->values($userData);
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface) {
            if ($newId = $result->getGeneratedValue()) {
                return $newId;
            }
        }
        //Debug::dump($userData);exit;
    }

    function genRandomString() {
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = '';

        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters))];
        }

        return $string;
    }

    public function saveUserMatrimonialDetailSignUp($data) {
        Debug::dump($data);exit;
        $sql = new Sql($this->dbAdapter);
        $userData['title'] = $data['name_title_father'];
        $userData['name'] = $data['father_name'];
        $userData['last_name'] = $data['father_last_name'];
        $userData['user_id'] = $data['user_id'];
        $userData['relation_id'] = '1';
        $userData['created_date'] = date("Y-m-d H:i:s");
        $userData['Modified_Date'] = date("Y-m-d H:i:s");
//        
        $action = new Insert('tbl_family_info_matrimonial');
        $action->values($userData);
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
//        if ($result instanceof ResultInterface) {
//            if ($newId = $result->getGeneratedValue()) {
//                return $newId;
//            }
//        }
        unset($userData);

        $userData['name_title_user'] = $data['name_title_user'];
        $userData['full_name'] = $data['full_name'];
        $userData['last_name'] = $data['last_name'];
        $userData['ref_no'] = $this->createReferenceNumberMatrimonial($data['full_name'], $data['user_id']);
        $userData['referral_key'] = $this->genRandomString();
        $userData['gender'] = $data['gender'];
        
        $userData['religion'] = $data['religion'];
        $userData['community'] = $data['community'];
        $userData['caste'] = $data['caste'];
        $userData['gothra_gothram'] = $data['gothra_gothram'];
        
        
        $userData['dob'] = date('Y-m-d',strtotime($data['dob']));
        $userData['native_place'] = $data['native_place'];
        $userData['created_date'] = date("Y-m-d H:i:s");
        $userData['user_id'] = $data['user_id'];
        //Debug::dump($userData);exit;
        $action = new Insert('tbl_user_info_matrimonial');
        $action->values($userData);
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        //Debug::dump($result);exit;

        $this->updateRefNoMatrimonial($data['user_id'], $userData['ref_no']);
        $this->updateUserMatrimonial($data['user_id'], 'referral_key', $userData['referral_key']);
        $this->updateUserMatrimonial($data['user_id'], 'signup_status', '2');
        //Debug::dump($result);exit;
        unset($userData);

        $userData['address'] = $data['address'];
        $userData['country'] = $data['country'];
        $userData['state'] = $data['state'];
        $userData['city'] = $data['city'];
        $userData['created_date'] = date("Y-m-d H:i:s");
        $userData['user_id'] = $data['user_id'];
        //Debug::dump($userData);exit;
        $action = new Insert('tbl_user_address_matrimonial');
        $action->values($userData);
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        unset($userData);

        $userData['profession'] = $data['profession'];
        $userData['created_date'] = date("Y-m-d H:i:s");
        $userData['user_id'] = $data['user_id'];

        //Debug::dump($userData);exit;

        $action = new Insert('tbl_user_professional_matrimonial');
        $action->values($userData);
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

//        $remote = new RemoteAddress;
//        $userData['ip'] = $remote->getIpAddress();
//        $userData['created_date'] = date("Y-m-d H:i:s");
//        $userData['Modified_Date'] = date("Y-m-d H:i:s");
//        $action = new Insert('tbl_user_matrimonial');
//        $action->values($userData);
//        $stmt = $sql->prepareStatementForSqlObject($action);
        //Debug::dump($userData);exit;
    }

    public function saveUserMemberDetailSignUp($data) {
        
        //Debug::dump($data);exit;

        $sql = new Sql($this->dbAdapter);

        $userData['name_title_user'] = $data['name_title_user'];
        $userData['full_name'] = $data['full_name'];
        $userData['last_name'] = $data['last_name'];
        $userData['ref_no'] = $this->createReferenceNumberMatrimonial($data['full_name'], $data['user_id']);
        $userData['referral_key'] = $this->genRandomString();
        $userData['gender'] = $data['gender'];
        $userData['dob'] = date('Y-m-d',strtotime($data['dob']));
        $userData['native_place'] = $data['native_place'];
        $remote = new RemoteAddress;
        $userData['ip'] = $remote->getIpAddress();
        $userData['profession'] = $data['profession'];
        $userData['marital_status'] = 'Single';
        $userData['address'] = $data['address'];
        $userData['country'] = $data['country'];
        $userData['state'] = $data['state'];
        $userData['city'] = $data['city'];
        $userData['caste'] = $data['cast'];
        $userData['caste_other'] = $data['cast_other'];
        $userData['branch_ids'] = $data['rustagi_branch'];
        $userData['branch_ids_other'] = $data['rustagi_branch_other'];
        $userData['created_date'] = date("Y-m-d H:i:s");
        $userData['user_type_id'] = '1';
        $userData['religion']=$data['religion'];
        $userData['community']=$data['community'];
        $userData['gothra_gothram']=$data['gothra_gothram'];
        $userData['user_id'] = $data['user_id'];
        $action = new Insert('tbl_user_info');
        $action->values($userData);
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        $this->updateRefNoMember($data['user_id'], $userData['ref_no']);
        $this->updateUserMember($data['user_id'], 'referral_key', $userData['referral_key']);
        $this->updateUserMember($data['user_id'], 'signup_status', '2');
        unset($userData);

        $father_id = $data['father_id'];

        if ($result instanceof ResultInterface) {
            //satya

            $selfRelationData['user_id'] = $data['user_id'];
            $selfRelationData['gender'] = $data['gender'];
            $action = new Insert('tbl_family_relation');
            $action->values($selfRelationData);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();

            if ($father_id == "") {
                $profileId = $this->userMapper->createFamilyProfile($data['father_name'], $data['name_title_father'], 'Alive', '', '', 'Male','','',$data['user_id'],$data['father_last_name']);
                $this->userMapper->saveRelation($data['user_id'], $profileId, 'f');
            } else {
                $profileId = $father_id;
                $this->userMapper->saveRelation($data['user_id'], $profileId, 'f', $father_id);
            }
        }
    }

    public function createReferenceNumberMatrimonial($fullName, $id) {
        $dateYear = date('y');
        if ($dateYear > 26) {
            $dateYear = $dateYear - 26;
            $dateYear = 64 + $dateYear;
            $dateYear = chr($dateYear);
            $dateYear = "A" . $dateYear;
        } else {
            $dateYear = 64 + $dateYear;
            $dateYear = chr($dateYear);
        }
        $full_nameArray = explode(' ', $fullName);
        if (count($full_nameArray) > 1) {
            $first = strtoupper(substr($full_nameArray[0], 0, 1));
            $last = strtoupper(substr($full_nameArray[1], 0, 1));
            $referenceNo = 'R' . $dateYear . $first . $last . $id;
        } else {
            $first = strtoupper(substr($full_nameArray[0], 0, 2));
            $referenceNo = 'R' . $dateYear . $first . $id;
        }
        return $referenceNo;
    }

//    public function saveUserMemberDetailSignUp($data) {
//        Debug::dump($data);
//        exit;
//        $sql = new Sql($this->dbAdapter);
////        $userData['title'] = $data['name_title_father'];
////        $userData['name'] = $data['father_name'];
////        $userData['user_id'] = $data['user_id'];
////        $userData['relation_id'] = '1';
////        $userData['created_date'] = date("Y-m-d H:i:s");
////        $userData['Modified_Date'] = date("Y-m-d H:i:s");
//////        
////        $action = new Insert('tbl_family_info_matrimonial');
////        $action->values($userData);
////        $stmt = $sql->prepareStatementForSqlObject($action);
////        $result = $stmt->execute();
//////        if ($result instanceof ResultInterface) {
//////            if ($newId = $result->getGeneratedValue()) {
//////                return $newId;
//////            }
//////        }
////        unset($userData);
//
//        $userData['name_title_user'] = $data['name_title_user'];
//        $userData['full_name'] = $data['full_name'];
//        $userData['gender'] = $data['gender'];
//        $userData['dob'] = $data['dob'];
//        $userData['native_place'] = $data['native_place'];
//        $userData['ref_no'] = $data['user_id'] . rand(4, 6);
//        $userData['created_date'] = date("Y-m-d H:i:s");
//        $userData['user_id'] = $data['user_id'];
//
//        $action = new Insert('tbl_user');
//        $action->values($userData);
//        $stmt = $sql->prepareStatementForSqlObject($action);
//        $result = $stmt->execute();
//        // Debug::dump($userData);exit;
//
//        unset($userData);
//
//        $userData['address'] = $data['address'];
//        $userData['country'] = $data['country'];
//        $userData['state'] = $data['state'];
//        $userData['city'] = $data['city'];
//        $userData['created_date'] = date("Y-m-d H:i:s");
//        $userData['user_id'] = $data['user_id'];
//
//        $action = new Insert('tbl_user_address_matrimonial');
//        $action->values($userData);
//        $stmt = $sql->prepareStatementForSqlObject($action);
//        $result = $stmt->execute();
//
//        unset($userData);
//
//        $userData['working_as'] = $data['profession'];
//        $userData['created_date'] = date("Y-m-d H:i:s");
//        $userData['user_id'] = $data['user_id'];
//
//
//
//        $action = new Insert('tbl_user_professional_matrimonial');
//        $action->values($userData);
//        $stmt = $sql->prepareStatementForSqlObject($action);
//        $result = $stmt->execute();
//
////        $remote = new RemoteAddress;
////        $userData['ip'] = $remote->getIpAddress();
////        $userData['created_date'] = date("Y-m-d H:i:s");
////        $userData['Modified_Date'] = date("Y-m-d H:i:s");
////        $action = new Insert('tbl_user_matrimonial');
////        $action->values($userData);
////        $stmt = $sql->prepareStatementForSqlObject($action);
//        //Debug::dump($userData);exit;
//    }

    public function saveAcitivationSmsCodeMatrimonial($userId, $number, $code, $time) {
        $sql = new Sql($this->dbAdapter);

        $userData['user_id'] = $userId;
        $userData['mobile'] = $number;
        $userData['code'] = $code;
        $userData['time'] = $time;

        $action = new Insert('tbl_mobile_matrimonial');
        $action->values($userData);
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface) {
            if ($newId = $result->getGeneratedValue()) {
                // When a value has been generated, set it on the object
                return $newId;
            }
        }
    }

    public function saveAcitivationSmsCodeMember($userId, $number, $code, $time) {
        $sql = new Sql($this->dbAdapter);

        $userData['user_id'] = $userId;
        $userData['mobile'] = $number;
        $userData['code'] = $code;
        $userData['time'] = $time;

        $action = new Insert('tbl_mobile');
        $action->values($userData);
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface) {
            if ($newId = $result->getGeneratedValue()) {
                // When a value has been generated, set it on the object
                return $newId;
            }
        }
    }

    public function getUserInfoByIdMatrimonial($id, $columns = false) {

        $columns = ($columns == false) ? array('*') : $columns;

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_user_info_matrimonial');
        $select->columns($columns);
        $select->where(array('user_id = ?' => $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        return $result->current();
    }

    public function getFamilyInfoByIdMatrimonial($user_id, $relation_id) {

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_family_info_matrimonial');
        $select->where(array('user_id = ?' => $user_id, 'relation_id = ?' => $relation_id));
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        return $result->current();
    }

    public function getFatherMatrimonial($user_id) {

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->from(array('tfi' => 'tbl_family_info_matrimonial'));
        $join = new \Zend\Db\Sql\Expression('tfi.id = tug.user_id AND 
                            tug.image_type = 1 AND tug.user_type = "F"');
        $select->join(array('tug' => 'tbl_user_gallery_matrimonial'), $join, array('gallery_id' => 'id', 'image_name'), 'left');
        $select->where(array('tfi.user_id = ?' => $user_id, 'tfi.relation_id = ?' => 1));
//        $select->where(
//    new \Zend\Db\Sql\Predicate\PredicateSet(
//        array(
//            new \Zend\Db\Sql\Predicate\Operator('tug.image_type', '=', '1'),
//            new \Zend\Db\Sql\Predicate\Operator('tug.user_type', '=', 'F')
//        ),
//        // optional; OP_AND is default
//        \Zend\Db\Sql\Predicate\PredicateSet::OP_AND
//    ),
//    // optional; OP_AND is default
//    \Zend\Db\Sql\Predicate\PredicateSet::OP_AND
//);
//        $select->where(array('tug.image_type=?'=>1), \Zend\Db\Sql\Predicate\PredicateSet::COMBINED_BY_OR);
//        $select->where(array('tug.user_type=?'=>'F'), \Zend\Db\Sql\Predicate\PredicateSet::OP_AND);
        $stmt = $sql->prepareStatementForSqlObject($select);
        //Debug::dump($stmt);
        $result = $stmt->execute();
        return $result->current();
    }

    public function getMotherMatrimonial($user_id) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->from(array('tfi' => 'tbl_family_info_matrimonial'));
        $join = new \Zend\Db\Sql\Expression('tfi.id = tug.user_id AND 
                            tug.image_type = 1 AND tug.user_type = "F"');
        $select->join(array('tug' => 'tbl_user_gallery_matrimonial'), $join, array('gallery_id' => 'id', 'image_name'), 'left');
        $select->where(array('tfi.user_id = ?' => $user_id, 'tfi.relation_id = ?' => 2));

        $stmt = $sql->prepareStatementForSqlObject($select);
        //Debug::dump($stmt);
        $result = $stmt->execute();
        return $result->current();
    }

    public function getBrotherMatrimonial($user_id) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->from(array('tfi' => 'tbl_family_info_matrimonial'));
        $join = new \Zend\Db\Sql\Expression('tfi.id = tug.user_id AND 
                            tug.image_type = 1 AND tug.user_type = "F"');
        $select->join(array('tug' => 'tbl_user_gallery_matrimonial'), $join, array('gallery_id' => 'id', 'image_name'), 'left');
        $select->where(array('tfi.user_id = ?' => $user_id, 'tfi.relation_id = ?' => 3));
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        $resultSet = $this->resultSet->initialize($result)->toArray();
        return $resultSet;
    }

    public function getSisterMatrimonial($user_id) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->from(array('tfi' => 'tbl_family_info_matrimonial'));
        $join = new \Zend\Db\Sql\Expression('tfi.id = tug.user_id AND 
                            tug.image_type = 1 AND tug.user_type = "F"');
        $select->join(array('tug' => 'tbl_user_gallery_matrimonial'), $join, array('gallery_id' => 'id', 'image_name'), 'left');
        $select->where(array('tfi.user_id = ?' => $user_id, 'tfi.relation_id = ?' => 4));
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        $resultSet = $this->resultSet->initialize($result)->toArray();
        return $resultSet;
    }

    public function getGrandFatherMatrimonial($user_id) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_family_info_matrimonial');
        $select->where(array('user_id = ?' => $user_id, 'relation_id = ?' => 7));
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        return $result->current();
    }

    public function getGrandMotherMatrimonial($user_id) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_family_info_matrimonial');
        $select->where(array('user_id = ?' => $user_id, 'relation_id = ?' => 8));
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        return $result->current();
    }

    public function getGrandGrandFatherMatrimonial($user_id) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_family_info_matrimonial');
        $select->where(array('user_id = ?' => $user_id, 'relation_id = ?' => 13));
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        return $result->current();
    }

    public function getGrandGrandMotherMatrimonial($user_id) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_family_info_matrimonial');
        $select->where(array('user_id = ?' => $user_id, 'relation_id = ?' => 14));
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        return $result->current();
    }

    public function getKidMatrimonial($user_id) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->from(array('tfi' => 'tbl_family_info_matrimonial'));
        $join = new \Zend\Db\Sql\Expression('tfi.id = tug.user_id AND 
                            tug.image_type = 1 AND tug.user_type = "F"');
        $select->join(array('tug' => 'tbl_user_gallery_matrimonial'), $join, array('gallery_id' => 'id', 'image_name'), 'left');
        $select->where(array('tfi.user_id = ?' => $user_id, 'tfi.relation_id = ?' => 6));
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        $resultSet = $this->resultSet->initialize($result)->toArray();
        return $resultSet;
    }

    public function getSpouseMatrimonial($user_id) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->from(array('tfi' => 'tbl_family_info_matrimonial'));
        $join = new \Zend\Db\Sql\Expression('tfi.id = tug.user_id AND 
                            tug.image_type = 1 AND tug.user_type = "F"');
        $select->join(array('tug' => 'tbl_user_gallery_matrimonial'), $join, array('gallery_id' => 'id', 'image_name'), 'left');
        $select->where(array('tfi.user_id = ?' => $user_id, 'tfi.relation_id = ?' => 5));

        $stmt = $sql->prepareStatementForSqlObject($select);
        //Debug::dump($stmt);
        $result = $stmt->execute();
        return $result->current();
    }

    public function getUserAboutByIdMatrimonial($user_id) {
        $statement = $this->dbAdapter->query("SELECT id, about_yourself AS about_me FROM tbl_user_info_matrimonial WHERE user_id=:user_id");
        $parameters = array(
            'user_id' => $user_id
        );
        $result = $statement->execute($parameters);

        return $result->current();

        //return $this->hydrator->hydrate($result->current(), new UserInfo());
    }

    public function getUserPersonalDetailByIdMatrimonial($user_id) {
        $statement = $this->dbAdapter->query("SELECT 
                 tui.*, 
                 tu.email, 
                 tu.mobile_no, 
                 tup.* ,
                 tuam.*,
                 tugm.* 
             FROM tbl_user_info_matrimonial as tui
               LEFT JOIN tbl_user_matrimonial as tu ON tui.user_id=tu.id
               LEFT JOIN tbl_user_professional_matrimonial as tup ON tui.user_id=tup.user_id
               LEFT JOIN tbl_user_gallery_matrimonial as tugm ON tugm.user_id=tui.user_id
               LEFT JOIN tbl_user_address_matrimonial as tuam ON tuam.user_id=tui.user_id
               WHERE tui.user_id=:user_id");
        $parameters = array(
            'user_id' => $user_id
        );
        $result = $statement->execute($parameters);

        return $result->current();

        //return $this->hydrator->hydrate($result->current(), new UserInfo());
    }

    public function getEducationAndCareerByIdMatrimonial($user_id) {
        $statement = $this->dbAdapter->query("SELECT 
             tupm.* , 
             tuem.*, 
             tuem.id as education_id, 
             tupm.id as profession_id
             FROM tbl_user_professional_matrimonial as tupm 
             LEFT JOIN tbl_user_education_matrimonial as tuem ON tuem.user_id=:user_id WHERE tupm.user_id=:user_id");
        $parameters = array(
            'user_id' => $user_id
        );
        $result = $statement->execute($parameters);
        //Debug::dump($result);
        return $result->current();

        //return $this->hydrator->hydrate($result->current(), new UserInfo());
    }

    public function saveUserAboutMatrimonial($user_id, $data) {
        //Debug::dump($data);

        $userData['about_yourself'] = $data['about_me'];

        $sql = new Sql($this->dbAdapter);
        $action = new Update('tbl_user_info_matrimonial');
        $action->set($userData);
        $action->where(array('user_id = ?' => $user_id));
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
    }

    public function updateRefNoMatrimonial($id, $ref_no) {

        $userData['ref_no'] = $ref_no;

        $sql = new Sql($this->dbAdapter);
        $action = new Update('tbl_user_matrimonial');
        $action->set($userData);
        $action->where(array('id = ?' => $id));
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
    }

    public function updateRefNoMember($id, $ref_no) {

        $userData['ref_no'] = $ref_no;

        $sql = new Sql($this->dbAdapter);
        $action = new Update('tbl_user');
        $action->set($userData);
        $action->where(array('id = ?' => $id));
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
    }

    public function updateUserMatrimonial($id, $field, $val) {

        $userData[$field] = $val;

        $sql = new Sql($this->dbAdapter);
        $action = new Update('tbl_user_matrimonial');
        $action->set($userData);
        $action->where(array('id = ?' => $id));
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
    }

    public function updateUserMember($id, $field, $val) {

        $userData[$field] = $val;

        $sql = new Sql($this->dbAdapter);
        $action = new Update('tbl_user');
        $action->set($userData);
        $action->where(array('id = ?' => $id));
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
    }

    public function userSummaryByIdMatrimonial($user_id) {

        $statement = $this->dbAdapter->query("SELECT tui.*, 
             tu.email, 
             tu.mobile_no, 
             tp.profession as profession_name, 
             tuam.*,
             tuem.*,
             tel.*,
             tup.*,
             td.*,
             tai.*,
             tr.*,
             tef.*,
             tugm.*
             FROM tbl_user_info_matrimonial as tui
               LEFT JOIN tbl_user_matrimonial as tu ON tui.user_id=tu.id
               LEFT JOIN tbl_user_professional_matrimonial as tup ON tui.user_id=tup.user_id
               LEFT JOIN tbl_profession as tp ON tup.profession=tp.id
               LEFT JOIN tbl_designation as td ON td.id=tup.designation
               LEFT JOIN tbl_annual_income as tai ON tai.id=tup.annual_income
               LEFT JOIN tbl_religion as tr ON tr.id=tui.religion
               LEFT JOIN tbl_user_education_matrimonial as tuem ON tuem.user_id=tui.user_id
               LEFT JOIN tbl_education_level as tel ON tel.id=tuem.education_level_id
               LEFT JOIN tbl_education_field as tef ON tef.id=tuem.education_field_id
               LEFT JOIN tbl_user_gallery_matrimonial as tugm ON tugm.user_id=tui.user_id AND tugm.user_type='U' AND 
               tugm.image_type=1
               LEFT JOIN tbl_user_address_matrimonial as tuam ON tuam.user_id=tui.user_id
               WHERE tui.user_id=:user_id ORDER BY tugm.id DESC");
        $parameters = array(
            'user_id' => $user_id
        );
        $result = $statement->execute($parameters);
        //Debug::dump($result->current());
        return $result->current();
    }

    public function ProfileBarMatrimonial($user_id) {
        //var_dump($user_id);
        //exit;
        $data = $this->dbAdapter->query("select * from tbl_user_info_matrimonial as tui  where tui.user_id=$user_id", Adapter::QUERY_MODE_EXECUTE)->toArray();

        $totalfields = count($data[0]);

        $arr = array('id', "ref_no", "user_id", "user_type_id", "comm_mem_id", "comm_mem_status", "ip", "created_date", "modified_date");
        $c = 0;
        foreach ($data[0] as $key => $value) {
            if (in_array($key, $arr))
                continue;
            if (!empty($value))
                $c++;
            // echo $value."<br>";
        }

        $percentage = ceil(($c / $totalfields) * 100);
        //$percentage=50;

        return $percentage; //array($percentage, $this->profilescript(ceil($percentage)));
    }

    public function saveUserPersonalDetailsMatrimonial($formData) {

        //Debug::dump($formData);exit;

        $sql = new Sql($this->dbAdapter);

        $userData['name_title_user'] = $formData['name_title_user'];
        $userData['full_name'] = $formData['full_name'];
        $userData['last_name'] = $formData['last_name'];
        $userData['gender'] = $formData['gender'];
        $userData['dob'] = Date('Y-m-d', strtotime($formData['dob']));
        $userData['birth_time'] = $formData['birth_time'];
        $userData['birth_place'] = $formData['birth_place'];

        $userData['marital_status'] = $formData['marital_status'];
        $userData['children'] = $formData['children'];
        $userData['no_of_kids'] = $formData['no_of_kids'];

        $userData['native_place'] = $formData['native_place'];
        // $userData['dob'] = $formData['star_sign'];
        $userData['blood_group'] = $formData['blood_group'];
        //$userData['dob'] = $formData['skin_tone'];
        //$userData['dob'] = $formData['star_sign'];
        $userData['zodiac_sign_raasi'] = $formData['zodiac_sign_raasi'];
        //$userData['dob'] = $formData['sevvai_dosham'];
        $userData['religion'] = $formData['religion'];
        $userData['community'] = $formData['community'];
        $userData['religion_other'] = $formData['religion_other'];
        $userData['gothra_gothram'] = $formData['gothra_gothram'];
        $userData['gothra_gothram_other'] = $formData['gothra_gothram_other'];
        $userData['smoke'] = $formData['smoke'];
        $userData['manglik_dossam'] = $formData['manglik_dossam'];
        $userData['height'] = $formData['height'];
        $userData['color_complexion'] = $formData['color_complexion'];
        $userData['any_disability'] = $formData['any_disability'];
        $userData['body_type'] = $formData['body_type'];
        $userData['body_weight'] = $formData['body_weight'];
        $userData['body_weight_type'] = $formData['body_weight_type'];
        $userData['alternate_mobile_no'] = $formData['alternate_mobile_no'];
        $userData['phone_no'] = $formData['phone_no'];
        $userData['religion'] = $formData['religion'];
        $userData['religion_other'] = $formData['religion_other'];
        $userData['gothra_gothram'] = $formData['gothra_gothram'];
        $userData['gothra_gothram_other'] = $formData['gothra_gothram_other'];
        $userData['caste'] = $formData['caste'];
        //$userData['caste_other'] = $formData['caste_other'];
        $userData['sub_caste'] = $formData['sub_caste'];
        $userData['mother_tongue_id'] = $formData['mother_tongue_id'];
        $userData['manglik_dossam'] = $formData['manglik_dossam'];
        $userData['star_sign'] = $formData['star_sign'];
        $userData['drink'] = $formData['drink'];
        $userData['smoke'] = $formData['smoke'];
        $userData['meal_preference'] = $formData['meal_preference'];
        //$MemberbasicForm->get('religion')->setValue($info['religion']);
        //$userData['body_weight_type'] = $formData['body_weight_type'];
        //$userData['created_date'] = date("Y-m-d H:i:s");
        $userData['user_id'] = $formData['user_id'];
        //Debug::dump($userData);exit;
        $action = new Update('tbl_user_info_matrimonial');
        $action->set($userData);
        $action->where(array('user_id = ?' => $userData['user_id']));
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        //Debug::dump($result);exit;

        unset($userData);

        $userData['address'] = $formData['address'];
        $userData['country'] = $formData['country'];
        $userData['state'] = $formData['state'];
        $userData['city'] = $formData['city'];
        $userData['pincode'] = $formData['zip_pin_code'];
        //$userData['created_date'] = date("Y-m-d H:i:s");
        $userData['user_id'] = $formData['user_id'];


        $action = new Update('tbl_user_address_matrimonial');
        $action->set($userData);
        $action->where(array('user_id = ?' => $userData['user_id']));
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
    }

    public function saveEducationAndCareerDetailMatrimonial($formData) {
        $sql = new Sql($this->dbAdapter);

        if (isset($formData['education_id']) && !empty($formData['education_id'])) {
            $userData['education_level_id'] = $formData['education_level'];
            $userData['education_field_id'] = $formData['education_field'];
            $userData['user_id'] = $formData['user_id'];

            $action = new Update('tbl_user_education_matrimonial');
            $action->set($userData);
            $action->where(array('user_id = ?' => $userData['user_id']));
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            unset($userData);
        } else {
            $userData['education_level_id'] = $formData['education_level'];
            $userData['education_field_id'] = $formData['education_field'];
            $userData['user_id'] = $formData['user_id'];
            $action = new Insert('tbl_user_education_matrimonial');
            $action->values($userData);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            unset($userData);
        }



        if (isset($formData['profession_id']) && !empty($formData['profession_id'])) {
            $userData['employer'] = $formData['employer'];
            $userData['designation'] = $formData['designation'];
            $userData['specialize_profession'] = $formData['specialize_profession'];
            $userData['annual_income'] = $formData['annual_income'];
            $userData['profession'] = $formData['profession'];
            $userData['office_name'] = $formData['office_name'];
            $userData['office_email'] = $formData['office_email'];
            $userData['office_website'] = $formData['office_website'];
            $userData['office_phone'] = $formData['office_phone'];
            $userData['office_address'] = $formData['office_address'];
            $userData['office_country'] = $formData['office_country'];
            $userData['office_state'] = $formData['office_state'];
            $userData['office_city'] = $formData['office_city'];
            $userData['office_pincode'] = $formData['office_pincode'];
            $userData['annual_income_status'] = $formData['annual_income_status'];
            $userData['user_id'] = $formData['user_id'];

            $action = new Update('tbl_user_professional_matrimonial');
            $action->set($userData);
            $action->where(array('user_id = ?' => $userData['user_id']));
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            unset($userData);
        } else {
            $userData['employer'] = $formData['employer'];
            $userData['designation'] = $formData['designation'];
            $userData['specialize_profession'] = $formData['specialize_profession'];
            $userData['annual_income'] = $formData['annual_income'];
            $userData['profession'] = $formData['profession'];
            $userData['office_name'] = $formData['office_name'];
            $userData['office_email'] = $formData['office_email'];
            $userData['office_website'] = $formData['office_website'];
            $userData['office_phone'] = $formData['office_phone'];
            $userData['office_address'] = $formData['office_address'];
            $userData['office_country'] = $formData['office_country'];
            $userData['office_state'] = $formData['office_state'];
            $userData['office_city'] = $formData['office_city'];
            $userData['office_pincode'] = $formData['office_pincode'];
            $userData['annual_income_status'] = $formData['annual_income_status'];
            $userData['user_id'] = $formData['user_id'];

            $action = new Insert('tbl_user_education_matrimonial');
            $action->values($userData);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            unset($userData);
        }
    }

    public function saveFamilyInfoMatrimonial($formData) {


        $sql = new Sql($this->dbAdapter);


        if (isset($formData['user_id'])) {
            $userData['family_values_status'] = $formData['family_values'];
            $action = new Update('tbl_user_info_matrimonial');
            $action->set($userData);
            $action->where(array('user_id = ?' => $formData['user_id']));
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            unset($userData);
        }

        if (isset($formData['father_id']) && !empty($formData['father_id'])) {
            $userData['title'] = $formData['name_title_father'];
            $userData['name'] = $formData['father_name'];
            $userData['last_name'] = $formData['father_last_name'];
            $userData['dob'] = date("Y-m-d", strtotime($formData['father_dob']));
            $userData['status'] = $formData['father_status'];
            $userData['dod'] = date("Y-m-d", strtotime($formData['father_dod']));
            $userData['about'] = $formData['about_father'];

            $action = new Update('tbl_family_info_matrimonial');
            $action->set($userData);
            $action->where(array('id = ?' => $formData['father_id']));
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            unset($userData);
        } elseif (isset($formData['father_name'])) {
            
        }


        if (isset($formData['mother_id']) && !empty($formData['mother_id'])) {
            //Debug::dump($formData);exit;
            $userData['title'] = $formData['name_title_mother'];
            $userData['name'] = $formData['mother_name'];
            $userData['last_name'] = $formData['mother_last_name'];
            $userData['dob'] = date("Y-m-d", strtotime($formData['mother_dob']));
            $userData['status'] = $formData['mother_status'];
            $userData['dod'] = date("Y-m-d", strtotime($formData['mother_dod']));
            $userData['about'] = $formData['about_mother'];

            $action = new Update('tbl_family_info_matrimonial');
            $action->set($userData);
            $action->where(array('id = ?' => $formData['mother_id']));
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            unset($userData);
        } elseif (isset($formData['mother_name'])) {
            //Debug::dump($formData);exit;
            $userData['title'] = $formData['name_title_mother'];
            $userData['name'] = $formData['mother_name'];
            $userData['last_name'] = $formData['mother_last_name'];
            $userData['dob'] = date("Y-m-d", strtotime($formData['mother_dob']));
            $userData['status'] = $formData['mother_status'];
            $userData['dod'] = date("Y-m-d", strtotime($formData['mother_dod']));
            $userData['about'] = $formData['about_mother'];
            $userData['relation_id'] = '2';
            $userData['created_date'] = date("Y-m-d H:i:s");
            $userData['Modified_Date'] = date("Y-m-d H:i:s");
            $userData['user_id'] = $formData['user_id'];

            $action = new Insert('tbl_family_info_matrimonial');
            $action->values($userData);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            unset($userData);
        }



        if (isset($formData['brother_id']) && !empty($formData['brother_id'])) {
            foreach ($formData['brother_id'] as $key => $brother_id) {

                $userData['title'] = $formData['name_title_brother'][$key];
                $userData['name'] = $formData['brother_name'][$key];
                $userData['last_name'] = $formData['brother_last_name'][$key];
                $userData['dob'] = date("Y-m-d", strtotime($formData['brother_dob'][$key]));
                $userData['status'] = $formData['brother_status'][$key];
                $userData['marital_status'] = $formData['marital_status_brother'][$key];
                $userData['dod'] = date("Y-m-d", strtotime($formData['brother_dod'][$key]));
                $userData['about'] = $formData['about_brother'][$key];
                // Debug::dump($userData);
                $action = new Update('tbl_family_info_matrimonial');
                $action->set($userData);
                $action->where(array('id = ?' => $brother_id));
                $stmt = $sql->prepareStatementForSqlObject($action);
                $result = $stmt->execute();
                unset($userData);
            }
        }
        if (isset($formData['new_brother_name'])) {

            for ($i = 0; $i < count($formData['new_brother_name']) - 1; $i++) {

                $userData['title'] = $formData['new_name_title_brother'][$i];
                $userData['name'] = $formData['new_brother_name'][$i];
                $userData['last_name'] = $formData['new_brother_last_name'][$i];
                $userData['dob'] = date("Y-m-d", strtotime($formData['new_brother_dob'][$i]));
                $userData['status'] = $formData['new_brother_status'][$i];
                $userData['dod'] = date("Y-m-d", strtotime($formData['new_brother_dod'][$i]));
                $userData['about'] = $formData['new_about_brother'][$i];
                $userData['relation_id'] = '3';
                $userData['created_date'] = date("Y-m-d H:i:s");
                $userData['Modified_Date'] = date("Y-m-d H:i:s");
                $userData['user_id'] = $formData['user_id'];
                //Debug::dump($userData);
                $action = new Insert('tbl_family_info_matrimonial');
                $action->values($userData);
                $stmt = $sql->prepareStatementForSqlObject($action);
                $result = $stmt->execute();
                unset($userData);
            }
        }


        if (isset($formData['sister_id']) && !empty($formData['sister_id'])) {
            foreach ($formData['sister_id'] as $key => $sister_id) {

                $userData['title'] = $formData['name_title_sister'][$key];
                $userData['name'] = $formData['sister_name'][$key];
                $userData['last_name'] = $formData['sister_last_name'][$key];
                $userData['dob'] = date("Y-m-d", strtotime($formData['sister_dob'][$key]));
                $userData['status'] = $formData['sister_status'][$key];
                $userData['marital_status'] = $formData['marital_status_sister'][$key];
                $userData['dod'] = date("Y-m-d", strtotime($formData['sister_dod'][$key]));
                $userData['about'] = $formData['about_sister'][$key];
                // Debug::dump($userData);
                $action = new Update('tbl_family_info_matrimonial');
                $action->set($userData);
                $action->where(array('id = ?' => $sister_id));
                $stmt = $sql->prepareStatementForSqlObject($action);
                $result = $stmt->execute();
                unset($userData);
            }
        }
        if (isset($formData['new_sister_name'])) {

            for ($i = 0; $i < count($formData['new_sister_name']) - 1; $i++) {

                $userData['title'] = $formData['new_name_title_sister'][$i];
                $userData['name'] = $formData['new_sister_name'][$i];
                $userData['last_name'] = $formData['new_sister_last_name'][$i];
                $userData['dob'] = date("Y-m-d", strtotime($formData['new_sister_dob'][$i]));
                $userData['status'] = $formData['new_sister_status'][$i];
                $userData['marital_status'] = $formData['new_marital_status_sister'][$i];
                $userData['dod'] = date("Y-m-d", strtotime($formData['new_sister_dod'][$i]));
                $userData['about'] = $formData['new_about_sister'][$i];
                $userData['relation_id'] = '4';
                $userData['created_date'] = date("Y-m-d H:i:s");
                $userData['Modified_Date'] = date("Y-m-d H:i:s");
                $userData['user_id'] = $formData['user_id'];
                //Debug::dump($userData);
                $action = new Insert('tbl_family_info_matrimonial');
                $action->values($userData);
                $stmt = $sql->prepareStatementForSqlObject($action);
                $result = $stmt->execute();
                unset($userData);
            }
        }


        exit;

        // $userData['education_level_id'] = $formData['education_level'];
//        $userData['education_level_id'] = $formData['education_level'];
//        $userData['education_field_id'] = $formData['education_field'];
//        $userData['user_id'] = $formData['user_id'];
//        
//        $action = new Update('tbl_user_education_matrimonial');
//        $action->set($userData);
//        $action->where(array('user_id = ?' => $userData['user_id']));
//        $stmt = $sql->prepareStatementForSqlObject($action);
//        $result = $stmt->execute();
//    
//        $userData['title'] = $data['name_title_father'];
//        $userData['name'] = $data['father_name'];
//        $userData['user_id'] = $data['user_id'];
//        $userData['relation_id'] = '1';
//        $userData['created_date'] = date("Y-m-d H:i:s");
//        $userData['Modified_Date'] = date("Y-m-d H:i:s");
////        
//        $action = new Insert('tbl_family_info_matrimonial');
//        $action->values($userData);
//        $stmt = $sql->prepareStatementForSqlObject($action);
//        $result = $stmt->execute();
    }

    public function deleteBrotherMatrimonial($id) {
        $sql = new Sql($this->dbAdapter);
        $action = new \Zend\Db\Sql\Delete('tbl_family_info_matrimonial');
        $action->where('id=' . $id);
        $stmt = $sql->prepareStatementForSqlObject($action);
        //Debug::dump($stmt);
        $result = $stmt->execute();
    }

}
