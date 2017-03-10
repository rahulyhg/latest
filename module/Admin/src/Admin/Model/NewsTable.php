<?php

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class NewsTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {

        $resultSet = $this->tableGateway->select(function (Select $select) {
                $select->join('tbl_newscategory','tbl_news.news_category_id = tbl_newscategory.id',array("category_name"),Select::JOIN_INNER);
        });

        return $resultSet;
    }

    public function getNews($id) {
        $resultSet = $this->tableGateway->select(array('id'=>$id))->current();
        return $resultSet;
    }

    public function getNewsjoin($id) {
        $resultSet = $this->tableGateway->select(function (Select $select) use($id){
            $select->where(array('tbl_news.id'=>$id));
            $select->join('tbl_newscategory','tbl_news.news_category_id = tbl_newscategory.id',array('category_name'));
            $select->join('tbl_admin_login','tbl_news.modified_by = tbl_admin_login.id',array('username'));
        })->current();

        return $resultSet;
    }

    public function deleteNews($id) {
        $resultSet = $this->tableGateway->delete(array('id'=>$id));
        return $resultSet;
    }

    public function SaveNews($newsEntity)
    {
    	$newsEntity['created_date'] = (empty($newsEntity['created_date']))? date('Y-m-d h:i:s'):$newsEntity['created_date'];
//        echo "<pre>";
//        print_r($pagesEntity['created_date']);exit;
                $newsEntity['modified_date'] = (empty($newsEntity['modified_date']))? date('Y-m-d h:i:s'):$newsEntity['modified_date'];
                
                $Cstatus = empty($newsEntity['is_active']) ? 0 : 1;
                
    	$data = array(
            'title' => $newsEntity['title'],
            'description' => $newsEntity['description'],
            'news_category_id' => $newsEntity['news_category_id'],
            'image' => $newsEntity['image'],
    		'is_active' => $Cstatus,    		
    		'modified_by' => "1"
    		);
        if($newsEntity['id']==0){
            //$resultSet = $this->tableGateway->insert($data);
            
             $dateData=array(
                 'created_date' => $newsEntity['created_date'],
                 'modified_date' => $newsEntity['modified_date'],
            );
            
            $dataInput= array_merge($data,$dateData);
            $result = $this->tableGateway->insert($dataInput);
            
            if ($result)
                return "success";
            else
                return "couldn't update";
        }
        else {
           if ($this->getNews($newsEntity['id'])) {
                
            $dateData=array(
                 'modified_date' => $newsEntity['modified_date'],
            );
            
            $dataUpdate= array_merge($data,$dateData);

                $result = $this->tableGateway->update($dataUpdate, array('id' => $newsEntity['id']));
                
                if($newsEntity['post_image_flag']==1){
            $image = PUBLIC_PATH . '/NewsImages/' . $newsEntity['post_image_update'];
            $image_thumb = PUBLIC_PATH . '/NewsImages/thumb/100x100/' . $newsEntity['post_image_update'];
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

}
