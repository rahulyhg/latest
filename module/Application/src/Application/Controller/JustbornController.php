<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Zend\Debug\Debug;
use Zend\View\Model\JsonModel;

class JustbornController extends AbstractActionController {

    public function indexAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "select tp.*,tui.full_name from tbl_post as tp inner join tbl_user_info as tui on tp.user_id=tui.user_id "
                . "WHERE tp.post_category='1' and tp.is_active=1 ORDER BY id DESC";
        $data = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return new ViewModel(array(
            'AllPosts' => $data,
        ));
    }

    public function ViewAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');

        $id = $this->params()->fromRoute('id');

        $sql_update = "UPDATE tbl_post SET view_count=view_count+1 WHERE id='$id'";
        $adapter->query($sql_update, Adapter::QUERY_MODE_EXECUTE);

        // Query to Count Total Likes for the post ///
        $sql_select = "SELECT like_count,view_count FROM tbl_post WHERE id='$id'";
        $totalLikes = $adapter->query($sql_select, Adapter::QUERY_MODE_EXECUTE)->current();

        // Query to count total likes ////
        $sql1 = "select count(like_id) as total_likes from tbl_post_like
        where post_id='$id' and user_id='$user_id'";
        $totalCount = $adapter->query($sql1, Adapter::QUERY_MODE_EXECUTE)->current();

        // Query to select the particular post ///
        $sql = "select tp.*,tui.full_name from tbl_post as tp
        inner join tbl_user_info as tui on tp.user_id=tui.user_id
        where tp.id='$id' and tp.is_active=1";
        $post = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->current();

        $sql_comments = "select tui.full_name,tbl_posts_comments.*,tug.image_path from tbl_posts_comments
        inner join tbl_user_info as tui on tbl_posts_comments.user_id=tui.user_id
        LEFT join tbl_user_gallery as tug on (tbl_posts_comments.user_id=tug.user_id AND tug.profile_pic=1)
        where tbl_posts_comments.is_active=1 and tbl_posts_comments.post_id='$id' order by tbl_posts_comments.id DESC";

        $AllComments = $adapter->query($sql_comments, Adapter::QUERY_MODE_EXECUTE);

        return new ViewModel(array(
            'post' => $post,
            'totalCount' => $totalCount,
            'totalLikes' => $totalLikes,
            'AllComments' => $AllComments,
        ));
    }

    /// Function for Like Dislike Button //////
    public function ChangeLikeDislikeAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');

        if (!empty($_POST['post_id']) && !empty($_POST['rel'])) {
            $post_id = $_POST['post_id'];
            $rel = $_POST['rel'];
            $ip = $_SERVER['REMOTE_ADDR'];
            if ($rel == 'Like') {
//---Like----
                $sql1 = "select count(like_id) as total_likes from tbl_post_like
        where post_id='$post_id' and user_id='$user_id'";
                $totalCount = $adapter->query($sql1, Adapter::QUERY_MODE_EXECUTE)->current();
                $totalCount = $totalCount->total_likes;
                if ($totalCount == 0) {
                    $sql_insert = "INSERT INTO tbl_post_like (post_id,user_id,created_date,ip) VALUES('$post_id','$user_id',NOW(),'$ip')";
                    $adapter->query($sql_insert, Adapter::QUERY_MODE_EXECUTE);

                    $sql_update = "UPDATE tbl_post SET like_count=like_count+1 WHERE id='$post_id'";
                    $adapter->query($sql_update, Adapter::QUERY_MODE_EXECUTE);

                    $sql_select = "SELECT like_count FROM tbl_post WHERE id='$post_id'";
                    $totalLikes = $adapter->query($sql_select, Adapter::QUERY_MODE_EXECUTE)->current();
                    $totalLikes->like_count;
                }
            } else {
//---Unlike----
                $sql1 = "select count(like_id) as total_likes from tbl_post_like
        where post_id='$post_id' and user_id='$user_id'";
                $totalCount = $adapter->query($sql1, Adapter::QUERY_MODE_EXECUTE)->current();
                $totalCount = $totalCount->total_likes;
                if ($totalCount > 0) {

                    $sql_delete = "DELETE FROM tbl_post_like WHERE post_id='$post_id' and user_id='$user_id'";
                    $result = $adapter->query($sql_delete, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

                    $sql_update = "UPDATE tbl_post SET like_count=like_count-1 WHERE id='$post_id'";
                    $adapter->query($sql_update, Adapter::QUERY_MODE_EXECUTE);


                    $sql_select = "SELECT like_count FROM tbl_post WHERE id='$post_id'";
                    $totalLikes = $adapter->query($sql_select, Adapter::QUERY_MODE_EXECUTE)->current();
                    $totalLikes->like_count;
                }
            }

            $respArr = array("status" => 1, "data" => $totalLikes);
            return new JsonModel($respArr);
        }
    }

    public function PostCommentAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $userSession = $this->getUser()->session();
        $user_id = $userSession->offsetGet('id');
        //echo $_POST['post_id']; die;
        if (!empty($_POST['post_id']) && !empty($_POST['comment'])) {
            $post_id = $_POST['post_id'];
            $comment = $_POST['comment'];
            $ip = $_SERVER['REMOTE_ADDR'];
            $sql_insert = "INSERT INTO tbl_posts_comments (post_id,user_id,comment_desc,created_date,ip) VALUES('$post_id','$user_id','$comment',NOW(),'$ip')";
            $result = $adapter->query($sql_insert, Adapter::QUERY_MODE_EXECUTE);
            if ($result) {
                $status = 1;
            } else {
                $status = 0;
            }
            $respArr = array("status" => $status);
            return new JsonModel($respArr);
        }
    }
    
    public function convertdate($date) {

        $timestamp = strtotime($date);
        $date = date("Y/m/d h:i:s", $timestamp);
        return $date;
    }

    public function postfiltersAction() {

        $from = $this->convertdate($_POST['from']);
        $to = $this->convertdate($_POST['to']);
        $catfield = "and tbl_post.post_category=1";
        $sql = "select tbl_post.*,tbl_post_category.*,tui.full_name,tbl_post.id as postid,tbl_post.created_date as postdate from tbl_post 
        inner join tbl_user_info as tui on tbl_post.user_id=tui.user_id
        inner join tbl_post_category on tbl_post.post_category=tbl_post_category.id 
        where (tbl_post.created_date BETWEEN '" . $from . "' AND '" . $to . "' " . $catfield . " AND tbl_post.is_active=1) order by tbl_post.id DESC";
        //die;
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /*         * ****Fetch all Members Data from db******** */
        $AllData = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        /*         * ****Return to View Model******** */
        $view = new ViewModel(array('AllPosts' => $AllData));
        $view->setTerminal(true);
        return $view;
    }

}

?>
