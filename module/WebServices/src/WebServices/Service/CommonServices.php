<?php

namespace WebServices\Service;
use WebServices\Service\CommonServicesInterface;
use Zend\Db\Adapter\AdapterInterface;
use WebServices\WebServiceConstant;
use WebServices\TableName;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Insert;
use PDO;

class CommonServices implements CommonServicesInterface {

    protected $dbAdapter;
    public function __construct(AdapterInterface $dbAdapter) {       
        $this->dbAdapter=$dbAdapter;
    }
    
     public function getArrayDataFromObject($data){         
        $arrData=[];         
         foreach ($data as $key=>$val){
               $arrData[$key]=$val;
           }
          
         return $arrData;
     }
     
     public function isAllVaildParam(array $allParam, array $data, array $notMandParam = null ){
         $flag =true;         //var_dump($allParam,$data,$notMandParam );     
         foreach($allParam as $key)
           {   
             if($key =='loginType'){
                 
               $flag=$this->isVaildLoginType($data[$key]);              // var_dump($flag, $key); exit;
             }
             if($key=='token')
             {                // var_dump($flag);exit;            
               $flag= $this->isTokenExit($data[$key],$data['loginType'],$data['id']);               //var_dump($data[$key], $key,$flag,$data['id']); exit;  
             } //var_dump($key,$data,$data[$key]); exit;
               if(!array_key_exists($key, $data) || empty($data[$key]))
                {        //  var_dump($key, $notMandParam); exit;                      
                   if(in_array($key,$notMandParam))
                   {                      
                       if(null != $notMandParam){                                                    
                            foreach ($notMandParam as $param){

                                if(array_key_exists($param, $data))
                                {
                                    if(empty($data[$param]))
                                    {//var_dump($key);
                                                                                
                                        $flag=false;
                                        break;
                                    }
                                }else{
                                    $flag=true;
                                }
                            }
                       }
                         
                    }else{
                       $flag=false;
                       break;
                    }
                       
                    
                   }
                  
                
           }
          // var_dump($flag);exit;
           return $flag;
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
     public function isUserNameExit($userName, $loginType,$id=null){
       
          $flag = false;
          $tableName= $this->getUserTableByLoginType($loginType);       
          $sql= new Sql($this->dbAdapter);
          $select= $sql->select();
          $select->where(['username'=>$userName]);
          $select->from($tableName);
          $statement= $sql->prepareStatementForSqlObject($select); //var_dump($statement->getSql());exit;
          $results= $statement->execute();          
          $row=$results->current();
          if($row){
              $flag = true;
  
            }
          if($id!=null){
            if($row['id']===$id){
                $flag=false;
            }  
          }  
     
         return $flag ;
 
    }
    
    public function isUserEmailExit($email,$loginType,$id=null){
          $flag = false;
          $tableName= $this->getUserTableByLoginType($loginType);       
          $sql= new Sql($this->dbAdapter);
          $select= $sql->select();
          $select->where(['email'=>$email]);
          $select->from($tableName);
          $statement= $sql->prepareStatementForSqlObject($select); //var_dump($statement->getSql());exit;
          $results= $statement->execute();          
          $row=$results->current();          //var_dump($row); 
          if($row){
              $flag = true;
           }
         if($id!=null){             
            if($row['id']===$id){
                $flag=false;
            }  
          }
         return $flag ;
    }
    
    public function isUserMobileExit($mobile, $loginType,$id=null){
         $flag = false;
          $tableName= $this->getUserTableByLoginType($loginType);       
          $sql= new Sql($this->dbAdapter);
          $select= $sql->select();
          $select->where(['mobile_no'=>$mobile]);
          $select->from($tableName);
          $statement= $sql->prepareStatementForSqlObject($select); //var_dump($statement->getSql());exit;
          $results= $statement->execute();          
          $row=$results->current();
          if($row){
              $flag = true;
           }
          if($id!=null){
            if($row['id']===$id){
                $flag=false;
            }  
          } 
         return $flag ;
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
    public function getUserInfoTableBYLoginType($loginType){
        //var_dump($loginType); exit;
            $tableName='';
           $webServiceConstant= new WebServiceConstant();
           switch ($loginType){
               case WebServiceConstant::USERMATRIMONIAL: //var_dump("ddddd"); exit;
                   $tableName= $webServiceConstant->userInfoMappedTable[WebServiceConstant::USERMATRIMONIAL]; 
                           //$userInfoMappedTable[WebServiceConstant::USERMATRIMONIAL];
                   
                   break;
               case WebServiceConstant::USERMEMBER:
                   $tableName=$webServiceConstant->userInfoMappedTable[WebServiceConstant::USERMEMBER];
                   //$userInfoMappedTable[WebServiceConstant::USERMEMBER];
                   break;
               default :
                   $tableName='';
                   break;
           }  
        
           return $tableName;
        
    }

    public function getUserGallaryTableBYLoginType($loginType){
        //var_dump($loginType); exit;
            $tableName='';
           $webServiceConstant= new WebServiceConstant();
           switch ($loginType){
               case WebServiceConstant::USERMATRIMONIAL: //var_dump("ddddd"); exit;
                   $tableName= $webServiceConstant->userGallaryMappedTable[WebServiceConstant::USERMATRIMONIAL]; 
                           //$userInfoMappedTable[WebServiceConstant::USERMATRIMONIAL];
                   
                   break;
               case WebServiceConstant::USERMEMBER:
                   $tableName=$webServiceConstant->userGallaryMappedTable[WebServiceConstant::USERMEMBER];
                   //$userInfoMappedTable[WebServiceConstant::USERMEMBER];
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
      public function sendResponse($msg){
    
           $view= new \Zend\View\Model\JsonModel();
           $view->setVariables($msg);
           $view->setTerminal(true); 
           return $view;   

    }
    public function getCountry(){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','country_name','is_active','order_val']);
       $select->where(['is_active'=>'1']);
       $select->from(TableName::COUNTRYTABLE);
       $select->order('order_val ASC');
       $statement= $sql->prepareStatementForSqlObject($select);
       $results= $statement->execute(); 
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);
      if($row)
       {
        $data=$row;   
       }
      return $row;
        
    }

    public function getProfession(){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','profession','is_active','order_val']);
       $select->where(['is_active'=>'1']);
       $select->from(TableName::PROFESSIONTABLE);
       $select->order('profession ASC');
       $statement= $sql->prepareStatementForSqlObject($select);
       $results= $statement->execute(); 
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);
       if($row)
       {
        $data=$row;   
       }
       return $row;  
    }
    
    public function getStateByCountryId($id){
       
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','state_name','is_active']);
       $select->where(['is_active'=>'1', 'country_id'=>$id]);
       $select->from(TableName::STATETABLE);
       $select->order('state_name ASC');
       $statement= $sql->prepareStatementForSqlObject($select);
       $results= $statement->execute(); 
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);       
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
       $select->from(TableName::CITYTABLE);
       $select->order('city_name ASC');
       $statement= $sql->prepareStatementForSqlObject($select);
       $results= $statement->execute(); 
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);    
     if($row)
       {
        $data=$row;   
       }
       
       return $data;  
        
    }

    public function getCaste(){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','caste_name','is_active']);
       $select->where(['is_active'=>'1']);
       $select->from(TableName::CASTETABLE);
       $select->order('caste_name ASC');
       $statement= $sql->prepareStatementForSqlObject($select);
       $results= $statement->execute(); 
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);
       if($row)
       {
        $data=$row;   
       }
       return $row;
    }

     public function getPostCategories(){
       $data='';      // var_dump('dddd'); exit;
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','category_name','is_active']);
       $select->where(['is_active'=>'1']);
       $select->from(TableName::POSTCATEGORYTABLE);
       $select->order('category_name ASC');
       $statement= $sql->prepareStatementForSqlObject($select);       //var_dump($statement->getSql()); exit;
       $results= $statement->execute(); 
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);      // var_dump($row); exit;     
        if($row)
        {
         $data=$row;   
        }
     
       return $data;  
       
    }
    
    public function getNationality(){
      $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','nationality_name','is_active']);
       $select->where(['is_active'=>'1']);
       $select->from(TableName::NATIONALITYTABLE);
       $select->order('nationality_name ASC');
       $statement= $sql->prepareStatementForSqlObject($select);       //var_dump($statement->getSql()); exit;
       $results= $statement->execute(); 
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);       //var_dump($row); exit;     
        if($row)
        {
         $data=$row;   
        }
     
       return $data;    
    }
    public function getGothraGothram(){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','caste_id','gothra_name','is_active']);
       $select->where(['is_active'=>'1']);
       $select->from(TableName::GOTHRAGOTHRAMTABLE);
       $select->order('gothra_name ASC');
       $statement= $sql->prepareStatementForSqlObject($select);       //var_dump($statement->getSql()); exit;
       $results= $statement->execute(); 
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);       //var_dump($row); exit;     
        if($row)
        {
         $data=$row;   
        }
     
       return $data;
    }
    public function getGothraGothramByCastId($castId){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','caste_id','gothra_name','is_active']);
       $select->where(['caste_id'=>$castId,'is_active'=>'1']);
       $select->from(TableName::GOTHRAGOTHRAMTABLE);
       $select->order('gothra_name ASC');
       $statement= $sql->prepareStatementForSqlObject($select);       //var_dump($statement->getSql()); exit;
       $results= $statement->execute(); 
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);       //var_dump($row); exit;     
        if($row)
        {
         $data=$row;   
        }
     
       return $data;
    }
    public function getRefferalKeyByRefferal($refferalKey, $loginType){
        $tableName= $this->getUserTableByLoginType($loginType);
        $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['referral_key','id','is_active']);
       $select->where(['referral_key'=>$refferalKey,'is_active'=>'1']);
       $select->from($tableName);
     //  $select->order('gothra_name ASC');
       $statement= $sql->prepareStatementForSqlObject($select);      // var_dump($statement->getSql()); exit;
       $results= $statement->execute(); 
             //var_dump($row); exit; 
       $row=$results->current();
        if($row)
        {
         $data=$row;   
        }
     
       return $data;
        
    }
    
      public function updateTableField($id, $fieldName, $fieldVal,$tableName){
        $flag=false;
        $userData[$fieldName] = $fieldVal;        //var_dump($userData);      
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
    
     public function resendOtp($userDetails){         
        $mobile=$userDetails['mobile_no'];
       if(WebServiceConstant::USERMATRIMONIAL==$userDetails['loginType'] )
        {
            $tableName=  TableName::MOBILEMATRIMONIALTABLE;
            $loginType= WebServiceConstant::USERMATRIMONIAL;
        }else{
            $tableName= TableName::MOBILETABLE;
            $loginType= WebServiceConstant::USERMEMBER;
        }
        if($mobile){
            $code = rand(1111, 9999);
            date_default_timezone_set('Asia/Kolkata');
            $time = date('H:i');
            $sql= new Sql($this->dbAdapter);
            $update= $sql->update($tableName);
            $update->set(['code'=>$code, 'time'=>$time])
                    ->where(['mobile'=>$mobile]);
            $sql->prepareStatementForSqlObject($update)->execute();
            $this->sendAccountThanksSms($userDetails['username'], $mobile, $code);
            $data=['resp'=>2,'otpStatus'=>'otp sent','otpCode'=> $code,'loginType'=>$loginType];
       
        }else{
             $data = ['resp'=>5,'otpStatus'=>'you are not authorise','otpCode'=>null,'loginType'=>null];
         }
        
        return $data;
        
    }
    
    public function sendOtp($mobile, $loginType){        //var_dump($mobile,$loginType); exit;
        $otp='';
        $tableName=$this->getMobileTableByLoginType($loginType); 
        $code = rand(1111, 9999);
            date_default_timezone_set('Asia/Kolkata');
            $userDetails=$this->getUserDetailsByMobile($mobile,$loginType);           // var_dump($userDetails); exit;
            $data['user_id']=$userDetails['id'];
            $data['time']= date('H:i');
            $data['mobile']=$mobile;
            $data['code']=$code;            //var_dump($tableName, $data); exit;
            if($this->newInsertData($data, $tableName)){
             $this->sendAccountThanksSms($userDetails['username'], $mobile, $code);
                // var_dump('ddddddddd');
                 $otp= $code;  
             
            }
        return $otp;
            
    }
  
    public function sendAccountThanksSms($userName, $mobileNumber, $code) {        
        $view = new \Zend\View\Renderer\PhpRenderer();
        $resolver = new \Zend\View\Resolver\TemplateMapResolver();
        $resolver->setMap(array(
            'mailTemplate' => getcwd().'/module/Application/view/application/sms/accountThanksSms.phtml'
        ));
       // var_dump(getcwd().'/module/Application/view/application/sms/accountThanksSms.phtml');exit;
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

     public function newUpdateData($tableName, array $data , array $condition){
         $flag=false;
          try{
         $sql= new Sql($this->dbAdapter);
         $update= $sql->update();
         $update->table($tableName)->set($data)->where($condition);         //var_dump($update); exit;
         $stmt = $sql->prepareStatementForSqlObject($update);         //var_dump($stmt->getSql()); exit;
          $stmt->execute();       //  var_dump($stmt); exit;        
         $flag=true;
          }catch (\Exception $ex){
            throw false;
        }
        return $flag;
         
     }
    public function newInsertData($data ,$tableName){
         $flag =false;
         $sql = new Sql($this->dbAdapter);
         try{
         $insert= new Insert($tableName);
         $insert->values($data);
         $stmt= $sql->prepareStatementForSqlObject($insert);        // var_dump($data,$stmt->getSql());exit;
         $stmt->execute();
         $flag=true;
         }
        catch (\Exception $ex){            // var_dump($ex); exit;
            return false;
          //$flag =false;
        }
        return $flag;
         
     }
     
     public function newSelectSimpleData($tableName, array $condition){
         $data='';
                  //var_dump($condition); exit;
         try{
         $sql= new Sql($this->dbAdapter);
         $select=$sql->select();
         $select->from($tableName)->where($condition);
         $stmt=$sql->prepareStatementForSqlObject($select);        // var_dump($stmt->getSql()); exit;
         $data= $stmt->execute()->current();
         }  catch (Exception $ex){
             return false;
         }
         return $data;
     }
      
   public function getTokenByLoginId($id,$loginType){
       $data = '';
          $tableName= $this->getUserTableByLoginType($loginType);       
          $sql= new Sql($this->dbAdapter);
          $select= $sql->select();
          $select->columns(['token']);
          $select->where(['id'=>$id]);
          $select->from($tableName);
          $statement= $sql->prepareStatementForSqlObject($select); //var_dump($statement->getSql());exit;
          $results= $statement->execute();          
          $row=$results->current();          //var_dump('cc', $row['token']); exit;
          if($row){
              $data = $row['token'];
           }
          
         return $data ; 
   } 
   
   public function isTokenExit($token, $loginType,$id){
       
          $flag = false;
          $tableName= $this->getUserTableByLoginType($loginType);       
          $sql= new Sql($this->dbAdapter);
          $select= $sql->select();
         // $select->columns(['token']);
          $select->where(['token'=>$token, 'id'=>$id]);
          $select->from($tableName);
          $statement= $sql->prepareStatementForSqlObject($select); //var_dump($statement->getSql());exit;
          $results= $statement->execute();          
          $row=$results->current();
          if($row){
              $flag = true;
           }
          
         return $flag ; 
       
   }
   
       public function isSameOtp($code,$loginType,$mobile,$actionType){
        $flag= false;
        $tableName= $this->getMobileTableByLoginType($loginType); 
        $condition=['mobile'=>$mobile,'code'=>$code];
        $row= $this->newSelectSimpleData($tableName, $condition);        //var_dump($row); exit;
//        $sql = "SELECT * FROM $tableName WHERE mobile='$mobile' AND code='$code'";
//        $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
        if($row){
           $flag= true; 
        if($actionType==WebServiceConstant::SIGNUPACTION){
           $table= $this->getUserTableByLoginType($loginType);
           $data=['is_active'=>'1','signup_status'=>  WebServiceConstant::OTPVERIFYED];
           $condition=['mobile_no'=>$mobile];
           $this->newUpdateData($table, $data, $condition);
        }
           
        }
       
        return $flag;
    }

//    public function getUserByIdMobile($id, $mobile, $loginType) {
//        
//    }

        public function getUserByIdMobile($id,$mobile,$loginType){
        $data='';
        $tableName= $this->getUserTableByLoginType($loginType);
        if($tableName){
         $condition=['id'=>$id,'mobile_no'=>$mobile];   
        $row= $this->newSelectSimpleData($tableName, $condition);    
//        $sql = "SELECT * FROM $tableName WHERE id='$id' AND mobile_no='$mobile'";
//        $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
        if($row){
           $data=$row; 
        }
        }
        return $data;
         
        
    }
    
     public function getUserDetailsByMobile($mobile,$loginType){
        $data='';
        $tableName= $this->getUserTableByLoginType($loginType);
        if($tableName){
         $condition=['mobile_no'=>$mobile];   
        $row= $this->newSelectSimpleData($tableName, $condition);    
        if($row){
           $data=$row; 
        }
        }
        return $data;
         
        
    }
    
    public function getMobileNumberById($id,$loginType){
         $data='';
        $tableName= $this->getUserTableByLoginType($loginType);
        if($tableName){
         $condition=['id'=>$id];   
        $row= $this->newSelectSimpleData($tableName, $condition);    
//        $sql = "SELECT * FROM $tableName WHERE id='$id' AND mobile_no='$mobile'";
//        $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
        if($row){
           $data=$row['mobile_no']; 
        }
        }
        return $data; 
    }
     
    public function deleteOnRequest($table, $condition){
        
        $sql= new Sql($this->dbAdapter);
        $delete=$sql->delete();
        $delete->from($table)
                ->where($condition);
        $sql->prepareStatementForSqlObject($delete)->execute();
        return true;
               
    }
    
    public function filterText($data){
        $filterStrip= new \Zend\Filter\StripTags();
        $data=$filterStrip->filter($data);
        $filterTrim= new \Zend\Filter\StringTrim();
        $data= $filterTrim->filter($data);
        return $data;
               
    }
    
    public function getHeight(){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','height','is_active']);
       $select->where(['is_active'=>'1']);
       $select->from(TableName::HEIGHTTABLE);
       $select->order('id ASC');
       $statement= $sql->prepareStatementForSqlObject($select);       //var_dump($statement->getSql()); exit;
       $results= $statement->execute(); 
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);       //var_dump($row['0']); exit;     
        if($row)
        {
         $data=$row;   
        }
     
       return $data;  
    }
    
    public function getZodiacSigns(){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','zodiac_sign_name','is_active']);
       $select->where(['is_active'=>'1']);
       $select->from(TableName::ZODIACSIGNSRASSITABLE);
       $select->order('order_val ASC');
       $statement= $sql->prepareStatementForSqlObject($select);       //var_dump($statement->getSql()); exit;
       $results= $statement->execute(); 
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);       //var_dump($row['0']); exit;     
        if($row)
        {
         $data=$row;   
        }
     
       return $data;  
    }
    
    public function getNakshatra(){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','star_sign_name','is_active']);
       $select->where(['is_active'=>'1']);
       $select->from(TableName::STARSIGNTABLE);
       $select->order('star_sign_name ASC');
       $statement= $sql->prepareStatementForSqlObject($select);       //var_dump($statement->getSql()); exit;
       $results= $statement->execute(); 
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);       //var_dump($row['0']); exit;     
        if($row)
        {
         $data=$row;   
        }
     
       return $data;  
    }
    
    public function getReligion(){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','religion_name','is_active']);
       $select->where(['is_active'=>'1']);
       $select->from(TableName::RELIGIONTABLE);
       $select->order('order_val ASC');
       $statement= $sql->prepareStatementForSqlObject($select);       
       $results= $statement->execute();      
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);          
        if($row)
        {
         $data=$row;   
        }
     
       return $data;  
    }
    
    public function getMotherTongue(){
      $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','mother_tongue','is_active']);
       $select->where(['is_active'=>'1']);
       $select->from(TableName::MOTHERTONGUETABLE);
       $select->order('mother_tongue ASC');
       $statement= $sql->prepareStatementForSqlObject($select);       
       $results= $statement->execute();      
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);          
        if($row)
        {
         $data=$row;   
        }
     
       return $data;    
    }
    
    public function getEducationLevel(){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','education_level','is_active']);
       $select->where(['is_active'=>'1']);
       $select->from(TableName::EDUCATIONLEVELTABLE);
       $select->order('education_level ASC');
       $statement= $sql->prepareStatementForSqlObject($select);       
       $results= $statement->execute();      
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);          
        if($row)
        {
         $data=$row;   
        }
     
       return $data;   
    }
    public function getEducationField(){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','education_field','is_active']);
       $select->where(['is_active'=>'1']);
       $select->from(TableName::EDUCATIONFIELDTABLE);
       $select->order('education_field ASC');
       $statement= $sql->prepareStatementForSqlObject($select);       
       $results= $statement->execute();      
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);          
        if($row)
        {
         $data=$row;   
        }
     
       return $data;    
    }
    
    public function getDesignation(){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','designation','is_active']);
       $select->where(['is_active'=>'1']);
       $select->from(TableName::DESIGNATIONTABLE);
       $select->order('designation ASC');
       $statement= $sql->prepareStatementForSqlObject($select);       
       $results= $statement->execute();      
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);          
        if($row)
        {
         $data=$row;   
        }
     
       return $data;  
    }
    
    public function getAnnualIncome(){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','annual_income','is_active']);
       $select->where(['is_active'=>'1']);
       $select->from(TableName::ANNUALINCOMETABLE);
       $select->order('id ASC');
       $statement= $sql->prepareStatementForSqlObject($select);       
       $results= $statement->execute();      
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);          
        if($row)
        {
         $data=$row;   
        }
     
       return $data;  
    }
    public function getCommunity(){
     $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','religion_id','community_name','is_active']);
       $select->where(['is_active'=>'1']);
       $select->from(TableName::COMMUNITYTABLE);
       $select->order('community_name ASC');
       $statement= $sql->prepareStatementForSqlObject($select);       
       $results= $statement->execute();      
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);          
        if($row)
        {
         $data=$row;   
        }
     
       return $data;    
    }
    
     public function getCommunityByReligionId($religionId){ //die('ff');
     $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','religion_id','community_name','is_active']);
       $select->where(['is_active'=>'1','religion_id'=>$religionId]);
       $select->from(TableName::COMMUNITYTABLE);
       $select->order('community_name ASC');
       $statement= $sql->prepareStatementForSqlObject($select);       
       $results= $statement->execute();      
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);          
        if($row)
        {
         $data=$row;   
        }
     
       return $data;    
    }
    
    public function getSubCommunityByCommunityId($communityId){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','community_id','caste_name','is_active']);
       $select->where(['is_active'=>'1','community_id'=>$communityId]);
       $select->from(TableName::CASTETABLE);
       $select->order('caste_name ASC');
       $statement= $sql->prepareStatementForSqlObject($select);       
       $results= $statement->execute();      
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);          
        if($row)
        {
         $data=$row;   
        }
     
       return $data;    
    }

    public function getGotraBySubCommunityId($subCommunityId){
       $data=''; 
       $sql= new Sql($this->dbAdapter);
       $select= $sql->select();
       $select->columns(['id','caste_id','gothra_name','is_active']);
       $select->where(['is_active'=>'1','caste_id'=>$subCommunityId]);
       $select->from(TableName::GOTHRAGOTHRAMTABLE);
       $select->order('gothra_name ASC');
       $statement= $sql->prepareStatementForSqlObject($select);       
       $results= $statement->execute();      
       $row=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);          
        if($row)
        {
         $data=$row;   
        }
     
       return $data; 
    }
    public function getUserProfessionTableByLoginType($loginType){
      $tableName='';
           $webServiceConstant= new WebServiceConstant();
           switch ($loginType){
               case WebServiceConstant::USERMATRIMONIAL:
                   $tableName= $webServiceConstant->userProfessionMappedTable[WebServiceConstant::USERMATRIMONIAL];
                   break;
               case WebServiceConstant::USERMEMBER:
                   $tableName=$webServiceConstant->userProfessionMappedTable[WebServiceConstant::USERMEMBER];
                   break;
               default :
                   $tableName='';
                   break;
           }  
           return $tableName;  
    }
    
    public function getUserEducationTableByLoginType($loginType){
        $tableName='';
           $webServiceConstant= new WebServiceConstant();
           switch ($loginType){
               case WebServiceConstant::USERMATRIMONIAL:
                   $tableName= $webServiceConstant->userEducationMappedTable[WebServiceConstant::USERMATRIMONIAL];
                   break;
               case WebServiceConstant::USERMEMBER:
                   $tableName=$webServiceConstant->userEducationMappedTable[WebServiceConstant::USERMEMBER];
                   break;
               default :
                   $tableName='';
                   break;
           }  
           return $tableName; 
    }
    
    public function getUserFamilyInfoTableByLoginType($loginType){
        $tableName='';
           $webServiceConstant= new WebServiceConstant();
           switch ($loginType){
               case WebServiceConstant::USERMATRIMONIAL:
                   $tableName= $webServiceConstant->userFamilyInfoMappedTable[WebServiceConstant::USERMATRIMONIAL];
                   break;
               case WebServiceConstant::USERMEMBER:
                   $tableName=$webServiceConstant->userFamilyInfoMappedTable[WebServiceConstant::USERMEMBER];
                   break;
               default :
                   $tableName='';
                   break;
           }  
           return $tableName; 
    }
    
    public function getUserReferalKeyUsedTableByLoginType($loginType){
          $tableName='';
           $webServiceConstant= new WebServiceConstant();
           switch ($loginType){
               case WebServiceConstant::USERMATRIMONIAL:
                   $tableName= $webServiceConstant->userReferalKeyUsedMappedTable[WebServiceConstant::USERMATRIMONIAL];
                   break;
               case WebServiceConstant::USERMEMBER:
                   $tableName=$webServiceConstant->userReferalKeyUsedMappedTable[WebServiceConstant::USERMEMBER];
                   break;
               default :
                   $tableName='';
                   break;
           }  
           return $tableName; 
    }
    
    public function getUniqueString(){
        $time=microtime(true);
        $arrtime= explode('.', $time);
        return $time=$arrtime[0].$arrtime[1];
    }
    public function getRefernceNumberById($id, $loginType){
        $data='';
        $tableName=$this->getUserTableByLoginType($loginType);
        $sql= new Sql($this->dbAdapter);
        $select=$sql->select($tableName);
        $select->columns(['ref_no']);
        $select->where(['id'=>$id]);
        $statement=$sql->prepareStatementForSqlObject($select);
        $result= $statement->execute()->current();        //var_dump($result); exit;
        if($result){
         $data=$result['ref_no'];   
        }
       return $data;         
    }
}       
