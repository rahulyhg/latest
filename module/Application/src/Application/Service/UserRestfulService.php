<?php


namespace Application\Service;

use Application\Service\UserRestfulServiceInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Adapter; 
use Zend\Http\PhpEnvironment\RemoteAddress;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\Adapter\Driver\ResultInterface;
use Application\WebServiceConstant;
use Exception;





class UserRestfulService implements UserRestfulServiceInterface{
    protected $userRestfulMapper;
    protected $dbAdapter;
    protected $resultSet;
    private $castTable='tbl_caste';
    private $countryTable='tbl_country';
    private $stateTable='tbl_state';
    private $cityTable='tbl_city';
    private $professionTable='tbl_profession';
    private $familyMasterTable='tbl_family_master';
    private $familyInfoMatrimaonialTable='tbl_family_info_matrimonial';
    private $userInfoMatrimonialTable='tbl_user_info_matrimonial';
    private $userAddressMatrimonialTable='tbl_user_address_matrimonial';
    private $userProfessionalMatrimaonialTable='tbl_user_professional_matrimonial';
    private $userMatrimonialTable='tbl_user_matrimonial';
    private $postCategoryTable='tbl_post_category';
    

    public function __construct(AdapterInterface $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
        $this->resultSet = new ResultSet();
    }

    public function isUserExitDetails($loginEmail, $loginPassword ) {        
        $data = '';
        $sql = "SELECT * FROM tbl_user_matrimonial WHERE (mobile_no='$loginEmail' OR email= '$loginEmail') AND password='$loginPassword'";
     // $sql = "SELECT * FROM tbl_user WHERE (mobile_no='$login_email' OR email= '$login_email') AND password='$login_password'";
        $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();     
          if($row){
              $data = $row[0];
//               $sql = "SELECT * FROM tbl_user_matrimonial WHERE (mobile_no='$login_email' OR email= '$login_email') AND password='$login_password'";
//               $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
            
         }
         return $data ;
         
        
    }
    
    public function isUserActive($isActive){
        $status=false;
        if($isActive== 1 ){
            $status=true;
        }
       return $status;
      
    }
    
       
    

 
    public function resendOtp($userDetails ){       // var_dump($userDetails['username']); exit;
        $mobile=$userDetails['mobile_no'];
        $tableName= 'tbl_mobile';
        $loginType= WebServiceConstant::USERMEMBER;
        if(WebServiceConstant::USERMATRIMONIAL==$userDetails['loginType'] )
        {
            $tableName='tbl_mobile_matrimonial';
            $loginType= WebServiceConstant::USERMATRIMONIAL;
        }
  
        if($mobile){
           
            $code = rand(1111, 9999);
            date_default_timezone_set('Asia/Kolkata');
            $time = date('H:i');
            $sql="UPDATE $tableName SET code='$code', time='$time' WHERE mobile='$mobile'";            //var_dump($sql); exit;
            //exit;
            $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
            $this->sendAccountThanksSms($userDetails['username'], $mobile, $code);
            
            $data=['resp'=>2,'otpStatus'=>'otp sent','otpCode'=> $code,'loginType'=>$loginType];
            //return new JsonModel(array("resp" => 1, "message" => "otp sent"));
        }else{
             $data = ['resp'=>3,'otpStatus'=>'you are not authorise','otpCode'=>null,'loginType'=>null];
           //return new JsonModel(array("resp" => 0, "message" => "you are not authorise"));
        }
        
        return $data;
        
    }

  
    public function sendAccountThanksSms($userName, $mobileNumber, $code) {
        $view = new \Zend\View\Renderer\PhpRenderer();
        $resolver = new \Zend\View\Resolver\TemplateMapResolver();
        $resolver->setMap(array(
            'mailTemplate' => __DIR__ . '/../../../view/application/sms/accountThanksSms.phtml'
        ));
        $view->setResolver($resolver);
        $viewModel = new \Zend\View\Model\ViewModel();
        $viewModel->setTemplate('mailTemplate')->setVariables(array(
            'username' => $userName, 'code' => $code,
        ));
        $msg = $view->render($viewModel);
        file_put_contents("thanksSms.txt", $msg);
        
        $message="Hi+$userName,+Welcome+to+Rustagi,Thanks+for+Registration,+Please+complete+the+Registration+Formalities+OTP-$code+log+on+to+rustagisabha.com.+Or+Call+42424242";
        $url = "http://push3.maccesssmspush.com/servlet/com.aclwireless.pushconnectivity.listeners.TextListener?userId=helloalt&pass=helloalt&appid=helloalt&subappid=helloalt&msgtype=1&contenttype=1&selfid=true&to=$mobileNumber&from=Helocb&dlrreq=true&text=$message&alert=1";
     	$curl_handle = curl_init();    
        curl_setopt($curl_handle,CURLOPT_URL,$url);
        curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
        curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
        curl_exec($curl_handle);
        curl_close($curl_handle);
            

    }
    
    public function getDbAdapter(){
    
        return $this->dbAdapter;
        
    }
    
    public function sendResponse($msg){
    
           $view= new \Zend\View\Model\JsonModel();
           $view->setVariables($msg);
           $view->setTerminal(true);
           return $view;   
    }
    
    public function isUserNameExit($userName, $loginType){
       
        $flag = false;
          $tableName= $this->getUserTableByLoginType($loginType);       
         
          $sql = "SELECT * FROM $tableName WHERE username='$userName' ";
          $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();     
          if($row){
              $flag = true;
  
            }
                   
         return $flag ;
 
    }
    
    public function isUserEmailExit($email,$loginType){
         $flag = false;
         $tableName= $this->getUserTableByLoginType($loginType);
         
         $sql = "SELECT * FROM $tableName WHERE email='$email' ";
          $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();     
          if($row){
              $flag = true;
           }
        
         return $flag ;
    }
    
    public function isUserMobileExit($mobile, $loginType){
         $flag = false;
         $tableName= $this->getUserTableByLoginType($loginType);
         
          $sql = "SELECT * FROM $tableName WHERE mobile_no='$mobile' ";
          $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();     
          if($row){
              $flag = true;
           }
          
         return $flag ;
    }
    
   public function saveUser($data,$loginType){
       
        $tableName = $this->getUserTableByLoginType($loginType);
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
        $action = new Insert($tableName);       
        $action->values($userData);
        $stmt = $sql->prepareStatementForSqlObject($action);         
        $result = $stmt->execute();       
        if ($result instanceof ResultInterface) {
            if ($result->getGeneratedValue()) {
                return $result->getGeneratedValue();
            }
        }
       
   }
   
       public function getUserDetailsByMobile($mobile, $loginType=null){
           $data = $row= $row1= $row2= '';
           if(null != $loginType){
             $tableName = $this->getUserTableByLoginType($loginType);
             $sql = "SELECT * FROM $tableName WHERE mobile_no='$mobile'";//var_dump($sql); exit;
             $row2 = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray(); 
           
          } else{  
          $sql = "SELECT * FROM tbl_user_matrimonial WHERE mobile_no='$mobile' ";
          $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray(); 
          $sql1 = "SELECT * FROM tbl_user WHERE mobile_no='$mobile' ";
          $row1 = $this->dbAdapter->query($sql1, Adapter::QUERY_MODE_EXECUTE)->toArray(); 
          }
           if(!empty($row) && !empty($row1)){
              $data=['loginType'=> WebServiceConstant::USEREXITINBOTH,'table'=>null];
            
            } elseif ($row) {
                $data = $row[0]; 
                $data=  array_merge($data,['loginType'=> WebServiceConstant::USERMATRIMONIAL,'table'=>'tbl_user']);
             }elseif ($row1) {         
                $data = $row1[0];         
                $data=  array_merge($data,['loginType'=> WebServiceConstant::USERMEMBER,'table'=>'tbl_user_matrimonial']);
             }elseif($row2){
                 $data= $row2[0];
                 $data =  array_merge($data,['loginType'=> $loginType,'table'=>$tableName]);    
             }
                
                
         return $data ;
          
       }
       
    public function getTypeUser($loginEmail, $loginPassword){
        $data ='';
        $sql = "SELECT * FROM tbl_user WHERE (mobile_no='$loginEmail' OR email= '$loginEmail') AND password='$loginPassword'";
        $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();  
        $sql1 = "SELECT * FROM tbl_user_matrimonial WHERE (mobile_no='$loginEmail' OR email= '$loginEmail') AND password='$loginPassword'";
        $row1 = $this->dbAdapter->query($sql1, Adapter::QUERY_MODE_EXECUTE)->toArray();
          if(!empty($row) && !empty($row1)){
              $data=['loginType'=> WebServiceConstant::USEREXITINBOTH,'table'=>null];
           
         } elseif ($row) {
             $data = $row[0];
             $data=  array_merge($data,['loginType'=> WebServiceConstant::USERMEMBER,'table'=>'tbl_user']);
             
         
     }elseif ($row1) {         
         $data = $row1[0];         
         $data=  array_merge($data,['loginType'=> WebServiceConstant::USERMATRIMONIAL,'table'=>'tbl_user_matrimonial']);
         
            
        }
         return $data ;
           
       }
       
    public function getTypeUserByLogin($loginEmail, $loginPassword, $loginType){
           
        
        if(!in_array($loginType, [WebServiceConstant::USERMATRIMONIAL, WebServiceConstant::USERMEMBER])){
          $data ='';  
        }else{
        $table= 'tbl_user';
        $loginType= WebServiceConstant::USERMEMBER;
        if($loginType == WebServiceConstant::USERMATRIMONIAL){
            $table='tbl_user_matrimonial';
            $loginType= WebServiceConstant::USERMATRIMONIAL;
        
        }
      try {
        $sql = "SELECT * FROM $table WHERE (mobile_no='$loginEmail' OR email= '$loginEmail') AND password='$loginPassword'";
            $row  = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray(); 
            $data = $row[0];
            $data =  array_merge($data,['loginType'=> $loginType,'table'=>$table]);
            
            } catch (Exception $ex) {
            return $ex->getTrace();
            }
        }
            
        return $data;
         
         
       }
       
    public function  getUserTableByLoginType($loginType){
           $tableName='';
           $webServiceConstant= new WebServiceConstant();
           switch ($loginType){
               case WebServiceConstant::USERMATRIMONIAL:
                   $tableName= $webServiceConstant->userMappedTable[WebServiceConstant::USERMATRIMONIAL];
                   break;
               case WebServiceConstant::USERMEMBER:
                   $tableName=$webServiceConstant->userMappedTable[WebServiceConstant::USERMEMBER];
                   break;
               default :
                   $tableName='';
                   break;
           }  
           return $tableName;
       }
    public function  getMobileTableByLoginType($loginType){
           $tableName='';
           $webServiceConstant= new WebServiceConstant();
           switch ($loginType){
               case WebServiceConstant::USERMATRIMONIAL:
                   $tableName= $webServiceConstant->mobileMappedTable[WebServiceConstant::USERMATRIMONIAL];
                   break;
               case WebServiceConstant::USERMEMBER:
                   $tableName=$webServiceConstant->mobileMappedTable[WebServiceConstant::USERMEMBER];
                   break;
               default :
                   $tableName='';
                   break;
           }  
           return $tableName;
       }
       
    public function isVaildParamerter(array $receivedParam, $loginType=null){
         
        $flag= true;
        if(null != $loginType){
        $flag= $this->isVaildLoginType($loginType);    
        }
        if(!empty($receivedParam)){
            foreach ($receivedParam as $key){
                if(empty($key)){
                $flag= false;
                   break; 
                }

            }
        }
        
        return $flag;
        
    }
    
    public function isSameOtp($code,$loginType,$mobile){
        $flag= false;
        $tableName= $this->getMobileTableByLoginType($loginType);  
       
        $sql = "SELECT * FROM $tableName WHERE mobile='$mobile' AND code='$code'";
        $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
        if($row){
           $flag= true; 
        }
       
        return $flag;
    }
    
    public function sendMail($id,$loginType){
        $flag= false;
        $tableName= $this->getUserTableByLoginType($loginType);
        $sql = "SELECT * FROM $tableName WHERE id='$id'";
        $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
        if($row){
            
           //$this->sendSmtpMail($userData[0]['email'],$subject,$template,$data); 
        }
        
    }
    
    public function updatePassword($id,$mobile,$loginType,$password){
        $flag= false;
        try {
            if($this->getUserByIdMobile($id,$mobile, $loginType)){    
            $tableName= $this->getUserTableByLoginType($loginType);
            
            $sql = "UPDATE  $tableName SET password= '$password' WHERE mobile_no='$mobile' AND id='$id' ";        //var_dump($sql); exit;
            $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE);  
            $flag= true;
            }
          
        }catch (Exception $ex) {
            $ex->getTrace(); 
        }

        return $flag;
        
    }
    
    public function getUserByIdMobile($id,$mobile,$loginType){
        $data='';
        $tableName= $this->getUserTableByLoginType($loginType);
        if($tableName){
        $sql = "SELECT * FROM $tableName WHERE id='$id' AND mobile_no='$mobile'";
        $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
        if($row){
           $data=$row[0]; 
        }
        }
        return $data;
         
        
    }
    
    public function isVaildLoginType($loginType){
        $flag=false;
        if(WebServiceConstant::USERMATRIMONIAL==$loginType){
         $flag=true;   
        }elseif(WebServiceConstant::USERMEMBER== $loginType){
         $flag=true;   
        }
        
        return $flag;
    }
    
    public function getCast(){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','caste_name','is_active']);
       $select->where(['is_active'=>'1']);
       $select->from($this->castTable);
       $select->order('caste_name ASC');
       $statement= $sql->prepareStatementForSqlObject($select);
       $results= $statement->execute(); 
       $row=$results->getResource()->fetchAll();
//       $sql = "SELECT id, caste_name, is_active FROM $this->castTable WHERE is_active='1' ORDER BY caste_name ";       //var_dump($sql); exit;
//       $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();  
       if($row)
       {
        $data=$row[0];   
       }
       return $row;
    }
    
    public function getCountry(){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','country_name','is_active','order_val']);
       $select->where(['is_active'=>'1']);
       $select->from($this->countryTable);
       $select->order('order_val ASC');
       $statement= $sql->prepareStatementForSqlObject($select);
       $results= $statement->execute(); 
       $row=$results->getResource()->fetchAll();
//       $sql = "SELECT id, country_name, is_active, order_val FROM $this->countryTable WHERE is_active='1'  ORDER BY order_val ";       //var_dump($sql); exit;
//       $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();  
       if($row)
       {
        $data=$row[0];   
       }
       //var_dump($data); exit;
       return $row;
        
    }

    public function getProfession(){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','profession','is_active','order_val']);
       $select->where(['is_active'=>'1']);
       $select->from($this->professionTable);
       $select->order('profession ASC');
       $statement= $sql->prepareStatementForSqlObject($select);
       $results= $statement->execute(); 
       $row=$results->getResource()->fetchAll();
//       $sql = "SELECT id, profession, is_active, order_val FROM $this->professionTable WHERE is_active='1' ORDER BY profession";       
//       $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();  
       if($row)
       {
        $data=$row[0];   
       }
       return $row;  
    }
    
     public function getArrayDataFromObject($data){         //var_dump($data);exit;
        $arrData=[];         
         foreach ($data as $key=>$val){
               $arrData[$key]=$val;
           }
          // var_dump($arrData); exit;
           return $arrData;
     }
     
     public function isAllVaildParam(array $allParam, array $data, array $notMandParam = null ){
         $flag =true;
         foreach($allParam as $key)
           {   
             if($key =='loginType'){
                 
               $flag=$this->isVaildLoginType($data[$key]);
             }
               if(!array_key_exists($key, $data) || empty($data[$key]))
                {                               
                   if(in_array($key,$notMandParam))
                   { 
                       if(null!= $notMandParam){
                            foreach ($notMandParam as $param){

                                if(array_key_exists($param, $data))
                                {
                                    if(empty($data[$param]))
                                    {
                                        $flag=false;
                                        break;
                                    }
                                }
                            }
                       }
                         
                    }else{  
                        $flag=false;
                        break;
                    }
                       
                    
                   }
                
                
           }
          
           return $flag;
     }
     
     public function saveUserInfo(array $data, $loginType){
         $flag=false;
         if($loginType==WebServiceConstant::USERMEMBER){
        return;
             
         }elseif ($loginType==WebServiceConstant::USERMATRIMONIAL) {
             
             $flag=$this->saveUserInfoMatrimonial($data);             
             $flag=$this->saveFamilyInfoMatrimonial($data); 
             $flag=$this->saveUserMatrimonialAddress($data);
             $flag=$this->saveUserProfession($data);//var_dump($flag); exit;
              
             
         }
         return $flag;    
            
         
     }
     
     public function newInsertData($data ,$tableName){
         $flag =false;
         $sql = new Sql($this->dbAdapter);
         try{
         $insert= new Insert($tableName);
         $insert->values($data);
         $stmt= $sql->prepareStatementForSqlObject($insert);
         $stmt->execute();
         $flag=true;
         }
        catch (Exception $ex){
            return $ex;
          
        }
        return $flag;
         
     }
     
     public function saveFamilyInfoMatrimonial($data){ 
         $flag='';
        $tableName=$this->familyInfoMatrimaonialTable;
         if(isset($data['fname']) && !empty($data['fname'])){
                  
            $userData['title']= $data['fatherSalutation'];
            $userData['name']=$data['fname'];
            $userData['user_id'] = $data['id'];
            $userData['relation_id'] = WebServiceConstant::FATHER;
            $userData['created_date'] = date("Y-m-d H:i:s");
            $userData['Modified_Date'] = date("Y-m-d H:i:s");
            $flag=$this->newInsertData($userData, $tableName);
            
        } 
        return $flag;
     }
       
      public function saveUserInfoMatrimonial($data){
        $flag='';  
        $tableName=$this-> userInfoMatrimonialTable;
        $userData['name_title_user'] = $data['userSalutation'];
        $userData['full_name'] = $data['name'];
        $userData['ref_no'] = $this->createReferenceNumberMatrimonial($data['name'], $data['id']);
        $userData['referral_key']=$this->genRandomString();
        $userData['gender'] = $data['gender'];
        $userData['dob'] = $data['dob'];
        $userData['native_place'] = $data['nativePlace'];
        $userData['created_date'] = date("Y-m-d H:i:s");
        $userData['user_id'] = $data['id'];
        $flag=$this->newInsertData($userData, $tableName); 
        $flag=$this->updateTableField($userData['user_id'],'ref_no', $userData['ref_no'],$this->userMatrimonialTable);
        $flag=$this->updateTableField($userData['user_id'],'referral_key', $userData['referral_key'],$this->userMatrimonialTable);
        return $flag;
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
            $referenceNo = 'R'.$dateYear . $first . $last . $id;
        } else {
            $first = strtoupper(substr($full_nameArray[0], 0, 2));
            $referenceNo = 'R'.$dateYear . $first . $id;
        }
        return $referenceNo;
    }
    
    public function genRandomString() {
    $length = 10;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $string = '';    

    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }

    return $string;
    }
    
    public function updateTableField($id, $fieldName, $fieldVal,$tableName){
        $flag=false;
        $userData[$fieldName] = $fieldVal;        
        try{
            $sql = new Sql($this->dbAdapter);
            $action = new Update($tableName);
            $action->set($userData);
            $action->where(array('id' => $id));
            $stmt = $sql->prepareStatementForSqlObject($action);
            $stmt->execute();
            $flag=true;
        }  catch (Exception $ex){
            throw $ex;
        }
        return $flag;
    }
    
    public function saveUserMatrimonialAddress($data)
    {
        $flag='';    
        $tableName=$this->userAddressMatrimonialTable;
        $userData['address'] = $data['address'];
        $userData['country'] = $data['country'];
        $userData['state'] = $data['state'];
        $userData['city'] = $data['city'];
        $userData['created_date'] = date("Y-m-d H:i:s");
        $userData['user_id'] = $data['id'];
        $flag=$this->newInsertData($userData, $tableName);
       
        return $flag;         
    }
    
    public function saveUserProfession($data){
        $flag='';
        $tableName=$this->userProfessionalMatrimaonialTable;
        $userData['profession'] = $data['profession'];
        $userData['created_date'] = date("Y-m-d H:i:s");
        $userData['user_id'] = $data['id'];
        $flag=$this->newInsertData($userData, $tableName);
        return $flag;  
    }
    public function getStateByCountryId($id){
       $data=''; 
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','state_name','is_active']);
       $select->where(['is_active'=>'1', 'country_id'=>$id]);
       $select->from($this->stateTable);
       $select->order('city_name ASC');
       $statement= $sql->prepareStatementForSqlObject($select);
       $results= $statement->execute(); 
       $row=$results->getResource()->fetchAll();
//       $sql = "SELECT id, state_name, is_active FROM $this->stateTable WHERE is_active='1' AND country_id='$id'  ORDER BY state_name ";       //var_dump($sql); exit;
//       $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();      // var_dump($row); exit; 
       if($row)
       {
        $data=$row;   
       }
       
       return $data;  
    }
  
    public function getCityByStateId($id){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','city_name','is_active']);
       $select->where(['is_active'=>'1', 'state_id'=>$id]);
       $select->from($this->cityTable);
       $select->order('city_name ASC');
       $statement= $sql->prepareStatementForSqlObject($select);
       $results= $statement->execute(); 
       $row=$results->getResource()->fetchAll();    
//       $data=''; 
//       $sql = "SELECT id, city_name, is_active FROM $this->cityTable WHERE is_active='1' AND state_id='$id'  ORDER BY city_name ";       //var_dump($sql); exit;
//       $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();      // var_dump($row); exit; 
       if($row)
       {
        $data=$row;   
       }
       
       return $data;  
        
    }
    
    public function getCustomerDetailsById($loginId, $loginType){
 // ini_set('xdebug.var_display_max_depth', 100);
ini_set('xdebug.var_display_max_depth', 5);
ini_set('xdebug.var_display_max_children', 256);
ini_set('xdebug.var_display_max_data', 1024);
     $data='';
     if($loginType==WebServiceConstant::USERMATRIMONIAL){
//     $sql = "SELECT um. * , uim. * , uam. * , upm. * , city.city_name, state.state_name, country.country_name, cast.caste_name
//            FROM tbl_user_matrimonial um
//            LEFT JOIN tbl_user_info_matrimonial uim ON um.id = uim.user_id
//            LEFT JOIN tbl_user_address_matrimonial uam ON um.id = uam.user_id
//            LEFT JOIN tbl_user_professional_matrimonial upm ON um.id = upm.user_id
//            LEFT JOIN tbl_city city ON city.id = uam.city
//            LEFT JOIN tbl_state state ON state.id = uam.state
//            LEFT JOIN tbl_country country ON country.id = uam.country
//            LEFT JOIN tbl_caste cast ON cast.id = uim.caste
//            WHERE um.id =$loginId";       //var_dump($sql); exit;
//     
            $sql= new Sql($this->dbAdapter);
            $select= $sql->select(['um'=>$this->userMatrimonialTable]);
            $select->join(['uim'=>$this->userInfoMatrimonialTable],'um.id=uim.user_id','*',  'LEFT' );
            $select->join(['uam'=>$this->userAddressMatrimonialTable],'um.id=uam.user_id','*','LEFT');
            $select->join(['upm'=>$this->userProfessionalMatrimaonialTable],'um.id=upm.user_id','*','LEFT');
            $select->join(['city'=>$this->cityTable],'city.id=uam.city',['city_name'],'LEFT');
            $select->join(['state'=>$this->stateTable],'state.id=uam.state',['state_name'],'LEFT');
            $select->join(['country'=>$this->countryTable],'country.id=uam.country',['country_name'],'LEFT');
            $select->join(['caste'=>$this->castTable],'caste.id=uim.caste',['caste_name'],'LEFT');
            $select->where(['um.id'=>$loginId]);
            $statement= $sql->prepareStatementForSqlObject($select);
            $results= $statement->execute()->current();            ;
     }elseif (WebServiceConstant::USERMEMBER) {
//            $sql="SELECT u. * , ui. * , uam. * , up. * , city.city_name, state.state_name, country.country_name, cast.caste_name
//            FROM tbl_user u
//            LEFT JOIN tbl_user_info ui ON u.id = ui.user_id
//            LEFT JOIN tbl_user_address ua ON u.id = ua.user_id
//            LEFT JOIN tbl_user_professional up ON u.id = up.user_id
//            LEFT JOIN tbl_city city ON city.id = ua.city
//            LEFT JOIN tbl_state state ON state.id = ua.state
//            LEFT JOIN tbl_country country ON country.id = ua.country
//            LEFT JOIN tbl_caste cast ON cast.id = ui.caste
//            WHERE u.id =$loginId";
         
         // Above query not complete due table structure not defiend for member i,e tbl_user_address not exit.
        }
      // $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();      // var_dump($row); exit; 
       if($results)
       {
        $data=$results;   
       }
       
       
       return $data;  
        
    }

    public function getPostCategories(){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','category_name','is_active']);
       $select->where(['is_active'=>'1']);
       $select->from($this->postCategoryTable);
       $select->order('category_name ASC');
       $statement= $sql->prepareStatementForSqlObject($select);
       $results= $statement->execute(); 
       $row=$results->getResource()->fetchAll();         
       //$sql = "SELECT id, category_name, is_active FROM $this->postCategoryTable WHERE is_active='1'  ORDER BY category_name ";       
       //$row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();      
       if($row)
       {
        $data=$row;   
       }
     
       return $data;  
        
    }
    
   } 

