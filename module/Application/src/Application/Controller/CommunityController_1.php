<?php

namespace Application\Controller;

use Zend\Db\Adapter\Adapter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CommunityController extends AbstractActionController {

    public function indexAction() {

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $rows = $adapter->query("select * from tbl_community_mngmnt where status=1 group by agent_id", Adapter::QUERY_MODE_EXECUTE)->toArray();
        $lonerows = $adapter->query("select tui.full_name,tui.comm_mem_id,tui.comm_mem_status,tui.profile_photo,tbl_communities.*,tbl_user.email from tbl_user_info as tui 
          inner join tbl_communities on tui.comm_mem_id = tbl_communities.id   
          inner join tbl_user on tui.user_id = tbl_user.id   
        where (tui.comm_mem_status=1 && tbl_communities.Head=2)", Adapter::QUERY_MODE_EXECUTE)->toArray();



        $new = array();
        foreach ($rows as $a) {

            $childs = $adapter->query("select * from tbl_community_mngmnt where (status=1 && agent_id=" . $a['agent_id'] . ")", Adapter::QUERY_MODE_EXECUTE)->toArray();

            foreach ($childs as $child) {
                $children[] = $this->TreeUsersData($child['sub_agent_id']);
            }

            $parent = $this->TreeUsersData($a['agent_id']);
            $parent['mychild'] = $children;
            $new[$a['agent_id']] = $parent;
            unset($children);
        }
        foreach ($lonerows as $l) {
            $lone[$l['parent_id']][] = $l;
        }

        //     
        /*         * ****Return to View Model******** */
        $filters_data = $this->sidebarFilters();

        return new ViewModel(array("filters_data" => $filters_data, "new" => $new, "lone" => $lone, "firstrow" => array()));
    }

    public function sidebarFilters() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        // $select=$this->getServiceLocator()->get('Zend\Db\sql\Expression');

        $filters_array = array("country" => "tbl_country", "state" => "tbl_state", "designation" => "tbl_designation", "city" => "tbl_city", "rustagi_branch" => "tbl_rustagi_branches");

        foreach ($filters_array as $key => $table) {
            $filters_data[$key] = $adapter->query("select * from " . $table . "", Adapter::QUERY_MODE_EXECUTE);
        }
        return $filters_data;
    }

    public function TreeUsersData($value = '') {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $rows = $adapter->query("select tui.full_name,tui.comm_mem_id,tui.comm_mem_id,tui.profile_photo,tbl_communities.category_name,tbl_user.email from tbl_user_info as tui 
          inner join tbl_communities on tui.comm_mem_id = tbl_communities.id   
          inner join tbl_user on tui.user_id = tbl_user.id   
        where (tui.user_id=" . $value . " && tui.comm_mem_status=1)", Adapter::QUERY_MODE_EXECUTE)->toArray();

        $rows[0]['user_id'] = $value;

        return $rows[0];
    }

    public function communityfiltersAction() {
        
        //\Zend\Debug\Debug::dump($_POST);
        //exit;
        $where = "";

        if (isset($_POST['Country_name'])) {

            $where.=" AND tui.country=" . $_POST['Country_name'];
        }
        if (isset($_POST['State_name'])) {

            $where.=" AND tui.state=" . $_POST['State_name'];
        }
        if (isset($_POST['City_name'])) {

            $where.=" AND tui.city=" . $_POST['City_name'];
        }
        
        if (isset($_POST['Branch_name'])) {

            $where.=" AND tui.branch_ids=" . $_POST['Branch_name'];
        }
        
       


        $sql = "select tui.*, tui.user_id as uid,
                    tbl_user_roles.*,
                    tbl_profession.profession,
                    tbl_education_field.education_field,
                    tbl_city.city_name,
                    tbl_height.height,tbl_state.state_name,
                    tbl_country.country_name,
                    tbl_education_level.education_level 
            FROM tbl_user_info as tui 
                inner join tbl_profession on tui.profession=tbl_profession.id 
                left join tbl_designation on tui.designation=tbl_designation.id 
                left join tbl_education_field on tui.education_field=tbl_education_field.id 
                left join tbl_city on tui.city=tbl_city.id 
                left join tbl_state on tui.state=tbl_state.id 
                left join tbl_country on tui.country=tbl_country.id 
                left join tbl_height on tui.height=tbl_height.id 
                left JOIN tbl_education_level on tui.education_level=tbl_education_level.id
                left join tbl_user_roles on tui.user_id=tbl_user_roles.user_id WHERE 1" . $where;


        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        if (isset($_POST['Country_name']) && isset($_POST['State_name']) && isset($_POST['City_name']) && isset($_POST['Branch_name'])) {
           $userInfo = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
            $memberOrder=$this->MyPlugin()->getCommunityMemberTypeRecursive();
//            foreach($result as $results){
//                echo "<pre>";
                //print_r($result);
           // }
            $view = new ViewModel(array('community' => $userInfo,'memberOrder'=>$memberOrder));
            //$view->setTemplate('application/community/communityFiltersByCountry');
        } elseif (isset($_POST['Country_name']) || isset($_POST['State_name']) || isset($_POST['City_name'])) {
            $userInfo = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE)->toArray();
            $memberOrder=$this->MyPlugin()->getCommunityMemberTypeRecursive();
//            foreach($result as $results){
//                echo "<pre>";
                //print_r($result);
           // }
            $view = new ViewModel(array('community' => $userInfo,'memberOrder'=>$memberOrder));
            $view->setTemplate('application/community/communityFiltersByCountry');
        }
        $view->setTerminal(true);
        return $view;
    }

}

?>
