<?php

namespace Admin\Mapper;

use Admin\Model\Entity\Newses;
use Admin\Model\Entity\Newscategories;
//use Admin\Model\Entity\Countries;
//use Admin\Model\Entity\States;
//use Admin\Model\Entity\Cities;
//use Admin\Model\Entity\Religions;
//use Admin\Model\Entity\Gothras;
//use Admin\Model\Entity\Starsigns;
//use Admin\Model\Entity\Zodiacsigns;
//use Admin\Model\Entity\Professions;
//use Admin\Model\Entity\Designations;
//use Admin\Model\Entity\Educationlevels;
//use Application\Model\Entity\UserInfo;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Debug\Debug;
use Zend\Stdlib\Hydrator\ClassMethods;

class NewsDbSqlMapper implements NewsMapperInterface {

    protected $dbAdapter;
    protected $resultSet;
    protected $hydrator;

    public function __construct(AdapterInterface $dbAdapter) {


        $this->dbAdapter = $dbAdapter;
        $this->resultSet = new ResultSet();
        $this->hydrator = new ClassMethods();
    }

    public function getAmmir() {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_user_info");
        $result = $statement->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new UserInfo());
        }
    }

    public function getAmmirById($id) {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_user_info WHERE user_id=:klm");
        $parameters = array(
            'klm' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new UserInfo());
        }
    }
    
    //added by amir
    
    public function test() {
        
        $data = 'hello world';
        
       return $data;
    }
    //News
    
    public function getNewsList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT tbl_news.*, tbl_newscategory.category_name AS category_name,
            tal.id as adminid,
            tal.username as username
            FROM tbl_news 
                INNER JOIN tbl_newscategory ON tbl_news.news_category_id = tbl_newscategory.id
                LEFT JOIN tbl_admin_login as tal ON tal.id=tbl_news.modified_by OR tal.id=tbl_news.created_by
                ");
                
        $result = $statement->execute();
        //}
        // if(isset($status)){
//        Debug::dump($status);
//        exit;
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field  WHERE is_active=:is_active");
//        $parameters = array(
//            'is_active' => $status,
//        );
        //$result = $statement->execute($parameters);
        //$result = $statement->execute();
        //}
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Newses());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function getAllNewscategory() {
        
        $statement = $this->dbAdapter->query("SELECT id,category_name FROM tbl_newscategory WHERE 1");
        
        $result = $statement->execute();
        
        foreach ($result as $list) {
            $categorynamelist[$list['id']] = $list['category_name'];
        }
        
        return $categorynamelist;
        

    }
    
     public function saveNews($newsObject) {
//         echo  "<pre>";
//                 print_r($newsObject->getImagePath()['size']);
//                exit;
//         Debug::dump($newsObject['title']);
//            exit;
       /* $newsData = $this->hydrator->extract($newsObject);
        //print_r($educatioData);
        //exit;
        unset($newsData['id']); // Neither Insert nor Update needs the ID in the array

        if ($newsObject->getId()) {
            echo  "<pre>";
            echo  "hello";exit;
            $statement = $this->dbAdapter->query("UPDATE tbl_news 
                SET title=:title,
                    description=:description,
                    is_active=:is_active,
                    news_category_id=:news_category_id,    
                    image=:image 
                    WHERE id=:id");
            //Debug::dump($id);
            //exit;
            $parameters = array(
                'id' => $newsObject->getId(),
                'title' => $newsObject->getTitle(),
                'description' => $newsObject->getDescription(),
                'is_active' => $newsObject->getIsActive(),
                'news_category_id' => $newsObject->getNewsCategoryId(),
                'image' => $newsObject->getImage()
                
                
            );
            $result = $statement->execute($parameters);
            
            if($newsObject['post_image_flag']==1){
            $image = PUBLIC_PATH . '/NewsImages/' . $newsObject['post_image_update'];
            $image_thumb = PUBLIC_PATH . '/NewsImages/thumb/100x100/' . $newsObject['post_image_update'];
            unlink($image);
            unlink($image_thumb);
            }
            
            
            
            if ($result)
                    return "success";
                else
                    return "couldn't update";
        } */
        
         if ($newsObject['id']) {
             //echo  "hello";exit;
             
            $postData = array();

            $postData['title'] = $newsObject['title'];
            $postData['description']   = $newsObject['description'];
            $postData['news_category_id']      = $newsObject['news_category_id'];
            $postData['is_active']      = $newsObject['is_active'];
            if($newsObject['post_image_flag']==1){
            $postData['image']         = $newsObject['image'];
            }
            $postData['modified_by']      = $newsObject[0];
            //$postData['created_by']      = $newsObject[0];
            /*if (!empty($userPostData['image']['name'])) {
                $postData['image'] = $userPostData['image']['name'];
            }*/
            //$postData['modified_date'] = $userPostData['modified_date'];
            //Debug::dump($userPostData);
            //exit;
            //echo  "hello world";exit;

            $action = new Update('tbl_news');
            $action->set($postData);
            $action->where(array('id = ?' => $newsObject['id']));
            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if($newsObject['post_image_flag']==1){
            $image = PUBLIC_PATH . '/NewsImages/' . $newsObject['post_image_update'];
            $image_thumb = PUBLIC_PATH . '/NewsImages/thumb/100x100/' . $newsObject['post_image_update'];
            unlink($image);
            unlink($image_thumb);
            }
            
        } else {
            
//            echo  "<pre>";
//            print_r($newsObject);exit;
//            echo  "hello world";exit;
            
//            if(!empty($newsObject->getImagePath()['name'])){
////                        echo  "hello world";exit;
//                $filename = $newsObject->getImagePath()['name'];
//                $fileTmpName = $newsObject->getImagePath()['tmp_name'];
//                $filetype = $newsObject->getImagePath()['type'];
//                $filesize = $newsObject->getImagePath()['size'];
//                $filext = pathinfo($filename,PATHINFO_EXTENSION);
////                echo  $filext;exit;
//                $imagename = date("d-m-Y")."-".time().$filename;
////                $targetpath = ROOT_PATH.$imagename;
//                $targetpath = "/public/NewsImages/".$imagename;
////                        echo  "<pre>";
////                        print_r($targetpath);exit;
//                            
//
//
//                if(in_array($filext, array('jpg','png','gif','JPEG','JPG'))){
//
//                        if($filesize<500000)
//                    {          //echo  "<pre>";
//                        //print_r($filesize);exit;
//                        
//                       if(move_uploaded_file($fileTmpName, $targetpath))
//                        $error = "";                            
//                        else $targetpath="";
//                    }
//                    else  $error = "file size must not be smaller than 5 MB";
//
//                }
//                else  $error = "only jpg,png or gif files are allowed";
//            }
//
//            else {
//                $targetpath="";
//            }
            
             /*$statement = $this->dbAdapter->query("INSERT INTO tbl_news 
                 (title, description, is_active,news_category_id, image, created_date)
                 values(:title, :description, :is_active,:news_category_id, :image, now())");
                 
           
            $parameters = array(
                'title' => $newsObject->getTitle(),
                'description' => $newsObject->getDescription(),
                'is_active' => $newsObject->getIsActive(),
                'news_category_id' => $newsObject->getNewsCategoryId(),
                'image' => $newsObject->getImage()
            );
            //print_r($parameters);
            //exit;
            $result = $statement->execute($parameters);
            
            //if ($result) 
           if ($result)
                return "success";
            else
                return "couldn't update";*/

        //return $respArr;
            
            //added by amir
            
            $postData = array();
            $postData['title'] = $newsObject['title'];
            $postData['description'] = $newsObject['description'];
            $postData['news_category_id'] = $newsObject['news_category_id'];
            $postData['is_active'] = $newsObject['is_active'];            
            $postData['image']      =  $newsObject['image'];
            $postData['created_date']      = date("Y-m-d h:i:s");
            $postData['created_by']      = $newsObject[0];
            
//            echo "<pre>";
//            print_r($postData['image']);exit;
            

            $action = new Insert('tbl_news');
            $action->values($postData);

            $sql = new Sql($this->dbAdapter);
            $stmt = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
        }

        /*if ($result instanceof ResultInterface) {
            if ($newId = $result->getGeneratedValue()) {
                // When a value has been generated, set it on the object
                $newsObject->setId($newId);
            }

            //print_r($educationFieldsObject);
            //exit;
            
        }*/
    }
    
    public function getNews($id) {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_news WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Newses());
        }
    }
    
    public function viewByNewsId($table, $id) {

        //echo $id;exit;
//        $statement = $this->dbAdapter->query("SELECT * FROM $table WHERE id=:id");
        $statement = $this->dbAdapter->query("SELECT tbl_news.*,tbl_newscategory.category_name FROM tbl_news INNER JOIN tbl_newscategory ON(tbl_newscategory.id=tbl_news.news_category_id) WHERE tbl_news.id=:id");
        
        //$adapter->query('SELECT * FROM `artist` WHERE `id` = ?', array(5));

        $parameters = array(
            'id' => $id,
        );
        //print_r($statement);
        ///exit;
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Newses());
        }
        
    }
    
    //News category
    
    public function SaveNewscategory($newsCategoryObject) {
//                print_r($educationFieldsObject);
//                exit;
        $newsCategoryData = $this->hydrator->extract($newsCategoryObject);
        //print_r($educatioData);
        //exit;
        unset($newsCategoryData['id']); // Neither Insert nor Update needs the ID in the array

        if ($newsCategoryObject->getId()) {
//            echo  "<pre>";
//            echo  "hello";exit;
            $statement = $this->dbAdapter->query("UPDATE tbl_newscategory 
                SET category_name=:category_name,
                    is_active=:is_active
                    WHERE id=:id");
            //Debug::dump($id);
            //exit;
            $parameters = array(
                'id' => $newsCategoryObject->getId(),
                'category_name' => $newsCategoryObject->getCategoryName(),
                'is_active' => $newsCategoryObject->getIsActive(),
            );
            $result = $statement->execute($parameters);
            
            if ($result)
                    return "success";
                else
                    return "couldn't update";
        } else {
             $statement = $this->dbAdapter->query("INSERT INTO tbl_newscategory 
                 (category_name, is_active, created_date)
                 values(:category_name, :is_active, now())");
                 
           
            $parameters = array(
                'category_name' => $newsCategoryObject->getCategoryName(),
                'is_active' => $newsCategoryObject->getIsActive(),
            );
            //print_r($parameters);
            //exit;
            $result = $statement->execute($parameters);
            
            //if ($result) 
           if ($result)
                return "success";
            else
                return "couldn't update";

        //return $respArr;
        }

        if ($result instanceof ResultInterface) {
            if ($newId = $result->getGeneratedValue()) {
                // When a value has been generated, set it on the object
                $newsCategoryObject->setId($newId);
            }

            //print_r($educationFieldsObject);
            //exit;
            
        }
    }
    
    public function getNewscategoryList() {
//            Debug::dump($status);
//        exit;
        //if(isset($status)){
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_newscategory where 1");
        $result = $statement->execute();
        //}
        // if(isset($status)){
//        Debug::dump($status);
//        exit;
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field  WHERE is_active=:is_active");
//        $parameters = array(
//            'is_active' => $status,
//        );
        //$result = $statement->execute($parameters);
        //$result = $statement->execute();
        //}
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Newscategories());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    
    public function getNewscategory($id) {
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_newscategory WHERE id=:id");
        $parameters = array(
            'id' => $id
        );
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Newscategories());
        }
    }
    
    public function viewByNewscategoryId($table, $id) {

        //echo $id;exit;
//        $statement = $this->dbAdapter->query("SELECT * FROM $table WHERE id=:id");
        $statement = $this->dbAdapter->query("SELECT * FROM $table WHERE id=:id");
        
        //$adapter->query('SELECT * FROM `artist` WHERE `id` = ?', array(5));

        $parameters = array(
            'id' => $id,
        );
        //print_r($statement);
        ///exit;
        $result = $statement->execute($parameters);
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), new Newscategories());
        }
        
    }
    
    public function getNewscategoryRadioList($status) {
//            Debug::dump($status);
//        exit;
//        if(empty($status)){
//        $statement = $this->dbAdapter->query("SELECT * FROM tbl_education_field");
//        $result = $statement->execute();
//        }
//        if(isset($status)){
//        Debug::dump($status);
//        exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_newscategory  WHERE is_active=:is_active");
        $parameters = array(
            'is_active' => $status,
        );
        $result = $statement->execute($parameters);
        //$result = $statement->execute();
//        }
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Newscategories());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
    }
    public function newscategorySearch($data) {
//        echo   "<pre>";
//        echo  $data;exit;
//        $field1 = empty($field) ? "" : "education_field like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_newscategory WHERE category_name like '" . $data . "%'");
//        \Zend\Debug\Debug::dump($statement);exit;

//        $parameters = array(
//            'id' => $id,
//        );
        //print_r($statement);
        ///exit;
        $result = $statement->execute();
//        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
//            return $this->hydrator->hydrate($result->current(), new EducationFields());
//        }
        
         if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Newscategories());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    public function performSearchNewscategory($field) {
//        echo   "<pre>";
//        echo  $field;exit;
        $field1 = empty($field) ? "" : "category_name like '" . $field . "%'";
        //echo $id;exit;
        $statement = $this->dbAdapter->query("SELECT * FROM tbl_newscategory WHERE " . $field1 . "");
        

//        $parameters = array(
//            'id' => $id,
//        );
        //print_r($statement);
        ///exit;
        $result = $statement->execute();
//        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
//            return $this->hydrator->hydrate($result->current(), new EducationFields());
//        }
        
         if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultSet = new HydratingResultSet($this->hydrator, new Newscategories());

            return $resultSet->initialize($result);
            //return $this->hydrator->hydrate($result->current(), new EducationFields());
        }
       
    }
    
    
    
    

}
