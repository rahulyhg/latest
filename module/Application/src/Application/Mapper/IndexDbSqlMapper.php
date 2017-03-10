<?php

namespace Application\Mapper;

use Application\Model\Entity\IndexInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Stdlib\Hydrator\HydratorInterface;

class IndexDbSqlMapper implements IndexMapperInterface {

    protected $dbAdapter;
    protected $hydrator;
    protected $blogPrototype;
    protected $resultSet;

    public function __construct(
    AdapterInterface $dbAdapter, HydratorInterface $hydrator = null, IndexInterface $postPrototype = null
    ) {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->postPrototype = $postPrototype;
        $this->resultSet = new ResultSet();
    }

    public function delete(IndexInterface $commonObject) {
        
    }

    public function find($id) {
        
    }

    public function findAll() {
        
    }

    public function save(IndexInterface $commonObject) {
        
    }

    public function getGroomData() {
        $sql="select tbl_user.id as uid,tbl_city.*,tbl_user_info.profile_photo,tbl_user_info.full_name,tbl_user_info.last_name,
            tbl_user_info.age,tbl_user_info.height,tbl_user_info.city,tbl_user_info.address,
            tbl_user_info.gender,
            tbl_user_info.about_yourself_partner_family,tbl_profession.profession, tbl_family_relation.father_id 
            FROM tbl_user 
		 INNER JOIN tbl_user_info on tbl_user_info.user_id=tbl_user.id
		 INNER JOIN tbl_city on tbl_user_info.city=tbl_city.id
		 
         INNER JOIN tbl_profession on tbl_user_info.profession=tbl_profession.id
         INNER JOIN tbl_user_roles on tbl_user_info.user_id=tbl_user_roles.user_id
         LEFT JOIN tbl_family_relation ON tbl_family_relation.user_id=tbl_user_info.user_id
		 		 
		 where tbl_user_roles.IsMember='1'   ORDER BY tbl_user.id DESC ";
//        $GroomData = $this->dbAdapter->query("select tbl_user.id as uid,tbl_city.*,tbl_user_info.profile_photo,tbl_user_info.full_name,tbl_user_info.age,tbl_user_info.height,tbl_user_info.city,tbl_user_info.address,tbl_user_info.about_yourself_partner_family,tbl_profession.profession, tbl_family_relation.father_id from tbl_user 
//		 INNER JOIN tbl_user_info on tbl_user_info.user_id=tbl_user.id
//		 INNER JOIN tbl_city on tbl_user_info.city=tbl_city.id
//		 
//         INNER JOIN tbl_profession on tbl_user_info.profession=tbl_profession.id
//         INNER JOIN tbl_user_roles on tbl_user_info.user_id=tbl_user_roles.user_id
//         LEFT JOIN tbl_family_relation ON tbl_family_relation.user_id=tbl_user_info.user_id
//		 		 
//		 where tbl_user_roles.IsMember='1'  ORDER BY tbl_user.id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        
        $GroomData = $this->dbAdapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);        
        
    
        return $GroomData;
    }
    
    public function getExecutiveMember() {
      
        $ExecMembers = $this->dbAdapter->query("select tbl_communities.category_name,tbl_user_info.user_id as uid,
            tbl_user.id,tbl_city.*,tbl_user_info.profile_photo,tbl_user_info.full_name,tbl_user_info.last_name,
            tbl_user_info.age,tbl_user_info.height,tbl_user_info.city,tbl_user_info.address,
            tbl_user_info.about_yourself_partner_family,tbl_profession.profession,tbl_user_info.gender, tbl_family_relation.father_id
            from tbl_user 
		 INNER JOIN tbl_user_info on tbl_user_info.user_id=tbl_user.id
		 INNER JOIN tbl_city on tbl_user_info.city=tbl_city.id
		 
         INNER JOIN tbl_profession on tbl_user_info.profession=tbl_profession.id		 
		 INNER JOIN tbl_user_roles on tbl_user_info.user_id=tbl_user_roles.user_id
		 INNER JOIN tbl_communities on tbl_user_info.comm_mem_id = tbl_communities.id
                 LEFT JOIN tbl_family_relation ON tbl_family_relation.user_id=tbl_user_info.user_id
		 where tbl_user_roles.IsExecutive='1'  ORDER BY tbl_user.id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        return $ExecMembers;
        }
    
    public function getUpcomingEvents(){
         $date = date('Y-m-d h:i:s');
        $Upcoming_events = $this->dbAdapter->query("select * from tbl_upcoming_events where (event_date>'" . $date . "' && is_active=1) ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        return $Upcoming_events;
        
    }
    
    
    public function getMatrimonialBrideData() {
    $sql="SELECT tui.*, 
             tu.email, 
             tu.mobile_no, 
             tui.user_id as uid,
             tp.*, tp.profession as profession_name, 
             tuam.*,
             tuem.*,
             tel.*,
             tup.*,
             td.*,
             th.height as height_name,
             tai.*,
             tr.*,
             tc.*,
             tcountry.country_name,
             tstate.state_name,
             tcity.city_name,
             tef.*,
             TIMESTAMPDIFF(YEAR, tui.dob, CURDATE()) AS age,
             tugm.*
             FROM tbl_user_info_matrimonial as tui
               LEFT JOIN tbl_user_matrimonial as tu ON tui.user_id=tu.id
               LEFT JOIN tbl_user_professional_matrimonial as tup ON tui.user_id=tup.user_id
               LEFT JOIN tbl_profession as tp ON tup.profession=tp.id
               LEFT JOIN tbl_designation as td ON td.id=tup.designation
               LEFT JOIN tbl_annual_income as tai ON tai.id=tup.annual_income
               LEFT JOIN tbl_religion as tr ON tr.id=tui.religion
               LEFT JOIN tbl_height as th ON th.id=tui.height
               LEFT JOIN tbl_caste as tc ON tc.id=tui.caste
               LEFT JOIN tbl_user_education_matrimonial as tuem ON tuem.user_id=tui.user_id
               LEFT JOIN tbl_education_level as tel ON tel.id=tuem.education_level_id
               LEFT JOIN tbl_education_field as tef ON tef.id=tuem.education_field_id
               LEFT JOIN tbl_user_gallery_matrimonial as tugm ON tugm.user_id=tui.user_id AND tugm.user_type='U' AND 
               tugm.image_type=1
               LEFT JOIN tbl_user_address_matrimonial as tuam ON tuam.user_id=tui.user_id
               LEFT JOIN tbl_country as tcountry ON tcountry.id=tuam.country 
               LEFT JOIN tbl_state as tstate ON tstate.id=tuam.state 
               LEFT JOIN tbl_city as tcity ON tcity.id=tuam.city 
               WHERE 1 and tui.gender='Female' Group by(tugm.user_id) ORDER BY tugm.id DESC";
        $MatrimonialData = $this->dbAdapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE); 
        $result=$this->resultSet->initialize($MatrimonialData);
        //\Zend\Debug\Debug::dump($result->toArray());exit;
        return $result->toArray();
    }
    
    public function getMatrimonialGroomData() {
    $sql="SELECT tui.*, 
             tu.email, 
             tu.mobile_no, 
             tui.user_id as uid,
             tp.*, tp.profession as profession_name, 
             tuam.*,
             tuem.*,
             tel.*,
             tup.*,
             td.*,
             th.height as height_name,
             tai.*,
             tr.*,
             tc.*,
             tcountry.country_name,
             tstate.state_name,
             tcity.city_name,
             tef.*,
             TIMESTAMPDIFF(YEAR, tui.dob, CURDATE()) AS age,
             tugm.*
             FROM tbl_user_info_matrimonial as tui
               LEFT JOIN tbl_user_matrimonial as tu ON tui.user_id=tu.id
               LEFT JOIN tbl_user_professional_matrimonial as tup ON tui.user_id=tup.user_id
               LEFT JOIN tbl_profession as tp ON tup.profession=tp.id
               LEFT JOIN tbl_designation as td ON td.id=tup.designation
               LEFT JOIN tbl_annual_income as tai ON tai.id=tup.annual_income
               LEFT JOIN tbl_religion as tr ON tr.id=tui.religion
               LEFT JOIN tbl_height as th ON th.id=tui.height
               LEFT JOIN tbl_caste as tc ON tc.id=tui.caste
               LEFT JOIN tbl_user_education_matrimonial as tuem ON tuem.user_id=tui.user_id
               LEFT JOIN tbl_education_level as tel ON tel.id=tuem.education_level_id
               LEFT JOIN tbl_education_field as tef ON tef.id=tuem.education_field_id
               LEFT JOIN tbl_user_gallery_matrimonial as tugm ON tugm.user_id=tui.user_id AND tugm.user_type='U' AND 
               tugm.image_type=1
               LEFT JOIN tbl_user_address_matrimonial as tuam ON tuam.user_id=tui.user_id
               LEFT JOIN tbl_country as tcountry ON tcountry.id=tuam.country 
               LEFT JOIN tbl_state as tstate ON tstate.id=tuam.state 
               LEFT JOIN tbl_city as tcity ON tcity.id=tuam.city 
               WHERE 1 and tui.gender='Male' Group by(tugm.user_id) ORDER BY tugm.id DESC";
        $MatrimonialData = $this->dbAdapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE); 
        $result=$this->resultSet->initialize($MatrimonialData);
        //\Zend\Debug\Debug::dump($result->toArray());exit;
        return $result->toArray();
    }

}
