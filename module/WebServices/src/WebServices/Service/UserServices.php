<?php

namespace WebServices\Service;

use WebServices\Service\UserServicesInterface;
use WebServices\Service\CommonServicesInterface;
use WebServices\Service\LoginServicesInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use WebServices\WebServiceConstant;
use WebServices\TableName;
use Zend\Http\PhpEnvironment\RemoteAddress;

class UserServices implements UserServicesInterface{
     
    protected $dbAdapter;
    protected $loginService;
    protected $commonService;
    public function __construct(AdapterInterface $dbAdapter,
                                CommonServicesInterface $commonService,
                                LoginServicesInterface $loginService) { 
        $this->commonService= $commonService;
        $this->dbAdapter=$dbAdapter;
        $this->loginService= $loginService; 
    }
    
  public function getCustomerDetailsById($id, $loginType){
 // ini_set('xdebug.var_display_max_depth', 100);
        ini_set('xdebug.var_display_max_depth', 5);
        ini_set('xdebug.var_display_max_children', 256);
        ini_set('xdebug.var_display_max_data', 1024);
     $data='';
     $sql= new Sql($this->dbAdapter);
     if($loginType==WebServiceConstant::USERMATRIMONIAL){
            
            $select= $sql->select(['um'=>  TableName::USERMATRIMONIALTABLE]);
            $select->join(['uim'=>  TableName::USERINNFOMATRIMONIALTABLE],'um.id=uim.user_id','*',  'LEFT' );
            $select->join(['uam'=>  TableName::USERADDRESSMATRIMONIALTABLE],'um.id=uam.user_id','*','LEFT');
            $select->join(['upm'=>  TableName::USERPROFESSIONALMATRIMAONIALTABLE],'um.id=upm.user_id','*','LEFT');
            $select->join(['city'=>  TableName::CITYTABLE],'city.id=uam.city',['city_name'],'LEFT');
            $select->join(['state'=>  TableName::STATETABLE],'state.id=uam.state',['state_name'],'LEFT');
            $select->join(['country'=>  TableName::COUNTRYTABLE],'country.id=uam.country',['country_name'],'LEFT');
            $select->join(['caste'=>  TableName::CASTETABLE],'caste.id=uim.caste',['caste_name'],'LEFT');
            $select->where(['um.id'=>$id]);
            $statement= $sql->prepareStatementForSqlObject($select);
            $results= $statement->execute()->current();            ;
     }elseif (WebServiceConstant::USERMEMBER) {         //var_dump($id); exit;
            $select= $sql->select(['u'=>  TableName::USERTABLE]);
            $select->join(['ui'=>  TableName::USERINFOTABLE],'u.id=ui.user_id','*',  'LEFT' );
            $select->where(['u.id'=>$id]);
            $statement= $sql->prepareStatementForSqlObject($select);            //var_dump($statement->getSql()); exit;
            $results= $statement->execute()->current();   
          }
      if($results)
       {
        $data=$results;   
       }
     
       return $data;  
        
    }
    
        public function getProfilePercentage($id, $loginType) {
        $percentage='';
        $tableName=$this->commonService->getUserInfoTableBYLoginType($loginType);
        $data=$this->commonService->newSelectSimpleData($tableName, ['user_id'=>$id]);
        $totalfields = count($data);
        $webServiceConstant= new WebServiceConstant();
        $arr= $webServiceConstant->profileExculdeParam;
        $c = 0;
        foreach ($data as $key => $value) {
            if (in_array($key, $arr))
                continue;
            if (!empty($value))
                $c++;
           
        }
        $percentage = ceil(($c / $totalfields) * 100);
    
        return $percentage; 
    }
    
    
    public function setAboutYourSelf($id, $loginType, $msg){
        
        $tableName=$this->commonService->getUserInfoTableBYLoginType($loginType);
        $data=$this->commonService->filterText($msg);
        
       
        if(WebServiceConstant::USERMEMBER){
            $userInfo['about_yourself_partner_family']=$data; 
        }elseif (WebServiceConstant::USERMATRIMONIAL) {
           $userInfo['about_yourself']=$data;  
        }
        return $this->commonService->newUpdateData($tableName, $userInfo, ['user_id'=>$id]);
      
    }
    
    public function setPhysicalDetails($id, $loginType,$data){
       
        $tableName=$this->commonService->getUserInfoTableBYLoginType($loginType);
        $userInfo['height']=$data['height'];
        $userInfo['body_type']=$data['bodyType'];
        $skinTone =  isset($data['skinTone'])?$data['skinTone']:'';
        $userInfo['skin_tone']=$skinTone;
        $userInfo['any_disability']=$data['anyDisability'];
        $bloodGroup =  isset($data['bloodGroup'])?$data['bloodGroup']:'';
        $userInfo['blood_group']=$bloodGroup;
        $bodyWeight =  isset($data['bodyWeight'])?$data['bodyWeight']:'';
        $userInfo['body_weight']=$bodyWeight;
        $weightType =  isset($data['weightType'])?$data['weightType']:'';
        $userInfo['body_weight_type']=$weightType;
        return $this->commonService->newUpdateData($tableName, $userInfo, ['user_id'=>$id]);
         
    }
    
    public function setPersonalDetails($id, $loginType,$data){
       $tableName=$this->commonService->getUserInfoTableBYLoginType($loginType);
        
        $userInfo['marital_status']=$data['maritalStatus'];
        $alternativeMobile =  isset($data['alternativeMobile'])?$data['alternativeMobile']:'';
        $userInfo['alternate_mobile_no']=$alternativeMobile;
        $haveChildren =  isset($data['haveChildren'])?$data['haveChildren']:'';
        $userInfo['children']=$haveChildren; 
        $numberOfChildren =  isset($data['numberOfChildren'])?$data['numberOfChildren']:'';
       if($loginType==WebServiceConstant::USERMEMBER){
        $userInfo['no_of_childs']=$numberOfChildren;  
        }elseif($loginType==WebServiceConstant::USERMATRIMONIAL){
        
        $userInfo['no_of_kids']=$numberOfChildren;  
        }
       
        
        return $this->commonService->newUpdateData($tableName, $userInfo, ['user_id'=>$id]);
         
    }
    public function setAstroDetails($id, $loginType,$data){
        $tableName=$this->commonService->getUserInfoTableBYLoginType($loginType);
        $userInfo['birth_place']=$data['birthPlace'];
        $userInfo['birth_time']=isset($data['birthTime'])?date("H:i:s", strtotime($data['birthTime'])):'';
        $userInfo['zodiac_sign_raasi']=$data['zodiacSign'];
        $userInfo['star_sign']=$data['nakshatra'];
        $userInfo['manglik_dossam']=isset($data['manglikDosham'])?$data['manglikDosham']:'';
        return $this->commonService->newUpdateData($tableName, $userInfo, ['user_id'=>$id]); 
    }
    
    public function setReligiousBackgroundDetails($id, $loginType,$data){
        $tableName=$this->commonService->getUserInfoTableBYLoginType($loginType);
        $userInfo['religion']=$data['religion'];
        $gothraGothram =  isset($data['gothraGothram'])?$data['gothraGothram']:'';
        $userInfo['gothra_gothram']=$gothraGothram;
        $gothraGothramOther =  isset($data['gothraGothramOther'])?$data['gothraGothramOther']:'';
        $userInfo['gothra_gothram_other']=$gothraGothramOther;
        $userInfo['mother_tongue_id']=$data['motherTongue'];
        $relgionOther =  isset($data['relgionOther'])? $this->commonService->filterText($data['relgionOther']):'';
        $userInfo['religion_other']=$relgionOther;
        return $this->commonService->newUpdateData($tableName, $userInfo, ['user_id'=>$id]); 
    }
    
    public function setLifeStyleDetails($id, $loginType,$data){
        $tableName=$this->commonService->getUserInfoTableBYLoginType($loginType);
        $userInfo['religion']=$data['religion'];
        $drink =  isset($data['drink'])?$data['drink']:'';
        $userInfo['drink']=$drink;
        $smoke =  isset($data['smoke'])?$data['smoke']:'';
        $userInfo['smoke']=$smoke;
        $diet =  isset($data['diet'])?$data['diet']:'';
        $userInfo['meal_preference']=$diet;
        return $this->commonService->newUpdateData($tableName, $userInfo, ['user_id'=>$id]);  
    }
    
    public function setEducationCarrier($id, $loginType,$data){
        $flag=false;
        if($loginType==WebServiceConstant::USERMATRIMONIAL){
        $tableName=$this->commonService->getUserEducationTableByLoginType($loginType);
      //  $allParam=['id','loginType','token','educationLevel','educationLevelOther','educationField', 'educationFieldOther', 'workingWith','designation','designationOther','profession','professionOther', 'annualIncome'];
        $userEducation['user_id']=$data['id'];
        $userEducation['education_level_id']=$data['educationLevel'];
       // $educationLevelOther =  
        $userEducation['education_level_other']=isset($data['educationLevelOther'])? $this->commonService->filterText($data['educationLevelOther']):'';
        $userEducation['education_field_id']=$data['educationField'];
       // $educationFieldOther =  
        $userEducation['education_field_other']= isset($data['educationFieldOther'])?  $this->commonService->filterText($data['educationFieldOther']):'';
        $userEducation['created_date']=date("Y-m-d H:i:s");
        $tableProfession=$this->commonService->getUserProfessionTableByLoginType($loginType);
        $userProfession['employer']=$data['workingWith'];
       // $workingWithOther=
        $userProfession['employer_other']=isset($data['workingWithOther'])?  $this->commonService->filterText($data['workingWithOther']):'';
        $userProfession['user_id']=$data['id'];
        $userProfession['designation']=$data['designation'];
        //$designationOther =  
        $userProfession['designation_other']= isset($data['designationOther'])?  $this->commonService->filterText($data['designationOther']):'';
        $userProfession['profession']=$data['profession'];
       // $professionOther =  
        $userProfession['profession_other']= isset($data['professionOther'])?  $this->commonService->filterText($data['professionOther']):'';
        $userProfession['annual_income']=$data['annualIncome'];
        $userProfession['annual_income_status']=$data['annualIncomeStatus'];
        $userProfession['created_date']=date("Y-m-d H:i:s");       // var_dump($userProfession,$tableProfession); exit;
        $this->commonService->newInsertData($userEducation, $tableName);
        $flag= $this->commonService->newInsertData($userProfession, $tableProfession);  
        }elseif($loginType==WebServiceConstant::USERMEMBER){
          $tableName=  TableName::USERINFOTABLE;
          $userInfo['education_level']=$data['educationLevel'];; 
          $userInfo['education_level_other']=isset($data['educationLevelOther'])? $this->commonService->filterText($data['educationLevelOther']):'';
          $userInfo['education_field']=$data['educationField'];
          $userInfo['education_field_other']=isset($data['educationLevelOther'])? $this->commonService->filterText($data['educationLevelOther']):'';
          $userInfo['working_with']=$data['workingWith'];
          $userInfo['working_with_other']=isset($data['workingWithOther'])?  $this->commonService->filterText($data['workingWithOther']):'';
          $userInfo['designation']=$data['designation'];
          $userInfo['designation_other']= isset($data['designationOther'])?  $this->commonService->filterText($data['designationOther']):'';
          $userInfo['profession']=$data['profession'];
          $userInfo['profession_other']= isset($data['professionOther'])?  $this->commonService->filterText($data['professionOther']):'';
          $userInfo['annual_income']=$data['annualIncome'];
          $userInfo['annual_income_status']=$data['annualIncomeStatus'];
          $flag=$this->commonService->newUpdateData($tableName, $userInfo, ['user_id'=>$data['id']]);
        }
        return $flag;
        }
    
    public function setCompanyDetails($id, $loginType,$data){
        $flag=false;
        $tableName=$this->commonService->getUserProfessionTableByLoginType($loginType);    
      //  $allParam=['id','loginType','token','cname','cemail','country','state', 'city', 'address','contactNumber','pincode','cwebsite'];
        foreach($data as $key=>$val){
          $data[$key]= $this->commonService->filterText($val);
        }
        $userProfession['office_name']=$data['cname'];
        $userProfession['office_email']=$data['cemail'];
        $userProfession['office_address']=$data['address'];
        $userProfession['office_country']=$data['country'];
        $userProfession['office_state']=$data['state'];
        $userProfession['office_city']=$data['city'];
        $userProfession['office_pincode']=$data['pincode'];
        $userProfession['office_phone']=$data['contactNumber'];
        $userProfession['office_website']=$data['cwebsite'];
        $professionData=$this->commonService->newSelectSimpleData($tableName, ['user_id'=>$id]);
        if($professionData){
          $flag=$this->commonService->newUpdateData($tableName, $userProfession, ['user_id'=>$id]);      
        }else{
            $userProfession['user_id']=$id;
          $flag= $this->commonService->newInsertData($userProfession, $tableName);  
        }
        return $flag;
    }
    public function setParentDetails($id, $loginType,$data){
        $flag=false;
        $tableName=$this->commonService->getUserInfoTableBYLoginType($loginType);
        $userInfo['family_values_status']=$data['fvalue'];
        $userInfo['mother_tongue_id']=$data['motherTongue'];
        $flag=$this->commonService->newUpdateData($tableName, $userInfo, ['user_id'=>$id]);
        if($loginType==WebServiceConstant::USERMEMBER){
           $flag=$this->saveUserFatherDetailsAsCreatedMember($id, $loginType,$data);
           $flag=$this->saveUserMotherDetailsAsCreatedMember($id, $loginType,$data);
        }
        elseif($loginType==WebServiceConstant::USERMATRIMONIAL){
       
        $flag= $this->saveUserFamilyInfoFatherDetails($id, $loginType, $data);
        $flag= $this->saveUserFamilyInfoMotherDetails($id, $loginType, $data);
        }
        return $flag; 
    }
    
    public function isUserFamilyInfoByRelationIdDetailsExit($id, $loginType, $relationId){
       $data='';
       $tableName=$this->commonService->getUserFamilyInfoTableByLoginType($loginType); 
       $row= $this->commonService->newSelectSimpleData($tableName, ['user_id'=>$id,'relation_id'=>$relationId]);
       if($row){
           $data=$row['id'];
       }
       return $data;
    }
    
    public function saveUserFamilyInfoFatherDetails($id, $loginType,$data){
       $flag=false;
       $relationId=  WebServiceConstant::FATHER;
       $remote = new RemoteAddress;
       $familyInfoId=$this->isUserFamilyInfoByRelationIdDetailsExit($id, $loginType, $relationId);
       $tableName=$this->commonService->getUserFamilyInfoTableByLoginType($loginType); 
       $userFamily['ip'] = $remote->getIpAddress(); 
       $userFamily['relation_id']= $relationId ;
       $fdob= isset($data['fdob'])?date('Y-m-d',strtotime($data['fdob'])):'';
       $userFamily['dob']=$fdob;
       $userFamily['status']=$data['fstatus'];
       $fdod= isset($data['fdod'])?date('Y-m-d',strtotime($data['fdod'])):'';
       $userFamily['dod']=$fdod;
       $userFamily['about']=$this->commonService->filterText($data['fabout']);
      if($familyInfoId){         
         $flag= $this->commonService->newUpdateData($tableName, $userFamily, ['id'=>$familyInfoId]);
       }else{
           $userFamily['user_id']=$id; 
           $userFamily['created_date']=date("Y-m-d H:i:s");
           $flag= $this->commonService->newInsertData($userFamily, $tableName);
       }
       return $data;
    }
    
    public function saveUserFamilyInfoMotherDetails($id, $loginType,$data){
       $flag=false;
       $relationId=  WebServiceConstant::MOTHER;
       $remote = new RemoteAddress;  
       $familyInfoId=$this->isUserFamilyInfoByRelationIdDetailsExit($id, $loginType, $relationId);
       $tableName=$this->commonService->getUserFamilyInfoTableByLoginType($loginType); 
       $userFamily['relation_id']= $relationId ;
        $userFamily['ip'] = $remote->getIpAddress();
       $userFamily['title']=$data['msalutation'];
        $userFamily['name']=$data['mname'];
        $userFamily['last_name']=$data['mlname'];
        $mdob= isset($data['mdob'])?date('Y-m-d',strtotime($data['mdob'])):'';
        $userFamily['dob']=$mdob;
        $userFamily['status']=$data['mstatus'];
        $mdod= isset($data['mdod'])?date('Y-m-d',strtotime($data['mdod'])):'';
        $userFamily['dod']=$mdod;
        $userFamily['about']=$this->commonService->filterText($data['mabout']);
     if($familyInfoId){
         $flag= $this->commonService->newUpdateData($tableName, $userFamily, ['id'=>$familyInfoFatherId]);
       }else{
           $userFamily['user_id']=$id; 
           $userFamily['created_date']=date("Y-m-d H:i:s");
           $flag= $this->commonService->newInsertData($userFamily, $tableName);
       }
       return $data;
    }

    public function setBrotherDetails($id, $loginType,$data){
        $flag=false;
        $tableName=$this->commonService->getUserFamilyInfoTableByLoginType($loginType); 
        $remote = new RemoteAddress;       
        foreach ($data['brother'] as $key=>$val){            
        $userFamily['user_id']=$id;   
        $userFamily['ip'] = $remote->getIpAddress();
        $userFamily['title']=$val['bsalutation'];
        $userFamily['name']=$val['bname'];
        $userFamily['relation_id']=  WebServiceConstant::BROTHER;
        $userFamily['last_name']=$val['blname'];
        $bdob= isset($val['bdob'])?date('Y-m-d',strtotime($val['bdob'])):'';
        $userFamily['dob']=$bdob;
        $userFamily['status']=$val['bstatus'];
        $bdod= isset($val['bdod'])?date('Y-m-d',strtotime($val['bdod'])):'';
        $userFamily['dod']=$bdod;
        $userFamily['about']=$this->commonService->filterText($val['babout']);
        $userFamily['marital_status']= $val['bmatrialStatus'];
        $userFamily['created_date']=date("Y-m-d H:i:s");
        $flag= $this->commonService->newInsertData($userFamily, $tableName);   
        } 
        return $flag;
    }
    
    public function setSisterDetails($id, $loginType,$data){
        $flag=false;
        $tableName=$this->commonService->getUserFamilyInfoTableByLoginType($loginType); 
        $remote = new RemoteAddress;       
        foreach ($data['sister'] as $key=>$val){            
        $userFamily['user_id']=$id;   
        $userFamily['ip'] = $remote->getIpAddress();
        $userFamily['title']=$val['ssalutation'];
        $userFamily['name']=$val['sname'];
        $userFamily['relation_id']=  WebServiceConstant::SISTER;
        $userFamily['last_name']=$val['slname'];
        $sdob= isset($val['sdob'])?date('Y-m-d',strtotime($val['sdob'])):'';
        $userFamily['dob']=$sdob;
        $userFamily['status']=$val['sstatus'];
        $sdod= isset($val['sdod'])?date('Y-m-d',strtotime($val['sdod'])):'';
        $userFamily['dod']=$sdod;
        $userFamily['about']=$this->commonService->filterText($val['sabout']);
        $userFamily['marital_status']= $val['smatrialStatus'];
        $userFamily['created_date']=date("Y-m-d H:i:s");
        $flag= $this->commonService->newInsertData($userFamily, $tableName);   
        } 
        return $flag;
    }
    public function saveUserFatherDetailsAsCreatedMember($id, $loginType,$data){
        $this->isUserFatherMemberDetailsExiting($id, $loginType);
    }
    
    public function isUserFatherMemberDetailsExiting($id, $loginType){
        $tableName= TableName::FAMILYMASTERTABLE;
        $data=$this->commonService->newSelectSimpleData($tableName, ['user_id'=>$id]);
        if($data[]){
            
        }
    }
}

