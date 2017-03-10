<?php

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Session\Container;


class PagesTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
//        $resultSet = $this->tableGateway->select();
//        $select->order('order_val ASC');
//        return $resultSet;
        
        $resultSet = $this->tableGateway->select(function(Select $select){
            $select->order('order_val ASC');
        });
        return $resultSet;
    }

    public function fetchAllActive() {
        $resultSet = $this->tableGateway->select(function(Select $select){
            $select->where('IsActive=1');
        });
        return $resultSet;
    }

    public function getPage($id) {
        $resultSet = $this->tableGateway->select(array('id'=>$id))->current();
        return $resultSet;
    }

     public function SavePages($pagesEntity)
    {      
        $pagesEntity['created_date'] = (empty($pagesEntity['created_date']))? date('Y-m-d h:i:s'):$pagesEntity['created_date'];
//        echo "<pre>";
//        print_r($pagesEntity['created_date']);exit;
                $pagesEntity['modified_date'] = (empty($pagesEntity['modified_date']))? date('Y-m-d h:i:s'):$usertypeEntity['modified_date'];
                
                $Cstatus = empty($pagesEntity['is_active']) ? 0 : 1;
                
    	$data = array(
            'title' => $pagesEntity['title'],
            'page_name' => $pagesEntity['page_name'],
            'description' => $pagesEntity['description'],
            'image' => $pagesEntity['image'],
    		'is_active' => $Cstatus,    		
    		'modified_by' => "1"
    		);
        if($pagesEntity['id']==0){
            //$resultSet = $this->tableGateway->insert($data);
            
             $dateData=array(
                 'created_date' => $pagesEntity['created_date'],
                 'modified_date' => $pagesEntity['modified_date'],
            );
            
            $dataInput= array_merge($data,$dateData);
            $result = $this->tableGateway->insert($dataInput);
            
            if ($result)
                return "success";
            else
                return "couldn't update";
        }
        else {
           if ($this->getPage($pagesEntity['id'])) {
                
            $dateData=array(
                 'modified_date' => $pagesEntity['modified_date'],
            );
            
            $dataUpdate= array_merge($data,$dateData);

                $result = $this->tableGateway->update($dataUpdate, array('id' => $pagesEntity['id']));
                
                if($pagesEntity['post_image_flag']==1){
            $image = PUBLIC_PATH . '/PagesImages/' . $pagesEntity['post_image_update'];
            $image_thumb = PUBLIC_PATH . '/PagesImages/thumb/100x100/' . $pagesEntity['post_image_update'];
            unlink($image);
            unlink($image_thumb);
            }
                
                
                if ($result)
                    return "success";
                else
                    return "couldn't update";
            } else {
                return "couldn't update";
                throw new \Exception('Users id does not exist');
            }
        }
        
    }


     public function updatestatus($data)
    {
        $changedata = array('is_active'=>$data->is_active);
        // return "dfgdgdfgd";
        $status = $this->tableGateway->update($changedata,array('id'=>$data->id));
            
        if($status){
            $respArr = array('status'=>"Updated SuccessFully");
        }   
            
        else $respArr = array('status'=>"Couldn't update");

        return $respArr;

    }

    // public function getUsertype($id) {
    //     $resultSet = $this->tableGateway->select(array('id'=>$id))->current();
    //     return $resultSet;
    // }

    // // public function getStatejoin($id) {
    // //     $resultSet = $this->tableGateway->select(function (Select $select) use($id){
    // //         $select->where(array('tbl_state.id'=>$id));
    // //         $select->join('tbl_country','tbl_state.country_id = tbl_country.id',array('country_name'));
    // //     })->current();

    // //     return $resultSet;
    // // }

    public function deletePage($id) {
        $resultSet = $this->tableGateway->delete(array('id'=>$id));
        return $resultSet;
    }

    // public function updateUsertype($uid,$utype) {
    //     $resultSet = $this->tableGateway->update($utype,array('user_id'=>$uid));
    //     if($resultSet){
    //         $respArr = array('status'=>"Updated SuccessFully");
    //     }   
            
    //     else $respArr = array('status'=>"Couldn't update");

    //     return $respArr;
    // }

    // public function SaveUsertype($usertypeEntity)
    // {
    // 	$usertypeEntity->created_date = (empty($usertypeEntity->created_date))? date('Y-m-d h:i:s'):$usertypeEntity->created_date;
    //             $usertypeEntity->modified_date = (empty($usertypeEntity->modified_date))? date('Y-m-d h:i:s'):$usertypeEntity->modified_date;

    // 	$data = array(
    //         'user_type' => $usertypeEntity->user_type,
    // 		'IsActive' => $usertypeEntity->IsActive,
    // 		'created_date' => $usertypeEntity->created_date,
    // 		'modified_date' => $usertypeEntity->modified_date,
    // 		'modified_by' => "1"
    // 		);
    //     if($usertypeEntity->id==0){
    //         $resultSet = $this->tableGateway->insert($data);
    //     }
    //     else {
    //         if ($this->getUsertype($usertypeEntity->id)) {


    //                 $this->tableGateway->update($data, array('id' => $usertypeEntity->id));

    //             } else {
    //                 throw new \Exception('Users id does not exist');
    //             }
    //     }
    // }

    //  public function customFields($columns)
    // {   
    //     $stateName = $this->tableGateway->select(function(Select $select) use($columns){
    //         $select->order('id ASC');
    //         $select->columns($columns);
    //     })->toArray();

    //     foreach ($stateName as $list) {
    //         $statenamelist[$list['id']] = $list['state_name'];
    //     }
    //     // print_r($statenamelist);die;
    //     return $statenamelist;
    // }

}
