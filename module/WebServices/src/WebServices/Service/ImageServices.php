<?php

namespace WebServices\Service;

use WebServices\Service\ImageServicesInterface; 
use WebServices\Service\UserServicesInterface;
use WebServices\Service\CommonServicesInterface;
use WebServices\Service\LoginServicesInterface;
use Zend\Db\Adapter\AdapterInterface;
use WebServices\Image;
use WebServices\WebServiceConstant;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Insert;
use PDO;

class ImageServices implements ImageServicesInterface{
    
    protected $dbAdapter;
    protected $loginService;
    protected $commonService;
    protected $userService;
    public function __construct(AdapterInterface $dbAdapter,
                                CommonServicesInterface $commonService,
                                LoginServicesInterface $loginService,
                                UserServicesInterface $userService ) {        //var_dump('jjj'); exit;
        
                                $this->dbAdapter=$dbAdapter;
                                $this->commonService= $commonService;
                                $this->loginService= $loginService; 
                                $this->userService= $userService;
    }
    
    public function userImageUpload(array $data, $imageType){      // die('dd'); var_dump($imageType); exit;
        $location=$id=$msg=null;
        $directoryName= Image::$directoryName[$imageType];
        if($this->isValidImages($data['image'])){
           $imageType=$this->getImageType($data['image']);
           $time=microtime(true);
           $arrtime= explode('.', $time);
           $time=$arrtime[0].$arrtime[1];
           if($data['loginType']==WebServiceConstant::USERMEMBER){
               $imageName= $data['id'].$time.'.'.$imageType;
               $folderName=$data['id'].'__Unknown';
               $path=getcwd().'/public/uploads/'.$folderName;               
               $file=$path.'/'.$imageName;
               
               if(!is_dir($path)){
                mkdir($path, Image::$folderPermissionMode[Image::WRITE], true);   
               // var_dump($path); exit;
              }
              if(!file_exists($file)){
                $location=$this->base64ToImage($data['image'], $file); 
                if($location){
                    $tableName=$this->commonService->getUserGallaryTableBYLoginType($data['loginType']);            // var_dump($tableName); exit;
                    $imgData['user_id']=$data['id'];
                    $imgData['ref_no']= $this->commonService->getRefernceNumberById($data['id'], $data['loginType']);;
                    $imgData['image_path']=$folderName.'/'.$imageName;
                    $imgData['img_relation']='self';
                    $imgData['profile_pic']= Image::USERPROFILEIMAGE;
                    $imgData['created_on'] = date("Y-m-d H:i:s");
                    $imgData['is_approved']=  WebServiceConstant::NOTAPPROVED;
                    $id=$this->newInsertImageData($imgData, $tableName);             //var_dump($flag); exit;
                    $msg=['imageId'=>$id, 'location'=>"$location"]; 
                }
               }
               
           }elseif($data['loginType']==WebServiceConstant::USERMATRIMONIAL){
            $imageName=  'mt'.$data['id'].$time.'.'.$imageType;
            $path= getcwd().'/public/'.$directoryName.'/';
            $file = $path.$imageName;
            if(!file_exists($file)){
            //$output_file = $path.$imageName.'.'.$imageType;
            //mkdir($path, Image::$folderPermissionMode[Image::WRITE], true);
            $location=$this->base64ToImage($data['image'], $file);           // var_dump($location); exit;
           if($location){
             $tableName=$this->commonService->getUserGallaryTableBYLoginType($data['loginType']);            // var_dump($tableName); exit;
             $imgData['user_id']=$data['id'];
             $imgData['user_type']=  WebServiceConstant::USERIMAGE;
             $imgData['image_name']=$imageName;
             $imgData['status']=1;
             $imgData['image_type']= Image::USERPROFILEIMAGE;
             $imgData['created_date'] = date("Y-m-d H:i:s");
             $imgData['modified_date']=date("Y-m-d H:i:s");
             $imgData['is_approved']=  WebServiceConstant::NOTAPPROVED;
             $id=$this->newInsertImageData($imgData, $tableName);             //var_dump($flag); exit;
             $msg=['imageId'=>$id, 'location'=>"$location"];
             
           }
            }
        }
        }
        return $msg;
  
    }
    
    public function isValidImages($image){
        $flag=  true;
        $pos  = strpos($image, ';');
        $images = explode(':', substr($image, 0, $pos))[1];
        $imageType= explode('/', $images)[1];
        $imageSize=strlen(base64_decode($image));
        if(!in_array($imageType, Image::$imageType) || $imageSize<=Ima){
          $flag=false;
        }
        return $flag;

    }
    
    public function getImageType($image){
        $pos  = strpos($image, ';');
        $images = explode(':', substr($image, 0, $pos))[1];
        return  explode('/', $images)[1];
        
    }

    public function base64ToImage($base64_string, $output_file) {
     $file = fopen($output_file, "wb");
     $data = explode(',', $base64_string);
     fwrite($file, base64_decode($data[1]));
     fclose($file);
     return $output_file;
 }
 
 public function userMultipleImageUpload(array $data, $imageType){
     
     if($data['loginType']==WebServiceConstant::USERMEMBER){
         $dataUpload=$this->uploadMultipleImageMember($data, $imageType);
     }elseif($data['loginType']==WebServiceConstant::USERMATRIMONIAL){
         $dataUpload= $this->uploadMultipleImageMatrimaonial($data, $imageType);
     }
        return $dataUpload;      
 }
 
 
 public function uploadMultipleImageMember($data, $imageType){
   $location= $invalidImage= $imagePathNotSavedInDb= $imageNotSaved= $imageupload= null;
        $directoryName= Image::$directoryName[$imageType];
        foreach ($data['image'] as $key){            //var_dump($data['image']); exit;      
                if($this->isValidImages($key)){
                $imageType=$this->getImageType($key);
                $time=microtime(true);
                $arrtime= explode('.', $time);
                $time=$arrtime[0].$arrtime[1];
                $imageName= $data['id'].$time.'.'.$imageType;
                $folderName=$data['id'].'__Unknown';
                $path=getcwd().'/public/uploads/'.$folderName;               
                $file=$path.'/'.$imageName;
                if(!is_dir($path)){
                mkdir($path, Image::$folderPermissionMode[Image::WRITE], true);   
                }
                if(!file_exists($file)){
                $location=$this->base64ToImage($key, $file);
                    if($location){
                      $tableName=$this->commonService->getUserGallaryTableBYLoginType($data['loginType']);            // var_dump($tableName); exit;
                        $imgData['user_id']=$data['id'];
                        $imgData['ref_no']= $this->commonService->getRefernceNumberById($data['id'], $data['loginType']);;
                        $imgData['image_path']=$folderName.'/'.$imageName;
                        $imgData['img_relation']='self';
                        $imgData['profile_pic']= Image::IMAGETYPEDEFAULT;
                        $imgData['created_on'] = date("Y-m-d H:i:s");
                        $imgData['is_approved']=  WebServiceConstant::NOTAPPROVED;
                        $id=$this->newInsertImageData($imgData, $tableName);             //var_dump($flag); exit;
                     
                         if(!$id){
                           $imagePathNotSavedInDb[]=['status'=> WebServiceConstant::IMAGEPATHNOTSAVED,'file'=>$key];     
                         }else{
                           $imageupload[]=['status'=>WebServiceConstant::UPDATEMSG,'imagePath'=>$location,'imageName'=>$imageName,'imageId'=>$id];
                         }
                    }else{
                        $imageNotSaved[]=['status'=>  WebServiceConstant::NOTUPDATEMSG,'file'=> $key];
                    }
            
            }else{
                $invalidImage[]=['status'=> WebServiceConstant::INVALIDIMAGEFORMAT,'file'=>$key,];
            }
            
        }
        }
        
        return $arrData=['imagePathNotSavedInDb'=>$imagePathNotSavedInDb,'imageNotSaved'=>$imageNotSaved,'imageInvalid'=>$invalidImage,'imageupload'=>$imageupload];  
 }

 



 public function uploadMultipleImageMatrimaonial($data, $imageType){
      $location= $invalidImage= $imagePathNotSavedInDb= $imageNotSaved= $imageupload= null;
        $directoryName= Image::$directoryName[$imageType];
        foreach ($data['image'] as $key){            //var_dump($data['image']); exit;      
                if($this->isValidImages($key)){
                $imageType=$this->getImageType($key);
                $time=microtime(true);
                $arrtime= explode('.', $time);
                $time=$arrtime[0].$arrtime[1];
                $imageName=  'mt'.$data['id'].$time.'.'.$imageType;
                $path= getcwd().'/public/'.$directoryName.'/';
                $file = $path.$imageName;
                $location=$this->base64ToImage($key, $file);
                    if($location){
                      $tableName=$this->commonService->getUserGallaryTableBYLoginType($data['loginType']);            // var_dump($tableName); exit;
                      $imgData['user_id']=$data['id'];
                      $imgData['user_type']=  WebServiceConstant::USERIMAGE;
                      $imgData['image_name']=$imageName;
                      $imgData['status']=1;
                      $imgData['image_type']= Image::IMAGETYPEDEFAULT;
                      $imgData['created_date'] = date("Y-m-d H:i:s");
                      $imgData['modified_date']=date("Y-m-d H:i:s");
                      $imgData['is_approved']=  WebServiceConstant::NOTAPPROVED;
                      $id=$this->newInsertImageData($imgData, $tableName);   
                         if(!$id){
                           $imagePathNotSavedInDb[]=['status'=> WebServiceConstant::IMAGEPATHNOTSAVED,'file'=>$key];     
                         }else{
                           $imageupload[]=['status'=>WebServiceConstant::UPDATEMSG,'imagePath'=>$location,'imageName'=>$imageName,'imageId'=>$id];
                         }
                    }else{
                        $imageNotSaved[]=['status'=>  WebServiceConstant::NOTUPDATEMSG,'file'=> $key];
                    }
            
            }else{
                $invalidImage[]=['status'=> WebServiceConstant::INVALIDIMAGEFORMAT,'file'=>$key,];
            }
        }
        
        return $arrData=['imagePathNotSavedInDb'=>$imagePathNotSavedInDb,'imageNotSaved'=>$imageNotSaved,'imageInvalid'=>$invalidImage,'imageupload'=>$imageupload];
 }

 

 public function newInsertImageData($data ,$tableName){
         $id ='';
         $sql = new Sql($this->dbAdapter);
         try{
         $insert= new Insert($tableName);
         $insert->values($data);
         $stmt= $sql->prepareStatementForSqlObject($insert);
         $result=$stmt->execute(); 
         $id=$result->getGeneratedValue();   
 
         
         }
        catch (\Exception $ex){
            return $ex;
          
        }
        return $id;
         
     }
     
      public function userProfileImageHardDelete(array $data, $loginType){
          $tableName=$this->commonService->getUserGallaryTableBYLoginType($loginType); 
         //var_dump($data['imageId'],$tableName,$loginType); exit;
          $imageDeleted=$imageDatabaseEnrtyNotDelete=$imageDirectoryNotDelete=null;
          foreach ($data['imageId'] as $key){
              $condition=['id'=>$key];
              $imageData=$this->commonService->newSelectSimpleData($tableName, $condition);
              $path=$this->getProfileImagePath(Image::USERPROFILEIMAGE);
              $fileName=$path.$imageData['image_name'];
              if($this->unlinkFile($fileName)){
                if($this->commonService->deleteOnRequest($tableName, $condition))
                {
                    $imageDeleted[]=['status'=>'fileDelete', 'id'=>$key];
                }else{
                  $imageDatabaseEnrtyNotDelete[]=['status'=>'fileNotDelete', 'id'=>$key];      
                }
              }else{
                  $imageDirectoryNotDelete[]=['status'=>'fileNotDelete', 'id'=>$key];
              }
                
      }
      return $msg=['imageDatabaseEnrtyNotDelete'=>$imageDatabaseEnrtyNotDelete,'imageDirectoryNotDelete'=>$imageDirectoryNotDelete, 'imageDeleted'=>$imageDeleted ];
      }

      public function unlinkFile($fileName){          //var_dump($fileName); exit;
          $flag=false;
          if(file_exists($fileName)){              //var_dump($fileName); exit;
              unlink($fileName);
              $flag=true;
          }
          return $flag;
      }
      
      public function getProfileImagePath($imagePath){
           $directoryName= Image::$directoryName[$imagePath];         //  var_dump($directoryName); exit;
           $path= PUBLIC_PATH.'/'.$directoryName.'/';           //var_dump($path); exit;
            return $path;
      }
      
      
      public function userProfileImageSoftDelete(array $data, $loginType){
         $tableName=$this->commonService->getUserGallaryTableBYLoginType($loginType); 
         //var_dump($data['imageId'],$tableName,$loginType); exit;
          $deletedImage=$notDeletedImage=null;
          foreach ($data['imageId'] as $key){
              $condition=['id'=>$key];
                            
              if($this->commonService->newUpdateData($tableName,['is_delete'=>  Image::SOFTDELETE], $condition)){
                $deletedImage[]=$key;   
              }else{
                $notDeletedImage[]=$key;   
              }
             
                
      }
      return $msg=['deletedImage'=>$deletedImage,'notDeletedImage'=>$notDeletedImage ];
       
      }
      
      public function getUserImages($id, $loginType){
          $tableName=$this->commonService->getUserGallaryTableBYLoginType($loginType);
          $predicate=['user_id'=>$id,'is_delete'=>Image::NOTSOFTDELETE];
          $sql= new Sql($this->dbAdapter);
          $select= $sql->select($tableName);
          $select->columns(['image_name']);
          $select->where($predicate);
          $statement=$sql->prepareStatementForSqlObject($select);
          $results= $statement->execute();
          $rows=$results->getResource()->fetchAll(PDO::FETCH_ASSOC);         
          $path=$this->getProfileImagePath(Image::USERPROFILEIMAGE);
          return $msg=['data'=>$rows, 'path'=>$path];
          
      }
}

