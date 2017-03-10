<?php

namespace Application\Mapper;

use Application\Form\Entity\SingUpFormInterface;
use Application\Model\Entity\UserInfo;
use Common\Model\Entity\Post;
use Common\Model\Entity\User\User;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Debug\Debug;
use Zend\Stdlib\Hydrator\ClassMethods;

class ProfileDbSqlMapper implements ProfileMapperInterface {

    protected $dbAdapter;
    protected $resultSet;
    protected $hydrator;

    public function __construct(AdapterInterface $dbAdapter) {

        $this->dbAdapter = $dbAdapter;
        $this->resultSet = new ResultSet();
        $this->hydrator = new ClassMethods();
    }

    public function getUserById($id) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_user');
        $select->where(array('id = ?' => $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new User());
        }
    }

    public function getUserInfoById($id, $columns = false) {

        $columns = ($columns == false) ? array('*') : $columns;

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_user_info');
        $select->columns($columns);
        $select->where(array('user_id = ?' => $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {

            return $this->hydrator->hydrate($result->current(), new UserInfo());
        }
    }

    public function userSummaryById($id) {
//        $sql = new Sql($this->dbAdapter);
//        $select = $sql->select('tbl_user_info');
//        $select->join('tbl_family_info', 'tbl_family_info.user_id=tbl_user_info.user_id');
//        $select->where(array('tbl_user_info.user_id = ?' => $id));
//
//        $stmt = $sql->prepareStatementForSqlObject($select);
//        $result = $stmt->execute();
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_user_info WHERE user_id=:user_id");
        $parameters = array(
            'user_id' => $id
        );
        $result = $statement->execute($parameters);
//        Debug::dump($result->current());
//        exit;
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {

            //Debug::dump($result->current());
            //exit;

            return $this->hydrator->hydrate($result->current(), new UserInfo());
        }
    }

    public function getUserAboutById($id) {

        $statement = $this->dbAdapter->query("SELECT id, about_yourself_partner_family as about_me FROM tbl_user_info WHERE user_id=:user_id");
        $parameters = array(
            'user_id' => $id
        );
        $result = $statement->execute($parameters);

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {

              return $this->hydrator->hydrate($result->current(), new UserInfo());
        }
    }

    public function saveUserAbout($userAboutData) {

        $userData = $this->hydrator->extract($userAboutData);
        $userData = array_filter((array) $userData, function ($val) {
             return !is_null($val);
           });

        $userData['about_yourself_partner_family']=$userData['about_me'];
        unset($userData['about_me']);

        $sql = new Sql($this->dbAdapter);
        $action = new Update('tbl_user_info');
        $action->set($userData);
        $action->where(array('id = ?' => $userData['id']));
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
    }

    public function getUserPersonalDetailById($id) {
        
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_user_info');
        $select->where(array('user_id = ?' => $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {

            //return $result->current();
            return $this->hydrator->hydrate($result->current(), new UserInfo());
        }
    }

    public function educationDetailById($id) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_user_info');
        $select->where(array('user_id = ?' => $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {

            //return $result->current();
            return $this->hydrator->hydrate($result->current(), new UserInfo());
        }
    }

    public function getUserInfoDetail($id) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_user_info');
        $select->where(array('user_id = ?' => $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {

            return $this->hydrator->hydrate($result->current(), new UserInfo());
        }
    }

    public function checkAlreadyExist($fieldName, $value) {
        $sql = "select " . $fieldName . " from tbl_user where " . $fieldName . " like '" . $value . "%'";
        $data = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $data->count();
    }

    public function ProfileBar($user_id) {
        //var_dump($user_id);
        //exit;
        $data = $this->dbAdapter->query("select * from tbl_user_info as tui inner join tbl_family_info as tfi on 
            tui.user_id = tfi.user_id where tui.user_id=$user_id", Adapter::QUERY_MODE_EXECUTE)->toArray();

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

    public function getMemberInfoById($id) {
        
    }

    public function getRegisteredUserByActivationCode($id, $activationCode) {
        
    }

    public function getRegisteredUserById($id) {
        
    }

    public function getUserCareerById($id) {
        
    }

    public function getUserProfessionById($id, $columns = false) {

        $columns = ($columns == false) ? array('*') : $columns;

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_user_info');
        $select->columns($columns);
        $select->where(array('user_id = ?' => $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {

            return $this->hydrator->hydrate($result->current(), new UserInfo());
        }
    }

    public function getUserEducationAndCareerDetailById($id, $columns = false) {
        $columns = ($columns == false) ? array('*') : $columns;

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbl_user_info');
        $select->columns($columns);
        $select->where(array('user_id = ?' => $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {

            return $this->hydrator->hydrate($result->current(), new UserInfo());
        }
    }

    public function saveUserEducationAndCareerDetail($professionDetailsData) {

        //Debug::dump($professionDetailsData);
        //exit;
        $userData = $this->hydrator->extract($professionDetailsData);
        $userData = array_filter((array) $userData, function ($val) {
             return !is_null($val);
           });

        unset($userData['created_date']);
        //Debug::dump($userData);
        //exit;
        $sql = new Sql($this->dbAdapter);
        $action = new Update('tbl_user_info');
        $action->set($userData);
        $action->where(array('id = ?' => $userData['id']));
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
    }

    public function getUserEducationById($id) {
        
    }

    public function getUserMatrimonialById($id) {
        
    }

    public function removeUser($id) {
        
    }

    public function save(SingUpFormInterface $userObject) {

        $sql = new Sql($this->dbAdapter);

        $userData['user_type_id'] = $userObject->getUserTypeId();
        $userData['username'] = $userObject->getUsername();
        $userData['password'] = $userObject->getPassword();
        $userData['email'] = $userObject->getEmail();
        $userData['mobile_no'] = $userObject->getMobileNo();
        $userData['activation_key'] = md5($userObject->getEmail());
        $userData['ip'] = $userObject->getIp();
        $userData['created_date'] = $userObject->getCreatedDate();
        $userData['Modified_Date'] = $userObject->getModifiedDate();

        $action = new Insert('tbl_user');
        $action->values($userData);
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface) {
            if ($newId = $result->getGeneratedValue()) {
                $userObject->setUserId($newId);
                $ref_no = $this->createReferenceNumber($userObject->getFullName(), $userObject->getUserId());
                $userObject->setRefNo($ref_no);
                $action = new Update('tbl_user');
                $action->set(array('ref_no' => $ref_no));
                $action->where(array('id = ?' => $userObject->getUserId()));
                $stmt = $sql->prepareStatementForSqlObject($action);
                $result = $stmt->execute();
            }
            if ($userObject->getUserId()) {
                $userInfoData['ref_no'] = $userObject->getRefNo();
                $userInfoData['user_id'] = $userObject->getUserId();
                $userInfoData['user_type_id'] = $userObject->getUserTypeId();
                $userInfoData['ip'] = $userObject->getIp();
                $userInfoData['full_name'] = $userObject->getFullName();
                $userInfoData['name_title_user'] = $userObject->getNameTitleUser();
                $userInfoData['gender'] = $userObject->getGender();
                $userInfoData['address'] = $userObject->getAddress();
                $userInfoData['country'] = $userObject->getCountry();
                $userInfoData['state'] = $userObject->getState();
                $userInfoData['city'] = $userObject->getCity();
                $userInfoData['branch_ids'] = $userObject->getRustagiBranch();
                $userInfoData['branch_ids_other'] = $userObject->getRustagiBranchOther();
                $userInfoData['native_place'] = $userObject->getNativePlace();
                $userInfoData['gothra_gothram'] = $userObject->getGothraGothram();
                $userInfoData['gothra_gothram_other'] = $userObject->getGothraGothramOther();
                $userInfoData['created_date'] = $userObject->getCreatedDate();
                $userInfoData['modified_date'] = $userObject->getModifiedDate();

                $action = new Insert('tbl_user_info');
                $action->values($userInfoData);
                $stmt = $sql->prepareStatementForSqlObject($action);
                $result = $stmt->execute();
                if ($result instanceof ResultInterface) {

                    $familyInfoData["user_id"] = $userObject->getUserId();
                    $familyInfoData["relation_id"] = (int) 1;
                    $familyInfoData["title"] = $userObject->getNameTitleUser();
                    $familyInfoData["name"] = $userObject->getFatherName();
                    $familyInfoData['ip'] = $userObject->getIp();
                    $familyInfoData['created_date'] = $userObject->getCreatedDate();
                    $familyInfoData['modified_date'] = $userObject->getModifiedDate();

                    $action = new Insert('tbl_family_relation_info');
                    $action->values($familyInfoData);
                    $stmt = $sql->prepareStatementForSqlObject($action);
                    $result = $stmt->execute();
                }
            }
            return $userObject;
        }
    }

    public function saveUser(SingUpFormInterface $userObject) {

        $sql = new Sql($this->dbAdapter);

        $userData['user_type_id'] = $userObject->getUserTypeId();
        $userData['username'] = $userObject->getUsername();
        $userData['password'] = $userObject->getPassword();
        $userData['email'] = $userObject->getEmail();
        $userData['mobile_no'] = $userObject->getMobileNo();
        $userData['activation_key'] = md5($userObject->getEmail());
        $userData['ip'] = $userObject->getIp();
        $userData['created_date'] = $userObject->getCreatedDate();
        $userData['Modified_Date'] = $userObject->getModifiedDate();

        $action = new Insert('tbl_user');
        $action->values($userData);
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface) {
            if ($newId = $result->getGeneratedValue()) {
                $userObject->setUserId($newId);
                $ref_no = $this->createReferenceNumber($userObject->getFullName(), $userObject->getUserId());
                $userObject->setRefNo($ref_no);
                $action = new Update('tbl_user');
                $action->set(array('ref_no' => $ref_no));
                $action->where(array('id = ?' => $userObject->getUserId()));
                $stmt = $sql->prepareStatementForSqlObject($action);
                $result = $stmt->execute();
            }
            if ($userObject->getUserId()) {
                $userInfoData['ref_no'] = $userObject->getRefNo();
                $userInfoData['user_id'] = $userObject->getUserId();
                $userInfoData['user_type_id'] = $userObject->getUserTypeId();
                $userInfoData['ip'] = $userObject->getIp();
                $userInfoData['full_name'] = $userObject->getFullName();
                $userInfoData['name_title_user'] = $userObject->getNameTitleUser();
                $userInfoData['gender'] = $userObject->getGender();
                $userInfoData['address'] = $userObject->getAddress();
                $userInfoData['country'] = $userObject->getCountry();
                $userInfoData['state'] = $userObject->getState();
                $userInfoData['city'] = $userObject->getCity();
                $userInfoData['branch_ids'] = $userObject->getRustagiBranch();
                $userInfoData['branch_ids_other'] = $userObject->getRustagiBranchOther();
                $userInfoData['native_place'] = $userObject->getNativePlace();
                $userInfoData['gothra_gothram'] = $userObject->getGothraGothram();
                $userInfoData['gothra_gothram_other'] = $userObject->getGothraGothramOther();
                $userInfoData['created_date'] = $userObject->getCreatedDate();
                $userInfoData['modified_date'] = $userObject->getModifiedDate();

                $action = new Insert('tbl_user_info');
                $action->values($userInfoData);
                $stmt = $sql->prepareStatementForSqlObject($action);
                $result = $stmt->execute();
                if ($result instanceof ResultInterface) {

                    $familyInfoData["user_id"] = $userObject->getUserId();
                    $familyInfoData["relation_id"] = (int) 1;
                    $familyInfoData["title"] = $userObject->getNameTitleUser();
                    $familyInfoData["name"] = $userObject->getFatherName();
                    $familyInfoData['ip'] = $userObject->getIp();
                    $familyInfoData['created_date'] = $userObject->getCreatedDate();
                    $familyInfoData['modified_date'] = $userObject->getModifiedDate();

                    $action = new Insert('tbl_family_relation_info');
                    $action->values($familyInfoData);
                    $stmt = $sql->prepareStatementForSqlObject($action);
                    $result = $stmt->execute();
                }
            }
            return $userObject;
        }
    }

    public function saveUserSignUp(SingUpFormInterface $userObject) {

        $sql = new Sql($this->dbAdapter);
        $userObject->setActivationKey(md5($userObject->getEmail()));
        $userData['user_type_id'] = $userObject->getUserTypeId();
        $userData['username'] = $userObject->getUsername();
        $userData['password'] = $userObject->getPassword();
        $userData['email'] = $userObject->getEmail();
        $userData['mobile_no'] = $userObject->getMobileNo();
        $userData['activation_key'] = $userObject->getActivationKey();
        $userData['ip'] = $userObject->getIp();
        $userData['created_date'] = $userObject->getCreatedDate();
        $userData['Modified_Date'] = $userObject->getModifiedDate();

        $action = new Insert('tbl_user');
        $action->values($userData);
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface) {
            if ($newId = $result->getGeneratedValue()) {
                $userObject->setUserId($newId);
                $ref_no = $this->createReferenceNumber($userObject->getFullName(), $userObject->getUserId());
                $userObject->setRefNo($ref_no);
                $action = new Update('tbl_user');
                $action->set(array('ref_no' => $ref_no));
                $action->where(array('id = ?' => $userObject->getUserId()));
                $stmt = $sql->prepareStatementForSqlObject($action);
                $result = $stmt->execute();
            }
            if ($userObject->getUserId()) {
                $userInfoData['ref_no'] = $userObject->getRefNo();
                $userInfoData['user_id'] = $userObject->getUserId();
                $userInfoData['user_type_id'] = $userObject->getUserTypeId();
                $userInfoData['ip'] = $userObject->getIp();
                $userInfoData['full_name'] = $userObject->getFullName();
                $userInfoData['name_title_user'] = $userObject->getNameTitleUser();
                $userInfoData['gender'] = $userObject->getGender();
                $userInfoData['address'] = $userObject->getAddress();
                $userInfoData['country'] = $userObject->getCountry();
                $userInfoData['state'] = $userObject->getState();
                $userInfoData['city'] = $userObject->getCity();
                $userInfoData['branch_ids'] = $userObject->getRustagiBranch();
                $userInfoData['branch_ids_other'] = $userObject->getRustagiBranchOther();
                $userInfoData['native_place'] = $userObject->getNativePlace();
                $userInfoData['gothra_gothram'] = $userObject->getGothraGothram();
                $userInfoData['gothra_gothram_other'] = $userObject->getGothraGothramOther();
                $userInfoData['created_date'] = $userObject->getCreatedDate();
                $userInfoData['modified_date'] = $userObject->getModifiedDate();

                $action = new Insert('tbl_user_info');
                $action->values($userInfoData);
                $stmt = $sql->prepareStatementForSqlObject($action);
                $result = $stmt->execute();
                if ($result instanceof ResultInterface) {

                    $familyInfoData["user_id"] = $userObject->getUserId();
                    $familyInfoData["relation_id"] = (int) 1;
                    $familyInfoData["title"] = $userObject->getNameTitleUser();
                    $familyInfoData["name"] = $userObject->getFatherName();
                    $familyInfoData['ip'] = $userObject->getIp();
                    $familyInfoData['created_date'] = $userObject->getCreatedDate();
                    $familyInfoData['modified_date'] = $userObject->getModifiedDate();

                    $action = new Insert('tbl_family_relation_info');
                    $action->values($familyInfoData);
                    $stmt = $sql->prepareStatementForSqlObject($action);
                    $result = $stmt->execute();
                }
            }
            return $userObject;
        }
    }

    public function saveUserPersonalDetails($personalDetailsObject) {

        $userData=$this->hydrator->extract($personalDetailsObject);
         $userData = array_filter((array) $userData, function ($val) {
             return !is_null($val);
           });
        //Debug::dump($userData);
        //exit;
        //$remote = new RemoteAddress;
        //$this->ip = $remote->getIpAddress();
        $sql = new Sql($this->dbAdapter);



        $action = new Update('tbl_user_info');
        $action->set($userData);
        $action->where(array('id = ?' => $userData['id']));
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
    }

    public function saveUserEducationDetails($educationDetailsData) {

        $userData = $this->hydrator->extract($educationDetailsData);
        unset($userData['created_date']);
        //Debug::dump($userData);
        //exit;
        $sql = new Sql($this->dbAdapter);
        $action = new Update('tbl_user_info');
        $action->set($userData);
        $action->where(array('id = ?' => $userData['id']));
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
    }

    public function saveUserProfessionDetails($professionDetailsData) {

        $userData = $this->hydrator->extract($professionDetailsData);
        unset($userData['created_date']);
        //Debug::dump($userData);
        //exit;
        $sql = new Sql($this->dbAdapter);
        $action = new Update('tbl_user_info');
        $action->set($userData);
        $action->where(array('id = ?' => $userData['id']));
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
    }

    public function saveAcitivationSmsCode($userId, $number, $code, $time) {
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

    public function saveUserInfo($userInfoObject) {
        $userInfoData = $this->hydrator->extract($userInfoObject);
        //unset($userInfoData['id']); // Neither Insert nor Update needs the ID in the array

        Debug::dump($userInfoData);
        exit;
        $action = new Insert('tbl_user_info');
        $action->values($userInfoData);

        $sql = new Sql($this->dbAdapter);
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface) {
            if ($newId = $result->getGeneratedValue()) {
                // When a value has been generated, set it on the object
                $userInfoObject->setId($newId);
            }

            return $userInfoObject;
        }
    }

    public function saveUserCareer($careerInfo) {
        
    }

    public function saveUserEducation($educationInfo) {
        
    }

    public function saveUserMatrimonial($matrimonialInfo) {
        
    }

    public function createReferenceNumber($fullName, $id) {
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
            $referenceNo = $dateYear . $first . $last . $id;
        } else {
            $first = strtoupper(substr($full_nameArray[0], 0, 2));
            $referenceNo = $dateYear . $first . $id;
        }
        return $referenceNo;
    }
    
    public function getUserPostById($user_id){
        
          $statement = $this->dbAdapter->query("SELECT * FROM tbl_post WHERE user_id=:user_id");
        $parameters = array(
            'user_id' => $user_id
        );
        $result = $statement->execute($parameters);

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {

              return $this->hydrator->hydrate($result->current(), new Post());
        }
        
    }
    public function saveUserPost($userPostData){
         $postData = $this->hydrator->extract($userPostData);
        $postData = array_filter((array) $postData, function ($val) {
             return !is_null($val);
           });

//        $userData['about_yourself_partner_family']=$userData['about_me'];
        //unset($userData['about_me']);
        Debug::dump($postData);
        exit;
        $sql = new Sql($this->dbAdapter);
        $action = new Update('tbl_user_info');
        $action->set($userData);
        $action->where(array('id = ?' => $postData['id']));
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
    }

}
