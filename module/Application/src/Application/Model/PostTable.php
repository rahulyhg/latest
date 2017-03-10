<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;
use Zend\Session\Container;


class PostTable extends AbstractTableGateway {

    protected $table = 'tbl_post';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }

    public function fetchAll($data='')
    {
        $row = $this->select();
        if (!$row)
            return false;
         
        return $row;
    }

    public function savePost($entity='')
    {
                // print_r($entity);die;

                $entity->created_date = (empty($entity->created_date))? date('Y-m-d h:i:s'):$entity->created_date;
                $entity->modified_date = (empty($entity->modified_date))? date('Y-m-d h:i:s'):$entity->modified_date;

        
                if(!empty($entity->image['name'])){

                $filename = $entity->image['name'];
                $fileTmpName = $entity->image['tmp_name'];
                $filetype = $entity->image['type'];
                $filesize = $entity->image['size'];
                $filext = pathinfo($filename,PATHINFO_EXTENSION);
                $innerpath = '/img/PostsImages/'.time().$filename;
                $filepath = ROOT_PATH.$innerpath;

                $session = new Container('user');
                  $user_id=$session->offsetGet('id');
                 

                // echo $filepath;die;

                if(in_array($filext, array('jpg','png','gif','JPEG','JPG'))){

                        if($filesize<500000)
                    {
                        // $error = $fileTmpName;
                        // mkdir($bashPath."/uploads/$user_folder", 0777, true);
                       if(move_uploaded_file($fileTmpName, $filepath))
                        $error = "";
                        else $innerpath="";
                    }
                    else  $error = "file size must not be smaller than 5 MB";

                }
                else  $error = "only jpg,png or gif files are allowed";
            }

            else $innerpath="";
                
                // if($error==""){
                //     $success = "ok";
                // }
                // else echo "<script>alert('error');</script>";
                
                // if($success == "ok"){

                    $data = array(
                'user_id' => $user_id,
                'title' => $entity->title,
                'language' => $entity->language,
                'description' => $entity->description,
                'keywords' => $entity->description,
                'post_category' => $entity->post_category,
                'image' => $innerpath,
                'created_date' => $entity->created_date,
                'created_by' => $user_id,
                'IsActive' => 0,
                'modified_date' => $entity->modified_date,
                'modified_by' => 0
                );
                    // print_r($data);die;
                       if($entity->id==0){
                        $resultSet = $this->insert($data);
                        }
                    // else {
                    //             if ($this->getNews($entity->id)) {

                    //                 $this->tableGateway->update($data, array('id' => $entity->id));

                    //                 } else {
                    //                 throw new \Exception('Users id does not exist');
                    //             }
                    //     }
        
    }

    public function PopularPosts()
    {
        $result = $this->select(function(Select $select){
            $select->join('tbl_posts_views','tbl_post.id = tbl_posts_views.post_id',array('*'),Select::JOIN_RIGHT);
            $select->quantifier('TOP 2');
            $select->order("tbl_posts_views.id DESC");
        });

         
        return $result;
    }

    
    

}