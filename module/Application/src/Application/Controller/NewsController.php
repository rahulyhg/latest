<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\ViewModel;

class NewsController extends AbstractActionController {

    protected $postService;

    public function __construct(\Application\Service\NewsServiceInterface $postService) {
        $this->postService = $postService;
    }

    public function indexAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql="select tn.*,tal.username,tnc.category_name from tbl_news as tn
        inner join tbl_admin_login as tal on tn.modified_by=tal.id
        inner join tbl_newscategory as tnc on tn.news_category_id=tnc.id
        where (tn.is_active=1) order by tn.id DESC";
        $NewsData = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        // $filters_data = $this->sidebarFilters();
        $filters_data = $this->sidebarFilters();
        return new ViewModel(array("NewsData" => $NewsData, "filters_data" => $filters_data));
    }

    public function ViewAction() {
        if ($this->params()->fromRoute('id') > 0) {
            $id = $this->params()->fromRoute('id');
        } else
            $id = Null;

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "select tn.*,tal.username from tbl_news as tn
        inner join tbl_admin_login as tal on tn.modified_by=tal.id
        where (tn.id=$id)";
        $NewsSingle = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
        $news = (object) $NewsSingle[0];
        $filters_data = $this->sidebarFilters();
        return new ViewModel(array("filters_data" => $filters_data, "news" => $news));
    }

    public function sidebarFilters() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $filters_array = array("news_category_id" => "tbl_newscategory");
        foreach ($filters_array as $key => $table) {
            $filters_data[$key] = $adapter->query("select * from " . $table . "", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        }
        return $filters_data;
    }

    public function newsfiltersAction() {

        $from = $this->convertdate($_POST['from']);
        $to = $this->convertdate($_POST['to']);

        if (count($_POST['category']) > 0) {
            $category = implode(",", $_POST['category']);
            $catfield = "and tn.news_category_id IN (" . $category . ")";
        } else
            $catfield = "";

        $sql = "select tn.*,tal.username,tnc.category_name from tbl_news as tn 
        inner join tbl_admin_login as tal on tn.modified_by=tal.id
        inner join tbl_newscategory as tnc on tn.news_category_id=tnc.id
        where (tn.created_date BETWEEN '" . $from . "' AND '" . $to . "' " . $catfield . ") ORDER BY tn.id DESC";
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /*         * ****Fetch all Members Data from db******** */
        $NewsData = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        /*         * ****Return to View Model******** */
        $view = new ViewModel(array('NewsData' => $NewsData));
        $view->setTerminal(true);
        return $view;

        // echo $sql;

        exit();
    }

    public function convertdate($date) {

        $timestamp = strtotime($date);
        $date = date("Y/m/d h:i:s", $timestamp);
        return $date;
    }
    
    
    public function newsfiltersbycatAction() {
        $newsCat=$_POST['newsCat'];
        if($newsCat!=""){
            $newsCatcond="and tn.news_category_id in ($newsCat)";
        }else{
            $newsCatcond="";
        }
        $sql="select tn.*,tal.username,tnc.category_name from tbl_news as tn
        inner join tbl_admin_login as tal on tn.modified_by=tal.id
        inner join tbl_newscategory as tnc on tn.news_category_id=tnc.id
        where tn.is_active=1 $newsCatcond order by tn.id DESC";
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /*         * ****Fetch all Members Data from db******** */
        $NewsData = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        /*         * ****Return to View Model******** */
        $view = new ViewModel(array('NewsData' => $NewsData));
        $view->setTerminal(true);
        return $view;
    }

}

?>
