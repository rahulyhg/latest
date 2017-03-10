<?php

namespace Common\Plugin;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class MyPlugin extends AbstractPlugin {

    protected $dbAdapter;

    public function __construct(Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    public function getCommunityMemberType($parent = 0, $userInfo, $level = 0) {
        $html = '';
        $sql = "SELECT * FROM tbl_communities WHERE parent_id=$parent";
        $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        foreach ($row as $row) {
            $current_id = $row->id;
  
            foreach ($userInfo as $userInfos) {
                //echo "<pre>";
                
                //print_r($userInfos['full_name']);
                if ($userInfos['comm_mem_id']==$current_id) {
                    echo $userInfos['full_name'];
                }
            }
            $html .=$row->category_name;
            $has_sub = NULL;
            $has_sub = $this->dbAdapter->query("SELECT COUNT(parent_id) FROM tbl_communities WHERE parent_id = $current_id", Adapter::QUERY_MODE_EXECUTE);
            if ($has_sub) {

                $html .= $this->getCommunityMemberType($current_id, $userInfo, $level + 1);
            }
        }

        return $html;
    }
    
    public function getCommunityMemberTypeRecursive($parent = 0, $level = 0) {
        $html = '';
        $sql = "SELECT * FROM tbl_communities WHERE parent_id=$parent";
        $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        foreach ($row as $row) {
            $current_id = $row->id;
            $html .=str_repeat("-", $level) .":".$level.":".$row->category_name .":".$row->id.",";
            $has_sub = NULL;
            $has_sub = $this->dbAdapter->query("SELECT COUNT(parent_id) FROM tbl_communities WHERE parent_id = $current_id", Adapter::QUERY_MODE_EXECUTE);
            if ($has_sub) {

                $html .= $this->getCommunityMemberTypeRecursive($current_id, $level + 1);
            }
        }

        return $html;
    }
    
    public function getUserInfoById($id){
         $sql = "SELECT tui.*, tu.email, tu.id FROM tbl_user_info as tui INNER JOIN tbl_user as tu
                ON  tui.user_id=tu.id WHERE tui.user_id=$id";
        $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
        return $row;
    }

//    public function getCommunityMemberType($parent = 0, $level = 0) {
//        $html = '';
//        $sql = "SELECT * FROM tbl_communities WHERE parent_id=$parent";
//        $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
//        foreach ($row as $row) {
//            $current_id = $row->id;
//            $html .=str_repeat("-", $level) . $row->category_name . "<br>";
//            $has_sub = NULL;
//            $has_sub = $this->dbAdapter->query("SELECT COUNT(parent_id) FROM tbl_communities WHERE parent_id = $current_id", Adapter::QUERY_MODE_EXECUTE);
//            if ($has_sub) {
//
//                $html .= $this->getCommunityMemberType($current_id, $level + 1);
//            }
//        }
//
//        return $html;
//    }
    
    public function checkUserActiveByLogin($login_email){
         $sql = "SELECT * FROM tbl_user WHERE (mobile_no='$login_email' OR email= '$login_email') AND is_active=1";
         $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
          if($row){
             return true;
         }else{
              $sql = "SELECT * FROM tbl_user_matrimonial WHERE (mobile_no='$login_email' OR email= '$login_email') AND is_active=1";
              $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
             if($row){
                 return true;
             }else{
                 return false;
             }
             
         }
        
    }
    
    public function checkUserActiveByLoginV1($login_email,$table){
         $sql = "SELECT * FROM $table WHERE (mobile_no='$login_email' OR email= '$login_email')";
         $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
          if($row){
             $userStatus="true";
             $userActiveStatus=$row['is_active'];
             $userSignupStatus=$row['signup_status'];
         }else{
             $userStatus="false";
             $userActiveStatus="";
             $userSignupStatus="";
         }
             
         return array("userStatus"=>$userStatus,"userActiveStatus"=>$userActiveStatus,"userSignupStatus"=>$userSignupStatus);  
        
    }
    
    public function getMobileByLoginCredentials($login_email,$table){
         $sql = "SELECT * FROM $table WHERE mobile_no='$login_email' OR email= '$login_email'";
         $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
          
         return $row;
       
        
    }
    
    public function checkUserExist($email){
         $sql = "SELECT * FROM tbl_user WHERE mobile_no=$email OR email= $email";
         $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
         if($row){
             return true;
         }else{
             return false;
         }
         
    }
    public function checkUserUsernamePassword_old($login_email, $password){
         $sql = "SELECT * FROM tbl_user WHERE (mobile_no='$login_email' OR email= '$login_email') AND password='$password'";
         $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
          if($row){
             return true;
         }else{
              $sql = "SELECT * FROM tbl_user_matrimonial WHERE (mobile_no='$login_email' OR email= '$login_email') AND password='$password'";
             $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
             if($row){
                  return true;
             }else{
                 return false;
             }
         }
        
    }
    
    public function checkUserUsernamePassword($login_email, $password){
         $sql = "SELECT * FROM tbl_user WHERE (mobile_no='$login_email' OR email= '$login_email') AND password='$password'";
         $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
          if($row){
             $userStatus="true";
             $userIdMember=$row['id'];
         }else{
             $userStatus="false";
             $userIdMember="";
         }
        $sql = "SELECT * FROM tbl_user_matrimonial WHERE (mobile_no='$login_email' OR email= '$login_email') AND password='$password'";
       $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();
       if($row){
            $userMatrimonialStatus="true";
            $userIdMatrimonial=$row['id'];
       }else{
           $userMatrimonialStatus="false";
           $userIdMatrimonial="";
       }
       return array("userStatus"=>$userStatus,"userMatrimonialStatus"=>$userMatrimonialStatus,"user_id_member"=>$userIdMember,"user_id_matrimonial"=>$userIdMatrimonial);  
    }
    
        public function checkUserTypeTable($login_email){
         $sql = "SELECT * FROM tbl_user WHERE (mobile_no='$login_email' OR email= '$login_email') AND is_active=1";
         $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
          if($row){
             return 'tbl_user';
         }else{
              $sql = "SELECT * FROM tbl_user_matrimonial WHERE (mobile_no='$login_email' OR email= '$login_email') AND is_active=1";
              $row = $this->dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
             if($row){
                 return 'tbl_user_matrimonial';
             }else{
                 return false;
             }
             
         }
        
    }
    
}
