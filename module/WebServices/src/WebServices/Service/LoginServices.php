<?php
namespace WebServices\Service;

use WebServices\Service\LoginServicesInterface;
//use Zend\Db\Adapter\Adapter;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use WebServices\WebServiceConstant;
use WebServices\Service\CommonServicesInterface;
use WebServices\TableName;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Insert;
use Zend\Http\PhpEnvironment\RemoteAddress;

class LoginServices implements LoginServicesInterface{
    
    protected $dbAdapter;
    protected $commonService;

    public function __construct(AdapterInterface $dbAdapter, CommonServicesInterface $commonService) {
        $this->dbAdapter=$dbAdapter;
        $this->commonService=$commonService; 
    }
    
    
    public function getTypeUserByLogin($loginEmail, $loginPassword, $loginType=null){
       
        $data =  '';
       if(null== $loginType){           //var_dump($data);exit;
        $data=$this->getTypeUser($loginEmail, $loginPassword);   
       }else {
           if(in_array($loginType, [WebServiceConstant::USERMATRIMONIAL, WebServiceConstant::USERMEMBER])){
                if($loginType == WebServiceConstant::USERMATRIMONIAL){
                $tableName =  TableName::USERMATRIMONIALTABLE;
                $loginType= WebServiceConstant::USERMATRIMONIAL;
        
            }else{
                $tableName = TableName::USERTABLE; 
                $loginType = WebServiceConstant::USERMEMBER; 
            }

       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->where
               ->NEST
               ->equalTo('mobile_no', $loginEmail)
               ->OR
               ->equalTo('email', $loginEmail)
               ->UNNEST
               ->AND
               ->equalTo('password', $loginPassword);
               
       $select->from($tableName);
       $statement= $sql->prepareStatementForSqlObject($select);
       $results= $statement->execute();      // var_dump($statement->getSql()); exit;
       $data=$results->current(); 
       $token= $this->getToken($loginEmail); 
       if($this->commonService->updateTableField($data['id'], 'token', $token, $tableName)){
         
           $data =  array_merge($data,['loginType'=> $loginType,'table'=>$table, 'token'=>$token]);
       }
                
           
        }
       }    

        return $data;
         
         
       }
       
    public function getTypeUser($loginEmail, $loginPassword){
        $data ='';
        $sql= new Sql($this->dbAdapter);
        $select=$sql->select();
        $select->where
               ->NEST
               ->equalTo('mobile_no', $loginEmail)
               ->OR
               ->equalTo('email', $loginEmail)
               ->UNNEST
               ->AND
               ->equalTo('password', $loginPassword);
        $select->from(TableName::USERTABLE);
        $statement= $sql->prepareStatementForSqlObject($select);
        $results= $statement->execute(); 
        $row=$results->current(); 
        $select1=$sql->select();
         $select1->where
               ->NEST
               ->equalTo('mobile_no', $loginEmail)
               ->OR
               ->equalTo('email', $loginEmail)
               ->UNNEST
               ->AND
               ->equalTo('password', $loginPassword);
        $select1->from(TableName::USERMATRIMONIALTABLE);
        $statement1= $sql->prepareStatementForSqlObject($select1);
        $results1= $statement1->execute(); 
        $row1=$results1->current();        
       
//        $sql = "SELECT * FROM tbl_user WHERE (mobile_no='$loginEmail' OR email= '$loginEmail') AND password='$loginPassword'";
//        $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();  
//        $sql1 = "SELECT * FROM tbl_user_matrimonial WHERE (mobile_no='$loginEmail' OR email= '$loginEmail') AND password='$loginPassword'";
//        $row1 = $this->dbAdapter->query($sql1, Adapter::QUERY_MODE_EXECUTE)->toArray();
          if(!empty($row) && !empty($row1)){             // var_dump($row1); exit;
              $data=['loginType'=> WebServiceConstant::USEREXITINBOTH,'table'=>null];
           
         } elseif ($row) {             //var_dump($row); exit;
             $data = $row;
             $token=$token= $this->getToken($loginEmail);
               if($this->commonService->updateTableField($data['id'], 'token', $token, TableName::USERTABLE)){
                $data=  array_merge($data,['loginType'=> WebServiceConstant::USERMEMBER,'table'=>  TableName::USERTABLE,'token'=>$token]);
               }
         
     }elseif ($row1) {        // var_dump('ewfwefwe'); exit;       
         $data = $row1;   
         $token=$token= $this->getToken($loginEmail);
          if($this->commonService->updateTableField($data['id'], 'token', $token, TableName::USERMATRIMONIALTABLE)){
            $data=  array_merge($data,['loginType'=> WebServiceConstant::USERMATRIMONIAL,'table'=>  TableName::USERMATRIMONIALTABLE, 'token'=>$token]);
          }
         
        }
        
         return $data ;
           
       }
       
       public function getToken($loginEmail){
       $string=  time().$loginEmail;      
       return $token=  hash('sha256', $string);
       }
       
        public function isUserActive($isActive){
        $status=false;
        if($isActive== 1 ){
            $status=true;
        }
       return $status;
      
        }

    public function saveUser($data,$loginType){   
         
        $tableName = $this->commonService->getUserTableByLoginType($loginType); 
        $tableUserInfo= $this->commonService->getUserInfoTableBYLoginType($loginType);
        $userInfo['gender']= $data['gender']; 
       
        if(isset($data['id']) && !empty($data['id']))
        {
        $id=$data['id'];
        $updateData=['username'=>$data['userName'],'password'=>md5($data['password']),
            'email'=>$data['email'],'mobile_no'=>$data['mobile']];
        $condition=['id'=>$id]; 
       // $condition1=['user_id'=>$id];
        $this->commonService->newUpdateData($tableName, $updateData, $condition);
       // $this->commonService->newUpdateData($tableUserInfo, $userInfo, $condition1);
         
        }else{
        $sql = new Sql($this->dbAdapter); 
        $userData['username'] = $data['userName'];
        $userData['password'] = md5($data['password']);
        $userData['email'] = $data['email'];
        $userData['mobile_no'] = $data['mobile'];
        $userData['activation_key'] = md5($data['email']);
        $remote = new RemoteAddress;
        $userData['ip'] = $remote->getIpAddress();
        $userData['created_date'] = date("Y-m-d H:i:s");
        $userData['Modified_Date'] = date("Y-m-d H:i:s");
        $userData['user_type_id']=$loginType;
        if($loginType==WebServiceConstant::USERMEMBER){
        $userData['role'] = 'user';    
        }
        $userData['token']=$this->getToken($data['email']);
        $userData['signup_status']=  WebServiceConstant::SIGNUPINUSER;
        $action = new Insert($tableName);       
        $action->values($userData);
        $stmt = $sql->prepareStatementForSqlObject($action);         
        $result = $stmt->execute();
        if ($result instanceof ResultInterface) {
            if ($result->getGeneratedValue()) {
                $id= $result->getGeneratedValue();
            }
        } 
//        $sqlObject= new Insert($tableUserInfo);       
//        $userInfo['user_id']= $id;      
//        $userInfo['ref_no'] = $this->commonService->createReferenceNumberMatrimonial($data['userName'], $id);
//        $userInfo['referral_key']=$this->commonService->genRandomString();
//        $sqlObject->values($userInfo);
//        $stmt1= $sql->prepareStatementForSqlObject($sqlObject)->execute();            
//        $data=['ref_no'=>$userInfo['ref_no'],'referral_key'=>$userInfo['referral_key']];
//        $condition=['id'=>$id]; 
//        $this->commonService->newUpdateData($tableName, $data, $condition);
        }
        return $id;
    }  
    
    public function saveUserInfo(array $data, $loginType){
         $flag=false;
         if($loginType==WebServiceConstant::USERMEMBER){
        //return;
             //die('fff');
             $flag=$this->saveUserInfoMamber($data);
             
         }elseif ($loginType==WebServiceConstant::USERMATRIMONIAL) {
             $tableName=  TableName::USERMATRIMONIALTABLE;
            // $flag=$this->commonService->newUpdateData($tableName, ['signup_status'=>  WebServiceConstant::SIGNUPINUSERINFO], ['id'=>$data['id']]);
             $flag=$this->saveUserInfoMatrimonial($data);                      
             $flag=$this->saveFamilyInfoMatrimonial($data); 
             $flag=$this->saveUserMatrimonialAddress($data);
             $flag=$this->saveUserProfession($data);
             
              
             
         }
         if(isset($data['refferalKey']) && !empty($data['refferalKey'])){
              $flag=$this->saveRefferalKeyMatrimonial($data,$loginType);  
             }
         return $flag;    
            
         
     }
     
    public function saveRefferalKeyMatrimonial($data){
      $flag=false;
      $tableName=$this->commonService->getUserReferalKeyUsedTableByLoginType($data['loginType']);
      //$tableName=TableName::USERMATRIMONAILREFERRALKEYUSED;      //var_dump($tableName);
      $refferalData= $this->commonService->getRefferalKeyByRefferal($data['refferalKey'], $data['loginType']);      //var_dump($refferalData);
      if($refferalData){          //var_dump($refferalData,$refferalData['id'],$data['id']); exit;
      $userData['user_id']=$refferalData['id'];
      $userData['used_by']=$data['id'];
      $userData['referral_key']=$this->commonService->filterText($refferalData['referral_key']);
      $userData['created_date']=date("Y-m-d H:i:s");
      $remote = new RemoteAddress;
      $userData['ip'] = $remote->getIpAddress();
      $flag=$this->commonService->newInsertData($userData, $tableName);      //var_dump($flag);exit;
      }
      
      return $flag;
    }

    public function saveFamilyInfoMatrimonial($data){ 
         $flag='';
        $tableName=  TableName::FAMILYINFOMATRIMONIALTABLE;
            $userData['title']= $data['fatherSalutation'];
            $userData['name']=$data['fname'];
            $userData['last_name']=$data['flname'];
            $userData['user_id'] = $data['id'];
            $userData['relation_id'] = WebServiceConstant::FATHER;
            $userData['created_date'] = date("Y-m-d H:i:s");
            $userData['Modified_Date'] = date("Y-m-d H:i:s");
            $flag=$this->commonService->newInsertData($userData, $tableName);
      
        return $flag;
     }
       
      public function saveUserInfoMatrimonial($data){
        $flag='';  
        $tableName= TableName::USERINNFOMATRIMONIALTABLE;
        $userData['name_title_user'] = $data['userSalutation'];
        $userData['full_name'] = $this->commonService->filterText($data['name']);
        $userData['last_name']=$this->commonService->filterText($data['lname']);
        $userData['gender'] = $data['gender'];
        $userData['dob'] = date('Y-m-d',strtotime($data['dob']));
        $userData['nationality'] = $data['nationality'];
        $userData['native_place'] = $this->commonService->filterText($data['nativePlace']);
        $userData['created_date'] = date("Y-m-d H:i:s");
        $userData['user_id'] = $data['id'];  
        $userData['religion']=$data['religion'];
        $userData['religion_other']=isset($data['religionOther'])?$this->commonService->filterText($data['religionOther']):'';
        $userData['community']=$data['community'];
        $userData['community_other']=isset($data['communityOther'])?$this->commonService->filterText($data['communityOther']):'';
        $userData['caste']=$data['subCommunity'];
        $userData['caste_other']=isset($data['subCommunityOther'])?$this->commonService->filterText($data['subCommunityOther']):'';
        $userData['gothra_gothram']=$data['gotra'];
        $userData['gothra_gothram_other']=isset($data['gotraOther'])?$this->commonService->filterText($data['gotraOther']):'';
        $userData['ref_no']=$this->commonService->createReferenceNumberMatrimonial($userData['full_name'], $data['id']);
        $userData['referral_key']=$this->commonService->genRandomString(); 
        $userData['user_type_id']=  WebServiceConstant::USERMATRIMONIAL;
        $flag=$this->commonService->newInsertData($userData, $tableName);
//$flag=$this->commonService->newUpdateData($tableName, $userData, ['user_id'=>$data['id']]);        var_dump($flag); exit;   
        $data=['ref_no'=>$userData['ref_no'],'referral_key'=>$userData['referral_key']];
        $condition=['id'=>$userData['user_id']];
        $flag=$this->commonService->newUpdateData(TableName::USERMATRIMONIALTABLE, $data, $condition);
//        $flag=$this->updateTableField($userData['user_id'],'ref_no', $userData['ref_no'],$this->userMatrimonialTable);
//        $flag=$this->updateTableField($userData['user_id'],'referral_key', $userData['referral_key'],$this->userMatrimonialTable);
        return $flag;
     }
//$this->commonService->createReferenceNumberMatrimonial($userInfo['full_name'], $data['id'])


     public function saveUserMatrimonialAddress($data)
    {
        $flag='';    
        $tableName=  TableName::USERADDRESSMATRIMONIALTABLE;
        $userData['address'] = $this->commonService->filterText($data['address']);
        $userData['country'] = $data['country'];
        $userData['state'] = $data['state'];
        $userData['city'] = $data['city'];
        $userData['created_date'] = date("Y-m-d H:i:s");
        $userData['user_id'] = $data['id'];
        $flag=$this->commonService->newInsertData($userData, $tableName);
       
        return $flag;         
    }
    
    public function saveUserProfession($data){
        $flag='';
        $tableName= TableName::USERPROFESSIONALMATRIMAONIALTABLE;
        $userData['profession'] = $data['profession'];
        $userData['created_date'] = date("Y-m-d H:i:s");
        $userData['user_id'] = $data['id'];
        $flag=$this->commonService->newInsertData($userData, $tableName);
        return $flag;  
    }

    public function getUserDetailsByMobile($mobile, $loginType=null){
           $data = $row= $row1= $row2= '';           
           $condition=['mobile_no'=>$mobile];
           if(null != $loginType){//var_dump($loginType); exit;
             $tableName = $this->commonService->getUserTableByLoginType($loginType);
                          //var_dump($tableName); exit;
             $row2=$this->commonService->newSelectSimpleData($tableName,$condition );
           } else{              //var_dump($condition); exit;
            $row = $this->commonService->newSelectSimpleData(TableName::USERMATRIMONIALTABLE,$condition );            
            $row1 = $this->commonService->newSelectSimpleData(TableName::USERTABLE,$condition );  
            }
           if(!empty($row) && !empty($row1)){
              $data=['loginType'=> WebServiceConstant::USEREXITINBOTH,'table'=>null];
            
            } elseif ($row) {
                $data = $row; 
                $data=  array_merge($data,['loginType'=> WebServiceConstant::USERMATRIMONIAL]);
             }elseif ($row1) {         
                $data = $row1;         
                $data=  array_merge($data,['loginType'=> WebServiceConstant::USERMEMBER]);
             }elseif($row2){
                 $data= $row2;
                 $data =  array_merge($data,['loginType'=> $loginType]);    
             }
                
                
         return $data ;
          
       }
       
       public function updatePassword($id,$mobile,$loginType,$password){
        $flag= false;
        try {           
            if($this->commonService->getUserByIdMobile($id,$mobile, $loginType)){    
            $tableName= $this->commonService->getUserTableByLoginType($loginType);
            $data=['password'=>$password];
            $condition=['mobile_no'=>$mobile]; 
            $this->commonService->newUpdateData($tableName, $data, $condition);
            $flag= true;
            }
          
        }catch (Exception $ex) {
            $ex->getTrace(); 
        }

        return $flag;
        
    }
    
    public function saveUserInfoMamber($data){
       $flag=false;  
        $tableName= TableName::USERINFOTABLE;        //var_dump($tableName);exit;
        $userInfo['name_title_user']=$data['userSalutation'];
        $userInfo['full_name']=$this->commonService->filterText($data['name']);
        $userInfo['last_name']=$this->commonService->filterText($data['lname']);
        $userInfo['dob']=date('Y-m-d',strtotime($data['dob']));
        $userInfo['nationality']=$data['nationality'];
        $userInfo['address']=$this->commonService->filterText($data['address']);
        $userInfo['country']=$data['country'];
        $userInfo['state']=$data['state'];
        $userInfo['city']=$data['city'];
        $userInfo['profession']=$data['profession'];
        $userInfo['profession_other']=isset($data['professionOther'])?$this->commonService->filterText($data['professionOther']):'';
        $userInfo['religion']=$data['religion'];
        $userInfo['religion_other']=isset($data['religionOther'])?$this->commonService->filterText($data['religionOther']):'';
        $userInfo['community']=$data['community'];
        $userInfo['community_other']=isset($data['communityOther'])?$this->commonService->filterText($data['communityOther']):'';
        $userInfo['caste']=$data['subCommunity'];
        $userInfo['caste_other']=isset($data['subCommunityOther'])?$this->commonService->filterText($data['subCommunityOther']):'';
        $userInfo['gothra_gothram']=$data['gotra'];
        $userInfo['gothra_gothram_other']=isset($data['gotraOther'])?$this->commonService->filterText($data['gotraOther']):'';
        $userInfo['branch_ids']=isset($data['branch'])?$this->commonService->filterText($data['branch']):'';
        //$userInfo['branch_ids']=$data['branch'];
        $userInfo['branch_ids_other']=isset($data['branchOther'])?$this->commonService->filterText($data['branchOther']):'';
        $userInfo['gender']=$data['gender'];
        $userInfo['user_id']=$data['id'];
        $userInfo['native_place']=$this->commonService->filterText($data['nativePlace']);
        $userInfo['ref_no']=$this->commonService->createReferenceNumberMatrimonial($userInfo['full_name'], $data['id']);
        $userInfo['referral_key']=$this->commonService->genRandomString();        //var_dump($userInfo); exit;
        $sql= new Sql($this->dbAdapter);
        $insert=$sql->insert($tableName);
        $insert->values($userInfo);
         $stmt= $sql->prepareStatementForSqlObject($insert);        // var_dump($stmt->getSql()); exit;    
         $result=$stmt->execute();
         $id=$result->getGeneratedValue();        // var_dump($id); exit;
         if($id){
         $tableLogin=$this->commonService->getUserTableByLoginType($data['loginType']);
         $userLoginData=['ref_no'=>$userInfo['ref_no'],'referral_key'=>$userInfo['referral_key']];
         $flag=$this->commonService->newUpdateData($tableLogin, $userLoginData, ['id'=>$data['id']]);         //var_dump($flag); exit;  
         $flag=$this->createFatherAsUser($id,$data);    
         }
         return $flag;
        
    }
    
    public function createFatherAsUser($id,$data){
        $flag=false;
        $tableName=$this->commonService->getUserTableByLoginType($data['loginType']);
        $email=$this->getDummyEmailId($id);
        $sql = new Sql($this->dbAdapter); 
        $userData['username'] = $this->getDummyUserName($data['fname']);
        $userData['password'] = md5($this->getDummyPassword($data['fname']));
        $userData['email'] = $email;
        $userData['mobile_no'] = $this->getDummyMobile();
        $userData['activation_key'] = md5($email);
        $remote = new RemoteAddress;
        $userData['ip'] = $remote->getIpAddress();
        $userData['created_date'] = date("Y-m-d H:i:s");
        $userData['Modified_Date'] = date("Y-m-d H:i:s");
        $userData['user_type_id']=  WebServiceConstant::USERMEMBERDUMMY;
        $userData['token']=$this->getToken($email);
        $userData['signup_status']=  WebServiceConstant::SIGNUPINUSER;
        $action = new Insert($tableName);       
        $action->values($userData);
        $stmt = $sql->prepareStatementForSqlObject($action);         
        $result = $stmt->execute();
        if ($result->getGeneratedValue()) {
                $dummyUserId= $result->getGeneratedValue();                //var_dump($dummyUserId); exit;
                $flag=$this->saveFatherAsUserInfo($data['id'], $dummyUserId,$data,$data['loginType']);
                $flag=$this->saveFamilyRelationShip($data['id'], $dummyUserId, WebServiceConstant::FATHER, WebServiceConstant::MALE );
            }
        return $flag;
        
        
    }
    
    public function getDummyUserName($data){
        $uniqueString=$this->commonService->getUniqueString();
        return $data.$uniqueString;
    }
    
    public function getDummyPassword($data){
        return $data.'@123';
   }
    
    public function getDummyEmailId($id){
        $uniqueString=$this->commonService->getUniqueString();
        return $id.$uniqueString.'@dummy.com';
    }
    
    public function getDummyMobile(){
       return $this->commonService->getUniqueString(); 
    }
    
    public function saveFatherAsUserInfo($createById, $dummyUserId,$data,$loginType){
        $tableName=$this->commonService->getUserInfoTableBYLoginType($loginType); 
        $userInfo['name_title_user']=$data['fatherSalutation'];
        $userInfo['full_name']=$this->commonService->filterText($data['fname']);
        $userInfo['last_name']=$this->commonService->filterText($data['flname']);
        $userInfo['created_by']=$createById;
        $userInfo['user_id']=$dummyUserId;  
        $userInfo['ref_no']=$this->commonService->createReferenceNumberMatrimonial($userInfo['full_name'], $dummyUserId);
        $userInfo['referral_key']=$this->commonService->genRandomString();
        $userInfo['native_place']=$this->commonService->filterText($data['nativePlace']);
        $sql= new Sql($this->dbAdapter);       // var_dump($this->commonService->filterText($data['nativePlace'])); exit;
        $action = new Insert($tableName);       
        $action->values($userInfo);
        $stmt = $sql->prepareStatementForSqlObject($action);       // var_dump( $userInfo,$stmt->getSql()); exit;      
        $result = $stmt->execute();        //var_dump($result); exit;
        $tableLogin=$this->commonService->getUserTableByLoginType($loginType);      //  var_dump($tableLogin); exit;
        $userLoginData=['ref_no'=>$userInfo['ref_no'],'referral_key'=>$userInfo['referral_key']];
        
        return $flag=$this->commonService->newUpdateData($tableLogin, $userLoginData, ['id'=>$dummyUserId]);    
        //var_dump($flag); exit;   
    }
    
    public function saveFamilyRelationShip($id, $dummyUserId, $relationType, $gender ){
      $flag=false;
      $data=$this->isUserExitInFamilyRelationship($id);  
      $tableName= TableName::USERFAMILYRELATION;
      switch ($relationType){
          case WebServiceConstant::FATHER:
              $familyRelation['father_id']=$dummyUserId;
              break;
          case WebServiceConstant::MOTHER:
              $familyRelation['mother_id']=$dummyUserId;
              break;
          case WebServiceConstant::WIFE:
              $familyRelation['mother_id']=$dummyUserId;
              break;
          case WebServiceConstant::HUSBAND:
              $familyRelation['mother_id']=$dummyUserId;
              break;
      }
      $familyRelation['gender']=$gender;        
      if($data){
        $flag=$this->commonService->newUpdateData($tableName, $familyRelation, ['user_id'=>$id]);   
      }else{
        $familyRelation['user_id']=$id;  
        $flag=$this->commonService->newInsertData($familyRelation, $tableName);        //var_dump($familyRelation, $id, $flag, $tableName); exit;      
      }
      return $flag;  
    }
    
    public function isUserExitInFamilyRelationship($id){
        return $this->commonService->newSelectSimpleData(TableName::USERFAMILYRELATION, ['user_id'=>$id]);
    }
}